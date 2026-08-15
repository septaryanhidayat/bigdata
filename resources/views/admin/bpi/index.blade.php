@extends('admin.layout')

@section('title', 'Mutaba\'ah BPI & Character Building')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-black text-[10px] uppercase border border-emerald-200">Modul 15: Character Building</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                🕌 Mutaba'ah BPI & Pembinaan Karakter Islami
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Monitoring ibadah harian, tilawah Al-Qur'an, hafalan surah, dzikir Al-Mathurat, & infaq siswa.</p>
        </div>

        <button onclick="document.getElementById('addBpiModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>+</span> Catat Mutaba'ah Hari Ini
        </button>
    </div>

    <!-- Table of Mutabaah BPI Logs -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Jurnal Mutaba'ah Amal Yaumiyah Siswa (10 Terkini)</h3>
            <span class="text-xs font-bold text-slate-400">Verified by Parent & Pembina BPI</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">Unit Sekolah</th>
                        <th class="p-4">Sholat 5 Waktu</th>
                        <th class="p-4">Sunnah & Tilawah</th>
                        <th class="p-4">Infaq (Rp)</th>
                        <th class="p-4">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($mutabaahLogs as $log)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $log->date }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $log->student->full_name ?? 'Siswa' }}</td>
                        <td class="p-4 font-bold text-slate-600">{{ $log->student->school->code ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">
                                5 Waktu Lunas (Subuh, Zhuhur, Ashar, Maghrib, Isya)
                            </span>
                        </td>
                        <td class="p-4 space-y-0.5">
                            <span class="font-bold text-purple-700 block">{{ $log->tilawah_juz ?? 'Juz 30' }}</span>
                            <span class="text-[10px] text-slate-500 block">{{ $log->hafalan_surah ?? 'Surah Al-Mulk' }}</span>
                        </td>
                        <td class="p-4 font-black text-emerald-700">Rp {{ number_format($log->infaq_amount, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-black text-[10px]">✓ Validated Ortus</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada jurnal mutaba'ah BPI terrecord.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Input Mutabaah -->
<div id="addBpiModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Input Mutaba'ah BPI Siswa</h3>
            <button onclick="document.getElementById('addBpiModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.bpi.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Siswa:</label>
                <select name="student_id" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($students as $st)
                    <option value="{{ $st->id }}">{{ $st->full_name }} ({{ $st->school->code ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Mutaba'ah:</label>
                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3 p-3 bg-emerald-50 rounded-2xl border border-emerald-100 text-slate-800">
                <label class="flex items-center gap-2"><input type="checkbox" name="sholat_subuh" checked> Sholat Subuh</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="sholat_zhuhur" checked> Sholat Zhuhur</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="sholat_ashar" checked> Sholat Ashar</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="sholat_maghrib" checked> Sholat Maghrib</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="sholat_isya" checked> Sholat Isya</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="dhuha" checked> Sholat Dhuha</label>
                <label class="flex items-center gap-2"><input type="checkbox" name="al_mathurat" checked> Al-Mathurat</label>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Tilawah Qur'an:</label>
                    <input type="text" name="tilawah_juz" value="Juz 30 (Surah An-Naba)" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Hafalan Surah:</label>
                    <input type="text" name="hafalan_surah" value="Surah Al-Mulk 1-15" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Infaq Harian (Rp):</label>
                <input type="number" name="infaq_amount" value="5000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addBpiModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Mutaba'ah</button>
            </div>
        </form>
    </div>
</div>
@endsection
