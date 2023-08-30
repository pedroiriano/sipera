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

            $reas = Realization::leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
            ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
            ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
            ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
            ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
            ->get();

            return view('backend.realization.index')->with('user', $user)->with('reas', $reas);
        }
        else if (($user->role_id) == 2) {
            if (($user->region->parent_id) == NULL) {
                $regionIds = DB::table('regions')
                ->where('id', '=', $user->region->id)
                ->orWhere('parent_id', '=', $user->region->id)
                ->pluck('id');

                $reas = Realization::whereIn('region_id', $regionIds)
                ->leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
                ->get();

                return view('backend.realization.index')->with('user', $user)->with('reas', $reas);
            }
            else {
                $reas = Realization::where('region_id', $user->region->id)
                ->leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
                ->get();

                return view('backend.realization.index')->with('user', $user)->with('reas', $reas);
            }
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $subs = SubActivity::select(
            DB::raw("CONCAT(sub_activities.sub_activity, ' - ', activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS sub_activity_info"), 'sub_activities.id')
            ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
            ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
            ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
            ->pluck('sub_activity_info', 'sub_activities.id');

            return view('backend.realization.create')->with('user', $user)->with('subs', $subs);
        }
        else if (($user->role_id) == 2) {
            if (($user->region->parent_id) == NULL) {
                $regionIds = DB::table('regions')
                ->where('id', '=', $user->region->id)
                ->orWhere('parent_id', '=', $user->region->id)
                ->pluck('id');

                $subs = SubActivity::select(
                DB::raw("CONCAT(sub_activities.sub_activity, ' - ', activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS sub_activity_info"), 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->whereIn('programs.region_id', $regionIds)
                ->pluck('sub_activity_info', 'sub_activities.id');

                return view('backend.realization.create')->with('user', $user)->with('subs', $subs);
            }
            else {
                $subs = SubActivity::select(
                DB::raw("CONCAT(sub_activities.sub_activity, ' - ', activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS sub_activity_info"), 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->where('programs.region_id', $user->region->id)
                ->pluck('sub_activity_info', 'sub_activities.id');

                return view('backend.realization.create')->with('user', $user)->with('subs', $subs);
            }
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
            $budget_remaining = $request->input('available') - $request->input('budget_use');
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
                    $rea->budget_remaining = $budget_remaining;
                    $rea->problem_category = $request->input('problem_category');
                    $rea->problem_description = $request->input('problem_description');
                    $rea->problem_solution = $request->input('problem_solution');
                    $rea->sub_activity_id = $request->input('subact');
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
            $budget_remaining = $request->input('available') - $request->input('budget_use');
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
                    $rea->budget_remaining = $budget_remaining;
                    $rea->problem_category = $request->input('problem_category');
                    $rea->problem_description = $request->input('problem_description');
                    $rea->problem_solution = $request->input('problem_solution');
                    $rea->sub_activity_id = $request->input('subact');
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

    public function show($id)
    {
        try {
            $rea = Realization::where('id', $id)->first();

            return view('backend.realization.show')->with('rea', $rea);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $rea = Realization::findOrFail($id);

            $subs = SubActivity::select(
                DB::raw("CONCAT(sub_activities.sub_activity, ' - ', activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS sub_activity_info"), 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->pluck('sub_activity_info', 'sub_activities.id');

            $subId = $rea->sub_activity_id;

            $performanceTarget = SubActivity::where('id', $subId)->first()->physic;

            $sumBudget = Realization::where('sub_activity_id', $subId)->where('month', '<', $rea->month)->sum('budget_use');

            switch ($rea->month) {
                case 1:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01) AS budget')
                        ->first();
                    $budget_available = $subs_sum->budget;
                    break;
                case 2:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 3:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 4:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 5:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 6:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 7:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 8:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 9:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 10:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 11:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                case 12:
                    $subs_sum = SubActivity::where('id', $subId)
                        ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                        ->first();
                    $budget_available = ($subs_sum->budget) - $sumBudget;
                    break;
                default:
                    $budget_available = 'Terjadi Kesalahan Data';
                    break;
            }

            return view('backend.realization.edit')->with('user', $user)->with('rea', $rea)->with('subs', $subs)->with('budget_available', $budget_available)->with('sumBudget', $sumBudget)->with('performanceTarget', $performanceTarget);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subact' => 'required',
            'month' => 'required',
            'performance' => 'required',
        ]);

        $subId = $request->input('subact');
        $month = $request->input('month');

        $budget_remaining = $request->input('available') - $request->input('budget_use');

        $rea = Realization::findOrFail($id);
        $rea->month = $request->input('month');
        $rea->budget_use = $request->input('budget_use');
        $rea->physic_use = $request->input('physic_use');
        $rea->performance = $request->input('performance');
        $rea->budget_remaining = $budget_remaining;
        $rea->problem_category = $request->input('problem_category');
        $rea->problem_description = $request->input('problem_description');
        $rea->problem_solution = $request->input('problem_solution');

        $rea->save();

        return redirect()->route('realization')->with('success', 'Data Realisasi Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $rea = Realization::findOrFail($id);
            $rea->delete();

            return redirect()->route('realization')->with('success', 'Data Realisasi Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function getTarget(Request $request)
    {
        $subId = $request->input('sub_id');

        $existingBudget = Realization::where('sub_activity_id', $subId)->first();
        $performanceTarget = SubActivity::where('id', $subId)->first()->physic;
        $sumBudget = Realization::where('sub_activity_id', $subId)->sum('budget_use');
        $realizationCount = Realization::where('sub_activity_id', $subId)->count('budget_use');

        if ($existingBudget)
        {
            return response()->json([
                'performance_target' => $performanceTarget,
                'sum_budget' => $sumBudget,
                'realization_count' => $realizationCount,
                ]);
        }
        else
        {
            return response()->json([
                'performance_target' => $performanceTarget,
                'sum_budget' => $sumBudget,
                'realization_count' => $realizationCount,
                ]);
        }
    }

    public function getBudget(Request $request)
    {
        $subId = $request->input('sub_id');
        $monthId = $request->input('month_id');

        $sumBudget = Realization::where('sub_activity_id', $subId)->where('month', '<=', $monthId)->sum('budget_use');

        switch ($monthId) {
            case 1:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 2:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 3:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 4:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 5:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 6:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 7:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 8:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 9:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 10:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 11:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            case 12:
                $subs_sum = SubActivity::where('id', $subId)
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                    ->first();
                $budget_available = ($subs_sum->budget) - $sumBudget;
                break;
            default:
                $budget_available = 'Terjadi Kesalahan Data';
                break;
        }

        return response()->json([
            'budget_available' => $budget_available
            ]);
    }
}
