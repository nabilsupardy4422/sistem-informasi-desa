@extends('layouts.public')

@section('title', 'Direktori UMKM Lokal — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HERO SECTION --}}
    <section class="mb-14 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 lg:p-16 shadow-2xl border border-slate-800">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-teal-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Katalog Ekonomi Kreatif</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    Dukung <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">UMKM Lokal</span>
                </h1>

                <p class="text-lg lg:text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                    Temukan usaha terbaik milik masyarakat desa, dukung pertumbuhan ekonomi lokal, dan kenali ragam produk unggulan dari para pelaku UMKM kami.
                </p>
            </div>
        </div>
    </section>

    @if($data->count())

        {{-- PREMIUM SUMMARY CARDS --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 reveal">
            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 border border-emerald-100 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-store"></i>
                </div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">Total UMKM Terdaftar</p>
                <h3 class="text-4xl font-display font-black text-slate-800">
                    {{ $summary['total'] }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">usaha</span>
                </h3>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 border border-blue-100 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">UMKM Dengan Foto</p>
                <h3 class="text-4xl font-display font-black text-slate-800">
                    {{ $summary['with_photo'] }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">terdokumentasi</span>
                </h3>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mb-6 border border-purple-100 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all">
                    <i class="fa-solid fa-users"></i>
                </div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">Total Pemilik</p>
                <h3 class="text-4xl font-display font-black text-slate-800">
                    {{ $summary['owners'] }} <span class="text-sm font-medium text-slate-400 lowercase tracking-normal">warga</span>
                </h3>
            </div>
        </section>

        {{-- PREMIUM SEARCH BAR --}}
        <section class="mb-14 reveal">
            <div class="bg-white border border-slate-200/60 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-6 lg:items-center lg:justify-between">
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                            <i class="fa-solid fa-magnifying-glass text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-display font-black text-slate-900 tracking-tight mb-1">
                                Cari Usaha
                            </h2>
                            <p class="text-slate-500 text-sm font-medium">
                                Filter berdasarkan nama usaha atau pemilik.
                            </p>
                        </div>
                    </div>
                    <div class="w-full lg:w-[450px] relative group">
                        <input
                            id="searchUmkm"
                            type="text"
                            placeholder="Ketik nama UMKM / pemilik..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-full px-8 py-4 text-slate-800 font-medium placeholder:font-light placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-inner"
                        >
                    </div>
                </div>
            </div>
        </section>

        @php
            $featured = $data->first();
        @endphp

        {{-- FEATURED UMKM (SOROTAN) --}}
        <section class="mb-16 reveal">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden group">
                <div class="grid grid-cols-1 lg:grid-cols-2 h-full">

                    {{-- GAMBAR UTAMA --}}
                    <div class="relative min-h-[400px] lg:min-h-full overflow-hidden bg-slate-100">
                        @if($featured->foto)
                            <img
                                src="{{ asset('storage/' . $featured->foto) }}"
                                alt="{{ $featured->nama_umkm }}"
                                class="w-full h-full object-cover absolute inset-0 transition-transform duration-1000 group-hover:scale-105"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div style="display:none;" class="w-full h-full flex flex-col items-center justify-center text-slate-300 absolute inset-0 bg-slate-50">
                                <i class="fa-solid fa-store text-7xl mb-4"></i>
                                <span class="font-display font-bold text-lg">Tidak Ada Foto</span>
                            </div>
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 absolute inset-0 bg-slate-50">
                                <i class="fa-solid fa-store text-7xl mb-4"></i>
                                <span class="font-display font-bold text-lg">Tidak Ada Foto</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent lg:hidden"></div>
                        <div class="absolute top-6 left-6 bg-emerald-600 text-white px-5 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-lg flex items-center gap-2">
                            <i class="fa-solid fa-star text-yellow-300"></i> Unggulan
                        </div>
                    </div>

                    {{-- KONTEN SOROTAN --}}
                    <div class="p-10 md:p-14 flex flex-col justify-center bg-white relative z-10">
                        <div class="inline-flex bg-emerald-50 text-emerald-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest mb-6 w-fit border border-emerald-100">
                            Spotlight UMKM
                        </div>

                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-black text-slate-900 tracking-tight leading-tight mb-6 group-hover:text-emerald-600 transition-colors">
                            {{ $featured->nama_umkm }}
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                            <div class="flex items-center gap-3 text-slate-600 bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">
                                <i class="fa-regular fa-user text-emerald-500"></i>
                                <span class="font-medium text-sm truncate">{{ $featured->pemilik }}</span>
                            </div>
                            <div class="flex items-center gap-3 text-slate-600 bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">
                                <i class="fa-solid fa-phone text-emerald-500"></i>
                                <span class="font-medium text-sm">{{ $featured->no_hp }}</span>
                            </div>
                            <div class="flex items-start gap-3 text-slate-600 bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100 sm:col-span-2">
                                <i class="fa-solid fa-location-dot text-emerald-500 mt-1"></i>
                                <span class="font-medium text-sm leading-relaxed">{{ $featured->alamat }}</span>
                            </div>
                        </div>

                        <p class="text-slate-500 text-lg leading-relaxed mb-10 line-clamp-3">
                            {{ strip_tags($featured->deskripsi) }}
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 mt-auto">
                            <a href="{{ route('public.umkm.show', $featured->id) }}"
                                class="flex-1 inline-flex items-center justify-center bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg hover:shadow-emerald-600/30 gap-2">
                                <i class="fa-solid fa-store"></i> Kunjungi Toko
                            </a>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $featured->no_hp) }}"
                                target="_blank"
                                class="inline-flex items-center justify-center bg-slate-900 hover:bg-slate-800 text-white px-8 py-4 rounded-2xl font-bold transition-all gap-2">
                                <i class="fa-brands fa-whatsapp text-lg text-emerald-400"></i> Hubungi
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- GRID UMKM LAINNYA --}}
        <section class="reveal">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-display font-black text-slate-900">
                    Katalog UMKM
                </h3>
                <div class="h-px bg-slate-200 flex-grow ml-6"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($data->skip(1) as $item)

                <article
                    class="umkm-card group bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 overflow-hidden flex flex-col h-full"
                    data-name="{{ strtolower($item->nama_umkm) }}"
                    data-owner="{{ strtolower($item->pemilik) }}">

                    <a href="{{ route('public.umkm.show', $item->id) }}" class="relative h-60 bg-slate-50 overflow-hidden block">
                        @if($item->foto)
                            <img
                                src="{{ asset('storage/' . $item->foto) }}"
                                alt="{{ $item->nama_umkm }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
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
                            <div class="flex items-center gap-3 text-sm text-slate-600">
                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 shrink-0">
                                    <i class="fa-solid fa-phone text-xs"></i>
                                </div>
                                <span class="font-medium">{{ $item->no_hp }}</span>
                            </div>
                        </div>

                        <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-2">
                            {{ strip_tags($item->deskripsi) }}
                        </p>

                        <a href="{{ route('public.umkm.show', $item->id) }}"
                            class="inline-flex items-center justify-center w-full bg-slate-50 hover:bg-emerald-600 text-slate-700 hover:text-white px-6 py-4 rounded-2xl font-bold transition-colors duration-300 mt-auto border border-slate-100 hover:border-emerald-600 gap-2">
                            Lihat Etalase <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </article>

                @endforeach
            </div>
        </section>

    @else

        {{-- EMPTY STATE MODERN --}}
        <section class="reveal">
            <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm p-16 text-center min-h-[50vh] flex flex-col items-center justify-center">
                <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 flex items-center justify-center text-5xl mb-8 text-slate-300 shadow-inner">
                    <i class="fa-solid fa-store-slash"></i>
                </div>

                <h2 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-4">
                    Belum Ada Data UMKM
                </h2>

                <p class="text-slate-500 text-lg leading-relaxed max-w-xl mx-auto font-light">
                    Saat ini direktori UMKM desa masih kosong. Direktori akan diperbarui ketika pelaku usaha telah didaftarkan ke dalam sistem.
                </p>
            </div>
        </section>

    @endif

</div>

@endsection

@push('scripts')
{{-- JAVASCRIPT PENCARIAN (LOGIC TETAP 100% SAMA, HANYA DIPINDAH KE PUSH) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchUmkm');
    const umkmCards = document.querySelectorAll('.umkm-card');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();

            umkmCards.forEach(card => {
                const name = card.dataset.name || '';
                const owner = card.dataset.owner || '';

                const match = name.includes(keyword) || owner.includes(keyword);

                card.style.display = match ? '' : 'none';
            });
        });
    }
});
</script>
@endpush