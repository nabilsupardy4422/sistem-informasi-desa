<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nik', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();

            $table->string('kategori')->nullable();

            $table->text('isi_pengaduan');

            $table->string('tracking_code')->unique();

            $table->enum('status', [
                'baru',
                'ditinjau',
                'diproses',
                'selesai',
                'ditolak'
            ])->default('baru');

            $table->enum('prioritas', [
                'rendah',
                'sedang',
                'tinggi',
                'urgent'
            ])->default('sedang');

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('catatan_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};