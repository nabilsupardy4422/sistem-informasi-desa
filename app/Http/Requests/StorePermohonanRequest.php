<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermohonanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'layanan_id' => 'required|exists:layanans,id',
            'nama' => 'required|string|max:100',
            'nik' => 'required|digits:16',
            'no_hp' => 'required|string|max:15',
            'keperluan' => 'required|string'
        ];
    }
}
