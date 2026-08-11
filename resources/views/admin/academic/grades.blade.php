@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 2: Sub-Modul 2.2</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Penilaian Multi-Kurikulum (K13 & Merdeka P5)</h1>
            <p class="text-xs text-slate-500 font-medium">Input nilai formatif, sumatif, capaian TP, KI-3 pengetahuan, KI-4 keterampilan, & proyek P5.</p>
        </div>
    </div>

    <!-- Table Grades -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Nilai Siswa Terdaftar</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $grades->total() }} Nilai</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">Mata Pelajaran</th>
                        <th class="p-4">Kategori Penilaian</th>
                        <th class="p-4">Skor / Nilai</th>
                        <th class="p-4">Predikat</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($grades as $grd)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="font-black text-slate-900 block">{{ $grd->student->full_name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">NIS: {{ $grd->student->nis ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-bold text-emerald-800">{{ $grd->subject->name ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 font-bold text-[10px]">
                                {{ $grd->type }}
                            </span>
                        </td>
                        <td class="p-4 font-black text-base text-slate-900">{{ $grd->score }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-xs font-black text-white" style="background-color: {{ $grd->predicate == 'A' ? '#059669' : ($grd->predicate == 'B' ? '#0284c7' : '#d97706') }}">
                                {{ $grd->predicate }}
                            </span>
                        </td>
                        <td class="p-4">
                            <a href="{{ route('admin.academic.report-card', $grd->student_id) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-900 text-white font-bold text-[10px] shadow">
                                Preview Rapor PDF ➔
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $grades->links() }}
        </div>
    </div>

    <!-- Form Input Nilai Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Input Nilai Capaian Siswa</h3>

        <form action="{{ route('admin.academic.grades.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs font-bold">
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
                <label class="block text-slate-700 mb-1">Mata Pelajaran</label>
                <select name="subject_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($subjects as $sb)
                        <option value="{{ $sb->id }}">{{ $sb->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tahun Akademik</label>
                <select name="academic_year_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($academicYears as $ay)
                        <option value="{{ $ay->id }}">{{ $ay->name }} - {{ $ay->semester }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Jenis Penilaian</label>
                <select name="type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="SUMATIF_AKHIR_SEMESTER">Sumatif Akhir Semester (SAS)</option>
                    <option value="FORMATIF_TP">Formatif Tujuan Pembelajaran (TP)</option>
                    <option value="PROYEK_P5">Penilaian Proyek P5 Merdeka</option>
                    <option value="KI3_PENGETAHUAN">K13 KI-3 Pengetahuan</option>
                    <option value="KI4_KETERAMPILAN">K13 KI-4 Keterampilan</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Skor Angka (0 - 100)</label>
                <input type="number" step="0.1" name="score" value="88" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Catatan Deskripsi Guru</label>
                <input type="text" name="notes" placeholder="Sangat baik dalam memahami materi" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-3 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Nilai Siswa ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
