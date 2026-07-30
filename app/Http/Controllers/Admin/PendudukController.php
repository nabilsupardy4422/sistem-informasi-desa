<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Throwable;

class PendudukController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        return view('admin.penduduk.index');
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA
    |--------------------------------------------------------------------------
    */
    public function getData(): JsonResponse
    {
        $data = Penduduk::orderByDesc('tahun')->get();

        return response()->json([
            'success' => true,
            'data' => $data
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
            'tahun' => 'required|integer|min:1900|max:2100|unique:penduduks,tahun',
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'jumlah_kk' => 'required|integer|min:0',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.unique' => 'Data untuk tahun tersebut sudah ada.',
            'jumlah_laki.required' => 'Jumlah laki-laki wajib diisi.',
            'jumlah_perempuan.required' => 'Jumlah perempuan wajib diisi.',
            'jumlah_kk.required' => 'Jumlah KK wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $jumlahPenduduk = (int)$validated['jumlah_laki'] + (int)$validated['jumlah_perempuan'];

            $penduduk = Penduduk::create([
                'tahun' => $validated['tahun'],
                'jumlah_laki' => $validated['jumlah_laki'],
                'jumlah_perempuan' => $validated['jumlah_perempuan'],
                'jumlah_kk' => $validated['jumlah_kk'],
                'jumlah_penduduk' => $jumlahPenduduk,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data penduduk berhasil ditambahkan.',
                'data' => $penduduk
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data penduduk.'
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
        $data = Penduduk::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = Penduduk::findOrFail($id);

        $validated = $request->validate([
            'tahun' => 'required|integer|min:1900|max:2100|unique:penduduks,tahun,' . $id,
            'jumlah_laki' => 'required|integer|min:0',
            'jumlah_perempuan' => 'required|integer|min:0',
            'jumlah_kk' => 'required|integer|min:0',
        ], [
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.unique' => 'Data untuk tahun tersebut sudah ada.',
            'jumlah_laki.required' => 'Jumlah laki-laki wajib diisi.',
            'jumlah_perempuan.required' => 'Jumlah perempuan wajib diisi.',
            'jumlah_kk.required' => 'Jumlah KK wajib diisi.',
        ]);

        try {
            DB::beginTransaction();

            $jumlahPenduduk = (int)$validated['jumlah_laki'] + (int)$validated['jumlah_perempuan'];

            $data->update([
                'tahun' => $validated['tahun'],
                'jumlah_laki' => $validated['jumlah_laki'],
                'jumlah_perempuan' => $validated['jumlah_perempuan'],
                'jumlah_kk' => $validated['jumlah_kk'],
                'jumlah_penduduk' => $jumlahPenduduk,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data penduduk berhasil diperbarui.',
                'data' => $data
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data penduduk.'
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
        try {
            DB::beginTransaction();

            $data = Penduduk::findOrFail($id);
            $data->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data penduduk berhasil dihapus.'
            ]);

        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data penduduk.'
            ], 500);
        }
    }
}