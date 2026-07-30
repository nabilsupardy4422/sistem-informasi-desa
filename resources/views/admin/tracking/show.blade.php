@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Detail Tracking
            </h1>

            <p class="text-slate-500 text-lg">
                Timeline lengkap histori perubahan status layanan, pengaduan, dan permohonan masyarakat.
            </p>
        </div>

        <div class="flex flex-wrap gap-4">

            <a href="{{ route('admin.tracking.index') }}"
               class="bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 px-8 py-4 rounded-2xl font-semibold shadow-sm transition">
                Kembali
            </a>

            <button
                type="button"
                onclick="deleteAllLogs('{{ $summary['tracking_code'] }}')"
                class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-sm transition">
                Hapus Semua
            </button>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-6 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm xl:col-span-2">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Tracking Code
            </p>

            <h3 class="text-xl font-black text-blue-600 break-all">
                {{ $summary['tracking_code'] }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Jenis
            </p>

            <h3 class="text-xl font-black text-slate-800 capitalize">
                {{ $summary['jenis'] }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Status Awal
            </p>

            <h3 class="text-lg font-black text-amber-600 capitalize">
                {{ str_replace('_', ' ', $summary['status_awal']) }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Status Terakhir
            </p>

            <h3 class="text-lg font-black text-emerald-600 capitalize">
                {{ str_replace('_', ' ', $summary['status_terakhir']) }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Update
            </p>

            <h3 class="text-2xl font-black text-purple-600">
                {{ $summary['total_update'] }}
            </h3>
        </div>

    </div>

    {{-- META --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <p class="text-sm text-slate-500 mb-2 font-medium">
                Tracking Dimulai
            </p>

            <p class="text-lg font-bold text-slate-800">
                {{ $summary['created_at']->format('d M Y H:i') }}
            </p>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <p class="text-sm text-slate-500 mb-2 font-medium">
                Update Terakhir
            </p>

            <p class="text-lg font-bold text-slate-800">
                {{ $summary['updated_at']->format('d M Y H:i') }}
            </p>
        </div>

    </div>

    {{-- TIMELINE --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">

        <div class="mb-10">
            <h2 class="text-3xl font-black text-slate-800">
                Timeline Tracking
            </h2>

            <p class="text-slate-500 mt-2">
                Riwayat lengkap perubahan status.
            </p>
        </div>

        @if($logs->count())

            <div class="space-y-10">

                @foreach($logs as $log)

                    @php
                        $statusColor = match($log->status_baru) {
                            'baru' => 'bg-blue-600',
                            'ditinjau' => 'bg-yellow-500',
                            'diproses' => 'bg-orange-500',
                            'menunggu_dokumen' => 'bg-purple-500',
                            'selesai' => 'bg-green-600',
                            'ditolak' => 'bg-red-600',
                            default => 'bg-slate-500'
                        };

                        $jenisBadge = match($log->jenis) {
                            'layanan' => 'bg-blue-100 text-blue-700',
                            'pengaduan' => 'bg-orange-100 text-orange-700',
                            'permohonan' => 'bg-purple-100 text-purple-700',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <div class="flex gap-6">

                        {{-- TIMELINE LINE --}}
                        <div class="flex flex-col items-center shrink-0">

                            <div class="w-6 h-6 rounded-full {{ $statusColor }} shadow-lg"></div>

                            @if(!$loop->last)
                                <div class="w-[4px] h-full bg-slate-200 mt-3 rounded-full"></div>
                            @endif

                        </div>

                        {{-- CARD --}}
                        <div class="flex-1 bg-slate-50 border border-slate-200 rounded-3xl p-8">

                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-6">

                                <div>
                                    <h3 class="font-black text-2xl text-slate-800 capitalize">
                                        {{ str_replace('_', ' ', $log->status_baru) }}
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        {{ $log->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>

                                <span class="{{ $jenisBadge }} px-5 py-2 rounded-full text-sm font-semibold capitalize">
                                    {{ $log->jenis }}
                                </span>

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">
                                        Status Lama
                                    </p>

                                    <p class="font-bold text-slate-800 capitalize">
                                        {{ $log->status_lama ? str_replace('_', ' ', $log->status_lama) : '-' }}
                                    </p>
                                </div>

                                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">
                                        Status Baru
                                    </p>

                                    <p class="font-bold text-slate-800 capitalize">
                                        {{ str_replace('_', ' ', $log->status_baru) }}
                                    </p>
                                </div>

                                <div class="bg-white border border-slate-200 rounded-2xl p-5">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">
                                        Admin
                                    </p>

                                    <p class="font-bold text-slate-800">
                                        {{ $log->admin->name ?? '-' }}
                                    </p>
                                </div>

                            </div>

                            <div>
                                <p class="text-xs text-slate-500 mb-3 font-medium">
                                    Catatan
                                </p>

                                <div class="bg-white border border-slate-200 rounded-2xl p-6 text-slate-700 leading-relaxed">
                                    {{ $log->catatan ?? 'Tidak ada catatan.' }}
                                </div>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            @else

            <div class="text-center py-20">
                <div class="bg-slate-50 border border-slate-200 rounded-3xl p-12">
                    <p class="text-slate-500 text-lg">
                        Tidak ada histori tracking.
                    </p>
                </div>
            </div>

        @endif

    </div>

</div>

<script>
const csrfToken = '{{ csrf_token() }}';

async function safeJson(response) {
    const text = await response.text();

    if (!text) {
        return {};
    }

    try {
        return JSON.parse(text);
    } catch {
        return {
            success: false,
            message: 'Response server tidak valid.'
        };
    }
}

async function deleteAllLogs(trackingCode) {
    const confirmed = confirm(
        'Yakin ingin menghapus seluruh histori tracking ini?\n\nAksi ini permanen dan tidak bisa dibatalkan.'
    );

    if (!confirmed) {
        return;
    }

    try {
        const response = await fetch(`/admin/tracking/code/${trackingCode}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const result = await safeJson(response);

        if (!response.ok) {
            throw result;
        }

        alert(result.message || 'Semua histori tracking berhasil dihapus.');

        window.location.href = "{{ route('admin.tracking.index') }}";

    } catch (error) {
        console.error(error);

        if (error.message) {
            alert(error.message);
        } else {
            alert('Gagal menghapus histori tracking.');
        }
    }
}
</script>

@endsection