<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Realization;
use App\Models\Region;

class MonitoringController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function performance(Request $request)
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

            return view('backend.monitoring.performance')->with('user', $user)->with('reas', $reas);
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

                return view('backend.monitoring.performance')->with('user', $user)->with('reas', $reas);
            }
            else {
                $reas = Realization::where('region_id', $user->region->id)
                ->leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
                ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
                ->get();

                return view('backend.monitoring.performance')->with('user', $user)->with('reas', $reas);
            }
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function problem(Request $request)
    {
        $user = auth()->user();

        return view('backend.monitoring.problem')->with('user', $user)->with('reas', $reas);
    }
}
