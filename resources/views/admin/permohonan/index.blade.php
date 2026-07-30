@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
        <div>
            <h1 class="text-4xl font-black text-slate-800">
                Manajemen Permohonan Layanan
            </h1>
            <p class="text-slate-500 mt-3 text-lg">
                Kelola permohonan layanan masyarakat, verifikasi dokumen, tracking proses, dan assignment admin.
            </p>
        </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Total Permohonan
            </p>
            <h3 class="text-5xl font-black text-blue-600">
                {{ $permohonans->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Sedang Diproses
            </p>
            <h3 class="text-5xl font-black text-amber-600">
                {{ $permohonans->whereIn('status', ['ditinjau','diproses','menunggu_dokumen'])->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Selesai
            </p>
            <h3 class="text-5xl font-black text-emerald-600">
                {{ $permohonans->where('status', 'selesai')->count() }}
            </h3>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            <p class="text-slate-500 text-sm font-medium mb-3">
                Diverifikasi
            </p>
            <h3 class="text-5xl font-black text-purple-600">
                {{ $permohonans->whereNotNull('verified_at')->count() }}
            </h3>
        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-8 mb-10">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Filter Status
                </label>

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">Semua Status</option>
                    <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="ditinjau" {{ request('status') == 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="menunggu_dokumen" {{ request('status') == 'menunggu_dokumen' ? 'selected' : '' }}>Menunggu Dokumen</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-3">
                    Filter Assignment
                </label>

                <select
                    name="assigned"
                    onchange="this.form.submit()"
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <option value="">Semua</option>
                    <option value="assigned" {{ request('assigned') == 'assigned' ? 'selected' : '' }}>
                        Sudah Assigned
                    </option>
                    <option value="unassigned" {{ request('assigned') == 'unassigned' ? 'selected' : '' }}>
                        Belum Assigned
                    </option>

                </select>
            </div>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-2xl font-bold text-slate-800">
                Daftar Permohonan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[1600px] text-sm">

                <thead class="bg-slate-50">
                    <tr class="text-slate-600 border-b border-slate-200">
                        <th class="px-5 py-4 text-left">Tracking</th>
                        <th class="px-5 py-4 text-left">Pemohon</th>
                        <th class="px-5 py-4 text-left">Kontak</th>
                        <th class="px-5 py-4 text-left">Layanan</th>
                        <th class="px-5 py-4 text-left">Dokumen</th>
                        <th class="px-5 py-4 text-left">Status</th>
                        <th class="px-5 py-4 text-left">Assigned Admin</th>
                        <th class="px-5 py-4 text-left">Verifikasi</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($permohonans as $item)

                    @php
                        $statusClass = match($item->status) {
                            'baru' => 'bg-blue-100 text-blue-700',
                            'ditinjau' => 'bg-yellow-100 text-yellow-700',
                            'diproses' => 'bg-orange-100 text-orange-700',
                            'menunggu_dokumen' => 'bg-purple-100 text-purple-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'ditolak' => 'bg-red-100 text-red-700',
                            default => 'bg-slate-100 text-slate-700'
                        };
                    @endphp

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        <td class="px-5 py-5">
                            <div class="font-bold text-blue-600">
                                {{ $item->tracking_code }}
                            </div>
                            <div class="text-xs text-slate-500 mt-2">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </div>
                        </td>

                        <td class="px-5 py-5">
                            <div class="font-bold text-slate-800">
                                {{ $item->nama }}
                            </div>
                            <div class="text-xs text-slate-500 mt-2">
                                NIK: {{ $item->nik }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ \Illuminate\Support\Str::limit($item->alamat, 50) }}
                            </div>
                        </td>

                        <td class="px-5 py-5">
                            <div class="text-slate-700">
                                {{ $item->telepon ?? '-' }}
                            </div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $item->email ?? '-' }}
                            </div>
                        </td>

                        <td class="px-5 py-5">
                            <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl font-medium">
                                {{ $item->layanan->nama_layanan ?? '-' }}
                            </span>
                        </td>

                        <td class="px-5 py-5">
                            <div class="flex flex-col gap-2 text-xs">

                                @if($item->file_ktp)
                                    <span class="bg-green-100 text-green-700 px-3 py-2 rounded-full font-medium">
                                        KTP
                                    </span>
                                @endif

                                @if($item->file_kk)
                                    <span class="bg-green-100 text-green-700 px-3 py-2 rounded-full font-medium">
                                        KK
                                    </span>
                                @endif

                                @if($item->file_pendukung)
                                    <span class="bg-blue-100 text-blue-700 px-3 py-2 rounded-full font-medium">
                                        Pendukung
                                    </span>
                                @endif

                                @if(!$item->file_ktp && !$item->file_kk && !$item->file_pendukung)
                                    <span class="text-slate-400">
                                        Tidak ada
                                    </span>
                                @endif

                            </div>
                        </td>

                        <td class="px-5 py-5">
                            <span class="{{ $statusClass }} px-4 py-2 rounded-full text-xs font-semibold capitalize">
                                {{ str_replace('_', ' ', $item->status) }}
                            </span>
                        </td>

                        <td class="px-5 py-5">
                            <span class="font-medium text-slate-700">
                                {{ $item->admin->name ?? 'Belum assigned' }}
                            </span>
                        </td>

                        <td class="px-5 py-5">
                            @if($item->verified_at)
                                <span class="bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-semibold">
                                    Verified
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-500 px-4 py-2 rounded-full text-xs font-semibold">
                                    Pending
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-5">
                            <div class="flex justify-center gap-2">

                                <button
                                    type="button"
                                    onclick="editPermohonan({{ $item->id }})"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                                    Kelola
                                </button>

                                <button
                                    type="button"
                                    onclick="deletePermohonan({{ $item->id }})"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl font-semibold transition">
                                    Hapus
                                </button>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center py-20 text-slate-500">
                            Belum ada data permohonan.
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>

        </div>
    </div>

        {{-- MODAL --}}
        <div id="permohonanModal"
        class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm overflow-y-auto p-6">

       <div class="min-h-screen flex items-center justify-center">

           <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl overflow-hidden">

               <div class="px-8 py-6 border-b border-slate-200 flex items-center justify-between">
                   <div>
                       <h3 class="text-2xl font-black text-slate-800">
                           Kelola Permohonan
                       </h3>
                       <p class="text-slate-500 mt-2">
                           Detail permohonan layanan dan proses verifikasi.
                       </p>
                   </div>

                   <button type="button"
                           onclick="closeModal()"
                           class="w-12 h-12 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 text-2xl font-bold">
                       ×
                   </button>
               </div>

               <form id="updateForm" class="p-8 space-y-8">

                   @csrf
                   <input type="hidden" id="permohonanId">

                   <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                       {{-- LEFT --}}
                       <div class="space-y-5">

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Tracking Code
                               </label>
                               <input id="tracking_code" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Nama Pemohon
                               </label>
                               <input id="nama" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   NIK
                               </label>
                               <input id="nik" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Email
                               </label>
                               <input id="email" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Telepon
                               </label>
                               <input id="telepon" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Alamat
                               </label>
                               <textarea id="alamat" rows="3" readonly
                                         class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Pesan / Keperluan
                               </label>
                               <textarea id="pesan" rows="4" readonly
                                         class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                           </div>

                       </div>

                       {{-- RIGHT --}}
                       <div class="space-y-5">

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Layanan
                               </label>
                               <input id="layanan" type="text" readonly
                                      class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4">
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Status
                               </label>
                               <select id="status"
                                       class="w-full border border-slate-200 rounded-2xl px-5 py-4">
                                   <option value="baru">Baru</option>
                                   <option value="ditinjau">Ditinjau</option>
                                   <option value="diproses">Diproses</option>
                                   <option value="menunggu_dokumen">Menunggu Dokumen</option>
                                   <option value="selesai">Selesai</option>
                                   <option value="ditolak">Ditolak</option>
                               </select>
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Assign Admin
                               </label>
                               <select id="assigned_to"
                                       class="w-full border border-slate-200 rounded-2xl px-5 py-4">
                                   <option value="">Belum Assigned</option>

                                   @foreach($admins as $admin)
                                       <option value="{{ $admin->id }}">
                                           {{ $admin->name }}
                                       </option>
                                   @endforeach
                               </select>
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Catatan Admin
                               </label>
                               <textarea id="catatan_admin" rows="4"
                                         class="w-full border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-2">
                                   Catatan Verifikasi
                               </label>
                               <textarea id="catatan_verifikasi" rows="4"
                                         class="w-full border border-slate-200 rounded-2xl px-5 py-4"></textarea>
                           </div>

                           <div>
                               <label class="block text-sm font-semibold text-slate-600 mb-3">
                                   Dokumen
                               </label>

                               <div id="dokumenArea" class="flex flex-wrap gap-3">
                               </div>
                           </div>

                       </div>

                   </div>

                   <div class="flex justify-end gap-4">
                       <button type="button"
                               onclick="closeModal()"
                               class="px-6 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 font-semibold">
                           Batal
                       </button>

                       <button id="saveBtn"
                               type="button"
                               onclick="updatePermohonan()"
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
    const modal = document.getElementById('permohonanModal');
    const saveBtn = document.getElementById('saveBtn');

    let isSubmitting = false;

    function closeModal() {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openModal() {
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    async function safeJson(response) {
        const text = await response.text();

        if (!text) return {};

        try {
            return JSON.parse(text);
        } catch {
            return {
                success: false,
                message: 'Response bukan JSON valid.'
            };
        }
    }

    async function editPermohonan(id) {
        try {
            const response = await fetch(`/admin/permohonan/${id}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data.');
            }

            const data = await safeJson(response);

            document.getElementById('permohonanId').value = data.id ?? '';
            document.getElementById('tracking_code').value = data.tracking_code ?? '';
            document.getElementById('nama').value = data.nama ?? '';
            document.getElementById('nik').value = data.nik ?? '';
            document.getElementById('email').value = data.email ?? '-';
            document.getElementById('telepon').value = data.telepon ?? '-';
            document.getElementById('alamat').value = data.alamat ?? '-';
            document.getElementById('pesan').value = data.pesan ?? '-';
            document.getElementById('layanan').value = data.layanan?.nama_layanan ?? '-';
            document.getElementById('status').value = data.status ?? 'baru';
            document.getElementById('assigned_to').value = data.assigned_to ?? '';
            document.getElementById('catatan_admin').value = data.catatan_admin ?? '';
            document.getElementById('catatan_verifikasi').value = data.catatan_verifikasi ?? '';

            let docs = '';

            if (data.file_ktp) {
                docs += `
                    <a href="/admin/permohonan/${id}/download/ktp"
                       target="_blank"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl font-semibold">
                        Download KTP
                    </a>
                `;
            }

            if (data.file_kk) {
                docs += `
                    <a href="/admin/permohonan/${id}/download/kk"
                       target="_blank"
                       class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-semibold">
                        Download KK
                    </a>
                `;
            }

            if (data.file_pendukung) {
                docs += `
                    <a href="/admin/permohonan/${id}/download/pendukung"
                       target="_blank"
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-xl font-semibold">
                        Dokumen Pendukung
                    </a>
                `;
            }

            if (!docs) {
                docs = `<span class="text-slate-400">Tidak ada dokumen</span>`;
            }

            document.getElementById('dokumenArea').innerHTML = docs;

            openModal();

        } catch (error) {
            console.error(error);
            alert('Gagal memuat data permohonan.');
        }
    }

    async function updatePermohonan() {
        if (isSubmitting) return;

        const id = document.getElementById('permohonanId').value;

        if (!id) {
            alert('ID permohonan tidak ditemukan.');
            return;
        }

        isSubmitting = true;
        saveBtn.disabled = true;
        saveBtn.innerText = 'Menyimpan...';

        const assignedValue = document.getElementById('assigned_to').value;

        const payload = {
            status: document.getElementById('status').value,
            assigned_to: assignedValue === '' ? null : parseInt(assignedValue),
            catatan_admin: document.getElementById('catatan_admin').value,
            catatan_verifikasi: document.getElementById('catatan_verifikasi').value
        };

        try {
            const response = await fetch(`/admin/permohonan/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const result = await safeJson(response);

            if (!response.ok) {
                throw result;
            }

            alert(result.message || 'Permohonan berhasil diperbarui.');
            location.reload();

        } catch (error) {
            console.error(error);

            if (error.errors) {
                const messages = Object.values(error.errors)
                    .flat()
                    .join('\n');

                alert(messages);
            } else {
                alert(error.message || 'Gagal memperbarui permohonan.');
            }

        } finally {
            isSubmitting = false;
            saveBtn.disabled = false;
            saveBtn.innerText = 'Simpan Perubahan';
        }
    }

    async function deletePermohonan(id) {
        if (!confirm('Yakin ingin menghapus permohonan ini?')) {
            return;
        }

        try {
            const response = await fetch(`/admin/permohonan/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await safeJson(response);

            if (!response.ok) {
                throw result;
            }

            alert(result.message || 'Data berhasil dihapus.');
            location.reload();

        } catch (error) {
            console.error(error);
            alert('Gagal menghapus data.');
        }
    }

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
    </script>

@endsection