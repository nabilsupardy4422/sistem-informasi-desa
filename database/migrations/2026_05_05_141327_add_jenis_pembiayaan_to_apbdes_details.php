<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('apbdes_details', function (Blueprint $table) {
            $table->enum('jenis_pembiayaan', ['masuk','keluar'])
                ->nullable()
                ->after('kategori');
        });
    }

    public function down()
    {
        Schema::table('apbdes_details', function (Blueprint $table) {
            $table->dropColumn('jenis_pembiayaan');
        });
    }
};
