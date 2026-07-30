@extends('layouts.public')

@section('title', $data->nama_umkm . ' — Direktori UMKM Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- NAVIGASI KEMBALI --}}
    <div class="mb-10 reveal">
        <a href="{{ route('public.umkm.index') }}"
           class="group inline-flex items-center gap-3 text-slate-500 hover:text-emerald-600 font-semibold transition-colors">
            <span class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-emerald-50 group-hover:border-emerald-200 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
            </span>
            Kembali ke Katalog UMKM
        </a>
    </div>

    {{-- HEADER ARTIKEL (NAMA & BADGE) --}}
    <header class="max-w-4xl mx-auto text-center mb-12 reveal">
        <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Etalase Usaha Lokal</span>
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black text-slate-900 tracking-tight leading-tight mb-8">
            {{ $data->nama_umkm }}
        </h1>

        <div class="flex flex-wrap items-center justify-center gap-4 text-sm font-medium">
            <div class="flex items-center gap-2 bg-white border border-slate-200 px-5 py-2.5 rounded-full shadow-sm">
                <i class="fa-solid fa-user-tie text-emerald-500"></i>
                <span class="text-slate-700">{{ $data->pemilik }}</span>
            </div>
            <div class="flex items-center gap-2 bg-white border border-slate-200 px-5 py-2.5 rounded-full shadow-sm">
                <i class="fa-solid fa-phone text-emerald-500"></i>
                <span class="text-slate-700">{{ $data->no_hp }}</span>
            </div>
        </div>
    </header>

    {{-- MAIN SHOWCASE (SPLIT LAYOUT) --}}
    <section class="mb-16 reveal">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

            {{-- KIRI: GAMBAR PRODUK/TOKO --}}
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="relative w-full h-[400px] md:h-[500px] lg:h-[600px] rounded-[3rem] overflow-hidden shadow-2xl bg-slate-100 group border border-slate-200/50">
                    @if($data->foto)
                        <img
                            src="{{ asset('storage/' . $data->foto) }}"
                            alt="{{ $data->nama_umkm }}"
                            class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                        <div style="display:none;" class="absolute inset-0 bg-[#0F172A] flex flex-col items-center justify-center overflow-hidden">
                            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/20 blur-[100px] rounded-full"></div>
                            <i class="fa-solid fa-store text-8xl text-slate-800 mb-6 relative z-10"></i>
                            <h2 class="text-2xl font-display font-bold text-slate-700 relative z-10 opacity-50">Tidak Ada Foto</h2>
                        </div>
                    @else
                        <div class="absolute inset-0 bg-[#0F172A] flex flex-col items-center justify-center overflow-hidden">
                            <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/20 blur-[100px] rounded-full"></div>
                            <i class="fa-solid fa-store text-8xl text-slate-800 mb-6 relative z-10"></i>
                            <h2 class="text-2xl font-display font-bold text-slate-700 relative z-10 opacity-50">Tidak Ada Foto</h2>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent pointer-events-none"></div>
                </div>
            </div>

            {{-- KANAN: KARTU INFORMASI & KONTAK --}}
            <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">

                {{-- Card Info Dasar --}}
                <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm p-8">
                    <h3 class="text-lg font-display font-black text-slate-800 tracking-tight mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-500"></i> Profil Bisnis
                    </h3>

                    <div class="space-y-6">
                        <div class="border-b border-slate-50 pb-5">
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Pengelola / Pemilik</p>
                            <p class="text-base font-bold text-slate-700">{{ $data->pemilik }}</p>
                        </div>

                        <div class="border-b border-slate-50 pb-5">
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-1">Kontak Usaha</p>
                            <p class="text-base font-bold text-slate-700 font-mono">{{ $data->no_hp }}</p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Lokasi Operasional</p>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-start gap-3">
                                <i class="fa-solid fa-location-dot text-rose-500 mt-1 shrink-0"></i>
                                <p class="text-sm text-slate-600 leading-relaxed">{{ $data->alamat }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Aksi Cepat --}}
                <div class="bg-emerald-600 rounded-[2.5rem] p-8 shadow-xl shadow-emerald-600/20 text-white relative overflow-hidden flex flex-col justify-center h-full">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>

                    <h3 class="text-xl font-display font-black mb-2 relative z-10">Tertarik?</h3>
                    <p class="text-emerald-100 text-sm mb-6 leading-relaxed relative z-10">
                        Hubungi pemilik usaha sekarang juga untuk memesan atau bertanya mengenai produk.
                    </p>

                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data->no_hp) }}"
                       target="_blank"
                       class="relative z-10 w-full inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-emerald-700 px-6 py-4 rounded-2xl font-black transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 group">
                        <i class="fa-brands fa-whatsapp text-xl text-emerald-500 group-hover:scale-110 transition-transform"></i> Chat via WhatsApp
                    </a>
                </div>

            </div>

        </div>
    </section>

    {{-- DESKRIPSI LENGKAP --}}
    <section class="mb-24 reveal">
        <div class="max-w-4xl mx-auto bg-white rounded-[3rem] p-8 md:p-12 lg:p-16 shadow-sm border border-slate-100 relative">
            <h2 class="text-3xl font-display font-black text-slate-900 tracking-tight mb-8 pb-6 border-b border-slate-100">
                Kisah & Deskripsi Usaha
            </h2>

            <article class="prose prose-lg md:prose-xl max-w-none text-slate-600 prose-p:leading-relaxed">
                {!! nl2br(e($data->deskripsi ?: 'Pemilik belum menambahkan deskripsi untuk usaha ini.')) !!}
            </article>
        </div>
    </section>

    {{-- UMKM TERKAIT / LAINNYA --}}
    <section class="pt-16 border-t border-slate-200 reveal">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl font-display font-black text-slate-900 mb-2">
                    Eksplorasi UMKM Lainnya
                </h2>
                <p class="text-slate-500">
                    Jelajahi potensi usaha lokal lain yang ada di desa kita.
                </p>
            </div>
            <a href="{{ route('public.umkm.index') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        @if($related->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($related as $item)
                    <article class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col h-full hover:-translate-y-2">

                        <a href="{{ route('public.umkm.show', $item->id) }}" class="relative h-56 overflow-hidden block bg-slate-50">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div style="display:none;" class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-store text-5xl mb-2"></i>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-store text-5xl mb-2"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur text-slate-800 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                                    <i class="fa-solid fa-tag text-emerald-500"></i> Lokal
                                </span>
                            </div>
                        </a>

                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-display font-black text-slate-900 leading-snug mb-5 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                <a href="{{ route('public.umkm.show', $item->id) }}">{{ $item->nama_umkm }}</a>
                            </h3>

                            <div class="space-y-3 mb-6 flex-grow">
                                <div class="flex items-center gap-3 text-sm text-slate-600">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                        <i class="fa-regular fa-user"></i>
                                    </div>
                                    <span class="truncate font-medium">{{ $item->pemilik }}</span>
                                </div>
                            </div>

                            <a href="{{ route('public.umkm.show', $item->id) }}" class="inline-flex items-center justify-center w-full bg-slate-50 hover:bg-emerald-600 text-slate-700 hover:text-white px-6 py-4 rounded-2xl font-bold transition-colors duration-300 mt-auto border border-slate-100 hover:border-emerald-600 gap-2">
                                Kunjungi Toko <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8 text-center md:hidden">
                 <a href="{{ route('public.umkm.index') }}" class="inline-flex items-center justify-center w-full bg-emerald-50 text-emerald-700 px-6 py-4 rounded-2xl font-bold">
                    Lihat Seluruh UMKM
                </a>
            </div>
        @else
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-16 text-center shadow-sm">
                <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-3xl mb-6 text-slate-300 shadow-inner">
                    <i class="fa-solid fa-store-slash"></i>
                </div>
                <h3 class="text-2xl font-display font-black text-slate-800 mb-2">
                    Tidak Ada UMKM Terkait
                </h3>
                <p class="text-slate-500">
                    Belum ada publikasi UMKM lain saat ini.
                </p>
            </div>
        @endif
    </section>

</div>

@endsection