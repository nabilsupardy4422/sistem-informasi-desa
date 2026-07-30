@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6 mb-8">

        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-800 mb-3">
                Manajemen APBDes
            </h1>

            <p class="text-slate-500 text-base md:text-lg max-w-2xl">
                Kelola data Anggaran Pendapatan dan Belanja Desa secara transparan, terstruktur, dan real-time.
            </p>
        </div>

        <button onclick="openModal()"
            class="inline-flex items-center justify-center gap-3 bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-2xl font-semibold shadow-lg transition shrink-0">
            <span class="text-xl">+</span>
            Tambah Tahun APBDes
        </button>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 mb-8">

        <label class="block text-sm font-semibold text-slate-600 mb-3">
            Filter Tahun
        </label>

        <select id="filterTahun"
            class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}">{{ $tahun }}</option>
            @endforeach
        </select>

    </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5 mb-8">

        <div class="bg-white rounded-3xl border border-emerald-200 shadow-sm p-6 min-h-[150px] flex flex-col justify-between">
            <p class="text-slate-500 text-sm font-semibold">
                Pendapatan
            </p>

            <h3 id="sumPendapatan"
                class="text-xl md:text-2xl font-black text-emerald-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-red-200 shadow-sm p-6 min-h-[150px] flex flex-col justify-between">
            <p class="text-slate-500 text-sm font-semibold">
                Belanja
            </p>

            <h3 id="sumBelanja"
                class="text-xl md:text-2xl font-black text-red-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-cyan-200 shadow-sm p-6 min-h-[150px] flex flex-col justify-between">
            <p class="text-slate-500 text-sm font-semibold">
                Pembiayaan Masuk
            </p>

            <h3 id="sumMasuk"
                class="text-xl md:text-2xl font-black text-cyan-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-amber-200 shadow-sm p-6 min-h-[150px] flex flex-col justify-between">
            <p class="text-slate-500 text-sm font-semibold">
                Pembiayaan Keluar
            </p>

            <h3 id="sumKeluar"
                class="text-xl md:text-2xl font-black text-amber-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

        <div class="bg-white rounded-3xl border border-blue-200 shadow-sm p-6 min-h-[150px] flex flex-col justify-between">
            <p class="text-slate-500 text-sm font-semibold">
                Saldo Keseluruhan
            </p>

            <h3 id="sumSaldo"
                class="text-xl md:text-2xl font-black text-blue-600 break-words leading-tight">
                Rp 0
            </h3>
        </div>

    </div>

    <!-- CHART -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 md:p-8 mb-8">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-2">
                Grafik APBDes
            </h2>

            <p class="text-slate-500 text-sm md:text-base">
                Visualisasi pendapatan, belanja, pembiayaan masuk, dan pembiayaan keluar per tahun.
            </p>
        </div>

        <div class="h-[320px] md:h-[420px]">
            <canvas id="chart"></canvas>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 md:px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Data APBDes
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1100px]">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Tahun</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Pendapatan</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Belanja</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Pembiayaan Masuk</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Pembiayaan Keluar</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Saldo</th>
                        <th class="px-6 py-5 text-left text-sm font-bold text-slate-600">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center text-slate-500">
                            Memuat data APBDes...
                        </td>
                    </tr>
                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- MODAL -->
<div id="modal"
    class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm items-center justify-center z-50 p-6">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h3 id="modalTitle" class="text-2xl font-bold text-slate-800">
                Tambah Tahun APBDes
            </h3>
        </div>

        <div class="p-8">

            <label class="block text-sm font-semibold text-slate-600 mb-3">
                Tahun
            </label>

            <input
                type="number"
                id="tahun"
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-blue-500">

        </div>

        <div class="px-8 py-6 border-t border-slate-200 flex gap-4">

            <button onclick="saveData()"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 rounded-2xl font-semibold transition">
                Simpan
            </button>

            <button onclick="closeModal()"
                class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-4 rounded-2xl font-semibold transition">
                Batal
            </button>

        </div>

    </div>

</div>

<script>
let editId = null;

const filterTahun = document.getElementById('filterTahun');
const modal = document.getElementById('modal');
const tahunInput = document.getElementById('tahun');
const modalTitle = document.getElementById('modalTitle');
const tableBody = document.getElementById('tableBody');

const chart = new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Pendapatan',
                data: [],
                backgroundColor: '#10b981',
                borderRadius: 12
            },
            {
                label: 'Belanja',
                data: [],
                backgroundColor: '#ef4444',
                borderRadius: 12
            },
            {
                label: 'Pembiayaan Masuk',
                data: [],
                backgroundColor: '#06b6d4',
                borderRadius: 12
            },
            {
                label: 'Pembiayaan Keluar',
                data: [],
                backgroundColor: '#f59e0b',
                borderRadius: 12
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

function rupiah(n) {
    return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
}

function loadData() {
    const tahun = filterTahun.value;

    fetch(`/admin/apbdes?tahun=${tahun}`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.json())
    .then(res => {

        document.getElementById('sumPendapatan').textContent = rupiah(res.summary.pendapatan);
        document.getElementById('sumBelanja').textContent = rupiah(res.summary.belanja);
        document.getElementById('sumMasuk').textContent = rupiah(res.summary.pembiayaan_masuk);
        document.getElementById('sumKeluar').textContent = rupiah(res.summary.pembiayaan_keluar);
        document.getElementById('sumSaldo').textContent = rupiah(res.summary.saldo);

        chart.data.labels = res.chart.map(i => i.tahun);
        chart.data.datasets[0].data = res.chart.map(i => i.pendapatan);
        chart.data.datasets[1].data = res.chart.map(i => i.belanja);
        chart.data.datasets[2].data = res.chart.map(i => i.pembiayaan_masuk);
        chart.data.datasets[3].data = res.chart.map(i => i.pembiayaan_keluar);
        chart.update();

        if (!res.data.length) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-6 py-20 text-center text-slate-500">
                        Tidak ada data APBDes.
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';

        res.data.forEach(d => {
            html += `
                <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                    <td class="px-6 py-5 font-semibold text-slate-800">${d.tahun}</td>
                    <td class="px-6 py-5 text-emerald-600 font-bold">${rupiah(d.pendapatan)}</td>
                    <td class="px-6 py-5 text-red-600 font-bold">${rupiah(d.belanja)}</td>
                    <td class="px-6 py-5 text-cyan-600 font-bold">${rupiah(d.pembiayaan_masuk)}</td>
                    <td class="px-6 py-5 text-amber-600 font-bold">${rupiah(d.pembiayaan_keluar)}</td>
                    <td class="px-6 py-5 text-blue-600 font-bold">${rupiah(d.saldo)}</td>

                    <td class="px-6 py-5">
                        <div class="flex flex-wrap gap-2">

                            <button onclick="editData(${d.id})"
                                class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold transition">
                                Edit
                            </button>

                            <button onclick="deleteData(${d.id})"
                                class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition">
                                Hapus
                            </button>

                            <a href="/admin/apbdes/${d.id}/detail"
                                class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                                Detail
                            </a>

                        </div>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    });
}

function openModal() {
    editId = null;
    tahunInput.value = '';
    modalTitle.textContent = 'Tambah Tahun APBDes';

    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function saveData() {
    if (!tahunInput.value) {
        alert('Tahun wajib diisi');
        return;
    }

    const formData = new FormData();
    formData.append('tahun', tahunInput.value);

    if (editId) {
        formData.append('_method', 'PUT');
    }

    let url = '/admin/apbdes';

    if (editId) {
        url = `/admin/apbdes/${editId}`;
    }

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(() => {
        closeModal();
        loadData();
    });
}

function editData(id) {
    fetch(`/admin/apbdes/${id}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(res => {
        editId = res.data.id;
        tahunInput.value = res.data.tahun;
        modalTitle.textContent = 'Edit Tahun APBDes';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });
}

function deleteData(id) {
    if (!confirm('Yakin hapus data ini?')) return;

    fetch(`/admin/apbdes/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(() => loadData());
}

filterTahun.addEventListener('change', loadData);

modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeModal();
    }
});

loadData();
</script>

@endsection