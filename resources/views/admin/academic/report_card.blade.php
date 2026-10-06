<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>
        @if($printType === 'academic')
            Rapor Akademik Kurikulum Merdeka - {{ $student->full_name }}
        @elseif($printType === 'cover')
            Cover & Profil Sekolah - {{ $student->full_name }}
        @elseif($printType === 'identity')
            Identitas Peserta Didik - {{ $student->full_name }}
        @elseif($printType === 'quran')
            Rapor Al-Qur'an Wafa & Tahfidz - {{ $student->full_name }}
        @elseif($printType === 'character')
            Rapor Karakter 7 SKL JSIT - {{ $student->full_name }}
        @elseif($printType === 'leger')
            Leger Nilai Kelas {{ $student->classroom->name ?? '' }}
        @else
            Rapor Terpadu Lengkap SIT Robbani - {{ $student->full_name }}
        @endif
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @page {
            size: {{ $printType === 'leger' ? 'A4 landscape' : 'A4 portrait' }};
            margin: {{ $printType === 'leger' ? '8mm 10mm 8mm 10mm' : '10mm 14mm 10mm 14mm' }};
        }

        @media print {
            .no-print { display: none !important; }
            body {
                background-color: #ffffff;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .page-break {
                page-break-after: always !important;
                break-after: page !important;
                display: block !important;
                clear: both !important;
                height: 0 !important;
            }
            .page-container {
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
                margin-bottom: 0 !important;
                min-height: 275mm !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
            }
            .page-container-cover {
                min-height: 270mm !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                text-align: center !important;
            }
            tr { page-break-inside: avoid !important; break-inside: avoid !important; }
            table { page-break-inside: auto !important; }
        }

        .border-double-custom {
            border-bottom: 3px solid #d97706;
            box-shadow: 0 1.5px 0 0 #0f172a;
        }
    </style>
</head>
<body class="p-4 sm:p-8 {{ $printType === 'leger' ? 'w-full max-w-[98%] mx-auto' : 'max-w-4xl mx-auto' }}">

    <!-- Top Action Bar (No-Print) -->
    <div class="no-print mb-6 bg-slate-900 text-white p-4 rounded-2xl flex items-center justify-between shadow-xl flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.academic.grades') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white font-bold text-xs transition">
                ← Kembali ke Sistem Nilai
            </a>
            <div>
                <h4 class="font-black text-sm text-emerald-400">
                    @if($printType === 'academic')
                        📄 Mode Cetak: Rapor Akademik (Kurikulum Merdeka Hal 1 & 2)
                    @elseif($printType === 'cover')
                        📕 Mode Cetak: Cover Rapor & Profil Singkat Sekolah
                    @elseif($printType === 'identity')
                        👤 Mode Cetak: Identitas Peserta Didik (Data Diri Siswa)
                    @elseif($printType === 'quran')
                        📖 Mode Cetak: Rapor Al-Qur'an Metode Wafa & Tahfidz
                    @elseif($printType === 'character')
                        🌙 Mode Cetak: Rapor Karakter 7 SKL JSIT & Mutaba'ah BPI
                    @elseif($printType === 'leger')
                        📊 Mode Cetak: Leger Rekap Nilai 1 Kelas
                    @else
                        ⭐ Mode Cetak: Rapor Lengkap All-in-One (Cover, Identitas, Rapor Merdeka, Wafa & JSIT)
                    @endif
                </h4>
                <p class="text-[11px] text-slate-300">
                    Siswa: <strong>{{ $student->full_name }}</strong> (NISN: {{ $student->nisn ?? '-' }} / NIS: {{ $student->nis }}) • {{ $student->school->name ?? 'SIT ROBBANI' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <!-- Format Switcher Buttons -->
            <div class="flex items-center bg-slate-800 p-1 rounded-xl flex-wrap gap-1">
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'all_in_one']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'all_in_one' ? 'bg-emerald-600 text-white' : 'text-slate-400 hover:text-white' }}" title="Cetak Seluruh Lembar Rapor Lengkap">
                    ⭐ Lengkap (All-in-One)
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'cover']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'cover' ? 'bg-blue-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Cover & Profil
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'identity']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'identity' ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Identitas Siswa
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'academic']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'academic' ? 'bg-cyan-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    Rapor Akademik
                </a>
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'quran']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'quran' ? 'bg-teal-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    {{ ($isSmp ?? false) ? 'TTQ Al-Qur\'an' : 'Qur\'an Wafa' }}
                </a>
                @if($isBpiAllowed ?? true)
                <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'character']) }}" class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $printType === 'character' ? 'bg-purple-600 text-white' : 'text-slate-400 hover:text-white' }}">
                    {{ ($isSmp ?? false) ? 'BPI SMP' : 'BPI & Karakter' }}
                </a>
                @endif
            </div>

            @if($printType === 'leger')
            <a href="{{ route('admin.academic.leger.export', ['classroom_id' => $student->classroom_id]) }}" 
               class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs rounded-xl shadow-lg transition active:scale-95 cursor-pointer flex items-center gap-1.5">
                <span>📥</span> <span>DOWNLOAD EXCEL</span>
            </a>
            @endif

            <!-- Tombol Download Word (.doc) -->
            <a href="{{ route('admin.academic.report-card.word', $student->id) }}" 
               class="px-3.5 py-2 bg-blue-600 hover:bg-blue-500 text-white font-black text-xs rounded-xl shadow-lg transition active:scale-95 cursor-pointer flex items-center gap-1.5"
               title="Unduh e-Rapor Microsoft Word (.doc) untuk diedit manual">
                <span>📝</span> <span>DOWNLOAD WORD (.DOC)</span>
            </a>

            <button onclick="window.print()" class="px-3.5 py-2 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs rounded-xl shadow-lg transition active:scale-95 cursor-pointer flex items-center gap-1.5">
                <span>🖨️</span> <span>CETAK / SIMPAN PDF</span>
            </button>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODE CETAK KHUSUS: LEGER NILAI 1 KELAS -->
    <!-- ========================================================================= -->
    @if($printType === 'leger')
    <div class="bg-white p-6 rounded-2xl border border-slate-300 shadow-md space-y-4 print:border-none print:p-0 print:shadow-none">
        <div class="text-center space-y-1 pb-2 border-b-2 border-slate-900">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-800">YAYASAN GENERASI ROBBANI SUMATERA SELATAN</h3>
            <h1 class="text-lg font-black uppercase text-slate-900 tracking-wider">SEKOLAH DASAR ISLAM TERPADU ROBBANI (SD IT ROBBANI)</h1>
            <h2 class="text-sm font-black uppercase tracking-wider underline">LEGER REKAPITULASI NILAI HASIL BELAJAR PESERTA DIDIK</h2>
            <p class="text-xs font-bold text-slate-700">Rombel: {{ $student->classroom->name ?? 'Kelas 1' }} • Tahun Ajaran: {{ $academicYear->name ?? '2025/2026' }} • Semester: {{ $academicYear->semester ?? 'Genap' }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-slate-900 text-[10px]">
                <thead class="bg-slate-100 text-center font-bold">
                    <tr>
                        <th class="border border-slate-900 p-1.5 w-8 text-center" rowspan="2">No</th>
                        <th class="border border-slate-900 p-1.5 whitespace-nowrap min-w-[80px] text-center" rowspan="2">NIS</th>
                        <th class="border border-slate-900 p-1.5 whitespace-nowrap min-w-[180px] text-left" rowspan="2">Nama Lengkap Siswa</th>
                        <th class="border border-slate-900 p-1 text-center" colspan="{{ $classSubjects->count() ?: 1 }}">Mata Pelajaran (Nilai Akhir)</th>
                        <th class="border border-slate-900 p-1.5 whitespace-nowrap w-16 text-center" rowspan="2">Rata-Rata</th>
                        <th class="border border-slate-900 p-1.5 whitespace-nowrap min-w-[110px] w-28 text-center" rowspan="2">Predikat</th>
                    </tr>
                    <tr>
                        @forelse($classSubjects as $csb)
                            <th class="border border-slate-900 p-1 text-[9px] min-w-[42px] font-bold text-center" title="{{ $csb->name }}">
                                {{ $csb->code ?? substr($csb->name, 0, 4) }}
                            </th>
                        @empty
                            <th class="border border-slate-900 p-1 text-[9px]">Nilai Rapor</th>
                        @endforelse
                    </tr>
                </thead>
                <tbody>
                    @forelse($classStudents as $idx => $cst)
                    @php
                        $stScores = $cst->grades->pluck('score')->filter()->toArray();
                        $avg = !empty($stScores) ? round(array_sum($stScores) / count($stScores), 1) : 85;
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="border border-slate-900 p-1.5 text-center">{{ $idx + 1 }}</td>
                        <td class="border border-slate-900 p-1.5 font-mono font-bold whitespace-nowrap text-center">{{ $cst->nis }}</td>
                        <td class="border border-slate-900 p-1.5 font-bold whitespace-nowrap text-left text-slate-900">{{ $cst->full_name }}</td>
                        @forelse($classSubjects as $csb)
                            @php
                                $score = $cst->grades->firstWhere('subject_id', $csb->id)->score ?? '-';
                                if (is_numeric($score)) $score = round($score);
                            @endphp
                            <td class="border border-slate-900 p-1 text-center font-bold text-slate-800">{{ $score }}</td>
                        @empty
                            <td class="border border-slate-900 p-1 text-center font-bold">{{ $avg }}</td>
                        @endforelse
                        <td class="border border-slate-900 p-1.5 text-center font-black text-slate-900">{{ $avg }}</td>
                        <td class="border border-slate-900 p-1.5 text-center font-bold whitespace-nowrap min-w-[110px] {{ $avg >= 85 ? 'text-emerald-800' : 'text-blue-800' }}">
                            {{ $avg >= 85 ? 'A (Istimewa)' : ($avg >= 75 ? 'B (Baik)' : 'C (Cukup)') }}
                        </td>
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
    @else

    <!-- ========================================================================= -->
    <!-- LEMBAR 1: COVER RAPOR PESERTA DIDIK RESMI SIT ROBBANI -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'cover')
    <div class="bg-white p-6 sm:p-10 rounded-2xl border border-slate-200 shadow-sm print:border-none print:p-0 print:shadow-none page-container page-container-cover">
        
        <div class="h-full flex flex-col justify-between py-6">
            
            <!-- 1. Header Cover: Instansi Pembina -->
            <div class="text-center space-y-1">
                <p class="text-[11px] font-bold tracking-[0.2em] uppercase text-slate-700">
                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                </p>
                <p class="text-[10px] font-black tracking-[0.25em] uppercase text-slate-900">
                    REPUBLIK INDONESIA
                </p>
                <p class="text-[9px] font-bold tracking-[0.15em] uppercase text-emerald-800">
                    JARINGAN SEKOLAH ISLAM TERPADU (JSIT) INDONESIA
                </p>
            </div>

            <!-- 2. Logo Resmi (BERSIH TANPA BORDER DI LUAR LOGO) -->
            <div class="flex justify-center my-6">
                @php
                    $coverLogo = $reportSetting?->school_logo_url ?? $student->school?->logo_url;
                @endphp
                @if(!empty($coverLogo) && file_exists(public_path($coverLogo)))
                    <img src="{{ asset($coverLogo) }}" class="h-32 sm:h-36 w-auto object-contain" alt="Logo Sekolah" style="border: none !important; box-shadow: none !important;">
                @else
                    <div class="flex flex-col items-center justify-center p-2 text-center">
                        <span class="text-xs font-black uppercase text-slate-700 tracking-tight">{{ ($isSmp ?? false) ? 'SMP Islam Terpadu' : 'SD Islam Terpadu' }}</span>
                        <span class="text-3xl font-black tracking-widest text-emerald-800">ROBBANI</span>
                        <span class="text-[10px] italic text-rose-600 font-bold mt-1">Because Every Child is Unique</span>
                    </div>
                @endif
            </div>

            <!-- 3. Judul Rapor Megah Bersih Modern (Tanpa Border Kuno) -->
            <div class="space-y-2 text-center">
                <h2 class="text-sm sm:text-base font-bold tracking-[0.25em] uppercase text-slate-700">
                    LAPORAN HASIL BELAJAR
                </h2>
                <h1 class="text-2xl sm:text-3xl font-black tracking-[0.15em] uppercase text-slate-900">
                    RAPOR PESERTA DIDIK
                </h1>
                <div class="inline-block px-5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200">
                    <p class="text-xs sm:text-sm font-black tracking-wider uppercase text-emerald-900">
                        {{ ($isSmp ?? false) ? 'SEKOLAH MENENGAH PERTAMA ISLAM TERPADU (SMP IT)' : 'SEKOLAH DASAR ISLAM TERPADU (SD IT)' }}
                    </p>
                </div>
                <p class="text-[10px] font-bold tracking-widest text-slate-500 uppercase pt-1">
                    Kurikulum Merdeka • Standar Mutu Kekhasan Sekolah Islam Terpadu
                </p>
            </div>

            <!-- 4. Plakat Identitas Siswa Bersih Modern -->
            <div class="w-full max-w-lg mx-auto my-6">
                <div class="border border-slate-300 bg-slate-50/80 p-5 rounded-2xl shadow-xs space-y-3">
                    <div class="text-center pb-2.5 border-b border-slate-200">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-500 block">Nama Lengkap Peserta Didik</span>
                        <h3 class="text-lg sm:text-xl font-black uppercase tracking-wide text-slate-950 mt-1">
                            {{ $student->full_name }}
                        </h3>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs font-serif pt-1">
                        <div class="bg-white p-2.5 rounded-xl border border-slate-200">
                            <span class="text-[9px] uppercase font-bold text-slate-500 block">NISN</span>
                            <span class="font-bold text-slate-900 tracking-wider">{{ $student->nisn ?? '-' }}</span>
                        </div>
                        <div class="bg-white p-2.5 rounded-xl border border-slate-200">
                            <span class="text-[9px] uppercase font-bold text-slate-500 block">Nomor Induk Siswa (NIS)</span>
                            <span class="font-bold text-slate-900 tracking-wider">{{ $student->nis }}</span>
                        </div>
                        <div class="bg-white p-2.5 rounded-xl border border-slate-200">
                            <span class="text-[9px] uppercase font-bold text-slate-500 block">Rombongan Belajar</span>
                            <span class="font-bold text-slate-900">{{ $student->classroom->name ?? 'Kelas' }}</span>
                        </div>
                        <div class="bg-white p-2.5 rounded-xl border border-slate-200">
                            <span class="text-[9px] uppercase font-bold text-slate-500 block">Tahun Pelajaran / Semester</span>
                            <span class="font-bold text-slate-900">{{ $academicYear->name ?? '2026/2027' }} ({{ $academicYear->semester ?? 'Ganjil' }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Footer Lembaga Satuan Pendidikan -->
            <div class="text-center space-y-1 pt-2 pb-2">
                <h3 class="text-sm sm:text-base font-black tracking-widest uppercase text-slate-900">
                    {{ $student->school->name ?? (($isSmp ?? false) ? 'SMP ISLAM TERPADU ROBBANI' : 'SD ISLAM TERPADU ROBBANI') }}
                </h3>
                <h4 class="text-xs font-bold tracking-wider uppercase text-slate-700">
                    YAYASAN GENERASI ROBBANI SUMATERA SELATAN
                </h4>
                <p class="text-[10px] font-semibold text-slate-500">
                    KABUPATEN OGAN ILIR • PROVINSI SUMATERA SELATAN
                </p>
            </div>

        </div>

    </div>
    <div class="page-break"></div>
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 2: PROFIL SATUAN PENDIDIKAN & LEMBAR PENGESAHAN DOKUMEN -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'cover')
    <div class="bg-white p-8 sm:p-12 rounded-2xl border border-slate-300 shadow-md space-y-6 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Profil Sekolah Bergaris Ganda -->
        <div class="text-center space-y-1 pb-4 border-b-2 border-slate-900">
            <h3 class="text-xs font-black uppercase tracking-widest text-slate-700">YAYASAN GENERASI ROBBANI SUMATERA SELATAN</h3>
            <h1 class="text-lg font-black uppercase tracking-wider text-slate-950">{{ $student->school->name ?? (($isSmp ?? false) ? 'SMP ISLAM TERPADU ROBBANI' : 'SD ISLAM TERPADU ROBBANI') }}</h1>
            <h2 class="text-sm font-black uppercase tracking-wider text-emerald-900 underline">PROFIL SATUAN PENDIDIKAN</h2>
            <p class="text-[10px] text-slate-600">NPSN: {{ $student->school->npsn ?? (($isSmp ?? false) ? '20198033' : '70014022') }} • NSS / NDS: {{ $reportSetting->nss_nds ?? $nssNds }} • Akreditasi: {{ $reportSetting->accreditation ?? $schoolAccreditation }}</p>
        </div>

        <!-- Tabel Profil Sekolah 13 Baris Resmi Sesuai Standar e-Rapor -->
        <div class="w-full py-2 text-xs font-serif">
            <table class="w-full border-2 border-slate-900 border-collapse text-left">
                <tbody>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="w-10 text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">1.</td>
                        <td class="w-56 py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Nama Satuan Pendidikan</td>
                        <td class="w-4 text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 font-black text-slate-950 uppercase">{{ $student->school->name ?? (($isSmp ?? false) ? 'SMP IT ROBBANI' : 'SDIT ROBBANI') }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">2.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">NPSN</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 font-bold text-slate-950">{{ $student->school->npsn ?? (($isSmp ?? false) ? '20198033' : '70014022') }}</td>
                    </tr>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">3.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">NSS / NDS</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 font-bold text-slate-950">{{ $reportSetting->nss_nds ?? $nssNds }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">4.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Status Akreditasi</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 font-black text-emerald-900">{{ $reportSetting->accreditation ?? $schoolAccreditation }}</td>
                    </tr>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">5.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Alamat Sekolah</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->address ?? (($isSmp ?? false) ? 'Jl Sarjana Gg. Padang Guci Kel. Timbangan' : 'Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan') }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">6.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Kelurahan / Desa</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->village ?? 'Timbangan' }}</td>
                    </tr>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">7.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Kecamatan</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->district ?? 'Indralaya Utara' }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">8.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Kabupaten / Kota</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->city ?? 'Ogan Ilir' }}</td>
                    </tr>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">9.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Provinsi</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->province ?? 'Sumatera Selatan' }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">10.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Kode Pos</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->postal_code ?? '30662' }}</td>
                    </tr>
                    <tr class="border-b border-slate-900 bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">11.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Telepon / Kontak</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-semibold">{{ $student->school->phone ?? (($isSmp ?? false) ? '+62 853-7719-3977' : '0811747472') }}</td>
                    </tr>
                    <tr class="border-b border-slate-900">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">12.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">Website Resmi</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-mono font-semibold">{{ $student->school->website ?? 'www.sitrobbani.sch.id' }}</td>
                    </tr>
                    <tr class="bg-slate-50">
                        <td class="text-center py-2 px-3 font-bold border-r border-slate-900 text-slate-900">13.</td>
                        <td class="py-2 px-3 font-bold text-slate-800 border-r border-slate-900">E-mail Resmi</td>
                        <td class="text-center font-bold border-r border-slate-900">:</td>
                        <td class="py-2 px-3 text-slate-900 font-mono font-semibold">{{ $student->school->email ?? (($isSmp ?? false) ? 'smpit@sitrobbani.sch.id' : 'sd@sitrobbani.sch.id') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pengesahan Resmi Kepala Sekolah (Fleksibel & Anti-Tumpang Tindih) -->
        @php
            $sigMode = $reportSetting->signature_mode ?? 'both';
            $hasStamp = !empty($reportSetting->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
            $hasSig = !empty($reportSetting->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
        @endphp
        <div class="pt-6 flex justify-end text-xs font-serif">
            <div class="w-72 text-center space-y-1">
                <p class="text-slate-800">{{ $reportSetting->report_city ?? 'Ogan Ilir' }}, {{ $reportSetting->report_date ?? '18 Juni 2026' }}</p>
                <p class="font-bold text-slate-900">Kepala Sekolah,</p>
                
                <div class="h-20 flex items-center justify-center relative my-1">
                    @if($showStamp)
                        <img src="{{ asset($reportSetting->stamp_image_url) }}" class="absolute left-6 w-20 h-20 object-contain opacity-80" alt="Stempel">
                    @endif
                    @if($showSig)
                        <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-16 w-auto object-contain relative z-10" alt="TTD Kepala Sekolah">
                    @endif
                </div>

                <p class="font-black text-slate-950 underline tracking-wide">
                    {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr')) }}
                </p>
                <p class="text-[11px] text-slate-700">
                    NIP. {{ $reportSetting->principal_nip ?? ($isSmp ? '142062021012' : '19850315 200904 1 003') }}
                </p>
            </div>
        </div>

        <div class="pb-6"></div>
    </div>
    <div class="page-break"></div>
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 3: IDENTITAS PESERTA DIDIK (DATA DIRI SISWA) -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'identity')
    <div class="bg-white p-8 sm:p-12 rounded-2xl border border-slate-300 shadow-md space-y-6 print:border-none print:p-0 print:shadow-none page-container">
        
        <div class="text-center pt-2 pb-4">
            <h2 class="text-base font-black uppercase tracking-wider text-slate-900 underline">
                IDENTITAS PESERTA DIDIK
            </h2>
        </div>

        <div class="text-xs space-y-2 leading-relaxed">
            <table class="w-full border-collapse">
                <tr class="h-7">
                    <td class="w-56 text-slate-800">Nama Peserta Didik</td>
                    <td class="w-4 text-center">:</td>
                    <td class="font-black text-slate-950 uppercase">{{ $student->full_name }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">NISN / NIS</td>
                    <td class="text-center">:</td>
                    <td class="font-bold text-slate-900">{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">Tempat, Tanggal Lahir</td>
                    <td class="text-center">:</td>
                    <td class="font-medium text-slate-900">
                        {{ $student->pob ?? 'Ogan Ilir' }}, {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->translatedFormat('d F Y') : '-' }}
                    </td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">Jenis Kelamin</td>
                    <td class="text-center">:</td>
                    <td class="font-medium text-slate-900">{{ $student->gender === 'F' ? 'Perempuan' : 'Laki-laki' }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">Agama</td>
                    <td class="text-center">:</td>
                    <td class="font-medium text-slate-900">Islam</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">Pendidikan Sebelumnya</td>
                    <td class="text-center">:</td>
                    <td class="font-medium text-slate-900">{{ $student->previous_school ?? 'TK IT ROBBANI' }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800">Alamat Peserta Didik</td>
                    <td class="text-center">:</td>
                    <td class="font-medium text-slate-900">{{ $student->address ?? 'Jl. Sarjana Perumahan Surya Akbar VI Blok A4' }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 font-bold" colspan="3">Nama Orang Tua</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">a. Ayah</td>
                    <td class="text-center">:</td>
                    <td class="font-bold text-slate-900">{{ $student->father_name }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">b. Ibu</td>
                    <td class="text-center">:</td>
                    <td class="font-bold text-slate-900">{{ $student->mother_name }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 font-bold" colspan="3">Pekerjaan Orang Tua</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">a. Ayah</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->father_job }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">b. Ibu</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->mother_job }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 font-bold" colspan="3">Alamat Orang Tua</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">a. Alamat</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->parent_address }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">b. Kelurahan / Desa</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->village }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">c. Kecamatan</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->district }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">d. Kabupaten / Kota</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->city }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">e. Provinsi</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->province }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 font-bold" colspan="3">Wali Peserta Didik</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">a. Nama</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->guardian_name }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">b. Pekerjaan</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->guardian_job }}</td>
                </tr>
                <tr class="h-7">
                    <td class="text-slate-800 pl-6">c. Alamat</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->guardian_address }}</td>
                </tr>
            </table>
        </div>

        <!-- Pas Foto 3x4 & Tanda Tangan Kepala Sekolah -->
        <div class="pt-6 flex items-end justify-between text-xs">
            <!-- Box Pas Foto -->
            <div class="w-28 h-36 border border-slate-900 flex flex-col items-center justify-center text-center p-1 text-slate-500 font-sans overflow-hidden relative bg-slate-50/50">
                @if(!empty($student->photo_path) && file_exists(public_path($student->photo_path)))
                    <img src="{{ asset($student->photo_path) }}" alt="Pas Foto {{ $student->full_name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-[11px] font-bold text-slate-700">Pas Foto</span>
                    <span class="text-[10px] text-slate-600">Ukuran</span>
                    <span class="text-[11px] font-black text-slate-800 mt-1">3 x 4</span>
                @endif
            </div>

            <!-- Titimangsa & Tanda Tangan Kepala Sekolah -->
            <div class="w-64 text-center space-y-1">
                <p class="text-slate-800">
                    {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                    {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}
                </p>
                <p class="font-bold text-slate-900">Kepala Sekolah,</p>
                @php
                    $sigMode = $reportSetting->signature_mode ?? 'both';
                    $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                    $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                    $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                    $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                @endphp
                <div class="h-16 flex items-center justify-center relative my-1">
                    @if($showStamp)
                        <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-2 z-0 pointer-events-none" alt="Stempel">
                    @endif
                    @if($showSig)
                        <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                    @endif
                </div>
                <p class="font-black text-slate-950 underline">
                    {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Nur Amalia, S.Pd., Gr') }}
                </p>
                <p class="text-[11px] text-slate-700">
                    NIP. {{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}
                </p>
            </div>
        </div>

    </div>
    <div class="page-break"></div>
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 4: LAPORAN HASIL BELAJAR - HALAMAN 1 (NILAI AKADEMIK NASIONAL) -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'academic')
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-5 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- KOP SURAT RESMI SDIT ROBBANI -->
        <div class="w-full pb-2 mb-2">
            @php
                $kopImage = $reportSetting?->kop_image_url ?: ($student->school?->kop_image_url ?: null);
                if (empty($kopImage) && file_exists(public_path('uploads/reports/kop_sd_robbani.png'))) {
                    $kopImage = 'uploads/reports/kop_sd_robbani.png';
                }
            @endphp

            @if(!empty($kopImage) && file_exists(public_path($kopImage)))
                <div class="text-center">
                    <img src="{{ asset($kopImage) }}" class="w-full max-h-36 object-contain mx-auto" alt="Kop Surat Resmi SDIT Robbani">
                </div>
            @else
                <!-- KOP HTML/CSS RESMI SESUAI FOTO RESMI SDIT ROBBANI -->
                <div class="border-double-custom pb-2 text-center relative flex items-center justify-between gap-4">
                    <!-- Logo JSIT Indonesia Kiri -->
                    <div class="w-20 text-center shrink-0">
                        <div class="text-emerald-700 font-black text-xs">JSIT</div>
                        <div class="text-[9px] font-bold text-amber-600">INDONESIA</div>
                        <div class="text-[7px] italic text-slate-500">Empowering Islamic Schools</div>
                    </div>

                    <!-- Teks Utama Tengah -->
                    <div class="flex-1 text-center space-y-0.5">
                        <h4 class="text-[11px] font-bold tracking-widest uppercase text-slate-800">
                            YAYASAN GENERASI ROBBANI SUMATERA SELATAN
                        </h4>
                        <h2 class="text-sm font-extrabold uppercase text-slate-900 tracking-wide">
                            SEKOLAH DASAR ISLAM TERPADU
                        </h2>
                        <h1 class="text-2xl font-black uppercase text-emerald-800 tracking-widest leading-none my-0.5">
                            ROBBANI
                        </h1>
                        <h3 class="text-[11px] font-black uppercase text-slate-900 tracking-wider">
                            TERAKREDITASI B
                        </h3>
                        <p class="text-[10px] text-slate-700">
                            Alamat : Jln Sarjana Blok A. Kel. Timbangan, Kec. Indralaya Utara Kab. Ogan Ilir
                        </p>
                        <p class="text-[10px] font-bold text-slate-800">
                            email : <span class="text-blue-700 underline">sdit@sitrobbani.sch.id</span> &nbsp;&nbsp; NPSN : 69957391
                        </p>
                    </div>

                    <!-- Logo Bulat SDIT Robbani Kanan -->
                    <div class="w-20 text-center shrink-0">
                        <div class="w-16 h-16 rounded-full border border-amber-500 bg-white mx-auto flex flex-col items-center justify-center p-1">
                            <span class="text-[7px] font-bold text-slate-700">SD IT</span>
                            <span class="text-[10px] font-black text-emerald-800">ROBBANI</span>
                            <span class="text-[6px] italic text-rose-600">Unique</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Judul Rapor -->
        <div class="text-center space-y-0.5 pt-1">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-900">
                LAPORAN HASIL BELAJAR
            </h2>
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900">
                (RAPOR)
            </h3>
        </div>

        <!-- Biodata Metadata Siswa (2 Kolom) -->
        <div class="grid grid-cols-2 gap-4 text-xs font-bold py-1 border-y border-slate-300">
            <table class="w-full">
                <tr class="h-5">
                    <td class="w-28 text-slate-700">Nama Murid</td>
                    <td class="w-3 text-center">:</td>
                    <td class="font-black text-slate-950">{{ $student->full_name }}</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">NISN</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->nisn ?? $student->nis }}</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">Sekolah</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">SD IT Robbani</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">Alamat</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900 font-normal">Jln. Sarjana Blok A</td>
                </tr>
            </table>
            <table class="w-full">
                <tr class="h-5">
                    <td class="w-28 text-slate-700">Kelas</td>
                    <td class="w-3 text-center">:</td>
                    <td class="text-slate-900">{{ $student->classroom->name ?? 'I (Satu)' }}</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">Fase</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $student->classroom->level->code ?? 'A' }}</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">Semester</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $academicYear->semester ?? 'II (Genap)' }}</td>
                </tr>
                <tr class="h-5">
                    <td class="text-slate-700">Tahun Pelajaran</td>
                    <td class="text-center">:</td>
                    <td class="text-slate-900">{{ $academicYear->name ?? '2025/2026' }}</td>
                </tr>
            </table>
        </div>

        <!-- Tabel Nilai Mapel Kurikulum Nasional (Merdeka) -->
        @php
            $nationalGrades = $nationalGrades ?? ($grades ?? collect([]));
            $mulokGrades = $mulokGrades ?? collect([]);
        @endphp
        <div class="space-y-1">
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 text-center font-bold">
                    <tr>
                        <th class="border border-slate-900 py-2 px-1 w-9 text-center">No</th>
                        <th class="border border-slate-900 py-2 px-2.5 w-48 text-center">Mata Pelajaran</th>
                        <th class="border border-slate-900 py-2 px-2 w-16 text-center whitespace-nowrap">Nilai Akhir</th>
                        <th class="border border-slate-900 py-2 px-3 text-center">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nationalGrades as $idx => $grd)
                    @php
                        $scoreVal = (float) $grd->score;
                        $formattedScore = round($scoreVal);
                        $notesText = $grd->notes ?? '';
                        // Pisahkan narasi jika mengandung pemisah standar
                        $parts = explode(" Namun perlu pendampingan pada: ", $notesText);
                        $highestPart = $parts[0] ?? $notesText;
                        $lowestPart = $parts[1] ?? '';
                    @endphp
                    <tr>
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold text-slate-800">{{ $idx + 1 }}</td>
                        <td class="border border-slate-900 py-2 px-2.5 font-bold text-slate-950">{{ $grd->subject->name ?? '-' }}</td>
                        <td class="border border-slate-900 py-2 px-2 text-center font-black text-sm text-slate-950 whitespace-nowrap">{{ $formattedScore }}</td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            @if(!empty($highestPart))
                                <p class="mb-1 text-slate-900">{{ $highestPart }}</p>
                            @endif
                            @if(!empty($lowestPart))
                                <p class="text-slate-700 italic">{{ $lowestPart }}</p>
                            @elseif(empty($highestPart))
                                <p>Ananda {{ $student->full_name }} menunjukkan penguasaan yang sangat baik dalam memahami materi capaian pembelajaran.</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border border-slate-900 p-4 text-center italic text-slate-500">Belum ada data nilai mata pelajaran nasional.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    <div class="page-break"></div>
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 5: LAPORAN HASIL BELAJAR - HALAMAN 2 (MULOK, EKSTRAKURIKULER, PRESENSI & KEPUTUSAN) -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'academic')
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-4 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Sub: MUATAN LOKAL -->
        <div class="space-y-1">
            <h4 class="text-xs font-black uppercase tracking-wider text-slate-900">MUATAN LOKAL</h4>
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 text-center font-bold">
                    <tr>
                        <th class="border border-slate-900 py-1.5 px-1 w-9 text-center">No</th>
                        <th class="border border-slate-900 py-1.5 px-2.5 w-48 text-center">Muatan Pelajaran</th>
                        <th class="border border-slate-900 py-1.5 px-2 w-16 text-center whitespace-nowrap">Nilai Akhir</th>
                        <th class="border border-slate-900 py-1.5 px-3 text-center">Capaian Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $mulokIdx = ($nationalGrades->count() ?: 7) + 1; @endphp
                    @forelse($mulokGrades as $mGrd)
                    @php
                        $mScore = round((float) $mGrd->score);
                        $mNotes = $mGrd->notes ?? '';
                        $mParts = explode(" Namun perlu pendampingan pada: ", $mNotes);
                        $mHigh = $mParts[0] ?? $mNotes;
                        $mLow = $mParts[1] ?? '';
                    @endphp
                    <tr>
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold">{{ $mulokIdx++ }}</td>
                        <td class="border border-slate-900 py-2 px-2.5 font-bold text-slate-950">{{ $mGrd->subject->name ?? '-' }}</td>
                        <td class="border border-slate-900 py-2 px-2 text-center font-black text-sm whitespace-nowrap">{{ $mScore }}</td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            @if(!empty($mHigh))
                                <p class="mb-1 text-slate-900">{{ $mHigh }}</p>
                            @endif
                            @if(!empty($mLow))
                                <p class="text-slate-700 italic">{{ $mLow }}</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="border border-slate-900 p-2 text-center italic text-slate-500">Tidak ada muatan lokal terpisah.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Tabel Ekstrakurikuler -->
        <div class="space-y-1 pt-1">
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 text-center font-bold">
                    <tr>
                        <th class="border border-slate-900 py-1.5 px-1 w-9 text-center">No</th>
                        <th class="border border-slate-900 py-1.5 px-3 w-64 text-center">Ekstrakurikuler</th>
                        <th class="border border-slate-900 py-1.5 px-3 text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-900 py-1.5 px-1 text-center font-bold">1</td>
                        <td class="border border-slate-900 py-1.5 px-3 font-bold text-slate-950">Life Skill / Kepanduan Pramuka SIT</td>
                        <td class="border border-slate-900 py-1.5 px-3 text-[11px] font-semibold text-slate-900">Baik, aktif dan berdisiplin tinggi dalam mengikuti pembinaan</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Grid 2 Kolom: Ketidakhadiran & Catatan Wali Kelas -->
        <div class="grid grid-cols-2 gap-3 text-xs pt-1">
            <!-- Tabel Ketidakhadiran -->
            <div>
                <table class="w-full border-collapse border border-slate-900 text-xs">
                    <thead class="bg-slate-100 text-center font-bold">
                        <tr>
                            <th class="border border-slate-900 py-1.5 px-3" colspan="2">Ketidakhadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-900 py-1.5 px-3 text-slate-800">Sakit</td>
                            <td class="border border-slate-900 py-1.5 px-3 text-center font-bold w-28">{{ $homeroomNote->sick_count ?? 0 }} hari</td>
                        </tr>
                        <tr>
                            <td class="border border-slate-900 py-1.5 px-3 text-slate-800">Izin</td>
                            <td class="border border-slate-900 py-1.5 px-3 text-center font-bold">{{ $homeroomNote->permission_count ?? 0 }} hari</td>
                        </tr>
                        <tr>
                            <td class="border border-slate-900 py-1.5 px-3 text-slate-800">Tanpa Keterangan</td>
                            <td class="border border-slate-900 py-1.5 px-3 text-center font-bold">{{ $homeroomNote->absent_count ?? 0 }} hari</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kotak Catatan Wali Kelas -->
            <div class="border border-slate-900 rounded-none flex flex-col justify-between">
                <div class="bg-slate-100 text-center font-bold py-1.5 px-3 border-b border-slate-900">
                    Catatan Wali Kelas
                </div>
                <div class="p-2.5 text-[11px] leading-relaxed italic text-slate-900 flex-1 flex items-center">
                    "{{ $homeroomNote->notes ?? 'Alhamdulillah ananda telah menyelesaikan pembelajaran dengan sangat baik. Terus tingkatkan semangat belajar dan amalkan adab Islami di kehidupan sehari-hari.' }}"
                </div>
            </div>
        </div>

        <!-- Grid 2 Kolom: Tanggapan Orangtua & Keputusan Kenaikan -->
        <div class="grid grid-cols-2 gap-3 text-xs pt-1">
            <!-- Tanggapan Orang Tua -->
            <div class="border border-slate-900 flex flex-col">
                <div class="bg-slate-100 text-center font-bold py-1.5 px-3 border-b border-slate-900">
                    Tanggapan Orangtua / Wali Murid
                </div>
                <div class="p-3 h-20"></div>
            </div>

            <!-- Keputusan Kenaikan Kelas -->
            <div class="border border-slate-900 flex flex-col justify-between p-2.5 space-y-1">
                <div class="text-center font-bold pb-1 border-b border-slate-400">
                    Keputusan
                </div>
                <div class="text-[11px] text-slate-900 space-y-1">
                    <p>Berdasarkan Hasil Capaian Pembelajaran dan Penilaian Akhir Semester I dan II</p>
                    <p class="font-bold">Ananda : <span class="uppercase font-black text-slate-950">{{ $student->full_name }}</span></p>
                    <p class="font-bold">Naik / <span class="line-through">Tinggal</span> *) kelas : <span class="font-black underline">{{ $student->classroom->name === 'Kelas 1' || str_contains($student->classroom->name ?? '', '1') ? 'II (Dua)' : 'Kelas Selanjutnya' }}</span></p>
                </div>
            </div>
        </div>

        <!-- Titimangsa & Tanda Tangan 3 Pihak Simetris Sesuai Format Rapor Resmi -->
        <div class="pt-4 text-xs font-bold">
            <table class="w-full border-none text-xs text-center" style="table-layout: fixed;">
                <tr>
                    <td class="w-1/3 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold">Mengetahui,</p>
                        <p class="font-bold">Orang Tua / Wali Siswa</p>
                    </td>
                    <td class="w-1/3 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold">Wali Kelas {{ $student->classroom->name ?? 'I (Satu)' }},</p>
                    </td>
                    <td class="w-1/3 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-semibold text-slate-800">
                            {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                            {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}
                        </p>
                        <p class="font-bold">Kepala Sekolah,</p>
                    </td>
                </tr>
                <tr style="height: 68px;">
                    <td class="text-center" style="vertical-align: middle;">
                        <!-- Area Tanda Tangan Orang Tua Fisik -->
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <!-- TTD Wali Kelas -->
                        @if(!empty($student->classroom->homeroom_signature_path) && file_exists(public_path($student->classroom->homeroom_signature_path)))
                            <img src="{{ asset($student->classroom->homeroom_signature_path) }}" class="h-14 max-w-[130px] object-contain mx-auto" alt="TTD Walas">
                        @endif
                    </td>
                    <td class="text-center" style="vertical-align: middle; position: relative;">
                        <!-- TTD Kepala Sekolah & Stempel -->
                        @php
                            $sigMode = $reportSetting->signature_mode ?? 'both';
                            $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                            $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                        @endphp
                        <div class="h-16 flex items-center justify-center relative">
                            @if($showStamp)
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-4 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if($showSig)
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center px-2" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 uppercase leading-snug">
                            {{ $student->father_name ?? ($student->guardian?->full_name ?? '( .................................................. )') }}
                        </p>
                        <p class="text-[10px] text-transparent select-none leading-tight mt-0.5">-</p>
                    </td>
                    <td class="text-center px-2" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $student->classroom->homeroomTeacher->full_name ?? ($student->classroom->homeroomTeacher->name ?? 'Ranti Saputri, S.TP') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIP/NIY: {{ $student->classroom->homeroomTeacher->nip ?? '199208152021042001' }}
                        </p>
                    </td>
                    <td class="text-center px-2" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Nur Amalia, S.Pd., Gr') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIP: {{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Catatan Footer Otomasi Sistem & Verifikasi -->
            <div class="mt-4 pt-2 border-t border-slate-300 text-center text-[9px] text-slate-500 font-sans">
                Dokumen ini diterbitkan secara resmi melalui SmartEdu SIT School System • Verifikasi Keaslian Dokumen: {{ config('app.url') ?? 'https://sitrobbani.sch.id' }}/verify-report/{{ $student->nis ?? $student->id }}
            </div>
        </div>

    </div>
    <div class="page-break"></div>
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 6: KEUNGGULAN KHAS SIT ROBBANI - AL-QUR'AN WAFA & TAHFIDZ -->
    <!-- ========================================================================= -->
    @if($printType === 'all_in_one' || $printType === 'quran')
    @if($isSmp ?? false)
    <!-- ========================================================================= -->
    <!-- LEMBAR AL-QUR'AN TTQ (TAHSIN & TAHFIDZ AL-QUR'AN) SMP ISLAM TERPADU ROBBANI -->
    <!-- (SESUAI DOKUMEN RESMI PDF 2) -->
    <!-- ========================================================================= -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-5 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Rapor TTQ Sesuai PDF 2 -->
        <div class="border-b-2 border-slate-900 pb-2 text-center space-y-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-800">SMP ISLAM TERPADU ROBBANI</h3>
            <h2 class="text-base font-black uppercase tracking-wider text-slate-950">
                LAPORAN ASESMEN AKHIR SEMESTER {{ strtoupper($academicYear->semester ?? 'GENAP') }}<br>
                TAHSIN TAHFIDZ QUR’AN (TTQ)
            </h2>
        </div>

        <!-- Biodata Siswa TTQ SMP Sesuai PDF 2 -->
        <div class="grid grid-cols-2 gap-x-8 gap-y-1.5 text-xs font-bold py-2 border-y border-slate-300">
            <div class="flex">
                <span class="w-36 text-slate-700">Nama Peserta Didik</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-black uppercase text-slate-950">{{ $student->full_name }}</span>
            </div>
            <div class="flex">
                <span class="w-32 text-slate-700">Kelas/Semester</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-black text-slate-950">{{ $student->classroom->name ?? 'VIII' }} / {{ $academicYear->semester ?? 'II' }}</span>
            </div>
            <div class="flex">
                <span class="w-36 text-slate-700">NIS</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-bold text-slate-900">{{ $student->nis }}</span>
            </div>
            <div class="flex">
                <span class="w-32 text-slate-700">Kelompok</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-black text-slate-950">{{ $quranGrade->quran_group ?? ($student->quran_group ?? 'Jannatu Al-Firdaus') }}</span>
            </div>
            <div class="flex">
                <span class="w-36 text-slate-700">NISN</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-bold text-slate-900">{{ $student->nisn ?? '-' }}</span>
            </div>
            <div class="flex">
                <span class="w-32 text-slate-700">Tahun Pelajaran</span>
                <span class="w-4">:</span>
                <span class="flex-1 font-bold text-slate-900">{{ $academicYear->name ?? '2025/2026' }}</span>
            </div>
        </div>

        <!-- Tabel 4 Target Pembelajaran TTQ SMP Sesuai PDF 2 -->
        <div class="space-y-1">
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 font-bold text-center">
                    <tr>
                        <th class="border border-slate-900 py-2 px-1 w-10 text-center">No</th>
                        <th class="border border-slate-900 py-2 px-3 w-64 text-center">Target Pembelajaran</th>
                        <th class="border border-slate-900 py-2 px-2 w-16 text-center">Nilai</th>
                        <th class="border border-slate-900 py-2 px-3 text-center">Capaian Pembelajaran</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Target 1: Hafalan -->
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold">1</td>
                        <td class="border border-slate-900 py-2.5 px-3 font-bold text-slate-950">
                            {{ $quranGrade->tahfidz_target ?? 'Hafalan Juz 1 ayat 1– 141 Ayat' }}
                        </td>
                        <td class="border border-slate-900 py-2.5 px-2 text-center font-black text-emerald-800 text-sm">
                            {{ $quranGrade->tahfidz_predicate ?? 'A' }}
                        </td>
                        <td class="border border-slate-900 py-2.5 px-3 text-[11px] leading-relaxed text-slate-800">
                            {{ $quranGrade->tahfidz_notes ?? ('Barakallah, ananda ' . ($student->nickname ?? $student->full_name) . ' sudah menuntaskan hafalan ' . ($quranGrade->tahfidz_target ?? 'target hafalan') . ' dengan sangat baik.') }}
                        </td>
                    </tr>

                    <!-- Target 2: Tahsin -->
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold">2</td>
                        <td class="border border-slate-900 py-2.5 px-3 font-bold text-slate-950">
                            Tahsin (Ghunnah, Nun mati/Tanwin, Mim Sukun, Idghom, Alif Lam, Lafdul Jalalah, Hukum Ro’, Qolqolah, Hukum Bacaan Panjang/Mad).
                        </td>
                        <td class="border border-slate-900 py-2.5 px-2 text-center font-black text-emerald-800 text-sm">
                            {{ $quranGrade->tahsin_predicate ?? 'A' }}
                        </td>
                        <td class="border border-slate-900 py-2.5 px-3 text-[11px] leading-relaxed text-slate-800">
                            {{ $quranGrade->tahsin_notes ?? ('Alhamdulillah, ananda ' . ($student->nickname ?? $student->full_name) . ' sudah sangat baik dalam memahami hukum tajwid yang telah dipelajari, hanya saja ananda masih perlu bimbingan ketika mengaplikasikan Mad saat membaca Al-Qur’an.') }}
                        </td>
                    </tr>

                    <!-- Target 3: Tilawah -->
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold">3</td>
                        <td class="border border-slate-900 py-2.5 px-3 font-bold text-slate-950">
                            Tilawah Al-Qur’an {{ $quranGrade->tahsin_level ?? 'Juz 1 – Juz 10' }}
                        </td>
                        <td class="border border-slate-900 py-2.5 px-2 text-center font-black text-emerald-800 text-sm">
                            {{ $quranGrade->tilawah_predicate ?? 'A' }}
                        </td>
                        <td class="border border-slate-900 py-2.5 px-3 text-[11px] leading-relaxed text-slate-800">
                            Alhamdulillah ananda {{ $student->nickname ?? $student->full_name }} sangat baik dalam tilawah. Semoga Ananda bisa lebih semangat lagi dalam tilawah dimana pun Ananda {{ $student->nickname ?? $student->full_name }} berada.
                        </td>
                    </tr>

                    <!-- Target 4: Santun & Adab -->
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold" rowspan="3">4</td>
                        <td class="border border-slate-900 py-2 px-3 font-semibold text-slate-900">
                            1. Senang membaca dan menghafal Al Qur’an
                        </td>
                        <td class="border border-slate-900 py-2 px-2 text-center font-black text-emerald-800 text-sm">
                            A
                        </td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            Alhamdulillah ananda {{ $student->nickname ?? $student->full_name }} sudah terbiasa membaca Al-Qur’an tanpa diingatkan oleh guru, namun tetap mohon bimbingan orang tua supaya Ananda senantiasa istiqomah dalam membaca Al-Qur’an di rumah.
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-900 py-2 px-3 font-semibold text-slate-900">
                            2. Sikap Memuliakan Al-Qur’an
                        </td>
                        <td class="border border-slate-900 py-2 px-2 text-center font-black text-emerald-800 text-sm">
                            A
                        </td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            MasyaAllah, ananda {{ $student->nickname ?? $student->full_name }} sudah dapat memuliakan Al Qur’an dengan sangat baik.
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-slate-900 py-2 px-3 font-semibold text-slate-900">
                            3. Adab Ketika belajar
                        </td>
                        <td class="border border-slate-900 py-2 px-2 text-center font-black text-emerald-800 text-sm">
                            A
                        </td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            Baarakallah ananda {{ $student->nickname ?? $student->full_name }} dalam pembelajaran Al Qur’an, sudah terbiasa mengucapkan terimakasih, meminta tolong jika perlu bantuan dan meminta maaf jika ada yang kurang berkenan dilakukan, baik terhadap guru atau temannya. Semoga Allah senantiasa menjaga ananda.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- TTD Guru Tahfidz & Kepala SMP Robbani Simetris Sesuai PDF 2 -->
        <div class="pt-6 text-xs font-bold">
            <table class="w-full border-none text-xs text-center" style="table-layout: fixed;">
                <tr>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-semibold text-slate-800">Mengetahui,</p>
                        <p class="font-bold text-slate-900">SMP Islam Terpadu Robbani</p>
                        <p class="font-bold text-slate-900">Kepala Sekolah</p>
                    </td>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-semibold text-slate-800">
                            {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                            {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '19 Juni 2026' }}
                        </p>
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold text-slate-900">Guru Tahfidz</p>
                    </td>
                </tr>
                <tr style="height: 65px;">
                    <td class="text-center" style="vertical-align: middle;">
                        @php
                            $sigMode = $reportSetting->signature_mode ?? 'both';
                            $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                            $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                        @endphp
                        <div class="h-16 flex items-center justify-center relative">
                            @if($showStamp)
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-12 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if($showSig)
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                            @endif
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align: middle;"></td>
                </tr>
                <tr>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Tia Wulandari, S.Pd.,Gr.') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIY. {{ $reportSetting->principal_nip ?? '142062021012' }}
                        </p>
                    </td>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">{{ $wafaTeacherName ?? 'Nurul Hamidah Yanti, S.E' }}</p>
                        <p class="text-[10px] text-slate-600 font-normal leading-tight mt-0.5">{{ $wafaTeacherTitle ?? 'Guru Tahfidz SMPIT Robbani' }}</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="page-break"></div>
    @else
    <!-- LEMBAR AL-QUR'AN METODE WAFA & TAHFIDZ SDIT ROBBANI -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-6 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Rapor Al-Qur'an Wafa -->
        <div class="border-b-2 border-slate-900 pb-2 text-center space-y-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-800">SEKOLAH DASAR ISLAM TERPADU ROBBANI</h3>
            <h2 class="text-base font-black uppercase tracking-wider text-teal-900">
                LAPORAN CAPAIAN PEMBELAJARAN AL-QUR'AN (METODE WAFA & TAHFIDZ)
            </h2>
            <p class="text-xs font-bold text-slate-700">Tahun Ajaran: {{ $academicYear->name ?? '2025/2026' }} • Semester: {{ $academicYear->semester ?? 'Genap' }}</p>
        </div>

        <!-- Biodata Ringkas -->
        <div class="grid grid-cols-2 gap-4 text-xs font-bold py-2 border-y border-slate-300">
            <div>Nama Santri: <span class="font-black uppercase text-slate-950">{{ $student->full_name }}</span></div>
            <div>Kelas / Rombel: <span class="font-black text-slate-950">{{ $student->classroom->name ?? 'Kelas 1' }}</span></div>
        </div>

        <!-- Bagian 1: Tahsin Wafa -->
        <div class="border border-slate-900 p-4 rounded-lg space-y-2">
            <div class="flex items-center justify-between border-b border-slate-300 pb-1.5">
                <h4 class="font-black text-xs uppercase text-teal-900">1. Tahsin Tilawah Al-Qur'an (Metode Otak Kanan Wafa)</h4>
                <span class="px-2.5 py-0.5 rounded bg-teal-100 text-teal-900 font-bold text-[10px]">Nada Hijaz Wafa</span>
            </div>

            <table class="w-full text-xs">
                <tr class="h-6"><td class="w-48 text-slate-700">Capaian Jilid / Buku Wafa</td><td class="w-3">:</td><td class="font-black text-slate-950">{{ $quranGrade->tahsin_level ?? 'Buku Wafa Jilid 2-3' }}</td></tr>
                <tr class="h-6"><td class="text-slate-700">Nilai Akhir Tahsin</td><td>:</td><td class="font-black text-slate-950">{{ $quranGrade->tahsin_final_score ?? 91 }}</td></tr>
                <tr class="h-6"><td class="text-slate-700">Predikat Capaian</td><td>:</td><td class="font-black text-teal-800">{{ $quranGrade->tahsin_predicate ?? 'Mumtaz (A)' }}</td></tr>
            </table>

            <div class="border-t border-slate-200 pt-2 text-[11px] leading-relaxed italic text-slate-800">
                <strong>Catatan Guru Al-Qur'an ({{ $wafaTeacherName ?? 'Ustadz / Ustadzah Wafa' }}):</strong> {{ $quranGrade->tahsin_notes ?? 'Ananda melantunkan ayat suci Al-Qur\'an dengan irama Hijaz Wafa yang merdu, tartil, dan tertib makharijul huruf.' }}
            </div>
        </div>

        <!-- Bagian 2: Tahfidz & Tasmi' -->
        <div class="border border-slate-900 p-4 rounded-lg space-y-2">
            <div class="flex items-center justify-between border-b border-slate-300 pb-1.5">
                <h4 class="font-black text-xs uppercase text-amber-900">2. Tahfidz Al-Qur'an & Ujian Tasmi' Sekali Duduk</h4>
                <span class="px-2.5 py-0.5 rounded bg-amber-100 text-amber-900 font-bold text-[10px]">Ziyadah & Muraja'ah</span>
            </div>

            <table class="w-full text-xs">
                <tr class="h-6"><td class="w-48 text-slate-700">Target Hafalan Semester</td><td class="w-3">:</td><td class="font-black text-slate-950">{{ $quranGrade->tahfidz_target ?? 'Juz 30 (An-Naas s/d Al-Humazah)' }}</td></tr>
                <tr class="h-6"><td class="text-slate-700">Capaian Ziyadah Hafalan</td><td>:</td><td class="font-black text-slate-950">{{ $quranGrade->tahfidz_achievement ?? 'Tuntas Surat Al-Fill s/d An-Naas' }}</td></tr>
                <tr class="h-6"><td class="text-slate-700">Predikat Hafalan</td><td>:</td><td class="font-black text-amber-800">{{ $quranGrade->tahfidz_predicate ?? 'Mumtaz (A - Mutqin)' }}</td></tr>
                <tr class="h-6"><td class="text-slate-700">Hasil Ujian Tasmi'</td><td>:</td><td class="font-black text-emerald-800">{{ $quranGrade->tasmi_exam_result ?? 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Mumtaz' }}</td></tr>
            </table>

            <div class="border-t border-slate-200 pt-2 text-[11px] leading-relaxed italic text-slate-800">
                <strong>Catatan Tahfidz:</strong> {{ $quranGrade->tahfidz_notes ?? 'Hafalan sangat mutqin dan lancar tanpa keraguan, tajwid terjaga dengan baik. Istiqomahkan muraja\'ah di rumah.' }}
            </div>
        </div>

        <!-- TTD Penguji Al-Qur'an & Kepala Sekolah Simetris -->
        <div class="pt-6 text-xs font-bold">
            <table class="w-full border-none text-xs text-center" style="table-layout: fixed;">
                <tr>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold">Penguji / Koordinator Al-Qur'an Wafa,</p>
                    </td>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-semibold text-slate-800">
                            {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                            {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}
                        </p>
                        <p class="font-bold">Kepala Sekolah,</p>
                    </td>
                </tr>
                <tr style="height: 65px;">
                    <td class="text-center" style="vertical-align: middle;"></td>
                    <td class="text-center" style="vertical-align: middle;">
                        @php
                            $sigMode = $reportSetting->signature_mode ?? 'both';
                            $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                            $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                        @endphp
                        <div class="h-16 flex items-center justify-center relative">
                            @if($showStamp)
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-12 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if($showSig)
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">{{ $wafaTeacherName ?? 'Ustadz / Ustadzah Wafa' }}</p>
                        <p class="text-[10px] text-slate-600 font-normal leading-tight mt-0.5">{{ $wafaTeacherTitle ?? 'Sertifikasi Wafa Indonesia' }}</p>
                    </td>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Nur Amalia, S.Pd., Gr') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIP: {{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="page-break"></div>
    @endif
    @endif

    <!-- ========================================================================= -->
    <!-- LEMBAR 7: KEUNGGULAN KHAS SIT ROBBANI - KARAKTER 7 SKL JSIT & MUTABA'AH BPI -->
    <!-- ========================================================================= -->
    @if(($printType === 'all_in_one' || $printType === 'character') && ($isBpiAllowed ?? true))
    @if($isSmp ?? false)
    <!-- ========================================================================= -->
    <!-- LEMBAR BPI (BINA PRIBADI ISLAM) SMP IT ROBBANI (SESUAI DOKUMEN RESMI PDF 3) -->
    <!-- ========================================================================= -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-6 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Rapor BPI Sesuai PDF 3 -->
        <div class="border-b-2 border-slate-900 pb-2 text-center space-y-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-800">SMP ISLAM TERPADU ROBBANI</h3>
            <h2 class="text-base font-black uppercase tracking-wider text-slate-950">
                LAPORAN PERKEMBANGAN BINA PRIBADI ISLAM (BPI)<br>
                SUMATIF AKHIR SEMESTER {{ strtoupper($academicYear->semester ?? 'GENAP') }}<br>
                TAHUN PELAJARAN {{ $academicYear->name ?? '2025-2026' }}
            </h2>
        </div>

        <!-- Biodata Siswa BPI SMP -->
        <div class="max-w-xl mx-auto w-full text-xs font-bold py-2 border-y border-slate-300 space-y-1.5">
            <div class="flex">
                <span class="w-36 text-slate-700">Nama</span>
                <span class="w-4">:</span>
                <span class="font-black uppercase text-slate-950">{{ $student->full_name }}</span>
            </div>
            <div class="flex">
                <span class="w-36 text-slate-700">Kelas/Semester</span>
                <span class="w-4">:</span>
                <span class="font-black text-slate-950">{{ $student->classroom->name ?? 'VIII (Delapan)' }}</span>
            </div>
            <div class="flex">
                <span class="w-36 text-slate-700">NIS/NISN</span>
                <span class="w-4">:</span>
                <span class="font-bold text-slate-900">{{ $student->nis }} / {{ $student->nisn ?? '-' }}</span>
            </div>
            <div class="flex">
                <span class="w-36 text-slate-700">Tahun Ajaran</span>
                <span class="w-4">:</span>
                <span class="font-bold text-slate-900">{{ $academicYear->name ?? '2025-2026' }}</span>
            </div>
        </div>

        @php
            $rawAkidah = $characterGrade->indicator_scores['akidah'] ?? $characterGrade->indicator_scores['salimul_aqidah'] ?? 'B';
            $akidahScore = is_array($rawAkidah) ? ($rawAkidah['predicate'] ?? 'B') : $rawAkidah;
            $rawIbadah = $characterGrade->indicator_scores['ibadah'] ?? $characterGrade->indicator_scores['shahihul_ibadah'] ?? 'C';
            $ibadahScore = is_array($rawIbadah) ? ($rawIbadah['predicate'] ?? 'C') : $rawIbadah;
            $bpiAttendance = $characterGrade->indicator_scores['bpi_attendance'] ?? [];
            $sakit = $bpiAttendance['sakit'] ?? '-';
            $izin = $bpiAttendance['izin'] ?? '-';
            $alpa = $bpiAttendance['alpa'] ?? '-';
            $totalPertemuan = $bpiAttendance['total'] ?? 3;
        @endphp

        <!-- A. Pengembangan -->
        <div class="space-y-1.5">
            <h4 class="font-black text-xs text-slate-900 uppercase">A. Pengembangan</h4>
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 font-bold">
                    <tr>
                        <th class="border border-slate-900 py-2 px-1 w-12 text-center">No</th>
                        <th class="border border-slate-900 py-2 px-4 text-left">Standar Kompetensi Lulusan</th>
                        <th class="border border-slate-900 py-2 px-4 w-28 text-center">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold">1</td>
                        <td class="border border-slate-900 py-2.5 px-4 font-bold text-slate-900">Memiliki Akidah yang lurus</td>
                        <td class="border border-slate-900 py-2.5 px-4 text-center font-black text-slate-950 text-sm">{{ $akidahScore }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-900 py-2.5 px-1 text-center font-bold">2</td>
                        <td class="border border-slate-900 py-2.5 px-4 font-bold text-slate-900">Melakukan Ibadah yang benar</td>
                        <td class="border border-slate-900 py-2.5 px-4 text-center font-black text-slate-950 text-sm">{{ $ibadahScore }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- B. Kehadiran -->
        <div class="space-y-1.5">
            <h4 class="font-black text-xs text-slate-900 uppercase">B. Kehadiran</h4>
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 font-bold">
                    <tr>
                        <th class="border border-slate-900 py-2 px-1 w-12 text-center">No</th>
                        <th class="border border-slate-900 py-2 px-4 text-left">Deskripsi</th>
                        <th class="border border-slate-900 py-2 px-4 w-40 text-center">Keterangan</th>
                        <th class="border border-slate-900 py-2 px-4 w-44 text-center">Jumlah Total Pertemuan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold">1.</td>
                        <td class="border border-slate-900 py-2 px-4 font-semibold text-slate-800">Sakit</td>
                        <td class="border border-slate-900 py-2 px-4 text-center font-bold">{{ $sakit }}</td>
                        <td class="border border-slate-900 py-2 px-4 text-center font-bold" rowspan="3">{{ $totalPertemuan }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold">2.</td>
                        <td class="border border-slate-900 py-2 px-4 font-semibold text-slate-800">Izin</td>
                        <td class="border border-slate-900 py-2 px-4 text-center font-bold">{{ $izin }}</td>
                    </tr>
                    <tr>
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold">3.</td>
                        <td class="border border-slate-900 py-2 px-4 font-semibold text-slate-800">Alpa</td>
                        <td class="border border-slate-900 py-2 px-4 text-center font-bold">{{ $alpa }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- C. Catatan Pembina & Standar Nilai Sesuai PDF 3 -->
        <div class="space-y-1.5">
            <h4 class="font-black text-xs text-slate-900 uppercase">C. Catatan Pembina</h4>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                <div class="sm:col-span-8 border border-slate-900 p-3.5 rounded text-xs leading-relaxed text-slate-900">
                    <p class="mb-2">
                        {{ $characterGrade->bpi_mentor_notes ?? ('Alhamdulillah, ananda ' . ($student->nickname ?? $student->full_name) . ' sudah baik dalam memahami materi akidah yang lurus dan cukup baik dalam memahami materi cara melakukan ibadah yang benar.') }}
                    </p>
                    <p>
                        Bismillah, ananda dapat terus belajar dan meningkatkan semangat dalam ibadah hariannya, sehingga kelak menjadi seorang muslim yang kaffah (sepenuhnya yang senantiasa bersandar pada Allah SWT).
                    </p>
                </div>
                <div class="sm:col-span-4 border border-slate-900 p-3 rounded text-[11px] leading-snug space-y-1 bg-slate-50/50">
                    <p class="font-bold text-slate-900">Keterangan:</p>
                    <table class="w-full text-[11px]">
                        <tr><td>1. A (Sangat baik)</td><td class="text-right font-semibold">80-100</td></tr>
                        <tr><td>2. B (Baik)</td><td class="text-right font-semibold">66-80</td></tr>
                        <tr><td>3. C (Cukup baik)</td><td class="text-right font-semibold">51-65</td></tr>
                        <tr><td>4. D (Kurang)</td><td class="text-right font-semibold">≤ 50</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- TTD Pembina BPI & Kepala SMP Robbani Simetris Sesuai PDF 3 -->
        <div class="pt-6 text-xs font-bold">
            <table class="w-full border-none text-xs text-center" style="table-layout: fixed;">
                <tr>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-semibold text-slate-800">Mengetahui,</p>
                        <p class="font-bold text-slate-900">SMP Islam Terpadu Robbani</p>
                        <p class="font-bold text-slate-900">Kepala Sekolah</p>
                    </td>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-semibold text-slate-800">
                            {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                            {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '19 Juni 2026' }}
                        </p>
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold text-slate-900">Pembina BPI</p>
                    </td>
                </tr>
                <tr style="height: 65px;">
                    <td class="text-center" style="vertical-align: middle;">
                        @php
                            $sigMode = $reportSetting->signature_mode ?? 'both';
                            $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                            $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                        @endphp
                        <div class="h-16 flex items-center justify-center relative">
                            @if($showStamp)
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-12 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if($showSig)
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                            @endif
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align: middle;"></td>
                </tr>
                <tr>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Tia Wulandari, S.Pd., Gr.') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIY. {{ $reportSetting->principal_nip ?? '142062021012' }}
                        </p>
                    </td>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">Syaifudin, S.Sn., Gr.</p>
                        <p class="text-[10px] text-slate-600 font-normal leading-tight mt-0.5">Pembina BPI SMPIT Robbani</p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="page-break"></div>
    @else
    <!-- LEMBAR BPI & KARAKTER 7 SKL JSIT SD (HANYA KELAS 4, 5, DAN 6) -->
    <div class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-300 shadow-md space-y-5 print:border-none print:p-0 print:shadow-none page-container">
        
        <!-- Header Rapor Karakter JSIT -->
        <div class="border-b-2 border-slate-900 pb-2 text-center space-y-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-800">JARINGAN SEKOLAH ISLAM TERPADU (JSIT) INDONESIA</h3>
            <h2 class="text-base font-black uppercase tracking-wider text-purple-900">
                LAPORAN PENILAIAN KARAKTER 7 SKL JSIT & MUTABA'AH BPI
            </h2>
            <p class="text-xs font-bold text-slate-700">Standar Mutu JSIT Indonesia • Tahun Ajaran: {{ $academicYear->name ?? '2025/2026' }} • Semester: {{ $academicYear->semester ?? 'Genap' }}</p>
        </div>

        <!-- Biodata Ringkas -->
        <div class="grid grid-cols-2 gap-4 text-xs font-bold py-2 border-y border-slate-300">
            <div>Nama Santri: <span class="font-black uppercase text-slate-950">{{ $student->full_name }}</span></div>
            <div>Kelas / Rombel: <span class="font-black text-slate-950">{{ $student->classroom->name ?? 'Kelas 4' }}</span></div>
        </div>

        <!-- Tabel 7 SKL JSIT (LEBAR KOLOM LEGA - TIDAK ADA TEKS TERPOTONG) -->
        <div class="space-y-1">
            <table class="w-full border-collapse border border-slate-900 text-xs">
                <thead class="bg-slate-100 font-bold text-center">
                    <tr>
                        <th class="border border-slate-900 py-2 px-1 w-9 text-center">No</th>
                        <th class="border border-slate-900 py-2 px-3 w-56 text-left">Standar Kompetensi Lulusan (SKL JSIT)</th>
                        <th class="border border-slate-900 py-2 px-3 min-w-[170px] w-48 text-center whitespace-nowrap">Capaian Karakter</th>
                        <th class="border border-slate-900 py-2 px-3 text-left">Deskripsi Pembiasaan Karakter</th>
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
                        <td class="border border-slate-900 py-2 px-1 text-center font-bold">{{ $idx + 1 }}</td>
                        <td class="border border-slate-900 py-2 px-3 font-bold text-slate-950">{{ $ci->standard_name }}</td>
                        <td class="border border-slate-900 py-2 px-3 text-center whitespace-nowrap font-black min-w-[170px]">
                            <span class="px-2.5 py-1 rounded bg-slate-100 border border-slate-300 text-[11px] font-bold inline-block whitespace-nowrap">
                                {{ $scoreCode }} ({{ $label }})
                            </span>
                        </td>
                        <td class="border border-slate-900 py-2 px-3 text-[11px] leading-relaxed text-slate-800">
                            {{ $customDesc ?: $ci->indicator_name }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Rekap Mutaba'ah Yaumiyah & Catatan BPI -->
        <div class="border border-slate-900 p-3 rounded space-y-2">
            <h4 class="font-black text-xs uppercase text-slate-900 border-b border-slate-200 pb-1">
                Rekapitulasi Mutaba'ah Yaumiyah & Ibadah Harian
            </h4>
            <div class="grid grid-cols-4 gap-2 text-xs">
                <div>
                    <span class="text-[10px] text-slate-600 block">Shalat Fardhu:</span>
                    <strong class="text-emerald-900">{{ $characterGrade->mutabaah_sholat_fardhu ?? 'Selalu Berjamaah di Masjid' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-600 block">Shalat Dhuha:</span>
                    <strong class="text-blue-900">{{ $characterGrade->mutabaah_sholat_dhuha ?? 'Rutin Berjamaah' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-600 block">Tilawah Yaumiyah:</span>
                    <strong class="text-purple-900">{{ $characterGrade->mutabaah_tilawah ?? '1 Lembar per Hari' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] text-slate-600 block">Infaq & Sedekah:</span>
                    <strong class="text-amber-900">{{ $characterGrade->mutabaah_infaq ?? 'Setiap Hari Jumat' }}</strong>
                </div>
            </div>
            <div class="border-t border-slate-200 pt-2 text-[11px] italic text-slate-800">
                <strong>Catatan Mentor BPI:</strong> "{{ $characterGrade->bpi_mentor_notes ?? 'Ananda memiliki akhlak yang santun, adab islami yang terjaga, serta rajin mengamalkan ibadah yaumiyah.' }}"
            </div>
        </div>

        <!-- TTD Pembimbing BPI & Kepala Sekolah Simetris -->
        <div class="pt-6 text-xs font-bold">
            <table class="w-full border-none text-xs text-center" style="table-layout: fixed;">
                <tr>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-bold text-transparent select-none">&nbsp;</p>
                        <p class="font-bold">Pembimbing Karakter BPI,</p>
                    </td>
                    <td class="w-1/2 pb-1 text-center" style="vertical-align: top;">
                        <p class="font-semibold text-slate-800">
                            {{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}, 
                            {{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}
                        </p>
                        <p class="font-bold">Kepala Sekolah,</p>
                    </td>
                </tr>
                <tr style="height: 65px;">
                    <td class="text-center" style="vertical-align: middle;"></td>
                    <td class="text-center" style="vertical-align: middle;">
                        @php
                            $sigMode = $reportSetting->signature_mode ?? 'both';
                            $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
                            $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
                            $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
                            $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
                        @endphp
                        <div class="h-16 flex items-center justify-center relative">
                            @if($showStamp)
                                <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-16 w-auto object-contain absolute opacity-80 left-12 z-0 pointer-events-none" alt="Stempel">
                            @endif
                            @if($showSig)
                                <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-14 w-auto object-contain relative z-10" alt="TTD">
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 uppercase leading-snug">Ustadz / Ustadzah Pembimbing</p>
                        <p class="text-[10px] text-slate-600 font-normal leading-tight mt-0.5">Pembina Bina Pribadi Islami</p>
                    </td>
                    <td class="text-center px-4" style="vertical-align: bottom;">
                        <p class="font-bold underline text-slate-950 leading-snug">
                            {{ $reportSetting->principal_name ?? ($student->school->principal_name ?? 'Nur Amalia, S.Pd., Gr') }}
                        </p>
                        <p class="text-[10px] text-slate-700 font-normal leading-tight mt-0.5">
                            NIP: {{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}
                        </p>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <div class="page-break"></div>
    @endif
    @elseif($printType === 'character' && !($isBpiAllowed ?? true))
    <!-- PEMBERITAHUAN ATURAN BPI UNTUK SD KELAS 1-3 -->
    <div class="bg-white p-8 sm:p-12 rounded-2xl border border-slate-300 shadow-md text-center space-y-4 max-w-xl mx-auto my-12 page-container">
        <div class="text-4xl">ℹ️</div>
        <h3 class="text-base font-black text-slate-900">Buku Rapor Siswa Kelas {{ $classroomGrade ?? 1 }} SD</h3>
        <p class="text-xs text-slate-600 leading-relaxed">
            Sesuai standar kurikulum SIT Robbani, Penilaian dan Buku Rapor <b>Bina Pribadi Islam (BPI)</b> resmi diselenggarakan khusus untuk <b>Jenjang SMP</b> serta <b>Jenjang SD Kelas 4, 5, dan 6</b>.
        </p>
        <p class="text-xs font-semibold text-emerald-800">
            Untuk peserta didik Kelas {{ $classroomGrade ?? 1 }} SD, lembar penilaian BPI tidak diwajibkan / tidak dicetak pada buku laporan hasil belajar.
        </p>
        <div class="pt-4">
            <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'all_in_one']) }}" class="px-4 py-2 rounded-xl bg-emerald-700 text-white font-bold text-xs inline-block">
                Kembali ke Rapor Lengkap
            </a>
        </div>
    </div>
    @endif

    @endif <!-- End Leger Check -->

</body>
</html>
