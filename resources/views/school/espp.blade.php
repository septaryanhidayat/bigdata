<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SPP &amp; Portal ARSI Mobile | {{ $settings['school_name'] }}</title>
    
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
                    <span class="font-black text-xs block text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">PORTAL E-SPP ONLINE</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>

            <!-- Desktop Header Controls -->
            <div class="hidden md:flex items-center gap-2.5 text-xs font-extrabold">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">🏠 Beranda</a>
                <a href="{{ route('school.profil') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">👤 Profil</a>
                <a href="{{ route('school.layanan.kunjungan') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">📋 Layanan</a>
                <a href="{{ route('school.berita') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">📰 Berita</a>
                <a href="{{ route('school.artikel') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">📖 Artikel</a>
                <a href="{{ route('school.fasilitas') }}" class="px-3 py-2 rounded-xl text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 transition-colors">🏢 Fasilitas</a>
                <a href="{{ route('school.espp') }}" class="px-3.5 py-2 rounded-xl bg-emerald-700 text-white font-black shadow-xs">💳 E-SPP</a>

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
                <a href="{{ route('school.berita') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>📰</span> <span>Berita Kampus</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.artikel') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>📖</span> <span>Artikel Edukasi Islam</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.fasilitas') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700">
                    <span class="flex items-center gap-2"><span>🏢</span> <span>Fasilitas Kampus</span></span>
                    <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
                </a>
                <a href="{{ route('school.espp') }}" class="group flex items-center justify-between px-4 py-3 rounded-2xl font-extrabold text-xs bg-emerald-700 text-white shadow-md">
                    <span class="flex items-center gap-2"><span>💳</span> <span>Portal E-SPP Online</span></span>
                    <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded bg-emerald-800">Aktif</span>
                </a>
                <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">
                    <a href="{{ route('school.ppdb') }}" class="w-full py-3 text-center rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-black text-xs shadow-md flex items-center justify-center gap-2">
                        <span>✨ Pendaftaran SPMB Online 2026/2027</span> ➔
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-8 sm:py-12 max-w-4xl mx-auto px-4 sm:px-6 space-y-8 flex-1">
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-slate-800 border border-emerald-300 dark:border-slate-700 text-emerald-800 dark:text-emerald-400 font-black text-xs uppercase shadow-xs">
                ROBBANI STUDENT INFORMATION
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
                Cek Tagihan &amp; Informasi SPP Realtime
            </h1>
            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm font-semibold">
                Masukkan NISN atau Nomor Induk Siswa untuk mengecek rincian tagihan SPP dan riwayat pembayaran.
            </p>
        </div>

        <form action="{{ route('school.espp') }}" method="GET" class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="nisn" value="{{ request('nisn') }}" required placeholder="Masukkan NIS / NISN Siswa..." class="flex-1 px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:border-emerald-600">
                <button type="submit" class="px-6 py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs uppercase tracking-wider shadow-sm hover:scale-105 transition-transform">
                    Cek Status SPP ➔
                </button>
            </div>
        </form>

        @if(request()->has('nisn'))
            @if($student)
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b pb-3 border-slate-200 dark:border-slate-800">
                    <div>
                        <h3 class="font-black text-base text-slate-900 dark:text-white">{{ $student->name }}</h3>
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-bold">NISN: {{ $student->nisn }} • Unit: {{ $student->school->code ?? 'SIT Robbani' }}</span>
                    </div>
                    <span class="px-3 py-1 bg-emerald-700 text-white font-black text-xs rounded-full">SISWA AKTIF</span>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-black text-emerald-700 dark:text-emerald-400 uppercase">Rincian Tagihan SPP:</h4>
                    @if($bills->count() > 0)
                        <div class="space-y-2">
                            @foreach($bills as $bill)
                            <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-slate-900 dark:text-white">{{ $bill->month }} {{ $bill->year }}</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $bill->status == 'lunas' ? 'bg-emerald-700 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $bill->status }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500 dark:text-slate-400 italic">Tidak ada rincian tagihan SPP terpisah. Seluruh pembayaran terdata lunas.</p>
                    @endif
                </div>
            </div>
            @else
            <div class="p-6 rounded-3xl bg-amber-500/10 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-xs font-bold text-center space-y-1">
                <p>Data siswa dengan NISN / NIS "{{ request('nisn') }}" tidak ditemukan.</p>
                <p class="text-[11px] font-normal text-amber-800 dark:text-amber-200">Silakan hubungi Tata Usaha atau WhatsApp Hotline 0811747472.</p>
            </div>
            @endif
        @endif

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
