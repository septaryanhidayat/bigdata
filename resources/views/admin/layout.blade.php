<!DOCTYPE html>
<html lang="id" class="h-full theme-magenta">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - SmartEdu</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

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
           DYNAMIC THEME OVERRIDES FOR ALL MODULE VIEWS
           ========================================================================== */
        html.theme-magenta .bg-emerald-600, html.theme-magenta .bg-emerald-700, html.theme-magenta .bg-emerald-800, html.theme-magenta .bg-teal-600, html.theme-magenta .bg-teal-700 { background-color: #ec4899 !important; }
        html.theme-magenta .hover\:bg-emerald-700:hover, html.theme-magenta .hover\:bg-emerald-800:hover, html.theme-magenta .hover\:bg-teal-700:hover { background-color: #db2777 !important; }
        html.theme-magenta .text-emerald-600, html.theme-magenta .text-emerald-700, html.theme-magenta .text-emerald-800, html.theme-magenta .text-emerald-900, html.theme-magenta .text-teal-700, html.theme-magenta .group-hover\:text-emerald-700:hover { color: #db2777 !important; }
        html.theme-magenta .bg-emerald-100, html.theme-magenta .bg-emerald-50, html.theme-magenta .bg-teal-100 { background-color: #fce7f3 !important; }
        html.theme-magenta .border-emerald-200, html.theme-magenta .border-emerald-300, html.theme-magenta .border-emerald-500, html.theme-magenta .hover\:border-emerald-500:hover { border-color: #fbcfe8 !important; }
        html.theme-magenta .bg-emerald-950, html.theme-magenta .bg-emerald-900, html.theme-magenta .from-emerald-950, html.theme-magenta .from-emerald-900, html.theme-magenta .to-emerald-900, html.theme-magenta .to-emerald-950 { background: linear-gradient(135deg, #831843 0%, #701a75 50%, #4c1d95 100%) !important; }

        html.theme-emerald .bg-emerald-600, html.theme-emerald .bg-emerald-700, html.theme-emerald .bg-emerald-800, html.theme-emerald .bg-teal-600, html.theme-emerald .bg-teal-700 { background-color: #10b981 !important; }
        html.theme-emerald .hover\:bg-emerald-700:hover, html.theme-emerald .hover\:bg-emerald-800:hover, html.theme-emerald .hover\:bg-teal-700:hover { background-color: #059669 !important; }
        html.theme-emerald .text-emerald-600, html.theme-emerald .text-emerald-700, html.theme-emerald .text-emerald-800, html.theme-emerald .text-emerald-900, html.theme-emerald .text-teal-700, html.theme-emerald .group-hover\:text-emerald-700:hover { color: #047857 !important; }
        html.theme-emerald .bg-emerald-100, html.theme-emerald .bg-emerald-50, html.theme-emerald .bg-teal-100 { background-color: #d1fae5 !important; }
        html.theme-emerald .border-emerald-200, html.theme-emerald .border-emerald-300, html.theme-emerald .border-emerald-500, html.theme-emerald .hover\:border-emerald-500:hover { border-color: #a7f3d0 !important; }
        html.theme-emerald .bg-emerald-950, html.theme-emerald .bg-emerald-900, html.theme-emerald .from-emerald-950, html.theme-emerald .from-emerald-900, html.theme-emerald .to-emerald-900, html.theme-emerald .to-emerald-950 { background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #020617 100%) !important; }

        html.theme-ocean .bg-emerald-600, html.theme-ocean .bg-emerald-700, html.theme-ocean .bg-emerald-800, html.theme-ocean .bg-teal-600, html.theme-ocean .bg-teal-700 { background-color: #3b82f6 !important; }
        html.theme-ocean .hover\:bg-emerald-700:hover, html.theme-ocean .hover\:bg-emerald-800:hover, html.theme-ocean .hover\:bg-teal-700:hover { background-color: #2563eb !important; }
        html.theme-ocean .text-emerald-600, html.theme-ocean .text-emerald-700, html.theme-ocean .text-emerald-800, html.theme-ocean .text-emerald-900, html.theme-ocean .text-teal-700, html.theme-ocean .group-hover\:text-emerald-700:hover { color: #1d4ed8 !important; }
        html.theme-ocean .bg-emerald-100, html.theme-ocean .bg-emerald-50, html.theme-ocean .bg-teal-100 { background-color: #dbeafe !important; }
        html.theme-ocean .border-emerald-200, html.theme-ocean .border-emerald-300, html.theme-ocean .border-emerald-500, html.theme-ocean .hover\:border-emerald-500:hover { border-color: #bfdbfe !important; }
        html.theme-ocean .bg-emerald-950, html.theme-ocean .bg-emerald-900, html.theme-ocean .from-emerald-950, html.theme-ocean .from-emerald-900, html.theme-ocean .to-emerald-900, html.theme-ocean .to-emerald-950 { background: linear-gradient(135deg, #172554 0%, #1e1b4b 50%, #0f172a 100%) !important; }

        html.theme-sunset .bg-emerald-600, html.theme-sunset .bg-emerald-700, html.theme-sunset .bg-emerald-800, html.theme-sunset .bg-teal-600, html.theme-sunset .bg-teal-700 { background-color: #f43f5e !important; }
        html.theme-sunset .hover\:bg-emerald-700:hover, html.theme-sunset .hover\:bg-emerald-800:hover, html.theme-sunset .hover\:bg-teal-700:hover { background-color: #e11d48 !important; }
        html.theme-sunset .text-emerald-600, html.theme-sunset .text-emerald-700, html.theme-sunset .text-emerald-800, html.theme-sunset .text-emerald-900, html.theme-sunset .text-teal-700, html.theme-sunset .group-hover\:text-emerald-700:hover { color: #be123c !important; }
        html.theme-sunset .bg-emerald-100, html.theme-sunset .bg-emerald-50, html.theme-sunset .bg-teal-100 { background-color: #ffe4e6 !important; }
        html.theme-sunset .border-emerald-200, html.theme-sunset .border-emerald-300, html.theme-sunset .border-emerald-500, html.theme-sunset .hover\:border-emerald-500:hover { border-color: #fecdd3 !important; }
        html.theme-sunset .bg-emerald-950, html.theme-sunset .bg-emerald-900, html.theme-sunset .from-emerald-950, html.theme-sunset .from-emerald-900, html.theme-sunset .to-emerald-900, html.theme-sunset .to-emerald-950 { background: linear-gradient(135deg, #4c0519 0%, #431407 50%, #0f172a 100%) !important; }

        html.theme-gold .bg-emerald-600, html.theme-gold .bg-emerald-700, html.theme-gold .bg-emerald-800, html.theme-gold .bg-teal-600, html.theme-gold .bg-teal-700 { background-color: #f59e0b !important; }
        html.theme-gold .hover\:bg-emerald-700:hover, html.theme-gold .hover\:bg-emerald-800:hover, html.theme-gold .hover\:bg-teal-700:hover { background-color: #d97706 !important; }
        html.theme-gold .text-emerald-600, html.theme-gold .text-emerald-700, html.theme-gold .text-emerald-800, html.theme-gold .text-emerald-900, html.theme-gold .text-teal-700, html.theme-gold .group-hover\:text-emerald-700:hover { color: #b45309 !important; }
        html.theme-gold .bg-emerald-100, html.theme-gold .bg-emerald-50, html.theme-gold .bg-teal-100 { background-color: #fef3c7 !important; }
        html.theme-gold .border-emerald-200, html.theme-gold .border-emerald-300, html.theme-gold .border-emerald-500, html.theme-gold .hover\:border-emerald-500:hover { border-color: #fde68a !important; }
        html.theme-gold .bg-emerald-950, html.theme-gold .bg-emerald-900, html.theme-gold .from-emerald-950, html.theme-gold .from-emerald-900, html.theme-gold .to-emerald-900, html.theme-gold .to-emerald-950 { background: linear-gradient(135deg, #451a03 0%, #3f2305 50%, #0f172a 100%) !important; }

        /* ==========================================================================
           DYNAMIC MINIMIZE / COMPACT SIDEBAR STYLES (ICON ONLY MODE)
           ========================================================================== */
        #adminSidebar.sidebar-compact {
            width: 5rem !important; /* 80px compact width */
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
            overflow-x: hidden !important;
        }

        #adminSidebar.sidebar-compact .sidebar-brand-container img {
            max-width: 2.25rem !important;
            max-height: 2.25rem !important;
            object-fit: contain !important;
        }

        #adminSidebar.sidebar-compact .sidebar-text,
        #adminSidebar.sidebar-compact .sidebar-group-title,
        #adminSidebar.sidebar-compact .sidebar-profile-info {
            display: none !important;
        }

        #adminSidebar.sidebar-compact .sidebar-brand-container {
            justify-content: center !important;
            width: 100% !important;
        }

        #adminSidebar.sidebar-compact .sidebar-expand-icon {
            display: none !important;
        }

        #adminSidebar.sidebar-compact .sidebar-compact-icon {
            display: inline-block !important;
        }

        #adminSidebar.sidebar-compact .nav-item-link {
            justify-content: center !important;
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }

        #adminSidebar.sidebar-compact .profile-box-container {
            justify-content: center !important;
            padding: 0.5rem !important;
        }

        #adminSidebar.sidebar-compact .logout-text {
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

    <!-- Dark Sleek Floating Sidebar -->
    <aside id="adminSidebar" class="w-full md:w-64 bg-[#14151b] text-white shrink-0 p-4 sm:p-5 flex flex-col justify-between shadow-2xl relative z-20 transition-all duration-300 overflow-x-hidden">
        <div class="space-y-5">
            
            <!-- Logo & Brand Header (SmartEdu Only) -->
            <div class="flex items-center justify-between px-1 sidebar-brand-container">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 shrink-0 overflow-hidden">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-pink-500 via-rose-500 to-purple-600 flex items-center justify-center text-white font-black text-base shadow-md shrink-0">
                        S
                    </div>
                    <div class="sidebar-text overflow-hidden">
                        <h2 class="font-black text-base tracking-tight leading-none text-white flex items-center gap-1.5">
                            <span>SmartEdu</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                        </h2>
                        <p class="text-[9px] text-slate-400 font-bold tracking-wider uppercase mt-0.5 truncate">Smart School System</p>
                    </div>
                </a>

                <!-- Minimize / Expand Sidebar Toggle Button -->
                <button onclick="toggleAdminSidebar()" title="Minimize / Expand Sidebar" class="hidden md:flex w-7 h-7 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 items-center justify-center text-xs transition-transform active:scale-95 shrink-0">
                    <span class="sidebar-expand-icon">◀</span>
                    <span class="sidebar-compact-icon hidden">▶</span>
                </button>
            </div>

            <!-- Profile User Box -->
            <div class="p-3 rounded-2xl bg-[#1d1f27] border border-slate-800 flex items-center gap-3 profile-box-container">
                <div class="relative shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=ec4899&color=ffffff&bold=true" alt="Avatar" class="w-9 h-9 rounded-full border-2 border-theme-accent shadow-md">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#1d1f27] rounded-full"></span>
                </div>
                <div class="overflow-hidden sidebar-profile-info">
                    <h4 class="font-black text-xs text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</h4>
                    <p class="text-[9px] text-theme-accent font-bold uppercase tracking-wider">Super Administrator</p>
                </div>
            </div>

            @php
                $sidebarSchoolId = session('dashboard_school_id', 'all');
                $sidebarSchools = \App\Models\School::all();
            @endphp

            <!-- Active Unit School Badge & Quick Switcher -->
            <div class="p-3 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2 sidebar-text">
                <div class="flex items-center justify-between text-[9px] font-black text-slate-400">
                    <span class="uppercase tracking-wider">UNIT KONTROL:</span>
                    <span class="px-2 py-0.5 rounded-full {{ $sidebarSchoolId === 'all' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' }}">
                        {{ $sidebarSchoolId === 'all' ? '🏢 Yayasan' : '🏫 Unit Active' }}
                    </span>
                </div>
                
                <form action="{{ route('admin.master.switch-school') }}" method="POST">
                    @csrf
                    <select name="school_id" onchange="this.form.submit()" class="w-full px-2.5 py-1.5 rounded-xl bg-slate-900 text-white font-black text-xs border border-slate-700 focus:outline-none cursor-pointer">
                        <option value="all" {{ $sidebarSchoolId == 'all' ? 'selected' : '' }}>🏢 Semua Unit (Yayasan)</option>
                        @foreach($sidebarSchools as $sc)
                            <option value="{{ $sc->id }}" {{ $sidebarSchoolId == $sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Direct Link Button to Main Website -->
            <a href="{{ route('home') }}" target="_blank" title="Buka Tampilan Website Utama" class="flex items-center justify-between px-3 py-2 rounded-xl bg-slate-800/80 text-white font-bold hover:bg-slate-800 transition-all border border-slate-700/60 nav-item-link text-xs">
                <div class="flex items-center gap-2.5">
                    <span class="text-sm shrink-0">🌐</span>
                    <span class="sidebar-text truncate">Lihat Website Utama</span>
                </div>
                <span class="sidebar-text text-[10px] opacity-60">↗</span>
            </a>

            <!-- Navigation Links with Simplified Icons -->
            <nav class="space-y-1 text-xs font-bold" id="sidebarNav">
                
                <!-- Dashboard Overview -->
                <a href="{{ route('admin.dashboard') }}" title="Dashboard Overview" class="flex items-center justify-between px-3 py-2 rounded-xl transition-all nav-item-link {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 text-center text-sm shrink-0">📊</span> 
                        <span class="sidebar-text">Dashboard Overview</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-orange-400 sidebar-text"></span>
                </a>

                @php
                    $isMasterActive = request()->routeIs('admin.master.*');
                    $isAcademicActive = request()->routeIs('admin.academic.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.bpi.*') || request()->routeIs('admin.cbt.*') || request()->routeIs('admin.ppdb-admin.*') || request()->routeIs('admin.payroll.*') || request()->routeIs('admin.lms.*') || request()->routeIs('admin.bk.*') || request()->routeIs('admin.library.*') || request()->routeIs('admin.sarpras.*');
                    $isFinanceActive = request()->routeIs('admin.finance.*') || request()->routeIs('admin.savings.*') || request()->routeIs('admin.canteen.*');
                    $isCmsActive = request()->routeIs('admin.settings.*') || request()->routeIs('admin.cms.*') || request()->routeIs('admin.modules.*') || request()->routeIs('admin.faqs.*');
                @endphp

                <!-- Nav Group: Modul 1 Master Data (Collapsible) -->
                <div onclick="toggleNavGroup('grpMaster')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-amber-300 transition-colors">
                    <span class="text-[10px] {{ $isMasterActive ? 'text-amber-300 font-black' : 'text-amber-400 font-bold' }} uppercase tracking-widest block">Modul 1: Master Data</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpMaster">{{ $isMasterActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpMaster" class="space-y-0.5 group-content" style="{{ $isMasterActive ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ route('admin.master.index') }}" title="Master Data Hub" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.index') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📂</span> 
                        <span class="sidebar-text">Master Data Hub</span>
                    </a>
                    <a href="{{ route('admin.master.schools') }}" title="Multi-Sekolah & Profil" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.schools') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏛️</span> 
                        <span class="sidebar-text">Multi-Sekolah & Profil</span>
                    </a>
                    <a href="{{ route('admin.master.curriculums') }}" title="Kurikulum & Semester" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.curriculums') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📜</span> 
                        <span class="sidebar-text">Kurikulum & Semester</span>
                    </a>
                    <a href="{{ route('admin.master.classrooms') }}" title="Tingkat & Rombel" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.classrooms') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏫</span> 
                        <span class="sidebar-text">Tingkat & Rombel</span>
                    </a>
                    <a href="{{ route('admin.master.students') }}" title="Data Siswa & RFID" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.students') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🎓</span> 
                        <span class="sidebar-text">Data Siswa & RFID</span>
                    </a>
                    <a href="{{ route('admin.master.teachers') }}" title="Guru & Karyawan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.teachers') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">👨‍🏫</span> 
                        <span class="sidebar-text">Guru & Karyawan</span>
                    </a>
                    <a href="{{ route('admin.master.references') }}" title="Referensi Mapel & Ruang" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.references') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📑</span> 
                        <span class="sidebar-text">Referensi Mapel & Ruang</span>
                    </a>
                </div>

                <!-- Nav Group: Akademik, Presensi & LMS/CBT (Collapsible) -->
                <div onclick="toggleNavGroup('grpAcademic')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-purple-300 transition-colors">
                    <span class="text-[10px] {{ $isAcademicActive ? 'text-purple-300 font-black' : 'text-purple-400 font-bold' }} uppercase tracking-widest block">Akademik, LMS & Konseling</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpAcademic">{{ $isAcademicActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpAcademic" class="space-y-0.5 group-content" style="{{ $isAcademicActive ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ route('admin.academic.schedules') }}" title="Jadwal KBM Mingguan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.schedules') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📅</span> 
                        <span class="sidebar-text">Jadwal KBM Mingguan</span>
                    </a>
                    <a href="{{ route('admin.academic.journals') }}" title="Jurnal KBM Guru" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.journals') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📖</span> 
                        <span class="sidebar-text">Jurnal KBM Guru</span>
                    </a>
                    <a href="{{ route('admin.lms.index') }}" title="E-Learning LMS & Materi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.lms.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💻</span> 
                        <span class="sidebar-text">E-Learning LMS & Materi</span>
                    </a>
                    <a href="{{ route('admin.academic.grades') }}" title="Penilaian & E-Rapor" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.grades') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📝</span> 
                        <span class="sidebar-text">Penilaian & E-Rapor</span>
                    </a>
                    <a href="{{ route('admin.attendance.index') }}" title="Presensi RFID Gate" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.attendance.index') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🪪</span> 
                        <span class="sidebar-text">Presensi RFID Gate</span>
                    </a>
                    <a href="{{ route('admin.attendance.leaves') }}" title="Pengajuan Izin & Sakit" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.attendance.leaves') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏥</span> 
                        <span class="sidebar-text">Pengajuan Izin & Sakit</span>
                    </a>
                    <a href="{{ route('admin.bk.index') }}" title="BK Online & Poin Siswa" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.bk.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💬</span> 
                        <span class="sidebar-text">BK Online & Poin Siswa</span>
                    </a>
                    <a href="{{ route('admin.bpi.index') }}" title="Mutaba'ah BPI & Karakter" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.bpi.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🕌</span> 
                        <span class="sidebar-text">Mutaba'ah BPI & Karakter</span>
                    </a>
                    <a href="{{ route('admin.library.index') }}" title="Perpustakaan Digital E-Library" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.library.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📚</span> 
                        <span class="sidebar-text">Perpustakaan Digital E-Library</span>
                    </a>
                    <a href="{{ route('admin.sarpras.index') }}" title="Sarpras & Aset Barcode" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.sarpras.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📦</span> 
                        <span class="sidebar-text">Sarpras & Aset Barcode</span>
                    </a>
                    <a href="{{ route('admin.cbt.index') }}" title="CBT Ujian Online" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.cbt.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📝</span> 
                        <span class="sidebar-text">CBT Ujian Online</span>
                    </a>
                    <a href="{{ route('admin.ppdb-admin.index') }}" title="PPDB & SPMB Manager" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.ppdb-admin.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📋</span> 
                        <span class="sidebar-text">PPDB & SPMB Manager</span>
                    </a>
                    <a href="{{ route('admin.payroll.index') }}" title="HRIS & E-Payroll Pegawai" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.payroll.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💼</span> 
                        <span class="sidebar-text">HRIS & E-Payroll Pegawai</span>
                    </a>
                </div>

                <!-- Nav Group: Keuangan & Cashless (Collapsible) -->
                <div onclick="toggleNavGroup('grpFinance')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-emerald-300 transition-colors">
                    <span class="text-[10px] {{ $isFinanceActive ? 'text-emerald-300 font-black' : 'text-emerald-400 font-bold' }} uppercase tracking-widest block">Keuangan & Cashless</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpFinance">{{ $isFinanceActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpFinance" class="space-y-0.5 group-content" style="{{ $isFinanceActive ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ route('admin.finance.spp-bills') }}" title="Kasir SPP & Kwitansi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.finance.spp-bills') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💳</span> 
                        <span class="sidebar-text">Kasir SPP & Kwitansi</span>
                    </a>
                    <a href="{{ route('admin.finance.coa') }}" title="COA & Jurnal Akuntansi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.finance.coa') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📊</span> 
                        <span class="sidebar-text">COA & Jurnal Akuntansi</span>
                    </a>
                    <a href="{{ route('admin.savings.index') }}" title="Teller Tabungan Siswa" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.savings.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏦</span> 
                        <span class="sidebar-text">Teller Tabungan Siswa</span>
                    </a>
                    <a href="{{ route('admin.canteen.index') }}" title="POS Kantin Cashless" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.canteen.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🛒</span> 
                        <span class="sidebar-text">POS Kantin Cashless</span>
                    </a>
                </div>

                <!-- Nav Group: Pengaturan CMS Web (Collapsible) -->
                <div onclick="toggleNavGroup('grpCms')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-cyan-300 transition-colors">
                    <span class="text-[10px] {{ $isCmsActive ? 'text-cyan-300 font-black' : 'text-cyan-400 font-bold' }} uppercase tracking-widest block">Pengaturan Web & Sales</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpCms">{{ $isCmsActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpCms" class="space-y-0.5 group-content" style="{{ $isCmsActive ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ route('admin.settings.portal') }}" title="Web Portal Utama" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.portal') || request()->routeIs('admin.settings') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏛️</span> 
                        <span class="sidebar-text">Web Portal Utama</span>
                    </a>
                    <a href="{{ route('admin.cms.content') }}" title="Kelola Konten Web" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.cms.content') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🎨</span> 
                        <span class="sidebar-text">Kelola Konten Web</span>
                    </a>
                    <a href="{{ route('admin.settings.sales') }}" title="Landing Sales 21 Modul" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.sales') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📦</span> 
                        <span class="sidebar-text">Landing Sales 21 Modul</span>
                    </a>
                    <a href="{{ route('admin.settings.units') }}" title="Profil Unit (SD/SMP/SMA)" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.units') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏢</span> 
                        <span class="sidebar-text">Profil Unit (SD/SMP/SMA)</span>
                    </a>
                    <a href="{{ route('admin.modules.index') }}" title="Kelola 21 Modul Fitur" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.modules.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🧩</span> 
                        <span class="sidebar-text">Kelola 21 Modul Fitur</span>
                    </a>
                    <a href="{{ route('admin.faqs.index') }}" title="Kelola FAQ Tanya Jawab" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.faqs.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">❓</span> 
                        <span class="sidebar-text">Kelola FAQ Tanya Jawab</span>
                    </a>
                </div>

            </nav>
        </div>

        <!-- Sidebar Footer Action Box -->
        <div class="pt-4 mt-6 border-t border-slate-800/80 space-y-3">
            <div class="p-3 rounded-2xl bg-[#1d1f27] border border-slate-800 text-center space-y-2 profile-box-container">
                <p class="text-[10px] text-slate-400 font-semibold leading-tight sidebar-text">SmartEdu Ecosystem Active</p>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Keluar / Logout" class="w-full py-2 px-3 rounded-xl bg-theme-gradient text-white font-black text-xs transition-colors shadow-lg flex items-center justify-center gap-2">
                        <span>🚪</span> <span class="logout-text">Keluar (Logout)</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Container -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Bar Header -->
        <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10 shadow-sm">
            
            <!-- Sidebar Toggle Button & Global Search Box -->
            <div class="flex items-center gap-3">
                
                <!-- Toggle Minimize/Expand Sidebar Button -->
                <button onclick="toggleAdminSidebar()" title="Minimize / Expand Sidebar Menu" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 flex items-center justify-center font-bold text-lg shadow-sm border border-slate-200 transition-transform active:scale-95">
                    ☰
                </button>

                <!-- Direct Website Link (Top Header Quick Button) -->
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-extrabold text-xs hover:bg-emerald-100 transition-colors">
                    <span>🌐</span> <span>Lihat Website</span> <span>↗</span>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-xl w-64 lg:w-72">
                    <span class="text-slate-400">🔍</span>
                    <input type="text" placeholder="Cari data siswa, guru, tagihan, rfid..." class="bg-transparent border-none text-xs font-semibold focus:outline-none w-full text-slate-700">
                </div>
            </div>

            <!-- Right Controls: 5 Color Preset Switchers & User Dropdown -->
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- 5 Theme Gradient Color Options -->
                <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shadow-sm">
                    <span class="text-[10px] text-slate-500 font-black uppercase px-1 hidden lg:inline">Theme:</span>
                    
                    <!-- Option 1: Magenta Pink -->
                    <button onclick="setAdminTheme('theme-magenta')" data-theme="theme-magenta" title="Theme 1: Neon Magenta" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #ec4899 0%, #d946ef 50%, #8b5cf6 100%);"></button>
                    
                    <!-- Option 2: Emerald Robbani -->
                    <button onclick="setAdminTheme('theme-emerald')" data-theme="theme-emerald" title="Theme 2: Emerald Robbani" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);"></button>
                    
                    <!-- Option 3: Cyber Ocean Blue -->
                    <button onclick="setAdminTheme('theme-ocean')" data-theme="theme-ocean" title="Theme 3: Cyber Blue" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);"></button>
                    
                    <!-- Option 4: Sunset Coral -->
                    <button onclick="setAdminTheme('theme-sunset')" data-theme="theme-sunset" title="Theme 4: Sunset Coral" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #f43f5e 0%, #f97316 50%, #eab308 100%);"></button>
                    
                    <!-- Option 5: Obsidian Gold -->
                    <button onclick="setAdminTheme('theme-gold')" data-theme="theme-gold" title="Theme 5: Obsidian Gold" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);"></button>
                </div>

                <!-- User Top Profile Indicator -->
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=ec4899&color=ffffff&bold=true" class="w-9 h-9 rounded-full border-2 border-theme-accent">
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
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

            // Highlight active button ring cleanly with shadow ring
            document.querySelectorAll('.theme-btn').forEach(btn => {
                if (btn.dataset.theme === themeName) {
                    btn.style.boxShadow = '0 0 0 2px #ffffff, 0 0 0 4px #0f172a';
                    btn.style.transform = 'scale(1.15)';
                } else {
                    btn.style.boxShadow = 'none';
                    btn.style.transform = 'scale(1)';
                }
            });

            // Dispatch event for chart re-render if needed
            window.dispatchEvent(new CustomEvent('adminThemeChanged', { detail: { theme: themeName } }));
        }

        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('sidebar-compact');
            const isCompact = sidebar.classList.contains('sidebar-compact');
            localStorage.setItem('smartedu_sidebar_compact', isCompact);
        }

        // Show/Hide Menu Filter (All vs Active Only)
        function setMenuFilter(mode) {
            const allLinks = document.querySelectorAll('.nav-item-link');
            const groupTitles = document.querySelectorAll('.sidebar-group-title');
            const btnAll = document.getElementById('btnFilterAll');
            const btnActive = document.getElementById('btnFilterActive');

            if (mode === 'active') {
                if (btnAll) btnAll.className = 'px-2 py-0.5 rounded-md text-slate-400 hover:text-white font-bold transition-all';
                if (btnActive) btnActive.className = 'px-2 py-0.5 rounded-md bg-pink-600 text-white font-bold transition-all';
                
                allLinks.forEach(link => {
                    if (link.classList.contains('nav-link-active')) {
                        link.style.display = 'flex';
                    } else {
                        link.style.display = 'none';
                    }
                });
                groupTitles.forEach(g => g.style.display = 'none');
            } else {
                if (btnActive) btnActive.className = 'px-2 py-0.5 rounded-md text-slate-400 hover:text-white font-bold transition-all';
                if (btnAll) btnAll.className = 'px-2 py-0.5 rounded-md bg-slate-700 text-white font-bold transition-all';
                
                allLinks.forEach(link => link.style.display = 'flex');
                groupTitles.forEach(g => g.style.display = 'flex');
            }
        }

        // Toggle Group Accordion Collapse/Expand
        function toggleNavGroup(groupId) {
            const groupEl = document.getElementById(groupId);
            const arrowEl = document.getElementById('arrow-' + groupId);
            if (groupEl) {
                if (groupEl.style.display === 'none') {
                    groupEl.style.display = 'block';
                    if (arrowEl) arrowEl.innerText = '▼';
                } else {
                    groupEl.style.display = 'none';
                    if (arrowEl) arrowEl.innerText = '►';
                }
            }
        }

        // Restore saved theme & sidebar compact state on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('smartedu_admin_theme') || 'theme-magenta';
            setAdminTheme(savedTheme);

            const isCompact = localStorage.getItem('smartedu_sidebar_compact') === 'true';
            if (isCompact) {
                document.getElementById('adminSidebar').classList.add('sidebar-compact');
            }
        });

        // Global Client Device & Browser Exception Listener
        window.addEventListener('error', function(event) {
            if (!event.message || event.message.includes('Script error')) return;
            try {
                fetch('/admin/system-errors/log-client-error', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: event.message,
                        file: event.filename ? event.filename.split('/').slice(-2).join('/') : 'Browser JS Device',
                        line: event.lineno || 0,
                        stack_trace: event.error ? event.error.stack : null,
                        url: window.location.href
                    })
                });
            } catch(e) {}
        });
    </script>
</body>
</html>
