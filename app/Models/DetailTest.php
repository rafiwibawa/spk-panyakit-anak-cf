<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTest extends Model
{
    use HasFactory;

    protected $table = 'detail_test';

    protected $fillable = [
        'test_id', 
        'gejala_id', 
        'nilai_cf', 
    ];

    protected $hidden = [];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
