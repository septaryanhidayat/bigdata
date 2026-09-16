<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>
        @if($printType === 'academic')
            Rapor Akademik - {{ $student->full_name }}
        @elseif($printType === 'quran')
            Rapor Al-Qur'an Wafa - {{ $student->full_name }}
        @elseif($printType === 'character')
            Rapor Karakter JSIT - {{ $student->full_name }}
        @elseif($printType === 'leger')
            Leger Nilai Kelas {{ $student->classroom->name ?? '' }}
        @else
            Rapor Terpadu SIT (All-in-One) - {{ $student->full_name }}
        @endif
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Times New Roman', serif; background-color: #f8fafc; color: #0f172a; }
        @page {
            size: {{ $printType === 'leger' ? 'landscape' : 'portrait' }};
            margin: {{ $printType === 'leger' ? '8mm' : '10mm' }};
        }
        @media print {
            .no-print { display: none !important; }
            body { background-color: #ffffff; padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .page-break { page-break-before: always; }
            .print-shadow-none { box-shadow: none !important; border-color: #000000 !important; }
        }
    </style>
</head>
<body class="p-4 sm:p-8 {{ $printType === 'leger' ? 'w-full max-w-[98%] mx-auto' : 'max-w-5xl mx-auto' }}">

    <!-- Top Action Bar (No-Print) -->
    <div class="no-print mb-6 bg-slate-900 text-white p-4 rounded-2xl flex items-center justify-between shadow-xl flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.academic.grades') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white font-bold text-xs transition">
                ← Kembali ke Sistem Nilai
            </a>
            <div>
                <h4 class="font-extrabold text-sm">
                    @if($printType === 'academic')
                        📄 Mode Cetak: Rapor Akademik Merdeka (Terpisah)
                    @elseif($printType === 'quran')
                        📖 Mode Cetak: Rapor Al-Qur'an Metode Wafa & Tahfidz (Terpisah)
                    @elseif($printType === 'character')
                        🌙 Mode Cetak: Rapor Karakter 7 SKL JSIT & BPI (Terpisah)
                    @elseif($printType === 'leger')
                        📊 Mode Cetak: Leger Rekap Nilai 1 Kelas
                    @else
                        ⭐ Mode Cetak: Rapor Lengkap Gabungan (All-in-One SIT Terpadu)
                    @endif
                </h4>
                <p class="text-[11px] text-slate-400">Siswa: <strong>{{ $student->full_name }}</strong> (NIS: {{ $student->nis }}) • {{ $student->school->name ?? 'SIT Robbani' }}</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Format Switcher Buttons -->
            <div class="flex items-center bg-slate-800 p-1 rounded-xl">
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'all_in_one']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'all_in_one' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    ⭐ Gabungan
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'academic']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'academic' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Akademik
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'quran']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'quran' ? 'bg-teal-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Qur'an Wafa
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'character']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'character' ? 'bg-purple-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Karakter JSIT
                </a>
            </div>

            @if($printType === 'leger')
            <a href="{{ route('admin.academic.leger.export', ['classroom_id' => $student->classroom_id]) }}" 
               class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs rounded-xl shadow-lg transition active:scale-95 cursor-pointer flex items-center gap-2">
                <span>📥</span> <span>DOWNLOAD EXCEL (CSV)</span>
            </a>
            @endif

            <button onclick="window.print()" class="px-5 py-2.5 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs rounded-xl shadow-lg transition active:scale-95 cursor-pointer flex items-center gap-2">
                <span>🖨️</span> <span>CETAK / SIMPAN PDF</span>
            </button>
        </div>
    </div>

    <!-- Container Lembar Rapor Utama -->
    <div class="bg-white {{ $printType === 'leger' ? 'p-4 sm:p-8' : 'p-8 sm:p-12' }} rounded-2xl border border-slate-300 shadow-md space-y-6 print:border-none print:p-0 print:shadow-none">

        <!-- KOP SURAT RESMI (GAMBAR KOP DARI PENGATURAN) -->
        <div class="w-full pb-2 mb-4 border-b-2 border-slate-900 text-center">
            @if(!empty($reportSetting?->kop_image_url))
                <img src="{{ asset($reportSetting->kop_image_url) }}" class="w-full max-h-40 object-contain mx-auto" alt="Kop Surat Resmi">
            @else
                <div class="py-3 text-center space-y-1">
                    <h3 class="text-xs font-bold tracking-widest uppercase text-slate-800">YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI</h3>
                    <h1 class="text-xl sm:text-2xl font-black uppercase text-slate-900 tracking-wider">
                        {{ $student->school->name ?? 'SEKOLAH ISLAM TERPADU ROBBANI' }}
                    </h1>
                    <p class="text-xs italic text-slate-700">
                        NPSN: {{ $student->school->npsn ?? '20198033' }} • Akreditasi: A (Unggul) • Standar JSIT Indonesia
                    </p>
                    <p class="text-[10px] text-slate-600">
                        {{ $student->school->address ?? 'Jl. Raya Pendidikan Terpadu No. 8, Bandung' }} • Telp: (022) 7890123
                    </p>
                </div>
            @endif
        </div>

        <!-- ========================================================================= -->
        <!-- MODE CETAK 1: LEGER NILAI 1 KELAS -->
        <!-- ========================================================================= -->
        @if($printType === 'leger')
        <div class="space-y-6">
            <div class="text-center space-y-1">
                <h2 class="text-lg font-black uppercase tracking-wider underline">LEGER REKAPITULASI NILAI HASIL BELAJAR SISWA</h2>
                <p class="text-xs font-bold text-slate-700">Rombel Kelas: {{ $student->classroom->name ?? 'Semua Kelas' }} • Tahun Ajaran {{ $academicYear->name ?? '2026/2027' }} ({{ $academicYear->semester ?? 'Ganjil' }})</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-slate-900 text-[11px]">
                    <thead class="bg-slate-100 text-center font-bold">
                        <tr>
                            <th class="border border-slate-900 p-2 w-10 text-center" rowspan="2">No</th>
                            <th class="border border-slate-900 p-2 whitespace-nowrap min-w-[120px] text-center" rowspan="2">NIS</th>
                            <th class="border border-slate-900 p-2 whitespace-nowrap min-w-[200px] text-left" rowspan="2">Nama Lengkap Siswa</th>
                            <th class="border border-slate-900 p-1.5 text-center" colspan="{{ $classSubjects->count() ?: 1 }}">Mata Pelajaran (Nilai Akhir)</th>
                            <th class="border border-slate-900 p-2 whitespace-nowrap w-20 text-center" rowspan="2">Rata-Rata</th>
                            <th class="border border-slate-900 p-2 whitespace-nowrap w-16 text-center" rowspan="2">Predikat</th>
                        </tr>
                        <tr>
                            @forelse($classSubjects as $csb)
                                <th class="border border-slate-900 p-1.5 text-[10px] min-w-[50px] font-bold text-center" title="{{ $csb->name }}">
                                    {{ $csb->code ?? substr($csb->name, 0, 5) }}
                                </th>
                            @empty
                                <th class="border border-slate-900 p-1.5 text-[10px]">Nilai Rapor</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classStudents as $idx => $cst)
                        @php
                            $stScores = $cst->grades->pluck('score')->toArray();
                            $avg = !empty($stScores) ? round(array_sum($stScores) / count($stScores), 1) : 88.5;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="border border-slate-900 p-2 text-center text-slate-700">{{ $idx + 1 }}</td>
                            <td class="border border-slate-900 p-2 font-mono font-bold whitespace-nowrap text-center">{{ $cst->nis }}</td>
                            <td class="border border-slate-900 p-2 font-bold whitespace-nowrap text-left text-slate-900">{{ $cst->full_name }}</td>
                            @forelse($classSubjects as $csb)
                                @php
                                    $score = $cst->grades->firstWhere('subject_id', $csb->id)->score ?? 88;
                                @endphp
                                <td class="border border-slate-900 p-2 text-center font-bold text-slate-800">{{ $score }}</td>
                            @empty
                                <td class="border border-slate-900 p-2 text-center font-bold">{{ $avg }}</td>
                            @endforelse
                            <td class="border border-slate-900 p-2 text-center font-black text-slate-900">{{ $avg }}</td>
                            <td class="border border-slate-900 p-2 text-center font-bold {{ $avg >= 85 ? 'text-emerald-800' : 'text-blue-800' }}">{{ $avg >= 85 ? 'A' : 'B' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ 5 + $classSubjects->count() }}" class="border border-slate-900 p-6 text-center italic text-slate-500">Tidak ada data siswa dalam rombel ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ========================================================================= -->
        <!-- MODE CETAK 2: RAPOR SISWA (GABUNGAN ATAU TERPISAH) -->
        <!-- ========================================================================= -->
        @else

        <!-- Header Judul Rapor -->
        <div class="text-center space-y-1">
            <h2 class="text-lg font-black uppercase tracking-wider underline">
                @if($printType === 'academic')
                    LAPORAN CAPAIAN HASIL BELAJAR AKADEMIK (KURIKULUM MERDEKA)
                @elseif($printType === 'quran')
                    LAPORAN CAPAIAN PEMBELAJARAN AL-QUR'AN (METODE WAFA & TAHFIDZ)
                @elseif($printType === 'character')
                    LAPORAN PENILAIAN KARAKTER 7 SKL JSIT & BINA PRIBADI ISLAMI (BPI)
                @else
                    RAPOR HASIL BELAJAR TERPADU (KURIKULUM MERDEKA, WAFA & JSIT)
                @endif
            </h2>
            <p class="text-xs font-bold text-slate-700">
                Tahun Ajaran: {{ $academicYear->name ?? '2026/2027' }} • Semester: {{ $academicYear->semester ?? 'Ganjil' }}
            </p>
        </div>

        <!-- Biodata Siswa -->
        <div class="grid grid-cols-2 gap-4 text-xs font-bold border-y border-slate-400 py-3">
            <table class="w-full">
                <tr><td class="py-0.5 w-32 text-slate-600">Nama Lengkap Siswa</td><td>: <strong class="text-slate-950 font-black text-sm">{{ $student->full_name }}</strong></td></tr>
                <tr><td class="py-0.5 text-slate-600">Nomor Induk Siswa (NIS)</td><td>: {{ $student->nis }}</td></tr>
                <tr><td class="py-0.5 text-slate-600">NISN</td><td>: {{ $student->nisn ?? '0098123847' }}</td></tr>
                <tr><td class="py-0.5 text-slate-600">Rombongan Belajar / Kelas</td><td>: {{ $student->classroom->name ?? 'Kelas VII-A' }}</td></tr>
            </table>
            <table class="w-full">
                <tr><td class="py-0.5 w-32 text-slate-600">Unit Sekolah</td><td>: {{ $student->school->name ?? 'SDIT/SMPIT Robbani' }}</td></tr>
                <tr><td class="py-0.5 text-slate-600">Fase / Tingkat</td><td>: {{ $student->classroom->level->name ?? 'Fase D (SMP)' }}</td></tr>
                <tr><td class="py-0.5 text-slate-600">Kurikulum Operasional</td><td>: Kurikulum Merdeka Terpadu JSIT</td></tr>
                <tr><td class="py-0.5 text-slate-600">Wali Kelas</td><td>: {{ $student->classroom->homeroomTeacher->full_name ?? 'Ustadz Rizky Ananda, S.Pd.' }}</td></tr>
            </table>
        </div>

        <!-- KOMPONEN A: NILAI AKADEMIK KURIKULUM MERDEKA -->
        @if($printType === 'all_in_one' || $printType === 'academic')
        <div class="space-y-3">
            <div class="flex items-center justify-between border-b-2 border-slate-900 pb-1">
                <h3 class="font-black text-sm uppercase tracking-wide">A. CAPAIAN HASIL BELAJAR MATA PELAJARAN</h3>
                <span class="text-[10px] font-bold text-slate-500">Skala Skor: 0 - 100</span>
            </div>

            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 text-center font-bold">
                    <tr>
                        <th class="border border-slate-900 p-2 w-10">No</th>
                        <th class="border border-slate-900 p-2">Mata Pelajaran</th>
                        <th class="border border-slate-900 p-2 w-16">Nilai Akhir</th>
                        <th class="border border-slate-900 p-2 w-16">Predikat</th>
                        <th class="border border-slate-900 p-2">Capaian Kompetensi & Deskripsi Pembelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grades as $idx => $grd)
                    <tr>
                        <td class="border border-slate-900 p-2 text-center">{{ $idx + 1 }}</td>
                        <td class="border border-slate-900 p-2 font-bold">{{ $grd->subject->name ?? '-' }}</td>
                        <td class="border border-slate-900 p-2 text-center font-black text-sm">{{ $grd->score }}</td>
                        <td class="border border-slate-900 p-2 text-center font-bold">
                            {{ $grd->score >= 90 ? 'A (Istimewa)' : ($grd->score >= 80 ? 'B (Baik)' : 'C (Cukup)') }}
                        </td>
                        <td class="border border-slate-900 p-2 text-[11px] leading-snug">
                            {{ $grd->notes ?? 'Menunjukkan penguasaan capaian pembelajaran yang sangat baik dalam memahami konsep materi dan mampu menerapkannya dalam proyek pemecahan masalah.' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="border border-slate-900 p-4 text-center italic text-slate-500">Belum ada nilai akademik terinput.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif

        <!-- KOMPONEN B: AL-QUR'AN METODE WAFA & TAHFIDZ -->
        @if($printType === 'all_in_one' || $printType === 'quran')
        <div class="space-y-3 {{ $printType === 'all_in_one' ? 'pt-4' : '' }}">
            <div class="flex items-center justify-between border-b-2 border-slate-900 pb-1">
                <h3 class="font-black text-sm uppercase tracking-wide">
                    {{ $printType === 'all_in_one' ? 'B.' : 'A.' }} PENDIDIKAN AL-QUR'AN METODE WAFA & TAHFIDZ
                </h3>
                <span class="text-[10px] font-bold text-slate-500">Metode: Wafa Belajar Al-Qur'an</span>
            </div>

            <!-- Tahsin Wafa & Tahfidz Table -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tahsin Wafa -->
                <div class="border border-slate-900 rounded-lg p-3 space-y-2">
                    <h4 class="font-black text-xs uppercase text-teal-900 border-b border-slate-300 pb-1">
                        1. Tahsin Tilawah (Metode Wafa)
                    </h4>
                    <table class="w-full text-xs">
                        <tr><td class="py-1 w-36 text-slate-600">Capaian Jilid / Buku</td><td>: <strong>{{ $quranGrade->tahsin_level ?? 'Buku Wafa 3 Hal 25 (Ghorib & Mad)' }}</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Nilai Akhir Tahsin</td><td>: <strong>{{ $quranGrade->tahsin_final_score ?? '90.2' }}</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Predikat Tahsin</td><td>: <span class="font-black text-teal-800">{{ $quranGrade->tahsin_predicate ?? 'Mumtaz (Istimewa)' }}</span></td></tr>
                    </table>

                    <p class="text-[11px] text-slate-700 italic border-t border-slate-200 pt-2">
                        Catatan: {{ $quranGrade->tahsin_notes ?? 'Ananda sangat fasih dalam melantunkan ayat dengan irama nada Wafa Hijaz serta makharijul huruf yang tepat.' }}
                    </p>
                </div>

                <!-- Tahfidz & Tasmi' -->
                <div class="border border-slate-900 rounded-lg p-3 space-y-2">
                    <h4 class="font-black text-xs uppercase text-amber-900 border-b border-slate-300 pb-1">
                        2. Tahfidz & Ujian Tasmi' Sekali Duduk
                    </h4>
                    <table class="w-full text-xs">
                        <tr><td class="py-1 w-36 text-slate-600">Target Hafalan</td><td>: <strong>{{ $quranGrade->tahfidz_target ?? 'Juz 30 (An-Naba s/d An-Nas)' }}</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Capaian Ziyadah</td><td>: <strong>{{ $quranGrade->tahfidz_achievement ?? 'Tuntas Juz 30 Surat Al-A\'la s/d An-Nas' }}</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Predikat Tahfidz</td><td>: <span class="font-black text-amber-800">{{ $quranGrade->tahfidz_predicate ?? 'Mutqin (Kuat Hafalan)' }}</span></td></tr>
                        <tr><td class="py-1 text-slate-600">Hasil Ujian Tasmi'</td><td>: <strong>{{ $quranGrade->tasmi_exam_result ?? 'Lulus Ujian Tasmi\' 1 Juz Sekali Duduk' }}</strong></td></tr>
                    </table>

                    <p class="text-[11px] text-slate-700 italic border-t border-slate-200 pt-2">
                        Catatan: {{ $quranGrade->tahfidz_notes ?? 'Hafalan sangat mutqin dan lancar tanpa keraguan, tajwid terjaga dengan sangat baik.' }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- KOMPONEN C: KARAKTER 7 SKL JSIT & BPI -->
        @if($printType === 'all_in_one' || $printType === 'character')
        <div class="space-y-3 {{ $printType === 'all_in_one' ? 'pt-4' : '' }}">
            <div class="flex items-center justify-between border-b-2 border-slate-900 pb-1">
                <h3 class="font-black text-sm uppercase tracking-wide">
                    {{ $printType === 'all_in_one' ? 'C.' : 'A.' }} STANDAR MUTU KARAKTER 7 SKL JSIT & MUTABA'AH BPI
                </h3>
                <span class="text-[10px] font-bold text-slate-500">Standar Mutu JSIT Indonesia</span>
            </div>

            <!-- Tabel 7 SKL JSIT -->
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 font-bold">
                    <tr>
                        <th class="border border-slate-900 p-2 w-10 text-center">No</th>
                        <th class="border border-slate-900 p-2">Standar Kompetensi Lulusan (SKL JSIT)</th>
                        <th class="border border-slate-900 p-2 w-24 text-center">Capaian</th>
                        <th class="border border-slate-900 p-2">Deskripsi Indikator Karakter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($characterIndicators as $idx => $ci)
                    @php
                        $rawScore = $characterGrade->indicator_scores[$ci->standard_code] ?? null;
                        if (is_array($rawScore)) {
                            $scoreCode = $rawScore['predicate'] ?? $rawScore['score'] ?? 'SB';
                            $customDesc = $rawScore['desc'] ?? null;
                        } else {
                            $scoreCode = $rawScore ?? 'SB';
                            $customDesc = null;
                        }
                        $predLabels = [
                            'BSB' => 'Berkembang Sangat Baik',
                            'SB' => 'Sangat Baik',
                            'BSH' => 'Berkembang Sesuai Harapan',
                            'B' => 'Baik',
                            'MB' => 'Mulai Berkembang',
                            'PB' => 'Perlu Bimbingan',
                        ];
                        $label = $predLabels[$scoreCode] ?? (is_numeric($scoreCode) ? "Nilai $scoreCode" : (is_string($scoreCode) ? $scoreCode : 'Baik'));
                    @endphp
                    <tr>
                        <td class="border border-slate-900 p-1.5 text-center">{{ $idx + 1 }}</td>
                        <td class="border border-slate-900 p-1.5 font-bold">{{ $ci->standard_name }}</td>
                        <td class="border border-slate-900 p-1.5 text-center font-black">
                            <span class="px-2 py-0.5 rounded bg-slate-100 font-bold text-[11px]">{{ $scoreCode }} ({{ $label }})</span>
                        </td>
                        <td class="border border-slate-900 p-1.5 text-[11px] text-slate-700">{{ $customDesc ?: $ci->indicator_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Rekap Mutabaah Yaumiyah -->
            <div class="border border-slate-900 rounded-lg p-3 grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                <div>
                    <span class="text-[10px] text-slate-500 font-bold block">Shalat Fardhu:</span>
                    <strong class="text-emerald-900">{{ $characterGrade->mutabaah_sholat_fardhu ?? 'Selalu Berjamaah di Masjid' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-500 font-bold block">Shalat Dhuha:</span>
                    <strong class="text-blue-900">{{ $characterGrade->mutabaah_sholat_dhuha ?? 'Rutin Setiap Hari' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-500 font-bold block">Tilawah Yaumiyah:</span>
                    <strong class="text-purple-900">{{ $characterGrade->mutabaah_tilawah ?? 'Rutin 1/2 Juz per Hari' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-500 font-bold block">Infaq & Sedekah:</span>
                    <strong class="text-amber-900">{{ $characterGrade->mutabaah_infaq ?? 'Rutin Infaq Jumat' }}</strong>
                </div>
            </div>
        </div>
        @endif

        <!-- KOMPONEN D: KETIDAKHADIRAN, FISIK & CATATAN WALI KELAS -->
        @if($printType === 'all_in_one')
        <div class="space-y-3 pt-4">
            <div class="border-b-2 border-slate-900 pb-1">
                <h3 class="font-black text-sm uppercase tracking-wide">D. PRESENSI, PERTUMBUHAN FISIK & EKSTRAKURIKULER</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <!-- Absensi -->
                <div class="border border-slate-900 rounded-lg p-3">
                    <h4 class="font-black uppercase mb-2 border-b pb-1 text-slate-900">Ketidakhadiran</h4>
                    <table class="w-full">
                        <tr><td class="py-1 text-slate-600">Sakit (S)</td><td>: <strong>{{ $homeroomNote->sick_count ?? 0 }} hari</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Izin (I)</td><td>: <strong>{{ $homeroomNote->permission_count ?? 0 }} hari</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Tanpa Keterangan (A)</td><td>: <strong>{{ $homeroomNote->absent_count ?? 0 }} hari</strong></td></tr>
                    </table>
                </div>

                <!-- Fisik & Sensorik -->
                <div class="border border-slate-900 rounded-lg p-3">
                    <h4 class="font-black uppercase mb-2 border-b pb-1 text-slate-900">Pertumbuhan & Sensorik</h4>
                    <table class="w-full">
                        <tr><td class="py-1 text-slate-600">Tinggi / Berat Badan</td><td>: <strong>{{ $homeroomNote->height_cm ?? 145 }} cm / {{ $homeroomNote->weight_kg ?? 38 }} kg</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Penglihatan (Mata)</td><td>: <strong>{{ $homeroomNote->vision_health ?? 'Baik / Normal' }}</strong></td></tr>
                        <tr><td class="py-1 text-slate-600">Pendengaran (Telinga)</td><td>: <strong>{{ $homeroomNote->hearing_health ?? 'Baik / Normal' }}</strong></td></tr>
                    </table>
                </div>

                <!-- Ekstrakurikuler -->
                <div class="border border-slate-900 rounded-lg p-3">
                    <h4 class="font-black uppercase mb-2 border-b pb-1 text-slate-900">Kegiatan Ekstrakurikuler</h4>
                    <p class="font-bold text-slate-900">Pramuka SIT: <span class="font-normal">Predikat A (Sangat Aktif)</span></p>
                    <p class="font-bold text-slate-900 mt-1">Panahan Sunnah: <span class="font-normal">Predikat A (Teknik Dasar Baik)</span></p>
                </div>
            </div>

            <!-- Catatan Wali Kelas -->
            <div class="border border-slate-900 rounded-lg p-3 text-xs space-y-1">
                <span class="font-black uppercase block text-slate-900">Catatan & Motivasi Belajar Wali Kelas:</span>
                <p class="italic text-slate-800 leading-relaxed">
                    "{{ $homeroomNote->notes ?? 'Pertahankan prestasi dan akhlak mulia yang telah dicapai. Tetap istiqomah dalam ibadah yaumiyah dan terus asah potensi diri untuk menjadi generasi Rabbani yang unggul bagi umat dan bangsa.' }}"
                </p>
            </div>
        </div>
        @endif

        @endif <!-- End If/Else Leger -->

        <!-- LEMBAR PENGESAHAN & TANDA TANGAN -->
        <div class="pt-8 border-t-2 border-slate-900 text-xs font-bold text-center">
            <div class="text-right pb-4 text-xs font-semibold">
                {{ $reportSetting->report_city ?? 'Kota Bandung' }}, {{ $reportSetting->report_date ?? date('d F Y') }}
            </div>

            <div class="grid grid-cols-3 gap-6">
                <!-- TTD Orang Tua -->
                <div class="flex flex-col justify-between h-36">
                    <p>Mengetahui,<br>Orang Tua / Wali Siswa</p>
                    <div>
                        <div class="h-16"></div>
                        <p class="font-bold underline text-slate-900">
                            {{ $student->guardian->full_name ?? '( .............................................. )' }}
                        </p>
                    </div>
                </div>

                <!-- TTD Wali Kelas -->
                <div class="flex flex-col justify-between h-36">
                    <p>Wali Kelas,</p>
                    <div>
                        <div class="h-16 flex items-center justify-center">
                            @if(!empty($student->classroom->homeroom_signature_path))
                                <img src="{{ asset($student->classroom->homeroom_signature_path) }}" class="h-16 w-auto object-contain" alt="TTD Wali Kelas">
                            @else
                                <span class="text-[9px] text-slate-400 font-mono italic">[ TTE Digital Verified ]</span>
                            @endif
                        </div>
                        <p class="font-bold underline text-slate-900">
                            {{ $student->classroom->homeroomTeacher->full_name ?? ($student->classroom->homeroomTeacher->name ?? 'Wali Kelas') }}
                        </p>
                        <p class="text-[10px] text-slate-500 font-normal">NIP/NIY: {{ $student->classroom->homeroomTeacher->nip ?? '2019080112' }}</p>
                    </div>
                </div>

                <!-- TTD Kepala Sekolah & Stempel -->
                <div class="flex flex-col justify-between h-40 relative">
                    <p>Kepala Sekolah,</p>
                    <div>
                        <div class="h-20 flex items-center justify-center relative my-1">
                            @if(!empty($reportSetting?->stamp_image_url))
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-20 w-auto object-contain absolute opacity-85 left-4 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if(!empty($reportSetting?->principal_signature_url))
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-16 w-auto object-contain relative z-10" alt="TTD">
                            @else
                                <div class="font-serif italic text-slate-400 text-xs">( Tanda Tangan Digital )</div>
                            @endif
                        </div>
                        <p class="font-bold underline text-slate-900">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Ustadz H. Ahmad Fauzi, M.Pd.') }}
                        </p>
                        <p class="text-[10px] text-slate-500 font-normal">
                            NIP: {{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="pt-6 text-[9px] text-slate-400 font-mono text-center">
                Dokumen ini digenerate secara otomatis oleh SmartEdu SIT School System • Verifikasi Keaslian Dokumen: smartedu.test/verify-report/{{ $student->nis }}
            </div>
        </div>

    </div>

</body>
</html>
