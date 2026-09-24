<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Artikel Keislaman &amp; Edukasi | {{ $settings['school_name'] }}</title>
    
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
    <main class="py-8 sm:py-12 max-w-6xl mx-auto px-4 sm:px-6 space-y-8 flex-1">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-slate-800 border border-emerald-300 dark:border-slate-700 text-emerald-800 dark:text-emerald-400 font-black text-xs uppercase shadow-xs">
                LITERASI ROBBANI
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
                Artikel Fiqih, Ibadah &amp; Parenting Islami
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm font-semibold">
                Panduan fiqih ibadah sunnah dan pembentukan karakter generasi Rabbani.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
            @foreach($articleList as $article)
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="h-48 rounded-2xl bg-slate-900 overflow-hidden">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-4 bg-white';">
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-emerald-700 text-white font-black text-[10px] uppercase inline-block shadow-xs">
                        {{ $article['category'] ?? 'Artikel' }}
                    </span>
                    <span class="text-xs text-slate-400 font-bold block">📅 {{ $article['date'] }} • {{ $article['author'] }}</span>
                    <h3 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors leading-snug">{{ $article['title'] }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium line-clamp-3">{{ $article['excerpt'] }}</p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('school.artikel.show', $article['slug']) }}" class="inline-block px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs shadow-xs transition-colors">
                        Baca Artikel Lengkap ➔
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
