@extends('admin.layout')

@section('title', 'Manajemen Permohonan Layanan Publik')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-teal-100 text-teal-800 font-black text-[10px] uppercase border border-teal-200">Modul 25: Layanan Publik & Kemitraan</span>
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                🤝 Permohonan Layanan Mandiri Masyarakat
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola pengajuan kunjungan studi banding, kemitraan sponsorship, dan penyewaan sarpras sekolah.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.public-services.index') }}" class="px-3.5 py-2 rounded-2xl text-xs font-black transition-all {{ empty($type) ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                Semua ({{ $totalCount }})
            </a>
            <a href="{{ route('admin.public-services.index', ['type' => 'kunjungan']) }}" class="px-3.5 py-2 rounded-2xl text-xs font-black transition-all {{ $type === 'kunjungan' ? 'bg-teal-700 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                🏫 Kunjungan
            </a>
            <a href="{{ route('admin.public-services.index', ['type' => 'kerjasama']) }}" class="px-3.5 py-2 rounded-2xl text-xs font-black transition-all {{ $type === 'kerjasama' ? 'bg-blue-700 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                💼 Kerjasama
            </a>
            <a href="{{ route('admin.public-services.index', ['type' => 'sewa']) }}" class="px-3.5 py-2 rounded-2xl text-xs font-black transition-all {{ $type === 'sewa' ? 'bg-amber-700 text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                🏛️ Sewa Fasilitas
            </a>
        </div>
    </div>

    <!-- Stats Banner -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500">Total Permohonan</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl font-bold">📋</div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500">Menunggu Tindak Lanjut</p>
                <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $pendingCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">⏳</div>
        </div>
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500">Disetujui / Terjadwal</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $approvedCount }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">✓</div>
        </div>
    </div>

    <!-- Requests Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Permohonan Layanan Publik</h3>
            <span class="text-xs font-bold text-slate-400">Total: {{ $requests->total() }} Permohonan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Tipe & Tanggal</th>
                        <th class="p-4">Pemohon & Lembaga</th>
                        <th class="p-4">Kontak (HP/Email)</th>
                        <th class="p-4">Keperluan / Detail</th>
                        <th class="p-4">Dokumen</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-center">Aksi Respon</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($requests as $req)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            @if($req->request_type === 'kunjungan')
                                <span class="px-2.5 py-1 rounded-full bg-teal-100 text-teal-800 font-black text-[10px]">🏫 Kunjungan</span>
                            @elseif($req->request_type === 'kerjasama')
                                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px]">💼 Kerjasama</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[10px]">🏛️ Sewa</span>
                            @endif
                            <div class="font-bold text-slate-900 mt-1.5">{{ $req->event_date ? $req->event_date->format('d/m/Y') : '-' }}</div>
                            <div class="text-[10px] text-slate-400 font-medium">{{ $req->created_at ? $req->created_at->diffForHumans() : '' }}</div>
                        </td>
                        <td class="p-4">
                            <div class="font-black text-slate-900 text-sm">{{ $req->applicant_name }}</div>
                            <div class="text-xs font-bold text-slate-600 mt-0.5">{{ $req->institution_name ?: '-' }}</div>
                            @if($req->participants_count)
                                <div class="text-[10px] text-teal-700 font-bold mt-1">👥 {{ $req->participants_count }} Peserta</div>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="font-bold text-slate-900">{{ $req->phone_number }}</div>
                            <div class="text-slate-500 font-medium">{{ $req->email ?: '-' }}</div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $req->phone_number) }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] font-black text-emerald-600 hover:text-emerald-700 mt-1">
                                <span>💬 Chat WhatsApp</span>
                            </a>
                        </td>
                        <td class="p-4 max-w-xs">
                            <div class="font-bold text-slate-800 line-clamp-2">{{ $req->purpose_description }}</div>
                            @if($req->facility_or_type)
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-lg bg-slate-100 text-slate-700 text-[10px] font-bold">Kategori: {{ $req->facility_or_type }}</span>
                            @endif
                            @if($req->admin_note)
                                <div class="mt-1 text-[10px] text-amber-800 bg-amber-50 p-1.5 rounded-lg font-medium border border-amber-200">
                                    <span class="font-bold">Catatan Humas:</span> {{ $req->admin_note }}
                                </div>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($req->document_path)
                                <a href="{{ asset('storage/' . $req->document_path) }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-[10px] inline-flex items-center gap-1 border border-slate-200">
                                    📄 Unduh File
                                </a>
                            @else
                                <span class="text-slate-400 italic text-[11px]">-</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($req->status === 'APPROVED')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">✓ Disetujui</span>
                            @elseif($req->status === 'REJECTED')
                                <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 font-black text-[10px]">✕ Ditolak</span>
                            @elseif($req->status === 'COMPLETED')
                                <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[10px]">✓ Selesai</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[10px]">⏳ Pending</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                <!-- Status update form -->
                                <form action="{{ route('admin.public-services.update-status', $req->id) }}" method="POST" class="inline-flex items-center gap-1">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold p-1 rounded-xl border border-slate-200 bg-slate-50 text-slate-800">
                                        <option value="PENDING" {{ $req->status === 'PENDING' ? 'selected' : '' }}>Pending</option>
                                        <option value="APPROVED" {{ $req->status === 'APPROVED' ? 'selected' : '' }}>Setujui</option>
                                        <option value="REJECTED" {{ $req->status === 'REJECTED' ? 'selected' : '' }}>Tolak</option>
                                        <option value="COMPLETED" {{ $req->status === 'COMPLETED' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>

                                <!-- Delete form -->
                                <form action="{{ route('admin.public-services.destroy', $req->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permohonan ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-black text-[10px] transition-colors" title="Hapus Permohonan">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 italic">
                            Belum ada permohonan layanan mandiri masyarakat yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $requests->links() }}
        </div>
    </div>

</div>
@endsection
