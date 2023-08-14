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
            $subs = SubActivity::all();

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
            DB::raw("CONCAT(activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS activity_info"), 'programs.id')
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
            'budget' => 'required',
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
            $sub->budget = $request->input('budget');
            $sub->physic = $request->input('physic');
            $sub->activity_id = $request->input('activity');
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
            $sub = SubActivity::where('id', $id)->first();

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
                DB::raw("CONCAT(activities.activity, ' - ', programs.program, ' - ', programs.year, ' - ', regions.name) AS activity_info"), 'programs.id')
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
            'budget' => 'required',
            'physic' => 'required',
        ]);

        if ((DB::table('sub_activities')
        ->where('sub_activity', $request->input('subact'))
        ->where('activity_id', $request->input('activity'))
        ->first()) === NULL)
        {
            $sub = SubActivity::findOrFail($id);
            $sub->sub_activity = $request->input('subact');
            $sub->budget = $request->input('budget');
            $sub->physic = $request->input('physic');
            $sub->activity_id = $request->input('activity');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
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
