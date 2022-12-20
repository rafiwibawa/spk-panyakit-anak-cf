<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory; 

    protected $table = 'gejala';

    protected $fillable = [
        'name', 
    ];

    protected $hidden = [];

    public function detail_penyakit()
    {
        return $this->HasMany(DetailPenyakit::class);
    }
}
