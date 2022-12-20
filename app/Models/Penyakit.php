<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = [
        'name', 
        'kode',
    ];

    protected $hidden = [];

    public function detail_penyakit()
    {
        return $this->HasMany(DetailPenyakit::class);
    }
}
