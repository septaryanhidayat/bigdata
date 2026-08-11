@extends('admin.layout')

@section('title', 'Jurnal KBM Guru')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-theme-light text-theme-dark font-extrabold text-[10px] uppercase">Modul 2: Sub-Modul 2.2</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Jurnal Kegiatan Belajar Mengajar (KBM) Guru</h1>
            <p class="text-xs text-slate-500 font-medium">Recording materi pembelajaran per sesi KBM, capaian topik bahasan, & catatan kelas.</p>
        </div>
    </div>

    <!-- Table Jurnal KBM -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Catatan Jurnal KBM Guru</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $journals->total() }} Jurnal</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Tanggal / Waktu</th>
                        <th class="p-4">Guru Pengampu</th>
                        <th class="p-4">Rombel & Mapel</th>
                        <th class="p-4">Materi / Topik Bahasan</th>
                        <th class="p-4">Catatan Sesi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($journals as $j)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono text-slate-600 font-bold">{{ $j->date }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $j->teacher->full_name ?? '-' }}</td>
                        <td class="p-4">
                            <span class="font-black text-theme-accent block">{{ $j->schedule->classroom->name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400 font-bold">{{ $j->schedule->subject->name ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-bold text-slate-900">{{ $j->topic }}</td>
                        <td class="p-4 text-slate-500 font-normal">{{ $j->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-400 italic font-semibold">Belum ada catatan jurnal KBM terinput. Silakan input jurnal KBM baru di bawah ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $journals->links() }}
        </div>
    </div>

    <!-- Form Input Jurnal KBM Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Input Jurnal Sesi KBM Baru</h3>

        <form action="{{ route('admin.academic.journals.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Sesi Jadwal KBM</label>
                <select name="schedule_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($schedules as $sch)
                        <option value="{{ $sch->id }}">{{ $sch->day }} - {{ $sch->classroom->name ?? 'Kelas' }} ({{ $sch->subject->name ?? 'Mapel' }}) [{{ $sch->start_time }} - {{ $sch->end_time }}]</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Pilih Guru Pengampu</label>
                <select name="teacher_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($teachers as $tch)
                        <option value="{{ $tch->id }}">{{ $tch->full_name }} (NIP: {{ $tch->nip ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Sesi KBM</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Materi / Topik Pembahasan</label>
                <input type="text" name="topic" required placeholder="Surah An-Naba Ayat 1-15 & Tajwid Mad Thabi'i" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 mb-1">Catatan Kelas / Progres Belajar</label>
                <input type="text" name="notes" placeholder="90% siswa sudah menguasai bacaan tajwid dengan tartil." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-theme-gradient text-white font-black hover:opacity-90 transition-all shadow-lg">
                    Simpan Jurnal KBM ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
