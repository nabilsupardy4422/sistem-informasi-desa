@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

        <div>
            <a href="{{ route('admin.apbdes.index') }}"
               class="inline-flex items-center gap-2 text-blue-500 hover:text-blue-600 font-semibold mb-4 transition">
                ← Kembali ke APBDes
            </a>

            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Detail APBDes {{ $apbdes->tahun }}
            </h1>

            <p class="text-slate-500 text-lg">
                Kelola rincian transaksi APBDes desa.
            </p>
        </div>

        <button onclick="openModal()"
            class="inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-7 py-4 rounded-2xl font-semibold shadow-xl transition">
            <span class="text-xl">+</span>
            Tambah Detail
        </button>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 mb-10">

        <div class="bg-white rounded-3xl border border-emerald-200 shadow-sm p-8">
            <p class="text-slate-500 text-sm font-semibold mb-3">Pendapatan</p>
            <h3 id="sumPendapatan" class="text-2xl font-black text-emerald-600">Rp 0</h3>
        </div>

        <div class="bg-white rounded-3xl border border-red-200 shadow-sm p-8">
            <p class="text-slate-500 text-sm font-semibold mb-3">Belanja</p>
            <h3 id="sumBelanja" class="text-2xl font-black text-red-600">Rp 0</h3>
        </div>

        <div class="bg-white rounded-3xl border border-cyan-200 shadow-sm p-8">
            <p class="text-slate-500 text-sm font-semibold mb-3">Pembiayaan Masuk</p>
            <h3 id="sumMasuk" class="text-2xl font-black text-cyan-600">Rp 0</h3>
        </div>

        <div class="bg-white rounded-3xl border border-amber-200 shadow-sm p-8">
            <p class="text-slate-500 text-sm font-semibold mb-3">Pembiayaan Keluar</p>
            <h3 id="sumKeluar" class="text-2xl font-black text-amber-600">Rp 0</h3>
        </div>

        <div class="bg-white rounded-3xl border border-blue-200 shadow-sm p-8">
            <p class="text-slate-500 text-sm font-semibold mb-3">Saldo</p>
            <h3 id="sumSaldo" class="text-2xl font-black text-blue-600">Rp 0</h3>
        </div>

    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 mb-10">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">
                Visualisasi APBDes
            </h2>

            <p class="text-slate-500">
                Ringkasan distribusi transaksi APBDes.
            </p>
        </div>

        <div class="h-[420px]">
            <canvas id="chart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Daftar Detail Transaksi
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1100px]">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Kategori</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Jenis</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Nama Item</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Jumlah</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-500">
                            Memuat data...
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </div>

</div>

<div id="modal"
     class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm items-center justify-center z-50 p-6">

    <div class="w-full max-w-xl bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h3 id="modalTitle" class="text-2xl font-bold text-slate-800">
                Tambah Detail
            </h3>
        </div>

        <div class="p-8 space-y-6">

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Kategori
                </label>

                <select id="kategori"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
                    <option value="pendapatan">Pendapatan</option>
                    <option value="belanja">Belanja</option>
                    <option value="pembiayaan">Pembiayaan</option>
                </select>
            </div>

            <div id="jenisWrapper" class="hidden">
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Jenis Pembiayaan
                </label>

                <select id="jenis"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Nama Item
                </label>

                <input id="nama"
                    type="text"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Jumlah
                </label>

                <input id="jumlah"
                    type="number"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4">
            </div>

        </div>

        <div class="px-8 py-6 border-t border-slate-200 flex gap-4">

            <button onclick="saveData()"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-semibold transition">
                Simpan
            </button>

            <button onclick="closeModal()"
                class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-4 rounded-2xl font-semibold transition">
                Batal
            </button>

        </div>

    </div>

</div>

<script>
let editId = null;
const apbdesId = {{ $apbdes->id }};

const modal = document.getElementById('modal');
const kategori = document.getElementById('kategori');
const jenis = document.getElementById('jenis');
const jenisWrapper = document.getElementById('jenisWrapper');
const nama = document.getElementById('nama');
const jumlah = document.getElementById('jumlah');
const tableBody = document.getElementById('tableBody');

const chart = new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: [
            'Pendapatan',
            'Belanja',
            'Pembiayaan Masuk',
            'Pembiayaan Keluar',
            'Saldo'
        ],
        datasets: [{
            label: 'Nominal',
            data: [0, 0, 0, 0, 0],
            backgroundColor: [
                '#10b981',
                '#ef4444',
                '#06b6d4',
                '#f59e0b',
                '#2563eb'
            ],
            borderRadius: 12
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

function rupiah(nominal) {
    return 'Rp ' + Number(nominal || 0).toLocaleString('id-ID');
}

function resetForm() {
    editId = null;
    nama.value = '';
    jumlah.value = '';
    kategori.value = 'pendapatan';
    jenis.value = 'masuk';
    jenisWrapper.classList.add('hidden');
    document.getElementById('modalTitle').textContent = 'Tambah Detail';
}

function openModal() {
    resetForm();
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

kategori.addEventListener('change', function () {
    if (this.value === 'pembiayaan') {
        jenisWrapper.classList.remove('hidden');
    } else {
        jenisWrapper.classList.add('hidden');
    }
});

function renderSummary(summary) {
    document.getElementById('sumPendapatan').textContent = rupiah(summary.pendapatan);
    document.getElementById('sumBelanja').textContent = rupiah(summary.belanja);
    document.getElementById('sumMasuk').textContent = rupiah(summary.pembiayaan_masuk);
    document.getElementById('sumKeluar').textContent = rupiah(summary.pembiayaan_keluar);
    document.getElementById('sumSaldo').textContent = rupiah(summary.saldo);

    chart.data.datasets[0].data = [
        summary.pendapatan,
        summary.belanja,
        summary.pembiayaan_masuk,
        summary.pembiayaan_keluar,
        summary.saldo
    ];

    chart.update();
}

function kategoriBadge(kategoriValue) {
    if (kategoriValue === 'pendapatan') {
        return `<span class="inline-flex px-4 py-2 rounded-xl bg-emerald-100 text-emerald-700 font-semibold text-sm">Pendapatan</span>`;
    }

    if (kategoriValue === 'belanja') {
        return `<span class="inline-flex px-4 py-2 rounded-xl bg-red-100 text-red-700 font-semibold text-sm">Belanja</span>`;
    }

    return `<span class="inline-flex px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-semibold text-sm">Pembiayaan</span>`;
}

function loadData() {
    fetch(`/admin/apbdes/${apbdesId}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) throw new Error('Load gagal');
        return res.json();
    })
    .then(response => {
        const details = response.details || [];
        const summary = response.summary || {};

        renderSummary(summary);

        if (details.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center text-slate-500">
                        Belum ada transaksi.
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';

        details.forEach(item => {
            html += `
                <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-6 py-5">${kategoriBadge(item.kategori)}</td>
                    <td class="px-6 py-5 text-slate-600">${item.jenis_pembiayaan ?? '-'}</td>
                    <td class="px-6 py-5 text-slate-800 font-semibold">${item.nama_item}</td>
                    <td class="px-6 py-5 text-blue-600 font-bold">${rupiah(item.jumlah)}</td>
                    <td class="px-6 py-5">
                        <div class="flex gap-3">
                            <button onclick="editData(${item.id})"
                                class="px-4 py-2 rounded-xl bg-amber-500 text-white">
                                Edit
                            </button>

                            <button onclick="deleteData(${item.id})"
                                class="px-4 py-2 rounded-xl bg-red-600 text-white">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    })
    .catch(err => {
        console.error(err);
    });
}

function saveData() {
    if (!nama.value || !jumlah.value) {
        alert('Lengkapi semua data.');
        return;
    }

    const formData = new FormData();

    formData.append('apbdes_id', apbdesId);
    formData.append('kategori', kategori.value);
    formData.append('nama_item', nama.value);
    formData.append('jumlah', jumlah.value);

    if (kategori.value === 'pembiayaan') {
        formData.append('jenis_pembiayaan', jenis.value);
    }

    let url = '/admin/apbdes-detail';

    if (editId) {
        url = `/admin/apbdes-detail/${editId}`;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();

        if (!res.ok) {
            console.error(data);
            throw new Error(data.message || 'Save gagal');
        }

        return data;
    })
    .then(() => {
        closeModal();
        loadData();
    })
    .catch(err => {
        console.error(err);
        alert(err.message);
    });
}

function editData(id) {
    fetch(`/admin/apbdes-detail/${id}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Edit gagal');
        }

        return res.json();
    })
    .then(response => {
        const data = response.data;

        editId = data.id;

        nama.value = data.nama_item;
        jumlah.value = data.jumlah;
        kategori.value = data.kategori;

        if (data.kategori === 'pembiayaan') {
            jenisWrapper.classList.remove('hidden');
            jenis.value = data.jenis_pembiayaan;
        } else {
            jenisWrapper.classList.add('hidden');
        }

        document.getElementById('modalTitle').textContent = 'Edit Detail';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    })
    .catch(err => {
        console.error(err);
    });
}

function deleteData(id) {
    if (!confirm('Yakin ingin menghapus transaksi ini?')) {
        return;
    }

    fetch(`/admin/apbdes-detail/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Delete gagal');
        }

        return res.json();
    })
    .then(() => {
        loadData();
    })
    .catch(err => {
        console.error(err);
        alert('Gagal menghapus data.');
    });
}

modal.addEventListener('click', function (e) {
    if (e.target === modal) {
        closeModal();
    }
});

loadData();
</script>

@endsection