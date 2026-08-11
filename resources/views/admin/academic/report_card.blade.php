<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Cetak Rapor Hasil Belajar - {{ $student->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f8fafc; }
        @media print {
            .no-print { display: none !important; }
            body { background-color: #ffffff; }
        }
    </style>
</head>
<body class="p-8 max-w-4xl mx-auto text-slate-900">

    <div class="no-print mb-6 flex items-center justify-between bg-slate-900 text-white p-4 rounded-2xl">
        <span class="text-xs font-bold">📄 Preview Rapor Hasil Belajar Siswa (Kurikulum Merdeka + JSIT)</span>
        <button onclick="window.print()" class="px-4 py-2 bg-amber-400 text-slate-950 font-black text-xs rounded-xl shadow">
            🖨️ Cetak PDF Rapor
        </button>
    </div>

    <div class="bg-white p-10 rounded-2xl border border-slate-300 shadow-md space-y-6">
        
        <!-- Header Rapor -->
        <div class="border-b-2 border-slate-900 pb-4 text-center space-y-1">
            <h2 class="text-xl font-bold uppercase tracking-wide">YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI</h2>
            <h1 class="text-2xl font-black uppercase text-emerald-800">{{ $student->school->name ?? 'SEKOLAH ISLAM TERPADU ROBBANI' }}</h1>
            <p class="text-xs italic text-slate-600">NPSN: {{ $student->school->npsn ?? '20198033' }} • Alamat: {{ $student->school->address ?? 'Jl. Pendidikan Karakter No. 1-2' }}</p>
        </div>

        <h3 class="text-center font-bold text-lg uppercase tracking-wider text-slate-800">RAPOR HASIL BELAJAR SISWA</h3>

        <!-- Biodata Header Table -->
        <div class="grid grid-cols-2 gap-4 text-xs font-semibold">
            <table class="w-full">
                <tr><td class="py-1 w-32">Nama Siswa</td><td>: <strong>{{ $student->full_name }}</strong></td></tr>
                <tr><td class="py-1">NIS / NISN</td><td>: {{ $student->nis }} / {{ $student->nisn ?? '-' }}</td></tr>
                <tr><td class="py-1">Rombel / Kelas</td><td>: {{ $student->classroom->name ?? '-' }}</td></tr>
            </table>
            <table class="w-full">
                <tr><td class="py-1 w-32">Tahun Ajaran</td><td>: {{ $academicYear->name ?? '2026/2027' }}</td></tr>
                <tr><td class="py-1">Semester</td><td>: {{ $academicYear->semester ?? 'GANJIL' }}</td></tr>
                <tr><td class="py-1">Kode Kurikulum</td><td>: {{ $academicYear->curriculum_code ?? 'KURIKULUM_MERDEKA_JSIT' }}</td></tr>
            </table>
        </div>

        <!-- Tabel Nilai Mapel -->
        <table class="w-full text-left border-collapse border border-slate-400 text-xs">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-400 text-center font-bold">
                    <th class="border border-slate-400 p-2.5 w-12">No</th>
                    <th class="border border-slate-400 p-2.5">Mata Pelajaran</th>
                    <th class="border border-slate-400 p-2.5 w-24">Skor (0-100)</th>
                    <th class="border border-slate-400 p-2.5 w-20">Predikat</th>
                    <th class="border border-slate-400 p-2.5">Capaian Kompetensi / Catatan Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $idx => $grd)
                <tr>
                    <td class="border border-slate-400 p-2 text-center">{{ $idx + 1 }}</td>
                    <td class="border border-slate-400 p-2 font-bold">{{ $grd->subject->name ?? '-' }}</td>
                    <td class="border border-slate-400 p-2 text-center font-black">{{ $grd->score }}</td>
                    <td class="border border-slate-400 p-2 text-center font-bold">{{ $grd->predicate }}</td>
                    <td class="border border-slate-400 p-2 text-slate-700">{{ $grd->notes ?? 'Menunjukkan penguasaan yang sangat baik dalam capaian pembelajaran.' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border border-slate-400 p-4 text-center text-slate-400 italic">Belum ada nilai terinput untuk siswa ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <div class="pt-8 grid grid-cols-2 gap-8 text-center text-xs font-semibold">
            <div>
                <p>Orang Tua / Wali Siswa,</p>
                <div class="h-16"></div>
                <p class="font-bold underline">{{ $student->guardian->full_name ?? '....................................' }}</p>
            </div>
            <div>
                <p>Kota Bandung, {{ date('d F Y') }}</p>
                <p>Wali Kelas,</p>
                <div class="h-16"></div>
                <p class="font-bold underline">{{ $student->classroom->homeroomTeacher->full_name ?? 'Ustadz Rizky, S.Pd' }}</p>
            </div>
        </div>

    </div>

</body>
</html>
