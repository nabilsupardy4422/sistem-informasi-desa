<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_code',
        'jenis',
        'status_lama',
        'status_baru',
        'catatan',
        'updated_by'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}