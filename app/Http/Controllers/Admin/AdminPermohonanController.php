<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TrackingHelper;
use App\Http\Controllers\Controller;
use App\Models\PermohonanLayanan;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminPermohonanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $query = PermohonanLayanan::with([
            'layanan',
            'admin'
        ])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $permohonans = $query->get();
        $admins = User::orderBy('name')->get();

        return view('admin.permohonan.index', compact(
            'permohonans',
            'admins'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): JsonResponse
    {
        $permohonan = PermohonanLayanan::with([
            'layanan',
            'admin'
        ])->findOrFail($id);

        return response()->json([
            'id' => $permohonan->id,
            'tracking_code' => $permohonan->tracking_code,

            'nama' => $permohonan->nama,
            'nik' => $permohonan->nik,
            'email' => $permohonan->email,
            'telepon' => $permohonan->telepon,
            'alamat' => $permohonan->alamat,
            'pesan' => $permohonan->pesan,

            'status' => $permohonan->status,
            'assigned_to' => $permohonan->assigned_to,
            'catatan_admin' => $permohonan->catatan_admin,
            'catatan_verifikasi' => $permohonan->catatan_verifikasi,
            'verified_at' => $permohonan->verified_at,

            'layanan' => [
                'id' => $permohonan->layanan?->id,
                'nama_layanan' => $permohonan->layanan?->nama_layanan,
            ],

            'admin' => [
                'id' => $permohonan->admin?->id,
                'name' => $permohonan->admin?->name,
            ],

            'file_ktp' => $permohonan->file_ktp,
            'file_kk' => $permohonan->file_kk,
            'file_pendukung' => $permohonan->file_pendukung,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:baru,ditinjau,diproses,menunggu_dokumen,selesai,ditolak',
            'assigned_to' => 'nullable|exists:users,id',
            'catatan_admin' => 'nullable|string',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $permohonan = PermohonanLayanan::findOrFail($id);

        $statusLama = $permohonan->status;

        $dataUpdate = [
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'catatan_admin' => $request->catatan_admin,
            'catatan_verifikasi' => $request->catatan_verifikasi,
        ];

        if (
            $request->status === 'selesai'
            && !$permohonan->verified_at
        ) {
            $dataUpdate['verified_at'] = now();
        }

        $permohonan->update($dataUpdate);

        if ($statusLama !== $request->status) {
            TrackingHelper::log(
                $permohonan->tracking_code,
                'permohonan',
                $statusLama,
                $request->status,
                $request->catatan_admin,
                auth()->id()
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil diperbarui.',
            'data' => $permohonan->fresh()->load([
                'layanan',
                'admin'
            ])
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD DOKUMEN
    |--------------------------------------------------------------------------
    */
    public function downloadDocument(int $id, string $type)
    {
        $permohonan = PermohonanLayanan::findOrFail($id);

        $dokumen = [
            'ktp' => $permohonan->file_ktp,
            'kk' => $permohonan->file_kk,
            'pendukung' => $permohonan->file_pendukung,
        ];

        if (!array_key_exists($type, $dokumen)) {
            abort(404, 'Tipe dokumen tidak valid.');
        }

        $path = $dokumen[$type];

        if (!$path) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        $fullPath = storage_path('app/public/' . $path);

        if (!file_exists($fullPath)) {
            abort(404, 'File dokumen tidak ditemukan di storage.');
        }

        return response()->download($fullPath);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(int $id): JsonResponse
    {
        $permohonan = PermohonanLayanan::findOrFail($id);

        foreach ([
            $permohonan->file_ktp,
            $permohonan->file_kk,
            $permohonan->file_pendukung
        ] as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

        $permohonan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permohonan berhasil dihapus.'
        ]);
    }
}