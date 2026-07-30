@extends('layouts.public')

@section('title', 'Portal Berita Desa — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HERO SECTION --}}
    <section class="mb-14 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 lg:p-16 shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">
                    <a href="{{ url('/') }}" class="hover:text-cyan-400 transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white">Portal Berita</span>
                </div>

                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Pusat Informasi</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    Warta <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Desa</span>
                </h1>

                <p class="text-lg lg:text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                    Ikuti informasi terbaru, pengumuman resmi, kegiatan masyarakat, dan perkembangan terkini langsung dari desa.
                </p>
            </div>
        </div>
    </section>

    @if($data->count())

        @php
            $featured = $data->first();
        @endphp

        {{-- FEATURED NEWS (BERITA UTAMA) --}}
        <section class="mb-16 reveal">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden group">
                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">

                    <div class="relative min-h-[400px] lg:min-h-full overflow-hidden bg-slate-100">
                        @if($featured->gambar)
                            <img
                                src="{{ asset('storage/' . $featured->gambar) }}"
                                alt="{{ $featured->judul }}"
                                class="w-full h-full object-cover absolute inset-0 transition-transform duration-1000 group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-7xl text-slate-300 absolute inset-0">
                                <i class="fa-regular fa-image"></i>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-navy-900/40 to-transparent lg:hidden"></div>
                    </div>

                    <div class="p-10 md:p-14 flex flex-col justify-center bg-white relative z-10">
                        <div class="inline-flex bg-blue-50 text-blue-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 w-fit border border-blue-100">
                            <i class="fa-solid fa-star mr-2"></i> Sorotan Utama
                        </div>

                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-black text-slate-900 tracking-tight leading-tight mb-6 group-hover:text-blue-600 transition-colors">
                            {{ $featured->judul }}
                        </h2>

                        <p class="text-slate-500 text-lg leading-relaxed mb-8 line-clamp-3">
                            {{ strip_tags($featured->isi) }}
                        </p>

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mt-auto">
                            <div class="flex items-center gap-3 text-sm text-slate-400 font-bold uppercase tracking-wider">
                                <i class="fa-regular fa-clock"></i>
                                {{ $featured->created_at->format('d M Y') }}
                            </div>

                            <a href="{{ route('public.berita.show', $featured->id) }}"
                                class="inline-flex items-center justify-center gap-2 bg-navy-900 hover:bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg hover:shadow-blue-500/30 hover:-translate-y-1">
                                Baca Selengkapnya <i class="fa-solid fa-arrow-right text-sm"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- GRID BERITA LAINNYA --}}
        <section class="reveal">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-display font-black text-slate-900">
                    Berita Lainnya
                </h3>
                <div class="h-px bg-slate-200 flex-grow ml-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($data->skip(1) as $item)

                <article class="group bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col h-full">

                    <a href="{{ route('public.berita.show', $item->id) }}" class="relative h-56 bg-slate-50 overflow-hidden block">
                        @if($item->gambar)
                            <img
                                src="{{ asset('storage/' . $item->gambar) }}"
                                alt="{{ $item->judul }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl text-slate-300">
                                <i class="fa-regular fa-newspaper"></i>
                            </div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur text-slate-800 text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                                Berita
                            </span>
                        </div>
                    </a>

                    <div class="p-8 flex flex-col flex-grow">
                        <div class="flex items-center gap-3 text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-4">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span>Admin</span>
                        </div>

                        <h3 class="text-xl font-display font-bold text-slate-900 leading-snug mb-4 group-hover:text-blue-600 transition-colors line-clamp-2">
                            <a href="{{ route('public.berita.show', $item->id) }}">{{ $item->judul }}</a>
                        </h3>

                        <p class="text-slate-500 text-sm leading-relaxed mb-6 flex-grow line-clamp-3">
                            {{ strip_tags($item->isi) }}
                        </p>

                        <a href="{{ route('public.berita.show', $item->id) }}"
                            class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 group-hover:text-blue-600 transition-colors mt-auto">
                            Baca Artikel <i class="fa-solid fa-arrow-right-long text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>

                </article>

                @endforeach
            </div>
        </section>

        {{-- PAGINATION MODERN --}}
        <section class="mt-16 reveal">
            <div class="bg-white border border-slate-100 rounded-[2rem] p-4 shadow-sm flex justify-center">
                {{ $data->links() }}
            </div>
        </section>

    @else

        {{-- EMPTY STATE MODERN --}}
        <section class="reveal">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm p-16 text-center min-h-[50vh] flex flex-col items-center justify-center">
                <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 flex items-center justify-center text-5xl mb-8 text-slate-300 shadow-inner">
                    <i class="fa-regular fa-folder-open"></i>
                </div>

                <h2 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-4">
                    Belum Ada Berita
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed max-w-xl mx-auto font-light">
                    Saat ini belum ada publikasi berita atau pengumuman dari pihak desa.
                    Informasi terbaru akan segera diperbarui di halaman ini.
                </p>
            </div>
        </section>

    @endif

</div>

@endsection