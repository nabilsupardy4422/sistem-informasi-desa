@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Data Penduduk
            </h1>

            <p class="text-slate-500 text-lg">
                Kelola statistik jumlah penduduk desa per tahun.
            </p>
        </div>

        <button
            type="button"
            onclick="openCreateModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-semibold shadow-sm transition">
            + Tambah Data
        </button>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Record
            </p>

            <h3 id="totalRecord" class="text-3xl font-black text-blue-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Penduduk
            </p>

            <h3 id="totalPenduduk" class="text-3xl font-black text-emerald-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Laki-laki
            </p>

            <h3 id="totalLaki" class="text-3xl font-black text-sky-600">
                0
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-sm text-slate-500 mb-3 font-medium">
                Total Perempuan
            </p>

            <h3 id="totalPerempuan" class="text-3xl font-black text-pink-600">
                0
            </h3>
        </div>

    </div>

    {{-- SEARCH --}}
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-8">
        <input
            id="searchInput"
            type="text"
            placeholder="Cari berdasarkan tahun..."
            class="w-full border border-slate-300 rounded-2xl px-6 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Tahun
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Laki-laki
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Perempuan
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            Total
                        </th>
                        <th class="px-6 py-5 text-left text-sm font-black uppercase text-slate-600">
                            KK
                        </th>
                        <th class="px-6 py-5 text-center text-sm font-black uppercase text-slate-600">
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody id="pendudukTable">

                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-slate-500">
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
    id="pendudukModal"
    class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-6">

    <div class="bg-white rounded-3xl w-full max-w-2xl shadow-2xl">

        <div class="p-8 border-b border-slate-200 flex items-center justify-between">

            <h2 id="modalTitle" class="text-3xl font-black text-slate-800">
                Tambah Data Penduduk
            </h2>

            <button
                onclick="closeModal()"
                class="text-slate-500 hover:text-red-600 text-3xl">
                ×
            </button>

        </div>

        <form id="pendudukForm" class="p-8 space-y-6">

            @csrf

            <input type="hidden" id="pendudukId">

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Tahun
                </label>

                <input
                    id="tahun"
                    type="number"
                    min="1900"
                    max="2100"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                        Jumlah Laki-laki
                    </label>

                    <input
                        id="jumlah_laki"
                        type="number"
                        min="0"
                        class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                        Jumlah Perempuan
                    </label>

                    <input
                        id="jumlah_perempuan"
                        type="number"
                        min="0"
                        class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            <div>
                <label class="block text-sm font-black uppercase text-slate-600 mb-3">
                    Jumlah KK
                </label>

                <input
                    id="jumlah_kk"
                    type="number"
                    min="0"
                    class="w-full border border-slate-300 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                <p class="text-sm text-slate-500 mb-2 font-medium">
                    Preview Total Penduduk
                </p>

                <h3 id="previewTotal" class="text-3xl font-black text-blue-600">
                    0
                </h3>
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

    const pendudukTable = document.getElementById('pendudukTable');
    const pendudukModal = document.getElementById('pendudukModal');

    const pendudukId = document.getElementById('pendudukId');
    const tahunInput = document.getElementById('tahun');
    const lakiInput = document.getElementById('jumlah_laki');
    const perempuanInput = document.getElementById('jumlah_perempuan');
    const kkInput = document.getElementById('jumlah_kk');

    const modalTitle = document.getElementById('modalTitle');
    const saveBtn = document.getElementById('saveBtn');

    const totalRecord = document.getElementById('totalRecord');
    const totalPenduduk = document.getElementById('totalPenduduk');
    const totalLaki = document.getElementById('totalLaki');
    const totalPerempuan = document.getElementById('totalPerempuan');
    const previewTotal = document.getElementById('previewTotal');
    const searchInput = document.getElementById('searchInput');

    let pendudukData = [];
    let isSaving = false;

    function safeJsonParse(text) {
        try {
            return JSON.parse(text);
        } catch {
            return {
                success: false,
                message: 'Response server tidak valid.'
            };
        }
    }

    async function safeJson(response) {
        const text = await response.text();
        return safeJsonParse(text);
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '';

        return String(text)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatNumber(number) {
        return Number(number || 0).toLocaleString('id-ID');
    }

    function updatePreview() {
        const laki = Number(lakiInput.value || 0);
        const perempuan = Number(perempuanInput.value || 0);

        previewTotal.textContent = formatNumber(laki + perempuan);
    }

    function updateStats(data) {
        totalRecord.textContent = formatNumber(data.length);

        totalPenduduk.textContent = formatNumber(
            data.reduce((sum, item) => sum + Number(item.jumlah_penduduk || 0), 0)
        );

        totalLaki.textContent = formatNumber(
            data.reduce((sum, item) => sum + Number(item.jumlah_laki || 0), 0)
        );

        totalPerempuan.textContent = formatNumber(
            data.reduce((sum, item) => sum + Number(item.jumlah_perempuan || 0), 0)
        );
    }

    function renderTable(data) {
        if (!data.length) {
            pendudukTable.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                        Tidak ada data penduduk.
                    </td>
                </tr>
            `;
            return;
        }

        pendudukTable.innerHTML = data.map(item => `
            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                <td class="px-6 py-5 font-black text-slate-800">
                    ${escapeHtml(item.tahun)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${formatNumber(item.jumlah_laki)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${formatNumber(item.jumlah_perempuan)}
                </td>

                <td class="px-6 py-5 font-bold text-blue-600">
                    ${formatNumber(item.jumlah_penduduk)}
                </td>

                <td class="px-6 py-5 text-slate-600">
                    ${formatNumber(item.jumlah_kk)}
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
        pendudukTable.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                    Memuat data...
                </td>
            </tr>
        `;

        try {
            const response = await fetch("{{ route('admin.penduduk.data') }}");
            const result = await safeJson(response);

            if (!result.success) {
                throw result;
            }

            pendudukData = result.data || [];

            updateStats(pendudukData);
            renderTable(pendudukData);

        } catch (error) {
            pendudukTable.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-red-500">
                        Gagal memuat data.
                    </td>
                </tr>
            `;
        }
    }

    function openCreateModal() {
    pendudukId.value = '';
    tahunInput.value = '';
    lakiInput.value = '';
    perempuanInput.value = '';
    kkInput.value = '';

    updatePreview();

    modalTitle.textContent = 'Tambah Data Penduduk';
    saveBtn.textContent = 'Simpan';
    saveBtn.disabled = false;

    isSaving = false;

    pendudukModal.classList.remove('hidden');
}

function closeModal() {
    pendudukModal.classList.add('hidden');

    isSaving = false;
    saveBtn.disabled = false;
    saveBtn.textContent = 'Simpan';
}

async function editData(id) {
    try {
        const response = await fetch(`/admin/penduduk/${id}`);
        const result = await safeJson(response);

        if (!result.success) {
            throw result;
        }

        const item = result.data;

        pendudukId.value = item.id;
        tahunInput.value = item.tahun || '';
        lakiInput.value = item.jumlah_laki || '';
        perempuanInput.value = item.jumlah_perempuan || '';
        kkInput.value = item.jumlah_kk || '';

        updatePreview();

        modalTitle.textContent = 'Edit Data Penduduk';
        saveBtn.textContent = 'Update';

        pendudukModal.classList.remove('hidden');

    } catch (error) {
        alert(error.message || 'Gagal mengambil data.');
    }
}

async function saveData() {
    if (isSaving) return;

    const tahun = tahunInput.value.trim();
    const jumlahLaki = lakiInput.value.trim();
    const jumlahPerempuan = perempuanInput.value.trim();
    const jumlahKk = kkInput.value.trim();

    if (!tahun) {
        alert('Tahun wajib diisi.');
        return;
    }

    if (!jumlahLaki) {
        alert('Jumlah laki-laki wajib diisi.');
        return;
    }

    if (!jumlahPerempuan) {
        alert('Jumlah perempuan wajib diisi.');
        return;
    }

    if (!jumlahKk) {
        alert('Jumlah KK wajib diisi.');
        return;
    }

    isSaving = true;
    saveBtn.disabled = true;
    saveBtn.textContent = 'Menyimpan...';

    try {
        const payload = {
            tahun,
            jumlah_laki: jumlahLaki,
            jumlah_perempuan: jumlahPerempuan,
            jumlah_kk: jumlahKk
        };

        const id = pendudukId.value;
        let url = "{{ route('admin.penduduk.store') }}";
        let method = 'POST';

        if (id) {
            url = `/admin/penduduk/${id}`;
            payload._method = 'PUT';
        }

        const response = await fetch(url, {
            method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
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
        saveBtn.textContent = pendudukId.value ? 'Update' : 'Simpan';
    }
}

async function deleteData(id) {
    const confirmed = confirm(
        'Yakin ingin menghapus data penduduk ini?\n\nAksi ini tidak dapat dibatalkan.'
    );

    if (!confirmed) return;

    try {
        const response = await fetch(`/admin/penduduk/${id}`, {
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

    const filtered = pendudukData.filter(item =>
        String(item.tahun).toLowerCase().includes(keyword)
    );

    renderTable(filtered);
});

lakiInput.addEventListener('input', updatePreview);
perempuanInput.addEventListener('input', updatePreview);

window.addEventListener('click', function (e) {
    if (e.target === pendudukModal) {
        closeModal();
    }
});

loadData();
</script>

@endsection