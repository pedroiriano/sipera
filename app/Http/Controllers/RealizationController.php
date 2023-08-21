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
                    $rea->performance = 0;
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
                    $rea->performance = 0;
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

        if ($existingBudget) {
            return response()->json(['performance_target' => $performanceTarget, 'sum_budget' => $sumBudget, 'realization_count' => $realizationCount]);
        } else {
            return response()->json(['performance_target' => $performanceTarget, 'sum_budget' => $sumBudget, 'realization_count' => $realizationCount]);
        }

        // if ($existingRetribution) {
        //     $current_due = $due - $sumAmount;
        //     return response()->json(['due_amount' => $current_due, 'daily_retibution' => $retribution]);
        // } else {
        //     return response()->json(['due_amount' => $due, 'daily_retibution' => $retribution]);
        // }
    }
}
