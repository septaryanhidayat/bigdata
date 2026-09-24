<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPMB Online T.A 2026/2027 | Sekolah Islam Terpadu Robbani Ogan Ilir</title>
    <meta name="description" content="Official Portal Sistem Penerimaan Murid Baru (SPMB / PPDB) Sekolah Islam Terpadu Robbani Ogan Ilir. Jenjang TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT.">
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=12">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=12">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=12">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="SPMB Online 2026/2027 - Sekolah Islam Terpadu Robbani Ogan Ilir">
    <meta property="og:description" content="Penerimaan Peserta Didik Baru (PPDB / SPMB) SIT Robbani Ogan Ilir T.A 2026/2027. Sekolah Berbasis Digital Pertama dengan Pendidikan Karakter di Ogan Ilir.">
    <meta property="og:image" content="{{ asset('images/logo robbani light.png') }}">
    <meta name="theme-color" content="#047857">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .hero-pattern {
            background-color: #064e3b;
            background-image: radial-gradient(rgba(16, 185, 129, 0.25) 1px, transparent 1px), radial-gradient(rgba(245, 158, 11, 0.15) 1px, #04362a 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 30px -10px rgba(15, 23, 42, 0.08);
        }
    </style>
</head>
<body class="antialiased text-slate-800" x-data="spmbLandingApp()">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-900 text-emerald-200 text-xs py-2.5 px-4 border-b border-emerald-800/40">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div class="flex items-center justify-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-400 text-amber-950">
                    GELOMBANG 1 DIBUKA
                </span>
                <span class="font-medium text-[11px] sm:text-xs">
                    Penerimaan Siswa Baru T.A. 2026/2027 Telah Dibuka (12 Sept – 31 Des 2026)
                </span>
            </div>
            <div class="flex items-center gap-4 text-[11px]">
                <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20Panitia%20SPMB%20SIT%20Robbani" target="_blank" class="hover:text-white flex items-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.347.491 1.2.534 1.288.043.088.072.191.014.307-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.182-.077.357.101.174.45 0.744.966 1.203.666.594 1.228.777 1.402.864.173.087.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.043.072.043.419-.101.824z"/></svg>
                    Helpdesk WA: 0811747472
                </a>
                <span class="text-emerald-700">|</span>
                <a href="#cek-status" class="hover:text-amber-300 font-bold transition-colors">
                    🔍 Cek Status Pendaftaran
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand / Logo -->
                <a href="{{ route('school.spmb') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-12 w-auto object-contain transition-transform group-hover:scale-105" onerror="this.src='{{ asset('favicon.png') }}'">
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-black tracking-wider text-emerald-800 uppercase">SPMB SIT ROBBANI</span>
                        <span class="block text-[11px] font-semibold text-slate-500">Ogan Ilir — Sumatera Selatan</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                    <a href="#jadwal" class="hover:text-emerald-700 transition-colors">Jadwal SPMB</a>
                    <a href="#syarat-biaya" class="hover:text-emerald-700 transition-colors">Syarat & Biaya</a>
                    <a href="#jenjang" class="hover:text-emerald-700 transition-colors">Pilihan Unit</a>
                    <a href="#alur" class="hover:text-emerald-700 transition-colors">Alur Daftar</a>
                    <a href="#layanan-digital" class="hover:text-emerald-700 transition-colors">Keunggulan Digital</a>
                    <a href="#cek-status" class="hover:text-emerald-700 transition-colors">Cek Status</a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center gap-2.5">
                    <a href="#cek-status" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                        <span>🔍</span> Cek Status
                    </a>
                    <a href="{{ route('school.spmb.form') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-black text-white bg-emerald-700 hover:bg-emerald-800 rounded-xl shadow-md hover:shadow-lg shadow-emerald-700/20 transition-all transform hover:-translate-y-0.5">
                        <span>📝</span> Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative hero-pattern text-white pt-12 pb-20 sm:pt-20 sm:pb-28 overflow-hidden">
        <!-- Ambient Glow -->
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-80 h-80 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <!-- Left Hero Text -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-800/80 border border-emerald-600/50 text-emerald-200 text-xs font-bold shadow-inner">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>SPMB SIT Robbani Ogan Ilir T.A. 2026/2027</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                        Sekolah Berbasis Digital Pertama dengan Pendidikan Karakter di Ogan Ilir
                    </h1>

                    <p class="text-sm sm:text-base text-emerald-100/90 font-medium leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        "Mewujudkan Generasi Cerdas, Mandiri, dan Berakhlak Mulia di Era Digital". Mendidik ananda dengan Kurikulum Merdeka, Kekhasan JSIT, Tahfidz Al-Qur'an, dan Ekosistem Digital SmartEdu.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3.5 pt-2">
                        <a href="{{ route('school.spmb.form') }}" class="px-7 py-3.5 rounded-2xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            <span>📝</span>
                            <span>Isi Formulir SPMB Sekarang</span>
                            <span>➔</span>
                        </a>
                        <a href="#jenjang" class="px-6 py-3.5 rounded-2xl bg-emerald-800/80 hover:bg-emerald-800 text-white border border-emerald-600/60 font-bold text-sm transition-all flex items-center gap-2">
                            <span>🏫</span>
                            <span>Pilih Jenjang Unit</span>
                        </a>
                        <a href="#cek-status" class="px-5 py-3.5 rounded-2xl bg-slate-900/60 hover:bg-slate-900 text-emerald-200 border border-emerald-700/40 font-bold text-sm transition-all flex items-center gap-2">
                            <span>🔍</span>
                            <span>Cek Bukti Pendaftaran</span>
                        </a>
                    </div>

                    <!-- Trust Stats Ribbon -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-6 border-t border-emerald-800/60 text-left">
                        <div class="p-3 rounded-xl bg-emerald-900/40 border border-emerald-700/30">
                            <span class="block text-xl font-black text-amber-300">4 Jenjang</span>
                            <span class="text-[11px] text-emerald-200 font-medium">KB/TK, SD, SMP, SMA</span>
                        </div>
                        <div class="p-3 rounded-xl bg-emerald-900/40 border border-emerald-700/30">
                            <span class="block text-xl font-black text-emerald-300">Akreditasi A</span>
                            <span class="text-[11px] text-emerald-200 font-medium">Standar Unggul JSIT</span>
                        </div>
                        <div class="p-3 rounded-xl bg-emerald-900/40 border border-emerald-700/30">
                            <span class="block text-xl font-black text-amber-300">Tahfidz Qur'an</span>
                            <span class="text-[11px] text-emerald-200 font-medium">Metode Talaqqi & Mutqin</span>
                        </div>
                        <div class="p-3 rounded-xl bg-emerald-900/40 border border-emerald-700/30">
                            <span class="block text-xl font-black text-emerald-300">SmartEdu 100%</span>
                            <span class="text-[11px] text-emerald-200 font-medium">Ekosistem Terintegrasi</span>
                        </div>
                    </div>
                </div>

                <!-- Right Card / Interactive Overview -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-3xl p-6 sm:p-8 text-slate-800 shadow-2xl border border-emerald-100 space-y-6 relative">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <div>
                                <span class="text-[10px] font-black uppercase tracking-wider text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                    Informasi Resmi
                                </span>
                                <h2 class="text-lg font-black text-slate-900 mt-1.5">Penerimaan Siswa Baru</h2>
                            </div>
                            <img src="{{ asset('images/logo robbani light.png') }}" alt="SIT Robbani" class="h-10 w-auto">
                        </div>

                        <!-- Date highlight badge -->
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/80 flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-700 text-white flex items-center justify-center shrink-0 shadow-md">
                                <span class="text-lg">📅</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-emerald-950 uppercase tracking-wide">Waktu Pendaftaran Gelombang 1</h4>
                                <p class="text-base font-black text-emerald-700 mt-0.5">12 September – 31 Desember 2026</p>
                                <p class="text-[11px] text-slate-500 font-medium mt-0.5">Pendaftaran online dibuka 24 jam setiap hari.</p>
                            </div>
                        </div>

                        <!-- Quick List of Units & Fees -->
                        <div class="space-y-2">
                            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wide">Biaya Formulir per Jenjang:</h4>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 flex justify-between items-center">
                                    <span class="font-bold text-slate-700">TPA & KB/TKIT</span>
                                    <span class="font-mono font-black text-emerald-700">Rp 200.000</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 flex justify-between items-center">
                                    <span class="font-bold text-slate-700">SDIT Robbani</span>
                                    <span class="font-mono font-black text-emerald-700">Rp 250.000</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 flex justify-between items-center">
                                    <span class="font-bold text-slate-700">SMPIT Robbani</span>
                                    <span class="font-mono font-black text-emerald-700">Rp 300.000</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 flex justify-between items-center">
                                    <span class="font-bold text-slate-700">SMAIT Robbani</span>
                                    <span class="font-mono font-black text-emerald-700">Rp 350.000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rekening Resmi Yayasan -->
                        <div class="p-3.5 rounded-2xl bg-amber-50/70 border border-amber-200 text-xs space-y-1">
                            <span class="font-black text-amber-900 block text-[11px]">💳 Rekening Resmi Yayasan Generasi Robbani:</span>
                            <div class="font-mono text-slate-800 text-[11px] leading-relaxed">
                                <p><strong class="text-emerald-800">BSI:</strong> 7206858502 a.n. YAYASAN GENERASI ROBBANI</p>
                                <p><strong class="text-emerald-800">Muamalat:</strong> 3610061740 a.n. YAYASAN GENERASI ROBBANI SUMSEL</p>
                            </div>
                        </div>

                        <!-- Direct Form Action -->
                        <a href="{{ route('school.spmb.form') }}" class="w-full py-3.5 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider text-center flex items-center justify-center gap-2 shadow-lg shadow-emerald-700/25 transition-all">
                            <span>Mulai Isi Formulir Pendaftaran</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: JADWAL SPMB & AGENDA -->
    <section id="jadwal" class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Jadwal & Agenda
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Tahapan & Jadwal Lengkap SPMB 2026/2027
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Catat tanggal-tanggal penting agar ananda tidak tertinggal tahapan seleksi penerimaan murid baru SIT Robbani.
                </p>
            </div>

            <!-- Timeline Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <!-- Step 1 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 card-hover space-y-3 relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center shadow-md">
                        01
                    </div>
                    <span class="text-[11px] font-black text-emerald-700 uppercase tracking-wider block">Tahap 1</span>
                    <h3 class="font-black text-base text-slate-900">Pendaftaran Online & Berkas</h3>
                    <p class="text-xs font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-lg w-fit border border-amber-200">
                        12 Sept – 31 Des 2026
                    </p>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Mengisi formulir online lengkap (identitas, sekolah asal, kesehatan, ortu) dan mengunggah berkas persyaratan.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 card-hover space-y-3 relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center shadow-md">
                        02
                    </div>
                    <span class="text-[11px] font-black text-emerald-700 uppercase tracking-wider block">Tahap 2</span>
                    <h3 class="font-black text-base text-slate-900">Tes Kesehatan & Observasi</h3>
                    <p class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit border border-emerald-200">
                        17 Februari 2027
                    </p>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Pemeriksaan fisik/kesehatan dasar serta observasi kesiapan belajar dan pemetaan kemampuan calon siswa baru.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 card-hover space-y-3 relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center shadow-md">
                        03
                    </div>
                    <span class="text-[11px] font-black text-emerald-700 uppercase tracking-wider block">Tahap 3</span>
                    <h3 class="font-black text-base text-slate-900">Wawancara Orang Tua & Pemetaan</h3>
                    <p class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit border border-emerald-200">
                        24 Februari 2027
                    </p>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Wawancara keselarasan visi pendidikan sekolah dan komitmen sinergi orang tua dengan dewan asatidz SIT Robbani.
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 card-hover space-y-3 relative overflow-hidden">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-700 text-white font-black text-sm flex items-center justify-center shadow-md">
                        04
                    </div>
                    <span class="text-[11px] font-black text-emerald-700 uppercase tracking-wider block">Tahap 4</span>
                    <h3 class="font-black text-base text-slate-900">Pengumuman & Daftar Ulang</h3>
                    <p class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg w-fit border border-emerald-200">
                        26 Feb – 21 Maret 2027
                    </p>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Pengumuman hasil kelulusan secara online & pembayaran biaya pendidikan/daftar ulang calon siswa yang diterima.
                    </p>
                </div>
            </div>

            <!-- Additional Agenda Bar -->
            <div class="mt-8 p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200/70 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-700">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📦</span>
                    <div>
                        <strong class="text-slate-900 block font-black">Pembagian Perlengkapan, Buku & Seragam:</strong>
                        <span>01 Mei – 30 Juni 2027 di KPA Kampus SIT Robbani</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🎒</span>
                    <div>
                        <strong class="text-slate-900 block font-black">Hari Pertama Masuk Sekolah & MPLS:</strong>
                        <span>Juli 2027 (Awal Tahun Ajaran 2027/2028)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: SYARAT PENDAFTARAN & PENJELASAN BIAYA -->
    <section id="syarat-biaya" class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-amber-100 text-amber-900 uppercase tracking-wider">
                    Ketentuan Lengkap
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Syarat Pendaftaran & Rincian Biaya
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Ketentuan usia calon peserta didik per 1 Juli 2027, berkas lampiran yang harus disiapkan, dan transparansi biaya pendidikan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                <!-- Left: Syarat Pendaftaran -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-lg">
                            📋
                        </div>
                        <div>
                            <h3 class="font-black text-lg text-slate-900">1. Syarat Usia & Dokumen</h3>
                            <p class="text-xs text-slate-500">Ketentuan minimal usia per 1 Juli 2027</p>
                        </div>
                    </div>

                    <!-- Usia Table -->
                    <div class="space-y-2.5">
                        <h4 class="text-xs font-black text-slate-700 uppercase tracking-wide">Ketentuan Usia Minimal:</h4>
                        <div class="divide-y divide-slate-100 text-xs">
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">TPA Robbani</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Kurang dari 3 thn 7 bln</span>
                            </div>
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">KB (Kelompok Bermain)</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Telah mencapai 3 thn 7 bln</span>
                            </div>
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">TK A Robbani</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Telah mencapai 3 thn 10 bln</span>
                            </div>
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">TK B Robbani</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Telah mencapai 4 thn 10 bln</span>
                            </div>
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">SDIT Robbani</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Telah mencapai 5 thn 10 bln</span>
                            </div>
                            <div class="py-2 flex justify-between items-center">
                                <span class="font-bold text-slate-800">SMPIT Robbani</span>
                                <span class="text-slate-600 bg-slate-100 px-2 py-0.5 rounded font-mono">Telah mencapai 11 thn 10 bln</span>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Checklist -->
                    <div class="space-y-2.5 pt-2">
                        <h4 class="text-xs font-black text-slate-700 uppercase tracking-wide">Kelengkapan Dokumen / Lampiran:</h4>
                        <ul class="space-y-2 text-xs text-slate-600">
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Fotokopi Akte Kelahiran calon siswa (1 lembar / upload digital)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Fotokopi Kartu Keluarga (KK) yang masih berlaku (1 lembar)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Fotokopi KTP Orang Tua (Ayah dan Ibu)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Pas foto berwarna terbaru (3x4 & 2x3 @ 2 lembar / file upload)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Fotokopi Ijazah / Surat Keterangan Lulus dari jenjang sebelumnya (bisa menyusul)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-emerald-600 font-bold">✓</span>
                                <span>Bukti transfer biaya pendaftaran formulir</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right: Penjelasan Biaya & Rekening Pembayaran -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center font-bold text-lg">
                            💳
                        </div>
                        <div>
                            <h3 class="font-black text-lg text-slate-900">2. Rincian & Ketentuan Biaya</h3>
                            <p class="text-xs text-slate-500">Transparan, akuntabel, dan berorientasi manfaat santri</p>
                        </div>
                    </div>

                    <!-- Rekening Box -->
                    <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2.5">
                        <span class="text-[10px] font-black uppercase tracking-wider text-amber-400 block">
                            Rekening Resmi Transfer SPMB
                        </span>
                        <div class="space-y-1.5 font-mono text-xs">
                            <div class="flex justify-between items-center p-2 rounded-xl bg-slate-800/80">
                                <div>
                                    <strong class="text-emerald-400 block text-xs">BANK SYARIAH INDONESIA (BSI)</strong>
                                    <span class="text-slate-300">7206858502</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-sans">a.n. YAYASAN GENERASI ROBBANI</span>
                            </div>
                            <div class="flex justify-between items-center p-2 rounded-xl bg-slate-800/80">
                                <div>
                                    <strong class="text-emerald-400 block text-xs">BANK MUAMALAT</strong>
                                    <span class="text-slate-300">3610061740</span>
                                </div>
                                <span class="text-[10px] text-slate-400 font-sans">a.n. YAYASAN GENERASI ROBBANI SUMATERA SELATAN</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ketentuan Biaya Detail -->
                    <div class="space-y-2 text-xs text-slate-600 leading-relaxed">
                        <p class="font-bold text-slate-900">Komponen Biaya Pendidikan Meliputi:</p>
                        <ul class="list-disc list-inside space-y-1 text-slate-600 pl-1">
                            <li>BPPS (Biaya Penyelenggaraan Pendidikan Sekolah)</li>
                            <li>Paket Seragam Lengkap Sekolah & Olahraga</li>
                            <li>Paket Buku Teks, Modul Belajar, & Panduan Karakter</li>
                            <li>Sarana dan Prasarana Penunjang Pembelajaran Digital</li>
                            <li>Biaya Program Kegiatan Siswa Selama 1 Tahun</li>
                            <li>SPP Bulan Juli (Bulan Pertama Masuk)</li>
                        </ul>

                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-1.5 text-[11px] text-slate-600 mt-3">
                            <p>• Biaya pendaftaran formulir tidak dapat ditarik kembali bila mengundurkan diri.</p>
                            <p>• Pembayaran biaya pendidikan dilakukan paling lambat 2 pekan sejak siswa dinyatakan lulus seleksi.</p>
                            <p>• Pembatalan/pengunduran diri setelah pelunasan biaya pendidikan dikenakan administrasi 30%.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: TUJUAN DAFTAR (PILIHAN JENJANG SIT ROBBANI) -->
    <section id="jenjang" class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Pilihan Unit Sekolah
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Tujuan Pendaftaran Jenjang Pendidikan
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Silakan tentukan jenjang pendidikan yang sesuai dengan usia dan tingkat ananda untuk memulai formulir registrasi.
                </p>
            </div>

            <!-- Grid 6 Units -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 1. TPA ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-purple-100 text-purple-800 uppercase">
                                Usia Dini / Batita
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 200rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">TPA ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Taman Pengasuhan Anak berbasis nilai Qur'ani, pengasuhan hangat, higienis, dan stimulasi motorik terarah sejak dini.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Jl. Sarjana Blok C No 17, Kel. Timbangan, Indralaya Utara & Perum Griya Sejahtera No.5</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'TPA']) }}" class="w-full py-3 rounded-2xl bg-slate-900 hover:bg-emerald-700 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                        <span>Daftar TPA Sekarang</span> <span>➔</span>
                    </a>
                </div>

                <!-- 2. KB ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-pink-100 text-pink-800 uppercase">
                                Kelompok Bermain
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 200rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">KB ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Bermain sambil belajar dengan penanaman adab islami, kemandirian anak, sosialisasi positif, dan hafalan doa harian.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Jalan Sarjana Blok C No 14, Kel. Timbangan, Kec. Indralaya Utara, Ogan Ilir</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'KB']) }}" class="w-full py-3 rounded-2xl bg-slate-900 hover:bg-emerald-700 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                        <span>Daftar KB Sekarang</span> <span>➔</span>
                    </a>
                </div>

                <!-- 3. TKIT ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-800 uppercase">
                                TK Islam Terpadu
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 200rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">TKIT ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Fondasi tauhid, tahsin & tahfidz Juz 'Amma, pra-literasi calistung ceria, dan pembiasaan sholat fardhu sejak usia dini.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Jalan Sarjana Blok C No 14, Kel. Timbangan, Kec. Indralaya Utara, Ogan Ilir</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'TKIT']) }}" class="w-full py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-md">
                        <span>Daftar TKIT Sekarang</span> <span>➔</span>
                    </a>
                </div>

                <!-- 4. SDIT ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 uppercase">
                                SD Islam Terpadu
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 250rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SDIT ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Kurikulum Merdeka berpadu Kurikulum JSIT, Full Day School, Target Hafalan Al-Qur'an 3 Juz, Bina Pribadi Islami (BPI), dan Science Club.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Jalan Sarjana Blok A, Kel. Timbangan, Kec. Indralaya Utara, Ogan Ilir</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'SDIT']) }}" class="w-full py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-md">
                        <span>Daftar SDIT Sekarang</span> <span>➔</span>
                    </a>
                </div>

                <!-- 5. SMPIT ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-cyan-100 text-cyan-800 uppercase">
                                SMP Islam Terpadu
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 300rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SMPIT ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Kepemimpinan remaja qur'ani, bilingual Arabic & English, hafalan mutqin minimal 5 Juz, IT Coding & Olimpiade Sains Nasional.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Jalan Sarjana Padang Guci, Kel. Timbangan, Kec. Indralaya Utara, Ogan Ilir</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'SMPIT']) }}" class="w-full py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-md">
                        <span>Daftar SMPIT Sekarang</span> <span>➔</span>
                    </a>
                </div>

                <!-- 6. SMAIT ROBBANI -->
                <div class="bg-slate-50 rounded-3xl p-6 border border-slate-200/80 card-hover flex flex-col justify-between space-y-5">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black bg-indigo-100 text-indigo-800 uppercase">
                                SMA Islam Terpadu
                            </span>
                            <span class="font-mono font-black text-emerald-700 text-xs">Biaya: Rp 350rb</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">SMAIT ROBBANI</h3>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">
                            Mencetak calon pemimpin peradaban, persiapan tembus PTN Favorit & Kampus Timur Tengah, riset ilmiah, dan pembinaan karakter matang.
                        </p>
                        <div class="p-3 rounded-2xl bg-white border border-slate-200/70 text-[11px] text-slate-600 flex items-start gap-2">
                            <span class="text-sm">📍</span>
                            <span>Kampus Terpadu Yayasan Generasi Robbani, Indralaya, Ogan Ilir</span>
                        </div>
                    </div>
                    <a href="{{ route('school.spmb.form', ['unit' => 'SMAIT']) }}" class="w-full py-3 rounded-2xl bg-slate-900 hover:bg-emerald-700 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 transition-colors shadow-sm">
                        <span>Daftar SMAIT Sekarang</span> <span>➔</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: LAYANAN DIGITAL TERBAIK SIT ROBBANI (SmartEdu Ecosystem) -->
    <section id="layanan-digital" class="py-16 sm:py-24 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-900 text-emerald-300 uppercase tracking-wider border border-emerald-700">
                    Ekosistem SmartEdu
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Layanan Digital Unggulan yang Akan Anda Dapatkan
                </h2>
                <p class="text-xs sm:text-sm text-slate-400 font-medium">
                    SIT Robbani menghadirkan teknologi mutakhir untuk kemudahan akses pembelajaran, presensi, keuangan, dan komunikasi wali murid.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <!-- 1 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-emerald-900/60 text-emerald-400 flex items-center justify-center text-xl">
                        📖
                    </div>
                    <h4 class="font-black text-sm text-white">E-Learning</h4>
                    <p class="text-[11px] text-slate-400">Modul, tugas, & kelas interaktif online</p>
                </div>

                <!-- 2 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-teal-900/60 text-teal-400 flex items-center justify-center text-xl">
                        📚
                    </div>
                    <h4 class="font-black text-sm text-white">E-Library</h4>
                    <p class="text-[11px] text-slate-400">Ribuan koleksi buku digital & literasi</p>
                </div>

                <!-- 3 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-900/60 text-blue-400 flex items-center justify-center text-xl">
                        ✉️
                    </div>
                    <h4 class="font-black text-sm text-white">E-Surat</h4>
                    <p class="text-[11px] text-slate-400">Permohonan surat & verifikasi QR code</p>
                </div>

                <!-- 4 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-900/60 text-amber-400 flex items-center justify-center text-xl">
                        💰
                    </div>
                    <h4 class="font-black text-sm text-white">E-Tabungan</h4>
                    <p class="text-[11px] text-slate-400">Catatan tabungan santri transparan</p>
                </div>

                <!-- 5 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-purple-900/60 text-purple-400 flex items-center justify-center text-xl">
                        📊
                    </div>
                    <h4 class="font-black text-sm text-white">E-Akademik</h4>
                    <p class="text-[11px] text-slate-400">Rapor berkala & perkembangan karakter</p>
                </div>

                <!-- 6 -->
                <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 text-center space-y-2.5 card-hover">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-rose-900/60 text-rose-400 flex items-center justify-center text-xl">
                        ⏰
                    </div>
                    <h4 class="font-black text-sm text-white">E-Presensi</h4>
                    <p class="text-[11px] text-slate-400">Absensi digital real-time & notifikasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: ALUR PENDAFTARAN -->
    <section id="alur" class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Alur Mudah & Cepat
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    5 Langkah Mudah Mendaftar SPMB Online
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Proses pendaftaran dirancang sistematis, cepat, dan dapat diakses dari smartphone tanpa perlu antre panjang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 relative">
                <!-- Step 1 -->
                <div class="text-center p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-700 text-white font-black text-base flex items-center justify-center shadow-md">
                        1
                    </div>
                    <h4 class="font-black text-sm text-slate-900">Isi Formulir</h4>
                    <p class="text-[11px] text-slate-500">Lengkapi data diri calon siswa, riwayat kesehatan, dan data orang tua.</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-700 text-white font-black text-base flex items-center justify-center shadow-md">
                        2
                    </div>
                    <h4 class="font-black text-sm text-slate-900">Transfer Biaya</h4>
                    <p class="text-[11px] text-slate-500">Transfer biaya pendaftaran formulir ke rekening resmi BSI / Muamalat.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-700 text-white font-black text-base flex items-center justify-center shadow-md">
                        3
                    </div>
                    <h4 class="font-black text-sm text-slate-900">Tes & Wawancara</h4>
                    <p class="text-[11px] text-slate-500">Mengikuti observasi kesiapan belajar anak & wawancara pemetaan wali murid.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-700 text-white font-black text-base flex items-center justify-center shadow-md">
                        4
                    </div>
                    <h4 class="font-black text-sm text-slate-900">Pengumuman</h4>
                    <p class="text-[11px] text-slate-500">Cek pengumuman kelulusan di portal SPMB dan konfirmasi daftar ulang.</p>
                </div>

                <!-- Step 5 -->
                <div class="text-center p-5 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-3">
                    <div class="w-12 h-12 mx-auto rounded-full bg-emerald-700 text-white font-black text-base flex items-center justify-center shadow-md">
                        5
                    </div>
                    <h4 class="font-black text-sm text-slate-900">Masuk Sekolah</h4>
                    <p class="text-[11px] text-slate-500">Ambil buku & seragam, ikuti MPLS ceria, dan ananda siap bersekolah!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: CEK STATUS PENDAFTARAN & CETAK BUKTI PDF -->
    <section id="cek-status" class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl space-y-6">
                <div class="text-center max-w-xl mx-auto space-y-2">
                    <span class="w-12 h-12 mx-auto rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xl shadow-sm">
                        🔍
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                        Cek Status Pendaftaran & Unduh Formulir PDF
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        Sudah pernah mendaftar? Masukkan Nomor Registrasi SPMB atau Nomor HP Orang Tua untuk melihat status verifikasi & cetak formulir resmi.
                    </p>
                </div>

                <!-- Search Input Box -->
                <form @submit.prevent="checkStatus()" class="max-w-xl mx-auto flex flex-col sm:flex-row gap-2.5">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            x-model="searchQuery" 
                            placeholder="Contoh: SPMB-2026-SDIT-12345 atau No. HP" 
                            class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold font-mono focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white transition-all"
                            required
                        >
                    </div>
                    <button 
                        type="submit" 
                        :disabled="isLoading"
                        class="px-6 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 disabled:opacity-50 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2 shrink-0"
                    >
                        <span x-show="!isLoading">Cari Data Registrasi ➔</span>
                        <span x-show="isLoading" x-cloak>Mencari...</span>
                    </button>
                </form>

                <!-- Search Result Alert / Card -->
                <div x-show="searchResult" x-cloak class="max-w-xl mx-auto p-5 rounded-2xl border" :class="searchResult?.found ? 'bg-emerald-50/70 border-emerald-200' : 'bg-rose-50/70 border-rose-200'">
                    <template x-if="searchResult?.found">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b border-emerald-200/60 pb-3">
                                <div>
                                    <span class="text-[10px] font-black text-emerald-800 uppercase tracking-wider block">Data Ditemukan</span>
                                    <h4 class="text-base font-black text-slate-900" x-text="searchResult.registration.full_name"></h4>
                                </div>
                                <span class="px-3 py-1 rounded-full text-[10px] font-black" :class="{
                                    'bg-emerald-600 text-white': searchResult.registration.status === 'PASSED',
                                    'bg-amber-500 text-white': searchResult.registration.status === 'PENDING',
                                    'bg-rose-600 text-white': searchResult.registration.status === 'REJECTED'
                                }" x-text="searchResult.registration.status === 'PASSED' ? '✓ DITERIMA / LULUS' : (searchResult.registration.status === 'PENDING' ? '⏳ VERIFIKASI BERKAS' : 'TIDAK DITERIMA')"></span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div>
                                    <span class="text-[10px] text-slate-500 block">No. Registrasi:</span>
                                    <span class="font-mono font-bold text-slate-900" x-text="searchResult.registration.registration_number"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 block">Jenjang Tujuan:</span>
                                    <span class="font-bold text-emerald-800" x-text="searchResult.registration.target_level"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 block">Nama Orang Tua:</span>
                                    <span class="font-bold text-slate-800" x-text="searchResult.registration.parent_name"></span>
                                </div>
                                <div>
                                    <span class="text-[10px] text-slate-500 block">Biaya Formulir:</span>
                                    <span class="font-mono font-bold text-slate-800" x-text="'Rp ' + Number(searchResult.registration.registration_fee).toLocaleString('id-ID')"></span>
                                </div>
                            </div>

                            <div class="pt-2 flex flex-col sm:flex-row gap-2">
                                <a :href="searchResult.registration.pdf_url" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 shadow-sm">
                                    <span>🖨️</span> Cetak Formulir & Bukti PDF
                                </a>
                                <a href="https://wa.me/62811747472?text=Assalamu'alaikum%20saya%20ingin%20konfirmasi%20SPMB" target="_blank" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs text-center flex items-center justify-center gap-1.5 shadow-sm">
                                    <span>💬</span> Konfirmasi via WhatsApp
                                </a>
                            </div>
                        </div>
                    </template>
                    <template x-if="searchResult && !searchResult?.found">
                        <div class="text-center py-2 space-y-1 text-xs text-rose-800">
                            <span class="text-lg">⚠️</span>
                            <p class="font-bold" x-text="searchResult.message || 'Data registrasi tidak ditemukan.'"></p>
                            <p class="text-[11px] text-rose-600">Pastikan nomor registrasi sesuai dengan bukti yang Anda terima saat mendaftar.</p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION: FAQ ACCORDION -->
    <section class="py-16 sm:py-24 bg-white border-b border-slate-200/80">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="text-center space-y-3">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-slate-100 text-slate-700 uppercase tracking-wider">
                    Pertanyaan Umum
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Frequently Asked Questions (FAQ)
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 font-medium">
                    Jawaban seputar pendaftaran, tes observasi, dan pembayaran biaya pendidikan SIT Robbani.
                </p>
            </div>

            <div class="space-y-3 text-xs" x-data="{ activeFaq: null }">
                <!-- FAQ 1 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 1 ? null : 1)" class="w-full p-4 text-left font-black text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Apakah pendaftaran dilakukan 100% online?</span>
                        <span x-text="activeFaq === 1 ? '▲' : '▼'" class="text-slate-400"></span>
                    </button>
                    <div x-show="activeFaq === 1" x-cloak class="p-4 pt-0 text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50">
                        Ya, pendaftaran awal dapat dilakukan sepenuhnya secara online melalui portal ini. Orang tua hanya perlu hadir saat pelaksanaan Observasi Calon Siswa & Wawancara Pemetaan Orang Tua di kampus SIT Robbani.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 2 ? null : 2)" class="w-full p-4 text-left font-black text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Bagaimana jika usia anak kurang beberapa bulan dari syarat minimal?</span>
                        <span x-text="activeFaq === 2 ? '▲' : '▼'" class="text-slate-400"></span>
                    </button>
                    <div x-show="activeFaq === 2" x-cloak class="p-4 pt-0 text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50">
                        Untuk calon siswa yang usianya mendekati syarat batas (kurang dari 2-3 bulan), keputusan penerimaan akan dipertimbangkan melalui rekomendasi psikolog atau hasil observasi kesiapan psikologis belajar oleh tim guru SIT Robbani.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 3 ? null : 3)" class="w-full p-4 text-left font-black text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Apakah biaya pendidikan dapat diangsur?</span>
                        <span x-text="activeFaq === 3 ? '▲' : '▼'" class="text-slate-400"></span>
                    </button>
                    <div x-show="activeFaq === 3" x-cloak class="p-4 pt-0 text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50">
                        Ya, panitia menyediakan skema angsuran biaya pendidikan setelah siswa dinyatakan lulus. Pembayaran angsuran pertama dilakukan maksimal 2 pekan setelah pengumuman, dan pelunasan sesuai jadwal kesepakatan daftar ulang.
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="border border-slate-200 rounded-2xl overflow-hidden">
                    <button @click="activeFaq = (activeFaq === 4 ? null : 4)" class="w-full p-4 text-left font-black text-slate-900 flex justify-between items-center hover:bg-slate-50 transition-colors">
                        <span>Bagaimana jika bukti pendaftaran atau nomor registrasi saya hilang?</span>
                        <span x-text="activeFaq === 4 ? '▲' : '▼'" class="text-slate-400"></span>
                    </button>
                    <div x-show="activeFaq === 4" x-cloak class="p-4 pt-0 text-slate-600 leading-relaxed border-t border-slate-100 bg-slate-50/50">
                        Anda dapat memasukkan Nomor WhatsApp Orang Tua yang didaftarkan pada kolom "Cek Status" di atas, atau menghubungi Customer Service WhatsApp di <strong>0811747472</strong> untuk cetak ulang dokumen.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-14 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1: Identity -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-10 w-auto">
                        <div>
                            <strong class="text-white block text-sm font-black">YAYASAN GENERASI ROBBANI SUMATERA SELATAN</strong>
                            <span class="text-[11px] text-slate-400">Official SPMB Portal SIT Robbani Ogan Ilir</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-md">
                        Mendidik tunas bangsa dengan integrasi nilai Al-Qur'an, adab mulia, prestasi sains-teknologi, dan kecakapan digital terdepan di Kabupaten Ogan Ilir, Sumatera Selatan.
                    </p>
                    <div class="flex items-center gap-3 text-emerald-400 font-bold text-xs">
                        <a href="https://wa.me/62811747472" target="_blank" class="hover:text-emerald-300">WA: 0811747472</a>
                        <span>•</span>
                        <a href="mailto:info@sitrobbani.sch.id" class="hover:text-emerald-300">info@sitrobbani.sch.id</a>
                        <span>•</span>
                        <a href="{{ route('home') }}" class="hover:text-emerald-300">Website Utama ↗</a>
                    </div>
                </div>

                <!-- Col 2: Unit Pendidikan -->
                <div class="space-y-3">
                    <strong class="text-white block font-black text-xs uppercase tracking-wider">Unit Pendidikan</strong>
                    <ul class="space-y-2 text-slate-400 text-xs">
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'TPA']) }}" class="hover:text-white transition-colors">TPA Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'KB']) }}" class="hover:text-white transition-colors">KB Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'TKIT']) }}" class="hover:text-white transition-colors">TKIT Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'SDIT']) }}" class="hover:text-white transition-colors">SDIT Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'SMPIT']) }}" class="hover:text-white transition-colors">SMPIT Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.spmb.form', ['unit' => 'SMAIT']) }}" class="hover:text-white transition-colors">SMAIT Robbani Ogan Ilir</a></li>
                    </ul>
                </div>

                <!-- Col 3: Akses Cepat -->
                <div class="space-y-3">
                    <strong class="text-white block font-black text-xs uppercase tracking-wider">Akses Cepat</strong>
                    <ul class="space-y-2 text-slate-400 text-xs">
                        <li><a href="{{ route('school.spmb.form') }}" class="hover:text-white transition-colors">Formulir SPMB Online</a></li>
                        <li><a href="#jadwal" class="hover:text-white transition-colors">Jadwal Seleksi Gelombang 1</a></li>
                        <li><a href="#syarat-biaya" class="hover:text-white transition-colors">Syarat & Biaya Pendidikan</a></li>
                        <li><a href="#cek-status" class="hover:text-white transition-colors">Cek Status & Unduh Formulir PDF</a></li>
                        <li><a href="{{ route('login') }}" class="text-slate-500 hover:text-slate-300 transition-colors">Login Admin / Panitia</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-3 text-[11px] text-slate-500">
                <p>&copy; {{ date('Y') }} Yayasan Generasi Robbani Sumatera Selatan. All Rights Reserved.</p>
                <p>Ekosistem Pendidikan Digital Powered by SmartEdu</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Landing Page Logic -->
    <script>
        function spmbLandingApp() {
            return {
                searchQuery: '',
                isLoading: false,
                searchResult: null,

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
    </script>
</body>
</html>
