<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false, videoModalOpen: false, currentVideoUrl: '', currentVideoTitle: '', currentEmbedId: '' }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <title>Profil Resmi {{ $info['name'] }} | Portal Terpadu SIT Robbani</title>

    <!-- Favicon & Social Meta Tags -->
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
                            orange: '#f97316',
                            lime: '#c6f634'
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
           EXECUTIVE OBSIDIAN EMERALD & ELECTRIC LIME DARK MODE SYSTEM
           ========================================================================== */
        html.dark, html.dark body {
            background-color: #061107 !important;
            color: #f7fee7 !important;
        }

        html.dark header,
        html.dark section,
        html.dark footer,
        html.dark main,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .bg-white {
            background-color: #061107 !important;
        }

        /* Pure White Logo in Dark Mode */
        .logo-badge-container {
            background-color: transparent !important;
            display: inline-flex;
            align-items: center;
        }

        html.dark img.official-logo-img {
            filter: brightness(0) invert(1) !important;
        }

        /* Card Surfaces */
        html.dark .card-surface,
        html.dark .bg-white,
        html.dark .bg-slate-50 {
            background-color: #0d1e0f !important;
            border-color: #1a381c !important;
            color: #f7fee7 !important;
        }

        /* Section Pill Badges */
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

        /* Action CTA Buttons */
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

        /* Text Contrast */
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
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#061107] text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col selection:bg-orange-500 selection:text-white transition-colors duration-300">

    <!-- Top Utility Header Ribbon (WPSchool Pro Reference Style) -->
    <div class="bg-[#0b1f3a] dark:bg-[#040d06] text-slate-300 text-xs py-2 px-4 sm:px-6 border-b border-slate-800/80 dark:border-[#1a381c] relative z-50">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2.5">
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-[11px] font-medium text-slate-300">
                <span class="flex items-center gap-1.5 text-slate-300">
                    <span class="material-symbols-outlined text-[14px] text-amber-400 dark:text-[#c6f634]">location_on</span>
                    <span>Jl. Raya Lintas Timur KM. 35 Indralaya, Kab. Ogan Ilir</span>
                </span>
                <span class="text-slate-600 dark:text-slate-700 hidden sm:inline">•</span>
                <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['phone'] ?? '811747472', '0') }}" target="_blank" class="hover:text-amber-300 dark:hover:text-[#c6f634] transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] text-emerald-400 dark:text-[#c6f634]">call</span>
                    <span>{{ $info['phone'] ?? '0811-7474-72' }}</span>
                </a>
                <span class="text-slate-600 dark:text-slate-700 hidden sm:inline">•</span>
                <span class="flex items-center gap-1 text-slate-300 hidden lg:inline-flex">
                    <span class="material-symbols-outlined text-[14px] text-cyan-400 dark:text-[#c6f634]">mail</span>
                    <span>{{ $info['email'] ?? strtolower($info['code']) . '@sitrobbani.sch.id' }}</span>
                </span>
            </div>
            <div class="flex items-center gap-3 text-[11px] font-bold">
                <span class="px-2 py-0.5 rounded bg-amber-400/20 text-amber-300 dark:bg-[#c6f634]/20 dark:text-[#c6f634] border border-amber-400/30 dark:border-[#c6f634]/40 text-[10px] uppercase tracking-wider">
                    ✨ {{ $info['akreditasi'] }}
                </span>
                <span class="text-slate-600 dark:text-slate-700">•</span>
                <a href="{{ route('home') }}" class="hover:text-amber-300 dark:hover:text-[#c6f634] text-slate-200 transition-colors flex items-center gap-1">
                    <span>Portal SIT Robbani</span> ➔
                </a>
            </div>
        </div>
    </div>

    @php
        $unitCodeLower = strtolower($info['code'] ?? 'sdit');
        if ($unitCodeLower === 'kbtkit') $unitCodeLower = 'tkit';

        $themeConfig = [
            'tkit' => [
                'hero_gradient' => 'from-[#78350f] via-[#c2410c] to-[#ea580c]',
                'badge_bg' => 'bg-orange-400/20 text-orange-300 border-orange-400/40',
                'accent_text' => 'text-orange-600 dark:text-[#c6f634]',
                'btn_action' => 'bg-orange-600 hover:bg-orange-700 text-white dark:bg-[#c6f634] dark:text-[#061107]',
                'top_border' => 'border-t-orange-500',
                'glow_1' => 'bg-orange-500/20',
                'glow_2' => 'bg-amber-500/15',
                'tag_pill' => 'bg-orange-100 dark:bg-[#c6f634]/20 text-orange-800 dark:text-[#c6f634]',
                'brand_name' => 'KB/TKIT Robbani',
            ],
            'sdit' => [
                'hero_gradient' => 'from-[#003828] via-[#065f46] to-[#047857]',
                'badge_bg' => 'bg-emerald-400/20 text-emerald-300 border-emerald-400/40',
                'accent_text' => 'text-emerald-600 dark:text-[#c6f634]',
                'btn_action' => 'bg-emerald-700 hover:bg-emerald-800 text-white dark:bg-[#c6f634] dark:text-[#061107]',
                'top_border' => 'border-t-emerald-600',
                'glow_1' => 'bg-emerald-500/20',
                'glow_2' => 'bg-teal-500/15',
                'tag_pill' => 'bg-emerald-100 dark:bg-[#c6f634]/20 text-emerald-800 dark:text-[#c6f634]',
                'brand_name' => 'SDIT Robbani',
            ],
            'smpit' => [
                'hero_gradient' => 'from-[#071b34] via-[#0d2e5c] to-[#124285]',
                'badge_bg' => 'bg-blue-400/20 text-blue-300 border-blue-400/40',
                'accent_text' => 'text-blue-600 dark:text-[#c6f634]',
                'btn_action' => 'bg-[#1a56db] hover:bg-[#1e429f] text-white dark:bg-[#c6f634] dark:text-[#061107]',
                'top_border' => 'border-t-blue-600',
                'glow_1' => 'bg-blue-500/20',
                'glow_2' => 'bg-cyan-500/15',
                'tag_pill' => 'bg-blue-100 dark:bg-[#c6f634]/20 text-blue-800 dark:text-[#c6f634]',
                'brand_name' => 'SMPIT Robbani',
            ],
            'smait' => [
                'hero_gradient' => 'from-[#1e1b4b] via-[#4c1d95] to-[#6d28d9]',
                'badge_bg' => 'bg-purple-400/20 text-purple-300 border-purple-400/40',
                'accent_text' => 'text-purple-600 dark:text-[#c6f634]',
                'btn_action' => 'bg-purple-700 hover:bg-purple-800 text-white dark:bg-[#c6f634] dark:text-[#061107]',
                'top_border' => 'border-t-purple-600',
                'glow_1' => 'bg-purple-500/20',
                'glow_2' => 'bg-indigo-500/15',
                'tag_pill' => 'bg-purple-100 dark:bg-[#c6f634]/20 text-purple-800 dark:text-[#c6f634]',
                'brand_name' => 'SMAIT Robbani',
            ],
        ];

        $uTheme = $themeConfig[$unitCodeLower] ?? $themeConfig['sdit'];
        $unitLogoPath = '/images/logo_' . $unitCodeLower . '.png';
        if (!file_exists(public_path($unitLogoPath))) {
            $unitLogoPath = \App\Models\SiteSetting::get('logo_light', '/images/logo robbani light.png');
        }
    @endphp

    <!-- Main Navigation Header (Clean Floating Navbar) -->
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-[#07170a]/95 backdrop-blur-xl border-b border-slate-200/80 dark:border-[#1a381c] shadow-sm transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-4">
            
            <!-- Logo Section -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                <div class="logo-badge-container shrink-0 p-1.5 rounded-2xl bg-slate-50 dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-xs">
                    <img src="{{ asset($unitLogoPath) }}" alt="Logo {{ $info['name'] }}" width="140" height="44" fetchpriority="high" class="h-10 sm:h-11 w-auto object-contain transition-all group-hover:scale-105">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded {{ $uTheme['tag_pill'] }} border border-transparent dark:border-[#1a381c] font-black text-[10px] tracking-wider uppercase">
                            UNIT {{ $info['code'] }}
                        </span>
                        <span class="text-[10px] font-extrabold text-slate-500 dark:text-slate-400 hidden sm:inline-block">• SIT ROBBANI</span>
                    </div>
                    <span class="font-black text-sm sm:text-base text-slate-900 dark:text-white leading-tight block group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] transition-colors font-headline">
                        {{ $info['name'] }}
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden xl:flex items-center gap-4 text-xs font-bold text-slate-700 dark:text-slate-200 shrink-0">
                <a href="#" class="{{ $uTheme['accent_text'] }} font-black transition-colors">Beranda</a>
                <a href="#sambutan" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Profil Sekolah</a>
                <a href="#program" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Akademik</a>
                <a href="#agenda-pengumuman" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Agenda</a>
                <a href="#fasilitas" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Fasilitas</a>
                <a href="#guru" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Guru &amp; Staf</a>
                <a href="#berita" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Berita</a>
                <a href="#galeri" class="hover:text-emerald-600 dark:hover:text-[#c6f634] transition-colors whitespace-nowrap">Galeri</a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Gelap/Terang" class="p-2 rounded-xl bg-slate-100 dark:bg-[#0d1e0f] text-slate-700 dark:text-[#c6f634] hover:bg-slate-200 dark:hover:bg-[#16361a] transition-all shadow-xs border border-slate-200 dark:border-[#1a381c] shrink-0">
                    <span x-show="!darkMode" class="text-xs">🌙</span>
                    <span x-show="darkMode" class="text-xs">☀️</span>
                </button>

                <!-- Action Button: DAFTAR SISWA -->
                <a href="{{ route('school.ppdb') }}" class="px-5 py-2.5 rounded-xl {{ $uTheme['btn_action'] }} font-black text-xs shadow-md hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2 shrink-0 whitespace-nowrap">
                    <span>Daftar Siswa</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </nav>

            <!-- Mobile Controls -->
            <div class="flex items-center gap-2 xl:hidden shrink-0">
                <button @click="darkMode = !darkMode" class="p-2 rounded-xl bg-slate-100 dark:bg-[#0d1e0f] text-slate-700 dark:text-[#c6f634] border border-slate-200 dark:border-[#1a381c]">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl {{ $uTheme['btn_action'] }} font-bold text-sm flex items-center gap-1">
                    <span x-show="!mobileMenuOpen">☰ Menu</span>
                    <span x-show="mobileMenuOpen">✕ Tutup</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div x-show="mobileMenuOpen" x-cloak x-transition class="xl:hidden bg-white dark:bg-[#061107] border-b border-slate-200 dark:border-[#1a381c] px-6 py-4 space-y-3 font-bold text-xs">
        <a href="{{ route('home') }}" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🏠 Beranda Utama SIT Robbani</a>
        <a href="#sambutan" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">👤 Profil &amp; Sambutan Kepala Sekolah</a>
        <a href="#program" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🌟 Program Unggulan &amp; Kurikulum</a>
        <a href="#agenda-pengumuman" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">📅 Agenda &amp; Pengumuman</a>
        <a href="#fasilitas" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">🏢 Sarana &amp; Fasilitas Sekolah</a>
        <a href="#guru" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">👨‍🏫 Dewan Guru &amp; Tendik</a>
        <a href="#berita" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">📰 Berita &amp; Prestasi</a>
        <a href="#galeri" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-[#1a381c]">📸 Galeri Foto &amp; Video</a>
        <a href="{{ route('school.ppdb') }}" class="block py-3 text-center {{ $uTheme['btn_action'] }} font-black rounded-xl shadow-md">Daftar Siswa Online Unit {{ $info['code'] }} ➔</a>
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow space-y-12 sm:space-y-16">
        
        <!-- 1. BANNER HERO SECTION (Warna Unit di Light Mode & Obsidian Green + Neon Lime di Dark Mode) -->
        <section class="relative bg-gradient-to-r {{ $uTheme['hero_gradient'] }} dark:from-[#061107] dark:via-[#0d1e0f] dark:to-[#04200c] text-white pt-12 sm:pt-16 pb-20 sm:pb-28 px-4 sm:px-6 overflow-hidden border-b border-black/10 dark:border-[#1a381c] transition-colors duration-500">
            <!-- Ambient Background Glow & Geometric Accents -->
            <div class="absolute -top-24 -left-24 w-96 h-96 {{ $uTheme['glow_1'] }} dark:bg-[#c6f634]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 {{ $uTheme['glow_2'] }} dark:bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                
                <!-- Left: Headline & Actions -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 {{ $uTheme['badge_bg'] }} dark:bg-[#c6f634]/20 dark:text-[#c6f634] dark:border-[#c6f634]/40 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-400 dark:bg-[#c6f634] animate-ping"></span>
                        <span>✨ TAHFIDZ &amp; SAINS TERPADU ROBBANI</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black font-headline text-white dark:text-[#f7fee7] leading-tight tracking-tight drop-shadow-md">
                        Membentuk Generasi Cerdas untuk Masa Depan
                    </h1>

                    <p class="text-sm sm:text-base text-slate-200 dark:text-emerald-100/90 font-medium leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $info['tagline'] }} — Mendidik siswa berprestasi di bidang akademik, sains teknologi, penguasaan Al-Qur'an, dan berakhlak mulia di lingkungan {{ $info['name'] }}.
                    </p>

                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <!-- Amber CTA Button in Light Mode / Neon Lime in Dark Mode -->
                        <a href="{{ route('school.ppdb') }}" class="px-8 py-4 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-slate-950 dark:from-[#c6f634] dark:to-[#a3e635] dark:text-[#061107] font-black text-xs sm:text-sm shadow-xl hover:shadow-amber-500/30 dark:hover:shadow-[#c6f634]/30 hover:scale-105 transition-all flex items-center gap-2">
                            <span>Daftar Sekarang</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                        <!-- Secondary WhatsApp Consultation Button -->
                        <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['phone'] ?? '811747472', '0') }}" target="_blank" class="px-6 py-4 rounded-xl bg-white/10 hover:bg-white/20 dark:bg-[#153018]/80 dark:hover:bg-[#1c4021] backdrop-blur-md border border-white/25 dark:border-[#1a381c] text-white dark:text-[#f7fee7] font-bold text-xs sm:text-sm transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-emerald-400 dark:text-[#c6f634]">call</span>
                            <span>Konsultasi PPDB</span>
                        </a>
                    </div>
                </div>

                <!-- Right: High Resolution Student Visual -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-md lg:max-w-none">
                        <!-- Background Frame Decor -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-emerald-600 to-amber-400 dark:from-[#c6f634] dark:to-emerald-500 rounded-3xl transform rotate-2 scale-105 opacity-30 blur-sm"></div>
                        
                        <!-- Main Hero Image Container -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-2 border-white/20 dark:border-[#1a381c] bg-slate-900 aspect-[4/3] sm:aspect-[4/3] lg:aspect-[5/4]">
                            <img src="{{ !empty($info['hero_image']) ? $info['hero_image'] : '/uploads/wp_assets/1-e1643012044561_a09877b7.jpeg' }}" alt="Siswa Berprestasi {{ $info['name'] }}" width="600" height="450" fetchpriority="high" class="w-full h-full object-cover object-center" onerror="this.onerror=null; this.src='/images/mockup_desktop_1.png';">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 dark:from-[#061107]/80 via-transparent to-transparent"></div>
                            
                            <!-- Floating Achievement Badge -->
                            <div class="absolute bottom-4 left-4 right-4 bg-white/95 dark:bg-[#0d1e0f]/95 backdrop-blur-md p-3.5 rounded-2xl border border-white/30 dark:border-[#1a381c] shadow-lg flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-600 dark:bg-[#c6f634] text-white dark:text-[#061107] flex items-center justify-center font-black shrink-0 shadow-md">
                                        <span class="material-symbols-outlined text-[22px]">verified</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black uppercase text-emerald-700 dark:text-[#c6f634] block tracking-wider">UNIT RESMI AKREDITASI</span>
                                        <h4 class="text-xs font-black text-slate-900 dark:text-white">{{ $info['name'] }}</h4>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg bg-amber-100 dark:bg-[#c6f634]/20 text-amber-800 dark:text-[#c6f634] font-black text-[11px] border border-transparent dark:border-[#1a381c]">
                                    {{ $info['akreditasi'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- 2. MENU KECIL MELAYANG DI BAWAH BANNER (4 FLOATING ACTION CARDS) -->
        <section class="-mt-14 sm:-mt-20 relative z-30 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                    
                    <!-- Card 1: Profil Sekolah -->
                    <a href="#sambutan" class="bg-white dark:bg-[#0d1e0f] border-t-4 {{ $uTheme['top_border'] }} dark:border-t-[#c6f634] border-x border-b border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-5 shadow-xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-[#153018] text-emerald-600 dark:text-[#c6f634] flex items-center justify-center shrink-0 group-hover:bg-emerald-600 dark:group-hover:bg-[#c6f634] group-hover:text-white dark:group-hover:text-[#061107] transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-[26px]">school</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white font-headline group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] transition-colors">Profil Sekolah</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium line-clamp-1">Visi misi &amp; sambutan kepala sekolah</p>
                            </div>
                        </div>
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#153018] text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] group-hover:bg-emerald-50 dark:group-hover:bg-[#1c4021] flex items-center justify-center shrink-0 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </span>
                    </a>

                    <!-- Card 2: PPDB 2026/2027 -->
                    <a href="{{ route('school.ppdb') }}" class="bg-white dark:bg-[#0d1e0f] border-t-4 border-t-amber-500 dark:border-t-[#c6f634] border-x border-b border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-5 shadow-xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-[#153018] text-amber-600 dark:text-[#c6f634] flex items-center justify-center shrink-0 group-hover:bg-amber-500 dark:group-hover:bg-[#c6f634] group-hover:text-white dark:group-hover:text-[#061107] transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-[26px]">how_to_reg</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white font-headline group-hover:text-amber-600 dark:group-hover:text-[#c6f634] transition-colors">PPDB 2026/2027</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium line-clamp-1">Pendaftaran siswa baru online</p>
                            </div>
                        </div>
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#153018] text-slate-400 dark:text-slate-500 group-hover:text-amber-600 dark:group-hover:text-[#c6f634] group-hover:bg-amber-50 dark:group-hover:bg-[#1c4021] flex items-center justify-center shrink-0 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </span>
                    </a>

                    <!-- Card 3: Program Unggulan -->
                    <a href="#program" class="bg-white dark:bg-[#0d1e0f] border-t-4 border-t-cyan-500 dark:border-t-[#c6f634] border-x border-b border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-5 shadow-xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-50 dark:bg-[#153018] text-cyan-600 dark:text-[#c6f634] flex items-center justify-center shrink-0 group-hover:bg-cyan-500 dark:group-hover:bg-[#c6f634] group-hover:text-white dark:group-hover:text-[#061107] transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-[26px]">menu_book</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white font-headline group-hover:text-cyan-600 dark:group-hover:text-[#c6f634] transition-colors">Program Unggulan</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium line-clamp-1">Tahfidz, sains, koding &amp; bilingual</p>
                            </div>
                        </div>
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#153018] text-slate-400 dark:text-slate-500 group-hover:text-cyan-600 dark:group-hover:text-[#c6f634] group-hover:bg-cyan-50 dark:group-hover:bg-[#1c4021] flex items-center justify-center shrink-0 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </span>
                    </a>

                    <!-- Card 4: Agenda Sekolah -->
                    <a href="#agenda-pengumuman" class="bg-white dark:bg-[#0d1e0f] border-t-4 border-t-indigo-600 dark:border-t-[#c6f634] border-x border-b border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-5 shadow-xl hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 group flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-[#153018] text-indigo-600 dark:text-[#c6f634] flex items-center justify-center shrink-0 group-hover:bg-indigo-600 dark:group-hover:bg-[#c6f634] group-hover:text-white dark:group-hover:text-[#061107] transition-colors shadow-xs">
                                <span class="material-symbols-outlined text-[26px]">calendar_month</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white font-headline group-hover:text-indigo-600 dark:group-hover:text-[#c6f634] transition-colors">Agenda Sekolah</h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 font-medium line-clamp-1">Jadwal kegiatan &amp; pengumuman resmi</p>
                            </div>
                        </div>
                        <span class="w-8 h-8 rounded-full bg-slate-100 dark:bg-[#153018] text-slate-400 dark:text-slate-500 group-hover:text-indigo-600 dark:group-hover:text-[#c6f634] group-hover:bg-indigo-50 dark:group-hover:bg-[#1c4021] flex items-center justify-center shrink-0 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </span>
                    </a>

                </div>
            </div>
        </section>

        <!-- 3. SAMBUTAN KEPALA SEKOLAH UNIT (POSISI TERATAS, FOTO FORMAT KOTAK / PORTRAIT CARD SESUAI ASSET ASLI) -->
        <section id="sambutan" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 sm:p-10 shadow-xl flex flex-col md:flex-row gap-6 sm:gap-10 items-center relative overflow-hidden">
                    
                    <!-- Background Accent Watermark -->
                    <div class="absolute -right-10 -bottom-10 opacity-5 pointer-events-none text-emerald-900 dark:text-white">
                        <span class="material-symbols-outlined text-[260px]">school</span>
                    </div>

                    <!-- Foto Kepala Sekolah (FORMAT KOTAK / PORTRAIT PAS FOTO DENGAN ROUNDED CORNER) -->
                    <div class="flex-shrink-0 flex flex-col items-center text-center w-full md:w-1/3 z-10">
                        <div class="w-48 sm:w-56 h-64 sm:h-72 rounded-2xl overflow-hidden border-2 border-emerald-600 dark:border-[#c6f634] p-1 mb-4 shadow-2xl bg-white dark:bg-slate-900 ring-4 ring-emerald-500/20">
                            <img src="{{ $info['principal_photo'] }}" alt="Foto {{ $info['principal_name'] }}" width="224" height="288" loading="lazy" decoding="async" class="w-full h-full object-cover rounded-xl" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                        </div>
                        <span class="unit-pill-badge mb-1.5 px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-emerald-900 dark:text-[#061107] text-[10px] font-black uppercase tracking-wider shadow-sm">
                            KEPALA SEKOLAH
                        </span>
                        <h3 class="text-base sm:text-xl font-black font-headline text-slate-900 dark:text-white">{{ $info['principal_name'] }}</h3>
                        <p class="text-xs font-semibold text-emerald-700 dark:text-[#c6f634] max-w-[260px] mt-0.5">{{ $info['principal_title'] }}</p>
                    </div>

                    <!-- Teks Sambutan Resmi -->
                    <div class="flex-grow w-full md:w-2/3 border-t md:border-t-0 md:border-l border-slate-200 dark:border-[#1a381c] pt-5 md:pt-0 md:pl-8 text-center md:text-left space-y-4 z-10">
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <span class="material-symbols-outlined text-[32px] text-emerald-600/40 dark:text-[#c6f634]/40">format_quote</span>
                            <span class="text-xs font-black uppercase tracking-widest text-slate-400 dark:text-slate-400">KATA SAMBUTAN PIMPINAN SATUAN PENDIDIKAN</span>
                        </div>
                        
                        <p class="text-xs sm:text-base font-semibold italic text-slate-800 dark:text-slate-200 leading-relaxed">
                            "{{ $info['principal_greeting'] }}"
                        </p>

                        <div class="pt-2 flex flex-wrap items-center justify-center md:justify-start gap-4">
                            <a href="{{ route('school.ppdb') }}" class="btn-unit-cta px-5 py-2.5 rounded-full bg-emerald-700 dark:bg-[#c6f634] text-white dark:text-[#061107] font-black text-xs shadow-md hover:scale-105 transition-all flex items-center gap-1.5">
                                <span>Pendaftaran Siswa Baru {{ $info['code'] }}</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                            <a href="#guru" class="px-5 py-2.5 rounded-full bg-slate-100 dark:bg-[#153018] text-slate-700 dark:text-slate-200 font-bold text-xs hover:bg-slate-200 transition-all">
                                <span>Lihat Profil Dewan Guru ({{ count($info['teachers'] ?? []) }} GTK)</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 3. METRICS & STATISTIK UNIT -->
        <section id="statistik" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1 hover:border-emerald-500 transition-all">
                    <span class="text-3xl sm:text-4xl font-black text-emerald-700 dark:text-[#c6f634] block font-headline">
                        {{ $info['students_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Siswa Aktif Terdaftar</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1 hover:border-orange-500 transition-all">
                    <span class="text-3xl sm:text-4xl font-black text-orange-600 dark:text-[#c6f634] block font-headline">
                        {{ $info['employees_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Guru &amp; Tenaga Pendidik</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1 hover:border-emerald-500 transition-all">
                    <span class="text-3xl sm:text-4xl font-black text-emerald-700 dark:text-[#c6f634] block font-headline">
                        {{ $info['classrooms_count'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Rombongan Belajar</span>
                </div>
                <div class="p-5 sm:p-6 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200 dark:border-[#1a381c] shadow-sm text-center space-y-1 hover:border-emerald-500 transition-all">
                    <span class="text-xl sm:text-2xl font-black text-emerald-800 dark:text-[#c6f634] block font-headline py-1">
                        {{ $info['target_hafalan'] }}
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">Target Hafalan Al-Qur'an</span>
                </div>
            </div>
        </section>

        <!-- 4. PROFIL & VISI MISI UNIT -->
        <section id="profil" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">
                
                <!-- Left: Profil Pembelajaran -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] shadow-sm space-y-4">
                        <div class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">
                            PROFIL PEMBELAJARAN
                        </div>
                        <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900 dark:text-white">Keunggulan {{ $info['name'] }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                            {{ $info['description'] }}
                        </p>
                        <div class="pt-3 border-t border-slate-100 dark:border-[#1a381c] grid grid-cols-2 gap-4 text-xs font-bold text-slate-700 dark:text-slate-300">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-[#c6f634]">verified</span>
                                <span>Akreditasi: {{ $info['akreditasi'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-[#c6f634]">menu_book</span>
                                <span>Kurikulum: Merdeka + JSIT</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Visi & Misi Unit -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] shadow-sm space-y-4">
                        <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">
                            VISI &amp; MISI SATUAN PENDIDIKAN
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

        <!-- 5. STRUKTUR KURIKULUM & PROGRAM UNGGULAN -->
        <section id="program" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">KURIKULUM UNGGULAN</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Program Pembelajaran {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Pengembangan potensi akademis, hafalan Al-Qur'an, koding digital, dan pembiasaan adab islami.</p>
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

        <!-- 6 & 7. AGENDA & PENGUMUMAN SEBELAHAN (SIMETRIS & RAPI SEPERTI WEB UTAMA) -->
        <section id="agenda-pengumuman" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
                
                <!-- Left: Agenda Sekolah Unit (50% Symmetrical Column) -->
                <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 sm:p-7 shadow-sm space-y-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-[#1a381c] pb-4">
                        <div class="space-y-1">
                            <span class="unit-pill-badge inline-block px-3 py-0.5 rounded-full bg-emerald-100 dark:bg-[#c6f634]/20 text-emerald-800 dark:text-[#c6f634] text-[11px] font-black uppercase tracking-wider">
                                ✨ AGENDA UNIT {{ $info['code'] }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-black font-headline text-slate-900 dark:text-white">Jadwal &amp; Kalender Kegiatan</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline-block">Terjadwal</span>
                    </div>

                    @if(isset($unitAgendas) && count($unitAgendas) > 0)
                    <div class="space-y-3.5">
                        @foreach(array_slice($unitAgendas, 0, 3) as $ag)
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-[#061107] border border-slate-200/70 dark:border-[#1a381c] hover:border-emerald-500 dark:hover:border-[#c6f634] transition-all flex items-start gap-3.5 group">
                            <!-- Date Box -->
                            <div class="w-12 h-12 rounded-xl bg-emerald-700 dark:bg-[#153018] text-white dark:text-[#c6f634] flex flex-col items-center justify-center font-black shrink-0 shadow-xs border border-transparent dark:border-[#1a381c]">
                                <span class="text-sm leading-none font-headline">{{ preg_match('/\d+/', $ag['date'] ?? '', $m) ? $m[0] : '25' }}</span>
                                <span class="text-[9px] uppercase tracking-wider mt-0.5">{{ strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $ag['date'] ?? 'AGU'), 0, 3)) ?: 'AGU' }}</span>
                            </div>
                            <!-- Agenda Details -->
                            <div class="space-y-1 min-w-0 flex-1">
                                <h3 class="text-xs sm:text-sm font-bold font-headline text-slate-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors line-clamp-1">
                                    {{ $ag['title'] }}
                                </h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1 leading-snug">{{ $ag['desc'] }}</p>
                                <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 dark:text-slate-400 pt-0.5">
                                    <span class="flex items-center gap-1">📍 {{ $ag['location'] ?? 'Kampus SIT Robbani' }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">⏰ {{ $ag['time'] ?? '08:00 WIB' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-8 text-center bg-slate-50 dark:bg-[#061107] rounded-2xl border border-slate-200/70 dark:border-[#1a381c] text-xs text-slate-500 dark:text-slate-400 space-y-1">
                        <span class="text-2xl block mb-1">📅</span>
                        <p class="font-bold">Belum ada agenda terdekat untuk unit ini.</p>
                        <p class="text-[11px] text-slate-400">Jadwal kegiatan berkala akan diperbarui oleh admin unit.</p>
                    </div>
                    @endif
                </div>

                <!-- Right: Pengumuman Resmi Unit (50% Symmetrical Column) -->
                <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 sm:p-7 shadow-sm space-y-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-[#1a381c] pb-4">
                        <div class="space-y-1">
                            <span class="unit-pill-badge inline-block px-3 py-0.5 rounded-full bg-orange-100 dark:bg-[#c6f634]/20 text-orange-800 dark:text-[#c6f634] text-[11px] font-black uppercase tracking-wider">
                                📢 INFORMASI RESMI
                            </span>
                            <h2 class="text-lg sm:text-xl font-black font-headline text-slate-900 dark:text-white">Pengumuman &amp; Edaran Unit</h2>
                        </div>
                        <span class="text-xs text-slate-400 font-bold hidden sm:inline-block">Terbaru</span>
                    </div>

                    @if(isset($unitAnnouncements) && count($unitAnnouncements) > 0)
                    <div class="space-y-3.5">
                        @foreach(array_slice($unitAnnouncements, 0, 3) as $ann)
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-[#061107] border-l-4 border-l-orange-500 dark:border-l-[#c6f634] border-y border-r border-slate-200/70 dark:border-y-[#1a381c] dark:border-r-[#1a381c] hover:border-orange-500 dark:hover:border-[#c6f634] transition-all space-y-1.5 group">
                            <div class="flex items-center justify-between text-[10px] text-slate-400 dark:text-slate-400">
                                <span class="font-bold text-orange-600 dark:text-[#c6f634] flex items-center gap-1">🗓️ {{ $ann['date'] ?? '17 Agustus 2026' }}</span>
                                <span class="bg-orange-100 dark:bg-[#c6f634]/20 text-orange-800 dark:text-[#c6f634] px-2 py-0.5 rounded font-black uppercase text-[9px]">PENGUMUMAN</span>
                            </div>
                            <h3 class="text-xs sm:text-sm font-bold font-headline text-slate-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-[#c6f634] transition-colors line-clamp-1">
                                {{ $ann['title'] }}
                            </h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1 leading-snug">
                                {{ $ann['summary'] ?? $ann['excerpt'] ?? strip_tags($ann['content'] ?? '') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-8 text-center bg-slate-50 dark:bg-[#061107] rounded-2xl border border-slate-200/70 dark:border-[#1a381c] text-xs text-slate-500 dark:text-slate-400 space-y-1">
                        <span class="text-2xl block mb-1">📢</span>
                        <p class="font-bold">Belum ada pengumuman baru untuk unit ini.</p>
                        <p class="text-[11px] text-slate-400">Pengumuman dan edaran wali murid akan ditampilkan di sini.</p>
                    </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- 8. SARANA & FASILITAS SEKOLAH UNIT -->
        @if(isset($unitFacilities) && count($unitFacilities) > 0)
        <section id="fasilitas" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">SARANA PRASARANA</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Fasilitas Unggulan {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Sarana penunjang kenyamanan belajar, ibadah, olahraga, dan laboratorium modern.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($unitFacilities as $fac)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all group">
                        <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-900">
                            <img src="{{ $fac['image'] }}" alt="{{ $fac['title'] }}" width="380" height="240" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/mockup_desktop_1.png';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            <span class="absolute bottom-3 left-3 bg-emerald-700/90 text-white text-[10px] font-black uppercase px-2.5 py-1 rounded-full backdrop-blur-sm">Fasilitas Terpadu</span>
                        </div>
                        <div class="p-5 sm:p-6 space-y-2">
                            <h3 class="text-base font-bold font-headline text-slate-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">{{ $fac['title'] }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{{ $fac['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>
        @endif

        <!-- 9. EKSTRAKURIKULER & MINAT BAKAT -->
        @if(isset($unitEkskul) && count($unitEkskul) > 0)
        <section id="ekskul" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">MINAT &amp; BAKAT</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Ekstrakurikuler Siswa {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Wadah eksplorasi talenta sains, teknologi koding, seni islami, panahan, dan kepanduan.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($unitEkskul as $ek)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-5 text-center space-y-2.5 shadow-sm hover:border-orange-500 hover:shadow-md transition-all">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-orange-50 dark:bg-[#153018] text-orange-600 dark:text-[#c6f634] flex items-center justify-center text-xl font-bold shadow-xs">
                            🎯
                        </div>
                        <h3 class="text-xs sm:text-sm font-bold font-headline text-slate-900 dark:text-white leading-snug">{{ $ek['title'] }}</h3>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">{{ $ek['desc'] }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>
        @endif

        <!-- 10. DEWAN GURU & TENAGA PENDIDIK (GTK) (FORMAT FOTO KOTAK 3:4 RAPI & SERAGAM) -->
        <section id="guru" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">TENAGA PENDIDIK</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Dewan Guru &amp; Tenaga Pendidik {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Guru profesional, berpendidikan linier, hafidz Al-Qur'an, dan berdedikasi tinggi membimbing siswa.</p>
                </div>

                <!-- Grid Guru Format Foto Kotak Pas Foto 3:4 -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($info['teachers'] as $t)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-4 sm:p-5 text-center space-y-3 shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all flex flex-col justify-between group">
                        <div class="space-y-3">
                            <!-- Foto Pendidik Format Kotak 3:4 -->
                            <div class="w-full aspect-[3/4] sm:aspect-[4/5] rounded-2xl overflow-hidden border border-slate-200 dark:border-[#1a381c] bg-slate-100 dark:bg-slate-800 shadow-sm group-hover:scale-[1.02] transition-transform duration-300">
                                <img src="{{ $t['photo'] }}" alt="{{ $t['name'] }}" width="128" height="128" loading="lazy" decoding="async" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                            </div>
                            <div>
                                <h3 class="text-xs sm:text-sm font-bold font-headline text-slate-900 dark:text-white leading-snug group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">{{ $t['name'] }}</h3>
                                <span class="text-[10px] sm:text-[11px] font-semibold text-emerald-700 dark:text-[#c6f634] block mt-1">{{ $t['role'] }}</span>
                            </div>
                        </div>
                        @if(!empty($t['bio']))
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-2 italic pt-2 border-t border-slate-100 dark:border-[#1a381c]">
                            "{{ $t['bio'] }}"
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 11. BERITA & PRESTASI SISWA KHUSUS UNIT -->
        <section id="berita" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                    <div>
                        <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">KABAR TERBARU</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Berita &amp; Prestasi {{ $info['name'] }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">Dokumentasi kegiatan, prestasi siswa, dan pengumuman resmi unit {{ $info['code'] }}.</p>
                    </div>
                    <a href="{{ route('school.berita') }}" class="px-5 py-2.5 rounded-full bg-white dark:bg-[#0d1e0f] text-emerald-700 dark:text-[#c6f634] font-black text-xs border border-slate-200/80 dark:border-[#1a381c] shadow-sm hover:shadow-md transition-all flex items-center gap-1.5 shrink-0">
                        <span>Lihat Semua Berita</span> ➔
                    </a>
                </div>

                @if(isset($unitNews) && count($unitNews) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($unitNews as $un)
                    @php
                        $unSlug = $un['slug'] ?? \Illuminate\Support\Str::slug($un['title']);
                    @endphp
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-900">
                                <img src="{{ $un['image'] }}" alt="{{ $un['title'] }}" width="380" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-4 bg-white';">
                                <span class="absolute top-3 left-3 bg-emerald-700 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase shadow-md">
                                    {{ $un['category'] ?? ('Berita ' . $info['code']) }}
                                </span>
                            </div>
                            <div class="p-5 sm:p-6 space-y-2.5">
                                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-400 block">🗓️ {{ $un['date'] }}</span>
                                <h3 class="text-sm sm:text-base font-black font-headline text-slate-900 dark:text-white line-clamp-2 group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors leading-snug">
                                    {{ $un['title'] }}
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed font-medium">
                                    {{ $un['excerpt'] }}
                                </p>
                            </div>
                        </div>
                        <div class="p-5 sm:p-6 pt-0">
                            <a href="{{ route('school.berita.show', $unSlug) }}" class="text-emerald-700 dark:text-[#c6f634] font-black text-xs flex items-center gap-1 group-hover:underline">
                                <span>Baca Selengkapnya</span> ➔
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

            </div>
        </section>

        <!-- 12. ARTIKEL & EDITORIAL EDUKASI UNIT -->
        @if(isset($unitArticles) && count($unitArticles) > 0)
        <section id="artikel" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                    <div>
                        <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">LITERASI &amp; EDUKASI</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Artikel &amp; Editorial {{ $info['code'] }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">Wawasan keislaman, parenting, dan tips belajar siswa.</p>
                    </div>
                    <a href="{{ route('school.artikel') }}" class="px-5 py-2.5 rounded-full bg-white dark:bg-[#0d1e0f] text-orange-600 dark:text-[#c6f634] font-black text-xs border border-slate-200/80 dark:border-[#1a381c] shadow-sm hover:shadow-md transition-all flex items-center gap-1.5 shrink-0">
                        <span>Lihat Semua Artikel</span> ➔
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($unitArticles as $art)
                    @php
                        $artSlug = $art['slug'] ?? \Illuminate\Support\Str::slug($art['title']);
                    @endphp
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:border-orange-500 transition-all flex flex-col justify-between group">
                        <div>
                            <div class="relative h-44 sm:h-48 overflow-hidden bg-slate-900">
                                <img src="{{ $art['image'] }}" alt="{{ $art['title'] }}" width="380" height="200" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/mockup_desktop_2.png';">
                                <span class="absolute top-3 left-3 bg-orange-600 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase shadow-md">
                                    {{ $art['category'] ?? 'Artikel' }}
                                </span>
                            </div>
                            <div class="p-5 space-y-2">
                                <span class="text-[11px] font-bold text-slate-400 block">🗓️ {{ $art['date'] }}</span>
                                <h3 class="text-sm sm:text-base font-black font-headline text-slate-900 dark:text-white line-clamp-2 group-hover:text-orange-600 dark:group-hover:text-[#c6f634] transition-colors leading-snug">
                                    {{ $art['title'] }}
                                </h3>
                                <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed font-medium">
                                    {{ $art['excerpt'] }}
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <a href="{{ route('school.artikel.show', $artSlug) }}" class="text-orange-600 dark:text-[#c6f634] font-black text-xs flex items-center gap-1 group-hover:underline">
                                <span>Baca Artikel</span> ➔
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>
        @endif

        <!-- 13. GALERI FOTO & DOKUMENTASI KEGIATAN UNIT -->
        @if(isset($unitGallery) && count($unitGallery) > 0)
        <section id="galeri" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#c6f634] text-[#004532] dark:text-[#061107] text-xs font-black uppercase tracking-wider">DOKUMENTASI FOTO</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Galeri Foto Kegiatan {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Potret keceriaan siswa, perkemahan, kegiatan manasik, dan perlombaan akademik.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach(array_slice($unitGallery, 0, 8) as $gal)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:scale-[1.02] transition-all group relative">
                        <div class="h-44 sm:h-52 overflow-hidden bg-slate-900 relative">
                            <img src="{{ $gal['image'] }}" alt="{{ $gal['title'] }}" width="380" height="250" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/mockup_desktop_3.png';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity"></div>
                            <div class="absolute bottom-3 left-3 right-3 text-white space-y-1">
                                <span class="text-[10px] font-bold text-amber-300 block">🗓️ {{ $gal['date'] ?? 'Kegiatan' }}</span>
                                <h3 class="text-xs sm:text-sm font-bold font-headline leading-tight line-clamp-2">{{ $gal['title'] }}</h3>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>
        @endif

        <!-- 14. GALERI VIDEO KEGIATAN UNIT -->
        @if(isset($unitVideos) && count($unitVideos) > 0)
        <section id="video" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-red-100 dark:bg-[#c6f634] text-red-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">DOKUMENTASI VIDEO</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Galeri Video Kegiatan {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Saksikan video aktivitas belajar, wisuda tahfidz, unjuk bakat siswa, dan dokumenter sekolah resmi.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(array_slice($unitVideos, 0, 9) as $vid)
                    @php
                        $embedId = $vid['embed_id'] ?? '';
                    @endphp
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between cursor-pointer"
                         @click="currentEmbedId = '{{ $embedId }}'; currentVideoUrl = '{{ $vid['url'] }}'; currentVideoTitle = '{{ addslashes($vid['title']) }}'; videoModalOpen = true">
                        <div>
                            <div class="relative h-48 sm:h-52 overflow-hidden bg-slate-900 flex items-center justify-center">
                                <img src="{{ $vid['image'] }}" alt="{{ $vid['title'] }}" width="400" height="225" loading="lazy" decoding="async" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/mockup_desktop_4.png';">
                                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                                <!-- Red YouTube Play Button Icon -->
                                <div class="absolute w-14 h-14 rounded-full bg-red-600/90 text-white flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:bg-red-600 transition-all ring-4 ring-white/30">
                                    <span class="material-symbols-outlined text-[32px] ml-1">play_arrow</span>
                                </div>
                                <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full shadow-md">
                                    YouTube Video
                                </span>
                            </div>
                            <div class="p-5 space-y-2">
                                <span class="text-[10px] font-bold text-slate-400 block">🗓️ {{ $vid['date'] ?? 'Dokumentasi Video' }}</span>
                                <h3 class="text-sm sm:text-base font-bold font-headline text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-red-600 dark:group-hover:text-[#c6f634] transition-colors">{{ $vid['title'] }}</h3>
                            </div>
                        </div>
                        <div class="p-5 pt-0">
                            <span class="text-red-600 dark:text-[#c6f634] font-black text-xs flex items-center gap-1 group-hover:underline">
                                <span>Putar Video</span> ▶
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>
        @endif

        <!-- 15. KISAH ALUMNI & TESTIMONI -->
        <section id="alumni" class="px-4 sm:px-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                <div class="text-center space-y-1">
                    <span class="unit-pill-badge inline-block px-3 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634] text-orange-800 dark:text-[#061107] text-xs font-black uppercase tracking-wider">KISAH SUKSES</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Kesan Alumni &amp; Orang Tua {{ $info['code'] }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Pengalaman berharga mempercayakan pendidikan putra-putri di {{ $info['name'] }}.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($info['alumni'] as $al)
                    <div class="bg-white dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
                        <div class="space-y-3">
                            <span class="material-symbols-outlined text-[32px] text-amber-500 block">format_quote</span>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-200 italic leading-relaxed">
                                "{{ $al['text'] }}"
                            </p>
                        </div>
                        <div class="flex items-center gap-3 pt-3 border-t border-slate-100 dark:border-[#1a381c]">
                            <!-- Foto Alumni Kotak Rounded -->
                            <div class="w-12 h-12 rounded-2xl overflow-hidden border-2 border-emerald-600 dark:border-[#c6f634] bg-white shrink-0">
                                <img src="{{ $al['avatar'] }}" alt="{{ $al['name'] }}" width="56" height="56" loading="lazy" decoding="async" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                            </div>
                            <div>
                                <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white">{{ $al['name'] }}</h3>
                                <span class="text-[10px] sm:text-xs text-emerald-700 dark:text-[#c6f634] font-semibold block">{{ $al['title'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- 16. SPMB UNIT CALLOUT BANNER -->
        <section class="px-4 sm:px-6 pb-8">
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

    <!-- YouTube Video Modal Player -->
    <div x-show="videoModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md" @keydown.escape.window="videoModalOpen = false; currentEmbedId = ''; currentVideoUrl = ''">
        <div class="relative w-full max-w-4xl bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-slate-700" @click.away="videoModalOpen = false; currentEmbedId = ''; currentVideoUrl = ''">
            <div class="p-4 bg-slate-950 flex items-center justify-between border-b border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="bg-red-600 text-white text-[10px] font-black uppercase px-2 py-0.5 rounded">YOUTUBE</span>
                    <h4 class="text-xs sm:text-sm font-bold text-white line-clamp-1" x-text="currentVideoTitle"></h4>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="currentVideoUrl" target="_blank" class="text-xs font-bold text-emerald-400 hover:underline flex items-center gap-1">
                        <span>Buka di YouTube</span> ➔
                    </a>
                    <button @click="videoModalOpen = false; currentEmbedId = ''; currentVideoUrl = ''" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm font-black transition-all">✕</button>
                </div>
            </div>
            <div class="aspect-video w-full bg-black">
                <template x-if="videoModalOpen && currentEmbedId">
                    <iframe :src="'https://www.youtube-nocookie.com/embed/' + currentEmbedId + '?autoplay=1&rel=0'" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </template>
            </div>
        </div>
    </div>

    <!-- Modern 4-Column Footer (WPSchool Pro Reference Style) -->
    <footer class="bg-[#07182c] text-slate-300 text-xs border-t border-slate-800/80 mt-auto">
        <!-- Top Footer Columns -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-10">
                
                <!-- Col 1: Logo & School Identity (4 cols) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="inline-flex items-center gap-3 bg-white p-2.5 rounded-2xl shadow-md border border-slate-200">
                        <img src="{{ asset($unitLogoPath) }}" alt="Logo {{ $info['name'] }}" width="140" height="40" loading="lazy" decoding="async" class="h-10 w-auto object-contain">
                        <div>
                            <span class="text-[10px] font-black text-blue-700 uppercase tracking-wider block">SIT ROBBANI</span>
                            <span class="text-xs font-black text-slate-900 leading-tight block">{{ $info['name'] }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Lembaga Pendidikan Islam Terpadu unggulan di Kabupaten Ogan Ilir yang mengintegrasikan pembinaan aqidah, tahfidz Al-Qur'an, sains modern, dan karakter kepemimpinan Qur'ani.
                    </p>
                    <div class="flex items-center gap-2 pt-2">
                        <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['phone'] ?? '811747472', '0') }}" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-emerald-600 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs" title="WhatsApp">
                            <span class="material-symbols-outlined text-[18px]">chat</span>
                        </a>
                        <a href="{{ route('home') }}" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs" title="Portal Utama">
                            <span class="material-symbols-outlined text-[18px]">language</span>
                        </a>
                        <a href="#video" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-red-600 text-slate-300 hover:text-white flex items-center justify-center transition-all shadow-xs" title="YouTube">
                            <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigasi Utama (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-black text-white font-headline border-b border-slate-800 pb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span>Navigasi Utama</span>
                    </h4>
                    <ul class="space-y-2 text-xs font-semibold text-slate-400">
                        <li><a href="#" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Beranda {{ $info['code'] }}</a></li>
                        <li><a href="#sambutan" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Sambutan Kepala Sekolah</a></li>
                        <li><a href="#profil" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Profil &amp; Visi Misi</a></li>
                        <li><a href="#program" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Kurikulum &amp; Program Unggulan</a></li>
                        <li><a href="#fasilitas" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Sarana &amp; Fasilitas Sekolah</a></li>
                        <li><a href="#guru" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Dewan Guru &amp; Tendik</a></li>
                        <li><a href="#berita" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Berita &amp; Prestasi Siswa</a></li>
                    </ul>
                </div>

                <!-- Col 3: Informasi Sekolah (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-sm font-black text-white font-headline border-b border-slate-800 pb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span>Informasi Sekolah</span>
                    </h4>
                    <ul class="space-y-2 text-xs font-semibold text-slate-400">
                        <li><a href="{{ route('school.ppdb') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all text-amber-300/90 font-bold">• PPDB Online 2026</a></li>
                        <li><a href="#agenda-pengumuman" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Agenda &amp; Info</a></li>
                        <li><a href="#galeri" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Galeri Foto</a></li>
                        <li><a href="#video" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Galeri Video</a></li>
                        <li><a href="#alumni" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all">• Testimoni Alumni</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-amber-300 hover:translate-x-1 inline-block transition-all text-cyan-400">• Portal SIT Robbani</a></li>
                    </ul>
                </div>

                <!-- Col 4: Hubungi Kami (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-sm font-black text-white font-headline border-b border-slate-800 pb-2 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Hubungi Kami</span>
                    </h4>
                    <div class="space-y-2.5 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <span class="material-symbols-outlined text-[16px] text-amber-400 shrink-0 mt-0.5">location_on</span>
                            <span>Jl. Raya Lintas Timur KM. 35 Indralaya, Kab. Ogan Ilir, Sumatera Selatan</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[16px] text-emerald-400 shrink-0">call</span>
                            <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['phone'] ?? '811747472', '0') }}" target="_blank" class="hover:text-white transition-colors">
                                {{ $info['phone'] ?? '0811-7474-72' }}
                            </a>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[16px] text-cyan-400 shrink-0">mail</span>
                            <span>{{ $info['email'] ?? strtolower($info['code']) . '@sitrobbani.sch.id' }}</span>
                        </div>
                        <div class="flex items-start gap-2.5 pt-1 border-t border-slate-800/80">
                            <span class="material-symbols-outlined text-[16px] text-indigo-400 shrink-0 mt-0.5">schedule</span>
                            <div>
                                <strong class="text-white block font-bold">Jam Layanan:</strong>
                                <span>Senin – Jumat: 07.30 – 16.00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom Copyright Sub-Footer -->
        <div class="bg-[#051120] py-5 px-4 sm:px-6 border-t border-slate-800/80">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left text-[11px] text-slate-500 font-medium">
                <div>
                    <span>© {{ date('Y') }} <strong>{{ $info['name'] }}</strong>. Yayasan Generasi Robbani Ogan Ilir.</span>
                </div>
                <div class="flex items-center gap-4 text-slate-400">
                    <a href="{{ route('home') }}" class="hover:text-white transition-colors">Portal Utama</a>
                    <span>•</span>
                    <a href="{{ route('school.ppdb') }}" class="hover:text-white transition-colors">SPMB Online</a>
                    <span>•</span>
                    <a href="#sambutan" class="hover:text-white transition-colors">Ke Atas ↑</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
