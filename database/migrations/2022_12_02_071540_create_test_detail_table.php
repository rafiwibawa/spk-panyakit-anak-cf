<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id')->nullable()->defalut(null); 
            $table->foreign('test_id')->references('id')->on('test')->onDelete('set null');
            $table->unsignedBigInteger('gejala_id')->nullable()->defalut(null); 
            $table->foreign('gejala_id')->references('id')->on('gejala')->onDelete('set null');
            $table->float('nilai_cf');
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
        Schema::dropIfExists('test_detail');
    }
}
