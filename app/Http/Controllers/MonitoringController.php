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

    public function performance()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $pars = Region::select(
                'regions.id',
                'regions.name',
                'regions.address',
                'regions.parent_id',
                DB::raw("IFNULL(parent.name, '') as parent_name")
                )
                ->leftJoin('regions as parent', 'regions.parent_id', '=', 'parent.id')
                ->get();

            $regs = collect();

            foreach ($pars as $par) {
                if ($par->parent_id !== null) {
                    $districtInfo = "Kelurahan {$par->name} - Kecamatan {$par->parent_name}";
                    $regs->put($par->id, $districtInfo);
                }
                else {
                    $districtInfo = "Kecamatan {$par->name}";
                    $regs->put($par->id, $districtInfo);
                }
            }

            return view('backend.monitoring.performance')->with('user', $user)->with('regs', $regs);
        }
        else if (($user->role_id) == 2) {
            $pars = Region::select(
                'regions.id',
                'regions.name',
                'regions.address',
                'regions.parent_id',
                DB::raw("IFNULL(parent.name, '') as parent_name")
                )
                ->leftJoin('regions as parent', 'regions.parent_id', '=', 'parent.id')
                ->where('regions.id', '=', $user->region->id)
                ->orWhere('regions.parent_id', '=', $user->region->id)
                ->get();

            $regs = collect();

            foreach ($pars as $par) {
                if ($par->parent_id !== null) {
                    $districtInfo = "Kelurahan {$par->name} - Kecamatan {$par->parent_name}";
                    $regs->put($par->id, $districtInfo);
                }
                else {
                    $districtInfo = "Kecamatan {$par->name}";
                    $regs->put($par->id, $districtInfo);
                }
            }

            return view('backend.monitoring.performance')->with('user', $user)->with('regs', $regs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function getPerformance(Request $request)
    {
        $user = auth()->user();

        $reas = Realization::where('region_id', $request->input('region'))
        ->where('month', $request->input('month'))
        ->leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
        ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
        ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
        ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
        ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
        ->get();

        return view('backend.monitoring.performance-result')->with('user', $user)->with('reas', $reas);
    }

    public function problem()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $pars = Region::select(
                'regions.id',
                'regions.name',
                'regions.address',
                'regions.parent_id',
                DB::raw("IFNULL(parent.name, '') as parent_name")
                )
                ->leftJoin('regions as parent', 'regions.parent_id', '=', 'parent.id')
                ->get();

            $regs = collect();

            foreach ($pars as $par) {
                if ($par->parent_id !== null) {
                    $districtInfo = "Kelurahan {$par->name} - Kecamatan {$par->parent_name}";
                    $regs->put($par->id, $districtInfo);
                }
                else {
                    $districtInfo = "Kecamatan {$par->name}";
                    $regs->put($par->id, $districtInfo);
                }
            }

            return view('backend.monitoring.problem')->with('user', $user)->with('regs', $regs);
        }
        else if (($user->role_id) == 2) {
            $pars = Region::select(
                'regions.id',
                'regions.name',
                'regions.address',
                'regions.parent_id',
                DB::raw("IFNULL(parent.name, '') as parent_name")
                )
                ->leftJoin('regions as parent', 'regions.parent_id', '=', 'parent.id')
                ->where('regions.id', '=', $user->region->id)
                ->orWhere('regions.parent_id', '=', $user->region->id)
                ->get();

            $regs = collect();

            foreach ($pars as $par) {
                if ($par->parent_id !== null) {
                    $districtInfo = "Kelurahan {$par->name} - Kecamatan {$par->parent_name}";
                    $regs->put($par->id, $districtInfo);
                }
                else {
                    $districtInfo = "Kecamatan {$par->name}";
                    $regs->put($par->id, $districtInfo);
                }
            }

            return view('backend.monitoring.problem')->with('user', $user)->with('regs', $regs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function getProblem(Request $request)
    {
        $user = auth()->user();

        $reas = Realization::where('region_id', $request->input('region'))
        ->where('month', $request->input('month'))
        ->leftJoin('sub_activities', 'realizations.sub_activity_id', '=', 'sub_activities.id')
        ->leftJoin('activities', 'sub_activities.activity_id', '=', 'activities.id')
        ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
        ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
        ->select('realizations.*', 'sub_activities.sub_activity', 'sub_activities.physic', 'activities.activity', 'activities.budget', 'programs.program', 'programs.year', 'regions.name')
        ->get();

        return view('backend.monitoring.problem-result')->with('user', $user)->with('reas', $reas);
    }
}
