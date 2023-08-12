<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;

class WardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $wars = Region::whereNotNull('parent_id')->get();

            return view('backend.ward.index')->with('user', $user)->with('wars', $wars);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $wars = Region::select(
                DB::raw("name AS district_info"), 'id')
                ->whereNull('parent_id')
                ->pluck('district_info', 'id');

            return view('backend.ward.create')->with('user', $user)->with('wars', $wars);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'district' => 'required',
            'ward' => 'required',
        ]);

        $user = auth()->user();

        if ((DB::table('regions')
        ->where('parent_id', $request->input('district'))
        ->where('name', $request->input('ward'))
        ->first()) === NULL)
        {
            $war = new Region;
            $war->parent_id = $request->input('district');
            $war->name = $request->input('ward');
            $war->address = $request->input('address');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $war->save();

        return redirect()->route('ward')->with('success', 'Kelurahan Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $war = Region::where('id', $id)->first();

            return view('backend.ward.show')->with('war', $war);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $war = Region::findOrFail($id);

            $diss = Region::select(
                DB::raw("name AS district_info"), 'id')
                ->whereNull('parent_id')
                ->pluck('district_info', 'id');

            return view('backend.ward.edit')->with('war', $war)->with('diss', $diss);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'district' => 'required',
            'ward' => 'required',
        ]);

        if ((DB::table('regions')
        ->where('parent_id', $request->input('district'))
        ->where('name', $request->input('ward'))
        ->first()) === NULL)
        {
            $war = Region::findOrFail($id);
            $war->parent_id = $request->input('district');
            $war->name = $request->input('ward');
            $war->address = $request->input('address');
        }
        else
        {
            if ((DB::table('regions')
            ->where('parent_id', $request->input('district'))
            ->where('name', $request->input('ward'))
            ->where('address', $request->input('address'))
            ->first()) === NULL)
            {
                $war = Region::findOrFail($id);
                $war->parent_id = $request->input('district');
                $war->name = $request->input('ward');
                $war->address = $request->input('address');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $war->save();

        return redirect()->route('ward')->with('success', 'Kelurahan Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $war = Region::findOrFail($id);
            $war->delete();

            return redirect()->route('ward')->with('success', 'Kelurahan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
