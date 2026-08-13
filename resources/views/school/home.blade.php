<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] }} | Website Resmi SIT Robbani Ogan Ilir</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-32x32.png">
    <link rel="shortcut icon" href="https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-32x32.png" type="image/x-icon">

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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root, html.theme-emerald, body.theme-emerald {
            --theme-gradient-primary: linear-gradient(135deg, #059669 0%, #10b981 50%, #0d9488 100%);
            --theme-accent: #059669;
            --theme-accent-dark: #047857;
            --theme-accent-light: #ecfdf5;
            --theme-text-accent: #047857;
            --theme-hero-bg: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #0f172a 100%);
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
                    <span>SPMB 2026/2027</span>
                </span>
                <span class="truncate max-w-xl text-slate-200 hidden md:inline">{{ $settings['ppdb_status'] }}: {{ $settings['ppdb_desc'] }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-bold">
                <a href="https://api.whatsapp.com/send?phone=62811747472&text=Assalamualaikum%20saya%20mau%20bertanya%20tentang%20SIT%20Robbani%20Ogan%20Ilir" target="_blank" class="hover:text-amber-300 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>0811-7474-72</span>
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
            
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="p-1 rounded-2xl bg-white border border-slate-200 group-hover:border-emerald-500 transition-all shadow-sm">
                    <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" alt="Logo SIT Robbani" class="h-10 w-auto object-contain transition-transform group-hover:scale-105">
                </div>
                <div class="border-l border-slate-200 pl-3">
                    <span class="text-xs font-black text-slate-900 uppercase tracking-tight block leading-tight group-hover:text-emerald-700 transition-colors">YAYASAN GENERASI ROBBANI</span>
                    <span class="text-[11px] text-emerald-700 font-bold block leading-tight">SUMATERA SELATAN (SIT ROBBANI)</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="hidden lg:flex items-center gap-5 text-xs font-bold text-slate-700 whitespace-nowrap">
                <a href="{{ route('home') }}" class="hover:text-emerald-600 transition-colors">Beranda</a>
                <a href="{{ route('school.profil') }}" class="hover:text-emerald-600 transition-colors">Profil</a>
                <a href="#unit-sekolah" class="hover:text-emerald-600 transition-colors">Unit Pendidikan</a>
                <a href="{{ route('school.berita') }}" class="hover:text-emerald-600 transition-colors">Berita</a>
                <a href="{{ route('school.artikel') }}" class="hover:text-emerald-600 transition-colors">Artikel</a>
                <a href="{{ route('school.fasilitas') }}" class="hover:text-emerald-600 transition-colors">Fasilitas</a>
                <a href="{{ route('school.espp') }}" class="hover:text-emerald-600 transition-colors">E-SPP ARSI</a>
                <a href="#layanan-terpadu" class="hover:text-emerald-600 transition-colors">Layanan Terpadu</a>
            </nav>

            <div class="hidden sm:flex items-center gap-3 shrink-0">
                <a href="{{ route('school.ppdb') }}" class="px-4 py-2 rounded-xl theme-btn-primary font-extrabold text-xs shadow-md transition-all hover:scale-105">
                    Daftar PPDB ➔
                </a>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-xl text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden bg-white border-b border-slate-200 px-4 py-4 space-y-3 font-bold text-sm text-slate-700 shadow-xl">
            <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="block py-2 hover:text-emerald-600">Beranda</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.profil') }}" class="block py-2 hover:text-emerald-600">Profil Yayasan</a>
            <a @click="mobileMenuOpen = false" href="#unit-sekolah" class="block py-2 hover:text-emerald-600">Unit KB/TKIT, SDIT, SMPIT, SMAIT</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.berita') }}" class="block py-2 hover:text-emerald-600">Berita</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.artikel') }}" class="block py-2 hover:text-emerald-600">Artikel</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.fasilitas') }}" class="block py-2 hover:text-emerald-600">Fasilitas Sekolah</a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.espp') }}" class="block py-2 hover:text-emerald-600">E-SPP ARSI</a>
            <a @click="mobileMenuOpen = false" href="#layanan-terpadu" class="block py-2 hover:text-emerald-600">Layanan Terpadu</a>
            <a href="{{ route('school.ppdb') }}" class="block text-center w-full py-2.5 rounded-xl theme-btn-primary font-black text-xs">Daftar PPDB Online ➔</a>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- SECTION 3: HERO SLIDER & BANNER            -->
    <!-- ========================================== -->
    <section id="hero" class="relative overflow-hidden bg-slate-950 text-white py-16 lg:py-24">
        <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full bg-teal-500/20 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-400/30 text-emerald-300 font-extrabold text-xs tracking-wide">
                        <span>{{ $settings['hero_badge'] }}</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight tracking-tight">
                        Membentuk <span class="bg-gradient-to-r from-emerald-400 via-teal-300 to-amber-300 bg-clip-text text-transparent">Generasi Rabbani</span> Berakhlak Mulia & Berprestasi Digital
                    </h1>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl font-medium">
                        {{ $settings['hero_desc'] }}
                    </p>

                    <div class="flex flex-wrap gap-2 pt-2">
                        <span class="px-3 py-1 bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-bold rounded-lg">👶 TPA - KB Robbani</span>
                        <span class="px-3 py-1 bg-emerald-400/20 border border-emerald-400/40 text-emerald-300 text-xs font-bold rounded-lg">🎈 TKIT Robbani</span>
                        <span class="px-3 py-1 bg-teal-400/20 border border-teal-400/40 text-teal-300 text-xs font-bold rounded-lg">🎒 SDIT Robbani</span>
                        <span class="px-3 py-1 bg-sky-400/20 border border-sky-400/40 text-sky-300 text-xs font-bold rounded-lg">📚 SMPIT Robbani</span>
                        <span class="px-3 py-1 bg-purple-400/20 border border-purple-400/40 text-purple-300 text-xs font-bold rounded-lg">🎓 SMAIT Robbani</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <a href="{{ route('school.ppdb') }}" class="px-6 py-3.5 rounded-2xl theme-btn-primary font-black text-sm shadow-xl shadow-emerald-900/40 hover:scale-105 transition-all flex items-center gap-2">
                            <span>Daftar SPMB / PPDB Online</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#unit-sekolah" class="px-6 py-3.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-extrabold text-sm transition-all">
                            Jelajahi Unit Sekolah
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md rounded-3xl bg-slate-900/80 border border-slate-800 p-6 shadow-2xl backdrop-blur-xl animate-float">
                        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            </div>
                            <span class="text-[11px] font-mono text-emerald-400 font-bold uppercase">SIT Robbani Ogan Ilir</span>
                        </div>

                        <div class="pt-6 space-y-5">
                            <div class="p-4 rounded-2xl bg-slate-800/60 border border-slate-700/60 space-y-2">
                                <div class="flex items-center justify-between text-xs font-bold text-slate-300">
                                    <span>Penerimaan Siswa Baru (PPDB)</span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 text-[10px]">T.A 2026/2027</span>
                                </div>
                                <p class="text-xs text-slate-400">Pendaftaran dibuka untuk jenjang TPA, KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-4 rounded-2xl bg-emerald-950/60 border border-emerald-800/50 text-center">
                                    <span class="block text-2xl font-black text-emerald-400">4 Unit</span>
                                    <span class="text-[11px] font-bold text-slate-300">KB/TK, SD, SMP, SMA</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-teal-950/60 border border-teal-800/50 text-center">
                                    <span class="block text-2xl font-black text-teal-400">Ogan Ilir</span>
                                    <span class="text-[11px] font-bold text-slate-300">Sumatera Selatan</span>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-amber-950/40 border border-amber-800/40 flex items-center gap-3">
                                <div class="p-2.5 rounded-xl bg-amber-500/20 text-amber-300 text-xl font-bold">📲</div>
                                <div>
                                    <span class="block text-xs font-black text-amber-200">ARSI Mobile & SIM Robbani</span>
                                    <span class="text-[11px] text-amber-300/80 font-medium">Pembayaran E-SPP Realtime & Academic Portal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: SHORTCUT MENU DIGITALS          -->
    <!-- ========================================== -->
    <section class="py-8 bg-white border-b border-slate-200 shadow-sm relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                <a href="{{ route('school.profil') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">🏫</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Profil</span>
                </a>
                <a href="{{ route('school.berita') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">📰</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Berita</span>
                </a>
                <a href="{{ route('school.artikel') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">📖</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Artikel</span>
                </a>
                <a href="{{ route('school.fasilitas') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">⏰</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Fasilitas</span>
                </a>
                <a href="{{ route('school.espp') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">🧮</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">E-SPP ARSI</span>
                </a>
                <a href="{{ route('school.ppdb') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">📝</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">PPDB</span>
                </a>
                <a href="{{ route('school.layanan.kunjungan') }}" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">🚌</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Kunjungan</span>
                </a>
                <a href="https://api.whatsapp.com/send?phone=62811747472&text=Assalamualaikum%20saya%20mau%20bertanya%20tentang%20SIT%20Robbani%20Ogan%20Ilir" target="_blank" class="p-3.5 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-300 transition-all text-center group">
                    <span class="text-2xl block mb-1 group-hover:scale-110 transition-transform">✈️</span>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700 block">Kontak WA</span>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: PROFIL YAYASAN & SAMBUTAN       -->
    <!-- ========================================== -->
    <section id="profil" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-5">
                    <div class="relative p-8 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-6">
                        <div class="w-20 h-20 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-4xl shadow-inner font-black">
                            🕌
                        </div>
                        <div>
                            <span class="text-xs font-black text-emerald-700 uppercase tracking-widest block mb-1">PROFIL ORGANISASI</span>
                            <h3 class="text-2xl font-black text-slate-900">Yayasan Generasi Robbani Sumatera Selatan</h3>
                            <p class="text-xs font-bold text-slate-500 mt-1">SIT Robbani Ogan Ilir, Sumatera Selatan</p>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Yayasan Generasi Robbani Sumatera Selatan berdedikasi menyelenggarakan lembaga pendidikan Islam terpadu yang berkualitas tinggi dari usia dini hingga menengah atas. Kami memadukan Kurikulum Nasional, Kurikulum Merdeka, Kekhasan JSIT, dan Pembinaan Karakter Qur'ani.
                        </p>
                        <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-700">
                            <a href="{{ route('school.profil') }}" class="text-emerald-700 font-black hover:underline">Baca Selengkapnya ➔</a>
                            <span class="text-emerald-600">Ogan Ilir, Sumsel</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-xs">
                        <span>SAMBUTAN KETUA YAYASAN</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                        Mewujudkan Pendidikan Islam Terpadu yang Unggul, Berkarakter, dan Berorientasi Masa Depan
                    </h2>

                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        {{ $settings['principal_greeting'] }}
                    </p>

                    <div class="p-5 rounded-2xl bg-white border-l-4 border-emerald-600 shadow-sm space-y-2">
                        <p class="text-xs italic text-slate-700 font-medium">
                            "Pendidikan Rabbani adalah perpaduan ilmu, iman, dan amal. Kami berkomitmen membentuk siswa yang kokoh akidahnya, rajin ibadahnya, santun akhlaknya, serta unggul prestasinya."
                        </p>
                        <div class="pt-2">
                            <span class="block text-xs font-black text-slate-900">{{ $settings['principal_name'] }}</span>
                            <span class="text-[11px] font-bold text-emerald-700">{{ $settings['principal_title'] }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 6: SHOWCASE 4 UNIT PENDIDIKAN      -->
    <!-- ========================================== -->
    <section id="unit-sekolah" class="py-20 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">UNIT PENDIDIKAN YAYASAN</span>
                <h2 class="text-3xl font-black text-slate-900">4 Unit Pendidikan Islam Terpadu Under Yayasan</h2>
                <p class="text-slate-600 text-sm font-medium">Layanan pendidikan holistik dari jenjang Usia Dini (KB/TKIT), Dasar (SDIT), Menengah Pertama (SMPIT), hingga Menengah Atas (SMAIT) di Ogan Ilir.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 flex flex-col justify-between hover:border-amber-400 hover:shadow-xl transition-all group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                            👶
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">JENJANG PAUD & TK</span>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-amber-600 transition-colors">TPA - KB & TKIT Robbani</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Pendidikan anak usia dini dengan pembiasaan adab Islami, kemandirian motorik, hafalan juz 'Amma, doa harian, dan bermain kreatif ramah anak.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-200/80 mt-6">
                        <a href="{{ route('school.unit', 'TKIT') }}" class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs block text-center transition-colors">
                            Profil KB/TKIT Robbani ➔
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 flex flex-col justify-between hover:border-emerald-500 hover:shadow-xl transition-all group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                            🎒
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">JENJANG SEKOLAH DASAR</span>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors">SDIT Robbani</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Pendidikan dasar terpadu memadukan Kurikulum Merdeka dan Kekhasan JSIT, Tahfidz Al-Qur'an, Pramuka SIT, serta Bina Pribadi Islami.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-200/80 mt-6">
                        <a href="{{ route('school.unit', 'SDIT') }}" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs block text-center transition-colors">
                            Profil SDIT Robbani ➔
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 flex flex-col justify-between hover:border-teal-500 hover:shadow-xl transition-all group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                            📚
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-teal-700 uppercase tracking-widest">JENJANG MENENGAH PERTAMA</span>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-teal-700 transition-colors">SMPIT Robbani</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Pendidikan menengah pertama berfokus pada kepemimpinan remaja, literasi digital, penguatan Tahfidz Al-Qur'an, dan prestasi olimpiade.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-200/80 mt-6">
                        <a href="{{ route('school.unit', 'SMPIT') }}" class="w-full py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-black text-xs block text-center transition-colors">
                            Profil SMPIT Robbani ➔
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-6 flex flex-col justify-between hover:border-purple-500 hover:shadow-xl transition-all group">
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                            🎓
                        </div>
                        <div>
                            <span class="text-[10px] font-black text-purple-700 uppercase tracking-widest">JENJANG MENENGAH ATAS</span>
                            <h3 class="text-xl font-black text-slate-900 group-hover:text-purple-700 transition-colors">SMAIT Robbani</h3>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            Pendidikan menengah atas persiapan masuk Perguruan Tinggi Negeri (PTN) favorit, penguasaan Bahasa Arab & Inggris, serta kemandirian dakwah.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-200/80 mt-6">
                        <a href="{{ route('school.unit', 'SMAIT') }}" class="w-full py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs block text-center transition-colors">
                            Profil SMAIT Robbani ➔
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 7: BERITA TERBARU & ARTIKEL        -->
    <!-- ========================================== -->
    <section id="berita" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">INFORMASI TERBARU</span>
                    <h2 class="text-3xl font-black text-slate-900 mt-2">Berita, Pengumuman & Artikel Keislaman</h2>
                </div>
                <a href="{{ route('school.berita') }}" class="text-xs font-black text-emerald-700 hover:underline flex items-center gap-1">
                    Lihat Seluruh Berita Native ➔
                </a>
            </div>

            <!-- News Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($newsList as $news)
                <div class="rounded-3xl bg-white border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group">
                    <div>
                        <div class="relative h-48 bg-slate-200 overflow-hidden">
                            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full h-full object-contain p-4 bg-slate-900';">
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-black text-[10px] uppercase shadow-md">
                                {{ $news['category'] }}
                            </span>
                        </div>
                        <div class="p-5 space-y-3">
                            <span class="text-[11px] font-bold text-slate-400 block">📅 {{ $news['date'] }}</span>
                            <h3 class="text-sm font-black text-slate-900 line-clamp-2 group-hover:text-emerald-700 transition-colors leading-snug">
                                {{ $news['title'] }}
                            </h3>
                            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed font-medium">
                                {{ $news['excerpt'] }}
                            </p>
                        </div>
                    </div>
                    <div class="p-5 pt-0">
                        <a href="{{ route('school.berita.show', $news['slug'] ?? 'kepsek-smp-it-robbani-raih-peserta-terbaik-iii') }}" class="inline-flex items-center gap-1 text-xs font-black text-emerald-700 hover:underline">
                            <span>Baca Berita Selengkapnya</span>
                            <span>➔</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Article Highlight Card -->
            <div class="p-8 rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-950 text-white border border-slate-800 flex flex-col lg:flex-row items-center justify-between gap-8 shadow-2xl">
                <div class="space-y-3 max-w-2xl">
                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-xs">FEATURED ARTIKEL KEISLAMAN</span>
                    <h3 class="text-2xl font-black text-white">Tata Cara Sholat Tasbih dan Keutamaannya</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Sholat Tasbih merupakan salah satu sholat sunnah yang dianjurkan untuk dikerjakan oleh umat Islam. Sholat ini memiliki keistimewaan karena di dalamnya dipenuhi kalimat tasbih memuji keagungan Allah SWT.
                    </p>
                </div>
                <a href="{{ route('school.artikel.show', 'tata-cara-sholat-tasbih-dan-keutamaannya') }}" class="px-6 py-3.5 rounded-2xl theme-btn-primary font-black text-xs whitespace-nowrap shadow-xl hover:scale-105 transition-transform">
                    Baca Artikel Lengkap ➔
                </a>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 8: LAYANAN DIGITAL & E-SPP ARSI    -->
    <!-- ========================================== -->
    <section id="aplikasi-digital" class="py-20 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">EKOSISTEM DIGITAL ROBBANI</span>
                    <h2 class="text-3xl font-black text-slate-900 leading-tight">
                        Kemudahan Pengelolaan Tagihan & Pembayaran Siswa Secara Online dan Realtime
                    </h2>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        Melalui Portal Aplikasi <strong class="text-slate-900">ARSI (Aplikasi Robbani Student Information)</strong> dan portal <strong class="text-slate-900">SIM Robbani</strong>, wali murid dapat memantau pembayaran SPP, kehadiran, dan aktivitas akademik siswa.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <a href="{{ route('school.espp') }}" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/40 transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl group-hover:scale-110 transition-transform">💳</span>
                                <div>
                                    <h4 class="text-xs font-black text-slate-900 group-hover:text-emerald-700 transition-colors">E-SPP ARSI Mobile</h4>
                                    <span class="text-[10px] text-slate-500 font-bold block line-clamp-1">Cek Tagihan Native ➔</span>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('school.ppdb') }}" class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-emerald-500 hover:bg-emerald-50/40 transition-all group">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl group-hover:scale-110 transition-transform">📝</span>
                                <div>
                                    <h4 class="text-xs font-black text-slate-900 group-hover:text-emerald-700 transition-colors">PPDB Online</h4>
                                    <span class="text-[10px] text-slate-500 font-bold block line-clamp-1">Form SPMB Native ➔</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-6 flex justify-center">
                    <div class="relative max-w-sm rounded-3xl bg-slate-950 p-6 border-4 border-slate-800 shadow-2xl text-white space-y-5">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                            <span class="text-xs font-black tracking-widest text-emerald-400">ARSI MOBILE APP</span>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-300 font-bold">ONLINE</span>
                        </div>
                        <div class="text-center py-4 space-y-2">
                            <span class="text-4xl block">📱</span>
                            <h3 class="text-lg font-black text-white">Robbani Student Info</h3>
                            <p class="text-xs text-slate-400">Cek rincian SPP, histori transaksi, & konfirmasi otomatis</p>
                        </div>
                        <div class="space-y-2">
                            <a href="{{ route('school.espp') }}" class="w-full py-3 rounded-xl theme-btn-primary font-black text-xs block text-center shadow-lg">
                                Cek Status Tagihan E-SPP ➔
                            </a>
                            <a href="{{ route('school.ppdb') }}" class="w-full py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-extrabold text-xs block text-center">
                                Form PPDB Online Native ➔
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 9: FASILITAS SEKOLAH               -->
    <!-- ========================================== -->
    <section id="fasilitas" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">FASILITAS UNGGULAN</span>
                    <h2 class="text-3xl font-black text-slate-900 mt-2">Sarana & Prasarana Pembelajaran Kondusif</h2>
                </div>
                <a href="{{ route('school.fasilitas') }}" class="text-xs font-black text-emerald-700 hover:underline flex items-center gap-1">
                    Lihat Galeri Fasilitas Lengkap ➔
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($facilityList as $fac)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all space-y-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl font-bold group-hover:scale-110 transition-transform">
                        {{ $fac['icon'] }}
                    </div>
                    <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $fac['title'] }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $fac['desc'] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 10: TESTIMONI WALI MURID & ALUMNI  -->
    <!-- ========================================== -->
    <section id="testimoni" class="py-20 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">WALL OF TESTIMONIALS</span>
                <h2 class="text-3xl font-black text-slate-900">Apa Kata Orang Tua, Alumni & Siswa SIT Robbani?</h2>
                <p class="text-slate-600 text-sm font-medium">Kepercayaan dan kebanggaan dari wali murid dan alumni SIT Robbani Ogan Ilir, Sumatera Selatan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonialList as $testi)
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 flex flex-col justify-between hover:shadow-xl transition-all space-y-4">
                    <p class="text-xs text-slate-700 italic leading-relaxed font-medium">
                        "{{ $testi['text'] }}"
                    </p>
                    <div class="flex items-center gap-3 pt-4 border-t border-slate-200/80">
                        <img src="{{ $testi['avatar'] }}" alt="{{ $testi['name'] }}" class="w-11 h-11 rounded-full object-cover border-2 border-emerald-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-192x192.png';">
                        <div>
                            <h4 class="text-xs font-black text-slate-900 leading-tight">{{ $testi['name'] }}</h4>
                            <span class="text-[11px] font-bold text-emerald-700 block leading-tight">{{ $testi['title'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 11: LAYANAN TERPADU YAYASAN        -->
    <!-- ========================================== -->
    <section id="layanan-terpadu" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">LAYANAN TERPADU NATIVE</span>
                <h2 class="text-3xl font-black text-slate-900">Layanan & Kemitraan Interaktif Dalam Aplikasi</h2>
                <p class="text-slate-600 text-sm font-medium">Kemudahan akses permohonan kunjungan sekolah, kerjasama strategis, dan penyewaan sarana prasarana langsung di aplikasi ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 rounded-3xl bg-white border border-slate-200 text-center space-y-4 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold mx-auto group-hover:scale-110 transition-transform">
                        🚌
                    </div>
                    <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">Izin Kunjungan Sekolah</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">Form permohonan izin kunjungan studi banding atau silaturahmi ke SIT Robbani Ogan Ilir.</p>
                    <a href="{{ route('school.layanan.kunjungan') }}" class="inline-block px-5 py-2.5 rounded-xl theme-btn-primary font-black text-xs shadow-md hover:scale-105 transition-transform">
                        Form Izin Kunjungan Native ➔
                    </a>
                </div>

                <div class="p-8 rounded-3xl bg-white border border-slate-200 text-center space-y-4 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold mx-auto group-hover:scale-110 transition-transform">
                        🤝
                    </div>
                    <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">Permohonan Kerjasama</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">Layanan kemitraan dan sinergi program pendidikan, sosial, dan dakwah.</p>
                    <a href="{{ route('school.layanan.kerjasama') }}" class="inline-block px-5 py-2.5 rounded-xl theme-btn-primary font-black text-xs shadow-md hover:scale-105 transition-transform">
                        Form Kerjasama Native ➔
                    </a>
                </div>

                <div class="p-8 rounded-3xl bg-white border border-slate-200 text-center space-y-4 shadow-sm hover:shadow-xl transition-all group">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold mx-auto group-hover:scale-110 transition-transform">
                        🏢
                    </div>
                    <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 transition-colors">Permohonan Sewa Fasilitas</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium">Layanan permohonan pemanfaatan aula, fasilitas lapangan, dan sarana sekolah.</p>
                    <a href="{{ route('school.layanan.sewa') }}" class="inline-block px-5 py-2.5 rounded-xl theme-btn-primary font-black text-xs shadow-md hover:scale-105 transition-transform">
                        Form Sewa Fasilitas Native ➔
                    </a>
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 12: FOOTER                         -->
    <!-- ========================================== -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-16 border-t border-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-12">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" alt="Logo SIT Robbani" class="h-10 w-auto bg-white p-1 rounded-xl">
                        <div>
                            <span class="block font-black text-white text-sm">YAYASAN GENERASI ROBBANI</span>
                            <span class="text-[11px] text-emerald-400 font-bold">SUMATERA SELATAN</span>
                        </div>
                    </div>
                    <p class="text-slate-400 leading-relaxed font-medium max-w-sm">
                        Lembaga Pendidikan Islam Terpadu menyelenggarakan TPA/KB-TKIT Robbani, SDIT Robbani, SMPIT Robbani, dan SMAIT Robbani di Kabupaten Ogan Ilir, Sumatera Selatan.
                    </p>
                    <div class="pt-2 text-slate-300 font-bold space-y-1">
                        <p>📍 Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan</p>
                        <p>📞 WhatsApp: 0811-7474-72</p>
                        <p>✉️ Email: info@sitrobbani.sch.id</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <h4 class="font-black text-white uppercase text-xs tracking-wider">Unit Pendidikan</h4>
                    <ul class="space-y-2 font-medium">
                        <li><a href="{{ route('school.unit', 'TKIT') }}" class="hover:text-emerald-400 transition-colors">KB / TKIT Robbani</a></li>
                        <li><a href="{{ route('school.unit', 'SDIT') }}" class="hover:text-emerald-400 transition-colors">SDIT Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.unit', 'SMPIT') }}" class="hover:text-emerald-400 transition-colors">SMPIT Robbani Ogan Ilir</a></li>
                        <li><a href="{{ route('school.unit', 'SMAIT') }}" class="hover:text-emerald-400 transition-colors">SMAIT Robbani Ogan Ilir</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h4 class="font-black text-white uppercase text-xs tracking-wider">Fitur Native Aplikasi</h4>
                    <ul class="space-y-2 font-medium">
                        <li><a href="{{ route('school.berita') }}" class="hover:text-emerald-400 transition-colors">Portal Berita Native</a></li>
                        <li><a href="{{ route('school.artikel') }}" class="hover:text-emerald-400 transition-colors">Portal Artikel Native</a></li>
                        <li><a href="{{ route('school.fasilitas') }}" class="hover:text-emerald-400 transition-colors">Galeri Fasilitas Native</a></li>
                        <li><a href="{{ route('school.espp') }}" class="hover:text-emerald-400 transition-colors">Portal E-SPP ARSI</a></li>
                        <li><a href="{{ route('school.ppdb') }}" class="hover:text-emerald-400 transition-colors">Portal PPDB Online</a></li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h4 class="font-black text-white uppercase text-xs tracking-wider">Layanan Terpadu</h4>
                    <ul class="space-y-2 font-medium">
                        <li><a href="{{ route('school.layanan.kunjungan') }}" class="hover:text-emerald-400 transition-colors">Form Izin Kunjungan</a></li>
                        <li><a href="{{ route('school.layanan.kerjasama') }}" class="hover:text-emerald-400 transition-colors">Form Permohonan Kerjasama</a></li>
                        <li><a href="{{ route('school.layanan.sewa') }}" class="hover:text-emerald-400 transition-colors">Form Sewa Fasilitas</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-400 font-bold text-amber-400">Portal Login Admin ➔</a></li>
                    </ul>
                </div>

            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 font-medium text-slate-500">
                <p>© {{ date('Y') }} Yayasan Generasi Robbani Sumatera Selatan (SIT Robbani Ogan Ilir). All rights reserved.</p>
                <p>Sistem Baru Terintegrasi Mandiri</p>
            </div>

        </div>
    </footer>

</body>
</html>
