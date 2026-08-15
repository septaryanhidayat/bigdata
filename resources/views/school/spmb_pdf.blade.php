<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Registrasi SPMB Online - {{ $registration->registration_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a; 
        }
        
        .pdf-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .gradient-line {
            background: linear-gradient(90deg, #059669 0%, #10b981 50%, #f97316 100%);
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
                margin: 10mm;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 antialiased">

    @php
        $d = json_decode($registration->details_json, true) ?? [];
        $docs = $d['uploaded_docs'] ?? [];
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="no-print max-w-4xl mx-auto mb-6 p-4 rounded-2xl bg-slate-900 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-500 text-white font-black text-lg flex items-center justify-center shadow-md">
                📄
            </div>
            <div>
                <h4 class="font-black text-sm text-white">Bukti Pendaftaran SPMB Online Resmi</h4>
                <p class="text-xs text-slate-300 font-medium">Nomor Registrasi: <span class="font-mono text-amber-300 font-bold">{{ $registration->registration_number }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <button onclick="window.print()" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                <span>🖨️</span> Cetak / Simpan Dokumen PDF
            </button>
        </div>
    </div>

    <!-- Main Printable A4 Form Container -->
    <div class="pdf-container max-w-4xl mx-auto pdf-card rounded-3xl p-6 sm:p-10 space-y-6 relative overflow-hidden">
        
        <!-- Header Kop Surat Yayasan -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b pb-6 border-slate-200">
            <div class="flex items-center gap-4 text-center sm:text-left">
                @php
                    $logoPdf = $settings['logo_light'] ?? $settings['school_logo'] ?? null;
                @endphp
                @if($logoPdf)
                <img src="{{ $logoPdf }}" alt="Logo {{ $settings['school_name'] ?? 'SIT Robbani' }}" class="h-16 w-auto max-w-[200px] object-contain shrink-0 mx-auto sm:mx-0">
                @else
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-700 via-teal-600 to-orange-500 text-white font-black text-3xl flex items-center justify-center shadow-md shrink-0 mx-auto sm:mx-0">
                    S
                </div>
                @endif
                <div>
                    <h1 class="text-lg sm:text-xl font-black tracking-tight text-slate-900 uppercase">{{ $settings['school_name'] ?? 'YAYASAN GENERASI ROBBANI SUMATERA SELATAN' }}</h1>
                    <h2 class="text-xs sm:text-sm font-bold text-emerald-700 uppercase tracking-wide">SEKOLAH ISLAM TERPADU ROBBANI (KB/TKIT, SDIT, SMPIT, SMAIT)</h2>
                    <p class="text-[10px] text-slate-500 font-medium mt-0.5">Alamat: {{ $settings['contact_address'] ?? 'Indralaya, Ogan Ilir, Sumatera Selatan' }} | Email: {{ $settings['contact_email'] ?? 'info@sitrobbani.sch.id' }}</p>
                </div>
            </div>
            
            <div class="text-center sm:text-right shrink-0 space-y-1">
                <span class="px-3.5 py-1 rounded-full bg-emerald-100 border border-emerald-200 text-emerald-800 font-mono font-black text-xs inline-block">
                    SPMB T.A 2026/2027
                </span>
                <p class="text-[10px] text-slate-400 font-bold block uppercase">VERIFIED DIGITAL DOCUMENT</p>
            </div>
        </div>

        <div class="h-1.5 w-full rounded-full gradient-line"></div>

        <!-- Document Title Banner & QR Code -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 py-1">
            <div class="text-center sm:text-left space-y-1">
                <h2 class="text-base sm:text-lg font-black text-slate-900 uppercase tracking-wide">FORMULIR TANDA TERIMA BUKTI REGISTRASI SPMB ONLINE</h2>
                <p class="text-xs text-slate-500 font-semibold">Panitia Penerimaan Murid Baru SIT Robbani Ogan Ilir</p>
                
                <div class="pt-1">
                    <div class="px-5 py-2.5 rounded-2xl bg-slate-900 text-white border-2 border-amber-400 shadow-md inline-flex items-center gap-3">
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider">NO. REGISTRASI:</span>
                        <span class="font-mono text-xl font-black text-amber-300">{{ $registration->registration_number }}</span>
                    </div>
                </div>
            </div>

            @php
                $pdfVerifyUrl = route('school.spmb.verify', $registration->registration_number);
                $pdfQrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($pdfVerifyUrl);
            @endphp
            <div class="p-2 rounded-2xl bg-white border border-slate-200 text-center shadow-xs shrink-0">
                <img src="{{ $pdfQrUrl }}" alt="QR Code Verifikasi" class="w-20 h-20 mx-auto rounded-lg">
                <span class="text-[8px] font-bold text-slate-500 uppercase block mt-0.5">Scan Untuk Akses & Download Ulang</span>
            </div>
        </div>

        <!-- Section I: Data Calon Siswa -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-2 text-white font-black text-xs uppercase flex items-center justify-between">
                <span>🎓 I. DATA CALON SISWA (ANANDA)</span>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 font-mono font-black text-[10px] uppercase">
                    UNIT: {{ $registration->target_level }}
                </span>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-3 text-xs bg-slate-50/50">
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Nama Lengkap Ananda</span>
                    <span class="font-black text-slate-900 text-sm block">{{ $registration->full_name }}</span>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">NIK Siswa / NISN</span>
                    <span class="font-mono font-bold text-slate-800 block">{{ $d['nik_siswa'] ?? '-' }} / {{ $d['nisn'] ?? '-' }}</span>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Jenis Kelamin</span>
                    <span class="font-bold text-slate-900 block">{{ $d['jenis_kelamin'] ?? 'Laki-laki' }}</span>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Tempat, Tgl Lahir</span>
                    <span class="font-bold text-slate-900 block">{{ $d['tempat_lahir'] ?? 'Kota' }}, {{ isset($d['tanggal_lahir']) ? \Carbon\Carbon::parse($d['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}</span>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Jalur Pendaftaran</span>
                    <span class="font-black text-emerald-700 block uppercase">{{ $d['jalur_pendaftaran'] ?? 'REGULER' }}</span>
                </div>
                <div class="space-y-0.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Sekolah Asal</span>
                    <span class="font-bold text-slate-800 block">{{ $registration->previous_school ?? 'TK/SD Asal' }}</span>
                </div>
            </div>
        </div>

        <!-- Section II: Data Orang Tua Kandung -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-2 text-white font-black text-xs uppercase flex items-center justify-between">
                <span>👨‍👩‍👦 II. DATA ORANG TUA KANDUNG & KONTAK</span>
                <span class="text-[10px] text-amber-300 font-bold">VERIFIED CONTACT</span>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-xs bg-slate-50/50">
                <div class="space-y-0.5 border-b sm:border-b-0 pb-2 sm:pb-0 border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">👨 Ayah Kandung</span>
                    <span class="font-black text-slate-900 block">{{ $registration->parent_name }}</span>
                    <span class="text-[11px] text-slate-600 block">Pekerjaan: {{ $d['pekerjaan_ayah'] ?? '-' }} ({{ $d['pendidikan_ayah'] ?? '-' }})</span>
                    <span class="text-[11px] font-mono text-emerald-700 font-bold block">WA: {{ $registration->phone_number }}</span>
                </div>
                <div class="space-y-0.5 border-b sm:border-b-0 pb-2 sm:pb-0 border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">👩 Ibu Kandung</span>
                    <span class="font-black text-slate-900 block">{{ $d['nama_ibu'] ?? '-' }}</span>
                    <span class="text-[11px] text-slate-600 block">Pekerjaan: {{ $d['pekerjaan_ibu'] ?? '-' }} ({{ $d['pendidikan_ibu'] ?? '-' }})</span>
                    <span class="text-[11px] font-mono text-orange-700 font-bold block">WA: {{ $d['no_hp_ibu'] ?? '-' }}</span>
                </div>
                <div class="space-y-0.5 col-span-1 sm:col-span-2 pt-2 border-t border-slate-200">
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Email Aktif Orang Tua</span>
                    <span class="font-mono font-bold text-slate-900 block">{{ $d['email_ortu'] ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Section III: Data Domisili Siswa -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-2 text-white font-black text-xs uppercase">
                <span>🏡 III. ALAMAT DOMISILI SISWA</span>
            </div>
            <div class="p-4 text-xs bg-slate-50/50 space-y-1">
                <span class="font-bold text-slate-900 block">{{ $d['alamat'] ?? $registration->address ?? '-' }}</span>
                <span class="text-slate-600 block">Desa/Kel: {{ $d['kelurahan'] ?? '-' }} | Kec: {{ $d['kecamatan'] ?? 'Indralaya Utara' }} | Kab: {{ $d['kabupaten'] ?? 'Ogan Ilir' }} | Prov: {{ $d['provinsi'] ?? 'Sumatera Selatan' }}</span>
            </div>
        </div>

        <!-- Section IV: Checklist Berkas Dokumen Uploaded -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-900 to-slate-800 px-4 py-2 text-white font-black text-xs uppercase">
                <span>📁 IV. CHECKLIST DOKUMEN LAMPIRAN BERKAS</span>
            </div>
            <div class="p-4 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs bg-slate-50/50 font-bold">
                <div class="flex items-center gap-1.5 {{ !empty($docs['pas_foto']) ? 'text-emerald-700' : 'text-slate-400' }}">
                    <span>{{ !empty($docs['pas_foto']) ? '☑' : '☐' }}</span> Pas Foto Ananda
                </div>
                <div class="flex items-center gap-1.5 {{ !empty($docs['ktp_ortu']) ? 'text-emerald-700' : 'text-slate-400' }}">
                    <span>{{ !empty($docs['ktp_ortu']) ? '☑' : '☐' }}</span> KTP Orang Tua
                </div>
                <div class="flex items-center gap-1.5 {{ !empty($docs['kartu_keluarga']) ? 'text-emerald-700' : 'text-slate-400' }}">
                    <span>{{ !empty($docs['kartu_keluarga']) ? '☑' : '☐' }}</span> Kartu Keluarga (KK)
                </div>
                <div class="flex items-center gap-1.5 {{ !empty($docs['bukti_transfer']) ? 'text-emerald-700' : 'text-slate-400' }}">
                    <span>{{ !empty($docs['bukti_transfer']) ? '☑' : '☐' }}</span> Bukti Transfer Form
                </div>
            </div>
        </div>

        <!-- Section V: Tanggung Jawab & Tanda Tangan Official -->
        <div class="pt-2 grid grid-cols-1 sm:grid-cols-2 gap-6 items-end text-xs">
            
            <!-- Stamp Simulator -->
            <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded bg-emerald-600 text-white font-black text-[9px] uppercase">STAMP VERIFIED</span>
                    <span class="font-bold text-slate-700 text-[10px]">SIT ROBBANI ADMISI</span>
                </div>
                <p class="text-[11px] text-slate-600 leading-relaxed">
                    Dokumen ini merupakan bukti pendaftaran sah. Harap membawa dokumen cetak ini saat mengikuti tahapan <strong>observasi & tes pemetaan</strong> di kampus SIT Robbani Ogan Ilir.
                </p>
            </div>

            <!-- Signature Box -->
            <div class="text-center space-y-8 sm:pl-8">
                <div>
                    <p class="font-bold text-slate-700">Ogan Ilir, {{ now()->translatedFormat('d F Y') }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">Panitia SPMB SIT Robbani</p>
                </div>
                <div class="border-b-2 border-slate-900 w-48 mx-auto"></div>
                <div>
                    <p class="font-black text-slate-900">Tim Admisi & SPMB Online</p>
                    <p class="text-[9px] text-slate-500 font-bold uppercase">SIT ROBBANI OGAN ILIR</p>
                </div>
            </div>

        </div>

        <!-- Footer Bar -->
        <div class="pt-4 border-t border-slate-200 text-center text-[10px] font-semibold text-slate-400 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>© {{ date('Y') }} SIT Robbani Ogan Ilir (SmartEdu Digital System)</span>
            <span>Printed on: {{ now()->translatedFormat('d F Y H:i:s') }}</span>
        </div>

    </div>

</body>
</html>
