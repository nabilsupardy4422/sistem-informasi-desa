@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="mb-10">
        <h1 class="text-4xl font-black text-slate-800">
            Manajemen Tracking
        </h1>
        <p class="text-slate-500 mt-3 text-lg">
            Monitoring histori perubahan status pengaduan, permohonan, dan layanan.
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Total Tracking
            </p>
            <h3 class="text-5xl font-black text-blue-600">
                {{ $stats['total'] }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Pengaduan
            </p>
            <h3 class="text-5xl font-black text-red-600">
                {{ $stats['pengaduan'] }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Permohonan
            </p>
            <h3 class="text-5xl font-black text-purple-600">
                {{ $stats['permohonan'] }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Layanan
            </p>
            <h3 class="text-5xl font-black text-emerald-600">
                {{ $stats['layanan'] }}
            </h3>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8 mb-10">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Tracking Code
                </label>

                <input
                    type="text"
                    name="tracking_code"
                    value="{{ request('tracking_code') }}"
                    placeholder="Cari tracking code..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Jenis
                </label>

                <select
                    name="jenis"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">Semua Jenis</option>

                    @foreach($jenisList as $jenis)
                        <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>
                            {{ ucfirst($jenis) }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">Semua Status</option>

                    @foreach($statusList as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="xl:col-span-4 flex gap-4">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold">
                    Filter
                </button>

                <a href="{{ route('admin.tracking.index') }}"
                   class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl font-semibold">
                    Reset
                </a>
            </div>

        </form>

    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Riwayat Tracking
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1500px] text-sm">

                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-slate-600">
                        <th class="px-6 py-5 text-left">Tracking Code</th>
                        <th class="px-6 py-5 text-left">Jenis</th>
                        <th class="px-6 py-5 text-left">Status Lama</th>
                        <th class="px-6 py-5 text-left">Status Baru</th>
                        <th class="px-6 py-5 text-left">Catatan</th>
                        <th class="px-6 py-5 text-left">Admin</th>
                        <th class="px-6 py-5 text-left">Waktu</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($logs as $log)

                    <tr class="border-b border-slate-100 hover:bg-slate-50">

                        <td class="px-6 py-6 font-bold text-blue-600">
                            {{ $log->tracking_code }}
                        </td>

                        <td class="px-6 py-6">
                            <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-xs font-semibold">
                                {{ ucfirst($log->jenis) }}
                            </span>
                        </td>

                        <td class="px-6 py-6 text-slate-600">
                            {{ $log->status_lama ?? '-' }}
                        </td>

                        <td class="px-6 py-6 font-semibold text-slate-800">
                            {{ $log->status_baru }}
                        </td>

                        <td class="px-6 py-6 max-w-[300px]">
                            {{ \Illuminate\Support\Str::limit($log->catatan, 70) ?: '-' }}
                        </td>

                        <td class="px-6 py-6">
                            {{ $log->admin->name ?? '-' }}
                        </td>

                        <td class="px-6 py-6 text-slate-500">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('admin.tracking.show', $log->tracking_code) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-semibold">
                                    Detail
                                </a>

                                <button
                                    type="button"
                                    onclick="deleteTracking({{ $log->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center py-20 text-slate-500">
                            Tidak ada data tracking.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>

        <div class="px-8 py-6 border-t border-slate-200">
            {{ $logs->links() }}
        </div>

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

    async function deleteTracking(id) {
        const confirmed = confirm(
            'Yakin ingin menghapus log tracking ini?\n\nAksi ini tidak bisa dibatalkan.'
        );

        if (!confirmed) {
            return;
        }

        try {
            const response = await fetch(`/admin/tracking/${id}`, {
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

            alert(result.message || 'Log tracking berhasil dihapus.');
            location.reload();

        } catch (error) {
            console.error(error);

            if (error.message) {
                alert(error.message);
            } else {
                alert('Gagal menghapus log tracking.');
            }
        }
    }
    </script>

    @endsection