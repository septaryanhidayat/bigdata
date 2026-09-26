<!-- TOP ANNOUNCEMENT (DESKTOP ONLY, TIDAK MENGGANGGU MOBILE) -->
<div class="hidden sm:block bg-gradient-to-r from-[#004532] via-[#065f46] to-[#043324] dark:from-[#061107] dark:via-[#0c220f] dark:to-[#112413] text-white py-1.5 px-3 sm:px-4 text-[10px] sm:text-xs font-semibold shadow-inner relative z-50 border-b border-white/10 dark:border-[#1a381c]">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
        <div class="flex items-center gap-2 text-emerald-100">
            <span>🔥 SPMB Online 2026/2027 Telah Dibuka Resmi!</span>
            <a href="{{ route('school.spmb') }}" class="underline font-black text-amber-300 dark:text-[#c6f634] hover:text-amber-200">Daftar Sekarang &rarr;</a>
        </div>
        <div class="flex items-center gap-3 text-xs">
            <a href="https://wa.me/62811747472" target="_blank" class="text-emerald-200 hover:text-white transition flex items-center gap-1 font-bold">
                <span>💬 Hotline: 0811-747-472</span>
            </a>
        </div>
    </div>
</div>

<!-- TOP NAVIGATION BAR -->
<nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 sticky top-0 left-0 w-full z-40 h-16 sm:h-20 shadow-xs transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex justify-between items-center">
        
        <!-- Logo Saja di Kiri Atas (Tanpa Teks di Sampingnya - Proporsi Rapi & Tidak Terlalu Besar) -->
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center shrink-0" title="SIT Robbani Ogan Ilir">
                <img alt="SIT Robbani Logo" width="150" height="38" fetchpriority="high" class="h-7.5 sm:h-9 max-h-9 w-auto object-contain dark:hidden" src="{{ $settings['logo_light'] ?? '/images/logo-robbani-official.png' }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img alt="SIT Robbani Logo" width="150" height="38" fetchpriority="high" class="h-7.5 sm:h-9 max-h-9 w-auto object-contain hidden dark:block" src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
            </a>
        </div>

        <!-- Desktop Menu Navigasi Lengkap & Rapi -->
        <div class="hidden md:flex space-x-1 lg:space-x-3 items-center font-bold text-xs lg:text-sm font-sans" style="font-family: 'Inter', sans-serif;">
            @php
                $currentUrl = url()->current();
            @endphp

            <!-- Beranda -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('home') || $currentUrl === route('home') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('home') }}">
                Beranda
            </a>

            <!-- Profil -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('school.profil*') || str_contains($currentUrl, '/profil') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('school.profil') }}">
                Profil
            </a>

            <!-- Dropdown Unit Sekolah -->
            <div class="relative" x-data="{ unitOpen: false }" @mouseenter="unitOpen = true" @mouseleave="unitOpen = false">
                <button @click="unitOpen = !unitOpen" class="px-2.5 py-1.5 rounded-lg transition-colors flex items-center gap-1 font-bold {{ request()->routeIs('school.unit*') || str_contains($currentUrl, '/unit/') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
                    <span>Unit Sekolah</span>
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="unitOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="unitOpen" x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-1"
                     class="absolute top-full left-0 mt-1 w-60 rounded-2xl bg-white dark:bg-slate-900 shadow-2xl border border-slate-200 dark:border-slate-800 p-2 z-50">
                    <a href="{{ route('school.unit', 'tkit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-colors">
                        <span class="text-base shrink-0">🎓</span>
                        <div>
                            <span class="block font-bold">KB / TKIT Robbani</span>
                            <span class="text-[10px] text-slate-400 font-normal">Pendidikan Anak Usia Dini</span>
                        </div>
                    </a>
                    <a href="{{ route('school.unit', 'sdit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-colors">
                        <span class="text-base shrink-0">🏫</span>
                        <div>
                            <span class="block font-bold">SDIT Robbani</span>
                            <span class="text-[10px] text-slate-400 font-normal">Sekolah Dasar Islam Terpadu</span>
                        </div>
                    </a>
                    <a href="{{ route('school.unit', 'smpit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-colors">
                        <span class="text-base shrink-0">🎒</span>
                        <div>
                            <span class="block font-bold">SMPIT Robbani</span>
                            <span class="text-[10px] text-slate-400 font-normal">Sekolah Menengah Pertama</span>
                        </div>
                    </a>
                    <a href="{{ route('school.unit', 'smait') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-800 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-colors">
                        <span class="text-base shrink-0">🏛️</span>
                        <div>
                            <span class="block font-bold">SMAIT Robbani</span>
                            <span class="text-[10px] text-slate-400 font-normal">Sekolah Menengah Atas</span>
                        </div>
                    </a>
                    <div class="border-t border-slate-100 dark:border-slate-800 mt-1 pt-1.5">
                        <a href="{{ url('/#unit-sekolah') }}" class="flex items-center justify-between px-3 py-1.5 rounded-lg text-[11px] font-semibold text-emerald-700 dark:text-[#c6f634] hover:bg-emerald-50 dark:hover:bg-slate-800 transition-colors">
                            <span>Lihat Semua Unit di Beranda</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Layanan -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('school.layanan*') || str_contains($currentUrl, '/layanan') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('school.layanan') }}">
                Layanan
            </a>

            <!-- Fasilitas -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('school.fasilitas*') || str_contains($currentUrl, '/fasilitas') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('school.fasilitas') }}">
                Fasilitas
            </a>

            <!-- Berita -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('school.berita*') || str_contains($currentUrl, '/berita') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('school.berita') }}">
                Berita
            </a>

            <!-- Artikel -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors {{ request()->routeIs('school.artikel*') || str_contains($currentUrl, '/artikel') ? 'text-emerald-700 dark:text-[#c6f634] font-black bg-emerald-50 dark:bg-emerald-950/40' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ route('school.artikel') }}">
                Artikel
            </a>

            <!-- Galeri -->
            <a class="px-2.5 py-1.5 rounded-lg transition-colors text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]" href="{{ url('/#galeri-sekolah') }}">
                Galeri
            </a>
        </div>

        <!-- Tombol Aksi Kanan (Bersih, Rapi & Elegan - Tanpa Icon Mismatch) -->
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Portal Admin / Guru Button -->
            <a class="hidden lg:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:text-emerald-700 dark:hover:text-[#c6f634] hover:border-emerald-600 dark:hover:border-[#c6f634] hover:bg-slate-50 dark:hover:bg-slate-800 font-bold text-xs transition-all shadow-xs" href="{{ route('admin.dashboard') }}" title="Portal Guru & Administrasi SIT Robbani">
                <span class="material-symbols-outlined text-[16px] text-emerald-600 dark:text-[#c6f634]">lock</span>
                <span>Portal Login</span>
            </a>

            <!-- SPMB Online Button (Glowing CTA) -->
            <a class="px-4 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-black text-xs rounded-full transition-all flex items-center gap-1.5 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 whitespace-nowrap" href="{{ route('school.spmb') }}">
                <span>SPMB Online</span>
                <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
            </a>

            <!-- Hamburger Button (Mobile Only) -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka Menu Navigasi Mobile" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                <span class="material-symbols-outlined" x-show="mobileMenuOpen" x-cloak>close</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu Drawer (RESPONSIF, LENGKAP & RAPI DENGAN ACCORDION UNIT) -->
<div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false" class="md:hidden fixed inset-x-4 top-20 z-50 bg-white/98 dark:bg-[#0c1a0e]/98 backdrop-blur-xl border border-slate-200 dark:border-[#1c401f] p-4 rounded-3xl space-y-1 shadow-2xl transition-all max-h-[85vh] overflow-y-auto" x-data="{ mobileUnitOpen: false }">
    <!-- Mobile Tagline Ribbon -->
    <div class="p-2.5 rounded-2xl bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-950 text-center text-white border border-emerald-800/60 shadow-inner mb-2">
        <span class="text-[9px] font-black uppercase text-amber-400 tracking-wider block">TAGLINE RESMI SEKOLAH</span>
        <div class="text-[11px] font-black tracking-wide mt-0.5 text-white flex items-center justify-center gap-1.5">
            <span class="text-amber-300">⚡ MANDIRI</span> • <span class="text-emerald-300">📖 PINTER NGAJI</span> • <span class="text-cyan-300">💻 JAGO IT!</span>
        </div>
    </div>

    <!-- Beranda -->
    <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('home') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>🏠</span> <span>Beranda Utama</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Profil -->
    <a @click="mobileMenuOpen = false" href="{{ route('school.profil') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.profil*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>👤</span> <span>Profil Yayasan</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Unit Sekolah Accordion -->
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 overflow-hidden">
        <button @click="mobileUnitOpen = !mobileUnitOpen" class="w-full flex items-center justify-between px-3.5 py-2.5 font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 transition-colors">
            <span class="flex items-center gap-2.5"><span>🏫</span> <span>4 Unit Pendidikan</span></span>
            <span class="text-xs transition-transform font-black" :class="mobileUnitOpen ? 'rotate-90' : ''">▼</span>
        </button>
        <div x-show="mobileUnitOpen" x-cloak class="bg-slate-50/80 dark:bg-slate-900/60 p-2 space-y-1 border-t border-slate-200 dark:border-slate-800">
            <a @click="mobileMenuOpen = false" href="{{ route('school.unit', 'tkit') }}" class="flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]">
                <span>🎓 KB / TKIT Robbani</span>
                <span class="text-[10px] text-slate-400">PAUD</span>
            </a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.unit', 'sdit') }}" class="flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]">
                <span>🏫 SDIT Robbani</span>
                <span class="text-[10px] text-slate-400">SD</span>
            </a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.unit', 'smpit') }}" class="flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]">
                <span>🎒 SMPIT Robbani</span>
                <span class="text-[10px] text-slate-400">SMP</span>
            </a>
            <a @click="mobileMenuOpen = false" href="{{ route('school.unit', 'smait') }}" class="flex items-center justify-between px-3 py-1.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]">
                <span>🏛️ SMAIT Robbani</span>
                <span class="text-[10px] text-slate-400">SMA</span>
            </a>
        </div>
    </div>

    <!-- Layanan -->
    <a @click="mobileMenuOpen = false" href="{{ route('school.layanan') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.layanan*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>📋</span> <span>Layanan Publik Terpadu</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Fasilitas -->
    <a @click="mobileMenuOpen = false" href="{{ route('school.fasilitas') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.fasilitas*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>🏢</span> <span>Fasilitas Sekolah</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Berita -->
    <a @click="mobileMenuOpen = false" href="{{ route('school.berita') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.berita*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>📰</span> <span>Berita Kampus</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Artikel -->
    <a @click="mobileMenuOpen = false" href="{{ route('school.artikel') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.artikel*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2.5"><span>📖</span> <span>Artikel Edukasi</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Galeri -->
    <a @click="mobileMenuOpen = false" href="{{ url('/#galeri-sekolah') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]">
        <span class="flex items-center gap-2.5"><span>🖼️</span> <span>Galeri Dokumentasi</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>

    <!-- Bottom Actions inside Drawer -->
    <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">
        <button @click="darkMode = !darkMode" class="w-full py-2.5 px-4 rounded-2xl bg-slate-100 dark:bg-[#071509] text-slate-800 dark:text-[#c6f634] font-extrabold text-xs border border-slate-200 dark:border-[#1a3d1e] flex items-center justify-between shadow-xs cursor-pointer">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'opsz' 24;" x-show="!darkMode">dark_mode</span>
                <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'opsz' 24;" x-show="darkMode" x-cloak>light_mode</span>
                <span x-text="darkMode ? '☀️ Mode Terang' : '🌙 Mode Gelap'"></span>
            </span>
            <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-emerald-200/60 dark:bg-[#c6f634]/20" x-text="darkMode ? 'DARK' : 'LIGHT'"></span>
        </button>
        <a href="{{ route('school.spmb') }}" class="w-full py-3 text-center rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-black text-xs shadow-md flex items-center justify-center gap-2">
            <span>✨ Pendaftaran SPMB Online</span> ➔
        </a>
        <a href="{{ route('admin.dashboard') }}" class="w-full py-2.5 text-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-extrabold text-xs border border-slate-200 dark:border-slate-700 flex items-center justify-center gap-1.5">
            <span class="material-symbols-outlined text-[16px] text-emerald-600">lock</span>
            <span>Portal Login Guru & Admin</span>
        </a>
    </div>
</div>

<!-- Icon Font Weight Styles -->
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 700, 'GRAD' 0, 'opsz' 24;
    }
    .material-symbols-outlined[data-weight="fill"],
    .material-symbols-fill {
        font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
    }
</style>

