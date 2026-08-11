<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] }} | Website Resmi Profil Sekolah & Portal Terpadu</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN Fallback for Guaranteed Instant Rendering -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            950: '#022c22',
                            900: '#064e3b',
                            800: '#065f46',
                            700: '#047857',
                            600: '#059669',
                            500: '#10b981',
                        },
                        amber: {
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* 5 Dynamic Theme Presets (Harmonized with Admin Layout System) */
        :root, html.theme-emerald, body.theme-emerald {
            --theme-gradient-primary: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            --theme-accent: #10b981;
            --theme-accent-dark: #059669;
            --theme-accent-light: #d1fae5;
            --theme-text-accent: #047857;
            --theme-hero-bg: linear-gradient(135deg, #022c22 0%, #0f172a 50%, #064e3b 100%);
        }
        html.theme-ocean, body.theme-ocean {
            --theme-gradient-primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            --theme-accent: #3b82f6;
            --theme-accent-dark: #2563eb;
            --theme-accent-light: #dbeafe;
            --theme-text-accent: #1d4ed8;
            --theme-hero-bg: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #172554 100%);
        }
        html.theme-magenta, body.theme-magenta {
            --theme-gradient-primary: linear-gradient(135deg, #ec4899 0%, #d946ef 50%, #8b5cf6 100%);
            --theme-accent: #ec4899;
            --theme-accent-dark: #db2777;
            --theme-accent-light: #fce7f3;
            --theme-text-accent: #be185d;
            --theme-hero-bg: linear-gradient(135deg, #4c0519 0%, #0f172a 50%, #3b0764 100%);
        }
        html.theme-sunset, body.theme-sunset {
            --theme-gradient-primary: linear-gradient(135deg, #f43f5e 0%, #f97316 50%, #eab308 100%);
            --theme-accent: #f43f5e;
            --theme-accent-dark: #e11d48;
            --theme-accent-light: #ffe4e6;
            --theme-text-accent: #be123c;
            --theme-hero-bg: linear-gradient(135deg, #450a0a 0%, #0f172a 50%, #431407 100%);
        }
        html.theme-gold, body.theme-gold {
            --theme-gradient-primary: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            --theme-accent: #f59e0b;
            --theme-accent-dark: #d97706;
            --theme-accent-light: #fef3c7;
            --theme-text-accent: #b45309;
            --theme-hero-bg: linear-gradient(135deg, #000000 0%, #0f172a 50%, #451a03 100%);
        }

        body { 
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; 
            color: #0f172a;
            background-color: #f8fafc;
        }
        [x-cloak] { display: none !important; }

        .theme-btn-primary {
            background: var(--theme-gradient-primary) !important;
            color: #ffffff !important;
        }
        .theme-text-accent {
            color: var(--theme-text-accent) !important;
        }
        .theme-bg-badge {
            background-color: var(--theme-accent-light) !important;
            color: var(--theme-text-accent) !important;
        }
        .theme-border-accent {
            border-color: var(--theme-accent) !important;
        }

        /* Smooth Scroll Reveal & Card Hover Animations */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-1 { transition-delay: 0.1s; }
        .delay-2 { transition-delay: 0.2s; }
        .delay-3 { transition-delay: 0.3s; }
        .delay-4 { transition-delay: 0.4s; }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-float {
            animation: floatSlow 4s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen selection:bg-amber-400 selection:text-slate-950">

    <!-- ========================================== -->
    <!-- SECTION 1: TOP ANNOUNCEMENT BAR            -->
    <!-- ========================================== -->
    <div class="bg-slate-950 text-slate-100 text-xs py-2.5 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 font-black text-[10px] uppercase tracking-wider animate-pulse">
                    <span>INFO PPDB</span>
                </span>
                <span class="truncate max-w-xl text-slate-200 hidden md:inline">{{ $settings['ppdb_status'] }}: {{ $settings['ppdb_desc'] }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-bold">
                <a href="tel:{{ $settings['contact_phone'] }}" class="hover:text-amber-300 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    <span>{{ $settings['contact_phone'] }}</span>
                </a>
                <a href="mailto:{{ $settings['contact_email'] }}" class="hover:text-amber-300 hidden lg:flex items-center gap-1 transition-colors">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>{{ $settings['contact_email'] }}</span>
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1 rounded-xl theme-btn-primary font-black shadow-sm transition-transform hover:scale-105">Portal Admin ➔</a>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- SECTION 2: MAIN NAVIGATION NAVBAR          -->
    <!-- ========================================== -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            
            <!-- School Brand Identity -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="p-1.5 rounded-2xl bg-slate-50 border border-slate-200 group-hover:theme-border-accent transition-all shadow-sm">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo {{ $settings['school_name'] }}" class="h-10 w-auto object-contain transition-transform group-hover:scale-110">
                </div>
                <div class="border-l border-slate-200 pl-3">
                    <span class="text-xs font-black text-slate-900 uppercase tracking-tight block leading-tight group-hover:theme-text-accent transition-colors">{{ $settings['school_name'] }}</span>
                    <span class="text-[11px] theme-text-accent font-bold block leading-tight">Yayasan Pendidikan Islam Terpadu</span>
                </div>
            </a>

            <!-- Desktop Nav Links (Concise 1-word titles) -->
            <nav class="hidden lg:flex items-center gap-5 text-xs font-bold text-slate-700 whitespace-nowrap">
                <a href="#hero" class="hover:theme-text-accent transition-colors">Beranda</a>
                <a href="#sambutan" class="hover:theme-text-accent transition-colors">Sambutan</a>
                <a href="#berita" class="hover:theme-text-accent transition-colors">Berita</a>
                <a href="#program" class="hover:theme-text-accent transition-colors">Program</a>
                <a href="#pimpinan" class="hover:theme-text-accent transition-colors">Pimpinan</a>
                <a href="#video" class="hover:theme-text-accent transition-colors">Video</a>
                <a href="#agenda" class="hover:theme-text-accent transition-colors">Agenda</a>
                <a href="#unit-sekolah" class="hover:theme-text-accent transition-colors">Unit</a>
                <a href="{{ route('sales') }}" class="theme-text-accent font-black hover:underline">Sales</a>
            </nav>

            <!-- CTA Actions -->
            <div class="hidden sm:flex items-center gap-3 shrink-0">
                <a href="#ppdb" class="px-4 py-2 rounded-xl theme-btn-primary font-extrabold text-xs shadow-md transition-all hover:scale-105">
                    PPDB ➔
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden bg-white border-b border-slate-200 p-4 space-y-1 text-xs font-bold text-slate-700">
            <a href="#hero" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Beranda</a>
            <a href="#sambutan" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Sambutan</a>
            <a href="#berita" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Berita</a>
            <a href="#program" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Program</a>
            <a href="#pimpinan" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Pimpinan</a>
            <a href="#video" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Video</a>
            <a href="#agenda" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Agenda</a>
            <a href="#unit-sekolah" @click="mobileMenuOpen = false" class="block py-2 px-3 rounded-lg hover:bg-slate-50 hover:theme-text-accent">Unit</a>
            <a href="{{ route('sales') }}" class="block py-2 px-3 rounded-lg theme-text-accent font-black">Sales ➔</a>
            <a href="#ppdb" @click="mobileMenuOpen = false" class="block py-2.5 text-center rounded-xl theme-btn-primary font-black">PPDB Online ➔</a>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- SECTION 3: HERO BANNER CAROUSEL            -->
    <!-- ========================================== -->
    <section id="hero" class="relative py-16 md:py-24 overflow-hidden text-white" style="background: var(--theme-hero-bg);">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6 text-left scroll-reveal">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 border border-white/20 text-amber-300 font-extrabold text-xs uppercase tracking-wider backdrop-blur-md animate-pulse">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span>{{ $settings['hero_badge'] }}</span>
                </span>

                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ $settings['hero_title'] }}
                </h1>

                <p class="text-sm md:text-base text-slate-200 leading-relaxed max-w-2xl font-normal">
                    {{ $settings['hero_desc'] }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="#ppdb" class="px-6 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-xl transition-transform hover:scale-105 flex items-center gap-2">
                        <span>Pendaftaran PPDB 2026</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-extrabold text-xs backdrop-blur-md border border-white/20 transition-all flex items-center gap-2">
                        <span>Portal Login Admin SmartEdu</span>
                    </a>
                </div>
            </div>

            <!-- Hero Banner Image / Visual Card -->
            <div class="lg:col-span-5 relative scroll-reveal delay-2">
                <div class="p-3 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl overflow-hidden animate-float">
                    <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80" alt="Gedung & Kegiatan Sekolah Robbani" class="w-full h-80 object-cover rounded-2xl shadow-md">
                    <div class="mt-4 p-3 rounded-xl bg-slate-900/90 border border-slate-800 text-xs flex items-center justify-between">
                        <div>
                            <span class="text-amber-400 font-extrabold block uppercase text-[10px]">Kampus Terpadu</span>
                            <span class="text-white font-bold">Gedung Pembelajaran Digital Robbani</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full theme-btn-primary font-black text-[10px]">Terakreditasi A</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: HORIZONTAL QUICK NAV ICON GRID   -->
    <!-- ========================================== -->
    <section class="py-8 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-4 sm:grid-cols-4 md:grid-cols-8 gap-4 text-center">
                
                <a href="#sambutan" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal">
                    <div class="w-12 h-12 mx-auto rounded-2xl theme-bg-badge flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 theme-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">Profil Sekolah</span>
                </a>

                <a href="#program" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-1">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-blue-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">Kurikulum JSIT</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-purple-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">RFID Gate</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">Kasir SPP</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-1">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-cyan-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">Tabungan</span>
                </a>

                <a href="{{ route('admin.dashboard') }}" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-2">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-rose-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">POS Kantin</span>
                </a>

                <a href="#program" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-3">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-teal-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">SafeSchool</span>
                </a>

                <a href="#ppdb" class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 hover:theme-border-accent transition-all group scroll-reveal delay-4">
                    <div class="w-12 h-12 mx-auto rounded-2xl bg-orange-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <span class="text-[11px] font-extrabold text-slate-800 block mt-2">PPDB Online</span>
                </a>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: SAMBUTAN KEPALA SEKOLAH / YAYASAN -->
    <!-- ========================================== -->
    <section id="sambutan" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-3xl p-8 md:p-12 border border-slate-200 shadow-md grid grid-cols-1 lg:grid-cols-12 gap-8 items-center scroll-reveal">
                
                <!-- Left: Portrait Photo -->
                <div class="lg:col-span-5 relative">
                    <div class="p-2 rounded-3xl theme-btn-primary shadow-xl">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=600&q=80" alt="{{ $settings['principal_name'] }}" class="w-full h-96 object-cover rounded-2xl">
                    </div>
                </div>

                <!-- Right: Welcome Quote & Message -->
                <div class="lg:col-span-7 space-y-4 text-left">
                    <span class="text-5xl theme-text-accent block leading-none font-serif">“</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Sambutan Ketua Yayasan & Kepala Sekolah</h2>
                    <p class="text-sm text-slate-600 leading-relaxed italic font-medium">
                        "{{ $settings['principal_greeting'] }}"
                    </p>
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-base font-black text-slate-900">{{ $settings['principal_name'] }}</h4>
                        <p class="text-xs theme-text-accent font-bold">{{ $settings['principal_title'] }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 6: BERITA UTAMA & NEWS GRID        -->
    <!-- ========================================== -->
    <section id="berita" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 scroll-reveal">
                <div>
                    <span class="px-3 py-1 rounded-full theme-bg-badge font-black text-[10px] uppercase">Kabar Sekolah</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Berita & Informasi Terkini Robbani</h2>
                </div>
                <a href="#berita" class="text-xs font-black theme-text-accent hover:underline">Lihat Semua Berita ➔</a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Big Featured News (Left) -->
                <div class="lg:col-span-7 bg-slate-50 rounded-3xl p-5 border border-slate-200 space-y-4 shadow-sm hover:shadow-md transition-shadow scroll-reveal">
                    <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=800&q=80" class="w-full h-64 object-cover rounded-2xl">
                    <div class="space-y-2">
                        <span class="px-3 py-1 rounded-full theme-btn-primary font-black text-[10px]">PRESTASI NASIONAL</span>
                        <h3 class="text-xl font-black text-slate-900">Siswa SMPIT Robbani Raih Juara 1 Musabaqah Hifdzil Qur'an (MHQ) 10 Juz</h3>
                        <p class="text-xs text-slate-500">11 Agustus 2026 • Oleh Humas Robbani</p>
                        <p class="text-xs text-slate-600 leading-relaxed font-normal">Ananda Fatih Abdullah berhasil menorehkan prestasi gemilang tingkat nasional pada ajang Festival Anak Sholeh Indonesia...</p>
                    </div>
                </div>

                <!-- Stacked News List (Right) -->
                <div class="lg:col-span-5 space-y-4 scroll-reveal delay-2">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-center hover:theme-border-accent transition-all">
                        <img src="https://images.unsplash.com/photo-1588072432836-e10032774350?auto=format&fit=crop&w=300&q=80" class="w-20 h-20 object-cover rounded-xl shrink-0">
                        <div class="space-y-1">
                            <span class="text-[10px] theme-text-accent font-bold uppercase">AKADEMIK</span>
                            <h4 class="font-extrabold text-xs text-slate-900 leading-snug">Implementasi E-Rapor Kurikulum Merdeka Terintegrasi SmartEdu</h4>
                            <span class="text-[10px] text-slate-400 font-medium block">10 Agustus 2026</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-center hover:theme-border-accent transition-all">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=300&q=80" class="w-20 h-20 object-cover rounded-xl shrink-0">
                        <div class="space-y-1">
                            <span class="text-[10px] text-blue-700 font-bold uppercase">SAFE SCHOOL</span>
                            <h4 class="font-extrabold text-xs text-slate-900 leading-snug">Sosialisasi Anti-Bullying & Pembentukan Duta Konseling Siswa</h4>
                            <span class="text-[10px] text-slate-400 font-medium block">08 Agustus 2026</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-center hover:theme-border-accent transition-all">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=300&q=80" class="w-20 h-20 object-cover rounded-xl shrink-0">
                        <div class="space-y-1">
                            <span class="text-[10px] text-purple-700 font-bold uppercase">DIGITAL CASHLESS</span>
                            <h4 class="font-extrabold text-xs text-slate-900 leading-snug">Uji Coba Sistem POS Kantin Cashless Berbasis Tap RFID Card</h4>
                            <span class="text-[10px] text-slate-400 font-medium block">05 Agustus 2026</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 7: PROGRAM UNGGULAN GRID           -->
    <!-- ========================================== -->
    <section id="program" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2 scroll-reveal">
                <span class="px-3 py-1 rounded-full theme-bg-badge font-black text-[10px] uppercase">Karakter & Akademik</span>
                <h2 class="text-3xl font-black text-slate-900">4 Program Unggulan Kekhasan Robbani</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Program 1 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 hover:shadow-lg transition-all hover:-translate-y-1 scroll-reveal delay-1">
                    <div class="w-12 h-12 rounded-2xl theme-bg-badge flex items-center justify-center font-bold">
                        <svg class="w-6 h-6 theme-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-black text-base text-slate-900">Tahfidz Al-Qur'an 30 Juz</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Program setoran tahfidz harian dengan metode talaqqi & bimbingan ustadz bersanad.</p>
                </div>

                <!-- Program 2 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 hover:shadow-lg transition-all hover:-translate-y-1 scroll-reveal delay-2">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="font-black text-base text-slate-900">BPI & SafeSchool</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Bina Pribadi Islami, mutabaah yaumiyah, & perlindungan lingkungan sekolah anti-bullying.</p>
                </div>

                <!-- Program 3 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 hover:shadow-lg transition-all hover:-translate-y-1 scroll-reveal delay-3">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-black text-base text-slate-900">Digital SmartEdu</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Presensi gate RFID, POS kantin cashless, teller tabungan, & e-rapor Kurikulum Merdeka.</p>
                </div>

                <!-- Program 4 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 hover:shadow-lg transition-all hover:-translate-y-1 scroll-reveal delay-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-black text-base text-slate-900">Sunnah Sports & Club</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Ekstrakulikuler memanah, berkuda, renang, robotik, & club olimpiade sains.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 8: PROFIL PIMPINAN YAYASAN CAROUSEL -->
    <!-- ========================================== -->
    <section id="pimpinan" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2 scroll-reveal">
                <span class="px-3 py-1 rounded-full theme-bg-badge font-black text-[10px] uppercase">Struktur Kepemimpinan</span>
                <h2 class="text-3xl font-black text-slate-900">Pimpinan Yayasan & Kepala Unit Sekolah</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all scroll-reveal delay-1">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" class="w-32 h-32 mx-auto rounded-full object-cover border-4 theme-border-accent shadow-md">
                    <div>
                        <h4 class="font-black text-sm text-slate-900">Ustadz Ahmad Fauzi M.Pd</h4>
                        <p class="text-xs theme-text-accent font-bold">Ketua Yayasan Robbani</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all scroll-reveal delay-2">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" class="w-32 h-32 mx-auto rounded-full object-cover border-4 theme-border-accent shadow-md">
                    <div>
                        <h4 class="font-black text-sm text-slate-900">Ustadzah Fitriana S.Si</h4>
                        <p class="text-xs theme-text-accent font-bold">Kepala Unit SDIT Robbani</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all scroll-reveal delay-3">
                    <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=400&q=80" class="w-32 h-32 mx-auto rounded-full object-cover border-4 theme-border-accent shadow-md">
                    <div>
                        <h4 class="font-black text-sm text-slate-900">Ustadzah Sri Nurhidayat M.Pd</h4>
                        <p class="text-xs theme-text-accent font-bold">Kepala Unit SMPIT Robbani</p>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-3xl p-5 border border-slate-200 text-center space-y-3 hover:shadow-md transition-all scroll-reveal delay-4">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80" class="w-32 h-32 mx-auto rounded-full object-cover border-4 theme-border-accent shadow-md">
                    <div>
                        <h4 class="font-black text-sm text-slate-900">Ustadz Drs. H. Ridwan M.Ag</h4>
                        <p class="text-xs theme-text-accent font-bold">Kepala Unit SMAIT Robbani</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 9: VIDEO GALLERY CAROUSEL (DARK)  -->
    <!-- ========================================== -->
    <section id="video" class="py-16 bg-slate-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 scroll-reveal">
                <div>
                    <span class="px-3 py-1 rounded-full bg-amber-400/20 text-amber-300 font-black text-[10px] uppercase">Multimedia</span>
                    <h2 class="text-2xl font-black text-white tracking-tight mt-1">Galeri Video & Dokumentasi Kegiatan</h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-slate-900 p-4 rounded-3xl border border-slate-800 space-y-3 scroll-reveal delay-1">
                    <div class="relative rounded-2xl overflow-hidden group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&w=600&q=80" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center group-hover:bg-slate-950/20 transition-all">
                            <span class="w-12 h-12 rounded-full theme-btn-primary flex items-center justify-center font-bold text-xl shadow-lg group-hover:scale-110 transition-transform">▶</span>
                        </div>
                    </div>
                    <h4 class="font-extrabold text-sm text-white">Video Profil Resmi Sekolah Islam Terpadu Robbani</h4>
                </div>

                <div class="bg-slate-900 p-4 rounded-3xl border border-slate-800 space-y-3 scroll-reveal delay-2">
                    <div class="relative rounded-2xl overflow-hidden group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center group-hover:bg-slate-950/20 transition-all">
                            <span class="w-12 h-12 rounded-full theme-btn-primary flex items-center justify-center font-bold text-xl shadow-lg group-hover:scale-110 transition-transform">▶</span>
                        </div>
                    </div>
                    <h4 class="font-extrabold text-sm text-white">Dokumentasi Wisuda Tahfidz 30 Juz Angkatan IV</h4>
                </div>

                <div class="bg-slate-900 p-4 rounded-3xl border border-slate-800 space-y-3 scroll-reveal delay-3">
                    <div class="relative rounded-2xl overflow-hidden group cursor-pointer">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center group-hover:bg-slate-950/20 transition-all">
                            <span class="w-12 h-12 rounded-full theme-btn-primary flex items-center justify-center font-bold text-xl shadow-lg group-hover:scale-110 transition-transform">▶</span>
                        </div>
                    </div>
                    <h4 class="font-extrabold text-sm text-white">Demo Sistem Presensi RFID Gate & POS Kantin Cashless</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 10: DUAL PANEL AGENDA & PENGUMUMAN  -->
    <!-- ========================================== -->
    <section id="agenda" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Left: Agenda Kegiatan -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 scroll-reveal">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="font-black text-lg text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 theme-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Agenda Kegiatan Sekolah</span>
                    </h3>
                    <span class="text-xs font-bold theme-text-accent">Agustus - September 2026</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4 hover:theme-border-accent transition-all">
                        <div class="p-2.5 rounded-xl theme-btn-primary text-center font-black shrink-0 w-14 shadow-sm">
                            <span class="block text-xs uppercase">AGU</span>
                            <span class="block text-lg leading-none">17</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xs text-slate-900">Upacara Peringatan HUT RI ke-81 & Lomba Santri</h4>
                            <p class="text-[11px] text-slate-500">Lapangan Utama Kampus Robbani • 07:00 WIB</p>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4 hover:theme-border-accent transition-all">
                        <div class="p-2.5 rounded-xl bg-blue-600 text-white text-center font-black shrink-0 w-14 shadow-sm">
                            <span class="block text-xs uppercase">AGU</span>
                            <span class="block text-lg leading-none">25</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xs text-slate-900">Pelatihan Parent Control BPI & Parenting Islami</h4>
                            <p class="text-[11px] text-slate-500">Aula Utama Robbani & Zoom Meeting</p>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-4 hover:theme-border-accent transition-all">
                        <div class="p-2.5 rounded-xl bg-purple-600 text-white text-center font-black shrink-0 w-14 shadow-sm">
                            <span class="block text-xs uppercase">SEP</span>
                            <span class="block text-lg leading-none">05</span>
                        </div>
                        <div>
                            <h4 class="font-extrabold text-xs text-slate-900">Ujian Munaqasyah Tahfidz Al-Qur'an Semester Ganjil</h4>
                            <p class="text-[11px] text-slate-500">Masjid Sekolah Islam Terpadu Robbani</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Pengumuman Resmi -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 scroll-reveal delay-2">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="font-black text-lg text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 theme-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span>Pengumuman Resmi Yayasan</span>
                    </h3>
                    <span class="text-xs font-bold theme-text-accent">Edaran Terkini</span>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1 hover:theme-border-accent transition-all">
                        <span class="px-2 py-0.5 rounded theme-bg-badge text-[10px] font-black">EDARAN PPDB</span>
                        <h4 class="font-extrabold text-xs text-slate-900">Jadwal Gelombang 1 Pendaftaran PPDB TA 2026/2027</h4>
                        <p class="text-[11px] text-slate-500">Pendaftaran dibuka online sampai tanggal 30 September 2026.</p>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-1 hover:theme-border-accent transition-all">
                        <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-black">KARTU RFID</span>
                        <h4 class="font-extrabold text-xs text-slate-900">Pengambilan Kartu RFID Multi-Fungsi Siswa Baru</h4>
                        <p class="text-[11px] text-slate-500">Dapat diambil di Bagian TU Sekolah mulai jam kerja 08:00 - 15:00 WIB.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 11: UNIT SEKOLAH CARDS             -->
    <!-- ========================================== -->
    <section id="unit-sekolah" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2 scroll-reveal">
                <span class="px-3 py-1 rounded-full theme-bg-badge font-black text-[10px] uppercase">Multi-Tenant Unit</span>
                <h2 class="text-3xl font-black text-slate-900">Unit Sekolah Dalam Naungan Yayasan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($schools as $sc)
                <div class="bg-slate-50 p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between hover:shadow-lg transition-all hover:-translate-y-1 scroll-reveal">
                    <div class="space-y-2">
                        <span class="px-3 py-1 rounded-full text-xs font-black text-white" style="background-color: {{ $sc->theme_color ?? '#059669' }}">
                            {{ $sc->code }}
                        </span>
                        <h3 class="text-xl font-black text-slate-900">{{ $sc->name }}</h3>
                        <p class="text-xs text-slate-500 font-medium">NPSN: {{ $sc->npsn }} • Kepsek: {{ $sc->principal_name }}</p>
                        <p class="text-xs text-slate-600">📍 {{ $sc->address }}</p>
                    </div>

                    <div class="pt-4 border-t border-slate-200 flex items-center justify-between text-xs font-bold">
                        <span class="text-slate-500">{{ $sc->students_count }} Siswa Active</span>
                        <a href="{{ route('school.unit', strtolower($sc->code)) }}" class="theme-text-accent hover:underline flex items-center gap-1">
                            <span>Profil Unit {{ $sc->code }}</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 12: PPDB BANNER & CALLOUT          -->
    <!-- ========================================== -->
    <section id="ppdb" class="py-16 text-white" style="background: var(--theme-hero-bg);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center space-y-6 scroll-reveal">
            <span class="px-3.5 py-1.5 rounded-full bg-amber-400 text-slate-950 font-black text-xs uppercase animate-pulse">PENDAFTARAN SISWA BARU</span>
            <h2 class="text-3xl sm:text-4xl font-black text-white">Bergabunglah Bersama Sekolah Islam Terpadu Robbani</h2>
            <p class="text-sm text-slate-200 max-w-2xl mx-auto">Kuota terbatas untuk jenjang SDIT, SMPIT, & SMAIT Tahun Ajaran 2026/2027.</p>
            <div class="pt-2">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Robbani,%20saya%20ingin%20bertanya%20informasi%20PPDB" class="px-8 py-4 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm shadow-xl inline-block transition-transform hover:scale-105">
                    Hubungi Panitia PPDB via WhatsApp ➔
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 13: FOOTER WITH NEWSLETTER         -->
    <!-- ========================================== -->
    <footer class="bg-slate-950 text-white pt-16 pb-8 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Col 1 -->
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="h-9 w-auto bg-white p-1 rounded-xl">
                        <h4 class="font-black text-base text-white leading-tight">{{ $settings['school_name'] }}</h4>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">Platform ekosistem pendidikan Islam terpadu berkarakter & berbasis digital SmartEdu.</p>
                </div>

                <!-- Col 2 -->
                <div class="space-y-2 text-xs">
                    <h5 class="font-black text-amber-400 uppercase tracking-wider mb-2">Navigasi Utama</h5>
                    <a href="#hero" class="block text-slate-400 hover:text-white transition-colors">Beranda Portal</a>
                    <a href="#sambutan" class="block text-slate-400 hover:text-white transition-colors">Sambutan Yayasan</a>
                    <a href="#berita" class="block text-slate-400 hover:text-white transition-colors">Berita & Pengumuman</a>
                    <a href="#program" class="block text-slate-400 hover:text-white transition-colors">Program Tahfidz & BPI</a>
                </div>

                <!-- Col 3 -->
                <div class="space-y-2 text-xs">
                    <h5 class="font-black text-amber-400 uppercase tracking-wider mb-2">Akses Portal</h5>
                    <a href="{{ route('admin.dashboard') }}" class="block text-slate-400 hover:text-white transition-colors">Dashboard Admin SmartEdu</a>
                    <a href="{{ route('sales') }}" class="block text-slate-400 hover:text-white transition-colors">Halaman Sales 21 Modul</a>
                    <a href="#ppdb" class="block text-slate-400 hover:text-white transition-colors">Pendaftaran PPDB Online</a>
                </div>

                <!-- Col 4 -->
                <div class="space-y-2 text-xs">
                    <h5 class="font-black text-amber-400 uppercase tracking-wider mb-2">Kontak Yayasan</h5>
                    <p class="text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>{{ $settings['contact_address'] }}</span>
                    </p>
                    <p class="text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>{{ $settings['contact_phone'] }}</span>
                    </p>
                    <p class="text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ $settings['contact_email'] }}</span>
                    </p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-900 text-center text-xs text-slate-500 font-medium">
                © 2026 {{ $settings['school_name'] }} • Powered by SmartEdu Siakad Platform. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Theme Synchronization & Scroll Reveal Script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Restore theme from localStorage if customized in admin
            const savedAdminTheme = localStorage.getItem('smartedu_admin_theme');
            if (savedAdminTheme) {
                document.documentElement.className = 'scroll-smooth ' + savedAdminTheme;
            }

            // Scroll Reveal Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
