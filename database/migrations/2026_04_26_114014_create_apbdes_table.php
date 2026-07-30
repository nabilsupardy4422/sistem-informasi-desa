<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('apbdes', function (Blueprint $table) {
        $table->id();
        $table->year('tahun');
        $table->bigInteger('total_anggaran');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('apbdes');
    }
};
