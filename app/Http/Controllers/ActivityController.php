<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Activity;
use App\Models\Region;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $acts = Activity::all();

            return view('backend.activity.index')->with('user', $user)->with('acts', $acts);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        $pros = Program::select(
            DB::raw("CONCAT(programs.program, ' - ', programs.year, ' - ', regions.name) AS program_info"), 'programs.id')
            ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
            ->pluck('program_info', 'programs.id');

        if(($user->role_id) == 1) {
            return view('backend.activity.create')->with('user', $user)->with('pros', $pros);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'activity' => 'required',
            'program' => 'required',
        ]);

        $user = auth()->user();

        if ((DB::table('activities')
        ->where('activity', $request->input('activity'))
        ->where('program_id', $request->input('program'))
        ->first()) === NULL)
        {
            $act = new Activity;
            $act->activity = $request->input('activity');
            $act->program_id = $request->input('program');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $act->save();

        return redirect()->route('activity')->with('success', 'Kegiatan Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $act = Activity::where('id', $id)->first();

            return view('backend.activity.show')->with('act', $act);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $act = Activity::findOrFail($id);

            $pros = Program::select(
                DB::raw("CONCAT(programs.program, ' - ', programs.year, ' - ', regions.name) AS program_info"), 'programs.id')
                ->leftJoin('regions', 'programs.region_id', '=', 'regions.id')
                ->pluck('program_info', 'programs.id');

            return view('backend.activity.edit')->with('user', $user)->with('act', $act)->with('pros', $pros);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'activity' => 'required',
        ]);

        if ((DB::table('activities')
        ->where('activity', $request->input('activity'))
        ->where('program_id', $request->input('program'))
        ->first()) === NULL)
        {
            $act = Activity::findOrFail($id);
            $act->activity = $request->input('activity');
            $act->program_id = $request->input('program');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $act->save();

        return redirect()->route('activity')->with('success', 'Kegiatan Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $act = Activity::findOrFail($id);
            $act->delete();

            return redirect()->route('activity')->with('success', 'Kegiatan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
