<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Sekolah | {{ $settings['school_name'] }}</title>
    
    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=11">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=11">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=11">
    <link rel="image_src" href="{{ asset('images/og_share_robbani.png') }}?v=11">

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="Fasilitas Lengkap &amp; Modern | SIT Robbani">
    <meta property="og:description" content="Sarana dan prasarana belajar terbaik, ruang kelas ber-AC, masjid, laboratorium komputer, kolam renang, dan area olahraga SIT Robbani.">
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

    <!-- Main Content -->
    <main class="py-8 sm:py-12 max-w-7xl mx-auto px-4 sm:px-6 space-y-8 sm:space-y-12 flex-1">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-slate-800 border border-emerald-300 dark:border-slate-700 text-emerald-800 dark:text-emerald-400 font-black text-xs uppercase shadow-xs">
                SARANA &amp; PRASARANA UNGGULAN
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
                Fasilitas Pembelajaran Modern &amp; Kondusif
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm font-semibold">
                SIT Robbani Ogan Ilir dilengkapi sarana penunjang akademik, keagamaan, olahraga, dan keamanan 24 jam.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($facilityList as $fac)
            <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-4 group">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-emerald-50 dark:bg-slate-800 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-slate-700 flex items-center justify-center text-2xl sm:text-3xl font-bold group-hover:scale-110 transition-transform">
                    {{ $fac['icon'] }}
                </div>
                <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $fac['title'] }}</h3>
                <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium">{{ $fac['desc'] }}</p>
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-bold text-emerald-700 dark:text-emerald-400 flex items-center gap-1">
                    <span>✓ Siap Digunakan Pembelajaran</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Banner Sewa Fasilitas -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-700 via-emerald-800 to-teal-900 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-lg sm:text-xl font-extrabold">Ingin Menyewa Fasilitas Sekolah Kami?</h3>
                <p class="text-xs sm:text-sm text-emerald-100 font-medium">Aula pertemuan, lapangan olahraga, dan sarana sekolah dapat disewa untuk kegiatan resmi institusi/masyarakat.</p>
            </div>
            <a href="{{ route('school.layanan.sewa') }}" class="px-6 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-emerald-950 font-black text-xs shadow-lg hover:scale-105 transition-transform whitespace-nowrap">
                Permohonan Sewa Fasilitas ➔
            </a>
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
