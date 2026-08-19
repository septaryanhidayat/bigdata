<!DOCTYPE html>
<html lang="id" class="h-full" x-data="{ 
    darkMode: localStorage.getItem('theme_mode') === 'dark',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme_mode', this.darkMode ? 'dark' : 'light');
    },
    showPassword: false, 
    isSubmitting: false,
    timeString: '',
    dateString: '',
    initClock() {
        const update = () => {
            const now = new Date();
            const options = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
            this.dateString = now.toLocaleDateString('id-ID', options);
            this.timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
        };
        update();
        setInterval(update, 1000);
    }
}" 
:class="darkMode ? 'dark' : ''"
x-init="initClock()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#004532">
    <title>Portal Masuk SmartEdu | Yayasan Generasi Robbani Sumatera Selatan</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=10">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=10">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN with Forms Plugin -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        robbani: {
                            dark: '#004532',
                            obsidian: '#061107',
                            cardDark: '#0d1e0f',
                            borderDark: '#1a381c',
                            primary: '#065f46',
                            emerald: '#059669',
                            light: '#10b981',
                            accent: '#fd761a',
                            orange: '#f97316',
                            lime: '#c6f634'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Ambient Glow Animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
        }
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }

        .glow-orb-1 {
            animation: pulse-slow 8s ease-in-out infinite alternate;
        }
        .glow-orb-2 {
            animation: pulse-slow 10s ease-in-out infinite alternate-reverse;
        }
        .float-card {
            animation: float-gentle 6s ease-in-out infinite;
        }

        /* Texture Overlays */
        .islamic-pattern-light {
            background-image: radial-gradient(rgba(5, 150, 105, 0.1) 1px, transparent 1px), radial-gradient(rgba(0, 69, 50, 0.08) 1px, transparent 1px);
            background-size: 28px 28px;
            background-position: 0 0, 14px 14px;
        }

        .islamic-pattern-dark {
            background-image: radial-gradient(rgba(198, 246, 52, 0.08) 1px, transparent 1px), radial-gradient(rgba(16, 185, 129, 0.08) 1px, transparent 1px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(5, 150, 105, 0.4);
            border-radius: 9999px;
        }
    </style>
</head>
<body class="h-full antialiased flex flex-col justify-between selection:bg-emerald-500 selection:text-white relative overflow-x-hidden min-h-screen bg-slate-50 text-slate-900 dark:bg-[#061107] dark:text-slate-100">

    <!-- 1. BACKGROUND LAYERS: DUAL-THEME SCHOOL ASSET BACKDROP -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- High-Res Campus Image from Real School Assets -->
        <img src="https://lh3.googleusercontent.com/aida/AP1WRLuf5i7pWfq9dzqqqjNB6dJ3JNiFjsv6Iv0erwSW9QTXek-Ur1VI-e_ULP2zi3qLQIbKln9GGYMrKRcDMpgsk8uELhhqxDf4J0N_tZ3ObFRa1UmfynfH5wzEfpsoQwZd8ofmDXnfj0-gwTaJjxlH2Gt_qt3XIBHF0DtXovfyqeC4E7-y7dd3rgARHyA57tjdlEywmGuLbJ1q3jagkMiPIv2sK3XpKR-CEw_Kr3hiDZtYNpxD6JtANagJSWCU" 
             alt="Kampus SIT Robbani" 
             class="w-full h-full object-cover object-center filter blur-[1px] scale-105 transform opacity-20 dark:opacity-30 transition-opacity duration-500"
             onerror="this.src='{{ asset('images/facilities/gedung_smpit.jpg') }}'; this.onerror=null;">

        <!-- LIGHT MODE GRADIENT OVERLAYS -->
        <div class="dark:hidden absolute inset-0 bg-gradient-to-br from-slate-50/90 via-emerald-50/70 to-teal-50/80"></div>
        <div class="dark:hidden absolute inset-0 islamic-pattern-light"></div>
        <div class="dark:hidden absolute -top-32 -left-32 w-96 h-96 bg-emerald-200/40 rounded-full blur-3xl glow-orb-1"></div>
        <div class="dark:hidden absolute -bottom-32 -right-32 w-[30rem] h-[30rem] bg-teal-200/35 rounded-full blur-3xl glow-orb-2"></div>

        <!-- DARK MODE OBSIDIAN EMERALD & NEON LIME OVERLAYS -->
        <div class="hidden dark:block absolute inset-0 bg-gradient-to-br from-[#061107]/95 via-[#004532]/90 to-[#022c22]/95 mix-blend-multiply"></div>
        <div class="hidden dark:block absolute inset-0 islamic-pattern-dark"></div>
        <div class="hidden dark:block absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl glow-orb-1"></div>
        <div class="hidden dark:block absolute -bottom-32 -right-32 w-[32rem] h-[32rem] bg-[#c6f634]/15 rounded-full blur-3xl glow-orb-2"></div>
        <div class="hidden dark:block absolute top-1/2 left-1/3 w-72 h-72 bg-teal-500/15 rounded-full blur-2xl glow-orb-1"></div>
    </div>

    <!-- 2. TOP NAVIGATION BRAND BAR -->
    <header class="relative z-10 w-full px-4 sm:px-8 py-4 sm:py-6 flex items-center justify-between">
        <!-- Logo & Organization Name -->
        <a href="{{ route('home') }}" class="group flex items-center gap-3 transition-transform hover:scale-[1.02]">
            <div class="p-2 rounded-2xl bg-white dark:bg-white/10 shadow-md border border-slate-200/80 dark:border-white/15 flex items-center justify-center">
                <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo Yayasan Generasi Robbani" class="h-8 sm:h-10 w-auto object-contain drop-shadow" onerror="this.src='{{ asset('images/logo robbani light.png') }}'">
            </div>
            <div>
                <span class="block text-xs sm:text-sm font-black tracking-wide uppercase text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] transition-colors">
                    YAYASAN GENERASI ROBBANI
                </span>
                <span class="block text-[10px] sm:text-[11px] font-bold text-emerald-700 dark:text-emerald-300/90 tracking-wide">
                    Indralaya Utara, Ogan Ilir, Sumatera Selatan
                </span>
            </div>
        </a>

        <!-- Right Side: Theme Switcher, Live Clock & Main Web Link -->
        <div class="flex items-center gap-3">
            <!-- Real-Time WIB Clock (Desktop) -->
            <div class="hidden lg:flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-white/80 dark:bg-white/[0.06] backdrop-blur-md border border-slate-200 dark:border-white/10 text-xs shadow-xs">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500 dark:bg-[#c6f634]"></span>
                </span>
                <div class="text-right leading-tight">
                    <div class="font-extrabold text-slate-800 dark:text-white" x-text="timeString || 'WIB'"></div>
                    <div class="text-[10px] text-slate-500 dark:text-slate-300 font-medium" x-text="dateString"></div>
                </div>
            </div>

            <!-- DUAL THEME TOGGLE BUTTON (Default Light / Dark Obsidian Lime) -->
            <button type="button" 
                    @click="toggleTheme()" 
                    title="Ganti Mode Tampilan (Terang / Gelap Obsidian Neon)"
                    class="px-3.5 py-2 rounded-2xl bg-white dark:bg-[#0d1e0f] text-slate-700 dark:text-[#c6f634] border border-slate-200 dark:border-[#1a381c] shadow-sm hover:shadow-md hover:border-emerald-500 dark:hover:border-[#c6f634] transition-all flex items-center gap-2 text-xs font-black cursor-pointer select-none">
                <!-- Light Mode Icon (Visible in Light Mode) -->
                <span x-show="!darkMode" class="flex items-center gap-1.5 text-amber-600 font-extrabold">
                    <span>☀️</span>
                    <span class="hidden sm:inline">Mode Terang</span>
                </span>
                <!-- Dark Mode Icon (Visible in Dark Mode) -->
                <span x-show="darkMode" x-cloak class="flex items-center gap-1.5 text-[#c6f634] font-extrabold">
                    <span>🌙</span>
                    <span class="hidden sm:inline">Obsidian Lime</span>
                </span>
            </button>

            <!-- Link to Main Portal -->
            <a href="{{ route('home') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-600 dark:bg-emerald-500/20 text-white dark:text-emerald-300 border border-emerald-700 dark:border-emerald-500/40 text-xs font-bold hover:bg-emerald-700 dark:hover:bg-emerald-500/30 transition-all shadow-sm">
                <span>🌐 Web Utama</span>
                <span class="text-xs">↗</span>
            </a>
        </div>
    </header>

    <!-- 3. MAIN LOGIN CONTAINER (SPLIT DUAL PANEL) -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 py-6 sm:py-10">
        <div class="w-full max-w-5xl rounded-3xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 border bg-white/95 border-slate-200/90 dark:bg-[#09180e]/90 dark:border-emerald-500/25 dark:backdrop-blur-2xl transition-all duration-300">
            
            <!-- LEFT PANEL: School Identity & Integrated Ecosystem Highlights -->
            <div class="lg:col-span-5 p-6 sm:p-10 bg-gradient-to-br from-[#004532] via-[#065f46] to-[#022c22] dark:from-[#091f11] dark:to-[#040f06] text-white flex flex-col justify-between relative overflow-hidden border-b lg:border-b-0 lg:border-r border-emerald-600/30 dark:border-emerald-500/20">
                
                <!-- Background Campus Glow Accent -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-400/20 dark:bg-[#c6f634]/10 rounded-full blur-3xl"></div>

                <div class="space-y-6 relative z-10">
                    <!-- Top Pill Tag -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/25 border border-emerald-400/40 dark:bg-[#c6f634]/20 dark:border-[#c6f634]/40 text-emerald-200 dark:text-[#c6f634] text-xs font-black shadow-sm">
                        <span>🏛️</span>
                        <span>YAYASAN GENERASI ROBBANI</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-2">
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-snug">
                            Portal Masuk <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 via-teal-200 to-[#c6f634] dark:from-[#c6f634] dark:via-emerald-300 dark:to-teal-200">
                                SmartEdu Terpadu
                            </span>
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-100/90 dark:text-slate-300 leading-relaxed font-medium">
                            Satu gerbang akses terintegrasi untuk pengelolaan data akademik, presensi RFID, keuangan SPP, CBT, dan CMS website yayasan.
                        </p>
                    </div>

                    <!-- 4 Unit Integrated Badges -->
                    <div class="space-y-2 pt-1">
                        <span class="text-[10px] uppercase tracking-wider font-extrabold text-emerald-200/80 dark:text-slate-400 block">Unit Sekolah Terpadu:</span>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="p-2.5 rounded-xl bg-white/10 dark:bg-white/[0.05] border border-white/15 dark:border-white/10 flex items-center gap-2 text-white shadow-xs">
                                <span class="text-base">🧸</span>
                                <div>
                                    <div class="font-extrabold text-[11px]">KB / TKIT</div>
                                    <div class="text-[9px] text-emerald-200 dark:text-slate-400">Pendidikan Usia Dini</div>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-xl bg-white/10 dark:bg-white/[0.05] border border-white/15 dark:border-white/10 flex items-center gap-2 text-white shadow-xs">
                                <span class="text-base">🎒</span>
                                <div>
                                    <div class="font-extrabold text-[11px]">SDIT Robbani</div>
                                    <div class="text-[9px] text-emerald-200 dark:text-slate-400">Sekolah Dasar Islam</div>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-xl bg-white/10 dark:bg-white/[0.05] border border-white/15 dark:border-white/10 flex items-center gap-2 text-white shadow-xs">
                                <span class="text-base">📖</span>
                                <div>
                                    <div class="font-extrabold text-[11px]">SMPIT Robbani</div>
                                    <div class="text-[9px] text-emerald-200 dark:text-slate-400">Boarding &amp; Reguler</div>
                                </div>
                            </div>
                            <div class="p-2.5 rounded-xl bg-white/10 dark:bg-white/[0.05] border border-white/15 dark:border-white/10 flex items-center gap-2 text-white shadow-xs">
                                <span class="text-base">🎓</span>
                                <div>
                                    <div class="font-extrabold text-[11px]">SMAIT Robbani</div>
                                    <div class="text-[9px] text-emerald-200 dark:text-slate-400">Kader Pemimpin Umat</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Protection Pill -->
                    <div class="p-3.5 rounded-2xl bg-black/25 dark:bg-black/40 border border-white/15 dark:border-emerald-500/20 space-y-1">
                        <div class="flex items-center gap-2 text-xs font-bold text-emerald-200 dark:text-[#c6f634]">
                            <svg class="w-4 h-4 text-emerald-300 dark:text-[#c6f634] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Keamanan Terenkripsi &amp; RBAC Terisolasi</span>
                        </div>
                        <p class="text-[10px] text-emerald-100/80 dark:text-slate-400 leading-normal">
                            Hak akses akun dibatasi secara otomatis sesuai penugasan unit kerja &amp; wewenang jabatan.
                        </p>
                    </div>
                </div>

                <!-- Bottom Footer Info -->
                <div class="pt-6 mt-6 border-t border-white/15 flex items-center justify-between text-[11px] text-emerald-100/90 dark:text-slate-400">
                    <span class="font-semibold">Indralaya Utara, Ogan Ilir</span>
                    <span class="font-extrabold text-[#c6f634]">Sumatera Selatan</span>
                </div>
            </div>

            <!-- RIGHT PANEL: Interactive Modern Login Form -->
            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center space-y-6 bg-white dark:bg-slate-950/40">
                
                <!-- Form Header -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex p-2.5 rounded-2xl bg-slate-100 dark:bg-white/10 shadow-xs border border-slate-200 dark:border-white/15">
                            <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-10 sm:h-12 w-auto object-contain">
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-white/10 dark:text-[#c6f634] dark:border-[#c6f634]/30">
                            🔒 Autentikasi Pengguna
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight pt-2">
                        Masuk ke Dashboard
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                        Gunakan email resmi institusi atau username akun yang telah terdaftar.
                    </p>
                </div>

                <!-- Flash Alert Message: Error -->
                @if ($errors->any())
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 dark:bg-rose-500/15 dark:border-rose-500/40 dark:text-rose-200 rounded-2xl text-xs space-y-1.5 shadow-sm animate-fade-in">
                    <div class="flex items-center gap-2 font-bold text-rose-700 dark:text-rose-300">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Gagal Masuk:</span>
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="pl-6 text-[11px] font-medium">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Flash Alert Message: Success -->
                @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 dark:bg-emerald-500/15 dark:border-emerald-500/40 dark:text-emerald-200 rounded-2xl text-xs space-y-1 shadow-sm">
                    <div class="flex items-center gap-2 font-bold text-emerald-700 dark:text-emerald-300">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('admin.login.store') }}" 
                      method="POST" 
                      class="space-y-5"
                      @submit="isSubmitting = true">
                    @csrf

                    <!-- Username / Email Field -->
                    <div class="space-y-1.5">
                        <label for="username" class="block text-xs font-bold text-slate-700 dark:text-slate-200">
                            Username / Email Pengguna:
                        </label>
                        <div class="relative rounded-2xl shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus
                                   placeholder="Contoh: humas@sitrobbani.sch.id / sd@sitrobbani.sch.id" 
                                   class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-white/[0.07] border border-slate-300 dark:border-white/15 text-slate-900 dark:text-white text-xs sm:text-sm font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-[#c6f634] focus:border-transparent focus:bg-white dark:focus:bg-white/[0.12] transition-all">
                        </div>
                    </div>

                    <!-- Password Field with Show/Hide Toggle -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-200">
                                Password Akun:
                            </label>
                        </div>
                        <div class="relative rounded-2xl shadow-xs">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Masukkan password Anda" 
                                   class="w-full pl-11 pr-12 py-3.5 rounded-2xl bg-slate-50 dark:bg-white/[0.07] border border-slate-300 dark:border-white/15 text-slate-900 dark:text-white text-xs sm:text-sm font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-[#c6f634] focus:border-transparent focus:bg-white dark:focus:bg-white/[0.12] transition-all">
                            
                            <!-- Toggle Visibility Button -->
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-700 dark:hover:text-white transition-colors cursor-pointer"
                                    title="Tampilkan / Sembunyikan Password">
                                <!-- Eye Open Icon -->
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Closed Icon -->
                                <svg x-show="showPassword" x-cloak class="w-5 h-5 text-emerald-600 dark:text-[#c6f634]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Encrypted Badge -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors select-none">
                            <input type="checkbox" 
                                   name="remember" 
                                   checked 
                                   class="w-4 h-4 rounded-lg border-slate-300 text-emerald-600 focus:ring-emerald-500 dark:bg-white/10 dark:border-white/20 dark:text-emerald-500 dark:focus:ring-[#c6f634] dark:focus:ring-offset-slate-900 cursor-pointer">
                            <span>Ingat Saya</span>
                        </label>
                        <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-300/90 flex items-center gap-1">
                            <span>🔒</span> SSO Terintegrasi
                        </span>
                    </div>

                    <!-- Submit Button with Dynamic Theme Styling -->
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 dark:from-emerald-500 dark:via-teal-500 dark:to-emerald-600 text-white dark:text-slate-950 font-black text-xs sm:text-sm tracking-wider uppercase shadow-xl shadow-emerald-900/20 dark:shadow-emerald-950/60 hover:shadow-emerald-600/30 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting" class="flex items-center gap-2">
                            <span>MASUK KE DASHBOARD ADMIN</span>
                            <span class="text-base font-bold">➔</span>
                        </span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white dark:text-slate-900" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>MEMVERIFIKASI AKUN...</span>
                        </span>
                    </button>
                </form>

                <!-- Navigation Quick Links -->
                <div class="pt-4 border-t border-slate-200 dark:border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <a href="{{ route('home') }}" class="font-bold text-slate-500 hover:text-emerald-700 dark:text-slate-400 dark:hover:text-[#c6f634] transition-colors flex items-center gap-1.5">
                        <span>←</span>
                        <span>Kembali ke Website Utama</span>
                    </a>
                    <a href="{{ route('school.ppdb') }}" class="font-bold text-emerald-700 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-[#c6f634] transition-colors flex items-center gap-1.5">
                        <span>Portal PPDB Online</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- 4. BOTTOM COPYRIGHT & VERSION FOOTER -->
    <footer class="relative z-10 w-full px-4 py-4 text-center text-[11px] text-slate-500 dark:text-slate-400/80 font-medium">
        <p>© 2026 Yayasan Generasi Robbani Sumatera Selatan • Indralaya Utara, Ogan Ilir • SmartEdu v4.2</p>
    </footer>

</body>
</html>
