<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Crypt;
use App\Models\Gejala;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('users')->insert([
            'name' => 'Rafi Wibawa Aruan',
            'email' => 'rafinew1997@gmail.com',
            'password' => Hash::make('1234qwer'),
            'key' => Crypt::encryptString('1234qwer'),
        ]);

        $gejala = [
            'Demam',
            'Lesu',
            'Malas Makan',
            'Muntah Berak',
            'Pendarahan Pada kulit',
            'Mimisan',
            'Sakit Kepala',
            'Tubuh menggigil',
            'Denyut jantung lemah',
            'Badan Lemah',
            'Nyeri otot myalgia',
            'Tidak nafsu makan',
            'Konstipasi',
            'Buang Air Besar terus menerus',
            'Mual',
            'Muntah Muntah',
            'Pegal Pada punggung',
        ];

        collect($gejala)->each(function ($gejala) {  
            Gejala::updateOrCreate(
                ['name' => $gejala], 
            ); 
        });

        $penyakit = [
            'Demam',
            'Lesu',
            'Malas Makan',
            'Muntah Berak',
            'Pendarahan Pada kulit',
            'Mimisan',
            'Sakit Kepala',
            'Tubuh menggigil',
            'Denyut jantung lemah',
            'Badan Lemah',
            'Nyeri otot myalgia',
            'Tidak nafsu makan',
            'Konstipasi',
            'Buang Air Besar terus menerus',
            'Mual',
            'Muntah Muntah',
            'Pegal Pada punggung',
        ];

        collect($penyakit)->each(function ($penyakit) {  
            Penyakit::updateOrCreate(
                ['name' => $penyakit], 
            ); 
        });
    }
}
