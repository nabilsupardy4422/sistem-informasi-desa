@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Manajemen Berita
            </h1>

            <p class="text-slate-500 text-lg">
                Kelola berita dan informasi terbaru untuk website desa.
            </p>
        </div>

        <button
            type="button"
            onclick="openCreateModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-sm transition">
            + Tambah Berita
        </button>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Berita
            </p>

            <h3
                id="totalBerita"
                class="text-3xl font-black text-blue-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Dengan Gambar
            </p>

            <h3
                id="withImage"
                class="text-3xl font-black text-emerald-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Tanpa Gambar
            </p>

            <h3
                id="withoutImage"
                class="text-3xl font-black text-orange-600">
                0
            </h3>
        </div>

    </div>

    {{-- SEARCH --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-8">
        <input
            id="searchInput"
            type="text"
            placeholder="Cari berita..."
            class="w-full border border-slate-300 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm font-black text-slate-600 uppercase">
                            Gambar
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black text-slate-600 uppercase">
                            Judul
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black text-slate-600 uppercase">
                            Isi
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black text-slate-600 uppercase">
                            Dibuat
                        </th>
                        <th class="px-6 py-5 text-center text-sm font-black text-slate-600 uppercase">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody
                    id="beritaTable"
                    class="divide-y divide-slate-100">

                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                            Memuat data...
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- MODAL --}}
<div
    id="beritaModal"
    class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl w-full max-w-3xl shadow-2xl max-h-[90vh] overflow-y-auto">

        <div class="p-8 border-b border-slate-200 flex items-center justify-between">

            <h2
                id="modalTitle"
                class="text-3xl font-black text-slate-800">
                Tambah Berita
            </h2>

            <button
                onclick="closeModal()"
                class="text-slate-500 hover:text-red-600 text-3xl">
                ×
            </button>

        </div>

        <form
            id="beritaForm"
            class="p-8 space-y-6"
            enctype="multipart/form-data">

            @csrf

            <input type="hidden" id="beritaId">

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Judul
                </label>

                <input
                    id="judul"
                    type="text"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Isi Berita
                </label>

                <textarea
                    id="isi"
                    rows="8"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Gambar
                </label>

                <input
                    id="gambar"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4">

                <div
                    id="previewContainer"
                    class="hidden mt-5">
                    <img
                        id="previewImage"
                        class="w-48 h-32 object-cover rounded-2xl border border-slate-200">
                </div>
            </div>

            <div class="flex gap-4 pt-4">

                <button
                    id="saveBtn"
                    type="button"
                    onclick="saveData()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold transition">
                    Simpan
                </button>

                <button
                    type="button"
                    onclick="closeModal()"
                    class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-8 py-4 rounded-2xl font-semibold transition">
                    Batal
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    const csrfToken = '{{ csrf_token() }}';

    const beritaTable = document.getElementById('beritaTable');
    const beritaModal = document.getElementById('beritaModal');
    const beritaForm = document.getElementById('beritaForm');

    const beritaId = document.getElementById('beritaId');
    const judulInput = document.getElementById('judul');
    const isiInput = document.getElementById('isi');
    const gambarInput = document.getElementById('gambar');

    const modalTitle = document.getElementById('modalTitle');
    const saveBtn = document.getElementById('saveBtn');

    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    const totalBerita = document.getElementById('totalBerita');
    const withImage = document.getElementById('withImage');
    const withoutImage = document.getElementById('withoutImage');
    const searchInput = document.getElementById('searchInput');

    let beritaData = [];
    let isSaving = false;

    function escapeHtml(text) {
        if (!text) return '';

        return text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function truncateText(text, limit = 120) {
        if (!text) return '-';

        return text.length > limit
            ? text.substring(0, limit) + '...'
            : text;
    }

    async function safeJson(response) {
        const text = await response.text();

        if (!text) return {};

        try {
            return JSON.parse(text);
        } catch {
            return {
                success: false,
                message: 'Response server tidak valid.'
            };
        }
    }

    function updateStats(data) {
        totalBerita.textContent = data.length;
        withImage.textContent = data.filter(item => item.gambar).length;
        withoutImage.textContent = data.filter(item => !item.gambar).length;
    }

    function renderTable(data) {
        if (!data.length) {
            beritaTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                        Tidak ada data berita.
                    </td>
                </tr>
            `;
            return;
        }

        beritaTable.innerHTML = data.map(item => `
            <tr class="hover:bg-slate-50 transition">
                <td class="px-6 py-5">
                    ${
                        item.gambar
                        ? `<img src="/storage/${item.gambar}" class="w-24 h-16 object-cover rounded-xl border border-slate-200">`
                        : `<div class="w-24 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">-</div>`
                    }
                </td>

                <td class="px-6 py-5 font-bold text-slate-800">
                    ${escapeHtml(item.judul)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${escapeHtml(truncateText(item.isi))}
                </td>

                <td class="px-6 py-5 text-slate-500">
                    ${new Date(item.created_at).toLocaleString('id-ID')}
                </td>

                <td class="px-6 py-5">
                    <div class="flex justify-center gap-3">
                        <button
                            onclick="editData(${item.id})"
                            class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl font-semibold">
                            Edit
                        </button>

                        <button
                            onclick="deleteData(${item.id})"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold">
                            Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    async function loadData() {
        beritaTable.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                    Memuat data...
                </td>
            </tr>
        `;

        try {
            const response = await fetch("{{ route('admin.berita.data') }}");
            const result = await safeJson(response);

            if (!result.success) {
                throw result;
            }

            beritaData = result.data || [];

            updateStats(beritaData);
            renderTable(beritaData);

        } catch (error) {
            beritaTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-red-500">
                        Gagal memuat data berita.
                    </td>
                </tr>
            `;
        }
    }

    function openCreateModal() {
        beritaId.value = '';
        judulInput.value = '';
        isiInput.value = '';
        gambarInput.value = '';

        previewContainer.classList.add('hidden');
        previewImage.src = '';

        modalTitle.textContent = 'Tambah Berita';
        saveBtn.textContent = 'Simpan';

        beritaModal.classList.remove('hidden');
    }

    function closeModal() {
        beritaModal.classList.add('hidden');
        isSaving = false;
        saveBtn.disabled = false;
        saveBtn.textContent = 'Simpan';
    }

    gambarInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            previewContainer.classList.add('hidden');
            previewImage.src = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran gambar maksimal 2MB.');
            this.value = '';
            return;
        }

        previewImage.src = URL.createObjectURL(file);
        previewContainer.classList.remove('hidden');
    });

    async function editData(id) {
    try {
        const response = await fetch(`/admin/berita/${id}`);
        const result = await safeJson(response);

        if (!result.success) {
            throw result;
        }

        const item = result.data;

        beritaId.value = item.id;
        judulInput.value = item.judul || '';
        isiInput.value = item.isi || '';
        gambarInput.value = '';

        if (item.gambar) {
            previewImage.src = `/storage/${item.gambar}`;
            previewContainer.classList.remove('hidden');
        } else {
            previewImage.src = '';
            previewContainer.classList.add('hidden');
        }

        modalTitle.textContent = 'Edit Berita';
        saveBtn.textContent = 'Update';

        beritaModal.classList.remove('hidden');

    } catch (error) {
        alert(error.message || 'Gagal mengambil data berita.');
    }
}

async function saveData() {
    if (isSaving) return;

    const judul = judulInput.value.trim();
    const isi = isiInput.value.trim();

    if (!judul) {
        alert('Judul berita wajib diisi.');
        return;
    }

    if (isi.length < 20) {
        alert('Isi berita minimal 20 karakter.');
        return;
    }

    isSaving = true;
    saveBtn.disabled = true;
    saveBtn.textContent = 'Menyimpan...';

    try {
        const formData = new FormData();

        formData.append('judul', judul);
        formData.append('isi', isi);

        if (gambarInput.files.length) {
            formData.append('gambar', gambarInput.files[0]);
        }

        const id = beritaId.value;
        let url = "{{ route('admin.berita.store') }}";

        if (id) {
            formData.append('_method', 'PUT');
            url = `/admin/berita/${id}`;
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        });

        const result = await safeJson(response);

        if (!response.ok || !result.success) {
            throw result;
        }

        closeModal();
        await loadData();

        alert(result.message || 'Berita berhasil disimpan.');

    } catch (error) {
        alert(error.message || 'Gagal menyimpan berita.');

        isSaving = false;
        saveBtn.disabled = false;
        saveBtn.textContent = beritaId.value ? 'Update' : 'Simpan';
    }
}

async function deleteData(id) {
    const confirmed = confirm(
        'Yakin ingin menghapus berita ini?\n\nAksi ini tidak dapat dibatalkan.'
    );

    if (!confirmed) return;

    try {
        const response = await fetch(`/admin/berita/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });

        const result = await safeJson(response);

        if (!response.ok || !result.success) {
            throw result;
        }

        await loadData();

        alert(result.message || 'Berita berhasil dihapus.');

    } catch (error) {
        alert(error.message || 'Gagal menghapus berita.');
    }
}

searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();

    const filtered = beritaData.filter(item =>
        (item.judul || '').toLowerCase().includes(keyword) ||
        (item.isi || '').toLowerCase().includes(keyword)
    );

    renderTable(filtered);
});

window.addEventListener('click', function (e) {
    if (e.target === beritaModal) {
        closeModal();
    }
});

loadData();
</script>

@endsection