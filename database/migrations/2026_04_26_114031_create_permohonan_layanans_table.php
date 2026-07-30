<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_layanans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('layanan_id')
                ->constrained('layanans')
                ->cascadeOnDelete();

            $table->string('nama');
            $table->string('nik', 20);
            $table->string('email')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->text('pesan')->nullable();

            $table->string('tracking_code')->unique();

            $table->enum('status', [
                'baru',
                'ditinjau',
                'diproses',
                'menunggu_dokumen',
                'selesai',
                'ditolak'
            ])->default('baru');

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
        Schema::dropIfExists('permohonan_layanans');
    }
};