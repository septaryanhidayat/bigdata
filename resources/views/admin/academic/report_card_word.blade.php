<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<meta charset="utf-8">
<title>e-Rapor SIT Robbani - Dokumen Word Resmi</title>
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
    font-size: 10.5pt;
    line-height: 1.25;
    color: #000000;
}
br.page-break {
    page-break-before: always;
    mso-special-character: line-break;
    clear: all;
}
table {
    border-collapse: collapse;
    width: 100%;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
    margin-bottom: 6pt;
}
table.bordered, table.bordered th, table.bordered td {
    border: 1px solid #000000;
}
th, td {
    padding: 3.5pt 5pt;
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
.kop-header {
    border-bottom: 2.5pt double #000000;
    padding-bottom: 5pt;
    margin-bottom: 10pt;
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
    $schoolAccreditation = $data['schoolAccreditation'] ?? ($reportSetting?->accreditation ?? 'Terakreditasi B (BAN-S/M)');
    $nssNds = $data['nssNds'] ?? ($reportSetting?->nss_nds ?? '102110304001');
    $quranCriteria = $data['quranCriteria'] ?? collect();
    $characterIndicators = $data['characterIndicators'] ?? collect();
    $isSmp = $data['isSmp'] ?? false;
    $isSd = $data['isSd'] ?? true;
    $classroomGrade = $data['classroomGrade'] ?? 1;
    $isBpiAllowed = $data['isBpiAllowed'] ?? true;
    $school = $student->school;
    $clsName = $student->classroom->name ?? 'Kelas 1';
    $walasName = $student->classroom->homeroomTeacher->name ?? 'Ranti Saputri, S.TP';
    $walasNip = $student->classroom->homeroomTeacher->nip ?? '199208152021042001';
    $kepsekName = $reportSetting->principal_name ?? ($school->principal_name ?? ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr'));
    $kepsekNip = $reportSetting->principal_nip ?? ($isSmp ? '142062021012' : '19850315 200904 1 003');
    $titimangsa = ($reportSetting->report_city ?? 'Ogan Ilir') . ', ' . ($reportSetting->report_date ?? ($isSmp ? '19 Juni 2026' : '18 Juni 2026'));
    $coverLogo = $reportSetting?->school_logo_url ?? $student->school?->logo_url;

    $sigMode = $reportSetting->signature_mode ?? 'both';
    $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
    $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
    $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
    $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);
@endphp

@if($stIdx > 0)
    <br clear="all" style="page-break-before:always; mso-special-character:line-break;" />
@endif

<!-- ========================================================================= -->
<!-- LEMBAR 1: COVER DEPAN RAPOR (BERSIH MODERN, TANPA BORDER FRAME & TANPA BORDER LOGO) -->
<!-- ========================================================================= -->
<div style="text-align: center; padding: 15pt 0;">
    
    <!-- 1. Instansi Pembina -->
    <div style="font-size: 10pt; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase;">
        KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
    </div>
    <div style="font-size: 11pt; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; margin: 2pt 0;">
        REPUBLIK INDONESIA
    </div>
    <div style="font-size: 9.5pt; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; color: #064e3b;">
        JARINGAN SEKOLAH ISLAM TERPADU (JSIT) INDONESIA
    </div>

    <!-- 2. Logo Resmi (Bersih Tanpa Border Luar) -->
    <div style="margin: 30pt auto 20pt auto;">
        @if(!empty($coverLogo) && file_exists(public_path($coverLogo)))
            <img src="{{ url($coverLogo) }}" width="140" style="border: 0; outline: none; margin: 0 auto; display: block;" alt="Logo SIT Robbani" />
        @else
            <div style="font-size: 11pt; font-weight: 900; text-transform: uppercase; color: #333;">
                {{ $isSmp ? 'SMP ISLAM TERPADU' : 'SD ISLAM TERPADU' }}
            </div>
            <div style="font-size: 26pt; font-weight: 900; color: #064e3b; letter-spacing: 2px; margin: 2pt 0;">
                ROBBANI
            </div>
            <div style="font-size: 8.5pt; font-style: italic; color: #b91c1c; font-weight: bold;">
                Because, Every Child is Unique
            </div>
        @endif
    </div>

    <!-- 3. Judul Rapor Megah -->
    <div style="margin-top: 20pt;">
        <div style="font-size: 13pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase;">
            LAPORAN HASIL BELAJAR
        </div>
        <div style="font-size: 20pt; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; margin: 4pt 0;">
            RAPOR PESERTA DIDIK
        </div>
        <div style="font-size: 12pt; font-weight: 900; color: #064e3b; text-transform: uppercase; margin-top: 3pt;">
            {{ $isSmp ? 'SEKOLAH MENENGAH PERTAMA ISLAM TERPADU (SMP IT)' : 'SEKOLAH DASAR ISLAM TERPADU (SD IT)' }}
        </div>
        <div style="font-size: 9pt; font-weight: bold; color: #555555; margin-top: 4pt;">
            Kurikulum Merdeka &bull; Standar Mutu Kekhasan Sekolah Islam Terpadu
        </div>
    </div>

    <!-- 4. Plakat Identitas Siswa -->
    <div style="margin: 25pt auto; width: 85%; border: 1px solid #777777; padding: 10pt 14pt; background-color: #fdfdfd; text-align: left;">
        <div style="text-align: center; border-bottom: 1px solid #cccccc; padding-bottom: 6pt; margin-bottom: 8pt;">
            <div style="font-size: 8.5pt; font-weight: bold; color: #666; text-transform: uppercase;">Nama Lengkap Peserta Didik</div>
            <div style="font-size: 14pt; font-weight: 900; text-transform: uppercase; color: #000000; margin-top: 2pt;">
                {{ $student->full_name }}
            </div>
        </div>
        <table style="width: 100%; border: none; font-size: 10pt; margin-bottom: 0;">
            <tr>
                <td style="width: 25%; font-weight: bold; padding: 2pt 0;">NISN</td>
                <td style="width: 3%; text-align: center; padding: 2pt 0;">:</td>
                <td style="width: 32%; padding: 2pt 0;">{{ $student->nisn ?? '-' }}</td>
                <td style="width: 18%; font-weight: bold; padding: 2pt 0;">Rombel</td>
                <td style="width: 3%; text-align: center; padding: 2pt 0;">:</td>
                <td style="width: 19%; padding: 2pt 0;">{{ $clsName }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold; padding: 2pt 0;">NIS</td>
                <td style="text-align: center; padding: 2pt 0;">:</td>
                <td style="padding: 2pt 0;">{{ $student->nis }}</td>
                <td style="font-weight: bold; padding: 2pt 0;">Tahun Ajaran</td>
                <td style="text-align: center; padding: 2pt 0;">:</td>
                <td style="padding: 2pt 0;">{{ $academicYear->name ?? '2026/2027' }} ({{ $academicYear->semester ?? 'Ganjil' }})</td>
            </tr>
        </table>
    </div>

    <!-- 5. Footer Lembaga Satuan Pendidikan -->
    <div style="margin-top: 35pt;">
        <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase; color: #000000;">
            {{ $student->school->name ?? ($isSmp ? 'SMP ISLAM TERPADU ROBBANI' : 'SD ISLAM TERPADU ROBBANI') }}
        </div>
        <div style="font-size: 10pt; font-weight: bold; text-transform: uppercase; margin: 3pt 0;">
            YAYASAN GENERASI ROBBANI SUMATERA SELATAN
        </div>
        <div style="font-size: 9pt; color: #444444;">
            KABUPATEN OGAN ILIR &bull; PROVINSI SUMATERA SELATAN
        </div>
    </div>

</div>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 2: PROFIL SATUAN PENDIDIKAN & IDENTITAS SEKOLAH (13 BARIS TABEL) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 9.5pt; font-weight: bold; text-transform: uppercase;">YAYASAN GENERASI ROBBANI SUMATERA SELATAN</div>
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase; margin: 2pt 0;">
        {{ $student->school->name ?? ($isSmp ? 'SMP ISLAM TERPADU ROBBANI' : 'SD ISLAM TERPADU ROBBANI') }}
    </div>
    <div style="font-size: 11pt; font-weight: 900; text-transform: uppercase; text-decoration: underline; color: #064e3b;">
        PROFIL SATUAN PENDIDIKAN
    </div>
    <div style="font-size: 8.5pt; color: #555; margin-top: 2pt;">
        NPSN: {{ $school->npsn ?? ($isSmp ? '20198033' : '70014022') }} &bull; NSS / NDS: {{ $nssNds }} &bull; Status Akreditasi: {{ $schoolAccreditation }}
    </div>
</div>

<table class="bordered">
    <tbody>
        <tr>
            <td style="width: 28pt; text-align: center; font-weight: bold;">1.</td>
            <td style="width: 170pt; font-weight: bold;">Nama Satuan Pendidikan</td>
            <td style="width: 12pt; text-align: center; font-weight: bold;">:</td>
            <td style="font-weight: 900; text-transform: uppercase;">{{ $school->name ?? ($isSmp ? 'SMP IT ROBBANI' : 'SDIT ROBBANI') }}</td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">2.</td>
            <td style="font-weight: bold;">NPSN</td>
            <td style="text-align: center; font-weight: bold;">:</td>
            <td style="font-weight: bold;">{{ $school->npsn ?? ($isSmp ? '20198033' : '70014022') }}</td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">3.</td>
            <td style="font-weight: bold;">NSS / NDS</td>
            <td style="text-align: center; font-weight: bold;">:</td>
            <td>{{ $nssNds }}</td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">4.</td>
            <td style="font-weight: bold;">Status Akreditasi</td>
            <td style="text-align: center; font-weight: bold;">:</td>
            <td style="font-weight: bold; color: #064e3b;">{{ $schoolAccreditation }}</td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold;">5.</td>
            <td style="font-weight: bold;">Alamat Sekolah</td>
            <td style="text-align: center; font-weight: bold;">:</td>
            <td>{{ $school->address ?? (($isSmp ?? false) ? 'Jl Sarjana Gg. Padang Guci Kel. Timbangan' : 'Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan') }}</td>
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
            <td>{{ $school->phone ?? (($isSmp ?? false) ? '+62 853-7719-3977' : '0811747472') }}</td>
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
            <td>{{ $school->email ?? (($isSmp ?? false) ? 'smpit@sitrobbani.sch.id' : 'sd@sitrobbani.sch.id') }}</td>
        </tr>
    </tbody>
</table>

<!-- Pengesahan Kepala Sekolah Lembar Profil -->
<table style="margin-top: 18pt; border: none;">
    <tr>
        <td style="width: 55%; border: none;"></td>
        <td style="width: 45%; text-align: center; border: none;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Kepala Sekolah,</div>
            <div style="height: 55pt; text-align: center;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="55" style="border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="55" style="border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 50pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9.5pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 3: IDENTITAS PESERTA DIDIK (DATA DIRI SISWA) -->
<!-- ========================================================================= -->
<div style="text-align: center; margin-bottom: 12pt;">
    <div style="font-size: 13pt; font-weight: 900; text-transform: uppercase; text-decoration: underline;">
        IDENTITAS PESERTA DIDIK
    </div>
</div>

<table style="border: none;">
    <tr>
        <td style="width: 160pt; border: none;">Nama Peserta Didik</td>
        <td style="width: 15pt; text-align: center; border: none;">:</td>
        <td style="font-weight: 900; text-transform: uppercase; border: none;">{{ $student->full_name }}</td>
    </tr>
    <tr>
        <td style="border: none;">NISN / NIS</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
    </tr>
    <tr>
        <td style="border: none;">Tempat, Tanggal Lahir</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->pob ?? 'Sambas' }}, {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->translatedFormat('d F Y') : '12 Mei 2018' }}</td>
    </tr>
    <tr>
        <td style="border: none;">Jenis Kelamin</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->gender === 'F' ? 'Perempuan' : 'Laki-laki' }}</td>
    </tr>
    <tr>
        <td style="border: none;">Agama</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">Islam</td>
    </tr>
    <tr>
        <td style="border: none;">Pendidikan Sebelumnya</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->previous_school ?? 'TK IT ROBBANI' }}</td>
    </tr>
    <tr>
        <td style="border: none;">Alamat Peserta Didik</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->address ?? 'Ogan Ilir, Sumatera Selatan' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 6pt; border: none;">Nama Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none;">a. Ayah</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->father_name ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none;">b. Ibu</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->mother_name ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 6pt; border: none;">Pekerjaan Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none;">a. Ayah</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->father_job ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none;">b. Ibu</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->mother_job ?? '-' }}</td>
    </tr>
    <tr>
        <td style="border: none;">Wali Peserta Didik (Jika Ada)</td>
        <td style="text-align: center; border: none;">:</td>
        <td style="border: none;">{{ $student->guardian_name ?? '-' }}</td>
    </tr>
</table>

<!-- Pas Foto 3x4 & Tanda Tangan Kepala Sekolah Lembar Identitas -->
<table style="margin-top: 20pt; border: none;">
    <tr>
        <td style="width: 25%; text-align: center; vertical-align: middle; border: none;">
            @if(!empty($student->photo_path) && file_exists(public_path($student->photo_path)))
                <img src="{{ url($student->photo_path) }}" width="85" style="border: 1px solid #000; outline: none; margin: 0 auto; display: block;" alt="Pas Foto" />
            @else
                <div style="border: 1px solid #000; width: 85pt; height: 110pt; text-align: center; line-height: 110pt; font-size: 9pt; color: #777; margin: 0 auto;">
                    Pas Foto 3 x 4
                </div>
            @endif
        </td>
        <td style="width: 30%; border: none;"></td>
        <td style="width: 45%; text-align: center; border: none;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Kepala Sekolah,</div>
            <div style="height: 55pt; text-align: center;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="55" style="border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="55" style="border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 50pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9.5pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 4: RAPOR HASIL BELAJAR AKADEMIK (KURIKULUM MERDEKA NASIONAL) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">LAPORAN HASIL BELAJAR (RAPOR) AKADEMIK</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR KURIKULUM MERDEKA</div>
</div>

<table style="border: none; margin-bottom: 8pt; font-size: 10pt;">
    <tr>
        <td style="width: 15%; border: none;">Nama Siswa</td>
        <td style="width: 2%; border: none;">:</td>
        <td style="width: 43%; font-weight: bold; border: none;">{{ $student->full_name }}</td>
        <td style="width: 15%; border: none;">Kelas / Rombel</td>
        <td style="width: 2%; border: none;">:</td>
        <td style="width: 23%; font-weight: bold; border: none;">{{ $clsName }}</td>
    </tr>
    <tr>
        <td style="border: none;">NISN / NIS</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
        <td style="border: none;">Semester</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ $academicYear->semester ?? 'Ganjil' }}</td>
    </tr>
    <tr>
        <td style="border: none;">Nama Sekolah</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ $school->name ?? ($isSmp ? 'SMP IT Robbani' : 'SDIT Robbani') }}</td>
        <td style="border: none;">Tahun Ajaran</td>
        <td style="border: none;">:</td>
        <td style="border: none;">{{ $academicYear->name ?? '2026/2027' }}</td>
    </tr>
</table>

<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 155pt;">Mata Pelajaran</th>
            <th style="width: 45pt;">Nilai Akhir</th>
            <th>Capaian Kompetensi (Deskripsi Pembelajaran)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($nationalGrades as $idx => $g)
        @php
            $scoreVal = round((float) ($g->score ?? 0));
            $notesText = $g->notes ?? $g->competency_description ?? '';
            $parts = explode(" Namun perlu pendampingan pada: ", $notesText);
            $highPart = $parts[0] ?? $notesText;
            $lowPart = $parts[1] ?? '';
        @endphp
        <tr>
            <td class="text-center font-bold">{{ $idx + 1 }}</td>
            <td class="font-bold">{{ $g->subject->name ?? 'Mata Pelajaran' }}</td>
            <td class="text-center font-black" style="font-size: 11pt;">{{ $scoreVal }}</td>
            <td style="font-size: 9.5pt; text-align: justify;">
                @if(!empty($highPart))
                    {{ $highPart }}
                @else
                    Ananda menunjukkan penguasaan materi yang baik pada capaian pembelajaran semester ini.
                @endif
                @if(!empty($lowPart))
                    <br><em>Namun perlu pendampingan pada: {{ $lowPart }}</em>
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

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 5: MUATAN LOKAL, EKSTRAKURIKULER, PRESENSI & PENGESAHAN 3 PIHAK -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">CATATAN PERKEMBANGAN & PENGESAHAN RAPOR</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">TAHUN AJARAN {{ $academicYear->name ?? '2026/2027' }}</div>
</div>

@if($mulokGrades->isNotEmpty())
<div style="font-weight: bold; margin: 4pt 0 3pt 0; font-size: 10pt; color: #064e3b;">A. Muatan Lokal & Kekhasan SIT:</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 155pt;">Mata Pelajaran Mulok</th>
            <th style="width: 45pt;">Nilai</th>
            <th>Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mulokGrades as $idx => $mg)
        @php
            $mScore = round((float) ($mg->score ?? 0));
        @endphp
        <tr>
            <td class="text-center font-bold">{{ $idx + 1 }}</td>
            <td class="font-bold">{{ $mg->subject->name ?? 'Muatan Lokal' }}</td>
            <td class="text-center font-black">{{ $mScore }}</td>
            <td style="font-size: 9.5pt; text-align: justify;">{{ $mg->notes ?? $mg->competency_description ?? 'Mencapai kompetensi muatan lokal dengan predikat baik.' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div style="font-weight: bold; margin: 8pt 0 3pt 0; font-size: 10pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'B.' : 'A.' }} Kegiatan Ekstrakurikuler
</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 165pt;">Nama Kegiatan Ekstrakurikuler</th>
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

<div style="font-weight: bold; margin: 8pt 0 3pt 0; font-size: 10pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'C.' : 'B.' }} Rekapitulasi Ketidakhadiran
</div>
<table class="bordered" style="width: 50%;">
    <tr>
        <td style="width: 150pt;">Sakit (S)</td>
        <td style="width: 15pt; text-align: center;">:</td>
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

<div style="font-weight: bold; margin: 8pt 0 3pt 0; font-size: 10pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'D.' : 'C.' }} Catatan Perkembangan & Motivasi Wali Kelas
</div>
<div style="border: 1px solid #000; padding: 7pt; min-height: 40pt; font-size: 9.5pt; text-align: justify; background-color: #fafafa; margin-bottom: 8pt;">
    @if(!empty($homeroomNote->notes))
        {{ $homeroomNote->notes }}
    @elseif(!empty($homeroomNote->special_notes))
        {{ $homeroomNote->special_notes }}
    @else
        Barakallahu fiik ananda {{ $student->full_name }}. Terus pertahankan akhlak mulia dan semangat belajarmu. Semoga Allah SWT senantiasa memberikan kemudahan dalam menuntut ilmu dan meraih prestasi yang membanggakan.
    @endif
</div>

<!-- Titimangsa & Tanda Tangan 3 Pihak Resmi -->
<table style="margin-top: 15pt; border: none;">
    <tr>
        <td style="width: 33%; text-align: center; vertical-align: top; border: none;">
            <div>Mengetahui,</div>
            <div style="font-weight: bold; margin-bottom: 45pt;">Orang Tua / Wali Siswa,</div>
            <div style="border-bottom: 1px solid #000; width: 80%; margin: 0 auto;">
                {{ $student->father_name ?? ($student->guardian?->full_name ?? '') }}
            </div>
        </td>
        <td style="width: 34%; text-align: center; vertical-align: top; border: none;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Wali Kelas {{ $clsName }},</div>
            <div style="height: 45pt; text-align: center;">
                @if(!empty($student->classroom->homeroom_signature_path) && file_exists(public_path($student->classroom->homeroom_signature_path)))
                    <img src="{{ url($student->classroom->homeroom_signature_path) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="TTD Walas" />
                @else
                    <div style="height: 40pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $walasName }}</div>
            <div style="font-size: 9pt;">NIP. {{ $walasNip }}</div>
        </td>
        <td style="width: 33%; text-align: center; vertical-align: top; border: none;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Kepala Sekolah,</div>
            <div style="height: 45pt; text-align: center;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 40pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 6: LAPORAN PEMBELAJARAN AL-QUR'AN (METODE WAFA & TAHFIDZ / TTQ) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">
        {{ $isSmp ? 'LAPORAN TILAWAH & TAHFIDZ AL-QUR\'AN (TTQ)' : 'LAPORAN PEMBELAJARAN AL-QUR\'AN METODE WAFA & TAHFIDZ' }}
    </div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR PENDIDIKAN AL-QUR'AN JSIT INDONESIA</div>
</div>

<div style="font-weight: bold; font-size: 10.5pt; margin-bottom: 4pt; color: #064e3b;">A. Tilawah Al-Qur'an (Metode Wafa)</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 175pt;">Aspek Penilaian Tilawah</th>
            <th style="width: 65pt;">Capaian / Nilai</th>
            <th>Keterangan / Deskripsi Kemajuan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="font-bold">Buku / Jilid Wafa & Halaman</td>
            <td class="text-center font-bold">{{ $quranGrade->wafa_level ?? $quranGrade->tahsin_level ?? 'Jilid 3' }}</td>
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

<div style="font-weight: bold; font-size: 10.5pt; margin: 9pt 0 4pt 0; color: #064e3b;">B. Hafalan Al-Qur'an (Tahfidz)</div>
<table class="bordered">
    <thead>
        <tr>
            <th style="width: 25pt;">No</th>
            <th style="width: 145pt;">Juz / Surat Target</th>
            <th style="width: 80pt;">Predikat / Nilai</th>
            <th>Catatan Mutaba'ah Tahfidz</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center">1</td>
            <td class="font-bold">{{ $quranGrade->tahfidz_target ?? $quranGrade->tahfidz_surah ?? 'Juz 30 (An-Naba s.d An-Nas)' }}</td>
            <td class="text-center font-bold">{{ $quranGrade->tahfidz_score ?? 90 }} ({{ $quranGrade->tahfidz_predicate ?? 'Mumtaz' }})</td>
            <td style="font-size: 9.5pt;">{{ $quranGrade->tahfidz_notes ?? 'Hafalan lancar dan mutqin, istiqomahkan muraja\'ah di rumah bersama orang tua.' }}</td>
        </tr>
    </tbody>
</table>

<!-- Pengesahan Guru Qur'an & Kepsek -->
<table style="margin-top: 18pt; border: none;">
    <tr>
        <td style="width: 50%; text-align: center; border: none;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-bottom: 45pt;">Koordinator / Guru Al-Qur'an Wafa,</div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $wafaTeacherName ?? 'Ustadz / Ustadzah Wafa' }}</div>
            <div style="font-size: 9pt;">{{ $wafaTeacherTitle ?? 'Sertifikasi Wafa Indonesia' }}</div>
        </td>
        <td style="width: 50%; text-align: center; border: none;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Kepala Sekolah,</div>
            <div style="height: 45pt; text-align: center;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 40pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

@if($isBpiAllowed)
<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-special-character:line-break;" />

<!-- ========================================================================= -->
<!-- LEMBAR 7: LAPORAN KARAKTER 7 SKL JSIT & BINA PRIBADI ISLAM (BPI) -->
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
            <td class="text-center font-bold" style="color: #064e3b;">SB (Sangat Baik)</td>
            <td style="font-size: 9.5pt;">{{ $skl[1] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 8pt; border: 1px solid #ccc; padding: 6pt; background-color: #fafafa; font-size: 9.5pt;">
    <strong>Catatan Pembimbing Karakter & BPI:</strong><br>
    {{ $characterGrade->notes ?? $characterGrade->bpi_mentor_notes ?? 'Ananda menunjukkan antusiasme yang tinggi dalam pembiasaan ibadah harian. Terus dampingi dzikir pagi-petang dan sholat berjamaah di rumah.' }}
</div>

<table style="margin-top: 18pt; border: none;">
    <tr>
        <td style="width: 50%; text-align: center; border: none;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-bottom: 45pt;">Pembina Bina Pribadi Islam (BPI),</div>
            <div style="font-weight: bold; text-decoration: underline;">Ustadz / Ustadzah Pembimbing</div>
            <div style="font-size: 9pt;">Pembina BPI Robbani</div>
        </td>
        <td style="width: 50%; text-align: center; border: none;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-bottom: 6pt;">Kepala Sekolah,</div>
            <div style="height: 45pt; text-align: center;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="45" style="border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 40pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>
@endif

@endforeach

</div>
</body>
</html>
