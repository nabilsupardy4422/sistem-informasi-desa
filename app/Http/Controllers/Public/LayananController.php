<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Helpers\TrackingHelper;
use App\Models\Layanan;
use App\Models\PermohonanLayanan;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LayananController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        $layanans = Layanan::where('status', 'aktif')
            ->orderBy('nama_layanan')
            ->get();

        return view('public.layanan.index', compact('layanans'));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): View
    {
        $layanan = Layanan::where('status', 'aktif')
            ->findOrFail($id);

        return view('public.layanan.show', compact('layanan'));
    }

    /*
    |--------------------------------------------------------------------------
    | AJUKAN PERMOHONAN
    |--------------------------------------------------------------------------
    */
    public function ajukan(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanans,id',

            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:1000',
            'keperluan' => 'required|string|min:20|max:5000',

            'file_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'file_kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'file_pendukung' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'telepon.required' => 'Nomor telepon wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'keperluan.required' => 'Keperluan wajib diisi.',
            'keperluan.min' => 'Keperluan minimal 20 karakter.',
            'file_ktp.required' => 'File KTP wajib diupload.',
            'file_kk.required' => 'File KK wajib diupload.',
        ]);

        $fileKtp = null;
        $fileKk = null;
        $filePendukung = null;

        try {
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | UPLOAD FILES
            |--------------------------------------------------------------------------
            */
            if ($request->hasFile('file_ktp')) {
                $fileKtp = $request->file('file_ktp')
                    ->store('permohonan/ktp', 'public');
            }

            if ($request->hasFile('file_kk')) {
                $fileKk = $request->file('file_kk')
                    ->store('permohonan/kk', 'public');
            }

            if ($request->hasFile('file_pendukung')) {
                $filePendukung = $request->file('file_pendukung')
                    ->store('permohonan/pendukung', 'public');
            }

            /*
            |--------------------------------------------------------------------------
            | TRACKING CODE
            |--------------------------------------------------------------------------
            */
            $trackingCode = TrackingHelper::generateCode('LYN');

            /*
            |--------------------------------------------------------------------------
            | SAVE PERMOHONAN
            |--------------------------------------------------------------------------
            */
            $permohonan = PermohonanLayanan::create([
                'layanan_id' => $validated['layanan_id'],
                'nama' => trim($validated['nama']),
                'nik' => preg_replace('/[^0-9]/', '', $validated['nik']),
                'email' => $validated['email'] ?? null,
                'telepon' => trim($validated['telepon']),
                'alamat' => trim($validated['alamat']),
                'pesan' => trim($validated['keperluan']),
                'status' => 'baru',
                'tracking_code' => $trackingCode,
                'file_ktp' => $fileKtp,
                'file_kk' => $fileKk,
                'file_pendukung' => $filePendukung,
                'assigned_to' => null,
                'catatan_admin' => null,
                'catatan_verifikasi' => null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | TRACKING LOG
            |--------------------------------------------------------------------------
            */
            TrackingHelper::log(
                $permohonan->tracking_code,
                'permohonan',
                null,
                'baru',
                'Permohonan layanan berhasil dibuat oleh masyarakat.',
                null
            );

            DB::commit();

            return redirect()
                ->route('public.tracking.index')
                ->with('success', 'Permohonan layanan berhasil dikirim.')
                ->with('tracking_code', $trackingCode)
                ->with('tracking_type', 'permohonan');

        } catch (Throwable $e) {
            DB::rollBack();

            if ($fileKtp && Storage::disk('public')->exists($fileKtp)) {
                Storage::disk('public')->delete($fileKtp);
            }

            if ($fileKk && Storage::disk('public')->exists($fileKk)) {
                Storage::disk('public')->delete($fileKk);
            }

            if ($filePendukung && Storage::disk('public')->exists($filePendukung)) {
                Storage::disk('public')->delete($filePendukung);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'system' => 'Terjadi kesalahan saat mengirim permohonan. Silakan coba lagi.'
                ]);
        }
    }
}