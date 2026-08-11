@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 3: Sub-Modul 3.2</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Pengajuan Izin & Sakit Siswa</h1>
            <p class="text-xs text-slate-500 font-medium">Manajemen izin ketidakhadiran siswa (Sakit / Izin / Dispensasi) dan persetujuan wali kelas.</p>
        </div>
    </div>

    <!-- Table Izin -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Pengajuan Izin Siswa</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $leaves->total() }} Pengajuan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">Jenis Izin</th>
                        <th class="p-4">Tanggal Izin</th>
                        <th class="p-4">Alasan Ketidakhadiran</th>
                        <th class="p-4">Status Approval</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($leaves as $lv)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-black text-slate-900">{{ $lv->student->full_name ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] {{ $lv->leave_type == 'SAKIT' ? 'bg-rose-100 text-rose-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $lv->leave_type }}
                            </span>
                        </td>
                        <td class="p-4 font-mono text-slate-600">{{ $lv->start_date }} s/d {{ $lv->end_date }}</td>
                        <td class="p-4 text-slate-700 font-normal">{{ $lv->reason }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">
                                {{ $lv->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $leaves->links() }}
        </div>
    </div>

    <!-- Form Tambah Izin Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Input Pengajuan Izin Siswa Baru</h3>

        <form action="{{ route('admin.attendance.leaves.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Siswa</label>
                <select name="student_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($students as $st)
                        <option value="{{ $st->id }}">{{ $st->full_name }} (NIS: {{ $st->nis }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kategori Izin</label>
                <select name="leave_type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="SAKIT">SAKIT (Dengan Surat Dokter)</option>
                    <option value="IZIN">IZIN (Acara Keluarga / Penting)</option>
                    <option value="DISPENSASI">DISPENSASI (Lomba / Tugas Sekolah)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" value="{{ date('Y-m-d') }}">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" value="{{ date('Y-m-d') }}">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 mb-1">Alasan Ketidakhadiran</label>
                <input type="text" name="reason" required placeholder="Sakit demam & perlu istirahat di rumah" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan & Setujui Izin Siswa ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
