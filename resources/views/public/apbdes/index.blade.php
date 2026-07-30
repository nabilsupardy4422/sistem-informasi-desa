@extends('layouts.public')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto px-6 py-24">

    <!-- HERO -->
    <section class="mb-14">

        <div
            class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-slate-950 via-emerald-900 to-teal-900 p-10 md:p-16 shadow-2xl">

            <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 text-center max-w-5xl mx-auto text-white">

                <div
                    class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-xl border border-white/15 px-6 py-3 rounded-full text-sm font-black uppercase tracking-wide mb-8">
                    <span class="w-2.5 h-2.5 bg-emerald-300 rounded-full animate-pulse"></span>
                    Transparansi Keuangan Desa
                </div>

                <h1 class="text-4xl md:text-6xl xl:text-7xl font-black leading-[1.05] tracking-tight mb-8">
                    Transparansi
                    <span class="text-emerald-200">
                        APBDes
                    </span>
                </h1>

                <p class="text-lg md:text-xl text-slate-200 leading-relaxed max-w-4xl mx-auto">
                    Informasi APBDes ditampilkan secara terbuka sebagai bentuk transparansi,
                    akuntabilitas, dan keterbukaan informasi publik kepada masyarakat desa.
                </p>

            </div>

        </div>

    </section>

    <!-- FILTER -->
    <section class="mb-10">

        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm p-8">

            <div class="flex flex-col lg:flex-row lg:items-end gap-6">

                <div class="flex-1">

                    <label class="block text-sm font-black uppercase tracking-wide text-slate-600 mb-4">
                        Filter Tahun Anggaran
                    </label>

                    <select
                        id="filterTahun"
                        class="w-full border border-slate-300 rounded-2xl px-6 py-5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500">

                        <option value="">Semua Tahun</option>

                        @foreach($tahunList as $tahun)
                            <option value="{{ $tahun }}">
                                {{ $tahun }}
                            </option>
                        @endforeach

                    </select>

                </div>

                <div>

                    <button
                        onclick="loadData()"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-5 rounded-2xl font-black transition shadow-xl">
                        Terapkan Filter
                    </button>

                </div>

            </div>

        </div>

    </section>

    <!-- SUMMARY -->
    <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-6 mb-12">

        <div class="bg-white border border-emerald-200 rounded-[2rem] shadow-sm p-6">
            <div class="w-14 h-14 rounded-3xl bg-emerald-100 flex items-center justify-center text-2xl mb-5">
                💰
            </div>

            <p class="text-sm uppercase tracking-wide text-slate-400 font-bold mb-3">
                Pendapatan
            </p>

            <h3 id="sumPendapatan"
                class="text-xl md:text-2xl font-black text-emerald-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white border border-red-200 rounded-[2rem] shadow-sm p-6">
            <div class="w-14 h-14 rounded-3xl bg-red-100 flex items-center justify-center text-2xl mb-5">
                📉
            </div>

            <p class="text-sm uppercase tracking-wide text-slate-400 font-bold mb-3">
                Belanja
            </p>

            <h3 id="sumBelanja"
                class="text-xl md:text-2xl font-black text-red-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white border border-cyan-200 rounded-[2rem] shadow-sm p-6">
            <div class="w-14 h-14 rounded-3xl bg-cyan-100 flex items-center justify-center text-2xl mb-5">
                📥
            </div>

            <p class="text-sm uppercase tracking-wide text-slate-400 font-bold mb-3">
                Pembiayaan Masuk
            </p>

            <h3 id="sumMasuk"
                class="text-xl md:text-2xl font-black text-cyan-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white border border-amber-200 rounded-[2rem] shadow-sm p-6">
            <div class="w-14 h-14 rounded-3xl bg-amber-100 flex items-center justify-center text-2xl mb-5">
                📤
            </div>

            <p class="text-sm uppercase tracking-wide text-slate-400 font-bold mb-3">
                Pembiayaan Keluar
            </p>

            <h3 id="sumKeluar"
                class="text-xl md:text-2xl font-black text-amber-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white border border-blue-200 rounded-[2rem] shadow-sm p-6">
            <div class="w-14 h-14 rounded-3xl bg-blue-100 flex items-center justify-center text-2xl mb-5">
                📊
            </div>

            <p class="text-sm uppercase tracking-wide text-slate-400 font-bold mb-3">
                Saldo
            </p>

            <h3 id="sumSaldo"
                class="text-xl md:text-2xl font-black text-blue-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

    </section>

    <!-- CHART -->
    <section class="mb-12">

        <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">

            <div class="p-8 md:p-10 border-b border-slate-100">

                <h2 class="text-3xl font-black text-slate-800 mb-3">
                    Grafik APBDes
                </h2>

                <p class="text-slate-500 text-lg max-w-3xl">
                    Visualisasi APBDes berdasarkan pendapatan, belanja,
                    pembiayaan masuk, dan pembiayaan keluar.
                </p>

            </div>

            <div class="p-8 md:p-10">
                <div class="h-[350px] md:h-[450px]">
                    <canvas id="chart"></canvas>
                </div>
            </div>

        </div>

    </section>

        <!-- TABLE -->
        <section>

            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">

                <div class="px-8 md:px-10 py-8 border-b border-slate-100">

                    <h2 class="text-3xl font-black text-slate-800 mb-3">
                        Data APBDes
                    </h2>

                    <p class="text-slate-500 text-lg max-w-3xl">
                        Ringkasan data APBDes yang dapat dipantau masyarakat secara transparan.
                    </p>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[1200px]">

                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Tahun
                                </th>

                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Pendapatan
                                </th>

                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Belanja
                                </th>

                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Pembiayaan Masuk
                                </th>

                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Pembiayaan Keluar
                                </th>

                                <th class="text-left px-8 py-5 text-sm font-black uppercase tracking-wide text-slate-500">
                                    Saldo
                                </th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">

                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center text-slate-400">
                                    Memuat data APBDes...
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </div>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');

        /*
        |--------------------------------------------------------------------------
        | PREMIUM GRADIENTS
        |--------------------------------------------------------------------------
        */
        const gradientPendapatan = ctx.createLinearGradient(0, 0, 0, 500);
        gradientPendapatan.addColorStop(0, '#34d399');
        gradientPendapatan.addColorStop(1, '#047857');

        const gradientBelanja = ctx.createLinearGradient(0, 0, 0, 500);
        gradientBelanja.addColorStop(0, '#fb7185');
        gradientBelanja.addColorStop(1, '#be123c');

        const gradientMasuk = ctx.createLinearGradient(0, 0, 0, 500);
        gradientMasuk.addColorStop(0, '#67e8f9');
        gradientMasuk.addColorStop(1, '#0e7490');

        const gradientKeluar = ctx.createLinearGradient(0, 0, 0, 500);
        gradientKeluar.addColorStop(0, '#fde68a');
        gradientKeluar.addColorStop(1, '#d97706');

        /*
        |--------------------------------------------------------------------------
        | SHADOW PLUGIN
        |--------------------------------------------------------------------------
        */
        const shadowPlugin = {
            id: 'shadowPlugin',
            beforeDatasetsDraw(chart) {
                const { ctx } = chart;

                ctx.save();
                ctx.shadowColor = 'rgba(15, 23, 42, 0.15)';
                ctx.shadowBlur = 20;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 10;
            },
            afterDatasetsDraw(chart) {
                chart.ctx.restore();
            }
        };

        /*
        |--------------------------------------------------------------------------
        | BACKGROUND GLOW
        |--------------------------------------------------------------------------
        */
        const bgGlowPlugin = {
            id: 'bgGlowPlugin',
            beforeDraw(chart) {
                const { ctx, chartArea } = chart;

                if (!chartArea) return;

                const {
                    left,
                    top,
                    width,
                    height
                } = chartArea;

                ctx.save();

                const bg = ctx.createLinearGradient(0, top, 0, top + height);
                bg.addColorStop(0, 'rgba(248,250,252,0.9)');
                bg.addColorStop(1, 'rgba(255,255,255,0.1)');

                ctx.fillStyle = bg;
                ctx.fillRect(left, top, width, height);

                ctx.restore();
            }
        };

        /*
        |--------------------------------------------------------------------------
        | NUMBER FORMAT
        |--------------------------------------------------------------------------
        */
        function formatCompactCurrency(value) {
            if (value >= 1000000000) {
                return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
            }

            if (value >= 1000000) {
                return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
            }

            if (value >= 1000) {
                return 'Rp ' + (value / 1000).toFixed(1) + ' Rb';
            }

            return 'Rp ' + value;
        }

        /*
        |--------------------------------------------------------------------------
        | CHART INIT
        |--------------------------------------------------------------------------
        */
        const chart = new Chart(ctx, {
            type: 'bar',

            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Pendapatan',
                        data: [],
                        backgroundColor: gradientPendapatan,
                        borderRadius: 18,
                        borderSkipped: false,
                        barPercentage: 0.72,
                        categoryPercentage: 0.66
                    },
                    {
                        label: 'Belanja',
                        data: [],
                        backgroundColor: gradientBelanja,
                        borderRadius: 18,
                        borderSkipped: false,
                        barPercentage: 0.72,
                        categoryPercentage: 0.66
                    },
                    {
                        label: 'Pembiayaan Masuk',
                        data: [],
                        backgroundColor: gradientMasuk,
                        borderRadius: 18,
                        borderSkipped: false,
                        barPercentage: 0.72,
                        categoryPercentage: 0.66
                    },
                    {
                        label: 'Pembiayaan Keluar',
                        data: [],
                        backgroundColor: gradientKeluar,
                        borderRadius: 18,
                        borderSkipped: false,
                        barPercentage: 0.72,
                        categoryPercentage: 0.66
                    }
                ]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                animation: {
                    duration: 1800,
                    easing: 'easeOutExpo'
                },

                interaction: {
                    mode: 'index',
                    intersect: false
                },

                layout: {
                    padding: {
                        top: 15,
                        left: 10,
                        right: 10,
                        bottom: 10
                    }
                },

                plugins: {
                    legend: {
                        position: 'top',
                        align: 'center',

                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 28,
                            color: '#334155',

                            font: {
                                size: 13,
                                weight: '700'
                            }
                        }
                    },

                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.88)',
                        titleColor: '#ffffff',
                        bodyColor: '#e2e8f0',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        padding: 16,
                        cornerRadius: 16,
                        displayColors: true,
                        caretSize: 8,

                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' +
                                    Number(context.raw).toLocaleString('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    });
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            color: '#64748b',
                            padding: 12,

                            font: {
                                size: 13,
                                weight: '700'
                            }
                        }
                    },

                    y: {
                        beginAtZero: true,

                        grid: {
                            color: 'rgba(148, 163, 184, 0.12)',
                            drawBorder: false
                        },

                        ticks: {
                            color: '#64748b',
                            padding: 12,

                            font: {
                                size: 12,
                                weight: '600'
                            },

                            callback: function(value) {
                                return formatCompactCurrency(value);
                            }
                        }
                    }
                }
            },

            plugins: [shadowPlugin, bgGlowPlugin]
        });

        /*
        |--------------------------------------------------------------------------
        | HELPERS
        |--------------------------------------------------------------------------
        */
        function rupiah(n) {
            return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
        }

        /*
        |--------------------------------------------------------------------------
        | LOAD DATA
        |--------------------------------------------------------------------------
        */
        function loadData() {
            const tahun = document.getElementById('filterTahun').value;

            fetch(`/apbdes/data?tahun=${tahun}`)
                .then(res => res.json())
                .then(res => {

                    document.getElementById('sumPendapatan').innerText =
                        rupiah(res.summary.pendapatan);

                    document.getElementById('sumBelanja').innerText =
                        rupiah(res.summary.belanja);

                    document.getElementById('sumMasuk').innerText =
                        rupiah(res.summary.pembiayaan_masuk);

                    document.getElementById('sumKeluar').innerText =
                        rupiah(res.summary.pembiayaan_keluar);

                    document.getElementById('sumSaldo').innerText =
                        rupiah(res.summary.saldo);

                    chart.data.labels = res.chart.map(i => i.tahun);
                    chart.data.datasets[0].data = res.chart.map(i => i.pendapatan);
                    chart.data.datasets[1].data = res.chart.map(i => i.belanja);
                    chart.data.datasets[2].data = res.chart.map(i => i.pembiayaan_masuk);
                    chart.data.datasets[3].data = res.chart.map(i => i.pembiayaan_keluar);

                    chart.update();

                    let html = '';

                    if (!res.data.length) {
                        html = `
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center text-slate-500">
                                    Tidak ada data APBDes.
                                </td>
                            </tr>
                        `;
                    } else {
                        res.data.forEach(d => {
                            html += `
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                                    <td class="px-8 py-6">
                                        <span class="inline-flex px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-black">
                                            ${d.tahun}
                                        </span>
                                    </td>

                                    <td class="px-8 py-6 text-emerald-600 font-black">
                                        ${rupiah(d.pendapatan)}
                                    </td>

                                    <td class="px-8 py-6 text-red-600 font-black">
                                        ${rupiah(d.belanja)}
                                    </td>

                                    <td class="px-8 py-6 text-cyan-600 font-black">
                                        ${rupiah(d.pembiayaan_masuk)}
                                    </td>

                                    <td class="px-8 py-6 text-amber-600 font-black">
                                        ${rupiah(d.pembiayaan_keluar)}
                                    </td>

                                    <td class="px-8 py-6 text-blue-600 font-black">
                                        ${rupiah(d.saldo)}
                                    </td>
                                </tr>
                            `;
                        });
                    }

                    document.getElementById('tableBody').innerHTML = html;
                });
        }

        document.getElementById('filterTahun').addEventListener('change', loadData);

        loadData();
        </script>

    @endsection