<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class UmkmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        return view('admin.umkm.index');
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA
    |--------------------------------------------------------------------------
    */
    public function data(): JsonResponse
    {
        $umkms = Umkm::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $umkms
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): JsonResponse
    {
        $umkm = Umkm::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $umkm
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateRequest($request);

        $fotoPath = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')
                    ->store('umkm', 'public');
            }

            $umkm = Umkm::create([
                'nama_umkm' => trim($validated['nama_umkm']),
                'pemilik' => trim($validated['pemilik']),
                'alamat' => trim($validated['alamat']),
                'no_hp' => trim($validated['no_hp']),
                'deskripsi' => $validated['deskripsi'] ?? null,
                'foto' => $fotoPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data UMKM berhasil ditambahkan.',
                'data' => $umkm
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data UMKM.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id): JsonResponse
    {
        $umkm = Umkm::findOrFail($id);

        $validated = $this->validateRequest($request);

        $newFotoPath = null;
        $oldFotoPath = $umkm->foto;

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto')) {
                $newFotoPath = $request->file('foto')
                    ->store('umkm', 'public');
            }

            $umkm->update([
                'nama_umkm' => trim($validated['nama_umkm']),
                'pemilik' => trim($validated['pemilik']),
                'alamat' => trim($validated['alamat']),
                'no_hp' => trim($validated['no_hp']),
                'deskripsi' => $validated['deskripsi'] ?? null,
                'foto' => $newFotoPath ?: $oldFotoPath
            ]);

            if ($newFotoPath && $oldFotoPath && Storage::disk('public')->exists($oldFotoPath)) {
                Storage::disk('public')->delete($oldFotoPath);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data UMKM berhasil diperbarui.',
                'data' => $umkm
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            if ($newFotoPath && Storage::disk('public')->exists($newFotoPath)) {
                Storage::disk('public')->delete($newFotoPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data UMKM.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(int $id): JsonResponse
    {
        $umkm = Umkm::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($umkm->foto && Storage::disk('public')->exists($umkm->foto)) {
                Storage::disk('public')->delete($umkm->foto);
            }

            $umkm->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data UMKM berhasil dihapus.'
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data UMKM.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */
    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'pemilik' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'nama_umkm.required' => 'Nama UMKM wajib diisi.',
            'pemilik.required' => 'Nama pemilik wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.max' => 'Ukuran gambar maksimal 2MB.',
        ]);
    }
}