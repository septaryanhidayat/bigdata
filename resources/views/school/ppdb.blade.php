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
    <header class="py-3 px-4 sm:px-8 sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
            <!-- Brand Logo -->
            <a href="{{ route('school.spmb') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-10 sm:h-11 w-auto object-contain">
                <div>
                    <h2 class="font-black text-xs sm:text-sm tracking-tight text-slate-900 leading-tight">
                        FORMULIR SPMB ONLINE
                    </h2>
                    <p class="text-[10px] sm:text-[11px] font-bold text-emerald-800 uppercase tracking-wider">
                        SIT ROBBANI OGAN ILIR
                    </p>
                </div>
            </a>

            <!-- Right Controls -->
            <div class="flex items-center gap-2">
                <a href="{{ route('school.spmb') }}" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors flex items-center gap-1.5">
                    <span>➔</span>
                    <span>Landing Page SPMB</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="py-6 sm:py-10 max-w-4xl mx-auto px-3 sm:px-4 w-full space-y-6 flex-1">
        
        <!-- Header Title -->
        <div class="text-center space-y-2">
            <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider inline-block">
                F-SPMB 2026-2027 / 2027-2028
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Formulir Penerimaan Peserta Didik Baru
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-2xl mx-auto">
                Silakan lengkapi formulir pendaftaran di bawah ini dengan data yang benar dan teliti sesuai dokumen resmi (Kartu Keluarga & Akta Kelahiran).
            </p>
        </div>

        <!-- Success Notification Banner -->
        @if(session('spmb_success_data'))
        @php 
            $data = session('spmb_success_data'); 
            $verifyUrl = route('school.spmb.verify', $data['registration_number']);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($verifyUrl);
        @endphp
        <div class="p-5 sm:p-8 rounded-3xl bg-emerald-800 text-white shadow-xl space-y-4">
            <div class="flex items-center justify-between border-b border-emerald-700 pb-3">
                <span class="px-3 py-1 rounded-full bg-emerald-700 text-emerald-100 font-black text-[10px] sm:text-xs uppercase">
                    ✓ Pendaftaran SPMB Berhasil
                </span>
                <span class="text-xs text-emerald-200 font-medium">{{ $data['date'] }}</span>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-5">
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
                <div class="p-3 rounded-2xl bg-white text-center shadow-md shrink-0">
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
                <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB,%20saya%20sudah%20mendaftar%20dengan%20No%20Registrasi%20{{ $data['registration_number'] }}" target="_blank" class="w-full py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-600 text-white font-black text-xs text-center flex items-center justify-center gap-2 transition-all">
                    <span>💬</span> Konfirmasi Bukti ke Panitia WA
                </a>
            </div>
        </div>
        @endif

        <!-- Validation Error Alert -->
        @if (isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
            <div class="flex items-center gap-2 font-black">
                <span>⚠️</span> Terdapat kolom yang belum terisi dengan benar:
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-[11px] text-rose-700 pl-1">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- STEP WIZARD PILL NAVIGATION -->
        <div class="bg-white p-3 rounded-2xl border border-slate-200/80 shadow-xs">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-0.5 text-xs font-bold">
                <button type="button" onclick="goToStep(1)" id="pill-step-1" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-active text-[11px]">
                    1. Identitas Calon Siswa
                </button>
                <button type="button" onclick="goToStep(2)" id="pill-step-2" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    2. Sekolah & Prestasi
                </button>
                <button type="button" onclick="goToStep(3)" id="pill-step-3" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    3. Kesehatan & Transport
                </button>
                <button type="button" onclick="goToStep(4)" id="pill-step-4" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    4. Data Orang Tua
                </button>
                <button type="button" onclick="goToStep(5)" id="pill-step-5" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    5. Berkas & Selesai
                </button>
            </div>
        </div>

        <!-- MAIN FORM -->
        <form id="spmbForm" action="{{ route('school.ppdb.store') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-8 rounded-3xl form-card space-y-6">
            @csrf

            <!-- ========================================================================= -->
            <!-- STEP 1: IDENTITAS PESERTA DIDIK (WAJIB DIISI) -->
            <!-- ========================================================================= -->
            <div id="step-section-1" class="step-section space-y-5">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Bagian 1 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center gap-2">
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
                                $selected = $selectedUnit ?? 'SDIT';
                            @endphp
                            <option value="TPA" {{ $selected == 'TPA' ? 'selected' : '' }}>TPA ROBBANI (Taman Pengasuhan Anak)</option>
                            <option value="KB" {{ $selected == 'KB' ? 'selected' : '' }}>KB ROBBANI (Kelompok Bermain)</option>
                            <option value="TKIT" {{ ($selected == 'TKIT' || $selected == 'TK') ? 'selected' : '' }}>TKIT ROBBANI (Taman Kanak-Kanak)</option>
                            <option value="SDIT" {{ ($selected == 'SDIT' || $selected == 'SD') ? 'selected' : '' }}>SDIT ROBBANI (Sekolah Dasar)</option>
                            <option value="SMPIT" {{ ($selected == 'SMPIT' || $selected == 'SMP') ? 'selected' : '' }}>SMPIT ROBBANI (Sekolah Menengah Pertama)</option>
                            <option value="SMAIT" {{ ($selected == 'SMAIT' || $selected == 'SMA') ? 'selected' : '' }}>SMAIT ROBBANI (Sekolah Menengah Atas)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Masuk di Kelas</label>
                        <input type="text" name="masuk_kelas" id="masuk_kelas" placeholder="Contoh: TK A / SD Kelas 1 / SMP Kelas 7" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Jalur Pendaftaran *</label>
                        <select name="jalur_pendaftaran" id="jalur_pendaftaran" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="REGULER">Jalur Reguler (Umum)</option>
                            <option value="PRESTASI">Jalur Prestasi (Akademik / Non-Akademik)</option>
                            <option value="TAHFIDZ">Jalur Beasiswa Tahfidz Qur'an</option>
                            <option value="PINDAHAN">Jalur Pindahan / Mutasi</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Status Masuk Siswa *</label>
                        <select name="status_siswa" id="status_siswa" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Baru">Siswa Baru</option>
                            <option value="Pindahan">Siswa Pindahan</option>
                        </select>
                    </div>
                </div>

                <!-- Fee banner preview -->
                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
                    <span class="font-bold text-slate-700">Biaya Formulir Pendaftaran Unit Ini:</span>
                    <span id="selectedUnitFeeDisplay" class="font-mono font-black text-emerald-800 text-sm">
                        Rp 250.000
                    </span>
                </div>

                <!-- Nama Lengkap & Panggilan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ananda (Huruf Kapital) *</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" required placeholder="NAMA LENGKAP SESUAI AKTA KELAHIRAN" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold uppercase">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Nama Panggilan</label>
                        <input type="text" name="nama_panggilan" id="nama_panggilan" placeholder="Nama Panggilan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- NIK & Jenis Kelamin -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. NIK Siswa (16 Digit Angka KK)</label>
                        <input type="text" name="nik_siswa" id="nik_siswa" maxlength="16" placeholder="16 Digit NIK dari Kartu Keluarga" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <!-- Tempat, Tanggal Lahir -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" required placeholder="Kota / Kabupaten Lahir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                </div>

                <!-- Anak ke & Saudara -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">6. Anak ke -</label>
                        <input type="number" name="anak_ke" id="anak_ke" min="1" max="20" placeholder="1" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Dari ... Saudara</label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" min="0" max="20" placeholder="2" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="sm:col-span-2 space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">7. Status Orang Tua *</label>
                        <select name="status_ortu" id="status_ortu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Ayah dan Ibu Masih Ada">Ayah dan Ibu Masih Ada</option>
                            <option value="Anak Yatim">Anak Yatim (Ayah Wafat)</option>
                            <option value="Anak Piatu">Anak Piatu (Ibu Wafat)</option>
                            <option value="Yatim Piatu">Yatim Piatu (Kedua Wafat)</option>
                        </select>
                    </div>
                </div>

                <!-- Tempat Tinggal Anak & Kewarganegaraan -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">8. Tempat Tinggal Anak</label>
                        <select name="tempat_tinggal_anak" id="tempat_tinggal_anak" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Ikut Orang Tua">Ikut Orang Tua</option>
                            <option value="Tinggal dikosan">Tinggal dikosan</option>
                            <option value="Ikut Keluarga/Saudara">Ikut Keluarga / Saudara</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">10. Kewarganegaraan</label>
                        <select name="kewarganegaraan" id="kewarganegaraan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="WNI">WNI (Warga Negara Indonesia)</option>
                            <option value="WNA">WNA (Warga Negara Asing)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">11. Bahasa Sehari-hari</label>
                        <select name="bahasa_sehari_hari" id="bahasa_sehari_hari" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Indonesia">Bahasa Indonesia</option>
                            <option value="Daerah">Bahasa Daerah</option>
                            <option value="Inggris">Bahasa Inggris</option>
                            <option value="Arab">Bahasa Arab</option>
                            <option value="Mandarin">Bahasa Mandarin</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" onclick="goToStep(2)" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center gap-2">
                        <span>Lanjut: Data Sekolah & Prestasi</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 2: DATA SEKOLAH ASAL & PRESTASI -->
            <!-- ========================================================================= -->
            <div id="step-section-2" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Bagian 2 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center gap-2">
                        <span>🏫</span> DATA SEKOLAH ASAL & PRESTASI
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Informasi sekolah jenjang sebelumnya dan riwayat capaian ananda.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. NISN (Jika Ada)</label>
                        <input type="text" name="nisn" id="nisn" maxlength="12" placeholder="Nomor Induk Siswa Nasional (10-12 Angka)" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Kategori Sekolah Asal</label>
                        <select name="kategori_sekolah_asal" id="kategori_sekolah_asal" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Luar SIT Robbani">Luar SIT Robbani</option>
                            <option value="Alumni SIT Robbani">Alumni SIT Robbani</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">5. Nama Sekolah Asal *</label>
                    <input type="text" name="sekolah_asal" id="sekolah_asal" placeholder="Contoh: TKIT Robbani / SDN 01 Indralaya" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    <p class="text-[10px] text-slate-400">*) Diisikan data dari jenjang sebelumnya (misal pendaftar SD isi nama TK asal, pendaftar SMP isi nama SD asal).</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Prestasi Yang Pernah Diraih</label>
                    <textarea name="prestasi" id="prestasi" rows="3" placeholder="Contoh: Juara 1 Tahfidz 1 Juz Tingkat Kabupaten, Juara 2 Lomba Menggambar, dll. (Kosongkan bila belum ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium"></textarea>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToStep(1)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="goToStep(3)" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center gap-2">
                        <span>Lanjut: Data Kesehatan & Transportasi</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 3: DATA KESEHATAN & MODA TRANSPORTASI -->
            <!-- ========================================================================= -->
            <div id="step-section-3" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Bagian 3 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center gap-2">
                        <span>🩺</span> DATA KESEHATAN & MODA TRANSPORTASI
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Informasi fisik, rekam medis penunjang, dan jarak ke sekolah.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">1. Tinggi Badan (cm)</label>
                        <input type="number" name="tinggi_badan" id="tinggi_badan" min="30" max="250" placeholder="Contoh: 120" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">2. Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="berat_badan" min="5" max="200" placeholder="Contoh: 25" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">3. Golongan Darah</label>
                        <select name="golongan_darah" id="golongan_darah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                            <option value="Belum Tahu">Belum Tahu</option>
                            <option value="A">Golongan A</option>
                            <option value="B">Golongan B</option>
                            <option value="AB">Golongan AB</option>
                            <option value="O">Golongan O</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">4. Penyakit yang Pernah Diderita</label>
                        <input type="text" name="penyakit_pernah" id="penyakit_pernah" placeholder="Contoh: Asma, Tifus, DBD (Kosongkan bila tidak ada)" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">5. Penyakit yang Sedang Diderita</label>
                        <input type="text" name="penyakit_sedang" id="penyakit_sedang" placeholder="Tuliskan jika sedang dalam terapi atau rutin obat" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-black text-slate-700 uppercase">6. Kelainan Fisik / Kebutuhan Khusus</label>
                    <input type="text" name="kelainan_fisik" id="kelainan_fisik" placeholder="Tuliskan bila ada kebutuhan khusus / 'Tidak Ada'" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                </div>

                <!-- Moda Transportasi -->
                <div class="border-t border-slate-200 pt-4">
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wide mb-3">Moda Transportasi Peserta Didik:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Jarak Tempat Tinggal ke Sekolah</label>
                            <select name="jarak_ke_sekolah" id="jarak_ke_sekolah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Kurang dari 1 km">Kurang dari 1 km</option>
                                <option value="1 - 3 km">1 - 3 km</option>
                                <option value="3 - 5 km">3 - 5 km</option>
                                <option value="5 - 10 km">5 - 10 km</option>
                                <option value="Lebih dari 10 km">Lebih dari 10 km</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. Transportasi yang Digunakan</label>
                            <select name="transportasi" id="transportasi" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Sepeda Motor / Diantar Ortu">Sepeda Motor / Diantar Ortu</option>
                                <option value="Mobil Pribadi">Mobil Pribadi</option>
                                <option value="Jalan Kaki">Jalan Kaki</option>
                                <option value="Antar Jemput Sekolah">Antar Jemput Sekolah</option>
                                <option value="Angkutan Umum">Angkutan Umum</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToStep(2)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="goToStep(4)" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center gap-2">
                        <span>Lanjut: Data Orang Tua & Domisili</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 4: ALAMAT DOMISILI & DATA ORANG TUA (AYAH & IBU KANDUNG) -->
            <!-- ========================================================================= -->
            <div id="step-section-4" class="step-section space-y-6 hidden">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Bagian 4 dari 5
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center gap-2">
                        <span>🏡</span> ALAMAT TEMPAT TINGGAL & DATA ORANG TUA KANDUNG
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Data ayah & ibu kandung wajib diisi untuk verifikasi panitia SPMB.</p>
                </div>

                <!-- ALAMAT DOMISILI LENGKAP -->
                <div class="space-y-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wide">Alamat Tempat Tinggal Anak:</h4>
                    
                    <div class="space-y-1">
                        <label class="block text-xs font-black text-slate-700 uppercase">Alamat Jalan / No. Rumah / Gang *</label>
                        <input type="text" name="alamat" id="alamat" required placeholder="Contoh: Jl. Sarjana Komplek Griya Sejahtera Blok A4 No. 5" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-medium">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Dusun / RT-RW</label>
                            <input type="text" name="dusun" id="dusun" placeholder="RT 02 / RW 01" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kelurahan / Desa</label>
                            <input type="text" name="kelurahan" id="kelurahan" placeholder="Kelurahan Timbangan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kode Pos</label>
                            <input type="text" name="kode_pos" id="kode_pos" maxlength="7" placeholder="30662" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" placeholder="Indralaya Utara" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Kabupaten / Kota</label>
                            <input type="text" name="kabupaten" id="kabupaten" placeholder="Ogan Ilir" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" placeholder="Sumatera Selatan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>
                </div>

                <!-- DATA AYAH KANDUNG (WAJIB DIISI) -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                        <span class="text-sm">👨</span>
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-wide">DATA AYAH KANDUNG (WAJIB DIISI)</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ayah *</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" required placeholder="Nama Lengkap Ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. NIK Ayah (16 Digit KK)</label>
                            <input type="text" name="nik_ayah" id="nik_ayah" maxlength="16" placeholder="16 Digit NIK Ayah" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. Tempat Lahir Ayah</label>
                            <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" placeholder="Kota Lahir Ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Tanggal Lahir Ayah</label>
                            <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Pendidikan Terakhir</label>
                            <select name="pendidikan_ayah" id="pendidikan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S-1">S-1 (Sarjana)</option>
                                <option value="SMA">SMA / SMK / MA</option>
                                <option value="SMP">SMP / MTs</option>
                                <option value="SD">SD / Sederajat</option>
                                <option value="D3/D4">D3 / D4</option>
                                <option value="S-2">S-2 (Magister)</option>
                                <option value="S-3">S-3 (Doktor)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pekerjaan Ayah</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" placeholder="PNS / Wiraswasta / Karyawan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Tempat Instansi Bekerja</label>
                            <input type="text" name="instansi_ayah" id="instansi_ayah" placeholder="Nama Kantor / Perusahaan" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">7. Bidang Keahlian</label>
                            <input type="text" name="bidang_keahlian_ayah" id="bidang_keahlian_ayah" placeholder="Keahlian / Profesi" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. No. HP / WhatsApp Ayah *</label>
                            <input type="text" name="no_hp_ayah" id="no_hp_ayah" required placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. Penghasilan Bulanan</label>
                            <select name="penghasilan_ayah" id="penghasilan_ayah" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Rp 3.000.000 - Rp 5.000.000">Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="< Rp 1.000.000">&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000">Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000">&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATA IBU KANDUNG (WAJIB DIISI) -->
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
                    <div class="flex items-center gap-2 border-b border-slate-200 pb-2">
                        <span class="text-sm">👩</span>
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-wide">DATA IBU KANDUNG (WAJIB DIISI)</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">1. Nama Lengkap Ibu *</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" required placeholder="Nama Lengkap Ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">3. NIK Ibu (16 Digit KK)</label>
                            <input type="text" name="nik_ibu" id="nik_ibu" maxlength="16" placeholder="16 Digit NIK Ibu" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">2. Tempat Lahir Ibu</label>
                            <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" placeholder="Kota Lahir Ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">Tanggal Lahir Ibu</label>
                            <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">4. Pendidikan Terakhir</label>
                            <select name="pendidikan_ibu" id="pendidikan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="S-1">S-1 (Sarjana)</option>
                                <option value="SMA">SMA / SMK / MA</option>
                                <option value="SMP">SMP / MTs</option>
                                <option value="SD">SD / Sederajat</option>
                                <option value="D3/D4">D3 / D4</option>
                                <option value="S-2">S-2 (Magister)</option>
                                <option value="S-3">S-3 (Doktor)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">5. Pekerjaan Ibu</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" placeholder="Ibu Rumah Tangga / PNS / Guru" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">6. Tempat Instansi Bekerja</label>
                            <input type="text" name="instansi_ibu" id="instansi_ibu" placeholder="Nama Kantor / Tempat Usaha" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">8. Alamat Rumah Ibu</label>
                            <input type="text" name="alamat_ibu" id="alamat_ibu" placeholder="Sama dengan alamat siswa / tuliskan jika beda" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">9. No. HP / WhatsApp Ibu</label>
                            <input type="text" name="no_hp_ibu" id="no_hp_ibu" placeholder="08xxxxxxxxxx" oninput="this.value = this.value.replace(/[^0-9\+\-\s]/g, '')" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-black text-slate-700 uppercase">10. Penghasilan Bulanan</label>
                            <select name="penghasilan_ibu" id="penghasilan_ibu" class="w-full px-3.5 py-2.5 rounded-xl form-input text-xs font-bold">
                                <option value="Tidak Berpenghasilan">Tidak Berpenghasilan / IRT</option>
                                <option value="< Rp 1.000.000">&lt; Rp 1.000.000</option>
                                <option value="Rp 1.000.000 - Rp 3.000.000">Rp 1.000.000 - Rp 3.000.000</option>
                                <option value="Rp 3.000.000 - Rp 5.000.000">Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000">&gt; Rp 10.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- DATA WALI (OPSIONAL) -->
                <div class="p-4 rounded-2xl bg-white border border-slate-200/80 space-y-3">
                    <span class="text-xs font-black text-slate-700 block uppercase">Data Wali (Opsional, Bila Tidak Tinggal Bersama Orang Tua Kandung):</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <input type="text" name="nama_wali" id="nama_wali" placeholder="Nama Lengkap Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="hubungan_wali" id="hubungan_wali" placeholder="Hubungan (Kakek/Paman/Bibi)" class="px-3.5 py-2.5 rounded-xl form-input text-xs">
                        <input type="text" name="no_hp_wali" id="no_hp_wali" placeholder="No. HP Wali" class="px-3.5 py-2.5 rounded-xl form-input text-xs font-mono">
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToStep(3)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="button" onclick="goToStep(5)" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center gap-2">
                        <span>Lanjut: Upload Berkas & Pembayaran</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- ========================================================================= -->
            <!-- STEP 5: INFORMASI PENDAFTARAN & UPLOAD BERKAS -->
            <!-- ========================================================================= -->
            <div id="step-section-5" class="step-section space-y-5 hidden">
                <div class="border-b border-slate-200 pb-3">
                    <span class="text-[10px] font-black uppercase tracking-wider text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                        Bagian 5 dari 5 (Final)
                    </span>
                    <h3 class="text-base font-black text-slate-900 mt-1 flex items-center gap-2">
                        <span>📑</span> INFORMASI PENDAFTARAN & UPLOAD DOKUMEN
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Unggah berkas persyaratan dan konfirmasi pembayaran pendaftaran.</p>
                </div>

                <!-- Informasi Sumber Pendaftaran (Sesuai Scan Form F-SPMB) -->
                <div class="space-y-2">
                    <label class="block text-xs font-black text-slate-700 uppercase">Informasi Pendaftaran Diperoleh Dari Mana?</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Brosur" class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Brosur</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Banner / Spanduk" class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Banner / Spanduk</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Media Sosial" checked class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Media Sosial (IG/FB)</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Teman / Saudara" class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Teman / Saudara</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Guru / Tendik SIT Robbani" class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Guru / Tendik Robbani</span>
                        </label>
                        <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-50 border border-slate-200 cursor-pointer hover:bg-emerald-50 hover:border-emerald-300 transition-colors">
                            <input type="radio" name="info_pendaftaran" value="Lainnya" class="text-emerald-700 focus:ring-emerald-500">
                            <span class="font-bold text-slate-700">Lainnya</span>
                        </label>
                    </div>
                </div>

                <!-- Info Rekening Pembayaran Resmi -->
                <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-amber-400 block">
                        💳 Rekening Resmi Pembayaran Biaya Pendaftaran Formulir:
                    </span>
                    <div class="font-mono text-xs space-y-1.5">
                        <div class="p-2 rounded-xl bg-slate-800 flex justify-between items-center">
                            <div>
                                <span class="text-emerald-400 font-bold block">BANK SYARIAH INDONESIA (BSI)</span>
                                <span>7206858502</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-sans">a.n. YAYASAN GENERASI ROBBANI</span>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-800 flex justify-between items-center">
                            <div>
                                <span class="text-emerald-400 font-bold block">BANK MUAMALAT</span>
                                <span>3610061740</span>
                            </div>
                            <span class="text-[10px] text-slate-400 font-sans">a.n. YAYASAN GENERASI ROBBANI SUMATERA SELATAN</span>
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

                        <!-- Kartu Keluarga -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">2. Kartu Keluarga (KK)</label>
                            <input type="file" name="kartu_keluarga" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Scan / Foto Kartu Keluarga jelas.</p>
                        </div>

                        <!-- KTP Orang Tua -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">3. KTP Orang Tua (Ayah / Ibu)</label>
                            <input type="file" name="ktp_ortu" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Foto KTP Ayah / Ibu.</p>
                        </div>

                        <!-- Akta Kelahiran -->
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1.5">
                            <label class="block text-xs font-bold text-slate-800">4. Akta Kelahiran Anak</label>
                            <input type="file" name="akta_kelahiran" accept="image/png,image/jpeg,image/webp,application/pdf" class="block w-full text-xs text-slate-500 file:mr-2.5 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 cursor-pointer">
                            <p class="text-[10px] text-slate-400">Foto Akta Kelahiran.</p>
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

                <!-- Navigation & Submit -->
                <div class="pt-4 flex items-center justify-between">
                    <button type="button" onclick="goToStep(4)" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors">
                        <span>⬅ Kembali</span>
                    </button>
                    <button type="submit" id="submitBtn" class="px-8 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-emerald-700/25 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <span>✓ KIRIM PENDAFTARAN SEKARANG</span>
                    </button>
                </div>
            </div>

        </form>
    </main>

    <!-- Footer Simple -->
    <footer class="py-6 border-t border-slate-200 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} Yayasan Generasi Robbani Sumatera Selatan. SPMB Online System.</p>
    </footer>

    <!-- Form Wizard Logic -->
    <script>
        const feesBySchool = {
            'TPA': 'Rp 200.000',
            'KB': 'Rp 200.000',
            'TK': 'Rp 200.000',
            'TKIT': 'Rp 200.000',
            'SD': 'Rp 250.000',
            'SDIT': 'Rp 250.000',
            'SMP': 'Rp 300.000',
            'SMPIT': 'Rp 300.000',
            'SMA': 'Rp 350.000',
            'SMAIT': 'Rp 350.000',
        };

        function updateUnitFeeInfo() {
            const sc = document.getElementById('school_code');
            const feeDisplay = document.getElementById('selectedUnitFeeDisplay');
            if (sc && feeDisplay) {
                const val = sc.value.toUpperCase();
                feeDisplay.innerText = feesBySchool[val] || 'Rp 250.000';
            }
        }

        function goToStep(step) {
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
                    if (i === step) {
                        pill.className = "px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-active text-[11px]";
                    } else {
                        pill.className = "px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]";
                    }
                }
            }
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateUnitFeeInfo();
        });
    </script>
</body>
</html>
