<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>SPMB SIT Robbani Ogan Ilir T.A 2026/2027 | Sistem Penerimaan Murid Baru</title>
    <meta name="description" content="Official Portal Sistem Penerimaan Murid Baru (SPMB / PPDB) Sekolah Islam Terpadu Robbani Ogan Ilir T.A 2026/2027. Jenjang TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT.">
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=12">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=12">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=12">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="SPMB Online 2026/2027 - Sekolah Islam Terpadu Robbani Ogan Ilir">
    <meta property="og:description" content="Penerimaan Murid Baru SIT Robbani Ogan Ilir T.A 2026/2027. Sekolah Berbasis Digital Pertama dengan Pendidikan Karakter di Ogan Ilir.">
    <meta property="og:image" content="{{ asset('images/logo robbani light.png') }}">
    <meta name="theme-color" content="#047857">

    <!-- Fonts & Scripts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            -webkit-tap-highlight-color: transparent;
        }

        /* Smooth Fade-Up Animation */
        .fade-up {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-up.in-view {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        .delay-1 { transition-delay: 100ms; }
        .delay-2 { transition-delay: 200ms; }
        .delay-3 { transition-delay: 300ms; }

        /* Responsive button with guaranteed no-clipping */
        .btn-responsive {
            white-space: normal;
            word-break: break-word;
            line-height: 1.25;
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        /* Card Hover Effect */
        .unit-card {
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .unit-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 35px -10px rgba(15, 23, 42, 0.12);
        }

        /* Hero Background with Islamic Arch & Modern Texture */
        .hero-bg {
            background-color: #064e3b;
            background-image: 
                radial-gradient(rgba(16, 185, 129, 0.22) 1.5px, transparent 1.5px),
                radial-gradient(rgba(245, 158, 11, 0.12) 1.5px, #033d2e 1.5px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }
    </style>
</head>
<body class="antialiased pb-20 sm:pb-0" x-data="spmbLandingApp()">

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-emerald-950 text-emerald-200 text-xs py-1.5 px-4 border-b border-emerald-900/60">
        <div class="max-w-6xl mx-auto flex items-center justify-between text-xs">
            <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase tracking-wide">
                    Gelombang 1
                </span>
                <span class="hidden sm:inline font-bold text-xs text-white">
                    12 Sept – 31 Des 2026
                </span>
            </div>
            <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani" target="_blank" class="text-[11px] sm:text-xs font-bold text-emerald-300 hover:text-white transition-colors">
                WA: 0811-747-472
            </a>
        </div>
    </div>

    <!-- 2. HEADER NAVIGASI (SIMPLE & RAPI, TIDAK TERPOTONG) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14 sm:h-16">
                <!-- Brand / Logo -->
                <a href="{{ route('school.spmb') }}" class="flex items-center gap-2.5 shrink-0">
                    <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 sm:h-10 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                    <span class="font-black text-sm sm:text-base tracking-tight text-emerald-950 uppercase">SPMB ROBBANI</span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                    <a href="#daftar" class="hover:text-emerald-700 transition-colors">Pilihan Unit</a>
                    <a href="#langkah" class="hover:text-emerald-700 transition-colors">Cara Daftar</a>
                    <a href="#program" class="hover:text-emerald-700 transition-colors">Program</a>
                    <a href="#syarat-biaya" class="hover:text-emerald-700 transition-colors">Syarat Berkas</a>
                    <a href="#cek-status" class="hover:text-emerald-700 transition-colors">Cek Status</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="#cek-status" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        <span>Cek Status</span>
                    </a>
                    <a href="#daftar" class="px-4 py-2 text-xs font-black text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-sm transition-all shrink-0 whitespace-nowrap">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. HERO UTAMA (DENGAN ILUSTRASI MASCOT SISWA ROBBANI SEPERTI WEB LAMA) -->
    <section class="relative hero-bg text-white pt-8 pb-14 sm:pt-16 sm:pb-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Teks Hero -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-800/90 border border-emerald-600/60 text-emerald-200 text-xs font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>SPMB Online SIT Robbani T.A. 2026/2027</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                        Sekolah Berbasis Digital Pertama dengan Pendidikan Karakter di Ogan Ilir
                    </h1>

                    <p class="text-xs sm:text-base text-emerald-100/95 font-medium leading-relaxed max-w-xl mx-auto lg:mx-0">
                        "Mewujudkan Generasi Cerdas dan Berakhlak Mulia di Era Digital". Pendaftaran mudah dari HP Anda, tanpa repot antre panjang.
                    </p>

                    <!-- Tombol Aksi Hero (Teks Singkat, Bebas Terpotong) -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                        <a href="#daftar" class="btn-responsive w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5">
                            <span>👉 Pilih Unit Sekolah</span>
                        </a>
                        <a href="#cek-status" class="btn-responsive w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-emerald-800/90 hover:bg-emerald-800 text-white border border-emerald-600/70 font-bold text-sm transition-all">
                            <span>🔍 Cek Status Pendaftaran</span>
                        </a>
                    </div>

                    <!-- 3 Poin Kemudahan -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-2.5 text-[11px] font-bold text-emerald-200">
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">✓ Bisa Daftar dari HP</span>
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">✓ Berkas Cukup Difoto</span>
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">✓ Bantuan Panitia 24 Jam</span>
                    </div>
                </div>

                <!-- Ilustrasi Santri / Mascot (Dari Web Lama) -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end fade-up delay-1">
                    <div class="relative">
                        <div class="w-64 h-64 sm:w-80 sm:h-80 rounded-full bg-gradient-to-tr from-emerald-500/20 to-amber-400/20 blur-2xl absolute inset-0 m-auto pointer-events-none"></div>
                        <img 
                            src="{{ asset('images/spmb/hero-kid.webp') }}" 
                            alt="Siswa SIT Robbani" 
                            class="relative z-10 w-60 sm:w-72 md:w-80 h-auto object-contain mx-auto filter drop-shadow-2xl transform hover:scale-105 transition-transform duration-500"
                            onerror="this.src='{{ asset('images/logo robbani light.png') }}'"
                        >
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. SECTION: PILIHAN UNIT SEKOLAH (KONSEP DENGAN ILUSTRASI, ICON, & FOTO SEPERTI WEB LAMA) -->
    <section id="daftar" class="py-14 sm:py-20 bg-slate-100/70 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
            
            <!-- Judul Section Sesuai Web Lama -->
            <div class="text-center space-y-2 fade-up">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Silahkan Pilih Salah Satu
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Tujuan Pendaftaran Unit Sekolah
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto font-medium">
                    Klik tombol "Daftar Sekarang" pada unit pendidikan yang dituju untuk langsung mengisi formulir resmi:
                </p>
            </div>

            <!-- Grid Kartu Unit dengan Ilustrasi Karakter Asli -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- 1. TPA ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-1">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-purple-100 text-purple-900 uppercase">
                                Usia 0 – 3 Tahun
                            </span>
                            <span class="text-xs font-bold text-slate-400">Taman Asuh Anak</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">TPA ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Jl. Sarjana, Blok C No. 17, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi Karakter TPA Asli -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-purple-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/tpa.webp') }}" alt="TPA Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'TPA']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

                <!-- 2. KB ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-2">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-pink-100 text-pink-900 uppercase">
                                Usia 3 – 4 Tahun
                            </span>
                            <span class="text-xs font-bold text-slate-400">Kelompok Bermain</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">KB ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Jl. Sarjana Blok C No. 14, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi Karakter KB Asli -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-pink-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/kb.webp') }}" alt="KB Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'KB']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

                <!-- 3. TKIT ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-3">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-amber-100 text-amber-900 uppercase">
                                Usia 4 – 6 Tahun
                            </span>
                            <span class="text-xs font-bold text-slate-400">Taman Kanak-Kanak IT</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">TKIT ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Jl. Sarjana Blok C No. 14, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi Karakter TK Asli -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-amber-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/tk.webp') }}" alt="TKIT Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'TKIT']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

                <!-- 4. SDIT ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-1">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-900 uppercase">
                                Usia Min. 6 Tahun
                            </span>
                            <span class="text-xs font-bold text-slate-400">Sekolah Dasar IT</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">SDIT ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Jl. Sarjana Blok A, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi Karakter SD Asli (Dari Web Lama) -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-emerald-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/sd.webp') }}" alt="SDIT Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'SDIT']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

                <!-- 5. SMPIT ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-2">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-cyan-100 text-cyan-900 uppercase">
                                Lulusan SD / MI
                            </span>
                            <span class="text-xs font-bold text-slate-400">SMP Islam Terpadu</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">SMPIT ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Jl. Sarjana Padang Guci, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi Karakter SMP Asli (Dari Web Lama) -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-cyan-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/smp.png') }}" alt="SMPIT Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'SMPIT']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

                <!-- 6. SMAIT ROBBANI -->
                <div class="unit-card bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-5 fade-up delay-3">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-black bg-indigo-100 text-indigo-900 uppercase">
                                Lulusan SMP / MTs
                            </span>
                            <span class="text-xs font-bold text-slate-400">SMA Islam Terpadu</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 tracking-tight">SMAIT ROBBANI</h3>
                        
                        <p class="text-xs text-slate-500 leading-relaxed flex items-start gap-1.5">
                            <span class="text-emerald-700 text-sm">📍</span>
                            <span>Kompleks SIT Robbani, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir</span>
                        </p>

                        <!-- Ilustrasi SMA Siswa Asli Robbani -->
                        <div class="py-2 text-center">
                            <div class="w-40 h-40 mx-auto rounded-3xl bg-indigo-50 flex items-center justify-center p-3 shadow-inner">
                                <img src="{{ asset('images/spmb/sma.jpg') }}" alt="SMAIT Robbani" class="w-full h-full object-contain filter drop-shadow-md">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Sesuai Web Lama -->
                    <a href="{{ route('school.spmb.form', ['unit' => 'SMAIT']) }}" class="btn-responsive w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <span>👉</span>
                        <span>Daftar Sekarang</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. SECTION: PROGRAM UNGGULAN (DENGAN ILUSTRASI ASLI DARI WEB LAMA) -->
    <section id="program" class="py-14 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
            <div class="text-center space-y-2 fade-up">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Program Unggulan
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Keunggulan Sekolah Islam Terpadu Robbani
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto">
                    Kombinasi kurikulum nasional berstandar, kekhasan JSIT, nilai Al-Qur'an, dan teknologi modern.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 sm:gap-6">
                
                <!-- 1. Kurikulum Terpadu -->
                <div class="p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all fade-up delay-1">
                    <img src="{{ asset('images/spmb/kurikulum.png') }}" alt="Kurikulum Terpadu" class="w-24 h-24 sm:w-28 sm:h-28 object-contain mx-auto filter drop-shadow">
                    <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-tight">Kurikulum Terpadu</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed">Kurikulum Nasional dan Kekhasan JSIT</p>
                </div>

                <!-- 2. Life Skill -->
                <div class="p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all fade-up delay-2">
                    <img src="{{ asset('images/spmb/lifeskill.png') }}" alt="Life Skill" class="w-24 h-24 sm:w-28 sm:h-28 object-contain mx-auto filter drop-shadow">
                    <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-tight">Program Life Skill</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed">Pembelajaran adab dan karakter mandiri</p>
                </div>

                <!-- 3. Tahsin & Tahfidz -->
                <div class="p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all fade-up delay-3">
                    <img src="{{ asset('images/spmb/tahsin.png') }}" alt="Tahsin & Tahfidz" class="w-24 h-24 sm:w-28 sm:h-28 object-contain mx-auto filter drop-shadow">
                    <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-tight">Tahsin & Tahfidz</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed">Metode Wafa intensif & bersanad</p>
                </div>

                <!-- 4. Digitalisasi SmartEdu -->
                <div class="p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all fade-up delay-1">
                    <img src="{{ asset('images/spmb/digital.png') }}" alt="Digitalisasi Sekolah" class="w-24 h-24 sm:w-28 sm:h-28 object-contain mx-auto filter drop-shadow">
                    <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-tight">Digital SmartEdu</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed">Manajemen modern berbasis aplikasi HP</p>
                </div>

                <!-- 5. Ekskul Berkelas -->
                <div class="p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all col-span-2 md:col-span-1 max-w-xs mx-auto md:max-w-none w-full fade-up delay-2">
                    <img src="{{ asset('images/spmb/ekskul.png') }}" alt="Ekskul Berkelas" class="w-24 h-24 sm:w-28 sm:h-28 object-contain mx-auto filter drop-shadow">
                    <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-tight">Ekskul Berkelas</h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 leading-relaxed">Panahan, beladiri, dan sains kreatif</p>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. SECTION: SYARAT BERKAS & REKENING RESMI (DIPERJELAS UNTUK WALI MURID) -->
    <section id="syarat-biaya" class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <!-- Syarat & Berkas -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 fade-up delay-1">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl font-bold">
                            📋
                        </span>
                        <div>
                            <h3 class="font-black text-lg text-slate-900">Kelengkapan Berkas Pendaftaran</h3>
                            <p class="text-xs text-slate-500">Cukup difoto menggunakan kamera HP Anda</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs text-slate-700">
                        <div class="p-3.5 rounded-2xl bg-emerald-50/80 border border-emerald-300 flex items-start gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="text-emerald-950 font-black text-xs block">1. Akta Kelahiran Calon Siswa (Wajib)</strong>
                                <span class="text-[11px] text-emerald-800 font-medium">Foto asli atau fotokopi 1 lembar yang terbaca jelas.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold text-xs block">2. Kartu Keluarga (KK)</strong>
                                <span class="text-[11px] text-slate-500">Foto Kartu Keluarga yang masih berlaku.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold text-xs block">3. KTP Orang Tua (Ayah / Ibu)</strong>
                                <span class="text-[11px] text-slate-500">Foto KTP Ayah atau Ibu kandung.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold text-xs block">4. Pas Foto Berwarna Anak</strong>
                                <span class="text-[11px] text-slate-500">Foto wajah setengah badan terbaru yang sopan dan jelas.</span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-start gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold text-xs block">5. Bukti Transfer Formulir</strong>
                                <span class="text-[11px] text-slate-500">Struk ATM atau screenshot m-banking bukti pembayaran biaya pendaftaran.</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-950 flex items-start gap-2.5">
                        <span class="text-lg">💡</span>
                        <p class="leading-relaxed text-[11px]">
                            <strong>Tips untuk Orang Tua:</strong> Tidak perlu mesin scanner atau pergi ke warnet. Semua dokumen cukup difoto dengan kamera HP Anda.
                        </p>
                    </div>
                </div>

                <!-- Rekening Pembayaran Resmi Yayasan -->
                <div class="bg-gradient-to-br from-emerald-900 to-emerald-950 text-white rounded-3xl p-6 sm:p-8 border border-emerald-800 shadow-xl space-y-6 fade-up delay-2">
                    <div class="flex items-center gap-3 border-b border-emerald-800/80 pb-4">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-800 text-amber-300 flex items-center justify-center text-2xl font-bold">
                            💳
                        </span>
                        <div>
                            <h3 class="font-black text-lg text-white">Rekening Resmi Pembayaran</h3>
                            <p class="text-xs text-emerald-200">Yayasan Generasi Robbani Sumatera Selatan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Rekening BSI -->
                        <div class="p-4 sm:p-5 rounded-2xl bg-emerald-900/60 border border-emerald-700/60 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-300">Bank Syariah Indonesia (BSI)</span>
                                <button @click="copyToClipboard('7206858502', 'BSI')" type="button" class="px-3 py-1 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white text-[11px] font-bold transition-all shadow-xs">
                                    <span x-text="copiedBank === 'BSI' ? '✓ Tersalin' : 'Salin Nomor'"></span>
                                </button>
                            </div>
                            <div class="font-mono text-2xl sm:text-3xl font-black text-amber-300 tracking-wider">
                                7206858502
                            </div>
                            <p class="text-xs text-emerald-200">a.n. <strong>YAYASAN GENERASI ROBBANI</strong></p>
                        </div>

                        <!-- Rekening Muamalat -->
                        <div class="p-4 sm:p-5 rounded-2xl bg-emerald-900/60 border border-emerald-700/60 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-300">Bank Muamalat</span>
                                <button @click="copyToClipboard('3610061740', 'Muamalat')" type="button" class="px-3 py-1 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white text-[11px] font-bold transition-all shadow-xs">
                                    <span x-text="copiedBank === 'Muamalat' ? '✓ Tersalin' : 'Salin Nomor'"></span>
                                </button>
                            </div>
                            <div class="font-mono text-2xl sm:text-3xl font-black text-amber-300 tracking-wider">
                                3610061740
                            </div>
                            <p class="text-xs text-emerald-200">a.n. <strong>YAYASAN GENERASI ROBBANI SUMSEL</strong></p>
                        </div>
                    </div>

                    <!-- Ketentuan Singkat -->
                    <div class="p-3.5 rounded-2xl bg-emerald-950 border border-emerald-800 text-[11px] text-emerald-200 leading-relaxed space-y-1">
                        <p>• Rincian biaya formulir pendaftaran tertera langsung pada halaman formulir isian masing-masing unit.</p>
                        <p>• Pembayaran juga dapat dilakukan langsung di Kantor Pelayanan Administrasi (KPA) SIT Robbani Ogan Ilir.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. SECTION: CEK STATUS PENDAFTARAN & UNDUH FORMULIR PDF -->
    <section id="cek-status" class="py-14 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">
            <div class="text-center space-y-2 fade-up">
                <span class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl shadow-xs">
                    🔍
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Cek Status & Unduh Formulir PDF
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto font-medium">
                    Sudah pernah mendaftar? Masukkan Nomor Registrasi SPMB atau Nomor WhatsApp yang didaftarkan:
                </p>
            </div>

            <!-- Form Pencarian Sederhana -->
            <form @submit.prevent="checkStatus()" class="bg-slate-50 p-4 sm:p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 fade-up delay-1">
                <div class="flex flex-col sm:flex-row gap-2.5">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Contoh: 08123456789 atau SPMB-2026-..." 
                        class="w-full px-4 py-3.5 rounded-2xl bg-white border border-slate-300 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 transition-all"
                        required
                    >
                    <button 
                        type="submit" 
                        :disabled="isLoading"
                        class="btn-responsive px-6 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 disabled:opacity-50 text-white font-black text-xs shrink-0 shadow-md transition-all"
                    >
                        <span x-show="!isLoading">Cari Data Saya ➔</span>
                        <span x-show="isLoading" x-cloak>Mencari...</span>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 text-center">
                    Gunakan nomor WhatsApp orang tua yang diisikan saat pendaftaran.
                </p>
            </form>

            <!-- Kartu Hasil Pencarian -->
            <div x-show="searchResult" x-cloak class="p-5 sm:p-6 rounded-3xl border transition-all" :class="searchResult?.found ? 'bg-white border-emerald-200 shadow-md' : 'bg-rose-50 border-rose-200'">
                
                <!-- Ditemukan -->
                <template x-if="searchResult?.found">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">Data Pendaftaran Ditemukan</span>
                                <h4 class="text-lg font-black text-slate-900" x-text="searchResult.registration.full_name"></h4>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase" :class="{
                                'bg-emerald-100 text-emerald-800': searchResult.registration.status === 'PASSED',
                                'bg-amber-100 text-amber-800': searchResult.registration.status === 'PENDING',
                                'bg-rose-100 text-rose-800': searchResult.registration.status === 'REJECTED'
                            }" x-text="searchResult.registration.status === 'PASSED' ? '✓ Diterima / Lulus' : (searchResult.registration.status === 'PENDING' ? '⏳ Verifikasi Berkas' : 'Belum Lulus')"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-2.5 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 block font-semibold">No. Registrasi:</span>
                                <span class="font-mono font-bold text-slate-800" x-text="searchResult.registration.registration_number"></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 block font-semibold">Unit Sekolah:</span>
                                <span class="font-bold text-emerald-800" x-text="searchResult.registration.target_level"></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 block font-semibold">Nama Orang Tua:</span>
                                <span class="font-bold text-slate-800" x-text="searchResult.registration.parent_name"></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 block font-semibold">Status Berkas:</span>
                                <span class="font-bold text-emerald-800" x-text="searchResult.registration.status === 'PASSED' ? 'Diterima' : 'Dalam Proses'"></span>
                            </div>
                        </div>

                        <!-- Tombol Unduh PDF Singkat & Jelas -->
                        <div class="pt-2 flex flex-col sm:flex-row gap-2.5">
                            <a :href="searchResult.registration.pdf_url" target="_blank" class="btn-responsive w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-bold text-xs shadow-sm">
                                <span>🖨️ Unduh Formulir PDF</span>
                            </a>
                            <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20saya%20ingin%20konfirmasi%20SPMB" target="_blank" class="btn-responsive w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm">
                                <span>💬 Chat Panitia WA</span>
                            </a>
                        </div>
                    </div>
                </template>

                <!-- Tidak Ditemukan -->
                <template x-if="searchResult && !searchResult?.found">
                    <div class="text-center py-3 space-y-1 text-xs text-rose-800">
                        <span class="text-2xl">⚠️</span>
                        <p class="font-bold text-sm" x-text="searchResult.message || 'Data pendaftaran tidak ditemukan.'"></p>
                        <p class="text-[11px] text-rose-600">
                            Pastikan nomor WhatsApp atau nomor pendaftaran Anda sudah benar.
                        </p>
                    </div>
                </template>

            </div>
        </div>
    </section>

    <!-- 8. SECTION: TESTIMONI WALI MURID (DARI WEB LAMA) -->
    <section class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
            <div class="text-center space-y-2 fade-up">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-slate-200 text-slate-700 uppercase tracking-wider">
                    Testimonial
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Apa Kata Mereka Tentang SIT Robbani?
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto font-medium">
                    Pengalaman nyata para orang tua wali murid yang mempercayakan pendidikan ananda di SIT Robbani.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Testi 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 fade-up delay-1">
                    <p class="text-xs text-slate-600 leading-relaxed italic">
                        "Sekolah Robbani pilihan yang sangat tepat bagi anak. Guru yang profesional dan berkompeten sangat menunjang pembelajaran. Yang paling penting pelajaran ilmu agamanya serta sopan santun yang diajarkan kepada murid."
                    </p>
                    <div class="border-t border-slate-100 pt-3 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0">
                            EO
                        </div>
                        <div>
                            <strong class="text-xs font-black text-slate-900 block">ECILIA OKTARINA, SE, MM</strong>
                            <span class="text-[10px] text-slate-400">Bapenda Provinsi Sumsel</span>
                        </div>
                    </div>
                </div>

                <!-- Testi 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 fade-up delay-2">
                    <p class="text-xs text-slate-600 leading-relaxed italic">
                        "Sekolah pilihan terbaik masa sekarang ini. Gurunya ramah, muda, dan berkompeten. Nilai agamanya sangat kuat, dan tidak ada batasan antara guru, siswa, serta ortu—semua saling mendukung dalam satu ikatan silaturahmi."
                    </p>
                    <div class="border-t border-slate-100 pt-3 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0">
                            RS
                        </div>
                        <div>
                            <strong class="text-xs font-black text-slate-900 block">RENNI SUSANTI, A.Md. Kep</strong>
                            <span class="text-[10px] text-slate-400">Perawat RSUD Ogan Ilir</span>
                        </div>
                    </div>
                </div>

                <!-- Testi 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 fade-up delay-3">
                    <p class="text-xs text-slate-600 leading-relaxed italic">
                        "Alhamdulillah selama anak saya bersekolah di sini banyak ilmu yang didapat, terutama hafalan Al-Qur'an dan adab ibadah. Anak semakin percaya diri dalam mengikuti perlombaan. Terima kasih Ustadz dan Bunda!"
                    </p>
                    <div class="border-t border-slate-100 pt-3 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0">
                            BM
                        </div>
                        <div>
                            <strong class="text-xs font-black text-slate-900 block">Bunda Mazaya</strong>
                            <span class="text-[10px] text-slate-400">Wali Murid Alumni SDIT Robbani</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 9. SECTION: BANTUAN WHATSAPP LANGSUNG -->
    <section class="py-14 bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center space-y-4 fade-up">
            <div class="w-14 h-14 mx-auto rounded-3xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl shadow-xs">
                🤝
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">
                Butuh Bantuan Pendaftaran?
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed">
                Bila Anda mengalami kesulitan saat mengisi formulir online, panitia SPMB SIT Robbani siap memandu Anda langkah demi langkah via WhatsApp sampai selesai.
            </p>
            <div class="pt-2">
                <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20butuh%20panduan%20mendaftar%20calon%20siswa%20baru" target="_blank" class="btn-responsive px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg shadow-emerald-600/25 transition-all">
                    <span>💬 Hubungi Panitia via WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 10. FOOTER -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-10 border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center space-y-4">
            <div class="flex items-center justify-center gap-2.5">
                <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 w-auto">
                <span class="text-white font-black text-sm">YAYASAN GENERASI ROBBANI SUMATERA SELATAN</span>
            </div>
            <p class="text-xs text-slate-400 max-w-md mx-auto">
                Sekolah Islam Terpadu Robbani Ogan Ilir. Kampus TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT di Timbangan, Indralaya Utara, Ogan Ilir.
            </p>
            <div class="pt-2 border-t border-slate-800 text-[11px] text-slate-500">
                &copy; {{ date('Y') }} SIT Robbani Ogan Ilir. Sistem Penerimaan Murid Baru Online SmartEdu.
            </div>
        </div>
    </footer>

    <!-- 11. STICKY MOBILE BOTTOM BAR (UNTUK PENGGUNA HP) -->
    <div class="fixed bottom-0 inset-x-0 sm:hidden z-50 bg-white/95 backdrop-blur-md border-t border-slate-200 p-2.5 shadow-2xl flex items-center gap-2">
        <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20ingin%20bertanya%20seputar%20pendaftaran" target="_blank" class="btn-responsive flex-1 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-emerald-800 font-bold text-xs transition-colors">
            <span>💬 Bantuan WA</span>
        </a>
        <a href="#daftar" class="btn-responsive flex-1 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-colors">
            <span>👉 Pilih Unit</span>
        </a>
    </div>

    <!-- TOAST NOTIFICATION COPY -->
    <div x-show="toastMessage" x-cloak class="fixed top-5 right-5 z-50 px-4 py-2.5 rounded-xl bg-slate-900 text-amber-300 font-bold text-xs shadow-2xl transition-all" x-text="toastMessage"></div>

    <!-- Scripts: Alpine.js + IntersectionObserver Fade-Up -->
    <script>
        function spmbLandingApp() {
            return {
                searchQuery: '',
                isLoading: false,
                searchResult: null,
                copiedBank: null,
                toastMessage: '',

                copyToClipboard(text, bankName) {
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text);
                    } else {
                        const tempInput = document.createElement("input");
                        tempInput.value = text;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        document.execCommand("copy");
                        document.body.removeChild(tempInput);
                    }
                    this.copiedBank = bankName;
                    this.toastMessage = `No. Rekening ${bankName} berhasil disalin!`;
                    setTimeout(() => {
                        this.copiedBank = null;
                        this.toastMessage = '';
                    }, 2500);
                },

                async checkStatus() {
                    if (!this.searchQuery) return;
                    this.isLoading = true;
                    this.searchResult = null;

                    try {
                        const response = await fetch(`{{ route('school.spmb.check-status') }}?q=${encodeURIComponent(this.searchQuery)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await response.json();
                        this.searchResult = data;
                    } catch (e) {
                        this.searchResult = {
                            found: false,
                            message: 'Terjadi kendala saat memeriksa data. Silakan coba lagi.'
                        };
                    } finally {
                        this.isLoading = false;
                    }
                }
            };
        }

        // IntersectionObserver for Fade-Up Animations
        document.addEventListener('DOMContentLoaded', function () {
            const elements = document.querySelectorAll('.fade-up');
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('in-view');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px -20px 0px'
                });

                elements.forEach(el => observer.observe(el));
            } else {
                elements.forEach(el => el.classList.add('in-view'));
            }
        });
    </script>
</body>
</html>
