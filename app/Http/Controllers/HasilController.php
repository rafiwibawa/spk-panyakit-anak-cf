<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

use App\Models\Penyakit;
use App\Models\Test;
use App\Models\DetailPenyakit as DetailPenyakitModel;
use App\Models\Gejala as GejalaModel;

use DataTables;
use Auth;

class HasilController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hasil.index');
    }

    public function dt(Request $request)
    {
        $data = Test::select([
                'test.id',
                'test.created_at',
                'users.name',  
            ])
            ->leftJoin('test_detail', 'test_detail.test_id', '=', 'test.id')
            ->leftJoin('users', 'users.id', '=', 'test.user_id')
            ->get();
 
        return DataTables::of($data)->addIndexColumn()->make(true);
    } 
    
    public function store(Request $request)
    {   
        date_default_timezone_set("Asia/Jakarta");

        DB::beginTransaction();
        try {
            // insert penyakit
            $result = Penyakit::create([
                'name' => $request->name, 
                'kode' => $request->kode, 
                'desc' => $request->desc, 
            ]);

            // insert detail_penyakit
            collect($request->input('gejala'))->each(function($gejala) use ($result){
                $data_detail_penyakit = [
                    'gejala_id' => $gejala['id'], 
                ];

                $detail_penyakit_create = DetailPenyakitModel::create($data_detail_penyakit);
                $result->detail_penyakit()->save($detail_penyakit_create);
            });
            
            DB::commit();
        } catch (Exception $e) {
            $properties = [$e->getMessage(), $e->getTraceAsString()];
            $log->new()->properties($properties)->save('error');
            DB::rollBack();
            return response(['message' => 'Server busy, please try again later!', 500]);
        }
        return response([
                "status"    => 200,
                "data"      => $result,
                "message"   => 'Successfully added'
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            date_default_timezone_set("Asia/Jakarta");

            $result = DB::transaction(function () use($request, $id){
                $result = Penyakit::find($id)->update([
                    'name' => $request->name, 
                ]);

                return $result;
            });

            return response([
                "status"    => 200,
                "data"      => $request->rule,
                "message"   => 'Data Terubah'
            ], 200);
        } catch (Exception $e) {
            return response([
                "status" => 400,
                "message"=> $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            date_default_timezone_set("Asia/Jakarta");

            $result = Penyakit::find($id);

            DB::transaction(function () use($result){
                $result->delete();
            });

            // if ($result->trashed()) {
                return response([
                    "status"=> 200,
                    "message"   => 'Data Terhapus'
                ], 200);
            // }
        } catch (Exception $e) {
            return response([
                "status" => 400,
                "message"=> $e->getMessage(),
            ]);
        }
    }
 
    public function validate_gejala(Request $request)
    { 
        $gejala = GejalaModel::find($request->gejala_id);
 
        return response([
            'gejala_data' => $gejala,
        ]);
    }
 
    public function select2_gejala(Request $request)
    {
        $gejala = GejalaModel::orderBy('id', 'ASC')->get(['id AS id', 'name AS text']);
        return response(['gejala' => $gejala]);
    }


    public function show($id)
    { 
        $penyakit = Penyakit::all();
        $hasil = [];
    
        foreach ($penyakit as $key => $value) {
            $detail_penyakit = DB::table('detail_penyakit')->where('penyakit_id', $value->id)
                    ->get();
            $nilai_cf = [];
            foreach ($detail_penyakit as $key => $val) { 
                $detail_test = DB::table('test_detail')->where('test_id', $id)
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
        
        $data = Test::select([
                'test.id',
                'test.created_at',
                'users.name',  
            ])
            ->where('test.id', $id)
            ->leftJoin('test_detail', 'test_detail.test_id', '=', 'test.id')
            ->leftJoin('users', 'users.id', '=', 'test.user_id')
            ->first();

        return view('hasil.result', compact('hasil', 'data'));
    }
}
