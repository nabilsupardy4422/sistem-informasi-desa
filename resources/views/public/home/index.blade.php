@extends('layouts.public')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    :root {
        --navy-dark: #0F172A;
        --navy-light: #1E293B;
        --cyan-glow: #22D3EE;
    }

    body {
        font-family: 'Inter', sans-serif;
        scroll-behavior: smooth;
    }

    .font-display {
        font-family: 'Poppins', sans-serif;
    }

    /* Glassmorphism Utility */
    .glass {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Floating Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }

    /* Gradient Background */
    .mesh-gradient {
        background: radial-gradient(at 0% 0%, rgba(30, 64, 175, 0.15) 0, transparent 50%),
                    radial-gradient(at 50% 0%, rgba(34, 211, 238, 0.1) 0, transparent 50%),
                    radial-gradient(at 100% 0%, rgba(30, 58, 138, 0.15) 0, transparent 50%);
    }
</style>

<div class="bg-[#F8FAFC] min-h-screen overflow-hidden mesh-gradient">

    {{-- HERO SECTION PREMIUM --}}
    <section class="relative min-h-[95vh] flex items-center pt-24 pb-16 overflow-hidden bg-[#0F172A]">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -mr-64 -mt-64 animate-pulse pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] -ml-32 -mb-32 pointer-events-none"></div>

        @if($slider->count())
            <div id="heroSlider" class="absolute inset-0 z-0">
                @foreach($slider as $index => $item)
                    <div class="slide absolute inset-0 transition-all duration-1000 transform {{ $index === 0 ? 'opacity-100 scale-100' : 'opacity-0 scale-105' }}">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover opacity-40">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-900 to-blue-900"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0F172A] via-[#0F172A]/50 to-transparent"></div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="container mx-auto px-6 relative z-10 reveal">
            <div class="max-w-5xl mx-auto text-center">
                <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full mb-8 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <span class="text-xs font-bold text-white uppercase tracking-[0.2em] font-display">Digital Village Ecosystem</span>
                </div>

                @php $firstSlider = $slider->first(); @endphp
                <h1 id="sliderTitle" class="text-5xl md:text-7xl lg:text-8xl font-display font-extrabold text-white leading-tight mb-8 tracking-tighter transition-opacity duration-300">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-white to-white/50">
                        {{ $firstSlider->judul ?? 'Transformasi Digital Desa' }}
                    </span>
                </h1>

                <p id="sliderDesc" class="text-lg md:text-xl text-slate-300 mb-12 max-w-3xl mx-auto leading-relaxed font-light transition-opacity duration-300">
                    {{ \Illuminate\Support\Str::limit(strip_tags($firstSlider->isi ?? 'Memudahkan urusan administrasi, transparansi, dan layanan publik dalam satu genggaman digital.'), 180) }}
                </p>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
            <div class="w-6 h-10 border-2 border-white/20 rounded-full flex justify-center p-1">
                <div class="w-1 h-2 bg-cyan-400 rounded-full animate-bounce"></div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION - FLOATING GLASS CARDS --}}
    <section class="relative -mt-24 z-20 pb-20 reveal">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @foreach([
                    ['label' => 'Total Penduduk', 'value' => $stats['penduduk'], 'icon' => 'fa-users', 'color' => 'text-blue-500'],
                    ['label' => 'UMKM Aktif', 'value' => $stats['umkm'], 'icon' => 'fa-store', 'color' => 'text-emerald-500'],
                    ['label' => 'Jenis Layanan', 'value' => $stats['layanan'], 'icon' => 'fa-file-invoice', 'color' => 'text-cyan-500'],
                ] as $stat)
                <div class="bg-white/70 backdrop-blur-xl border border-white/50 p-8 rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.04)] group hover:-translate-y-2 transition-all duration-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-xl {{ $stat['color'] }} group-hover:scale-110 transition-transform">
                            <i class="fa-solid {{ $stat['icon'] }}"></i>
                        </div>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Live Data</span>
                    </div>
                    <h3 class="text-4xl font-display font-black text-slate-900 mb-1">
                        {{ is_numeric($stat['value']) ? number_format($stat['value'], 0, ',', '.') : $stat['value'] }}
                    </h3>
                    <p class="text-sm font-medium text-slate-500 uppercase tracking-wide">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- QUICK ACCESS --}}
    <section class="py-20 overflow-hidden reveal">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-end justify-between mb-16 gap-6">
                <div class="max-w-2xl">
                    <h2 class="text-4xl md:text-5xl font-display font-black text-slate-900 tracking-tight mb-6">
                        Smart <span class="text-blue-600">Gateways</span>
                    </h2>
                    <p class="text-slate-500 text-lg leading-relaxed">Pintu masuk cepat ke seluruh ekosistem layanan digital desa yang dirancang untuk efisiensi maksimal warga.</p>
                </div>
                <div class="flex gap-2">
                    <div class="w-12 h-1 bg-blue-600 rounded-full"></div>
                    <div class="w-4 h-1 bg-blue-200 rounded-full"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
                @php
                    $menus = [
                        ['Layanan', 'public.layanan.index', '📄', 'bg-blue-50 text-blue-600'],
                        ['Tracking', 'public.tracking.index', '🔍', 'bg-cyan-50 text-cyan-600'],
                        ['Pengaduan', 'public.pengaduan.index', '⚠️', 'bg-red-50 text-red-600'],
                        ['Berita Desa', 'public.berita.index', '📰', 'bg-purple-50 text-purple-600'],
                        ['UMKM Lokal', 'public.umkm.index', '🏪', 'bg-emerald-50 text-emerald-600'],
                    ];
                @endphp
                @foreach($menus as $menu)
                <a href="{{ route($menu[1]) }}" class="group bg-white border border-slate-100 p-8 rounded-[2rem] text-center transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10 hover:border-blue-200 hover:-translate-y-2">
                    <div class="text-5xl mb-6 group-hover:scale-125 transition-transform duration-500 grayscale group-hover:grayscale-0">
                        {{ $menu[2] }}
                    </div>
                    <p class="font-display font-bold text-slate-800">{{ $menu[0] }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FEATURED NEWS SECTION --}}
    @if($featured)
    <section class="py-24 relative reveal">
        <div class="container mx-auto px-6">
            <div class="bg-[#0F172A] rounded-[3rem] overflow-hidden relative shadow-2xl border border-slate-800">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/10 blur-[100px] pointer-events-none"></div>

                <div class="grid grid-cols-1 lg:grid-cols-2 items-center">
                    <div class="p-12 lg:p-20 relative z-10">
                        <div class="inline-block px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-emerald-400 text-xs font-black uppercase tracking-widest mb-8">
                            Spotlight News
                        </div>
                        <h2 class="text-4xl md:text-5xl font-display font-bold text-white leading-tight mb-8">
                            {{ $featured->judul }}
                        </h2>
                        <p class="text-slate-400 text-lg mb-10 leading-relaxed font-light italic">
                            "{{ \Illuminate\Support\Str::limit(strip_tags($featured->isi), 240) }}"
                        </p>
                        <a href="{{ route('public.berita.show', $featured->id) }}"
                           class="inline-flex items-center gap-3 text-white font-bold group">
                            Baca Artikel Lengkap
                            <span class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                                <i class="fa-solid fa-arrow-right text-sm"></i>
                            </span>
                        </a>
                    </div>
                    <div class="relative h-[400px] lg:h-full group overflow-hidden">
                        @if($featured->gambar)
                            <img src="{{ asset('storage/' . $featured->gambar) }}" class="w-full h-full object-cover transition duration-1000 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0F172A] via-transparent to-transparent hidden lg:block"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- BERITA TERBARU GRID --}}
    <section class="py-24 reveal">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div>
                    <h2 class="text-4xl md:text-5xl font-display font-black text-slate-900 mb-4">Warta Desa</h2>
                    <p class="text-slate-500 text-lg">Informasi aktual dan terpercaya seputar kegiatan warga.</p>
                </div>
                <a href="{{ route('public.berita.index') }}" class="group flex items-center gap-3 bg-white border border-slate-200 px-8 py-4 rounded-2xl font-bold hover:bg-slate-900 hover:text-white transition-all duration-300">
                    Lihat Berita
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($berita as $item)
                <article class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full hover:-translate-y-2">
                    <div class="relative h-64 overflow-hidden">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                <i class="fa-solid fa-image text-5xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/90 backdrop-blur px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">News</span>
                        </div>
                    </div>
                    <div class="p-10 flex flex-col flex-grow">
                        <div class="flex items-center gap-4 text-slate-400 text-[11px] font-bold mb-4">
                            <span><i class="fa-regular fa-calendar-days mr-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span><i class="fa-regular fa-clock mr-1"></i> 5 Min Read</span>
                        </div>
                        <h3 class="text-2xl font-display font-bold text-slate-900 mb-4 leading-tight group-hover:text-blue-600 transition-colors">
                            {{ $item->judul }}
                        </h3>
                        <p class="text-slate-500 leading-relaxed mb-8 flex-grow">
                            {{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 120) }}
                        </p>
                        <a href="{{ route('public.berita.show', $item->id) }}" class="text-navy-dark font-black flex items-center gap-2 group-hover:gap-4 transition-all mt-auto">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right-long text-blue-500"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ALUR LAYANAN & FAQ SECTION --}}
    <section class="py-24 relative overflow-hidden reveal bg-slate-50/50">
        <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-block px-4 py-2 bg-blue-500/10 border border-blue-500/20 rounded-full text-blue-600 text-xs font-black uppercase tracking-widest mb-6">
                    Pusat Bantuan
                </div>
                <h2 class="text-4xl md:text-5xl font-display font-black text-slate-900 mb-6 tracking-tight">
                    Panduan <span class="text-blue-600">Layanan Publik</span>
                </h2>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Pahami langkah-langkah mudah untuk mengajukan surat keterangan atau melaporkan kendala di lingkungan desa Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">

                {{-- KIRI: ALUR KERJA (STEPPER) --}}
                <div>
                    <h3 class="text-2xl font-display font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fa-solid fa-route text-cyan-500"></i> Alur Pengajuan & Pengaduan
                    </h3>

                    <div class="relative border-l-2 border-slate-200 ml-4 space-y-10 pb-4">
                        <div class="relative pl-10">
                            <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full bg-blue-600 border-4 border-slate-50 flex items-center justify-center text-white text-xs font-bold shadow-lg">1</div>
                            <h4 class="text-xl font-bold text-slate-800 mb-2">Pilih Layanan & Isi Formulir</h4>
                            <p class="text-slate-500 leading-relaxed text-sm">Masuk ke menu <span class="font-semibold text-navy-dark">E-Layanan</span> atau <span class="font-semibold text-navy-dark">Pengaduan</span>. Lengkapi data diri dan unggah dokumen persyaratan yang diminta (seperti KTP/KK) dengan format gambar atau PDF.</p>
                        </div>

                        <div class="relative pl-10">
                            <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full bg-cyan-500 border-4 border-slate-50 flex items-center justify-center text-white text-xs font-bold shadow-lg">2</div>
                            <h4 class="text-xl font-bold text-slate-800 mb-2">Verifikasi Oleh Perangkat Desa</h4>
                            <p class="text-slate-500 leading-relaxed text-sm">Sistem akan meneruskan laporan/pengajuan Anda ke admin desa. Anda dapat melacak status dokumen Anda secara real-time melalui menu <span class="font-semibold text-blue-600">Tracking (Lacak Permohonan)</span>.</p>
                        </div>

                        <div class="relative pl-10">
                            <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full bg-emerald-500 border-4 border-slate-50 flex items-center justify-center text-white text-xs font-bold shadow-lg">3</div>
                            <h4 class="text-xl font-bold text-slate-800 mb-2">Selesai & Tindak Lanjut</h4>
                            <p class="text-slate-500 leading-relaxed text-sm">Untuk surat menyurat, Anda akan menerima notifikasi jika surat siap diambil di balai desa. Untuk pengaduan, status akan diubah menjadi "Selesai" setelah ditindaklanjuti.</p>
                        </div>
                    </div>
                </div>

                {{-- KANAN: FAQ ACCORDION --}}
                <div>
                    <h3 class="text-2xl font-display font-bold text-slate-900 mb-8 flex items-center gap-3">
                        <i class="fa-regular fa-circle-question text-blue-500"></i> Pertanyaan Umum (FAQ)
                    </h3>

                    <div class="space-y-4">
                        <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm open:shadow-md transition-all duration-300">
                            <summary class="flex items-center justify-between p-6 cursor-pointer font-semibold text-slate-800">
                                Apakah pembuatan surat dipungut biaya?
                                <span class="transition-transform duration-300 group-open:-rotate-180 text-blue-500">
                                    <i class="fa-solid fa-chevron-down text-sm"></i>
                                </span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-100 pt-4 mt-2">
                                Tidak. Seluruh layanan administrasi persuratan digital di Sistem Informasi Desa 100% <strong>GRATIS</strong> tanpa dipungut biaya sepeser pun.
                            </div>
                        </details>

                        <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm open:shadow-md transition-all duration-300">
                            <summary class="flex items-center justify-between p-6 cursor-pointer font-semibold text-slate-800">
                                Berapa lama proses verifikasi pengajuan?
                                <span class="transition-transform duration-300 group-open:-rotate-180 text-blue-500">
                                    <i class="fa-solid fa-chevron-down text-sm"></i>
                                </span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-100 pt-4 mt-2">
                                Normalnya, perangkat desa akan memverifikasi dokumen Anda dalam waktu <strong>1x24 Jam Kerja</strong>. Pastikan dokumen (KTP/KK) yang Anda unggah terlihat jelas agar proses verifikasi lebih cepat.
                            </div>
                        </details>

                        <details class="group bg-white border border-slate-200 rounded-2xl shadow-sm open:shadow-md transition-all duration-300">
                            <summary class="flex items-center justify-between p-6 cursor-pointer font-semibold text-slate-800">
                                Apakah identitas saya aman saat melapor pengaduan?
                                <span class="transition-transform duration-300 group-open:-rotate-180 text-blue-500">
                                    <i class="fa-solid fa-chevron-down text-sm"></i>
                                </span>
                            </summary>
                            <div class="px-6 pb-6 text-slate-500 text-sm leading-relaxed border-t border-slate-100 pt-4 mt-2">
                                Tentu saja. Anda memiliki opsi untuk mengirimkan pengaduan secara anonim (tanpa identitas) untuk isu-isu yang sensitif. Keamanan dan kerahasiaan data pribadi Anda adalah prioritas kami.
                            </div>
                        </details>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- UMKM SECTION --}}
    <section class="py-24 bg-white relative overflow-hidden reveal">
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-emerald-50 rounded-full blur-[80px] pointer-events-none"></div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-4xl md:text-5xl font-display font-black text-slate-900 mb-6 tracking-tight">Etalase <span class="text-emerald-600">Ekonomi Kreatif</span></h2>
                <p class="text-slate-500 text-lg leading-relaxed">Mendukung pertumbuhan usaha lokal untuk kemandirian ekonomi desa yang berkelanjutan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($umkmPreview as $item)
                <div class="bg-slate-50 rounded-[3rem] p-4 group transition-all duration-500 hover:bg-white hover:shadow-2xl">
                    <div class="relative h-72 rounded-[2.5rem] overflow-hidden mb-8">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-8">
                            <a href="{{ route('public.umkm.show', $item->id) }}" class="w-full bg-white text-navy-dark py-4 rounded-2xl text-center font-bold">Kunjungi Toko</a>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <h3 class="text-2xl font-display font-bold text-slate-900 mb-2">{{ $item->nama_umkm }}</h3>
                        <p class="text-slate-500 font-light mb-4">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</p>
                        <div class="flex items-center gap-2">
                            <span class="w-8 h-[1px] bg-emerald-300"></span>
                            <span class="text-[10px] font-black uppercase text-emerald-600 tracking-widest">Produk Unggulan</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TRANSPARANSI APBDES --}}
    <section class="py-24 reveal">
        <div class="container mx-auto px-6">
            <div class="bg-navy-dark rounded-[4rem] p-12 lg:p-20 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#22D3EE 1px, transparent 1px); background-size: 30px 30px;"></div>

                <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
                    <div class="max-w-xl text-center lg:text-left">
                        <h2 class="text-4xl md:text-5xl font-display font-black text-slate-900 mb-6 tracking-tight">Open <span class="text-cyan-400 italic font-light font-sans">Governance</span></h2>
                        <p class="text-slate-400 text-lg font-light leading-relaxed mb-8">
                            Wujud transparansi tata kelola keuangan desa. Setiap rupiah yang dikelola diperuntukkan sepenuhnya demi pembangunan dan kesejahteraan warga.
                        </p>
                        <div class="flex items-center justify-center lg:justify-start gap-4">
                            <div class="px-6 py-3 rounded-2xl bg-white/5 border border-white/10 text-white text-sm font-bold">Tahun Anggaran 2024</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full lg:w-auto">
                        @foreach([
                            ['Pendapatan', $apbdesPreview['pendapatan'], 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                            ['Belanja', $apbdesPreview['belanja'], 'bg-red-500/10 text-red-400 border-red-500/20'],
                            ['Pembiayaan', $apbdesPreview['pembiayaan'], 'bg-blue-500/10 text-blue-400 border-blue-500/20']
                        ] as $budget)
                        <div class="p-8 rounded-[2.5rem] {{ $budget[2] }} border text-center backdrop-blur-md transition-transform hover:scale-105">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 opacity-70">{{ $budget[0] }}</p>
                            <h4 class="text-2xl font-display font-black leading-none">
                                <span class="text-xs mr-1 opacity-60">Rp</span>{{ number_format($budget[1], 0, ',', '.') }}
                            </h4>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.slide');
    if (!slides.length) return;

    let current = 0;
    // Pengecekan safety jika $slider kosong
    const titles = @json($slider->pluck('judul') ?? []);
    const contents = @json($slider->pluck('isi') ?? []);

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('scale-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
            slide.classList.toggle('scale-105', i !== index);
        });

        const titleEl = document.getElementById('sliderTitle');
        const descEl = document.getElementById('sliderDesc');

        if (titleEl && titles[index]) {
            titleEl.style.opacity = 0;
            setTimeout(() => {
                titleEl.querySelector('span').innerText = titles[index];
                titleEl.style.opacity = 1;
            }, 300);
        }

        if (descEl && contents[index]) {
            descEl.style.opacity = 0;
            setTimeout(() => {
                // Cara paling aman membersihkan HTML dari teks di Javascript
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = contents[index];
                let cleanText = tempDiv.textContent || tempDiv.innerText || '';

                descEl.innerText = cleanText.substring(0, 180) + '...';
                descEl.style.opacity = 1;
            }, 300);
        }

        current = index;
    }

    // Auto Slide
    setInterval(() => {
        let next = (current + 1) % slides.length;
        showSlide(next);
    }, 8000);
});
</script>
@endpush