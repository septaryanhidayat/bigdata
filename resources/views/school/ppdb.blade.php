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
    <meta property="og:title" content="Formulir SPMB / PPDB Online 2026/2027 | SIT Robbani">
    <meta property="og:description" content="Penerimaan Peserta Didik Baru (PPDB / SPMB) SIT Robbani Ogan Ilir Jenjang TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT T.A 2026/2027.">
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
    <header class="py-2.5 sm:py-3 px-4 sm:px-8 sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            <!-- Brand Logo -->
            <a href="{{ route('school.spmb') }}" class="flex items-center gap-2.5 shrink-0">
                <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 sm:h-10 w-auto object-contain">
                <span class="font-black text-sm sm:text-base tracking-tight text-emerald-950 uppercase">{{ $spmb['brand_title'] ?? 'SPMB ROBBANI' }}</span>
            </a>

            <!-- Right Controls -->
            <div class="flex items-center gap-2">
                <a href="{{ route('school.spmb') }}" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors flex items-center gap-1.5 shrink-0 whitespace-nowrap">
                    <span>← Beranda</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="py-6 sm:py-10 max-w-4xl mx-auto px-3 sm:px-4 w-full space-y-6 flex-1">
        
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

        <!-- Success Notification Banner -->
        @if(session('spmb_success_data'))
        @php 
            $data = session('spmb_success_data'); 
            $verifyUrl = route('school.spmb.verify', $data['registration_number']);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($verifyUrl);
            $cleanWa = preg_replace('/[^0-9]/', '', $spmb['wa_number'] ?? '62811747472');
        @endphp
        <div class="p-5 sm:p-8 rounded-3xl bg-emerald-800 text-white shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-emerald-700 pb-3">
                <span class="px-3 py-1 rounded-full bg-emerald-700 text-emerald-100 font-black text-[10px] sm:text-xs uppercase">
                    ✓ Pendaftaran SPMB Berhasil
                </span>
                <span class="text-xs text-emerald-200 font-medium">{{ $data['date'] }}</span>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-5 text-center sm:text-left">
                <div class="space-y-1.5 text-center sm:text-left">
                    <h3 class="text-lg sm:text-xl font-black text-white">Alhamdulillah, Pendaftaran Ananda {{ $data['student_name'] }} Berhasil Diterima!</h3>
                    <p class="text-xs text-emerald-200">Nomor Registrasi SPMB Resmi Ananda:</p>
                    <div class="pt-1">
                        <span class="px-4 py-2 rounded-2xl bg-slate-950 font-mono text-xl sm:text-2xl font-black text-amber-300 inline-block border border-amber-400/40 shadow-inner">
                            {{ $data['registration_number'] }}
                        </span>
                    </div>
                    <p class="text-[11px] text-emerald-200/90 pt-1">
                        Jenjang Target: <strong>{{ $data['target_level'] }}</strong> | Kontak HP: <strong>{{ $data['parent_phone'] }}</strong>
                    </p>
                </div>

                <!-- QR Code Box -->
                <div class="p-3 rounded-2xl bg-white text-center shadow-md shrink-0 mx-auto sm:mx-0">
                    <img src="{{ $qrUrl }}" alt="QR Code Pendaftaran" class="w-24 h-24 sm:w-28 sm:h-28 mx-auto rounded-lg">
                    <a href="{{ $verifyUrl }}" target="_blank" class="text-[10px] font-bold text-emerald-800 hover:underline block mt-1">
                        Verifikasi Digital ↗
                    </a>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-3 border-t border-emerald-700 flex flex-col sm:flex-row gap-2.5">
                <a href="{{ route('school.spmb.download-pdf', $data['registration_id']) }}" target="_blank" class="w-full py-3 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs text-center flex items-center justify-center gap-2 shadow-md transition-all">
                    <span>🖨️</span> Unduh & Cetak Formulir PDF Resmi
                </a>
                <a href="https://wa.me/{{ $cleanWa }}?text=Assalamu'alaikum%20Panitia%20SPMB,%20saya%20sudah%20mendaftar%20dengan%20No%20Registrasi%20{{ $data['registration_number'] }}" target="_blank" class="w-full py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs text-center flex items-center justify-center gap-2 transition-all">
                    <span>💬</span> Konfirmasi Bukti ke Panitia WA
                </a>
            </div>
        </div>
        @endif

        @php
            $initialStep = 1;
            if (isset($errors) && $errors->any()) {
                $step1Keys = ['school_code', 'masuk_kelas', 'jalur_pendaftaran', 'status_siswa', 'nama_lengkap', 'nama_panggilan', 'nik_siswa', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'anak_ke', 'jumlah_saudara', 'jumlah_saudara_kandung', 'jumlah_saudara_tiri', 'agama', 'keadaan_jasmani', 'status_tempat_tinggal', 'kewarganegaraan', 'bahasa_sehari_hari'];
                $step2Keys = ['jenjang_sekolah_asal', 'status_sekolah_asal', 'npsn_sekolah_asal', 'nisn', 'sekolah_asal', 'prestasi'];
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
                <button type="button" onclick="validateAndGo(currentStep, 1)" id="pill-step-1" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-active text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-white/20 text-white flex items-center justify-center text-[10px] font-black shrink-0">1</span>
                    <span class="truncate">Identitas Siswa</span>
                </button>
                <button type="button" onclick="validateAndGo(currentStep, 2)" id="pill-step-2" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">2</span>
                    <span class="truncate">Sekolah Asal</span>
                </button>
                <button type="button" onclick="validateAndGo(currentStep, 3)" id="pill-step-3" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">3</span>
                    <span class="truncate">Kesehatan</span>
                </button>
                <button type="button" onclick="validateAndGo(currentStep, 4)" id="pill-step-4" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
                    <span class="w-5 h-5 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px] font-black shrink-0">4</span>
                    <span class="truncate">Orang Tua</span>
                </button>
                <button type="button" onclick="validateAndGo(currentStep, 5)" id="pill-step-5" class="py-2.5 px-3 rounded-xl text-center transition-all step-pill-inactive text-xs flex items-center justify-center gap-1.5">
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
                <button type="button" onclick="validateAndGo(currentStep, 1)" id="m-step-1" class="py-1 rounded-md text-[10px] font-black transition-all bg-emerald-700 text-white shadow-xs text-center">1</button>
                <button type="button" onclick="validateAndGo(currentStep, 2)" id="m-step-2" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">2</button>
                <button type="button" onclick="validateAndGo(currentStep, 3)" id="m-step-3" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">3</button>
                <button type="button" onclick="validateAndGo(currentStep, 4)" id="m-step-4" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">4</button>
                <button type="button" onclick="validateAndGo(currentStep, 5)" id="m-step-5" class="py-1 rounded-md text-[10px] font-bold transition-all bg-slate-100 text-slate-500 text-center">5</button>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form id="spmbForm" action="{{ route('school.ppdb.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-8 rounded-3xl form-card space-y-6">
            @csrf

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
                        <label class="block text-xs font-black text-slate-700 uppercase">Unit Sekolah Tujuan *</label>
                        <select name="school_code" id="school_code" onchange="updateUnitFeeInfo()" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            @php
                                $selected = old('school_code', $selectedUnit ?? 'SDIT');
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
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Masuk di Kelas</label>
                        <input type="text" name="masuk_kelas" id="masuk_kelas" value="{{ old('masuk_kelas') }}" placeholder="Contoh: TK A / SD Kelas 1 / SMP Kelas 7" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jalur Pendaftaran *</label>
                        <select name="jalur_pendaftaran" id="jalur_pendaftaran" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="REGULER" {{ old('jalur_pendaftaran', 'REGULER') == 'REGULER' ? 'selected' : '' }}>Jalur Reguler (Umum)</option>
                            <option value="PRESTASI" {{ old('jalur_pendaftaran') == 'PRESTASI' ? 'selected' : '' }}>Jalur Prestasi (Akademik / Non-Akademik)</option>
                            <option value="TAHFIDZ" {{ old('jalur_pendaftaran') == 'TAHFIDZ' ? 'selected' : '' }}>Jalur Beasiswa Tahfidz Qur'an</option>
                            <option value="PINDAHAN" {{ old('jalur_pendaftaran') == 'PINDAHAN' ? 'selected' : '' }}>Jalur Pindahan / Mutasi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Status Masuk Siswa *</label>
                        <select name="status_siswa" id="status_siswa" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Baru" {{ old('status_siswa', 'Baru') == 'Baru' ? 'selected' : '' }}>Siswa Baru</option>
                            <option value="Pindahan" {{ old('status_siswa') == 'Pindahan' ? 'selected' : '' }}>Siswa Pindahan</option>
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
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required placeholder="NAMA LENGKAP SESUAI AKTA KELAHIRAN" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold uppercase">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan') }}" placeholder="Nama Panggilan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- NIK & Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. NIK Siswa (16 Digit Angka KK)</label>
                        <input type="text" name="nik_siswa" id="nik_siswa" value="{{ old('nik_siswa') }}" maxlength="16" placeholder="16 Digit NIK dari Kartu Keluarga" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Tempat, Tanggal Lahir -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota / Kabupaten Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- Anak ke & Saudara -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">6. Anak ke -</label>
                        <input type="number" name="anak_ke" id="anak_ke" value="{{ old('anak_ke') }}" min="1" max="20" placeholder="1" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Dari Jml Saudara</label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" value="{{ old('jumlah_saudara') }}" min="1" max="20" placeholder="3" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jml Saudara Kandung</label>
                        <input type="number" name="jumlah_saudara_kandung" id="jumlah_saudara_kandung" value="{{ old('jumlah_saudara_kandung') }}" min="0" max="20" placeholder="2" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jml Saudara Tiri</label>
                        <input type="number" name="jumlah_saudara_tiri" id="jumlah_saudara_tiri" value="{{ old('jumlah_saudara_tiri') }}" min="0" max="20" placeholder="0" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- Agama & Keadaan Jasmani -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">7. Agama</label>
                        <input type="text" name="agama" id="agama" value="{{ old('agama', 'Islam') }}" readonly class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 form-input text-xs font-bold text-slate-500 cursor-not-allowed">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">8. Keadaan Jasmani</label>
                        <select name="keadaan_jasmani" id="keadaan_jasmani" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Sehat" {{ old('keadaan_jasmani', 'Sehat') == 'Sehat' ? 'selected' : '' }}>Sehat Walafiat</option>
                            <option value="Kurang Sehat" {{ old('keadaan_jasmani') == 'Kurang Sehat' ? 'selected' : '' }}>Kurang Sehat</option>
                            <option value="Berkebutuhan Khusus" {{ old('keadaan_jasmani') == 'Berkebutuhan Khusus' ? 'selected' : '' }}>Berkebutuhan Khusus</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">9. Status Tempat Tinggal</label>
                        <select name="status_tempat_tinggal" id="status_tempat_tinggal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Rumah Sendiri" {{ old('status_tempat_tinggal', 'Rumah Sendiri') == 'Rumah Sendiri' ? 'selected' : '' }}>Rumah Sendiri</option>
                            <option value="Sewa / Kontrak" {{ old('status_tempat_tinggal') == 'Sewa / Kontrak' ? 'selected' : '' }}>Sewa / Kontrak</option>
                            <option value="Ikut Orang Tua" {{ old('status_tempat_tinggal') == 'Ikut Orang Tua' ? 'selected' : '' }}>Ikut Orang Tua</option>
                            <option value="Tinggal dikosan" {{ old('status_tempat_tinggal') == 'Tinggal dikosan' ? 'selected' : '' }}>Tinggal dikosan</option>
                            <option value="Ikut Keluarga/Saudara" {{ old('status_tempat_tinggal') == 'Ikut Keluarga/Saudara' ? 'selected' : '' }}>Ikut Keluarga / Saudara</option>
                            <option value="Lainnya" {{ old('status_tempat_tinggal') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">10. Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI (Warga Negara Indonesia)</option>
                            <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga Negara Asing)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">11. Bahasa Sehari-hari</label>
                        <select name="bahasa_sehari_hari" id="bahasa_sehari_hari" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Indonesia" {{ old('bahasa_sehari_hari', 'Indonesia') == 'Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="Daerah" {{ old('bahasa_sehari_hari') == 'Daerah' ? 'selected' : '' }}>Bahasa Daerah</option>
                            <option value="Inggris" {{ old('bahasa_sehari_hari') == 'Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Arab" {{ old('bahasa_sehari_hari') == 'Arab' ? 'selected' : '' }}>Bahasa Arab</option>
                            <option value="Mandarin" {{ old('bahasa_sehari_hari') == 'Mandarin' ? 'selected' : '' }}>Bahasa Mandarin</option>
                            <option value="Lainnya" {{ old('bahasa_sehari_hari') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. Jenjang Sekolah Asal</label>
                        <select name="jenjang_sekolah_asal" id="jenjang_sekolah_asal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="">-- Pilih Bila Ada --</option>
                            <option value="Belum Sekolah / Dari Rumah" {{ old('jenjang_sekolah_asal') == 'Belum Sekolah / Dari Rumah' ? 'selected' : '' }}>Belum Sekolah / Dari Rumah</option>
                            <option value="PAUD / Kelompok Bermain" {{ old('jenjang_sekolah_asal') == 'PAUD / Kelompok Bermain' ? 'selected' : '' }}>PAUD / Kelompok Bermain</option>
                            <option value="TK / RA" {{ old('jenjang_sekolah_asal') == 'TK / RA' ? 'selected' : '' }}>TK / RA</option>
                            <option value="SD / MI" {{ old('jenjang_sekolah_asal') == 'SD / MI' ? 'selected' : '' }}>SD / MI</option>
                            <option value="SMP / MTs" {{ old('jenjang_sekolah_asal') == 'SMP / MTs' ? 'selected' : '' }}>SMP / MTs</option>
                            <option value="Pondok Pesantren" {{ old('jenjang_sekolah_asal') == 'Pondok Pesantren' ? 'selected' : '' }}>Pondok Pesantren</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Status Sekolah Asal</label>
                        <select name="status_sekolah_asal" id="status_sekolah_asal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Swasta" {{ old('status_sekolah_asal', 'Swasta') == 'Swasta' ? 'selected' : '' }}>Swasta</option>
                            <option value="Negeri" {{ old('status_sekolah_asal') == 'Negeri' ? 'selected' : '' }}>Negeri</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. NPSN Sekolah Asal</label>
                        <input type="text" name="npsn_sekolah_asal" id="npsn_sekolah_asal" value="{{ old('npsn_sekolah_asal') }}" placeholder="8 Digit NPSN (Bila Ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. No. Peserta Ujian / NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}" placeholder="10 Digit NISN (Khusus lulusan SD/SMP)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">5. Nama Sekolah Asal *</label>
                    <input type="text" name="sekolah_asal" id="sekolah_asal" value="{{ old('sekolah_asal') }}" required placeholder="Contoh: TKIT Robbani / SDN 01 Indralaya" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    <p class="text-[10px] text-slate-400">*) Diisikan data dari jenjang sebelumnya (misal pendaftar SD isi nama TK asal, pendaftar SMP isi nama SD asal).</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Prestasi Yang Pernah Diraih</label>
                    <textarea name="prestasi" id="prestasi" rows="3" placeholder="Contoh: Juara 1 Tahfidz 1 Juz Tingkat Kabupaten, Juara 2 Lomba Menggambar, dll. (Kosongkan bila belum ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">{{ old('prestasi') }}</textarea>
                </div>

                <!-- Tombol Navigasi Step 2 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="validateAndGo(2, 1)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
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
                        <input type="number" name="tinggi_badan" id="tinggi_badan" value="{{ old('tinggi_badan') }}" placeholder="Contoh: 110" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="berat_badan" value="{{ old('berat_badan') }}" placeholder="Contoh: 20" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Belum Tahu" {{ old('golongan_darah') == 'Belum Tahu' ? 'selected' : '' }}>Belum Tahu</option>
                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>Golongan A</option>
                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>Golongan B</option>
                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>Golongan AB</option>
                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>Golongan O</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Penyakit yang Pernah Diderita</label>
                        <input type="text" name="penyakit_pernah" id="penyakit_pernah" value="{{ old('penyakit_pernah') }}" placeholder="Contoh: Asma, Tifus, DBD (Kosongkan bila tidak ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Penyakit yang Sedang Diderita</label>
                        <input type="text" name="penyakit_sedang" id="penyakit_sedang" value="{{ old('penyakit_sedang') }}" placeholder="Tuliskan jika sedang dalam terapi atau rutin obat" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Kelainan Fisik / Kebutuhan Khusus</label>
                    <input type="text" name="kelainan_fisik" id="kelainan_fisik" value="{{ old('kelainan_fisik') }}" placeholder="Tuliskan bila ada kebutuhan khusus / 'Tidak Ada'" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                </div>

                <!-- Moda Transportasi -->
                <div class="border-t border-slate-200 pt-4">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wide mb-3">Moda Transportasi Peserta Didik:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Jarak Tempat Tinggal ke Sekolah</label>
                            <select name="jarak_ke_sekolah" id="jarak_ke_sekolah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Kurang dari 1 km" {{ old('jarak_ke_sekolah') == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                                <option value="1 - 3 km" {{ old('jarak_ke_sekolah') == '1 - 3 km' ? 'selected' : '' }}>1 - 3 km</option>
                                <option value="3 - 5 km" {{ old('jarak_ke_sekolah') == '3 - 5 km' ? 'selected' : '' }}>3 - 5 km</option>
                                <option value="5 - 10 km" {{ old('jarak_ke_sekolah') == '5 - 10 km' ? 'selected' : '' }}>5 - 10 km</option>
                                <option value="Lebih dari 10 km" {{ old('jarak_ke_sekolah') == 'Lebih dari 10 km' ? 'selected' : '' }}>Lebih dari 10 km</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. Transportasi yang Digunakan</label>
                            <select name="transportasi" id="transportasi" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Sepeda Motor / Diantar Ortu" {{ old('transportasi') == 'Sepeda Motor / Diantar Ortu' ? 'selected' : '' }}>Sepeda Motor / Diantar Ortu</option>
                                <option value="Mobil Pribadi" {{ old('transportasi') == 'Mobil Pribadi' ? 'selected' : '' }}>Mobil Pribadi</option>
                                <option value="Jalan Kaki" {{ old('transportasi') == 'Jalan Kaki' ? 'selected' : '' }}>Jalan Kaki</option>
                                <option value="Antar Jemput Sekolah" {{ old('transportasi') == 'Antar Jemput Sekolah' ? 'selected' : '' }}>Antar Jemput Sekolah</option>
                                <option value="Angkutan Umum" {{ old('transportasi') == 'Angkutan Umum' ? 'selected' : '' }}>Angkutan Umum</option>
                                <option value="Lainnya" {{ old('transportasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi Step 3 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="validateAndGo(3, 2)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
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
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" required placeholder="Contoh: Jl. Sarjana Komplek Griya Sejahtera Blok A4 No. 5" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Dusun / RT-RW</label>
                            <input type="text" name="dusun" id="dusun" value="{{ old('dusun') }}" placeholder="RT 02 / RW 01" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Desa / Kelurahan *</label>
                            <input type="text" name="kelurahan" id="kelurahan" value="{{ old('kelurahan') }}" required placeholder="Contoh: Timbangan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kecamatan *</label>
                            <input type="text" name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}" required placeholder="Contoh: Indralaya Utara" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kabupaten / Kota *</label>
                            <input type="text" name="kabupaten" id="kabupaten" value="{{ old('kabupaten') }}" required placeholder="Contoh: Ogan Ilir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Provinsi *</label>
                            <input type="text" name="provinsi" id="provinsi" value="{{ old('provinsi') }}" required placeholder="Contoh: Sumatera Selatan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" value="{{ old('kode_pos') }}" placeholder="Contoh: 30662" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
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
                            <input type="text" name="nama_ayah" id="nama_ayah" value="{{ old('nama_ayah') }}" required placeholder="Nama Lengkap Beserta Gelar" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. NIK Ayah (16 Digit KK) *</label>
                            <input type="text" name="nik_ayah" id="nik_ayah" value="{{ old('nik_ayah') }}" required maxlength="16" placeholder="16 Digit NIK Ayah" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. Tempat Lahir Ayah</label>
                            <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" value="{{ old('tempat_lahir_ayah') }}" placeholder="Kota / Kab Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" value="{{ old('tanggal_lahir_ayah') }}" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pendidikan Terakhir</label>
                            <select name="pendidikan_ayah" id="pendidikan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S1" {{ old('pendidikan_ayah', 'S1') == 'S1' ? 'selected' : '' }}>S1 / Sarjana</option>
                                <option value="S2/S3" {{ old('pendidikan_ayah') == 'S2/S3' ? 'selected' : '' }}>S2 / S3 (Pascasarjana)</option>
                                <option value="D3/D4" {{ old('pendidikan_ayah') == 'D3/D4' ? 'selected' : '' }}>D3 / D4 (Diploma)</option>
                                <option value="SMA/SMK" {{ old('pendidikan_ayah') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                                <option value="SMP" {{ old('pendidikan_ayah') == 'SMP' ? 'selected' : '' }}>SMP Sederajat</option>
                                <option value="SD" {{ old('pendidikan_ayah') == 'SD' ? 'selected' : '' }}>SD Sederajat</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Pekerjaan Ayah *</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required placeholder="PNS/TNI/Karyawan/Wiraswasta" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">7. Nama Instansi / Perusahaan</label>
                            <input type="text" name="instansi_ayah" id="instansi_ayah" value="{{ old('instansi_ayah') }}" placeholder="Nama Kantor / Usaha" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. Jabatan</label>
                            <input type="text" name="jabatan_ayah" id="jabatan_ayah" value="{{ old('jabatan_ayah') }}" placeholder="Staff / Manager / Pemilik" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. No. HP / WhatsApp Ayah *</label>
                            <input type="text" name="no_hp_ayah" id="no_hp_ayah" value="{{ old('no_hp_ayah') }}" required placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">10. Penghasilan Bulanan</label>
                            <select name="penghasilan_ayah" id="penghasilan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="< Rp 1.000.000" {{ old('penghasilan_ayah') == '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ old('penghasilan_ayah') == 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('penghasilan_ayah', 'Rp 3.000.000 - Rp 5.000.000') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ old('penghasilan_ayah') == 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ old('penghasilan_ayah') == '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
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
                            <input type="text" name="nama_ibu" id="nama_ibu" value="{{ old('nama_ibu') }}" required placeholder="Nama Lengkap Beserta Gelar" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. NIK Ibu (16 Digit KK) *</label>
                            <input type="text" name="nik_ibu" id="nik_ibu" value="{{ old('nik_ibu') }}" required maxlength="16" placeholder="16 Digit NIK Ibu" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. Tempat Lahir Ibu</label>
                            <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" value="{{ old('tempat_lahir_ibu') }}" placeholder="Kota / Kab Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" value="{{ old('tanggal_lahir_ibu') }}" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pendidikan Terakhir</label>
                            <select name="pendidikan_ibu" id="pendidikan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S1" {{ old('pendidikan_ibu', 'S1') == 'S1' ? 'selected' : '' }}>S1 / Sarjana</option>
                                <option value="S2/S3" {{ old('pendidikan_ibu') == 'S2/S3' ? 'selected' : '' }}>S2 / S3 (Pascasarjana)</option>
                                <option value="D3/D4" {{ old('pendidikan_ibu') == 'D3/D4' ? 'selected' : '' }}>D3 / D4 (Diploma)</option>
                                <option value="SMA/SMK" {{ old('pendidikan_ibu') == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                                <option value="SMP" {{ old('pendidikan_ibu') == 'SMP' ? 'selected' : '' }}>SMP Sederajat</option>
                                <option value="SD" {{ old('pendidikan_ibu') == 'SD' ? 'selected' : '' }}>SD Sederajat</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Pekerjaan Ibu *</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required placeholder="Ibu Rumah Tangga / PNS / Guru / Swasta" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">7. Nama Instansi / Perusahaan</label>
                            <input type="text" name="instansi_ibu" id="instansi_ibu" value="{{ old('instansi_ibu') }}" placeholder="Nama Kantor / Usaha" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. Jabatan</label>
                            <input type="text" name="jabatan_ibu" id="jabatan_ibu" value="{{ old('jabatan_ibu') }}" placeholder="Staff / Guru / Pemilik" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. No. HP / WhatsApp Ibu</label>
                            <input type="text" name="no_hp_ibu" id="no_hp_ibu" value="{{ old('no_hp_ibu') }}" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">10. Penghasilan Bulanan</label>
                            <select name="penghasilan_ibu" id="penghasilan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Tidak Berpenghasilan" {{ old('penghasilan_ibu') == 'Tidak Berpenghasilan' ? 'selected' : '' }}>Tidak Berpenghasilan / IRT</option>
                                <option value="< Rp 1.000.000" {{ old('penghasilan_ibu') == '< Rp 1.000.000' ? 'selected' : '' }}>&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000" {{ old('penghasilan_ibu') == 'Rp 1.000.000 - Rp 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000" {{ old('penghasilan_ibu') == 'Rp 3.000.000 - Rp 5.000.000' ? 'selected' : '' }}>Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000" {{ old('penghasilan_ibu') == 'Rp 5.000.000 - Rp 10.000.000' ? 'selected' : '' }}>Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000" {{ old('penghasilan_ibu') == '> Rp 10.000.000' ? 'selected' : '' }}>&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATA WALI (OPSIONAL) -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-700 block uppercase">Data Wali (Opsional, Bila Tidak Tinggal Bersama Orang Tua Kandung):</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" name="nama_wali" id="nama_wali" value="{{ old('nama_wali') }}" placeholder="Nama Lengkap Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="hubungan_wali" id="hubungan_wali" value="{{ old('hubungan_wali') }}" placeholder="Hubungan (Kakek/Paman/Bibi)" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="no_hp_wali" id="no_hp_wali" value="{{ old('no_hp_wali') }}" placeholder="No. HP Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>
                </div>

                <!-- Tombol Navigasi Step 4 (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="validateAndGo(4, 3)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
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
                            <input type="radio" name="info_pendaftaran" value="Brosur" {{ old('info_pendaftaran') == 'Brosur' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Brosur</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Banner / Spanduk" {{ old('info_pendaftaran') == 'Banner / Spanduk' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Banner / Spanduk</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Media Sosial" {{ old('info_pendaftaran', 'Media Sosial') == 'Media Sosial' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Media Sosial (IG/FB)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Teman / Saudara" {{ old('info_pendaftaran') == 'Teman / Saudara' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Teman / Saudara</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Guru / Tendik SIT Robbani" {{ old('info_pendaftaran') == 'Guru / Tendik SIT Robbani' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Guru / Tendik Robbani</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Lainnya" {{ old('info_pendaftaran') == 'Lainnya' ? 'checked' : '' }} class="text-emerald-700 focus:ring-emerald-500">
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
                            <p class="text-[10px] text-slate-400">Format foto 3x4 atau setara.</p>
                        </div>

                        <!-- Akta Kelahiran Calon Siswa -->
                        <div class="p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-300 space-y-1.5">
                            <label class="block text-xs font-black text-emerald-950 flex items-center justify-between">
                                <span>2. Akta Kelahiran Calon Siswa *</span>
                                <span class="text-[10px] font-bold text-emerald-800 bg-emerald-200/80 px-2 py-0.5 rounded-full">WAJIB</span>
                            </label>
                            <input type="file" name="akta_kelahiran" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-800 file:text-white hover:file:bg-emerald-900 cursor-pointer">
                            <p class="text-[10px] text-emerald-800 font-medium">Foto / Scan Asli Akta Kelahiran calon siswa.</p>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">3. Kartu Keluarga (KK)</label>
                            <input type="file" name="kartu_keluarga" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Scan / Foto Kartu Keluarga jelas.</p>
                        </div>

                        <!-- KTP Orang Tua -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">4. KTP Orang Tua (Ayah / Ibu)</label>
                            <input type="file" name="ktp_ortu" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Foto KTP Ayah / Ibu.</p>
                        </div>
                    </div>

                    <!-- Bukti Transfer -->
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-1.5">
                        <label class="block text-xs font-black text-amber-950 uppercase">5. Bukti Transfer Biaya Formulir Pendaftaran</label>
                        <input type="file" name="bukti_transfer" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-600 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-amber-600 file:text-white hover:file:bg-amber-700 cursor-pointer">
                        <p class="text-[11px] text-amber-800">Unggah bukti transfer dari ATM / Mobile Banking untuk mempercepat verifikasi otomatis.</p>
                    </div>
                </div>

                <!-- Pernyataan Keabsahan Data -->
                <div class="p-4 rounded-2xl bg-slate-100 border border-slate-200 text-xs text-slate-700 space-y-2">
                    <label class="flex items-start gap-2.5 cursor-pointer">
                        <input type="checkbox" required class="mt-0.5 rounded text-emerald-700 focus:ring-emerald-500">
                        <span class="text-[11px] leading-relaxed">
                            Dengan ini saya menyatakan bahwa data yang saya isikan pada formulir pendaftaran SPMB SIT Robbani Ogan Ilir ini adalah benar, sah, dan dapat dipertanggungjawabkan.
                        </span>
                    </label>
                </div>

                <!-- Navigation & Submit (Rata Tengah di HP) -->
                <div class="pt-4 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">
                    <button type="button" onclick="validateAndGo(5, 4)" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors text-center">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="submit" id="submitBtn" class="w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-700/25 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <span>✓ Kirim Formulir Pendaftaran</span>
                    </button>
                </div>
            </div>

        </form>
    </main>

    <!-- Footer Simple (Rata Tengah) -->
    <footer class="py-6 border-t border-slate-200 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Yayasan Generasi Robbani Sumatera Selatan. SPMB Online System.</p>
    </footer>

    <!-- Form Wizard Logic (Dinamis dari CMS Admin) -->
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

        function validateStep(step) {
            const section = document.getElementById(`step-section-${step}`);
            if (!section) return true;
            const requiredFields = section.querySelectorAll('input[required], select[required], textarea[required]');
            for (let el of requiredFields) {
                if (!el.checkValidity()) {
                    el.reportValidity();
                    return false;
                }
            }
            return true;
        }

        function validateAndGo(fromStep, toStep) {
            if (toStep > fromStep) {
                for (let s = fromStep; s < toStep; s++) {
                    if (!validateStep(s)) {
                        goToStep(s);
                        return false;
                    }
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
            goToStep(currentStep);

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
</body>
</html>
