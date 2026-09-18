@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $unitUrl = url('/unit/' . $codeLower);
@endphp

{{-- TOP MINI BAR (Kontak Telepon, Email Resmi, & Lokasi) --}}
<div class="bg-[#0f172a] text-slate-200 text-xs py-2 border-b border-indigo-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <div class="flex items-center space-x-4 sm:space-x-6">
            <a href="tel:{{ $info['phone'] ?? '0852-6990-8696' }}" class="flex items-center text-slate-200 hover:text-amber-300 transition text-xs font-semibold">
                <i class="fa-solid fa-phone mr-1.5 text-amber-400"></i>
                <span>{{ $info['phone'] ?? '0852-6990-8696' }}</span>
            </a>
            <span class="text-slate-700 hidden sm:inline">|</span>
            <a href="mailto:{{ $info['email'] ?? 'smpitishlahulummah.2015@yahoo.com' }}" class="flex items-center text-slate-200 hover:text-amber-300 transition text-xs font-semibold">
                <i class="fa-solid fa-envelope mr-1.5 text-amber-400"></i>
                <span class="truncate max-w-[200px] sm:max-w-none">{{ $info['email'] ?? 'smpitishlahulummah.2015@yahoo.com' }}</span>
            </a>
            <span class="text-slate-700 hidden md:inline">|</span>
            <span class="hidden md:flex items-center text-slate-300 text-xs">
                <i class="fa-solid fa-location-dot mr-1.5 text-amber-400"></i>
                <span>{{ $info['city'] ?? ($codeLower === 'smpit' ? 'Prabumulih Timur, Sumatera Selatan' : 'Indralaya, Ogan Ilir, Sumatera Selatan') }}</span>
            </span>
        </div>
        <div class="flex items-center space-x-3 text-xs">
            <a href="{{ $portalUrl ?? route('home') }}" class="text-slate-300 hover:text-amber-300 transition flex items-center gap-1 font-medium">
                <i class="fa-solid fa-globe text-[11px] text-amber-400"></i>
                <span class="hidden sm:inline">Portal Utama</span>
            </a>
            <span class="text-slate-700">|</span>
            <a href="{{ route('login') }}" class="text-slate-200 hover:text-amber-300 transition flex items-center gap-1 font-semibold">
                <i class="fa-solid fa-lock text-[11px] text-amber-400"></i>
                <span>Login</span>
            </a>
        </div>
    </div>
</div>

{{-- MAIN STICKY NAVBAR --}}
<header class="sticky top-0 z-50 bg-gradient-to-r {{ $uTheme['nav_gradient'] }} shadow-xl border-b border-white/10 backdrop-blur-md transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- LOGO & IDENTITAS SEKOLAH --}}
            <a href="{{ $unitUrl }}" class="flex items-center space-x-3 group flex-shrink-0">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white p-1.5 flex items-center justify-center shadow-lg transform group-hover:scale-105 transition duration-300 border border-white/20">
                    <img src="{{ asset($info['logo'] ?? '/uploads/logo-ishum-square.png') }}" 
                         alt="{{ $info['name'] }}" 
                         class="max-h-full max-w-full object-contain"
                         onerror="this.src='/uploads/logo-ishum-square.png'">
                </div>
                <div class="text-left">
                    <span class="block text-[10px] sm:text-[11px] font-extrabold uppercase tracking-wider text-amber-300">
                        {{ $codeLower === 'tkit' ? 'Taman Kanak-Kanak Islam Terpadu' : ($codeLower === 'sdit' ? 'Sekolah Dasar Islam Terpadu' : ($codeLower === 'smpit' ? 'Sekolah Menengah Pertama Islam Terpadu' : 'Sekolah Menengah Atas Islam Terpadu')) }}
                    </span>
                    <span class="block text-base sm:text-lg font-black tracking-tight text-white leading-tight drop-shadow-sm">
                        {{ $info['name'] }}
                    </span>
                    <span class="inline-block text-[9px] sm:text-[10px] font-bold text-slate-200 uppercase tracking-widest">
                        {{ $info['sub_badge'] ?? ($info['akreditasi'] ?? 'Terakreditasi B') }}
                    </span>
                </div>
            </a>

            {{-- DESKTOP NAVIGATION --}}
            <nav class="hidden lg:flex items-center space-x-1 font-bold text-xs text-white">
                
                {{-- 1. Beranda --}}
                <a href="{{ $unitUrl }}" class="px-3 py-2 rounded-xl hover:bg-white/15 transition {{ request()->is('unit/' . $codeLower) && !request()->is('unit/' . $codeLower . '/*') && !request()->has('page') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                    Beranda
                </a>

                {{-- 2. Profil Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition {{ request()->is('*profil*', '*sambutan*', '*visi*', '*sejarah*') ? 'bg-white/20 text-white shadow-inner' : '' }}">
                        <span>Profil</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    {{-- Safe Hover Bridge Container --}}
                    <div class="absolute left-0 top-full pt-1.5 w-64 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-user-tie w-5 text-indigo-600 mr-2 text-sm"></i> Sambutan Kepala Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-school w-5 text-indigo-600 mr-2 text-sm"></i> Profil Singkat Sekolah
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-compass w-5 text-indigo-600 mr-2 text-sm"></i> Visi dan Misi
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-landmark w-5 text-indigo-600 mr-2 text-sm"></i> Sejarah Sekolah
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ $unitUrl }}#guru" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-chalkboard-user w-5 text-indigo-600 mr-2 text-sm"></i> Dewan Guru &amp; GTK
                            </a>
                            <a href="{{ $unitUrl }}#fasilitas" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-layer-group w-5 text-indigo-600 mr-2 text-sm"></i> Fasilitas &amp; Sarana
                            </a>
                            <a href="{{ $unitUrl }}#program" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-star w-5 text-indigo-600 mr-2 text-sm"></i> Program Unggulan
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 3. Kabar & Galeri Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition">
                        <span>Kabar &amp; Galeri</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ $unitUrl }}#berita" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-newspaper w-5 text-indigo-600 mr-2 text-sm"></i> Berita &amp; Prestasi
                            </a>
                            <a href="{{ $unitUrl }}#galeri" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-images w-5 text-indigo-600 mr-2 text-sm"></i> Galeri Foto Kegiatan
                            </a>
                            <a href="{{ $unitUrl }}#video" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-brands fa-youtube w-5 text-red-600 mr-2 text-sm"></i> Video Dokumentasi
                            </a>
                            <a href="{{ $unitUrl }}#agenda" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-calendar-days w-5 text-indigo-600 mr-2 text-sm"></i> Agenda Akademik
                            </a>
                            <a href="{{ $unitUrl }}#testimoni" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-comment-dots w-5 text-indigo-600 mr-2 text-sm"></i> Testimoni Wali &amp; Alumni
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 4. Download Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition">
                        <span>Download</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ asset('/uploads/pedoman-adab-santri.pdf') }}" target="_blank" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-file-pdf w-5 text-red-600 mr-2 text-sm"></i> Buku Saku Adab Santri
                            </a>
                            <a href="{{ asset('/uploads/panduan-tahfidz-ishum.pdf') }}" target="_blank" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-book-quran w-5 text-indigo-600 mr-2 text-sm"></i> Panduan Mutqin Tahfidz
                            </a>
                            <a href="{{ $unitUrl }}#elibrary" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-book-open-reader w-5 text-indigo-600 mr-2 text-sm"></i> E-Book &amp; Modul Ajar
                            </a>
                            <a href="{{ asset('/uploads/logo-ishum.png') }}" target="_blank" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-image w-5 text-indigo-600 mr-2 text-sm"></i> Logo Resmi Sekolah
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 5. Layanan Dropdown --}}
                <div class="relative group py-2">
                    <button type="button" class="px-3 py-2 rounded-xl inline-flex items-center hover:bg-white/15 transition">
                        <span>Layanan</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-1.5 transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute left-0 top-full pt-1.5 w-60 hidden group-hover:block transition-all duration-150 z-50">
                        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200/80 py-2.5 text-gray-800">
                            <a href="{{ route('school.layanan.kunjungan') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-bus w-5 text-indigo-600 mr-2 text-sm"></i> Izin Kunjungan Sekolah
                            </a>
                            <a href="{{ route('school.layanan.kerjasama') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-handshake w-5 text-indigo-600 mr-2 text-sm"></i> Permohonan Kerja Sama
                            </a>
                            <a href="{{ route('school.layanan.sewa') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-building-columns w-5 text-indigo-600 mr-2 text-sm"></i> Sewa Sarana &amp; Gedung
                            </a>
                            <a href="{{ route('school.espp') }}" class="block px-4 py-2.5 text-xs font-semibold text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                <i class="fa-solid fa-credit-card w-5 text-indigo-600 mr-2 text-sm"></i> Cek E-SPP Santri
                            </a>
                        </div>
                    </div>
                </div>

                {{-- 6. Kontak --}}
                <a href="{{ $unitUrl }}#kontak" class="px-3 py-2 rounded-xl hover:bg-white/15 transition">
                    Kontak
                </a>

                {{-- ACTION CTA: DAFTAR SPMB (Radiant Gold Pill) --}}
                <div class="pl-2">
                    <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
                       class="inline-flex items-center space-x-2 px-5 py-2.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transform hover:-translate-y-0.5 active:translate-y-0 transition duration-200">
                        <i class="fa-solid fa-graduation-cap text-sm"></i>
                        <span>Daftar SPMB</span>
                    </a>
                </div>
            </nav>

            {{-- MOBILE MENU TRIGGER BUTTON --}}
            <div class="flex items-center space-x-2 lg:hidden">
                <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
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

    {{-- MOBILE MENU DRAWER --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="lg:hidden bg-slate-900/98 backdrop-blur-xl border-b border-indigo-900/80 px-4 pt-3 pb-6 space-y-2 text-sm text-white shadow-2xl">
        <a href="{{ $unitUrl }}" class="block px-3.5 py-2.5 rounded-xl hover:bg-white/10 font-bold">
            <i class="fa-solid fa-house w-6 text-amber-400"></i> Beranda
        </a>
        <div class="border-t border-slate-800 my-1 pt-1">
            <span class="block px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Profil Lembaga</span>
            <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-user-tie w-6 text-indigo-400"></i> Sambutan Kepala Sekolah
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-school w-6 text-indigo-400"></i> Profil Singkat
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-compass w-6 text-indigo-400"></i> Visi dan Misi
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-landmark w-6 text-indigo-400"></i> Sejarah Sekolah
            </a>
        </div>
        <div class="border-t border-slate-800 my-1 pt-1">
            <span class="block px-3.5 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Informasi &amp; Galeri</span>
            <a href="{{ $unitUrl }}#berita" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-newspaper w-6 text-indigo-400"></i> Berita &amp; Prestasi
            </a>
            <a href="{{ $unitUrl }}#agenda" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-calendar-days w-6 text-indigo-400"></i> Agenda Akademik
            </a>
            <a href="{{ $unitUrl }}#galeri" class="block px-3.5 py-2 rounded-xl hover:bg-white/10 font-medium text-xs">
                <i class="fa-solid fa-images w-6 text-indigo-400"></i> Galeri Foto &amp; Video
            </a>
        </div>
        <div class="pt-3">
            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
               class="w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Daftar Santri Baru (SPMB Online)</span>
            </a>
        </div>
    </div>
</header>
