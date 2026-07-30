<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PermohonanLayanan;
use App\Models\Pengaduan;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TrackingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(): View
    {
        return view('public.tracking.index');
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH TRACKING
    |--------------------------------------------------------------------------
    */
    public function cari(Request $request): View|RedirectResponse
    {
        $request->validate([
            'tracking_code' => 'required|string|max:100'
        ]);

        $trackingCode = strtoupper(trim($request->tracking_code));

        /*
        |--------------------------------------------------------------------------
        | PERMOHONAN
        |--------------------------------------------------------------------------
        */
        $permohonan = PermohonanLayanan::with('layanan')
            ->where('tracking_code', $trackingCode)
            ->first();

        if ($permohonan) {
            $logs = TrackingLog::with('admin')
                ->where('tracking_code', $trackingCode)
                ->orderBy('created_at', 'asc')
                ->get();

            return view('public.tracking.result', [
                'jenis' => 'permohonan',
                'data' => $permohonan,
                'logs' => $logs
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | PENGADUAN
        |--------------------------------------------------------------------------
        */
        $pengaduan = Pengaduan::where('tracking_code', $trackingCode)
            ->first();

        if ($pengaduan) {
            $logs = TrackingLog::with('admin')
                ->where('tracking_code', $trackingCode)
                ->orderBy('created_at', 'asc')
                ->get();

            return view('public.tracking.result', [
                'jenis' => 'pengaduan',
                'data' => $pengaduan,
                'logs' => $logs
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | NOT FOUND
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route('public.tracking.index')
            ->with('error', 'Kode tracking tidak ditemukan.');
    }
}