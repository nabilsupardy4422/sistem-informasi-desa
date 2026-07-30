@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-indigo-700 via-violet-600 to-indigo-500 p-10 lg:p-14 shadow-2xl">

        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 grid grid-cols-1 xl:grid-cols-2 gap-10 items-center">

            <div>
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-xl border border-white/10 px-5 py-3 rounded-full text-xs font-black uppercase tracking-widest text-white mb-8">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Sistem Smart Village v3.0
                </div>

                <h2 class="text-4xl md:text-6xl font-black text-white tracking-tight leading-[1.05] mb-8">
                    Selamat Datang,
                    Pusat Kendali Desa Digital
                </h2>

                <p class="text-lg text-indigo-100 leading-relaxed max-w-2xl">
                    Pantau layanan publik, pengaduan masyarakat, sistem tracking,
                    serta transparansi APBDes dalam satu dashboard terpadu.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                <a href="{{ route('admin.layanan.index') }}"
                   class="bg-white text-indigo-700 px-6 py-5 rounded-2xl font-black text-center shadow-xl hover:scale-105 transition">
                    Kelola Layanan
                </a>

                <a href="{{ route('admin.permohonan.index') }}"
                   class="bg-white/10 backdrop-blur-xl border border-white/15 text-white px-6 py-5 rounded-2xl font-black text-center hover:bg-white/20 transition">
                    Permohonan
                </a>

                <a href="{{ route('admin.pengaduan.index') }}"
                   class="bg-white/10 backdrop-blur-xl border border-white/15 text-white px-6 py-5 rounded-2xl font-black text-center hover:bg-white/20 transition">
                    Pengaduan
                </a>

            </div>

        </div>

    </section>

    {{-- QUICK STATS --}}
    <section>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8">

            @foreach($quickStats as $stat)
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 hover:shadow-xl transition">

                    <div class="flex items-center justify-between mb-8">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6 text-indigo-600"></i>
                        </div>

                        <span class="text-[10px] font-black uppercase tracking-widest text-indigo-500 bg-indigo-50 px-3 py-2 rounded-full">
                            LIVE DATA
                        </span>
                    </div>

                    <p class="text-sm font-semibold text-slate-500 mb-4">
                        {{ $stat['label'] }}
                    </p>

                    <h3 class="text-5xl font-black text-slate-900">
                        {{ number_format($stat['value']) }}
                    </h3>

                    <div class="mt-6 h-2 rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full bg-indigo-500 rounded-full w-3/4"></div>
                    </div>

                </div>
            @endforeach

        </div>
    </section>

    {{-- APBDES --}}
    <section>
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

            {{-- SALDO --}}
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8 xl:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.25em] text-slate-400">
                            Saldo Desa
                        </p>

                        <h3 class="text-4xl font-black text-slate-900 mt-4">
                            Rp {{ number_format($saldoDesa, 0, ',', '.') }}
                        </h3>
                    </div>

                    <div class="w-16 h-16 rounded-3xl bg-indigo-50 flex items-center justify-center">
                        <i data-lucide="wallet" class="w-8 h-8 text-indigo-600"></i>
                    </div>
                </div>

                <p class="text-slate-500 text-sm leading-relaxed">
                    Ringkasan kondisi keuangan desa berdasarkan APBDes aktif.
                </p>
            </div>

            {{-- PENDAPATAN --}}
            <div class="bg-emerald-50 rounded-[2rem] border border-emerald-100 p-8">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xs font-black uppercase tracking-[0.25em] text-emerald-500">
                        Pendapatan
                    </p>

                    <i data-lucide="trending-up" class="w-5 h-5 text-emerald-500"></i>
                </div>

                <h4 class="text-2xl font-black text-emerald-700 leading-tight">
                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </h4>
            </div>

            {{-- BELANJA --}}
            <div class="bg-rose-50 rounded-[2rem] border border-rose-100 p-8">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xs font-black uppercase tracking-[0.25em] text-rose-500">
                        Belanja
                    </p>

                    <i data-lucide="trending-down" class="w-5 h-5 text-rose-500"></i>
                </div>

                <h4 class="text-2xl font-black text-rose-700 leading-tight">
                    Rp {{ number_format($belanja, 0, ',', '.') }}
                </h4>
            </div>

            {{-- PEMBIAYAAN MASUK --}}
            <div class="bg-cyan-50 rounded-[2rem] border border-cyan-100 p-8">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-cyan-500">
                        Pembiayaan Masuk
                    </p>

                    <i data-lucide="arrow-down-left" class="w-5 h-5 text-cyan-500"></i>
                </div>

                <h4 class="text-xl font-black text-cyan-700 leading-tight">
                    Rp {{ number_format($pembiayaanMasuk, 0, ',', '.') }}
                </h4>
            </div>

            {{-- PEMBIAYAAN KELUAR --}}
            <div class="bg-amber-50 rounded-[2rem] border border-amber-100 p-8">
                <div class="flex items-center justify-between mb-5">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-500">
                        Pembiayaan Keluar
                    </p>

                    <i data-lucide="arrow-up-right" class="w-5 h-5 text-amber-500"></i>
                </div>

                <h4 class="text-xl font-black text-amber-700 leading-tight">
                    Rp {{ number_format($pembiayaanKeluar, 0, ',', '.') }}
                </h4>
            </div>

        </div>
    </section>

        {{-- CHARTS --}}
        <section>
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- TREND --}}
                <div class="xl:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">

                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900">
                                Tren Aktivitas Sistem
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Aktivitas 6 bulan terakhir
                            </p>
                        </div>

                        <span class="text-xs font-black uppercase tracking-widest bg-slate-100 px-4 py-2 rounded-full text-slate-500">
                            Live
                        </span>
                    </div>

                    <div class="h-[380px]">
                        <canvas id="trendChart"></canvas>
                    </div>

                </div>

                {{-- MINI STATS --}}
                <div class="space-y-6">

                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                        <p class="text-xs uppercase font-black tracking-widest text-slate-400 mb-4">
                            Permohonan Baru
                        </p>

                        <h3 class="text-5xl font-black text-amber-500">
                            {{ $permohonanBaru }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                        <p class="text-xs uppercase font-black tracking-widest text-slate-400 mb-4">
                            Pengaduan Aktif
                        </p>

                        <h3 class="text-5xl font-black text-rose-500">
                            {{ $pengaduanAktif }}
                        </h3>
                    </div>

                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                        <p class="text-xs uppercase font-black tracking-widest text-slate-400 mb-4">
                            Tracking Hari Ini
                        </p>

                        <h3 class="text-5xl font-black text-indigo-500">
                            {{ $trackingHariIni }}
                        </h3>
                    </div>

                </div>

            </div>
        </section>

        {{-- BREAKDOWN --}}
        <section>
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

                {{-- STATUS PERMOHONAN --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-slate-900">
                            Status Permohonan
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Breakdown status permohonan layanan
                        </p>
                    </div>

                    <div class="h-[360px]">
                        <canvas id="permohonanChart"></canvas>
                    </div>
                </div>

                {{-- STATUS PENGADUAN --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-black text-slate-900">
                            Status Pengaduan
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Breakdown status pengaduan masyarakat
                        </p>
                    </div>

                    <div class="h-[360px]">
                        <canvas id="pengaduanChart"></canvas>
                    </div>
                </div>

            </div>
        </section>

        {{-- RECENT DATA --}}
        <section>
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- PERMOHONAN TERBARU --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">

                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-slate-900">
                                Permohonan Terbaru
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Permohonan masuk terbaru
                            </p>
                        </div>

                        <a href="{{ route('admin.permohonan.index') }}"
                           class="text-indigo-600 text-sm font-black">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="space-y-5">

                        @forelse($recentPermohonan as $item)

                            @php
                                $statusColors = [
                                    'baru' => 'bg-amber-50 text-amber-600',
                                    'ditinjau' => 'bg-violet-50 text-violet-600',
                                    'diproses' => 'bg-blue-50 text-blue-600',
                                    'menunggu_dokumen' => 'bg-cyan-50 text-cyan-600',
                                    'selesai' => 'bg-emerald-50 text-emerald-600',
                                    'ditolak' => 'bg-rose-50 text-rose-600',
                                ];
                            @endphp

                            <div class="flex items-start gap-4">

                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center font-black text-indigo-600">
                                    {{ strtoupper(substr($item->nama, 0, 1)) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-3">
                                        <h4 class="font-black text-slate-900 truncate">
                                            {{ $item->nama }}
                                        </h4>

                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-sm text-slate-500 mt-1">
                                        {{ $item->layanan->nama_layanan ?? 'Layanan' }}
                                    </p>

                                    <div class="mt-3">
                                        <span class="text-xs font-black px-3 py-2 rounded-full {{ $statusColors[$item->status] ?? 'bg-slate-100 text-slate-500' }}">
                                            {{ strtoupper(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </div>
                                </div>

                            </div>

                        @empty
                            <div class="text-center py-16 text-slate-400 font-semibold">
                                Belum ada data permohonan.
                            </div>
                        @endforelse

                    </div>

                </div>

                            {{-- PENGADUAN TERBARU --}}
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">
                            Pengaduan Terbaru
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Aktivitas pengaduan terbaru
                        </p>
                    </div>

                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="text-indigo-600 text-sm font-black">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-5">

                    @forelse($recentPengaduan as $item)

                        @php
                            $priority = strtolower($item->prioritas ?? 'sedang');
                        @endphp

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center">
                                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-500"></i>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-3">
                                    <h4 class="font-black text-slate-900 truncate">
                                        {{ $item->nama }}
                                    </h4>

                                    <span class="
                                        text-xs font-black px-2 py-1 rounded-md uppercase
                                        @if($priority === 'tinggi')
                                            text-rose-600 bg-rose-50
                                        @elseif($priority === 'sedang')
                                            text-amber-600 bg-amber-50
                                        @else
                                            text-emerald-600 bg-emerald-50
                                        @endif
                                    ">
                                        {{ ucfirst($priority) }}
                                    </span>
                                </div>

                                <p class="text-sm text-slate-500 mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::limit($item->isi_pengaduan, 90) }}
                                </p>

                                <p class="text-xs text-slate-400 mt-3 font-semibold">
                                    {{ $item->created_at->diffForHumans() }}
                                </p>
                            </div>

                        </div>

                    @empty
                        <div class="text-center py-16 text-slate-400 font-semibold">
                            Belum ada pengaduan.
                        </div>
                    @endforelse

                </div>

            </div>

            {{-- TRACKING LOG --}}
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">

                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-900">
                            Tracking Logs
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Aktivitas sistem terbaru
                        </p>
                    </div>
                </div>

                <div class="space-y-5">

                    @forelse($recentTracking as $log)

                        <div class="flex items-start gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center">
                                <i data-lucide="activity" class="w-5 h-5 text-slate-500"></i>
                            </div>

                            <div class="flex-1">
                                <h4 class="font-black text-slate-900">
                                    {{ $log->keterangan ?? 'Aktivitas Sistem' }}
                                </h4>

                                <p class="text-sm text-slate-500 mt-2">
                                    {{ $log->admin->name ?? 'System' }}
                                </p>

                                <p class="text-xs text-slate-400 mt-3 font-semibold">
                                    {{ $log->created_at->diffForHumans() }}
                                </p>
                            </div>

                        </div>

                    @empty
                        <div class="text-center py-16 text-slate-400 font-semibold">
                            Belum ada aktivitas tracking.
                        </div>
                    @endforelse

                </div>

            </div>

        </div>
    </section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    const donutOptions = {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 14,
                    padding: 16,
                    font: {
                        weight: 'bold'
                    }
                }
            }
        }
    };

    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Permohonan',
                    data: @json($chartPermohonan),
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.08)',
                    tension: 0.45,
                    borderWidth: 4,
                    pointRadius: 0
                },
                {
                    label: 'Pengaduan',
                    data: @json($chartPengaduan),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239,68,68,0.08)',
                    tension: 0.45,
                    borderWidth: 4,
                    pointRadius: 0
                },
                {
                    label: 'Tracking',
                    data: @json($chartTracking),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    tension: 0.45,
                    borderWidth: 4,
                    pointRadius: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#eef2ff'
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('permohonanChart'), {
        type: 'doughnut',
        data: {
            labels: [
                'Baru',
                'Ditinjau',
                'Diproses',
                'Menunggu Dokumen',
                'Selesai',
                'Ditolak'
            ],
            datasets: [{
                data: [
                    {{ $permohonanStatusBreakdown['baru'] }},
                    {{ $permohonanStatusBreakdown['ditinjau'] }},
                    {{ $permohonanStatusBreakdown['diproses'] }},
                    {{ $permohonanStatusBreakdown['menunggu_dokumen'] }},
                    {{ $permohonanStatusBreakdown['selesai'] }},
                    {{ $permohonanStatusBreakdown['ditolak'] }}
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#8b5cf6',
                    '#2563eb',
                    '#06b6d4',
                    '#10b981',
                    '#ef4444'
                ],
                hoverOffset: 10,
                spacing: 5
            }]
        },
        options: donutOptions
    });

    new Chart(document.getElementById('pengaduanChart'), {
        type: 'doughnut',
        data: {
            labels: [
                'Baru',
                'Ditinjau',
                'Diproses',
                'Selesai',
                'Ditolak'
            ],
            datasets: [{
                data: [
                    {{ $pengaduanStatusBreakdown['baru'] }},
                    {{ $pengaduanStatusBreakdown['ditinjau'] }},
                    {{ $pengaduanStatusBreakdown['diproses'] }},
                    {{ $pengaduanStatusBreakdown['selesai'] }},
                    {{ $pengaduanStatusBreakdown['ditolak'] }}
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#8b5cf6',
                    '#2563eb',
                    '#10b981',
                    '#ef4444'
                ],
                hoverOffset: 10,
                spacing: 5
            }]
        },
        options: donutOptions
    });
});
</script>

@endsection