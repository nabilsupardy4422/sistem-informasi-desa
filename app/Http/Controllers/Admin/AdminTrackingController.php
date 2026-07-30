<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AdminTrackingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PRIVATE QUERY BUILDER
    |--------------------------------------------------------------------------
    */
    private function buildQuery(Request $request)
    {
        $query = TrackingLog::with('admin')
            ->orderBy('created_at', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('tracking_code')) {
            $query->where(
                'tracking_code',
                'like',
                '%' . $request->tracking_code . '%'
            );
        }

        if ($request->filled('status')) {
            $query->where('status_baru', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        return $query;
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request): View
    {
        $logs = $this->buildQuery($request)
            ->paginate(15)
            ->appends($request->query());

        $stats = [
            'total' => TrackingLog::count(),
            'pengaduan' => TrackingLog::where('jenis', 'pengaduan')->count(),
            'permohonan' => TrackingLog::where('jenis', 'permohonan')->count(),
            'layanan' => TrackingLog::where('jenis', 'layanan')->count(),
        ];

        $jenisList = TrackingLog::select('jenis')
            ->whereNotNull('jenis')
            ->distinct()
            ->pluck('jenis');

        $statusList = TrackingLog::select('status_baru')
            ->whereNotNull('status_baru')
            ->distinct()
            ->pluck('status_baru');

        return view('admin.tracking.index', compact(
            'logs',
            'stats',
            'jenisList',
            'statusList'
        ));
    }
    /*
    |--------------------------------------------------------------------------
    | SHOW TRACKING TIMELINE
    |--------------------------------------------------------------------------
    */
    public function show(string $trackingCode): View
    {
        $logs = TrackingLog::with('admin')
            ->where('tracking_code', $trackingCode)
            ->orderBy('created_at', 'asc')
            ->get();

        abort_if($logs->isEmpty(), 404);

        $summary = [
            'tracking_code' => $trackingCode,
            'jenis' => $logs->first()->jenis,
            'status_awal' => $logs->first()->status_baru,
            'status_terakhir' => $logs->last()->status_baru,
            'total_update' => $logs->count(),
            'created_at' => $logs->first()->created_at,
            'updated_at' => $logs->last()->created_at,
        ];

        return view('admin.tracking.show', compact(
            'logs',
            'summary'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX DATA
    |--------------------------------------------------------------------------
    */
    public function data(Request $request): JsonResponse
    {
        $logs = $this->buildQuery($request)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE SINGLE LOG
    |--------------------------------------------------------------------------
    */
    public function destroy(int $id): JsonResponse
    {
        $log = TrackingLog::findOrFail($id);

        $log->delete();

        return response()->json([
            'success' => true,
            'message' => 'Log tracking berhasil dihapus.'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ALL BY TRACKING CODE
    |--------------------------------------------------------------------------
    */
    public function destroyByCode(string $trackingCode): JsonResponse
    {
        $deleted = TrackingLog::where(
            'tracking_code',
            $trackingCode
        )->delete();

        if ($deleted <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Data tracking tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua riwayat tracking berhasil dihapus.'
        ]);
    }
}