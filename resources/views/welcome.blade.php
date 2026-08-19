<!DOCTYPE html>
<html lang="id" x-data="{ 
    activeCategory: 'all',
    activeConceptTab: 'hp',
    selectedModule: null,
    faqOpen: null,
    mobileMenuOpen: false,
    
    // Continuous 5-slide auto carousel (shows 3 photo cards side-by-side)
    mobileIndex: 0,
    desktopIndex: 0,
    mobileTotal: 5,
    desktopTotal: 5,
    
    init() {
        setInterval(() => {
            if (this.activeConceptTab === 'hp') {
                this.mobileIndex = (this.mobileIndex + 1) % 5;
            } else {
                this.desktopIndex = (this.desktopIndex + 1) % 5;
            }
        }, 3500);
    },
    
    nextMobile() {
        this.mobileIndex = (this.mobileIndex + 1) % 5;
    },
    prevMobile() {
        this.mobileIndex = (this.mobileIndex - 1 + 5) % 5;
    },
    
    nextDesktop() {
        this.desktopIndex = (this.desktopIndex + 1) % 5;
    },
    prevDesktop() {
        this.desktopIndex = (this.desktopIndex - 1 + 5) % 5;
    }
}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['app_name'] }} - {{ $settings['school_name'] }} | Platform Digital Sekolah Islam Terpadu</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon / Five Icon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <!-- Open Graph (OG) Meta Tags for WhatsApp, Facebook, Telegram, LinkedIn -->
    <link rel="image_src" href="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $settings['school_name'] }} | Platform Digital SmartEdu">
    <meta property="og:description" content="{{ $settings['hero_desc'] }}">
    <meta property="og:image" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:secure_url" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta itemprop="image" content="{{ asset('images/og_share_robbani.png') }}?v=11">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['school_name'] }}">
    <meta name="twitter:description" content="{{ $settings['hero_desc'] }}">
    <meta name="twitter:image" content="{{ asset('images/og_share_robbani.png') }}?v=11">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN Fallback for Guaranteed Instant Rendering -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            color: #1e293b;
        }
        [x-cloak] { display: none !important; }
        
        ::-webkit-scrollbar {
            width: 8px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        ::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 4px;
        }

        /* Hide Scrollbar for Horizontal Scrollable Pill Bar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Slow, Luxurious, Eye-Catching Scroll-Triggered Fade Up Animation */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .scroll-reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Staggered Delays for Sequential Element Reveal */
        .delay-1 { transition-delay: 0.15s; }
        .delay-2 { transition-delay: 0.3s; }
        .delay-3 { transition-delay: 0.45s; }
        .delay-4 { transition-delay: 0.6s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    <!-- ========================================== -->
    <!-- HEADER BAR                                 -->
    <!-- ========================================== -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            
            <!-- SmartEdu Logo & School Identity (Displayed on Mobile & Desktop) -->
            <a href="#" class="flex items-center gap-2.5 group">
                <img src="/images/logo-robbani-official.png" alt="Logo SIT Robbani" class="h-10 sm:h-12 w-auto object-contain transition-transform group-hover:scale-105" onerror="this.onerror=null; this.src='/images/logo-robbani-light.png';">
                <div class="border-l border-slate-200 pl-2.5">
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-900 uppercase tracking-wide block leading-tight">{{ $settings['edition_title'] }}</span>
                    <span class="text-[10px] sm:text-[11px] text-teal-700 font-semibold block leading-tight">{{ $settings['school_name'] }}</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-700">
                <a href="{{ route('home') }}" class="text-teal-800 hover:text-teal-900 transition-colors flex items-center gap-1.5 font-extrabold bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-200">
                    <span>🌐 Website Sekolah</span>
                </a>
                <a href="#fitur" class="hover:text-teal-700 transition-colors">Modul Fitur</a>
                <a href="#konsep-aplikasi" class="hover:text-teal-700 transition-colors">Mockup Tampilan</a>
                @if(($settings['show_sales_section'] ?? '1') === '1')
                <a href="#harga" class="hover:text-teal-700 transition-colors">Paket Harga</a>
                @endif
                <a href="#faq" class="hover:text-teal-700 transition-colors">FAQ</a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs flex items-center gap-2 shadow-sm transition-all">
                    <span>Akses CMS Admin</span>
                </a>
            </nav>

            <!-- Mobile Hamburger Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    aria-label="Toggle Menu"
                    class="md:hidden p-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors focus:outline-none">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Responsive Dropdown Drawer Menu -->
        <div x-show="mobileMenuOpen" 
             x-cloak 
             @click.away="mobileMenuOpen = false" 
             class="md:hidden bg-white border-b border-slate-200 px-6 py-4 space-y-3 font-bold text-xs text-slate-800 shadow-xl">
            <a href="{{ route('home') }}" class="block py-2 border-b border-slate-100 text-teal-800 font-extrabold">🌐 Website Sekolah (Profil)</a>
            <a href="#fitur" @click="mobileMenuOpen = false" class="block py-2 border-b border-slate-100 hover:text-teal-700">Modul Fitur</a>
            <a href="#konsep-aplikasi" @click="mobileMenuOpen = false" class="block py-2 border-b border-slate-100 hover:text-teal-700">Mockup Tampilan</a>
            @if(($settings['show_sales_section'] ?? '1') === '1')
            <a href="#harga" @click="mobileMenuOpen = false" class="block py-2 border-b border-slate-100 hover:text-teal-700">Paket Harga & Lisensi</a>
            @endif
            <a href="#faq" @click="mobileMenuOpen = false" class="block py-2 border-b border-slate-100 hover:text-teal-700">Pertanyaan Umum</a>
            <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 rounded-xl bg-teal-600 text-white font-extrabold text-center shadow-sm">Akses CMS Admin</a>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- HERO SECTION                               -->
    <!-- ========================================== -->
    <section class="py-12 sm:py-16 px-4 sm:px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            
            <!-- Left Content -->
            <div class="lg:col-span-7 space-y-5 sm:space-y-6 text-center lg:text-left scroll-reveal">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200/80 text-[11px] sm:text-xs font-bold tracking-wide shadow-sm max-w-full">
                    <span class="truncate">{{ $settings['hero_badge'] }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 tracking-tight leading-tight">
                    {{ $settings['hero_title'] }}
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-slate-600 leading-relaxed font-normal">
                    {{ $settings['hero_desc'] }}
                </p>

                <!-- Stats Summary (Neat responsive grid) -->
                <div class="pt-4 grid grid-cols-3 gap-2.5 sm:gap-4 border-t border-slate-200">
                    <div class="bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 text-center shadow-sm">
                        <h3 class="text-xl sm:text-3xl font-black text-teal-700">{{ count($modules) }}</h3>
                        <p class="text-[10px] sm:text-xs text-slate-800 font-extrabold mt-0.5 leading-tight">25 Modul Terintegrasi</p>
                    </div>
                    <div class="bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 text-center shadow-sm">
                        <h3 class="text-xl sm:text-3xl font-black text-teal-700">100%</h3>
                        <p class="text-[10px] sm:text-xs text-slate-800 font-extrabold mt-0.5 leading-tight">Real-Time Sync</p>
                    </div>
                    <div class="bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 text-center shadow-sm">
                        <h3 class="text-xl sm:text-3xl font-black text-amber-600">Multi</h3>
                        <p class="text-[10px] sm:text-xs text-slate-800 font-extrabold mt-0.5 leading-tight">Unit Sekolah</p>
                    </div>
                </div>
            </div>

            <!-- Right Visual Illustration: Clean Dual Device Hero Mockup -->
            <div class="lg:col-span-5 flex justify-center scroll-reveal delay-1">
                <div class="w-full max-w-lg bg-white p-3 sm:p-4 rounded-3xl border border-slate-200 shadow-xl hover:shadow-2xl transition-all">
                    <div class="relative overflow-hidden rounded-2xl border border-slate-200 bg-slate-900 min-h-[260px] flex items-center justify-center">
                        <img src="/images/hero_dual_device_mockup.png" 
                             alt="SmartEdu App Mockup Preview" 
                             class="w-full h-auto object-cover rounded-2xl"
                             onerror="this.onerror=null; this.src='/images/mockup_desktop_1.png';">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- KATALOG 25 MODUL FITUR LENGKAP             -->
    <!-- ========================================== -->
    <section id="fitur" class="py-16 sm:py-20 max-w-7xl mx-auto px-4 sm:px-6">
        
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-8 sm:mb-10 scroll-reveal">
            <div class="inline-block">
                <span class="px-3.5 py-1.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200/80 text-[11px] sm:text-xs font-black uppercase tracking-wider">
                    Katalog 25 Produk Digital Enterprise
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Preview Semua 25 Modul Fitur SmartEdu
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                Solusi lengkap dari manajemen data dasar, kurikulum akademik, keuangan, hingga pembentukan karakter dan keamanan siswa.
            </p>
        </div>

        <!-- Sleek Horizontal Scrollable Filter Bar on Mobile -->
        <div class="scroll-reveal delay-1 mb-8 sm:mb-10">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-2 px-1 sm:justify-center">
                <button @click="activeCategory = 'all'" 
                        :class="{ 'bg-teal-700 text-white shadow-md font-extrabold': activeCategory === 'all', 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 font-bold': activeCategory !== 'all' }"
                        class="px-4 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all flex-shrink-0">
                    Semua Modul ({{ count($modules) }})
                </button>
                <button @click="activeCategory = 'akademik'" 
                        :class="{ 'bg-teal-700 text-white shadow-md font-extrabold': activeCategory === 'akademik', 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 font-bold': activeCategory !== 'akademik' }"
                        class="px-4 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all flex-shrink-0">
                    Akademik & Rapor
                </button>
                <button @click="activeCategory = 'keuangan'" 
                        :class="{ 'bg-teal-700 text-white shadow-md font-extrabold': activeCategory === 'keuangan', 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 font-bold': activeCategory !== 'keuangan' }"
                        class="px-4 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all flex-shrink-0">
                    Keuangan & POS
                </button>
                <button @click="activeCategory = 'bpi'" 
                        :class="{ 'bg-teal-700 text-white shadow-md font-extrabold': activeCategory === 'bpi', 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 font-bold': activeCategory !== 'bpi' }"
                        class="px-4 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all flex-shrink-0">
                    BPI & Karakter
                </button>
                <button @click="activeCategory = 'operasional'" 
                        :class="{ 'bg-teal-700 text-white shadow-md font-extrabold': activeCategory === 'operasional', 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-100 font-bold': activeCategory !== 'operasional' }"
                        class="px-4 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all flex-shrink-0">
                    HRIS, Persuratan & Layanan
                </button>
            </div>
        </div>

        <!-- 25 Cards Grid with Scroll Reveal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $mod)
            <div x-show="activeCategory === 'all' || activeCategory === '{{ $mod->category }}'" 
                 @click="selectedModule = {{ json_encode($mod) }}"
                 class="scroll-reveal bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-teal-500 transition-all cursor-pointer flex flex-col justify-between group relative overflow-hidden">
                
                <div class="absolute top-0 left-0 right-0 h-1 bg-teal-600"></div>

                <div>
                    <div class="flex items-center justify-between mb-4 mt-1">
                        <div class="w-11 h-11 rounded-xl bg-slate-100 text-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                            {{ $mod->icon }}
                        </div>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $mod->badge_bg }}">
                            {{ $mod->category_name }}
                        </span>
                    </div>

                    <h3 class="text-base font-bold text-slate-900 tracking-tight mb-2 group-hover:text-teal-700 transition-colors">
                        {{ $mod->title }}
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-normal mb-4">
                        {{ $mod->short_desc }}
                    </p>

                    <ul class="space-y-2 mb-4">
                        @if(is_array($mod->highlights))
                            @foreach(array_slice($mod->highlights, 0, 3) as $item)
                            <li class="flex items-start gap-2 text-xs text-slate-700 font-medium">
                                <span class="text-teal-600 font-bold">✓</span>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-teal-700">
                    <span>Lihat Sub-Modul Detail</span>
                    <span class="group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- MOCKUP CONCEPT REALISTIC PHOTO CAROUSEL   -->
    <!-- HANDHELD SMARTPHONE & LAPTOP PHOTO MOCKUPS -->
    <!-- 5 DESAIN PER TAB, TAMPIL 3 CARDS SIDE-BY-SIDE, CONTINUOUS AUTO SLIDE -->
    <!-- ========================================== -->
    <section id="konsep-aplikasi" class="py-16 sm:py-20 bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-10">
            
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3 scroll-reveal">
                <div class="inline-block">
                    <span class="px-3.5 py-1.5 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/40 text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                        Tampilan Layar Mobile & Desktop
                    </span>
                </div>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight text-white">
                    Mockup Device Realistik HP Smartphone &amp; Laptop Desktop
                </h2>
                <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed">
                    Desain antarmuka modern yang nyaman digunakan oleh Admin, Guru, Siswa, Orang Tua, dan Kasir POS.
                </p>
            </div>

            <!-- Tab Toggle Button for Mobile vs Laptop Preview -->
            <div class="flex justify-center scroll-reveal">
                <div class="inline-flex bg-slate-800 p-1.5 rounded-2xl border border-slate-700 text-xs font-bold">
                    <button @click="activeConceptTab = 'hp'" 
                            :class="{ 'bg-teal-700 text-white shadow-md': activeConceptTab === 'hp', 'text-slate-300 hover:text-white': activeConceptTab !== 'hp' }"
                            class="px-5 py-2.5 rounded-xl transition-all">
                        📱 Smartphone Mobile App
                    </button>
                    <button @click="activeConceptTab = 'laptop'" 
                            :class="{ 'bg-teal-700 text-white shadow-md': activeConceptTab === 'laptop', 'text-slate-300 hover:text-white': activeConceptTab !== 'laptop' }"
                            class="px-5 py-2.5 rounded-xl transition-all">
                        💻 Laptop Desktop Admin
                    </button>
                </div>
            </div>

            <!-- SMARTPHONE MOBILE APP CAROUSEL CONTAINER (SHOWS 3 CARDS SIDE-BY-SIDE) -->
            <div x-show="activeConceptTab === 'hp'" x-transition class="relative scroll-reveal">
                <div class="overflow-hidden py-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 transition-all duration-700 ease-in-out">
                        
                        <template x-for="slotOffset in [0, 1, 2]" :key="slotOffset">
                            <div class="bg-white rounded-3xl border border-slate-800 shadow-xl overflow-hidden text-slate-900 flex flex-col justify-between h-[540px] transform hover:-translate-y-1 transition-transform duration-300">
                                
                                <!-- MOBILE PHOTO 1: Portal Ortu & Student Mobile App -->
                                <div x-show="((mobileIndex + slotOffset) % 5) === 0" class="h-full flex flex-col justify-between">
                                    <div class="p-3 bg-teal-900 text-white flex items-center justify-between text-xs font-bold">
                                        <span>Parent &amp; Student App</span>
                                        <span class="text-[10px] bg-teal-800 px-2 py-0.5 rounded-full">Active</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_mobile_1.png" alt="Mobile Photo Mockup Parent App" class="w-full h-[410px] object-cover rounded-2xl shadow-md" onerror="this.onerror=null; this.src='/images/hero_mobile_mockup_3d.png';">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">1. Portal Ortu &amp; Student App 📱</h4>
                                        <p class="text-[11px] text-slate-600">Presensi realtime, jadwal pelajaran, nilai, &amp; pengumuman.</p>
                                    </div>
                                </div>

                                <!-- MOBILE PHOTO 2: Gate RFID & QR Code Scanner -->
                                <div x-show="((mobileIndex + slotOffset) % 5) === 1" class="h-full flex flex-col justify-between">
                                    <div class="p-3 bg-emerald-900 text-white flex items-center justify-between text-xs font-bold">
                                        <span>Presensi RFID / QR Gate</span>
                                        <span class="text-[10px] bg-emerald-800 px-2 py-0.5 rounded-full">Scan Gate</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_mobile_2.png" alt="Mobile Photo Mockup RFID Gate Scanner" class="w-full h-[410px] object-cover rounded-2xl shadow-md" onerror="this.onerror=null; this.src='/images/hero_mobile_mockup_3d.png';">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">2. Gate Presensi Scanner ⏱️</h4>
                                        <p class="text-[11px] text-slate-600">Absensi gerbang cepat RFID &amp; QR Code dengan notifikasi WA.</p>
                                    </div>
                                </div>

                                <!-- MOBILE PHOTO 3: SafeSchool Panic Alarm & Anti-Bullying App -->
                                <div x-show="((mobileIndex + slotOffset) % 5) === 2" class="h-full flex flex-col justify-between">
                                    <div class="p-3 bg-rose-900 text-white flex items-center justify-between text-xs font-bold">
                                        <span>SafeSchool Alarm App</span>
                                        <span class="text-[10px] bg-rose-800 px-2 py-0.5 rounded-full">SOS Active</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_mobile_3.png" alt="Mobile Photo Mockup SafeSchool App" class="w-full h-[410px] object-cover rounded-2xl shadow-md" onerror="this.onerror=null; this.src='/images/hero_mobile_mockup_3d.png';">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-rose-900">3. SafeSchool Anti-Bullying 🚨</h4>
                                        <p class="text-[11px] text-slate-600">Tombol panic alarm darurat siswa &amp; laporan insiden rahasia.</p>
                                    </div>
                                </div>

                                <!-- MOBILE PHOTO 4: Mobile POS Kantin Cashless -->
                                <div x-show="((mobileIndex + slotOffset) % 5) === 3" class="h-full flex flex-col justify-between">
                                    <div class="p-3 bg-amber-900 text-white flex items-center justify-between text-xs font-bold">
                                        <span>POS Kantin Kiosk App</span>
                                        <span class="text-[10px] bg-amber-800 px-2 py-0.5 rounded-full">Cashless</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_mobile_4.png" alt="Mobile Photo Mockup POS Kantin" class="w-full h-[410px] object-cover rounded-2xl shadow-md" onerror="this.onerror=null; this.src='/images/hero_mobile_mockup_3d.png';">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">4. POS Kantin Cashless Kiosk 🛒</h4>
                                        <p class="text-[11px] text-slate-600">Transaksi jajan saldo kartu RFID &amp; batasan limit harian ortu.</p>
                                    </div>
                                </div>

                                <!-- MOBILE PHOTO 5: Mutaba'ah Yaumiyah BPI App -->
                                <div x-show="((mobileIndex + slotOffset) % 5) === 4" class="h-full flex flex-col justify-between">
                                    <div class="p-3 bg-purple-900 text-white flex items-center justify-between text-xs font-bold">
                                        <span>Mutaba'ah Yaumiyah App</span>
                                        <span class="text-[10px] bg-purple-800 px-2 py-0.5 rounded-full">BPI Character</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_mobile_5.png" alt="Mobile Photo Mockup Mutabaah BPI" class="w-full h-[410px] object-cover rounded-2xl shadow-md" onerror="this.onerror=null; this.src='/images/hero_mobile_mockup_3d.png';">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-purple-900">5. Mutaba'ah BPI &amp; Karakter 📖</h4>
                                        <p class="text-[11px] text-slate-600">Jurnal ibadah harian (Sholat 5 waktu, Dhuha, Tilawah, &amp; Hafalan).</p>
                                    </div>
                                </div>

                            </div>
                        </template>

                    </div>
                </div>
            </div>

            <!-- LAPTOP DESKTOP ADMIN CAROUSEL CONTAINER (SHOWS 3 CARDS SIDE-BY-SIDE) -->
            <div x-show="activeConceptTab === 'laptop'" x-cloak x-transition class="relative scroll-reveal">
                <div class="overflow-hidden py-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 transition-all duration-700 ease-in-out">
                        
                        <template x-for="slotOffset in [0, 1, 2]" :key="slotOffset">
                            <div class="bg-white rounded-3xl border border-slate-800 shadow-xl overflow-hidden text-slate-900 flex flex-col justify-between h-[480px] transform hover:-translate-y-1 transition-transform duration-300">
                                
                                <!-- DESKTOP PHOTO 1: Executive Dashboard Laptop -->
                                <div x-show="((desktopIndex + slotOffset) % 5) === 0" class="h-full flex flex-col justify-between">
                                    <div class="p-2.5 bg-slate-900 text-white flex items-center justify-between text-[11px] font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <img src="/images/logo-robbani-official.png" alt="SmartEdu" class="h-5 w-auto bg-white rounded p-0.5">
                                            <span>Executive Dashboard</span>
                                        </div>
                                        <span class="text-[9px] bg-teal-600 text-white px-2 py-0.5 rounded-full font-bold">Multi-Unit</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_desktop_1.png" alt="Laptop Photo Mockup Executive Dashboard" class="w-full h-[360px] rounded-2xl object-cover shadow-sm">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">1. Executive Dashboard Multi-Unit 🏢</h4>
                                        <p class="text-[11px] text-slate-600">Statistik realtime siswa, guru, SPP, tabungan, &amp; presensi gate.</p>
                                    </div>
                                </div>

                                <!-- DESKTOP PHOTO 2: Financial Management SPP Laptop -->
                                <div x-show="((desktopIndex + slotOffset) % 5) === 1" class="h-full flex flex-col justify-between">
                                    <div class="p-2.5 bg-slate-900 text-white flex items-center justify-between text-[11px] font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <img src="/images/logo-robbani-official.png" alt="SmartEdu" class="h-5 w-auto bg-white rounded p-0.5">
                                            <span>Laptop Keuangan SPP</span>
                                        </div>
                                        <span class="text-[9px] bg-emerald-600 text-white px-2 py-0.5 rounded-full font-bold">Auto COA</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_desktop_2.png" alt="Laptop Photo Mockup Keuangan SPP" class="w-full h-[360px] rounded-2xl object-cover shadow-sm">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">2. Keuangan SPP &amp; Akuntansi COA 💳</h4>
                                        <p class="text-[11px] text-slate-600">Tagihan otomatis, kwitansi PDF, &amp; laporan keuangan sekolah.</p>
                                    </div>
                                </div>

                                <!-- DESKTOP PHOTO 3: Academic E-Rapor K13 & Merdeka Laptop -->
                                <div x-show="((desktopIndex + slotOffset) % 5) === 2" class="h-full flex flex-col justify-between">
                                    <div class="p-2.5 bg-slate-900 text-white flex items-center justify-between text-[11px] font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <img src="/images/logo-robbani-official.png" alt="SmartEdu" class="h-5 w-auto bg-white rounded p-0.5">
                                            <span>Laptop Academic E-Rapor</span>
                                        </div>
                                        <span class="text-[9px] bg-blue-600 text-white px-2 py-0.5 rounded-full font-bold">K13 &amp; Merdeka</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_desktop_3.png" alt="Laptop Photo Mockup Academic E-Rapor" class="w-full h-[360px] rounded-2xl object-cover shadow-sm">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">3. Akademik &amp; E-Rapor Merdeka 🎓</h4>
                                        <p class="text-[11px] text-slate-600">Input nilai guru, leger nilai, &amp; pencetakan rapor PDF terstruktur.</p>
                                    </div>
                                </div>

                                <!-- DESKTOP PHOTO 4: SafeSchool Command Center Laptop -->
                                <div x-show="((desktopIndex + slotOffset) % 5) === 3" class="h-full flex flex-col justify-between">
                                    <div class="p-2.5 bg-rose-900 text-white flex items-center justify-between text-[11px] font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <img src="/images/logo-robbani-official.png" alt="SmartEdu" class="h-5 w-auto bg-white rounded p-0.5">
                                            <span>Laptop SafeSchool</span>
                                        </div>
                                        <span class="text-[9px] bg-rose-600 text-white px-2 py-0.5 rounded-full font-bold">Satgas Alert</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_desktop_4.png" alt="Laptop Photo Mockup Anti-Bullying" class="w-full h-[360px] rounded-2xl object-cover shadow-sm">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-rose-900">4. Satgas Anti-Bullying Control 🚨</h4>
                                        <p class="text-[11px] text-slate-600">Command Center geolokasi panic alarm &amp; alur investigasi insiden.</p>
                                    </div>
                                </div>

                                <!-- DESKTOP PHOTO 5: Tracer Study Alumni Laptop -->
                                <div x-show="((desktopIndex + slotOffset) % 5) === 4" class="h-full flex flex-col justify-between">
                                    <div class="p-2.5 bg-slate-900 text-white flex items-center justify-between text-[11px] font-bold">
                                        <div class="flex items-center gap-1.5">
                                            <img src="/images/logo-robbani-official.png" alt="SmartEdu" class="h-5 w-auto bg-white rounded p-0.5">
                                            <span>Laptop Alumni View</span>
                                        </div>
                                        <span class="text-[9px] bg-cyan-600 text-white px-2 py-0.5 rounded-full font-bold">Tracer Study</span>
                                    </div>
                                    <div class="p-2 bg-slate-100 flex-1 flex items-center justify-center">
                                        <img src="/images/mockup_desktop_5.png" alt="Laptop Photo Mockup Alumni" class="w-full h-[360px] rounded-2xl object-cover shadow-sm">
                                    </div>
                                    <div class="p-4 bg-white border-t border-slate-100">
                                        <h4 class="font-bold text-xs text-slate-900">5. Alumni &amp; Tracer Study 🎓</h4>
                                        <p class="text-[11px] text-slate-600">Direktori alumni, tracer study PTN, &amp; legalisir e-ijazah QR Code.</p>
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </section>

    @if(($settings['show_sales_section'] ?? '1') === '1')
    <!-- ========================================== -->
    <!-- SALES & PRICING SECTION (ULTRA HIGH CONTRAST) -->
    <!-- ========================================== -->
    <section id="harga" class="py-16 sm:py-24 max-w-7xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-12 sm:mb-16 scroll-reveal">
            <div class="inline-block">
                <span class="px-4 py-1.5 rounded-full bg-teal-100 text-teal-900 border border-teal-200 text-xs font-black uppercase tracking-wider shadow-xs">
                    {{ $settings['sales_badge'] }}
                </span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                {{ $settings['sales_title'] }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-medium leading-relaxed">
                {{ $settings['sales_desc'] }}
            </p>
        </div>

        <!-- Pricing Cards Grid (3 Options with Ultra Readability & High Contrast) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
            
            <!-- PAKET 1: Source Code Only -->
            <div class="scroll-reveal bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="space-y-2 border-b border-slate-100 pb-4">
                        <span class="px-3.5 py-1 rounded-full bg-slate-100 text-slate-800 text-[10px] font-black uppercase tracking-wider">Single License</span>
                        <h3 class="text-xl font-black text-slate-900 mt-2">{{ $settings['pkg1_title'] }}</h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $settings['pkg1_desc'] }}</p>
                    </div>

                    <div class="py-4 border-b border-slate-100">
                        <span class="text-xs font-bold text-slate-500 block mb-1">Investasi Sekali Bayar:</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-black text-slate-900">{{ $settings['pkg1_price'] }}</span>
                            <span class="text-xs font-bold text-slate-500">/ selamanya</span>
                        </div>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-800 font-bold">
                        @foreach(explode("\n", $settings['pkg1_features']) as $feat)
                            @if(trim($feat))
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs flex items-center justify-center shrink-0">✓</span>
                                <span>{{ trim($feat) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="pt-8">
                    <a href="{{ $settings['pkg1_link'] }}" 
                       target="_blank" 
                       class="w-full py-4 px-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs text-center block shadow-md hover:scale-[1.02] transition-all">
                        Pesan {{ $settings['pkg1_title'] }} ➔
                    </a>
                </div>
            </div>

            <!-- PAKET 2: BEST SELLER & RESELLER (OBSIDIAN EMERALD DARK CARD WITH INLINE HIGH CONTRAST STYLING) -->
            <div class="scroll-reveal delay-1 rounded-3xl p-6 sm:p-8 shadow-2xl transition-all flex flex-col justify-between relative border-2 border-emerald-400 ring-4 ring-emerald-500/20"
                 style="background-color: #061107; color: #ffffff;">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1.5 rounded-full bg-amber-400 text-slate-950 font-black text-xs uppercase tracking-wider shadow-lg whitespace-nowrap">
                    {{ $settings['pkg2_badge'] }}
                </div>

                <div class="space-y-6 pt-3">
                    <div class="space-y-2 border-b border-emerald-900/80 pb-4">
                        <span class="px-3.5 py-1 rounded-full bg-emerald-950 text-emerald-300 border border-emerald-800 text-[10px] font-black uppercase tracking-wider">Full Package + Affiliate</span>
                        <h3 class="text-2xl font-black text-white mt-2">{{ $settings['pkg2_title'] }}</h3>
                        <p class="text-xs text-emerald-200 font-medium leading-relaxed">{{ $settings['pkg2_desc'] }}</p>
                    </div>

                    <div class="py-4 border-b border-emerald-900/80">
                        <span class="text-xs font-bold text-slate-400 block mb-1">Investasi Sekali Bayar:</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-black" style="color: #fbbf24; text-shadow: 0 1px 2px rgba(0,0,0,0.8);">{{ $settings['pkg2_price'] }}</span>
                            <span class="text-xs font-bold text-slate-300">/ selamanya</span>
                        </div>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-100 font-bold">
                        @foreach(explode("\n", $settings['pkg2_features']) as $feat)
                            @if(trim($feat))
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-amber-400 text-slate-950 font-black text-xs flex items-center justify-center shrink-0 shadow-sm">✓</span>
                                <span>{{ trim($feat) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="pt-8">
                    <a href="{{ $settings['pkg2_link'] }}" 
                       target="_blank" 
                       class="w-full py-4 px-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm text-center block shadow-xl hover:scale-[1.02] transition-all">
                        Pesan {{ $settings['pkg2_title'] }} ➔
                    </a>
                </div>
            </div>

            <!-- PAKET 3: Enterprise Yayasan -->
            <div class="scroll-reveal delay-2 bg-white rounded-3xl border-2 border-slate-200 p-6 sm:p-8 shadow-sm hover:shadow-xl transition-all flex flex-col justify-between">
                <div class="space-y-6">
                    <div class="space-y-2 border-b border-slate-100 pb-4">
                        <span class="px-3.5 py-1 rounded-full bg-teal-50 text-teal-800 text-[10px] font-black uppercase tracking-wider">Multi-School License</span>
                        <h3 class="text-xl font-black text-slate-900 mt-2">{{ $settings['pkg3_title'] }}</h3>
                        <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $settings['pkg3_desc'] }}</p>
                    </div>

                    <div class="py-4 border-b border-slate-100">
                        <span class="text-xs font-bold text-slate-500 block mb-1">Investasi Sekali Bayar:</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-3xl sm:text-4xl font-black text-teal-800">{{ $settings['pkg3_price'] }}</span>
                            <span class="text-xs font-bold text-slate-500">/ selamanya</span>
                        </div>
                    </div>

                    <ul class="space-y-3 text-xs text-slate-800 font-bold">
                        @foreach(explode("\n", $settings['pkg3_features']) as $feat)
                            @if(trim($feat))
                            <li class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-teal-100 text-teal-800 font-black text-xs flex items-center justify-center shrink-0">✓</span>
                                <span>{{ trim($feat) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="pt-8">
                    <a href="{{ $settings['pkg3_link'] }}" 
                       target="_blank" 
                       class="w-full py-4 px-4 rounded-2xl bg-teal-700 hover:bg-teal-800 text-white font-black text-xs text-center block shadow-md hover:scale-[1.02] transition-all">
                        Pesan {{ $settings['pkg3_title'] }} ➔
                    </a>
                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- ========================================== -->
    <!-- FAQ SECTION                                -->
    <!-- ========================================== -->
    <section id="faq" class="py-16 sm:py-20 max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center space-y-3 mb-10 sm:mb-12 scroll-reveal">
            <div class="inline-block">
                <span class="px-3.5 py-1.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200/80 text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                    Pertanyaan Umum
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Pertanyaan yang Sering Diajukan
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 font-normal leading-relaxed">
                Informasi seputar penggunaan, integrasi, dan keamanan sistem SmartEdu.
            </p>
        </div>

        <div class="space-y-4">
            @foreach($faqs as $index => $faq)
            <div class="scroll-reveal bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                <button @click="faqOpen = (faqOpen === {{ $index }} ? null : {{ $index }})" 
                        class="w-full flex items-center justify-between text-left font-bold text-xs sm:text-sm text-slate-900">
                    <span>{{ $faq->question }}</span>
                    <span class="text-teal-700 font-bold text-base ml-2" x-text="faqOpen === {{ $index }} ? '−' : '+'"></span>
                </button>
                <div x-show="faqOpen === {{ $index }}" x-cloak class="mt-3 text-xs text-slate-600 leading-relaxed font-normal pt-3 border-t border-slate-100">
                    {{ $faq->answer }}
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FOOTER CLEAN RESPONSIVE MOBILE & DESKTOP   -->
    <!-- ========================================== -->
    <footer class="py-12 bg-white border-t border-slate-200 text-xs text-slate-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            
            <!-- Top Row: Logo & Navigation Links -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 pb-8 border-b border-slate-100 text-center md:text-left">
                
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <img src="/images/logo-robbani-light.png" alt="Logo SIT Robbani" class="h-10 w-auto object-contain">
                    <div class="border-t sm:border-t-0 sm:border-l border-slate-200 pt-2 sm:pt-0 sm:pl-3">
                        <span class="font-extrabold text-slate-900 text-xs block leading-tight">{{ $settings['edition_title'] }}</span>
                        <span class="text-teal-700 font-semibold text-[11px] block leading-tight">{{ $settings['school_name'] }}</span>
                    </div>
                </div>

                <!-- Footer Nav Links -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-5 text-xs font-semibold text-slate-700">
                    <a href="#fitur" class="hover:text-teal-700 transition-colors">Modul Fitur</a>
                    <span class="text-slate-300">•</span>
                    <a href="#konsep-aplikasi" class="hover:text-teal-700 transition-colors">Mockup Tampilan</a>
                    @if(($settings['show_sales_section'] ?? '1') === '1')
                    <span class="text-slate-300">•</span>
                    <a href="#harga" class="hover:text-teal-700 transition-colors">Paket Harga</a>
                    @endif
                    <span class="text-slate-300">•</span>
                    <a href="{{ route('admin.dashboard') }}" class="text-teal-700 font-bold hover:underline">CMS Admin Portal</a>
                </div>
            </div>

            <!-- Bottom Row: Copyright & Developer Badge -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-slate-500 font-medium text-center sm:text-left">
                <p>© 2026 {{ $settings['app_name'] }} - {{ $settings['school_name'] }}. Hak Cipta Dilindungi.</p>
                
                <div class="px-3.5 py-1.5 rounded-xl bg-slate-50 border border-slate-200 inline-flex items-center gap-1.5 text-slate-600 shadow-sm">
                    <span>Didukung oleh</span>
                    <a href="https://berandadigital.net" target="_blank" rel="noopener noreferrer" class="text-teal-700 hover:underline font-extrabold">Beranda Teknologi Digital</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- MODAL POPUP SUB-MODUL                      -->
    <!-- ========================================== -->
    <div x-show="selectedModule !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" @keydown.escape.window="selectedModule = null">
        <div class="bg-white w-full max-w-xl rounded-2xl p-6 border border-slate-200 shadow-2xl relative max-h-[85vh] overflow-y-auto" @click.away="selectedModule = null">
            <button @click="selectedModule = null" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center hover:bg-slate-200 transition-colors">✕</button>

            <template x-if="selectedModule">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-2xl flex items-center justify-center" x-text="selectedModule.icon"></div>
                        <div>
                            <span class="text-[11px] font-semibold px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-800 border border-teal-200" x-text="selectedModule.category_name"></span>
                            <h3 class="text-lg font-bold text-slate-900 mt-1" x-text="selectedModule.title"></h3>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed font-normal" x-text="selectedModule.full_desc"></p>

                    <div>
                        <h4 class="font-bold text-xs text-slate-900 mb-2">Sub-Modul dan Fitur Detail:</h4>
                        <ul class="space-y-2 text-xs text-slate-700 font-medium">
                            <template x-for="item in selectedModule.highlights" :key="item">
                                <li class="flex items-start gap-2.5 p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                                    <span class="text-teal-600 font-bold">✓</span>
                                    <span x-text="item"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex justify-end">
                        <button @click="selectedModule = null" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 transition-colors">Tutup</button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Smooth Scroll Reveal Observer Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.scroll-reveal').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
