@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 2: Sub-Modul 2.1</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Jadwal Pelajaran Mingguan</h1>
            <p class="text-xs text-slate-500 font-medium">Penjadwalan KBM bebas bentrok per rombel kelas, mapel, dan guru pengampu.</p>
        </div>
    </div>

    <!-- Table Jadwal -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Jadwal KBM Pelajaran</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $schedules->count() }} Sesi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 font-extrabold text-slate-600">
                        <th class="p-4">Hari</th>
                        <th class="p-4">Waktu / Jam</th>
                        <th class="p-4">Unit & Rombel</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Guru Pengampu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($schedules as $sch)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-black text-emerald-800">{{ $sch->day }}</td>
                        <td class="p-4 font-mono text-slate-900">{{ $sch->start_time }} - {{ $sch->end_time }}</td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">{{ $sch->classroom->name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $sch->school->code ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-extrabold text-slate-900">{{ $sch->subject->name ?? '-' }}</td>
                        <td class="p-4 font-bold text-slate-700">👨‍🏫 {{ $sch->teacher->full_name ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Tambah Jadwal Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Input Jadwal KBM Mingguan Baru</h3>

        <form action="{{ route('admin.academic.schedules.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Unit Sekolah</label>
                <select name="school_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Rombel Kelas</label>
                <select name="classroom_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}">{{ $cls->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Hari Belajar</label>
                <select name="day" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="SENIN">SENIN</option>
                    <option value="SELASA">SELASA</option>
                    <option value="RABU">RABU</option>
                    <option value="KAMIS">KAMIS</option>
                    <option value="JUMAT">JUMAT</option>
                    <option value="SABTU">SABTU</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Mata Pelajaran</label>
                <select name="subject_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($subjects as $sb)
                        <option value="{{ $sb->id }}">{{ $sb->name }} ({{ $sb->code }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Guru Pengampu</label>
                <select name="teacher_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($teachers as $tch)
                        <option value="{{ $tch->id }}">{{ $tch->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="block text-slate-700 mb-1">Jam Mulai</label>
                    <input type="time" name="start_time" value="07:30" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Jam Selesai</label>
                    <input type="time" name="end_time" value="09:00" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                </div>
            </div>

            <div class="md:col-span-3 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Jadwal KBM ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
