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
        $data['user'] = User::count();
        $data['admin'] = User::where('rule','admin')->count();
        $data['member'] = User::where('rule','member')->count();
        $data['gejala'] = Gejala::count();
        $data['penyakit'] = Penyakit::count();
        $data['test'] = Test::count();
 
        $bulan = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);  
        $data['jumlah_pengunjung'] = [];
        for ($i=0; $i < 12 ; $i++) {  
            $total = User::where('rule','member')->whereMonth('created_at',$bulan[$i])->count();  
            
            array_push($data['jumlah_pengunjung'],$total);
        }  
        
        $data['jumlah_test'] = [];
        for ($i=0; $i < 12 ; $i++) {  
            $total = Test::whereMonth('created_at',$bulan[$i])->count();  
            
            array_push($data['jumlah_test'],$total);
        }    


        return view('dashboard.index', compact('data'));
    }
}
