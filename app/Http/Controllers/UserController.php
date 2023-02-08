<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\User;

use DataTables;
use Auth;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function dt(Request $request)
    {
        $data = DB::table('users')
            ->select([
                'id',
                'name',
                'email',
                'rule',
                'age'
            ])
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    } 

    public function store(Request $request)
    {
        try {
            date_default_timezone_set("Asia/Jakarta");
  
            $result = DB::transaction(function () use($request){
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 8; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                } 

                $result = User::create([
                    'name' => $request->name,
                    'email' =>$request->email,
                    'rule' => $request->rule,
                    'age' => $request->age,
                    'password' => Hash::make($randomString),
                    'key' => Crypt::encryptString($randomString), 
                ]);

                $user = $result;

                Mail::send('mail.send-access', compact('user','randomString'), function($message) use($user,$randomString){
                    $message->to($user->email, $user->name , $randomString)->subject('Tugas Akhir');
                });

                return $result;
            });

            return response([
                "status"    => 200,
                "data"      => $result,
                "message"   => 'Data Tersimpan'
            ], 200);
        } catch (Exception $e) {
            return response([
                "status" => 400,
                "message"=> $e->getMessage(),
            ]);
        }
    } 
    
    public function update(Request $request, $id)
    {

        try {
            date_default_timezone_set("Asia/Jakarta");

            $result = DB::transaction(function () use($request, $id){
                $result = User::find($id)->update([
                    'name' => $request->name,
                    'email' =>$request->email,
                    'rule' =>$request->rule,
                    'age' => $request->age,
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

            $result = User::find($id);

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

    public function send_email($id)
    {
        try {
            date_default_timezone_set("Asia/Jakarta");

            $user = User::find($id);

            Mail::send('mail.send-access', compact('user'), function($message) use($user){
                $message->to($user->email, $user->name)->subject('Pemura - Giving access to the Pemura system');
            });

            return response([
                "status"=> 200,
                "message"   => 'Email Terkirim'
            ], 200);
        } catch (Exception $e) {
            return response([
                "status" => 400,
                "message"=> $e->getMessage(),
            ]);
        }
    }
}
