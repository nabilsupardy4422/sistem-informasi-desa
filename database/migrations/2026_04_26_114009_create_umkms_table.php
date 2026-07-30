<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('umkms', function (Blueprint $table) {
        $table->id();
        $table->string('nama_umkm');
        $table->string('pemilik');
        $table->text('alamat');
        $table->string('no_hp');
        $table->text('deskripsi')->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('umkms');
    }
};
