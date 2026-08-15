@extends('admin.layout')

@section('title', 'Bimbingan Konseling & Poin BK')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 font-black text-[10px] uppercase border border-rose-200">Modul 8: BK Online & Poin Siswa</span>
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                💬 Bimbingan Konseling (BK Online) & Record Poin
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Catatan poin pelanggaran & prestasi siswa, booking konseling online, & foto log home visit.</p>
        </div>

        <button onclick="document.getElementById('addBkModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>+</span> Input Catatan BK Baru
        </button>
    </div>

    <!-- Table of BK Records -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Histori Poin Pelanggaran & Prestasi Siswa</h3>
            <span class="text-xs font-bold text-slate-400">Total {{ count($records) }} Log Terrecord</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">Unit / Kelas</th>
                        <th class="p-4">Tipe Catatan</th>
                        <th class="p-4">Keterangan / Judul</th>
                        <th class="p-4">Poin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($records as $rec)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $rec->date }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $rec->student->full_name ?? 'Siswa' }}</td>
                        <td class="p-4 font-bold text-slate-600">{{ $rec->student->school->code ?? '-' }}</td>
                        <td class="p-4">
                            @if($rec->type == 'ACHIEVEMENT')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">🏆 PRESTASI</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-black text-[10px]">⚠️ PELANGGARAN</span>
                            @endif
                        </td>
                        <td class="p-4 space-y-0.5">
                            <span class="font-bold text-slate-900 block">{{ $rec->title }}</span>
                            <span class="text-[10px] text-slate-500 block">{{ $rec->description ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-mono font-black text-sm {{ $rec->type == 'ACHIEVEMENT' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $rec->type == 'ACHIEVEMENT' ? '+' : '-' }}{{ $rec->points }} Poin
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada catatan BK terrecord.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Input BK -->
<div id="addBkModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Input Catatan BK Siswa</h3>
            <button onclick="document.getElementById('addBkModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.bk.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Siswa:</label>
                <select name="student_id" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($students as $st)
                    <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->school->code ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Tipe Catatan:</label>
                    <select name="type" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="ACHIEVEMENT">🏆 Prestasi</option>
                        <option value="VIOLATION">⚠️ Pelanggaran</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Jumlah Poin:</label>
                    <input type="number" name="points" value="10" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Judul Catatan / Prestasi / Pelanggaran:</label>
                <input type="text" name="title" placeholder="Contoh: Juara 1 Lomba Tahfidz" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Keterangan Tambahan:</label>
                <textarea name="description" rows="2" placeholder="Catatan bimbingan konseling..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addBkModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Catatan BK</button>
            </div>
        </form>
    </div>
</div>
@endsection
