@extends('layouts.public')

@section('title', 'Lacak Permohonan & Pengaduan — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8 min-h-[85vh] flex flex-col">

    {{-- SUCCESS ALERT (KODE TRACKING BARU) --}}
    @if(session('success') && session('tracking_code'))
    <section class="mb-10 reveal">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[3rem] p-1 relative overflow-hidden shadow-xl shadow-emerald-500/20">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="bg-white rounded-[2.8rem] p-8 md:p-10 relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">

                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-3xl text-emerald-600 shrink-0 shadow-inner">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <div class="inline-flex bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 mb-3">
                            Tracking Aktif
                        </div>
                        <h3 class="text-2xl md:text-3xl font-display font-black text-slate-900 tracking-tight mb-2">
                            {{ session('success') }}
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-lg">
                            Simpan kode tracking Anda dengan baik. Anda dapat langsung melacaknya menggunakan form di bawah.
                        </p>
                    </div>
                </div>

                <div class="w-full lg:w-[400px] bg-slate-50 p-5 rounded-[2rem] border border-slate-200 shrink-0">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">
                        KODE TRACKING ANDA
                    </label>
                    <div class="flex gap-2">
                        <input id="trackingCode" type="text" readonly value="{{ session('tracking_code') }}"
                            class="flex-1 border-2 border-slate-200 bg-white rounded-xl px-4 py-3 font-display font-black text-slate-800 text-lg tracking-widest focus:outline-none transition-colors cursor-text text-center sm:text-left">
                        <button type="button" onclick="copyTrackingCode()"
                            class="bg-emerald-600 hover:bg-navy-900 text-white px-5 rounded-xl font-bold transition-all shadow-lg flex items-center justify-center group" title="Salin Kode">
                            <i class="fa-regular fa-copy group-hover:scale-110 transition-transform"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- ERROR & VALIDATION ALERTS --}}
    @if($errors->any() || session('error'))
    <section class="mb-10 reveal">
        <div class="bg-red-50 border border-red-200 rounded-[2.5rem] p-8 shadow-sm relative overflow-hidden flex items-start gap-6">
            <div class="absolute -right-5 -top-5 text-red-500/10 text-8xl pointer-events-none">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-3xl text-red-600 shrink-0 shadow-inner border border-red-200 relative z-10">
                <i class="fa-solid fa-magnifying-glass-minus"></i>
            </div>

            <div class="relative z-10">
                <h3 class="text-2xl font-display font-black text-red-800 tracking-tight mb-3">
                    {{ session('error') ? 'Tracking Tidak Ditemukan' : 'Pencarian Gagal' }}
                </h3>

                @if(session('error'))
                    <p class="text-red-600 font-medium bg-white/60 px-5 py-3 rounded-xl border border-red-100 inline-block">
                        {{ session('error') }}
                    </p>
                @endif

                @if($errors->any())
                    <ul class="space-y-2 text-red-600 font-medium text-sm bg-white/60 p-5 rounded-xl border border-red-100">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation mt-1 text-red-500 shrink-0"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- MAIN TRACKING SEARCH (CENTERED ENGINE STYLE) --}}
    <section class="mb-16 reveal flex-grow flex flex-col justify-center">
        <div class="relative overflow-hidden rounded-[3.5rem] bg-[#0F172A] p-10 md:p-20 shadow-2xl border border-slate-800 text-center">

            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="relative z-10 max-w-3xl mx-auto flex flex-col items-center">

                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-[2rem] flex items-center justify-center text-4xl text-white shadow-xl shadow-blue-500/30 mb-8 transform -rotate-6">
                    <i class="fa-solid fa-satellite-dish"></i>
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    Lacak Berkas & Laporan
                </h1>

                <p class="text-lg text-slate-400 font-light leading-relaxed mb-12 max-w-xl mx-auto">
                    Masukkan kode tracking (<strong class="text-white">LYN-...</strong> atau <strong class="text-white">PGD-...</strong>) untuk memantau status secara *real-time*.
                </p>

                <form id="trackingForm" action="{{ route('public.tracking.cari') }}" method="POST" class="w-full max-w-2xl">
                    @csrf

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 text-xl group-focus-within:text-blue-500 transition-colors"></i>
                        </div>

                        <input
                            id="trackingInput"
                            type="text"
                            name="tracking_code"
                            value="{{ old('tracking_code') }}"
                            placeholder="Contoh: LYN-2026-0001"
                            required
                            class="w-full bg-white border-4 border-white/10 rounded-[2rem] pl-16 pr-40 py-6 text-xl md:text-2xl font-display font-black text-slate-800 uppercase tracking-widest placeholder:text-slate-300 placeholder:font-medium placeholder:tracking-normal placeholder:normal-case focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all shadow-2xl"
                        >

                        <div class="absolute inset-y-2 right-2 flex gap-2">
                            <button type="button" onclick="clearTrackingForm()" class="hidden md:flex items-center justify-center px-4 text-slate-400 hover:text-red-500 transition-colors" title="Bersihkan">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>
                            <button
                                id="submitBtn"
                                type="submit"
                                class="bg-blue-600 hover:bg-navy-900 text-white px-8 rounded-2xl font-bold transition-all shadow-lg flex items-center justify-center gap-2 group/btn">
                                Cari <i class="fa-solid fa-arrow-right transform group-hover/btn:translate-x-1 transition-transform hidden sm:inline-block"></i>
                            </button>
                        </div>
                    </div>

                    <p class="text-slate-500 text-sm mt-6 font-medium">
                        Layanan online 24 Jam Non-Stop.
                    </p>
                </form>

            </div>
        </div>
    </section>

    {{-- INFO CARDS --}}
    <section class="reveal">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 md:p-10 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-3xl mb-6 text-blue-600 group-hover:scale-110 transition-transform">
                    <i class="fa-regular fa-folder-open"></i>
                </div>
                <h3 class="text-2xl font-display font-black text-slate-900 tracking-tight mb-3">
                    Layanan Administrasi
                </h3>
                <p class="text-slate-500 leading-relaxed">
                    Kode berawalan <strong>LYN-</strong> digunakan untuk memantau status pengajuan pembuatan surat pengantar, keterangan domisili, atau administrasi warga lainnya.
                </p>
            </div>

            <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 md:p-10 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group">
                <div class="w-16 h-16 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-3xl mb-6 text-rose-600 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-bullhorn text-2xl"></i>
                </div>
                <h3 class="text-2xl font-display font-black text-slate-900 tracking-tight mb-3">
                    Pengaduan Masyarakat
                </h3>
                <p class="text-slate-500 leading-relaxed">
                    Kode berawalan <strong>PGD-</strong> digunakan untuk melihat tindak lanjut dari laporan, keluhan infrastruktur, atau layanan yang telah Anda sampaikan.
                </p>
            </div>
        </div>
    </section>

</div>

@endsection

@push('scripts')
{{-- JAVASCRIPT LOGIC (TIDAK ADA LOGIC YANG DIUBAH DARI VERSI ASLI) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trackingForm = document.getElementById('trackingForm');
    const trackingInput = document.getElementById('trackingInput');
    const submitBtn = document.getElementById('submitBtn');

    // Upgrade alert ke SweetAlert2 jika tersedia
    function showMessage(message, type = 'info') {
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'info' ? 'Informasi' : 'Peringatan',
                text: message,
                confirmButtonColor: '#2563eb',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl font-bold px-8 py-3'
                }
            });
        } else {
            alert(message);
        }
    }

    // Export function agar bisa dipanggil onClick
    window.copyTrackingCode = async function() {
        const input = document.getElementById('trackingCode');
        if (!input) return;

        try {
            await navigator.clipboard.writeText(input.value);
            showMessage('Kode tracking berhasil disalin ke clipboard.', 'success');
        } catch (error) {
            try {
                input.select();
                document.execCommand('copy');
                showMessage('Kode tracking berhasil disalin ke clipboard.', 'success');
            } catch {
                showMessage('Gagal menyalin kode tracking.', 'error');
            }
        }
    };

    window.clearTrackingForm = function() {
        if(trackingInput) {
            trackingInput.value = '';
            trackingInput.focus();
        }
    };

    if(trackingInput) {
        trackingInput.addEventListener('input', function() {
            // Auto uppercase & remove space
            this.value = this.value.toUpperCase().replace(/\s+/g, '');
        });
    }

    if(trackingForm) {
        trackingForm.addEventListener('submit', function(e) {
            const value = trackingInput.value.trim();

            if (!value) {
                e.preventDefault();
                showMessage('Kode tracking wajib diisi untuk melakukan pencarian.', 'warning');
                return;
            }

            if(submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mencari...';
            }
        });
    }
});
</script>
@endpush