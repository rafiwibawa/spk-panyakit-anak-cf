<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenyakit extends Model
{
    use HasFactory;

    protected $table = 'detail_penyakit';
    
    protected $fillable = [
        'gejala_id', 
        'penykit_id',
    ];

    protected $hidden = [];

    public function penyakit()
    {
        return $this->belongsTo(Penyakit::class);
    }

    public function gejala()
    {
        return $this->belongsTo(Gejala::class);
    }
}
