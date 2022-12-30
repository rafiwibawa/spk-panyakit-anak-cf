<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Penyakit;
use App\Models\DetailPenyakit as DetailPenyakitModel;
use App\Models\Gejala as GejalaModel;
use App\Models\Test;
use App\Models\DetailTest;

use Auth;
class TestController extends Controller
{
    public function step_one()
    {
        $data = session()->get('test_step_1', []);

        $questions = DB::table('gejala')
        ->select([
            'id',
            'name', 
        ])  
        ->inRandomOrder()
        ->get();

        return view('main.step-1', [
            'data' => $data,
            'questions' => $questions
        ]);
    }

    public function post_step_one(Request $request)
    { 
        date_default_timezone_set("Asia/Jakarta");

        DB::beginTransaction();
        try { 
            $test = Test::create([
                'user_id' => Auth::user()->id, 
            ]);
             
            foreach ($request->all() as $key => $answer) {
                if($key != '_token'){
                    DetailTest::create([
                        'test_id' => $test->id,
                        'gejala_id' => $key,
                        'nilai_cf' => $answer,
                    ]);
                }
            } 
            DB::commit();
        } catch (Exception $e) {
            $properties = [$e->getMessage(), $e->getTraceAsString()];
            $log->new()->properties($properties)->save('error');
            DB::rollBack();
            return response(['message' => 'Server busy, please try again later!', 500]);
        }

        $penyakit = Penyakit::all();
        $hasil = [];
        foreach ($penyakit as $key => $value) {
            $detail_penyakit = DB::table('detail_penyakit')->where('penyakit_id', $value->id)
                    ->get();
            $nilai_cf = [];
            foreach ($detail_penyakit as $key => $val) { 
                $detail_test = DB::table('test_detail')->where('test_id', $test->id)
                    ->where('gejala_id', $val->gejala_id)
                    ->first();

                array_push($nilai_cf, $detail_test->nilai_cf);
            }
            
            $cf = $nilai_cf[0] + ($nilai_cf[1] * (1 - $nilai_cf[0]));
            for ($i=2; $i < (count($nilai_cf)-1); $i++) { 
                $cf = $nilai_cf[$i] + ($cf * (1 - $nilai_cf[$i]));

            }

            array_push($hasil,[
                'id' => $value->id,
                'name'=> $value->name,
                'nilai'=> $cf*100,
                'img' => null,
                'desc' => $value->desc,
            ]);  
        } 

        return view('main.done', compact('hasil')); 
    } 

    public function detail($id)
    { 
        $penyakit = Penyakit::find($id);
 
        return view('main.detail', compact('penyakit')); 
    }
}
