<!DOCTYPE html>
<html lang="id" 
      class="scroll-smooth" 
      x-data="{ 
          darkMode: localStorage.getItem('theme_mode') === 'dark', 
          mobileMenuOpen: false 
      }" 
      x-init="$watch('darkMode', val => { 
          localStorage.setItem('theme_mode', val ? 'dark' : 'light'); 
          if (val) { document.documentElement.classList.add('dark'); } 
          else { document.documentElement.classList.remove('dark'); } 
      })" 
      :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <script>
        if (localStorage.getItem('theme_mode') === 'dark') {
            document.documentElement.classList.add('dark');
        } else if (localStorage.getItem('theme_mode') === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <title>@yield('title', ($info['name'] ?? 'Sekolah Islam Terpadu') . ' - ' . ($info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia'))</title>
    <meta name="description" content="@yield('meta_description', $info['description'] ?? 'Official Website ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Lembaga Pendidikan Islam Terpadu berakreditasi unggul.')">
    <meta name="keywords" content="@yield('meta_keywords', ($info['name'] ?? '') . ', JSIT Indonesia, SPMB Online, Tahfidz Qur\'an, Sekolah Islam Terpadu')">
    <meta name="author" content="{{ $info['name'] ?? 'Sekolah Islam Terpadu' }}">
    <meta name="robots" content="index, follow">

    {{-- Open Graph / Facebook / WhatsApp --}}
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $info['name'] ?? 'Sekolah Islam Terpadu' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', ($info['name'] ?? 'Sekolah Islam Terpadu'))">
    <meta property="og:description" content="@yield('meta_description', $info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia')">
    <meta property="og:image" content="{{ asset($info['logo'] ?? '/images/logo-robbani-official.png') }}">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', ($info['name'] ?? 'Sekolah Islam Terpadu'))">
    <meta name="twitter:description" content="@yield('meta_description', $info['tagline'] ?? '')">
    <meta name="twitter:image" content="{{ asset($info['logo'] ?? '/images/logo-robbani-official.png') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset($info['favicon'] ?? '/favicon.png') }}">

    {{-- Google Fonts Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,700&display=swap" rel="stylesheet">

    {{-- FontAwesome 6 Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" referrerpolicy="no-referrer" />

    {{-- Tailwind CSS & Alpine.js --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        $uTheme = $info['theme'] ?? [
            'primary' => '#4338ca',
            'primary_dark' => '#312e81',
            'primary_light' => '#6366f1',
            'electric_blue' => '#2563eb',
            'gold' => '#f59e0b',
            'gold_light' => '#fbbf24',
            'dark' => '#0f172a',
            'dark_container' => '#1e1b4b',
            'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
            'hero_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
            'accent_text' => 'text-indigo-600',
            'btn_primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
            'btn_gold' => 'bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950',
            'border_accent' => 'border-indigo-600',
            'bg_light' => 'bg-indigo-50/70'
        ];
    @endphp

    <style>
        [x-cloak] { display: none !important; }

        :root {
            --color-primary: {{ $uTheme['primary'] }};
            --color-primary-dark: {{ $uTheme['primary_dark'] }};
            --color-primary-light: {{ $uTheme['primary_light'] }};
            --color-gold: {{ $uTheme['gold'] }};
            --color-gold-light: {{ $uTheme['gold_light'] }};
            --color-dark: {{ $uTheme['dark'] }};
        }

        .bg-unit-primary { background-color: var(--color-primary) !important; }
        .bg-unit-primary-dark { background-color: var(--color-primary-dark) !important; }
        .bg-unit-soft { background-color: color-mix(in srgb, var(--color-primary) 10%, white) !important; }
        .text-unit-primary { color: var(--color-primary) !important; }
        .border-unit-primary { border-color: var(--color-primary) !important; }
        .hover\:bg-unit-primary:hover { background-color: var(--color-primary) !important; }
        .hover\:bg-unit-primary-dark:hover { background-color: var(--color-primary-dark) !important; }
        .hover\:text-unit-primary:hover { color: var(--color-primary) !important; }
        .hover\:border-unit-primary:hover { border-color: var(--color-primary) !important; }

        body {
            font-family: 'Poppins', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Micro-Interactions & Smooth Scroll-Reveal Animation */
        .reveal-fade-up {
            opacity: 0;
            transform: translate3d(0, 24px, 0);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), 
                        transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-fade-up.is-revealed {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .delay-1 { transition-delay: 80ms; }
        .delay-2 { transition-delay: 160ms; }
        .delay-3 { transition-delay: 240ms; }
        .delay-4 { transition-delay: 320ms; }
        .delay-5 { transition-delay: 400ms; }
        .delay-6 { transition-delay: 480ms; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: {{ $uTheme['primary'] }};
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: {{ $uTheme['gold'] }};
        }

        /* ==========================================================================
           EXECUTIVE OBSIDIAN DARK MODE SYSTEM UNTUK SELURUH UNIT WEBSITE SIT ROBBANI
           ========================================================================== */
        html.dark, html.dark body {
            background-color: #070d18 !important;
            color: #f1f5f9 !important;
        }

        /* 1. Base Main & Body Backgrounds */
        html.dark main,
        html.dark body,
        html.dark section,
        html.dark .bg-\[\#f8fafc\],
        html.dark .bg-slate-50,
        html.dark .bg-gray-50 {
            background-color: #070d18 !important;
        }

        /* 2. Elevated Dark Card Surfaces (#0f172a / #111e33) */
        html.dark .bg-white {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            color: #f8fafc !important;
        }

        /* 3. Soft Backgrounds, Pills, Chips & Minor Wrappers */
        html.dark .bg-slate-100,
        html.dark .bg-gray-100,
        html.dark .bg-indigo-50,
        html.dark .bg-indigo-50\/70,
        html.dark .bg-indigo-50\/80,
        html.dark .bg-orange-50,
        html.dark .bg-orange-50\/80,
        html.dark .bg-emerald-50,
        html.dark .bg-blue-50,
        html.dark .bg-amber-50,
        html.dark .bg-cyan-50,
        html.dark .bg-rose-50,
        html.dark .bg-purple-50 {
            background-color: #162238 !important;
            border-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        html.dark .bg-red-50 {
            background-color: rgba(239, 68, 68, 0.15) !important;
            border-color: rgba(239, 68, 68, 0.3) !important;
        }

        html.dark .bg-unit-soft {
            background-color: rgba(67, 56, 202, 0.2) !important;
            border-color: rgba(99, 102, 241, 0.3) !important;
        }

        /* 4. Headings & High-Contrast Typography */
        html.dark h1, html.dark h2, html.dark h3, html.dark h4, html.dark h5, html.dark h6 {
            color: #ffffff !important;
        }

        html.dark .text-gray-900,
        html.dark .text-gray-800,
        html.dark .text-slate-900,
        html.dark .text-slate-800 {
            color: #f8fafc !important;
        }

        html.dark .text-gray-700,
        html.dark .text-gray-600,
        html.dark .text-slate-700,
        html.dark .text-slate-600 {
            color: #cbd5e1 !important;
        }

        html.dark .text-gray-500,
        html.dark .text-gray-400,
        html.dark .text-slate-500,
        html.dark .text-slate-400 {
            color: #94a3b8 !important;
        }

        /* 5. Borders & Dividers */
        html.dark .border-gray-50,
        html.dark .border-gray-100,
        html.dark .border-gray-200,
        html.dark .border-gray-300,
        html.dark .border-slate-100,
        html.dark .border-slate-200,
        html.dark .border-slate-300 {
            border-color: #1e293b !important;
        }

        /* 6. Form Controls, Search Bars & Inputs */
        html.dark input,
        html.dark select,
        html.dark textarea {
            background-color: #0b1322 !important;
            color: #f8fafc !important;
            border-color: #334155 !important;
        }

        html.dark input::placeholder,
        html.dark textarea::placeholder {
            color: #64748b !important;
        }

        /* 7. Dropdowns & Submenu Hover Drawers */
        html.dark .group-hover\:block > div {
            background-color: #0f172a !important;
            border-color: #1e293b !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.8) !important;
        }

        html.dark .group-hover\:block a {
            color: #e2e8f0 !important;
        }

        html.dark .group-hover\:block a:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        /* 8. Filter Pills & Category Buttons */
        html.dark button.bg-white,
        html.dark a.bg-white {
            background-color: #162238 !important;
            color: #cbd5e1 !important;
            border-color: #1e293b !important;
        }

        html.dark button.bg-white:hover,
        html.dark a.bg-white:hover {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        /* 9. Interactive Hover States */
        html.dark .hover\:bg-slate-50:hover,
        html.dark .hover\:bg-gray-50:hover,
        html.dark .hover\:bg-slate-100:hover,
        html.dark .hover\:bg-gray-100:hover {
            background-color: #1e293b !important;
        }

        /* 10. Floating Shadows in Dark Mode */
        html.dark .shadow-sm,
        html.dark .shadow-md,
        html.dark .shadow-lg,
        html.dark .shadow-xl,
        html.dark .shadow-2xl {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.6) !important;
        }

        /* 11. Modal Dialogs / Lightboxes */
        html.dark .modal-content,
        html.dark [role="dialog"] {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-color: #1e293b !important;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-800 flex flex-col min-h-screen transition-colors duration-300">

    {{-- HEADER (TOP BAR & STICKY NAVBAR) --}}
    @include('school.unit.partials.header')

    {{-- MAIN CONTENT VIEWPORT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER (NEWSLETTER & INSTITUTIONAL MEGA FOOTER) --}}
    @include('school.unit.partials.footer')

    {{-- FLOATING WIDGETS (SAMA PERSIS DENGAN WEB UTAMA: GTRANSLATE KIRI, ROBBANI AI KANAN) --}}
    {{-- Floating Google Translate (Kiri Bawah) --}}
    @include('components.floating-translate')

    {{-- Floating Robbani AI Assistant Widget (Kanan Bawah) --}}
    @include('components.chat-ai-widget')

    {{-- Scroll Animation & Back To Top Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-tag major sections and cards with reveal-fade-up if not already present
            document.querySelectorAll('section, article, .subpage-card, .grid > div, footer > div > div').forEach((el) => {
                if (!el.classList.contains('reveal-fade-up') && 
                    !el.closest('header') && 
                    !el.closest('nav') && 
                    !el.classList.contains('no-fade') &&
                    el.tagName !== 'HEADER' &&
                    el.tagName !== 'NAV') {
                    el.classList.add('reveal-fade-up');
                }
            });

            // Scroll Reveal Observer
            const reveals = document.querySelectorAll('.reveal-fade-up');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.05, rootMargin: '0px 0px -30px 0px' });
                reveals.forEach(el => observer.observe(el));
            } else {
                reveals.forEach(el => el.classList.add('is-revealed'));
            }

            // Fallback: reveal visible elements immediately
            setTimeout(() => {
                reveals.forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight + 50) {
                        el.classList.add('is-revealed');
                    }
                });
            }, 80);

            // Back to Top Visibility
            const backBtn = document.getElementById('backToTopBtn');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 300) {
                    backBtn.classList.remove('opacity-0', 'pointer-events-none');
                    backBtn.classList.add('opacity-100', 'pointer-events-auto');
                } else {
                    backBtn.classList.add('opacity-0', 'pointer-events-none');
                    backBtn.classList.remove('opacity-100', 'pointer-events-auto');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
