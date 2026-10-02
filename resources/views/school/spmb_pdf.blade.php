<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir F-SPMB & Lampiran Dokumen - {{ $registration->registration_number }} | SIT Robbani</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background-color: #f1f5f9; 
            color: #0f172a; 
        }
        
        .pdf-card {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .table-field td {
            padding: 3px 6px;
            vertical-align: top;
            text-transform: uppercase;
        }

        .table-field td.no-uppercase,
        .table-field td a {
            text-transform: none !important;
        }

        .table-field tr:nth-child(even) {
            background-color: #f8fafc;
        }

        @media print {
            .no-print { display: none !important; }
            html, body { 
                padding: 0 !important; 
                margin: 0 !important; 
                background: #ffffff !important; 
                color: #0f172a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .pdf-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .page-sheet {
                page-break-after: always !important;
                break-after: page !important;
                min-height: 297mm;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 7mm 9mm !important;
                border: none !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                box-sizing: border-box;
            }
            .page-sheet:last-child {
                page-break-after: avoid !important;
                break-after: avoid !important;
            }
            .table-field td {
                padding: 2px 5px !important;
                font-size: 10px !important;
            }
            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body class="p-3 sm:p-8 antialiased">

    @php
        $rawD = is_array($registration->details_json) 
            ? $registration->details_json 
            : (is_string($registration->details_json) ? (json_decode($registration->details_json, true) ?? []) : []);
        
        $toUpperRec = function($data) use (&$toUpperRec) {
            $res = [];
            foreach ($data as $k => $v) {
                if (is_array($v)) {
                    $res[$k] = $toUpperRec($v);
                } elseif (is_string($v)) {
                    $lk = strtolower($k);
                    if (str_contains($lk, 'email') || str_contains($lk, 'url') || str_contains($lk, 'file') || str_contains($lk, 'uploaded') || str_contains($lk, 'token')) {
                        $res[$k] = $v;
                    } else {
                        $res[$k] = mb_strtoupper($v, 'UTF-8');
                    }
                } else {
                    $res[$k] = $v;
                }
            }
            return $res;
        };
        $d = $toUpperRec($rawD);
        $rawDocs = $rawD['uploaded_docs'] ?? ($d['uploaded_docs'] ?? []);
        
        $verifyUrl = route('school.spmb.verify', $registration->registration_number);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' . urlencode($verifyUrl);

        $resolveDocUrl = function($field) use ($rawDocs) {
            $path = $rawDocs[$field] ?? null;
            if (empty($path) || !is_string($path)) return null;
            $path = trim($path);
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }
            return asset(ltrim($path, '/'));
        };

        $checkIsPdf = function($field) use ($rawDocs) {
            $path = $rawDocs[$field] ?? null;
            if (empty($path) || !is_string($path)) return false;
            $cleanPath = parse_url($path, PHP_URL_PATH) ?? $path;
            $ext = strtolower(pathinfo($cleanPath, PATHINFO_EXTENSION));
            return $ext === 'pdf';
        };

        $aktaUrl = $resolveDocUrl('akta_kelahiran');
        $aktaIsPdf = $checkIsPdf('akta_kelahiran');

        $kkUrl = $resolveDocUrl('kartu_keluarga');
        $kkIsPdf = $checkIsPdf('kartu_keluarga');

        $ktpUrl = $resolveDocUrl('ktp_ortu');
        $ktpIsPdf = $checkIsPdf('ktp_ortu');

        $fotoUrl = $resolveDocUrl('pas_foto');
        $fotoIsPdf = $checkIsPdf('pas_foto');

        $buktiUrl = $resolveDocUrl('bukti_transfer');
        $buktiIsPdf = $checkIsPdf('bukti_transfer');
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 p-4 rounded-2xl bg-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center shadow-md">
                📄
            </div>
            <div>
                <h4 class="font-black text-sm text-white">Formulir Pendaftaran Siswa Baru (F-SPMB) Lengkap 4 Halaman</h4>
                <p class="text-xs text-slate-300 font-medium">Nomor Registrasi: <span class="font-mono text-amber-300 font-bold">{{ $registration->registration_number }}</span> | Siap Cetak (Formulir + 3 Halaman Lampiran)</p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <button onclick="window.print()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                <span>🖨️</span> Cetak / Simpan PDF (4 Hal)
            </button>
            <a href="{{ route('school.spmb') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs text-center">
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Printable 4-Page Container -->
    <div class="pdf-container max-w-4xl mx-auto space-y-6">
        
        <!-- ========================================================================= -->
        <!-- HALAMAN 1 DARI 4: FORMULIR ISIAN PENDAFTARAN RESMI (F-SPMB) -->
        <!-- ========================================================================= -->
        <div class="no-print flex items-center justify-between text-xs font-bold text-slate-500 mb-1 px-1">
            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full border border-emerald-300 flex items-center gap-1.5 shadow-2xs">
                <span>📄</span> <strong>HALAMAN 1 DARI 4:</strong> FORMULIR ISIAN PENDAFTARAN RESMI (F-SPMB)
            </span>
            <span class="font-mono text-emerald-900 text-xs font-black">REG: {{ $registration->registration_number }}</span>
        </div>

        <div class="page-sheet pdf-card rounded-2xl p-5 sm:p-8 space-y-3.5 text-xs text-slate-900 bg-white">
            <!-- Header Kop Surat Sekolah Islam Terpadu Robbani (Rata Tengah Simetris) -->
            <div class="flex items-center justify-between border-b-2 border-emerald-950 pb-2.5 gap-2 sm:gap-4">
                <!-- Logo Kiri -->
                <div class="w-20 sm:w-24 shrink-0 flex items-center justify-center">
                    <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-16 sm:h-20 w-auto object-contain mx-auto" onerror="this.src='{{ asset('favicon.png') }}'">
                </div>
                
                <!-- Teks Kop Surat Rata Tengah -->
                <div class="flex-1 text-center px-1">
                    <h1 class="text-base sm:text-xl font-black tracking-tight uppercase text-emerald-950 leading-tight">
                        SEKOLAH ISLAM TERPADU ROBBANI
                    </h1>
                    <p class="text-[10px] sm:text-xs text-slate-800 font-bold leading-snug mt-0.5">
                        KPA (Kantor Pusat Administrasi) Sekolah Islam Terpadu Robbani
                    </p>
                    <p class="text-[10px] sm:text-[11px] text-slate-700 font-medium leading-snug">
                        Alamat: Jl. Sarjana Blok A.25, Timbangan, Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan
                    </p>
                    <p class="text-[9px] sm:text-[10px] text-slate-600 font-semibold leading-tight mt-0.5">
                        Telp/WA: 0811747472 | Website: sitrobbani.sch.id
                    </p>
                </div>

                <!-- QR Code Kanan Setara Ukuran Logo Kiri -->
                <div class="w-20 sm:w-24 shrink-0 flex items-center justify-center">
                    <div class="p-1 border border-slate-300 rounded-xl bg-white shadow-xs flex flex-col items-center justify-center w-16 sm:w-20 h-16 sm:h-20">
                        <img src="{{ $qrUrl }}" alt="QR Code" class="w-10 sm:w-12 h-10 sm:h-12 object-contain mx-auto">
                        <span class="text-[8px] sm:text-[9px] font-mono font-black text-slate-800 tracking-tight leading-none text-center mt-1">F - SPMB</span>
                    </div>
                </div>
            </div>

            <!-- Title of Form -->
            <div class="text-center space-y-0.5">
                <h3 class="text-sm sm:text-base font-black uppercase tracking-wide text-slate-900">
                    FORMULIR PENERIMAAN PESERTA DIDIK BARU SEKOLAH ISLAM TERPADU ROBBANI
                </h3>
                <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 pt-0.5">
                    <span>Tanggal: {{ $registration->created_at ? $registration->created_at->translatedFormat('d / m / Y') : date('d / m / Y') }}</span>
                    <span>REG : <strong class="font-mono text-emerald-900 text-xs">{{ $registration->registration_number }}</strong></span>
                </div>
            </div>

            <!-- I. IDENTITAS PESERTA DIDIK (WAJIB DIISI) -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase flex justify-between items-center">
                    <span>IDENTITAS PESERTA DIDIK (WAJIB DIISI)</span>
                    <span class="text-[9px] font-normal text-emerald-100">Mohon diisi dengan Huruf Kapital</span>
                </div>
                <table class="w-full text-[11px] table-field">
                    <tbody>
                        <tr>
                            <td class="w-48 font-bold text-slate-700">1. Nama Lengkap</td>
                            <td class="w-3">:</td>
                            <td class="font-black uppercase text-slate-900">{{ $registration->full_name }}</td>
                            <td class="w-36 font-bold text-slate-700">2. Nama Panggilan</td>
                            <td class="w-3">:</td>
                            <td class="font-bold text-slate-800">{{ $d['nama_panggilan'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">3. NIK Siswa</td>
                            <td>:</td>
                            <td class="font-mono font-bold">{{ $d['nik_siswa'] ?? '-' }}</td>
                            <td class="font-bold text-slate-700">4. Jenis Kelamin</td>
                            <td>:</td>
                            <td class="font-bold">{{ $d['jenis_kelamin'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">5. Tempat, Tgl Lahir</td>
                            <td>:</td>
                            <td colspan="4" class="font-bold">
                                {{ $d['tempat_lahir'] ?? '-' }}, {{ isset($d['tanggal_lahir']) ? \Carbon\Carbon::parse($d['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">6. Anak ke -</td>
                            <td>:</td>
                            <td>{{ $d['anak_ke'] ?? '1' }} dari {{ $d['jumlah_saudara'] ?? '1' }} saudara</td>
                            <td class="font-bold text-slate-700">7. Status Orang Tua</td>
                            <td>:</td>
                            <td class="font-bold">{{ $d['status_ortu'] ?? 'Ayah dan Ibu Masih Ada' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">8. Tempat Tinggal Anak</td>
                            <td>:</td>
                            <td colspan="4">{{ $d['status_tempat_tinggal'] ?? ($d['tempat_tinggal_anak'] ?? 'Ikut Orang Tua') }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">9. Alamat Tempat Tinggal</td>
                            <td>:</td>
                            <td colspan="4" class="font-medium">
                                {{ $d['alamat'] ?? '-' }}
                                <div class="text-[10px] text-slate-600 mt-0.5">
                                    Dusun/RT: {{ $d['dusun'] ?? '-' }} | Kel/Desa: {{ $d['kelurahan'] ?? '-' }} | Kode Pos: {{ $d['kode_pos'] ?? '-' }} | Kec: {{ $d['kecamatan'] ?? '-' }} | Kab/Kota: {{ $d['kabupaten'] ?? '-' }} | Prov: {{ $d['provinsi'] ?? '-' }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">10. Kewarganegaraan</td>
                            <td>:</td>
                            <td>{{ $d['kewarganegaraan'] ?? 'WNI' }}</td>
                            <td class="font-bold text-slate-700">11. Bahasa Sehari-hari</td>
                            <td>:</td>
                            <td>{{ $d['bahasa_sehari_hari'] ?? 'Indonesia' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- II. DATA SEKOLAH -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase">
                    DATA SEKOLAH
                </div>
                <table class="w-full text-[11px] table-field">
                    <tbody>
                        <tr>
                            <td class="w-48 font-bold text-slate-700">1. NISN</td>
                            <td class="w-3">:</td>
                            <td class="font-mono font-bold">{{ $d['nisn'] ?? '-' }}</td>
                            <td class="w-36 font-bold text-slate-700">2. Masuk di Kelas / Unit</td>
                            <td class="w-3">:</td>
                            <td class="font-black text-emerald-900">{{ $registration->target_level }} ({{ $d['masuk_kelas'] ?? '-' }})</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">3. Siswa Baru / Pindahan</td>
                            <td>:</td>
                            <td>{{ $d['status_siswa'] ?? 'Baru' }}</td>
                            <td class="font-bold text-slate-700">4. Kategori Sekolah Asal</td>
                            <td>:</td>
                            <td>{{ $d['kategori_sekolah_asal'] ?? 'Luar SIT Robbani' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">5. Nama Sekolah Asal</td>
                            <td>:</td>
                            <td colspan="4" class="font-bold">{{ $registration->previous_school ?? $d['sekolah_asal'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">6. Prestasi Yang Pernah Diraih</td>
                            <td>:</td>
                            <td colspan="4">{{ $d['prestasi'] ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- III. DATA KESEHATAN & MODA TRANSPORTASI -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- Data Kesehatan -->
                <div class="border border-slate-300 rounded-lg overflow-hidden">
                    <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase">
                        DATA KESEHATAN
                    </div>
                    <table class="w-full text-[11px] table-field">
                        <tbody>
                            <tr>
                                <td class="w-36 font-bold text-slate-700">1. Tinggi Badan</td>
                                <td class="w-2">:</td>
                                <td>{{ $d['tinggi_badan'] ?? '-' }} cm</td>
                                <td class="font-bold text-slate-700">2. Berat</td>
                                <td class="w-2">:</td>
                                <td>{{ $d['berat_badan'] ?? '-' }} kg</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">3. Golongan Darah</td>
                                <td>:</td>
                                <td colspan="4" class="font-bold">{{ $d['golongan_darah'] ?? 'Belum Tahu' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">4. Penyakit Pernah</td>
                                <td>:</td>
                                <td colspan="4">{{ $d['penyakit_pernah'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">5. Penyakit Sedang</td>
                                <td>:</td>
                                <td colspan="4">{{ $d['penyakit_sedang'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">6. Kelainan Fisik</td>
                                <td>:</td>
                                <td colspan="4">{{ $d['kelainan_fisik'] ?? 'Tidak Ada' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Moda Transportasi -->
                <div class="border border-slate-300 rounded-lg overflow-hidden">
                    <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase">
                        MODA TRANSPORTASI PESERTA DIDIK
                    </div>
                    <table class="w-full text-[11px] table-field">
                        <tbody>
                            <tr>
                                <td class="w-40 font-bold text-slate-700">1. Jarak ke Sekolah</td>
                                <td class="w-2">:</td>
                                <td class="font-bold">{{ $d['jarak_ke_sekolah'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">2. Transportasi Digunakan</td>
                                <td>:</td>
                                <td class="font-bold">{{ $d['transportasi'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">3. Sumber Info SPMB</td>
                                <td>:</td>
                                <td>{{ $d['info_pendaftaran'] ?? 'Media Sosial' }}</td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-700">4. Biaya Pendaftaran</td>
                                <td>:</td>
                                <td class="font-mono font-bold text-emerald-800">
                                    Rp {{ number_format($registration->registration_fee, 0, ',', '.') }}
                                    <span class="text-[9px] px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 ml-1 font-sans">
                                        {{ $registration->fee_paid ? 'LUNAS' : 'MENUNGGU VERIFIKASI' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- IV. DATA AYAH KANDUNG (WAJIB DIISI) -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase">
                    DATA AYAH KANDUNG (WAJIB DIISI)
                </div>
                <table class="w-full text-[11px] table-field">
                    <tbody>
                        <tr>
                            <td class="w-48 font-bold text-slate-700">1. Nama Lengkap</td>
                            <td class="w-3">:</td>
                            <td class="font-black text-slate-900">{{ $registration->parent_name }}</td>
                            <td class="w-36 font-bold text-slate-700">3. NIK Ayah</td>
                            <td class="w-3">:</td>
                            <td class="font-mono font-bold">{{ $d['nik_ayah'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">2. Tempat, Tgl Lahir</td>
                            <td>:</td>
                            <td>{{ $d['tempat_lahir_ayah'] ?? '-' }}, {{ isset($d['tanggal_lahir_ayah']) ? \Carbon\Carbon::parse($d['tanggal_lahir_ayah'])->translatedFormat('d F Y') : '-' }}</td>
                            <td class="font-bold text-slate-700">4. Pendidikan Terakhir</td>
                            <td>:</td>
                            <td>{{ $d['pendidikan_ayah'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">5. Pekerjaan</td>
                            <td>:</td>
                            <td>{{ $d['pekerjaan_ayah'] ?? '-' }}</td>
                            <td class="font-bold text-slate-700">6. Instansi Bekerja</td>
                            <td>:</td>
                            <td>{{ $d['instansi_ayah'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">7. Bidang Keahlian</td>
                            <td>:</td>
                            <td>{{ $d['bidang_keahlian_ayah'] ?? '-' }}</td>
                            <td class="font-bold text-slate-700">8. No. HP / WhatsApp</td>
                            <td>:</td>
                            <td class="font-mono font-bold">{{ $registration->phone_number }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">9. Penghasilan Bulanan</td>
                            <td>:</td>
                            <td colspan="4">{{ $d['penghasilan_ayah'] ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- V. DATA IBU KANDUNG (WAJIB DIISI) -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase">
                    DATA IBU KANDUNG (WAJIB DIISI)
                </div>
                <table class="w-full text-[11px] table-field">
                    <tbody>
                        <tr>
                            <td class="w-48 font-bold text-slate-700">1. Nama Lengkap</td>
                            <td class="w-3">:</td>
                            <td class="font-black text-slate-900">{{ $d['nama_ibu'] ?? '-' }}</td>
                            <td class="w-36 font-bold text-slate-700">3. NIK Ibu</td>
                            <td class="w-3">:</td>
                            <td class="font-mono font-bold">{{ $d['nik_ibu'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">2. Tempat, Tgl Lahir</td>
                            <td>:</td>
                            <td>{{ $d['tempat_lahir_ibu'] ?? '-' }}, {{ isset($d['tanggal_lahir_ibu']) ? \Carbon\Carbon::parse($d['tanggal_lahir_ibu'])->translatedFormat('d F Y') : '-' }}</td>
                            <td class="font-bold text-slate-700">4. Pendidikan Terakhir</td>
                            <td>:</td>
                            <td>{{ $d['pendidikan_ibu'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">5. Pekerjaan</td>
                            <td>:</td>
                            <td>{{ $d['pekerjaan_ibu'] ?? '-' }}</td>
                            <td class="font-bold text-slate-700">6. Instansi Bekerja</td>
                            <td>:</td>
                            <td>{{ $d['instansi_ibu'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">7. Alamat Rumah</td>
                            <td>:</td>
                            <td>{{ $d['alamat_ibu'] ?? 'Sama dengan alamat siswa' }}</td>
                            <td class="font-bold text-slate-700">8. No. HP / WhatsApp</td>
                            <td>:</td>
                            <td class="font-mono font-bold">{{ $d['no_hp_ibu'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-700">9. Penghasilan Bulanan</td>
                            <td>:</td>
                            <td colspan="4">{{ $d['penghasilan_ibu'] ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- VI. KELENGKAPAN BERKAS PERSYARATAN & BIAYA PENDAFTARAN -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1 uppercase flex justify-between items-center">
                    <span>VI. KELENGKAPAN BERKAS PERSYARATAN & BIAYA PENDAFTARAN</span>
                    <span class="text-[10px] font-bold font-mono">Biaya: Rp {{ number_format($registration->registration_fee ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="p-2.5 bg-slate-50/50">
                    <div class="grid grid-cols-2 gap-x-4 gap-y-1 text-[10px]">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ !empty($aktaUrl) ? '☑' : '☐' }} 1. Akta Kelahiran Calon Siswa</span>
                            @if(!empty($aktaUrl))
                                <span class="text-[9px] text-emerald-700 font-bold">(Terlampir di Halaman 2)</span>
                            @else
                                <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ !empty($kkUrl) ? '☑' : '☐' }} 2. Kartu Keluarga (KK)</span>
                            @if(!empty($kkUrl))
                                <span class="text-[9px] text-emerald-700 font-bold">(Terlampir di Halaman 3)</span>
                            @else
                                <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ !empty($ktpUrl) ? '☑' : '☐' }} 3. KTP Orang Tua (Ayah / Ibu)</span>
                            @if(!empty($ktpUrl))
                                <span class="text-[9px] text-emerald-700 font-bold">(Terlampir di Halaman 4)</span>
                            @else
                                <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-800">{{ !empty($fotoUrl) ? '☑' : '☐' }} 4. Pas Foto Calon Siswa (3x4 & 2x3)</span>
                            @if(!empty($fotoUrl))
                                <span class="text-[9px] text-emerald-700 font-bold">(Terlampir di Halaman 4)</span>
                            @else
                                <span class="text-[9px] text-slate-400">(@ 2 Lembar)</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 col-span-2 pt-1 border-t border-slate-200">
                            <span class="font-bold text-slate-800">{{ !empty($buktiUrl) ? '☑' : '☐' }} 5. Bukti Transfer Biaya Pendaftaran Unit:</span>
                            <span class="font-mono font-bold text-emerald-800">Rp {{ number_format($registration->registration_fee ?? 0, 0, ',', '.') }}</span>
                            @if(!empty($buktiUrl))
                                <span class="text-[9px] text-emerald-700 font-bold">(Terlampir di Halaman 4 / Terverifikasi)</span>
                            @else
                                <span class="text-[9px] text-amber-700 font-bold">(Menunggu Pembayaran / Verifikasi)</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan Official Panitia & Orang Tua Siswa -->
            <div class="pt-4 flex justify-between items-end px-8 sm:px-14 text-center text-xs">
                <!-- Kolom 1: Panitia SPMB -->
                <div class="space-y-12">
                    <div>
                        <span class="block text-slate-500 text-[10px]">Mengetahui,</span>
                        <strong class="font-black text-slate-900">Panitia SPMB SIT Robbani</strong>
                    </div>
                    <div class="border-t border-slate-400 w-40 sm:w-48 mx-auto pt-1 font-bold text-slate-800 text-[11px]">
                        ( Panitia SPMB SIT Robbani )
                    </div>
                </div>

                <!-- Kolom 2: Orang Tua Siswa -->
                <div class="space-y-12">
                    <div>
                        <span class="block text-slate-500 text-[10px]">Indralaya, {{ $registration->created_at ? $registration->created_at->translatedFormat('d F Y') : date('d F Y') }}</span>
                        <strong class="font-black text-slate-900">Orang Tua / Wali Siswa</strong>
                    </div>
                    <div class="border-t border-slate-400 w-40 sm:w-48 mx-auto pt-1 font-bold text-slate-800 text-[11px]">
                        ( {{ $registration->parent_name }} )
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 text-[9px] text-slate-400 text-center flex justify-between items-center">
                <span>Dokumen formulir resmi pendaftaran peserta didik baru SIT Robbani Ogan Ilir.</span>
                <span class="font-bold text-slate-600">Halaman 1 dari 4: Formulir Pendaftaran</span>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- HALAMAN 2 DARI 4: LAMPIRAN I - AKTA KELAHIRAN CALON SISWA -->
        <!-- ========================================================================= -->
        <div class="no-print flex items-center justify-between text-xs font-bold text-slate-500 mb-1 px-1 pt-3">
            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full border border-emerald-300 flex items-center gap-1.5 shadow-2xs">
                <span>📑</span> <strong>HALAMAN 2 DARI 4:</strong> LAMPIRAN I - AKTA KELAHIRAN
            </span>
            <span class="text-slate-400 text-[11px]">Lampiran Berkas Pendukung</span>
        </div>

        <div class="page-sheet pdf-card rounded-2xl p-5 sm:p-8 space-y-4 text-xs text-slate-900 bg-white flex flex-col justify-between">
            <div class="space-y-4">
                <!-- Header Kop Lampiran -->
                <div class="flex items-center justify-between border-b-2 border-emerald-950 pb-2.5 gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-12 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                        <div>
                            <h2 class="text-xs sm:text-sm font-black uppercase text-emerald-950 leading-tight">
                                SEKOLAH ISLAM TERPADU ROBBANI
                            </h2>
                            <p class="text-[10px] text-slate-600 font-bold">
                                Lampiran Berkas Pendaftaran Siswa Baru (SPMB) T.A 2026/2027
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-800 text-white font-black text-[10px] uppercase">
                            LAMPIRAN I
                        </span>
                        <p class="font-mono font-bold text-slate-800 text-xs mt-0.5">REG: {{ $registration->registration_number }}</p>
                    </div>
                </div>

                <!-- Subheader Banner Info Siswa -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokumen Lampiran:</span>
                        <h3 class="font-black text-slate-900 text-sm">AKTA KELAHIRAN CALON SISWA</h3>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Calon Siswa:</span>
                        <strong class="font-black text-slate-900">{{ $registration->full_name }}</strong>
                        <span class="text-slate-500 text-[11px] block">Unit Tujuan: <strong>{{ $registration->target_level }}</strong></span>
                    </div>
                </div>

                <!-- Image / Document Preview Box -->
                <div class="w-full flex-1 flex flex-col items-center justify-center min-h-[580px] bg-slate-50/60 rounded-2xl border-2 border-dashed border-slate-300 p-3 sm:p-5">
                    @if(!empty($aktaUrl))
                        @if($aktaIsPdf)
                            <div class="w-full h-full flex flex-col items-center justify-center space-y-3">
                                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center justify-between w-full max-w-xl">
                                    <span class="font-bold flex items-center gap-1.5"><span>📄</span> Berkas Akta Kelahiran Format PDF</span>
                                    <a href="{{ $aktaUrl }}" target="_blank" class="no-print px-3 py-1 rounded-lg bg-emerald-700 text-white font-bold text-[11px] hover:bg-emerald-800 transition-colors">Buka / Unduh File Asli ↗</a>
                                </div>
                                <embed src="{{ $aktaUrl }}#toolbar=0" type="application/pdf" class="w-full h-[620px] rounded-xl border border-slate-300 shadow-xs bg-white">
                            </div>
                        @else
                            <div class="w-full flex items-center justify-center">
                                <img src="{{ $aktaUrl }}" alt="Akta Kelahiran - {{ $registration->full_name }}" class="max-w-full max-h-[720px] w-auto h-auto object-contain rounded-xl shadow-md border border-slate-200 bg-white p-1">
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16 space-y-2">
                            <span class="text-4xl text-slate-300 block">📄</span>
                            <h4 class="font-black text-slate-600 text-sm">Berkas Akta Kelahiran Belum Diunggah</h4>
                            <p class="text-xs text-slate-400 max-w-md mx-auto">
                                Calon siswa belum mengunggah file Akta Kelahiran secara online. Salinan fisik diserahkan langsung ke Panitia SPMB SIT Robbani.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Hal 2 -->
            <div class="pt-3 border-t border-slate-200 text-[9px] text-slate-400 text-center flex justify-between items-center">
                <span>Dokumen formulir resmi pendaftaran peserta didik baru SIT Robbani Ogan Ilir.</span>
                <span class="font-bold text-slate-600">Halaman 2 dari 4: Lampiran I (Akta Kelahiran)</span>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- HALAMAN 3 DARI 4: LAMPIRAN II - KARTU KELUARGA (KK) -->
        <!-- ========================================================================= -->
        <div class="no-print flex items-center justify-between text-xs font-bold text-slate-500 mb-1 px-1 pt-3">
            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full border border-emerald-300 flex items-center gap-1.5 shadow-2xs">
                <span>📑</span> <strong>HALAMAN 3 DARI 4:</strong> LAMPIRAN II - KARTU KELUARGA (KK)
            </span>
            <span class="text-slate-400 text-[11px]">Lampiran Berkas Pendukung</span>
        </div>

        <div class="page-sheet pdf-card rounded-2xl p-5 sm:p-8 space-y-4 text-xs text-slate-900 bg-white flex flex-col justify-between">
            <div class="space-y-4">
                <!-- Header Kop Lampiran -->
                <div class="flex items-center justify-between border-b-2 border-emerald-950 pb-2.5 gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-12 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                        <div>
                            <h2 class="text-xs sm:text-sm font-black uppercase text-emerald-950 leading-tight">
                                SEKOLAH ISLAM TERPADU ROBBANI
                            </h2>
                            <p class="text-[10px] text-slate-600 font-bold">
                                Lampiran Berkas Pendaftaran Siswa Baru (SPMB) T.A 2026/2027
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-800 text-white font-black text-[10px] uppercase">
                            LAMPIRAN II
                        </span>
                        <p class="font-mono font-bold text-slate-800 text-xs mt-0.5">REG: {{ $registration->registration_number }}</p>
                    </div>
                </div>

                <!-- Subheader Banner Info Siswa -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokumen Lampiran:</span>
                        <h3 class="font-black text-slate-900 text-sm">KARTU KELUARGA (KK)</h3>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Calon Siswa:</span>
                        <strong class="font-black text-slate-900">{{ $registration->full_name }}</strong>
                        <span class="text-slate-500 text-[11px] block">Orang Tua/Wali: <strong>{{ $registration->parent_name }}</strong></span>
                    </div>
                </div>

                <!-- Image / Document Preview Box -->
                <div class="w-full flex-1 flex flex-col items-center justify-center min-h-[580px] bg-slate-50/60 rounded-2xl border-2 border-dashed border-slate-300 p-3 sm:p-5">
                    @if(!empty($kkUrl))
                        @if($kkIsPdf)
                            <div class="w-full h-full flex flex-col items-center justify-center space-y-3">
                                <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 text-xs flex items-center justify-between w-full max-w-xl">
                                    <span class="font-bold flex items-center gap-1.5"><span>📄</span> Berkas Kartu Keluarga Format PDF</span>
                                    <a href="{{ $kkUrl }}" target="_blank" class="no-print px-3 py-1 rounded-lg bg-emerald-700 text-white font-bold text-[11px] hover:bg-emerald-800 transition-colors">Buka / Unduh File Asli ↗</a>
                                </div>
                                <embed src="{{ $kkUrl }}#toolbar=0" type="application/pdf" class="w-full h-[620px] rounded-xl border border-slate-300 shadow-xs bg-white">
                            </div>
                        @else
                            <div class="w-full flex items-center justify-center">
                                <img src="{{ $kkUrl }}" alt="Kartu Keluarga - {{ $registration->full_name }}" class="max-w-full max-h-[720px] w-auto h-auto object-contain rounded-xl shadow-md border border-slate-200 bg-white p-1">
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16 space-y-2">
                            <span class="text-4xl text-slate-300 block">📄</span>
                            <h4 class="font-black text-slate-600 text-sm">Berkas Kartu Keluarga (KK) Belum Diunggah</h4>
                            <p class="text-xs text-slate-400 max-w-md mx-auto">
                                Calon siswa belum mengunggah file Kartu Keluarga secara online. Salinan fisik diserahkan langsung ke Panitia SPMB SIT Robbani.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer Hal 3 -->
            <div class="pt-3 border-t border-slate-200 text-[9px] text-slate-400 text-center flex justify-between items-center">
                <span>Dokumen formulir resmi pendaftaran peserta didik baru SIT Robbani Ogan Ilir.</span>
                <span class="font-bold text-slate-600">Halaman 3 dari 4: Lampiran II (Kartu Keluarga)</span>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- HALAMAN 4 DARI 4: LAMPIRAN III - FOTO CALON SISWA, KTP ORTU & BUKTI TRANSFER -->
        <!-- ========================================================================= -->
        <div class="no-print flex items-center justify-between text-xs font-bold text-slate-500 mb-1 px-1 pt-3">
            <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full border border-emerald-300 flex items-center gap-1.5 shadow-2xs">
                <span>📑</span> <strong>HALAMAN 4 DARI 4:</strong> LAMPIRAN III - FOTO, KTP ORTU & BUKTI BIAYA PENDAFTARAN
            </span>
            <span class="text-slate-400 text-[11px]">Lampiran Berkas Pendukung</span>
        </div>

        <div class="page-sheet pdf-card rounded-2xl p-5 sm:p-8 space-y-4 text-xs text-slate-900 bg-white flex flex-col justify-between">
            <div class="space-y-3.5">
                <!-- Header Kop Lampiran -->
                <div class="flex items-center justify-between border-b-2 border-emerald-950 pb-2.5 gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-12 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                        <div>
                            <h2 class="text-xs sm:text-sm font-black uppercase text-emerald-950 leading-tight">
                                SEKOLAH ISLAM TERPADU ROBBANI
                            </h2>
                            <p class="text-[10px] text-slate-600 font-bold">
                                Lampiran Berkas Pendaftaran Siswa Baru (SPMB) T.A 2026/2027
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2.5 py-0.5 rounded bg-emerald-800 text-white font-black text-[10px] uppercase">
                            LAMPIRAN III
                        </span>
                        <p class="font-mono font-bold text-slate-800 text-xs mt-0.5">REG: {{ $registration->registration_number }}</p>
                    </div>
                </div>

                <!-- Subheader Banner Info Siswa -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 flex flex-wrap items-center justify-between gap-2 text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Dokumen Lampiran:</span>
                        <h3 class="font-black text-slate-900 text-sm">FOTO CALON SISWA, KTP ORANG TUA & BUKTI TRANSFER</h3>
                    </div>
                    <div class="text-left sm:text-right">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nama Calon Siswa / Ortu:</span>
                        <strong class="font-black text-slate-900">{{ $registration->full_name }}</strong>
                        <span class="text-slate-500 text-[11px] block">Orang Tua: <strong>{{ $registration->parent_name }}</strong></span>
                    </div>
                </div>

                <!-- Grid Layout untuk 3 Dokumen di Halaman 4 -->
                <div class="space-y-3">
                    <!-- Baris 1: Foto Calon Siswa (Kiri) & KTP Orang Tua (Kanan) -->
                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-stretch">
                        <!-- 1. Pas Foto Calon Siswa (4 Kolom) -->
                        <div class="sm:col-span-4 border border-slate-300 rounded-xl p-3 bg-slate-50/50 flex flex-col justify-between space-y-2">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-1.5">
                                <span class="font-black text-slate-800 text-[11px]">1. FOTO CALON SISWA</span>
                                <span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-200">3 x 4</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center py-1">
                                @if(!empty($fotoUrl))
                                    @if($fotoIsPdf)
                                        <div class="text-center p-3">
                                            <span class="text-3xl block">📄</span>
                                            <a href="{{ $fotoUrl }}" target="_blank" class="text-[10px] font-bold text-emerald-700 hover:underline">Unduh File Pas Foto PDF ↗</a>
                                        </div>
                                    @else
                                        <img src="{{ $fotoUrl }}" alt="Foto {{ $registration->full_name }}" class="h-44 sm:h-48 w-32 sm:w-36 object-cover rounded-lg border-2 border-slate-300 shadow-sm bg-white p-0.5">
                                    @endif
                                @else
                                    <div class="w-32 h-44 border-2 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center text-center p-2 bg-white">
                                        <span class="text-2xl text-slate-300">👤</span>
                                        <span class="text-[9px] font-bold text-slate-400 mt-1">Pas Foto Belum Diunggah</span>
                                    </div>
                                @endif
                            </div>
                            <div class="text-center pt-1 border-t border-slate-200">
                                <span class="text-[10px] font-bold text-slate-700 block truncate">{{ $registration->full_name }}</span>
                                <span class="text-[9px] text-slate-500 font-mono">{{ $d['jenis_kelamin'] ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- 2. KTP Orang Tua (Ayah / Ibu) (8 Kolom) -->
                        <div class="sm:col-span-8 border border-slate-300 rounded-xl p-3 bg-slate-50/50 flex flex-col justify-between space-y-2">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-1.5">
                                <span class="font-black text-slate-800 text-[11px]">2. KTP ORANG TUA (AYAH / IBU)</span>
                                <span class="text-[9px] font-mono font-bold text-slate-600">NIK: {{ $d['nik_ayah'] ?? ($d['nik_ibu'] ?? '-') }}</span>
                            </div>
                            <div class="flex-1 flex items-center justify-center py-1">
                                @if(!empty($ktpUrl))
                                    @if($ktpIsPdf)
                                        <div class="w-full text-center p-4">
                                            <span class="text-3xl block">📄</span>
                                            <p class="text-xs font-bold text-slate-700 mt-1">File KTP Format PDF</p>
                                            <a href="{{ $ktpUrl }}" target="_blank" class="no-print inline-block mt-2 px-3 py-1 rounded-lg bg-emerald-700 text-white font-bold text-[10px]">Buka File KTP ↗</a>
                                        </div>
                                    @else
                                        <img src="{{ $ktpUrl }}" alt="KTP Orang Tua - {{ $registration->parent_name }}" class="max-h-44 sm:max-h-48 max-w-full object-contain rounded-lg border border-slate-300 shadow-sm bg-white p-1">
                                    @endif
                                @else
                                    <div class="w-full h-44 border-2 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center text-center p-3 bg-white">
                                        <span class="text-3xl text-slate-300">🪪</span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-1">KTP Orang Tua Belum Diunggah</span>
                                    </div>
                                @endif
                            </div>
                            <div class="text-left pt-1 border-t border-slate-200 flex justify-between items-center text-[10px]">
                                <span class="font-bold text-slate-700">Nama: {{ $registration->parent_name }}</span>
                                <span class="font-mono text-slate-500">WA: {{ $registration->phone_number }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Baris 2: Bukti Transfer Biaya Pendaftaran -->
                    <div class="border border-slate-300 rounded-xl p-3 bg-slate-50/50 space-y-2">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-1.5">
                            <div class="flex items-center gap-2">
                                <span class="font-black text-slate-800 text-[11px]">3. BUKTI TRANSFER BIAYA PENDAFTARAN</span>
                                <span class="text-[9px] font-black text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full">
                                    {{ $registration->fee_paid ? '✓ LUNAS' : 'STATUS: MENUNGGU VERIFIKASI' }}
                                </span>
                            </div>
                            <span class="font-mono font-black text-emerald-900 text-xs">
                                Biaya: Rp {{ number_format($registration->registration_fee, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-1">
                            <div class="flex-1 w-full flex items-center justify-center min-h-[190px] max-h-[260px]">
                                @if(!empty($buktiUrl))
                                    @if($buktiIsPdf)
                                        <div class="text-center p-4">
                                            <span class="text-3xl block">📄</span>
                                            <p class="text-xs font-bold text-slate-700 mt-1">Bukti Transfer Format PDF</p>
                                            <a href="{{ $buktiUrl }}" target="_blank" class="no-print inline-block mt-2 px-3 py-1 rounded-lg bg-emerald-700 text-white font-bold text-[10px]">Buka Struk Transfer ↗</a>
                                        </div>
                                    @else
                                        <img src="{{ $buktiUrl }}" alt="Bukti Transfer Pendaftaran" class="max-h-[250px] max-w-full object-contain rounded-lg border border-slate-300 shadow-sm bg-white p-1">
                                    @endif
                                @else
                                    <div class="w-full h-36 border-2 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center text-center p-3 bg-white">
                                        <span class="text-3xl text-slate-300">💳</span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-1">Bukti Transfer Belum Diunggah</span>
                                    </div>
                                @endif
                            </div>
                            <div class="w-full sm:w-64 bg-white p-2.5 rounded-lg border border-slate-200 text-[10px] space-y-1.5 shrink-0">
                                <span class="font-bold text-slate-700 block border-b border-slate-100 pb-1">Rincian Transaksi:</span>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Unit Sekolah:</span>
                                    <strong class="text-slate-800">{{ $registration->target_level }} ROBBANI</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Nominal Biaya:</span>
                                    <strong class="text-emerald-800 font-mono font-bold">Rp {{ number_format($registration->registration_fee, 0, ',', '.') }}</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Bank Tujuan:</span>
                                    <strong class="text-slate-800">BSI / Bank Muamalat</strong>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Atas Nama:</span>
                                    <span class="text-[9px] text-slate-700 font-bold truncate">YAYASAN GENERASI ROBBANI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Hal 4 -->
            <div class="pt-3 border-t border-slate-200 text-[9px] text-slate-400 text-center flex justify-between items-center">
                <span>Dokumen formulir resmi pendaftaran peserta didik baru SIT Robbani Ogan Ilir.</span>
                <span class="font-bold text-slate-600">Halaman 4 dari 4: Lampiran III (Foto, KTP Ortu & Bukti Transfer)</span>
            </div>
        </div>

    </div>

</body>
</html>
