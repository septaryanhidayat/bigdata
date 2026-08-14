<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $school->name }} | Portal Resmi SIT Robbani</title>

    <link rel="icon" type="image/png" href="https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-32x32.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        robbani: {
                            dark: '#004532',
                            primary: '#065f46',
                            light: '#10b981',
                            accent: '#fd761a',
                            orange: '#f97316'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ==========================================================================
           EXECUTIVE DEEP OBSIDIAN EMERALD & ELECTRIC LEMON DARK MODE SYSTEM
           ========================================================================== */
        html.dark, html.dark body {
            background-color: #061107 !important;
            color: #f7fee7 !important;
        }

        /* 1. Eliminate Light Backgrounds in Dark Mode */
        html.dark header,
        html.dark section,
        html.dark footer,
        html.dark main,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .bg-white {
            background-color: #061107 !important;
        }

        /* 2. Pure White Logo Filter in Dark Mode (NO WHITE BACKGROUND BOX) */
        .logo-badge-container {
            background-color: #ffffff;
            padding: 0.375rem 0.625rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            display: inline-flex;
            align-items: center;
        }

        html.dark .logo-badge-container {
            background-color: transparent !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }

        html.dark img[alt*="Robbani Logo"],
        html.dark img[src*="logo-robbani"],
        html.dark img[src*="WEB-SIT-2"] {
            filter: brightness(0) invert(1) !important;
        }

        /* 3. Primary Card Surfaces: Deep Moss Emerald (#0e2010) */
        html.dark .bg-white,
        html.dark .bg-slate-50,
        html.dark .bg-slate-100,
        html.dark .card-surface {
            background-color: #0e2010 !important;
            border-color: #1a381c !important;
            color: #f7fee7 !important;
        }

        /* 4. Section Pill Badges in Dark Mode */
        html.dark .bg-emerald-100,
        html.dark .bg-orange-100,
        html.dark .bg-emerald-700,
        html.dark [class*="bg-emerald-100"],
        html.dark [class*="bg-orange-100"] {
            background-color: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
        }

        html.dark .bg-emerald-100 *,
        html.dark .bg-orange-100 *,
        html.dark .bg-emerald-700 * {
            color: #061107 !important;
        }

        /* 5. Primary Action Buttons: Electric Lemon Lime (#c6f634) with Dark Text (#061107) */
        html.dark a.bg-gradient-to-r.from-\[\#fd761a\],
        html.dark a.bg-\[\#004532\],
        html.dark a.bg-emerald-700,
        html.dark a.bg-emerald-600,
        html.dark a[href*="ppdb"] {
            background: #c6f634 !important;
            color: #061107 !important;
            border-color: #c6f634 !important;
            font-weight: 900 !important;
            box-shadow: 0 10px 25px -5px rgba(198, 246, 52, 0.4) !important;
        }

        html.dark a.bg-gradient-to-r.from-\[\#fd761a\] *,
        html.dark a.bg-\[\#004532\] *,
        html.dark a.bg-emerald-700 *,
        html.dark a.bg-emerald-600 *,
        html.dark a[href*="ppdb"] * {
            color: #061107 !important;
        }

        /* 6. Text & Heading Contrast in Dark Mode (NO DARK GREEN TEXT ON DARK GREEN BACKGROUNDS) */
        html.dark .text-slate-900,
        html.dark .text-slate-800,
        html.dark .text-slate-700 {
            color: #f7fee7 !important;
        }

        html.dark .text-slate-600,
        html.dark .text-slate-500,
        html.dark .text-slate-400 {
            color: #d9f99d !important;
        }

        html.dark .text-emerald-700,
        html.dark .text-emerald-800,
        html.dark .text-emerald-900,
        html.dark .text-emerald-600,
        html.dark .text-emerald-500,
        html.dark .text-\[\#004532\] {
            color: #c6f634 !important;
        }

        /* 7. Footer Section in Dark Mode */
        html.dark footer,
        html.dark footer.bg-slate-950,
        html.dark .bg-slate-950 {
            background-color: #040a04 !important;
            border-top: 1px solid #1a381c !important;
            color: #d9f99d !important;
        }

        /* 8. Borders across all dark containers */
        html.dark .border-slate-200,
        html.dark .border-slate-300 {
            border-color: #1a381c !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#071208] text-slate-800 dark:text-slate-100 antialiased min-h-screen flex flex-col selection:bg-orange-500 selection:text-white transition-colors duration-300">

    <!-- Top Announcement Strip -->
    <div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] text-white text-xs py-2 px-4 shadow-sm relative z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-hidden text-ellipsis whitespace-nowrap">
                <span class="bg-orange-500 text-white text-[10px] font-black uppercase px-2 py-0.5 rounded-full animate-pulse shrink-0">UNIT {{ $school->code }}</span>
                <span class="font-semibold text-[11px] sm:text-xs">🔥 {{ $school->name }} - Pendaftaran SPMB Online TA 2026/2027 Telah Dibuka!</span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-[11px] font-bold shrink-0">
                <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="hover:text-orange-300 transition-colors flex items-center gap-1">
                    <span>💬 Info PPDB WhatsApp</span>
                </a>
                <span class="text-emerald-300">•</span>
                <a href="{{ route('admin.dashboard') }}" class="hover:underline text-emerald-200">Portal Admin ➔</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between gap-4">
            
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="relative">
                    <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" alt="SIT Robbani Logo" class="h-12 w-auto object-contain group-hover:scale-105 transition-transform drop-shadow">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950 text-[#004532] dark:text-emerald-400 font-black text-[10px] tracking-wider uppercase border border-emerald-300/50">
                            UNIT {{ $school->code }}
                        </span>
                    </div>
                    <span class="font-black text-sm sm:text-base text-slate-900 dark:text-white leading-tight block group-hover:text-emerald-600 transition-colors">
                        {{ $school->name }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block">NPSN: {{ $school->npsn }} • Terakreditasi Unggul</span>
                </div>
            </a>

            <!-- Desktop Links -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-700 dark:text-slate-200">
                <a href="{{ route('home') }}" class="hover:text-[#fd761a] transition-colors">Beranda Utama</a>
                <a href="#profil" class="hover:text-[#fd761a] transition-colors">Profil Unit</a>
                <a href="#program" class="hover:text-[#fd761a] transition-colors">Program Unggulan</a>
                <a href="#kepsek" class="hover:text-[#fd761a] transition-colors">Sambutan Kepsek</a>
                <a href="#statistik" class="hover:text-[#fd761a] transition-colors">Statistik</a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Gelap/Terang" class="p-2.5 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-amber-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all shadow-sm border border-slate-200 dark:border-slate-700">
                    <span x-show="!darkMode" class="text-sm">🌙</span>
                    <span x-show="darkMode" class="text-sm">☀️</span>
                </button>

                <a href="{{ route('school.ppdb') }}" class="px-5 py-2.5 rounded-2xl bg-gradient-to-r from-[#fd761a] to-[#f97316] text-white font-black text-xs shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 hover:scale-105 transition-all flex items-center gap-2">
                    <span>Daftar SPMB</span>
                    <span>➔</span>
                </a>
            </nav>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex items-center gap-2 md:hidden">
                <button @click="darkMode = !darkMode" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-amber-300 border border-slate-200 dark:border-slate-700">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode">☀️</span>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-xl bg-emerald-600 text-white font-bold text-sm">
                    <span x-show="!mobileMenuOpen">☰</span>
                    <span x-show="mobileMenuOpen">✕</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Drawer -->
    <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 py-4 space-y-3 font-bold text-xs">
        <a href="{{ route('home') }}" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800">🏠 Beranda Utama</a>
        <a href="#profil" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800">🏫 Profil Unit</a>
        <a href="#program" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800">🌟 Program Unggulan</a>
        <a href="#kepsek" @click="mobileMenuOpen = false" class="block py-2 text-slate-800 dark:text-slate-200 border-b border-slate-100 dark:border-slate-800">👤 Sambutan Kepsek</a>
        <a href="{{ route('school.ppdb') }}" class="block py-3 text-center bg-gradient-to-r from-[#fd761a] to-[#f97316] text-white rounded-xl shadow-md">Daftar SPMB Online ➔</a>
    </div>

    <!-- Main Content Container -->
    <main class="flex-grow">
        
        <!-- Unit Hero Glassmorphism Banner -->
        <section class="relative py-12 md:py-20 px-4 sm:px-6 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative rounded-[2.5rem] p-8 md:p-12 overflow-hidden shadow-2xl bg-cover bg-center border border-white/40 dark:border-slate-800" style="background-image: linear-gradient(135deg, rgba(0, 69, 50, 0.85) 0%, rgba(15, 23, 42, 0.90) 100%), url('{{ $settings['hero_bg_image'] ?? 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png' }}');">
                    
                    <div class="relative z-10 max-w-3xl space-y-6">
                        <div class="inline-flex items-center gap-2 bg-orange-500/20 backdrop-blur-md border border-orange-400/40 px-4 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-orange-400 animate-ping"></span>
                            <span class="text-orange-300 font-black text-xs uppercase tracking-wider">PROFIL PROFIL UNIT {{ $school->code }} ROBBANI</span>
                        </div>

                        <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight drop-shadow-md">
                            {{ $school->name }}
                        </h1>

                        <p class="text-sm sm:text-base text-emerald-100 font-medium leading-relaxed drop-shadow">
                            {{ $school->description }}
                        </p>

                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="{{ route('school.ppdb') }}" class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-[#fd761a] to-[#f97316] text-white font-black text-xs sm:text-sm shadow-xl shadow-orange-500/30 hover:scale-105 transition-all flex items-center gap-2">
                                <span>Daftar SPMB Online Unit {{ $school->code }}</span>
                                <span>➔</span>
                            </a>
                            <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="px-7 py-3.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/30 text-white font-bold text-xs sm:text-sm hover:bg-white/20 transition-all flex items-center gap-2">
                                <span>💬 Hubungi Admin WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section id="statistik" class="py-6 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md text-center space-y-2">
                    <span class="text-4xl font-black bg-gradient-to-r from-[#004532] to-emerald-600 dark:from-emerald-400 dark:to-emerald-200 bg-clip-text text-transparent block">
                        {{ $school->students_count ?? 250 }}
                    </span>
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Siswa Aktif Terdaftar</span>
                </div>
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md text-center space-y-2">
                    <span class="text-4xl font-black bg-gradient-to-r from-[#fd761a] to-orange-500 bg-clip-text text-transparent block">
                        {{ $school->employees_count ?? 25 }}
                    </span>
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Guru &amp; Tenaga Pendidik</span>
                </div>
                <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md text-center space-y-2">
                    <span class="text-4xl font-black bg-gradient-to-r from-[#004532] to-emerald-600 dark:from-emerald-400 dark:to-emerald-200 bg-clip-text text-transparent block">
                        {{ $school->classrooms_count ?? 12 }}
                    </span>
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rombongan Belajar (Rombel)</span>
                </div>
            </div>
        </section>

        <!-- Profil & Sambutan Section -->
        <section id="profil" class="py-12 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <!-- Left: Profil & Visi Misi -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md space-y-4">
                        <div class="inline-block px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950 text-[#004532] dark:text-emerald-400 text-xs font-bold uppercase tracking-wider">
                            KEUNGGULAN KURIKULUM
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 dark:text-white">Profil Pembelajaran {{ $school->name }}</h2>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                            Unit {{ $school->name }} menerapkan kurikulum terintegrasi antara Kurikulum Merdeka Nasional, Kekhasan JSIT (Jaringan Sekolah Islam Terpadu), serta Program Unggulan Tahfidz Al-Qur'an dan Literasi Digital. Setiap siswa dibimbing oleh guru profesional berakhlak mulia dengan pendekatan cinta Al-Qur'an dan pembiasaan ibadah.
                        </p>
                    </div>

                    <div id="kepsek" class="p-8 rounded-3xl bg-gradient-to-br from-emerald-900 to-[#004532] text-white shadow-xl space-y-4">
                        <span class="text-xs font-black text-orange-400 uppercase tracking-wider block">SAMBUTAN KEPALA SEKOLAH</span>
                        <h3 class="text-xl font-black text-white">{{ $school->principal_name }}</h3>
                        <p class="text-xs sm:text-sm text-emerald-100 italic font-medium leading-relaxed">
                            "Selamat datang di portal resmi {{ $school->name }}. Kami berikhtiar mendidik para siswa menjadi pribadi yang beriman, hafidz Al-Qur'an, berakhlak mulia, cerdas sains, serta siap memimpin masa depan dengan landasan Islam."
                        </p>
                    </div>
                </div>

                <!-- Right: Program Unggulan -->
                <div id="program" class="lg:col-span-5 space-y-4">
                    <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-md space-y-4">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>🌟</span> <span>Program Unggulan Unit {{ $school->code }}</span>
                        </h3>
                        <div class="space-y-3">
                            @if(isset($school->programs) && is_array($school->programs))
                                @foreach($school->programs as $prog)
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 flex items-start gap-3">
                                    <span class="text-2xl p-2 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 shrink-0">{{ $prog['icon'] }}</span>
                                    <div>
                                        <h4 class="font-bold text-xs sm:text-sm text-slate-900 dark:text-white">{{ $prog['title'] }}</h4>
                                        <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">{{ $prog['desc'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- PPDB Callout Banner -->
        <section class="py-12 px-4 sm:px-6">
            <div class="max-w-7xl mx-auto rounded-3xl bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] p-8 sm:p-12 text-white shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <span class="bg-orange-500 text-white font-black text-[10px] uppercase px-3 py-1 rounded-full">SPMB ONLINE TA 2026/2027</span>
                    <h2 class="text-2xl sm:text-3xl font-black">Bergabung Bersama {{ $school->name }}</h2>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium max-w-xl">Kuota pendaftaran terbatas untuk setiap rombongan belajar. Daftarkan putra-putri Anda secara online dengan cepat dan praktis.</p>
                </div>
                <a href="{{ route('school.ppdb') }}" class="px-8 py-4 rounded-2xl bg-white text-[#004532] font-black text-xs sm:text-sm shadow-xl hover:bg-orange-100 hover:scale-105 transition-all shrink-0">
                    Daftar Sekarang ➔
                </a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-10 px-4 sm:px-6 border-t border-slate-800 mt-auto">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <p class="font-bold text-slate-300">© {{ date('Y') }} {{ $school->name }}</p>
                <p class="text-[11px] text-slate-500 mt-1">Yayasan Generasi Robbani Ogan Ilir Sumatera Selatan.</p>
            </div>
            <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-800 text-emerald-400 font-bold hover:text-emerald-300">
                ← Kembali ke Portal Utama
            </a>
        </div>
    </footer>

</body>
</html>
