<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] }} | Website Resmi SIT Robbani Ogan Ilir</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-32x32.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; transition: background-color 0.3s, color 0.3s; }
        [x-cloak] { display: none !important; }

        /* Color Scheme: Forest Green (#15803d) & Golden Orange (#f59e0b) */
        .bg-robbani-green { background-color: #15803d !important; color: #ffffff !important; }
        .bg-robbani-green:hover { background-color: #166534 !important; }

        .bg-robbani-gold { background-color: #f59e0b !important; color: #000000 !important; }
        .bg-robbani-gold:hover { background-color: #d97706 !important; color: #ffffff !important; }

        .bg-robbani-orange { background-color: #f97316 !important; color: #ffffff !important; }
        .bg-robbani-orange:hover { background-color: #ea580c !important; }
    </style>
</head>
<body :class="darkMode ? 'bg-[#061208] text-emerald-50 selection:bg-[#15803d] selection:text-white' : 'bg-[#f8fafc] text-slate-900 selection:bg-[#f59e0b] selection:text-slate-900'" class="antialiased min-h-screen pb-24 lg:pb-0">

    <!-- ========================================== -->
    <!-- 1. HEADER (CLEAN MOBILE LOGO, NO TEXT OVERLAP) -->
    <!-- ========================================== -->
    <header :class="darkMode ? 'bg-[#0a1f0f]/95 border-[#173b1d]' : 'bg-white/95 border-slate-200 shadow-md'" class="sticky top-0 z-50 backdrop-blur-xl border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            
            <!-- Logo SIT Robbani (Text Hidden on Mobile) -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div :class="darkMode ? 'bg-[#122e17] border-[#1d4724]' : 'bg-emerald-50 border-emerald-200'" class="p-2 rounded-2xl border group-hover:border-[#15803d] transition-all">
                    <img src="/images/logo-robbani-new.png" alt="Logo SIT Robbani" class="h-10 w-auto object-contain" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                </div>
                <!-- Text Hidden on Mobile to prevent squishing -->
                <div :class="darkMode ? 'border-[#1d4724]' : 'border-slate-300'" class="hidden lg:block border-l pl-3">
                    <span :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xs font-black uppercase tracking-tight block leading-tight group-hover:text-[#15803d] transition-colors">YAYASAN GENERASI ROBBANI</span>
                    <span :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-[11px] font-bold block leading-tight">SUMATERA SELATAN (SIT ROBBANI)</span>
                </div>
            </a>

            <!-- Desktop Contact, Theme Toggle & Portal Admin -->
            <div class="hidden lg:flex items-center gap-4 text-xs font-bold">
                <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="flex items-center gap-1.5 text-[#15803d] dark:text-[#4ade80] hover:underline bg-emerald-50 dark:bg-emerald-950/50 px-3 py-1.5 rounded-xl border border-emerald-200 dark:border-emerald-800">
                    <span>📞 0811-7474-72</span>
                </a>
                
                <!-- Theme Toggle Button -->
                <button @click="darkMode = !darkMode" :class="darkMode ? 'bg-white/10 text-white border-white/20' : 'bg-slate-100 text-slate-800 border-slate-300'" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl border font-bold transition-all hover:scale-105">
                    <span x-show="!darkMode">🌙 Mode Gelap</span>
                    <span x-show="darkMode" x-cloak>☀️ Mode Terang</span>
                </button>

                <!-- Portal Admin Button -->
                <a href="{{ route('admin.dashboard') }}" class="bg-robbani-green px-4 py-2 rounded-xl font-black text-xs shadow-md transition-transform hover:scale-105 flex items-center gap-1.5">
                    <span>🔑 Portal Admin</span>
                    <span>➔</span>
                </a>

                <!-- PPDB Button -->
                <a href="{{ route('school.ppdb') }}" class="bg-robbani-gold px-4 py-2 rounded-xl font-black text-xs shadow-md transition-transform hover:scale-105">
                    Daftar PPDB ➔
                </a>
            </div>

            <!-- Mobile Buttons (Clean Logo + Minimal Controls) -->
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('admin.dashboard') }}" class="bg-robbani-green px-2.5 py-1.5 rounded-xl text-xs font-black">
                    Admin
                </a>
                <button @click="darkMode = !darkMode" :class="darkMode ? 'bg-white/10 text-white' : 'bg-slate-100 text-slate-900 border-slate-300'" class="p-2 rounded-xl border text-xs">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode" x-cloak>☀️</span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" :class="darkMode ? 'bg-[#122e17] border-[#1d4724] text-slate-200' : 'bg-slate-100 border-slate-300 text-slate-900'" class="p-2 rounded-xl border">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-cloak :class="darkMode ? 'bg-[#061208] border-[#1d4724] text-slate-100' : 'bg-white border-slate-300 text-slate-900'" class="lg:hidden border-b px-4 py-4 space-y-3 font-bold text-sm shadow-2xl">
            <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-800 text-xs">
                <span>📞 Hotline: 0811-7474-72</span>
                <a href="{{ route('admin.dashboard') }}" class="text-[#15803d] dark:text-[#4ade80] font-black underline">Portal Admin ➔</a>
            </div>
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="block py-1 text-[#15803d] dark:text-[#f59e0b]">Beranda</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.profil') }}" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Profil Yayasan</a>
            <a @click="mobileMenuOpen = false" href="#unit-sekolah" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Unit Sekolah</a>
            <a @click="mobileMenuOpen = false" href="#artikel-berita" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Artikel & Berita</a>
            <a @click="mobileMenuOpen = false" href="#video-profil" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Video Profil</a>
            <a @click="mobileMenuOpen = false" href="#agenda-pengumuman" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Agenda & Pengumuman</a>
            <a @click="mobileMenuOpen = false" href="#galeri-sekolah" class="block py-1 text-slate-800 dark:text-slate-200 hover:text-[#15803d]">Galeri Sekolah</a>
            <a href="{{ route('school.ppdb') }}" class="block text-center w-full py-2.5 rounded-xl font-black text-xs bg-robbani-gold">Daftar PPDB Online ➔</a>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- SLIDER GAMBAR DI ATAS MENU UTAMA           -->
    <!-- ========================================== -->
    <section class="py-4 sm:py-6 px-4 sm:px-6 max-w-7xl mx-auto" x-data="{
        slides: [
            {
                title: 'Yayasan Generasi Robbani Sumatera Selatan',
                badge: 'SEKOLAH ISLAM TERPADU UNTUK BANGSA',
                desc: 'Mewujudkan generasi Qur\'ani, berkarakter Islami, berprestasi akademik tinggi, serta berwawasan global di Kabupaten Ogan Ilir.',
                image: '/images/logo-robbani-new.png',
                ctaText: 'Pendaftaran SPMB Online 2026',
                ctaLink: '{{ route('school.ppdb') }}',
                bgGradient: 'from-emerald-950 via-slate-900 to-slate-950'
            },
            {
                title: 'Penerimaan Peserta Didik Baru (PPDB) 2026/2027',
                badge: 'SPMB ONLINE TERPADU',
                desc: 'Bergabunglah bersama keluarga besar KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir. Kuota terbatas!',
                image: '/images/logo-robbani-new.png',
                ctaText: 'Isi Formulir SPMB Now',
                ctaLink: '{{ route('school.ppdb') }}',
                bgGradient: 'from-amber-950 via-slate-900 to-emerald-950'
            },
            {
                title: 'Layanan E-SPP Realtime & Sistem ARSI',
                badge: 'EKOSISTEM DIGITAL ROBBANI',
                desc: 'Kemudahan cek tagihan SPP, konfirmasi pembayaran, dan informasi akademik siswa secara akurat dan transparan.',
                image: '/images/logo-robbani-new.png',
                ctaText: 'Cek E-SPP Siswa',
                ctaLink: '{{ route('school.espp') }}',
                bgGradient: 'from-slate-950 via-emerald-900 to-slate-900'
            }
        ],
        activeSlide: 0,
        next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
        prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
        init() { setInterval(() => this.next(), 6000) }
    }">
        <div class="relative rounded-[2.5rem] overflow-hidden border border-slate-300 dark:border-emerald-900/60 shadow-2xl bg-slate-900 text-white min-h-[360px] sm:min-h-[400px] flex items-center">
            
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute inset-0 p-6 sm:p-10 flex items-center bg-gradient-to-r"
                     :class="slide.bgGradient">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center w-full z-10">
                        <div class="lg:col-span-8 space-y-4">
                            <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full font-black text-xs uppercase tracking-wider bg-robbani-gold shadow-md">
                                <span x-text="slide.badge"></span>
                            </span>

                            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black leading-tight text-white" x-text="slide.title"></h1>

                            <p class="text-slate-200 text-xs sm:text-sm font-medium leading-relaxed max-w-2xl" x-text="slide.desc"></p>

                            <div class="flex flex-wrap gap-3 pt-2">
                                <a :href="slide.ctaLink" class="bg-robbani-green px-6 py-3 rounded-2xl font-black text-xs shadow-lg hover:scale-105 transition-transform flex items-center gap-2">
                                    <span x-text="slide.ctaText"></span>
                                    <span>➔</span>
                                </a>
                                <a href="{{ route('school.profil') }}" class="px-6 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/30 backdrop-blur-md">
                                    Profil Yayasan ➔
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-4 hidden lg:flex justify-center">
                            <div class="bg-white/10 border border-white/20 backdrop-blur-md p-6 rounded-3xl text-center space-y-3 max-w-xs">
                                <img :src="slide.image" class="h-20 mx-auto object-contain bg-white p-2 rounded-2xl border border-white/20">
                                <span class="block text-xs font-black text-amber-300 uppercase">SIT ROBBANI OGAN ILIR</span>
                            </div>
                        </div>
                    </div>

                </div>
            </template>

            <!-- Slider Controls -->
            <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/70 hover:bg-[#15803d] text-white border border-white/30 flex items-center justify-center font-black transition-all">
                ❮
            </button>
            <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-slate-950/70 hover:bg-[#15803d] text-white border border-white/30 flex items-center justify-center font-black transition-all">
                ❯
            </button>

            <!-- Slider Dots -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            :class="activeSlide === index ? 'w-8 bg-[#f59e0b]' : 'w-2.5 bg-white/50'" 
                            class="h-2.5 rounded-full transition-all duration-300">
                    </button>
                </template>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 2. MENU UTAMA 8 ITEM                       -->
    <!-- (4 items per row on mobile, 8 in desktop)  -->
    <!-- ========================================== -->
    <section class="py-4 px-4 sm:px-6 max-w-7xl mx-auto space-y-3">
        <div class="flex items-center justify-between px-1">
            <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-base font-black">Menu Utama Portal</h3>
            <span :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-bold">8 Fitur Utama</span>
        </div>

        <div class="grid grid-cols-4 lg:grid-cols-8 gap-2.5 sm:gap-3">
            
            <a href="{{ route('school.profil') }}" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">Profil</h4>
            </a>

            <a href="#unit-sekolah" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">4 Unit</h4>
            </a>

            <a href="#artikel-berita" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">Berita</h4>
            </a>

            <a href="{{ route('school.artikel') }}" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">Artikel</h4>
            </a>

            <a href="{{ route('school.fasilitas') }}" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">Fasilitas</h4>
            </a>

            <a href="{{ route('school.espp') }}" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">E-SPP</h4>
            </a>

            <a href="{{ route('school.ppdb') }}" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">PPDB</h4>
            </a>

            <a href="#layanan-terpadu" :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] hover:bg-[#15381b]' : 'bg-white border-slate-300 hover:border-[#15803d] shadow-md'" class="p-3 rounded-2xl border transition-all space-y-1.5 group text-center flex flex-col items-center justify-center">
                <div :class="darkMode ? 'bg-[#061208] text-[#f59e0b] border-[#1d4724]' : 'bg-emerald-50 text-[#15803d] border-emerald-200'" class="w-10 h-10 rounded-xl border flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-[11px] font-black group-hover:text-[#15803d] transition-colors leading-tight">Layanan</h4>
            </a>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. SAMBUTAN KETUA YAYASAN & FOTO           -->
    <!-- 4. 2 TOMBOL AKSI SAMBUTAN & VISI MISI      -->
    <!-- ========================================== -->
    <section class="py-8 px-4 sm:px-6 max-w-7xl mx-auto">
        <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-lg'" class="p-6 sm:p-8 rounded-[2.5rem] border">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Foto Ketua Yayasan & Nama -->
                <div class="lg:col-span-4 text-center">
                    <div class="relative inline-block">
                        <img src="/images/logo-robbani-new.png" alt="Foto Ketua Yayasan" class="w-40 h-40 object-contain rounded-full bg-white p-4 border-4 border-[#15803d] shadow-xl mx-auto" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                        <span class="bg-robbani-green absolute -bottom-2 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full font-black text-[10px] uppercase shadow whitespace-nowrap">
                            KETUA YAYASAN
                        </span>
                    </div>
                    <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-base font-black mt-4 leading-tight">
                        {{ $settings['principal_name'] }}
                    </h3>
                    <span :class="darkMode ? 'text-emerald-400' : 'text-[#15803d]'" class="text-xs font-bold block mt-1">{{ $settings['principal_title'] }}</span>
                </div>

                <!-- Sambutan Singkat & 2 Tombol Aksi -->
                <div class="lg:col-span-8 space-y-4">
                    <span class="text-4xl text-[#15803d] font-serif leading-none block">“</span>
                    <p :class="darkMode ? 'text-slate-200' : 'text-slate-800'" class="text-sm sm:text-base font-bold leading-relaxed italic -mt-4">
                        {{ $settings['principal_greeting'] }}
                    </p>
                    
                    <!-- 2 Tombol Aksi Sambutan & Visi Misi -->
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="{{ route('school.profil') }}" class="bg-robbani-green px-6 py-3 rounded-xl font-black text-xs shadow-md hover:scale-105 transition-transform">
                            1. Baca Sambutan Lengkap ➔
                        </a>
                        <a href="{{ route('school.profil') }}#visi-misi" class="bg-robbani-gold px-6 py-3 rounded-xl font-black text-xs shadow-md hover:scale-105 transition-transform">
                            2. Visi & Misi Yayasan ➔
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. ARTIKEL & BERITA GRID                   -->
    <!-- ========================================== -->
    <section id="artikel-berita" class="py-8 px-4 sm:px-6 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">KABAR KAMPUS</span>
                <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-2xl sm:text-3xl font-black mt-1.5">Artikel & Berita Terbaru</h2>
            </div>
            <a href="{{ route('school.berita') }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-black hover:underline">
                Lihat Seluruh Artikel ➔
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($newsList as $news)
            <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-md'" class="rounded-3xl border overflow-hidden flex flex-col justify-between group">
                <div>
                    <div class="relative h-44 bg-slate-950 overflow-hidden">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='/images/logo-robbani-new.png'; this.className='w-full h-full object-contain p-4 bg-white';">
                        <span class="bg-robbani-green absolute top-3 left-3 px-2.5 py-1 rounded-lg font-black text-[10px] uppercase shadow-md">
                            {{ $news['category'] }}
                        </span>
                    </div>
                    <div class="p-4 space-y-2">
                        <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 block">📅 {{ $news['date'] }}</span>
                        <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-sm font-black line-clamp-2 group-hover:text-[#15803d] transition-colors leading-snug">
                            {{ $news['title'] }}
                        </h3>
                        <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-xs line-clamp-3 leading-relaxed font-medium">
                            {{ $news['excerpt'] }}
                        </p>
                    </div>
                </div>
                <div class="p-4 pt-0">
                    <a href="{{ route('school.berita.show', $news['slug'] ?? \Illuminate\Support\Str::slug($news['title'])) }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="inline-flex items-center gap-1 text-xs font-black hover:underline">
                        <span>Baca Artikel Selengkapnya</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. VIDEO PROFIL & DOKUMENTASI              -->
    <!-- ========================================== -->
    <section id="video-profil" class="py-8 px-4 sm:px-6 max-w-7xl mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-3">
            <div>
                <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">GALERI VIDEO</span>
                <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-2xl sm:text-3xl font-black mt-1.5">Video Profil & Dokumentasi Kegiatan</h2>
            </div>
            <span :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-bold">SIT Robbani Channel</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @foreach($videoList as $vid)
            <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-md'" class="rounded-3xl border overflow-hidden space-y-3 group">
                <div class="relative h-48 bg-slate-950 overflow-hidden flex items-center justify-center">
                    <img src="{{ $vid['thumbnail'] }}" alt="{{ $vid['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80">
                    <div class="absolute inset-0 bg-slate-950/40 flex items-center justify-center">
                        <div class="bg-robbani-gold w-14 h-14 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                    </div>
                    <span class="absolute bottom-3 right-3 px-2 py-0.5 rounded bg-slate-950/80 text-white font-mono text-[10px] font-bold">
                        {{ $vid['duration'] }}
                    </span>
                    <span class="bg-robbani-green absolute top-3 left-3 px-2.5 py-1 rounded-lg font-black text-[10px] uppercase">
                        {{ $vid['category'] }}
                    </span>
                </div>
                <div class="p-4 pt-0 space-y-1.5">
                    <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-sm font-black group-hover:text-[#15803d] transition-colors leading-snug">
                        {{ $vid['title'] }}
                    </h3>
                    <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-xs font-medium leading-relaxed">
                        {{ $vid['desc'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 7. PENGUMUMAN & AGENDA (SEJAJAR / 2-KOLOM) -->
    <!-- ========================================== -->
    <section id="agenda-pengumuman" class="py-8 px-4 sm:px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- LEFT COLUMN: PAPAN PENGUMUMAN RESMI -->
            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">ANNOUNCEMENT</span>
                        <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xl sm:text-2xl font-black mt-1">Papan Pengumuman</h2>
                    </div>
                    <a href="{{ route('school.berita') }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-black hover:underline">Lihat Semua ➔</a>
                </div>

                <div class="space-y-3">
                    @foreach($announcementList as $ann)
                    <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-sm'" class="p-4 sm:p-5 rounded-3xl border space-y-2 group">
                        <div class="flex items-center justify-between gap-2">
                            <span class="bg-robbani-green px-2.5 py-0.5 rounded-lg font-black text-[10px] uppercase">
                                {{ $ann['category'] }}
                            </span>
                            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">📅 {{ $ann['date'] }}</span>
                        </div>
                        <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xs sm:text-sm font-black group-hover:text-[#15803d] transition-colors leading-snug">
                            {{ $ann['title'] }}
                        </h3>
                        <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-xs font-medium leading-relaxed">
                            {{ $ann['summary'] }}
                        </p>
                        <div class="pt-1">
                            <a href="{{ $ann['link'] }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-black hover:underline inline-flex items-center gap-1">
                                <span>Detail Pengumuman</span>
                                <span>➔</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT COLUMN: AGENDA KEGIATAN -->
            <div class="space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">JADWAL & EVENT</span>
                        <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xl sm:text-2xl font-black mt-1">Agenda Kegiatan</h2>
                    </div>
                    <span :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-bold">2026/2027</span>
                </div>

                <div class="space-y-3">
                    @foreach($agendaList as $agenda)
                    <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-sm'" class="p-4 rounded-3xl border flex items-start gap-4 group hover:border-[#15803d] transition-all">
                        <div class="bg-robbani-green shrink-0 w-14 h-14 rounded-2xl flex flex-col items-center justify-center font-black shadow-sm">
                            <span class="text-lg leading-none">{{ $agenda['date_day'] }}</span>
                            <span class="text-[9px] uppercase tracking-wider leading-none mt-1">{{ $agenda['date_month'] }}</span>
                        </div>
                        <div class="space-y-1 flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <span :class="darkMode ? 'text-[#f59e0b] border-[#f59e0b]/30' : 'text-[#15803d] border-[#15803d]/30'" class="px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 font-black text-[9px] uppercase border">
                                    {{ $agenda['category'] }}
                                </span>
                                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 shrink-0">🕒 {{ $agenda['time'] }}</span>
                            </div>
                            <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xs sm:text-sm font-black group-hover:text-[#15803d] transition-colors leading-snug">
                                {{ $agenda['title'] }}
                            </h3>
                            <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-[11px] font-medium truncate">
                                📍 {{ $agenda['location'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 8. GALERI FOTO FASILITAS & KEGIATAN       -->
    <!-- ========================================== -->
    <section id="galeri-sekolah" class="py-8 px-4 sm:px-6 max-w-7xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">DOKUMENTASI FOTO</span>
                <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-2xl sm:text-3xl font-black mt-1.5">Galeri Sekolah & Sarana Prasarana</h2>
            </div>
            <a href="{{ route('school.fasilitas') }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-xs font-black hover:underline">Lihat Semua Fasilitas ➔</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
            @foreach($facilityList as $fac)
            <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-md'" class="p-4 rounded-3xl border text-center space-y-2 group hover:border-[#15803d] transition-all">
                <div class="text-3xl group-hover:scale-110 transition-transform">{{ $fac['icon'] }}</div>
                <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xs font-black line-clamp-1">{{ $fac['title'] }}</h4>
                <p :class="darkMode ? 'text-slate-400' : 'text-slate-600'" class="text-[10px] line-clamp-2 leading-snug">{{ $fac['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 9. TESTIMONI WALI MURID & ALUMNI           -->
    <!-- ========================================== -->
    <section id="testimonial-wall" class="py-8 px-4 sm:px-6 max-w-7xl mx-auto space-y-6">
        <div class="text-center max-w-3xl mx-auto space-y-2">
            <span :class="darkMode ? 'bg-[#0e2412] border-[#1d4724] text-[#f59e0b]' : 'bg-emerald-100 border-emerald-300 text-[#15803d]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase tracking-wider">WALL OF TESTIMONIALS</span>
            <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-2xl sm:text-3xl font-black">Kesan & Testimoni Orang Tua Murid</h2>
            <p :class="darkMode ? 'text-slate-400' : 'text-slate-700'" class="text-xs sm:text-sm font-medium">Kepercayaan dan apresiasi wali murid & alumni terhadap pendidikan SIT Robbani Ogan Ilir.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($testimonialList as $testi)
            <div :class="darkMode ? 'bg-[#0e2412] border-[#1d4724]' : 'bg-white border-slate-300 shadow-md'" class="p-5 rounded-3xl border flex flex-col justify-between space-y-4 hover:shadow-xl transition-all">
                <p :class="darkMode ? 'text-slate-200' : 'text-slate-800'" class="text-xs italic leading-relaxed font-bold">
                    "{{ $testi['text'] }}"
                </p>
                <div :class="darkMode ? 'border-[#1d4724]' : 'border-slate-200'" class="flex items-center gap-3 pt-3 border-t">
                    <img src="{{ $testi['avatar'] }}" alt="{{ $testi['name'] }}" class="w-10 h-10 rounded-full object-cover border-2 border-[#15803d]" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-192x192.png';">
                    <div>
                        <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xs font-black leading-tight">{{ $testi['name'] }}</h4>
                        <span :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="text-[11px] font-bold block leading-tight">{{ $testi['title'] }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FLOATING MOBILE BOTTOM NAVIGATION BAR      -->
    <!-- ========================================== -->
    <div :class="darkMode ? 'bg-[#061208]/95 border-[#1d4724]' : 'bg-white/95 border-slate-300 shadow-2xl'" class="lg:hidden fixed bottom-0 left-0 right-0 z-50 backdrop-blur-xl border-t px-4 py-2">
        <div class="max-w-md mx-auto flex items-center justify-between relative">
            
            <a href="{{ route('home') }}" :class="darkMode ? 'text-[#f59e0b]' : 'text-[#15803d]'" class="flex flex-col items-center gap-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span class="text-[10px] font-bold">Home</span>
            </a>

            <a href="{{ route('school.profil') }}" :class="darkMode ? 'text-slate-400' : 'text-slate-700'" class="flex flex-col items-center gap-1 hover:text-[#15803d]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="text-[10px] font-bold">Profil</span>
            </a>

            <!-- Raised Center Action Button (PPDB) -->
            <div class="-mt-6">
                <a href="{{ route('school.ppdb') }}" class="bg-robbani-gold w-14 h-14 rounded-full shadow-lg flex items-center justify-center border-4 border-white dark:border-slate-900 hover:scale-110 transition-transform">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </a>
            </div>

            <a href="{{ route('school.berita') }}" :class="darkMode ? 'text-slate-400' : 'text-slate-700'" class="flex flex-col items-center gap-1 hover:text-[#15803d]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                <span class="text-[10px] font-bold">Berita</span>
            </a>

            <a href="{{ route('school.espp') }}" :class="darkMode ? 'text-slate-400' : 'text-slate-700'" class="flex flex-col items-center gap-1 hover:text-[#15803d]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="text-[10px] font-bold">E-SPP</span>
            </a>

        </div>
    </div>

    <!-- ========================================== -->
    <!-- 10. FOOTER WITH BRANDING CREDIT            -->
    <!-- ========================================== -->
    <footer :class="darkMode ? 'bg-[#040d06] border-[#1d4724] text-slate-400' : 'bg-slate-950 border-slate-800 text-slate-200'" class="text-xs py-10 border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6 text-center">
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-6 border-b border-white/10">
                <div class="flex items-center gap-3 text-left">
                    <img src="/images/logo-robbani-new.png" class="h-10 p-1 bg-white rounded-xl" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                    <div>
                        <span class="font-black text-xs block text-white">YAYASAN GENERASI ROBBANI</span>
                        <span class="text-[10px] text-amber-400 font-bold block">SUMATERA SELATAN (SIT ROBBANI)</span>
                    </div>
                </div>
                <div class="flex items-center gap-4 font-bold text-xs">
                    <a href="{{ route('home') }}" class="hover:text-[#15803d]">Beranda</a>
                    <a href="{{ route('school.profil') }}" class="hover:text-[#15803d]">Profil</a>
                    <a href="{{ route('school.ppdb') }}" class="hover:text-[#15803d]">PPDB Online</a>
                    <a href="{{ route('school.espp') }}" class="hover:text-[#15803d]">E-SPP</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-emerald-400 hover:underline">Portal Admin</a>
                </div>
            </div>

            <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
            
            <div class="pt-3 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 font-bold text-xs">
                <span class="text-emerald-400">SIT Robbani Smart Educational System</span>
                <a href="https://berandadigital.net" target="_blank" class="text-amber-400 hover:underline flex items-center justify-center gap-1">
                    <span>Powered by Beranda Teknologi Digital</span>
                    <span>➔</span>
                </a>
            </div>

        </div>
    </footer>

</body>
</html>
