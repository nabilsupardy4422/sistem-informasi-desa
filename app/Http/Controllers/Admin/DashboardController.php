<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApbdesDetail;
use App\Models\Layanan;
use App\Models\Pengaduan;
use App\Models\PermohonanLayanan;
use App\Models\TrackingLog;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */
        $totalLayanan = Layanan::count();
        $layananAktif = Layanan::where('status', 'aktif')->count();

        $totalPermohonan = PermohonanLayanan::count();

        $permohonanBaru = PermohonanLayanan::where('status', 'baru')->count();

        $permohonanDiproses = PermohonanLayanan::whereIn('status', [
            'ditinjau',
            'diproses',
            'menunggu_dokumen'
        ])->count();

        $permohonanSelesai = PermohonanLayanan::where('status', 'selesai')->count();

        $totalPengaduan = Pengaduan::count();

        $pengaduanAktif = Pengaduan::whereIn('status', [
            'baru',
            'ditinjau',
            'diproses'
        ])->count();

        $pengaduanSelesai = Pengaduan::where('status', 'selesai')->count();

        $totalTracking = TrackingLog::count();

        $trackingHariIni = TrackingLog::whereDate('created_at', today())->count();

        $pendingTotal =
            PermohonanLayanan::whereNotIn('status', [
                'selesai',
                'ditolak'
            ])->count()
            +
            Pengaduan::whereNotIn('status', [
                'selesai',
                'ditolak'
            ])->count();

        /*
        |--------------------------------------------------------------------------
        | APBDES (AKUMULASI SEMUA DATA)
        |--------------------------------------------------------------------------
        */
        $pendapatan = ApbdesDetail::whereRaw(
            'LOWER(kategori) LIKE ?',
            ['%pendapatan%']
        )->sum('jumlah');

        $belanja = ApbdesDetail::whereRaw(
            'LOWER(kategori) LIKE ?',
            ['%belanja%']
        )->sum('jumlah');

        $pembiayaanMasuk = ApbdesDetail::whereRaw(
            'LOWER(kategori) LIKE ?',
            ['%pembiayaan%']
        )
        ->whereRaw(
            'LOWER(jenis_pembiayaan) LIKE ?',
            ['%masuk%']
        )
        ->sum('jumlah');

        $pembiayaanKeluar = ApbdesDetail::whereRaw(
            'LOWER(kategori) LIKE ?',
            ['%pembiayaan%']
        )
        ->whereRaw(
            'LOWER(jenis_pembiayaan) LIKE ?',
            ['%keluar%']
        )
        ->sum('jumlah');

        $saldoDesa =
            $pendapatan
            - $belanja
            + $pembiayaanMasuk
            - $pembiayaanKeluar;

        /*
        |--------------------------------------------------------------------------
        | TREND CHART
        |--------------------------------------------------------------------------
        */
        $chartLabels = [];
        $chartPermohonan = [];
        $chartPengaduan = [];
        $chartTracking = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $chartLabels[] = $date->translatedFormat('M Y');

            $chartPermohonan[] = PermohonanLayanan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chartPengaduan[] = Pengaduan::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            $chartTracking[] = TrackingLog::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS BREAKDOWN
        |--------------------------------------------------------------------------
        */
        $permohonanStatusBreakdown = [
            'baru' => PermohonanLayanan::where('status', 'baru')->count(),
            'ditinjau' => PermohonanLayanan::where('status', 'ditinjau')->count(),
            'diproses' => PermohonanLayanan::where('status', 'diproses')->count(),
            'menunggu_dokumen' => PermohonanLayanan::where('status', 'menunggu_dokumen')->count(),
            'selesai' => PermohonanLayanan::where('status', 'selesai')->count(),
            'ditolak' => PermohonanLayanan::where('status', 'ditolak')->count(),
        ];

        $pengaduanStatusBreakdown = [
            'baru' => Pengaduan::where('status', 'baru')->count(),
            'ditinjau' => Pengaduan::where('status', 'ditinjau')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | RECENT DATA
        |--------------------------------------------------------------------------
        */
        $recentPermohonan = PermohonanLayanan::with('layanan')
            ->latest()
            ->take(5)
            ->get();

        $recentPengaduan = Pengaduan::latest()
            ->take(5)
            ->get();

        $recentTracking = TrackingLog::with('admin')
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | QUICK STATS
        |--------------------------------------------------------------------------
        */
        $quickStats = [
            [
                'label' => 'Total Layanan',
                'value' => $totalLayanan,
                'icon' => 'file-text',
            ],
            [
                'label' => 'Permohonan Masuk',
                'value' => $totalPermohonan,
                'icon' => 'mail',
            ],
            [
                'label' => 'Pengaduan Masuk',
                'value' => $totalPengaduan,
                'icon' => 'alert-triangle',
            ],
            [
                'label' => 'Tracking Logs',
                'value' => $totalTracking,
                'icon' => 'map-pinned',
            ],
        ];

        return view('admin.dashboard', compact(
            'totalLayanan',
            'layananAktif',
            'totalPermohonan',
            'permohonanBaru',
            'permohonanDiproses',
            'permohonanSelesai',
            'totalPengaduan',
            'pengaduanAktif',
            'pengaduanSelesai',
            'totalTracking',
            'trackingHariIni',
            'pendingTotal',
            'saldoDesa',
            'pendapatan',
            'belanja',
            'pembiayaanMasuk',
            'pembiayaanKeluar',
            'chartLabels',
            'chartPermohonan',
            'chartPengaduan',
            'chartTracking',
            'permohonanStatusBreakdown',
            'pengaduanStatusBreakdown',
            'recentPermohonan',
            'recentPengaduan',
            'recentTracking',
            'quickStats'
        ));
    }
}