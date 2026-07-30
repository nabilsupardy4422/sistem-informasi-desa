<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;

class ApbdesController extends Controller
{
    public function index()
    {
        $tahunList = Apbdes::select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('public.apbdes.index', compact('tahunList'));
    }

    public function data(Request $request)
    {
        $tahun = $request->tahun;

        $query = Apbdes::with('details');

        if ($tahun) {
            $query->where('tahun', $tahun);
        }

        $data = $query
            ->orderBy('tahun', 'desc')
            ->get();

        $totalPendapatan = 0;
        $totalBelanja = 0;
        $totalPembiayaanMasuk = 0;
        $totalPembiayaanKeluar = 0;
        $totalSaldo = 0;

        foreach ($data as $item) {

            $pendapatan = $item->details
                ->where('kategori', 'pendapatan')
                ->sum('jumlah');

            $belanja = $item->details
                ->where('kategori', 'belanja')
                ->sum('jumlah');

            $pembiayaanMasuk = $item->details
                ->where('kategori', 'pembiayaan')
                ->where('jenis_pembiayaan', 'masuk')
                ->sum('jumlah');

            $pembiayaanKeluar = $item->details
                ->where('kategori', 'pembiayaan')
                ->where('jenis_pembiayaan', 'keluar')
                ->sum('jumlah');

            $saldo = $pendapatan - $belanja + $pembiayaanMasuk - $pembiayaanKeluar;

            $item->pendapatan = $pendapatan;
            $item->belanja = $belanja;
            $item->pembiayaan_masuk = $pembiayaanMasuk;
            $item->pembiayaan_keluar = $pembiayaanKeluar;
            $item->saldo = $saldo;

            $totalPendapatan += $pendapatan;
            $totalBelanja += $belanja;
            $totalPembiayaanMasuk += $pembiayaanMasuk;
            $totalPembiayaanKeluar += $pembiayaanKeluar;
            $totalSaldo += $saldo;
        }

        $chartData = $data->map(function ($item) {
            return [
                'tahun' => $item->tahun,
                'pendapatan' => $item->pendapatan,
                'belanja' => $item->belanja,
                'pembiayaan_masuk' => $item->pembiayaan_masuk,
                'pembiayaan_keluar' => $item->pembiayaan_keluar,
            ];
        });

        return response()->json([
            'data' => $data,
            'chart' => $chartData,
            'summary' => [
                'pendapatan' => $totalPendapatan,
                'belanja' => $totalBelanja,
                'pembiayaan_masuk' => $totalPembiayaanMasuk,
                'pembiayaan_keluar' => $totalPembiayaanKeluar,
                'saldo' => $totalSaldo,
            ]
        ]);
    }
}