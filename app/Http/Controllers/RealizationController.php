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
}
