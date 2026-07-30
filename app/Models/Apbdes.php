<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    protected $fillable = ['tahun','total_anggaran'];

    public function details()
    {
        return $this->hasMany(ApbdesDetail::class);
    }
}