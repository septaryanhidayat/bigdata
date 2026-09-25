@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $currentHost = request()->getHost();
    $subdomains = ['tk', 'tkit', 'sd', 'sdit', 'smp', 'smpit', 'sma', 'smait', 'spmb', 'ppdb', 'tpa', 'kb'];
    $parts = explode('.', $currentHost);
    $isSubdomain = count($parts) >= 3 && in_array(strtolower($parts[0]), $subdomains);
    $unitUrl = $isSubdomain ? url('/') : url('/unit/' . $codeLower);

    // Dynamic absolute URLs guaranteeing correct redirection across all pointing subdomains
    if (str_contains($currentHost, 'sitrobbani.sch.id')) {
        $portalUrl = 'https://sitrobbani.sch.id';
        $loginUrl = 'https://sitrobbani.sch.id/login';
        $spmbUrl = 'https://spmb.sitrobbani.sch.id?unit=' . $codeLower;
        $spmbDaftarUrl = 'https://spmb.sitrobbani.sch.id/daftar?unit=' . $codeLower;
    } else {
        $portalUrl = $portalUrl ?? (config('app.url') ?: url('/'));
        $loginUrl = route('login');
        $spmbUrl = route('school.spmb') . '?unit=' . $codeLower;
        $spmbDaftarUrl = route('school.spmb.form', ['unit' => $codeLower]);
    }
@endphp

{{-- TOP MINI BAR (Kontak Telepon, Email Resmi, & Lokasi) --}}
<div class="bg-[#0f172a] text-slate-200 text-xs py-1.5 sm:py-2 border-b border-indigo-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center space-x-3 sm:space-x-6">
            <a href="tel:{{ $info['phone'] ?? '0811747472' }}" class="flex items-center text-slate-200 hover:text-amber-300 transition text-[11px] sm:text-xs font-semibold shrink-0">
                <i class="fa-solid fa-phone mr-1.5 text-amber-400"></i>
                <span>{{ $info['phone'] ?? '0811747472' }}</span>
            </a>
            <span class="text-slate-700 hidden sm:inline">|</span>
            <a href="mailto:{{ $info['email'] ?? 'info@sitrobbani.sch.id' }}" class="hidden sm:flex items-center text-slate-200 hover:text-amber-300 transition text-xs font-semibold">
                <i class="fa-solid fa-envelope mr-1.5 text-amber-400"></i>
                <span class="truncate max-w-[200px] sm:max-w-none">{{ $info['email'] ?? 'info@sitrobbani.sch.id' }}</span>
            </a>
            <span class="text-slate-700 hidden md:inline">|</span>
            <span class="hidden md:flex items-center text-slate-300 text-xs">
                <i class="fa-solid fa-location-dot mr-1.5 text-amber-400"></i>
                <span>{{ $info['city'] ?? 'Indralaya, Ogan Ilir, Sumatera Selatan' }}</span>
            </span>
        </div>
        <div class="flex items-center space-x-2 sm:space-x-3 text-[11px] sm:text-xs shrink-0">
            <a href="{{ $portalUrl }}" class="text-slate-300 hover:text-amber-300 transition flex items-center gap-1 font-semibold" title="Kunjungi Website Utama SIT Robbani">
                <i class="fa-solid fa-globe text-[11px] text-amber-400"></i>
                <span>Web Utama</span>
            </a>
            <span class="text-slate-700">|</span>
            <a href="{{ $loginUrl }}" class="text-slate-200 hover:text-amber-300 transition flex items-center gap-1 font-bold" title="Login Portal Sekolah">
                <i class="fa-solid fa-lock text-[11px] text-amber-400"></i>
                <span>Login</span>
            </a>
        </div>
    </div>
</div>

{{-- MAIN STICKY NAVBAR --}}
<header class="sticky top-0 z-50 bg-gradient-to-r {{ $uTheme['nav_gradient'] }} shadow-xl border-b border-white/10 backdrop-blur-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-20">
            
            {{-- LOGO RESMI SEKOLAH (GAMBAR ASLI TANPA TEKS BERLEBIH) --}}
            <a href="{{ $unitUrl }}" class="flex items-center group py-1.5 shrink-0" aria-label="Beranda {{ $info['name'] }}">
                <div class="h-12 sm:h-16 flex items-center py-1">
                    <img src="{{ asset($info['logo'] ?? '/images/logo-robbani-official.png') }}" 
                         alt="{{ $info['name'] }}" 
                         class="max-h-12 sm:max-h-16 w-auto object-contain transform group-hover:scale-105 transition duration-300 drop-shadow-md"
                         onerror="this.src='/images/logo-robbani-official.png'">
                </div>
            </a>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="hidden lg:flex items-center space-x-1 font-bold text-xs text-white">
                
                {{-- 1. Beranda --}}
                <a href="{{ $unitUrl }}" class="px-3 py-2 rounded-xl hover:bg-white/15 transition {{ ((request()->is('unit/' . $codeLower) || request()->path() === '/') && !request()->is('unit/' . $codeLower . '/*') && !request()->has('page')) ? 'bg-white/20 text-white shadow-inner' : '' }}">
                    Beranda
                </a>

                {{-- 2. Profil Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition {{ request()->is('*profil*', '*sambutan*', '*visi*', '*sejarah*', '*guru*', '*struktur*', '*fasilitas*', '*program*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                        <span>Profil</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    {{-- Safe Hover Bridge Container --}}
                    <div class="absolute left-0 top-full pt-1.5 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-user-tie w-5 text-unit-primary mr-2 text-sm"></i> Sambutan Kepala Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-school w-5 text-unit-primary mr-2 text-sm"></i> Profil Singkat Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-compass w-5 text-unit-primary mr-2 text-sm"></i> Visi dan Misi
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-landmark w-5 text-unit-primary mr-2 text-sm"></i> Sejarah Sekolah
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-chalkboard-user w-5 text-unit-primary mr-2 text-sm"></i> Dewan Guru &amp; GTK
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/struktur-organisasi') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-sitemap w-5 text-unit-primary mr-2 text-sm"></i> Struktur Organisasi
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/fasilitas') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-layer-group w-5 text-unit-primary mr-2 text-sm"></i> Fasilitas &amp; Sarana
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/program-unggulan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-star w-5 text-unit-primary mr-2 text-sm"></i> Program Unggulan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Kabar & Galeri Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition {{ request()->is('*artikel*', '*berita*', '*galeri*', '*video*', '*agenda*', '*pengumuman*', '*testimoni*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                        <span>Kabar &amp; Galeri</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ url('/unit/' . $codeLower . '/artikel') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-newspaper w-5 text-unit-primary mr-2 text-sm"></i> Berita &amp; Prestasi
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/galeri') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-images w-5 text-unit-primary mr-2 text-sm"></i> Galeri Foto Kegiatan
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/video') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-brands fa-youtube w-5 text-red-600 mr-2 text-sm"></i> Video Dokumentasi
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ url('/unit/' . $codeLower . '/agenda') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-calendar-days w-5 text-unit-primary mr-2 text-sm"></i> Agenda Akademik
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/pengumuman') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-bullhorn w-5 text-unit-primary mr-2 text-sm"></i> Pengumuman Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/testimoni') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-comment-dots w-5 text-unit-primary mr-2 text-sm"></i> Testimoni Wali &amp; Alumni
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. Download Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition {{ request()->is('*download*', '*e-book*', '*ebook*', '*hymne*', '*logo*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                        <span>Download</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-folder-open w-5 text-unit-primary mr-2 text-sm"></i> Semua Berkas Publik
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-book-open-reader w-5 text-unit-primary mr-2 text-sm"></i> E-Book &amp; Modul Siswa
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/hymne-mars') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-music w-5 text-unit-primary mr-2 text-sm"></i> Mars JSIT Indonesia
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/logo') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-image w-5 text-unit-primary mr-2 text-sm"></i> Logo Resmi Sekolah
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 5. Layanan Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition {{ request()->is('*layanan*', '*izin*', '*sewa*', '*kerjasama*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                        <span>Layanan</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ url('/unit/' . $codeLower . '/layanan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-handshake-angle w-5 text-unit-primary mr-2 text-sm"></i> Portal Layanan Terpadu
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-bus w-5 text-unit-primary mr-2 text-sm"></i> Izin Kunjungan Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/layanan/kerjasama') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-handshake w-5 text-unit-primary mr-2 text-sm"></i> Permohonan Kerja Sama
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/layanan/sewa') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-slate-50 hover:text-unit-primary transition flex items-center">
                                <i class="fa-solid fa-building-columns w-5 text-unit-primary mr-2 text-sm"></i> Sewa Sarana &amp; Gedung
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 6. Kontak --}}
                <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" class="px-3 py-2 rounded-xl hover:bg-white/15 transition {{ request()->is('*hubungi*', '*kontak*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                    Kontak
                </a>

                {{-- ACTION CTA: DAFTAR SPMB (Radiant Gold Pill) --}}
                <div class="pl-2">
                    <a href="{{ $spmbUrl }}" 
                       class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200">
                        <i class="fa-solid fa-graduation-cap text-sm"></i>
                        <span>Daftar SPMB</span>
                    </a>
                </div>
            </nav>

            {{-- MOBILE MENU TRIGGER BUTTON --}}
            <div class="flex items-center space-x-2 lg:hidden">
                <a href="{{ $spmbUrl }}" 
                   class="px-3.5 py-1.5 rounded-full font-black text-[11px] uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-md">
                    SPMB
                </a>
                <button type="button" 
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 rounded-xl bg-white/10 text-white hover:bg-white/20 transition focus:outline-none"
                        aria-label="Menu Navigasi Mobile">
                    <i class="fa-solid text-lg" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU DRAWER (With x-cloak & display:none to prevent reload flash) --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-slate-900/98 backdrop-blur-xl border-b border-indigo-900/80 px-4 pt-3 pb-6 space-y-2 text-sm text-white shadow-2xl max-h-[80vh] overflow-y-auto">
        
        {{-- Akses Cepat Web Utama & Login di Mobile Drawer --}}
        <div class="grid grid-cols-2 gap-2 pb-1 border-b border-slate-800">
            <a href="{{ $portalUrl }}" class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition">
                <i class="fa-solid fa-globe text-amber-400"></i>
                <span>Web Utama</span>
            </a>
            <a href="{{ $loginUrl }}" class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-emerald-600/90 hover:bg-emerald-600 text-white font-bold text-xs transition">
                <i class="fa-solid fa-lock text-amber-300"></i>
                <span>Login Portal</span>
            </a>
        </div>

        <a href="{{ $unitUrl }}" class="block px-3.5 py-2.5 rounded-xl hover:bg-white/10 font-bold {{ ((request()->is('unit/' . $codeLower) || request()->path() === '/') && !request()->is('unit/' . $codeLower . '/*')) ? 'bg-white/15' : '' }}">
            <i class="fa-solid fa-house w-6 text-amber-400"></i> Beranda
        </a>
        <div class="border-t border-slate-800 my-1 pt-1">
            <span class="block px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Profil Lembaga</span>
            <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-user-tie w-6 text-amber-300"></i> Sambutan Kepala Sekolah
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-school w-6 text-amber-300"></i> Profil Singkat
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-compass w-6 text-amber-300"></i> Visi dan Misi
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-landmark w-6 text-amber-300"></i> Sejarah Sekolah
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-chalkboard-user w-6 text-amber-300"></i> Dewan Guru &amp; GTK
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/struktur-organisasi') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-sitemap w-6 text-amber-300"></i> Struktur Organisasi
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/fasilitas') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-layer-group w-6 text-amber-300"></i> Fasilitas &amp; Sarana
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/program-unggulan') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-star w-6 text-amber-300"></i> Program Unggulan
            </a>
        </div>
        <div class="border-t border-slate-800 my-1 pt-1">
            <span class="block px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Kabar, Galeri &amp; Video</span>
            <a href="{{ url('/unit/' . $codeLower . '/artikel') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-newspaper w-6 text-amber-300"></i> Berita &amp; Prestasi
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/galeri') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-images w-6 text-amber-300"></i> Galeri Foto Kegiatan
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/video') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-brands fa-youtube w-6 text-red-400"></i> Video Dokumentasi
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/agenda') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-calendar-days w-6 text-amber-300"></i> Agenda Akademik
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/pengumuman') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-bullhorn w-6 text-amber-300"></i> Pengumuman Sekolah
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/testimoni') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-comment-dots w-6 text-amber-300"></i> Testimoni Wali &amp; Alumni
            </a>
        </div>
        <div class="border-t border-slate-800 my-1 pt-1">
            <span class="block px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Download &amp; Layanan</span>
            <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-folder-open w-6 text-amber-300"></i> Pusat Unduhan Berkas
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-book-open-reader w-6 text-amber-300"></i> E-Book &amp; Modul
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/hymne-mars') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-music w-6 text-amber-300"></i> Mars JSIT Indonesia
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/logo') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-image w-6 text-amber-300"></i> Logo Resmi Sekolah
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/layanan') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-handshake-angle w-6 text-amber-300"></i> Portal Layanan Terpadu
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-map-location-dot w-6 text-amber-400"></i> Kontak &amp; Lokasi Kampus
            </a>
        </div>
        <div class="pt-3">
            <a href="{{ $spmbDaftarUrl }}" 
               class="w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Daftar Murid Baru (SPMB Online)</span>
            </a>
        </div>
    </div>
</header>
