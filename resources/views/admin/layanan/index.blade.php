@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-3">
                Manajemen Layanan
            </h1>

            <p class="text-slate-400 text-lg">
                Kelola layanan administrasi desa, persyaratan, estimasi proses, dan status layanan.
            </p>
        </div>

        <button onclick="openCreateModal()"
            class="inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-7 py-4 rounded-2xl font-semibold shadow-xl transition">
            <span class="text-xl">+</span>
            Tambah Layanan
        </button>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Total Layanan
            </p>

            <h3 class="text-5xl font-black text-blue-600">
                {{ $layanans->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Layanan Aktif
            </p>

            <h3 class="text-5xl font-black text-emerald-600">
                {{ $layanans->where('status','aktif')->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Layanan Nonaktif
            </p>

            <h3 class="text-5xl font-black text-red-600">
                {{ $layanans->where('status','nonaktif')->count() }}
            </h3>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Data Layanan
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px] text-sm">

                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-slate-600">
                        <th class="px-6 py-5 text-left font-semibold">Nama Layanan</th>
                        <th class="px-6 py-5 text-left font-semibold">Estimasi</th>
                        <th class="px-6 py-5 text-left font-semibold">Status</th>
                        <th class="px-6 py-5 text-left font-semibold">Dibuat</th>
                        <th class="px-6 py-5 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($layanans as $layanan)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        <td class="px-6 py-6">
                            <div class="font-bold text-slate-800 text-base">
                                {{ $layanan->nama_layanan }}
                            </div>

                            <div class="text-sm text-slate-500 mt-2">
                                {{ \Illuminate\Support\Str::limit($layanan->deskripsi, 100) }}
                            </div>
                        </td>

                        <td class="px-6 py-6 text-slate-700 font-medium">
                            {{ $layanan->estimasi_hari }} Hari
                        </td>

                        <td class="px-6 py-6">
                            @if($layanan->status === 'aktif')
                                <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-semibold">
                                    Aktif
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-semibold">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-6 text-slate-600 font-medium">
                            {{ $layanan->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex flex-wrap justify-center gap-3">

                                <button onclick="showDetail({{ $layanan->id }})"
                                    class="px-4 py-2 rounded-xl bg-slate-600 hover:bg-slate-700 text-white font-semibold transition">
                                    Detail
                                </button>

                                <button onclick="editLayanan({{ $layanan->id }})"
                                    class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition">
                                    Edit
                                </button>

                                <button onclick="toggleStatus({{ $layanan->id }})"
                                    class="px-4 py-2 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold transition">
                                    Toggle
                                </button>

                                <button onclick="deleteLayanan({{ $layanan->id }})"
                                    class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 text-slate-500">
                            Belum ada data layanan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

<!-- MODAL -->
<div id="layananModal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 overflow-y-auto p-6">

<div class="w-full max-w-4xl bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden my-10 mx-auto">

        <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between">

            <div>
                <h2 id="modalTitle" class="text-2xl font-bold text-slate-800">
                    Tambah Layanan
                </h2>

                <p class="text-slate-500 mt-1">
                    Kelola data layanan administrasi desa.
                </p>
            </div>

            <button onclick="closeModal()"
                class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xl transition">
                ✕
            </button>
        </div>

        <input type="hidden" id="layananId">

        <div class="p-8 space-y-6">

            <div>
                <label class="block mb-3 text-sm font-semibold text-slate-700">
                    Nama Layanan
                </label>

                <input
                    type="text"
                    id="nama_layanan"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block mb-3 text-sm font-semibold text-slate-700">
                    Deskripsi
                </label>

                <textarea
                    id="deskripsi"
                    rows="5"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block mb-3 text-sm font-semibold text-slate-700">
                    Persyaratan
                </label>

                <textarea
                    id="persyaratan"
                    rows="5"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="block mb-3 text-sm font-semibold text-slate-700">
                        Estimasi Hari
                    </label>

                    <input
                        type="number"
                        id="estimasi_hari"
                        min="1"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block mb-3 text-sm font-semibold text-slate-700">
                        Status
                    </label>

                    <select
                        id="status"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

        </div>

        <div class="px-8 py-6 border-t border-slate-200 flex gap-4">

            <button id="saveBtn"
                type="button"
                onclick="saveLayanan()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-xl transition">
                Simpan
            </button>

            <button type="button"
                onclick="closeModal()"
                class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-8 py-4 rounded-2xl font-semibold transition">
                Batal
            </button>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const csrf = '{{ csrf_token() }}';
let isSaving = false;

function showLoading(message = 'Loading...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => Swal.showLoading()
    });
}

function closeLoading() {
    Swal.close();
}

function showSuccess(message = 'Berhasil') {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: message,
        timer: 1800,
        showConfirmButton: false
    });
}

function showError(message = 'Terjadi kesalahan') {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
    });
}

function confirmDelete(callback) {
    Swal.fire({
        title: 'Hapus data?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

function resetForm() {
    document.getElementById('layananId').value = '';
    document.getElementById('nama_layanan').value = '';
    document.getElementById('deskripsi').value = '';
    document.getElementById('persyaratan').value = '';
    document.getElementById('estimasi_hari').value = 1;
    document.getElementById('status').value = 'aktif';
}

function openCreateModal() {
    resetForm();
    document.getElementById('modalTitle').innerText = 'Tambah Layanan';
    document.getElementById('layananModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('layananModal').classList.add('hidden');
}

async function showDetail(id) {
    try {
        showLoading('Memuat detail...');

        const res = await fetch(`/admin/layanan/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Gagal memuat detail');
        }

        closeLoading();

        Swal.fire({
            title: data.nama_layanan,
            width: 700,
            html: `
                <div class="text-left space-y-4">
                    <div>
                        <strong>Estimasi:</strong><br>${data.estimasi_hari} hari
                    </div>
                    <div>
                        <strong>Status:</strong><br>${data.status}
                    </div>
                    <div>
                        <strong>Deskripsi:</strong><br>${data.deskripsi || '-'}
                    </div>
                    <div>
                        <strong>Persyaratan:</strong><br>${data.persyaratan || '-'}
                    </div>
                </div>
            `
        });

    } catch (err) {
        closeLoading();
        showError(err.message);
    }
}

async function editLayanan(id) {
    try {
        showLoading('Memuat data...');

        const res = await fetch(`/admin/layanan/${id}`, {
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Gagal memuat data');
        }

        closeLoading();

        document.getElementById('modalTitle').innerText = 'Edit Layanan';
        document.getElementById('layananId').value = data.id;
        document.getElementById('nama_layanan').value = data.nama_layanan || '';
        document.getElementById('deskripsi').value = data.deskripsi || '';
        document.getElementById('persyaratan').value = data.persyaratan || '';
        document.getElementById('estimasi_hari').value = data.estimasi_hari || 1;
        document.getElementById('status').value = data.status || 'aktif';

        document.getElementById('layananModal').classList.remove('hidden');

    } catch (err) {
        closeLoading();
        showError(err.message);
    }
}

async function saveLayanan() {
    if (isSaving) return;

    const nama = document.getElementById('nama_layanan').value.trim();

    if (!nama) {
        showError('Nama layanan wajib diisi');
        return;
    }

    try {
        isSaving = true;

        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        showLoading('Menyimpan data...');

        const id = document.getElementById('layananId').value;

        const payload = {
            nama_layanan: nama,
            deskripsi: document.getElementById('deskripsi').value,
            persyaratan: document.getElementById('persyaratan').value,
            estimasi_hari: document.getElementById('estimasi_hari').value,
            status: document.getElementById('status').value
        };

        const res = await fetch(id ? `/admin/layanan/${id}` : '/admin/layanan', {
            method: id ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (!res.ok) {
            throw new Error(data.message || 'Gagal menyimpan');
        }

        closeLoading();
        closeModal();
        showSuccess(data.message || 'Data berhasil disimpan');

        setTimeout(() => location.reload(), 1000);

    } catch (err) {
        closeLoading();
        showError(err.message);
    } finally {
        isSaving = false;

        const btn = document.getElementById('saveBtn');
        btn.disabled = false;
        btn.textContent = 'Simpan';
    }
}

function toggleStatus(id) {
    Swal.fire({
        title: 'Toggle status layanan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then(async (result) => {
        if (!result.isConfirmed) return;

        try {
            showLoading('Memproses...');

            const res = await fetch(`/admin/layanan/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.message || 'Gagal toggle status');
            }

            closeLoading();
            showSuccess(data.message || 'Status diperbarui');

            setTimeout(() => location.reload(), 1000);

        } catch (err) {
            closeLoading();
            showError(err.message);
        }
    });
}

function deleteLayanan(id) {
    confirmDelete(async () => {
        try {
            showLoading('Menghapus data...');

            const res = await fetch(`/admin/layanan/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });

            const data = await res.json();

            if (!res.ok) {
                throw new Error(data.message || 'Gagal menghapus');
            }

            closeLoading();
            showSuccess(data.message || 'Data berhasil dihapus');

            setTimeout(() => location.reload(), 1000);

        } catch (err) {
            closeLoading();
            showError(err.message);
        }
    });
}
</script>

@endsection