<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('penduduks', function (Blueprint $table) {
        $table->id();
        $table->year('tahun');
        $table->integer('jumlah_penduduk');
        $table->integer('jumlah_laki');
        $table->integer('jumlah_perempuan');
        $table->integer('jumlah_kk');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('penduduks');
    }
};
