<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>SPMB SIT Robbani Ogan Ilir T.A 2026/2027 | Sistem Penerimaan Murid Baru</title>
    <meta name="description" content="Official Portal Sistem Penerimaan Murid Baru (SPMB) Sekolah Islam Terpadu Robbani Ogan Ilir T.A 2026/2027. Jenjang TPA, KB, TKIT, SDIT, SMPIT, dan SMAIT.">
    
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

        /* Hero Background with Islamic Pattern & Modern Depth */
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

    <!-- 1. TOP ANNOUNCEMENT BAR (RATA TENGAH DI HP, DINAMIS CMS) -->
    <div class="bg-emerald-950 text-emerald-200 text-xs py-2 px-4 border-b border-emerald-900/60">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-center sm:justify-between text-xs gap-1.5 sm:gap-0 text-center sm:text-left">
            <div class="flex items-center justify-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-950 uppercase tracking-wide">
                    {{ $spmb['announcement_badge'] ?? 'Gelombang 1' }}
                </span>
                <span class="font-bold text-xs text-white">
                    {{ $spmb['announcement_date'] ?? '12 Sept – 31 Des 2026' }}
                </span>
            </div>
            <a href="{{ $spmb['wa_link'] ?? 'https://wa.me/62811747472' }}" target="_blank" class="text-[11px] sm:text-xs font-bold text-emerald-300 hover:text-white transition-colors">
                WA Panitia: {{ $spmb['wa_number'] ?? '0811-747-472' }}
            </a>
        </div>
    </div>

    <!-- 2. HEADER NAVIGASI (SIMPLE & RAPI, TIDAK TERPOTONG) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex items-center justify-between h-14 sm:h-16">
                <!-- Brand / Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0" title="Beranda SPMB SIT Robbani">
                    <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-8 sm:h-10 w-auto object-contain" onerror="this.src='{{ asset('favicon.png') }}'">
                    <span class="font-black text-sm sm:text-base tracking-tight text-emerald-950 uppercase">{{ $spmb['brand_title'] ?? 'SPMB ROBBANI' }}</span>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                    <a href="#daftar" class="hover:text-emerald-700 transition-colors">Pilihan Unit</a>
                    <a href="#program" class="hover:text-emerald-700 transition-colors">Program</a>
                    <a href="#syarat-biaya" class="hover:text-emerald-700 transition-colors">Syarat Berkas</a>
                    <a href="#cek-status" class="hover:text-emerald-700 transition-colors">Cek Status</a>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-2">
                    <a href="https://sitrobbani.sch.id" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-700 hover:text-emerald-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all" title="Kunjungi Website Utama SIT Robbani">
                        <span>🌐 Web Utama</span>
                    </a>
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

    <!-- 3. HERO UTAMA (RATA TENGAH DI HP, KONTEN DINAMIS DARI DASHBOARD ADMIN) -->
    <section class="relative hero-bg text-white pt-8 pb-14 sm:pt-16 sm:pb-20 overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Teks Hero -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-6 text-center lg:text-left flex flex-col items-center lg:items-start">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-800/90 border border-emerald-600/60 text-emerald-200 text-xs font-bold shadow-sm mx-auto lg:mx-0">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>{{ $spmb['hero_badge'] ?? 'SPMB Online SIT Robbani T.A. 2026/2027' }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight text-center lg:text-left">
                        {{ $spmb['hero_title'] ?? 'Sekolah Berbasis Digital Pertama dengan Pendidikan Karakter di Ogan Ilir' }}
                    </h1>

                    <p class="text-xs sm:text-base text-emerald-100/95 font-medium leading-relaxed max-w-xl mx-auto lg:mx-0 text-center lg:text-left">
                        {{ $spmb['hero_desc'] ?? '"Mewujudkan Generasi Cerdas dan Berakhlak Mulia di Era Digital". Pendaftaran mudah dari HP Anda, tanpa repot antre panjang.' }}
                    </p>

                    <!-- Tombol Aksi Hero (Teks Singkat, Bebas Terpotong, Rata Tengah di Mobile) -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 w-full sm:w-auto">
                        <a href="#daftar" class="btn-responsive w-full sm:w-auto px-7 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/25 transition-all transform hover:-translate-y-0.5">
                            <span>👉 Pilih Unit Sekolah</span>
                        </a>
                        <a href="#cek-status" class="btn-responsive w-full sm:w-auto px-6 py-3.5 rounded-2xl bg-emerald-800/90 hover:bg-emerald-800 text-white border border-emerald-600/70 font-bold text-sm transition-all">
                            <span>🔍 Cek Status Pendaftaran</span>
                        </a>
                    </div>

                    <!-- 3 Poin Kemudahan (Rata Tengah di HP) -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-2.5 text-[11px] font-bold text-emerald-200 text-center">
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">{{ $spmb['hero_point1'] ?? '✓ Bisa Daftar dari HP' }}</span>
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">{{ $spmb['hero_point2'] ?? '✓ Berkas Cukup Difoto' }}</span>
                        <span class="px-3 py-1 rounded-lg bg-emerald-900/70 border border-emerald-700/50">{{ $spmb['hero_point3'] ?? '✓ Bantuan Panitia 24 Jam' }}</span>
                    </div>
                </div>

                <!-- Ilustrasi Santri / Mascot -->
                <div class="lg:col-span-5 flex justify-center lg:justify-end fade-up delay-1">
                    <div class="relative">
                        <div class="w-64 h-64 sm:w-80 sm:h-80 rounded-full bg-gradient-to-tr from-emerald-500/20 to-amber-400/20 blur-2xl absolute inset-0 m-auto pointer-events-none"></div>
                        <img 
                            src="{{ asset(ltrim($spmb['hero_image'] ?? 'images/spmb/hero-kid.webp', '/')) }}" 
                            alt="Siswa SIT Robbani" 
                            class="relative z-10 w-60 sm:w-72 md:w-80 h-auto object-contain mx-auto filter drop-shadow-2xl transform hover:scale-105 transition-transform duration-500"
                            onerror="this.src='{{ asset('images/logo robbani light.png') }}'"
                        >
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. SECTION: PILIHAN UNIT SEKOLAH (DINAMIS CMS & RATA TENGAH DI HP) -->
    <section id="daftar" class="py-14 sm:py-20 bg-slate-100/70 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
            
            <!-- Judul Section -->
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

            <!-- Grid Kartu Unit Dinamis dari CMS Admin Dashboard (Sesuai Referensi Pengguna) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($spmb['units'] as $uCode => $unit)
                    @if(!empty($unit['is_active']))
                        <div class="group bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/90 hover:border-emerald-500 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between space-y-6 fade-up text-center">
                            <div class="space-y-3">
                                <!-- Nama Unit (Hanya 1 Kalimat Sesuai Permintaan) -->
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                                    {{ $unit['name'] ?? $uCode }}
                                </h3>

                                <!-- Alamat Lengkap Unit -->
                                <p class="text-[11px] sm:text-xs text-slate-600 font-medium leading-relaxed px-1 min-h-[52px] flex items-center justify-center">
                                    {{ $unit['address'] ?? '' }}
                                </p>

                                <!-- Mascot Character Circle (Ukuran Lebih Besar Menonjol Sesuai Referensi) -->
                                <div class="py-4 flex items-center justify-center">
                                    <div class="relative w-52 h-52 sm:w-60 sm:h-60 flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
                                        <img 
                                            src="{{ asset(ltrim($unit['image'] ?? '', '/')) }}?v=5" 
                                            alt="{{ $unit['name'] ?? $uCode }}" 
                                            class="w-full h-full object-contain filter drop-shadow-md"
                                            onerror="this.src='{{ asset('images/logo robbani light.png') }}'"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Daftar Sekarang Sesuai Desain Referensi -->
                            <div>
                                <a href="{{ url('/daftar?unit=' . ($unit['code'] ?? $uCode)) }}" class="w-full py-3.5 px-6 rounded-2xl bg-[#004532] hover:bg-[#065f46] text-white font-extrabold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group/btn">
                                    <span class="text-base">👆</span>
                                    <span>Daftar Sekarang</span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. SECTION: PROGRAM UNGGULAN (DIPERBESAR & TAMBAH 1 KEUNGGULAN AI) -->
    <section id="program" class="py-14 sm:py-20 bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-10">
            <div class="text-center space-y-2 fade-up">
                <span class="px-3.5 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase tracking-wider">
                    Program Unggulan
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $spmb['program_title'] ?? 'Keunggulan Sekolah Islam Terpadu Robbani' }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 max-w-xl mx-auto font-medium">
                    {{ $spmb['program_desc'] ?? 'Kombinasi kurikulum nasional berstandar, kekhasan JSIT, nilai Al-Qur\'an, dan teknologi modern.' }}
                </p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-5 items-stretch">
                @foreach($spmb['programs'] as $prog)
                    <div class="group p-4 sm:p-5 rounded-3xl bg-slate-50 border border-slate-200/90 hover:bg-white text-center hover:shadow-xl hover:border-emerald-300 transition-all duration-300 fade-up flex flex-col justify-between h-full">
                        <div class="space-y-3 flex flex-col items-center">
                            <div class="w-28 h-28 sm:w-32 sm:h-32 lg:w-32 lg:h-32 xl:w-36 xl:h-36 mx-auto flex items-center justify-center p-1 rounded-2xl bg-white shadow-sm border border-slate-100 group-hover:scale-105 transition-transform duration-300 shrink-0">
                                <img 
                                    src="{{ asset(ltrim($prog['image'] ?? '', '/')) }}" 
                                    alt="{{ $prog['title'] ?? '' }}" 
                                    class="w-full h-full object-contain filter drop-shadow-sm"
                                    onerror="this.src='{{ asset('images/logo robbani light.png') }}'"
                                >
                            </div>
                            <h3 class="font-black text-xs sm:text-sm text-slate-900 leading-snug text-center min-h-[36px] sm:min-h-[40px] flex items-center justify-center px-1">
                                {{ $prog['title'] ?? '' }}
                            </h3>
                        </div>
                        <div class="mt-3 pt-2.5 border-t border-slate-200/60 min-h-[42px] flex items-center justify-center">
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug text-center font-medium">
                                {{ $prog['desc'] ?? '' }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 6. SECTION: SYARAT BERKAS & REKENING RESMI (DINAMIS CMS & RATA TENGAH DI HP) -->
    <section id="syarat-biaya" class="py-14 sm:py-20 bg-slate-50 border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                <!-- Syarat & Berkas -->
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-5 fade-up delay-1 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-start gap-3 border-b border-slate-100 pb-4 text-center sm:text-left">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl font-bold shrink-0 mx-auto sm:mx-0">
                            📋
                        </span>
                        <div>
                            <h3 class="font-black text-lg text-slate-900">{{ $spmb['syarat_title'] ?? 'Kelengkapan Berkas Pendaftaran' }}</h3>
                            <p class="text-xs text-slate-500">{{ $spmb['syarat_desc'] ?? 'Cukup difoto menggunakan kamera HP Anda' }}</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs text-slate-700">
                        @foreach($spmb['syarat_items'] as $sIdx => $sItem)
                        <div class="p-3.5 rounded-2xl {{ $loop->first ? 'bg-emerald-50/80 border border-emerald-300' : 'bg-slate-50 border border-slate-200' }} flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2 sm:gap-3">
                            <span class="text-emerald-700 font-black text-base shrink-0">✓</span>
                            <div>
                                <strong class="{{ $loop->first ? 'text-emerald-950 font-black' : 'text-slate-900 font-bold' }} text-xs block">
                                    {{ $sIdx + 1 }}. {{ $sItem['title'] }} {{ !empty($sItem['is_mandatory']) ? '(Wajib)' : '' }}
                                </strong>
                                <span class="text-[11px] {{ $loop->first ? 'text-emerald-800 font-medium' : 'text-slate-500' }}">
                                    {{ $sItem['desc'] }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200 text-xs text-amber-950 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2.5">
                        <span class="text-lg shrink-0">💡</span>
                        <p class="leading-relaxed text-[11px]">
                            <strong>Tips untuk Orang Tua:</strong> {{ $spmb['syarat_tips'] ?? 'Tidak perlu mesin scanner atau pergi ke warnet. Semua dokumen cukup difoto dengan kamera HP Anda.' }}
                        </p>
                    </div>
                </div>

                <!-- Rekening Pembayaran Resmi Yayasan -->
                <div class="bg-gradient-to-br from-emerald-900 to-emerald-950 text-white rounded-3xl p-6 sm:p-8 border border-emerald-800 shadow-xl space-y-6 fade-up delay-2 text-center sm:text-left">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-start gap-3 border-b border-emerald-800/80 pb-4 text-center sm:text-left">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-800 text-amber-300 flex items-center justify-center text-2xl font-bold shrink-0 mx-auto sm:mx-0">
                            💳
                        </span>
                        <div>
                            <h3 class="font-black text-lg text-white">Rekening Resmi Pembayaran</h3>
                            <p class="text-xs text-emerald-200">Yayasan Generasi Robbani Sumatera Selatan</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($spmb['banks'] as $bank)
                        <div class="p-4 sm:p-5 rounded-2xl bg-emerald-900/60 border border-emerald-700/60 space-y-2 text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-2">
                                <span class="text-xs font-bold text-emerald-300">{{ $bank['bank_name'] }}</span>
                                <button @click="copyToClipboard('{{ $bank['account_number'] }}', '{{ $bank['bank_name'] }}')" type="button" class="px-3 py-1 rounded-xl bg-emerald-800 hover:bg-emerald-700 text-white text-[11px] font-bold transition-all shadow-xs">
                                    <span x-text="copiedBank === '{{ $bank['bank_name'] }}' ? '✓ Tersalin' : 'Salin Nomor'"></span>
                                </button>
                            </div>
                            <div class="font-mono text-2xl sm:text-3xl font-black text-amber-300 tracking-wider">
                                {{ $bank['account_number'] }}
                            </div>
                            <p class="text-xs text-emerald-200">a.n. <strong>{{ $bank['account_holder'] }}</strong></p>
                        </div>
                        @endforeach
                    </div>

                    <!-- Ketentuan Singkat -->
                    <div class="p-3.5 rounded-2xl bg-emerald-950 border border-emerald-800 text-[11px] text-emerald-200 leading-relaxed space-y-1 text-center sm:text-left">
                        <p>• {{ $spmb['payment_note'] ?? 'Rincian biaya formulir pendaftaran tertera langsung pada halaman formulir isian masing-masing unit.' }}</p>
                        <p>• Pembayaran juga dapat dilakukan langsung di Kantor Pusat Administrasi (KPA) SIT Robbani Ogan Ilir.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 7. SECTION: CEK STATUS PENDAFTARAN & UNDUH FORMULIR PDF (RATA TENGAH DI HP) -->
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
                        class="w-full px-4 py-3.5 rounded-2xl bg-white border border-slate-300 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600 transition-all text-center sm:text-left"
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
            <div x-show="searchResult" x-cloak class="p-5 sm:p-6 rounded-3xl border transition-all text-center sm:text-left" :class="searchResult?.found ? 'bg-white border-emerald-200 shadow-md' : 'bg-rose-50 border-rose-200'">
                
                <!-- Ditemukan -->
                <template x-if="searchResult?.found">
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row items-center justify-between border-b border-slate-100 pb-3 gap-2 text-center sm:text-left">
                            <div>
                                <span class="text-[10px] font-black text-emerald-700 uppercase tracking-wider block">Data Pendaftaran Ditemukan</span>
                                <h4 class="text-lg font-black text-slate-900" x-text="searchResult.registration.full_name"></h4>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase inline-block mx-auto sm:mx-0" :class="{
                                'bg-emerald-100 text-emerald-800': searchResult.registration.status === 'PASSED',
                                'bg-amber-100 text-amber-800': searchResult.registration.status === 'PENDING',
                                'bg-rose-100 text-rose-800': searchResult.registration.status === 'REJECTED'
                            }" x-text="searchResult.registration.status === 'PASSED' ? '✓ Diterima / Lulus' : (searchResult.registration.status === 'PENDING' ? '⏳ Verifikasi Berkas' : 'Belum Lulus')"></span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs text-center sm:text-left">
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
                        <div class="pt-2 flex flex-col sm:flex-row gap-2.5 justify-center sm:justify-start">
                            <a :href="searchResult.registration.pdf_url" target="_blank" class="btn-responsive w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-bold text-xs shadow-sm">
                                <span>🖨️ Unduh Formulir PDF</span>
                            </a>
                            <a :href="'https://wa.me/{{ preg_replace('/[^0-9]/', '', $spmb['wa_number'] ?? '62811747472') }}?text=' + encodeURIComponent('Assalamu\'alaikum saya ingin konfirmasi SPMB ' + (searchResult.registration.registration_number || ''))" target="_blank" class="btn-responsive w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm">
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

    <!-- 8. SECTION: TESTIMONI WALI MURID (DINAMIS CMS & RATA TENGAH DI HP) -->
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
                @foreach($spmb['testimonials'] as $testi)
                    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4 fade-up text-center sm:text-left">
                        <p class="text-xs text-slate-600 leading-relaxed italic text-center sm:text-left">
                            "{{ $testi['quote'] ?? '' }}"
                        </p>
                        <div class="border-t border-slate-100 pt-3 flex flex-col sm:flex-row items-center sm:items-start justify-center sm:justify-start gap-3 text-center sm:text-left">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-black flex items-center justify-center text-xs shrink-0 mx-auto sm:mx-0">
                                {{ $testi['initials'] ?? substr($testi['name'] ?? 'W', 0, 2) }}
                            </div>
                            <div>
                                <strong class="text-xs font-black text-slate-900 block">{{ $testi['name'] ?? '' }}</strong>
                                <span class="text-[10px] text-slate-400">{{ $testi['role'] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 9. SECTION: BANTUAN WHATSAPP LANGSUNG (RATA TENGAH) -->
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
                <a href="{{ $spmb['wa_link'] ?? 'https://wa.me/62811747472' }}" target="_blank" class="btn-responsive px-6 py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg shadow-emerald-600/25 transition-all">
                    <span>💬 Hubungi Panitia via WhatsApp ({{ $spmb['wa_number'] ?? '0811-747-472' }})</span>
                </a>
            </div>
        </div>
    </section>

    <!-- 10. FOOTER (MODERN 4-COLUMN INSTITUTIONAL FOOTER) -->
    <footer class="bg-slate-950 text-slate-300 text-xs pt-16 pb-12 border-t border-slate-800/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-12">
            <!-- 4 Columns Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
                
                <!-- Col 1: Brand & Foundation -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-10 w-auto" onerror="this.src='{{ asset('favicon.png') }}'">
                        <div>
                            <span class="text-white font-black text-sm block tracking-tight leading-snug">SIT ROBBANI</span>
                            <span class="text-[10px] text-emerald-400 font-bold tracking-wider uppercase block">Ogan Ilir, Sumatera Selatan</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Di bawah naungan <strong>Yayasan Generasi Robbani Sumatera Selatan</strong>. Menyelenggarakan pendidikan Islam terpadu yang unggul, berakhlak karimah, dan berwawasan global.
                    </p>
                    <div class="pt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-950/80 border border-emerald-700/60 text-emerald-300 text-[11px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>Afiliasi JSIT Indonesia</span>
                        </span>
                    </div>
                </div>

                <!-- Col 2: Pilihan Jenjang Pendidikan -->
                <div class="space-y-4">
                    <h4 class="text-white font-black text-sm uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Jenjang Sekolah</span>
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        @if(!empty($spmb['units']))
                            @foreach($spmb['units'] as $uCode => $u)
                                @if(!empty($u['is_active']))
                                <li>
                                    <a href="{{ route('school.spmb.form', ['unit' => $u['code'] ?? $uCode]) }}" class="hover:text-emerald-400 transition-colors block">
                                        {{ $u['name'] ?? $uCode }}
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        @else
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">TPA Robbani (0 - 3 Tahun)</a></li>
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">KB Robbani (3 - 4 Tahun)</a></li>
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">TK IT Robbani (4 - 6 Tahun)</a></li>
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">SD IT Robbani (SD Unggulan)</a></li>
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">SMP IT Robbani (Boarding & Full Day)</a></li>
                            <li><a href="#daftar" class="hover:text-emerald-400 transition-colors block">SMA IT Robbani (Tahfidz & Sains)</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 3: Layanan & Informasi SPMB -->
                <div class="space-y-4">
                    <h4 class="text-white font-black text-sm uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Informasi SPMB</span>
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li>
                            <a href="#jadwal" class="hover:text-emerald-400 transition-colors block">
                                Jadwal Gelombang & Kuota
                            </a>
                        </li>
                        <li>
                            <a href="#syarat" class="hover:text-emerald-400 transition-colors block">
                                Persyaratan Berkas Pendaftaran
                            </a>
                        </li>
                        <li>
                            <a href="#biaya" class="hover:text-emerald-400 transition-colors block">
                                Rekening Resmi & Biaya Formulir
                            </a>
                        </li>
                        <li>
                            <a href="#cek-status" class="hover:text-emerald-400 transition-colors block">
                                Cek Status Kelulusan / Berkas
                            </a>
                        </li>
                        <li>
                            <a href="{{ $spmb['brochure_url'] ?? '#' }}" target="_blank" class="hover:text-emerald-400 transition-colors block">
                                Unduh Brosur SPMB Lengkap
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Sekretariat & Narahubung -->
                <div class="space-y-4">
                    <h4 class="text-white font-black text-sm uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-500"></span>
                        <span>Sekretariat SPMB</span>
                    </h4>
                    <div class="space-y-2.5 text-xs text-slate-400 leading-relaxed">
                        <p class="flex items-start gap-2">
                            <span class="text-emerald-400 shrink-0">📍</span>
                            <span>Jl. Sarjana Blok C No. 14-17 & Jl. Lintas Timur Km 35, Kel. Timbangan, Kec. Indralaya Utara, Kab. Ogan Ilir, Sumatera Selatan 30662</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <span class="text-emerald-400 shrink-0">🕒</span>
                            <span>Senin – Sabtu: 07.30 – 16.00 WIB</span>
                        </p>
                    </div>
                    <div class="pt-2">
                        <a href="{{ $spmb['wa_link'] ?? 'https://wa.me/62811747472' }}" target="_blank" class="w-full py-2.5 px-3 rounded-xl bg-emerald-700 hover:bg-emerald-600 text-white font-bold text-xs flex items-center justify-center gap-2 transition-all shadow-sm">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                            <span>WhatsApp Panitia ({{ $spmb['wa_number'] ?? '0811-747-472' }})</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-400 text-center sm:text-left">
                <p>&copy; {{ date('Y') }} SIT Robbani Ogan Ilir. Hak Cipta Dilindungi Undang-Undang.</p>
                <div class="flex items-center gap-4 text-slate-400">
                    <span>Sistem Informasi SPMB SmartEdu</span>
                    <span>•</span>
                    <a href="#beranda" class="hover:text-emerald-400 transition-colors">Kembali ke Atas ↑</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- 11. STICKY MOBILE BOTTOM BAR (UNTUK PENGGUNA HP, RATA TENGAH) -->
    <div class="fixed bottom-0 inset-x-0 sm:hidden z-50 bg-white/95 backdrop-blur-md border-t border-slate-200 p-2.5 shadow-2xl flex items-center justify-center gap-2">
        <a href="{{ $spmb['wa_link'] ?? 'https://wa.me/62811747472' }}" target="_blank" class="btn-responsive flex-1 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-emerald-800 font-bold text-xs transition-colors">
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
                        const response = await fetch(`{{ url('/cek-status') }}?q=${encodeURIComponent(this.searchQuery)}`, {
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
    @include('components.chat-ai-widget')
</body>
</html>
