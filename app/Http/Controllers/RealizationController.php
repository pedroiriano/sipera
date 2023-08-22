<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Realization;
use App\Models\Region;

class RealizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $reas = Realization::all();

            return view('backend.realization.index')->with('user', $user)->with('reas', $reas);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        $subs = SubActivity::select(
            DB::raw("CONCAT(sub_activities.sub_activity, ' - ', activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS sub_activity_info"), 'sub_activities.id')
            ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
            ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
            ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
            ->pluck('sub_activity_info', 'sub_activities.id');

        if(($user->role_id) == 1) {
            return view('backend.realization.create')->with('user', $user)->with('subs', $subs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subact' => 'required',
            'month' => 'required',
            'performance' => 'required',
        ]);

        $user = auth()->user();

        $subId = $request->input('subact');
        $month = $request->input('month');
        $count = Realization::where('sub_activity_id', $subId)->count('budget_use');

        if ($count > 0)
        {
            $max = Realization::where('sub_activity_id', $subId)->max('month');
            $maxx = $max + 1;
            if ($month == $maxx)
            {
                if ((DB::table('realizations')
                ->where('sub_activity_id', $request->input('subact'))
                ->where('month', $request->input('month'))
                ->first()) === NULL)
                {
                    $rea = new Realization;
                    $rea->month = $request->input('month');
                    $rea->budget_use = $request->input('budget_use');
                    $rea->physic_use = $request->input('physic_use');
                    $rea->performance = $request->input('performance');
                    $rea->budget_remaining = 0;
                    $rea->problem_category = $request->input('problem_category');
                    $rea->problem_description = $request->input('problem_description');
                    $rea->problem_solution = $request->input('problem_solution');
                    $rea->sub_activity_id = $request->input('subact');

                    // $act_sum = $request->input('budget_01') + $request->input('budget_02') + $request->input('budget_03') + $request->input('budget_04') + $request->input('budget_05') + $request->input('budget_06') + $request->input('budget_07') + $request->input('budget_08') + $request->input('budget_09') + $request->input('budget_10') + $request->input('budget_11') + $request->input('budget_12');

                    // $act = Activity::findOrFail($request->input('activity'));
                    // $act->budget = $act->budget + $act_sum;

                    // $act->save();

                    // $pro_sum = Activity::where('program_id', $sub->activity->program->id)->sum('budget');

                    // $pro = Program::findOrFail($sub->activity->program->id);
                    // $pro->budget = $pro_sum;

                    // $pro->save();
                }
                else
                {
                    return back()->with('status', 'Maaf Data Sudah Ada');
                }
            }
            else
            {
                return back()->with('status', 'Tolong Isi Bulan ke-'. $maxx);
            }
        }
        else
        {
            if ($month == 1)
            {
                if ((DB::table('realizations')
                ->where('sub_activity_id', $request->input('subact'))
                ->where('month', $request->input('month'))
                ->first()) === NULL)
                {
                    $rea = new Realization;
                    $rea->month = $request->input('month');
                    $rea->budget_use = $request->input('budget_use');
                    $rea->physic_use = $request->input('physic_use');
                    $rea->performance = $request->input('performance');
                    $rea->budget_remaining = 0;
                    $rea->problem_category = $request->input('problem_category');
                    $rea->problem_description = $request->input('problem_description');
                    $rea->problem_solution = $request->input('problem_solution');
                    $rea->sub_activity_id = $request->input('subact');

                    // $act_sum = $request->input('budget_01') + $request->input('budget_02') + $request->input('budget_03') + $request->input('budget_04') + $request->input('budget_05') + $request->input('budget_06') + $request->input('budget_07') + $request->input('budget_08') + $request->input('budget_09') + $request->input('budget_10') + $request->input('budget_11') + $request->input('budget_12');

                    // $act = Activity::findOrFail($request->input('activity'));
                    // $act->budget = $act->budget + $act_sum;

                    // $act->save();

                    // $pro_sum = Activity::where('program_id', $sub->activity->program->id)->sum('budget');

                    // $pro = Program::findOrFail($sub->activity->program->id);
                    // $pro->budget = $pro_sum;

                    // $pro->save();
                }
                else
                {
                    return back()->with('status', 'Maaf Data Sudah Ada');
                }
            }
            else
            {
                return back()->with('status', 'Tolong Isi Bulan ke-1');
            }
        }

        $rea->save();

        return redirect()->route('realization')->with('success', 'Data Realisasi Berhasil Disimpan');
    }

    public function getTarget(Request $request)
    {
        $subId = $request->input('sub_id');

        // $existingRetribution = Retribution::where('rent_id', $subId)->first();
        // $sumAmount = Retribution::where('rent_id', $subId)->sum('amount');

        // $start = Rent::where('id', $subId)->first()->start;
        // $start = Carbon::parse($start);
        // $end = Carbon::now();
        // $difference = $start->diffInDays($end);

        // $stall_id = Rent::where('id', $subId)->first()->stall_id;
        // $stall_type_id = Stall::where('id', $stall_id)->first()->stall_type_id;
        // $retribution = StallType::where('id', $stall_type_id)->first()->retribution;
        // $due = $difference * $retribution;

        $existingBudget = Realization::where('sub_activity_id', $subId)->first();
        $performanceTarget = SubActivity::where('id', $subId)->first()->physic;
        $sumBudget = Realization::where('sub_activity_id', $subId)->sum('budget_use');
        $realizationCount = Realization::where('sub_activity_id', $subId)->count('budget_use');

        switch ($realizationCount) {
            case 0:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01) AS budget')
                    ->first();
                $budget_available = $subs_sum->budget;
                break;
            case 1:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 2:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 3:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 4:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 5:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 6:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 7:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 8:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 9:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 10:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 11:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            default:
                $budget_available = 'Terjadi Kesalahan Data';
                break;
        }

        if ($existingBudget)
        {
            return response()->json([
                'performance_target' => $performanceTarget,
                'sum_budget' => $sumBudget,
                'realization_count' => $realizationCount,
                'budget_available' => $budget_available
                ]);
        }
        else
        {
            return response()->json([
                'performance_target' => $performanceTarget,
                'sum_budget' => $sumBudget,
                'realization_count' => $realizationCount,
                'budget_available' => $budget_available
                ]);
        }

        // if ($existingRetribution) {
        //     $current_due = $due - $sumAmount;
        //     return response()->json(['due_amount' => $current_due, 'daily_retibution' => $retribution]);
        // } else {
        //     return response()->json(['due_amount' => $due, 'daily_retibution' => $retribution]);
        // }
    }
}
