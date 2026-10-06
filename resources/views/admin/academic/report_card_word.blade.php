<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<meta charset="utf-8">
<title>e-Rapor SIT Robbani - Dokumen Word</title>
<!--[if gte mso 9]>
<xml>
<w:WordDocument>
<w:View>Print</w:View>
<w:Zoom>100</w:Zoom>
<w:DoNotOptimizeForBrowser/>
</w:WordDocument>
</xml>
<![endif]-->
<style>
@page Section1 {
    size: 595.3pt 841.9pt; /* A4 Portrait */
    margin: 28.3pt 35.4pt 28.3pt 35.4pt;
    mso-header-margin: 28.3pt;
    mso-footer-margin: 28.3pt;
    mso-paper-source: 0;
}
div.Section1 { page: Section1; }
body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 11pt;
    line-height: 1.25;
    color: #000000;
}
.page-break {
    mso-special-character: line-break;
    page-break-before: always;
    clear: both;
}
table {
    border-collapse: collapse;
    width: 100%;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
    margin-bottom: 8pt;
}
table.bordered, table.bordered th, table.bordered td {
    border: 1px solid #000000;
}
th, td {
    padding: 4pt 6pt;
    vertical-align: top;
}
th {
    font-weight: bold;
    text-align: center;
    background-color: #f2f2f2;
}
.text-center { text-align: center; }
.text-right { text-align: right; }
.text-left { text-align: left; }
.font-bold { font-weight: bold; }
.font-black { font-weight: 900; }
.uppercase { text-transform: uppercase; }
.cover-box {
    border: 3px double #064e3b;
    padding: 18pt;
    text-align: center;
}
.cover-student-box {
    border: 2px solid #064e3b;
    padding: 10pt;
    margin: 15pt auto;
    width: 80%;
    background-color: #fdfdfd;
}
.kop-header {
    border-bottom: 3px double #000000;
    padding-bottom: 6pt;
    margin-bottom: 12pt;
    text-align: center;
}
</style>
</head>
<body>
<div class="Section1">

@foreach($studentsData as $stIdx => $data)
@php
    $student = $data['student'];
    $grades = $data['grades'];
    $nationalGrades = $data['nationalGrades'];
    $mulokGrades = $data['mulokGrades'];
    $academicYear = $data['academicYear'];
    $quranGrade = $data['quranGrade'];
    $characterGrade = $data['characterGrade'];
    $homeroomNote = $data['homeroomNote'];
    $reportSetting = $data['reportSetting'];
    $quranCriteria = $data['quranCriteria'];
    $characterIndicators = $data['characterIndicators'];
    $isSmp = $data['isSmp'] ?? false;
    $isSd = $data['isSd'] ?? true;
    $classroomGrade = $data['classroomGrade'] ?? 1;
    $isBpiAllowed = $data['isBpiAllowed'] ?? true;
    $school = $student->school;
    $clsName = $student->classroom->name ?? 'Kelas';
    $walasName = $student->classroom->homeroomTeacher->name ?? 'Wali Kelas';
    $walasNip = $student->classroom->homeroomTeacher->nip ?? '-';
    $kepsekName = $reportSetting->principal_name ?? ($school->principal_name ?? 'Nur Amalia, S.Pd., Gr');
    $kepsekNip = $reportSetting->principal_nip ?? '19850315 200904 1 003';
    $titimangsa = ($reportSetting->report_city ?? 'Ogan Ilir') . ', ' . ($reportSetting->report_date ?? '18 Juni 2026');
@endphp

@if($stIdx > 0)
    <div class="page-break"></div>
@endif

<!-- ========================================================================= -->
<!-- 1. HALAMAN COVER RESMI E-RAPOR SIT -->
<!-- ========================================================================= -->
<div class="cover-box">
    <div style="font-size: 11pt; font-weight: bold; letter-spacing: 2px;">
        YAYASAN GENERASI ROBBANI SUMATERA SELATAN
    </div>
    <div style="font-size: 14pt; font-weight: 900; color: #064e3b; margin-top: 4pt;">
        {{ $isSmp ? 'SEKOLAH MENENGAH PERTAMA ISLAM TERPADU (SMPIT) ROBBANI' : 'SEKOLAH DASAR ISLAM TERPADU (SDIT) ROBBANI' }}
    </div>
    <div style="font-size: 9pt; font-weight: bold; color: #555555; margin-top: 2pt;">
        Terakreditasi B &bull; NPSN: {{ $school->npsn ?? ($isSmp ? '20198033' : '69957391') }}
    </div>

    <div style="margin: 30pt auto 20pt auto;">
        <div style="font-size: 20pt; font-weight: 900; letter-spacing: 1.5px; text-decoration: underline;">
            RAPOR HASIL BELAJAR
        </div>
        <div style="font-size: 13pt; font-weight: bold; margin-top: 6pt; color: #064e3b;">
            PESERTA DIDIK {{ $isSmp ? 'SEKOLAH MENENGAH PERTAMA (SMPIT)' : 'SEKOLAH DASAR (SDIT)' }}
        </div>
        <div style="font-size: 10pt; font-weight: bold; color: #666; margin-top: 4pt;">
            STANDAR KURIKULUM MERDEKA & JSIT INDONESIA
        </div>
    </div>

    <div class="cover-student-box">
        <div style="font-size: 9pt; font-weight: bold; color: #555;">NAMA LENGKAP PESERTA DIDIK:</div>
        <div style="font-size: 14pt; font-weight: 900; margin: 4pt 0; text-transform: uppercase; color: #000;">
            {{ $student->full_name }}
        </div>
        <div style="border-top: 1px solid #ccc; margin: 6pt 0; padding-top: 6pt; font-size: 10pt;">
            <strong>NISN / NIS:</strong> {{ $student->nisn ?? '-' }} / {{ $student->nis }}
        </div>
        <div style="font-size: 10pt;">
            <strong>Kelas / Rombel:</strong> {{ $clsName }}
        </div>
        <div style="font-size: 10pt; margin-top: 2pt;">
            <strong>Tahun Ajaran:</strong> {{ $academicYear->name ?? '2026/2027' }} (Semester {{ $academicYear->semester ?? 'Ganjil' }})
        </div>
    </div>

    <div style="margin-top: 40pt; font-size: 10pt; font-weight: bold;">
        KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI<br>
        JARINGAN SEKOLAH ISLAM TERPADU (JSIT) INDONESIA<br>
        REPUBLIK INDONESIA
    </div>
</div>

<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 2. HALAMAN PROFIL SATUAN PENDIDIKAN & IDENTITAS SEKOLAH -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 10pt; font-weight: bold;">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
    <div style="font-size: 13pt; font-weight: 900; margin: 2pt 0;">PROFIL SATUAN PENDIDIKAN & IDENTITAS SEKOLAH</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">BUKU LAPORAN HASIL BELAJAR PESERTA DIDIK</div>
</div>

<table class="bordered">
    <tr>
        <td style="width: 30pt; text-align: center; font-weight: bold;">1.</td>
        <td style="width: 170pt; font-weight: bold;">Nama Satuan Pendidikan</td>
        <td style="width: 15pt; text-align: center; font-weight: bold;">:</td>
        <td style="font-weight: 900; text-transform: uppercase;">{{ $school->name ?? ($isSmp ? 'SMP IT ROBBANI' : 'SD IT ROBBANI') }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">2.</td>
        <td style="font-weight: bold;">NPSN</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->npsn ?? ($isSmp ? '20198033' : '69957391') }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">3.</td>
        <td style="font-weight: bold;">NSS / NDS</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $isSmp ? '202110304002' : '102110304001' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">4.</td>
        <td style="font-weight: bold;">Status Akreditasi</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>Terakreditasi B (BAN-S/M)</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">5.</td>
        <td style="font-weight: bold;">Alamat Sekolah</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->address ?? 'Jln. Sarjana Blok A' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">6.</td>
        <td style="font-weight: bold;">Kelurahan / Desa</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->village ?? 'Timbangan' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">7.</td>
        <td style="font-weight: bold;">Kecamatan</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->district ?? 'Indralaya Utara' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">8.</td>
        <td style="font-weight: bold;">Kabupaten / Kota</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->city ?? 'Ogan Ilir' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">9.</td>
        <td style="font-weight: bold;">Provinsi</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->province ?? 'Sumatera Selatan' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">10.</td>
        <td style="font-weight: bold;">Kode Pos</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->postal_code ?? '30662' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">11.</td>
        <td style="font-weight: bold;">Telepon / Kontak</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->phone ?? '0813-6736-3153' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">12.</td>
        <td style="font-weight: bold;">Website Resmi</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->website ?? 'www.sitrobbani.sch.id' }}</td>
    </tr>
    <tr>
        <td style="text-align: center; font-weight: bold;">13.</td>
        <td style="font-weight: bold;">E-mail Resmi</td>
        <td style="text-align: center; font-weight: bold;">:</td>
        <td>{{ $school->email ?? 'sdit@sitrobbani.sch.id' }}</td>
    </tr>
</table>

<table style="margin-top: 25pt;">
    <tr>
        <td style="width: 55%;"></td>
        <td style="width: 45%; text-align: center;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 45pt;">Kepala Sekolah,</div>
            <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">{{ $kepsekName }}</div>
            <div style="font-size: 10pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 3. HALAMAN IDENTITAS PESERTA DIDIK -->
<!-- ========================================================================= -->
<div class="text-center" style="margin-bottom: 15pt;">
    <div style="font-size: 13pt; font-weight: 900; text-decoration: underline;">IDENTITAS PESERTA DIDIK</div>
</div>

<table style="border: none;">
    <tr>
        <td style="width: 160pt;">Nama Peserta Didik</td>
        <td style="width: 15pt; text-align: center;">:</td>
        <td style="font-weight: bold; text-transform: uppercase;">{{ $student->full_name }}</td>
    </tr>
    <tr>
        <td>NISN / NIS</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
    </tr>
    <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->pob ?? 'Ogan Ilir' }}, {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->translatedFormat('d F Y') : '-' }}</td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->gender === 'F' ? 'Perempuan' : 'Laki-laki' }}</td>
    </tr>
    <tr>
        <td>Agama</td>
        <td style="text-align: center;">:</td>
        <td>Islam</td>
    </tr>
    <tr>
        <td>Pendidikan Sebelumnya</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->previous_school ?? 'TK IT ROBBANI' }}</td>
    </tr>
    <tr>
        <td>Alamat Peserta Didik</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->address ?? 'Ogan Ilir, Sumatera Selatan' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 8pt;">Nama Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 15pt;">a. Ayah</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->father_name }}</td>
    </tr>
    <tr>
        <td style="padding-left: 15pt;">b. Ibu</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->mother_name }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 8pt;">Pekerjaan Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 15pt;">a. Ayah</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->father_job }}</td>
    </tr>
    <tr>
        <td style="padding-left: 15pt;">b. Ibu</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->mother_job }}</td>
    </tr>
    <tr>
        <td>Wali Peserta Didik (Jika Ada)</td>
        <td style="text-align: center;">:</td>
        <td>{{ $student->guardian_name }}</td>
    </tr>
</table>

<table style="margin-top: 25pt;">
    <tr>
        <td style="width: 25%; text-align: center; vertical-align: middle;">
            <div style="border: 1px solid #000; width: 85pt; height: 110pt; text-align: center; line-height: 110pt; font-size: 9pt; color: #777;">
                Pas Foto 3 x 4
            </div>
        </td>
        <td style="width: 30%;"></td>
        <td style="width: 45%; text-align: center;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 45pt;">Kepala Sekolah,</div>
            <div style="font-weight: bold; text-decoration: underline; text-transform: uppercase;">{{ $kepsekName }}</div>
            <div style="font-size: 10pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 4. LAPORAN CAPAIAN KOMPETENSI (NILAI MATA PELAJARAN KURIKULUM MERDEKA) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">LAPORAN HASIL BELAJAR (RAPOR) AKADEMIK</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR KURIKULUM MERDEKA</div>
</div>

<table style="border: none; margin-bottom: 8pt;">
    <tr>
        <td style="width: 15%;">Nama Siswa</td>
        <td style="width: 2%;">:</td>
        <td style="width: 43%; font-weight: bold;">{{ $student->full_name }}</td>
        <td style="width: 15%;">Kelas / Fajar</td>
        <td style="width: 2%;">:</td>
        <td style="width: 23%; font-weight: bold;">{{ $clsName }}</td>
    </tr>
    <tr>
        <td>NISN / NIS</td>
        <td>:</td>
        <td>{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
        <td>Semester</td>
        <td>:</td>
        <td>{{ $academicYear->semester ?? 'Ganjil' }}</td>
    </tr>
    <tr>
        <td>Nama Sekolah</td>
        <td>:</td>
        <td>{{ $school->name ?? 'SD IT ROBBANI' }}</td>
        <td>Tahun Ajaran</td>
        <td>:</td>
        <td>{{ $academicYear->name ?? '2026/2027' }}</td>
    </tr>
</table>

<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 150pt;">Mata Pelajaran</th>
            <th style="width: 45pt;">Nilai Akhir</th>
            <th>Capaian Kompetensi (Deskripsi Pembelajaran)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($nationalGrades as $idx => $g)
        <tr>
            <td class="text-center font-bold">{{ $idx + 1 }}</td>
            <td class="font-bold">{{ $g->subject->name ?? 'Mata Pelajaran' }}</td>
            <td class="text-center font-black" style="font-size: 11pt;">{{ round($g->score ?? 0) }}</td>
            <td style="font-size: 9.5pt; text-align: justify;">
                @if(!empty($g->competency_description))
                    {{ $g->competency_description }}
                @else
                    Ananda menunjukkan penguasaan materi yang baik pada capaian pembelajaran semester ini.
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center" style="font-style: italic;">Belum ada data nilai mata pelajaran yang tersimpan.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($mulokGrades->isNotEmpty())
<div style="font-weight: bold; margin: 8pt 0 4pt 0; font-size: 10pt;">Muatan Lokal & Kekhasan SIT:</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 150pt;">Mata Pelajaran Mulok</th>
            <th style="width: 45pt;">Nilai</th>
            <th>Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mulokGrades as $idx => $mg)
        <tr>
            <td class="text-center font-bold">{{ $idx + 1 }}</td>
            <td class="font-bold">{{ $mg->subject->name ?? 'Muatan Lokal' }}</td>
            <td class="text-center font-black">{{ round($mg->score ?? 0) }}</td>
            <td style="font-size: 9.5pt; text-align: justify;">{{ $mg->competency_description ?? 'Mencapai kompetensi muatan lokal dengan predikat baik.' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 5. LAPORAN PEMBELAJARAN AL-QUR'AN (METODE WAFA & TAHFIDZ) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">
        {{ $isSmp ? 'LAPORAN TILAWAH & TAHFIDZ AL-QUR\'AN (TTQ)' : 'LAPORAN PEMBELAJARAN AL-QUR\'AN METODE WAFA & TAHFIDZ' }}
    </div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR PENDIDIKAN AL-QUR'AN JSIT INDONESIA</div>
</div>

<div style="font-weight: bold; font-size: 11pt; margin-bottom: 4pt; color: #064e3b;">A. Tilawah Al-Qur'an (Metode Wafa)</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 180pt;">Aspek Penilaian Tilawah</th>
            <th style="width: 60pt;">Capaian / Nilai</th>
            <th>Keterangan / Deskripsi Kemajuan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="font-bold">Buku / Jilid Wafa & Halaman</td>
            <td class="text-center font-bold">{{ $quranGrade->wafa_level ?? 'Jilid 3' }}</td>
            <td>Kelancaran membaca ayat Al-Qur'an secara tartil sesuai kaidah Wafa.</td>
        </tr>
        <tr>
            <td class="text-center">2</td>
            <td class="font-bold">Ketepatan Makharijul Huruf</td>
            <td class="text-center font-bold">{{ $quranGrade->makhraj_score ?? '88' }} (B)</td>
            <td>Mampu melafalkan huruf hijaiyyah dari makhraj yang benar.</td>
        </tr>
        <tr>
            <td class="text-center">3</td>
            <td class="font-bold">Penerapan Kaidah Tajwid</td>
            <td class="text-center font-bold">{{ $quranGrade->tajwid_score ?? '86' }} (B)</td>
            <td>Menerapkan hukum mad, nun mati, dan mim mati secara konsisten.</td>
        </tr>
    </tbody>
</table>

<div style="font-weight: bold; font-size: 11pt; margin: 10pt 0 4pt 0; color: #064e3b;">B. Hafalan Al-Qur'an (Tahfidz)</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 140pt;">Juz / Surat Target</th>
            <th style="width: 80pt;">Predikat / Nilai</th>
            <th>Catatan Mutaba'ah Tahfidz</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="font-bold">{{ $quranGrade->tahfidz_surah ?? 'Juz 30 (An-Naba s.d An-Nas)' }}</td>
            <td class="text-center font-bold">{{ $quranGrade->tahfidz_score ?? '90' }} (Mumtaz)</td>
            <td style="font-size: 9.5pt;">{{ $quranGrade->tahfidz_notes ?? 'Alhamdulillah ananda mutqin dalam hafalan surat pendek dengan tajwid yang baik.' }}</td>
        </tr>
    </tbody>
</table>

@if($isBpiAllowed)
<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 6. LAPORAN KARAKTER 7 SKL JSIT & MUTABA'AH BPI -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">
        {{ $isSmp ? 'LAPORAN BINA PRIBADI ISLAM (BPI) & KARAKTER' : 'LAPORAN KARAKTER 7 SKL JSIT & BINA PRIBADI ISLAM' }}
    </div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR KOMPETENSI LULUSAN (SKL) JSIT INDONESIA</div>
</div>

<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 160pt;">Indikator 7 SKL JSIT</th>
            <th style="width: 65pt;">Predikat</th>
            <th>Deskripsi Perkembangan Karakter</th>
        </tr>
    </thead>
    <tbody>
        @php
            $sklList = [
                ['Salimul Aqidah (Akidah Bersih)', 'Mengenal rukun iman dan terbiasa berakidah lurus.'],
                ['Shahihul Ibadah (Ibadah Benar)', 'Rajin melaksanakan sholat fardhu dan ibadah yaumiyah.'],
                ['Matinul Khuluq (Akhlak Mulia)', 'Santun kepada guru dan orang tua, menyayangi sesama.'],
                ['Qodirun alal Kasbi (Mandiri)', 'Disiplin merawat perlengkapan pribadi dan mandiri belajar.'],
                ['Mutsaqqoful Fikri (Cerdas Berilmu)', 'Rasa ingin tahu tinggi, kritis, dan gemar membaca.'],
                ['Qowiyyul Jismi (Fisik Kuat & Tangkas)', 'Menjaga kebersihan jasmani dan aktif berolahraga.'],
                ['Munazzhamun fi Syu\'unihi (Tertib & Rapi)', 'Manajemen waktu baik dan menjaga kerapian seragam.']
            ];
        @endphp
        @foreach($sklList as $idx => $skl)
        <tr>
            <td class="text-center font-bold">{{ $idx + 1 }}</td>
            <td class="font-bold">{{ $skl[0] }}</td>
            <td class="text-center font-bold" style="color: #064e3b;">Sangat Baik (SB)</td>
            <td style="font-size: 9.5pt;">{{ $skl[1] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 8pt; border: 1px solid #ccc; padding: 6pt; background-color: #fafafa; font-size: 9.5pt;">
    <strong>Catatan Pembimbing Karakter & BPI:</strong><br>
    {{ $characterGrade->notes ?? 'Ananda menunjukkan antusiasme yang tinggi dalam pembiasaan ibadah harian. Terus dampingi dzikir pagi-petang dan sholat berjamaah di rumah.' }}
</div>
@endif

<div class="page-break"></div>

<!-- ========================================================================= -->
<!-- 7. CATATAN WALI KELAS, EKSTRAKURIKULER & REKAP KEHADIRAN -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">CATATAN PERKEMBANGAN & PENGESAHAN RAPOR</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">TAHUN AJARAN {{ $academicYear->name ?? '2026/2027' }}</div>
</div>

<div style="font-weight: bold; margin-bottom: 3pt;">A. Kegiatan Ekstrakurikuler</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 170pt;">Nama Kegiatan Ekstrakurikuler</th>
            <th style="width: 60pt;">Predikat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="font-bold">{{ $homeroomNote->extracurricular_name ?? 'Pramuka SIT' }}</td>
            <td class="text-center font-bold">Baik (B)</td>
            <td style="font-size: 9.5pt;">Aktif mengikuti latihan kepanduan dan memiliki jiwa kemandirian.</td>
        </tr>
    </tbody>
</table>

<div style="font-weight: bold; margin: 8pt 0 3pt 0;">B. Rekapitulasi Ketidakhadiran</div>
<table class="bordered" style="width: 50%;">
    <tr>
        <td style="width: 150pt;">Sakit (S)</td>
        <td style="width: 20pt; text-align: center;">:</td>
        <td style="font-weight: bold;">{{ $homeroomNote->sick_count ?? 0 }} hari</td>
    </tr>
    <tr>
        <td>Izin (I)</td>
        <td style="text-align: center;">:</td>
        <td style="font-weight: bold;">{{ $homeroomNote->permission_count ?? 0 }} hari</td>
    </tr>
    <tr>
        <td>Tanpa Keterangan (A)</td>
        <td style="text-align: center;">:</td>
        <td style="font-weight: bold;">{{ $homeroomNote->absent_count ?? 0 }} hari</td>
    </tr>
</table>

<div style="font-weight: bold; margin: 8pt 0 3pt 0;">C. Catatan Perkembangan & Motivasi Wali Kelas</div>
<div style="border: 1px solid #000; padding: 8pt; min-height: 50pt; font-size: 10pt; text-align: justify; background-color: #fafafa;">
    @if(!empty($homeroomNote->special_notes))
        {{ $homeroomNote->special_notes }}
    @else
        Barakallahu fiik ananda {{ $student->full_name }}. Terus pertahankan akhlak mulia dan semangat belajarmu. Semoga Allah SWT senantiasa memberikan kemudahan dalam menuntut ilmu dan meraih prestasi yang membanggakan.
    @endif
</div>

<table style="margin-top: 30pt; border: none;">
    <tr>
        <td style="width: 33%; text-align: center; vertical-align: top;">
            <div>Mengetahui,</div>
            <div style="font-weight: bold; margin-bottom: 50pt;">Orang Tua / Wali Siswa,</div>
            <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;">&nbsp;</div>
        </td>
        <td style="width: 34%; text-align: center; vertical-align: top;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-bottom: 50pt;">Wali Kelas,</div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $walasName }}</div>
            <div style="font-size: 9.5pt;">NIP. {{ $walasNip }}</div>
        </td>
        <td style="width: 33%; text-align: center; vertical-align: top;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 50pt;">Kepala Sekolah,</div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9.5pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

@endforeach

</div>
</body>
</html>
