<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $info['name'] }} | Portal Resmi SIT Robbani</title>

    <!-- Favicon & Social Sharing Meta Tags (Default Light Logo) -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Profil {{ $info['name'] }} | Portal Resmi SIT Robbani">
    <meta property="og:description" content="{{ $info['tagline'] }}">
    <meta property="og:image" content="{{ asset('images/logo robbani light.png') }}">
    <meta property="og:site_name" content="SIT Robbani Ogan Ilir">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Profil {{ $info['name'] }}">
    <meta name="twitter:description" content="{{ $info['tagline'] }}">
    <meta name="twitter:image" content="{{ asset('images/logo robbani light.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        robbani: {
                            dark: '#004532',
                            primary: '#065f46',
                            light: '#10b981',
                            accent: '#fd761a',
                            orange: '#f97316'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        headline: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ==========================================================================
           EXECUTIVE DEEP OBSIDIAN EMERALD & ELECTRIC LIME DARK MODE SYSTEM
           ========================================================================== */
        html.dark, html.dark body {
            background-color: #061107 !important;
            color: #f7fee7 !important;
        }

        /* 1. Dark Mode Background Overrides */
        html.dark header,
        html.dark section,
        html.dark footer,
        html.dark main,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .bg-white {
            background-color: #061107 !important;
        }

        /* 2. Pure White Logo Filter in Dark Mode (NO WHITE CONTAINER BOX) */
        .logo-badge-container {
            background-color: transparent !important;
            padding: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            border: none !important;
            display: inline-flex;
            align-items: center;
        }

        html.dark .logo-badge-container {
            background-color: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }

        html.dark img.official-logo-img {
            filter: brightness(0) invert(1) !important;
        }

        /* 3. Primary Card Surfaces in Dark Mode */
        html.dark .bg-white,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .card-surface {
            background-color: #0d1e0f !important;
            border-color: #1a381c !important;
            color: #f7fee7 !important;
        }

        /* 4. Section Pill Badges in Dark Mode */
        html.dark .unit-pill-badge,
        html.dark .site-section-badge {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
        }

        html.dark .unit-pill-badge *,
        html.dark .site-section-badge * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* 5. Action CTA Buttons in Dark Mode: Electric Lime (#c6f634) with Obsidian Font (#061107) */
        html.dark a.btn-unit-cta,
        html.dark a[href*="ppdb"] {
            background: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
            box-shadow: 0 10px 25px -5px rgba(198, 246, 52, 0.4) !important;
        }

        html.dark a.btn-unit-cta *,
        html.dark a[href*="ppdb"] * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* 6. Text & Heading Contrast in Dark Mode */
        html.dark .text-slate-900,
        html.dark .text-slate-800,
        html.dark .text-slate-700 {
            color: #f7fee7 !important;
        }

        html.dark .text-slate-600,
        html.dark .text-slate-500 {
            color: #d9f99d !important;
        }

        html.dark .text-emerald-700,
        html.dark .text-emerald-800,
        html.dark .text-emerald-600,
        html.dark .text-orange-600 {
            color: #c6f634 !important;
        }

        /* 7. Footer in Dark Mode */
        html.dark footer {
            background-color: #040a04 !important;
            border-top: 1px solid #1a381c !important;
            color: #d9f99d !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#061107] text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col selection:bg-orange-500 selection:text-white transition-colors duration-300">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] text-white text-xs py-2 px-4 shadow-sm relative z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap">
                <span class="bg-orange-500 text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full animate-pulse shrink-0">PORTAL UNIT {{ $info['code'] }}</span>
                <span class="font-semibold text-[11px] sm:text-xs">🔥 {{ $info['name'] }} - Pendaftaran SPMB Online TA 2026/2027 Telah Resmi Dibuka!</span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-[11px] font-bold shrink-0">
                <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="hover:text-orange-300 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">call</span>
                    <span>WhatsApp Admin Unit</span>
                </a>
                <span class="text-emerald-300">•</span>
                <a href="{{ route('home') }}" class="hover:underline text-emerald-200 flex items-center gap-1">
                    <span>Portal Utama</span> ➔
                </a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#061107]/95 backdrop-blur-xl border-b border-slate-200/80 dark:border-[#1a381c] transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-4">
            
            <!-- Logo Section (Full Color in Light, Solid White in Dark Mode) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="logo-badge-container shrink-0">
                    <img src="{{ \App\Models\SiteSetting::get('logo_light', '/images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="official-logo-img h-10 sm:h-12 w-auto object-contain transition-all dark:hidden">
                    <img src="{{ \App\Models\SiteSetting::get('logo_dark', '/images/logo robbani dark.png') }}" alt="Logo SIT Robbani" class="official-logo-img h-10 sm:h-12 w-auto object-contain transition-all hidden dark:block">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="unit-pill-badge px-2 py-0.5 rounded bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] font-black text-[10px] tracking-wider uppercase">
                            UNIT {{ $info['code'] }}
                        </span>
                        <span class="text-[10px] font-extrabold text-amber-600 dark:text-[#c6f634] hidden lg:inline-block">• {{ $info['akreditasi'] }}</span>
                    </div>
                    <span class="font-black text-sm sm:text-base text-slate-900 dark:text-white leading-tight block group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">
                        {{ $info['name'] }}
                    </span>
                </div>
            </a>

            <!-- Desktop Links (Concise, Compact & Never Wrapping) -->
            <nav class="hidden lg:flex items-center gap-4 text-xs font-extrabold text-slate-700 dark:text-slate-200 shrink-0">
                <a href="{{ route('home') }}" class="hover:text-orange-500 transition-colors whitespace-nowrap">Beranda</a>
                <a href="#profil" class="hover:text-orange-500 transition-colors whitespace-nowrap">Profil</a>
                <a href="#kepsek" class="hover:text-orange-500 transition-colors whitespace-nowrap">Kepsek</a>
                <a href="#kurikulum" class="hover:text-orange-500 transition-colors whitespace-nowrap">Program</a>
                <a href="#guru" class="hover:text-orange-500 transition-colors whitespace-nowrap">Guru</a>
                <a href="#alumni" class="hover:text-orange-500 transition-colors whitespace-nowrap">Testimoni</a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Gelap/Terang" class="p-2 rounded-xl bg-slate-100 dark:bg-[#0d1e0f] text-slate-700 dark:text-[#c6f634] hover:bg-slate-200 dark:hover:bg-[#153018] transition-all shadow-sm border border-slate-200 dark:border-[#1a381c] shrink-0">
                    <span x-show="!darkMode" class="text-xs">🌙</span>
                    <span x-show="darkMode" class="text-xs">☀️</span>
                </button>

                <a href="{{ route('school.ppdb') }}" class="btn-unit-cta px-4 py-2 rounded-full bg-orange-600 dark:bg-[#c6f634] text-white dark:text-[#061107] font-black text-xs shadow-md hover:scale-105 transition-all flex items-center gap-1 shrink-0 whitespace-nowrap">
                    <span>Daftar SPMB</span>
                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                </a>
            </nav>

            <!-- Mobile Controls -->
            <div class="flex items-center gap-2 lg:hidden shrink-0">
                <button @click="darkMode = !darkMode" class="p-2 rounded-xl bg-slate-100 dark:bg-[#0d1e0f] text-slate-700 dark:text-[#c6f634] border border-slate-200 dark:border-[#1a381c]">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl bg-emerald-700 text-white font-bold text-sm">
                    <span x-show="!mobileMenuOpen">☰</span>
                    <span x-show="mobileMenuOpen">✕</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-cloak x-transition class="lg:hidden bg-white dark:bg-[#0d1e0f] border-b border-slate-200 dark:border-[#1a381c] px-6 py-4 space-y-3 font-bold text-xs">
        <a href="{{ route('home') }}" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🏠 Beranda Utama Portal</a>
        <a href="#profil" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🏫 Profil &amp; Visi Misi</a>
        <a href="#kepsek" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">👤 Sambutan Kepala Sekolah</a>
        <a href="#kurikulum" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🌟 Program Unggulan &amp; Kurikulum</a>
        <a href="#guru" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">👨‍🏫 Dewan Guru &amp; Tendik</a>
        <a href="#alumni" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🎓 Kisah Alumni &amp; Testimoni</a>
        <a href="{{ route('school.ppdb') }}" class="block py-3 text-center bg-orange-600 dark:bg-[#c6f634] text-white dark:text-[#061107] font-black rounded-xl shadow-md">Daftar SPMB Online Unit {{ $info['code'] }} ➔</a>
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow">
        
        <!-- 1. HERO UNIT GLASSMORPHISM BANNER (MOSQUE & CAMPUS BACKGROUND PHOTO) -->
        <section class="relative py-8 sm:py-14 px-4 sm:px-6 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative rounded-3xl p-6 sm:p-12 overflow-hidden shadow-2xl bg-cover bg-center border border-emerald-900/30 dark:border-[#1a381c]" style="background-image: url('https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1600');">
                    
                    <!-- Glassmorphism Dark Emerald Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-r from-[#004532]/90 via-[#065f46]/85 to-[#061107]/95 dark:from-[#061107]/95 dark:to-[#0d1e0f]/95 backdrop-blur-md"></div>

                    <div class="relative z-10 max-w-3xl space-y-4 sm:space-y-6 text-white">
                        <div class="inline-flex flex-wrap items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-3.5 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-[#c6f634] animate-ping"></span>
                            <span class="text-[#c6f634] font-black text-[11px] uppercase tracking-wider">PROFIL RESMI UNIT {{ $info['code'] }} ROBBANI</span>
                            <span class="text-white/60">•</span>
                            <span class="text-white text-[11px] font-bold">NPSN: {{ $info['npsn'] }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-5xl font-black text-white leading-tight drop-shadow-md font-headline">
                            {{ $info['name'] }}
                        </h1>

                        <p class="text-xs sm:text-base text-emerald-100 dark:text-slate-200 font-medium leading-relaxed drop-shadow">
                            {{ $info['description'] }}
                        </p>

                        <div class="flex flex-wrap gap-3 sm:gap-4 pt-2">
                            <a href="{{ route('school.ppdb') }}" class="btn-unit-cta px-6 py-3.5 rounded-full bg-orange-600 dark:bg-[#c6f634] text-white dark:text-[#061107] font-black text-xs sm:text-sm shadow-xl hover:scale-105 transition-all flex items-center gap-2">
                                <span>Daftar SPMB Online Unit {{ $info['code'] }}</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="px-6 py-3.5 rounded-full bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold text-xs sm:text-sm hover:bg-white/20 transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px]">call</span>
                                <span>Hubungi Admin WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. METRICS & STATISTIK UNIT -->
        <section id="statistik" class="py-4 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1">
                    <span class="text-3xl sm:text-4xl font-black text-emerald-700 dark:text-[#c6f634] block font-headline">
                        {{ $info['students_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Siswa Aktif Terdaftar</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1">
                    <span class="text-3xl sm:text-4xl font-black text-orange-600 dark:text-[#c6f634] block font-headline">
                        {{ $info['employees_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Guru &amp; Tenaga Pendidik</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1">
                    <span class="text-3xl sm:text-4xl font-black text-emerald-700 dark:text-[#c6f634] block font-headline">
                        {{ $info['classrooms_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Rombongan Belajar</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1">
                    <span class="text-xl sm:text-2xl font-black text-emerald-800 dark:text-[#c6f634] block font-headline py-1">
                        {{ $info['target_hafalan'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Target Hafalan Al-Qur'an</span>
                </div>
            </div>
        </section>

        <!-- 3. PROFIL & VISI MISI UNIT -->
        <section id="profil" class="py-10 sm:py-14 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Profil & Sejarah Singkat -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] shadow-sm space-y-4">
                        <div class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">
                            KEUNGGULAN UTAMA
                        </div>
                        <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900 dark:text-white">Profil Pembelajaran {{ $info['name'] }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                            {{ $info['description'] }}
                        </p>
                        <div class="pt-2 border-t border-slate-100 dark:border-[#1a381c] grid grid-cols-2 gap-4 text-xs font-bold text-slate-700 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-[#c6f634]">verified</span>
                                <span>Akreditasi: {{ $info['akreditasi'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-[#c6f634]">menu_book</span>
                                <span>Kurikulum Merdeka + JSIT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visi & Misi Poin-Poin -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] shadow-sm space-y-4">
                        <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">
                            VISI &amp; MISI SEKOLAH
                        </span>
                        <div>
                            <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Visi Unit {{ $info['code'] }}:</h3>
                            <p class="text-sm sm:text-base font-bold text-emerald-900 dark:text-[#c6f634] mt-1 italic font-headline leading-snug">
                                "{{ $info['vision'] }}"
                            </p>
                        </div>
                        <div class="space-y-2 pt-2">
                            <h4 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Misi Utama Unit:</h4>
                            <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                                @foreach($info['missions'] as $misi)
                                <li class="flex items-start gap-2">
                                    <span class="material-symbols-outlined text-[16px] text-emerald-600 dark:text-[#c6f634] shrink-0 mt-0.5">check_circle</span>
                                    <span>{{ $misi }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 4. SAMBUTAN KEPALA SEKOLAH UNIT (FEATURED VISUAL CARD) -->
        <section id="kepsek" class="py-10 sm:py-14 px-4 sm:px-6 bg-slate-100/60 dark:bg-[#040a04]">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 sm:p-10 shadow-md flex flex-col md:flex-row gap-6 sm:gap-10 items-center">
                    
                    <div class="flex-shrink-0 flex flex-col items-center text-center w-full md:w-1/3">
                        <div class="w-32 h-32 sm:w-44 sm:h-44 mx-auto rounded-full border-4 border-emerald-600 p-1 mb-3 shadow-lg overflow-hidden bg-white">
                            <img src="{{ $info['principal_photo'] }}" alt="{{ $info['principal_name'] }}" class="w-full h-full object-cover rounded-full" onerror="this.src='/images/logo robbani light.png';">
                        </div>
                        <span class="unit-pill-badge mb-1 px-3 py-0.5 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-emerald-900 dark:text-[#061107] text-[10px] font-black uppercase">KEPALA SEKOLAH</span>
                        <h3 class="text-base sm:text-lg font-bold font-headline text-slate-900 dark:text-white">{{ $info['principal_name'] }}</h3>
                        <p class="text-[11px] font-semibold text-emerald-700 dark:text-[#c6f634] max-w-[240px]">{{ $info['principal_title'] }}</p>
                    </div>

                    <div class="flex-grow w-full md:w-2/3 border-t md:border-t-0 md:border-l border-slate-200 dark:border-[#1a381c] pt-4 md:pt-0 md:pl-8 text-center md:text-left space-y-3">
                        <span class="material-symbols-outlined text-[40px] text-emerald-600/30 block md:inline-block">format_quote</span>
                        <p class="text-xs sm:text-base font-semibold italic text-slate-800 dark:text-slate-200 leading-relaxed">
                            "{{ $info['principal_greeting'] }}"
                        </p>
                        <div class="pt-2">
                            <a href="{{ route('school.ppdb') }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 dark:text-[#c6f634] hover:underline">
                                <span>Konsultasi PPDB Unit {{ $info['code'] }}</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 5. STRUKTUR KURIKULUM & PROGRAM UNGGULAN -->
        <section id="kurikulum" class="py-10 sm:py-16 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">KURIKULUM UNGGULAN</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Program Pembelajaran {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Pengembangan potensi akademis, hafalan Al-Qur'an, dan karakter islami terpadu.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($info['programs'] as $prog)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm space-y-3 hover:border-emerald-500 hover:shadow-lg transition-all">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-[#c6f634] text-emerald-800 dark:text-[#061107] flex items-center justify-center text-2xl font-bold shadow-xs">
                            {{ $prog['icon'] }}
                        </div>
                        <h3 class="text-base font-bold font-headline text-slate-900 dark:text-white">{{ $prog['title'] }}</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium">{{ $prog['desc'] }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 6. DEWAN GURU & TENAGA PENDIDIK UNIT -->
        <section id="guru" class="py-10 sm:py-16 px-4 sm:px-6 bg-slate-50 dark:bg-[#040a04] border-t border-slate-200/60 dark:border-[#1a381c]">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">TENAGA PENDIDIK</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Dewan Guru &amp; Ustadz / Ustadzah {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Guru profesional, berpendidikan linier, hafidz Al-Qur'an, dan berdedikasi tinggi.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($info['teachers'] as $t)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-4 sm:p-5 text-center space-y-3 shadow-sm hover:shadow-md transition-all">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full overflow-hidden border-2 border-emerald-500 p-0.5 bg-white">
                            <img src="{{ $t['photo'] }}" alt="{{ $t['name'] }}" class="w-full h-full object-cover rounded-full" onerror="this.src='/images/logo robbani light.png';">
                        </div>
                        <div>
                            <h4 class="text-xs sm:text-sm font-bold font-headline text-slate-900 dark:text-white leading-snug">{{ $t['name'] }}</h4>
                            <span class="text-[10px] sm:text-[11px] font-semibold text-emerald-700 dark:text-[#c6f634] block mt-1">{{ $t['role'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 7. KISAH ALUMNI & TESTIMONI -->
        <section id="alumni" class="py-10 sm:py-16 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">KISAH SUKSES</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Kesan Alumni &amp; Orang Tua Unit</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Pengalaman berharga mempercayakan pendidikan putra-putri di {{ $info['name'] }}.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($info['alumni'] as $al)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm space-y-4">
                        <span class="material-symbols-outlined text-[32px] text-amber-500 block">format_quote</span>
                        <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-200 italic leading-relaxed">
                            "{{ $al['text'] }}"
                        </p>
                        <div class="flex items-center gap-3 pt-2 border-t border-slate-100 dark:border-[#1a381c]">
                            <img src="{{ $al['avatar'] }}" alt="{{ $al['name'] }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-600" onerror="this.src='/images/logo robbani light.png';">
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">{{ $al['name'] }}</h4>
                                <span class="text-[10px] text-emerald-700 dark:text-[#c6f634] font-semibold block">{{ $al['title'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 8. SPMB UNIT CALLOUT BANNER -->
        <section class="py-10 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto rounded-3xl bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] p-8 sm:p-12 text-white shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <span class="bg-orange-500 text-white font-black text-[10px] uppercase px-3 py-1 rounded-full">SPMB ONLINE TA 2026/2027</span>
                    <h2 class="text-2xl sm:text-3xl font-black font-headline">Bergabung Bersama {{ $info['name'] }}</h2>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium max-w-xl">Kuota pendaftaran terbatas untuk setiap rombongan belajar. Daftarkan putra-putri Anda secara online dengan cepat dan praktis.</p>
                </div>
                <a href="{{ route('school.ppdb') }}" class="btn-unit-cta px-8 py-4 rounded-full bg-white dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] font-black text-xs sm:text-sm shadow-xl hover:scale-105 transition-all shrink-0 flex items-center gap-2">
                    <span>Daftar Sekarang</span>
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>
        </section>

    </main>

    <!-- Unit Footer -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 px-4 sm:px-6 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <p class="font-bold text-slate-300">© {{ date('Y') }} {{ $info['name'] }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Yayasan Generasi Robbani Ogan Ilir Sumatera Selatan.</p>
            </div>
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 font-bold hover:text-emerald-300 flex items-center gap-1">
                <span>← Kembali ke Portal Utama</span>
            </a>
        </div>
    </footer>

</body>
</html>
