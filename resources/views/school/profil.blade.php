<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Resmi & Sambutan Pimpinan | {{ $foundationProfile['name'] ?? $settings['school_name'] }}</title>
    <meta name="description" content="Profil Resmi, Sambutan Pimpinan, Visi Misi, dan 5 Pilar Utama Pendidikan Yayasan Generasi Robbani Sumatera Selatan.">

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=11">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=11">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=11">
    <link rel="image_src" href="{{ asset('images/og_share_robbani.png') }}?v=11">

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Yayasan Generasi Robbani Sumatera Selatan">
    <meta property="og:title" content="Profil Resmi &amp; Sambutan Pimpinan Yayasan Generasi Robbani">
    <meta property="og:description" content="Penyelenggara Pendidikan Islam Terpadu (KB/TKIT, SDIT, SMPIT, &amp; SMAIT Robbani Ogan Ilir) - Indralaya Utara, Ogan Ilir.">
    <meta property="og:image" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:secure_url" content="{{ asset('images/og_share_robbani.png') }}?v=11">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="id_ID">

    <!-- Tailwind CSS CDN with Custom Color Extensions -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              emerald: {
                950: '#040d06',
                900: '#07170a',
                800: '#0d1e0f',
                700: '#004532',
                600: '#059669',
              },
              neon: {
                lime: '#c6f634',
                bright: '#a3e635'
              }
            },
            fontFamily: {
              body: ["Inter", "sans-serif"],
              headline: ["Montserrat", "sans-serif"],
              sans: ["Inter", "sans-serif"]
            },
            keyframes: {
              'pulse-slow': {
                '0%, 100%': { opacity: '0.4', transform: 'scale(1)' },
                '50%': { opacity: '0.8', transform: 'scale(1.05)' }
              },
              'float': {
                '0%, 100%': { transform: 'translateY(0px)' },
                '50%': { transform: 'translateY(-8px)' }
              }
            },
            animation: {
              'pulse-glow': 'pulse-slow 4s infinite ease-in-out',
              'float-badge': 'float 3s infinite ease-in-out'
            }
          }
        }
      }
    </script>

    <!-- Google Fonts & Alpine.js -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Montserrat:wght@700;800;900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .font-headline { font-family: 'Montserrat', sans-serif; }
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
<body class="bg-slate-50 dark:bg-[#040d06] text-slate-900 dark:text-[#f0fdf4] antialiased min-h-screen flex flex-col justify-between transition-colors duration-300">

    @include('school.partials.header')

    <!-- Main Content Container: Seamless Vertical Scroll Layout Top to Bottom -->
    <main class="flex-grow space-y-16 sm:space-y-20 pb-20">
        
        <!-- SECTION 1: HERO HEADER BANNER -->
        <section class="relative py-14 sm:py-20 overflow-hidden bg-gradient-to-b from-emerald-900/90 via-[#004532] to-[#040d06] text-white">
            <!-- Glowing Ambient Halos -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-500/20 dark:bg-[#c6f634]/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-emerald-400/20 dark:bg-emerald-500/15 rounded-full blur-3xl pointer-events-none animate-pulse-glow" style="animation-delay: 2s;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 text-center space-y-6">
                <!-- Floating Badge -->
                <div class="inline-flex items-center gap-2 bg-white/10 dark:bg-[#c6f634]/20 border border-white/20 dark:border-[#c6f634]/40 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider text-amber-300 dark:text-[#c6f634] shadow-md animate-float-badge">
                    <span class="w-2 h-2 rounded-full bg-orange-400 dark:bg-[#c6f634] animate-ping"></span>
                    <span>✨ PROFIL RESMI YAYASAN</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black font-headline tracking-tight text-white dark:text-[#f0fdf4] drop-shadow-md max-w-4xl mx-auto leading-tight">
                    {{ $foundationProfile['name'] ?? $settings['school_name'] }}
                </h1>

                <p class="text-slate-200 dark:text-emerald-100 font-medium text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                    {{ $foundationProfile['tagline'] }} — Didirikan tahun {{ $foundationProfile['founded_year'] ?? '2014' }} di Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan.
                </p>
            </div>
        </section>

        <!-- SECTION 2: KATA SAMBUTAN KETUA YAYASAN -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 sm:p-10 lg:p-12 shadow-xl grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Left: Chairman Photo Frame -->
                <div class="lg:col-span-4 text-center space-y-4">
                    <div class="relative w-48 sm:w-56 h-48 sm:h-56 mx-auto rounded-3xl overflow-hidden border-4 border-emerald-600 dark:border-[#c6f634] shadow-2xl bg-slate-900 group">
                        <img src="{{ !empty($foundationProfile['chairman_photo']) && !str_contains($foundationProfile['chairman_photo'], 'principal_photo_6a7f525a6292e') ? asset($foundationProfile['chairman_photo']) : asset('images/sughesti_wulandari.webp') }}" alt="{{ $foundationProfile['chairman_name'] ?? 'Sughesti Wulandari, S.Pd' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.onerror=null; this.src='{{ asset('images/sughesti_wulandari.webp') }}';">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-lg sm:text-xl font-black font-headline text-slate-900 dark:text-white">{{ $foundationProfile['chairman_name'] }}</h3>
                        <span class="text-xs font-bold text-emerald-700 dark:text-[#c6f634] bg-emerald-100 dark:bg-[#0d1e0f] px-3.5 py-1 rounded-full inline-block border border-emerald-200 dark:border-[#1a381c]">{{ $foundationProfile['chairman_title'] }}</span>
                    </div>
                </div>

                <!-- Right: Speech Text -->
                <div class="lg:col-span-8 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-orange-100 dark:bg-[#c6f634]/20 text-orange-700 dark:text-[#c6f634] text-xs font-black uppercase">
                        <span>💬</span> <span>KATA SAMBUTAN RESMI</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white leading-tight">
                        Membangun Peradaban Rabbani Berbasis Al-Qur'an &amp; Sains Digital
                    </h2>
                    <div class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 leading-relaxed space-y-4 border-l-4 border-emerald-600 dark:border-[#c6f634] pl-4 italic bg-slate-50 dark:bg-[#0d1e0f]/50 p-4.5 rounded-r-2xl">
                        {!! $foundationProfile['chairman_greeting'] !!}
                    </div>
                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <a href="{{ route('school.spmb') }}" class="px-6 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 dark:bg-[#c6f634] dark:hover:bg-[#a3e635] text-white dark:text-[#040d06] font-black text-xs shadow-md transition-transform hover:scale-105 flex items-center gap-1.5">
                            <span>Daftar SPMB Online</span> ➔
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="px-5 py-3 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-extrabold text-xs shadow-sm transition-transform hover:scale-105">
                            Hubungi Sekretariat Yayasan 💬
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- SECTION 3: VISI & MISI YAYASAN -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2">
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 dark:bg-[#c6f634]/20 text-orange-700 dark:text-[#c6f634] text-xs font-black uppercase">ARAH &amp; TUJUAN YAYASAN</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Visi &amp; Misi Utama Yayasan</h2>
            </div>

            <!-- Vision Highlight Banner -->
            <div class="bg-gradient-to-r from-[#004532] to-emerald-800 dark:from-[#0d1e0f] dark:to-[#07170a] text-white p-8 sm:p-12 rounded-3xl border border-emerald-700 dark:border-[#1a381c] shadow-2xl relative overflow-hidden text-center space-y-4">
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-orange-500/20 dark:bg-[#c6f634]/10 rounded-full blur-2xl pointer-events-none"></div>
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-500 dark:bg-[#c6f634] text-white dark:text-[#040d06] text-xs font-black uppercase tracking-wider">VISI UTAMA YAYASAN</span>
                <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold leading-snug max-w-4xl mx-auto italic">
                    "{{ $foundationProfile['vision'] }}"
                </h2>
            </div>

            <!-- Mission Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($foundationProfile['missions'] as $idx => $m)
                <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-orange-500 transition-all flex items-start gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-orange-500 dark:bg-[#c6f634] text-white dark:text-[#040d06] font-black text-lg flex items-center justify-center shrink-0 shadow-md group-hover:scale-110 transition-transform">
                        {{ $idx + 1 }}
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-xs font-black text-orange-600 dark:text-[#c6f634] uppercase tracking-wider">MISI YAYASAN #{{ $idx + 1 }}</h3>
                        <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium leading-relaxed">{{ $m }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION 4: 5 PILAR UTAMA KURIKULUM SIT ROBBANI -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-[#c6f634]/20 text-[#004532] dark:text-[#c6f634] text-xs font-black uppercase">KEKHASAN JSIT &amp; KHARAKTER QUR'ANI</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">5 Pilar Utama Kurikulum SIT Robbani</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Fondasi pendidikan karakter, ilmu keislaman, dan penguasaan teknologi abad 21.</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                @foreach($foundationProfile['pillars'] as $p)
                <div class="w-full sm:w-[calc(50%-12px)] lg:w-[calc(33.333%-16px)] bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 space-y-3 group">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-[#0d1e0f] text-2xl flex items-center justify-center shadow-xs border border-emerald-200 dark:border-[#1a381c] group-hover:scale-110 transition-transform">
                        {{ $p['icon'] }}
                    </div>
                    <h3 class="text-base font-black font-headline text-slate-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">{{ $p['title'] }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-medium">{{ $p['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        <!-- SECTION 5: STRUKTUR PENGURUS YAYASAN (FOKUS KETUA YAYASAN) -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2">
                <span class="inline-block px-4 py-1.5 rounded-full bg-orange-100 dark:bg-[#c6f634]/20 text-orange-700 dark:text-[#c6f634] text-xs font-black uppercase">STRUKTUR ORGANISASI</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">Pimpinan Yayasan Generasi Robbani</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Pengelola resmi penyelenggara pendidikan Islam Terpadu SIT Robbani Ogan Ilir.</p>
            </div>

            <!-- Single Centered Ketua Yayasan Card -->
            <div class="max-w-sm mx-auto">
                <div class="bg-white dark:bg-[#07170a] border-2 border-emerald-600 dark:border-[#c6f634] rounded-3xl p-6 text-center space-y-4 shadow-xl hover:shadow-2xl transition-all group">
                    <div class="w-48 h-48 mx-auto rounded-2xl overflow-hidden border-2 border-emerald-500 dark:border-[#c6f634] bg-slate-900 shadow-md">
                        <img src="{{ !empty($foundationProfile['chairman_photo']) && !str_contains($foundationProfile['chairman_photo'], 'logo-robbani') ? asset($foundationProfile['chairman_photo']) : asset('images/sughesti_wulandari.webp') }}" alt="{{ $foundationProfile['chairman_name'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='{{ asset('images/sughesti_wulandari.webp') }}';">
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-base font-black font-headline text-slate-900 dark:text-white leading-snug group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">{{ $foundationProfile['chairman_name'] }}</h3>
                        <span class="text-xs font-bold text-orange-600 dark:text-[#c6f634] bg-orange-50 dark:bg-[#0d1e0f] px-3 py-1 rounded-full inline-block border border-orange-200 dark:border-[#1a381c]">{{ $foundationProfile['chairman_title'] }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 6: 4 UNIT SEKOLAH UNGGULAN -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 space-y-8">
            <div class="text-center space-y-2">
                <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-[#c6f634]/20 text-[#004532] dark:text-[#c6f634] text-xs font-black uppercase">UNIT PENDIDIKAN INTEGRASI</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold font-headline text-slate-900 dark:text-white">4 Unit Sekolah Unggulan SIT Robbani</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 max-w-xl mx-auto">Layanan pendidikan terpadu berjenjang dari usia dini hingga jenjang menengah atas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- KB/TKIT -->
                <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all flex flex-col justify-between space-y-4 group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-[#0d1e0f] text-emerald-800 dark:text-[#c6f634] font-black text-xs">KB / TKIT</span>
                            <span class="text-[10px] font-bold text-slate-400">Akreditasi A</span>
                        </div>
                        <h3 class="text-lg font-black font-headline text-slate-900 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-[#c6f634] transition-colors">KB/TKIT Robbani</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Tumbuh Ceria, Berakhlak Mulia, &amp; Hafiz Juz 30 Cilik berbasis sentra.</p>
                    </div>
                    <a href="{{ route('school.unit', 'tkit') }}" class="w-full py-2.5 rounded-xl bg-emerald-50 dark:bg-[#0d1e0f] hover:bg-emerald-700 hover:text-white text-emerald-700 dark:text-[#c6f634] font-black text-xs text-center border border-emerald-200 dark:border-[#1a381c] transition-colors block">
                        Lihat Profil Unit ➔
                    </a>
                </div>

                <!-- SDIT -->
                <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-orange-500 transition-all flex flex-col justify-between space-y-4 group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-950/40 text-orange-800 dark:text-orange-400 font-black text-xs">SDIT</span>
                            <span class="text-[10px] font-bold text-slate-400">Akreditasi B</span>
                        </div>
                        <h3 class="text-lg font-black font-headline text-slate-900 dark:text-white group-hover:text-orange-600 transition-colors">SDIT Robbani</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Mencetak Generasi Qur'ani, Berkarakter Karimah, &amp; Cerdas Sains.</p>
                    </div>
                    <a href="{{ route('school.unit', 'sdit') }}" class="w-full py-2.5 rounded-xl bg-orange-50 dark:bg-[#0d1e0f] hover:bg-orange-600 hover:text-white text-orange-700 dark:text-orange-400 font-black text-xs text-center border border-orange-200 dark:border-[#1a381c] transition-colors block">
                        Lihat Profil Unit ➔
                    </a>
                </div>

                <!-- SMPIT -->
                <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-blue-500 transition-all flex flex-col justify-between space-y-4 group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/40 text-blue-800 dark:text-blue-400 font-black text-xs">SMPIT</span>
                            <span class="text-[10px] font-bold text-slate-400">Akreditasi B</span>
                        </div>
                        <h3 class="text-lg font-black font-headline text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">SMPIT Robbani</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Menjadi Sekolah Menengah Pertama Terbaik di Indonesia 2032.</p>
                    </div>
                    <a href="{{ route('school.unit', 'smpit') }}" class="w-full py-2.5 rounded-xl bg-blue-50 dark:bg-[#0d1e0f] hover:bg-blue-600 hover:text-white text-blue-700 dark:text-blue-400 font-black text-xs text-center border border-blue-200 dark:border-[#1a381c] transition-colors block">
                        Lihat Profil Unit ➔
                    </a>
                </div>

                <!-- SMAIT -->
                <div class="bg-white dark:bg-[#07170a] border border-slate-200/80 dark:border-[#1a381c] rounded-3xl p-6 shadow-sm hover:shadow-xl hover:border-purple-500 transition-all flex flex-col justify-between space-y-4 group">
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-950/40 text-purple-800 dark:text-purple-400 font-black text-xs">SMAIT</span>
                            <span class="text-[10px] font-bold text-slate-400">Pengembangan</span>
                        </div>
                        <h3 class="text-lg font-black font-headline text-slate-900 dark:text-white group-hover:text-purple-600 transition-colors">SMAIT Robbani</h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">Persiapan Tembus PTN Favorit, Beasiswa Luar Negeri &amp; Sanad Tahfidz.</p>
                    </div>
                    <a href="{{ route('school.unit', 'smait') }}" class="w-full py-2.5 rounded-xl bg-purple-50 dark:bg-[#0d1e0f] hover:bg-purple-600 hover:text-white text-purple-700 dark:text-purple-400 font-black text-xs text-center border border-purple-200 dark:border-[#1a381c] transition-colors block">
                        Lihat Profil Unit ➔
                    </a>
                </div>
            </div>
        </section>

    </main>

    @include('school.partials.footer')

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
