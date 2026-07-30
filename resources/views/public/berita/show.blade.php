@extends('layouts.public')

@section('title', $data->judul . ' — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- NAVIGASI KEMBALI --}}
    <div class="mb-10 reveal">
        <a href="{{ route('public.berita.index') }}"
           class="group inline-flex items-center gap-3 text-slate-500 hover:text-blue-600 font-semibold transition-colors">
            <span class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-blue-50 group-hover:border-blue-200 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
            </span>
            Kembali ke Indeks Berita
        </a>
    </div>

    {{-- HEADER ARTIKEL (Typography Focus) --}}
    <header class="max-w-4xl mx-auto text-center mb-12 reveal">
        <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 px-4 py-2 rounded-full mb-6">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            <span class="text-[10px] font-black text-blue-700 uppercase tracking-widest">Warta Desa</span>
        </div>

        <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black text-slate-900 tracking-tight leading-tight mb-8">
            {{ $data->judul }}
        </h1>

        <div class="flex items-center justify-center gap-6 text-sm text-slate-500 font-medium">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600">
                    <i class="fa-solid fa-user-tie text-xs"></i>
                </div>
                <span>Admin Desa</span>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-calendar-days text-slate-400"></i>
                <span>{{ $data->created_at->format('d M Y') }}</span>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
            <div class="flex items-center gap-2">
                <i class="fa-regular fa-clock text-slate-400"></i>
                <span>{{ $data->created_at->format('H:i') }} WIB</span>
            </div>
        </div>
    </header>

    {{-- CINEMATIC IMAGE --}}
    <section class="mb-16 reveal">
        <div class="relative w-full h-[400px] md:h-[500px] lg:h-[650px] rounded-[3rem] overflow-hidden shadow-2xl bg-slate-100 group border border-slate-200/50">
            @if($data->gambar)
                <img src="{{ asset('storage/' . $data->gambar) }}"
                     alt="{{ $data->judul }}"
                     class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
            @else
                <div class="absolute inset-0 bg-[#0F172A] flex flex-col items-center justify-center overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500/20 blur-[100px] rounded-full"></div>
                    <i class="fa-regular fa-newspaper text-8xl text-slate-800 mb-6 relative z-10"></i>
                    <h2 class="text-3xl font-display font-bold text-slate-700 relative z-10 opacity-50">{{ $data->judul }}</h2>
                </div>
            @endif
        </div>
    </section>

    {{-- KONTEN ARTIKEL --}}
    <section class="mb-24 reveal">
        <div class="max-w-3xl mx-auto bg-white rounded-[3rem] p-8 md:p-12 lg:p-16 shadow-sm border border-slate-100 relative">

            <div class="hidden lg:flex flex-col gap-4 absolute top-16 -left-20">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest -rotate-90 origin-left mb-6 ml-4">Bagikan</p>
                <button class="w-12 h-12 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all flex items-center justify-center shadow-sm">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                </button>
                <button class="w-12 h-12 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all flex items-center justify-center shadow-sm">
                    <i class="fa-brands fa-facebook-f"></i>
                </button>
                <button class="w-12 h-12 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition-all flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-link"></i>
                </button>
            </div>

            <article class="prose prose-lg md:prose-xl max-w-none text-slate-600 prose-headings:font-display prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-3xl prose-img:shadow-lg prose-p:leading-relaxed">
                {!! nl2br(e($data->isi)) !!}
            </article>

            <div class="mt-12 pt-8 border-t border-slate-100 flex flex-wrap gap-2">
                <span class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wide">Info Desa</span>
                <span class="px-4 py-2 rounded-xl bg-slate-50 border border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wide">Pengumuman</span>
            </div>
        </div>
    </section>

    {{-- BERITA TERKAIT --}}
    <section class="pt-16 border-t border-slate-200 reveal">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl font-display font-black text-slate-900 mb-2">
                    Baca Juga
                </h2>
                <p class="text-slate-500">
                    Informasi lain yang mungkin relevan untuk Anda.
                </p>
            </div>
        </div>

        @if($related->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($related as $item)
                    <article class="group bg-white rounded-[2.5rem] overflow-hidden border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full hover:-translate-y-2">
                        <a href="{{ route('public.berita.show', $item->id) }}" class="relative h-56 overflow-hidden block bg-slate-50">
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-image text-5xl"></i>
                                </div>
                            @endif
                        </a>
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="flex items-center gap-3 text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                            <h3 class="text-xl font-display font-bold text-slate-900 mb-4 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                                <a href="{{ route('public.berita.show', $item->id) }}">{{ $item->judul }}</a>
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-2">
                                {{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 100) }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-16 text-center shadow-sm">
                <div class="w-20 h-20 mx-auto rounded-full bg-slate-50 flex items-center justify-center text-3xl mb-6 text-slate-300 shadow-inner">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <h3 class="text-2xl font-display font-black text-slate-800 mb-2">
                    Tidak Ada Berita Terkait
                </h3>
                <p class="text-slate-500">
                    Belum ada publikasi lain saat ini.
                </p>
            </div>
        @endif
    </section>

</div>

@endsection