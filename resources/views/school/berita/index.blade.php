<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita &amp; Pengumuman | {{ $settings['school_name'] }}</title>
    <meta name="description" content="Informasi resmi seputar Haflah, Wisuda Tahfidz, Prestasi Siswa, dan Kegiatan Belajar Unit KB/TKIT, SDIT, SMPIT, SMAIT Robbani Ogan Ilir.">
    <meta name="keywords" content="Berita SIT Robbani, Kegiatan Sekolah Islam Ogan Ilir, TKIT SDIT SMPIT SMAIT Robbani, Berita Pendidikan Islam Indralaya">
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=11">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=11">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=11">
    <link rel="image_src" href="{{ asset('images/og_share_robbani.png') }}?v=11">

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/berita') }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="Portal Berita Resmi | SIT Robbani Ogan Ilir">
    <meta property="og:description" content="Kumpulan berita, liputan kegiatan, dan pengumuman resmi SIT Robbani Ogan Ilir (KB/TKIT, SDIT, SMPIT, SMAIT).">
    <meta property="og:image" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:secure_url" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">
    
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
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                        headline: ["Montserrat", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts & Alpine.js -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@700;800;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .font-headline { font-family: 'Montserrat', sans-serif; }
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

    @include('school.partials.header')

    <!-- Main Content Grid with Unit Category Filter -->
    <main class="py-8 sm:py-12 max-w-7xl mx-auto px-4 sm:px-6 space-y-8 flex-1" x-data="{ activeCategory: '{{ $activeCategory ?? 'all' }}' }">
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
                            {{ $news['excerpt'] ?? $news['summary'] ?? '' }}
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

    @include('school.partials.footer')

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
