<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use App\Models\ApbdesDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;

class ApbdesController extends Controller
{
    private const KATEGORI_PENDAPATAN = 'pendapatan';
    private const KATEGORI_BELANJA = 'belanja';
    private const KATEGORI_PEMBIAYAAN = 'pembiayaan';

    private const JENIS_MASUK = 'masuk';
    private const JENIS_KELUAR = 'keluar';

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function getSummaryFromDetails(Collection $details): array
    {
        $pendapatan = $details
            ->where('kategori', self::KATEGORI_PENDAPATAN)
            ->sum('jumlah');

        $belanja = $details
            ->where('kategori', self::KATEGORI_BELANJA)
            ->sum('jumlah');

        $pembiayaanMasuk = $details
            ->where('kategori', self::KATEGORI_PEMBIAYAAN)
            ->where('jenis_pembiayaan', self::JENIS_MASUK)
            ->sum('jumlah');

        $pembiayaanKeluar = $details
            ->where('kategori', self::KATEGORI_PEMBIAYAAN)
            ->where('jenis_pembiayaan', self::JENIS_KELUAR)
            ->sum('jumlah');

        $saldo = $pendapatan + $pembiayaanMasuk - $belanja - $pembiayaanKeluar;

        return [
            'pendapatan' => (int) $pendapatan,
            'belanja' => (int) $belanja,
            'pembiayaan_masuk' => (int) $pembiayaanMasuk,
            'pembiayaan_keluar' => (int) $pembiayaanKeluar,
            'saldo' => (int) $saldo,
        ];
    }

    private function recalculateApbdesTotal(int $apbdesId): void
    {
        $details = ApbdesDetail::where('apbdes_id', $apbdesId)->get();

        $summary = $this->getSummaryFromDetails($details);

        Apbdes::where('id', $apbdesId)->update([
            'total_anggaran' => $summary['saldo']
        ]);
    }

    private function validateDetail(Request $request): array
    {
        $validated = $request->validate([
            'apbdes_id' => 'nullable|exists:apbdes,id',
            'kategori' => 'required|in:pendapatan,belanja,pembiayaan',
            'nama_item' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'jenis_pembiayaan' => 'nullable|in:masuk,keluar'
        ]);

        if (
            $validated['kategori'] === self::KATEGORI_PEMBIAYAAN &&
            empty($validated['jenis_pembiayaan'])
        ) {
            abort(response()->json([
                'success' => false,
                'message' => 'Jenis pembiayaan wajib dipilih.'
            ], 422));
        }

        if ($validated['kategori'] !== self::KATEGORI_PEMBIAYAAN) {
            $validated['jenis_pembiayaan'] = null;
        }

        return $validated;
    }

    /*
    |--------------------------------------------------------------------------
    | APBDes Main
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View|JsonResponse
    {
        $tahun = $request->tahun;

        $query = Apbdes::with('details');

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $apbdesList = $query
            ->orderBy('tahun', 'desc')
            ->get();

        $grandSummary = [
            'pendapatan' => 0,
            'belanja' => 0,
            'pembiayaan_masuk' => 0,
            'pembiayaan_keluar' => 0,
            'saldo' => 0,
        ];

        foreach ($apbdesList as $item) {
            $summary = $this->getSummaryFromDetails($item->details);

            $item->pendapatan = $summary['pendapatan'];
            $item->belanja = $summary['belanja'];
            $item->pembiayaan_masuk = $summary['pembiayaan_masuk'];
            $item->pembiayaan_keluar = $summary['pembiayaan_keluar'];
            $item->saldo = $summary['saldo'];

            $grandSummary['pendapatan'] += $summary['pendapatan'];
            $grandSummary['belanja'] += $summary['belanja'];
            $grandSummary['pembiayaan_masuk'] += $summary['pembiayaan_masuk'];
            $grandSummary['pembiayaan_keluar'] += $summary['pembiayaan_keluar'];
            $grandSummary['saldo'] += $summary['saldo'];
        }

        $chartData = $apbdesList->map(function ($item) {
            return [
                'tahun' => $item->tahun,
                'pendapatan' => $item->pendapatan,
                'belanja' => $item->belanja,
                'pembiayaan_masuk' => $item->pembiayaan_masuk,
                'pembiayaan_keluar' => $item->pembiayaan_keluar,
                'saldo' => $item->saldo,
            ];
        });

        if (
            $request->ajax() ||
            $request->expectsJson() ||
            $request->wantsJson()
        ) {
            return response()->json([
                'success' => true,
                'data' => $apbdesList,
                'summary' => $grandSummary,
                'chart' => $chartData
            ]);
        }

        $tahunList = Apbdes::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('admin.apbdes.index', compact('tahunList'));
    }

    public function show(int $id): JsonResponse
    {
        $apbdes = Apbdes::with('details')->findOrFail($id);

        $summary = $this->getSummaryFromDetails($apbdes->details);

        return response()->json([
            'success' => true,
            'data' => $apbdes,
            'details' => $apbdes->details,
            'summary' => $summary
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|unique:apbdes,tahun'
        ]);

        $apbdes = Apbdes::create([
            'tahun' => $validated['tahun'],
            'total_anggaran' => 0
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil ditambahkan.',
            'data' => $apbdes
        ]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'tahun' => 'required|digits:4|unique:apbdes,tahun,' . $id
        ]);

        $apbdes = Apbdes::findOrFail($id);

        $apbdes->update([
            'tahun' => $validated['tahun']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil diperbarui.',
            'data' => $apbdes
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $apbdes = Apbdes::findOrFail($id);

        ApbdesDetail::where('apbdes_id', $id)->delete();

        $apbdes->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data APBDes berhasil dihapus.'
        ]);
    }

    public function detail(int $id): View
    {
        $apbdes = Apbdes::findOrFail($id);

        return view('admin.apbdes.detail', compact('apbdes'));
    }

    /*
    |--------------------------------------------------------------------------
    | APBDes Detail CRUD
    |--------------------------------------------------------------------------
    */

    public function storeDetail(Request $request): JsonResponse
    {
        $validated = $this->validateDetail($request);

        if (empty($validated['apbdes_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'APBDes ID wajib diisi.'
            ], 422);
        }

        $detail = ApbdesDetail::create([
            'apbdes_id' => $validated['apbdes_id'],
            'kategori' => $validated['kategori'],
            'jenis_pembiayaan' => $validated['jenis_pembiayaan'],
            'nama_item' => $validated['nama_item'],
            'jumlah' => $validated['jumlah']
        ]);

        $this->recalculateApbdesTotal($detail->apbdes_id);

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil ditambahkan.',
            'data' => $detail
        ]);
    }

    public function showDetail(int $id): JsonResponse
    {
        $detail = ApbdesDetail::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $detail
        ]);
    }

    public function updateDetail(Request $request, int $id): JsonResponse
    {
        $validated = $this->validateDetail($request);

        $detail = ApbdesDetail::findOrFail($id);

        $detail->update([
            'kategori' => $validated['kategori'],
            'jenis_pembiayaan' => $validated['jenis_pembiayaan'],
            'nama_item' => $validated['nama_item'],
            'jumlah' => $validated['jumlah']
        ]);

        $this->recalculateApbdesTotal($detail->apbdes_id);

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diperbarui.',
            'data' => $detail
        ]);
    }

    public function destroyDetail(int $id): JsonResponse
    {
        $detail = ApbdesDetail::findOrFail($id);

        $apbdesId = $detail->apbdes_id;

        $detail->delete();

        $this->recalculateApbdesTotal($apbdesId);

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil dihapus.'
        ]);
    }
}