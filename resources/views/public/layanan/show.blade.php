@extends('layouts.public')

@section('title', 'Permohonan: ' . $layanan->nama_layanan . ' — SI Desa')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- NAVIGASI KEMBALI --}}
    <div class="mb-10 reveal">
        <a href="{{ route('public.layanan.index') }}"
           class="group inline-flex items-center gap-3 text-slate-500 hover:text-blue-600 font-semibold transition-colors">
            <span class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-blue-50 group-hover:border-blue-200 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
            </span>
            Kembali ke Katalog Layanan
        </a>
    </div>

    {{-- HERO SECTION --}}
    <section class="mb-12 reveal">
        <div class="relative overflow-hidden rounded-[3rem] bg-[#0F172A] p-10 md:p-14 lg:p-16 shadow-2xl">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] -mr-40 -mt-40 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                {{-- INFO KIRI --}}
                <div class="lg:col-span-7 text-white">
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 px-4 py-2 rounded-full mb-6 backdrop-blur-md">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Formulir E-Layanan</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-black leading-[1.1] tracking-tight mb-6">
                        {{ $layanan->nama_layanan }}
                    </h1>

                    <p class="text-lg text-slate-300 font-light leading-relaxed max-w-2xl">
                        {{ $layanan->deskripsi ?? 'Layanan administrasi desa untuk masyarakat. Lengkapi form di bawah untuk memulai pengajuan.' }}
                    </p>
                </div>

                {{-- INFO KANAN (SYARAT & STATUS) --}}
                <div class="lg:col-span-5 relative">
                    <div class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 text-white shadow-xl">
                        <h3 class="text-xl font-display font-bold tracking-tight mb-6 flex items-center gap-3">
                            <i class="fa-solid fa-circle-info text-cyan-400"></i> Detail Layanan
                        </h3>

                        <div class="space-y-4">
                            <div class="bg-navy-900/50 rounded-2xl px-6 py-5 border border-white/5 flex items-center justify-between">
                                <span class="text-sm text-slate-300 font-medium">Status Layanan</span>
                                <span class="px-3 py-1 bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 rounded-full text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span> {{ ucfirst($layanan->status) }}
                                </span>
                            </div>

                            <div class="bg-navy-900/50 rounded-2xl px-6 py-5 border border-white/5">
                                <p class="text-sm text-slate-300 font-medium mb-3">Persyaratan Dokumen</p>
                                <p class="text-sm text-slate-400 leading-relaxed font-light">
                                    {{ $layanan->persyaratan ?? 'Sesuai ketentuan administrasi desa.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ALERT VALIDATION ERROR --}}
    @if($errors->any())
    <section class="mb-12 reveal">
        <div class="bg-red-50 border border-red-200 rounded-[2.5rem] p-8 md:p-10 shadow-sm relative overflow-hidden">
            <div class="absolute -right-10 -top-10 text-red-500/10 text-9xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="relative z-10 flex items-start gap-6">
                <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center text-3xl text-red-600 shrink-0 shadow-inner border border-red-200">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-display font-black text-red-800 tracking-tight mb-4">
                        Validasi Form Gagal
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

    {{-- MAIN FORM SECTION --}}
    <section class="reveal mb-24">
        <div class="bg-white border border-slate-100 rounded-[3rem] shadow-sm overflow-hidden flex flex-col xl:flex-row">

            {{-- FORM LEFT SIDEBAR (GUIDELINE) --}}
            <div class="w-full xl:w-[400px] shrink-0 bg-slate-50 p-10 md:p-14 border-r border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-400"></div>

                <div class="w-16 h-16 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-2xl text-blue-600 mb-8 shadow-sm">
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>

                <h2 class="text-2xl font-display font-black tracking-tight mb-4 text-slate-900">
                    Panduan Pengisian
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed mb-8">
                    Pastikan Anda mengisi formulir dengan data yang valid dan sesuai dengan dokumen asli (KTP/KK).
                </p>

                <div class="space-y-4">
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">NIK Harus Valid</p>
                            <p class="text-xs text-slate-500 mt-1">Pastikan 16 digit angka sesuai KTP.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Unggah KTP & KK</p>
                            <p class="text-xs text-slate-500 mt-1">Wajib format gambar/PDF, maksimal 4MB.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
                        <i class="fa-solid fa-check-circle text-emerald-500 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Deskripsi Keperluan</p>
                            <p class="text-xs text-slate-500 mt-1">Minimal 20 karakter agar jelas dipahami admin.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FORM RIGHT (INPUT FIELDS) --}}
            <div class="w-full p-10 md:p-14">
                <div class="mb-10 flex items-center justify-between border-b border-slate-100 pb-6">
                    <div>
                        <h3 class="text-2xl md:text-3xl font-display font-black text-slate-900 tracking-tight mb-2">
                            Form Identitas & Dokumen
                        </h3>
                        <p class="text-slate-500 text-sm font-medium">
                            Tanda asteris (<span class="text-red-500">*</span>) wajib diisi.
                        </p>
                    </div>
                </div>

                <form
                    id="permohonanForm"
                    action="{{ route('public.layanan.ajukan') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    novalidate>
                    @csrf
                    <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

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
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="Contoh: Budi Santoso">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-id-card text-slate-400"></i>
                                </div>
                                <input id="nik" type="text" name="nik" value="{{ old('nik') }}" required maxlength="20" inputmode="numeric" autocomplete="off"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="Masukkan 16 digit NIK">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Alamat Email Aktif <span class="text-slate-300 font-medium normal-case tracking-normal">(Opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-slate-400"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Nomor WhatsApp / Telepon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-mobile-screen text-slate-400"></i>
                                </div>
                                <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" required maxlength="20" inputmode="numeric" autocomplete="tel"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-6 py-4 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT & KEPERLUAN --}}
                    <div class="space-y-8 mb-12 border-b border-slate-100 pb-12">
                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Alamat Lengkap Domisili <span class="text-red-500">*</span>
                            </label>
                            <textarea name="alamat" rows="3" required maxlength="1000"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-6 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="Tuliskan nama jalan, RT/RW, Dusun, dll.">{{ old('alamat') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3">
                                Tujuan / Keperluan Permohonan <span class="text-red-500">*</span>
                            </label>
                            <textarea id="keperluan" name="keperluan" rows="4" required minlength="20" maxlength="5000"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-6 text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all font-medium placeholder:font-light" placeholder="Jelaskan secara rinci untuk keperluan apa surat/layanan ini dibuat (Minimal 20 karakter).">{{ old('keperluan') }}</textarea>
                            <p class="text-xs font-bold text-slate-400 mt-2 flex items-center gap-1"><i class="fa-solid fa-circle-info"></i> Admin membutuhkan kejelasan tujuan untuk menyetujui dokumen.</p>
                        </div>
                    </div>

                    {{-- UPLOAD DOCUMENTS --}}
                    <div class="mb-12">
                        <h4 class="text-xl font-display font-black text-slate-900 mb-6 flex items-center gap-2">
                            <i class="fa-regular fa-folder-open text-blue-500"></i> Berkas Lampiran
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Upload KTP Asli <span class="text-red-500">*</span></label>
                                <div class="w-full relative bg-slate-50 hover:bg-slate-100 border-2 border-dashed border-slate-300 rounded-2xl p-4 transition-colors group">
                                    <input id="file_ktp" type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-blue-500 shadow-sm group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-upload"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Pilih / Tarik File (KTP)</p>
                                            <p class="text-[10px] font-bold text-slate-400">JPG/PNG/PDF (Maks 4MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Upload Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
                                <div class="w-full relative bg-slate-50 hover:bg-slate-100 border-2 border-dashed border-slate-300 rounded-2xl p-4 transition-colors group">
                                    <input id="file_kk" type="file" name="file_kk" required accept=".jpg,.jpeg,.png,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-blue-500 shadow-sm group-hover:scale-110 transition-transform">
                                            <i class="fa-solid fa-upload"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Pilih / Tarik File (KK)</p>
                                            <p class="text-[10px] font-bold text-slate-400">JPG/PNG/PDF (Maks 4MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2 relative">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Dokumen Pendukung <span class="text-slate-400 font-medium normal-case tracking-normal">(Opsional / Surat Pengantar RT)</span></label>
                                <div class="w-full relative bg-slate-50 hover:bg-slate-100 border-2 border-dashed border-slate-300 rounded-2xl p-4 transition-colors group">
                                    <input id="file_pendukung" type="file" name="file_pendukung" accept=".jpg,.jpeg,.png,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-blue-500 shadow-sm group-hover:scale-110 transition-all">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-700">Pilih / Tarik Dokumen Tambahan</p>
                                            <p class="text-[10px] font-bold text-slate-400">JPG/PNG/PDF (Maks 4MB)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT ACTIONS --}}
                    <div class="flex flex-col sm:flex-row gap-4 bg-slate-50 p-6 rounded-3xl border border-slate-100">
                        <button
                            id="submitBtn"
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-navy-900 text-white px-8 py-4 rounded-2xl font-black transition-colors shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2 group/btn">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Permohonan
                        </button>

                        <button
                            type="button"
                            onclick="resetPermohonanForm()"
                            class="bg-white border border-slate-200 hover:bg-slate-100 text-slate-600 px-8 py-4 rounded-2xl font-bold transition-colors shadow-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-rotate-right"></i> Kosongkan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>

</div>

@endsection

@push('scripts')
{{-- JAVASCRIPT VALIDASI (TIDAK ADA LOGIC YANG DIUBAH DARI VERSI ASLI) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const permohonanForm = document.getElementById('permohonanForm');
    const submitBtn = document.getElementById('submitBtn');
    const nikInput = document.getElementById('nik');
    const teleponInput = document.getElementById('telepon');
    const keperluanInput = document.getElementById('keperluan');

    const fileKtp = document.getElementById('file_ktp');
    const fileKk = document.getElementById('file_kk');
    const filePendukung = document.getElementById('file_pendukung');

    let isSubmitting = false;
    const MAX_FILE_SIZE = 4 * 1024 * 1024;

    function showMessage(message) {
        // Diganti menggunakan SweetAlert2 yang sudah diinisialisasi di layouts.public
        if(typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
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

    // Export function ke global (window) agar bisa dipanggil onclick html
    window.resetPermohonanForm = function() {
        if (!permohonanForm) return;

        permohonanForm.reset();
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Kirim Permohonan';
        isSubmitting = false;
    };

    function sanitizeNumericInput(input) {
        if (!input) return;
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    function sanitizePhoneInput(input) {
        if (!input) return;
        input.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    }

    function validateFile(fileInput, label) {
        if (!fileInput || !fileInput.files.length) {
            return true;
        }

        const file = fileInput.files[0];

        if (file.size > MAX_FILE_SIZE) {
            showMessage(`${label} melebihi batas 4MB.`);
            return false;
        }

        return true;
    }

    // Update Label UI saat file dipilih (Visual Feedback UI)
    [fileKtp, fileKk, filePendukung].forEach(input => {
        if(!input) return;
        input.addEventListener('change', function(e) {
            if(e.target.files.length > 0) {
                let fileName = e.target.files[0].name;
                // Ambil elemen tag 'p' yang merupakan judul file (sibling)
                let titleElement = e.target.nextElementSibling.querySelector('p.text-sm');
                if(titleElement) {
                    titleElement.innerText = fileName;
                    titleElement.classList.replace('text-slate-700', 'text-blue-600');
                }
            }
        });
    });

    sanitizeNumericInput(nikInput);
    sanitizePhoneInput(teleponInput);

    if (permohonanForm) {
        permohonanForm.addEventListener('submit', function (e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }

            const nama = permohonanForm.querySelector('[name="nama"]').value.trim();
            const nik = nikInput.value.trim();
            const telepon = teleponInput.value.trim();
            const alamat = permohonanForm.querySelector('[name="alamat"]').value.trim();
            const keperluan = keperluanInput.value.trim();

            if (!nama) { e.preventDefault(); showMessage('Nama lengkap wajib diisi.'); return; }
            if (!nik) { e.preventDefault(); showMessage('NIK wajib diisi.'); return; }
            if (!telepon) { e.preventDefault(); showMessage('Nomor telepon wajib diisi.'); return; }
            if (!alamat) { e.preventDefault(); showMessage('Alamat wajib diisi.'); return; }

            if (keperluan.length < 20) {
                e.preventDefault();
                showMessage('Keperluan minimal 20 karakter agar jelas bagi petugas.');
                return;
            }

            if (!fileKtp.files.length) { e.preventDefault(); showMessage('File KTP wajib diupload.'); return; }
            if (!fileKk.files.length) { e.preventDefault(); showMessage('File KK wajib diupload.'); return; }

            if (!validateFile(fileKtp, 'File KTP')) { e.preventDefault(); return; }
            if (!validateFile(fileKk, 'File KK')) { e.preventDefault(); return; }
            if (!validateFile(filePendukung, 'File pendukung')) { e.preventDefault(); return; }

            isSubmitting = true;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
        });
    }
});
</script>
@endpush