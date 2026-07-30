<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nik',
        'email',
        'telepon',
        'alamat',
        'kategori',
        'isi_pengaduan',
        'tracking_code',
        'status',
        'prioritas',
        'assigned_to',
        'catatan_admin'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}