@extends('layouts.public')

@section('title', 'Layanan Administrasi — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HERO SECTION --}}
    <section class="mb-12 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 lg:p-16 shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-slate-400 mb-8">
                    <a href="{{ url('/') }}" class="hover:text-cyan-400 transition-colors">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-white">E-Layanan</span>
                </div>

                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Pusat Administrasi Publik</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    E-Layanan <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">Desa</span>
                </h1>

                <p class="text-lg lg:text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                    Ajukan berbagai keperluan surat menyurat dan layanan administrasi desa secara online. Lebih cepat, transparan, dan mudah dipantau.
                </p>
            </div>
        </div>
    </section>

    {{-- SEARCH SECTION (PREMIUM FILTER BAR) --}}
    <section class="mb-10 reveal">
        <div class="bg-white border border-slate-200/60 rounded-[2.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-6 lg:p-8">
            <div class="flex flex-col lg:flex-row gap-8 lg:items-center lg:justify-between">

                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                        <i class="fa-regular fa-folder-open text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-black text-slate-900 tracking-tight mb-1">
                            Katalog Layanan
                        </h2>
                        <p class="text-slate-500 text-sm font-medium">
                            Temukan layanan yang Anda butuhkan di bawah ini.
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-[450px] relative group">
                    <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input
                        id="searchInput"
                        type="text"
                        placeholder="Ketik nama layanan atau kata kunci..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-full pl-14 pr-6 py-4 text-slate-800 font-medium placeholder:font-light placeholder:text-slate-400 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-inner"
                    >
                </div>

            </div>
        </div>
    </section>

    {{-- GRID SECTION --}}
    <section class="mb-20">

        @if($layanans->count())

        <div id="layananGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 reveal">
            @foreach($layanans as $layanan)

            <div
                class="layanan-card group bg-white border border-slate-100 rounded-[2.5rem] shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full relative overflow-hidden"
                data-name="{{ strtolower($layanan->nama_layanan) }}"
                data-desc="{{ strtolower($layanan->deskripsi ?? '') }}">

                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 blur-[50px] rounded-full group-hover:bg-blue-500/10 transition-colors pointer-events-none"></div>

                {{-- CARD HEADER --}}
                <div class="px-8 pt-8 pb-6 border-b border-slate-50 flex items-start justify-between relative z-10">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100/50 flex items-center justify-center text-blue-600 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-sm">
                        <i class="fa-regular fa-file-lines"></i>
                    </div>

                    @php
                        $statusColor = strtolower($layanan->status) == 'aktif'
                            ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                            : 'bg-red-50 text-red-600 border-red-100';
                    @endphp
                    <div class="inline-flex items-center gap-1.5 {{ $statusColor }} border px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full {{ strtolower($layanan->status) == 'aktif' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        {{ ucfirst($layanan->status) }}
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="px-8 flex flex-col flex-grow relative z-10">
                    <h3 class="text-xl font-display font-bold text-slate-900 tracking-tight leading-snug mb-6 group-hover:text-blue-600 transition-colors">
                        {{ $layanan->nama_layanan }}
                    </h3>

                    <div class="space-y-5 mb-8 flex-grow">
                        <div>
                            <h4 class="text-[11px] uppercase tracking-widest text-slate-400 font-bold mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-blue-400"></i> Deskripsi Singkat
                            </h4>
                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-3">
                                {{ $layanan->deskripsi ?: 'Layanan administrasi desa tersedia untuk masyarakat.' }}
                            </p>
                        </div>

                        <div>
                            <h4 class="text-[11px] uppercase tracking-widest text-slate-400 font-bold mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-list-check text-cyan-500"></i> Persyaratan
                            </h4>
                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-2">
                                {{ $layanan->persyaratan ?: 'Sesuai dengan ketentuan administrasi yang berlaku.' }}
                            </p>
                        </div>
                    </div>

                    {{-- CARD FOOTER (ACTION) --}}
                    <div class="pb-8 mt-auto pt-2">
                        <a href="{{ route('public.layanan.show', $layanan->id) }}"
                           class="w-full inline-flex items-center justify-center gap-2 bg-slate-50 hover:bg-navy-900 text-navy-900 hover:text-white border border-slate-200 hover:border-navy-900 px-6 py-4 rounded-2xl font-bold transition-all duration-300 group/btn">
                            Buat Pengajuan
                            <i class="fa-solid fa-arrow-right text-sm transform group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

            </div>

            @endforeach
        </div>

        {{-- EMPTY SEARCH RESULT (HIDDEN BY DEFAULT) --}}
        <div id="emptySearch" class="hidden bg-white border border-slate-200/60 rounded-[3rem] shadow-sm p-16 text-center max-w-3xl mx-auto reveal mt-8">
            <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 flex items-center justify-center text-5xl mb-8 shadow-inner text-slate-400">
                <i class="fa-solid fa-magnifying-glass-minus"></i>
            </div>
            <h3 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-4">
                Layanan Tidak Ditemukan
            </h3>
            <p class="text-slate-500 text-lg leading-relaxed mb-8">
                Kata kunci yang Anda cari tidak cocok dengan layanan manapun. Pastikan ejaan benar atau gunakan kata kunci umum (misal: "KTP", "Domisili").
            </p>
            <button onclick="document.getElementById('searchInput').value = ''; document.getElementById('searchInput').dispatchEvent(new Event('input'));"
                    class="bg-blue-600 hover:bg-navy-900 text-white px-8 py-3 rounded-full font-bold transition-colors">
                Reset Pencarian
            </button>
        </div>

        @else

        {{-- EMPTY DATA (NO SERVICES AVAILABLE IN DB) --}}
        <div class="bg-white border border-slate-200/60 rounded-[3rem] shadow-sm p-16 text-center max-w-3xl mx-auto reveal">
            <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 flex items-center justify-center text-5xl mb-8 shadow-inner text-slate-400">
                <i class="fa-regular fa-folder-closed"></i>
            </div>
            <h3 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-4">
                Belum Ada Layanan
            </h3>
            <p class="text-slate-500 text-lg leading-relaxed">
                Saat ini pihak desa belum mengaktifkan layanan administrasi elektronik apapun di dalam sistem.
            </p>
        </div>

        @endif

    </section>

</div>

{{-- SCRIPT PENCARIAN (LOGIC TETAP DIPERTAHANKAN 100%) --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const layananCards = document.querySelectorAll('.layanan-card');
    const emptySearch = document.getElementById('emptySearch');
    const layananGrid = document.getElementById('layananGrid');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleCount = 0;

            layananCards.forEach(card => {
                const name = card.dataset.name || '';
                const desc = card.dataset.desc || '';

                const matched = name.includes(keyword) || desc.includes(keyword);

                if (matched) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            if (visibleCount === 0 && keyword !== '') {
                emptySearch.classList.remove('hidden');
                if (layananGrid) {
                    layananGrid.classList.add('hidden');
                }
            } else {
                emptySearch.classList.add('hidden');
                if (layananGrid) {
                    layananGrid.classList.remove('hidden');
                }
            }
        });
    }
</script>

@endsection