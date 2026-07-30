@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-800 mb-3">
                Manajemen Pengaduan
            </h1>
            <p class="text-slate-500 text-lg">
                Kelola pengaduan masyarakat, assignment admin, prioritas penanganan, dan tindak lanjut.
            </p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">Total Pengaduan</p>
            <h3 class="text-5xl font-black text-blue-600">
                {{ $pengaduans->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">Sedang Diproses</p>
            <h3 class="text-5xl font-black text-amber-600">
                {{ $pengaduans->whereIn('status', ['ditinjau','diproses'])->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">Selesai</p>
            <h3 class="text-5xl font-black text-emerald-600">
                {{ $pengaduans->where('status', 'selesai')->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">Urgent</p>
            <h3 class="text-5xl font-black text-red-600">
                {{ $pengaduans->where('prioritas', 'urgent')->count() }}
            </h3>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8 mb-10">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Filter Status
                </label>
                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700">

                    <option value="">Semua Status</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="ditinjau" {{ request('status') == 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Filter Prioritas
                </label>
                <select
                    name="prioritas"
                    onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700">

                    <option value="">Semua Prioritas</option>
                    <option value="rendah" {{ request('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="sedang" {{ request('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="tinggi" {{ request('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    <option value="urgent" {{ request('prioritas') == 'urgent' ? 'selected' : '' }}>Urgent</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Filter Kategori
                </label>
                <select
                    name="kategori"
                    onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700">

                    <option value="">Semua Kategori</option>

                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Data Pengaduan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1800px] text-sm">
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-slate-600">
                        <th class="px-6 py-5 text-left font-semibold">Tracking</th>
                        <th class="px-6 py-5 text-left font-semibold">Pelapor</th>
                        <th class="px-6 py-5 text-left font-semibold">Kategori</th>
                        <th class="px-6 py-5 text-left font-semibold">Isi Aduan</th>
                        <th class="px-6 py-5 text-left font-semibold">Alamat</th>
                        <th class="px-6 py-5 text-left font-semibold">Prioritas</th>
                        <th class="px-6 py-5 text-left font-semibold">Status</th>
                        <th class="px-6 py-5 text-left font-semibold">Admin</th>
                        <th class="px-6 py-5 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($pengaduans as $item)

                    @php
                        $priorityClass = match($item->prioritas) {
                            'rendah' => 'bg-slate-100 text-slate-700',
                            'sedang' => 'bg-blue-100 text-blue-700',
                            'tinggi' => 'bg-orange-100 text-orange-700',
                            'urgent' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700'
                        };

                        $statusClass = match($item->status) {
                            'baru' => 'bg-blue-100 text-blue-700',
                            'ditinjau' => 'bg-yellow-100 text-yellow-700',
                            'diproses' => 'bg-orange-100 text-orange-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        <td class="px-6 py-6">
                            <div class="font-bold text-blue-600">
                                {{ $item->tracking_code }}
                            </div>
                            <div class="text-xs text-slate-500 mt-2">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </div>
                        </td>

                        <td class="px-6 py-6">
                            <div class="font-bold text-slate-800">
                                {{ $item->nama }}
                            </div>
                            <div class="text-xs text-slate-500 mt-2">
                                {{ $item->telepon ?? '-' }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $item->email ?? '-' }}
                            </div>
                        </td>

                        <td class="px-6 py-6 font-medium text-slate-700">
                            {{ $item->kategori ?? '-' }}
                        </td>

                        <td class="px-6 py-6 max-w-[350px]">
                            <div class="text-slate-700 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($item->isi_pengaduan, 100) }}
                            </div>
                        </td>

                        <td class="px-6 py-6 max-w-[280px]">
                            <div class="text-slate-700 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($item->alamat, 90) }}
                            </div>
                        </td>

                        <td class="px-6 py-6">
                            <span class="{{ $priorityClass }} px-4 py-2 rounded-full text-xs font-semibold uppercase">
                                {{ $item->prioritas }}
                            </span>
                        </td>

                        <td class="px-6 py-6">
                            <span class="{{ $statusClass }} px-4 py-2 rounded-full text-xs font-semibold capitalize">
                                {{ $item->status }}
                            </span>
                        </td>

                        <td class="px-6 py-6 font-medium text-slate-700">
                            {{ $item->admin->name ?? '-' }}
                        </td>

                        <td class="px-6 py-6">
                            <div class="flex flex-wrap justify-center gap-3">

                                <button
                                    type="button"
                                    onclick="editPengaduan({{ $item->id }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                                    Kelola
                                </button>

                                <button
                                    type="button"
                                    onclick="deletePengaduan({{ $item->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center py-20 text-slate-500">
                            Belum ada data pengaduan.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>
    </div>

        {{-- MODAL --}}
        <div
        id="pengaduanModal"
        class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm overflow-y-auto p-6">

        <div class="min-h-screen flex items-center justify-center">

            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden">

                <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800">
                            Kelola Pengaduan
                        </h3>
                        <p class="text-slate-500 mt-2">
                            Detail laporan dan update status penanganan.
                        </p>
                    </div>

                    <button
                        type="button"
                        onclick="closeModal()"
                        class="text-slate-400 hover:text-slate-700 text-3xl font-bold">
                        &times;
                    </button>
                </div>

                <form id="updateForm" class="p-8 space-y-8">

                    @csrf
                    <input type="hidden" id="pengaduanId">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Tracking</label>
                            <input id="tracking_code" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Nama Pelapor</label>
                            <input id="nama" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">NIK</label>
                            <input id="nik" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Telepon</label>
                            <input id="telepon" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Email</label>
                            <input id="email" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Kategori</label>
                            <input id="kategori" type="text" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Alamat</label>
                        <textarea id="alamat" rows="3" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Isi Pengaduan</label>
                        <textarea id="isi_pengaduan" rows="5" readonly class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Status</label>
                            <select id="status" class="w-full border border-slate-200 rounded-2xl px-5 py-4">
                                <option value="baru">Baru</option>
                                <option value="ditinjau">Ditinjau</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Prioritas</label>
                            <select id="prioritas" class="w-full border border-slate-200 rounded-2xl px-5 py-4">
                                <option value="rendah">Rendah</option>
                                <option value="sedang">Sedang</option>
                                <option value="tinggi">Tinggi</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-2">Assign Admin</label>
                            <select id="assigned_to" class="w-full border border-slate-200 rounded-2xl px-5 py-4">
                                <option value="">Belum Ditugaskan</option>

                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-600 mb-2">Catatan Admin</label>
                        <textarea id="catatan_admin" rows="4" class="w-full border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <button
                            type="button"
                            onclick="closeModal()"
                            class="px-6 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 font-semibold">
                            Batal
                        </button>

                        <button
                            id="saveBtn"
                            type="button"
                            onclick="updatePengaduan()"
                            class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

<script>
const modal = document.getElementById('pengaduanModal');
const saveBtn = document.getElementById('saveBtn');

function closeModal() {
    modal.classList.add('hidden');
}

async function editPengaduan(id) {
    try {
        const response = await fetch(`/admin/pengaduan/${id}`);
        const data = await response.json();

        document.getElementById('pengaduanId').value = data.id;
        document.getElementById('tracking_code').value = data.tracking_code ?? '';
        document.getElementById('nama').value = data.nama ?? '';
        document.getElementById('nik').value = data.nik ?? '';
        document.getElementById('telepon').value = data.telepon ?? '';
        document.getElementById('email').value = data.email ?? '';
        document.getElementById('kategori').value = data.kategori ?? '';
        document.getElementById('alamat').value = data.alamat ?? '';
        document.getElementById('isi_pengaduan').value = data.isi_pengaduan ?? '';
        document.getElementById('status').value = data.status ?? 'baru';
        document.getElementById('prioritas').value = data.prioritas ?? 'sedang';
        document.getElementById('assigned_to').value = data.assigned_to ?? '';
        document.getElementById('catatan_admin').value = data.catatan_admin ?? '';

        modal.classList.remove('hidden');

    } catch (error) {
        alert('Gagal mengambil data pengaduan.');
        console.error(error);
    }
}

async function updatePengaduan() {
    const id = document.getElementById('pengaduanId').value;

    saveBtn.disabled = true;
    saveBtn.innerText = 'Menyimpan...';

    try {
        const response = await fetch(`/admin/pengaduan/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: document.getElementById('status').value,
                prioritas: document.getElementById('prioritas').value,
                assigned_to: document.getElementById('assigned_to').value,
                catatan_admin: document.getElementById('catatan_admin').value
            })
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Gagal update data.');
        }

    } catch (error) {
        alert('Terjadi kesalahan.');
        console.error(error);
    }

    saveBtn.disabled = false;
    saveBtn.innerText = 'Simpan Perubahan';
}

async function deletePengaduan(id) {
    if (!confirm('Yakin ingin menghapus pengaduan ini?')) return;

    try {
        const response = await fetch(`/admin/pengaduan/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            location.reload();
        } else {
            alert('Gagal menghapus data.');
        }

    } catch (error) {
        alert('Terjadi kesalahan.');
        console.error(error);
    }
}

window.onclick = function(e) {
    if (e.target === modal) {
        closeModal();
    }
}
</script>

@endsection