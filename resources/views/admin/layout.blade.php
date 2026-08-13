<!DOCTYPE html>
<html lang="id" class="h-full theme-magenta">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SmartEdu</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* 5 Dynamic Theme Gradient Presets */
        :root, html.theme-magenta, body.theme-magenta {
            --theme-gradient-primary: linear-gradient(135deg, #ec4899 0%, #d946ef 50%, #8b5cf6 100%);
            --theme-accent: #ec4899;
            --theme-accent-dark: #db2777;
            --theme-accent-light: #fce7f3;
            --theme-text-accent: #be185d;
        }
        html.theme-emerald, body.theme-emerald {
            --theme-gradient-primary: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            --theme-accent: #10b981;
            --theme-accent-dark: #059669;
            --theme-accent-light: #d1fae5;
            --theme-text-accent: #047857;
        }
        html.theme-ocean, body.theme-ocean {
            --theme-gradient-primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            --theme-accent: #3b82f6;
            --theme-accent-dark: #2563eb;
            --theme-accent-light: #dbeafe;
            --theme-text-accent: #1d4ed8;
        }
        html.theme-sunset, body.theme-sunset {
            --theme-gradient-primary: linear-gradient(135deg, #f43f5e 0%, #f97316 50%, #eab308 100%);
            --theme-accent: #f43f5e;
            --theme-accent-dark: #e11d48;
            --theme-accent-light: #ffe4e6;
            --theme-text-accent: #be123c;
        }
        html.theme-gold, body.theme-gold {
            --theme-gradient-primary: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            --theme-accent: #f59e0b;
            --theme-accent-dark: #d97706;
            --theme-accent-light: #fef3c7;
            --theme-text-accent: #b45309;
        }

        /* Dynamic Theme Classes applied to buttons, cards, badges, text, and active sidebar */
        .bg-theme-gradient { background: var(--theme-gradient-primary) !important; }
        .bg-theme-accent { background-color: var(--theme-accent) !important; }
        .bg-theme-dark { background-color: var(--theme-accent-dark) !important; }
        .bg-theme-light { background-color: var(--theme-accent-light) !important; }
        .text-theme-accent { color: var(--theme-accent) !important; }
        .text-theme-dark { color: var(--theme-text-accent) !important; }
        .border-theme-accent { border-color: var(--theme-accent) !important; }

        /* Dynamic Active Nav Link */
        .nav-link-active {
            background: var(--theme-gradient-primary) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.2);
        }

        /* ==========================================================================
           DYNAMIC THEME OVERRIDES FOR ALL MODULE VIEWS (MASTER DATA, AKADEMIK, ETC.)
           ========================================================================== */

        /* --- 1. THEME MAGENTA (PINK/PURPLE) --- */
        html.theme-magenta .bg-emerald-600, html.theme-magenta .bg-emerald-700, html.theme-magenta .bg-emerald-800, html.theme-magenta .bg-teal-600, html.theme-magenta .bg-teal-700 { background-color: #ec4899 !important; }
        html.theme-magenta .hover\:bg-emerald-700:hover, html.theme-magenta .hover\:bg-emerald-800:hover, html.theme-magenta .hover\:bg-teal-700:hover { background-color: #db2777 !important; }
        html.theme-magenta .text-emerald-600, html.theme-magenta .text-emerald-700, html.theme-magenta .text-emerald-800, html.theme-magenta .text-emerald-900, html.theme-magenta .text-teal-700, html.theme-magenta .group-hover\:text-emerald-700:hover { color: #db2777 !important; }
        html.theme-magenta .bg-emerald-100, html.theme-magenta .bg-emerald-50, html.theme-magenta .bg-teal-100 { background-color: #fce7f3 !important; }
        html.theme-magenta .border-emerald-200, html.theme-magenta .border-emerald-300, html.theme-magenta .border-emerald-500, html.theme-magenta .hover\:border-emerald-500:hover { border-color: #fbcfe8 !important; }
        html.theme-magenta .bg-emerald-950, html.theme-magenta .bg-emerald-900, html.theme-magenta .from-emerald-950, html.theme-magenta .from-emerald-900, html.theme-magenta .to-emerald-900, html.theme-magenta .to-emerald-950 { background: linear-gradient(135deg, #831843 0%, #701a75 50%, #4c1d95 100%) !important; }

        /* --- 2. THEME EMERALD (GREEN/TEAL) --- */
        html.theme-emerald .bg-emerald-600, html.theme-emerald .bg-emerald-700, html.theme-emerald .bg-emerald-800, html.theme-emerald .bg-teal-600, html.theme-emerald .bg-teal-700 { background-color: #10b981 !important; }
        html.theme-emerald .hover\:bg-emerald-700:hover, html.theme-emerald .hover\:bg-emerald-800:hover, html.theme-emerald .hover\:bg-teal-700:hover { background-color: #059669 !important; }
        html.theme-emerald .text-emerald-600, html.theme-emerald .text-emerald-700, html.theme-emerald .text-emerald-800, html.theme-emerald .text-emerald-900, html.theme-emerald .text-teal-700, html.theme-emerald .group-hover\:text-emerald-700:hover { color: #047857 !important; }
        html.theme-emerald .bg-emerald-100, html.theme-emerald .bg-emerald-50, html.theme-emerald .bg-teal-100 { background-color: #d1fae5 !important; }
        html.theme-emerald .border-emerald-200, html.theme-emerald .border-emerald-300, html.theme-emerald .border-emerald-500, html.theme-emerald .hover\:border-emerald-500:hover { border-color: #a7f3d0 !important; }
        html.theme-emerald .bg-emerald-950, html.theme-emerald .bg-emerald-900, html.theme-emerald .from-emerald-950, html.theme-emerald .from-emerald-900, html.theme-emerald .to-emerald-900, html.theme-emerald .to-emerald-950 { background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #020617 100%) !important; }

        /* --- 3. THEME OCEAN (BLUE/INDIGO) --- */
        html.theme-ocean .bg-emerald-600, html.theme-ocean .bg-emerald-700, html.theme-ocean .bg-emerald-800, html.theme-ocean .bg-teal-600, html.theme-ocean .bg-teal-700 { background-color: #3b82f6 !important; }
        html.theme-ocean .hover\:bg-emerald-700:hover, html.theme-ocean .hover\:bg-emerald-800:hover, html.theme-ocean .hover\:bg-teal-700:hover { background-color: #2563eb !important; }
        html.theme-ocean .text-emerald-600, html.theme-ocean .text-emerald-700, html.theme-ocean .text-emerald-800, html.theme-ocean .text-emerald-900, html.theme-ocean .text-teal-700, html.theme-ocean .group-hover\:text-emerald-700:hover { color: #1d4ed8 !important; }
        html.theme-ocean .bg-emerald-100, html.theme-ocean .bg-emerald-50, html.theme-ocean .bg-teal-100 { background-color: #dbeafe !important; }
        html.theme-ocean .border-emerald-200, html.theme-ocean .border-emerald-300, html.theme-ocean .border-emerald-500, html.theme-ocean .hover\:border-emerald-500:hover { border-color: #bfdbfe !important; }
        html.theme-ocean .bg-emerald-950, html.theme-ocean .bg-emerald-900, html.theme-ocean .from-emerald-950, html.theme-ocean .from-emerald-900, html.theme-ocean .to-emerald-900, html.theme-ocean .to-emerald-950 { background: linear-gradient(135deg, #172554 0%, #1e1b4b 50%, #0f172a 100%) !important; }

        /* --- 4. THEME SUNSET (ROSE/CORAL/ORANGE) --- */
        html.theme-sunset .bg-emerald-600, html.theme-sunset .bg-emerald-700, html.theme-sunset .bg-emerald-800, html.theme-sunset .bg-teal-600, html.theme-sunset .bg-teal-700 { background-color: #f43f5e !important; }
        html.theme-sunset .hover\:bg-emerald-700:hover, html.theme-sunset .hover\:bg-emerald-800:hover, html.theme-sunset .hover\:bg-teal-700:hover { background-color: #e11d48 !important; }
        html.theme-sunset .text-emerald-600, html.theme-sunset .text-emerald-700, html.theme-sunset .text-emerald-800, html.theme-sunset .text-emerald-900, html.theme-sunset .text-teal-700, html.theme-sunset .group-hover\:text-emerald-700:hover { color: #be123c !important; }
        html.theme-sunset .bg-emerald-100, html.theme-sunset .bg-emerald-50, html.theme-sunset .bg-teal-100 { background-color: #ffe4e6 !important; }
        html.theme-sunset .border-emerald-200, html.theme-sunset .border-emerald-300, html.theme-sunset .border-emerald-500, html.theme-sunset .hover\:border-emerald-500:hover { border-color: #fecdd3 !important; }
        html.theme-sunset .bg-emerald-950, html.theme-sunset .bg-emerald-900, html.theme-sunset .from-emerald-950, html.theme-sunset .from-emerald-900, html.theme-sunset .to-emerald-900, html.theme-sunset .to-emerald-950 { background: linear-gradient(135deg, #4c0519 0%, #431407 50%, #0f172a 100%) !important; }

        /* --- 5. THEME GOLD (AMBER/GOLD) --- */
        html.theme-gold .bg-emerald-600, html.theme-gold .bg-emerald-700, html.theme-gold .bg-emerald-800, html.theme-gold .bg-teal-600, html.theme-gold .bg-teal-700 { background-color: #f59e0b !important; }
        html.theme-gold .hover\:bg-emerald-700:hover, html.theme-gold .hover\:bg-emerald-800:hover, html.theme-gold .hover\:bg-teal-700:hover { background-color: #d97706 !important; }
        html.theme-gold .text-emerald-600, html.theme-gold .text-emerald-700, html.theme-gold .text-emerald-800, html.theme-gold .text-emerald-900, html.theme-gold .text-teal-700, html.theme-gold .group-hover\:text-emerald-700:hover { color: #b45309 !important; }
        html.theme-gold .bg-emerald-100, html.theme-gold .bg-emerald-50, html.theme-gold .bg-teal-100 { background-color: #fef3c7 !important; }
        html.theme-gold .border-emerald-200, html.theme-gold .border-emerald-300, html.theme-gold .border-emerald-500, html.theme-gold .hover\:border-emerald-500:hover { border-color: #fde68a !important; }
        html.theme-gold .bg-emerald-950, html.theme-gold .bg-emerald-900, html.theme-gold .from-emerald-950, html.theme-gold .from-emerald-900, html.theme-gold .to-emerald-900, html.theme-gold .to-emerald-950 { background: linear-gradient(135deg, #451a03 0%, #3f2305 50%, #0f172a 100%) !important; }

        /* Collapsed Sidebar CSS */
        .sidebar-collapsed {
            display: none !important;
        }
    </style>

    <script>
        // Set initial theme before body renders to avoid color flicker
        const savedTheme = localStorage.getItem('smartedu_admin_theme') || 'theme-magenta';
        document.documentElement.className = 'h-full ' + savedTheme;
    </script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col md:flex-row theme-magenta" id="adminBody">

    <!-- Dark Sleek Floating Sidebar (No inner scroll, clean layout) -->
    <aside id="adminSidebar" class="w-full md:w-64 bg-[#14151b] text-white shrink-0 p-5 flex flex-col justify-between shadow-2xl relative z-20 transition-all duration-300">
        <div class="space-y-6">
            
            <!-- Logo & Brand Header -->
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SmartEdu" class="w-9 h-9 object-contain rounded-xl bg-white p-1 shadow-md">
                    <div>
                        <h2 class="font-black text-base tracking-tight leading-none text-white flex items-center gap-1">
                            <span>SmartEdu</span>
                            <span class="w-2 h-2 rounded-full bg-theme-accent animate-pulse"></span>
                        </h2>
                        <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase mt-1">Siakad Robbani</p>
                    </div>
                </div>
            </div>

            <!-- Profile User Box (Matching Reference "ZIHAD BROKEN UIUX Designer") -->
            <div class="p-3.5 rounded-2xl bg-[#1d1f27] border border-slate-800 flex items-center gap-3">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin Robbani') }}&background=ec4899&color=ffffff&bold=true" alt="Avatar" class="w-10 h-10 rounded-full border-2 border-theme-accent shadow-md">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-[#1d1f27] rounded-full"></span>
                </div>
                <div class="overflow-hidden">
                    <h4 class="font-black text-xs text-white truncate">{{ Auth::user()->name ?? 'ZIHAD ROBBANI' }}</h4>
                    <p class="text-[10px] text-theme-accent font-bold uppercase tracking-wider">Super Administrator</p>
                </div>
            </div>

            <!-- Navigation Links (No inner scrollbar) -->
            <nav class="space-y-1 text-xs font-bold">
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3.5 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center text-sm">📊</span> 
                        <span>Dashboard Overview</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                </a>

                <!-- Nav Group: Modul 1 Master Data -->
                <div class="pt-3 pb-1 px-3 flex items-center justify-between">
                    <span class="text-[10px] text-amber-400 font-black uppercase tracking-widest block">Modul 1: Master Data</span>
                </div>
                <a href="{{ route('admin.master.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.index') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center text-sm">📂</span> 
                    <span>Master Data Hub</span>
                </a>
                <a href="{{ route('admin.master.schools') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.schools') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-orange-500/20 text-orange-400 border border-orange-500/40 flex items-center justify-center text-sm">🏛️</span> 
                    <span>Multi-Sekolah & Profil</span>
                </a>
                <a href="{{ route('admin.master.curriculums') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.curriculums') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center text-sm">📜</span> 
                    <span>Kurikulum & Semester</span>
                </a>
                <a href="{{ route('admin.master.classrooms') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.classrooms') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center text-sm">🏫</span> 
                    <span>Tingkat & Rombel</span>
                </a>
                <a href="{{ route('admin.master.students') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.students') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-orange-500/20 text-orange-400 border border-orange-500/40 flex items-center justify-center text-sm">🎓</span> 
                    <span>Data Siswa & RFID</span>
                </a>
                <a href="{{ route('admin.master.teachers') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.teachers') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center text-sm">👨‍🏫</span> 
                    <span>Guru & Karyawan</span>
                </a>
                <a href="{{ route('admin.master.references') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.master.references') ? 'nav-link-active' : 'text-slate-300' }}">
                    <span class="w-7 h-7 rounded-lg bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center text-sm">📑</span> 
                    <span>Referensi Mapel & Ruang</span>
                </a>

                <!-- Nav Group: Modul 2 & 3 Akademik & Presensi -->
                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest block">Akademik & Presensi</span>
                </div>
                <a href="{{ route('admin.academic.schedules') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.academic.schedules') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>📅</span> <span>Jadwal KBM Mingguan</span>
                </a>
                <a href="{{ route('admin.academic.journals') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.academic.journals') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>📖</span> <span>Jurnal KBM Guru</span>
                </a>
                <a href="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.academic.grades') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>📝</span> <span>Penilaian & E-Rapor</span>
                </a>
                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.attendance.index') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🪪</span> <span>Presensi RFID Gate</span>
                </a>
                <a href="{{ route('admin.attendance.leaves') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.attendance.leaves') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🏥</span> <span>Pengajuan Izin & Sakit</span>
                </a>

                <!-- Nav Group: Modul 4, 5, 6 Keuangan & POS -->
                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest block">Keuangan & Cashless</span>
                </div>
                <a href="{{ route('admin.finance.spp-bills') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.finance.spp-bills') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>💳</span> <span>Kasir SPP & Kwitansi</span>
                </a>
                <a href="{{ route('admin.finance.coa') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.finance.coa') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>📊</span> <span>COA & Jurnal Akuntansi</span>
                </a>
                <a href="{{ route('admin.savings.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.savings.*') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🏦</span> <span>Teller Tabungan Siswa</span>
                </a>
                <a href="{{ route('admin.canteen.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.canteen.*') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🛒</span> <span>POS Kantin Cashless</span>
                </a>

                <!-- Nav Group: Landing Page & CMS Settings -->
                <div class="pt-3 pb-1 px-3">
                    <span class="text-[10px] text-slate-500 font-black uppercase tracking-widest block">Pengaturan Web & Sales</span>
                </div>
                <a href="{{ route('admin.settings.portal') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.settings.portal') || request()->routeIs('admin.settings') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🏛️</span> <span>Web Portal Utama</span>
                </a>
                <a href="{{ route('admin.settings.sales') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.settings.sales') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>📦</span> <span>Landing Sales 21 Modul</span>
                </a>
                <a href="{{ route('admin.settings.units') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.settings.units') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🏢</span> <span>Profil Unit (SD/SMP/SMA)</span>
                </a>
                <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.modules.*') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>🧩</span> <span>Kelola 21 Modul Fitur</span>
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3.5 py-2 rounded-xl hover:bg-slate-800/80 transition-colors {{ request()->routeIs('admin.faqs.*') ? 'nav-link-active' : 'text-slate-400' }}">
                    <span>❓</span> <span>Kelola FAQ Tanya Jawab</span>
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer Action Box (Matching Reference "+Add Menu" Card) -->
        <div class="pt-4 mt-6 border-t border-slate-800/80 space-y-3">
            <div class="p-3.5 rounded-2xl bg-[#1d1f27] border border-slate-800 text-center space-y-2">
                <p class="text-[11px] text-slate-300 font-semibold leading-tight">SmartEdu Ecosystem Active</p>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 px-3 rounded-xl bg-theme-gradient text-white font-black text-xs transition-colors shadow-lg">
                        🚪 Keluar (Logout)
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Bar Header (Matching Reference Image Header with Sidebar Toggle) -->
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10 shadow-sm">
            
            <!-- Sidebar Toggle Button & Global Search Box -->
            <div class="flex items-center gap-3">
                
                <!-- Toggle Hide/Show Sidebar Button -->
                <button onclick="toggleAdminSidebar()" title="Hide/Show Sidebar Nav" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center justify-center font-bold text-lg shadow-sm border border-slate-200 transition-transform active:scale-95">
                    ☰
                </button>

                <!-- Search Bar -->
                <div class="hidden sm:flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-xl w-64 md:w-80">
                    <span class="text-slate-400">🔍</span>
                    <input type="text" placeholder="Cari data siswa, guru, tagihan, rfid..." class="bg-transparent border-none text-xs font-semibold focus:outline-none w-full text-slate-700">
                </div>
            </div>

            <!-- Right Controls: 5 Color Preset Switchers & User Dropdown -->
            <div class="flex items-center gap-4">
                
                <!-- 5 Theme Gradient Color Options -->
                <div class="flex items-center gap-1.5 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] text-slate-500 font-black uppercase px-1 hidden lg:inline">Theme:</span>
                    
                    <!-- Option 1: Magenta Pink -->
                    <button onclick="setAdminTheme('theme-magenta')" data-theme="theme-magenta" title="Theme 1: Neon Magenta" class="theme-btn w-6 h-6 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 border-2 border-white shadow hover:scale-110 transition-all"></button>
                    
                    <!-- Option 2: Emerald Robbani -->
                    <button onclick="setAdminTheme('theme-emerald')" data-theme="theme-emerald" title="Theme 2: Emerald Robbani" class="theme-btn w-6 h-6 rounded-full bg-gradient-to-r from-emerald-500 to-cyan-600 border-2 border-white shadow hover:scale-110 transition-all"></button>
                    
                    <!-- Option 3: Cyber Ocean Blue -->
                    <button onclick="setAdminTheme('theme-ocean')" data-theme="theme-ocean" title="Theme 3: Cyber Blue" class="theme-btn w-6 h-6 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 border-2 border-white shadow hover:scale-110 transition-all"></button>
                    
                    <!-- Option 4: Sunset Coral -->
                    <button onclick="setAdminTheme('theme-sunset')" data-theme="theme-sunset" title="Theme 4: Sunset Coral" class="theme-btn w-6 h-6 rounded-full bg-gradient-to-r from-rose-500 to-amber-500 border-2 border-white shadow hover:scale-110 transition-all"></button>
                    
                    <!-- Option 5: Obsidian Gold -->
                    <button onclick="setAdminTheme('theme-gold')" data-theme="theme-gold" title="Theme 5: Obsidian Gold" class="theme-btn w-6 h-6 rounded-full bg-gradient-to-r from-amber-500 to-yellow-600 border-2 border-white shadow hover:scale-110 transition-all"></button>
                </div>

                <!-- User Top Profile Indicator -->
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=ec4899&color=ffffff&bold=true" class="w-9 h-9 rounded-full border-2 border-theme-accent">
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Zihad UIUX' }}</span>
                        <span class="block text-[10px] text-theme-accent font-bold">Admin Portal</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Area -->
        <main class="flex-1 p-6 md:p-8 overflow-y-auto bg-slate-50">
            <!-- Flash Message -->
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-100 border border-emerald-300 text-emerald-900 font-bold text-xs flex items-center gap-2 shadow-sm">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Dynamic Theme & Sidebar Toggle Script -->
    <script>
        function setAdminTheme(themeName) {
            document.documentElement.className = 'h-full ' + themeName;
            document.body.className = document.body.className.replace(/theme-\w+/g, '') + ' ' + themeName;
            localStorage.setItem('smartedu_admin_theme', themeName);

            // Highlight active button ring
            document.querySelectorAll('.theme-btn').forEach(btn => {
                if (btn.dataset.theme === themeName) {
                    btn.classList.add('ring-2', 'ring-slate-900', 'scale-110');
                } else {
                    btn.classList.remove('ring-2', 'ring-slate-900', 'scale-110');
                }
            });

            // Dispatch event for chart re-render if needed
            window.dispatchEvent(new CustomEvent('adminThemeChanged', { detail: { theme: themeName } }));
        }

        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('sidebar-collapsed');
            const isCollapsed = sidebar.classList.contains('sidebar-collapsed');
            localStorage.setItem('smartedu_sidebar_collapsed', isCollapsed);
        }

        // Restore saved theme & sidebar collapse state on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('smartedu_admin_theme') || 'theme-magenta';
            setAdminTheme(savedTheme);

            const isCollapsed = localStorage.getItem('smartedu_sidebar_collapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('adminSidebar').classList.add('sidebar-collapsed');
            }
        });
    </script>
</body>
</html>
