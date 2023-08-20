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
}
