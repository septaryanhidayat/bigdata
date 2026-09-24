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
        'btn_primary' => 'bg-unit-primary hover:brightness-110 text-white',
        'accent_text' => 'text-unit-primary',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $unitUrl = url('/unit/' . $codeLower);

    $isSmait = $codeLower === 'smait' || ($info['status'] ?? '') === 'BELUM_DIBUKA';
    $heroSlides = $isSmait ? [
        [
            'title' => 'Selamat Datang di Portal Resmi SMA IT Robbani',
            'subtitle' => 'Tahap Persiapan Operasional Menuju Pembukaan Jenjang Lanjutan Berkarakter Qur\'ani & Sains Teknologi.',
            'image' => asset('/images/logo-robbani-official.png')
        ],
        [
            'title' => 'Mempersiapkan Generasi Cendekia Qur\'ani Masa Depan',
            'subtitle' => 'Kurikulum Terpadu JSIT & Nasional dengan fasilitas sarana prasarana modern.',
            'image' => asset('/images/logo-robbani-official.png')
        ],
        [
            'title' => 'Informasi Pembukaan & Konsultasi Jenjang',
            'subtitle' => 'Insya Allah segera membuka penerimaan peserta didik baru setelah proses legalitas dan sarana siap.',
            'image' => asset('/images/logo-robbani-official.png')
        ]
    ] : [
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
            'title' => 'Pendaftaran Siswa Baru (SPMB) Telah Dibuka',
            'subtitle' => 'Daftarkan putra-putri tercinta sekarang, kuota terbatas per kelas.',
            'image' => asset($info['flyer'] ?: ($info['hero_image'] ?: '/images/logo-robbani-official.png'))
        ]
    ];
@endphp

@section('content')

@if($isSmait)
    <div class="bg-gradient-to-r from-amber-500 via-amber-600 to-orange-600 text-slate-950 px-4 py-3 shadow-md">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-center gap-2 text-center text-xs sm:text-sm font-bold">
            <span class="inline-flex items-center gap-1 bg-slate-950 text-amber-300 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider shrink-0">
                <i class="fa-solid fa-clock"></i> SEGERA DIBUKA
            </span>
            <span>SMA IT Robbani saat ini dalam tahap persiapan operasional pembukaan. Data kegiatan dan pendaftaran belum dibuka.</span>
        </div>
    </div>
@endif

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
                            <a href="{{ route('school.spmb') }}?unit={{ $codeLower }}" 
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
            
            <a href="{{ route('school.spmb') }}?unit={{ $codeLower }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">SPMB</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/profil') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-slate-100 text-unit-primary flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-school"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Profil</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Guru &amp; GTK</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/fasilitas') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Fasilitas</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/program-unggulan') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Unggulan</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/artikel') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-trophy"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Prestasi</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/agenda') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Agenda</span>
            </a>

            <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="group p-2 sm:p-3 rounded-2xl hover:bg-slate-100 transition duration-200 flex flex-col items-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg sm:text-xl mb-1.5 sm:mb-2 group-hover:scale-110 transition shadow-inner">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-gray-800 group-hover:text-unit-primary leading-tight line-clamp-1">Unduhan</span>
            </a>

        </div>
    </div>
</section>

{{-- ========================================================
     SESI 3: HIGHLIGHT SPMB EXCLUSIVE & EVENT BANNER
     ======================================================== --}}
<section class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} rounded-3xl p-5 sm:p-10 text-white shadow-2xl border border-white/10 reveal-fade-up relative overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            {{-- FLYER RESMI VERTIKAL SISI KIRI (SEIMBANG DENGAN KONTEN KANAN) --}}
            <div class="lg:col-span-5 flex justify-center">
                <div class="w-full max-w-[280px] sm:max-w-[320px] rounded-3xl overflow-hidden shadow-2xl border-4 border-amber-400/50 ring-4 ring-white/10 group bg-slate-900 aspect-[3/4] flex items-center justify-center">
                    <img src="{{ asset('/images/spmb/flyer-spmb-sit-robbani.webp') }}" 
                         alt="Brosur Resmi SPMB SIT Robbani" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                         onerror="this.onerror=null; this.src='/images/spmb/flyer-spmb-sit-robbani.jpg';">
                </div>
            </div>

            {{-- INFORMASI BENEFIT & EVENT SISI KANAN --}}
            <div class="lg:col-span-7 space-y-4 sm:space-y-5 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-amber-400/20 text-amber-300 border border-amber-400/30 px-3.5 py-1.5 rounded-full text-[11px] sm:text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-sparkles"></i>
                    <span>{{ $isSmait ? 'Tahap Persiapan Operasional Pembukaan' : 'Pendaftaran Tahun Ajaran 2026/2027' }}</span>
                </div>
                <h2 class="text-xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                    {{ $isSmait ? 'Menuju Pembukaan Resmi Jenjang SMA IT Robbani' : 'SPMB Gelombang Exclusive & Class Meeting Semester Genap' }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-100 font-light leading-relaxed max-w-2xl mx-auto lg:mx-0 text-justify">
                    {{ $isSmait ? 'SMA IT Robbani saat ini dalam tahap perampungan sarana prasarana modern dan perizinan operasional resmi. Insya Allah segera melayani pendidikan tingkat menengah atas berkarakter Qur\'ani dan unggul IPTEK.' : 'Wujudkan impian pendidikan ananda bersama ' . $info['name'] . '. Pembelajaran terintegrasi tahfidz mutqin, penguatan sains-teknologi, dan pembentukan karakter kepemimpinan islami.' }}
                </p>

                {{-- 3 KARTU BENEFIT --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3 pt-2 text-left sm:text-center">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-building-columns text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">{{ $isSmait ? 'Status Kampus' : 'Kuota Terbatas' }}</h4>
                            <p class="text-[10px] text-slate-200">{{ $isSmait ? 'Tahap Persiapan' : '24 Siswa / Kelas' }}</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-book-quran text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">{{ $isSmait ? 'Fokus Peminatan' : 'Cashback SPMB' }}</h4>
                            <p class="text-[10px] text-slate-200">{{ $isSmait ? 'Tahfidz & PTN' : 'Potongan Uang Masuk' }}</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/10 flex sm:flex-col items-center sm:justify-center space-x-3 sm:space-x-0">
                        <i class="fa-solid fa-certificate text-amber-400 text-lg mb-0 sm:mb-1 shrink-0"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white">{{ $isSmait ? 'Kurikulum Terpadu' : 'Class Meeting' }}</h4>
                            <p class="text-[10px] text-slate-200">{{ $isSmait ? 'JSIT & Merdeka' : 'Lomba Antar Sekolah' }}</p>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="pt-3 flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-2.5 sm:gap-3 w-full sm:w-auto">
                    @if(!$isSmait)
                    <a href="{{ route('school.spmb') }}?unit={{ $codeLower }}" 
                       class="w-full sm:w-auto px-7 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-105 active:scale-95 transition duration-200 flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Daftar Sekarang</span>
                    </a>
                    @endif
                    <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '0811747472', '0') }}&text={{ urlencode('Assalamu\'alaikum, saya ingin bertanya seputar informasi persiapan ' . $info['name']) }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full sm:w-auto px-6 py-3 rounded-full font-bold text-xs uppercase tracking-wider bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-md transition flex items-center justify-center space-x-2">
                        <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                        <span>{{ $isSmait ? 'Konsultasi Informasi Pembukaan' : 'Hubungi Panitia SPMB' }}</span>
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
                <div class="w-48 h-60 sm:w-64 sm:h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-slate-100 bg-slate-50 relative group">
                    <img src="{{ asset($info['principal_photo'] ?: '/images/avatar-gray-person.svg') }}" 
                         alt="{{ $info['principal_name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/images/avatar-gray-person.svg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 inset-x-0 text-center text-white px-2">
                        <span class="block text-xs sm:text-sm font-extrabold truncate">{{ $info['principal_name'] }}</span>
                        <span class="inline-block bg-amber-400 text-slate-950 font-black text-[9px] uppercase px-2 py-0.5 rounded-full mt-1">Kepala Sekolah</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                <div class="inline-flex items-center space-x-2 bg-slate-100 text-slate-800 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-user-tie text-unit-primary"></i>
                    <span>Sambutan Pimpinan Sekolah</span>
                </div>
                <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">
                    Mendidik Karakter Qur'ani &amp; Prestasi Holistik
                </h2>
                <div class="space-y-2 text-xs sm:text-sm text-gray-600 leading-relaxed font-light text-justify">
                    <p>
                        {{ \Illuminate\Support\Str::limit($info['principal_greeting'] ?? 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi kami. Kami berkomitmen menyelenggarakan pendidikan terpadu berkualitas untuk mendidik putra-putri menjadi generasi sholeh, berakhlak mulia, dan berprestasi.', 320) }}
                    </p>
                </div>
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                    <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition">
                        <span>Baca Sambutan Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/profil') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-slate-100 text-gray-700 hover:bg-slate-200 transition">
                        <span>Tentang Kami</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ========================================================
     SESI 5: WARTA & BERITA TERKINI (1 Utama + 5 List Kanan)
     ======================================================== --}}
<section id="berita" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-4 border-b border-gray-200 text-center sm:text-left">
        <div class="space-y-1">
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">Kabar Terkini</span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Warta &amp; Informasi Kampus</h2>
        </div>
        <a href="{{ url('/unit/' . $codeLower . '/artikel') }}" 
           class="inline-flex items-center justify-center sm:justify-start space-x-1 text-xs font-bold text-unit-primary hover:underline group shrink-0">
            <span>Lihat Semua Berita</span>
            <i class="fa-solid fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition"></i>
        </a>
    </div>

    @php
        $rawNews = !empty($unitNews) ? collect($unitNews)->take(6) : collect();
        $newsItems = $rawNews->map(function($item) {
            $item['title'] = str_ireplace(['siswa putra', 'siswa putri', 'para siswa', 'wali siswa', 'siswa'], ['siswa putra', 'siswa putri', 'para siswa', 'wali murid', 'siswa'], $item['title'] ?? '');
            $item['summary'] = str_ireplace(['siswa putra', 'siswa putri', 'para siswa', 'wali siswa', 'siswa'], ['siswa putra', 'siswa putri', 'para siswa', 'wali murid', 'siswa'], $item['summary'] ?? ($item['excerpt'] ?? ''));
            return $item;
        });
        $featuredNews = $newsItems->first();
        $sideNews = $newsItems->slice(1)->take(5);
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
                    <span class="absolute top-4 left-4 bg-unit-primary text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow">
                        {{ $featuredNews['category'] ?? 'Berita Utama' }}
                    </span>
                </div>
                <div class="p-6 sm:p-8 space-y-3">
                    <span class="text-xs text-gray-400 font-medium flex items-center gap-1.5">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ $featuredNews['date'] ?? '18 Sep 2026' }}</span>
                    </span>
                    <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 group-hover:text-unit-primary transition leading-snug">
                        <a href="{{ !empty($featuredNews['slug']) ? route('school.berita.show', $featuredNews['slug']) : '#' }}">
                            {{ $featuredNews['title'] }}
                        </a>
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-600 line-clamp-2 leading-relaxed text-justify">
                        {{ $featuredNews['summary'] ?: ($info['name'] . ' terus menorehkan prestasi dan menyelenggarakan kegiatan positif untuk mendukung potensi siswa.') }}
                    </p>
                </div>
            </div>

            {{-- 5 BERITA SAMPINGAN HORIZONTAL (KANAN - 5 Kolom) --}}
            <div class="lg:col-span-5 space-y-3 flex flex-col justify-between">
                @foreach($sideNews as $sItem)
                    <a href="{{ !empty($sItem['slug']) ? route('school.berita.show', $sItem['slug']) : '#' }}" 
                       class="bg-white rounded-2xl p-3.5 shadow-sm hover:shadow-md border border-gray-100 hover:border-slate-300 transition group flex items-center space-x-3.5 reveal-fade-up">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                            <img src="{{ asset($sItem['image'] ?? '/images/logo-robbani-official.png') }}" 
                                 alt="{{ $sItem['title'] }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                                 onerror="this.src='/images/logo-robbani-official.png'">
                        </div>
                        <div class="space-y-1 min-w-0 flex-1">
                            <span class="text-[10px] text-gray-400 font-medium block">
                                {{ $sItem['date'] ?? '18 Sep 2026' }}
                            </span>
                            <h4 class="text-xs font-bold text-gray-900 group-hover:text-unit-primary transition line-clamp-2 leading-snug">
                                {{ $sItem['title'] }}
                            </h4>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="col-span-12 bg-white rounded-3xl p-8 sm:p-12 text-center border border-gray-100 shadow-sm space-y-3 reveal-fade-up">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-unit-primary mx-auto flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-regular fa-newspaper"></i>
                </div>
                <h4 class="text-base font-bold text-gray-800">Belum Ada Warta Publikasi</h4>
                <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed text-center">
                    @if($codeLower === 'smait')
                        Publikasi warta dan agenda kegiatan SMA IT Robbani akan diperbarui menjelang pembukaan tahun ajaran baru.
                    @else
                        Warta dan informasi terbaru unit {{ $info['name'] }} akan dipublikasikan secara berkala.
                    @endif
                </p>
            </div>
        @endif

    </div>
</section>

{{-- ========================================================
     SESI 6: PROGRAM UNGGULAN (4 Kolom Grid)
     ======================================================== --}}
<section id="program" class="py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">Kekhasan Sekolah</span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Program Unggulan {{ $info['name'] }}</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    @php
        $programs = $info['programs'] ?? [
            ['title' => 'Tahfidz Al-Qur\'an Mutqin', 'icon' => '📖', 'desc' => 'Bimbingan tasmi\', murojaah harian, dan wisuda tahfidz tahunan bersama hafidz tersertifikasi.'],
            ['title' => 'Bilingual Arabic & English', 'icon' => '🗣️', 'desc' => 'Pembiasaan percakapan bahasa Arab dan Inggris dalam aktivitas siswa sehari-hari.'],
            ['title' => 'Bina Prestasi Sains & Riset', 'icon' => '🔬', 'desc' => 'Inkubator olimpiade matematika, sains terapan, dan koding dasar berbasis nalar ilmiah.'],
            ['title' => 'Karakter Mandiri & Kepemimpinan', 'icon' => '🌟', 'desc' => 'Mentoring kelompok kecil (BPI), kepanduan Pramuka SIT, serta pembinaan adab siswa.']
        ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        @forelse($programs as $prog)
            <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:border-amber-400 hover:-translate-y-1 transition duration-300 space-y-3 reveal-fade-up">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-unit-primary flex items-center justify-center text-2xl shadow-inner">
                    <span>{{ $prog['icon'] ?? '🌟' }}</span>
                </div>
                <h3 class="font-extrabold text-sm sm:text-base text-gray-900">{{ $prog['title'] }}</h3>
                <p class="text-xs text-gray-600 leading-relaxed font-light text-justify">{{ $prog['desc'] }}</p>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-sm space-y-2 reveal-fade-up">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-800">Kurikulum &amp; Program Unggulan Dalam Tahap Finalisasi</h4>
                <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                    Rancangan kurikulum terpadu JSIT dan program peminatan unggulan SMA IT Robbani sedang dipersiapkan untuk menyambut pembukaan resmi.
                </p>
            </div>
        @endforelse
    </div>

    <div class="text-center pt-2">
        <a href="{{ url('/unit/' . $codeLower . '/program-unggulan') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition">
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
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">Tenaga Pendidik</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Dewan Guru &amp; Tenaga Kependidikan</h2>
        <div class="w-16 h-1 bg-unit-primary rounded-full mx-auto"></div>
    </div>

    @php
        $teacherList = !empty($info['teachers']) ? array_slice($info['teachers'], 0, 8) : [];
    @endphp

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @forelse($teacherList as $tc)
            <div class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:shadow-2xl hover:-translate-y-1 transition duration-300 reveal-fade-up text-center group">
                <div class="h-44 sm:h-64 overflow-hidden bg-slate-50">
                    <img src="{{ asset($tc['photo'] ?? '/images/avatar-gray-person.svg') }}" 
                         alt="{{ $tc['name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/images/avatar-gray-person.svg'">
                </div>
                <div class="p-3 sm:p-4 space-y-1">
                    <h3 class="text-xs sm:text-sm font-bold text-gray-900 line-clamp-1">{{ $tc['name'] }}</h3>
                    <p class="text-[10px] sm:text-xs text-unit-primary font-semibold truncate">{{ $tc['role'] }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-2 sm:col-span-3 lg:col-span-4 bg-white rounded-3xl p-8 text-center border border-gray-100 shadow-sm space-y-2 reveal-fade-up">
                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-unit-primary mx-auto flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <h4 class="text-sm font-bold text-gray-800">Formasi Pendidik Sedang Dipersiapkan</h4>
                <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                    Perekrutan dan penempatan guru serta tenaga kependidikan SMA IT Robbani dalam proses seleksi kualifikasi terbaik.
                </p>
            </div>
        @endforelse
    </div>

    <div class="text-center pt-2">
        <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition">
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
                @php
                    $embedId = $v['embed_id'] ?? '';
                    if (empty($embedId) && !empty($v['url'])) {
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $v['url'], $match)) {
                            $embedId = $match[1];
                        }
                    }
                    $rawThumb = !empty($v['thumbnail']) ? $v['thumbnail'] : (!empty($v['image']) ? $v['image'] : '');
                    if (!empty($embedId) && (empty($rawThumb) || str_contains($rawThumb, 'mockup') || str_contains($rawThumb, 'logo-robbani') || str_contains($rawThumb, 'galeri-'))) {
                        $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                    } elseif (!empty($rawThumb)) {
                        $videoThumb = (str_starts_with($rawThumb, 'http://') || str_starts_with($rawThumb, 'https://')) ? $rawThumb : asset($rawThumb);
                    } elseif (!empty($embedId)) {
                        $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                    } else {
                        $videoThumb = asset('/images/mockup_desktop_4.png');
                    }
                @endphp
                <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 shadow-xl group flex flex-col justify-between reveal-fade-up">
                    <div class="relative h-44 sm:h-48 bg-slate-800 flex items-center justify-center overflow-hidden cursor-pointer"
                         @if(!empty($embedId)) @click="activeVideo = '{{ $embedId }}'" @else onclick="window.open('{{ $v['url'] ?? 'https://youtube.com' }}', '_blank')" @endif>
                        <img src="{{ $videoThumb }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover opacity-85 group-hover:scale-105 transition duration-500" onerror="this.onerror=null; @if(!empty($embedId)) this.src='https://img.youtube.com/vi/{{ $embedId }}/hqdefault.jpg'; @else this.src='/images/mockup_desktop_4.png'; @endif">
                        <div class="absolute inset-0 bg-black/25 group-hover:bg-black/10 transition duration-300"></div>
                        @if(!empty($embedId))
                            <button type="button" @click.stop="activeVideo = '{{ $embedId }}'" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition cursor-pointer" aria-label="Putar Video">
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
                    @php
                        $embedId = $v['embed_id'] ?? '';
                        if (empty($embedId) && !empty($v['url'])) {
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $v['url'], $match)) {
                                $embedId = $match[1];
                            }
                        }
                        $rawThumb = !empty($v['thumbnail']) ? $v['thumbnail'] : (!empty($v['image']) ? $v['image'] : '');
                        if (!empty($embedId) && (empty($rawThumb) || str_contains($rawThumb, 'mockup') || str_contains($rawThumb, 'logo-robbani') || str_contains($rawThumb, 'galeri-'))) {
                            $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                        } elseif (!empty($rawThumb)) {
                            $videoThumb = (str_starts_with($rawThumb, 'http://') || str_starts_with($rawThumb, 'https://')) ? $rawThumb : asset($rawThumb);
                        } elseif (!empty($embedId)) {
                            $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                        } else {
                            $videoThumb = asset('/images/mockup_desktop_4.png');
                        }
                    @endphp
                    <div class="bg-slate-900 rounded-2xl overflow-hidden border border-slate-800 shadow-xl group flex flex-col justify-between reveal-fade-up">
                        <div class="relative h-44 sm:h-48 bg-slate-800 flex items-center justify-center overflow-hidden cursor-pointer"
                             @if(!empty($embedId)) @click="activeVideo = '{{ $embedId }}'" @else onclick="window.open('{{ $v['url'] ?? 'https://youtube.com' }}', '_blank')" @endif>
                            <img src="{{ $videoThumb }}" alt="{{ $v['title'] }}" class="w-full h-full object-cover opacity-85 group-hover:scale-105 transition duration-500" onerror="this.onerror=null; @if(!empty($embedId)) this.src='https://img.youtube.com/vi/{{ $embedId }}/hqdefault.jpg'; @else this.src='/images/mockup_desktop_4.png'; @endif">
                            <div class="absolute inset-0 bg-black/25 group-hover:bg-black/10 transition duration-300"></div>
                            @if(!empty($embedId))
                                <button type="button" @click.stop="activeVideo = '{{ $embedId }}'" class="absolute w-12 h-12 rounded-full bg-red-600 text-white flex items-center justify-center text-lg shadow-lg group-hover:scale-110 transition cursor-pointer" aria-label="Putar Video">
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
     SESI 9: PENGUMUMAN & AGENDA AKADEMIK (2 Kolom Sejajar)
     ======================================================== --}}
<section id="agenda" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{ activeAnnouncement: null }">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 items-stretch">
        
        {{-- KOLOM PENGUMUMAN RESMI --}}
        @php
            $displayAnnouncements = !empty($unitAnnouncements) ? array_slice($unitAnnouncements, 0, 3) : [
                [
                    'category' => 'Akademik',
                    'date' => '18 Sep 2026',
                    'title' => 'Jadwal Penilaian Tengah Semester (PTS) TA 2026/2027',
                    'summary' => 'Diharapkan seluruh siswa mempersiapkan diri dengan belajar tekun dan menjaga kesehatan jasmani rohani.'
                ],
                [
                    'category' => 'Tahfidz',
                    'date' => '10 Sep 2026',
                    'title' => 'Pendaftaran Ujian Munaqosah Tahfidz Al-Qur\'an Periode Ganjil',
                    'summary' => 'Pendaftaran tasmi\' dan munaqosah terbuka bagi siswa yang telah menyelesaikan target hafalan mutqin.'
                ],
                [
                    'category' => 'Wali Murid',
                    'date' => '02 Sep 2026',
                    'title' => 'Pertemuan Parenting & Laporan Perkembangan Karakter Siswa',
                    'summary' => 'Undangan silaturahmi akbar dan parenting bersama pakar pendidikan keluarga Islam di kampus SIT Robbani.'
                ]
            ];

            $agendas = !empty($unitAgendas) ? array_slice($unitAgendas, 0, 3) : [
                ['title' => 'Munaqosah & Ujian Tahfidz Al-Qur\'an', 'date_day' => '05', 'date_month' => 'JUL', 'location' => 'Masjid Kampus'],
                ['title' => 'Pendaftaran SPMB Gelombang Exclusive', 'date_day' => '25', 'date_month' => 'JUN', 'location' => 'Kantor SPMB / Online'],
                ['title' => 'Pembukaan Class Meeting Semester Genap', 'date_day' => '17', 'date_month' => 'JUN', 'location' => 'Lapangan Kampus']
            ];
        @endphp

        <div class="bg-white rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 flex flex-col justify-between h-full space-y-5 reveal-fade-up">
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-sm sm:text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-unit-primary"></i>
                        <span>Pengumuman Resmi</span>
                    </h3>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-unit-primary bg-slate-100 px-2.5 py-1 rounded-full">
                        Warta Kampus
                    </span>
                </div>
                <div class="space-y-3">
                    @foreach($displayAnnouncements as $idx => $an)
                        <div @click="activeAnnouncement = {{ Js::from($an) }}" 
                             class="p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-200/80 hover:border-amber-400 transition cursor-pointer group space-y-1.5">
                            <div class="flex items-center justify-between text-[10px] font-bold text-unit-primary uppercase">
                                <span>{{ $an['category'] ?? 'Pengumuman' }}</span>
                                <span class="text-slate-400 font-normal">{{ $an['date'] ?? 'Terbaru' }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-gray-900 group-hover:text-unit-primary transition line-clamp-2">
                                {{ $an['title'] }}
                            </h4>
                            <p class="text-[11px] text-gray-500 line-clamp-2 font-light text-justify">
                                {{ $an['summary'] ?? ($an['desc'] ?? 'Pemberitahuan resmi dari pihak sekolah.') }}
                            </p>
                            <div class="pt-1 flex items-center text-[10px] font-bold text-unit-primary group-hover:underline">
                                <span>Lihat Detail Pengumuman</span>
                                <i class="fa-solid fa-chevron-right text-[8px] ml-1"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ url('/unit/' . $codeLower . '/pengumuman') }}" 
                   class="w-full inline-flex items-center justify-center space-x-2 py-3 rounded-2xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-gray-800 transition">
                    <span>Lihat Semua Pengumuman</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- KOLOM AGENDA AKADEMIK (SEJAJAR DI BATAS BAWAH) --}}
        <div class="bg-white rounded-3xl p-5 sm:p-8 shadow-xl border border-gray-100 flex flex-col justify-between h-full space-y-5 reveal-fade-up delay-1">
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-sm sm:text-base font-extrabold text-gray-900 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-unit-primary"></i>
                        <span>Agenda Kegiatan</span>
                    </h3>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                        Jadwal Akademik
                    </span>
                </div>
                <div class="space-y-3">
                    @foreach($agendas as $ag)
                        <div class="flex items-start space-x-3.5 p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-amber-400 transition">
                            <div class="w-12 h-12 rounded-xl bg-white text-unit-primary border border-slate-200 shadow-sm flex flex-col items-center justify-center shrink-0">
                                <span class="text-xs font-black">{{ $ag['date_day'] ?? '15' }}</span>
                                <span class="text-[9px] font-extrabold uppercase mt-0.5 tracking-wider text-amber-600">{{ $ag['date_month'] ?? 'JUL' }}</span>
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
            <div class="pt-4 border-t border-gray-100">
                <a href="{{ url('/unit/' . $codeLower . '/agenda') }}" 
                   class="w-full inline-flex items-center justify-center space-x-2 py-3 rounded-2xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-gray-800 transition">
                    <span>Lihat Semua Agenda</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- MODAL DETAIL PENGUMUMAN RESMI --}}
    <div x-show="activeAnnouncement" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm"
         style="display: none;"
         @keydown.escape.window="activeAnnouncement = null">
        <div class="relative w-full max-w-lg bg-white rounded-3xl overflow-hidden shadow-2xl border border-gray-100 p-6 sm:p-8 space-y-4" @click.outside="activeAnnouncement = null">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-unit-primary text-white" x-text="activeAnnouncement?.category || 'Pengumuman Resmi'"></span>
                <button @click="activeAnnouncement = null" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 hover:text-gray-800 flex items-center justify-center text-sm transition cursor-pointer">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="space-y-2">
                <span class="text-[11px] text-gray-400 font-medium flex items-center gap-1.5">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span x-text="activeAnnouncement?.date || 'Terbaru'"></span>
                </span>
                <h3 class="text-base sm:text-lg font-black text-gray-900 leading-snug" x-text="activeAnnouncement?.title"></h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light text-justify pt-1" x-text="activeAnnouncement?.summary || activeAnnouncement?.desc"></p>
            </div>
            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                <a :href="'{{ url('/unit/' . $codeLower . '/pengumuman') }}'" class="text-xs font-bold text-unit-primary hover:underline">
                    Buka Halaman Pengumuman &rarr;
                </a>
                <button @click="activeAnnouncement = null" class="px-5 py-2 rounded-full text-xs font-bold bg-gray-100 hover:bg-gray-200 text-gray-700 transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</section>

{{-- ========================================================
     SESI 10: GALERI FOTO SISWA
     ======================================================== --}}
<section id="galeri" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">Dokumentasi Siswa</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Galeri Foto Siswa</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
        @php
            $displayGallery = !empty($unitGallery) ? array_slice($unitGallery, 0, 6) : [];
        @endphp
        @forelse($displayGallery as $g)
            <div class="rounded-2xl overflow-hidden shadow-md h-52 sm:h-60 bg-gray-100 group relative reveal-fade-up">
                <img src="{{ asset($g['image'] ?? '/images/logo-robbani-official.png') }}" 
                     alt="{{ $g['title'] ?? 'Dokumentasi Siswa' }}" 
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
        <a href="{{ url('/unit/' . $codeLower . '/galeri') }}" 
           class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition">
            <span>Lihat Semua Foto Kegiatan</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</section>

{{-- ========================================================
     SESI 11: CALL-TO-ACTION HIGH CONVERSION BANNER
     ======================================================== --}}
<section class="py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="rounded-3xl bg-gradient-to-r {{ $uTheme['nav_gradient'] }} p-6 sm:p-12 text-white shadow-2xl border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left reveal-fade-up">
        <div class="space-y-2">
            <span class="inline-block bg-amber-400 text-slate-950 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                {{ $isSmait ? 'Tahap Persiapan' : 'Kuota Terbatas!' }}
            </span>
            <h3 class="text-xl sm:text-3xl font-black text-white tracking-tight">
                {{ $isSmait ? 'Pusat Informasi ' . $info['name'] : 'Daftar Sekarang di ' . $info['name'] }}
            </h3>
            <p class="text-xs sm:text-sm text-slate-100 font-light max-w-xl text-justify">
                {{ $isSmait ? 'Dapatkan update informasi jadwal pembukaan dan konsultasi kurikulum jenjang SMA IT Robbani.' : 'Amankan kursi belajar terbaik ananda sekarang juga sebelum kuota penerimaan terpenuhi.' }}
            </p>
        </div>
        @if($isSmait)
            <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '0811747472', '0') }}&text={{ urlencode('Assalamu\'alaikum, saya ingin bertanya seputar info pembukaan ' . $info['name']) }}" 
               target="_blank" rel="noopener noreferrer"
               class="w-full sm:w-auto px-8 py-3.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:scale-105 active:scale-95 transition shrink-0 flex items-center justify-center space-x-2">
                <i class="fa-brands fa-whatsapp text-base"></i>
                <span>Konsultasi Informasi</span>
            </a>
        @else
            <a href="{{ route('school.spmb') }}?unit={{ $codeLower }}" 
               class="w-full sm:w-auto px-8 py-3.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:scale-105 active:scale-95 transition shrink-0 flex items-center justify-center space-x-2">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Daftar SPMB Online</span>
            </a>
        @endif
    </div>
</section>

{{-- ========================================================
     SESI 12: SLIDER COVER BUKU DIGITAL & E-BOOK DOWNLOAD
     ======================================================== --}}
@php
    $unitBookLibrary = [
        'tkit' => [
            [
                'title' => 'Buku Saku Doa Harian & Adab Anak Shalih',
                'category' => 'Adab & Karakter',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pdf' => '/downloads/ebooks/buku-saku-adab-karakter-siswa.pdf',
                'desc' => 'Koleksi doa harian, adab makan, tidur, dan pembiasaan islami anak usia dini.',
                'size' => '1.4 MB'
            ],
            [
                'title' => 'Metode Nasyid Hafalan Juz 30 Cilik',
                'category' => 'Tahfidz Al-Qur\'an',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pdf' => '/downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf',
                'desc' => 'Metode menyenangkan mengenalkan surat-surat pendek Juz Amma bagi anak prasekolah.',
                'size' => '1.9 MB'
            ],
            [
                'title' => 'Kamus Bergambar Kosakata Bilingual Kids',
                'category' => 'Bahasa Arab & Inggris',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pdf' => '/downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf',
                'desc' => 'Kamus tematik visual percakapan dasar Bahasa Arab dan Inggris anak usia dini.',
                'size' => '1.6 MB'
            ],
            [
                'title' => 'Modul Sentra & Bermain Kreatif PAUD IT',
                'category' => 'Sentra Edukatif',
                'cover' => '/uploads/covers/cover-sentra-tkit.webp',
                'pdf' => '/downloads/ebooks/modul-sentra-dan-bermain-kreatif-tkit.pdf',
                'desc' => 'Panduan aktivitas stimulasi motorik halus, sensorik, dan kreativitas sentra.',
                'size' => '1.8 MB'
            ]
        ],
        'sdit' => [
            [
                'title' => 'Buku Saku 10 Karakter Muwashofat SDIT',
                'category' => 'Adab & Karakter',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pdf' => '/downloads/ebooks/buku-saku-adab-karakter-siswa.pdf',
                'desc' => '10 indikator karakter pribadi muslim tangguh dan mandiri standar mutu JSIT Indonesia.',
                'size' => '1.4 MB'
            ],
            [
                'title' => 'Target Mutqin Tahfidz Juz 29 & 30 SDIT',
                'category' => 'Tahfidz Al-Qur\'an',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pdf' => '/downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf',
                'desc' => 'Silabus hafalan bergradasi, tata cara tasmi\', dan metode muroja\'ah mandiri siswa.',
                'size' => '1.9 MB'
            ],
            [
                'title' => 'Kamus Percakapan Bilingual SDIT',
                'category' => 'Bahasa Arab & Inggris',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pdf' => '/downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf',
                'desc' => 'Ungkapan sehari-hari bilingual untuk percakapan di sekolah dan lingkungan rumah.',
                'size' => '1.6 MB'
            ],
            [
                'title' => 'Modul Literasi Sains Tematik SDIT',
                'category' => 'Sains & Literasi',
                'cover' => '/uploads/covers/cover-tematik-sdit.webp',
                'pdf' => '/downloads/ebooks/modul-literasi-sains-tematik-sdit.pdf',
                'desc' => 'Pembelajaran integrasi ayat-ayat kauniyah dan sains terapan dasar tingkat SD.',
                'size' => '1.8 MB'
            ]
        ],
        'smpit' => [
            [
                'title' => 'Panduan Kurikulum Tahfidz Mutqin 3 Juz',
                'category' => 'Tahfidz Al-Qur\'an',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pdf' => '/downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf',
                'desc' => 'Panduan tasmi\' bersanad, mutabaah munaqosah hafalan Al-Qur\'an 3 Juz SMPIT.',
                'size' => '1.9 MB'
            ],
            [
                'title' => 'Buku Saku Karakter Pemimpin Robbani',
                'category' => 'Adab & Muwashofat',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pdf' => '/downloads/ebooks/buku-saku-adab-karakter-siswa.pdf',
                'desc' => 'Pedoman adab penuntut ilmu, manajemen waktu, dan integritas kepemimpinan islami.',
                'size' => '1.4 MB'
            ],
            [
                'title' => 'Petunjuk Praktikum Laboratorium IPA',
                'category' => 'Sains & Riset',
                'cover' => '/uploads/covers/cover-praktikum-sains.webp',
                'pdf' => '/downloads/ebooks/petunjuk-praktikum-lab-ipa-terpadu.pdf',
                'desc' => 'Buku kerja eksperimen biologi, fisika, dan kimia terapan berbasis nalar ilmiah.',
                'size' => '1.8 MB'
            ],
            [
                'title' => 'Modul Pembinaan Da\'i & Public Speaking',
                'category' => 'Khitabah & Bahasa',
                'cover' => '/uploads/covers/cover-dai-muda.webp',
                'pdf' => '/downloads/ebooks/modul-pembinaan-dai-muda-public-speaking.pdf',
                'desc' => 'Khitabah, teknik pidato 3 bahasa, dan latihan percaya diri tampil di depan publik.',
                'size' => '1.5 MB'
            ],
            [
                'title' => 'Kamus Kosakata Harian Bilingual SMPIT',
                'category' => 'Language Center',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pdf' => '/downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf',
                'desc' => 'Koleksi kosakata tematik Arab-Inggris untuk percakapan aktif siswa sehari-hari.',
                'size' => '1.6 MB'
            ],
            [
                'title' => 'Panduan Sukses Asesmen Nasional & SNBT',
                'category' => 'Prestasi Akademik',
                'cover' => '/uploads/covers/cover-sukses-snbt.webp',
                'pdf' => '/downloads/ebooks/panduan-sukses-asesmen-nasional-snbt.pdf',
                'desc' => 'Strategi literasi, numerasi, dan penguatan konsep dasar materi tes skolastik.',
                'size' => '2.1 MB'
            ]
        ],
        'smait' => [
            [
                'title' => 'Panduan Kurikulum JSIT Lanjutan & PTN',
                'category' => 'Persiapan PTN & Beasiswa',
                'cover' => '/uploads/covers/cover-sukses-snbt.webp',
                'pdf' => '/downloads/ebooks/panduan-sukses-asesmen-nasional-snbt.pdf',
                'desc' => 'Strategi sukses tembus SNBP, UTBK SNBT, dan beasiswa perguruan tinggi unggulan.',
                'size' => '2.1 MB'
            ],
            [
                'title' => 'Modul Riset Karya Ilmiah Remaja & Al-Qur\'an',
                'category' => 'Riset & Nalar Qur\'ani',
                'cover' => '/uploads/covers/cover-praktikum-sains.webp',
                'pdf' => '/downloads/ebooks/petunjuk-praktikum-lab-ipa-terpadu.pdf',
                'desc' => 'Metodologi penelitian sains terintegrasi nilai-nilai keislaman bagi siswa SMA.',
                'size' => '1.8 MB'
            ],
            [
                'title' => 'Buku Saku Kepemimpinan Pemuda Muslim',
                'category' => 'Karakter & Dakwah',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pdf' => '/downloads/ebooks/buku-saku-adab-karakter-siswa.pdf',
                'desc' => 'Penguatan aqidah, wawasan kebangsaan, dan integritas moral generasi muda.',
                'size' => '1.4 MB'
            ],
            [
                'title' => 'Panduan Tahfidz Mutqin Lanjutan 5 Juz',
                'category' => 'Tahfidz Al-Qur\'an',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pdf' => '/downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf',
                'desc' => 'Metode menjaga kelancaran hafalan dan persiapan sertifikasi munaqosah 5 Juz.',
                'size' => '1.9 MB'
            ]
        ]
    ];
    $activeBooks = $unitBookLibrary[$codeLower] ?? $unitBookLibrary['smpit'];
@endphp

<section class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto" x-data="{
    books: {{ Js::from($activeBooks) }},
    currentIndex: 0,
    maxIndex() {
        return Math.max(0, this.books.length - (window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1)));
    },
    next() {
        if (this.currentIndex < this.maxIndex()) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0;
        }
    },
    prev() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.maxIndex();
        }
    }
}">
    <div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} rounded-3xl p-6 sm:p-12 text-white space-y-6 sm:space-y-8 border border-white/10 shadow-2xl reveal-fade-up">
        
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-2 border-b border-white/10 text-center sm:text-left">
            <div class="space-y-1">
                <span class="text-xs font-black uppercase tracking-wider text-amber-400 block">Kurikulum Holistik &amp; Perpustakaan Digital</span>
                <h2 class="text-xl sm:text-3xl font-extrabold text-white tracking-tight">Etalase Modul &amp; E-Book Resmi Siswa</h2>
                <p class="text-xs text-slate-300 font-light">Unduh gratis buku pedoman kurikulum, buku saku adab, dan modul suplemen resmi {{ $info['name'] }}.</p>
            </div>
            <div class="flex items-center space-x-2 shrink-0">
                <button @click="prev()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" aria-label="Sebelumnya">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </button>
                <button @click="next()" class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition cursor-pointer" aria-label="Berikutnya">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </button>
            </div>
        </div>

        {{-- BOOK COVERS SLIDER --}}
        <div class="overflow-hidden">
            <div class="flex transition-transform duration-500 ease-out gap-4 sm:gap-6" 
                 :style="'transform: translateX(-' + (currentIndex * (100 / (window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1)))) + '%)'">
                @foreach($activeBooks as $b)
                    <div class="w-full sm:w-1/2 lg:w-1/4 shrink-0 bg-white rounded-3xl p-4 sm:p-5 text-gray-900 shadow-xl flex flex-col justify-between border border-gray-100 group">
                        <div class="space-y-3">
                            <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden bg-slate-900 shadow-md border border-gray-100">
                                <img src="{{ asset($b['cover']) }}" 
                                     alt="{{ $b['title'] }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                     onerror="this.src='/images/logo-robbani-official.png'">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow">
                                    PDF &bull; {{ $b['size'] }}
                                </span>
                                <span class="absolute bottom-2.5 left-3 right-3 text-[10px] font-bold text-white truncate">
                                    {{ $b['category'] }}
                                </span>
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-xs sm:text-sm font-black text-gray-900 line-clamp-2 leading-snug group-hover:text-unit-primary transition">
                                    {{ $b['title'] }}
                                </h3>
                                <p class="text-[11px] text-gray-500 line-clamp-2 font-light text-justify">
                                    {{ $b['desc'] }}
                                </p>
                            </div>
                        </div>

                        <div class="pt-3 mt-3 border-t border-gray-100 flex flex-col gap-2">
                            <a href="{{ asset($b['pdf']) }}" 
                               download 
                               class="w-full inline-flex items-center justify-center space-x-1.5 py-2.5 rounded-xl font-bold text-xs bg-unit-primary text-white hover:brightness-110 shadow transition">
                                <i class="fa-solid fa-download text-xs"></i>
                                <span>Unduh PDF</span>
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" 
                               class="text-[10px] font-bold text-gray-500 hover:text-unit-primary text-center transition">
                                Detail di Laman E-Book &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/10 text-center sm:text-left">
            <span class="text-xs text-slate-300">
                Menyediakan beragam modul literasi Qur'ani, sains terapan, pembinaan bahasa, dan adab karakter.
            </span>
            <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" 
               class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/20 hover:brightness-105 transition shrink-0">
                <i class="fa-solid fa-book-open"></i>
                <span>Buka Seluruh Etalase E-Book</span>
            </a>
        </div>

    </div>
</section>

{{-- ========================================================
     SESI 13: TESTIMONI WALI MURID & ALUMNI
     ======================================================== --}}
<section id="testimoni" class="py-10 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
    <div class="text-center space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">Kesan &amp; Pengalaman</span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Testimoni Wali &amp; Alumni</h2>
        <div class="w-16 h-1 bg-amber-400 rounded-full mx-auto"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        @php
            $testimonials = !empty($info['alumni']) ? $info['alumni'] : [
                ['name' => 'Wali Murid Angkatan 2025', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di sekolah ini luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/images/avatar-gray-person.svg'],
                ['name' => 'Ahmad Faiz', 'title' => 'Alumni Berprestasi', 'text' => 'Fasilitas belajar modern dan bimbingan para guru sangat mendukung minat saya di bidang sains dan tahfidz.', 'avatar' => '/images/avatar-gray-person.svg'],
                ['name' => 'Bunda Siti', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/images/avatar-gray-person.svg']
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
                        <img src="{{ asset($t['avatar'] ?? '/images/avatar-gray-person.svg') }}" 
                             alt="{{ $t['name'] }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='/images/avatar-gray-person.svg'">
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
        <a href="{{ route('school.spmb') }}?unit={{ $codeLower }}" class="bg-white rounded-2xl p-4 sm:p-5 shadow-lg border-t-4 border-unit-primary hover:shadow-xl transition flex items-center space-x-3.5 sm:space-x-4">
            <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl bg-slate-50 text-unit-primary flex items-center justify-center text-lg sm:text-xl shrink-0">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-900">Pendaftaran SPMB Online</h4>
                <p class="text-[11px] text-gray-500">Buka formulir online siswa baru</p>
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
                <p class="text-[11px] text-gray-500">Program siswa yatim dhuafa</p>
            </div>
        </a>
    </div>
</section>

@endsection
