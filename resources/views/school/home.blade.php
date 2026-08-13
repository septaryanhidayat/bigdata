<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, mobileMenuOpen: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['school_name'] }} | Website Resmi SIT Robbani Ogan Ilir</title>
    <meta name="description" content="{{ $settings['hero_desc'] }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/images/logo-robbani-official.png">

    <!-- Tailwind CSS CDN with Plugins -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Google Fonts & Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "tertiary-fixed": "#89f5e7",
                "on-surface": "#111c2d",
                "on-tertiary-fixed-variant": "#005049",
                "on-primary-container": "#8bd6b7",
                "on-surface-variant": "#3f4944",
                "secondary-fixed-dim": "#ffb690",
                "on-background": "#111c2d",
                "surface-dim": "#cfdaf2",
                "on-primary": "#ffffff",
                "surface-container-high": "#dee8ff",
                "inverse-primary": "#8bd6b6",
                "surface-variant": "#d8e3fb",
                "surface-container-lowest": "#ffffff",
                "surface-container": "#e7eeff",
                "on-secondary-container": "#5c2400",
                "on-secondary": "#ffffff",
                "inverse-on-surface": "#ecf1ff",
                "primary-fixed": "#a6f2d1",
                "surface-tint": "#1b6b51",
                "tertiary": "#00443e",
                "secondary-container": "#fd761a",
                "outline": "#6f7973",
                "surface-container-low": "#f0f3ff",
                "inverse-surface": "#263143",
                "on-error-container": "#93000a",
                "tertiary-fixed-dim": "#6bd8cb",
                "on-primary-fixed": "#002116",
                "on-secondary-fixed": "#341100",
                "tertiary-container": "#005e56",
                "secondary-fixed": "#ffdbca",
                "primary": "#004532",
                "error": "#ba1a1a",
                "on-tertiary-fixed": "#00201d",
                "surface-bright": "#f9f9ff",
                "on-tertiary-container": "#6cd9cb",
                "on-primary-fixed-variant": "#00513b",
                "background": "#f9f9ff",
                "surface-container-highest": "#d8e3fb",
                "surface": "#f9f9ff",
                "on-error": "#ffffff",
                "secondary": "#9d4300",
                "on-tertiary": "#ffffff",
                "primary-fixed-dim": "#8bd6b6",
                "primary-container": "#065f46",
                "error-container": "#ffdad6",
                "outline-variant": "#bec9c2",
                "on-secondary-fixed-variant": "#783200"
            },
            "spacing": {
                "md": "16px",
                "sm": "8px",
                "xs": "4px",
                "base": "4px",
                "lg": "24px",
                "xl": "48px",
                "container-max": "1280px",
                "xxl": "80px",
                "gutter": "24px"
            },
            "fontFamily": {
                "body": ["Inter", "sans-serif"],
                "headline": ["Montserrat", "sans-serif"]
            }
          }
        }
      }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 700, 'GRAD' 0, 'opsz' 24;
        }
        .material-symbols-outlined[data-weight="fill"] {
            font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 24;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-background text-on-background font-body transition-colors duration-300">

    <!-- ========================================== -->
    <!-- TOP NAV BAR                                -->
    <!-- ========================================== -->
    <nav class="bg-surface dark:bg-inverse-surface border-b border-outline-variant dark:border-outline fixed top-0 left-0 w-full z-50 flex justify-between items-center px-lg py-md max-w-container-max mx-auto h-20 shadow-sm">
        <div class="flex items-center gap-md">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img alt="Yayasan Generasi Robbani Logo" class="h-10 sm:h-12 w-auto object-contain" src="/images/logo-robbani-official.png" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                <div class="font-bold text-lg md:text-xl text-primary dark:text-inverse-primary hidden sm:block font-headline leading-tight">
                    Yayasan Generasi Robbani
                </div>
            </a>
        </div>

        <div class="hidden md:flex space-x-lg items-center font-semibold text-sm">
            <a class="text-primary dark:text-inverse-primary border-b-2 border-primary font-bold pb-1 hover:text-secondary-container transition-colors" href="{{ route('home') }}">Beranda</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="{{ route('school.profil') }}">Profil</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="#unit-sekolah">Unit</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="{{ route('school.berita') }}">Berita</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="{{ route('school.artikel') }}">Artikel</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="{{ route('school.fasilitas') }}">Fasilitas</a>
            <a class="text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-secondary-fixed-dim transition-colors" href="{{ route('school.espp') }}">E-SPP</a>
        </div>

        <div class="flex items-center gap-sm">
            <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="p-sm text-primary dark:text-inverse-primary hover:bg-surface-container-high rounded-full transition-colors hidden lg:flex items-center justify-center" title="Hubungi Kami">
                <span class="material-symbols-outlined">call</span>
            </a>
            
            <button @click="darkMode = !darkMode" class="p-sm text-primary dark:text-inverse-primary hover:bg-surface-container-high rounded-full transition-colors hidden lg:flex items-center justify-center" title="Toggle Mode">
                <span class="material-symbols-outlined" x-show="!darkMode">dark_mode</span>
                <span class="material-symbols-outlined" x-show="darkMode" x-cloak>light_mode</span>
            </button>

            <a class="hidden lg:inline-flex px-md py-sm border border-primary text-primary dark:text-inverse-primary font-bold text-xs rounded-full hover:bg-primary-container hover:text-white transition-colors items-center gap-xs" href="{{ route('admin.dashboard') }}">
                Admin
            </a>
            <a class="px-md py-sm bg-secondary-container text-white font-bold text-xs rounded-full hover:opacity-90 transition-opacity flex items-center gap-xs shadow-sm" href="{{ route('school.ppdb') }}">
                SPMB <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-xl text-primary dark:text-inverse-primary border border-outline-variant">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Drawer -->
    <div x-show="mobileMenuOpen" x-cloak class="md:hidden fixed inset-x-0 top-20 z-40 bg-surface dark:bg-inverse-surface border-b border-outline-variant p-md space-y-md shadow-2xl font-semibold">
        <a @click="mobileMenuOpen = false" href="{{ route('home') }}" class="block text-primary font-bold">Beranda</a>
        <a @click="mobileMenuOpen = false" href="{{ route('school.profil') }}" class="block text-on-surface-variant dark:text-surface-variant">Profil Yayasan</a>
        <a @click="mobileMenuOpen = false" href="#unit-sekolah" class="block text-on-surface-variant dark:text-surface-variant">Unit Pendidikan</a>
        <a @click="mobileMenuOpen = false" href="{{ route('school.berita') }}" class="block text-on-surface-variant dark:text-surface-variant">Berita Kampus</a>
        <a @click="mobileMenuOpen = false" href="{{ route('school.artikel') }}" class="block text-on-surface-variant dark:text-surface-variant">Artikel</a>
        <a @click="mobileMenuOpen = false" href="{{ route('school.fasilitas') }}" class="block text-on-surface-variant dark:text-surface-variant">Fasilitas</a>
        <a @click="mobileMenuOpen = false" href="{{ route('school.espp') }}" class="block text-on-surface-variant dark:text-surface-variant">E-SPP ARSI</a>
        <a href="{{ route('admin.dashboard') }}" class="block text-center py-2 rounded-full border border-primary text-primary font-bold">Portal Admin</a>
    </div>

    <!-- MAIN CONTENT -->
    <main class="pt-20">

        <!-- ========================================== -->
        <!-- HERO SECTION WITH INTEGRATED PRAYER WIDGET -->
        <!-- ========================================== -->
        <section class="relative bg-[#111c2d] py-xxl overflow-hidden" style="background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), url('https://lh3.googleusercontent.com/aida/AP1WRLuf5i7pWfq9dzqqqjNB6dJ3JNiFjsv6Iv0erwSW9QTXek-Ur1VI-e_ULP2zi3qLQIbKln9GGYMrKRcDMpgsk8uELhhqxDf4J0N_tZ3ObFRa1UmfynfH5wzEfpsoQwZd8ofmDXnfj0-gwTaJjxlH2Gt_qt3XIBHF0DtXovfyqeC4E7-y7dd3rgARHyA57tjdlEywmGuLbJ1q3jagkMiPIv2sK3XpKR-CEw_Kr3hiDZtYNpxD6JtANagJSWCU'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div class="max-w-container-max mx-auto px-gutter relative z-10">
                <div class="bg-[#111c2d]/90 backdrop-blur-md border border-white/10 rounded-2xl p-lg md:p-xl relative overflow-hidden shadow-2xl">
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-xl items-center relative z-10">
                        
                        <!-- Left Hero Column -->
                        <div class="lg:col-span-7 space-y-lg">
                            <span class="inline-block bg-secondary-container text-white px-md py-xs rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">SPMB Online Terpadu</span>
                            <h1 class="text-3xl md:text-5xl font-extrabold font-headline leading-tight text-white">Penerimaan Peserta Didik Baru (PPDB) 2026/2027</h1>
                            <p class="text-base md:text-lg text-white/90 max-w-2xl font-medium leading-relaxed">Bergabunglah bersama keluarga besar KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir. Kuota terbatas! Wujudkan generasi Qur'ani yang berprestasi.</p>
                            
                            <div class="flex flex-wrap gap-md pt-2">
                                <a class="px-xl py-md bg-primary text-white font-bold text-sm rounded-full hover:bg-primary/90 transition-all flex items-center gap-sm shadow-md hover:scale-105" href="{{ route('school.ppdb') }}">
                                    Isi Formulir SPMB Now <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <a class="px-xl py-md bg-white/10 border border-white/20 text-white font-bold text-sm rounded-full hover:bg-white/20 transition-all flex items-center gap-sm backdrop-blur-md" href="{{ route('school.profil') }}">
                                    Profil Yayasan <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>

                        <!-- Right Column: REALTIME PRAYER TIMES WIDGET -->
                        <div class="lg:col-span-5">
                            <div class="bg-black/50 backdrop-blur-md border border-white/15 rounded-xl p-lg shadow-xl relative overflow-hidden space-y-md">
                                
                                <div class="flex justify-between items-center border-b border-white/10 pb-sm">
                                    <div>
                                        <div class="text-[10px] font-bold text-primary-fixed-dim uppercase flex items-center gap-xs">
                                            <span class="material-symbols-outlined text-[14px]">location_on</span> Indralaya, Ogan Ilir
                                        </div>
                                        <div class="text-sm font-bold text-white">Jadwal Sholat Realtime</div>
                                    </div>
                                    <div class="bg-secondary-container text-white px-sm py-xs rounded text-[10px] font-bold flex items-center gap-xs shadow-sm">
                                        <span class="material-symbols-outlined text-[12px]">explore</span> 295.2° NW
                                    </div>
                                </div>

                                <div>
                                    <div class="text-[10px] font-bold text-primary-fixed-dim uppercase mb-xs">Sholat Berikutnya</div>
                                    <div class="flex justify-between items-end">
                                        <div class="text-xl md:text-2xl font-black text-secondary-fixed">Subuh 04:47 WIB</div>
                                        <div class="text-[10px] font-semibold bg-white/10 px-sm py-xs rounded text-white/90 border border-white/10">29 Safar 1448 H</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 gap-xs pt-1">
                                    <div class="bg-white/5 border border-white/10 p-xs rounded text-center">
                                        <div class="text-[9px] font-bold text-white/70 uppercase">Subuh</div>
                                        <div class="text-xs font-black text-white">04:47</div>
                                    </div>
                                    <div class="bg-white/5 border border-white/10 p-xs rounded text-center">
                                        <div class="text-[9px] font-bold text-white/70 uppercase">Dzuhur</div>
                                        <div class="text-xs font-black text-white">12:08</div>
                                    </div>
                                    <div class="bg-white/5 border border-white/10 p-xs rounded text-center">
                                        <div class="text-[9px] font-bold text-white/70 uppercase">Ashar</div>
                                        <div class="text-xs font-black text-white">15:28</div>
                                    </div>
                                    <div class="bg-secondary-container p-xs rounded text-center shadow-md border border-secondary-container">
                                        <div class="text-[9px] font-bold text-white/90 uppercase">Maghrib</div>
                                        <div class="text-xs font-black text-white">18:10</div>
                                    </div>
                                    <div class="bg-white/5 border border-white/10 p-xs rounded text-center">
                                        <div class="text-[9px] font-bold text-white/70 uppercase">Isya</div>
                                        <div class="text-xs font-black text-white">19:21</div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Slide Navigation Indicator -->
                    <div class="flex justify-between items-center mt-lg relative z-10 px-lg border-t border-white/10 pt-md">
                        <div class="text-xs font-medium text-white/60">Slide 2 dari 3</div>
                        <div class="flex gap-sm">
                            <button class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition-colors"><span class="material-symbols-outlined text-[16px]">chevron_left</span></button>
                            <button class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-white/20 transition-colors"><span class="material-symbols-outlined text-[16px]">chevron_right</span></button>
                        </div>
                        <div class="flex gap-sm">
                            <div class="w-8 h-1.5 bg-white/20 rounded-full"></div>
                            <div class="w-8 h-1.5 bg-secondary-container rounded-full"></div>
                            <div class="w-8 h-1.5 bg-white/20 rounded-full"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- ICON MENU SECTION (8 QUICK TILES)          -->
        <!-- ========================================== -->
        <section class="py-xl bg-surface dark:bg-inverse-surface/40">
            <div class="max-w-container-max mx-auto px-gutter space-y-md">
                
                <div class="flex justify-between items-center border-b border-outline-variant pb-sm">
                    <h2 class="text-lg md:text-xl font-bold font-headline text-on-surface dark:text-inverse-on-surface">Menu Utama Portal</h2>
                    <span class="text-xs font-bold text-primary dark:text-inverse-primary">8 Fitur Utama</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-md">
                    
                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.profil') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">person</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Profil</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="#unit-sekolah">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-secondary-container group-hover:bg-secondary-container group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">domain</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">4 Unit</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.berita') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">newspaper</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Berita</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.artikel') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-secondary-container group-hover:bg-secondary-container group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">article</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Artikel</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.fasilitas') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">home_work</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Fasilitas</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.espp') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-secondary-container group-hover:bg-secondary-container group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">payments</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">E-SPP</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="{{ route('school.ppdb') }}">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">how_to_reg</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">PPDB</span>
                    </a>

                    <a class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md flex flex-col items-center justify-center gap-sm hover:border-primary hover:shadow-md transition-all group" href="#layanan-terpadu">
                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-secondary-container group-hover:bg-secondary-container group-hover:text-white transition-colors">
                            <span class="material-symbols-outlined text-[36px]" data-weight="fill">support_agent</span>
                        </div>
                        <span class="text-xs font-bold text-on-surface-variant group-hover:text-primary">Layanan</span>
                    </a>

                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- WELCOME SECTION (SAMBUTAN KETUA YAYASAN)   -->
        <!-- ========================================== -->
        <section class="py-xl">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="bg-surface-container-lowest border border-outline-variant rounded-[32px] p-lg md:p-xl shadow-sm flex flex-col md:flex-row gap-xl items-center relative overflow-hidden">
                    
                    <div class="flex-shrink-0 flex flex-col items-center z-10 w-full md:w-1/3 text-center">
                        <div class="w-40 h-40 rounded-full border-[5px] border-primary p-1 mb-md shadow-lg">
                            <img class="w-full h-full object-cover rounded-full bg-white" src="/images/logo-robbani-official.png" alt="Ketua Yayasan Generasi Robbani" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                        </div>
                        <span class="bg-primary text-white text-[10px] font-bold uppercase px-sm py-xs rounded-full mb-xs">Ketua Yayasan</span>
                        <h3 class="text-lg font-bold font-headline text-on-surface mb-xs">{{ $settings['principal_name'] }}</h3>
                        <p class="text-xs font-semibold text-primary max-w-[220px]">{{ $settings['principal_title'] }}</p>
                    </div>

                    <div class="flex-grow z-10 w-full md:w-2/3 border-t md:border-t-0 md:border-l border-outline-variant pt-lg md:pt-0 md:pl-lg">
                        <span class="material-symbols-outlined text-[48px] text-primary/40 mb-sm block">format_quote</span>
                        <p class="text-base md:text-lg font-semibold italic text-on-surface mb-lg leading-relaxed">
                            "{{ $settings['principal_greeting'] }}"
                        </p>
                        
                        <div class="flex flex-wrap gap-md">
                            <a class="px-md py-sm bg-primary text-white font-bold text-xs rounded-full hover:bg-primary/90 transition-colors flex items-center gap-xs shadow-sm" href="{{ route('school.profil') }}">
                                1. Baca Sambutan Lengkap <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a class="px-md py-sm bg-secondary-container text-white font-bold text-xs rounded-full hover:opacity-90 transition-opacity flex items-center gap-xs shadow-sm" href="{{ route('school.profil') }}#visi-misi">
                                2. Visi &amp; Misi Yayasan <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- UNIT PENDIDIKAN (KB/TKIT, SDIT, SMPIT, SMAIT)-->
        <!-- ========================================== -->
        <section id="unit-sekolah" class="py-xl bg-surface dark:bg-inverse-surface/40">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex justify-between items-end">
                    <div>
                        <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Jenjang Pendidikan</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold font-headline text-on-surface">Unit Pendidikan</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-md">
                    
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md text-center shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                        <div>
                            <div class="w-20 h-20 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-md group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-[40px] text-primary">child_care</span>
                            </div>
                            <h3 class="text-lg font-bold font-headline text-on-surface mb-xs">KB/TKIT Robbani</h3>
                            <p class="text-xs text-on-surface-variant mb-md leading-relaxed">Kelompok Bermain &amp; Taman Kanak-Kanak Islam Terpadu berakreditasi unggul.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-md py-sm border border-primary text-primary font-bold rounded-full hover:bg-primary hover:text-white transition-colors text-xs w-full" href="{{ route('school.ppdb') }}">Selengkapnya</a>
                    </div>

                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md text-center shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                        <div>
                            <div class="w-20 h-20 mx-auto bg-secondary-container/10 rounded-full flex items-center justify-center mb-md group-hover:bg-secondary-container/20 transition-colors">
                                <span class="material-symbols-outlined text-[40px] text-secondary-container">school</span>
                            </div>
                            <h3 class="text-lg font-bold font-headline text-on-surface mb-xs">SDIT Robbani</h3>
                            <p class="text-xs text-on-surface-variant mb-md leading-relaxed">Sekolah Dasar Islam Terpadu berakreditasi A dengan program Tahfidz Al-Qur'an.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-md py-sm border border-secondary-container text-secondary-container font-bold rounded-full hover:bg-secondary-container hover:text-white transition-colors text-xs w-full" href="{{ route('school.ppdb') }}">Selengkapnya</a>
                    </div>

                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md text-center shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                        <div>
                            <div class="w-20 h-20 mx-auto bg-primary/10 rounded-full flex items-center justify-center mb-md group-hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-[40px] text-primary">menu_book</span>
                            </div>
                            <h3 class="text-lg font-bold font-headline text-on-surface mb-xs">SMPIT Robbani</h3>
                            <p class="text-xs text-on-surface-variant mb-md leading-relaxed">Sekolah Menengah Pertama Islam Terpadu berasrama (boarding) / fullday.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-md py-sm border border-primary text-primary font-bold rounded-full hover:bg-primary hover:text-white transition-colors text-xs w-full" href="{{ route('school.ppdb') }}">Selengkapnya</a>
                    </div>

                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md text-center shadow-sm hover:shadow-md transition-shadow group flex flex-col justify-between">
                        <div>
                            <div class="w-20 h-20 mx-auto bg-secondary-container/10 rounded-full flex items-center justify-center mb-md group-hover:bg-secondary-container/20 transition-colors">
                                <span class="material-symbols-outlined text-[40px] text-secondary-container">account_balance</span>
                            </div>
                            <h3 class="text-lg font-bold font-headline text-on-surface mb-xs">SMAIT Robbani</h3>
                            <p class="text-xs text-on-surface-variant mb-md leading-relaxed">Sekolah Menengah Atas Islam Terpadu dengan program unggulan sains & IT.</p>
                        </div>
                        <a class="inline-flex items-center justify-center px-md py-sm border border-secondary-container text-secondary-container font-bold rounded-full hover:bg-secondary-container hover:text-white transition-colors text-xs w-full" href="{{ route('school.ppdb') }}">Selengkapnya</a>
                    </div>

                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- ARTIKEL & BERITA                           -->
        <!-- ========================================== -->
        <section id="artikel-berita" class="py-xl bg-surface dark:bg-inverse-surface/40">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex justify-between items-end">
                    <div>
                        <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Kabar Kampus</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold font-headline text-on-surface">Artikel &amp; Berita Terbaru</h2>
                    </div>
                    <a class="text-primary font-bold text-xs hover:underline flex items-center gap-xs" href="{{ route('school.berita') }}">
                        Lihat Seluruh Artikel <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
                    
                    @if(count($newsList) > 0)
                    @php $topNews = $newsList[0]; @endphp
                    <div class="lg:col-span-7">
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden shadow-sm group cursor-pointer hover:shadow-lg transition-all h-full flex flex-col">
                            <div class="relative h-72 sm:h-80 overflow-hidden bg-slate-900">
                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $topNews['image'] }}" alt="{{ $topNews['title'] }}" onerror="this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-6 bg-white';">
                                <span class="absolute top-lg left-lg bg-primary text-white px-md py-xs rounded-full text-xs font-bold shadow-md">HEADLINE NEWS</span>
                            </div>
                            <div class="p-lg flex-grow flex flex-col justify-between space-y-md">
                                <div class="space-y-sm">
                                    <div class="flex items-center gap-sm text-xs text-on-surface-variant font-medium">
                                        <span class="material-symbols-outlined text-[18px]">calendar_today</span> {{ $topNews['date'] }}
                                    </div>
                                    <h3 class="text-lg md:text-xl font-bold font-headline text-on-surface group-hover:text-primary transition-colors leading-snug">
                                        {{ $topNews['title'] }}
                                    </h3>
                                    <p class="text-xs md:text-sm text-on-surface-variant leading-relaxed line-clamp-3">
                                        {{ $topNews['excerpt'] }}
                                    </p>
                                </div>
                                <a href="{{ route('school.berita.show', $topNews['slug'] ?? \Illuminate\Support\Str::slug($topNews['title'])) }}" class="text-primary font-bold text-xs flex items-center gap-xs group-hover:underline">
                                    Baca Selengkapnya <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="lg:col-span-5 space-y-md">
                        @foreach(array_slice($newsList, 1, 4) as $sideNews)
                        <div class="flex items-center gap-md p-sm bg-surface-container-lowest rounded-xl border border-outline-variant hover:shadow-md transition-shadow cursor-pointer group">
                            <img class="w-20 h-20 object-cover rounded-lg flex-shrink-0 group-hover:opacity-90 transition-opacity bg-slate-900" src="{{ $sideNews['image'] }}" alt="{{ $sideNews['title'] }}" onerror="this.src='/images/logo-robbani-official.png'; this.className='w-20 h-20 object-contain p-2 bg-white rounded-lg';">
                            <div class="flex-grow space-y-xs min-w-0">
                                <div class="text-[10px] text-on-surface-variant flex items-center gap-xs font-semibold">
                                    <span class="material-symbols-outlined text-[12px]">calendar_today</span> {{ $sideNews['date'] }}
                                </div>
                                <h4 class="text-xs font-bold text-on-surface line-clamp-2 group-hover:text-primary transition-colors leading-snug">
                                    {{ $sideNews['title'] }}
                                </h4>
                                <a href="{{ route('school.berita.show', $sideNews['slug'] ?? \Illuminate\Support\Str::slug($sideNews['title'])) }}" class="text-[11px] font-bold text-primary hover:underline">
                                    Baca ➔
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- VIDEO PROFIL & DOKUMENTASI KEGIATAN        -->
        <!-- ========================================== -->
        <section id="video-profil" class="py-xl">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex justify-between items-end">
                    <div>
                        <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Galeri Video</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold font-headline text-on-surface">Video Profil &amp; Dokumentasi Kegiatan</h2>
                    </div>
                    <a class="text-primary font-bold text-xs hover:underline flex items-center gap-xs" href="#">
                        SIT Robbani Channel <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                    @foreach($videoList as $vid)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden shadow-sm flex flex-col group cursor-pointer hover:shadow-md transition-shadow">
                        <div class="relative h-48 overflow-hidden flex items-center justify-center bg-slate-950">
                            <img alt="{{ $vid['title'] }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 opacity-80" src="{{ $vid['thumbnail'] }}">
                            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors"></div>
                            <div class="relative z-10 w-14 h-14 bg-secondary-container rounded-full flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-[32px]" data-weight="fill">play_arrow</span>
                            </div>
                            <span class="absolute top-sm left-sm bg-primary text-white text-[10px] font-bold px-2 py-1 rounded z-10 uppercase">{{ $vid['category'] }}</span>
                            <span class="absolute bottom-sm right-sm bg-black/70 text-white text-[10px] font-bold px-2 py-1 rounded z-10">{{ $vid['duration'] }}</span>
                        </div>
                        <div class="p-md flex-grow flex flex-col space-y-xs">
                            <h3 class="text-sm font-bold font-headline text-on-surface line-clamp-2 leading-snug">{{ $vid['title'] }}</h3>
                            <p class="text-xs text-on-surface-variant line-clamp-2 leading-relaxed">{{ $vid['desc'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- PAPAN PENGUMUMAN & AGENDA KEGIATAN         -->
        <!-- ========================================== -->
        <section id="agenda-pengumuman" class="py-xl bg-surface dark:bg-inverse-surface/40">
            <div class="max-w-container-max mx-auto px-gutter">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-xl">
                    
                    <!-- Papan Pengumuman -->
                    <div class="space-y-lg">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Announcement</span>
                                <h2 class="text-xl md:text-2xl font-extrabold font-headline text-on-surface">Papan Pengumuman</h2>
                            </div>
                            <a class="text-primary font-bold text-xs hover:underline flex items-center gap-xs" href="{{ route('school.berita') }}">
                                Lihat Semua <span class="material-symbols-outlined text-[16px]" data-weight="fill">arrow_forward</span>
                            </a>
                        </div>

                        <div class="space-y-md">
                            @foreach($announcementList as $ann)
                            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm hover:shadow-md transition-shadow space-y-xs">
                                <div class="flex justify-between items-center">
                                    <span class="bg-secondary-container/10 text-secondary-container text-[10px] font-bold uppercase px-2 py-1 rounded">{{ $ann['category'] }}</span>
                                    <span class="text-[10px] text-on-surface-variant flex items-center gap-xs font-semibold"><span class="material-symbols-outlined text-[12px]">calendar_today</span> {{ $ann['date'] }}</span>
                                </div>
                                <h3 class="text-sm font-bold text-on-surface leading-snug">{{ $ann['title'] }}</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed">{{ $ann['summary'] }}</p>
                                <a class="text-primary text-xs font-bold hover:underline flex items-center gap-xs pt-1" href="{{ $ann['link'] }}">
                                    Detail Pengumuman <span class="material-symbols-outlined text-[14px]" data-weight="fill">arrow_forward</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Agenda Kegiatan -->
                    <div class="space-y-lg">
                        <div class="flex justify-between items-end">
                            <div>
                                <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Jadwal &amp; Event</span>
                                <h2 class="text-xl md:text-2xl font-extrabold font-headline text-on-surface">Agenda Kegiatan</h2>
                            </div>
                            <span class="text-primary font-bold text-xs">2026/2027</span>
                        </div>

                        <div class="space-y-md">
                            @foreach($agendaList as $agenda)
                            <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md shadow-sm flex gap-md items-start hover:shadow-md transition-shadow">
                                <div class="flex flex-col items-center justify-center bg-primary text-white w-12 h-12 rounded-lg flex-shrink-0 font-bold">
                                    <span class="text-base leading-none">{{ $agenda['date_day'] }}</span>
                                    <span class="text-[9px] uppercase tracking-wider leading-none mt-1">{{ $agenda['date_month'] }}</span>
                                </div>
                                <div class="flex-grow space-y-xs min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-xs md:text-sm font-bold text-on-surface leading-snug truncate">{{ $agenda['title'] }}</h3>
                                        <span class="text-[10px] text-on-surface-variant flex items-center gap-xs whitespace-nowrap shrink-0 ml-2 font-semibold">
                                            <span class="material-symbols-outlined text-[12px]">schedule</span> {{ $agenda['time'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-on-surface-variant flex items-center gap-xs truncate">
                                        <span class="material-symbols-outlined text-[14px]">location_on</span> {{ $agenda['location'] }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- GALERI FOTO FASILITAS                      -->
        <!-- ========================================== -->
        <section id="galeri-sekolah" class="py-xl">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg">
                
                <div class="flex justify-between items-end">
                    <div>
                        <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase mb-xs">Dokumentasi Foto</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold font-headline text-on-surface">Galeri Sekolah &amp; Sarana Prasarana</h2>
                    </div>
                    <a class="text-primary font-bold text-xs hover:underline flex items-center gap-xs" href="{{ route('school.fasilitas') }}">
                        Lihat Semua Fasilitas <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-md">
                    @foreach($facilityList as $fac)
                    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-md text-center shadow-sm space-y-xs group hover:border-primary transition-all">
                        <div class="text-3xl group-hover:scale-110 transition-transform">{{ $fac['icon'] }}</div>
                        <h4 class="text-xs font-bold text-on-surface truncate">{{ $fac['title'] }}</h4>
                        <p class="text-[10px] text-on-surface-variant line-clamp-2 leading-snug">{{ $fac['desc'] }}</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- TESTIMONIAL WALL                           -->
        <!-- ========================================== -->
        <section id="testimonial-wall" class="py-xl bg-surface dark:bg-inverse-surface/40">
            <div class="max-w-container-max mx-auto px-gutter space-y-lg text-center">
                
                <div class="max-w-2xl mx-auto space-y-xs">
                    <span class="inline-block bg-primary/10 text-primary px-sm py-xs rounded-full text-[10px] font-bold uppercase">Wall of Testimonials</span>
                    <h2 class="text-2xl md:text-3xl font-extrabold font-headline text-on-surface">Kesan &amp; Testimoni Orang Tua Murid</h2>
                    <p class="text-xs md:text-sm text-on-surface-variant">Kepercayaan dan apresiasi wali murid &amp; alumni terhadap pendidikan SIT Robbani Ogan Ilir.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-md text-left">
                    @foreach($testimonialList as $testi)
                    <div class="bg-surface-container-lowest border border-outline-variant p-md rounded-2xl shadow-sm flex flex-col justify-between space-y-md">
                        <p class="text-xs italic text-on-surface-variant leading-relaxed font-medium">"{{ $testi['text'] }}"</p>
                        <div class="flex items-center gap-sm pt-sm border-t border-outline-variant">
                            <img src="{{ $testi['avatar'] }}" alt="{{ $testi['name'] }}" class="w-10 h-10 rounded-full object-cover border border-primary" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-192x192.png';">
                            <div>
                                <h4 class="text-xs font-bold text-on-surface leading-tight">{{ $testi['name'] }}</h4>
                                <span class="text-[10px] text-primary font-semibold block leading-tight">{{ $testi['title'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

    </main>

    <!-- ========================================== -->
    <!-- FOOTER WITH BRANDING CREDIT                -->
    <!-- ========================================== -->
    <footer class="bg-[#111c2d] text-white py-xl border-t border-white/10 text-xs">
        <div class="max-w-container-max mx-auto px-gutter space-y-lg">
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-md pb-lg border-b border-white/10">
                <div class="flex items-center gap-md">
                    <img src="/images/logo-robbani-official.png" class="h-10 p-1 bg-white rounded-lg object-contain" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png';">
                    <div>
                        <span class="font-bold text-sm block text-white font-headline">YAYASAN GENERASI ROBBANI</span>
                        <span class="text-[10px] text-secondary-container font-semibold block uppercase">SUMATERA SELATAN (SIT ROBBANI)</span>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-md font-semibold text-xs text-white/80">
                    <a href="{{ route('home') }}" class="hover:text-secondary-container transition-colors">Beranda</a>
                    <a href="{{ route('school.profil') }}" class="hover:text-secondary-container transition-colors">Profil</a>
                    <a href="{{ route('school.ppdb') }}" class="hover:text-secondary-container transition-colors">PPDB Online</a>
                    <a href="{{ route('school.espp') }}" class="hover:text-secondary-container transition-colors">E-SPP ARSI</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary-container hover:underline">Portal Admin</a>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-sm text-center md:text-left text-white/70">
                <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
                <a href="https://berandadigital.net" target="_blank" class="text-secondary-container hover:underline font-bold flex items-center justify-center gap-xs">
                    <span>Powered by Beranda Teknologi Digital</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>

        </div>
    </footer>

</body>
</html>
