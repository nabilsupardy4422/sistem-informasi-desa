<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('apbdes_details', function (Blueprint $table) {
        $table->id();
        $table->foreignId('apbdes_id')->constrained()->cascadeOnDelete();
        $table->enum('kategori', ['pendapatan', 'belanja']);
        $table->string('nama_item');
        $table->bigInteger('jumlah');
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('apbdes_details');
    }
};
