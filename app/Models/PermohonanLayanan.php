<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermohonanLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'layanan_id',
        'nama',
        'nik',
        'email',
        'telepon',
        'alamat',
        'pesan',
        'status',
        'tracking_code',
        'assigned_to',
        'catatan_admin',
        'file_ktp',
        'file_kk',
        'file_pendukung',
        'catatan_verifikasi',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isVerified(): bool
    {
        return !is_null($this->verified_at);
    }

    public function hasKtp(): bool
    {
        return !empty($this->file_ktp);
    }

    public function hasKk(): bool
    {
        return !empty($this->file_kk);
    }

    public function hasPendukung(): bool
    {
        return !empty($this->file_pendukung);
    }
}