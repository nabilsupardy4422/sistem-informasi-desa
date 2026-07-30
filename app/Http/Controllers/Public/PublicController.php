<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Umkm;
use Illuminate\View\View;

class PublicController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PENDUDUK
    |--------------------------------------------------------------------------
    */
    public function penduduk(): View
    {
        $data = Penduduk::orderByDesc('tahun')->get();

        $latest = $data->first();

        $chartLabels = $data->pluck('tahun')->reverse()->values();
        $chartPenduduk = $data->pluck('jumlah_penduduk')->reverse()->values();
        $chartLaki = $data->pluck('jumlah_laki')->reverse()->values();
        $chartPerempuan = $data->pluck('jumlah_perempuan')->reverse()->values();
        $chartKk = $data->pluck('jumlah_kk')->reverse()->values();

        return view('public.penduduk.index', compact(
            'data',
            'latest',
            'chartLabels',
            'chartPenduduk',
            'chartLaki',
            'chartPerempuan',
            'chartKk'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UMKM
    |--------------------------------------------------------------------------
    */
    public function umkm(): View
    {
        $data = Umkm::latest()->get();

        $summary = [
            'total' => $data->count(),
            'with_photo' => $data->whereNotNull('foto')->count(),
            'owners' => $data->pluck('pemilik')->unique()->count(),
        ];

        return view('public.umkm.index', compact(
            'data',
            'summary'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UMKM DETAIL
    |--------------------------------------------------------------------------
    */
    public function umkmShow(int $id): View
    {
        $data = Umkm::findOrFail($id);

        $related = Umkm::where('id', '!=', $data->id)
            ->latest()
            ->take(3)
            ->get();

        return view('public.umkm.show', compact(
            'data',
            'related'
        ));
    }
}