<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Helpers\TrackingHelper;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengaduanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM PENGADUAN
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        return view('public.pengaduan.index');
    }

    /*
    |--------------------------------------------------------------------------
    | SUBMIT PENGADUAN
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:1000',
            'kategori' => 'required|string|max:100',
            'isi_pengaduan' => 'required|string|min:20|max:5000'
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kategori.required' => 'Kategori pengaduan wajib dipilih.',
            'isi_pengaduan.required' => 'Isi pengaduan wajib diisi.',
            'isi_pengaduan.min' => 'Isi pengaduan minimal 20 karakter.'
        ]);

        $trackingCode = TrackingHelper::generateCode('PGD');

        $pengaduan = Pengaduan::create([
            'nama' => trim($validated['nama']),
            'nik' => $validated['nik'] ?? null,
            'email' => $validated['email'] ?? null,
            'telepon' => trim($validated['telepon']),
            'alamat' => trim($validated['alamat']),
            'kategori' => trim($validated['kategori']),
            'isi_pengaduan' => trim($validated['isi_pengaduan']),
            'tracking_code' => $trackingCode,
            'status' => 'baru',
            'prioritas' => 'sedang',
            'assigned_to' => null,
            'catatan_admin' => null
        ]);

        TrackingHelper::log(
            $pengaduan->tracking_code,
            'pengaduan',
            null,
            'baru',
            'Pengaduan berhasil dibuat oleh masyarakat.',
            null
        );

        return redirect()
            ->route('public.tracking.index')
            ->with('success', 'Pengaduan berhasil dikirim.')
            ->with('tracking_code', $trackingCode);
    }
}