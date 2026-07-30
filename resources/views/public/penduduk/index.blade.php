@extends('layouts.public')

@section('title', 'Statistik Demografi Desa — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">
    {{-- HERO SECTION --}}
    <section class="mb-14 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 lg:p-16 shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Open Data Pemerintahan</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    Demografi <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Desa</span>
                </h1>

                <p class="text-lg lg:text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                    Informasi statistik jumlah penduduk, komposisi gender, dan riwayat perkembangan populasi desa yang disajikan secara transparan dan akurat.
                </p>
            </div>
        </div>
    </section>

    @if($data->count())

        {{-- SUMMARY CARDS --}}
        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-14 reveal">

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                    <i class="fa-regular fa-calendar-days text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-4 border border-indigo-100">
                        <i class="fa-regular fa-calendar-check"></i>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">
                        Data Tahun Terbaru
                    </p>
                    <h3 class="text-4xl font-display font-black text-indigo-600">
                        {{ $latest->tahun }}
                    </h3>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                    <i class="fa-solid fa-users text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4 border border-emerald-100">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">
                        Total Penduduk
                    </p>
                    <h3 class="text-4xl font-display font-black text-emerald-600">
                        {{ number_format($latest->jumlah_penduduk, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">jiwa</span>
                    </h3>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                    <i class="fa-solid fa-mars text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl mb-4 border border-sky-100">
                        <i class="fa-solid fa-person"></i>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">
                        Laki-laki
                    </p>
                    <h3 class="text-4xl font-display font-black text-sky-600">
                        {{ number_format($latest->jumlah_laki, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">jiwa</span>
                    </h3>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-6 -bottom-6 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500 pointer-events-none">
                    <i class="fa-solid fa-venus text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mb-4 border border-rose-100">
                        <i class="fa-solid fa-person-dress"></i>
                    </div>
                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">
                        Perempuan
                    </p>
                    <h3 class="text-4xl font-display font-black text-rose-600">
                        {{ number_format($latest->jumlah_perempuan, 0, ',', '.') }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">jiwa</span>
                    </h3>
                </div>
            </div>

        </section>

        {{-- CHARTS SECTION --}}
        <section class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-16 reveal">

            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm p-8 md:p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl border border-blue-100">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-black text-slate-800 tracking-tight">Tren Penduduk</h2>
                        <p class="text-slate-500 text-sm">Grafik pertumbuhan dari tahun ke tahun.</p>
                    </div>
                </div>

                <div class="relative w-full" style="height: 350px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm p-8 md:p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl border border-purple-100">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-black text-slate-800 tracking-tight">Komposisi Gender</h2>
                        <p class="text-slate-500 text-sm">Distribusi rasio laki-laki & perempuan tahun {{ $latest->tahun }}.</p>
                    </div>
                </div>

                <div class="relative w-full flex items-center justify-center" style="height: 350px;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>

        </section>

        {{-- DATA TABLE SECTION --}}
        <section class="reveal mb-20">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm overflow-hidden">

                <div class="p-8 md:p-10 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center text-xl border border-slate-200">
                            <i class="fa-solid fa-table-list"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-display font-black text-slate-800 tracking-tight">Riwayat Historis</h2>
                            <p class="text-slate-500 text-sm">Tabel data kependudukan secara mendetail.</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto p-4">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b-2 border-slate-100">Tahun</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b-2 border-slate-100">Total Penduduk</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b-2 border-slate-100">Laki-laki</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b-2 border-slate-100">Perempuan</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-slate-400 border-b-2 border-slate-100">Kepala Keluarga (KK)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($data as $item)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-slate-100 text-slate-700 font-display font-bold text-sm">
                                        {{ $item->tahun }}
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="font-black text-emerald-600 text-lg">{{ number_format($item->jumlah_penduduk, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap font-medium text-slate-600">
                                    {{ number_format($item->jumlah_laki, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap font-medium text-slate-600">
                                    {{ number_format($item->jumlah_perempuan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap font-medium text-slate-600">
                                    {{ number_format($item->jumlah_kk, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </section>

    @else

        {{-- EMPTY STATE MODERN --}}
        <section class="reveal">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm p-16 text-center min-h-[50vh] flex flex-col items-center justify-center">
                <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 flex items-center justify-center text-5xl mb-8 text-slate-300 shadow-inner">
                    <i class="fa-solid fa-users-slash"></i>
                </div>

                <h2 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-4">
                    Data Demografi Kosong
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed max-w-xl mx-auto font-light">
                    Statistik kependudukan desa belum diinput oleh Administrator. Grafik dan data populasi akan muncul di halaman ini setelah diperbarui.
                </p>
            </div>
        </section>

    @endif

</div>

@endsection

@push('scripts')
@if($data->count())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartLabels = @json($chartLabels);
    const chartPenduduk = @json($chartPenduduk);

    const latestLaki = {{ $latest->jumlah_laki }};
    const latestPerempuan = {{ $latest->jumlah_perempuan }};

    const trendCtx = document.getElementById('trendChart');
    const genderCtx = document.getElementById('genderChart');

    // Setup global font (menggunakan Inter agar serasi dengan body CSS)
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#94a3b8'; // text-slate-400

    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Total Populasi',
                        data: chartPenduduk,
                        borderColor: '#2563eb', // blue-600
                        backgroundColor: 'rgba(37, 99, 235, 0.1)', // blue-600 with opacity
                        fill: true,
                        borderWidth: 3,
                        tension: 0.4, // Smooth curve
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#2563eb',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: false // Disembunyikan agar lebih clean
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleFont: { size: 13, family: "'Poppins', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(241, 245, 249, 1)', // slate-100
                            drawBorder: false
                        },
                        ticks: {
                            padding: 10,
                            font: { size: 12 }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            padding: 10,
                            font: { size: 12, weight: '600' }
                        }
                    }
                }
            }
        });
    }

    if (genderCtx) {
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [
                    {
                        data: [latestLaki, latestPerempuan],
                        backgroundColor: [
                            '#0ea5e9', // sky-500
                            '#f43f5e'  // rose-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 8
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Modern thin doughnut
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 24,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: {
                                size: 13,
                                family: "'Inter', sans-serif",
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F172A',
                        titleFont: { size: 12 },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12,
                        cornerRadius: 12
                    }
                }
            }
        });
    }
});
</script>
@endif
@endpush