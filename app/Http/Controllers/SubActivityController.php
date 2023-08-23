<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Activity;
use App\Models\SubActivity;
use App\Models\Region;

class SubActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $subs = SubActivity::select('*')
                ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                ->groupBy('id')
                ->get();

            return view('backend.subactivity.index')->with('user', $user)->with('subs', $subs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        $acts = Activity::select(
            DB::raw("CONCAT(activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS activity_info"), 'activities.id')
            ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
            ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
            ->pluck('activity_info', 'activities.id');

        if(($user->role_id) == 1) {
            return view('backend.subactivity.create')->with('user', $user)->with('acts', $acts);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'subact' => 'required',
            'budget_01' => 'required',
            'budget_02' => 'required',
            'budget_03' => 'required',
            'budget_04' => 'required',
            'budget_05' => 'required',
            'budget_06' => 'required',
            'budget_07' => 'required',
            'budget_08' => 'required',
            'budget_09' => 'required',
            'budget_10' => 'required',
            'budget_11' => 'required',
            'budget_12' => 'required',
            'physic' => 'required',
        ]);

        $user = auth()->user();

        if ((DB::table('sub_activities')
        ->where('sub_activity', $request->input('subact'))
        ->where('activity_id', $request->input('activity'))
        ->first()) === NULL)
        {
            $sub = new SubActivity;
            $sub->sub_activity = $request->input('subact');
            $sub->budget_01 = $request->input('budget_01');
            $sub->budget_02 = $request->input('budget_02');
            $sub->budget_03 = $request->input('budget_03');
            $sub->budget_04 = $request->input('budget_04');
            $sub->budget_05 = $request->input('budget_05');
            $sub->budget_06 = $request->input('budget_06');
            $sub->budget_07 = $request->input('budget_07');
            $sub->budget_08 = $request->input('budget_08');
            $sub->budget_09 = $request->input('budget_09');
            $sub->budget_10 = $request->input('budget_10');
            $sub->budget_11 = $request->input('budget_11');
            $sub->budget_12 = $request->input('budget_12');
            $sub->physic = $request->input('physic');
            $sub->activity_id = $request->input('activity');

            $act_sum = $request->input('budget_01') + $request->input('budget_02') + $request->input('budget_03') + $request->input('budget_04') + $request->input('budget_05') + $request->input('budget_06') + $request->input('budget_07') + $request->input('budget_08') + $request->input('budget_09') + $request->input('budget_10') + $request->input('budget_11') + $request->input('budget_12');

            $act = Activity::findOrFail($request->input('activity'));
            $act->budget = $act->budget + $act_sum;

            $act->save();

            $pro_sum = Activity::where('program_id', $sub->activity->program->id)->sum('budget');

            $pro = Program::findOrFail($sub->activity->program->id);
            $pro->budget = $pro_sum;

            $pro->save();
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $sub->save();

        return redirect()->route('sub')->with('success', 'Sub Kegiatan Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $sub = SubActivity::where('id', $id)
                ->select('*')
                ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                ->groupBy('id', 'sub_activity')
                ->first();

            return view('backend.subactivity.show')->with('sub', $sub);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $sub = SubActivity::findOrFail($id);

            $acts = Activity::select(
                DB::raw("CONCAT(activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS activity_info"), 'activities.id')
                ->leftJoin('programs', 'activities.program_id', '=', 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->pluck('activity_info', 'activities.id');

            return view('backend.subactivity.edit')->with('user', $user)->with('sub', $sub)->with('acts', $acts);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'subact' => 'required',
            'budget_01' => 'required',
            'budget_02' => 'required',
            'budget_03' => 'required',
            'budget_04' => 'required',
            'budget_05' => 'required',
            'budget_06' => 'required',
            'budget_07' => 'required',
            'budget_08' => 'required',
            'budget_09' => 'required',
            'budget_10' => 'required',
            'budget_11' => 'required',
            'budget_12' => 'required',
            'physic' => 'required',
        ]);

        $sub = SubActivity::findOrFail($id);

        if (($sub->sub_activity == $request->input('subact')) && ($sub->activity_id == $request->input('activity')))
        {
            $sub->sub_activity = $request->input('subact');
            $sub->budget_01 = $request->input('budget_01');
            $sub->budget_02 = $request->input('budget_02');
            $sub->budget_03 = $request->input('budget_03');
            $sub->budget_04 = $request->input('budget_04');
            $sub->budget_05 = $request->input('budget_05');
            $sub->budget_06 = $request->input('budget_06');
            $sub->budget_07 = $request->input('budget_07');
            $sub->budget_08 = $request->input('budget_08');
            $sub->budget_09 = $request->input('budget_09');
            $sub->budget_10 = $request->input('budget_10');
            $sub->budget_11 = $request->input('budget_11');
            $sub->budget_12 = $request->input('budget_12');
            $sub->physic = $request->input('physic');
            $sub->activity_id = $request->input('activity');

            $sub_sum = SubActivity::where('id', $id)
                ->select('*')
                ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                ->groupBy('id', 'sub_activity')
                ->first();

            $act_sum = $request->input('budget_01') + $request->input('budget_02') + $request->input('budget_03') + $request->input('budget_04') + $request->input('budget_05') + $request->input('budget_06') + $request->input('budget_07') + $request->input('budget_08') + $request->input('budget_09') + $request->input('budget_10') + $request->input('budget_11') + $request->input('budget_12');

            $act = Activity::findOrFail($request->input('activity'));
            $act->budget = $act->budget - $sub_sum->budget + $act_sum;

            $act->save();

            $pro_sum = Activity::where('program_id', $sub->activity->program->id)->sum('budget');

            $pro = Program::findOrFail($sub->activity->program->id);
            $pro->budget = $pro_sum;

            $pro->save();
        }
        else
        {
            if ((DB::table('sub_activities')
            ->where('sub_activity', $request->input('subact'))
            ->where('activity_id', $request->input('activity'))
            ->first()) === NULL)
            {
                $sub->sub_activity = $request->input('subact');
                $sub->budget_01 = $request->input('budget_01');
                $sub->budget_02 = $request->input('budget_02');
                $sub->budget_03 = $request->input('budget_03');
                $sub->budget_04 = $request->input('budget_04');
                $sub->budget_05 = $request->input('budget_05');
                $sub->budget_06 = $request->input('budget_06');
                $sub->budget_07 = $request->input('budget_07');
                $sub->budget_08 = $request->input('budget_08');
                $sub->budget_09 = $request->input('budget_09');
                $sub->budget_10 = $request->input('budget_10');
                $sub->budget_11 = $request->input('budget_11');
                $sub->budget_12 = $request->input('budget_12');
                $sub->physic = $request->input('physic');
                $sub->activity_id = $request->input('activity');

                $sub_sum = SubActivity::where('id', $id)
                    ->select('*')
                    ->selectRaw('SUM(budget_01 + budget_02 + budget_03 + budget_04 + budget_05 + budget_06 + budget_07 + budget_08 + budget_09 + budget_10 + budget_11 + budget_12) AS budget')
                    ->groupBy('id', 'sub_activity')
                    ->first();

                $act_sum = $request->input('budget_01') + $request->input('budget_02') + $request->input('budget_03') + $request->input('budget_04') + $request->input('budget_05') + $request->input('budget_06') + $request->input('budget_07') + $request->input('budget_08') + $request->input('budget_09') + $request->input('budget_10') + $request->input('budget_11') + $request->input('budget_12');

                $act = Activity::findOrFail($request->input('activity'));
                $act->budget = $act->budget - $sub_sum->budget + $act_sum;

                $act->save();

                $pro_sum = Activity::where('program_id', $sub->activity->program->id)->sum('budget');

                $pro = Program::findOrFail($sub->activity->program->id);
                $pro->budget = $pro_sum;

                $pro->save();
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $sub->save();

        return redirect()->route('sub')->with('success', 'Sub Kegiatan Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $sub = SubActivity::findOrFail($id);
            $sub->delete();

            return redirect()->route('sub')->with('success', 'Sub Kegiatan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
