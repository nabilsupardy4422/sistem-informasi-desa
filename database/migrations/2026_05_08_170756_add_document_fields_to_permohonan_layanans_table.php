<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permohonan_layanans', function (Blueprint $table) {
            $table->string('file_ktp')->nullable()->after('catatan_admin');
            $table->string('file_kk')->nullable()->after('file_ktp');
            $table->string('file_pendukung')->nullable()->after('file_kk');

            $table->text('catatan_verifikasi')->nullable()->after('file_pendukung');

            $table->timestamp('verified_at')->nullable()->after('catatan_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan_layanans', function (Blueprint $table) {
            $table->dropColumn([
                'file_ktp',
                'file_kk',
                'file_pendukung',
                'catatan_verifikasi',
                'verified_at'
            ]);
        });
    }
};