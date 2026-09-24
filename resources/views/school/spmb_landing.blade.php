<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Pendaftaran Siswa Baru (SPMB) T.A 2026/2027 | SIT Robbani Ogan Ilir</title>
    <meta name="description" content="Pendaftaran Murid Baru (SPMB / PPDB) Sekolah Islam Terpadu Robbani Ogan Ilir T.A 2026/2027. Mudah, cepat, dan bisa langsung daftar dari HP. Jenjang TKIT, SDIT, SMPIT, SMAIT.">
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=12">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=12">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=12">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="Pendaftaran Siswa Baru (SPMB) 2026/2027 - SIT Robbani Ogan Ilir">
    <meta property="og:description" content="Pendaftaran Murid Baru SIT Robbani Ogan Ilir T.A 2026/2027. Mudah, cepat, dan bisa langsung daftar dari HP.">
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
            transform: translateY(26px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .fade-up.in-view {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
        .delay-1 { transition-delay: 120ms; }
        .delay-2 { transition-delay: 240ms; }
        .delay-3 { transition-delay: 360ms; }

        /* Button base to prevent text cut-off on small devices */
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

        /* Subtle hero texture */
        .hero-bg {
            background-color: #064e3b;
            background-image: radial-gradient(rgba(16, 185, 129, 0.22) 1.5px, transparent 1.5px), radial-gradient(rgba(245, 158, 11, 0.12) 1.5px, #033d2e 1.5px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }
    </style>
</head>
<body class="antialiased pb-20 sm:pb-0" x-data="spmbLandingApp()">

    <!-- 1. PENGUMUMAN GELOMBANG (TOP BANNER) -->
    <div class="bg-emerald-950 text-emerald-200 text-xs py-2 px-3 border-b border-emerald-900/60">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 text-center sm:text-left">
            <div class="flex items-center justify-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase tracking-wide">
                    Gelombang 1
                </span>
                <span class="font-bold text-[11px] sm:text-xs text-white">
                    Pendaftaran 12 Sept – 31 Des 2026
                </span>
            </div>
            <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani" target="_blank" class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-emerald-300 hover:text-white transition-colors">
                <span>💬 Bantuan WhatsApp: <strong>0811-747-472</strong></span>
            </a>
        </div>
    </div>

    <!-- 2. HEADER NAVIGASI (BERSIH & RAMAH HP) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/90 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo & Brand -->
                <a href="{{ route('school.spmb') }}" class="flex items-center gap-2.5 sm:gap-3 group">
                    <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-10 sm:h-12 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                    <div>
                        <span class="block text-xs sm:text-sm font-black tracking-wide text-emerald-900 uppercase leading-tight">SPMB SIT ROBBANI</span>
                        <span class="block text-[10px] sm:text-xs font-semibold text-slate-500 leading-tight">Ogan Ilir — Sumatera Selatan</span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center gap-5 text-xs font-bold text-slate-600">
                    <a href="#langkah" class="hover:text-emerald-700 transition-colors">Cara Daftar</a>
                    <a href="#jenjang-biaya" class="hover:text-emerald-700 transition-colors">Pilihan & Biaya</a>
                    <a href="#berkas" class="hover:text-emerald-700 transition-colors">Syarat Berkas</a>
                    <a href="#rekening" class="hover:text-emerald-700 transition-colors">No. Rekening</a>
                    <a href="#cek-status" class="hover:text-emerald-700 transition-colors">Cek Status</a>
                </nav>

                <!-- Action Buttons Header -->
                <div class="flex items-center gap-2">
                    <a href="#cek-status" class="btn-responsive px-3 sm:px-4 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        <span>🔍 Cek Status</span>
                    </a>
                    <a href="{{ route('school.spmb.form') }}" class="btn-responsive px-4 sm:px-5 py-2 text-xs font-black text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-md transition-all">
                        <span>Daftar Sekarang</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. HERO UTAMA (SEDERHANA, JELAS, & TIDAK BINGUNGKAN WALI MURID) -->
    <section class="relative hero-bg text-white pt-8 pb-14 sm:pt-16 sm:pb-20 overflow-hidden">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 text-center space-y-5">
            
            <!-- Badge Status -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-800/90 border border-emerald-600/60 text-emerald-200 text-xs font-bold shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Penerimaan Santri Baru T.A. 2026/2027</span>
            </div>

            <!-- Judul Utama -->
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight max-w-3xl mx-auto">
                Pendaftaran Siswa Baru SIT Robbani Ogan Ilir
            </h1>

            <!-- Penjelasan Sederhana -->
            <p class="text-sm sm:text-base text-emerald-100/95 font-medium max-w-2xl mx-auto leading-relaxed">
                Pendaftaran kini sangat mudah langsung dari HP Anda. Cukup isi formulir data anak, foto berkas dari HP, dan dapatkan bukti pendaftaran resmi tanpa perlu antre.
            </p>

            <!-- 2 Tombol Aksi Utama (Teks Singkat, Tidak Terpotong di Layar HP Apapun) -->
            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3 max-w-md mx-auto">
                <a href="{{ route('school.spmb.form') }}" class="btn-responsive w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5">
                    <span>📝 Mulai Isi Formulir</span>
                </a>
                <a href="#cek-status" class="btn-responsive w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-emerald-800/90 hover:bg-emerald-800 text-white border border-emerald-600/70 font-bold text-sm transition-all">
                    <span>🔍 Cek Status Pendaftaran</span>
                </a>
            </div>

            <!-- Poin Penenang untuk Wali Murid yang Gaptek -->
            <div class="pt-4 grid grid-cols-1 sm:grid-cols-3 gap-2.5 max-w-2xl mx-auto text-xs font-bold text-emerald-100">
                <div class="p-2.5 rounded-xl bg-emerald-900/60 border border-emerald-700/50 flex items-center justify-center gap-2">
                    <span class="text-amber-300 text-sm">✓</span>
                    <span>Bisa Daftar Cukup dari HP</span>
                </div>
                <div class="p-2.5 rounded-xl bg-emerald-900/60 border border-emerald-700/50 flex items-center justify-center gap-2">
                    <span class="text-amber-300 text-sm">✓</span>
                    <span>Berkas Cukup Difoto Biasa</span>
                </div>
                <div class="p-2.5 rounded-xl bg-emerald-900/60 border border-emerald-700/50 flex items-center justify-center gap-2">
                    <span class="text-amber-300 text-sm">✓</span>
                    <span>Panitia Siap Membantu via WA</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PANDUAN 3 LANGKAH MUDAH (SANGAT MUDAH DIPAHAMI) -->
    <section id="langkah" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2 fade-up">
                <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Panduan Praktis
                </span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                    3 Langkah Mudah Mendaftar dari HP
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto">
                    Wali murid tidak perlu repot, ikuti 3 tahapan sederhana berikut:
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Langkah 1 -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2.5 fade-up delay-1">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-700 text-white font-black text-lg flex items-center justify-center shadow-md">
                        1
                    </div>
                    <h3 class="font-black text-base text-slate-900">Pilih Unit & Isi Data</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pilih jenjang sekolah (TK, SD, SMP, SMA) lalu isi nama lengkap calon siswa dan nomor WhatsApp orang tua.
                    </p>
                </div>

                <!-- Langkah 2 -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2.5 fade-up delay-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-700 text-white font-black text-lg flex items-center justify-center shadow-md">
                        2
                    </div>
                    <h3 class="font-black text-base text-slate-900">Foto Berkas dari HP</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Foto <strong>Akta Kelahiran</strong>, Kartu Keluarga, dan bukti transfer menggunakan kamera HP Anda, lalu upload ke formulir.
                    </p>
                </div>

                <!-- Langkah 3 -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2.5 fade-up delay-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-700 text-white font-black text-lg flex items-center justify-center shadow-md">
                        3
                    </div>
                    <h3 class="font-black text-base text-slate-900">Selesai & Unduh Bukti</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Dapatkan Nomor Registrasi resmi dan Anda bisa langsung mengunduh formulir bukti pendaftaran dalam bentuk file PDF.
                    </p>
                </div>
            </div>

            <!-- Tips Penting untuk Wali Murid Gaptek -->
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 flex items-start gap-3 text-xs text-amber-950 fade-up">
                <span class="text-xl shrink-0">💡</span>
                <p class="leading-relaxed">
                    <strong>Penting untuk Wali Murid:</strong> Anda tidak membutuhkan alat scanner atau pergi ke warnet. Semua dokumen cukup difoto dengan kamera HP yang terang dan terbaca jelas.
                </p>
            </div>
        </div>
    </section>

    <!-- 5. PILIHAN UNIT SEKOLAH & BIAYA PENDAFTARAN -->
    <section id="jenjang-biaya" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2 fade-up">
                <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Pilihan Sekolah & Biaya
                </span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                    Pilihan Unit & Biaya Formulir Pendaftaran
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto">
                    Biaya formulir berlaku resmi untuk Gelombang 1. Silakan pilih unit yang ingin dituju:
                </p>
            </div>

            <!-- Kartu Jenjang Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
                
                <!-- Unit TKIT & KB/TPA -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4 fade-up delay-1">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-pink-100 text-pink-800 uppercase">
                                Usia 2 – 6 Tahun
                            </span>
                            <span class="text-[11px] font-bold text-slate-400">TK / KB / TPA</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">TKIT & KB Robbani</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Membentuk karakter adab, hafalan surat pendek & doa harian ceria, serta kemandirian anak sejak dini.
                        </p>
                        
                        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-100">
                            <span class="block text-[10px] font-bold text-emerald-800 uppercase">Biaya Formulir:</span>
                            <span class="font-mono text-2xl font-black text-emerald-900">Rp 350.000</span>
                        </div>
                    </div>

                    <a href="{{ route('school.spmb.form', ['unit' => 'TKIT']) }}" class="btn-responsive w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-sm transition-all">
                        <span>Daftar TK / KB ➔</span>
                    </a>
                </div>

                <!-- Unit SDIT -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border-2 border-emerald-500 shadow-md transition-all flex flex-col justify-between space-y-4 relative fade-up delay-2">
                    <div class="absolute -top-3 right-6 bg-emerald-600 text-white text-[10px] font-black px-3 py-0.5 rounded-full uppercase tracking-wider shadow-xs">
                        Favorit
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                Usia Min. 6 Tahun
                            </span>
                            <span class="text-[11px] font-bold text-slate-400">SD Islam Terpadu</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SDIT Robbani</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Pendidikan karakter islami, Kurikulum Merdeka, Tahfidz Al-Qur'an, dan pembiasaan ibadah harian.
                        </p>
                        
                        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200">
                            <span class="block text-[10px] font-bold text-emerald-800 uppercase">Biaya Formulir:</span>
                            <span class="font-mono text-2xl font-black text-emerald-900">Rp 450.000</span>
                        </div>
                    </div>

                    <a href="{{ route('school.spmb.form', ['unit' => 'SDIT']) }}" class="btn-responsive w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-sm transition-all">
                        <span>Daftar SDIT ➔</span>
                    </a>
                </div>

                <!-- Unit SMPIT -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4 fade-up delay-3">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-cyan-100 text-cyan-800 uppercase">
                                Lulusan SD / MI
                            </span>
                            <span class="text-[11px] font-bold text-slate-400">SMP Islam Terpadu</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SMPIT Robbani</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Membina jiwa kepemimpinan remaja, tahfidz intensif, prestasi akademik, dan pembinaan karakter akhlakul karimah.
                        </p>
                        
                        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-100">
                            <span class="block text-[10px] font-bold text-emerald-800 uppercase">Biaya Formulir:</span>
                            <span class="font-mono text-2xl font-black text-emerald-900">Rp 550.000</span>
                        </div>
                    </div>

                    <a href="{{ route('school.spmb.form', ['unit' => 'SMPIT']) }}" class="btn-responsive w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-sm transition-all">
                        <span>Daftar SMPIT ➔</span>
                    </a>
                </div>

                <!-- Unit SMAIT -->
                <div class="bg-white rounded-3xl p-5 sm:p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between space-y-4 sm:col-span-2 lg:col-span-3 max-w-xl mx-auto w-full fade-up">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800 uppercase">
                                Lulusan SMP / MTs
                            </span>
                            <span class="text-[11px] font-bold text-slate-400">SMA Islam Terpadu</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SMAIT Robbani</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Fokus persiapan masuk Perguruan Tinggi Negeri (PTN) terbaik, kepemimpinan islami, riset, dan tahfidz mandiri.
                        </p>
                        
                        <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] font-bold text-emerald-800 uppercase">Biaya Formulir:</span>
                                <span class="font-mono text-2xl font-black text-emerald-900">Rp 550.000</span>
                            </div>
                            <span class="text-xs font-semibold text-slate-500">Kuota Terbatas</span>
                        </div>
                    </div>

                    <a href="{{ route('school.spmb.form', ['unit' => 'SMAIT']) }}" class="btn-responsive w-full py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-sm transition-all">
                        <span>Daftar SMAIT ➔</span>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- 6. SYARAT BERKAS & NO REKENING PEMBAYARAN -->
    <section id="berkas" class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                
                <!-- Box Kiri: Syarat Berkas yang Diupload -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200 space-y-4 fade-up delay-1">
                    <div class="flex items-center gap-2.5 border-b border-slate-200 pb-3">
                        <span class="text-2xl">📋</span>
                        <div>
                            <h3 class="font-black text-base text-slate-900">Berkas yang Perlu Disiapkan</h3>
                            <p class="text-[11px] text-slate-500">Foto jelas dengan kamera HP Anda</p>
                        </div>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-700">
                        <li class="p-2.5 rounded-xl bg-emerald-50/80 border border-emerald-200 flex items-start gap-2.5">
                            <span class="text-emerald-700 font-black text-sm">✓</span>
                            <div>
                                <strong class="text-emerald-950 font-bold block">1. Akta Kelahiran Calon Siswa (Wajib)</strong>
                                <span class="text-[11px] text-emerald-800">Foto asli atau fotokopi akta kelahiran ananda.</span>
                            </div>
                        </li>

                        <li class="p-2.5 rounded-xl bg-white border border-slate-200 flex items-start gap-2.5">
                            <span class="text-emerald-700 font-black text-sm">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold block">2. Kartu Keluarga (KK)</strong>
                                <span class="text-[11px] text-slate-500">Foto kartu keluarga yang masih berlaku.</span>
                            </div>
                        </li>

                        <li class="p-2.5 rounded-xl bg-white border border-slate-200 flex items-start gap-2.5">
                            <span class="text-emerald-700 font-black text-sm">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold block">3. KTP Orang Tua</strong>
                                <span class="text-[11px] text-slate-500">Foto KTP Ayah atau Ibu kandung.</span>
                            </div>
                        </li>

                        <li class="p-2.5 rounded-xl bg-white border border-slate-200 flex items-start gap-2.5">
                            <span class="text-emerald-700 font-black text-sm">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold block">4. Pas Foto Anak Terbaru</strong>
                                <span class="text-[11px] text-slate-500">Foto wajah setengah badan yang jelas dan sopan.</span>
                            </div>
                        </li>

                        <li class="p-2.5 rounded-xl bg-white border border-slate-200 flex items-start gap-2.5">
                            <span class="text-emerald-700 font-black text-sm">✓</span>
                            <div>
                                <strong class="text-slate-900 font-bold block">5. Bukti Transfer Formulir</strong>
                                <span class="text-[11px] text-slate-500">Foto struk ATM atau screenshot bukti transfer m-banking.</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Box Kanan: Rekening Resmi Pembayaran -->
                <div id="rekening" class="bg-emerald-900 text-white rounded-3xl p-6 border border-emerald-800 shadow-md space-y-4 fade-up delay-2">
                    <div class="flex items-center gap-2.5 border-b border-emerald-800/80 pb-3">
                        <span class="text-2xl">💳</span>
                        <div>
                            <h3 class="font-black text-base text-white">Rekening Resmi Pembayaran</h3>
                            <p class="text-[11px] text-emerald-200">Yayasan Generasi Robbani Sumatera Selatan</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <!-- Rekening BSI -->
                        <div class="p-4 rounded-2xl bg-emerald-950/70 border border-emerald-700/60 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-300">Bank Syariah Indonesia (BSI)</span>
                                <button @click="copyToClipboard('7206858502', 'BSI')" type="button" class="px-2.5 py-1 rounded-lg bg-emerald-800 hover:bg-emerald-700 text-white text-[10px] font-bold transition-all">
                                    <span x-text="copiedBank === 'BSI' ? '✓ Tersalin' : 'Salin No. Rekening'"></span>
                                </button>
                            </div>
                            <div class="font-mono text-xl sm:text-2xl font-black text-amber-300 tracking-wider">
                                7206858502
                            </div>
                            <p class="text-[11px] text-emerald-200">a.n. <strong>YAYASAN GENERASI ROBBANI</strong></p>
                        </div>

                        <!-- Rekening Muamalat -->
                        <div class="p-4 rounded-2xl bg-emerald-950/70 border border-emerald-700/60 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-emerald-300">Bank Muamalat</span>
                                <button @click="copyToClipboard('3610061740', 'Muamalat')" type="button" class="px-2.5 py-1 rounded-lg bg-emerald-800 hover:bg-emerald-700 text-white text-[10px] font-bold transition-all">
                                    <span x-text="copiedBank === 'Muamalat' ? '✓ Tersalin' : 'Salin No. Rekening'"></span>
                                </button>
                            </div>
                            <div class="font-mono text-xl sm:text-2xl font-black text-amber-300 tracking-wider">
                                3610061740
                            </div>
                            <p class="text-[11px] text-emerald-200">a.n. <strong>YAYASAN GENERASI ROBBANI SUMSEL</strong></p>
                        </div>
                    </div>

                    <!-- Petunjuk Transfer Singkat -->
                    <div class="p-3 rounded-xl bg-emerald-800/60 text-[11px] text-emerald-100 leading-relaxed">
                        Simpan bukti transfer dan unggah saat mengisi formulir pendaftaran agar data Anda dapat diverifikasi otomatis.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. CEK STATUS PENDAFTARAN & UNDUH FORMULIR PDF (MUDAH & LANGSUNG) -->
    <section id="cek-status" class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">
            <div class="text-center space-y-2 fade-up">
                <span class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl shadow-xs">
                    🔍
                </span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                    Cek Status & Unduh Formulir PDF
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto">
                    Sudah pernah mendaftar? Masukkan Nomor Registrasi atau Nomor WhatsApp yang Anda gunakan saat mendaftar:
                </p>
            </div>

            <!-- Form Pencarian Sederhana -->
            <form @submit.prevent="checkStatus()" class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3 fade-up delay-1">
                <div class="flex flex-col sm:flex-row gap-2.5">
                    <input 
                        type="text" 
                        x-model="searchQuery" 
                        placeholder="Contoh: 08123456789 atau No. SPMB" 
                        class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-300 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition-all"
                        required
                    >
                    <button 
                        type="submit" 
                        :disabled="isLoading"
                        class="btn-responsive px-6 py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 disabled:opacity-50 text-white font-black text-xs shrink-0 shadow-md transition-all"
                    >
                        <span x-show="!isLoading">Cari Data Saya</span>
                        <span x-show="isLoading" x-cloak>Mencari...</span>
                    </button>
                </div>
                <p class="text-[11px] text-slate-400 text-center">
                    Ketik nomor HP yang Anda daftarkan di formulir SPMB.
                </p>
            </form>

            <!-- Kartu Hasil Pencarian -->
            <div x-show="searchResult" x-cloak class="p-5 sm:p-6 rounded-3xl border transition-all" :class="searchResult?.found ? 'bg-white border-emerald-200 shadow-md' : 'bg-rose-50 border-rose-200'">
                
                <!-- Ditemukan -->
                <template x-if="searchResult?.found">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div>
                                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">Data Ditemukan</span>
                                <h4 class="text-lg font-black text-slate-900" x-text="searchResult.registration.full_name"></h4>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase" :class="{
                                'bg-emerald-100 text-emerald-800': searchResult.registration.status === 'PASSED',
                                'bg-amber-100 text-amber-800': searchResult.registration.status === 'PENDING',
                                'bg-rose-100 text-rose-800': searchResult.registration.status === 'REJECTED'
                            }" x-text="searchResult.registration.status === 'PASSED' ? '✓ Diterima' : (searchResult.registration.status === 'PENDING' ? '⏳ Verifikasi Berkas' : 'Belum Lulus')"></span>
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
                                <span class="text-[10px] text-slate-400 block font-semibold">Orang Tua / Wali:</span>
                                <span class="font-bold text-slate-800" x-text="searchResult.registration.parent_name"></span>
                            </div>
                            <div class="p-2.5 rounded-xl bg-slate-50">
                                <span class="text-[10px] text-slate-400 block font-semibold">Biaya Formulir:</span>
                                <span class="font-mono font-bold text-emerald-700" x-text="'Rp ' + Number(searchResult.registration.registration_fee).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <!-- Tombol Unduh PDF (Pendek & Jelas) -->
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
                    <div class="text-center py-2 space-y-1 text-xs text-rose-800">
                        <span class="text-2xl">⚠️</span>
                        <p class="font-bold text-sm" x-text="searchResult.message || 'Data tidak ditemukan.'"></p>
                        <p class="text-[11px] text-rose-600">
                            Silakan periksa kembali nomor WhatsApp atau nomor pendaftaran Anda.
                        </p>
                    </div>
                </template>

            </div>
        </div>
    </section>

    <!-- 8. BANTUAN PANITIA (UNTUK WALI MURID YANG BUTUH PANDUAN) -->
    <section class="py-12 bg-white border-b border-slate-200">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center space-y-4 fade-up">
            <div class="w-14 h-14 mx-auto rounded-3xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl shadow-xs">
                🤝
            </div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900">
                Butuh Bantuan Saat Mendaftar?
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed">
                Jangan khawatir bila merasa bingung atau belum terbiasa mendaftar online. Panitia kami siap memandu Anda langkah demi langkah via WhatsApp sampai selesai.
            </p>
            <div class="pt-2">
                <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20butuh%20panduan%20mendaftar%20calon%20siswa%20baru" target="_blank" class="btn-responsive px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg shadow-emerald-600/25 transition-all">
                    <span>💬 Hubungi Panitia via WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 9. FOOTER SEDERHANA -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-10 border-t border-slate-800">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center space-y-4">
            <div class="flex items-center justify-center gap-2.5">
                <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 w-auto">
                <span class="text-white font-black text-sm">YAYASAN GENERASI ROBBANI SUMSEL</span>
            </div>
            <p class="text-xs text-slate-400 max-w-md mx-auto">
                Sekolah Islam Terpadu Robbani Ogan Ilir. Kampus: Indralaya, Ogan Ilir, Sumatera Selatan.
            </p>
            <div class="pt-2 border-t border-slate-800 text-[11px] text-slate-500">
                &copy; {{ date('Y') }} SIT Robbani Ogan Ilir. Sistem SPMB Online SmartEdu.
            </div>
        </div>
    </footer>

    <!-- 10. STICKY MOBILE BOTTOM BAR (SANGAT MEMUDAHKAN WALI MURID DI HP) -->
    <div class="fixed bottom-0 inset-x-0 sm:hidden z-50 bg-white/95 backdrop-blur-md border-t border-slate-200 p-2.5 shadow-2xl flex items-center gap-2">
        <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20ingin%20bertanya%20seputar%20pendaftaran" target="_blank" class="btn-responsive flex-1 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-emerald-800 font-bold text-xs transition-colors">
            <span>💬 Bantuan WA</span>
        </a>
        <a href="{{ route('school.spmb.form') }}" class="btn-responsive flex-1 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-colors">
            <span>📝 Daftar Sekarang</span>
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
                // Fallback for very old browsers
                elements.forEach(el => el.classList.add('in-view'));
            }
        });
    </script>
</body>
</html>
