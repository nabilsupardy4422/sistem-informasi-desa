<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BeritaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        return view('admin.berita.index');
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA
    |--------------------------------------------------------------------------
    */
    public function getData(): JsonResponse
    {
        $beritas = Berita::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $beritas
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|min:20',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'isi.required' => 'Isi berita wajib diisi.',
            'isi.min' => 'Isi berita minimal 20 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $gambarPath = null;

        try {
            DB::beginTransaction();

            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')
                    ->store('berita', 'public');
            }

            $berita = Berita::create([
                'judul' => trim($validated['judul']),
                'isi' => trim($validated['isi']),
                'gambar' => $gambarPath
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil ditambahkan.',
                'data' => $berita
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan berita.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(int $id): JsonResponse
    {
        $berita = Berita::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $berita
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id): JsonResponse
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string|min:20',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'isi.required' => 'Isi berita wajib diisi.',
            'isi.min' => 'Isi berita minimal 20 karakter.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $newImagePath = null;
        $oldImagePath = $berita->gambar;

        try {
            DB::beginTransaction();

            if ($request->hasFile('gambar')) {
                $newImagePath = $request->file('gambar')
                    ->store('berita', 'public');
            }

            $berita->update([
                'judul' => trim($validated['judul']),
                'isi' => trim($validated['isi']),
                'gambar' => $newImagePath ?: $oldImagePath
            ]);

            if ($newImagePath && $oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil diperbarui.',
                'data' => $berita
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            if ($newImagePath && Storage::disk('public')->exists($newImagePath)) {
                Storage::disk('public')->delete($newImagePath);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui berita.'
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
        $berita = Berita::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            $berita->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berita berhasil dihapus.'
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus berita.'
            ], 500);
        }
    }
}