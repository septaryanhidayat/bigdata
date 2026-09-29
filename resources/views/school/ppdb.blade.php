<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Formulir Pendaftaran SPMB Online T.A 2026/2027 | SIT Robbani Ogan Ilir</title>
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=12">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=12">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=12">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="Formulir SPMB Online 2026/2027 | SIT Robbani">
    <meta property="og:description" content="Sistem Penerimaan Murid Baru (SPMB) SIT Robbani Ogan Ilir Jenjang TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT T.A 2026/2027.">
    <meta property="og:image" content="{{ asset('images/logo robbani light.png') }}">
    <meta name="theme-color" content="#047857">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            background-color: #f8fafc; 
            color: #1e293b; 
        }
        .form-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.04), 0 8px 10px -6px rgba(15, 23, 42, 0.02);
        }
        .form-input {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .form-input:focus {
            border-color: #047857;
            box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.15);
            outline: none;
        }
        .step-pill-active {
            background-color: #047857 !important;
            color: #ffffff !important;
            font-weight: 800;
        }
        .step-pill-inactive {
            background-color: #f1f5f9 !important;
            color: #64748b !important;
            border: 1px solid #e2e8f0 !important;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="antialiased min-h-screen pb-16 flex flex-col justify-between">

    <!-- Header Navigation Bar -->
    <header class="py-2.5 sm:py-3 px-3 sm:px-8 sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
            <!-- Brand Logo (Logo Saja Tanpa Teks) -->
            <a href="{{ url('/') }}" class="flex items-center shrink-0" title="Beranda SPMB SIT Robbani">
                <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 sm:h-10 w-auto object-contain">
            </a>

            <!-- Right Controls -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <a href="https://sitrobbani.sch.id" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors whitespace-nowrap" title="Kunjungi Website Utama SIT Robbani">
                    <span>🌐 Web Utama</span>
                </a>
                <a href="{{ url('/') }}" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white font-bold text-xs transition-colors flex items-center gap-1.5 shrink-0 whitespace-nowrap">
                    <span>← SPMB</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="py-6 sm:py-10 max-w-4xl mx-auto px-3 sm:px-4 w-full space-y-6 flex-1">
        
        @if(session('spmb_success_data'))
        @php 
            $data = session('spmb_success_data'); 
            $regId = $data['registration_id'] ?? null;
            $regNumber = $data['registration_number'] ?? '';
            $studentName = $data['student_name'] ?? '';
            $targetLevel = $data['target_level'] ?? '';
            $parentPhone = $data['parent_phone'] ?? '';
            $parentName = $data['parent_name'] ?? '';
            $date = $data['date'] ?? now()->translatedFormat('d F Y H:i');
            
            $regObj = $regId ? \App\Models\PpdbRegistration::find($regId) : null;
            $d = $data['details'] ?? ($regObj ? (is_array($regObj->details_json) ? $regObj->details_json : (json_decode($regObj->details_json, true) ?? [])) : []);
            
            $verifyUrl = route('school.spmb.verify', $regNumber);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($verifyUrl);
            $cleanWa = preg_replace('/[^0-9]/', '', $spmb['wa_number'] ?? '62811747472');
            $regFee = $data['registration_fee'] ?? ($regObj->registration_fee ?? 450000);
        @endphp

        <!-- ========================================================================= -->
        <!-- SUCCESS STATE: HASIL OUTPUT PENDAFTARAN & QR CODE SAJA (FORM DISEMBUNYIKAN) -->
        <!-- ========================================================================= -->
        <div class="space-y-6">
            <!-- Hero Status Card -->
            <div class="p-6 sm:p-9 rounded-3xl bg-gradient-to-br from-emerald-800 via-emerald-900 to-slate-950 text-white shadow-2xl space-y-6 relative overflow-hidden border border-emerald-700/50">
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Top Pill Badge -->
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-emerald-700/80 pb-4">
                    @if(!empty($data['is_updated']))
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-400 text-amber-950 text-xs font-black uppercase tracking-wider shadow-sm">
                        <span>✓</span> Perubahan Data Formulir Berhasil Disimpan
                    </span>
                    @else
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 text-xs font-black uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        ✓ Pendaftaran SPMB Berhasil Diterima
                    </span>
                    @endif
                    <span class="text-xs text-emerald-200/80 font-medium">Tercatat: {{ $date }} WIB</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-2 space-y-3 text-center sm:text-left">
                        <h2 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                            @if(!empty($data['is_updated']))
                                Alhamdulillah! Perbaikan Data Ananda <span class="text-amber-300">{{ $studentName }}</span> Berhasil Disimpan.
                            @else
                                Alhamdulillah! Formulir Ananda <span class="text-amber-300">{{ $studentName }}</span> Telah Berhasil Terkirim.
                            @endif
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100/90 leading-relaxed font-medium">
                            @if(!empty($data['is_updated']))
                                Seluruh pembaruan data dan berkas telah tersimpan. Silakan simpan kembali atau unduh ulang formulir PDF terbaru di bawah ini.
                            @else
                                Data formulir resmi Anda telah berhasil disimpan di sistem SPMB SIT Robbani. Silakan simpan Nomor Registrasi resmi dan QR Code berikut sebagai identitas pendaftaran resmi yang sah.
                            @endif
                        </p>

                        <!-- Nomor Registrasi Prominen -->
                        <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                            <div class="px-5 py-2.5 rounded-2xl bg-slate-950 border border-amber-400/40 shadow-inner flex items-center gap-3">
                                <div>
                                    <span class="text-[9px] text-slate-400 uppercase tracking-widest block font-sans">Nomor Registrasi Resmi</span>
                                    <span class="font-mono text-xl sm:text-2xl font-black text-amber-300 tracking-wider" id="regNumberText">{{ $regNumber }}</span>
                                </div>
                            </div>
                            <button type="button" onclick="copyRegNumber('{{ $regNumber }}')" class="px-3.5 py-2.5 rounded-xl bg-emerald-800/80 hover:bg-emerald-700 text-emerald-100 text-xs font-bold border border-emerald-600 transition-colors flex items-center gap-1.5 shadow-sm">
                                <span>📋</span> <span id="copyBtnText">Salin Nomor</span>
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1 text-xs text-emerald-200">
                            <span>Jenjang Target: <strong class="text-white bg-emerald-700/60 px-2.5 py-0.5 rounded-lg">{{ $targetLevel }}</strong></span>
                            <span>•</span>
                            <span>WhatsApp Panitia: <strong class="text-white">{{ $spmb['wa_number'] ?? '0811-747-472' }}</strong></span>
                        </div>
                    </div>

                    <!-- QR Code Digital Verification Box -->
                    <div class="p-4 rounded-3xl bg-white text-center shadow-2xl shrink-0 mx-auto w-48 border border-emerald-100">
                        <img src="{{ $qrUrl }}" alt="QR Code Pendaftaran" class="w-36 h-36 mx-auto rounded-xl object-contain">
                        <div class="mt-2 space-y-0.5">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Verifikasi Digital</span>
                            <a href="{{ $verifyUrl }}" target="_blank" class="text-xs font-black text-emerald-800 hover:text-emerald-900 hover:underline block">
                                Cek Keaslian ↗
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Primary Action Buttons Row -->
                <div class="pt-4 border-t border-emerald-700/80 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <a href="{{ route('school.spmb.download-pdf', $regId) }}" target="_blank" class="py-3 px-4 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs text-center flex items-center justify-center gap-2 shadow-lg hover:shadow-amber-500/25 transition-all">
                        <span>🖨️</span>
                        <span>Cetak / Unduh Formulir PDF</span>
                    </a>
                    <a href="{{ request()->routeIs('subdomain.spmb*') ? route('subdomain.spmb.form', ['edit' => $regId]) : route('school.spmb.form', ['edit' => $regId]) }}" class="py-3 px-4 rounded-2xl bg-amber-600 hover:bg-amber-500 text-white font-black text-xs text-center flex items-center justify-center gap-2 transition-all shadow-md">
                        <span>✏️</span>
                        <span>Perbaiki / Ubah Data</span>
                    </a>
                    <a href="https://wa.me/{{ $cleanWa }}?text=Assalamu'alaikum%20Panitia%20SPMB,%20saya%20sudah%20mendaftar%20dengan%20No%20Registrasi%20{{ $regNumber }}%20atas%20nama%20ananda%20{{ urlencode($studentName) }}" target="_blank" class="py-3 px-4 rounded-2xl bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs text-center flex items-center justify-center gap-2 transition-all shadow-md">
                        <span>💬</span>
                        <span>Konfirmasi ke Panitia WA</span>
                    </a>
                    <a href="{{ route('school.spmb.form', ['new' => 1]) }}" class="py-3 px-4 rounded-2xl bg-white hover:bg-slate-100 text-emerald-950 font-black text-xs text-center flex items-center justify-center gap-2 transition-all shadow-md">
                        <span>➕</span>
                        <span>Daftarkan Siswa Lain</span>
                    </a>
                </div>
            </div>

            <!-- Ringkasan Hasil Isian Formulir Resmi -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between pb-4 border-b border-slate-200 gap-2">
                    <div>
                        <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                            Output Formulir F-SPMB
                        </span>
                        <h3 class="text-lg sm:text-xl font-black text-slate-900 mt-1">Ringkasan Data Pendaftaran Calon Peserta Didik Baru</h3>
                        <p class="text-xs text-slate-500">Berikut rincian data formulir resmi yang telah tersimpan dalam database:</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ request()->routeIs('subdomain.spmb*') ? route('subdomain.spmb.form', ['edit' => $regId]) : route('school.spmb.form', ['edit' => $regId]) }}" class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 text-xs font-bold transition-colors flex items-center gap-1.5">
                            <span>✏️ Perbaiki Data</span>
                        </a>
                        <a href="{{ route('school.spmb.download-pdf', $regId) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors flex items-center gap-1.5">
                            <span>🖨️ Cetak PDF</span>
                        </a>
                    </div>
                </div>

                <!-- 1. Identitas Calon Siswa -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black uppercase text-emerald-900 tracking-wider flex items-center gap-2">
                        <span>🧒</span>
                        <span>1. Identitas Calon Peserta Didik</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 text-xs">
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Nama Lengkap Siswa</span>
                            <span class="font-extrabold text-slate-900 block">{{ $d['nama_lengkap'] ?? $studentName }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Nama Panggilan</span>
                            <span class="font-bold text-slate-800 block">{{ $d['nama_panggilan'] ?? '-' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">NIK Siswa</span>
                            <span class="font-mono font-bold text-slate-800 block">{{ $d['nik_siswa'] ?? '-' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Jenis Kelamin</span>
                            <span class="font-bold text-slate-800 block">{{ $d['jenis_kelamin'] ?? '-' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Tempat, Tanggal Lahir</span>
                            <span class="font-bold text-slate-800 block">
                                {{ $d['tempat_lahir'] ?? '-' }}, {{ isset($d['tanggal_lahir']) ? \Carbon\Carbon::parse($d['tanggal_lahir'])->translatedFormat('d F Y') : '-' }}
                            </span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Anak ke / Dari Saudara</span>
                            <span class="font-bold text-slate-800 block">Anak ke-{{ $d['anak_ke'] ?? '1' }} dari {{ $d['jumlah_saudara'] ?? '1' }} bersaudara</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Status Tempat Tinggal</span>
                            <span class="font-bold text-slate-800 block">{{ $d['status_tempat_tinggal'] ?? '-' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Keadaan Jasmani</span>
                            <span class="font-bold text-slate-800 block">{{ $d['keadaan_jasmani'] ?? 'Sehat Walafiat' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kewarganegaraan & Agama</span>
                            <span class="font-bold text-slate-800 block">{{ $d['kewarganegaraan'] ?? 'WNI' }} ({{ $d['agama'] ?? 'Islam' }})</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Unit Pilihan & Sekolah Asal -->
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    <h4 class="text-xs font-black uppercase text-emerald-900 tracking-wider flex items-center gap-2">
                        <span>🏫</span>
                        <span>2. Unit Sekolah Tujuan & Riwayat Sekolah Asal</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
                        <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-emerald-700 uppercase">Unit Sekolah Pilihan</span>
                            <span class="font-extrabold text-emerald-900 block text-sm">{{ $d['school_code'] ?? $targetLevel }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Pilihan Kelas / Status</span>
                            <span class="font-bold text-slate-800 block">{{ $d['masuk_kelas'] ?? 'Siswa Baru' }} ({{ $d['status_siswa'] ?? 'Baru' }})</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Jalur Pendaftaran</span>
                            <span class="font-bold text-slate-800 block">{{ $d['jalur_pendaftaran'] ?? 'Reguler' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Kategori Calon Siswa</span>
                            <div class="pt-0.5">
                                @php
                                    $katOutput = strtoupper((string)($d['kategori_sekolah_asal'] ?? ''));
                                @endphp
                                @if(str_contains($katOutput, 'ALUMNI'))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                                        <span>⭐</span> Alumni SIT Robbani
                                    </span>
                                @elseif(str_contains($katOutput, 'BELUM'))
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                        <span>👶</span> Belum Sekolah
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                        <span>🏫</span> Luar SIT Robbani
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 space-y-0.5">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">Sekolah Asal</span>
                            <span class="font-bold text-slate-800 block truncate" title="{{ $d['sekolah_asal'] ?? ($data['previous_school'] ?? '-') }}">{{ $d['sekolah_asal'] ?? ($data['previous_school'] ?? '-') }}</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Data Orang Tua & Domisili -->
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    <h4 class="text-xs font-black uppercase text-emerald-900 tracking-wider flex items-center gap-2">
                        <span>👨‍👩‍👦</span>
                        <span>3. Data Orang Tua & Kontak Domisili</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <!-- Ayah -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Data Ayah Kandung</span>
                            <span class="font-black text-slate-900 block text-sm">{{ $d['nama_ayah'] ?? ($parentName ?: '-') }}</span>
                            <p class="text-slate-600 text-[11px]">
                                NIK: <span class="font-mono font-bold">{{ $d['nik_ayah'] ?? '-' }}</span> | Profesi: <span class="font-medium">{{ $d['pekerjaan_ayah'] ?? '-' }} ({{ $d['instansi_ayah'] ?? '-' }})</span>
                            </p>
                            <p class="text-emerald-800 font-bold text-[11px] pt-0.5">
                                No. WhatsApp: {{ $d['no_hp_ayah'] ?? ($parentPhone ?: '-') }}
                            </p>
                        </div>
                        <!-- Ibu -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Data Ibu Kandung</span>
                            <span class="font-black text-slate-900 block text-sm">{{ $d['nama_ibu'] ?? '-' }}</span>
                            <p class="text-slate-600 text-[11px]">
                                NIK: <span class="font-mono font-bold">{{ $d['nik_ibu'] ?? '-' }}</span> | Profesi: <span class="font-medium">{{ $d['pekerjaan_ibu'] ?? '-' }} ({{ $d['instansi_ibu'] ?? '-' }})</span>
                            </p>
                            <p class="text-slate-600 font-medium text-[11px] pt-0.5">
                                No. WhatsApp: {{ $d['no_hp_ibu'] ?? '-' }}
                            </p>
                        </div>
                        <!-- Alamat Lengkap -->
                        <div class="sm:col-span-2 p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Alamat Domisili Tempat Tinggal</span>
                            <p class="font-bold text-slate-800 text-xs">
                                {{ $d['alamat'] ?? '-' }}
                            </p>
                            <p class="text-slate-500 text-[11px]">
                                Kel/Desa: {{ $d['kelurahan'] ?? '-' }} | Kec: {{ $d['kecamatan'] ?? '-' }} | Kab/Kota: {{ $d['kabupaten'] ?? 'Ogan Ilir' }} | Prov: {{ $d['provinsi'] ?? 'Sumatera Selatan' }} {{ !empty($d['kode_pos']) ? '(' . $d['kode_pos'] . ')' : '' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 4. Administrasi & Dokumen Berkas -->
                <div class="space-y-3 pt-2 border-t border-slate-100">
                    <h4 class="text-xs font-black uppercase text-emerald-900 tracking-wider flex items-center gap-2">
                        <span>📑</span>
                        <span>4. Administrasi Biaya & Berkas Unggahan</span>
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200/80 space-y-1">
                            <span class="text-[10px] font-bold text-amber-900 uppercase block">Biaya Formulir Pendaftaran Unit</span>
                            <span class="font-mono text-lg font-black text-amber-950 block">Rp {{ number_format($regFee, 0, ',', '.') }}</span>
                            <p class="text-[11px] text-amber-800 font-medium">
                                Status: {{ !empty($d['uploaded_docs']['bukti_transfer']) ? '✓ Bukti Pembayaran Telah Diunggah' : 'Menunggu Konfirmasi Pembayaran' }}
                            </p>
                        </div>
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1.5 text-[11px]">
                            <span class="text-[10px] font-bold text-slate-400 uppercase block">Status Kelengkapan Dokumen</span>
                            <div class="grid grid-cols-2 gap-1 text-[11px]">
                                <span class="flex items-center gap-1.5">
                                    <span class="{{ !empty($d['uploaded_docs']['akta_kelahiran']) ? 'text-emerald-700 font-bold' : 'text-slate-400' }}">{{ !empty($d['uploaded_docs']['akta_kelahiran']) ? '☑' : '☐' }}</span>
                                    <span>Akta Kelahiran</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="{{ !empty($d['uploaded_docs']['kartu_keluarga']) ? 'text-emerald-700 font-bold' : 'text-slate-400' }}">{{ !empty($d['uploaded_docs']['kartu_keluarga']) ? '☑' : '☐' }}</span>
                                    <span>Kartu Keluarga</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="{{ !empty($d['uploaded_docs']['ktp_ortu']) ? 'text-emerald-700 font-bold' : 'text-slate-400' }}">{{ !empty($d['uploaded_docs']['ktp_ortu']) ? '☑' : '☐' }}</span>
                                    <span>KTP Orang Tua</span>
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="{{ !empty($d['uploaded_docs']['pas_foto']) ? 'text-emerald-700 font-bold' : 'text-slate-400' }}">{{ !empty($d['uploaded_docs']['pas_foto']) ? '☑' : '☐' }}</span>
                                    <span>Pas Foto Siswa</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Callout Box: Perbaiki Data Formulir -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-amber-50/80 border border-amber-200">
                    <div class="space-y-0.5 text-center sm:text-left">
                        <h5 class="text-xs font-black text-amber-950 flex items-center justify-center sm:justify-start gap-1.5">
                            <span>✏️</span>
                            <span>Menemukan kesalahan data atau ingin melengkapi berkas?</span>
                        </h5>
                        <p class="text-[11px] text-amber-800 font-medium">Selama status pendaftaran masih menunggu verifikasi (PENDING), Anda dapat memperbarui informasi formulir kapan saja.</p>
                    </div>
                    <a href="{{ request()->routeIs('subdomain.spmb*') ? route('subdomain.spmb.form', ['edit' => $regId]) : route('school.spmb.form', ['edit' => $regId]) }}" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs transition-all shadow-md shrink-0 flex items-center gap-1.5">
                        <span>✏️</span>
                        <span>Perbaiki Data Formulir Ini</span>
                    </a>
                </div>

                <!-- Callout Box: Daftarkan Calon Siswa Lain -->
                <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="space-y-0.5 text-center sm:text-left">
                        <h5 class="text-xs font-black text-slate-900">Ingin mendaftarkan putra-putri lainnya?</h5>
                        <p class="text-[11px] text-slate-500">Anda dapat langsung mengisi formulir pendaftaran baru untuk jenjang yang sama atau berbeda.</p>
                    </div>
                    <a href="{{ route('school.spmb.form', ['new' => 1]) }}" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition-all shadow-md shrink-0 flex items-center gap-1.5">
                        <span>➕</span>
                        <span>Isi Formulir untuk Siswa Lain</span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            function copyRegNumber(text) {
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text);
                } else {
                    const temp = document.createElement("input");
                    temp.value = text;
                    document.body.appendChild(temp);
                    temp.select();
                    document.execCommand("copy");
                    document.body.removeChild(temp);
                }
                const btn = document.getElementById('copyBtnText');
                if (btn) {
                    const orig = btn.innerText;
                    btn.innerText = 'Tersalin!';
                    setTimeout(() => { btn.innerText = orig; }, 2000);
                }
            }
        </script>

        @else

        <!-- Header Title (Responsive & Compact on Mobile) -->
        <div class="text-center space-y-1 sm:space-y-2">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] sm:text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                <span>{{ $spmb['form_badge'] ?? 'F-SPMB 2026-2027 / 2027-2028' }}</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-black text-slate-900 tracking-tight">
                {{ $spmb['form_title'] ?? 'Formulir Penerimaan Peserta Didik Baru' }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-2xl mx-auto hidden sm:block">
                {{ $spmb['form_desc'] ?? 'Silakan lengkapi formulir pendaftaran di bawah ini dengan data yang benar dan teliti sesuai dokumen resmi (Kartu Keluarga & Akta Kelahiran).' }}
            </p>
            <p class="text-[11px] text-slate-500 font-medium sm:hidden max-w-sm mx-auto">
                Lengkapi formulir resmi berikut sesuai dokumen Kartu Keluarga & Akta Kelahiran.
            </p>
        </div>

                @php
            $editData = (!empty($editRegistration) && is_array($editRegistration->details_json)) ? $editRegistration->details_json : [];
            $val = function($key, $default = '') use ($editData, $editRegistration) {
                if (old($key) !== null) {
                    return old($key);
                }
                if (isset($editData[$key]) && $editData[$key] !== '') {
                    return $editData[$key];
                }
                if (!empty($editRegistration)) {
                    if ($key === 'nama_lengkap') return $editRegistration->full_name;
                    if ($key === 'nama_ayah') return $editRegistration->parent_name;
                    if ($key === 'no_hp_ayah') return $editRegistration->phone_number;
                    if ($key === 'school_code') return $editRegistration->target_level;
                    if ($key === 'sekolah_asal') return $editRegistration->previous_school;
                }
                return $default;
            };

            $initialStep = 1;
            if (isset($errors) && $errors->any()) {
                $step1Keys = ['school_code', 'masuk_kelas', 'jalur_pendaftaran', 'status_siswa', 'nama_lengkap', 'nama_panggilan', 'nik_siswa', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'anak_ke', 'jumlah_saudara', 'jumlah_saudara_kandung', 'jumlah_saudara_tiri', 'agama', 'keadaan_jasmani', 'status_tempat_tinggal', 'kewarganegaraan', 'bahasa_sehari_hari'];
                $step2Keys = ['kategori_sekolah_asal', 'jenjang_sekolah_asal', 'status_sekolah_asal', 'npsn_sekolah_asal', 'nisn', 'sekolah_asal', 'prestasi'];
                $step3Keys = ['tinggi_badan', 'berat_badan', 'golongan_darah', 'penyakit_pernah', 'penyakit_sedang', 'kelainan_fisik', 'jarak_ke_sekolah', 'transportasi'];
                $step4Keys = ['alamat', 'dusun', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'nama_ayah', 'nik_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'instansi_ayah', 'jabatan_ayah', 'no_hp_ayah', 'penghasilan_ayah', 'nama_ibu', 'nik_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'instansi_ibu', 'jabatan_ibu', 'no_hp_ibu', 'penghasilan_ibu', 'nama_wali', 'hubungan_wali', 'no_hp_wali'];
                $step5Keys = ['info_pendaftaran', 'pas_foto', 'akta_kelahiran', 'kartu_keluarga', 'ktp_ortu', 'bukti_transfer'];

                foreach ($errors->keys() as $key) {
                    if (in_array($key, $step1Keys)) { $initialStep = 1; break; }
                    if (in_array($key, $step2Keys)) { $initialStep = 2; break; }
                    if (in_array($key, $step3Keys)) { $initialStep = 3; break; }
                    if (in_array($key, $step4Keys)) { $initialStep = 4; break; }
                    if (in_array($key, $step5Keys)) { $initialStep = 5; break; }
                }
            }
        @endphp

        <!-- Validation Error Alert -->
        @if (isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
            <div class="flex items-center gap-2 font-black">
                <span>⚠️</span> Terdapat kolom yang belum terisi dengan benar (Langkah {{ $initialStep }}):
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700 pl-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- STEP WIZARD NAVIGATION -->
        <!-- Desktop / Tablet Wizard (Hidden on mobile) -->
        <div class="hidden sm:block bg-white p-2.5 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="grid grid-cols-5 gap-2 text-xs font-bold">
                <button type="button" onclick="goToStep(1)" id="pill-step-1" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-active text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-white flex items-center justify-center text-[10px] font-black shrink-0">1</span>
                    <span class="truncate">Identitas Siswa</span>
                </button>
                <button type="button" onclick="goToStep(2)" id="pill-step-2" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">2</span>
                    <span class="truncate">Sekolah Asal</span>
                </button>
                <button type="button" onclick="goToStep(3)" id="pill-step-3" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">3</span>
                    <span class="truncate">Kesehatan</span>
                </button>
                <button type="button" onclick="goToStep(4)" id="pill-step-4" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">4</span>
                    <span class="truncate">Orang Tua</span>
                </button>
                <button type="button" onclick="goToStep(5)" id="pill-step-5" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">5</span>
                    <span class="truncate">Upload Berkas</span>
                </button>
            </div>
        </div>

        <!-- Mobile Stepper Progress Bar (Clean, Zero-Clipping, Never Truncated) -->
        <div class="sm:hidden bg-white p-3.5 rounded-2xl border border-slate-200/80 shadow-xs space-y-2.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-800 text-white font-black text-xs flex items-center justify-center shadow-xs" id="mobileStepBadge">1</span>
                    <div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Langkah <span id="mobileStepNum">1</span> dari 5</span>
                        <span class="text-xs font-black text-slate-900 block truncate" id="mobileStepTitle">Identitas Calon Siswa</span>
                    </div>
                </div>
                <span class="text-[11px] font-extrabold text-emerald-800" id="mobileProgressPercent">20%</span>
            </div>
            
            <!-- Progress Bar Track -->
            <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                <div id="mobileProgressBar" class="h-full bg-emerald-600 rounded-full transition-all duration-300" style="width: 20%;"></div>
            </div>

            <!-- 5 Quick Step Tap Targets for Mobile -->
            <div class="grid grid-cols-5 gap-1.5 pt-1">
                <button type="button" onclick="goToStep(1)" id="m-step-1" class="py-1 rounded-md text-[10px] font-black transition-all bg-emerald-700 text-white shadow-xs text-center">1</button>
                <button type="button" onclick="goToStep(2)" id="m-step-2" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">2</button>
                <button type="button" onclick="goToStep(3)" id="m-step-3" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">3</button>
                <button type="button" onclick="goToStep(4)" id="m-step-4" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">4</button>
                <button type="button" onclick="goToStep(5)" id="m-step-5" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">5</button>
            </div>
        </div>

                @if(!empty($editRegistration))
        <!-- MODE PERBAIKAN DATA BANNER -->
        <div class="p-4 sm:p-5 rounded-3xl bg-amber-50 border-2 border-amber-300 text-amber-950 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3.5">
                <span class="w-10 h-10 rounded-2xl bg-amber-200 text-amber-900 flex items-center justify-center text-xl shrink-0">✏️</span>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-800 bg-amber-200/60 px-2 py-0.5 rounded-full inline-block">
                        Mode Perbaikan Formulir SPMB
                    </span>
                    <h3 class="text-sm sm:text-base font-black text-slate-900 mt-0.5">
                        Memperbarui Data No. Registrasi: <span class="font-mono text-emerald-800">{{ $editRegistration->registration_number }}</span>
                    </h3>
                    <p class="text-xs text-slate-600">
                        Ananda: <strong class="text-slate-900">{{ $editRegistration->full_name }}</strong> | Unit Tujuan: <strong class="text-slate-900">{{ $editRegistration->target_level }}</strong> (Terkunci Sesuai Registrasi)
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 self-stretch sm:self-auto justify-end">
                <a href="{{ request()->routeIs('subdomain.spmb*') ? route('subdomain.spmb.form', ['new' => 1]) : route('school.spmb.form', ['new' => 1]) }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold transition-all text-center">
                    Batal / Form Baru
                </a>
            </div>
        </div>
        @endif

        <!-- MAIN FORM -->
                <form id="spmbForm" action="{{ request()->routeIs('subdomain.spmb*') ? route('subdomain.spmb.store') : route('school.spmb.store') }}" method="POST" enctype="multipart/form-data" novalidate class="p-4 sm:p-8 rounded-3xl form-card space-y-6">
            @csrf
            @if(!empty($editRegistration))
                <input type="hidden" name="registration_id" value="{{ $editRegistration->id }}">
            @endif

            <!-- ========================================================================= -->
            <!-- STEP 1: IDENTITAS PESERTA DIDIK (WAJIB DIISI) -->
            <!-- ========================================================================= -->
            <div id="step-section-1" class="step-section space-y-5">
                <div class="border-b border-slate-200 pb-3 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                        Bagian 1 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <span>🧒</span> IDENTITAS PESERTA DIDIK (WAJIB DIISI)
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Mohon diisi dengan huruf kapital sesuai Akta Kelahiran & Kartu Keluarga.</p>
                </div>

                <!-- Unit & Jalur Pendaftaran -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">
                            Unit Sekolah Tujuan *
                            @if(!empty($editRegistration))
                                <span class="text-[10px] font-bold text-amber-700 ml-1">(🔒 Terkunci Sesuai No. Registrasi)</span>
                            @endif
                        </label>
                        @if(!empty($editRegistration))
                            <input type="hidden" name="school_code" id="school_code" value="{{ $editRegistration->target_level }}">
                            <div class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700 flex items-center justify-between cursor-not-allowed">
                                <span>{{ $editRegistration->target_level }} ROBBANI</span>
                                <span class="text-[10px] font-bold text-slate-400">Unit Terkunci</span>
                            </div>
                        @else
                        <select name="school_code" id="school_code" onchange="onSchoolCodeChange()" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            @php
                                $selected = $val('school_code', $selectedUnit ?? 'SDIT');
                            @endphp
                            @if(!empty($spmb['units']))
                                @foreach($spmb['units'] as $uCode => $u)
                                    @if(!empty($u['is_active']))
                                    <option value="{{ $uCode }}" {{ ($selected == $uCode || ($uCode == 'TKIT' && $selected == 'TK') || ($uCode == 'SDIT' && $selected == 'SD') || ($uCode == 'SMPIT' && $selected == 'SMP') || ($uCode == 'SMAIT' && $selected == 'SMA')) ? 'selected' : '' }}>
                                        {{ $u['name'] ?? $uCode }} ({{ $u['level'] ?? '' }})
                                    </option>
                                    @endif
                                @endforeach
                            @else
                                <option value="TPA" {{ $selected == 'TPA' ? 'selected' : '' }}>TPA ROBBANI (Taman Pendidikan Anak)</option>
                                <option value="KB" {{ $selected == 'KB' ? 'selected' : '' }}>KB ROBBANI (Kelompok Bermain)</option>
                                <option value="TKIT" {{ ($selected == 'TKIT' || $selected == 'TK') ? 'selected' : '' }}>TK IT ROBBANI (TK Islam Terpadu)</option>
                                <option value="SDIT" {{ ($selected == 'SDIT' || $selected == 'SD') ? 'selected' : '' }}>SD IT ROBBANI (SD Islam Terpadu)</option>
                                <option value="SMPIT" {{ ($selected == 'SMPIT' || $selected == 'SMP') ? 'selected' : '' }}>SMP IT ROBBANI (SMP Islam Terpadu)</option>
                                <option value="SMAIT" {{ ($selected == 'SMAIT' || $selected == 'SMA') ? 'selected' : '' }}>SMA IT ROBBANI (SMA Islam Terpadu)</option>
                            @endif
                        </select>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Masuk di Kelas</label>
                        <select name="masuk_kelas" id="masuk_kelas" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="">-- Kosongkan untuk KB / TPA --</option>
                            <optgroup label="Taman Kanak-kanak (TK)">
                                <option value="TK A" {{ $val('masuk_kelas') == 'TK A' ? 'selected' : '' }}>TK A</option>
                                <option value="TK B" {{ $val('masuk_kelas') == 'TK B' ? 'selected' : '' }}>TK B</option>
                            </optgroup>
                            <optgroup label="Sekolah Dasar (SD)">
                                <option value="Kelas 1" {{ $val('masuk_kelas') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="Kelas 2" {{ $val('masuk_kelas') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="Kelas 3" {{ $val('masuk_kelas') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="Kelas 4" {{ $val('masuk_kelas') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4</option>
                                <option value="Kelas 5" {{ $val('masuk_kelas') == 'Kelas 5' ? 'selected' : '' }}>Kelas 5</option>
                                <option value="Kelas 6" {{ $val('masuk_kelas') == 'Kelas 6' ? 'selected' : '' }}>Kelas 6</option>
                            </optgroup>
                            <optgroup label="Sekolah Menengah Pertama (SMP)">
                                <option value="Kelas 7" {{ $val('masuk_kelas') == 'Kelas 7' ? 'selected' : '' }}>Kelas 7</option>
                                <option value="Kelas 8" {{ $val('masuk_kelas') == 'Kelas 8' ? 'selected' : '' }}>Kelas 8</option>
                                <option value="Kelas 9" {{ $val('masuk_kelas') == 'Kelas 9' ? 'selected' : '' }}>Kelas 9</option>
                            </optgroup>
                            <optgroup label="Sekolah Menengah Atas (SMA)">
                                <option value="Kelas 10" {{ $val('masuk_kelas') == 'Kelas 10' ? 'selected' : '' }}>Kelas 10</option>
                                <option value="Kelas 11" {{ $val('masuk_kelas') == 'Kelas 11' ? 'selected' : '' }}>Kelas 11</option>
                                <option value="Kelas 12" {{ $val('masuk_kelas') == 'Kelas 12' ? 'selected' : '' }}>Kelas 12</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jalur Pendaftaran *</label>
                        <select name="jalur_pendaftaran" id="jalur_pendaftaran" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="REGULER" {{ $val('jalur_pendaftaran', 'REGULER') == 'REGULER' ? 'selected' : '' }}>Jalur Reguler (Umum)</option>
                            <option value="PRESTASI" {{ $val('jalur_pendaftaran') == 'PRESTASI' ? 'selected' : '' }}>Jalur Prestasi (Akademik / Non-Akademik)</option>
                            <option value="TAHFIDZ" {{ $val('jalur_pendaftaran') == 'TAHFIDZ' ? 'selected' : '' }}>Jalur Beasiswa Tahfidz Qur'an</option>
                            <option value="PINDAHAN" {{ $val('jalur_pendaftaran') == 'PINDAHAN' ? 'selected' : '' }}>Jalur Pindahan / Mutasi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Status Masuk Siswa *</label>
                        <select name="status_siswa" id="status_siswa" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Baru" {{ $val('status_siswa', 'Baru') == 'Baru' ? 'selected' : '' }}>Siswa Baru</option>
                            <option value="Pindahan" {{ $val('status_siswa') == 'Pindahan' ? 'selected' : '' }}>Siswa Pindahan</option>
                        </select>
                    </div>
                </div>

                <!-- Fee banner preview (Dinamis dari Pengaturan Admin & Rata Tengah di Mobile) -->
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex flex-col sm:flex-row items-center justify-between text-xs text-center sm:text-left gap-1">
                    <span class="font-bold text-slate-700">Biaya Formulir Pendaftaran Unit Ini:</span>
                    <span id="selectedUnitFeeDisplay" class="font-mono font-black text-emerald-800 text-sm">
                        Rp 450.000
                    </span>
                </div>

                <!-- Nama Lengkap & Panggilan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ananda (Huruf Kapital) *</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ $val('nama_lengkap') }}" required placeholder="NAMA LENGKAP SESUAI AKTA KELAHIRAN" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold uppercase">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ $val('nama_panggilan') }}" placeholder="Nama Panggilan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- NIK & Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. NIK Siswa (16 Digit Angka KK)</label>
                        <input type="text" name="nik_siswa" id="nik_siswa" value="{{ $val('nik_siswa') }}" maxlength="16" placeholder="16 Digit NIK dari Kartu Keluarga" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Laki-laki" {{ $val('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $val('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Tempat, Tanggal Lahir -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ $val('tempat_lahir') }}" required placeholder="Kota / Kabupaten Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ $val('tanggal_lahir') }}" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- Anak ke & Saudara -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">6. Anak ke -</label>
                        <input type="number" name="anak_ke" id="anak_ke" value="{{ $val('anak_ke') }}" min="1" max="20" placeholder="1" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Dari Jml Saudara</label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" value="{{ $val('jumlah_saudara') }}" min="1" max="20" placeholder="3" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jml Saudara Kandung</label>
                        <input type="number" name="jumlah_saudara_kandung" id="jumlah_saudara_kandung" value="{{ $val('jumlah_saudara_kandung') }}" min="0" max="20" placeholder="2" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jml Saudara Tiri</label>
                        <input type="number" name="jumlah_saudara_tiri" id="jumlah_saudara_tiri" value="{{ $val('jumlah_saudara_tiri') }}" min="0" max="20" placeholder="0" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- Agama & Keadaan Jasmani -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">7. Agama</label>
                        <input type="text" name="agama" id="agama" value="{{ $val('agama', 'Islam') }}" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 form-input text-xs font-bold text-slate-500 cursor-not-allowed">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">8. Keadaan Jasmani</label>
                        <select name="keadaan_jasmani" id="keadaan_jasmani" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Sehat" {{ $val('keadaan_jasmani', 'Sehat') == 'Sehat' ? 'selected' : '' }}>Sehat Walafiat</option>
                            <option value="Kurang Sehat" {{ $val('keadaan_jasmani') == 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
                            <option value="Berkebutuhan Khusus" {{ $val('keadaan_jasmani') == 'Berkebutuhan Khusus' ? 'selected' : '' }}>Berkebutuhan Khusus</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">9. Status Tempat Tinggal</label>
                        <select name="status_tempat_tinggal" id="status_tempat_tinggal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Rumah Sendiri" {{ $val('status_tempat_tinggal', 'Rumah Sendiri') == 'Rumah Sendiri' ? 'selected' : '' }}>Rumah Sendiri</option>
                            <option value="Sewa / Kontrak" {{ $val('status_tempat_tinggal') == 'Sewa / Kontrak' ? 'selected' : '' }}>Sewa / Kontrak</option>
                            <option value="Ikut Orang Tua" {{ $val('status_tempat_tinggal') == 'Ikut Orang Tua' ? 'selected' : '' }}>Ikut Orang Tua</option>
                            <option value="Tinggal dikosan" {{ $val('status_tempat_tinggal') == 'Tinggal dikosan' ? 'selected' : '' }}>Tinggal dikosan</option>
                            <option value="Ikut Keluarga/Saudara" {{ $val('status_tempat_tinggal') == 'Ikut Keluarga/Saudara' ? 'selected' : '' }}>Ikut Keluarga / Saudara</option>
                            <option value="Lainnya" {{ $val('status_tempat_tinggal') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">10. Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="WNI" {{ $val('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                            <option value="WNA" {{ $val('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">11. Bahasa Sehari-hari</label>
                        <select name="bahasa_sehari_hari" id="bahasa_sehari_hari" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Indonesia" {{ $val('bahasa_sehari_hari', 'Indonesia') == 'Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="Daerah" {{ $val('bahasa_sehari_hari') == 'Daerah' ? 'selected' : '' }}>Bahasa Daerah</option>
                            <option value="Inggris" {{ $val('bahasa_sehari_hari') == 'Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Arab" {{ $val('bahasa_sehari_hari') == 'Arab' ? 'selected' : '' }}>Bahasa Arab</option>
                            <option value="Mandarin" {{ $val('bahasa_sehari_hari') == 'Mandarin' ? 'selected' : '' }}>Bahasa Mandarin</option>
                            <option value="Lainnya" {{ $val('bahasa_sehari_hari') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol Navigasi Step 1 (Rata Tengah di HP) -->
                <div class="pt-4 flex justify-center sm:justify-end">
                    <button type="button" onclick="validateAndGo(1, 2)" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Lanjut ke Langkah 2</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 2: DATA SEKOLAH ASAL & PRESTASI -->
            <!-- ========================================================================= -->
            <div id="step-section-2" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                        Bagian 2 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <span>🏫</span> DATA SEKOLAH ASAL & PRESTASI
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Bagi pendaftar TPA / KB baru, data sekolah asal boleh dikosongkan.</p>
                </div>

                <!-- 1. Kategori Asal Calon Siswa (Alumni SIT Robbani / Luar) -->
                @php
                    $curKategori = strtoupper((string)$val('kategori_sekolah_asal', ''));
                    if (empty($curKategori)) {
                        $curKategori = in_array(strtoupper($targetLevel ?? ''), ['TPA', 'KB']) ? 'BELUM PERNAH SEKOLAH' : 'ALUMNI SIT ROBBANI';
                    }
                @endphp
                <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-emerald-50/70 via-emerald-50/30 to-slate-50 border border-emerald-200/80 shadow-xs space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                        <div>
                            <label class="text-xs font-black text-emerald-950 uppercase tracking-wide flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                <span>1. Kategori Calon Siswa <span class="text-rose-500">*</span></span>
                            </label>
                            <p class="text-xs text-slate-600 font-medium mt-0.5">
                                Tentukan apakah calon siswa merupakan alumni/lulusan internal SIT Robbani atau pendaftar dari luar:
                            </p>
                        </div>
                        <span class="self-start sm:self-auto text-[10px] font-black uppercase text-emerald-800 bg-white border border-emerald-200 px-2.5 py-0.5 rounded-full shadow-xs">
                            Pilihan Wajib
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                        <!-- Option 1: Alumni SIT Robbani -->
                        <label class="relative flex items-start gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all bg-white hover:border-emerald-500 hover:shadow-xs has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20 group">
                            <input type="radio" name="kategori_sekolah_asal" value="Alumni SIT Robbani" 
                                {{ str_contains($curKategori, 'ALUMNI') ? 'checked' : '' }}
                                onchange="handleKategoriSekolahChange(this.value)"
                                class="mt-0.5 w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-black text-slate-900 group-hover:text-emerald-800 flex items-center gap-1.5">
                                    <span>⭐</span> Alumni SIT Robbani
                                </span>
                                <span class="block text-[11px] text-emerald-700 font-semibold mt-0.5 leading-tight">
                                    Lulusan internal SIT Robbani Ogan Ilir
                                </span>
                            </div>
                        </label>

                        <!-- Option 2: Luar SIT Robbani -->
                        <label class="relative flex items-start gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all bg-white hover:border-emerald-500 hover:shadow-xs has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20 group">
                            <input type="radio" name="kategori_sekolah_asal" value="Luar SIT Robbani" 
                                {{ str_contains($curKategori, 'LUAR') ? 'checked' : '' }}
                                onchange="handleKategoriSekolahChange(this.value)"
                                class="mt-0.5 w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-black text-slate-900 group-hover:text-emerald-800 flex items-center gap-1.5">
                                    <span>🏫</span> Luar SIT Robbani
                                </span>
                                <span class="block text-[11px] text-slate-500 font-medium mt-0.5 leading-tight">
                                    Pendaftar baru dari sekolah luar / umum
                                </span>
                            </div>
                        </label>

                        <!-- Option 3: Belum Pernah Sekolah -->
                        <label class="relative flex items-start gap-3 p-3.5 rounded-xl border-2 cursor-pointer transition-all bg-white hover:border-emerald-500 hover:shadow-xs has-[:checked]:border-emerald-600 has-[:checked]:bg-emerald-50/80 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500/20 group">
                            <input type="radio" name="kategori_sekolah_asal" value="Belum Pernah Sekolah" 
                                {{ str_contains($curKategori, 'BELUM') ? 'checked' : '' }}
                                onchange="handleKategoriSekolahChange(this.value)"
                                class="mt-0.5 w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-slate-300">
                            <div class="min-w-0 flex-1">
                                <span class="block text-xs font-black text-slate-900 group-hover:text-emerald-800 flex items-center gap-1.5">
                                    <span>👶</span> Belum Sekolah
                                </span>
                                <span class="block text-[11px] text-slate-500 font-medium mt-0.5 leading-tight">
                                    Balita / belum sekolah / dari rumah
                                </span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Jenjang Sekolah Asal</label>
                        <select name="jenjang_sekolah_asal" id="jenjang_sekolah_asal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="">-- Pilih Bila Ada --</option>
                            <option value="Belum Sekolah / Dari Rumah" {{ $val('jenjang_sekolah_asal') == 'Belum Sekolah / Dari Rumah' ? 'selected' : '' }}>Belum Sekolah / Dari Rumah</option>
                            <option value="PAUD / Kelompok Bermain" {{ $val('jenjang_sekolah_asal') == 'PAUD / Kelompok Bermain' ? 'selected' : '' }}>PAUD / Kelompok Bermain</option>
                            <option value="TK / RA" {{ $val('jenjang_sekolah_asal') == 'TK / RA' ? 'selected' : '' }}>TK / RA</option>
                            <option value="SD / MI" {{ $val('jenjang_sekolah_asal') == 'SD / MI' ? 'selected' : '' }}>SD / MI</option>
                            <option value="SMP / MTs" {{ $val('jenjang_sekolah_asal') == 'SMP / MTs' ? 'selected' : '' }}>SMP / MTs</option>
                            <option value="Pondok Pesantren" {{ $val('jenjang_sekolah_asal') == 'Pondok Pesantren' ? 'selected' : '' }}>Pondok Pesantren</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. Status Sekolah Asal</label>
                        <select name="status_sekolah_asal" id="status_sekolah_asal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Swasta" {{ $val('status_sekolah_asal', 'Swasta') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            <option value="Negeri" {{ $val('status_sekolah_asal') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. NPSN Sekolah Asal</label>
                        <input type="text" name="npsn_sekolah_asal" id="npsn_sekolah_asal" value="{{ $val('npsn_sekolah_asal') }}" placeholder="8 Digit NPSN (Bila Ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. No. Peserta Ujian / NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ $val('nisn') }}" placeholder="10 Digit NISN (Khusus lulusan SD/SMP)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Nama Sekolah Asal</label>
                    <input type="text" name="sekolah_asal" id="sekolah_asal" value="{{ $val('sekolah_asal') }}" placeholder="Contoh: TKIT Robbani / SDN 01 Indralaya" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    <p class="text-[10px] text-slate-400">*) Diisikan nama sekolah jenjang sebelumnya. Khusus pendaftar baru TPA / KB boleh dikosongkan.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">7. Prestasi Yang Pernah Diraih</label>
                    <textarea name="prestasi" id="prestasi" rows="3" placeholder="Contoh: Juara 1 Tahfidz 1 Juz Tingkat Kabupaten, Juara 2 Lomba Menggambar, dll. (Kosongkan bila belum ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">{{ $val('prestasi') }}</textarea>
                </div>

                <!-- Tombol Navigasi Step 2 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(1)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="validateAndGo(2, 3)" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Lanjut ke Langkah 3</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 3: DATA KESEHATAN & MODA TRANSPORTASI -->
            <!-- ========================================================================= -->
            <div id="step-section-3" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                        Bagian 3 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <span>🩺</span> DATA KESEHATAN & MODA TRANSPORTASI
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Informasi fisik, rekam medis penunjang, dan jarak ke sekolah.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" value="{{ $val('tinggi_badan') }}" placeholder="Contoh: 110" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="berat_badan" value="{{ $val('berat_badan') }}" placeholder="Contoh: 20" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Belum Tahu" {{ $val('golongan_darah') == 'Belum Tahu' ? 'selected' : '' }}>Belum Tahu</option>
                            <option value="A" {{ $val('golongan_darah') == 'A' ? 'selected' : '' }}>Golongan A</option>
                            <option value="B" {{ $val('golongan_darah') == 'B' ? 'selected' : '' }}>Golongan B</option>
                            <option value="AB" {{ $val('golongan_darah') == 'AB' ? 'selected' : '' }}>Golongan AB</option>
                            <option value="O" {{ $val('golongan_darah') == 'O' ? 'selected' : '' }}>Golongan O</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Penyakit yang Pernah Diderita</label>
                        <input type="text" name="penyakit_pernah" id="penyakit_pernah" value="{{ $val('penyakit_pernah') }}" placeholder="Contoh: Asma, Tifus, DBD (Kosongkan bila tidak ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Penyakit yang Sedang Diderita</label>
                        <input type="text" name="penyakit_sedang" id="penyakit_sedang" value="{{ $val('penyakit_sedang') }}" placeholder="Tuliskan jika sedang dalam terapi atau rutin obat" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Kelainan Fisik / Kebutuhan Khusus</label>
                    <input type="text" name="kelainan_fisik" id="kelainan_fisik" value="{{ $val('kelainan_fisik') }}" placeholder="Tuliskan bila ada kebutuhan khusus / 'Tidak Ada'" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                </div>

                <!-- Moda Transportasi -->
                <div class="border-t border-slate-200 pt-4">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wide mb-3">Moda Transportasi Peserta Didik:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Jarak Tempat Tinggal ke Sekolah</label>
                            <select name="jarak_ke_sekolah" id="jarak_ke_sekolah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Kurang dari 1 km" {{ $val('jarak_ke_sekolah') == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                <option value="1 - 3 km" {{ $val('jarak_ke_sekolah') == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                <option value="3 - 5 km" {{ $val('jarak_ke_sekolah') == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                <option value="5 - 10 km" {{ $val('jarak_ke_sekolah') == '5 - 10 km' ? 'selected' : '' }}>5 - 10 km</option>
                                <option value="Lebih dari 10 km" {{ $val('jarak_ke_sekolah') == 'Lebih dari 10 km' ? 'selected' : '' }}>Lebih dari 10 km</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. Transportasi yang Digunakan</label>
                            <select name="transportasi" id="transportasi" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Sepeda Motor / Diantar Ortu" {{ $val('transportasi') == 'Sepeda Motor / Diantar Ortu' ? 'selected' : '' }}>Sepeda Motor / Diantar Ortu</option>
                                <option value="Mobil Pribadi" {{ $val('transportasi') == 'Mobil Pribadi' ? 'selected' : '' }}>Mobil Pribadi</option>
                                <option value="Jalan Kaki" {{ $val('transportasi') == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                <option value="Antar Jemput Sekolah" {{ $val('transportasi') == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                <option value="Angkutan Umum" {{ $val('transportasi') == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                <option value="Lainnya" {{ $val('transportasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Step 3 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(2)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="validateAndGo(3, 4)" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Lanjut ke Langkah 4</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 4: ALAMAT DOMISILI & DATA ORANG TUA (AYAH & IBU KANDUNG) -->
            <!-- ========================================================================= -->
            <div id="step-section-4" class="step-section space-y-6 hidden">
                <div class="border-b border-slate-200 pb-3 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                        Bagian 4 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <span>🏡</span> ALAMAT TEMPAT TINGGAL & DATA ORANG TUA KANDUNG
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Data ayah & ibu kandung wajib diisi untuk verifikasi panitia SPMB.</p>
                </div>

                <!-- ALAMAT DOMISILI LENGKAP -->
                <div class="space-y-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wide">Alamat Tempat Tinggal Anak:</h4>
                    
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Alamat Jalan / No. Rumah / Gang *</label>
                        <input type="text" name="alamat" id="alamat" value="{{ $val('alamat') }}" required placeholder="Contoh: Jl. Sarjana Komplek Griya Sejahtera Blok A4 No. 5" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Dusun / RT-RW</label>
                            <input type="text" name="dusun" id="dusun" value="{{ $val('dusun') }}" placeholder="RT 02 / RW 01" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Desa / Kelurahan</label>
                            <input type="text" name="kelurahan" id="kelurahan" value="{{ $val('kelurahan') }}" placeholder="Contoh: Timbangan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" value="{{ $val('kecamatan') }}" placeholder="Contoh: Indralaya Utara" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten" id="kabupaten" value="{{ $val('kabupaten', 'Ogan Ilir') }}" placeholder="Contoh: Ogan Ilir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" value="{{ $val('provinsi', 'Sumatera Selatan') }}" placeholder="Contoh: Sumatera Selatan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" value="{{ $val('kode_pos') }}" placeholder="Contoh: 30662" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                    </div>
                </div>

                <!-- DATA AYAH KANDUNG -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-emerald-700 text-white flex items-center justify-center text-xs font-black">A</span>
                        <h4 class="text-xs font-black text-slate-900 uppercase">Data Ayah Kandung</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ayah *</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" value="{{ $val('nama_ayah') }}" required placeholder="Nama Lengkap Beserta Gelar" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. NIK Ayah (16 Digit KK)</label>
                            <input type="text" name="nik_ayah" id="nik_ayah" value="{{ $val('nik_ayah') }}" maxlength="16" placeholder="16 Digit NIK Ayah" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. Tempat Lahir Ayah</label>
                            <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" value="{{ $val('tempat_lahir_ayah') }}" placeholder="Kota / Kab Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" value="{{ $val('tanggal_lahir_ayah') }}" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pendidikan Terakhir</label>
                            <select name="pendidikan_ayah" id="pendidikan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S1" {{ $val('pendidikan_ayah', 'S1') == 'S1' ? 'selected' : '' }}>S1 / Sarjana</option>
                                <option value="S2/S3" {{ $val('pendidikan_ayah') == 'S2/S3' ? 'selected' : '' }}>S2 / S3 (Pascasarjana)</option>
                                <option value="D3/D4" {{ $val('pendidikan_ayah') == 'D3/D4' ? 'selected' : '' }}>D3 / D4 (Diploma)</option>
                                <option value="SMA/SMK" {{ $val('pendidikan_ayah') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                                <option value="SMP" {{ $val('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>SMP Sederajat</option>
                                <option value="SD" {{ $val('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD Sederajat</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ $val('pekerjaan_ayah') }}" placeholder="PNS/TNI/Karyawan/Wiraswasta" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">7. Nama Instansi / Perusahaan</label>
                            <input type="text" name="instansi_ayah" id="instansi_ayah" value="{{ $val('instansi_ayah') }}" placeholder="Nama Kantor / Usaha" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. Jabatan</label>
                            <input type="text" name="jabatan_ayah" id="jabatan_ayah" value="{{ $val('jabatan_ayah') }}" placeholder="Staff / Manager / Pemilik" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. No. HP / WhatsApp Ayah *</label>
                            <input type="text" name="no_hp_ayah" id="no_hp_ayah" value="{{ $val('no_hp_ayah') }}" required placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">10. Penghasilan Bulanan</label>
                            <select name="penghasilan_ayah" id="penghasilan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="< Rp 1.000.000" {{ $val('penghasilan_ayah') == '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ $val('penghasilan_ayah') == 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ $val('penghasilan_ayah', 'Rp 3.000.000 - Rp 5.000.000') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ $val('penghasilan_ayah') == 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ $val('penghasilan_ayah') == '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATA IBU KANDUNG -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                        <span class="w-6 h-6 rounded-lg bg-pink-700 text-white flex items-center justify-center text-xs font-black">B</span>
                        <h4 class="text-xs font-black text-slate-900 uppercase">Data Ibu Kandung</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ibu *</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" value="{{ $val('nama_ibu') }}" required placeholder="Nama Lengkap Beserta Gelar" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. NIK Ibu (16 Digit KK)</label>
                            <input type="text" name="nik_ibu" id="nik_ibu" value="{{ $val('nik_ibu') }}" maxlength="16" placeholder="16 Digit NIK Ibu" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. Tempat Lahir Ibu</label>
                            <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" value="{{ $val('tempat_lahir_ibu') }}" placeholder="Kota / Kab Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" value="{{ $val('tanggal_lahir_ibu') }}" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pendidikan Terakhir</label>
                            <select name="pendidikan_ibu" id="pendidikan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S1" {{ $val('pendidikan_ibu', 'S1') == 'S1' ? 'selected' : '' }}>S1 / Sarjana</option>
                                <option value="S2/S3" {{ $val('pendidikan_ibu') == 'S2/S3' ? 'selected' : '' }}>S2 / S3 (Pascasarjana)</option>
                                <option value="D3/D4" {{ $val('pendidikan_ibu') == 'D3/D4' ? 'selected' : '' }}>D3 / D4 (Diploma)</option>
                                <option value="SMA/SMK" {{ $val('pendidikan_ibu') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                                <option value="SMP" {{ $val('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP Sederajat</option>
                                <option value="SD" {{ $val('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD Sederajat</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ $val('pekerjaan_ibu') }}" placeholder="Ibu Rumah Tangga / PNS / Guru / Swasta" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">7. Nama Instansi / Perusahaan</label>
                            <input type="text" name="instansi_ibu" id="instansi_ibu" value="{{ $val('instansi_ibu') }}" placeholder="Nama Kantor / Usaha" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. Jabatan</label>
                            <input type="text" name="jabatan_ibu" id="jabatan_ibu" value="{{ $val('jabatan_ibu') }}" placeholder="Staff / Guru / Pemilik" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. No. HP / WhatsApp Ibu</label>
                            <input type="text" name="no_hp_ibu" id="no_hp_ibu" value="{{ $val('no_hp_ibu') }}" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">10. Penghasilan Bulanan</label>
                            <select name="penghasilan_ibu" id="penghasilan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Tidak Berpenghasilan" {{ $val('penghasilan_ibu') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan / IRT</option>
                                <option value="< Rp 1.000.000" {{ $val('penghasilan_ibu') == '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ $val('penghasilan_ibu') == 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ $val('penghasilan_ibu') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ $val('penghasilan_ibu') == 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ $val('penghasilan_ibu') == '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATA WALI (OPSIONAL) -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-700 block uppercase">Data Wali (Opsional, Bila Tidak Tinggal Bersama Orang Tua Kandung):</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" name="nama_wali" id="nama_wali" value="{{ $val('nama_wali') }}" placeholder="Nama Lengkap Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="hubungan_wali" id="hubungan_wali" value="{{ $val('hubungan_wali') }}" placeholder="Hubungan (Kakek/Paman/Bibi)" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="no_hp_wali" id="no_hp_wali" value="{{ $val('no_hp_wali') }}" placeholder="No. HP Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>
                </div>

                <!-- Tombol Navigasi Step 4 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(3)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="validateAndGo(4, 5)" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>Lanjut ke Upload Berkas</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 5: INFORMASI PENDAFTARAN & UPLOAD BERKAS (FINAL) -->
            <!-- ========================================================================= -->
            <div id="step-section-5" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 inline-block">
                        Bagian 5 dari 5 (Final)
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center justify-center sm:justify-start gap-2">
                        <span>📑</span> INFORMASI PENDAFTARAN & UPLOAD DOKUMEN
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Unggah berkas persyaratan dan konfirmasi pembayaran pendaftaran.</p>
                </div>

                <!-- Informasi Sumber Pendaftaran (Sesuai Scan Form F-SPMB) -->
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 uppercase">Informasi Pendaftaran Diperoleh Dari Mana?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Brosur" {{ $val('info_pendaftaran') == 'Brosur' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Brosur</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Banner / Spanduk" {{ $val('info_pendaftaran') == 'Banner / Spanduk' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Banner / Spanduk</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Media Sosial" {{ $val('info_pendaftaran', 'Media Sosial') == 'Media Sosial' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Media Sosial (IG/FB)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Teman / Saudara" {{ $val('info_pendaftaran') == 'Teman / Saudara' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Teman / Saudara</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Guru / Tendik SIT Robbani" {{ $val('info_pendaftaran') == 'Guru / Tendik SIT Robbani' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Guru / Tendik Robbani</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Lainnya" {{ $val('info_pendaftaran') == 'Lainnya' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Lainnya</span>
                        </label>
                    </div>
                </div>

                <!-- Info Rekening Pembayaran Resmi (Dinamis dari Pengaturan Admin & Rata Tengah di HP) -->
                <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2 text-center sm:text-left">
                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-400 block text-center sm:text-left">
                        💳 Rekening Resmi Pembayaran Biaya Pendaftaran Formulir:
                    </span>
                    <div class="font-mono text-xs space-y-1.5">
                        <div class="p-2.5 rounded-xl bg-slate-800 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left gap-1">
                            <div>
                                <span class="text-emerald-400 font-bold block">{{ $spmb['bank1_name'] ?? 'BANK SYARIAH INDONESIA (BSI)' }}</span>
                                <span class="font-mono font-bold text-amber-300 text-sm">{{ $spmb['bank1_number'] ?? '7206858502' }}</span>
                            </div>
                            <span class="text-[10px] text-slate-300 font-sans">a.n. {{ $spmb['bank1_holder'] ?? 'YAYASAN GENERASI ROBBANI' }}</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-800 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left gap-1">
                            <div>
                                <span class="text-emerald-400 font-bold block">{{ $spmb['bank2_name'] ?? 'BANK MUAMALAT' }}</span>
                                <span class="font-mono font-bold text-amber-300 text-sm">{{ $spmb['bank2_number'] ?? '3610061740' }}</span>
                            </div>
                            <span class="text-[10px] text-slate-300 font-sans">a.n. {{ $spmb['bank2_holder'] ?? 'YAYASAN GENERASI ROBBANI SUMATERA SELATAN' }}</span>
                        </div>
                    </div>
                </div>

                <!-- File Upload Cards -->
                <div class="space-y-3">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wide">Unggah Berkas Pendukung (JPG, PNG, atau PDF):</h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- Pas Foto -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">1. Pas Foto Calon Siswa (Terbaru)</label>
                            <input type="file" name="pas_foto" accept="image/png,image/jpeg,image/webp" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            @if(!empty($editData['uploaded_docs']['pas_foto']))
                                <p class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md inline-block mt-1">✓ File tersimpan sebelumnya. Unggah hanya jika ingin mengganti.</p>
                            @endif
                            <p class="text-[10px] text-slate-400">Format foto 3x4 atau setara.</p>
                        </div>

                        <!-- Akta Kelahiran Calon Siswa -->
                        <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-300 space-y-1.5">
                            <label class="block text-xs font-black text-emerald-950 flex items-center justify-between">
                                <span>2. Akta Kelahiran Calon Siswa *</span>
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-200/80 px-2 py-0.5 rounded-full">WAJIB</span>
                            </label>
                            <input type="file" name="akta_kelahiran" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-800 file:text-white hover:file:bg-emerald-900 cursor-pointer">
                            @if(!empty($editData['uploaded_docs']['akta_kelahiran']))
                                <p class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md inline-block mt-1">✓ File tersimpan sebelumnya. Unggah hanya jika ingin mengganti.</p>
                            @endif
                            <p class="text-[10px] text-emerald-800 font-medium">Foto / Scan Asli Akta Kelahiran calon siswa.</p>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">3. Kartu Keluarga (KK)</label>
                            <input type="file" name="kartu_keluarga" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            @if(!empty($editData['uploaded_docs']['kartu_keluarga']))
                                <p class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md inline-block mt-1">✓ File tersimpan sebelumnya. Unggah hanya jika ingin mengganti.</p>
                            @endif
                            <p class="text-[10px] text-slate-400">Scan / Foto Kartu Keluarga jelas.</p>
                        </div>

                        <!-- KTP Orang Tua -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">4. KTP Orang Tua (Ayah / Ibu)</label>
                            <input type="file" name="ktp_ortu" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            @if(!empty($editData['uploaded_docs']['ktp_ortu']))
                                <p class="text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 rounded-md inline-block mt-1">✓ File tersimpan sebelumnya. Unggah hanya jika ingin mengganti.</p>
                            @endif
                            <p class="text-[10px] text-slate-400">Foto KTP Ayah / Ibu.</p>
                        </div>
                    </div>

                    <!-- Bukti Transfer -->
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1.5">
                        <label class="block text-xs font-black text-amber-950 uppercase">5. Bukti Transfer Biaya Formulir Pendaftaran</label>
                        <input type="file" name="bukti_transfer" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-amber-600 file:text-white hover:file:bg-amber-700 cursor-pointer">
                        @if(!empty($editData['uploaded_docs']['bukti_transfer']))
                            <p class="text-[10px] font-bold text-amber-900 bg-amber-100/80 px-2 py-0.5 rounded-md inline-block mt-1">✓ Bukti transfer tersimpan sebelumnya. Unggah hanya jika ingin mengganti.</p>
                        @endif
                        <p class="text-[11px] text-amber-800">Unggah bukti transfer dari ATM / Mobile Banking untuk mempercepat verifikasi otomatis.</p>
                    </div>
                </div>

                <!-- Pernyataan Keabsahan Data -->
                <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-xs text-slate-700 space-y-2">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" required {{ !empty($editRegistration) ? "checked" : "" }} class="mt-0.5 rounded text-emerald-700 focus:ring-emerald-500">
                        <span class="text-[11px] leading-relaxed">
                            Dengan ini saya menyatakan bahwa data yang saya isikan pada formulir pendaftaran SPMB SIT Robbani Ogan Ilir ini adalah benar, sah, dan dapat dipertanggungjawabkan.
                        </span>
                    </label>
                </div>

                <!-- Navigation & Submit (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="goToStep(4)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-700/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        @if(!empty($editRegistration))
                            <span>💾 Simpan Perbaikan Data Formulir</span>
                        @else
                            <span>✓ Kirim Formulir Pendaftaran</span>
                        @endif
                    </button>
                </div>
            </div>

        </form>
        @endif
    </main>

    <!-- Footer Simple (Rata Tengah) -->
    <footer class="py-6 border-t border-slate-200 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Yayasan Generasi Robbani Sumatera Selatan. SPMB Online System.</p>
    </footer>

    @if(!session('spmb_success_data'))
    <!-- Form Wizard Logic (Dinamis dari CMS Admin & Interaktif Tanpa Macet) -->
    <script>
        @php
            $feeMap = [];
            if (!empty($spmb['units'])) {
                foreach ($spmb['units'] as $code => $u) {
                    $feeVal = isset($u['fee']) ? 'Rp ' . number_format($u['fee'], 0, ',', '.') : 'Rp 450.000';
                    $feeMap[$code] = $feeVal;
                    if ($code === 'TKIT') $feeMap['TK'] = $feeVal;
                    if ($code === 'SDIT') $feeMap['SD'] = $feeVal;
                    if ($code === 'SMPIT') $feeMap['SMP'] = $feeVal;
                    if ($code === 'SMAIT') $feeMap['SMA'] = $feeVal;
                }
            }
        @endphp

        const feesBySchool = {!! json_encode($feeMap ?: [
            'TPA' => 'Rp 350.000',
            'KB' => 'Rp 350.000',
            'TK' => 'Rp 350.000',
            'TKIT' => 'Rp 350.000',
            'SD' => 'Rp 450.000',
            'SDIT' => 'Rp 450.000',
            'SMP' => 'Rp 550.000',
            'SMPIT' => 'Rp 550.000',
            'SMA' => 'Rp 550.000',
            'SMAIT' => 'Rp 550.000',
        ]) !!};

        let currentStep = {{ $initialStep ?? 1 }};

        function updateUnitFeeInfo() {
            const sc = document.getElementById('school_code');
            const feeDisplay = document.getElementById('selectedUnitFeeDisplay');
            if (sc && feeDisplay) {
                const val = sc.value.toUpperCase();
                feeDisplay.innerText = feesBySchool[val] || 'Rp 450.000';
            }
        }

        const classesByUnit = {
            'TPA': [],
            'KB': [],
            'TK': ['TK A', 'TK B'],
            'TKIT': ['TK A', 'TK B'],
            'SD': ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'],
            'SDIT': ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6'],
            'SMP': ['Kelas 7', 'Kelas 8', 'Kelas 9'],
            'SMPIT': ['Kelas 7', 'Kelas 8', 'Kelas 9'],
            'SMA': ['Kelas 10', 'Kelas 11', 'Kelas 12'],
            'SMAIT': ['Kelas 10', 'Kelas 11', 'Kelas 12']
        };

        function updateClassOptions(preferredVal) {
            const sc = document.getElementById('school_code');
            const mk = document.getElementById('masuk_kelas');
            if (!sc || !mk) return;

            const unit = sc.value.toUpperCase();
            const currentVal = (preferredVal !== undefined && preferredVal !== null && preferredVal !== '') 
                ? preferredVal 
                : mk.value;

            if (unit === 'TPA' || unit === 'KB') {
                mk.innerHTML = '<option value="">-- Dikosongkan (KB / TPA Tidak Ada Kelas) --</option>';
                mk.value = '';
                mk.classList.add('bg-slate-100', 'text-slate-500');
                return;
            }

            mk.classList.remove('bg-slate-100', 'text-slate-500');

            const validClasses = classesByUnit[unit];
            if (validClasses && validClasses.length > 0) {
                let html = '<option value="">-- Pilih Kelas --</option>';
                validClasses.forEach(cls => {
                    const sel = (currentVal === cls) ? 'selected' : '';
                    html += `<option value="${cls}" ${sel}>${cls}</option>`;
                });
                mk.innerHTML = html;

                if (validClasses.includes(currentVal)) {
                    mk.value = currentVal;
                } else if (!currentVal) {
                    mk.value = validClasses[0];
                }
            } else {
                mk.innerHTML = `
                    <option value="">-- Pilih Kelas (Kosongkan bila KB / TPA) --</option>
                    <optgroup label="Taman Kanak-kanak (TK)">
                        <option value="TK A">TK A</option>
                        <option value="TK B">TK B</option>
                    </optgroup>
                    <optgroup label="Sekolah Dasar (SD)">
                        <option value="Kelas 1">Kelas 1</option>
                        <option value="Kelas 2">Kelas 2</option>
                        <option value="Kelas 3">Kelas 3</option>
                        <option value="Kelas 4">Kelas 4</option>
                        <option value="Kelas 5">Kelas 5</option>
                        <option value="Kelas 6">Kelas 6</option>
                    </optgroup>
                    <optgroup label="Sekolah Menengah Pertama (SMP)">
                        <option value="Kelas 7">Kelas 7</option>
                        <option value="Kelas 8">Kelas 8</option>
                        <option value="Kelas 9">Kelas 9</option>
                    </optgroup>
                    <optgroup label="Sekolah Menengah Atas (SMA)">
                        <option value="Kelas 10">Kelas 10</option>
                        <option value="Kelas 11">Kelas 11</option>
                        <option value="Kelas 12">Kelas 12</option>
                    </optgroup>
                `;
                if (currentVal) mk.value = currentVal;
            }
        }

        function onSchoolCodeChange() {
            updateUnitFeeInfo();
            updateClassOptions();
            const checkedKategori = document.querySelector('input[name="kategori_sekolah_asal"]:checked');
            if (checkedKategori && checkedKategori.value === 'Alumni SIT Robbani') {
                handleKategoriSekolahChange('Alumni SIT Robbani');
            }
        }

        function handleKategoriSekolahChange(val) {
            const sc = document.getElementById('school_code');
            const unit = sc ? sc.value.toUpperCase() : '';
            const jenjang = document.getElementById('jenjang_sekolah_asal');
            const statusSekolah = document.getElementById('status_sekolah_asal');
            const namaSekolah = document.getElementById('sekolah_asal');

            if (val === 'Alumni SIT Robbani') {
                if (statusSekolah) statusSekolah.value = 'Swasta';
                
                let defaultNama = 'SIT ROBBANI OGAN ILIR';
                let defaultJenjang = '';

                if (unit === 'SD' || unit === 'SDIT') {
                    defaultNama = 'TKIT ROBBANI OGAN ILIR';
                    defaultJenjang = 'TK / RA';
                } else if (unit === 'SMP' || unit === 'SMPIT') {
                    defaultNama = 'SDIT ROBBANI OGAN ILIR';
                    defaultJenjang = 'SD / MI';
                } else if (unit === 'SMA' || unit === 'SMAIT') {
                    defaultNama = 'SMPIT ROBBANI OGAN ILIR';
                    defaultJenjang = 'SMP / MTs';
                } else if (unit === 'TK' || unit === 'TKIT') {
                    defaultNama = 'KB ROBBANI OGAN ILIR';
                    defaultJenjang = 'PAUD / Kelompok Bermain';
                } else if (unit === 'KB') {
                    defaultNama = 'TPA ROBBANI OGAN ILIR';
                    defaultJenjang = 'PAUD / Kelompok Bermain';
                }

                if (namaSekolah && (!namaSekolah.value || namaSekolah.value === '-' || namaSekolah.value.includes('ROBBANI') || namaSekolah.value.includes('Belum Sekolah'))) {
                    namaSekolah.value = defaultNama;
                }
                if (jenjang && defaultJenjang && (!jenjang.value || jenjang.value === 'Belum Sekolah / Dari Rumah')) {
                    jenjang.value = defaultJenjang;
                }
            } else if (val === 'Belum Pernah Sekolah') {
                if (jenjang) jenjang.value = 'Belum Sekolah / Dari Rumah';
                if (namaSekolah && (namaSekolah.value.includes('ROBBANI') || !namaSekolah.value)) {
                    namaSekolah.value = '-';
                }
            } else if (val === 'Luar SIT Robbani') {
                if (namaSekolah && (namaSekolah.value.includes('ROBBANI') || namaSekolah.value === '-')) {
                    namaSekolah.value = '';
                }
            }
        }

        function clearStepErrors(step) {
            const section = document.getElementById(`step-section-${step}`);
            if (!section) return;
            section.querySelectorAll('.spmb-field-error').forEach(el => el.remove());
            section.querySelectorAll('.border-rose-500').forEach(el => {
                el.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-200');
            });
            const alertBox = document.getElementById(`step-alert-${step}`);
            if (alertBox) alertBox.remove();
        }

        function validateStep(step) {
            clearStepErrors(step);
            const section = document.getElementById(`step-section-${step}`);
            if (!section) return true;

            const requiredFields = section.querySelectorAll('input[required], select[required], textarea[required]');
            let firstInvalid = null;

            for (let el of requiredFields) {
                let isInvalid = false;
                if (el.type === 'checkbox') {
                    if (!el.checked) isInvalid = true;
                } else if (!el.value || el.value.trim() === '') {
                    isInvalid = true;
                }

                if (isInvalid) {
                    if (!firstInvalid) firstInvalid = el;

                    el.classList.add('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-200');

                    // Add inline error badge
                    const parent = el.closest('.space-y-1') || el.parentElement;
                    if (parent && !parent.querySelector('.spmb-field-error')) {
                        const err = document.createElement('span');
                        err.className = 'spmb-field-error text-[10px] font-bold text-rose-600 flex items-center gap-1 mt-1';
                        err.innerHTML = '<span>⚠️</span><span>Kolom ini wajib diisi</span>';
                        parent.appendChild(err);
                    }

                    // Auto clear error when input changes
                    const clearInputError = () => {
                        el.classList.remove('border-rose-500', 'bg-rose-50/40', 'ring-2', 'ring-rose-200');
                        const errBadge = parent ? parent.querySelector('.spmb-field-error') : null;
                        if (errBadge) errBadge.remove();
                        const topAlert = document.getElementById(`step-alert-${step}`);
                        if (topAlert && !section.querySelector('.border-rose-500')) {
                            topAlert.remove();
                        }
                    };
                    el.addEventListener('input', clearInputError, { once: true });
                    el.addEventListener('change', clearInputError, { once: true });
                }
            }

            if (firstInvalid) {
                // Show notification banner at top of section
                if (!document.getElementById(`step-alert-${step}`)) {
                    const alertDiv = document.createElement('div');
                    alertDiv.id = `step-alert-${step}`;
                    alertDiv.className = 'p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2.5 shadow-sm';
                    alertDiv.innerHTML = '<span class="text-base shrink-0">⚠️</span><span class="font-bold">Mohon lengkapi kolom bertanda bintang (*) yang berwarna merah sebelum melanjutkan.</span>';
                    const targetInsert = section.querySelector('div:first-child');
                    if (targetInsert && targetInsert.nextSibling) {
                        section.insertBefore(alertDiv, targetInsert.nextSibling);
                    } else {
                        section.prepend(alertDiv);
                    }
                }

                // Smooth scroll directly to the first invalid element
                const rect = firstInvalid.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const targetY = rect.top + scrollTop - 130;
                window.scrollTo({ top: Math.max(0, targetY), behavior: 'smooth' });

                setTimeout(() => {
                    try { firstInvalid.focus({ preventScroll: true }); } catch (e) { firstInvalid.focus(); }
                }, 300);

                return false;
            }

            return true;
        }

        function validateAndGo(fromStep, toStep) {
            // Allow going backward freely without validation
            if (toStep <= fromStep) {
                goToStep(toStep);
                return true;
            }

            // Going forward: validate step-by-step
            for (let s = fromStep; s < toStep; s++) {
                if (!validateStep(s)) {
                    goToStep(s);
                    return false;
                }
            }
            goToStep(toStep);
            return true;
        }

        function goToStep(step) {
            currentStep = step;
            const stepTitles = [
                '',
                'Identitas Calon Siswa',
                'Sekolah Asal & Prestasi',
                'Kesehatan & Transportasi',
                'Domisili & Data Orang Tua',
                'Upload Berkas & Konfirmasi'
            ];

            // 1. Update Form Sections & Desktop Tabs
            for (let i = 1; i <= 5; i++) {
                const section = document.getElementById(`step-section-${i}`);
                const pill = document.getElementById(`pill-step-${i}`);
                if (section) {
                    if (i === step) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                }
                if (pill) {
                    const numBadge = pill.querySelector('span:first-child');
                    if (i === step) {
                        pill.className = "py-2.5 px-3 rounded-xl text-center transition-all step-pill-active text-xs flex items-center justify-center gap-1.5 shadow-sm";
                        if (numBadge) numBadge.className = "w-5 h-5 rounded-full bg-white/20 text-white flex items-center justify-center text-[10px] font-black shrink-0";
                    } else if (i < step) {
                        pill.className = "py-2.5 px-3 rounded-xl text-center transition-all bg-emerald-50 text-emerald-900 border border-emerald-200 text-xs flex items-center justify-center gap-1.5";
                        if (numBadge) numBadge.className = "w-5 h-5 rounded-full bg-emerald-700 text-white flex items-center justify-center text-[10px] font-black shrink-0";
                    } else {
                        pill.className = "py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5";
                        if (numBadge) numBadge.className = "w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0";
                    }
                }
            }

            // 2. Update Mobile Stepper (Text, Percentage, Progress Bar, & Quick Step Badges)
            const mTitle = document.getElementById('mobileStepTitle');
            const mNum = document.getElementById('mobileStepNum');
            const mBadge = document.getElementById('mobileStepBadge');
            const mPct = document.getElementById('mobileProgressPercent');
            const mBar = document.getElementById('mobileProgressBar');

            if (mTitle) mTitle.innerText = stepTitles[step] || '';
            if (mNum) mNum.innerText = step;
            if (mBadge) mBadge.innerText = step;
            if (mPct) mPct.innerText = `${step * 20}%`;
            if (mBar) mBar.style.width = `${step * 20}%`;

            for (let j = 1; j <= 5; j++) {
                const mBtn = document.getElementById(`m-step-${j}`);
                if (mBtn) {
                    if (j === step) {
                        mBtn.className = "py-1 rounded-md text-[10px] font-black transition-all bg-emerald-700 text-white shadow-xs text-center";
                    } else if (j < step) {
                        mBtn.className = "py-1 rounded-md text-[10px] font-bold transition-all bg-emerald-100 text-emerald-800 text-center";
                    } else {
                        mBtn.className = "py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center";
                    }
                }
            }

            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateUnitFeeInfo();
            updateClassOptions(@json($val('masuk_kelas')));
            goToStep(currentStep);

            const checkedKategori = document.querySelector('input[name="kategori_sekolah_asal"]:checked');
            const namaSekolahEl = document.getElementById('sekolah_asal');
            if (checkedKategori && checkedKategori.value === 'Alumni SIT Robbani' && (!namaSekolahEl || !namaSekolahEl.value)) {
                handleKategoriSekolahChange('Alumni SIT Robbani');
            }

            const form = document.getElementById('spmbForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    for (let s = 1; s <= 5; s++) {
                        if (!validateStep(s)) {
                            e.preventDefault();
                            goToStep(s);
                            return false;
                        }
                    }
                    const btn = document.getElementById('submitBtn');
                    if (btn) {
                        btn.disabled = true;
                        btn.innerHTML = '<span>⏳ Memproses Pendaftaran...</span>';
                    }
                });
            }
        });
    </script>
    @endif

    {{-- FLOATING WIDGETS --}}
    @include('components.floating-translate')
    @include('components.chat-ai-widget')
</body>
</html>
