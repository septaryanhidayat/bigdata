<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false, activeVideoUrl: null, activeVideoTitle: null, activeLightboxImage: null, activeLightboxTitle: null }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] }} | Website Resmi SIT Robbani Ogan Ilir</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon & Social Sharing Meta Tags (Default Light Logo) -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $settings['school_name'] }} | Website Resmi">
    <meta property="og:description" content="{{ $settings['hero_desc'] }}">
    <meta property="og:image" content="{{ asset($settings['social_share_image'] ?? 'images/logo robbani light.png') }}">
    <meta property="og:site_name" content="SIT Robbani Ogan Ilir">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['school_name'] }} | Website Resmi">
    <meta name="twitter:description" content="{{ $settings['hero_desc'] }}">
    <meta name="twitter:image" content="{{ asset($settings['social_share_image'] ?? 'images/logo robbani light.png') }}">

    <!-- Tailwind CSS CDN with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "primary": "#004532",
                "primary-container": "#065f46",
                "secondary-container": "#fd761a",
                "accent-orange": "#f97316",
                "on-surface": "#0f172a",
                "on-surface-variant": "#475569",
                "background": "#f8fafc",
                "surface": "#ffffff",
                "outline-variant": "#e2e8f0"
            },
            "spacing": {
                "md": "16px",
                "sm": "8px",
                "xs": "4px",
                "lg": "24px",
                "xl": "48px",
                "container-max": "1280px",
                "gutter": "24px"
            },
            "fontFamily": {
                "body": ["Inter", "sans-serif"],
                "headline": ["Montserrat", "sans-serif"]
            }
          }
        }
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 700, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined[data-weight="fill"] {
            font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
        }
        [x-cloak] { display: none !important; }

        /* ==========================================================================
           EXECUTIVE DEEP OBSIDIAN EMERALD & ELECTRIC LEMON DARK MODE SYSTEM
           ========================================================================== */
        html.dark, html.dark body {
            background-color: #061107 !important;
            color: #f7fee7 !important;
        }

        /* 1. Base Backgrounds */
        html.dark nav,
        html.dark section,
        html.dark main,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100 {
            background-color: #061107 !important;
        }

        /* 2. Deep Moss Emerald Card Surfaces (#0e2010) */
        html.dark .bg-white,
        html.dark .bg-slate-50\/80,
        html.dark .card-surface {
            background-color: #0e2010 !important;
            border-color: #1a381c !important;
            color: #f7fee7 !important;
        }

        /* 3. Hero Glassmorphism Container */
        .hero-glass-container {
            background-color: rgba(255, 255, 255, 0.90);
            border-color: rgba(255, 255, 255, 0.6);
            color: #0f172a;
        }

        html.dark .hero-glass-container {
            background-color: rgba(13, 34, 18, 0.92) !important;
            border-color: #1e4222 !important;
            color: #f7fee7 !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
        }

        html.dark .hero-glass-container h1 { color: #ffffff !important; }
        html.dark .hero-glass-container p { color: #d9f99d !important; }

        /* 4. Pure White Logo Filter in Dark Mode (NO WHITE BACKGROUND BOX) */
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

        html.dark img[alt*="Robbani Logo"],
        html.dark img[src*="logo-robbani"],
        html.dark img[src*="WEB-SIT-2"] {
            filter: brightness(0) invert(1) !important;
        }

        /* UNIFIED SITE SECTION BADGE SYSTEM (ELECTRIC LIME BG + OBSIDIAN BLACK TEXT IN DARK MODE) */
        .site-section-badge {
            background-color: #dcfce7;
            color: #004532;
            border: 1px solid #bbf7d0;
            padding: 0.25rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-block;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        html.dark .site-section-badge,
        html.dark [class*="site-section-badge"] {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
        }

        html.dark .site-section-badge *,
        html.dark [class*="site-section-badge"] * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* 5. ALL Section Pill Badges in Dark Mode (100% BLACK/DARK GREEN CRISP TEXT ON LIME BG) */
        html.dark .bg-emerald-100,
        html.dark .bg-orange-100,
        html.dark .bg-orange-100\/90,
        html.dark .bg-purple-100,
        html.dark .bg-emerald-700,
        html.dark [class*="bg-emerald-100"],
        html.dark [class*="bg-orange-100"] {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
        }

        html.dark .bg-emerald-100 *,
        html.dark .bg-orange-100 *,
        html.dark .bg-purple-100 *,
        html.dark .bg-emerald-700 *,
        html.dark [class*="bg-emerald-100"] *,
        html.dark [class*="bg-orange-100"] * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* 6. Calendar Date Box in Agenda Section */
        html.dark .calendar-date-box,
        html.dark .w-10.h-10.bg-emerald-700,
        html.dark .w-12.h-12.bg-emerald-700 {
            background-color: #c6f634 !important;
            color: #061107 !important;
        }

        html.dark .calendar-date-box *,
        html.dark .w-10.h-10.bg-emerald-700 *,
        html.dark .w-12.h-12.bg-emerald-700 * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* 7. Realtime Prayer Widget in Dark Mode (ZERO ORANGE IN DARK MODE) */
        html.dark .prayer-widget-card,
        html.dark [class*="bg-slate-900"] {
            background-color: #0d1e0f !important;
            border-color: #1a381c !important;
        }

        html.dark .prayer-widget-card .bg-slate-800\/80 {
            background-color: #153018 !important;
            border-color: #1f4523 !important;
        }

        html.dark .prayer-widget-card .bg-orange-600,
        html.dark .prayer-widget-card .bg-orange-500,
        html.dark .prayer-widget-card [class*="bg-orange"] {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
        }

        html.dark .prayer-widget-card .bg-orange-600 *,
        html.dark .prayer-widget-card .bg-orange-500 *,
        html.dark .prayer-widget-card [class*="bg-orange"] * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        html.dark .prayer-widget-card .text-amber-300,
        html.dark .prayer-widget-card .text-emerald-400,
        html.dark .prayer-widget-card .text-emerald-300 {
            color: #c6f634 !important;
        }

        /* 8. Text Colors in Dark Mode (NO DARK GREEN TEXT ON DARK GREEN BACKGROUNDS) */
        html.dark h2, html.dark h3,
        html.dark .font-headline {
            color: #ffffff !important;
        }

        html.dark .text-emerald-700,
        html.dark .text-emerald-800,
        html.dark .text-emerald-900,
        html.dark .text-emerald-950,
        html.dark .text-emerald-600,
        html.dark .text-emerald-500,
        html.dark .text-orange-700,
        html.dark .text-orange-800,
        html.dark .text-\[\#004532\],
        html.dark .text-\[\#003828\] {
            color: #c6f634 !important;
        }

        /* 9. Action Buttons in Dark Mode (ONLY CTA buttons, NOT quick menu cards or footer navigation links) */
        html.dark button[type="submit"],
        html.dark a.btn-primary-cta,
        html.dark a.bg-gradient-to-r.from-amber-500,
        html.dark a.bg-gradient-to-r.from-\[\#fd761a\],
        html.dark a.bg-emerald-700,
        html.dark a.bg-emerald-600,
        html.dark a.bg-orange-600,
        html.dark a[href*="school/unit/"] {
            background: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
            box-shadow: 0 10px 25px -5px rgba(198, 246, 52, 0.4) !important;
        }

        html.dark button[type="submit"] *,
        html.dark a.btn-primary-cta *,
        html.dark a.bg-gradient-to-r.from-amber-500 *,
        html.dark a.bg-gradient-to-r.from-\[\#fd761a\] *,
        html.dark a.bg-emerald-700 *,
        html.dark a.bg-emerald-600 *,
        html.dark a.bg-orange-600 *,
        html.dark a[href*="school/unit/"] * {
            color: #061107 !important;
        }

        /* UNIFORM QUICK MENU CARDS IN DARK MODE */
        html.dark .quick-menu-card {
            background-color: #0d1e0f !important;
            border-color: #1a381c !important;
            box-shadow: none !important;
        }

        html.dark .quick-menu-card .w-11,
        html.dark .quick-menu-card .w-14 {
            background-color: #c6f634 !important;
            color: #061107 !important;
        }

        html.dark .quick-menu-card span.quick-menu-label {
            color: #f7fee7 !important;
        }

        html.dark .quick-menu-card .w-11 *,
        html.dark .quick-menu-card .w-14 * {
            color: #061107 !important;
        }

        /* ANNOUNCEMENT & NEWS CATEGORY BADGE (100% BLACK ON LIME IN DARK MODE) */
        .news-cat-badge {
            background-color: #ffedd5 !important;
            color: #9a3412 !important;
            border: 1px solid #fed7aa !important;
            font-weight: 800 !important;
            font-size: 0.5625rem !important;
            padding: 0.125rem 0.5rem !important;
            border-radius: 0.375rem !important;
            text-transform: uppercase !important;
            display: inline-block !important;
        }

        html.dark .news-cat-badge,
        html.dark [class*="news-cat-badge"],
        html.dark .announcement-cat-badge {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
        }

        html.dark .news-cat-badge *,
        html.dark [class*="news-cat-badge"] *,
        html.dark .announcement-cat-badge * {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* FACILITY ICON BOX DUAL THEME */
        .facility-icon-box {
            background: linear-gradient(135deg, #004532 0%, #065f46 100%) !important;
            color: #fdba74 !important;
            border: 1px solid #059669 !important;
        }
        .facility-icon-box span,
        .facility-icon-box .material-symbols-outlined {
            color: #fdba74 !important;
        }

        html.dark .facility-icon-box {
            background: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
        }
        html.dark .facility-icon-box span,
        html.dark .facility-icon-box .material-symbols-outlined {
            color: #061107 !important;
            font-weight: 900 !important;
        }

        /* SPMB ONLINE CALLOUT BUTTON (ELECTRIC LIME BG + OBSIDIAN BLACK TEXT ALWAYS) */
        .spmb-btn-lime {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border: 1px solid #c6f634 !important;
            font-weight: 900 !important;
            box-shadow: 0 10px 25px -5px rgba(198, 246, 52, 0.4) !important;
        }
        .spmb-btn-lime *,
        .spmb-btn-lime span,
        .spmb-btn-lime .material-symbols-outlined {
            color: #061107 !important;
            font-weight: 900 !important;
        }
        .spmb-btn-lime:hover {
            background-color: #b5e828 !important;
            border-color: #b5e828 !important;
        }

        /* 10. SPMB Callout Card in Dark Mode */
        html.dark .spmb-callout-card {
            background: linear-gradient(135deg, #0e2010 0%, #153218 100%) !important;
            border: 1px solid #1a381c !important;
            color: #f7fee7 !important;
        }

        /* 11. Footer Section in Dark Mode (Obsidian Dark Theme - ZERO GREEN OVERLAY) */
        html.dark footer,
        html.dark footer.bg-gradient-to-b {
            background: linear-gradient(180deg, #061107 0%, #09180b 50%, #040a04 100%) !important;
            border-top: 1px solid #1a381c !important;
            color: #d9f99d !important;
        }

        html.dark footer h4 {
            color: #ffffff !important;
            border-color: #c6f634 !important;
        }

        html.dark footer a {
            background: transparent !important;
            color: #d9f99d !important;
            box-shadow: none !important;
            font-weight: 600 !important;
        }

        html.dark footer a:hover {
            color: #c6f634 !important;
        }

        /* 11. Text & Heading Contrast in Dark Mode */
        html.dark .text-slate-900,
        html.dark .text-slate-800,
        html.dark .text-slate-700 {
            color: #f7fee7 !important;
        }

        html.dark .text-slate-600,
        html.dark .text-slate-500,
        html.dark .text-slate-400 {
            color: #d9f99d !important;
        }

        /* 12. General Borders */
        html.dark .border-slate-200,
        html.dark .border-slate-200\/80,
        html.dark .border-slate-200\/60,
        html.dark .border-slate-300 {
            border-color: #1a381c !important;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-body transition-colors duration-300 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- TOP ANNOUNCEMENT STRIP (EMERALD & ORANGE GRADIENT - MOBILE OPTIMIZED) -->
    <div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] dark:from-[#061107] dark:via-[#0c220f] dark:to-[#112413] text-white py-1.5 px-4 text-[10px] sm:text-xs font-semibold text-center flex items-center justify-center gap-1 sm:gap-2 shadow-inner relative z-50 border-b border-white/10 dark:border-[#1a381c]">
        <span class="truncate max-w-[80vw] sm:max-w-none">🔥 Pendaftaran SPMB Online TA 2026/2027 SIT Robbani Telah Dibuka!</span>
        <a href="{{ route('school.ppdb') }}" class="underline font-extrabold text-amber-300 dark:text-[#c6f634] hover:text-amber-200 shrink-0">Daftar &rarr;</a>
    </div>

    <!-- TOP NAVIGATION BAR -->
    <nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 sticky top-0 left-0 w-full z-40 h-20 shadow-sm transition-all">
        <div class="max-w-container-max mx-auto px-gutter h-full flex justify-between items-center">
            
            <div class="flex items-center gap-md">
                <a href="{{ route('home') }}" class="flex items-center gap-3 logo-badge-container" title="SIT Robbani Ogan Ilir">
                    <img alt="SIT Robbani Logo" class="h-10 sm:h-12 w-auto object-contain dark:hidden" src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}">
                    <img alt="SIT Robbani Logo" class="h-10 sm:h-12 w-auto object-contain hidden dark:block" src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}">
                </a>
            </div>

            <div class="hidden md:flex space-x-md lg:space-x-lg items-center font-semibold text-xs lg:text-sm">
                @foreach($headerMenus as $menu)
                    @if(!isset($menu['is_active']) || $menu['is_active'])
                        <a class="text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors" href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                    @endif
                @endforeach
            </div>

            <div class="flex items-center gap-sm">
                <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="p-2 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 rounded-full transition-colors hidden lg:flex items-center justify-center" title="Hubungi Kami">
                    <span class="material-symbols-outlined">call</span>
                </a>
                
                <button @click="darkMode = !darkMode" class="p-2 text-slate-600 dark:text-slate-300 hover:bg-slate-100 rounded-full transition-colors hidden lg:flex items-center justify-center" title="Toggle Mode">
                    <span class="material-symbols-outlined" x-show="!darkMode">dark_mode</span>
                    <span class="material-symbols-outlined" x-show="darkMode" x-cloak>light_mode</span>
                </button>

                <a class="hidden lg:inline-flex px-4 py-2 border border-emerald-700 text-emerald-800 dark:text-emerald-300 font-bold text-xs rounded-full hover:bg-emerald-700 hover:text-white transition-all items-center gap-xs" href="{{ route('admin.dashboard') }}">
                    Admin
                </a>
                <a class="px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-xs rounded-full transition-all flex items-center gap-xs shadow-md transform hover:scale-105" href="{{ route('school.ppdb') }}">
                    SPMB <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 border border-slate-300">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </nav>
    <!-- Mobile Menu Drawer (CENTERED IN MOBILE/TABLET) -->
    <div x-show="mobileMenuOpen" x-cloak class="md:hidden fixed inset-x-0 top-20 z-40 bg-white dark:bg-[#061107] border-b border-slate-200 dark:border-[#1a381c] p-6 space-y-3 shadow-2xl font-bold text-center">
        @foreach($headerMenus as $menu)
            @if(!isset($menu['is_active']) || $menu['is_active'])
                <a @click="mobileMenuOpen = false" href="{{ $menu['url'] }}" class="block text-slate-800 dark:text-slate-100 hover:text-emerald-500 py-2 border-b border-slate-100 dark:border-white/10 text-center">{{ $menu['title'] }}</a>
            @endif
        @endforeach
        <a href="{{ route('admin.dashboard') }}" class="block text-center py-2.5 rounded-full border-2 border-emerald-600 text-emerald-700 dark:text-[#c6f634] font-black mt-2">Portal Admin</a>
    </div>

    <!-- MAIN CONTENT -->
    <main>

        <!-- ========================================== -->
        <!-- HERO SECTION (CENTER ALIGNED MOBILE/TABLET) -->
        <!-- ========================================== -->
        <section class="relative py-12 sm:py-20 lg:py-24 overflow-hidden border-b border-slate-200/80 dark:border-slate-800 bg-cover bg-center bg-no-repeat transition-all" style="background-image: url('{{ !empty($settings['hero_bg_image']) ? $settings['hero_bg_image'] : 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1600' }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950 via-slate-950 to-orange-950 backdrop-blur-[2px]" style="opacity: {{ ((float) (!empty($settings['hero_banner_opacity']) ? $settings['hero_banner_opacity'] : 70)) / 100 }};"></div>
            
            <div class="max-w-container-max mx-auto px-gutter relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg sm:gap-xl items-center">
                    
                    <!-- Left Hero Column: Center aligned on Mobile & Tablet -->
                    <div class="lg:col-span-7 hero-glass-container backdrop-blur-xl border shadow-2xl rounded-3xl p-6 sm:p-8 space-y-4 text-center lg:text-left flex flex-col items-center lg:items-start">
                        <div>
                            <span class="site-section-badge flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-800 dark:bg-[#061107] animate-ping"></span>
                                <span class="dark:text-[#061107] font-black">{{ $settings['hero_badge'] }}</span>
                            </span>
                        </div>
                        
                        <h1 class="text-2xl sm:text-4xl md:text-5xl font-black font-headline leading-tight text-slate-900 dark:text-white drop-shadow-sm">
                            {!! $settings['hero_title'] !!}
                        </h1>
                        
                        <p class="text-xs sm:text-base text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                            {{ $settings['hero_desc'] }}
                        </p>
                        
                        <div class="flex flex-wrap justify-center lg:justify-start gap-sm sm:gap-md pt-2">
                            <a class="px-5 sm:px-7 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-xs sm:text-sm rounded-full transition-all flex items-center gap-xs sm:gap-sm shadow-lg transform hover:scale-105" href="{{ route('school.ppdb') }}">
                                Formulir SPMB Online <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a class="px-5 sm:px-7 py-3 border-2 border-emerald-700 dark:border-emerald-500 text-emerald-800 dark:text-emerald-300 font-bold text-xs sm:text-sm rounded-full hover:bg-emerald-700 hover:text-white transition-all flex items-center gap-xs sm:gap-sm" href="{{ route('school.profil') }}">
                                Profil Yayasan <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>

                        <!-- Highlights Feature Badges -->
                        <div class="flex flex-wrap justify-center lg:justify-start gap-md text-xs font-semibold text-slate-700 dark:text-slate-300 pt-3 border-t border-slate-200/80 dark:border-slate-800">
                            <span class="flex items-center gap-1.5"><span class="text-emerald-600 dark:text-emerald-400 font-bold">✓</span> Tahfidz Al-Qur'an</span>
                            <span class="flex items-center gap-1.5"><span class="text-emerald-600 dark:text-emerald-400 font-bold">✓</span> Kurikulum Merdeka</span>
                            <span class="flex items-center gap-1.5"><span class="text-emerald-600 dark:text-emerald-400 font-bold">✓</span> Akreditasi Unggul</span>
                        </div>
                    </div>

                    <!-- Right Column: PRAYER TIMES REALTIME WIDGET (WITH LIVE CLOCK & LOCATION SELECTOR) -->
                    <div class="lg:col-span-5" x-data="{
                        selectedLoc: 'indralaya_utara',
                        liveTimeStr: '',
                        liveDateStr: '',
                        locations: {
                            'indralaya_utara': { name: 'Kec. Indralaya Utara (Pusat)', qibla: '295.2° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'indralaya': { name: 'Kec. Indralaya', qibla: '295.2° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'indralaya_selatan': { name: 'Kec. Indralaya Selatan', qibla: '295.2° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'pemulutan': { name: 'Kec. Pemulutan', qibla: '295.1° NW', subuh: '04:46', dzuhur: '12:07', ashar: '15:27', maghrib: '18:09', isya: '19:20', next: 'Subuh 04:46 WIB' },
                            'pemulutan_barat': { name: 'Kec. Pemulutan Barat', qibla: '295.1° NW', subuh: '04:46', dzuhur: '12:07', ashar: '15:27', maghrib: '18:09', isya: '19:20', next: 'Subuh 04:46 WIB' },
                            'pemulutan_selatan': { name: 'Kec. Pemulutan Selatan', qibla: '295.1° NW', subuh: '04:46', dzuhur: '12:07', ashar: '15:27', maghrib: '18:09', isya: '19:20', next: 'Subuh 04:46 WIB' },
                            'tanjung_batu': { name: 'Kec. Tanjung Batu', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'tanjung_raja': { name: 'Kec. Tanjung Raja', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'payaraman': { name: 'Kec. Payaraman', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'rantau_alai': { name: 'Kec. Rantau Alai', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'rantau_panjang': { name: 'Kec. Rantau Panjang', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'sungai_pinang': { name: 'Kec. Sungai Pinang', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'kandis': { name: 'Kec. Kandis', qibla: '295.3° NW', subuh: '04:47', dzuhur: '12:08', ashar: '15:28', maghrib: '18:10', isya: '19:21', next: 'Subuh 04:47 WIB' },
                            'lubuk_keliat': { name: 'Kec. Lubuk Keliat', qibla: '295.4° NW', subuh: '04:48', dzuhur: '12:09', ashar: '15:29', maghrib: '18:11', isya: '19:22', next: 'Subuh 04:48 WIB' },
                            'muara_kuang': { name: 'Kec. Muara Kuang', qibla: '295.4° NW', subuh: '04:48', dzuhur: '12:09', ashar: '15:29', maghrib: '18:11', isya: '19:22', next: 'Subuh 04:48 WIB' },
                            'rambang_kuang': { name: 'Kec. Rambang Kuang', qibla: '295.4° NW', subuh: '04:48', dzuhur: '12:09', ashar: '15:29', maghrib: '18:11', isya: '19:22', next: 'Subuh 04:48 WIB' },
                            'palembang': { name: 'Sumsel (Palembang)', qibla: '295.1° NW', subuh: '04:46', dzuhur: '12:07', ashar: '15:27', maghrib: '18:09', isya: '19:20', next: 'Subuh 04:46 WIB' },
                            'jakarta': { name: 'DKI Jakarta (Pusat)', qibla: '295.0° NW', subuh: '04:43', dzuhur: '12:01', ashar: '15:22', maghrib: '18:01', isya: '19:12', next: 'Subuh 04:43 WIB' },
                            'bandung': { name: 'Jawa Barat (Bandung)', qibla: '295.0° NW', subuh: '04:40', dzuhur: '11:58', ashar: '15:19', maghrib: '17:58', isya: '19:09', next: 'Subuh 04:40 WIB' },
                            'semarang': { name: 'Jawa Tengah (Semarang)', qibla: '294.7° NW', subuh: '04:26', dzuhur: '11:44', ashar: '15:05', maghrib: '17:44', isya: '18:55', next: 'Subuh 04:26 WIB' },
                            'yogyakarta': { name: 'DI Yogyakarta', qibla: '294.6° NW', subuh: '04:26', dzuhur: '11:44', ashar: '15:05', maghrib: '17:44', isya: '18:55', next: 'Subuh 04:26 WIB' },
                            'surabaya': { name: 'Jawa Timur (Surabaya)', qibla: '294.4° NW', subuh: '04:15', dzuhur: '11:33', ashar: '14:54', maghrib: '17:33', isya: '18:44', next: 'Subuh 04:15 WIB' },
                            'medan': { name: 'Sumut (Medan)', qibla: '292.5° NW', subuh: '05:04', dzuhur: '12:28', ashar: '15:49', maghrib: '18:32', isya: '19:43', next: 'Subuh 05:04 WIB' },
                            'padang': { name: 'Sumbar (Padang)', qibla: '294.1° NW', subuh: '04:58', dzuhur: '12:20', ashar: '15:41', maghrib: '18:23', isya: '19:34', next: 'Subuh 04:58 WIB' },
                            'pekanbaru': { name: 'Riau (Pekanbaru)', qibla: '293.4° NW', subuh: '04:53', dzuhur: '12:15', ashar: '15:36', maghrib: '18:18', isya: '19:29', next: 'Subuh 04:53 WIB' },
                            'lampung': { name: 'Lampung (Bandar Lampung)', qibla: '295.2° NW', subuh: '04:44', dzuhur: '12:04', ashar: '15:25', maghrib: '18:05', isya: '19:16', next: 'Subuh 04:44 WIB' },
                            'denpasar': { name: 'Bali (Denpasar)', qibla: '293.8° NW', subuh: '05:06', dzuhur: '12:24', ashar: '15:45', maghrib: '18:24', isya: '19:35', next: 'Subuh 05:06 WITA' },
                            'makassar': { name: 'Sulsel (Makassar)', qibla: '292.1° NW', subuh: '04:49', dzuhur: '12:10', ashar: '15:31', maghrib: '18:09', isya: '19:20', next: 'Subuh 04:49 WITA' },
                            'jayapura': { name: 'Papua (Jayapura)', qibla: '288.6° NW', subuh: '04:16', dzuhur: '11:37', ashar: '14:57', maghrib: '17:39', isya: '18:49', next: 'Subuh 04:16 WIT' }
                        },
                        init() {
                            this.updateClock();
                            setInterval(() => { this.updateClock(); }, 1000);
                        },
                        updateClock() {
                            let now = new Date();
                            let days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                            this.liveDateStr = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
                            let h = String(now.getHours()).padStart(2, '0');
                            let m = String(now.getMinutes()).padStart(2, '0');
                            let s = String(now.getSeconds()).padStart(2, '0');
                            this.liveTimeStr = h + ':' + m + ':' + s + ' WIB';
                        }
                    }">
                        <div class="prayer-widget-card bg-slate-900 dark:bg-[#0d1e0f] text-white border border-slate-800 dark:border-[#1a381c] rounded-3xl p-md sm:p-lg shadow-2xl relative overflow-hidden space-y-sm sm:space-y-md">
                            
                            <!-- Header with Location Dropdown & Qibla -->
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 border-b border-slate-800 dark:border-[#1a381c] pb-xs sm:pb-sm">
                                <div class="w-full sm:w-auto">
                                    <div class="text-[10px] font-bold text-emerald-400 dark:text-[#c6f634] uppercase flex items-center gap-xs mb-1">
                                        <span class="material-symbols-outlined text-[14px]">location_on</span>
                                        <!-- Location Select Dropdown -->
                                        <select x-model="selectedLoc" class="bg-slate-800 dark:bg-[#153018] text-white dark:text-[#f7fee7] border border-slate-700 dark:border-[#1f4523] rounded-lg px-2 py-0.5 text-[10px] font-bold focus:outline-none cursor-pointer max-w-[200px] sm:max-w-xs truncate">
                                            <optgroup label="Kabupaten Ogan Ilir (16 Kecamatan)">
                                                <option value="indralaya_utara">★ Kec. Indralaya Utara (Kantor Pusat Yayasan)</option>
                                                <option value="indralaya">Kec. Indralaya</option>
                                                <option value="indralaya_selatan">Kec. Indralaya Selatan</option>
                                                <option value="pemulutan">Kec. Pemulutan</option>
                                                <option value="pemulutan_barat">Kec. Pemulutan Barat</option>
                                                <option value="pemulutan_selatan">Kec. Pemulutan Selatan</option>
                                                <option value="tanjung_batu">Kec. Tanjung Batu</option>
                                                <option value="tanjung_raja">Kec. Tanjung Raja</option>
                                                <option value="payaraman">Kec. Payaraman</option>
                                                <option value="rantau_alai">Kec. Rantau Alai</option>
                                                <option value="rantau_panjang">Kec. Rantau Panjang</option>
                                                <option value="sungai_pinang">Kec. Sungai Pinang</option>
                                                <option value="kandis">Kec. Kandis</option>
                                                <option value="lubuk_keliat">Kec. Lubuk Keliat</option>
                                                <option value="muara_kuang">Kec. Muara Kuang</option>
                                                <option value="rambang_kuang">Kec. Rambang Kuang</option>
                                            </optgroup>
                                            <optgroup label="Seluruh Provinsi Indonesia">
                                                <option value="palembang">Sumatera Selatan (Palembang)</option>
                                                <option value="jakarta">DKI Jakarta (Pusat)</option>
                                                <option value="bandung">Jawa Barat (Bandung)</option>
                                                <option value="semarang">Jawa Tengah (Semarang)</option>
                                                <option value="yogyakarta">DI Yogyakarta</option>
                                                <option value="surabaya">Jawa Timur (Surabaya)</option>
                                                <option value="medan">Sumatera Utara (Medan)</option>
                                                <option value="padang">Sumatera Barat (Padang)</option>
                                                <option value="pekanbaru">Riau (Pekanbaru)</option>
                                                <option value="lampung">Lampung (Bandar Lampung)</option>
                                                <option value="denpasar">Bali (Denpasar)</option>
                                                <option value="makassar">Sulawesi Selatan (Makassar)</option>
                                                <option value="jayapura">Papua (Jayapura)</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="text-xs sm:text-sm font-bold text-white font-headline">Jadwal Sholat Realtime</div>
                                </div>
                                <div class="bg-orange-500 dark:bg-[#c6f634] text-white dark:text-[#061107] px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-black flex items-center gap-xs shadow-sm border border-transparent dark:border-[#c6f634] shrink-0">
                                    <span class="material-symbols-outlined text-[12px]">explore</span> <span class="dark:text-[#061107] font-black" x-text="locations[selectedLoc].qibla"></span>
                                </div>
                            </div>

                            <!-- Live Clock & Date Display -->
                            <div class="bg-white/5 dark:bg-[#153018]/50 p-2.5 rounded-2xl border border-white/10 dark:border-[#1f4523] flex justify-between items-center text-xs">
                                <div>
                                    <span class="text-[9px] font-bold text-emerald-400 dark:text-[#c6f634] uppercase block">Waktu Sekarang</span>
                                    <span class="font-black text-amber-300 dark:text-[#c6f634] text-sm tracking-wider font-mono" x-text="liveTimeStr"></span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[9px] font-semibold text-slate-300 block" x-text="liveDateStr"></span>
                                    <span class="text-[9px] font-bold bg-emerald-700/60 dark:bg-[#c6f634] text-white dark:text-[#061107] px-2 py-0.5 rounded-full inline-block mt-0.5">29 Safar 1448 H</span>
                                </div>
                            </div>

                            <!-- Sholat Berikutnya Display -->
                            <div>
                                <div class="text-[9px] sm:text-[10px] font-bold text-emerald-300 dark:text-[#c6f634] uppercase mb-xs">Sholat Berikutnya</div>
                                <div class="text-lg sm:text-2xl font-black text-amber-300 dark:text-[#c6f634] font-headline" x-text="locations[selectedLoc].next"></div>
                            </div>

                            <!-- 5 Prayer Times Grid -->
                            <div class="grid grid-cols-5 gap-xs pt-1">
                                <div class="bg-slate-800/80 dark:bg-[#153018] border border-slate-700 dark:border-[#1f4523] p-xs rounded-xl text-center">
                                    <div class="text-[8px] sm:text-[9px] font-bold text-slate-400 dark:text-slate-300 uppercase">Subuh</div>
                                    <div class="text-[11px] sm:text-xs font-black text-white dark:text-[#f7fee7]" x-text="locations[selectedLoc].subuh"></div>
                                </div>
                                <div class="bg-slate-800/80 dark:bg-[#153018] border border-slate-700 dark:border-[#1f4523] p-xs rounded-xl text-center">
                                    <div class="text-[8px] sm:text-[9px] font-bold text-slate-400 dark:text-slate-300 uppercase">Dzuhur</div>
                                    <div class="text-[11px] sm:text-xs font-black text-white dark:text-[#f7fee7]" x-text="locations[selectedLoc].dzuhur"></div>
                                </div>
                                <div class="bg-slate-800/80 dark:bg-[#153018] border border-slate-700 dark:border-[#1f4523] p-xs rounded-xl text-center">
                                    <div class="text-[8px] sm:text-[9px] font-bold text-slate-400 dark:text-slate-300 uppercase">Ashar</div>
                                    <div class="text-[11px] sm:text-xs font-black text-white dark:text-[#f7fee7]" x-text="locations[selectedLoc].ashar"></div>
                                </div>
                                <div class="bg-orange-600 dark:bg-[#c6f634] p-xs rounded-xl text-center shadow-md border border-orange-500 dark:border-[#c6f634]">
                                    <div class="text-[8px] sm:text-[9px] font-black text-white/90 dark:text-[#061107] uppercase">Maghrib</div>
                                    <div class="text-[11px] sm:text-xs font-black text-white dark:text-[#061107]" x-text="locations[selectedLoc].maghrib"></div>
                                </div>
                                <div class="bg-slate-800/80 dark:bg-[#153018] border border-slate-700 dark:border-[#1f4523] p-xs rounded-xl text-center">
                                    <div class="text-[8px] sm:text-[9px] font-bold text-slate-400 dark:text-slate-300 uppercase">Isya</div>
                                    <div class="text-[11px] sm:text-xs font-black text-white dark:text-[#f7fee7]" x-text="locations[selectedLoc].isya"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- QUICK MENU (4 PER ROW ON MOBILE)           -->
        <!-- ========================================== -->
        <section class="py-10 sm:py-14 bg-white border-b border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter space-y-sm sm:space-y-md">
                
                <div class="text-center space-y-1">
                    <span class="site-section-badge">AKSES CEPAT</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900">Menu Utama</h2>
                </div>

                <div class="grid grid-cols-4 lg:grid-cols-8 gap-xs sm:gap-sm md:gap-md pt-2">
                    
                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="{{ route('school.profil') }}">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-emerald-100 dark:bg-[#c6f634] text-emerald-800 dark:text-[#061107] flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">person</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">Profil</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="#unit-sekolah">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-orange-100 dark:bg-[#c6f634] text-orange-700 dark:text-[#061107] flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">domain</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">4 Unit</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="{{ route('school.berita') }}">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-emerald-100 dark:bg-[#c6f634] text-emerald-800 dark:text-[#061107] flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">newspaper</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">Berita</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="{{ route('school.artikel') }}">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-orange-100 dark:bg-[#c6f634] text-orange-700 dark:text-[#061107] flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">article</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">Artikel</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="#sarana-prasarana">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-emerald-100 dark:bg-[#c6f634] text-emerald-800 dark:text-[#061107] flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">home_work</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">Fasilitas</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="{{ route('school.espp') }}">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-orange-100 dark:bg-[#c6f634] text-orange-700 dark:text-[#061107] flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">payments</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">E-SPP</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="{{ route('school.ppdb') }}">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-emerald-100 dark:bg-[#c6f634] text-emerald-800 dark:text-[#061107] flex items-center justify-center group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">how_to_reg</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">PPDB</span>
                    </a>

                    <a class="quick-menu-card bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-2xl p-2 sm:p-3 flex flex-col items-center justify-center gap-1 sm:gap-2 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 group" href="#galeri-sekolah">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-orange-100 dark:bg-[#c6f634] text-orange-700 dark:text-[#061107] flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[24px] sm:text-[28px] dark:text-[#061107]" data-weight="fill">photo_library</span>
                        </div>
                        <span class="quick-menu-label text-[10px] sm:text-xs font-bold text-slate-700 dark:text-[#f7fee7] group-hover:text-emerald-700 text-center leading-tight truncate w-full">Galeri</span>
                    </a>

                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- SAMBUTAN KETUA YAYASAN                     -->
        <!-- ========================================== -->
        <section class="py-12 sm:py-16 bg-slate-50">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="bg-white border border-slate-200/80 rounded-3xl p-md sm:p-xl shadow-md flex flex-col md:flex-row gap-lg md:gap-xl items-center relative overflow-hidden">
                    
                    <!-- Foto & Name: Top on Mobile, Left Column on Desktop -->
                    <div class="flex-shrink-0 flex flex-col items-center md:items-start text-center md:text-left z-10 w-full md:w-1/3">
                        <div class="w-28 h-28 sm:w-40 sm:h-40 mx-auto md:mx-0 rounded-full border-4 border-emerald-600 p-1 mb-sm sm:mb-md shadow-lg">
                            <img class="w-full h-full object-cover rounded-full bg-white" src="{{ $settings['principal_photo'] ?? '/images/logo-robbani-official.png' }}" alt="Ketua Yayasan Generasi Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                        </div>
                        <span class="site-section-badge mb-xs">Ketua Yayasan</span>
                        <h3 class="text-base sm:text-lg font-bold font-headline text-slate-900 mb-xs">{{ $settings['principal_name'] }}</h3>
                        <p class="text-[11px] sm:text-xs font-semibold text-emerald-700 max-w-[220px]">{{ $settings['principal_title'] }}</p>
                    </div>

                    <!-- Sambutan Quote & Buttons: Bottom on Mobile, Right Column on Desktop -->
                    <div class="flex-grow z-10 w-full md:w-2/3 border-t md:border-t-0 md:border-l border-slate-200 pt-md md:pt-0 md:pl-lg text-center md:text-left flex flex-col items-center md:items-start">
                        <span class="material-symbols-outlined text-[36px] sm:text-[48px] text-emerald-600/30 mb-xs sm:mb-sm block md:inline-block">format_quote</span>
                        <p class="text-xs sm:text-base md:text-lg font-semibold italic text-slate-800 mb-md sm:mb-lg leading-relaxed">
                            "{{ $settings['principal_greeting'] }}"
                        </p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-sm sm:gap-md">
                            <a class="px-5 py-2.5 bg-emerald-700 text-white font-bold text-xs rounded-full hover:bg-emerald-800 transition-colors flex items-center gap-xs shadow-sm" href="{{ route('school.profil') }}">
                                Sambutan Lengkap <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                            <a class="px-5 py-2.5 bg-orange-600 text-white font-bold text-xs rounded-full hover:bg-orange-700 transition-opacity flex items-center gap-xs shadow-sm" href="{{ route('school.profil') }}#visi-misi">
                                Visi &amp; Misi <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- UNIT PENDIDIKAN (2 DITAS, 2 DIBAWAH DI MOBILE) -->
        <!-- ========================================== -->
        <section id="unit-sekolah" class="py-12 sm:py-16 bg-white border-y border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter space-y-md sm:space-y-lg">
                
                <div class="text-center space-y-1">
                    <span class="site-section-badge">JENJANG PENDIDIKAN</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900">Unit Pendidikan SIT Robbani</h2>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto">Pendidikan berjenjang terpadu dari tingkat usia dini hingga tingkat menengah atas.</p>
                </div>

                <!-- 2 Units Top, 2 Units Bottom on Mobile (2x2 Grid) -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-sm sm:gap-md pt-2">
                    
                    <div class="bg-slate-50/80 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-3 sm:p-5 text-center shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 rounded-2xl flex items-center justify-center mb-sm sm:mb-md group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[28px] sm:text-[40px]">child_care</span>
                            </div>
                            <h3 class="text-sm sm:text-lg font-bold font-headline text-slate-900 dark:text-white mb-xs">KB/TKIT Robbani</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mb-sm sm:mb-md leading-relaxed line-clamp-2">Kelompok Bermain &amp; TK Islam Terpadu berakreditasi unggul.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-sm py-xs sm:px-md sm:py-sm border border-emerald-700 dark:border-emerald-500 text-emerald-800 dark:text-emerald-300 font-bold rounded-full hover:bg-emerald-700 hover:text-white transition-colors text-[11px] sm:text-xs w-full" href="{{ route('school.unit', 'tkit') }}">Detail Unit ➔</a>
                    </div>

                    <div class="bg-slate-50/80 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-3 sm:p-5 text-center shadow-sm hover:shadow-xl hover:border-orange-500 transition-all duration-300 transform hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto bg-orange-100 dark:bg-orange-950 text-orange-700 dark:text-orange-300 rounded-2xl flex items-center justify-center mb-sm sm:mb-md group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[28px] sm:text-[40px]">school</span>
                            </div>
                            <h3 class="text-sm sm:text-lg font-bold font-headline text-slate-900 dark:text-white mb-xs">SDIT Robbani</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mb-sm sm:mb-md leading-relaxed line-clamp-2">Sekolah Dasar Islam Terpadu berakreditasi A &amp; Tahfidz.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-sm py-xs sm:px-md sm:py-sm border border-orange-600 dark:border-orange-500 text-orange-700 dark:text-orange-300 font-bold rounded-full hover:bg-orange-600 hover:text-white transition-colors text-[11px] sm:text-xs w-full" href="{{ route('school.unit', 'sdit') }}">Detail Unit ➔</a>
                    </div>

                    <div class="bg-slate-50/80 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-3 sm:p-5 text-center shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 rounded-2xl flex items-center justify-center mb-sm sm:mb-md group-hover:bg-emerald-700 group-hover:text-white transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[28px] sm:text-[40px]">menu_book</span>
                            </div>
                            <h3 class="text-sm sm:text-lg font-bold font-headline text-slate-900 dark:text-white mb-xs">SMPIT Robbani</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mb-sm sm:mb-md leading-relaxed line-clamp-2">Sekolah Menengah Pertama berasrama (boarding) / fullday.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-sm py-xs sm:px-md sm:py-sm border border-emerald-700 dark:border-emerald-500 text-emerald-800 dark:text-emerald-300 font-bold rounded-full hover:bg-emerald-700 hover:text-white transition-colors text-[11px] sm:text-xs w-full" href="{{ route('school.unit', 'smpit') }}">Detail Unit ➔</a>
                    </div>

                    <div class="bg-slate-50/80 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-3 sm:p-5 text-center shadow-sm hover:shadow-xl hover:border-orange-500 transition-all duration-300 transform hover:-translate-y-1.5 group flex flex-col justify-between">
                        <div>
                            <div class="w-14 h-14 sm:w-20 sm:h-20 mx-auto bg-orange-100 dark:bg-orange-950 text-orange-700 dark:text-orange-300 rounded-2xl flex items-center justify-center mb-sm sm:mb-md group-hover:bg-orange-600 group-hover:text-white transition-colors shadow-sm">
                                <span class="material-symbols-outlined text-[28px] sm:text-[40px]">account_balance</span>
                            </div>
                            <h3 class="text-sm sm:text-lg font-bold font-headline text-slate-900 dark:text-white mb-xs">SMAIT Robbani</h3>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 mb-sm sm:mb-md leading-relaxed line-clamp-2">Sekolah Menengah Atas dengan program unggulan sains &amp; IT.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-sm py-xs sm:px-md sm:py-sm border border-orange-600 dark:border-orange-500 text-orange-700 dark:text-orange-300 font-bold rounded-full hover:bg-orange-600 hover:text-white transition-colors text-[11px] sm:text-xs w-full" href="{{ route('school.unit', 'smait') }}">Detail Unit ➔</a>
                    </div>

                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- BERITA & ARTIKEL                           -->
        <!-- ========================================== -->
        <section id="artikel-berita" class="py-12 sm:py-16 bg-slate-50">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex flex-col lg:flex-row justify-between items-center lg:items-end text-center lg:text-left gap-sm border-b border-slate-200 pb-xs">
                    <div class="flex flex-col items-center lg:items-start text-center lg:text-left">
                        <span class="site-section-badge mb-xs">KABAR KAMPUS</span>
                        <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900">Berita &amp; Artikel</h2>
                    </div>
                    <a class="text-emerald-700 font-bold text-xs hover:underline flex items-center justify-center lg:justify-start gap-xs" href="{{ route('school.berita') }}">
                        Lihat Semua <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg items-stretch">
                    
                    @if(count($newsList) > 0)
                    @php $topNews = $newsList[0]; @endphp
                    <!-- Left Headline Card -->
                    <div class="lg:col-span-6 flex flex-col">
                        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm group cursor-pointer hover:shadow-xl hover:border-emerald-500 transition-all duration-300 h-full flex flex-col justify-between">
                            <div>
                                <div class="relative h-60 sm:h-80 overflow-hidden bg-slate-900">
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $topNews['image'] }}" alt="{{ $topNews['title'] }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-6 bg-white';">
                                    <span class="absolute top-md left-md bg-emerald-700 text-white px-md py-xs rounded-full text-xs font-bold shadow-md">HEADLINE NEWS</span>
                                </div>
                                <div class="p-md sm:p-lg space-y-sm">
                                    <div class="flex items-center gap-sm text-xs text-slate-500 font-medium">
                                        <span class="material-symbols-outlined text-[16px]">calendar_today</span> {{ $topNews['date'] }}
                                        <span class="mx-1">•</span>
                                        <span class="text-emerald-700 font-bold">{{ $topNews['category'] ?? 'Berita' }}</span>
                                    </div>
                                    <h3 class="text-base sm:text-xl font-bold font-headline text-slate-900 group-hover:text-emerald-700 transition-colors leading-snug">
                                        {{ $topNews['title'] }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3 sm:line-clamp-4">
                                        {{ $topNews['excerpt'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-md sm:p-lg pt-0">
                                <a href="{{ route('school.berita.show', $topNews['slug'] ?? \Illuminate\Support\Str::slug($topNews['title'])) }}" class="text-emerald-700 font-bold text-xs flex items-center gap-xs group-hover:underline">
                                    Baca Selengkapnya <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Right Column: 5 List Berita Items -->
                    <div class="lg:col-span-6 flex flex-col justify-between space-y-sm">
                        @foreach(array_slice($newsList, 1, 5) as $sideNews)
                        <div class="flex items-center gap-sm sm:gap-md p-sm bg-white rounded-2xl border border-slate-200/80 hover:border-emerald-500 hover:shadow-md transition-all cursor-pointer group flex-1">
                            <img class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl flex-shrink-0 group-hover:scale-105 transition-transform bg-slate-900" src="{{ $sideNews['image'] }}" alt="{{ $sideNews['title'] }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-16 h-16 sm:w-20 sm:h-20 object-contain p-2 bg-white rounded-xl';">
                            <div class="flex-grow space-y-xs min-w-0">
                                <div class="text-[10px] text-slate-500 flex items-center justify-between font-semibold">
                                    <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[12px]">calendar_today</span> {{ $sideNews['date'] }}</span>
                                    <span class="news-cat-badge">{{ $sideNews['category'] ?? 'Berita' }}</span>
                                </div>
                                <h4 class="text-xs font-bold text-slate-900 line-clamp-2 group-hover:text-emerald-700 transition-colors leading-snug">
                                    {{ $sideNews['title'] }}
                                </h4>
                                <a href="{{ route('school.berita.show', $sideNews['slug'] ?? \Illuminate\Support\Str::slug($sideNews['title'])) }}" class="text-[11px] font-bold text-emerald-700 hover:underline inline-flex items-center gap-1">
                                    <span>Baca Berita</span> <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

                <!-- Sub-Section: Berita & Kabar Per Unit Sekolah (TKIT, SDIT, SMPIT, SMAIT) -->
                <div x-data="{ activeUnitTab: 'all' }" class="pt-8 sm:pt-10 border-t border-slate-200/80 space-y-5">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-3 text-center md:text-left">
                        <div>
                            <span class="site-section-badge mb-1 inline-block">KABAR KHUSUS UNIT</span>
                            <h3 class="text-lg sm:text-xl font-extrabold font-headline text-slate-900">Berita &amp; Kegiatan Per Unit Sekolah</h3>
                            <p class="text-xs text-slate-500 font-medium hidden sm:block">Pilih tab unit di bawah untuk menyaring berita khusus jenjang tertentu.</p>
                        </div>

                        <!-- Swipeable Horizontal Tab Pills on Mobile -->
                        <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-1.5 scrollbar-none w-full md:w-auto shrink-0 justify-start sm:justify-center">
                            <button @click="activeUnitTab = 'all'" :class="activeUnitTab === 'all' ? 'bg-emerald-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-2xl font-extrabold text-[11px] sm:text-xs shrink-0 transition-all flex items-center gap-1">
                                🌐 Semua Unit
                            </button>
                            <button @click="activeUnitTab = 'tkit'" :class="activeUnitTab === 'tkit' ? 'bg-emerald-700 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-2xl font-extrabold text-[11px] sm:text-xs shrink-0 transition-all flex items-center gap-1">
                                🧸 KB/TKIT
                            </button>
                            <button @click="activeUnitTab = 'sdit'" :class="activeUnitTab === 'sdit' ? 'bg-orange-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-2xl font-extrabold text-[11px] sm:text-xs shrink-0 transition-all flex items-center gap-1">
                                🏫 SDIT
                            </button>
                            <button @click="activeUnitTab = 'smpit'" :class="activeUnitTab === 'smpit' ? 'bg-blue-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-2xl font-extrabold text-[11px] sm:text-xs shrink-0 transition-all flex items-center gap-1">
                                📚 SMPIT
                            </button>
                            <button @click="activeUnitTab = 'smait'" :class="activeUnitTab === 'smait' ? 'bg-purple-600 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-2xl font-extrabold text-[11px] sm:text-xs shrink-0 transition-all flex items-center gap-1">
                                🎓 SMAIT
                            </button>
                        </div>
                    </div>

                    <!-- 8 News Cards Grid: 4 Top, 4 Bottom (4 Column Layout on Desktop) -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        
                        <!-- CARD 1: KB/TKIT #1 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'tkit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-emerald-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_mobile_1.png" alt="Berita KB/TKIT Robbani" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-emerald-700 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">KB/TKIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 12 Agustus 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                                        Puncak Tema &amp; Pentas Seni Cilik Santri KB/TKIT Robbani Ogan Ilir
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Kecerian dan kebersamaan santri cilik TKIT Robbani saat mengekspresikan bakat hafalan surah &amp; kreasi mewarnai.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'tkit') }}" class="text-[11px] font-bold text-emerald-700 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar KB/TKIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 2: SDIT #1 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'sdit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-orange-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_mobile_2.png" alt="Berita SDIT Robbani" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-orange-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SDIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 08 Agustus 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                        Pramuka SIT &amp; Supercamp Karakter Siswa SDIT Robbani 2026
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Pelatihan kemandirian, ketangkasan, dan mabit malam bina iman takwa santri penggalang SDIT.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'sdit') }}" class="text-[11px] font-bold text-orange-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SDIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 3: SMPIT #1 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'smpit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-blue-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/hero_3d_illustration_1786347707126.png" alt="Berita SMPIT Robbani" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SMPIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 31 Juli 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                        Kepala SMPIT Robbani Raih Peserta Terbaik III Diklat Kepsek Sumsel
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Prestasi kepemimpinan Ibu Tia Wulandari, S.Pd. dalam diklat manajemen sekolah tingkat provinsi.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'smpit') }}" class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SMPIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 4: SMAIT #1 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'smait'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-purple-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_mobile_4.png" alt="Berita SMAIT Robbani" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-purple-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SMAIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 20 Juli 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-purple-600 transition-colors line-clamp-2 leading-snug">
                                        Santri SMAIT Robbani Lolos Seleksi PTN Favorit &amp; Beasiswa Luar Negeri
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Capaian alumni SMAIT Robbani tembus jalur SNBP, SNBT, dan universitas timur tengah.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'smait') }}" class="text-[11px] font-bold text-purple-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SMAIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 5: KB/TKIT #2 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'tkit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-emerald-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_desktop_1.png" alt="Berita KB/TKIT Robbani 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-emerald-700 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">KB/TKIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 05 Juli 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition-colors line-clamp-2 leading-snug">
                                        Kegiatan Fun Cooking &amp; Edukasi Gizi Santri Usia Dini TKIT Robbani
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Mengenalkan makanan sehat halal dan thoyyib sejak dini melalui praktik memasak menyenangkan.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'tkit') }}" class="text-[11px] font-bold text-emerald-700 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar KB/TKIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 6: SDIT #2 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'sdit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-orange-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_desktop_2.png" alt="Berita SDIT Robbani 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-orange-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SDIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 18 Juni 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                        Munaqosyah Tahfidz Juz 29 &amp; 30 Terbuka SDIT Robbani Ogan Ilir
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Ujian hafalan Al-Qur'an terbuka siswa SDIT di hadapan para penguji dan orang tua santri.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'sdit') }}" class="text-[11px] font-bold text-orange-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SDIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 7: SMPIT #2 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'smpit'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-blue-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_desktop_3.png" alt="Berita SMPIT Robbani 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-blue-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SMPIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 10 Juni 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                                        Olimpiade Sains &amp; Kebumian: Tim Santri SMPIT Robbani Sabet Emas
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Perjuangan tim olimpiade sains SMPIT dalam kompetisi akademik tingkat regional.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'smpit') }}" class="text-[11px] font-bold text-blue-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SMPIT</span> ➔
                            </a>
                        </div>

                        <!-- CARD 8: SMAIT #2 -->
                        <div x-show="activeUnitTab === 'all' || activeUnitTab === 'smait'" x-transition class="bg-white border border-slate-200/80 rounded-2xl p-3 sm:p-4 shadow-xs hover:shadow-md hover:border-purple-500 transition-all flex flex-col justify-between group space-y-2">
                            <div class="space-y-2">
                                <div class="relative h-28 sm:h-36 overflow-hidden rounded-xl bg-slate-900">
                                    <img src="/images/mockup_desktop_4.png" alt="Berita SMAIT Robbani 2" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                                    <span class="absolute top-2 left-2 bg-purple-600 text-white px-2 py-0.5 rounded-md text-[9px] sm:text-[10px] font-black uppercase shadow-xs">SMAIT</span>
                                </div>
                                <div class="space-y-1">
                                    <span class="text-[10px] text-slate-400 font-bold block">🗓️ 28 Mei 2026</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-purple-600 transition-colors line-clamp-2 leading-snug">
                                        Workshop IoT &amp; Coding Mobile App Santri SMAIT Robbani
                                    </h4>
                                    <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed font-medium hidden sm:block">
                                        Pelatihan pemrograman aplikasi android dan teknologi internet of things berbasis dakwah digital.
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('school.unit', 'smait') }}" class="text-[11px] font-bold text-purple-600 hover:underline flex items-center gap-1 pt-1">
                                <span>Kabar SMAIT</span> ➔
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- VIDEO DOKUMENTASI                          -->
        <!-- ========================================== -->
        <section id="video-profil" class="py-12 sm:py-16 bg-white border-t border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex flex-col lg:flex-row justify-between items-center lg:items-end text-center lg:text-left gap-sm border-b border-slate-200 pb-xs">
                    <div class="flex flex-col items-center lg:items-start text-center lg:text-left">
                        <span class="site-section-badge mb-xs">GALERI VIDEO</span>
                        <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900">Video Dokumentasi</h2>
                    </div>
                    <a class="text-emerald-700 font-bold text-xs hover:underline flex items-center justify-center lg:justify-start gap-xs" href="https://youtube.com" target="_blank">
                        SIT Robbani Channel <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
                    @foreach(array_slice($videoList, 0, 6) as $vid)
                    <div @click="activeVideoUrl = 'https://www.youtube.com/embed/{{ $vid['youtube_id'] }}?autoplay=1'; activeVideoTitle = '{{ addslashes($vid['title']) }}'" class="bg-slate-50/80 border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm flex flex-col group cursor-pointer hover:shadow-xl transition-all duration-300 hover:border-emerald-500">
                        <div class="relative h-44 sm:h-48 overflow-hidden flex items-center justify-center bg-slate-950">
                            <img alt="{{ $vid['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-80" src="{{ $vid['thumbnail'] }}">
                            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors"></div>
                            <div class="relative z-10 w-12 h-12 sm:w-14 sm:h-14 bg-orange-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[28px] sm:text-[32px]" data-weight="fill">play_arrow</span>
                            </div>
                            <span class="absolute top-sm left-sm bg-emerald-700 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10 uppercase shadow-sm">{{ $vid['category'] }}</span>
                            <span class="absolute bottom-sm right-sm bg-black/70 text-white text-[10px] font-bold px-2 py-1 rounded-lg z-10">{{ $vid['duration'] }}</span>
                        </div>
                        <div class="p-md flex-grow flex flex-col space-y-xs justify-between">
                            <div>
                                <h3 class="text-sm font-bold font-headline text-slate-900 line-clamp-2 leading-snug group-hover:text-emerald-700 transition-colors">{{ $vid['title'] }}</h3>
                                <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mt-1">{{ $vid['desc'] }}</p>
                            </div>
                            <div class="pt-2 flex items-center gap-1 text-xs font-bold text-orange-600">
                                <span>▶️ Tonton Video</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- PENGUMUMAN (3 ITEM) & AGENDA (5 ITEM)     -->
        <!-- ========================================== -->
        <section id="agenda-pengumuman" class="py-12 sm:py-16 bg-slate-50 border-t border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl items-start">
                    
                    <!-- Pengumuman (Exactly 3 Items) -->
                    <div class="space-y-md">
                        <div class="flex justify-between items-end border-b border-slate-200 pb-xs">
                            <div>
                                <span class="site-section-badge mb-xs">ANNOUNCEMENT</span>
                                <h2 class="text-xl md:text-2xl font-extrabold font-headline text-slate-900">Pengumuman</h2>
                            </div>
                            <a class="text-emerald-700 font-bold text-xs hover:underline flex items-center gap-xs" href="{{ route('school.berita') }}">
                                Lihat Semua <span class="material-symbols-outlined text-[16px]" data-weight="fill">arrow_forward</span>
                            </a>
                        </div>

                        <div class="space-y-sm">
                            @foreach(array_slice($announcementList, 0, 3) as $ann)
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-md shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-xs">
                                <div class="flex justify-between items-center">
                                    <span class="announcement-cat-badge bg-orange-100 dark:bg-[#c6f634] text-orange-700 dark:text-[#061107] border border-orange-200 dark:border-[#c6f634] text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full">{{ $ann['category'] }}</span>
                                    <span class="text-[10px] text-slate-500 flex items-center gap-xs font-semibold"><span class="material-symbols-outlined text-[12px]">calendar_today</span> {{ $ann['date'] }}</span>
                                </div>
                                <h3 class="text-xs md:text-sm font-bold text-slate-900 leading-snug">{{ $ann['title'] }}</h3>
                                <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">{{ $ann['summary'] }}</p>
                                <a class="text-emerald-700 text-[11px] font-bold hover:underline inline-flex items-center gap-xs pt-1" href="{{ $ann['link'] }}">
                                    <span>Detail Pengumuman</span> <span class="material-symbols-outlined text-[14px]" data-weight="fill">arrow_forward</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Agenda (Exactly 5 Items Symmetrical in Total Height) -->
                    <div class="space-y-md">
                        <div class="flex justify-between items-end border-b border-slate-200 pb-xs">
                            <div>
                                <span class="site-section-badge mb-xs">JADWAL &amp; EVENT</span>
                                <h2 class="text-xl md:text-2xl font-extrabold font-headline text-slate-900">Agenda</h2>
                            </div>
                            <span class="text-emerald-700 font-bold text-xs">TA 2026/2027</span>
                        </div>

                        <div class="space-y-sm">
                            @foreach(array_slice($agendaList, 0, 5) as $agenda)
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-sm sm:p-md shadow-sm flex gap-sm sm:gap-md items-center hover:shadow-md hover:border-emerald-500 transition-all">
                                <div class="flex flex-col items-center justify-center bg-emerald-700 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex-shrink-0 font-bold shadow-sm">
                                    <span class="text-sm sm:text-base leading-none">{{ $agenda['date_day'] }}</span>
                                    <span class="text-[8px] sm:text-[9px] uppercase tracking-wider leading-none mt-0.5 sm:mt-1">{{ $agenda['date_month'] }}</span>
                                </div>
                                <div class="flex-grow space-y-xs min-w-0">
                                    <h3 class="text-xs md:text-sm font-bold text-slate-900 leading-snug truncate">{{ $agenda['title'] }}</h3>
                                    <div class="flex flex-wrap gap-xs sm:gap-md text-[10px] sm:text-[11px] text-slate-500 font-medium">
                                        <span class="flex items-center gap-xs"><span class="material-symbols-outlined text-[12px]">schedule</span> {{ $agenda['time'] }}</span>
                                        <span class="flex items-center gap-xs truncate"><span class="material-symbols-outlined text-[12px]">location_on</span> {{ $agenda['location'] }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SARANA & PRASARANA                         -->
        <!-- ========================================== -->
        <section id="sarana-prasarana" class="py-12 sm:py-16 bg-white border-t border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="text-center space-y-1">
                    <span class="site-section-badge">FASILITAS KAMPUS</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900">Sarana &amp; Prasarana</h2>
                    <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto">Fasilitas pendukung pembelajaran yang aman, nyaman, modern, dan islami.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-md pt-2">
                    @foreach($facilityList as $fac)
                    <div class="bg-slate-50/80 dark:bg-[#0d1e0f] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-md sm:p-lg shadow-sm space-y-sm group hover:border-emerald-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center gap-md">
                            <div class="facility-icon-box w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-md font-bold">
                                <span class="material-symbols-outlined text-[28px] sm:text-[32px]">
                                    @if(str_contains(strtolower($fac['title']), 'ac') || str_contains(strtolower($fac['title']), 'kelas'))
                                        ac_unit
                                    @elseif(str_contains(strtolower($fac['title']), 'masjid') || str_contains(strtolower($fac['title']), 'ibadah'))
                                        mosque
                                    @elseif(str_contains(strtolower($fac['title']), 'perpustakaan') || str_contains(strtolower($fac['title']), 'buku'))
                                        menu_book
                                    @elseif(str_contains(strtolower($fac['title']), 'komputer') || str_contains(strtolower($fac['title']), 'lab'))
                                        computer
                                    @elseif(str_contains(strtolower($fac['title']), 'olahraga') || str_contains(strtolower($fac['title']), 'lapangan') || str_contains(strtolower($fac['title']), 'playground'))
                                        sports_soccer
                                    @else
                                        security
                                    @endif
                                </span>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white font-headline">{{ $fac['title'] }}</h4>
                                <span class="text-[9px] sm:text-[10px] font-bold text-emerald-700 dark:text-[#c6f634] uppercase">Fasilitas Unggulan</span>
                            </div>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">{{ $fac['desc'] }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- SPMB ONLINE REGISTRATION CALLOUT CARD      -->
        <!-- ========================================== -->
        <section class="py-10 bg-slate-50">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="rounded-3xl spmb-callout-card bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] p-6 md:p-10 text-white shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left">
                        <span class="site-section-badge">PENDAFTARAN SPMB</span>
                        <h3 class="text-xl sm:text-3xl font-black font-headline">Siap Menjadi Bagian dari SIT Robbani?</h3>
                        <p class="text-xs sm:text-sm text-white/90 max-w-xl">Daftarkan putra-putri Anda secara online dengan proses yang mudah, cepat, dan terintegrasi.</p>
                    </div>
                    <div class="shrink-0 flex flex-wrap gap-3 justify-center">
                        <a href="{{ route('school.ppdb') }}" class="spmb-btn-lime px-6 py-3 font-black text-xs sm:text-sm rounded-full transition-all transform hover:scale-105 flex items-center gap-2">
                            <span>Daftar SPMB Online Now</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- GALERI FOTO: CAROUSEL 6 FOTO SEKALIGUS    -->
        <!-- ========================================== -->
        <section id="galeri-sekolah" class="py-12 sm:py-16 bg-white border-t border-slate-200/60 overflow-hidden" 
            x-data="{ 
                currentIndex: 0, 
                items: {{ json_encode($galleryList) }},
                timer: null,
                init() {
                    this.timer = setInterval(() => { this.next(); }, 4000);
                },
                next() {
                    if (this.items.length === 0) return;
                    this.currentIndex = (this.currentIndex + 1) % this.items.length;
                },
                prev() {
                    if (this.items.length === 0) return;
                    this.currentIndex = (this.currentIndex - 1 + this.items.length) % this.items.length;
                },
                getVisibleItems() {
                    let res = [];
                    for (let i = 0; i < 6; i++) {
                        let idx = (this.currentIndex + i) % this.items.length;
                        res.push(this.items[idx]);
                    }
                    return res;
                }
            }"
            @mouseenter="clearInterval(timer)"
            @mouseleave="timer = setInterval(() => { next(); }, 4000)">

            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex flex-col lg:flex-row justify-between items-center lg:items-end text-center lg:text-left gap-sm border-b border-slate-200 pb-xs">
                    <div class="flex flex-col items-center lg:items-start text-center lg:text-left">
                        <span class="site-section-badge mb-xs">DOKUMENTASI FOTO</span>
                        <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900">Galeri Foto</h2>
                    </div>
                    <div class="flex items-center justify-center gap-sm">
                        <button @click="prev()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-100 border border-slate-200 hover:bg-emerald-700 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Previous Slide">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">arrow_back</span>
                        </button>
                        <button @click="next()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-100 border border-slate-200 hover:bg-emerald-700 hover:text-white flex items-center justify-center transition-colors shadow-sm" title="Next Slide">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">arrow_forward</span>
                        </button>
                    </div>
                </div>

                <!-- 6 Photos Grid Carousel (2 Rows of 3 Photos Each) -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-md transition-all duration-500">
                    <template x-for="(item, idx) in getVisibleItems()" :key="idx + '-' + item.title">
                        <div class="bg-slate-50/80 border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm flex flex-col group cursor-pointer hover:shadow-xl hover:border-emerald-500 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="relative h-52 sm:h-60 overflow-hidden bg-slate-950">
                                <img :src="item.image" :alt="item.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-90"></div>
                                <span class="absolute top-sm left-sm bg-orange-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-md uppercase" x-text="item.category"></span>
                                <button @click="activeLightboxImage = item.image; activeLightboxTitle = item.title" class="absolute bottom-sm right-sm w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/20 hover:bg-white/40 backdrop-blur-md text-white flex items-center justify-center transition-colors" title="Perbesar Foto">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">zoom_in</span>
                                </button>
                            </div>
                            <div class="p-md space-y-xs flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="text-sm font-bold font-headline text-slate-900 line-clamp-1 group-hover:text-emerald-700 transition-colors" x-text="item.title"></h3>
                                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mt-1" x-text="item.desc"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Dot Pagination Indicators -->
                <div class="flex justify-center items-center gap-sm pt-2">
                    <template x-for="(item, index) in items" :key="index">
                        <button @click="currentIndex = index" 
                                :class="currentIndex === index ? 'w-8 bg-emerald-700' : 'w-2.5 bg-slate-300 hover:bg-emerald-500'" 
                                class="h-2.5 rounded-full transition-all duration-300" 
                                :title="'Slide ' + (index+1)"></button>
                    </template>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- TESTIMONIAL                                -->
        <!-- ========================================== -->
        <section id="testimonial-wall" class="py-12 sm:py-16 bg-slate-50 border-t border-slate-200/60">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg text-center">
                
                <div class="max-w-2xl mx-auto space-y-1">
                    <span class="site-section-badge">TESTIMONIAL</span>
                    <h2 class="text-xl sm:text-2xl font-extrabold font-headline text-slate-900">Kesan Orang Tua Murid</h2>
                    <p class="text-xs sm:text-sm text-slate-600">Kepercayaan dan apresiasi wali murid &amp; alumni terhadap pendidikan SIT Robbani Ogan Ilir.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-md text-left pt-2">
                    @foreach($testimonialList as $testi)
                    <div class="bg-white border border-slate-200/80 p-md sm:p-lg rounded-3xl shadow-sm flex flex-col justify-between space-y-md hover:border-emerald-500 hover:shadow-xl transition-all duration-300">
                        <div class="space-y-sm">
                            <div class="text-amber-400 text-sm font-black">⭐⭐⭐⭐⭐</div>
                            <p class="text-xs italic text-slate-700 leading-relaxed font-medium">"{{ $testi['text'] }}"</p>
                        </div>
                        <div class="flex items-center gap-sm pt-sm border-t border-slate-200">
                            <img src="{{ $testi['avatar'] }}" alt="{{ $testi['name'] }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-600" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 leading-tight">{{ $testi['name'] }}</h4>
                                <span class="text-[10px] text-emerald-700 font-semibold block leading-tight">{{ $testi['title'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

    </main>

    <footer class="bg-gradient-to-b from-[#003828] via-[#00291d] to-[#001c14] text-slate-300 pt-12 sm:pt-16 pb-10 sm:pb-12 border-t border-emerald-900 text-xs">
        <div class="max-w-container-max mx-auto px-gutter space-y-8 sm:space-y-12">
            
            <!-- Top Branding Banner: Centered on Mobile/Tablet, Horizontal on Desktop -->
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-4 pb-8 sm:pb-10 border-b border-emerald-800/60 dark:border-[#1a381c]">
                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-3 sm:gap-4 text-center sm:text-left">
                    <div class="logo-badge-container">
                        <img src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}" class="h-12 sm:h-14 w-auto object-contain mx-auto md:mx-0 dark:hidden" alt="Logo SIT Robbani">
                        <img src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" class="h-12 sm:h-14 w-auto object-contain mx-auto md:mx-0 hidden dark:block" alt="Logo SIT Robbani">
                    </div>
                    <div>
                        <h3 class="font-extrabold text-base sm:text-xl text-white font-headline tracking-wide leading-tight">YAYASAN GENERASI ROBBANI</h3>
                        <p class="text-[10px] sm:text-xs text-amber-400 dark:text-[#c6f634] font-semibold uppercase tracking-wider">SIT Robbani Ogan Ilir, Sumatera Selatan</p>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-[11px] sm:text-xs rounded-full flex items-center justify-center gap-1.5 shadow-lg transition-all hover:scale-105">
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">call</span>
                        <span>WhatsApp Admin</span>
                    </a>
                    <a href="{{ route('school.ppdb') }}" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-bold text-[11px] sm:text-xs rounded-full flex items-center justify-center gap-1.5 shadow-lg transition-all hover:scale-105">
                        <span>Pendaftaran SPMB</span>
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- 4 Column Main Footer Links Grid: Centered Stack on Mobile/Tablet, 4 Cols Horizontal on Desktop -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 text-center md:text-left">
                
                <!-- Col 1: About & Address -->
                <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                    <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Tentang Kami</h4>
                    <p class="text-slate-300 text-[11px] sm:text-xs leading-relaxed max-w-xs mx-auto md:mx-0">
                        Lembaga Pendidikan Islam Terpadu unggulan di Ogan Ilir, mencetak generasi Qur'ani, berakhlak mulia, cerdas, dan berprestasi nasional.
                    </p>
                    <div class="space-y-2 text-[11px] sm:text-xs text-slate-300 flex flex-col items-center md:items-start">
                        <p class="flex items-center justify-center md:justify-start gap-2">
                            <span class="material-symbols-outlined text-[16px] text-amber-400 shrink-0">location_on</span>
                            <span>Jl. Raya Indralaya - Prabumulih, Ogan Ilir, Sumsel</span>
                        </p>
                        <p class="flex items-center justify-center md:justify-start gap-2">
                            <span class="material-symbols-outlined text-[16px] text-amber-400 shrink-0">mail</span>
                            <span>info@sitrobbani.sch.id</span>
                        </p>
                    </div>
                </div>

                <!-- Col 2: Unit Pendidikan -->
                <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                    <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Unit Pendidikan</h4>
                    <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 flex flex-col items-center md:items-start">
                        <li><a href="#unit-sekolah" class="hover:text-amber-300 transition-colors">KB / TKIT Robbani</a></li>
                        <li><a href="#unit-sekolah" class="hover:text-amber-300 transition-colors">SDIT Robbani</a></li>
                        <li><a href="#unit-sekolah" class="hover:text-amber-300 transition-colors">SMPIT Robbani</a></li>
                        <li><a href="#unit-sekolah" class="hover:text-amber-300 transition-colors">SMAIT Robbani</a></li>
                    </ul>
                </div>

                <!-- Col 3: Navigasi Portal -->
                <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                    <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Navigasi Portal</h4>
                    <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 flex flex-col items-center md:items-start">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition-colors">Beranda Utama</a></li>
                        <li><a href="{{ route('school.profil') }}" class="hover:text-amber-300 transition-colors">Profil Yayasan</a></li>
                        <li><a href="{{ route('school.berita') }}" class="hover:text-amber-300 transition-colors">Berita &amp; Artikel</a></li>
                        <li><a href="#sarana-prasarana" class="hover:text-amber-300 transition-colors">Sarana &amp; Prasarana</a></li>
                        <li><a href="#galeri-sekolah" class="hover:text-amber-300 transition-colors">Galeri Foto</a></li>
                        <li><a href="{{ route('school.espp') }}" class="hover:text-amber-300 transition-colors">E-SPP ARSI Payment</a></li>
                    </ul>
                </div>

                <!-- Col 4: Layanan & Social Media (REAL SVG ICONS) -->
                <div class="space-y-3 sm:space-y-4 flex flex-col items-center md:items-start">
                    <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider font-headline border-b border-emerald-500/40 pb-1.5 inline-block mx-auto md:mx-0">Layanan &amp; Medsos</h4>
                    <ul class="space-y-2 text-[11px] sm:text-xs text-slate-300 mb-3 flex flex-col items-center md:items-start">
                        <li><a href="{{ route('school.ppdb') }}" class="hover:text-amber-300 transition-colors">Penerimaan Siswa Baru (SPMB)</a></li>
                        <li><a href="{{ route('school.layanan.sewa') }}" class="hover:text-amber-300 transition-colors">Permohonan Sewa Fasilitas</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-amber-400 hover:underline font-bold">Portal Administrasi</a></li>
                    </ul>

                    <div class="pt-2 border-t border-emerald-800/80 w-full flex flex-col items-center md:items-start">
                        <span class="text-[10px] sm:text-[11px] font-semibold text-slate-300 block mb-2 text-center md:text-left">Ikuti Media Sosial:</span>
                        <!-- Authentic SVG Social Media Icon Badges -->
                        <div class="flex items-center justify-center md:justify-start gap-2.5">
                            <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-red-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="YouTube Channel">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-pink-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="Instagram">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-blue-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="Facebook">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="w-9 h-9 rounded-full bg-emerald-900/80 hover:bg-emerald-600 text-white flex items-center justify-center transition-all hover:scale-110 shadow-md" title="WhatsApp Admin">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Credit Bar -->
            <div class="pt-6 sm:pt-8 border-t border-emerald-900 flex flex-col md:flex-row justify-between items-center gap-3 sm:gap-4 text-center md:text-left text-slate-400 text-[11px] sm:text-xs">
                <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumsel). All rights reserved.</p>
                <a href="https://berandadigital.net" target="_blank" class="text-amber-400 hover:underline font-bold inline-flex items-center gap-1.5 bg-slate-900/90 px-3.5 py-1.5 rounded-full border border-emerald-800 hover:border-amber-400 transition-all text-[11px]">
                    <span>Powered by Beranda Teknologi Digital</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>

        </div>
    </footer>

    <!-- Video Player Modal Overlay -->
    <div x-show="activeVideoUrl" x-cloak class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-3xl overflow-hidden w-full max-w-4xl shadow-2xl relative" @click.away="activeVideoUrl = null">
            <div class="flex justify-between items-center p-4 border-b border-slate-800 text-white">
                <h3 class="text-sm font-bold truncate pr-4" x-text="activeVideoTitle || 'Video Player SIT Robbani'"></h3>
                <button @click="activeVideoUrl = null" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-black">✕</button>
            </div>
            <div class="relative pt-[56.25%] bg-black">
                <iframe :src="activeVideoUrl" class="absolute inset-0 w-full h-full border-none" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Photo Lightbox Modal Overlay -->
    <div x-show="activeLightboxImage" x-cloak class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4">
        <div class="relative max-w-5xl max-h-[90vh] flex flex-col items-center" @click.away="activeLightboxImage = null">
            <button @click="activeLightboxImage = null" class="absolute -top-12 right-0 px-4 py-1.5 rounded-full bg-white/20 hover:bg-white/30 text-white font-bold text-xs backdrop-blur-md">✕ Tutup</button>
            <img :src="activeLightboxImage" :alt="activeLightboxTitle" class="max-w-full max-h-[80vh] rounded-2xl shadow-2xl object-contain border border-white/20">
            <p class="text-white font-bold text-sm text-center mt-3 bg-black/50 px-4 py-2 rounded-xl backdrop-blur-sm" x-text="activeLightboxTitle"></p>
        </div>
    </div>

</body>
</html>
