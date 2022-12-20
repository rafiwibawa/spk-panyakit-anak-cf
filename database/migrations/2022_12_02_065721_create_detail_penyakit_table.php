<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPenyakitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penyakit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gejala_id')->nullable()->defalut(null); 
            $table->unsignedBigInteger('penyakit_id')->nullable()->defalut(null); 
            $table->foreign('gejala_id')->references('id')->on('gejala')->onDelete('set null');
            $table->foreign('penyakit_id')->references('id')->on('penyakit')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_penyakit');
    }
}
