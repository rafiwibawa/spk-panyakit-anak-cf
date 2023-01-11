<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\Test;

use DataTables;
use Auth;

class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['admin'] = User::where('rule','admin')->count();
        $data['member'] = User::where('rule','member')->count();
        $data['gejala'] = Gejala::count();
        $data['penyakit'] = Penyakit::count();
        $data['test'] = Test::count();
        return view('dashboard.index', compact('data'));
    }
}
