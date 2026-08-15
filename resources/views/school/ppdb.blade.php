<!DOCTYPE html>
<html lang="id" class="scroll-smooth light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Formulir SPMB Online T.A 2026/2027 | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Light Mode Default (Emerald Green & Dynamic Orange with High-Contrast Dark Text) */
        html.light {
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --border-card: #e2e8f0;
            --bg-input: #ffffff;
            --border-input: #cbd5e1;
            --text-heading: #0f172a;
            --text-body: #1e293b;
            --text-muted: #64748b;
            --brand-primary: #059669;
            --brand-secondary: #ea580c;
            --badge-bg: #ffedd5;
            --badge-text: #c2410c;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
        }

        /* Dark Mode Option (Obsidian Black Green & Electric Neon Lime Palette) */
        html.dark {
            --bg-main: #040905;
            --bg-card: #0b170d;
            --border-card: #19331d;
            --bg-input: #071208;
            --border-input: #234928;
            --text-heading: #ffffff;
            --text-body: #f1f5f9;
            --text-muted: #94a3b8;
            --brand-primary: #a8f52c;
            --brand-secondary: #10b981;
            --badge-bg: #10240d;
            --badge-text: #a8f52c;
            --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }

        /* Explicit Logo Display Rules for Light / Dark mode */
        html.light .spmb-logo-light { display: block !important; }
        html.light .spmb-logo-dark { display: none !important; }
        html.dark .spmb-logo-light { display: none !important; }
        html.dark .spmb-logo-dark { display: block !important; }

        /* Guidance Cards Explicit Surface Styles for Light & Dark */
        html.light .spmb-guide-card-1 { background-color: #ecfdf5 !important; border: 1px solid #a7f3d0 !important; color: #064e3b !important; }
        html.light .spmb-guide-card-2 { background-color: #fff7ed !important; border: 1px solid #fed7aa !important; color: #7c2d12 !important; }
        html.light .spmb-guide-card-3 { background-color: #f0fdfa !important; border: 1px solid #99f6e4 !important; color: #134e4a !important; }
        html.light .spmb-guide-card-4 { background-color: #eff6ff !important; border: 1px solid #bfdbfe !important; color: #1e3a8a !important; }

        html.dark .spmb-guide-card-1,
        html.dark .spmb-guide-card-2,
        html.dark .spmb-guide-card-3,
        html.dark .spmb-guide-card-4 { 
            background-color: #0e1e12 !important; 
            border: 1px solid #1a381d !important; 
            color: #f1f5f9 !important; 
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-main); 
            color: var(--text-body); 
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .spmb-card { 
            background-color: var(--bg-card) !important; 
            border: 1px solid var(--border-card) !important; 
            box-shadow: var(--card-shadow);
        }

        .spmb-input { 
            background-color: var(--bg-input) !important; 
            border: 1px solid var(--border-input) !important; 
            color: var(--text-heading) !important; 
        }

        .step-pill-active {
            background-color: var(--brand-primary) !important;
            color: #ffffff !important;
        }
        html.dark .step-pill-active {
            color: #040905 !important;
            font-weight: 900 !important;
        }

        .step-pill-inactive {
            background-color: var(--bg-input) !important;
            color: var(--text-muted) !important;
            border: 1px solid var(--border-input) !important;
        }

        .btn-gradient-action {
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-secondary) 100%) !important;
            color: #ffffff !important;
        }
        html.dark .btn-gradient-action {
            background: #a8f52c !important;
            color: #040905 !important;
            font-weight: 900 !important;
        }

        /* Hide scrollbar for step pills horizontal scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-20 flex flex-col justify-between">

    <!-- Header Navigation Bar (Mobile Optimized Side Alignment) -->
    <header class="py-2.5 sm:py-3.5 px-3 sm:px-8 sticky top-0 z-50 border-b transition-colors shadow-xs" style="background-color: var(--bg-card); border-color: var(--border-card);">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
            
            <!-- Brand Logo Header (Dynamic Light & Dark Mode Uncropped Logos) -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                @php
                    $logoLight = $settings['logo_light'] ?? $settings['school_logo'] ?? '/images/smartedu_logo.jpg';
                    $logoDark = $settings['logo_dark'] ?? $settings['school_logo'] ?? $logoLight;
                @endphp

                <!-- Light Mode Logo -->
                <img src="{{ $logoLight }}" alt="Logo Light {{ $settings['school_name'] ?? 'SIT Robbani' }}" class="h-8 sm:h-10 w-auto max-w-[120px] sm:max-w-[200px] object-contain shrink-0 spmb-logo-light">
                
                <!-- Dark Mode Logo -->
                <img src="{{ $logoDark }}" alt="Logo Dark {{ $settings['school_name'] ?? 'SIT Robbani' }}" class="h-8 sm:h-10 w-auto max-w-[120px] sm:max-w-[200px] object-contain shrink-0 spmb-logo-dark">

                <div>
                    <h2 class="font-black text-[11px] sm:text-base tracking-tight leading-tight flex items-center gap-1" style="color: var(--text-heading);">
                        <span>PORTAL SPMB</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span>
                    </h2>
                    <p class="text-[8px] sm:text-[10px] font-bold uppercase tracking-wider" style="color: var(--text-muted);">SIT ROBBANI OGAN ILIR</p>
                </div>
            </a>

            <!-- Header Action Controls & Theme Mode Switcher -->
            <div class="flex items-center gap-1.5 shrink-0">
                <a href="{{ route('home') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-[11px] sm:text-xs hover:opacity-90 transition-all hidden sm:flex items-center gap-1">
                    <span>🌐</span> Beranda
                </a>

                <!-- Light / Dark Mode Toggle Switcher -->
                <button type="button" onclick="toggleSpmbTheme()" id="themeToggleBtn" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-2xl bg-orange-500 hover:bg-orange-600 text-white font-black text-[11px] sm:text-xs shadow-xs transition-all active:scale-95 flex items-center gap-1 shrink-0">
                    <span id="themeIcon">☀️</span>
                    <span id="themeText" class="text-[10px] sm:text-xs">Mode Terang</span>
                </button>
            </div>
        </div>
    </header>

    <main class="py-4 sm:py-8 max-w-4xl mx-auto px-3 sm:px-4 w-full space-y-4 sm:space-y-6 flex-1">
        
        <!-- Banner Title Header -->
        <div class="text-center space-y-1.5 sm:space-y-2.5">
            <span class="px-3 py-1 sm:px-4 sm:py-1.5 rounded-full font-black text-[9px] sm:text-xs uppercase tracking-wider inline-block" style="background-color: var(--badge-bg); color: var(--badge-text);">
                ✨ SELEKSI PENERIMAAN MURID BARU (SPMB T.A 2026/2027)
            </span>
            <h1 class="text-lg sm:text-3xl md:text-4xl font-black tracking-tight leading-tight" style="color: var(--text-heading);">
                Formulir Pendaftaran SPMB Online
            </h1>
            <p class="text-[11px] sm:text-sm font-medium max-w-2xl mx-auto px-1" style="color: var(--text-muted);">
                Ayo menjadi bagian dari SIT Robbani Ogan Ilir untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.
            </p>
        </div>

        <!-- Success Notification Banner / Modal -->
        @if(session('spmb_success_data'))
        @php 
            $data = session('spmb_success_data'); 
            $verifyUrl = route('school.spmb.verify', $data['registration_number']);
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($verifyUrl);
        @endphp
        <div class="p-4 sm:p-7 rounded-3xl bg-gradient-to-r from-emerald-600 via-teal-600 to-orange-600 shadow-xl text-white space-y-3.5 animate-fade-in">
            <div class="flex items-center justify-between">
                <span class="px-2.5 py-0.5 rounded-full bg-white text-emerald-950 font-black text-[9px] sm:text-xs uppercase">✓ PENDAFTARAN SPMB BERHASIL</span>
                <span class="text-[9px] sm:text-xs text-emerald-100 font-bold">{{ $data['date'] }}</span>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
                <div class="space-y-1 text-center sm:text-left">
                    <h3 class="text-sm sm:text-xl font-black text-white">Selamat, Pendaftaran Ananda {{ $data['student_name'] }} Berhasil Ditambahkan!</h3>
                    <p class="text-[11px] text-emerald-100 font-medium">Nomor Registrasi Resmi SPMB Online Anda adalah:</p>
                    <div class="pt-1">
                        <span class="px-3.5 py-1.5 sm:px-5 sm:py-2.5 rounded-2xl bg-slate-950 border border-amber-300 font-mono text-base sm:text-2xl font-black text-amber-300 inline-block shadow-inner">
                            {{ $data['registration_number'] }}
                        </span>
                    </div>
                </div>

                <!-- Live Scannable QR Code Box -->
                <div class="p-2.5 rounded-2xl bg-white text-center shadow-md shrink-0">
                    <img src="{{ $qrUrl }}" alt="QR Code Pendaftaran" class="w-20 h-20 sm:w-28 sm:h-28 mx-auto rounded-lg">
                    <a href="{{ $verifyUrl }}" target="_blank" class="text-[9px] font-bold text-emerald-800 hover:underline block mt-1">
                        Scan QR Verifikasi ↗
                    </a>
                </div>
            </div>

            <p class="text-[11px] sm:text-xs text-emerald-100 font-medium leading-relaxed">
                Panitia SPMB SIT Robbani akan mengonfirmasi jadwal tes pemetaan via WhatsApp ke nomor <strong class="text-amber-200">{{ $data['parent_phone'] }}</strong>. QR Code di atas dapat discan kapan saja untuk mengakses & mendownload ulang Bukti Registrasi PDF.
            </p>
            
            <div class="pt-1 flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                <a href="https://api.whatsapp.com/send?phone=6285377193977&text=Halo%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20sudah%20mendaftar%20dengan%20No%20Reg:%20{{ $data['registration_number'] }}" target="_blank" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-white text-emerald-900 font-black text-xs shadow-md hover:bg-slate-100 transition-all flex items-center justify-center gap-1.5">
                    <span>💬</span> Konfirmasi via WhatsApp Panitia
                </a>
                @if(isset($data['registration_id']))
                <a href="{{ route('school.spmb.download-pdf', $data['registration_id']) }}" target="_blank" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-amber-400 text-slate-950 font-black text-xs shadow-md hover:bg-amber-300 transition-all flex items-center justify-center gap-1.5">
                    <span>📄</span> Download / Cetak Bukti PDF Lengkap
                </a>
                @endif
                <a href="{{ $verifyUrl }}" target="_blank" class="w-full sm:w-auto px-4 py-2.5 rounded-xl bg-slate-900 text-lime-300 font-black text-xs shadow-md hover:bg-slate-800 transition-all flex items-center justify-center gap-1.5">
                    <span>🔍</span> Halaman Cek Status & QR ↗
                </a>
            </div>
        </div>
        @endif

        <!-- Form Guidance & Auto-Save Instruction Banner (Responsive Mobile Cards) -->
        <div class="spmb-card p-3.5 sm:p-6 rounded-3xl space-y-3 border-l-4 border-l-orange-500 shadow-sm">
            <div class="flex flex-col xs:flex-row items-start xs:items-center justify-between gap-2">
                <span class="px-2.5 py-1 rounded-full bg-orange-500/10 text-orange-700 dark:text-orange-400 font-black text-[10px] sm:text-xs uppercase">
                    📌 Petunjuk Penting Pendaftaran SPMB Online
                </span>
                <span id="unitFeeBadge" class="px-2.5 py-1 rounded-full bg-emerald-600 text-white font-mono font-black text-[10px] sm:text-xs shadow-xs self-start xs:self-auto">
                    Biaya Form SDIT: Rp 250.000
                </span>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-1 text-xs">
                <!-- Card 1 (Emerald) -->
                <div class="spmb-guide-card-1 p-3 rounded-2xl flex items-start gap-2.5 shadow-2xs">
                    <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white font-black text-[11px] flex items-center justify-center shrink-0 shadow-xs mt-0.5">📄</span>
                    <div>
                        <h4 class="font-black text-xs">1. Dokumen Resmi</h4>
                        <p class="text-[10px] sm:text-[11px] opacity-90 mt-0.5 leading-snug font-medium">Siapkan data sesuai Akta Kelahiran Ananda & Kartu Keluarga (KK) yang sah.</p>
                    </div>
                </div>

                <!-- Card 2 (Orange) -->
                <div class="spmb-guide-card-2 p-3 rounded-2xl flex items-start gap-2.5 shadow-2xs">
                    <span class="w-6 h-6 rounded-lg bg-orange-600 text-white font-black text-[11px] flex items-center justify-center shrink-0 shadow-xs mt-0.5">💾</span>
                    <div>
                        <h4 class="font-black text-xs">2. Simpan Draf Otomatis</h4>
                        <p class="text-[10px] sm:text-[11px] opacity-90 mt-0.5 leading-snug font-medium">Data tersimpan otomatis saat Anda mengetik. Isian aman walau browser tertutup.</p>
                    </div>
                </div>

                <!-- Card 3 (Teal) -->
                <div class="spmb-guide-card-3 p-3 rounded-2xl flex items-start gap-2.5 shadow-2xs">
                    <span class="w-6 h-6 rounded-lg bg-teal-600 text-white font-black text-[11px] flex items-center justify-center shrink-0 shadow-xs mt-0.5">📁</span>
                    <div>
                        <h4 class="font-black text-xs">3. Upload File Berkas</h4>
                        <p class="text-[10px] sm:text-[11px] opacity-90 mt-0.5 leading-snug font-medium">Upload Pas Foto, KTP Ortu, KK, & Bukti Transfer Pembayaran Form.</p>
                    </div>
                </div>

                <!-- Card 4 (Blue) -->
                <div class="spmb-guide-card-4 p-3 rounded-2xl flex items-start gap-2.5 shadow-2xs">
                    <span class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-[11px] flex items-center justify-center shrink-0 shadow-xs mt-0.5">🔍</span>
                    <div>
                        <h4 class="font-black text-xs">4. Pratinjau & Cetak PDF</h4>
                        <p class="text-[10px] sm:text-[11px] opacity-90 mt-0.5 leading-snug font-medium">Periksa pratinjau lengkap sebelum submit & cetak dokumen Bukti PDF.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Auto-Saved Draft Notification Bar -->
        <div id="draftNoticeBar" class="hidden p-3 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs font-bold text-amber-600 dark:text-amber-300">
            <div class="flex items-center gap-2">
                <span>⚡</span>
                <span class="text-[11px]">Draft pendaftaran sebelumnya berhasil dipulihkan secara otomatis.</span>
            </div>
            <button type="button" onclick="clearSpmbDraft()" class="px-2.5 py-1 rounded-xl bg-amber-500 text-slate-950 font-black hover:opacity-90 transition-all text-[11px] shrink-0 self-end sm:self-auto">
                Hapus Draft
            </button>
        </div>

        <!-- Stepper Wizard Progress Bar Header -->
        <div class="spmb-card p-3.5 sm:p-6 rounded-3xl space-y-3">
            <div class="flex flex-col xs:flex-row xs:items-center justify-between gap-1 text-[11px] sm:text-xs font-black" style="color: var(--text-heading);">
                <span id="stepTitleText" class="tracking-tight">LANGKAH 1 DARI 5: PILIHAN JENJANG & JALUR</span>
                <span id="stepPercentText" class="text-emerald-600 dark:text-lime-400 shrink-0 font-extrabold self-end xs:self-auto">20% SELESAI</span>
            </div>

            <!-- Progress Bar Bar -->
            <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-2 overflow-hidden">
                <div id="progressBarFill" class="h-2 rounded-full transition-all duration-500" style="width: 20%; background-color: var(--brand-primary);"></div>
            </div>

            <!-- Step Pills Navigation Bar (Scrollable on Mobile) -->
            <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pt-1 pb-0.5 text-xs font-black">
                <button type="button" onclick="goToStep(1)" id="pill-step-1" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-active text-[11px]">
                    1. Jenjang
                </button>
                <button type="button" onclick="goToStep(2)" id="pill-step-2" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    2. Siswa
                </button>
                <button type="button" onclick="goToStep(3)" id="pill-step-3" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    3. Ortu
                </button>
                <button type="button" onclick="goToStep(4)" id="pill-step-4" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    4. Domisili
                </button>
                <button type="button" onclick="goToStep(5)" id="pill-step-5" class="px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]">
                    5. Finish
                </button>
            </div>
        </div>

        <!-- Main Standard SPMB Form Wizard -->
        <form id="spmbForm" action="{{ route('school.ppdb.store') }}" method="POST" enctype="multipart/form-data" class="p-3.5 sm:p-10 rounded-3xl spmb-card space-y-5 sm:space-y-8">
            @csrf
            
            <!-- STEP 1: Pilihan Jenjang & Jalur -->
            <div id="step-section-1" class="step-section space-y-4">
                <div class="border-b pb-2.5 border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs sm:text-base font-black flex items-center gap-1.5" style="color: var(--text-heading);">
                        <span>🏫</span> STEP 1: Pilihan Jenjang Unit Sekolah & Jalur SPMB *
                    </h3>
                    <p class="text-[11px] sm:text-xs font-medium mt-0.5" style="color: var(--text-muted);">Pilih unit tujuan pendaftaran dan jalur penerimaan peserta didik baru.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Unit Sekolah Tujuan *</label>
                        <select name="school_code" id="school_code" onchange="updateUnitFeeInfo()" required class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            @foreach($schools as $sc)
                            <option value="{{ strtolower($sc->code) }}">🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Jalur SPMB *</label>
                        <select name="jalur_pendaftaran" id="jalur_pendaftaran" required class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="REGULER">Jalur Reguler (Umum)</option>
                            <option value="PRESTASI">Jalur Prestasi Akademik / Non-Akademik</option>
                            <option value="TAHFIDZ">Jalur Beasiswa Tahfidz Al-Qur'an</option>
                            <option value="PINDAHAN">Jalur Pindahan / Mutasi</option>
                        </select>
                    </div>
                </div>

                <!-- Fee Info Banner per Unit (Light / Dark Mode Clean Styling) -->
                <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-slate-900 border border-emerald-200 dark:border-slate-800 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-sm">💳</span>
                        <span class="font-bold text-slate-800 dark:text-slate-200 text-[11px] sm:text-xs">Biaya Formulir Unit Selected:</span>
                    </div>
                    <span id="selectedUnitFeeDisplay" class="font-mono font-black text-emerald-700 dark:text-lime-400 text-xs sm:text-sm">
                        Rp 250.000
                    </span>
                </div>

                <div class="pt-3 flex justify-end">
                    <button type="button" onclick="goToStep(2)" class="w-full sm:w-auto px-6 py-3 rounded-2xl btn-gradient-action font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>Lanjut ke Data Siswa</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Data Calon Siswa (Ananda) & Strict Format Enforcement -->
            <div id="step-section-2" class="step-section space-y-4 hidden">
                <div class="border-b pb-2.5 border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs sm:text-base font-black flex items-center gap-1.5" style="color: var(--text-heading);">
                        <span>🎓</span> STEP 2: Data Calon Siswa (Ananda) & Integrasi Akun Wali
                    </h3>
                    <p class="text-[11px] sm:text-xs font-medium mt-0.5" style="color: var(--text-muted);">Isikan identitas lengkap calon siswa. Kolom nama khusus huruf, NIK/NISN khusus angka.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Nama Lengkap Ananda (Khusus Huruf Sesuai Akta) *</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" required placeholder="Contoh: Fathan Al-Ghazali" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <p class="text-[10px] text-slate-400">Hanya menerima karakter huruf dan spasi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">NIK Siswa (Wajib 16 Digit Angka KK)</label>
                        <input type="text" name="nik_siswa" id="nik_siswa" maxlength="16" placeholder="16 Digit Angka NIK dari KK" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] text-slate-400">Khusus angka 0-9 (Maksimal 16 Digit).</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">NISN Siswa (Khusus Angka)</label>
                        <input type="text" name="nisn" id="nisn" maxlength="12" placeholder="10-12 Digit Angka NISN" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <p class="text-[10px] text-slate-400">Khusus angka 0-9.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Tempat Lahir (Khusus Huruf) *</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" required placeholder="Kota lahir ananda" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" required class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Sekolah Asal (TK / SD / SMP)</label>
                        <input type="text" name="sekolah_asal" id="sekolah_asal" placeholder="Contoh: TKIT Robbani" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Anak Ke- (Angka)</label>
                        <input type="number" name="anak_ke" id="anak_ke" value="1" min="1" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Jumlah Saudara (Angka)</label>
                        <input type="number" name="jumlah_saudara" id="jumlah_saudara" value="2" min="0" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Existing Sibling Integration Field -->
                <div class="p-3.5 sm:p-5 rounded-2xl bg-purple-50/80 dark:bg-slate-900/90 border border-purple-200 dark:border-slate-800 space-y-2.5">
                    <div class="flex items-center gap-1.5">
                        <span class="text-sm">👨‍👩‍👧‍👦</span>
                        <h4 class="font-black text-xs text-purple-950 dark:text-purple-300 uppercase">Integrasi Akun Wali: Saudara Kandung di SIT Robbani</h4>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-700 dark:text-slate-300">Memiliki Saudara Kandung Bersekolah di SIT Robbani?</label>
                            <select name="has_sibling" id="has_sibling" onchange="toggleSiblingInput()" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                                <option value="TIDAK">Tidak (Pendaftaran Anak Pertama / Baru)</option>
                                <option value="YA">Ya (Sudah Ada Kakak / Adik di Robbani)</option>
                            </select>
                        </div>

                        <div id="siblingInputContainer" class="hidden space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-700 dark:text-slate-300">NIS / Nama Saudara Kandung di Robbani *</label>
                            <input type="text" name="sibling_info" id="sibling_info" placeholder="Contoh: 20260001 - Fathan Al-Ghazali (SDIT)" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                    </div>
                    <p class="text-[10px] sm:text-[11px] text-purple-900 dark:text-purple-200 leading-snug font-medium">
                        💡 <strong>Fungsi Integrasi Wali:</strong> Mengisi data saudara ini akan otomatis menghubungkan pendaftaran ananda baru ke <strong>Portal / Aplikasi Wali Murid (Parent Portal)</strong> yang sama, sehingga Ayah/Ibu dapat memantau seluruh anak dari 1 Akun Wali Murid.
                    </p>
                </div>

                <div class="pt-3 flex flex-col-reverse sm:flex-row items-center justify-between gap-2.5">
                    <button type="button" onclick="goToStep(1)" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        ⬅ Kembali
                    </button>
                    <button type="button" onclick="goToStep(3)" class="w-full sm:w-auto px-6 py-3 rounded-2xl btn-gradient-action font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>Lanjut ke Data Orang Tua</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- STEP 3: Data Orang Tua Kandung & Strict Format Controls -->
            <div id="step-section-3" class="step-section space-y-4 hidden">
                <div class="border-b pb-2.5 border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs sm:text-base font-black flex items-center gap-1.5" style="color: var(--text-heading);">
                        <span>👨‍👩‍👦</span> STEP 3: Data Orang Tua Kandung (Ayah & Ibu)
                    </h3>
                    <p class="text-[11px] sm:text-xs font-medium mt-0.5" style="color: var(--text-muted);">Nama wajib huruf, Nomor WhatsApp wajib angka 10-15 digit, Email wajib format email valid.</p>
                </div>

                <!-- Data Ayah Card (High Contrast Light Mode Surface) -->
                <div class="p-3.5 sm:p-5 rounded-2xl bg-emerald-50 dark:bg-slate-900/90 border border-emerald-200 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-black text-emerald-900 dark:text-lime-300 block uppercase flex items-center gap-1.5">
                        <span>👨</span> Data Ayah Kandung
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Nama Lengkap Ayah (Khusus Huruf) *</label>
                            <input type="text" name="nama_ayah" id="nama_ayah" required placeholder="Nama sesuai KTP" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">No. WhatsApp Ayah (Khusus Angka) *</label>
                            <input type="text" name="no_hp_ayah" id="no_hp_ayah" maxlength="15" required placeholder="081234567890" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-mono font-bold text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Email Aktif Ortu (Format Email) *</label>
                            <input type="email" name="email_ortu" id="email_ortu" required placeholder="nama@gmail.com" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Pekerjaan Ayah (Khusus Huruf)</label>
                            <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" placeholder="Contoh: PNS / Wiraswasta" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Pendidikan Terakhir</label>
                            <select name="pendidikan_ayah" id="pendidikan_ayah" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                                <option value="S1">S1 / Sarjana</option>
                                <option value="S2">S2 / Magister</option>
                                <option value="S3">S3 / Doktor</option>
                                <option value="SMA">SMA / Sederajat</option>
                                <option value="D3">D3 / Diploma</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Penghasilan Bulanan</label>
                            <select name="penghasilan_ayah" id="penghasilan_ayah" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                                <option value="Rp 3.000.000 - Rp 5.000.000">Rp 3.000.000 - Rp 5.000.000</option>
                                <option value="Rp 5.000.000 - Rp 10.000.000">Rp 5.000.000 - Rp 10.000.000</option>
                                <option value="> Rp 10.000.000">> Rp 10.000.000</option>
                                <option value="< Rp 3.000.000">< Rp 3.000.000</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Data Ibu Card (High Contrast Light Mode Surface) -->
                <div class="p-3.5 sm:p-5 rounded-2xl bg-orange-50 dark:bg-slate-900/90 border border-orange-200 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-black text-orange-900 dark:text-amber-300 block uppercase flex items-center gap-1.5">
                        <span>👩</span> Data Ibu Kandung
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Nama Lengkap Ibu (Khusus Huruf)</label>
                            <input type="text" name="nama_ibu" id="nama_ibu" placeholder="Nama ibu sesuai KTP" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">No. WhatsApp Ibu (Khusus Angka)</label>
                            <input type="text" name="no_hp_ibu" id="no_hp_ibu" maxlength="15" placeholder="081398765432" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-mono font-bold text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Pekerjaan Ibu (Khusus Huruf)</label>
                            <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" placeholder="Contoh: Ibu Rumah Tangga / Guru" oninput="this.value = this.value.replace(/[^a-zA-Z\s\.\,\'\-]/g, '')" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">Pendidikan Terakhir Ibu</label>
                            <select name="pendidikan_ibu" id="pendidikan_ibu" class="w-full px-3 py-2 sm:py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                                <option value="S1">S1 / Sarjana</option>
                                <option value="SMA">SMA / Sederajat</option>
                                <option value="D3">D3 / Diploma</option>
                                <option value="S2">S2 / Magister</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="pt-3 flex flex-col-reverse sm:flex-row items-center justify-between gap-2.5">
                    <button type="button" onclick="goToStep(2)" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        ⬅ Kembali
                    </button>
                    <button type="button" onclick="goToStep(4)" class="w-full sm:w-auto px-6 py-3 rounded-2xl btn-gradient-action font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>Lanjut ke Data Domisili & Berkas</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- STEP 4: Data Domisili & Upload Berkas Dokumen -->
            <div id="step-section-4" class="step-section space-y-4 hidden">
                <div class="border-b pb-2.5 border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs sm:text-base font-black flex items-center gap-1.5" style="color: var(--text-heading);">
                        <span>🏡</span> STEP 4: Alamat Domisili & Upload File Berkas Dokumen
                    </h3>
                    <p class="text-[11px] sm:text-xs font-medium mt-0.5" style="color: var(--text-muted);">Alamat tinggal dan berkas persyaratan pendaftaran calon siswa baru.</p>
                </div>

                <div class="space-y-1">
                    <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Alamat Lengkap (Jalan, RT/RW, Dusun) *</label>
                    <textarea name="alamat" id="alamat" rows="2" required placeholder="Contoh: Jln. Lintas Palembang-Indralaya KM 35, RT 02 RW 01" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Desa / Kelurahan</label>
                        <input type="text" name="kelurahan" id="kelurahan" placeholder="Kelurahan Timbangan" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" value="Indralaya Utara" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-[11px] sm:text-xs font-black uppercase" style="color: var(--text-body);">Kabupaten / Kota</label>
                        <input type="text" name="kabupaten" id="kabupaten" value="Ogan Ilir" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s\.\,\'\-]/g, '')" class="w-full px-3.5 py-2.5 sm:py-3 rounded-2xl spmb-input text-xs font-bold">
                    </div>
                </div>

                <!-- File Upload Section -->
                <div class="p-3.5 sm:p-5 rounded-2xl bg-teal-50 dark:bg-slate-900/90 border border-teal-200 dark:border-slate-800 space-y-3">
                    <span class="text-xs font-black text-teal-900 dark:text-teal-300 block uppercase flex items-center gap-1.5">
                        <span>📁</span> Upload File Berkas Syarat SPMB (Opsional / Dapat Menyusul)
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">📸 Pas Foto Ananda (JPG/PNG)</label>
                            <input type="file" name="pas_foto" id="pas_foto" accept="image/*" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">🪪 KTP Orang Tua (JPG/PDF)</label>
                            <input type="file" name="ktp_ortu" id="ktp_ortu" accept="image/*,.pdf" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">📜 Kartu Keluarga / KK (JPG/PDF)</label>
                            <input type="file" name="kartu_keluarga" id="kartu_keluarga" accept="image/*,.pdf" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-[10px] sm:text-[11px] font-black uppercase text-slate-800 dark:text-slate-200">💳 Bukti Transfer Form (<span id="fileFeeNotice">Rp 250.000</span>)</label>
                            <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*,.pdf" class="w-full px-3 py-2 rounded-xl bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 text-xs font-medium">
                        </div>
                    </div>
                </div>

                <div class="pt-3 flex flex-col-reverse sm:flex-row items-center justify-between gap-2.5">
                    <button type="button" onclick="goToStep(3)" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        ⬅ Kembali
                    </button>
                    <button type="button" onclick="goToStep(5)" class="w-full sm:w-auto px-6 py-3 rounded-2xl btn-gradient-action font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>Lanjut ke Pratinjau Final</span> <span>➔</span>
                    </button>
                </div>
            </div>

            <!-- STEP 5: Konfirmasi Pratinjau Ringkasan & Submit -->
            <div id="step-section-5" class="step-section space-y-4 hidden">
                <div class="border-b pb-2.5 border-slate-200 dark:border-slate-800">
                    <h3 class="text-xs sm:text-base font-black flex items-center gap-1.5" style="color: var(--text-heading);">
                        <span>📋</span> STEP 5: Pratinjau Seluruh Isian Data Pendaftaran SPMB
                    </h3>
                    <p class="text-[11px] sm:text-xs font-medium mt-0.5" style="color: var(--text-muted);">Periksa kembali ringkasan seluruh data yang telah diisikan sebelum mengirim formulir secara resmi.</p>
                </div>

                <!-- Full Comprehensive Summary Card Grid -->
                <div class="p-3.5 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 text-xs shadow-sm">
                    <h4 class="font-black text-xs uppercase text-emerald-700 dark:text-lime-400 border-b pb-2 border-slate-200 dark:border-slate-800 flex items-center gap-1.5">
                        <span>🔍</span> Summary Ringkasan Formulir SPMB
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="space-y-1 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <span class="font-black text-[10px] uppercase text-orange-600 dark:text-orange-400 block">🏫 Unit & Biaya Form</span>
                            <p class="font-bold text-slate-800 dark:text-white">Unit Sekolah: <span id="sum-unit" class="text-emerald-700 dark:text-lime-400 font-black">-</span></p>
                            <p class="font-bold text-slate-800 dark:text-white">Jalur SPMB: <span id="sum-jalur" class="font-black">-</span></p>
                            <p class="font-bold text-slate-800 dark:text-white">Biaya Pendaftaran: <span id="sum-biaya" class="font-mono text-emerald-700 dark:text-lime-400 font-black">-</span></p>
                        </div>
                        
                        <div class="space-y-1 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <span class="font-black text-[10px] uppercase text-emerald-700 dark:text-lime-400 block">🎓 Calon Siswa & Saudara</span>
                            <p class="font-bold text-slate-800 dark:text-white">Nama Akta: <span id="sum-nama" class="font-black">-</span></p>
                            <p class="font-medium text-slate-600 dark:text-slate-300">NIK / NISN: <span id="sum-nik">-</span></p>
                            <p class="font-medium text-slate-600 dark:text-slate-300">TTL / JK: <span id="sum-ttl">-</span></p>
                            <p class="font-medium text-slate-600 dark:text-slate-300">Saudara di Robbani: <span id="sum-saudara" class="font-bold text-purple-700 dark:text-purple-400">-</span></p>
                        </div>

                        <div class="space-y-1 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <span class="font-black text-[10px] uppercase text-blue-600 dark:text-blue-400 block">👨‍👩‍JB Data Orang Tua</span>
                            <p class="font-bold text-slate-800 dark:text-white">Ayah Kandung: <span id="sum-ayah" class="font-black">-</span> (WA: <span id="sum-wa-ayah">-</span>)</p>
                            <p class="font-bold text-slate-800 dark:text-white">Ibu Kandung: <span id="sum-ibu" class="font-black">-</span></p>
                            <p class="font-medium text-slate-600 dark:text-slate-300">Email Ortu: <span id="sum-email">-</span></p>
                        </div>

                        <div class="space-y-1 p-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                            <span class="font-black text-[10px] uppercase text-teal-600 dark:text-teal-400 block">🏡 Domisili & Lampiran Berkas</span>
                            <p class="font-medium text-slate-600 dark:text-slate-300">Alamat: <span id="sum-alamat">-</span></p>
                            <p class="font-medium text-slate-600 dark:text-slate-300">Status Berkas: <span id="sum-berkas" class="font-bold text-emerald-700 dark:text-lime-400">Siap Ditinjau Panitia</span></p>
                        </div>
                    </div>
                </div>

                <div class="pt-3 flex flex-col-reverse sm:flex-row items-center justify-between gap-2.5">
                    <button type="button" onclick="goToStep(4)" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        ⬅ Kembali Edit Data
                    </button>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-2xl btn-gradient-action font-black text-xs uppercase tracking-wider shadow-2xl hover:opacity-95 transition-transform active:scale-95 flex items-center justify-center gap-2">
                        <span>Submit Formulir SPMB Online</span>
                        <span>➔</span>
                    </button>
                </div>
            </div>
        </form>

    </main>

    <!-- Footer -->
    <footer class="py-5 sm:py-8 text-center text-[11px] sm:text-xs font-semibold border-t transition-colors px-3" style="background-color: var(--bg-card); border-color: var(--border-card); color: var(--text-muted);">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

    <!-- Interactive Stepper & Auto-Save LocalStorage Script -->
    <script>
        let currentStep = 1;

        const unitFees = {
            'tkit': 'Rp 200.000',
            'sdit': 'Rp 250.000',
            'smpit': 'Rp 300.000',
            'smait': 'Rp 350.000'
        };

        function updateUnitFeeInfo() {
            const unit = (document.getElementById('school_code').value || 'sdit').toLowerCase();
            const fee = unitFees[unit] || 'Rp 250.000';
            const unitName = unit.toUpperCase();

            document.getElementById('unitFeeBadge').innerText = `Biaya Form ${unitName}: ${fee}`;
            document.getElementById('selectedUnitFeeDisplay').innerText = fee;
            document.getElementById('fileFeeNotice').innerText = fee;
        }

        function toggleSiblingInput() {
            const val = document.getElementById('has_sibling').value;
            const container = document.getElementById('siblingInputContainer');
            if (val === 'YA') {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function goToStep(stepNum) {
            // Validate basic required fields on current step before advancing
            if (stepNum > currentStep) {
                if (currentStep === 1) {
                    const unit = document.getElementById('school_code').value;
                    if (!unit) return alert('Silakan pilih unit sekolah terlebih dahulu.');
                } else if (currentStep === 2) {
                    const nama = document.getElementById('nama_lengkap').value;
                    if (!nama || nama.trim().length < 3) return alert('Silakan isi nama lengkap ananda dengan benar (huruf saja, minimal 3 karakter).');
                    
                    const nik = document.getElementById('nik_siswa').value;
                    if (nik && nik.length !== 16) return alert('NIK Siswa harus terdiri dari 16 digit angka (sesuai Kartu Keluarga).');
                } else if (currentStep === 3) {
                    const ayah = document.getElementById('nama_ayah').value;
                    const wa = document.getElementById('no_hp_ayah').value;
                    const email = document.getElementById('email_ortu').value;
                    if (!ayah || ayah.trim().length < 3) return alert('Silakan isi nama ayah dengan benar (khusus huruf).');
                    if (!wa || wa.length < 10) return alert('Silakan isi nomor WhatsApp ayah dengan benar (10-15 digit angka).');
                    if (!email || !email.includes('@')) return alert('Silakan masukkan format alamat email ortu yang valid.');
                }
            }

            // Hide all step sections
            document.querySelectorAll('.step-section').forEach(sec => sec.classList.add('hidden'));
            document.getElementById('step-section-' + stepNum).classList.remove('hidden');

            // Update step pills
            for (let i = 1; i <= 5; i++) {
                const pill = document.getElementById('pill-step-' + i);
                if (pill) {
                    if (i === stepNum) {
                        pill.className = 'px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-active text-[11px]';
                    } else {
                        pill.className = 'px-3 py-1.5 rounded-xl text-center transition-all shrink-0 step-pill-inactive text-[11px]';
                    }
                }
            }

            // Update step progress percentage
            const pct = stepNum * 20;
            document.getElementById('progressBarFill').style.width = pct + '%';
            document.getElementById('stepPercentText').innerText = pct + '% SELESAI';

            const titles = [
                'LANGKAH 1 DARI 5: PILIHAN JENJANG & JALUR',
                'LANGKAH 2 DARI 5: DATA CALON SISWA (ANANDA)',
                'LANGKAH 3 DARI 5: DATA ORANG TUA KANDUNG',
                'LANGKAH 4 DARI 5: DOMISILI & UPLOAD BERKAS',
                'LANGKAH 5 DARI 5: PRATINJAU RINGKASAN FINAL & SUBMIT'
            ];
            document.getElementById('stepTitleText').innerText = titles[stepNum - 1];

            // Update full preview on step 5
            if (stepNum === 5) {
                const unitCode = (document.getElementById('school_code').value || 'sdit').toLowerCase();
                const feeText = unitFees[unitCode] || 'Rp 250.000';
                
                document.getElementById('sum-unit').innerText = unitCode.toUpperCase();
                document.getElementById('sum-jalur').innerText = document.getElementById('jalur_pendaftaran').value || 'REGULER';
                document.getElementById('sum-biaya').innerText = feeText;
                document.getElementById('sum-nama').innerText = document.getElementById('nama_lengkap').value || '-';
                document.getElementById('sum-nik').innerText = (document.getElementById('nik_siswa').value || '-') + ' / ' + (document.getElementById('nisn').value || '-');
                document.getElementById('sum-ttl').innerText = (document.getElementById('tempat_lahir').value || '-') + ', ' + (document.getElementById('tanggal_lahir').value || '-') + ' (' + (document.getElementById('jenis_kelamin').value || '-') + ')';
                
                const siblingVal = document.getElementById('has_sibling').value;
                if (siblingVal === 'YA') {
                    document.getElementById('sum-saudara').innerText = document.getElementById('sibling_info').value || 'Ada Saudara di Robbani';
                } else {
                    document.getElementById('sum-saudara').innerText = 'Tidak Ada (Pendaftaran Baru)';
                }

                document.getElementById('sum-ayah').innerText = document.getElementById('nama_ayah').value || '-';
                document.getElementById('sum-wa-ayah').innerText = document.getElementById('no_hp_ayah').value || '-';
                document.getElementById('sum-ibu').innerText = document.getElementById('nama_ibu').value || '-';
                document.getElementById('sum-email').innerText = document.getElementById('email_ortu').value || '-';
                document.getElementById('sum-alamat').innerText = document.getElementById('alamat').value || '-';
            }

            currentStep = stepNum;
            window.scrollTo({ top: 120, behavior: 'smooth' });
        }

        // Auto-Save Draft to LocalStorage
        function saveSpmbDraft() {
            const form = document.getElementById('spmbForm');
            const formData = new FormData(form);
            const dataObj = {};
            formData.forEach((value, key) => {
                if (key !== '_token' && !(value instanceof File)) dataObj[key] = value;
            });
            localStorage.setItem('spmb_auto_draft_v7', JSON.stringify(dataObj));
        }

        function restoreSpmbDraft() {
            const draftStr = localStorage.getItem('spmb_auto_draft_v7');
            if (draftStr) {
                try {
                    const dataObj = JSON.parse(draftStr);
                    let restoredCount = 0;
                    Object.keys(dataObj).forEach(key => {
                        const el = document.getElementById(key);
                        if (el && dataObj[key] && el.type !== 'file') {
                            el.value = dataObj[key];
                            restoredCount++;
                        }
                    });
                    if (restoredCount > 0) {
                        const notice = document.getElementById('draftNoticeBar');
                        if (notice) notice.classList.remove('hidden');
                        toggleSiblingInput();
                        updateUnitFeeInfo();
                    }
                } catch(e) {}
            }
        }

        function clearSpmbDraft() {
            localStorage.removeItem('spmb_auto_draft_v7');
            const notice = document.getElementById('draftNoticeBar');
            if (notice) notice.classList.add('hidden');
        }

        // Theme Switcher (Default: Light Mode)
        function toggleSpmbTheme() {
            const html = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');
            
            if (html.classList.contains('light')) {
                html.classList.remove('light');
                html.classList.add('dark');
                localStorage.setItem('spmb_theme_preference', 'dark');
                if (themeIcon) themeIcon.innerText = '🌙';
                if (themeText) themeText.innerText = 'Mode Gelap';
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                localStorage.setItem('spmb_theme_preference', 'light');
                if (themeIcon) themeIcon.innerText = '☀️';
                if (themeText) themeText.innerText = 'Mode Terang';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // Restore theme preference or default to light
            const savedTheme = localStorage.getItem('spmb_theme_preference') || 'light';
            const html = document.documentElement;
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');

            if (savedTheme === 'dark') {
                html.classList.remove('light');
                html.classList.add('dark');
                if (themeIcon) themeIcon.innerText = '🌙';
                if (themeText) themeText.innerText = 'Mode Gelap';
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                if (themeIcon) themeIcon.innerText = '☀️';
                if (themeText) themeText.innerText = 'Mode Terang';
            }

            // Restore draft data
            restoreSpmbDraft();
            updateUnitFeeInfo();

            // Auto save on input change
            const form = document.getElementById('spmbForm');
            if (form) {
                form.addEventListener('input', saveSpmbDraft);
                form.addEventListener('change', saveSpmbDraft);
                form.addEventListener('submit', () => {
                    localStorage.removeItem('spmb_auto_draft_v7');
                });
            }
        });
    </script>
</body>
</html>
