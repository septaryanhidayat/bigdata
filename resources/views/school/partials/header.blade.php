<!-- TOP ANNOUNCEMENT STRIP (EMERALD & ORANGE GRADIENT - MOBILE OPTIMIZED) -->
<div class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#fd761a] dark:from-[#061107] dark:via-[#0c220f] dark:to-[#112413] text-white py-1.5 px-4 text-[10px] sm:text-xs font-semibold text-center flex items-center justify-center gap-1 sm:gap-2 shadow-inner relative z-50 border-b border-white/10 dark:border-[#1a381c]">
    <span class="truncate max-w-[80vw] sm:max-w-none">🔥 Pendaftaran SPMB Online TA 2026/2027 SIT Robbani Telah Dibuka!</span>
    <a href="{{ route('school.spmb') }}" class="underline font-extrabold text-amber-300 dark:text-[#c6f634] hover:text-amber-200 shrink-0">Daftar &rarr;</a>
</div>

<!-- TOP NAVIGATION BAR -->
<nav class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 sticky top-0 left-0 w-full z-40 h-20 shadow-sm transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex justify-between items-center">
        
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3 logo-badge-container" title="SIT Robbani Ogan Ilir">
                <img alt="SIT Robbani Logo" width="180" height="48" fetchpriority="high" class="h-10 sm:h-12 w-auto object-contain dark:hidden" src="{{ $settings['logo_light'] ?? '/images/logo-robbani-official.png' }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img alt="SIT Robbani Logo" width="180" height="48" fetchpriority="high" class="h-10 sm:h-12 w-auto object-contain hidden dark:block" src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
            </a>
        </div>

        <div class="hidden md:flex space-x-3 lg:space-x-5 items-center font-bold text-xs lg:text-sm font-sans" style="font-family: 'Inter', sans-serif;">
            @php
                $currentUrl = url()->current();
                $menus = $headerMenus ?? [
                    ['title' => 'Beranda', 'url' => route('home'), 'is_active' => true],
                    ['title' => 'Profil', 'url' => route('school.profil'), 'is_active' => true],
                    ['title' => 'Layanan', 'url' => route('school.layanan'), 'is_active' => true],
                    ['title' => 'Unit', 'url' => url('/#unit-sekolah'), 'is_active' => true],
                    ['title' => 'Berita', 'url' => route('school.berita'), 'is_active' => true],
                    ['title' => 'Artikel', 'url' => route('school.artikel'), 'is_active' => true],
                    ['title' => 'Fasilitas', 'url' => route('school.fasilitas'), 'is_active' => true],
                    ['title' => 'Galeri', 'url' => url('/#galeri-sekolah'), 'is_active' => true],
                ];
            @endphp

            @foreach($menus as $menu)
                @php
                    $mTitle = strtolower(trim($menu['title'] ?? ''));
                    if (str_contains($mTitle, 'espp') || str_contains($mTitle, 'e-spp')) continue;
                    
                    if ($mTitle === 'beranda') {
                        $mUrl = route('home');
                    } elseif ($mTitle === 'profil') {
                        $mUrl = route('school.profil');
                    } elseif ($mTitle === 'layanan') {
                        $mUrl = route('school.layanan');
                    } elseif ($mTitle === 'unit' || str_contains($mTitle, 'unit')) {
                        $mUrl = url('/#unit-sekolah');
                    } elseif ($mTitle === 'berita') {
                        $mUrl = route('school.berita');
                    } elseif ($mTitle === 'artikel') {
                        $mUrl = route('school.artikel');
                    } elseif ($mTitle === 'fasilitas' || str_contains($mTitle, 'sarana')) {
                        $mUrl = route('school.fasilitas');
                    } elseif ($mTitle === 'galeri' || str_contains($mTitle, 'galeri')) {
                        $mUrl = url('/#galeri-sekolah');
                    } else {
                        $mUrl = $menu['url'] ?? '#';
                        if (str_starts_with($mUrl, '#')) {
                            $mUrl = url('/' . $mUrl);
                        }
                    }
                    
                    $isActive = false;
                    if ($mTitle === 'beranda' && (request()->routeIs('home') || $currentUrl === route('home'))) {
                        $isActive = true;
                    } elseif ($mTitle === 'profil' && (request()->routeIs('school.profil*') || str_contains($currentUrl, '/profil'))) {
                        $isActive = true;
                    } elseif ($mTitle === 'layanan' && (request()->routeIs('school.layanan*') || str_contains($currentUrl, '/layanan'))) {
                        $isActive = true;
                    } elseif ($mTitle === 'berita' && (request()->routeIs('school.berita*') || str_contains($currentUrl, '/berita'))) {
                        $isActive = true;
                    } elseif ($mTitle === 'artikel' && (request()->routeIs('school.artikel*') || str_contains($currentUrl, '/artikel'))) {
                        $isActive = true;
                    } elseif (($mTitle === 'fasilitas' || str_contains($mTitle, 'sarana')) && (request()->routeIs('school.fasilitas*') || str_contains($currentUrl, '/fasilitas'))) {
                        $isActive = true;
                    }
                @endphp
                <a class="px-2 py-1 transition-colors {{ $isActive ? 'text-emerald-700 dark:text-[#c6f634] font-black border-b-2 border-emerald-600 dark:border-[#c6f634]' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}" href="{{ $mUrl }}">{{ $menu['title'] }}</a>
            @endforeach
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <!-- GTranslate Language Switcher (Desktop: ID, EN, AR) -->
            <div class="gtranslate_wrapper hidden sm:flex items-center"></div>

            <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="p-2 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-800 rounded-full transition-colors hidden lg:flex items-center justify-center" title="Hubungi Kami" aria-label="Hubungi Kami via WhatsApp">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;">call</span>
            </a>
            
            <button @click="darkMode = !darkMode" class="p-2 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors hidden lg:flex items-center justify-center cursor-pointer" title="Toggle Mode" aria-label="Toggle Tema Dark Mode">
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;" x-show="!darkMode">dark_mode</span>
                <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;" x-show="darkMode" x-cloak>light_mode</span>
            </button>

            <a class="hidden lg:inline-flex px-4 py-2 border border-emerald-700 text-emerald-800 dark:text-emerald-300 font-bold text-xs rounded-full hover:bg-emerald-700 hover:text-white transition-all items-center gap-1" href="{{ route('admin.dashboard') }}">
                Admin
            </a>
            <a class="px-4 sm:px-5 py-2 sm:py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-xs rounded-full transition-all flex items-center gap-1 shadow-md transform hover:scale-105" href="{{ route('school.spmb') }}">
                <span>SPMB</span> <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>

            <button @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Buka Menu Navigasi Mobile" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700">
                <span class="material-symbols-outlined" x-show="!mobileMenuOpen">menu</span>
                <span class="material-symbols-outlined" x-show="mobileMenuOpen" x-cloak>close</span>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu Drawer (INTERACTIVE WITH SELECTION INDICATORS) -->
<div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false" class="md:hidden fixed inset-x-4 top-24 z-50 bg-white/95 dark:bg-[#0c1a0e]/95 backdrop-blur-xl border border-slate-200 dark:border-[#1c401f] p-4 rounded-3xl space-y-1.5 shadow-2xl transition-all max-h-[85vh] overflow-y-auto">
    <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('home') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>🏠</span> <span>Beranda Utama</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ route('school.profil') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.profil*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>👤</span> <span>Profil Yayasan</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ route('school.layanan') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.layanan*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>📋</span> <span>Layanan Publik (3 Layanan)</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ url('/#unit-sekolah') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]">
        <span class="flex items-center gap-2"><span>🏫</span> <span>4 Unit Sekolah</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ route('school.berita') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.berita*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>📰</span> <span>Berita Kampus</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ route('school.artikel') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.artikel*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>📖</span> <span>Artikel Edukasi</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ route('school.fasilitas') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs {{ request()->routeIs('school.fasilitas*') ? 'bg-emerald-700 text-white shadow-md' : 'text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]' }}">
        <span class="flex items-center gap-2"><span>🏢</span> <span>Fasilitas Sekolah</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <a @click="mobileMenuOpen = false" href="{{ url('/#galeri-sekolah') }}" class="group flex items-center justify-between px-4 py-2.5 rounded-2xl font-extrabold text-xs text-slate-800 dark:text-slate-100 hover:bg-emerald-50 dark:hover:bg-emerald-950/80 hover:text-emerald-700 dark:hover:text-[#c6f634]">
        <span class="flex items-center gap-2"><span>🖼️</span> <span>Galeri Foto</span></span>
        <span class="text-xs transition-transform group-hover:translate-x-1 font-black">➔</span>
    </a>
    <div class="pt-2 border-t border-slate-200 dark:border-slate-800 flex flex-col gap-2">
        <!-- GTranslate Mobile Selector -->
        <div class="py-2 px-3 rounded-2xl bg-slate-50 dark:bg-[#071509] border border-slate-200 dark:border-[#1a3d1e] flex items-center justify-between">
            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 flex items-center gap-1.5">
                <span>🌐</span> <span>Bahasa / Language</span>
            </span>
            <div class="gtranslate_wrapper"></div>
        </div>

        <button @click="darkMode = !darkMode" class="w-full py-2.5 px-4 rounded-2xl bg-emerald-50 dark:bg-[#071509] text-emerald-800 dark:text-[#c6f634] font-extrabold text-xs border border-emerald-200 dark:border-[#1a3d1e] flex items-center justify-between shadow-xs cursor-pointer">
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
        <a href="{{ route('admin.dashboard') }}" class="w-full py-2 text-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-extrabold text-xs border border-slate-200 dark:border-slate-700">
            ⚙️ Portal Admin Sekolah
        </a>
    </div>
</div>

<!-- GTranslate Multi-Language Script (Indonesian, English, Arabic) & Icon Font Weight Styles -->
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 700, 'GRAD' 0, 'opsz' 24;
    }
    .material-symbols-outlined[data-weight="fill"],
    .material-symbols-fill {
        font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
    }
    /* GTranslate Native Minimalist Dropdown */
    .gtranslate_wrapper select.gt_selector {
        background-color: #f8fafc !important;
        color: #0f172a !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 9999px !important;
        padding: 4px 8px !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        cursor: pointer !important;
        outline: none !important;
        transition: all 0.2s ease !important;
        font-family: inherit !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    }
    .dark .gtranslate_wrapper select.gt_selector {
        background-color: #07170a !important;
        color: #f8fafc !important;
        border-color: #1a3d1e !important;
    }
    .gtranslate_wrapper select.gt_selector:hover {
        border-color: #059669 !important;
    }
    body { top: 0px !important; }
    .goog-te-banner-frame, .skiptranslate > iframe { display: none !important; }
</style>
<script>
    window.gtranslateSettings = {
        "default_language": "id",
        "languages": ["id", "en", "ar"],
        "wrapper_selector": ".gtranslate_wrapper",
        "flag_size": 18,
        "switcher_horizontal_position": "inline",
        "alt_flags": {"en": "usa"}
    };
</script>
<script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js" defer></script>
