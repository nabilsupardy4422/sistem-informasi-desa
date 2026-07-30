@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Manajemen UMKM
            </h1>
  
            <p class="text-slate-500 text-lg">
                Kelola data usaha mikro, kecil, dan menengah desa.
            </p>
        </div>

        <button
            type="button"
            onclick="openCreateModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-sm transition">
            + Tambah UMKM
        </button>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total UMKM
            </p>

            <h3 id="totalUmkm" class="text-3xl font-black text-blue-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Dengan Foto
            </p>

            <h3 id="withPhoto" class="text-3xl font-black text-emerald-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Tanpa Foto
            </p>

            <h3 id="withoutPhoto" class="text-3xl font-black text-orange-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Pemilik
            </p>

            <h3 id="totalOwner" class="text-3xl font-black text-purple-600">
                0
            </h3>
        </div>

    </div>

    {{-- SEARCH --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-8">
        <input
            id="searchInput"
            type="text"
            placeholder="Cari nama UMKM / pemilik..."
            class="w-full border border-slate-300 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Foto
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Nama UMKM
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Pemilik
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            No HP
                        </th>
                        <th class="px-6 py-5 text-center text-sm font-black uppercase text-slate-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody id="umkmTable">

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
    id="umkmModal"
    class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl w-full max-w-3xl shadow-2xl max-h-[90vh] overflow-y-auto">

        <div class="p-8 border-b border-slate-200 flex items-center justify-between">

            <h2 id="modalTitle" class="text-3xl font-black text-slate-800">
                Tambah UMKM
            </h2>

            <button
                onclick="closeModal()"
                class="text-slate-500 hover:text-red-600 text-3xl">
                ×
            </button>

        </div>

        <form id="umkmForm" class="p-8 space-y-6" enctype="multipart/form-data">

            @csrf

            <input type="hidden" id="umkmId">

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Nama UMKM
                </label>

                <input
                    id="nama_umkm"
                    type="text"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Nama Pemilik
                </label>

                <input
                    id="pemilik"
                    type="text"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Nomor HP
                </label>

                <input
                    id="no_hp"
                    type="text"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Alamat
                </label>

                <textarea
                    id="alamat"
                    rows="3"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Deskripsi
                </label>

                <textarea
                    id="deskripsi"
                    rows="5"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Foto
                </label>

                <input
                    id="foto"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4">

                <div id="previewContainer" class="hidden mt-5">
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

    const umkmTable = document.getElementById('umkmTable');
    const umkmModal = document.getElementById('umkmModal');

    const umkmId = document.getElementById('umkmId');
    const namaInput = document.getElementById('nama_umkm');
    const pemilikInput = document.getElementById('pemilik');
    const noHpInput = document.getElementById('no_hp');
    const alamatInput = document.getElementById('alamat');
    const deskripsiInput = document.getElementById('deskripsi');
    const fotoInput = document.getElementById('foto');

    const modalTitle = document.getElementById('modalTitle');
    const saveBtn = document.getElementById('saveBtn');

    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    const totalUmkm = document.getElementById('totalUmkm');
    const withPhoto = document.getElementById('withPhoto');
    const withoutPhoto = document.getElementById('withoutPhoto');
    const totalOwner = document.getElementById('totalOwner');
    const searchInput = document.getElementById('searchInput');

    let umkmData = [];
    let isSaving = false;

    function escapeHtml(text) {
        if (!text) return '';

        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    async function safeJson(response) {
        const text = await response.text();

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
        totalUmkm.textContent = data.length;
        withPhoto.textContent = data.filter(item => item.foto).length;
        withoutPhoto.textContent = data.filter(item => !item.foto).length;
        totalOwner.textContent = data.length;
    }

    function renderTable(data) {
        if (!data.length) {
            umkmTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                        Tidak ada data UMKM.
                    </td>
                </tr>
            `;
            return;
        }

        umkmTable.innerHTML = data.map(item => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                <td class="px-6 py-5">
                    ${
                        item.foto
                        ? `<img src="/storage/${item.foto}" class="w-24 h-16 object-cover rounded-xl border border-slate-200">`
                        : `<div class="w-24 h-16 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">-</div>`
                    }
                </td>

                <td class="px-6 py-5 font-black text-slate-800">
                    ${escapeHtml(item.nama_umkm)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${escapeHtml(item.pemilik)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${escapeHtml(item.no_hp)}
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
        umkmTable.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                    Memuat data...
                </td>
            </tr>
        `;

        try {
            const response = await fetch("{{ route('admin.umkm.data') }}");
            const result = await safeJson(response);

            if (!result.success) throw result;

            umkmData = result.data || [];

            updateStats(umkmData);
            renderTable(umkmData);

        } catch (error) {
            umkmTable.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-red-500">
                        Gagal memuat data UMKM.
                    </td>
                </tr>
            `;
        }
    }

    function openCreateModal() {
        umkmId.value = '';
        namaInput.value = '';
        pemilikInput.value = '';
        noHpInput.value = '';
        alamatInput.value = '';
        deskripsiInput.value = '';
        fotoInput.value = '';

        previewContainer.classList.add('hidden');
        previewImage.src = '';

        modalTitle.textContent = 'Tambah UMKM';
        saveBtn.textContent = 'Simpan';
        saveBtn.disabled = false;

        isSaving = false;

        umkmModal.classList.remove('hidden');
    }

    function closeModal() {
        umkmModal.classList.add('hidden');

        isSaving = false;
        saveBtn.disabled = false;
        saveBtn.textContent = 'Simpan';
    }

    fotoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            previewContainer.classList.add('hidden');
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
        const response = await fetch(`/admin/umkm/${id}`);
        const result = await safeJson(response);

        if (!result.success) {
            throw result;
        }

        const item = result.data;

        umkmId.value = item.id;
        namaInput.value = item.nama_umkm || '';
        pemilikInput.value = item.pemilik || '';
        noHpInput.value = item.no_hp || '';
        alamatInput.value = item.alamat || '';
        deskripsiInput.value = item.deskripsi || '';
        fotoInput.value = '';

        if (item.foto) {
            previewImage.src = `/storage/${item.foto}`;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
            previewImage.src = '';
        }

        modalTitle.textContent = 'Edit UMKM';
        saveBtn.textContent = 'Update';

        umkmModal.classList.remove('hidden');

    } catch (error) {
        alert(error.message || 'Gagal mengambil data.');
    }
}

async function saveData() {
    if (isSaving) return;

    const nama = namaInput.value.trim();
    const pemilik = pemilikInput.value.trim();
    const noHp = noHpInput.value.trim();
    const alamat = alamatInput.value.trim();
    const deskripsi = deskripsiInput.value.trim();

    if (!nama) {
        alert('Nama UMKM wajib diisi.');
        return;
    }

    if (!pemilik) {
        alert('Nama pemilik wajib diisi.');
        return;
    }

    if (!alamat) {
        alert('Alamat wajib diisi.');
        return;
    }

    if (!/^[0-9+\-\s]{8,20}$/.test(noHp)) {
        alert('Format nomor HP tidak valid.');
        return;
    }

    isSaving = true;
    saveBtn.disabled = true;
    saveBtn.textContent = 'Menyimpan...';

    try {
        const formData = new FormData();

        formData.append('nama_umkm', nama);
        formData.append('pemilik', pemilik);
        formData.append('no_hp', noHp);
        formData.append('alamat', alamat);
        formData.append('deskripsi', deskripsi);
        formData.append('_token', csrfToken);

        if (fotoInput.files[0]) {
            formData.append('foto', fotoInput.files[0]);
        }

        const id = umkmId.value;
        let url = "{{ route('admin.umkm.store') }}";

        if (id) {
            url = `/admin/umkm/${id}`;
            formData.append('_method', 'PUT');
        }

        const response = await fetch(url, {
            method: 'POST',
            body: formData
        });

        const result = await safeJson(response);

        if (!response.ok || !result.success) {
            throw result;
        }

        closeModal();
        await loadData();

        alert(result.message || 'Data berhasil disimpan.');

    } catch (error) {
        alert(error.message || 'Gagal menyimpan data.');

        isSaving = false;
        saveBtn.disabled = false;
        saveBtn.textContent = umkmId.value ? 'Update' : 'Simpan';
    }
}

async function deleteData(id) {
    const confirmed = confirm(
        'Yakin ingin menghapus data UMKM ini?\n\nFoto terkait juga akan dihapus.'
    );

    if (!confirmed) return;

    try {
        const response = await fetch(`/admin/umkm/${id}`, {
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

        alert(result.message || 'Data berhasil dihapus.');

    } catch (error) {
        alert(error.message || 'Gagal menghapus data.');
    }
}

searchInput.addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();

    const filtered = umkmData.filter(item =>
        String(item.nama_umkm || '').toLowerCase().includes(keyword) ||
        String(item.pemilik || '').toLowerCase().includes(keyword)
    );

    renderTable(filtered);
});

window.addEventListener('click', function (e) {
    if (e.target === umkmModal) {
        closeModal();
    }
});

loadData();
</script>

@endsection