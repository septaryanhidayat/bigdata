<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
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
    </style>

    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-800 flex flex-col min-h-screen">

    {{-- HEADER (TOP BAR & STICKY NAVBAR) --}}
    @include('school.unit.partials.header')

    {{-- MAIN CONTENT VIEWPORT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER (NEWSLETTER & INSTITUTIONAL MEGA FOOTER) --}}
    @include('school.unit.partials.footer')

    {{-- FLOATING WIDGETS --}}
    {{-- 1. Floating WhatsApp Hotline (Kiri Bawah) --}}
    <div class="fixed bottom-6 left-6 z-40 flex items-center space-x-2">
        <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '85269908696', '0') }}&text={{ urlencode('Assalamu\'alaikum, saya ingin bertanya seputar pendaftaran siswa baru dan program ' . ($info['name'] ?? 'sekolah')) }}" 
           target="_blank" 
           rel="noopener noreferrer"
           class="flex items-center space-x-2 bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2.5 rounded-full shadow-xl hover:shadow-emerald-500/30 transform hover:-translate-y-1 transition duration-300 group">
            <i class="fa-brands fa-whatsapp text-xl"></i>
            <span class="text-xs font-bold hidden sm:inline group-hover:inline transition">Chat Panitia</span>
        </a>
    </div>

    {{-- 2. Floating Back-to-Top Button (Kanan Bawah) --}}
    <button id="backToTopBtn" 
            onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-xl ring-2 ring-amber-400/40 opacity-0 pointer-events-none transition-all duration-300 hover:scale-110 hover:bg-indigo-700"
            style="background-color: {{ $uTheme['primary'] }};"
            aria-label="Kembali ke atas">
        <i class="fa-solid fa-arrow-up text-sm"></i>
    </button>

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
