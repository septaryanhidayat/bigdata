@extends('school.unit.layouts.master')

@section('title', ($info['name'] ?? 'Sekolah Islam Terpadu') . ' - ' . ($info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia'))
@section('meta_description', $info['description'] ?? 'Official Website ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Sekolah Islam Terpadu unggulan.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'primary_light' => '#6366f1',
        'gold' => '#f59e0b',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'hero_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'btn_primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'accent_text' => 'text-indigo-600',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $unitUrl = url('/unit/' . $codeLower);

    $heroSlides = [
        [
            'title' => 'Selamat Datang di Website Resmi ' . $info['name'],
            'subtitle' => $info['tagline'] ?? 'Membina Generasi Qur\'ani, Cerdas & Berakhlak Mulia',
            'image' => asset($info['hero_bg_image'] ?: ($info['campus_photo'] ?: '/images/logo-robbani-official.png'))
        ],
        [
            'title' => 'Mencetak Generasi Unggul Berkarakter Qur\'ani',
            'subtitle' => 'Kurikulum Terpadu JSIT & Nasional dengan fasilitas modern representatif.',
            'image' => asset($info['hero_image'] ?: ($info['hero_bg_image'] ?: '/images/logo-robbani-official.png'))
        ],
        [
            'title' => 'Pendaftaran Santri Baru (SPMB) Telah Dibuka',
            'subtitle' => 'Daftarkan putra-putri tercinta sekarang, kuota terbatas per kelas.',
            'image' => asset($info['flyer'] ?: ($info['hero_image'] ?: '/images/logo-robbani-official.png'))
        ]
    ];
@endphp

@section('content')

{{-- ========================================================
     SESI 1: HERO SLIDER BANNER (Carousel Otomatis)
     ======================================================== --}}
<section class="relative bg-slate-950 overflow-hidden" x-data="{
    activeSlide: 0,
    slides: {{ Js::from($heroSlides) }},
    autoSlide() {
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        }, 6500);
    }
}" x-init="autoSlide()">
    <div class="relative h-[440px] sm:h-[480px] lg:h-[520px] w-full overflow-hidden">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="activeSlide === index" 
                 x-transition:enter="transition ease-out duration-700" 
                 x-transition:enter-start="opacity-0 scale-105" 
                 x-transition:enter-end="opacity-100 scale-100" 
                 x-transition:leave="transition ease-in duration-500" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="absolute inset-0">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover object-center brightness-60" onerror="this.src='/images/logo-robbani-official.png'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-slate-950/40"></div>

                <div class="absolute inset-0 flex items-center justify-center pt-2 pb-16 sm:pb-14">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center text-white space-y-3 sm:space-y-4">
                        <span class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full text-[11px] sm:text-xs font-black uppercase tracking-widest bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg shadow-amber-500/30">
                            <i class="fa-solid fa-star text-[10px]"></i>
                            <span>{{ $info['name'] }} &bull; {{ $info['akreditasi'] ?? 'Terakreditasi B' }}</span>
                        </span>
                        <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-black tracking-tight drop-shadow-2xl leading-tight" x-text="slide.title"></h1>
                        <p class="text-xs sm:text-sm md:text-base text-slate-200 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md" x-text="slide.subtitle"></p>
                        
                        <div class="pt-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-2.5 sm:gap-4 w-full max-w-xs sm:max-w-none mx-auto">
                            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
                               class="w-full sm:w-auto px-6 sm:px-8 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:shadow-amber-500/50 hover:scale-105 active:scale-95 transition duration-200 flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>Daftar SPMB Sekarang</span>
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" 
                               class="w-full sm:w-auto px-6 sm:px-7 py-3 rounded-full font-bold text-xs uppercase tracking-wider bg-white/10 hover:bg-white/20 text-white border border-white/30 backdrop-blur-md transition duration-200 flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-compass"></i>
                                <span>Jelajahi Profil</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- SLIDE DOT INDICATORS --}}
    <div class="absolute bottom-5 inset-x-0 flex justify-center items-center space-x-2 z-20">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index" 
                    class="h-2 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'w-8 bg-amber-400 shadow-md shadow-amber-400/50' : 'w-2 bg-white/40 hover:bg-white/70'"
                    :aria-label="'Pindah ke Slide ' + (index + 1)"></button>
        </template>
    </div>
</section>

{{-- ========================================================
     SESI 2: FLOATING QUICK ACTION HUB (8 Kartu Ikon)
     ======================================================== --}}
<section class="-mt-8 sm:-mt-12 relative z-30 px-3 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white rounded-3xl p-3 sm:p-6 shadow-2xl border border-gray-100">
        <div class="grid grid-cols-4 lg:grid-cols-8 gap-2 sm:gap-4 text-center">
            
            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">SPMB</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-school"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Profil</span>
            </a>

            <a href="#guru" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Guru &amp; GTK</span>
            </a>

            <a href="#fasilitas" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Fasilitas</span>
            </a>

            <a href="#program" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Unggulan</span>
            </a>

            <a href="#berita" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Prestasi</span>
            </a>

            <a href="#agenda" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Agenda</span>
            </a>

            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-indigo-50 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-file-pdf"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-indigo-600 leading-tight line-clamp-1">Brosur</span>
            </a>

        </div>
    </div>
</section>

{{-- ========================================================
     SESI 3: HIGHLIGHT SPMB EXCLUSIVE & EVENT BANNER
     ======================================================== --}}
<section class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-gradient-to-r from-indigo-950 via-indigo-900 to-blue-950 rounded-3xl p-5 sm:p-10 text-white shadow-2xl border border-indigo-500/30 reveal-fade-up relative overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            {{-- FLYER 3:4 SISI KIRI --}}
            <div class="lg:col-span-4 flex justify-center">
                <div class="w-full max-w-[240px] sm:w-72 rounded-2xl overflow-hidden shadow-2xl border-4 border-amber-400/40 ring-4 ring-indigo-500/30 group">
                    <img src="{{ asset($info['flyer'] ?: ($info['hero_image'] ?: '/images/logo-robbani-official.png')) }}" 
                         alt="Flyer SPMB {{ $info['name'] }}" 
                         class="w-full h-auto object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.src='/images/logo-robbani-official.png'">
                </div>
            </div>

            {{-- INFORMASI BENEFIT & EVENT SISI KANAN --}}
            <div class="lg:col-span-8 space-y-4 sm:space-y-5 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-amber-400/20 text-amber-300 border border-amber-400/30 px-3.5 py-1.5 rounded-full text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>Pendaftaran Tahun Ajaran 2026/2027</span>
                </div>
                <h2 class="text-xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                    SPMB Gelombang Exclusive &amp; Class Meeting Semester Genap
                </h2>
                <p class="text-xs sm:text-sm text-indigo-100 font-light leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Wujudkan impian pendidikan ananda bersama {{ $info['name'] }}. Pembelajaran terintegrasi tahfidz mutqin, penguatan sains-teknologi, dan pembentukan karakter kepemimpinan islami.
                </p>

                {{-- 3 KARTU BENEFIT --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 pt-2 text-left sm:text-center">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-users text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">Kuota Terbatas</h4>
                            <p class="text-[10px] text-indigo-200">24 Santri / Kelas</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-tag text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">Cashback SPMB</h4>
                            <p class="text-[10px] text-indigo-200">Potongan Uang Masuk</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-medal text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">Class Meeting</h4>
                            <p class="text-[10px] text-indigo-200">Lomba Antar Sekolah</p>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="pt-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-2.5 sm:gap-3 w-full sm:w-auto">
                    <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
                       class="w-full sm:w-auto px-7 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-105 active:scale-95 transition duration-200 flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Daftar Sekarang</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '0811747472', '0') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full sm:w-auto px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition flex items-center justify-center space-x-2">
                        <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                        <span>Hubungi Panitia SPMB</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SESI 4: SAMBUTAN KEPALA SEKOLAH TEASER
     ======================================================== --}}
<section class="py-10 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-white rounded-3xl p-6 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 sm:gap-10 items-center">
            
            <div class="lg:col-span-4 flex justify-center">
                <div class="w-48 h-60 sm:w-64 sm:h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-indigo-100 bg-indigo-50 relative group">
                    <img src="{{ asset($info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp') }}" 
                         alt="{{ $info['principal_name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 inset-x-0 text-center text-white px-2">
                        <span class="block text-xs sm:text-sm font-extrabold truncate">{{ $info['principal_name'] }}</span>
                        <span class="inline-block bg-amber-400 text-slate-950 font-black text-[9px] uppercase px-2 py-0.5 rounded-full mt-1">Kepala Sekolah</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-indigo-100 text-indigo-800 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-user-tie text-indigo-600"></i>
                    <span>Sambutan Pimpinan</span>
                </div>
                <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Mendidik Generasi Qur'ani Berprestasi
                </h2>
                <div class="w-16 h-1 bg-indigo-600 rounded-full mx-auto lg:mx-0"></div>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                    {{ $info['principal_greeting'] ?? ('Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi ' . $info['name'] . '. Kami hadir dengan komitmen tinggi mendidik dan membimbing ananda menjadi generasi robbani yang beraqidah lurus, berakhlak mulia, hafidz Al-Qur\'an, serta unggul dalam penguasaan sains dan teknologi.') }}
                </p>
                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-2.5 sm:gap-3 w-full sm:w-auto">
                    <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-full text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md hover:shadow-indigo-500/20 transition flex items-center justify-center space-x-2">
                        <span>Baca Sambutan Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/profil') }}" 
                       class="w-full sm:w-auto px-6 py-3 rounded-full text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition flex items-center justify-center space-x-2">
                        <span>Profil Lengkap</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SESI 5: WARTA & KABAR KAMPUS (BERITA)
     ======================================================== --}}
<section id="berita" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-indigo-600 block">Kabar Terkini</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Warta &amp; Informasi Kampus</h2>
        </div>
        <a href="{{ route('school.berita') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1 self-start sm:self-auto">
            <span>Lihat Semua Berita</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>

    @php
        $newsItems = !empty($unitNews) ? collect($unitNews)->take(4) : collect();
        $featuredNews = $newsItems->first();
        $sideNews = $newsItems->slice(1);
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        {{-- BERITA UTAMA JUMBO (KIRI - 7 Kolom) --}}
        @if($featuredNews)
            <div class="lg:col-span-7 bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 group flex flex-col justify-between reveal-fade-up">
                <div class="relative h-64 sm:h-80 overflow-hidden bg-gray-100">
                    <img src="{{ asset($featuredNews['image'] ?? '/images/logo-robbani-official.png') }}" 
                         alt="{{ $featuredNews['title'] }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.src='/images/logo-robbani-official.png'">
                    <span class="absolute top-4 left-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow">
                        {{ $featuredNews['category'] ?? 'Berita Utama' }}
                    </span>
                </div>
                <div class="p-6 sm:p-8 space-y-3">
                    <span class="text-xs text-gray-400 font-medium flex items-center gap-1.5">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ $featuredNews['date'] ?? '18 Sep 2026' }}</span>
                    </span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 group-hover:text-indigo-600 transition leading-snug">
                        <a href="{{ !empty($featuredNews['slug']) ? route('school.berita.show', $featuredNews['slug']) : '#' }}">
                            {{ $featuredNews['title'] }}
                        </a>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 leading-relaxed">
                        {{ $featuredNews['summary'] ?? ($info['name'] . ' terus menorehkan prestasi dan menyelenggarakan kegiatan positif untuk mendukung potensi santri.') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- BERITA SAMPINGAN HORIZONTAL (KANAN - 5 Kolom) --}}
        <div class="lg:col-span-5 space-y-4 flex flex-col justify-between">
            @foreach($sideNews as $sItem)
                <a href="{{ !empty($sItem['slug']) ? route('school.berita.show', $sItem['slug']) : '#' }}" 
                   class="bg-white rounded-2xl p-4 shadow-md border border-gray-100 hover:border-indigo-300 transition group flex items-center space-x-4 reveal-fade-up">
                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        <img src="{{ asset($sItem['image'] ?? '/images/logo-robbani-official.png') }}" 
                             alt="{{ $sItem['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                             onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div class="space-y-1 min-w-0 flex-1">
                        <span class="text-[10px] text-gray-400 font-medium block">
                            {{ $sItem['date'] ?? '18 Sep 2026' }}
                        </span>
                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-indigo-600 transition line-clamp-2 leading-snug">
                            {{ $sItem['title'] }}
                        </h4>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

{{-- ========================================================
     SESI 6: PROGRAM UNGGULAN (4 Kolom Grid)
     ======================================================== --}}
<section id="program" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-indigo-600 block">Kekhasan Sekolah</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Program Unggulan {{ $info['name'] }}</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    @php
        $programs = $info['programs'] ?? [
            ['title' => 'Tahfidz Al-Qur\'an Mutqin', 'icon' => '📖', 'desc' => 'Bimbingan tasmi\', murojaah harian, dan wisuda tahfidz tahunan bersama hafidz tersertifikasi.'],
            ['title' => 'Bilingual Arabic & English', 'icon' => '🗣️', 'desc' => 'Pembiasaan percakapan bahasa Arab dan Inggris dalam aktivitas santri sehari-hari.'],
            ['title' => 'Bina Prestasi Sains & Riset', 'icon' => '🔬', 'desc' => 'Inkubator olimpiade matematika, sains terapan, dan koding dasar berbasis nalar ilmiah.'],
            ['title' => 'Karakter Mandiri & Kepemimpinan', 'icon' => '🌟', 'desc' => 'Mentoring kelompok kecil (BPI), kepanduan Pramuka SIT, serta pembinaan adab santri.']
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($programs as $prog)
            <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:border-amber-400 hover:-translate-y-1 transition duration-300 space-y-3 reveal-fade-up">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-2xl shadow-inner">
                    <span>{{ $prog['icon'] ?? '🌟' }}</span>
                </div>
                <h3 class="font-extrabold text-sm sm:text-base text-gray-900">{{ $prog['title'] }}</h3>
                <p class="text-xs text-gray-600 leading-relaxed font-light">{{ $prog['desc'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="text-center pt-2">
        <a href="{{ url('/unit/' . $codeLower . '/profil') }}#program" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 shadow-md transition">
            <span>Lihat Seluruh Program Unggulan</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</section>

{{-- ========================================================
     SESI 7: DEWAN GURU & GTK SHOWCASE
     ======================================================== --}}
<section id="guru" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-indigo-600 block">Tenaga Pendidik</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Dewan Guru &amp; Tenaga Kependidikan</h2>
        <div class="w-16 h-1 bg-indigo-600 rounded-full mx-auto"></div>
    </div>

    @php
        $teacherList = !empty($info['teachers']) ? array_slice($info['teachers'], 0, 8) : [
            ['name' => $info['principal_name'], 'role' => 'Kepala Sekolah', 'photo' => $info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp']
        ];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @foreach($teacherList as $tc)
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition duration-300 reveal-fade-up text-center group">
                <div class="h-44 sm:h-64 overflow-hidden bg-indigo-50">
                    <img src="{{ asset($tc['photo'] ?? '/uploads/dewan/kepala-sekolah.webp') }}" 
                         alt="{{ $tc['name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
                </div>
                <div class="p-3 sm:p-4 space-y-1">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-1">{{ $tc['name'] }}</h3>
                    <p class="text-[10px] sm:text-xs text-indigo-600 font-semibold truncate">{{ $tc['role'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center pt-2">
        <a href="{{ url('/unit/' . $codeLower . '/profil') }}#guru" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 shadow-md transition">
            <span>Lihat Semua Guru &amp; GTK ({{ count($info['teachers'] ?? []) }})</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</section>

{{-- ========================================================
     SESI 8: GALERI VIDEO YOUTUBE RESMI
     ======================================================== --}}
<section id="video" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 bg-slate-950 text-white" x-data="{ activeVideo: null, showAllVideos: false }">
    <div class="max-w-7xl mx-auto space-y-8 sm:space-y-10">
        <div class="text-center space-y-2">
            <span class="text-xs font-black uppercase tracking-wider text-amber-400 block">Dokumentasi Multimedia</span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-white tracking-tight">Galeri Video Resmi ({{ count($unitVideos ?? []) }} Video)</h2>
            <div class="w-16 h-1 bg-red-600 rounded-full mx-auto"></div>
        </div>

        @php
            $displayVideos = !empty($unitVideos) ? $unitVideos : [];
            $initialVideos = array_slice($displayVideos, 0, 6);
            $moreVideos = array_slice($displayVideos, 6);
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($initialVideos as $v)
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 shadow-xl group flex flex-col justify-between">
                    <div class="relative h-44 sm:h-48 bg-slate-800 flex items-center justify-center overflow-hidden">
                        <img src="{{ asset($v['thumbnail'] ?? '/images/logo-robbani-official.png') }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition duration-500" onerror="this.src='/images/logo-robbani-official.png'">
                        @if(!empty($v['embed_id']))
                            <button @click="activeVideo = '{{ $v['embed_id'] }}'" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition cursor-pointer" aria-label="Putar Video">
                                <i class="fa-solid fa-play"></i>
                            </button>
                        @else
                            <a href="{{ $v['url'] ?? 'https://youtube.com' }}" target="_blank" rel="noopener noreferrer" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition" aria-label="Putar Video">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        @endif
                    </div>
                    <div class="p-4 space-y-1">
                        <span class="text-[10px] text-amber-400 font-semibold">{{ $v['date'] ?? 'Video Resmi' }}</span>
                        <h4 class="text-xs font-bold text-white line-clamp-2 leading-snug">{{ $v['title'] }}</h4>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-6 text-xs text-slate-400">
                    Dokumentasi video resmi dapat dilihat pada saluran YouTube resmi SIT Robbani.
                </div>
            @endforelse
        </div>

        @if(count($moreVideos) > 0)
            <div x-show="showAllVideos" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 pt-4">
                @foreach($moreVideos as $v)
                    <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 shadow-xl group flex flex-col justify-between">
                        <div class="relative h-44 sm:h-48 bg-slate-800 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset($v['thumbnail'] ?? '/images/logo-robbani-official.png') }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition duration-500" onerror="this.src='/images/logo-robbani-official.png'">
                            @if(!empty($v['embed_id']))
                                <button @click="activeVideo = '{{ $v['embed_id'] }}'" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition cursor-pointer" aria-label="Putar Video">
                                    <i class="fa-solid fa-play"></i>
                                </button>
                            @else
                                <a href="{{ $v['url'] ?? 'https://youtube.com' }}" target="_blank" rel="noopener noreferrer" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition" aria-label="Putar Video">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            @endif
                        </div>
                        <div class="p-4 space-y-1">
                            <span class="text-[10px] text-amber-400 font-semibold">{{ $v['date'] ?? 'Video Resmi' }}</span>
                            <h4 class="text-xs font-bold text-white line-clamp-2 leading-snug">{{ $v['title'] }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            @if(count($moreVideos) > 0)
                <button @click="showAllVideos = !showAllVideos" 
                        class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-2.5 rounded-full font-bold text-xs bg-slate-800 hover:bg-slate-700 text-amber-400 border border-slate-700 shadow-md transition cursor-pointer">
                    <i class="fa-solid" :class="showAllVideos ? 'fa-chevron-up' : 'fa-film'"></i>
                    <span x-text="showAllVideos ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua ({{ count($unitVideos) }} Video)'"></span>
                </button>
            @endif
            <a href="https://youtube.com" target="_blank" 
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-2.5 rounded-full font-bold text-xs bg-red-600 hover:bg-red-700 text-white shadow-lg transition">
                <i class="fa-brands fa-youtube text-base"></i>
                <span>Kunjungi Saluran YouTube</span>
            </a>
        </div>

        {{-- MODAL VIDEO PLAYER INTERAKTIF --}}
        <div x-show="activeVideo" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
             style="display: none;"
             @keydown.escape.window="activeVideo = null">
            <div class="relative w-full max-w-4xl bg-slate-950 rounded-2xl overflow-hidden shadow-2xl border border-slate-800" @click.outside="activeVideo = null">
                <div class="flex items-center justify-between px-4 py-3 bg-slate-900 border-b border-slate-800">
                    <span class="text-xs font-bold text-white flex items-center gap-2">
                        <i class="fa-brands fa-youtube text-red-500"></i>
                        <span>Pemutar Video Resmi SIT Robbani</span>
                    </span>
                    <button @click="activeVideo = null" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center text-sm transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="relative pt-[56.25%] w-full bg-black">
                    <template x-if="activeVideo">
                        <iframe :src="'https://www.youtube.com/embed/' + activeVideo + '?autoplay=1&rel=0'" 
                                class="absolute inset-0 w-full h-full border-0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                        </iframe>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ========================================================
     SESI 9: PENGUMUMAN & AGENDA AKADEMIK (2 Kolom)
     ======================================================== --}}
<section id="agenda" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
        
        {{-- KOLOM PENGUMUMAN --}}
        <div class="bg-white rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 space-y-5 reveal-fade-up">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-sm sm:text-base font-extrabold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-indigo-600"></i>
                    <span>Pengumuman Resmi</span>
                </h3>
            </div>
            <div class="space-y-3.5">
                @php
                    $displayAnnouncements = !empty($unitAnnouncements) ? array_slice($unitAnnouncements, 0, 3) : [
                        [
                            'category' => 'Akademik',
                            'date' => '18 Sep 2026',
                            'title' => 'Jadwal Penilaian Tengah Semester (PTS) TA 2026/2027',
                            'summary' => 'Diharapkan seluruh santri mempersiapkan diri dengan belajar tekun dan menjaga kesehatan.'
                        ]
                    ];
                @endphp
                @foreach($displayAnnouncements as $an)
                    <div class="p-4 rounded-2xl bg-indigo-50/60 border border-indigo-100 space-y-1">
                        <span class="text-[10px] font-bold text-indigo-600 uppercase">{{ $an['category'] ?? 'Pengumuman' }} &bull; {{ $an['date'] ?? 'Terbaru' }}</span>
                        <h4 class="text-xs font-bold text-gray-900">{{ $an['title'] }}</h4>
                        @if(!empty($an['summary']))
                            <p class="text-xs text-gray-600">{{ $an['summary'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- KOLOM AGENDA AKADEMIK --}}
        <div class="bg-white rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 space-y-5 reveal-fade-up delay-1">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <h3 class="text-sm sm:text-base font-extrabold text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-days text-indigo-600"></i>
                    <span>Agenda Kegiatan</span>
                </h3>
            </div>
            <div class="space-y-3.5">
                @php
                    $agendas = !empty($unitAgendas) ? array_slice($unitAgendas, 0, 3) : [
                        ['title' => 'Munaqosah & Ujian Tahfidz Al-Qur\'an', 'date_day' => '05', 'date_month' => 'JUL', 'location' => 'Masjid Kampus'],
                        ['title' => 'Pendaftaran SPMB Gelombang Exclusive', 'date_day' => '25', 'date_month' => 'JUN', 'location' => 'Kantor SPMB / Online'],
                        ['title' => 'Pembukaan Class Meeting Semester Genap', 'date_day' => '17', 'date_month' => 'JUN', 'location' => 'Lapangan Kampus']
                    ];
                @endphp
                @foreach($agendas as $ag)
                    <div class="flex items-start space-x-3.5 p-3 sm:p-3.5 rounded-2xl bg-gray-50/80 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-200/60 flex flex-col items-center justify-center shrink-0">
                            <span class="text-xs font-black">{{ $ag['date_day'] ?? '15' }}</span>
                            <span class="text-[9px] font-extrabold uppercase mt-0.5 tracking-wider">{{ $ag['date_month'] ?? 'JUL' }}</span>
                        </div>
                        <div class="space-y-1 min-w-0 flex-1">
                            <h4 class="text-xs font-bold text-gray-900 line-clamp-1">{{ $ag['title'] }}</h4>
                            <p class="text-[10px] text-gray-500 flex items-center gap-1 truncate">
                                <i class="fa-solid fa-location-dot text-amber-500 text-[9px]"></i>
                                <span>{{ $ag['location'] ?? 'Kampus Sekolah' }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

{{-- ========================================================
     SESI 10: GALERI FOTO SANTRI
     ======================================================== --}}
<section id="galeri" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-indigo-600 block">Dokumentasi Santri</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Galeri Foto Santri</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
        @php
            $displayGallery = !empty($unitGallery) ? array_slice($unitGallery, 0, 6) : [];
        @endphp
        @forelse($displayGallery as $g)
            <div class="rounded-2xl overflow-hidden shadow-md h-52 sm:h-60 bg-gray-100 group relative">
                <img src="{{ asset($g['image'] ?? '/images/logo-robbani-official.png') }}" 
                     alt="{{ $g['title'] ?? 'Dokumentasi Santri' }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                     onerror="this.src='/images/logo-robbani-official.png'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                    <span class="text-white text-xs font-bold line-clamp-1">{{ $g['title'] ?? 'Dokumentasi' }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-6 text-xs text-gray-400">
                Dokumentasi foto kegiatan sekolah tersedia di laman profil.
            </div>
        @endforelse
    </div>

    <div class="text-center pt-2">
        <a href="{{ url('/unit/' . $codeLower . '/profil') }}#galeri" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 shadow-md transition">
            <span>Lihat Semua Foto Kegiatan</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</section>

{{-- ========================================================
     SESI 11: CALL-TO-ACTION HIGH CONVERSION BANNER
     ======================================================== --}}
<section class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="rounded-3xl bg-gradient-to-r from-indigo-950 via-indigo-900 to-blue-950 p-6 sm:p-12 text-white shadow-2xl border border-indigo-500/30 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div class="space-y-2">
            <span class="inline-block bg-amber-400 text-slate-950 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                Kuota Terbatas!
            </span>
            <h3 class="text-xl sm:text-3xl font-black text-white tracking-tight">
                Daftar Sekarang di {{ $info['name'] }}
            </h3>
            <p class="text-xs sm:text-sm text-indigo-200 font-light max-w-xl">
                Amankan kursi belajar terbaik ananda sekarang juga sebelum kuota penerimaan terpenuhi.
            </p>
        </div>
        <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
           class="w-full sm:w-auto px-8 py-3.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:scale-105 active:scale-95 transition shrink-0 flex items-center justify-center space-x-2">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>Daftar SPMB Online</span>
        </a>
    </div>
</section>

{{-- ========================================================
     SESI 12: 5 BIDANG LITERASI KEHIDUPAN (Kurikulum)
     ======================================================== --}}
<section class="py-10 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-[#0f172a] rounded-3xl p-6 sm:p-12 text-white space-y-6 sm:space-y-8 border border-slate-800">
        <div class="text-center space-y-2">
            <span class="text-xs font-black uppercase tracking-wider text-amber-400 block">Kurikulum Holistik</span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-white tracking-tight">5 Bidang Literasi Kehidupan</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-2xl overflow-hidden border border-slate-800 h-48 sm:h-52 group relative">
                <img src="/uploads/covers/cover-tahfidz-mutqin.webp" alt="Literasi Al-Qur'an" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/images/logo-robbani-official.png'">
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-800 h-48 sm:h-52 group relative">
                <img src="/uploads/covers/cover-praktikum-sains.webp" alt="Literasi Sains" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/images/logo-robbani-official.png'">
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-800 h-48 sm:h-52 group relative">
                <img src="/uploads/covers/cover-bilingual-arab-inggris.webp" alt="Literasi Bahasa" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/images/logo-robbani-official.png'">
            </div>
            <div class="rounded-2xl overflow-hidden border border-slate-800 h-48 sm:h-52 group relative">
                <img src="/uploads/covers/cover-karakter-santri.webp" alt="Literasi Karakter" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" onerror="this.src='/images/logo-robbani-official.png'">
            </div>
        </div>
        <div class="text-center pt-2">
            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-8 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg shadow-amber-500/20 hover:brightness-105 transition">
                <i class="fa-solid fa-book-open"></i>
                <span>Pelajari Kurikulum Literasi</span>
            </a>
        </div>
    </div>
</section>

{{-- ========================================================
     SESI 13: TESTIMONI WALI SANTRI & ALUMNI
     ======================================================== --}}
<section id="testimoni" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-indigo-600 block">Kesan &amp; Pengalaman</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Testimoni Wali &amp; Alumni</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        @php
            $testimonials = !empty($info['alumni']) ? $info['alumni'] : [
                ['name' => 'Wali Santri Angkatan 2025', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di sekolah ini luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp'],
                ['name' => 'Ahmad Faiz', 'title' => 'Alumni Berprestasi', 'text' => 'Fasilitas belajar modern dan bimbingan para guru sangat mendukung minat saya di bidang sains dan tahfidz.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp'],
                ['name' => 'Bunda Siti', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp']
            ];
        @endphp

        @foreach(array_slice($testimonials, 0, 3) as $t)
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-xl border border-gray-100 space-y-4 flex flex-col justify-between">
                <div class="space-y-3">
                    <i class="fa-solid fa-quote-left text-2xl text-emerald-500"></i>
                    <p class="text-xs text-gray-600 leading-relaxed italic">
                        “{{ $t['text'] }}”
                    </p>
                </div>
                <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                        <img src="{{ asset($t['avatar'] ?? '/uploads/dewan/kepala-sekolah.webp') }}" 
                             alt="{{ $t['name'] }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-900">{{ $t['name'] }}</span>
                        <span class="block text-[10px] text-gray-500">{{ $t['title'] }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

{{-- ========================================================
     SESI 14: BOTTOM QUICK ACTION CARDS (3 Kartu Aksi)
     ======================================================== --}}
<section class="py-6 sm:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5 sm:gap-4">
        <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" class="bg-white rounded-2xl p-4 sm:p-5 shadow-lg border-t-4 border-indigo-600 hover:shadow-xl transition flex items-center space-x-3.5 sm:space-x-4">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Pendaftaran SPMB Online</h4>
                <p class="text-[11px] text-gray-500">Buka formulir online santri baru</p>
            </div>
        </a>

        <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '0811747472', '0') }}" target="_blank" class="bg-white rounded-2xl p-4 sm:p-5 shadow-lg border-t-4 border-amber-500 hover:shadow-xl transition flex items-center space-x-3.5 sm:space-x-4">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Chat WhatsApp Hotline</h4>
                <p class="text-[11px] text-gray-500">Konsultasi langsung panitia</p>
            </div>
        </a>

        <a href="{{ route('school.layanan.kunjungan') }}" class="bg-white rounded-2xl p-4 sm:p-5 shadow-lg border-t-4 border-blue-600 hover:shadow-xl transition flex items-center space-x-3.5 sm:space-x-4">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Layanan Infaq / Beasiswa</h4>
                <p class="text-[11px] text-gray-500">Program santri yatim dhuafa</p>
            </div>
        </a>
    </div>
</section>

@endsection
