@extends('layouts.public')

@section('title', 'Hasil Pelacakan — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- NAVIGASI KEMBALI --}}
    <div class="mb-10 reveal">
        <a href="{{ route('public.tracking.index') }}"
           class="group inline-flex items-center gap-3 text-slate-500 hover:text-blue-600 font-semibold transition-colors">
            <span class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-blue-50 group-hover:border-blue-200 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
            </span>
            Kembali ke Pencarian
        </a>
    </div>

    {{-- HERO SECTION (DIGITAL TICKET STYLE) --}}
    <section class="mb-8 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 md:p-14 shadow-2xl border border-slate-800">
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-600/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[300px] h-[300px] bg-cyan-500/10 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                {{-- KIRI: JUDUL --}}
                <div class="lg:col-span-7 text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Hasil Pelacakan Sistem</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black leading-tight tracking-tight mb-4">
                        Status <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-500">{{ $jenis === 'permohonan' ? 'Layanan' : 'Pengaduan' }}</span>
                    </h1>

                    <p class="text-lg text-slate-400 font-light leading-relaxed max-w-xl">
                        Sistem berhasil menemukan data Anda. Pantau pergerakan berkas secara transparan melalui lini masa di bawah ini.
                    </p>
                </div>

                {{-- KANAN: TRACKING TICKET --}}
                <div class="lg:col-span-5">
                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-400"></div>
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-4">
                            Kode Resi / Tracking
                        </h3>
                        <div class="flex items-center justify-between bg-navy-950/50 border border-white/10 rounded-2xl p-6">
                            <span class="font-display font-black text-2xl tracking-widest text-cyan-50 break-all">
                                {{ $data->tracking_code }}
                            </span>
                            <i class="fa-solid fa-barcode text-4xl text-slate-600 opacity-50"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- STATUS SUMMARY METRICS --}}
    <section class="mb-14 reveal">
        @php
            // Upgrade visual mapping untuk status (UI ONLY)
            $statusUI = match(strtolower($data->status)) {
                'baru' => ['bg-blue-50 border-blue-200 text-blue-600', 'fa-inbox', 'text-blue-500'],
                'ditinjau' => ['bg-yellow-50 border-yellow-200 text-yellow-600', 'fa-magnifying-glass', 'text-yellow-500'],
                'diproses' => ['bg-amber-50 border-amber-200 text-amber-600', 'fa-gears', 'text-amber-500'],
                'menunggu_dokumen' => ['bg-purple-50 border-purple-200 text-purple-600', 'fa-file-signature', 'text-purple-500'],
                'selesai' => ['bg-emerald-50 border-emerald-200 text-emerald-600', 'fa-check-double', 'text-emerald-500'],
                'ditolak' => ['bg-rose-50 border-rose-200 text-rose-600', 'fa-circle-xmark', 'text-rose-500'],
                default => ['bg-slate-50 border-slate-200 text-slate-600', 'fa-circle-dot', 'text-slate-500']
            };
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm flex items-center gap-6 group hover:shadow-md transition-shadow">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl text-slate-400 group-hover:text-blue-500 group-hover:scale-110 transition-all">
                    <i class="fa-solid {{ $jenis === 'permohonan' ? 'fa-folder-open' : 'fa-bullhorn' }}"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-1">Tipe Data</p>
                    <h3 class="text-xl font-display font-black text-slate-800 leading-tight">
                        {{ $jenis === 'permohonan' ? 'Permohonan Layanan' : 'Pengaduan Publik' }}
                    </h3>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm flex items-center gap-6 group hover:shadow-md transition-shadow">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl {{ $statusUI[2] }} group-hover:scale-110 transition-all">
                    <i class="fa-solid {{ $statusUI[1] }}"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-2">Status Saat Ini</p>
                    <span class="inline-flex {{ $statusUI[0] }} border px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest">
                        {{ str_replace('_', ' ', $data->status) }}
                    </span>
                </div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2rem] p-8 shadow-sm flex items-center gap-6 group hover:shadow-md transition-shadow">
                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-2xl text-slate-400 group-hover:text-blue-500 group-hover:scale-110 transition-all">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400 font-bold mb-1">Tanggal Masuk</p>
                    <h3 class="text-xl font-display font-black text-slate-800 leading-tight">
                        {{ $data->created_at->format('d M Y') }}
                    </h3>
                    <p class="text-xs text-slate-400 mt-1 font-medium">{{ $data->created_at->format('H:i') }} WIB</p>
                </div>
            </div>
        </div>
    </section>

    {{-- MAIN CONTENT (DETAIL & TIMELINE) --}}
    <section class="reveal">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- LEFT: DETAIL DATA (STICKY) --}}
            <div class="lg:col-span-5 xl:col-span-4">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm p-8 md:p-10 sticky top-32">
                    <h2 class="text-2xl font-display font-black text-slate-800 tracking-tight mb-8 flex items-center gap-3">
                        <i class="fa-regular fa-address-card text-blue-500"></i> Detail Pemohon
                    </h2>

                    <div class="space-y-6">
                        <div class="border-b border-slate-50 pb-6">
                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Nama Lengkap</p>
                            <p class="text-lg font-black text-slate-800">{{ $data->nama }}</p>
                        </div>

                        @if($jenis === 'permohonan')
                            <div class="border-b border-slate-50 pb-6">
                                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Layanan yang Diajukan</p>
                                <p class="text-base font-bold text-blue-600">{{ $data->layanan->nama_layanan ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 border-b border-slate-50 pb-6">
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">NIK</p>
                                    <p class="text-sm font-semibold text-slate-700">{{ $data->nik }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Telepon</p>
                                    <p class="text-sm font-semibold text-slate-700">{{ $data->telepon ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Keperluan</p>
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $data->pesan ?? '-' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="border-b border-slate-50 pb-6">
                                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Kategori Laporan</p>
                                <p class="inline-flex bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-xs font-bold">{{ $data->kategori ?? '-' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 border-b border-slate-50 pb-6">
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Email</p>
                                    <p class="text-sm font-semibold text-slate-700 break-all">{{ $data->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Telepon</p>
                                    <p class="text-sm font-semibold text-slate-700">{{ $data->telepon ?? '-' }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2">Isi Pengaduan</p>
                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-sm text-slate-600 leading-relaxed">{{ $data->isi_pengaduan ?? '-' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: TIMELINE --}}
            <div class="lg:col-span-7 xl:col-span-8">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-sm p-8 md:p-12 h-full">

                    <div class="mb-12 border-b border-slate-100 pb-8 flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-display font-black text-slate-800 tracking-tight mb-2">
                                Jejak Aktivitas
                            </h2>
                            <p class="text-slate-500">
                                Riwayat pemrosesan dokumen secara real-time.
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-2xl">
                            <i class="fa-solid fa-list-ul"></i>
                        </div>
                    </div>

                    @if($logs->count())
                        <div class="relative pl-6 md:pl-8 space-y-12">
                            <div class="absolute left-[38px] md:left-[46px] top-4 bottom-0 w-0.5 bg-slate-100"></div>

                            @foreach($logs as $log)
                                @php
                                    // UI Mapping untuk setiap card timeline
                                    $tl = match(strtolower($log->status_baru)) {
                                        'baru' => ['bg-blue-50 border-blue-200 text-blue-600', 'fa-inbox'],
                                        'ditinjau' => ['bg-yellow-50 border-yellow-200 text-yellow-600', 'fa-magnifying-glass'],
                                        'diproses' => ['bg-amber-50 border-amber-200 text-amber-600', 'fa-gears'],
                                        'menunggu_dokumen' => ['bg-purple-50 border-purple-200 text-purple-600', 'fa-file-signature'],
                                        'selesai' => ['bg-emerald-50 border-emerald-200 text-emerald-600', 'fa-check-double'],
                                        'ditolak' => ['bg-rose-50 border-rose-200 text-rose-600', 'fa-circle-xmark'],
                                        default => ['bg-slate-50 border-slate-200 text-slate-600', 'fa-circle-dot']
                                    };
                                @endphp

                                <div class="relative group">
                                    {{-- DOT ICON (ABSOLUTE DI ATAS GARIS) --}}
                                    <div class="absolute -left-9 md:-left-[35px] top-0 w-12 h-12 rounded-full {{ $tl[0] }} border-2 flex items-center justify-center text-sm shadow-sm bg-white z-10 group-hover:scale-110 transition-transform">
                                        <i class="fa-solid {{ $tl[1] }}"></i>
                                    </div>

                                    {{-- CARD KONTEN --}}
                                    <div class="ml-8 md:ml-12 bg-white border border-slate-100 rounded-3xl p-6 shadow-sm group-hover:shadow-md transition-shadow group-hover:border-blue-100">

                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 border-b border-slate-50 pb-4">
                                            <div>
                                                <h3 class="text-lg font-display font-black text-slate-800 capitalize">
                                                    {{ str_replace('_', ' ', $log->status_baru) }}
                                                </h3>
                                                <p class="text-slate-400 text-[11px] font-bold tracking-widest uppercase mt-1">
                                                    {{ $log->created_at->format('d M Y • H:i') }} WIB
                                                </p>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                @if($log->status_lama)
                                                    <span class="inline-flex bg-slate-100 text-slate-500 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider">
                                                        {{ str_replace('_', ' ', $log->status_lama) }}
                                                    </span>
                                                    <i class="fa-solid fa-arrow-right-long text-slate-300 text-xs"></i>
                                                @endif
                                                <span class="inline-flex {{ str_replace('border-', 'bg-', str_replace('bg-', 'bg-opacity-20 ', $tl[0])) }} px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider shadow-sm">
                                                    {{ str_replace('_', ' ', $log->status_baru) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div>
                                            <p class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-2 flex items-center gap-2">
                                                <i class="fa-regular fa-comment-dots"></i> Catatan Petugas
                                            </p>
                                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                                <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line font-medium">
                                                    {{ $log->catatan ?? 'Status diperbarui otomatis oleh sistem tanpa catatan tambahan.' }}
                                                </p>
                                            </div>
                                        </div>

                                        @if($log->admin)
                                            <div class="mt-5 flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                                                    <i class="fa-solid fa-user-shield"></i>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Diproses Oleh</p>
                                                    <p class="text-xs font-bold text-slate-700">{{ $log->admin->name }}</p>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- EMPTY STATE TIMELINE --}}
                        <div class="bg-slate-50 border border-slate-100 rounded-[2.5rem] p-16 text-center h-full flex flex-col justify-center items-center">
                            <div class="w-24 h-24 rounded-[2rem] bg-white flex items-center justify-center text-5xl mb-6 shadow-sm text-slate-300">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <h3 class="text-2xl font-display font-black text-slate-800 tracking-tight mb-3">
                                Belum Ada Riwayat
                            </h3>
                            <p class="text-slate-500 text-sm leading-relaxed max-w-sm mx-auto">
                                Sistem belum mencatat perkembangan aktivitas untuk tracking ini. Mohon tunggu beberapa saat.
                            </p>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </section>

</div>

@endsection