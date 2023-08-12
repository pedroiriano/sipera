<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Region;

class DistrictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $diss = Region::whereNull('parent_id')->get();

            return view('backend.district.index')->with('user', $user)->with('diss', $diss);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            return view('backend.district.create')->with('user', $user);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'district' => 'required',
        ]);

        $user = auth()->user();

        if ((DB::table('regions')
        ->where('name', $request->input('district'))
        ->first()) === NULL)
        {
            $dis = new Region;
            $dis->name = $request->input('district');
            $dis->address = $request->input('address');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $dis->save();

        return redirect()->route('district')->with('success', 'Kecamatan Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $dis = Region::where('id', $id)->first();

            return view('backend.district.show')->with('dis', $dis);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $dis = Region::findOrFail($id);

            return view('backend.district.edit')->with('dis', $dis);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'district' => 'required',
        ]);

        if ((DB::table('regions')
        ->where('name', $request->input('district'))
        ->first()) === NULL)
        {
            $dis = Region::findOrFail($id);
            $dis->name = $request->input('district');
            $dis->address = $request->input('address');
        }
        else
        {
            if ((DB::table('regions')
            ->where('name', $request->input('district'))
            ->where('address', $request->input('address'))
            ->first()) === NULL)
            {
                $dis = Region::findOrFail($id);
                $dis->name = $request->input('district');
                $dis->address = $request->input('address');
            }
            else
            {
                return back()->with('status', 'Maaf Data Sudah Ada');
            }
        }

        $dis->save();

        return redirect()->route('district')->with('success', 'Kecamatan Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $dis = Region::findOrFail($id);
            $dis->delete();

            return redirect()->route('district')->with('success', 'Kecamatan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
