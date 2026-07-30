<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ApbdesDetail;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Penduduk;
use App\Models\PermohonanLayanan;
use App\Models\Pengaduan;
use App\Models\Umkm;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | BERITA
        |--------------------------------------------------------------------------
        */
        $allBerita = Berita::latest()->get();

        $slider = $allBerita->take(3);

        $featured = $allBerita->skip(3)->first() ?? $allBerita->first();

        $berita = $allBerita->skip(4)->take(6);

        if ($berita->isEmpty()) {
            $berita = $allBerita->take(6);
        }

        /*
        |--------------------------------------------------------------------------
        | STATISTICS
        |--------------------------------------------------------------------------
        */
        $stats = [
            'penduduk' => Penduduk::sum('jumlah_penduduk'),
            'umkm' => Umkm::count(),
            'layanan' => Layanan::count(),
            'permohonan_selesai' => PermohonanLayanan::where('status', 'selesai')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | UMKM PREVIEW
        |--------------------------------------------------------------------------
        */
        $umkmPreview = Umkm::latest()
            ->take(3)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | APBDES PREVIEW
        |--------------------------------------------------------------------------
        */
        $apbdesPreview = [
            'pendapatan' => ApbdesDetail::where('kategori', 'pendapatan')->sum('jumlah'),
            'belanja' => ApbdesDetail::where('kategori', 'belanja')->sum('jumlah'),
            'pembiayaan' => ApbdesDetail::where('kategori', 'pembiayaan')->sum('jumlah'),
        ];

        /*
        |--------------------------------------------------------------------------
        | PUBLIC COUNTS
        |--------------------------------------------------------------------------
        */
        $publicCounts = [
            'pengaduan' => Pengaduan::count(),
            'permohonan' => PermohonanLayanan::count(),
        ];

        return view('public.home.index', compact(
            'slider',
            'featured',
            'berita',
            'stats',
            'umkmPreview',
            'apbdesPreview',
            'publicCounts'
        ));
    }
}