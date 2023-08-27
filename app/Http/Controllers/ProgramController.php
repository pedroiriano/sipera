<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Program;
use App\Models\Region;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if (($user->role_id) == 1) {
            $pros = Program::all();

            return view('backend.program.index')->with('user', $user)->with('pros', $pros);
        }
        else if (($user->role_id) == 2) {
            if (($user->region->parent_id) == NULL) {
                $regionIds = DB::table('regions')
                ->where('id', '=', $user->region->id)
                ->orWhere('parent_id', '=', $user->region->id)
                ->pluck('id');

                $pros = Program::whereIn('region_id', $regionIds)->get();

                return view('backend.program.index')->with('user', $user)->with('pros', $pros);
            }
            else {
                $pros = Program::where('region_id', $user->region->id)->get();

                return view('backend.program.index')->with('user', $user)->with('pros', $pros);
            }
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function create()
    {
        $user = auth()->user();

        if (($user->role_id) == 1) {
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

            return view('backend.program.create')->with('user', $user)->with('regs', $regs);
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

            return view('backend.program.create')->with('user', $user)->with('regs', $regs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'program' => 'required',
            'year' => 'required',
        ]);

        $user = auth()->user();

        if ((DB::table('programs')
        ->where('program', $request->input('program'))
        ->where('year', $request->input('year'))
        ->where('region_id', $request->input('region'))
        ->first()) === NULL)
        {
            $pro = new Program;
            $pro->program = $request->input('program');
            $pro->year = $request->input('year');
            $pro->region_id = $request->input('region');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $pro->save();

        return redirect()->route('program')->with('success', 'Program Berhasil Disimpan');
    }

    public function show($id)
    {
        try {
            $pro = Program::where('id', $id)->first();

            return view('backend.program.show')->with('pro', $pro);
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }

    public function edit($id)
    {
        $user = auth()->user();

        if(($user->role_id) == 1) {
            $pro = Program::findOrFail($id);

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

            return view('backend.program.edit')->with('user', $user)->with('pro', $pro)->with('regs', $regs);
        }
        else if (($user->role_id) == 2) {
            $pro = Program::findOrFail($id);

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

            return view('backend.program.edit')->with('user', $user)->with('pro', $pro)->with('regs', $regs);
        }
        else {
            return back()->with('status', 'Tidak Punya Akses');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'program' => 'required',
            'year' => 'required',
        ]);

        if ((DB::table('programs')
        ->where('program', $request->input('program'))
        ->where('year', $request->input('year'))
        ->where('region_id', $request->input('region'))
        ->first()) === NULL)
        {
            $pro = Program::findOrFail($id);
            $pro->program = $request->input('program');
            $pro->year = $request->input('year');
            $pro->region_id = $request->input('region');
        }
        else
        {
            return back()->with('status', 'Maaf Data Sudah Ada');
        }

        $pro->save();

        return redirect()->route('program')->with('success', 'Program Berhasil Diubah');
    }

    public function destroy($id)
    {
        try {
            $pro = Program::findOrFail($id);
            $pro->delete();

            return redirect()->route('program')->with('success', 'Kecamatan Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf Data Tidak Sesuai');
        }
    }
}
