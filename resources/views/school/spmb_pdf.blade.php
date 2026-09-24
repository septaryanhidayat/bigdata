<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir F-SPMB Resmi - {{ $registration->registration_number }} | SIT Robbani</title>
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
            padding: 4px 8px;
            vertical-align: top;
        }

        .table-field tr:nth-child(even) {
            background-color: #f8fafc;
        }

        @media print {
            .no-print { display: none !important; }
            body { 
                padding: 0 !important; 
                margin: 0 !important; 
                background: #ffffff !important; 
            }
            .pdf-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
            }
            @page {
                size: A4 portrait;
                margin: 8mm 10mm;
            }
        }
    </style>
</head>
<body class="p-3 sm:p-8 antialiased">

    @php
        $d = is_array($registration->details_json) 
            ? $registration->details_json 
            : (is_string($registration->details_json) ? (json_decode($registration->details_json, true) ?? []) : []);
        $docs = $d['uploaded_docs'] ?? [];
        $verifyUrl = route('school.spmb.verify', $registration->registration_number);
        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=' . urlencode($verifyUrl);
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 p-4 rounded-2xl bg-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white font-black text-lg flex items-center justify-center shadow-md">
                📄
            </div>
            <div>
                <h4 class="font-black text-sm text-white">Formulir Pendaftaran Siswa Baru (F-SPMB)</h4>
                <p class="text-xs text-slate-300 font-medium">Nomor Registrasi: <span class="font-mono text-amber-300 font-bold">{{ $registration->registration_number }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <button onclick="window.print()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                <span>🖨️</span> Cetak / Simpan PDF
            </button>
            <a href="{{ route('school.spmb') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs">
                Kembali
            </a>
        </div>
    </div>

    <!-- Main Printable A4 Form Container -->
    <div class="pdf-container max-w-4xl mx-auto pdf-card rounded-2xl p-6 sm:p-10 space-y-5 text-xs text-slate-900">
        
        <!-- Header Kop Surat Sekolah Islam Terpadu Robbani (Rata Tengah Simetris) -->
        <div class="flex items-center justify-between border-b-2 border-emerald-950 pb-3 gap-2 sm:gap-4">
            <!-- Logo Kiri -->
            <div class="w-20 sm:w-24 shrink-0 flex items-center justify-center">
                <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-16 sm:h-20 w-auto object-contain mx-auto" onerror="this.src='{{ asset('favicon.png') }}'">
            </div>
            
            <!-- Teks Kop Surat Rata Tengah -->
            <div class="flex-1 text-center px-1">
                <h1 class="text-base sm:text-xl font-black tracking-tight uppercase text-emerald-950 leading-tight">
                    SEKOLAH ISLAM TERPADU ROBBANI
                </h1>
                <p class="text-[10px] sm:text-xs text-slate-800 font-bold leading-snug mt-1">
                    KPA (Kantor Pelayanan Administrasi) Sekolah Islam Terpadu Robbani
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
        <div class="text-center space-y-1">
            <h3 class="text-sm sm:text-base font-black uppercase tracking-wide text-slate-900">
                FORMULIR PENERIMAAN PESERTA DIDIK BARU SEKOLAH ISLAM TERPADU ROBBANI
            </h3>
            <div class="flex items-center justify-between text-[11px] font-bold text-slate-700 pt-1">
                <span>Tanggal: {{ $registration->created_at ? $registration->created_at->translatedFormat('d / m / Y') : date('d / m / Y') }}</span>
                <span>REG : <strong class="font-mono text-emerald-900 text-xs">{{ $registration->registration_number }}</strong></span>
            </div>
        </div>

        <!-- I. IDENTITAS PESERTA DIDIK (WAJIB DIISI) -->
        <div class="border border-slate-300 rounded-lg overflow-hidden">
            <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase flex justify-between items-center">
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
                        <td colspan="4">{{ $d['tempat_tinggal_anak'] ?? 'Ikut Orang Tua' }}</td>
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
            <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase">
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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Data Kesehatan -->
            <div class="border border-slate-300 rounded-lg overflow-hidden">
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase">
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
                <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase">
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
            <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase">
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
            <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase">
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
            <div class="bg-emerald-800 text-white font-black text-[11px] px-3 py-1.5 uppercase flex justify-between items-center">
                <span>VI. KELENGKAPAN BERKAS PERSYARATAN & BIAYA PENDAFTARAN</span>
                <span class="text-[10px] font-bold font-mono">Biaya: Rp {{ number_format($registration->registration_fee ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="p-2.5 bg-slate-50/50">
                <div class="grid grid-cols-2 gap-x-4 gap-y-1.5 text-[10px]">
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ !empty($d['uploaded_docs']['akta_kelahiran']) ? '☑' : '☐' }} 1. Akta Kelahiran Calon Siswa</span>
                        @if(!empty($d['uploaded_docs']['akta_kelahiran']))
                            <span class="text-[9px] text-emerald-700 font-bold">(Terlampir / Upload)</span>
                        @else
                            <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ !empty($d['uploaded_docs']['kartu_keluarga']) ? '☑' : '☐' }} 2. Kartu Keluarga (KK)</span>
                        @if(!empty($d['uploaded_docs']['kartu_keluarga']))
                            <span class="text-[9px] text-emerald-700 font-bold">(Terlampir / Upload)</span>
                        @else
                            <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ !empty($d['uploaded_docs']['ktp_ortu']) ? '☑' : '☐' }} 3. KTP Orang Tua (Ayah / Ibu)</span>
                        @if(!empty($d['uploaded_docs']['ktp_ortu']))
                            <span class="text-[9px] text-emerald-700 font-bold">(Terlampir / Upload)</span>
                        @else
                            <span class="text-[9px] text-slate-400">(Fotokopi 1 Lembar)</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-bold text-slate-800">{{ !empty($d['uploaded_docs']['pas_foto']) ? '☑' : '☐' }} 4. Pas Foto Calon Siswa (3x4 & 2x3)</span>
                        @if(!empty($d['uploaded_docs']['pas_foto']))
                            <span class="text-[9px] text-emerald-700 font-bold">(Terlampir / Upload)</span>
                        @else
                            <span class="text-[9px] text-slate-400">(@ 2 Lembar)</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 col-span-2 pt-1 border-t border-slate-200">
                        <span class="font-bold text-slate-800">{{ !empty($d['uploaded_docs']['bukti_transfer']) ? '☑' : '☐' }} 5. Bukti Transfer Biaya Pendaftaran Unit:</span>
                        <span class="font-mono font-bold text-emerald-800">Rp {{ number_format($registration->registration_fee ?? 0, 0, ',', '.') }}</span>
                        @if(!empty($d['uploaded_docs']['bukti_transfer']))
                            <span class="text-[9px] text-emerald-700 font-bold">(Bukti Transfer Terlampir / Terverifikasi)</span>
                        @else
                            <span class="text-[9px] text-amber-700 font-bold">(Menunggu Pembayaran / Verifikasi)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan Official Panitia & Orang Tua Siswa -->
        <div class="pt-6 flex justify-between items-end px-8 sm:px-14 text-center text-xs">
            <!-- Kolom 1: Panitia SPMB -->
            <div class="space-y-14">
                <div>
                    <span class="block text-slate-500 text-[10px]">Mengetahui,</span>
                    <strong class="font-black text-slate-900">Panitia SPMB SIT Robbani</strong>
                </div>
                <div class="border-t border-slate-400 w-40 sm:w-48 mx-auto pt-1 font-bold text-slate-800 text-[11px]">
                    ( Panitia SPMB SIT Robbani )
                </div>
            </div>

            <!-- Kolom 2: Orang Tua Siswa -->
            <div class="space-y-14">
                <div>
                    <span class="block text-slate-500 text-[10px]">Indralaya, {{ $registration->created_at ? $registration->created_at->translatedFormat('d F Y') : date('d F Y') }}</span>
                    <strong class="font-black text-slate-900">Orang Tua / Wali Siswa</strong>
                </div>
                <div class="border-t border-slate-400 w-40 sm:w-48 mx-auto pt-1 font-bold text-slate-800 text-[11px]">
                    ( {{ $registration->parent_name }} )
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 text-[9px] text-slate-400 text-center flex justify-between items-center">
            <span>Dokumen formulir resmi pendaftaran peserta didik baru SIT Robbani Ogan Ilir.</span>
            <span>Dicetak secara elektronik pada {{ now()->translatedFormat('d F Y H:i') }} WIB</span>
        </div>
    </div>

</body>
</html>
