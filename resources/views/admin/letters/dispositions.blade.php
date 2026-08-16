@extends('admin.layout')

@section('title', 'Sistem Disposisi Pimpinan')

@section('content')
<div class="space-y-6">

    <!-- Header Box -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[10px] uppercase border border-amber-200">
                    Sistem Disposisi Digital
                </span>
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📌 Alur Disposisi & Penugasan Berjenjang
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Pendelegasian instruksi pimpinan (Tindak lanjuti, pelajari, hadiri, arsipkan), batas waktu, & feedback respon staf.
            </p>
        </div>

        <button onclick="document.getElementById('newDispModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition-transform active:scale-95 flex items-center gap-2">
            <span>➕</span> Buat Lembar Disposisi Baru
        </button>
    </div>

    <!-- Table of Dispositions -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Lembar Disposisi Surat Masuk</h3>
            <span class="text-xs font-bold text-slate-400">Total: {{ $dispositions->total() }} Lembar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Surat Referensi</th>
                        <th class="p-4">Instruksi Pimpinan</th>
                        <th class="p-4">Pemberi ➔ Penerima</th>
                        <th class="p-4">Batas Waktu</th>
                        <th class="p-4">Status & Laporan Balasan</th>
                        <th class="p-4">Aksi Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($dispositions as $dp)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="font-mono font-bold text-slate-900 block">{{ $dp->letter->reference_number ?? '-' }}</span>
                            <span class="font-black text-slate-900 block text-xs mt-0.5">{{ $dp->letter->title ?? 'Surat Dinas' }}</span>
                            <span class="text-[10px] text-slate-400">Dari: {{ $dp->letter->sender ?? 'Eksternal' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-900 font-black text-[10px] block w-fit">
                                ⚡ {{ $dp->instruction }}
                            </span>
                            @if($dp->notes)
                            <p class="text-[11px] text-slate-600 italic mt-1 bg-amber-50/60 p-2 rounded-xl border border-amber-200/50">"{{ $dp->notes }}"</p>
                            @endif
                        </td>
                        <td class="p-4 space-y-1">
                            <div class="text-[11px]">👨‍💼 Dari: <strong>{{ $dp->fromEmployee->full_name ?? 'Pimpinan' }}</strong></div>
                            <div class="text-[11px] text-emerald-800">➔ Kepada: <strong>{{ $dp->toEmployee->full_name ?? 'Staf' }}</strong></div>
                        </td>
                        <td class="p-4 font-mono">
                            <span class="{{ $dp->due_date && $dp->due_date < now() && $dp->status !== 'COMPLETED' ? 'text-rose-600 font-black' : 'text-slate-700' }}">
                                ⏰ {{ $dp->due_date ? $dp->due_date->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($dp->status === 'COMPLETED')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] block w-fit">
                                    ✓ COMPLETED / SELESAI
                                </span>
                            @elseif($dp->status === 'IN_PROGRESS')
                                <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px] block w-fit">
                                    ⏳ SEDANG DIKERJAKAN
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[10px] block w-fit">
                                    ⏳ PENDING
                                </span>
                            @endif

                            @if($dp->reply_notes)
                                <p class="text-[10px] text-slate-500 mt-1 font-normal">Balasan: {{ $dp->reply_notes }}</p>
                            @endif
                        </td>
                        <td class="p-4">
                            <button onclick="openUpdateModal('{{ $dp->id }}', '{{ $dp->status }}')" class="px-3 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-[10px] shadow-xs">
                                ✏️ Update Progres
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada disposisi terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $dispositions->links() }}
        </div>
    </div>

</div>

<!-- Modal Buat Disposisi Baru -->
<div id="newDispModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Terbitkan Lembar Disposisi</h3>
            <button onclick="document.getElementById('newDispModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.letters.dispositions.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Surat Masuk:</label>
                <select name="letter_id" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($incomingLetters as $in)
                    <option value="{{ $in->id }}">{{ $in->agenda_number }} • {{ $in->title }} ({{ $in->sender }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Disposisikan Kepada (Staf/Guru):</label>
                <select name="to_employee_id" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->role_type }} • {{ $emp->school->code ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Instruksi Pimpinan:</label>
                <select name="instruction" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="Tindak Lanjuti Segera">⚡ Tindak Lanjuti Segera</option>
                    <option value="Pelajari & Buat Rekomendasi">🔍 Pelajari & Buat Rekomendasi</option>
                    <option value="Hadir / Wakili Acara Dinas">👥 Hadir / Wakili Acara Dinas</option>
                    <option value="Koordinasikan dengan Dewan Guru">🗣️ Koordinasikan dengan Dewan Guru</option>
                    <option value="Siapkan Data & Berkas Laporan">📁 Siapkan Data & Berkas Laporan</option>
                    <option value="Arsipkan untuk Bahan Evaluasi">🗄️ Arsipkan untuk Bahan Evaluasi</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Catatan Tambahan:</label>
                <textarea name="notes" rows="2" placeholder="Tuliskan arahan tambahan di sini..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Batas Waktu (Due Date):</label>
                <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('newDispModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black shadow-md">Kirim Disposisi ➔</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Update Status Disposisi -->
<div id="updateStatusModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Update Status Pengerjaan</h3>
            <button onclick="document.getElementById('updateStatusModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form id="updateStatusForm" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Status Pengerjaan:</label>
                <select name="status" id="modalStatusSelect" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="IN_PROGRESS">Sedang Dikerjakan (In Progress)</option>
                    <option value="COMPLETED">Selesai Dikerjakan (Completed)</option>
                    <option value="REJECTED">Ditolak / Terkendala (Rejected)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Laporan Balasan / Feedback Staf:</label>
                <textarea name="reply_notes" rows="3" required placeholder="Jelaskan tindak lanjut yang telah dilakukan..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('updateStatusModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black shadow-md">Simpan Feedback ➔</button>
            </div>
        </form>
    </div>
</div>

<script>
function openUpdateModal(dispId, currentStatus) {
    document.getElementById('updateStatusForm').action = '/admin/letters/dispositions/' + dispId + '/update';
    document.getElementById('modalStatusSelect').value = currentStatus === 'PENDING' ? 'IN_PROGRESS' : currentStatus;
    document.getElementById('updateStatusModal').classList.remove('hidden');
}
</script>
@endsection
