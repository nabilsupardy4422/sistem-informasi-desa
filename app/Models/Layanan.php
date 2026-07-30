<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'persyaratan',
        'estimasi_hari',
        'status'
    ];

    public function permohonans()
    {
        return $this->hasMany(PermohonanLayanan::class);
    }
}