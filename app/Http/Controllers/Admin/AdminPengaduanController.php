<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\TrackingHelper;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AdminPengaduanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $query = Pengaduan::with('admin')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('prioritas')) {
            $query->where('prioritas', $request->prioritas);
        }

        $pengaduans = $query->get();

        $admins = User::where('role', 'admin')
            ->orderBy('name')
            ->get();

        $kategoriList = Pengaduan::whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('admin.pengaduan.index', compact(
            'pengaduans',
            'admins',
            'kategoriList'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): JsonResponse
    {
        $pengaduan = Pengaduan::with('admin')
            ->findOrFail($id);

        return response()->json([
            'id' => $pengaduan->id,
            'tracking_code' => $pengaduan->tracking_code,
            'nama' => $pengaduan->nama,
            'nik' => $pengaduan->nik,
            'email' => $pengaduan->email,
            'telepon' => $pengaduan->telepon,
            'kategori' => $pengaduan->kategori,
            'alamat' => $pengaduan->alamat,
            'isi_pengaduan' => $pengaduan->isi_pengaduan,
            'status' => $pengaduan->status,
            'prioritas' => $pengaduan->prioritas,
            'assigned_to' => $pengaduan->assigned_to,
            'catatan_admin' => $pengaduan->catatan_admin,
            'created_at' => $pengaduan->created_at,
            'admin' => $pengaduan->admin
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:baru,ditinjau,diproses,selesai,ditolak',
            'prioritas' => 'required|in:rendah,sedang,tinggi,urgent',
            'assigned_to' => 'nullable|exists:users,id',
            'catatan_admin' => 'nullable|string'
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $statusLama = $pengaduan->status;

        $pengaduan->update($validated);

        if ($statusLama !== $validated['status']) {
            TrackingHelper::log(
                $pengaduan->tracking_code,
                'pengaduan',
                $statusLama,
                $validated['status'],
                $validated['catatan_admin'] ?? null,
                auth()->id()
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil diperbarui',
            'data' => $pengaduan->fresh()->load('admin')
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy(int $id): JsonResponse
    {
        $pengaduan = Pengaduan::findOrFail($id);

        TrackingHelper::log(
            $pengaduan->tracking_code,
            'pengaduan',
            $pengaduan->status,
            'deleted',
            'Pengaduan dihapus oleh admin',
            auth()->id()
        );

        $pengaduan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengaduan berhasil dihapus'
        ]);
    }
}