<?php

namespace App\Helpers;

use App\Models\TrackingLog;
use App\Models\PermohonanLayanan;
use App\Models\Pengaduan;

class TrackingHelper
{
    public static function generateCode(string $prefix): string
    {
        $year = date('Y');

        if ($prefix === 'LYN') {
            $count = PermohonanLayanan::count() + 1;
        } else {
            $count = Pengaduan::count() + 1;
        }

        return sprintf('%s-%s-%04d', $prefix, $year, $count);
    }

    public static function log(
        string $trackingCode,
        string $jenis,
        ?string $statusLama,
        string $statusBaru,
        ?string $catatan = null,
        ?int $updatedBy = null
    ): void {
        TrackingLog::create([
            'tracking_code' => $trackingCode,
            'jenis' => $jenis,
            'status_lama' => $statusLama,
            'status_baru' => $statusBaru,
            'catatan' => $catatan,
            'updated_by' => $updatedBy
        ]);
    }
}