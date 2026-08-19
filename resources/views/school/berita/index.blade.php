<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita &amp; Pengumuman | {{ $settings['school_name'] }}</title>
    <meta name="description" content="Informasi resmi seputar Haflah, Wisuda Tahfidz, Prestasi Siswa, dan Kegiatan Belajar Unit KB/TKIT, SDIT, SMPIT, SMAIT Robbani Ogan Ilir.">
    <meta name="keywords" content="Berita SIT Robbani, Kegiatan Sekolah Islam Ogan Ilir, TKIT SDIT SMPIT SMAIT Robbani, Berita Pendidikan Islam Indralaya">
    <link rel="canonical" href="{{ url('/berita') }}">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/berita') }}">
    <meta property="og:title" content="Portal Berita Resmi | SIT Robbani Ogan Ilir">
    <meta property="og:description" content="Kumpulan berita, liputan kegiatan, dan pengumuman resmi SIT Robbani Ogan Ilir.">
    <meta property="og:image" content="{{ asset('images/logo-robbani-official.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        theme: {
                            emerald: '#059669',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts & Alpine.js -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        [x-cloak] { display: none !important; }
    </style>

    <!-- Smooth Scroll Reveal Animation Styles -->
    <style>
        .scroll-reveal, .reveal-fade-up, .reveal-scale-up, .reveal-slide-left, .reveal-slide-right {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-scale-up { transform: scale(0.93); }
        .reveal-slide-left { transform: translateX(-35px); }
        .reveal-slide-right { transform: translateX(35px); }

        .scroll-reveal.is-visible, .reveal-fade-up.is-visible, .reveal-scale-up.is-visible,
        .reveal-slide-left.is-visible, .reveal-slide-right.is-visible, .revealed {
            opacity: 1 !important;
            transform: translateY(0) scale(1) translateX(0) !important;
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased min-h-screen flex flex-col justify-between">

    <!-- Sticky Glassmorphism Header Bar -->
    <header class="sticky top-0 z-50 transition-colors duration-300 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img x-show="!darkMode" src="{{ $settings['logo_light'] ?? '/images/logo-robbani-official.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img x-show="darkMode" x-cloak src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <div>
                    <span class="font-black text-xs block text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">PORTAL BERITA RESMI</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>

            <!-- Desktop Header Controls -->
            <div class="hidden md:flex items-center gap-2.5 text-xs font-extrabold">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">🏠 Beranda</a>
                <a href="{{ route('school.profil') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">👤 Profil</a>
                <a href="{{ route('school.layanan.kunjungan') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">📋 Layanan</a>
                <a href="{{ route('school.berita') }}" class="px-3.5 py-2 rounded-xl bg-emerald-700 text-white font-black shadow-xs">📰 Berita</a>
                <a href="{{ route('school.artikel') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">📖 Artikel</a>
                <a href="{{ route('school.fasilitas') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">🏢 Fasilitas</a>
                <a href="{{ route('school.espp') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">💳 E-SPP</a>

                <!-- Dark Mode Toggle Button (Default: Light Mode) -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Terang / Malam" class="p-2 sm:px-3 sm:py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-amber-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 font-extrabold text-xs transition-all shadow-xs flex items-center gap-1.5">
                    <span x-show="!darkMode" class="flex items-center gap-1">🌙 <span class="hidden md:inline">Mode Malam</span></span>
                    <span x-show="darkMode" x-cloak class="flex items-center gap-1">☀️ <span class="hidden md:inline">Mode Terang</span></span>
                </button>
            </div>

            <!-- Mobile Buttons (Dark Toggle & Hamburger) -->
            <div class="flex items-center gap-2 md:hidden">
                <button @click="darkMode = !darkMode" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-amber-300 border border-slate-200 dark:border-slate-700 text-xs font-bold">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode" x-cloak>☀️</span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="px-3 py-2 rounded-xl bg-emerald-700 text-white font-extrabold text-xs shadow-xs border border-emerald-600 flex items-center gap-1.5">
                    <span x-show="!mobileMenuOpen" class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        <span>Menu</span>
                    </span>
                    <span x-show="mobileMenuOpen" x-cloak class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span>Tutup</span>
                    </span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Modal Overlay -->
        <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false" class="md:hidden pt-3 pb-2 border-t border-slate-200 dark:border-slate-800 mt-3 px-4">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-4 shadow-2xl space-y-1.5">
                <a href="{{ route('home') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>🏠</span> <span>Beranda Utama</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.profil') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>👤</span> <span>Profil &amp; Sambutan</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.berita') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs bg-emerald-700 text-white shadow-md">
                    <span class="flex items-center gap-2"><span>📰</span> <span>Berita &amp; Pengumuman Kampus</span></span>
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded bg-emerald-800">Aktif</span>
                </a>
                <a href="{{ route('school.artikel') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>📖</span> <span>Artikel Edukasi Islam</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.fasilitas') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>🏢</span> <span>Fasilitas Kampus</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.espp') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>💳</span> <span>Portal E-SPP Online</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">
                    <a href="{{ route('school.ppdb') }}" class="w-full py-3 text-center rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>✨ Pendaftaran SPMB Online 2026/2027</span> ➔
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Grid with Unit Category Filter -->
    <main class="py-8 sm:py-12 max-w-7xl mx-auto px-4 sm:px-6 space-y-8 flex-1" x-data="{ activeCategory: 'all' }">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-slate-800 border border-emerald-300 dark:border-slate-700 text-emerald-800 dark:text-emerald-400 font-black text-xs uppercase shadow-xs">
                KABAR KAMPUS SIT ROBBANI
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
                Berita, Kegiatan &amp; Pengumuman
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm font-semibold">
                Informasi resmi seputar Haflah, Wisuda Tahfidz, Prestasi, dan Kegiatan Unit KB/TKIT, SDIT, SMPIT, SMAIT, & Yayasan Robbani.
            </p>

            <!-- Unit Filter Chips -->
            <div class="flex flex-wrap items-center justify-center gap-2 pt-3">
                <button @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-emerald-700 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    🌟 Semua Berita
                </button>
                <button @click="activeCategory = 'tkit'" :class="activeCategory === 'tkit' ? 'bg-amber-600 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    🎨 KB/TKIT
                </button>
                <button @click="activeCategory = 'sdit'" :class="activeCategory === 'sdit' ? 'bg-emerald-600 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    🎒 SDIT
                </button>
                <button @click="activeCategory = 'smpit'" :class="activeCategory === 'smpit' ? 'bg-blue-600 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    📘 SMPIT
                </button>
                <button @click="activeCategory = 'smait'" :class="activeCategory === 'smait' ? 'bg-purple-600 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    🎓 SMAIT
                </button>
                <button @click="activeCategory = 'yayasan'" :class="activeCategory === 'yayasan' ? 'bg-slate-800 text-white font-black shadow-md' : 'bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 font-bold hover:bg-slate-100 dark:hover:bg-slate-800'" class="px-3.5 py-1.5 rounded-full text-xs transition-all">
                    🏢 Yayasan
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($newsList as $news)
            @php
                $u = strtolower($news['unit'] ?? 'yayasan');
                $rawCat = strtolower($news['category'] ?? 'berita');
                $badgeBg = match($u) {
                    'tkit' => 'bg-amber-600 text-white',
                    'sdit' => 'bg-emerald-600 text-white',
                    'smpit' => 'bg-blue-600 text-white',
                    'smait' => 'bg-purple-600 text-white',
                    default => 'bg-slate-800 text-white'
                };
            @endphp
            <div x-show="activeCategory === 'all' || activeCategory === '{{ $u }}' || '{{ $rawCat }}'.includes(activeCategory)" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden flex flex-col justify-between group shadow-sm hover:shadow-md hover:border-emerald-500 transition-all">
                <div>
                    <div class="relative h-48 bg-slate-900 overflow-hidden">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-4 bg-white';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg {{ $badgeBg }} font-black text-[10px] uppercase shadow-sm">
                            {{ $news['category'] ?? 'Berita' }}
                        </span>
                    </div>
                    <div class="p-5 space-y-2.5">
                        <span class="text-[10px] font-bold text-slate-400 block">🗓️ {{ $news['date'] }}</span>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 dark:text-white line-clamp-2 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">
                            {{ $news['title'] }}
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 line-clamp-3 leading-relaxed font-medium">
                            {{ $news['excerpt'] }}
                        </p>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('school.berita.show', $news['slug'] ?? \Illuminate\Support\Str::slug($news['title'])) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 dark:text-emerald-400 hover:underline">
                        <span>Baca Berita Selengkapnya</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 text-xs py-8 text-center border-t border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
        </div>
    </footer>

    <!-- Robbani AI Assistant Chat Widget -->
    @include('components.chat-ai-widget')


    <!-- Universal Smooth Scroll Reveal IntersectionObserver -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -40px 0px',
                threshold: 0.05
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const selectors = '.scroll-reveal, .reveal-fade-up, .reveal-scale-up, .reveal-slide-left, .reveal-slide-right';
            document.querySelectorAll(selectors).forEach(el => revealObserver.observe(el));
        });
    </script>
</body>
</html>
