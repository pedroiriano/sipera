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

        $target = SubActivity::where('id', $subId)->first();
        $existingBudget = Realization::where('sub_activity_id', $subId)->first();
        $performanceTarget = SubActivity::where('id', $subId)->first()->physic;
        $sumBudget = Realization::where('sub_activity_id', $subId)->sum('budget_use');

        if ($existingBudget) {
            return response()->json(['performance_target' => $performanceTarget, 'sum_budget' => $sumBudget]);
        } else {
            return response()->json(['performance_target' => $performanceTarget, 'sum_budget' => $sumBudget]);
        }

        // if ($existingRetribution) {
        //     $current_due = $due - $sumAmount;
        //     return response()->json(['due_amount' => $current_due, 'daily_retibution' => $retribution]);
        // } else {
        //     return response()->json(['due_amount' => $due, 'daily_retibution' => $retribution]);
        // }
    }
}
