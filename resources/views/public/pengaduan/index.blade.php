@extends('layouts.public')

@section('title', 'Layanan Pengaduan Masyarakat — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">
    {{-- HERO SECTION --}}
    <section class="mb-12 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 md:p-14 lg:p-16 shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-red-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-rose-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Pusat Layanan Masyarakat</span>
                </div>

                <h1 class="text-5xl lg:text-7xl font-display font-black text-white leading-tight tracking-tight mb-6">
                    Suara <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-red-500">Warga</span>
                </h1>

                <p class="text-lg lg:text-xl text-slate-400 font-light leading-relaxed max-w-2xl">
                    Sampaikan laporan, keluhan, masukan, atau permasalahan di lingkungan desa. Setiap laporan akan diverifikasi dan dapat dipantau perkembangannya.
                </p>
            </div>
        </div>
    </section>

    {{-- SUCCESS ALERT (TAMPIL JIKA BERHASIL MENGIRIM) --}}
    @if(session('success') && session('tracking_code'))
    <section class="mb-12 reveal">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-[3rem] p-1 relative overflow-hidden shadow-2xl shadow-emerald-500/20">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="bg-white rounded-[2.8rem] p-8 md:p-12 relative z-10 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-10">

                <div class="flex items-start gap-6">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-3xl text-emerald-600 shrink-0 shadow-inner">
                        <i class="fa-solid fa-check-double"></i>
                    </div>
                    <div>
                        <div class="inline-flex bg-emerald-50 text-emerald-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100 mb-3">
                            Laporan Diterima
                        </div>
                        <h3 class="text-2xl md:text-3xl font-display font-black text-slate-900 tracking-tight mb-3">
                            {{ session('success') }}
                        </h3>
                        <p class="text-slate-500 text-base leading-relaxed max-w-xl">
                            Simpan kode unik di bawah ini dengan baik. Gunakan kode ini pada menu <strong>Tracking</strong> untuk memantau status penanganan pengaduan Anda.
                        </p>
                    </div>
                </div>

                <div class="w-full xl:w-[450px] bg-slate-50 p-6 rounded-3xl border border-slate-200">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">
                        KODE TRACKING RAHASIA
                    </label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input
                            id="trackingCode"
                            type="text"
                            readonly
                            value="{{ session('tracking_code') }}"
                            class="flex-1 border-2 border-slate-200 bg-white rounded-2xl px-6 py-4 font-display font-black text-slate-800 text-xl tracking-widest focus:outline-none focus:border-emerald-500 transition-colors cursor-text text-center sm:text-left"
                        >
                        <button
                            type="button"
                            onclick="copyTrackingCode()"
                            class="bg-emerald-600 hover:bg-navy-900 text-white px-8 py-4 rounded-2xl font-bold transition-all shadow-lg shadow-emerald-600/20 flex items-center justify-center gap-2 group">
                            <i class="fa-regular fa-copy group-hover:scale-110 transition-transform"></i> Salin
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    {{-- ERROR VALIDATION ALERT --}}
    @if($errors->any())
    <section class="mb-12 reveal">
        <div class="bg-red-50 border border-red-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-red-500/10 text-9xl pointer-events-none">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="relative z-10 flex items-start gap-6">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-3xl text-red-600 shrink-0 shadow-inner border border-red-200">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-display font-black text-red-800 tracking-tight mb-4">
                        Terdapat Kesalahan Input
                    </h3>
                    <ul class="space-y-2 text-red-600 font-medium text-sm md:text-base bg-white/60 p-6 rounded-2xl border border-red-100">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <i class="fa-solid fa-circle-exclamation mt-1 text-red-500 shrink-0"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- FORM SECTION --}}
    <section class="reveal mb-24">
        <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm overflow-hidden flex flex-col xl:flex-row">

            {{-- FORM LEFT SIDEBAR (GUIDELINE) --}}
            <div class="w-full xl:w-[400px] shrink-0 bg-slate-50 p-10 md:p-14 border-r border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-rose-400"></div>

                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-3xl text-red-600 mb-8 shadow-sm">
                    <i class="fa-solid fa-bullhorn text-2xl"></i>
                </div>

                <h2 class="text-2xl font-display font-black tracking-tight mb-4 text-slate-900">
                    Aturan Pelaporan
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-8">
                    Mohon baca aturan berikut sebelum mengirimkan pengaduan agar dapat segera ditindaklanjuti.
                </p>

                <div class="space-y-4">
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-rose-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Bukan Laporan Palsu</p>
                            <p class="text-xs text-slate-500 mt-1">Pastikan pengaduan berdasarkan fakta dan bukti nyata.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-rose-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Gunakan Bahasa Sopan</p>
                            <p class="text-xs text-slate-500 mt-1">Jelaskan kronologi masalah tanpa unsur SARA/kebencian.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-rose-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Simpan Kode Tracking</p>
                            <p class="text-xs text-slate-500 mt-1">Kode rahasia akan muncul setelah form dikirim.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM RIGHT (INPUT FIELDS) --}}
            <div class="w-full p-10 md:p-14">
                <div class="mb-10 border-b border-slate-100 pb-6">
                    <h3 class="text-2xl md:text-3xl font-display font-black text-slate-900 tracking-tight mb-2">
                        Formulir Pengaduan
                    </h3>
                    <p class="text-slate-500 text-sm font-medium">
                        Tanda asteris (<span class="text-red-500">*</span>) wajib diisi.
                    </p>
                </div>

                <form
                    id="pengaduanForm"
                    action="{{ route('public.pengaduan.store') }}"
                    method="POST"
                    novalidate>
                    @csrf

                    {{-- PERSONAL DATA --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Nama Lengkap Pemohohon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-user text-slate-400"></i>
                                </div>
                                <input type="text" name="nama" value="{{ old('nama') }}" required maxlength="255" autocomplete="name"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="Nama Anda (Bisa Anonim)">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                NIK <span class="text-slate-300 font-medium normal-case tracking-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-id-card text-slate-400"></i>
                                </div>
                                <input id="nik" type="text" name="nik" value="{{ old('nik') }}" maxlength="20" inputmode="numeric" autocomplete="off"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="16 digit angka KTP">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Alamat Email <span class="text-slate-300 font-medium normal-case tracking-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-slate-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Nomor Telepon / WA <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-mobile-screen text-slate-400"></i>
                                </div>
                                <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" required maxlength="20" inputmode="numeric" autocomplete="tel"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT & KATEGORI --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-b border-slate-100 pb-12">

                        <div class="relative md:col-span-2">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Kategori Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-layer-group text-slate-400"></i>
                                </div>
                                <select name="kategori" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-10 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium appearance-none cursor-pointer">
                                    <option value="" disabled selected class="text-slate-400">Pilih Kategori Permasalahan</option>
                                    <option value="Infrastruktur" {{ old('kategori') == 'Infrastruktur' ? 'selected' : '' }}>Infrastruktur & Fasilitas Umum</option>
                                    <option value="Kebersihan" {{ old('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan & Lingkungan</option>
                                    <option value="Pelayanan" {{ old('kategori') == 'Pelayanan' ? 'selected' : '' }}>Pelayanan Aparatur Desa</option>
                                    <option value="Keamanan" {{ old('kategori') == 'Keamanan' ? 'selected' : '' }}>Keamanan & Ketertiban</option>
                                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-chevron-down text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Lokasi / Alamat Kejadian <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" rows="3" required maxlength="1000"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-6 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="Jelaskan detail lokasi kejadian/permasalahan secara rinci.">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- ISI PENGADUAN --}}
                    <div class="mb-10 border-b border-slate-100 pb-10">
                        <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                            Isi Pengaduan / Keluhan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="isi_pengaduan" name="isi_pengaduan" rows="6" required minlength="20" maxlength="5000"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-6 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all font-medium placeholder:font-light" placeholder="Jelaskan secara rinci kronologi kejadian atau masalah yang Anda alami (Minimal 20 karakter).">{{ old('isi_pengaduan') }}</textarea>
                        <p class="text-xs font-bold text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info text-blue-400"></i> Semakin detail penjelasan Anda, semakin mudah admin menindaklanjuti.</p>
                    </div>

                    {{-- SUBMIT ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-4 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <button
                            id="submitBtn"
                            type="submit"
                            class="flex-1 bg-red-600 hover:bg-rose-700 text-white px-8 py-4 rounded-2xl font-black transition-colors shadow-lg shadow-red-600/20 flex items-center justify-center gap-2 group/btn">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Laporan
                        </button>

                        <button
                            type="button"
                            onclick="resetPengaduanForm()"
                            class="bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 px-8 py-4 rounded-2xl font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Reset
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>

</div>

@endsection

@push('scripts')
{{-- JAVASCRIPT VALIDASI & FUNGSI COPY (LOGIC TETAP DIPERTAHANKAN 100%) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pengaduanForm = document.getElementById('pengaduanForm');
    const submitBtn = document.getElementById('submitBtn');
    const nikInput = document.getElementById('nik');
    const teleponInput = document.getElementById('telepon');
    const isiPengaduan = document.getElementById('isi_pengaduan');

    let isSubmitting = false;

    // Fungsi notifikasi menggunakan SweetAlert2
    function showMessage(message, type = 'warning') {
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'warning' ? 'Validasi Gagal' : 'Berhasil',
                text: message,
                confirmButtonColor: type === 'warning' ? '#e11d48' : '#059669', // rose-600 / emerald-600
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl font-bold px-8 py-3'
                }
            });
        } else {
            alert(message);
        }
    }

    // Fungsi Copy Tracking (Export ke window agar bisa dipanggil via HTML onClick)
    window.copyTrackingCode = async function() {
        const input = document.getElementById('trackingCode');
        if (!input) return;

        try {
            await navigator.clipboard.writeText(input.value);
            showMessage('Kode tracking berhasil disalin ke clipboard.', 'success');
        } catch (error) {
            try {
                input.select();
                input.setSelectionRange(0, 99999);
                document.execCommand('copy');
                showMessage('Kode tracking berhasil disalin ke clipboard.', 'success');
            } catch {
                showMessage('Gagal menyalin kode tracking. Silakan salin secara manual.', 'warning');
            }
        }
    };

    window.resetPengaduanForm = function() {
        if (!pengaduanForm) return;

        pengaduanForm.reset();

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Laporan';
        }

        isSubmitting = false;
    };

    if (nikInput) {
        nikInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    if (teleponInput) {
        teleponInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    if (pengaduanForm) {
        pengaduanForm.addEventListener('submit', function (e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            const isi = isiPengaduan.value.trim();
            const telepon = teleponInput.value.trim();
            const alamat = pengaduanForm.querySelector('[name="alamat"]').value.trim();
            const kategori = pengaduanForm.querySelector('[name="kategori"]').value.trim();

            if (!telepon) {
                e.preventDefault();
                showMessage('Nomor telepon wajib diisi agar petugas dapat menghubungi Anda.');
                return;
            }

            if (!alamat) {
                e.preventDefault();
                showMessage('Lokasi/Alamat kejadian wajib diisi dengan jelas.');
                return;
            }

            if (!kategori) {
                e.preventDefault();
                showMessage('Kategori permasalahan pengaduan wajib dipilih.');
                return;
            }

            if (isi.length < 20) {
                e.preventDefault();
                showMessage('Isi laporan pengaduan minimal 20 karakter agar jelas.');
                return;
            }

            isSubmitting = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        });
    }
});
</script>
@endpush