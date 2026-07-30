<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApbdesDetail extends Model
{
    protected $fillable = [
        'apbdes_id',
        'kategori',
        'jenis_pembiayaan', // <-- tambahkan
        'nama_item',
        'jumlah'
    ];
    public function apbdes()
    {
        return $this->belongsTo(Apbdes::class);
    }
}