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
    size: 595.3pt 841.9pt; /* A4 Portrait: 210mm x 297mm */
    margin: 30.0pt 36.0pt 30.0pt 42.0pt; /* Top: ~1.05cm, Right: ~1.27cm, Bottom: ~1.05cm, Left: ~1.48cm */
    mso-header-margin: 20.0pt;
    mso-footer-margin: 20.0pt;
    mso-paper-source: 0;
}
div.Section1 { 
    page: Section1; 
}
body {
    font-family: 'Times New Roman', Times, serif;
    font-size: 10pt;
    line-height: 1.2;
    color: #000000;
}
table {
    border-collapse: collapse;
    width: 100%;
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
    margin-bottom: 4pt;
}
table.bordered, table.bordered th, table.bordered td {
    border: 0.75pt solid #000000;
}
th, td {
    padding: 2.5pt 4pt;
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
.text-justify { text-align: justify; }
.font-bold { font-weight: bold; }
.font-black { font-weight: 900; }
.uppercase { text-transform: uppercase; }
.kop-header {
    border-bottom: 2pt double #000000;
    padding-bottom: 4pt;
    margin-bottom: 8pt;
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
    $isTk = $data['isTk'] ?? false;
    $classroomGrade = $data['classroomGrade'] ?? 1;
    $isBpiAllowed = $data['isBpiAllowed'] ?? true;
    $school = $student->school;
    
    // Normalisasi Nama Rombel agar tidak duplikat "Wali Kelas Kelas"
    $rawClsName = $student->classroom->name ?? 'Kelas 1';
    $cleanClassroomName = preg_replace('/^(?:kelas|kls)\s+/i', '', trim($rawClsName));
    $clsName = 'Kelas ' . $cleanClassroomName;
    
    $walasName = $student->classroom->homeroomTeacher->name ?? 'Ranti Saputri, S.TP';
    $walasNip = $student->classroom->homeroomTeacher->nip ?? '199208152021042001';
    $kepsekName = $reportSetting->principal_name ?? ($school->principal_name ?? ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr'));
    $kepsekNip = $reportSetting->principal_nip ?? ($isSmp ? '142062021012' : '19850315 200904 1 003');
    $titimangsa = ($reportSetting->report_city ?? 'Ogan Ilir') . ', ' . ($reportSetting->report_date ?? ($isSmp ? '19 Juni 2026' : '18 Juni 2026'));

    // Logo Resmi Sekolah (Gunakan logo rasio 1:1 proporsional)
    $coverLogo = $reportSetting?->school_logo_url ?? $student->school?->logo_url;
    if (empty($coverLogo) || str_contains($coverLogo, 'logo_sd_robbani_cover.jpg')) {
        if (file_exists(public_path('images/logo-square-robbani.png'))) {
            $coverLogo = 'images/logo-square-robbani.png';
        } elseif (file_exists(public_path('images/logo-robbani-official.png'))) {
            $coverLogo = 'images/logo-robbani-official.png';
        }
    }

    $sigMode = $reportSetting->signature_mode ?? 'both';
    $hasStamp = !empty($reportSetting?->stamp_image_url) && file_exists(public_path($reportSetting->stamp_image_url));
    $hasSig = !empty($reportSetting?->principal_signature_url) && file_exists(public_path($reportSetting->principal_signature_url));
    $showStamp = $hasStamp && in_array($sigMode, ['both', 'stamp_only']);
    $showSig = $hasSig && in_array($sigMode, ['both', 'ttd_has_stamp', 'ttd_only']);

    // Sapaan Pendidik
    $wafaTeacherName = $data['wafaTeacherName'] ?? ($isTk ? 'Amah Nurul Hamidah, S.Pd.' : 'Bunda Nurul Hamidah, S.Pd.');
    $wafaTeacherTitle = $data['wafaTeacherTitle'] ?? ($isTk ? 'Sertifikasi Wafa Indonesia (Amah Wafa)' : 'Sertifikasi Wafa Indonesia (Bunda Wafa)');
@endphp

@if($stIdx > 0)
    <br clear="all" style="page-break-before:always; mso-break-type:section-break" />
@endif

<!-- ========================================================================= -->
<!-- LEMBAR 1: COVER DEPAN RESMI (BINGKAI GANDA ELEGAN STANDAR RAPOR KEMDIKBUD/JSIT) -->
<!-- ========================================================================= -->
<div style="border: 2.5pt double #064e3b; padding: 20pt 24pt; text-align: center; min-height: 720pt; box-sizing: border-box;">
    
    <!-- 1. Instansi Pembina -->
    <div style="font-size: 10.5pt; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; line-height: 1.3;">
        KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI<br>
        REPUBLIK INDONESIA
    </div>
    <div style="font-size: 10pt; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; color: #064e3b; margin-top: 3pt;">
        JARINGAN SEKOLAH ISLAM TERPADU (JSIT) INDONESIA
    </div>

    <!-- 2. Logo Resmi Proporsional (Simetris & Aspek Rasio 1:1) -->
    <table align="center" style="width: 100%; border: none; margin: 25pt auto 18pt auto;">
        <tr>
            <td style="text-align: center; vertical-align: middle; border: none; padding: 0;">
                @if(!empty($coverLogo) && file_exists(public_path($coverLogo)))
                    <img src="{{ url($coverLogo) }}" width="105" height="105" style="width: 80pt; height: 80pt; max-width: 80pt; max-height: 80pt; margin: 0 auto; display: block; border: 0;" alt="Logo SIT Robbani" />
                @else
                    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase; color: #333;">
                        {{ $isSmp ? 'SMP ISLAM TERPADU' : 'SD ISLAM TERPADU' }}
                    </div>
                    <div style="font-size: 26pt; font-weight: 900; color: #064e3b; letter-spacing: 2px; margin: 2pt 0;">
                        ROBBANI
                    </div>
                    <div style="font-size: 8.5pt; font-style: italic; color: #b91c1c; font-weight: bold;">
                        Because, Every Child is Unique
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <!-- 3. Judul Rapor Megah & Simetris -->
    <div style="margin-top: 15pt;">
        <div style="font-size: 13pt; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; color: #333333;">
            LAPORAN HASIL BELAJAR
        </div>
        <div style="font-size: 21pt; font-weight: 900; letter-spacing: 2px; text-transform: uppercase; color: #000000; margin: 4pt 0;">
            RAPOR PESERTA DIDIK
        </div>
        <div style="font-size: 12pt; font-weight: 900; color: #064e3b; text-transform: uppercase; margin-top: 3pt;">
            {{ $isSmp ? 'SEKOLAH MENENGAH PERTAMA ISLAM TERPADU (SMP IT)' : 'SEKOLAH DASAR ISLAM TERPADU (SD IT)' }}
        </div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #555555; margin-top: 4pt;">
            Kurikulum Merdeka &bull; Standar Mutu Kekhasan Sekolah Islam Terpadu
        </div>
    </div>

    <!-- 4. Plakat Identitas Siswa Mewah & Rapi -->
    <table align="center" style="width: 88%; border: 1.5pt solid #064e3b; background-color: #fafafa; margin: 30pt auto; border-collapse: collapse;">
        <tr>
            <td style="padding: 10pt 14pt; border: none;">
                <div style="text-align: center; border-bottom: 1pt solid #cbd5e1; padding-bottom: 5pt; margin-bottom: 8pt;">
                    <div style="font-size: 8.5pt; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">NAMA LENGKAP PESERTA DIDIK</div>
                    <div style="font-size: 14pt; font-weight: 900; text-transform: uppercase; color: #000000; margin-top: 3pt;">
                        {{ $student->full_name }}
                    </div>
                </div>
                <table style="width: 100%; border-collapse: separate; border-spacing: 8pt; margin-top: 4pt;">
                    <tr>
                        <td style="width: 50%; text-align: center; padding: 8pt 10pt; border: 1pt solid #cbd5e1; background-color: #ffffff;">
                            <div style="font-size: 8.5pt; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">NISN</div>
                            <div style="font-size: 11pt; font-weight: bold; color: #0f172a; margin-top: 3pt; letter-spacing: 0.5px;">{{ $student->nisn ?? '-' }}</div>
                        </td>
                        <td style="width: 50%; text-align: center; padding: 8pt 10pt; border: 1pt solid #cbd5e1; background-color: #ffffff;">
                            <div style="font-size: 8.5pt; font-weight: bold; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">NOMOR INDUK SISWA (NIS)</div>
                            <div style="font-size: 11pt; font-weight: bold; color: #0f172a; margin-top: 3pt; letter-spacing: 0.5px;">{{ $student->nis }}</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- 5. Footer Lembaga Satuan Pendidikan -->
    <div style="margin-top: 40pt;">
        <div style="font-size: 12.5pt; font-weight: 900; text-transform: uppercase; color: #000000; letter-spacing: 1px;">
            {{ $student->school->name ?? ($isSmp ? 'SMP ISLAM TERPADU ROBBANI' : 'SDIT ROBBANI') }}
        </div>
        <div style="font-size: 10.5pt; font-weight: bold; text-transform: uppercase; margin: 3pt 0; color: #064e3b;">
            YAYASAN GENERASI ROBBANI SUMATERA SELATAN
        </div>
        <div style="font-size: 9pt; font-weight: bold; color: #444444; letter-spacing: 0.5px;">
            KABUPATEN OGAN ILIR &bull; PROVINSI SUMATERA SELATAN
        </div>
    </div>

</div>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 2: PROFIL SATUAN PENDIDIKAN & IDENTITAS SEKOLAH -->
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
            <td style="width: 25pt; text-align: center; font-weight: bold;">1.</td>
            <td style="width: 160pt; font-weight: bold;">Nama Satuan Pendidikan</td>
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
<table style="width: 100%; margin-top: 15pt; border: none;">
    <tr>
        <td style="width: 55%; border: none;"></td>
        <td style="width: 45%; text-align: center; border: none; vertical-align: top;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-top: 2pt;">Kepala Sekolah,</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9.5pt; margin-top: 2pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 3: IDENTITAS PESERTA DIDIK (DATA DIRI + PAS FOTO 3X4 & TTD KEPSEK) -->
<!-- ========================================================================= -->
<div style="text-align: center; margin-bottom: 10pt;">
    <div style="font-size: 12.5pt; font-weight: 900; text-transform: uppercase; text-decoration: underline;">
        IDENTITAS PESERTA DIDIK
    </div>
</div>

<table style="width: 100%; border: none; font-size: 9.5pt; margin-bottom: 8pt;">
    <tr>
        <td style="width: 160pt; border: none; padding: 2pt 0;">Nama Peserta Didik</td>
        <td style="width: 15pt; text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="font-weight: 900; text-transform: uppercase; border: none; padding: 2pt 0;">{{ $student->full_name }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">NISN / NIS</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Tempat, Tanggal Lahir</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->pob ?? 'Sambas' }}, {{ $student->dob ? \Carbon\Carbon::parse($student->dob)->translatedFormat('d F Y') : '12 Mei 2018' }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Jenis Kelamin</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->gender === 'F' ? 'Perempuan' : 'Laki-laki' }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Agama</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">Islam</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Pendidikan Sebelumnya</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->previous_school ?? 'TK IT ROBBANI' }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Alamat Peserta Didik</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->address ?? 'Ogan Ilir, Sumatera Selatan' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 4pt; padding-bottom: 2pt; border: none;">Nama Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none; padding-top: 1pt; padding-bottom: 1pt;">a. Ayah</td>
        <td style="text-align: center; border: none; padding-top: 1pt; padding-bottom: 1pt;">:</td>
        <td style="border: none; padding-top: 1pt; padding-bottom: 1pt;">{{ $student->father_name ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none; padding-top: 1pt; padding-bottom: 1pt;">b. Ibu</td>
        <td style="text-align: center; border: none; padding-top: 1pt; padding-bottom: 1pt;">:</td>
        <td style="border: none; padding-top: 1pt; padding-bottom: 1pt;">{{ $student->mother_name ?? '-' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding-top: 4pt; padding-bottom: 2pt; border: none;">Pekerjaan Orang Tua</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none; padding-top: 1pt; padding-bottom: 1pt;">a. Ayah</td>
        <td style="text-align: center; border: none; padding-top: 1pt; padding-bottom: 1pt;">:</td>
        <td style="border: none; padding-top: 1pt; padding-bottom: 1pt;">{{ $student->father_job ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding-left: 18pt; border: none; padding-top: 1pt; padding-bottom: 1pt;">b. Ibu</td>
        <td style="text-align: center; border: none; padding-top: 1pt; padding-bottom: 1pt;">:</td>
        <td style="border: none; padding-top: 1pt; padding-bottom: 1pt;">{{ $student->mother_job ?? '-' }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 2pt 0;">Wali Peserta Didik (Jika Ada)</td>
        <td style="text-align: center; border: none; padding: 2pt 0;">:</td>
        <td style="border: none; padding: 2pt 0;">{{ $student->guardian_name ?? '-' }}</td>
    </tr>
</table>

<!-- Pas Foto 3x4 Proporsional & Tanda Tangan Kepala Sekolah (SIMETRIS DALAM HALAMAN YANG SAMA) -->
<table style="width: 100%; border: none; margin-top: 10pt; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
    <tr>
        <!-- Kotak Pas Foto 3x4 (Terkunci Dimensi 85pt x 113pt) -->
        <td style="width: 35%; text-align: center; vertical-align: middle; border: none; padding: 0;">
            <table align="center" style="width: 85pt; height: 113pt; border: 1pt solid #000000; border-collapse: collapse; margin: 0 auto; text-align: center;">
                <tr>
                    <td style="width: 85pt; height: 113pt; text-align: center; vertical-align: middle; padding: 0; background-color: #f8fafc;">
                        @if(!empty($student->photo_path) && file_exists(public_path($student->photo_path)))
                            <img src="{{ url($student->photo_path) }}" width="113" height="151" style="width: 85pt; height: 113pt; max-width: 85pt; max-height: 113pt; display: block; margin: 0 auto; border: 0;" alt="Pas Foto Siswa" />
                        @else
                            <div style="font-size: 9pt; color: #64748b; line-height: 1.3; font-family: 'Times New Roman', serif;">
                                <br><br>
                                <strong>PAS FOTO</strong><br>
                                3 x 4 cm
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
        <td style="width: 25%; border: none;">&nbsp;</td>
        <!-- Pengesahan Kepala Sekolah -->
        <td style="width: 40%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div style="font-size: 10pt;">{{ $titimangsa }}</div>
            <div style="font-size: 10pt; font-weight: bold; margin-top: 2pt; margin-bottom: 2pt;">Kepala Sekolah,</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-size: 10pt; font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 4: RAPOR HASIL BELAJAR AKADEMIK (KURIKULUM MERDEKA NASIONAL) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">LAPORAN HASIL BELAJAR (RAPOR) AKADEMIK</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR KURIKULUM MERDEKA</div>
</div>

<table style="width: 100%; border: none; margin-bottom: 6pt; font-size: 9.5pt;">
    <tr>
        <td style="width: 14%; border: none; padding: 1.5pt 0;">Nama Siswa</td>
        <td style="width: 2%; border: none; padding: 1.5pt 0;">:</td>
        <td style="width: 44%; font-weight: bold; border: none; padding: 1.5pt 0;">{{ $student->full_name }}</td>
        <td style="width: 15%; border: none; padding: 1.5pt 0;">Kelas / Rombel</td>
        <td style="width: 2%; border: none; padding: 1.5pt 0;">:</td>
        <td style="width: 23%; font-weight: bold; border: none; padding: 1.5pt 0;">{{ $clsName }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 1.5pt 0;">NISN / NIS</td>
        <td style="border: none; padding: 1.5pt 0;">:</td>
        <td style="border: none; padding: 1.5pt 0;">{{ $student->nisn ?? '-' }} / {{ $student->nis }}</td>
        <td style="border: none; padding: 1.5pt 0;">Semester</td>
        <td style="border: none; padding: 1.5pt 0;">:</td>
        <td style="border: none; padding: 1.5pt 0;">{{ $academicYear->semester ?? 'Ganjil' }}</td>
    </tr>
    <tr>
        <td style="border: none; padding: 1.5pt 0;">Nama Sekolah</td>
        <td style="border: none; padding: 1.5pt 0;">:</td>
        <td style="border: none; padding: 1.5pt 0;">{{ $school->name ?? ($isSmp ? 'SMP IT Robbani' : 'SDIT Robbani') }}</td>
        <td style="border: none; padding: 1.5pt 0;">Tahun Ajaran</td>
        <td style="border: none; padding: 1.5pt 0;">:</td>
        <td style="border: none; padding: 1.5pt 0;">{{ $academicYear->name ?? '2026/2027' }}</td>
    </tr>
</table>

<table class="bordered" style="font-size: 9pt; line-height: 1.15;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 145pt;">Mata Pelajaran</th>
            <th style="width: 40pt;">Nilai Akhir</th>
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
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $idx + 1 }}</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">{{ $g->subject->name ?? 'Mata Pelajaran' }}</td>
            <td class="text-center font-black" style="font-size: 10pt; padding: 2.5pt;">{{ $scoreVal }}</td>
            <td style="text-align: justify; padding: 2.5pt 4pt;">
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
            <td colspan="4" class="text-center" style="font-style: italic; padding: 8pt;">Belum ada data nilai mata pelajaran yang tersimpan.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 5: MUATAN LOKAL, EKSTRAKURIKULER, PRESENSI & PENGESAHAN 3 PIHAK -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">CATATAN PERKEMBANGAN & PENGESAHAN RAPOR</div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">TAHUN AJARAN {{ $academicYear->name ?? '2026/2027' }}</div>
</div>

@if($mulokGrades->isNotEmpty())
<div style="font-weight: bold; margin: 3pt 0 2pt 0; font-size: 9.5pt; color: #064e3b;">A. Muatan Lokal & Kekhasan SIT:</div>
<table class="bordered" style="font-size: 9pt; line-height: 1.15;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 145pt;">Mata Pelajaran Mulok</th>
            <th style="width: 40pt;">Nilai</th>
            <th>Capaian Kompetensi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($mulokGrades as $idx => $mg)
        @php
            $mScore = round((float) ($mg->score ?? 0));
        @endphp
        <tr>
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $idx + 1 }}</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">{{ $mg->subject->name ?? 'Muatan Lokal' }}</td>
            <td class="text-center font-black" style="font-size: 10pt; padding: 2.5pt;">{{ $mScore }}</td>
            <td style="text-align: justify; padding: 2.5pt 4pt;">{{ $mg->notes ?? $mg->competency_description ?? 'Mencapai kompetensi muatan lokal dengan predikat baik.' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div style="font-weight: bold; margin: 5pt 0 2pt 0; font-size: 9.5pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'B.' : 'A.' }} Kegiatan Ekstrakurikuler
</div>
<table class="bordered" style="font-size: 9pt;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 155pt;">Nama Kegiatan Ekstrakurikuler</th>
            <th style="width: 55pt;">Predikat</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center" style="padding: 2.5pt;">1</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">{{ $homeroomNote->extracurricular_name ?? 'Pramuka SIT' }}</td>
            <td class="text-center font-bold" style="padding: 2.5pt;">Baik (B)</td>
            <td style="padding: 2.5pt 4pt;">Aktif mengikuti latihan kepanduan dan memiliki jiwa kemandirian.</td>
        </tr>
    </tbody>
</table>

<div style="font-weight: bold; margin: 5pt 0 2pt 0; font-size: 9.5pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'C.' : 'B.' }} Rekapitulasi Ketidakhadiran
</div>
<table class="bordered" style="width: 55%; font-size: 9pt; margin-bottom: 5pt;">
    <tr>
        <td style="width: 140pt; padding: 2pt 4pt;">Sakit (S)</td>
        <td style="width: 12pt; text-align: center; padding: 2pt 0;">:</td>
        <td style="font-weight: bold; padding: 2pt 4pt;">{{ $homeroomNote->sick_count ?? 0 }} hari</td>
    </tr>
    <tr>
        <td style="padding: 2pt 4pt;">Izin (I)</td>
        <td style="text-align: center; padding: 2pt 0;">:</td>
        <td style="font-weight: bold; padding: 2pt 4pt;">{{ $homeroomNote->permission_count ?? 0 }} hari</td>
    </tr>
    <tr>
        <td style="padding: 2pt 4pt;">Tanpa Keterangan (A)</td>
        <td style="text-align: center; padding: 2pt 0;">:</td>
        <td style="font-weight: bold; padding: 2pt 4pt;">{{ $homeroomNote->absent_count ?? 0 }} hari</td>
    </tr>
</table>

<div style="font-weight: bold; margin: 5pt 0 2pt 0; font-size: 9.5pt; color: #064e3b;">
    {{ $mulokGrades->isNotEmpty() ? 'D.' : 'C.' }} Catatan Perkembangan & Motivasi Wali Kelas
</div>
<div style="border: 0.75pt solid #000; padding: 6pt; min-height: 35pt; font-size: 9pt; text-align: justify; background-color: #fafafa; margin-bottom: 8pt; line-height: 1.2;">
    @if(!empty($homeroomNote->notes))
        {{ $homeroomNote->notes }}
    @elseif(!empty($homeroomNote->special_notes))
        {{ $homeroomNote->special_notes }}
    @else
        Barakallahu fiik ananda {{ $student->full_name }}. Terus pertahankan akhlak mulia dan semangat belajarmu. Semoga Allah SWT senantiasa memberikan kemudahan dalam menuntut ilmu dan meraih prestasi yang membanggakan.
    @endif
</div>

<!-- Titimangsa & Tanda Tangan 3 Pihak Resmi (SIMETRIS & SEJAJAR) -->
<table style="width: 100%; margin-top: 10pt; border: none; font-size: 9.5pt; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
    <tr>
        <!-- Kolom Orang Tua / Wali -->
        <td style="width: 33.33%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>Mengetahui,</div>
            <div style="font-weight: bold; margin-top: 2pt;">Orang Tua / Wali Siswa,</div>
            <div style="height: 48pt;">&nbsp;</div>
            <div style="border-bottom: 1pt solid #000000; width: 85%; margin: 0 auto; padding-bottom: 2pt; font-weight: bold;">
                {{ $student->father_name ?? ($student->guardian_name ?? '............................................') }}
            </div>
        </td>
        <!-- Kolom Wali Kelas -->
        <td style="width: 33.33%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-top: 2pt;">Wali Kelas {{ $cleanClassroomName }},</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if(!empty($student->classroom->homeroom_signature_path) && file_exists(public_path($student->classroom->homeroom_signature_path)))
                    <img src="{{ url($student->classroom->homeroom_signature_path) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD Walas" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $walasName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">NIP. {{ $walasNip }}</div>
        </td>
        <!-- Kolom Kepala Sekolah -->
        <td style="width: 33.34%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-top: 2pt;">Kepala Sekolah,</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD Kepsek" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 6: LAPORAN PEMBELAJARAN AL-QUR'AN (METODE WAFA & TAHFIDZ / TTQ) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">
        {{ $isSmp ? 'LAPORAN TILAWAH & TAHFIDZ AL-QUR\'AN (TTQ)' : 'LAPORAN PEMBELAJARAN AL-QUR\'AN METODE WAFA & TAHFIDZ' }}
    </div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR PENDIDIKAN AL-QUR'AN JSIT INDONESIA</div>
</div>

<div style="font-weight: bold; font-size: 10pt; margin-bottom: 3pt; color: #064e3b;">A. Tilawah Al-Qur'an (Metode Wafa)</div>
<table class="bordered" style="font-size: 9pt;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 165pt;">Aspek Penilaian Tilawah</th>
            <th style="width: 65pt;">Capaian / Nilai</th>
            <th>Keterangan / Deskripsi Kemajuan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center" style="padding: 2.5pt;">1</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">Buku / Jilid Wafa & Halaman</td>
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $quranGrade->wafa_level ?? $quranGrade->tahsin_level ?? 'Jilid 3' }}</td>
            <td style="padding: 2.5pt 4pt;">Kelancaran membaca ayat Al-Qur'an secara tartil sesuai kaidah Wafa.</td>
        </tr>
        <tr>
            <td class="text-center" style="padding: 2.5pt;">2</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">Ketepatan Makharijul Huruf</td>
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $quranGrade->makhraj_score ?? '88' }} (B)</td>
            <td style="padding: 2.5pt 4pt;">Mampu melafalkan huruf hijaiyyah dari makhraj yang benar.</td>
        </tr>
        <tr>
            <td class="text-center" style="padding: 2.5pt;">3</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">Penerapan Kaidah Tajwid</td>
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $quranGrade->tajwid_score ?? '86' }} (B)</td>
            <td style="padding: 2.5pt 4pt;">Menerapkan hukum mad, nun mati, dan mim mati secara konsisten.</td>
        </tr>
    </tbody>
</table>

<div style="font-weight: bold; font-size: 10pt; margin: 8pt 0 3pt 0; color: #064e3b;">B. Hafalan Al-Qur'an (Tahfidz)</div>
<table class="bordered" style="font-size: 9pt;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 150pt;">Juz / Surat Target</th>
            <th style="width: 80pt;">Predikat / Nilai</th>
            <th>Catatan Mutaba'ah Tahfidz</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center" style="padding: 2.5pt;">1</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">{{ $quranGrade->tahfidz_target ?? $quranGrade->tahfidz_surah ?? 'Juz 30 (An-Naas s/d Al-Humazah)' }}</td>
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $quranGrade->tahfidz_score ?? 90 }} ({{ $quranGrade->tahfidz_predicate ?? 'Mumtaz (A)' }})</td>
            <td style="padding: 2.5pt 4pt;">{{ $quranGrade->tahfidz_notes ?? 'Hafalan lancar dan mutqin, istiqomahkan muraja\'ah di rumah bersama orang tua.' }}</td>
        </tr>
    </tbody>
</table>

<!-- Pengesahan Guru Qur'an & Kepsek (SIMETRIS 2 KOLOM) -->
<table style="width: 100%; margin-top: 15pt; border: none; font-size: 9.5pt; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
    <tr>
        <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-top: 2pt;">Koordinator / Guru Al-Qur'an Wafa,</div>
            <div style="height: 48pt;">&nbsp;</div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $wafaTeacherName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">{{ $wafaTeacherTitle }}</div>
        </td>
        <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-top: 2pt;">Kepala Sekolah,</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD Kepsek" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>

@if($isBpiAllowed)
<!-- PEMUTUS HALAMAN RESMI MICROSOFT WORD -->
<br clear="all" style="page-break-before:always; mso-break-type:section-break" />

<!-- ========================================================================= -->
<!-- LEMBAR 7: LAPORAN KARAKTER 7 SKL JSIT & BINA PRIBADI ISLAM (BPI) -->
<!-- ========================================================================= -->
<div class="kop-header">
    <div style="font-size: 12pt; font-weight: 900; text-transform: uppercase;">
        {{ $isSmp ? 'LAPORAN BINA PRIBADI ISLAM (BPI) & KARAKTER' : 'LAPORAN KARAKTER 7 SKL JSIT & BINA PRIBADI ISLAM' }}
    </div>
    <div style="font-size: 10pt; font-weight: bold; color: #064e3b;">STANDAR KOMPETENSI LULUSAN (SKL) JSIT INDONESIA</div>
</div>

<table class="bordered" style="font-size: 9pt; line-height: 1.15;">
    <thead>
        <tr>
            <th style="width: 22pt;">No</th>
            <th style="width: 155pt;">Indikator 7 SKL JSIT</th>
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
            <td class="text-center font-bold" style="padding: 2.5pt;">{{ $idx + 1 }}</td>
            <td class="font-bold" style="padding: 2.5pt 4pt;">{{ $skl[0] }}</td>
            <td class="text-center font-bold" style="color: #064e3b; padding: 2.5pt;">SB (Sangat Baik)</td>
            <td style="padding: 2.5pt 4pt;">{{ $skl[1] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div style="margin-top: 6pt; border: 0.75pt solid #ccc; padding: 5pt; background-color: #fafafa; font-size: 9pt;">
    <strong>Catatan Pembimbing Karakter & BPI:</strong><br>
    {{ $characterGrade->notes ?? $characterGrade->bpi_mentor_notes ?? 'Ananda menunjukkan antusiasme yang tinggi dalam pembiasaan ibadah harian. Terus dampingi dzikir pagi-petang dan sholat berjamaah di rumah.' }}
</div>

<!-- Pengesahan BPI & Kepsek (SIMETRIS 2 KOLOM) -->
<table style="width: 100%; margin-top: 15pt; border: none; font-size: 9.5pt; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
    <tr>
        <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>&nbsp;</div>
            <div style="font-weight: bold; margin-top: 2pt;">Pembina Bina Pribadi Islam (BPI),</div>
            <div style="height: 48pt;">&nbsp;</div>
            <div style="font-weight: bold; text-decoration: underline;">{{ !empty($isTk) ? 'Amah / Ustadz Pembimbing' : 'Bunda / Ustadz Pembimbing' }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">Pembina BPI Robbani</div>
        </td>
        <td style="width: 50%; text-align: center; vertical-align: top; border: none; padding: 0;">
            <div>{{ $titimangsa }}</div>
            <div style="font-weight: bold; margin-top: 2pt;">Kepala Sekolah,</div>
            <div style="height: 48pt; text-align: center; vertical-align: middle;">
                @if($showSig && !empty($reportSetting?->principal_signature_url))
                    <img src="{{ url($reportSetting->principal_signature_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="TTD Kepsek" />
                @elseif($showStamp && !empty($reportSetting?->stamp_image_url))
                    <img src="{{ url($reportSetting->stamp_image_url) }}" height="48" style="height: 48pt; max-height: 48pt; width: auto; border: 0; outline: none; margin: 0 auto;" alt="Stempel" />
                @else
                    <div style="height: 45pt;">&nbsp;</div>
                @endif
            </div>
            <div style="font-weight: bold; text-decoration: underline;">{{ $kepsekName }}</div>
            <div style="font-size: 9pt; margin-top: 2pt;">NIP. {{ $kepsekNip }}</div>
        </td>
    </tr>
</table>
@endif

@endforeach

</div>
</body>
</html>
