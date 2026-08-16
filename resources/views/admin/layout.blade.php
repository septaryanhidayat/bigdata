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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        /* Theme overrides for sidebar active indicators only */
        html.theme-emerald { --theme-accent: #059669; --theme-accent-light: #ecfdf5; --theme-gradient-primary: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0284c7 100%); }
        html.theme-ocean { --theme-accent: #2563eb; --theme-accent-light: #eff6ff; --theme-gradient-primary: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%); }
        html.theme-magenta { --theme-accent: #db2777; --theme-accent-light: #fdf2f8; --theme-gradient-primary: linear-gradient(135deg, #db2777 0%, #c026d3 50%, #7c3aed 100%); }
        html.theme-sunset { --theme-accent: #e11d48; --theme-accent-light: #fff1f2; --theme-gradient-primary: linear-gradient(135deg, #e11d48 0%, #ea580c 50%, #ca8a04 100%); }
        html.theme-gold { --theme-accent: #d97706; --theme-accent-light: #fffbeb; --theme-gradient-primary: linear-gradient(135deg, #d97706 0%, #b45309 50%, #78350f 100%); }

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
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=059669&color=ffffff&bold=true" alt="Avatar" class="w-9 h-9 rounded-full border-2 border-emerald-400 shadow-md">
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 border-2 border-[#1d1f27] rounded-full"></span>
                </div>
                <div class="overflow-hidden sidebar-profile-info">
                    <h4 class="font-black text-xs text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</h4>
                    <span class="inline-block px-2 py-0.5 mt-0.5 rounded-full text-[9px] font-extrabold border {{ Auth::user()->role_badge_class ?? 'bg-slate-500/20 text-slate-300 border-slate-500/30' }}">
                        {{ Auth::user()->role_name_label ?? 'Super Admin' }}
                    </span>
                </div>
            </div>

            @php
                $sidebarSchoolId = session('dashboard_school_id', 'all');
                $sidebarSchools = \App\Models\School::all();
            @endphp

            @if(Auth::user()->school_id)
            <!-- Locked Unit Badge for Unit Specific Accounts -->
            <div class="p-3 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2 sidebar-text">
                <div class="flex items-center justify-between text-[9px] font-black text-slate-400">
                    <span class="uppercase tracking-wider">UNIT KERJA:</span>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[9px] font-extrabold">
                        🔒 Terkunci
                    </span>
                </div>
                <div class="p-2 rounded-xl bg-slate-900 text-white font-black text-xs border border-slate-700 flex items-center gap-2.5">
                    @if(Auth::user()->school && Auth::user()->school->logo_url)
                        <img src="{{ asset(Auth::user()->school->logo_url) }}" alt="Logo {{ Auth::user()->school->code }}" class="h-6 w-auto object-contain shrink-0">
                    @else
                        <span class="text-sm shrink-0">🏫</span>
                    @endif
                    <span class="truncate">{{ Auth::user()->school->name ?? 'Unit Sekolah' }}</span>
                </div>
            </div>
            @else
            <!-- Active Unit School Badge & Quick Switcher for Foundation & Super Admin -->
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
            @endif

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
                
                <!-- Dashboard Overview (All Roles) -->
                <a href="{{ route('admin.dashboard') }}" title="Dashboard Overview" class="flex items-center justify-between px-3 py-2 rounded-xl transition-all nav-item-link {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 text-center text-sm shrink-0">📊</span> 
                        <span class="sidebar-text">Dashboard Overview</span>
                    </div>
                    <span class="w-2 h-2 rounded-full bg-orange-400 sidebar-text"></span>
                </a>

                @php
                    $isMasterActive = request()->routeIs('admin.master.*');
                    $isHrisActive = request()->routeIs('admin.employees.*') || request()->routeIs('admin.payroll.*') || request()->routeIs('admin.mobile.*') || request()->routeIs('admin.bpi.*');
                    $isAcademicActive = request()->routeIs('admin.academic.*') || request()->routeIs('admin.lms.*') || request()->routeIs('admin.cbt.*');
                    $isStudentServicesActive = request()->routeIs('admin.attendance.*') || request()->routeIs('admin.bk.*') || request()->routeIs('admin.ppdb-admin.*') || request()->routeIs('admin.library.*') || request()->routeIs('admin.sarpras.*');
                    $isFinanceActive = request()->routeIs('admin.finance.*') || request()->routeIs('admin.savings.*') || request()->routeIs('admin.canteen.*');
                    $isLettersActive = request()->routeIs('admin.letters.*');
                    $isCmsActive = request()->routeIs('admin.settings.*') || request()->routeIs('admin.cms.*') || request()->routeIs('admin.modules.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.users.*');
                @endphp

                <!-- 1. KATEGORI: MASTER DATA YAYASAN & SEKOLAH -->
                @if(Auth::user()->canAccessModule('master'))
                <div onclick="toggleNavGroup('grpMaster')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-amber-300 transition-colors">
                    <span class="text-[10px] {{ $isMasterActive ? 'text-amber-300 font-black' : 'text-amber-400 font-bold' }} uppercase tracking-widest block">1. Master Data Yayasan</span>
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
                    <a href="{{ route('admin.master.classrooms') }}" title="Tingkat & Rombel Kelas" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.classrooms') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏫</span> 
                        <span class="sidebar-text">Tingkat & Rombel Kelas</span>
                    </a>
                    <a href="{{ route('admin.master.students') }}" title="Data Siswa & RFID" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.students') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🎓</span> 
                        <span class="sidebar-text">Data Siswa & RFID</span>
                    </a>
                    <a href="{{ route('admin.master.references') }}" title="Referensi Mapel & Ruangan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.master.references') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📑</span> 
                        <span class="sidebar-text">Referensi Mapel & Ruang</span>
                    </a>
                </div>
                @endif

                <!-- 2. KATEGORI: SDM, KEPEGAWAIAN & MOBILE HRIS -->
                @php
                    $canViewHrisGroup = Auth::user()->canAccessModule('hris') || Auth::user()->canAccessModule('bpi');
                @endphp
                @if($canViewHrisGroup)
                <div onclick="toggleNavGroup('grpHris')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-emerald-300 transition-colors">
                    <span class="text-[10px] {{ $isHrisActive ? 'text-emerald-300 font-black' : 'text-emerald-400 font-bold' }} uppercase tracking-widest block">2. SDM & Mobile HRIS</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpHris">{{ $isHrisActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpHris" class="space-y-0.5 group-content" style="{{ $isHrisActive ? 'display: block;' : 'display: none;' }}">
                    @if(Auth::user()->canAccessModule('hris'))
                    <a href="{{ route('admin.employees.index') }}" title="Database Induk & E-Berkas SDM" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.employees.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📁</span> 
                        <span class="sidebar-text">Data Induk & E-Berkas SDM</span>
                    </a>
                    <a href="{{ route('admin.payroll.index') }}" title="HRIS & E-Payroll Pegawai" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.payroll.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💼</span> 
                        <span class="sidebar-text">HRIS & E-Payroll Pegawai</span>
                    </a>
                    <a href="{{ route('admin.mobile.index') }}" title="Aplikasi Mobile SDM & Face ID" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.mobile.index') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📱</span> 
                        <span class="sidebar-text">Monitoring Mobile SDM</span>
                    </a>
                    <a href="{{ route('admin.mobile.faces') }}" title="Database Biometrik Face ID" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.mobile.faces') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">👤</span> 
                        <span class="sidebar-text">Database Biometrik Face ID</span>
                    </a>
                    <a href="{{ route('admin.mobile.geofence') }}" title="Pengaturan Koordinat & Geofence GPS" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.mobile.geofence*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📍</span> 
                        <span class="sidebar-text">Geofence & Titik Peta</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('bpi'))
                    <a href="{{ route('admin.bpi.index') }}" title="Mutaba'ah BPI & Pembina" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.bpi.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🕌</span> 
                        <span class="sidebar-text">Mutaba'ah BPI & Pembina</span>
                    </a>
                    @endif
                </div>
                @endif

                <!-- 3. KATEGORI: AKADEMIK & PEMBELAJARAN (KBM, LMS, CBT) -->
                @php
                    $canViewAcademicGroup = Auth::user()->canAccessModule('academic') || Auth::user()->canAccessModule('lms') || Auth::user()->canAccessModule('cbt_ppdb');
                @endphp
                @if($canViewAcademicGroup)
                <div onclick="toggleNavGroup('grpAcademic')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-purple-300 transition-colors">
                    <span class="text-[10px] {{ $isAcademicActive ? 'text-purple-300 font-black' : 'text-purple-400 font-bold' }} uppercase tracking-widest block">3. Akademik & Pembelajaran</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpAcademic">{{ $isAcademicActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpAcademic" class="space-y-0.5 group-content" style="{{ $isAcademicActive ? 'display: block;' : 'display: none;' }}">
                    @if(Auth::user()->canAccessModule('academic'))
                    <a href="{{ route('admin.academic.schedules') }}" title="Jadwal KBM Mingguan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.schedules') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📅</span> 
                        <span class="sidebar-text">Jadwal KBM Mingguan</span>
                    </a>
                    <a href="{{ route('admin.academic.journals') }}" title="Jurnal KBM Guru" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.journals') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📖</span> 
                        <span class="sidebar-text">Jurnal KBM Guru</span>
                    </a>
                    <a href="{{ route('admin.academic.grades') }}" title="Penilaian & E-Rapor" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.academic.grades') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📝</span> 
                        <span class="sidebar-text">Penilaian & E-Rapor</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('lms'))
                    <a href="{{ route('admin.lms.index') }}" title="E-Learning LMS & Materi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.lms.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💻</span> 
                        <span class="sidebar-text">E-Learning LMS & Materi</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('cbt_ppdb'))
                    <a href="{{ route('admin.cbt.index') }}" title="CBT Ujian Online" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.cbt.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📝</span> 
                        <span class="sidebar-text">CBT Ujian Online</span>
                    </a>
                    @endif
                </div>
                @endif

                <!-- 4. KATEGORI: LAYANAN SISWA, KESISWAAN & FASILITAS -->
                @php
                    $canViewStudentServicesGroup = Auth::user()->canAccessModule('attendance') || Auth::user()->canAccessModule('bk') || Auth::user()->canAccessModule('cbt_ppdb') || Auth::user()->canAccessModule('library') || Auth::user()->canAccessModule('sarpras');
                @endphp
                @if($canViewStudentServicesGroup)
                <div onclick="toggleNavGroup('grpStudentServices')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-blue-300 transition-colors">
                    <span class="text-[10px] {{ $isStudentServicesActive ? 'text-blue-300 font-black' : 'text-blue-400 font-bold' }} uppercase tracking-widest block">4. Layanan Siswa & Fasilitas</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpStudentServices">{{ $isStudentServicesActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpStudentServices" class="space-y-0.5 group-content" style="{{ $isStudentServicesActive ? 'display: block;' : 'display: none;' }}">
                    @if(Auth::user()->canAccessModule('attendance'))
                    <a href="{{ route('admin.attendance.index') }}" title="Presensi RFID Gate Siswa" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.attendance.index') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🪪</span> 
                        <span class="sidebar-text">Presensi RFID Gate Siswa</span>
                    </a>
                    <a href="{{ route('admin.attendance.leaves') }}" title="Pengajuan Izin & Sakit" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.attendance.leaves') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏥</span> 
                        <span class="sidebar-text">Pengajuan Izin & Sakit</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('bk'))
                    <a href="{{ route('admin.bk.index') }}" title="BK Online & Poin Siswa" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.bk.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💬</span> 
                        <span class="sidebar-text">BK Online & Poin Siswa</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('cbt_ppdb'))
                    <a href="{{ route('admin.ppdb-admin.index') }}" title="PPDB & SPMB Siswa Baru" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.ppdb-admin.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📋</span> 
                        <span class="sidebar-text">PPDB & SPMB Siswa Baru</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('library'))
                    <a href="{{ route('admin.library.index') }}" title="Perpustakaan Digital E-Library" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.library.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📚</span> 
                        <span class="sidebar-text">Perpustakaan Digital</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('sarpras'))
                    <a href="{{ route('admin.sarpras.index') }}" title="Sarpras & Aset Barcode" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.sarpras.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📦</span> 
                        <span class="sidebar-text">Sarpras & Aset Barcode</span>
                    </a>
                    @endif
                </div>
                @endif

                <!-- 5. KATEGORI: KEUANGAN & CASHLESS KOPERASI -->
                @php
                    $canViewFinanceGroup = Auth::user()->canAccessModule('finance') || Auth::user()->canAccessModule('savings') || Auth::user()->canAccessModule('canteen');
                @endphp
                @if($canViewFinanceGroup)
                <div onclick="toggleNavGroup('grpFinance')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-emerald-300 transition-colors">
                    <span class="text-[10px] {{ $isFinanceActive ? 'text-emerald-300 font-black' : 'text-emerald-400 font-bold' }} uppercase tracking-widest block">5. Keuangan & Cashless</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpFinance">{{ $isFinanceActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpFinance" class="space-y-0.5 group-content" style="{{ $isFinanceActive ? 'display: block;' : 'display: none;' }}">
                    @if(Auth::user()->canAccessModule('finance'))
                    <a href="{{ route('admin.finance.spp-bills') }}" title="Kasir SPP & Kwitansi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.finance.spp-bills') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">💳</span> 
                        <span class="sidebar-text">Kasir SPP & Kwitansi</span>
                    </a>
                    <a href="{{ route('admin.finance.coa') }}" title="COA & Jurnal Akuntansi" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.finance.coa') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📊</span> 
                        <span class="sidebar-text">COA & Jurnal Akuntansi</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('savings'))
                    <a href="{{ route('admin.savings.index') }}" title="Teller Tabungan Siswa" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.savings.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🏦</span> 
                        <span class="sidebar-text">Teller Tabungan Siswa</span>
                    </a>
                    @endif

                    @if(Auth::user()->canAccessModule('canteen'))
                    <a href="{{ route('admin.canteen.index') }}" title="POS Kantin Cashless" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.canteen.*') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🛒</span> 
                        <span class="sidebar-text">POS Kantin Cashless</span>
                    </a>
                    @endif
                </div>
                @endif

                <!-- 6. KATEGORI: PERSURATAN & E-OFFICE TTE -->
                @if(Auth::user()->canAccessModule('letters'))
                <div onclick="toggleNavGroup('grpLetters')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-pink-300 transition-colors">
                    <span class="text-[10px] {{ $isLettersActive ? 'text-pink-300 font-black' : 'text-pink-400 font-bold' }} uppercase tracking-widest block">6. Persuratan & E-Office</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpLetters">{{ $isLettersActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpLetters" class="space-y-0.5 group-content" style="{{ $isLettersActive ? 'display: block;' : 'display: none;' }}">
                    <a href="{{ route('admin.letters.index') }}" title="Overview Persuratan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.index') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📬</span> 
                        <span class="sidebar-text">Overview Persuratan</span>
                    </a>
                    <a href="{{ route('admin.letters.incoming') }}" title="Buku Agenda Surat Masuk" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.incoming') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📥</span> 
                        <span class="sidebar-text">Buku Surat Masuk</span>
                    </a>
                    <a href="{{ route('admin.letters.outgoing') }}" title="Surat Keluar & Draft" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.outgoing') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📤</span> 
                        <span class="sidebar-text">Surat Keluar & Draft</span>
                    </a>
                    <a href="{{ route('admin.letters.dispositions') }}" title="Lembar Disposisi Pimpinan" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.dispositions') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📌</span> 
                        <span class="sidebar-text">Disposisi Pimpinan</span>
                    </a>
                    <a href="{{ route('admin.letters.tte-queue') }}" title="Antrian TTE Elektronik" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.tte-queue') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">✍️</span> 
                        <span class="sidebar-text">Antrian TTE Digital</span>
                    </a>
                    <a href="{{ route('admin.letters.templates') }}" title="Format Template Baku" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.templates') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">📝</span> 
                        <span class="sidebar-text">Format Template Baku</span>
                    </a>
                    <a href="{{ route('admin.letters.archive') }}" title="E-Filing & Arsip Digital" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.letters.archive') ? 'nav-link-active' : 'text-slate-300' }}">
                        <span class="w-5 text-center text-sm shrink-0 opacity-80">🗄️</span> 
                        <span class="sidebar-text">E-Filing & Arsip Digital</span>
                    </a>
                </div>
                @endif

                <!-- 7. KATEGORI: PENGATURAN WEB, AKUN & CMS -->
                @if(Auth::user()->canAccessModule('settings'))
                <div onclick="toggleNavGroup('grpCms')" class="pt-3 pb-1 px-3 flex items-center justify-between sidebar-group-title cursor-pointer hover:text-cyan-300 transition-colors">
                    <span class="text-[10px] {{ $isCmsActive ? 'text-cyan-300 font-black' : 'text-cyan-400 font-bold' }} uppercase tracking-widest block">7. Pengaturan Web & CMS</span>
                    <span class="text-[9px] text-slate-400 group-arrow sidebar-text" id="arrow-grpCms">{{ $isCmsActive ? '▼' : '►' }}</span>
                </div>
                <div id="grpCms" class="space-y-0.5 group-content" style="{{ $isCmsActive ? 'display: block;' : 'display: none;' }}">
                    @if(Auth::user()->school_id)
                        @php
                            $userSchoolCode = strtolower(Auth::user()->school->code ?? 'sdit');
                        @endphp
                        <a href="{{ route('admin.settings.units.edit', $userSchoolCode) }}" title="Profil Website Unit {{ strtoupper($userSchoolCode) }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.units.edit') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">🏢</span> 
                            <span class="sidebar-text">Profil Web Unit {{ strtoupper($userSchoolCode) }}</span>
                        </a>
                        <a href="{{ route('admin.cms.content', ['tab' => 'news']) }}" title="Publikasi Berita Unit" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.cms.content') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">📰</span> 
                            <span class="sidebar-text">Publikasi Berita Unit</span>
                        </a>
                    @else
                        <a href="{{ route('admin.users.index') }}" title="Manajemen Akun & Role Pengguna" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.users.*') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">👥</span> 
                            <span class="sidebar-text">Manajemen Akun & Role</span>
                        </a>
                        <a href="{{ route('admin.settings.portal') }}" title="Web Portal Utama" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.portal') || request()->routeIs('admin.settings') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">🏛️</span> 
                            <span class="sidebar-text">Web Portal Utama</span>
                        </a>
                        <a href="{{ route('admin.cms.content') }}" title="Kelola Konten Web" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.cms.content') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">🎨</span> 
                            <span class="sidebar-text">Kelola Konten Web</span>
                        </a>
                        <a href="{{ route('admin.settings.units') }}" title="Profil Unit (SD/SMP/SMA)" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.units') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">🏢</span> 
                            <span class="sidebar-text">Profil Unit (SD/SMP/SMA)</span>
                        </a>
                        <a href="{{ route('admin.settings.sales') }}" title="Landing Sales 21 Modul" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.settings.sales') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">📦</span> 
                            <span class="sidebar-text">Landing Sales 21 Modul</span>
                        </a>
                        <a href="{{ route('admin.modules.index') }}" title="Kelola 21 Modul Fitur" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.modules.*') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">🧩</span> 
                            <span class="sidebar-text">Kelola 21 Modul Fitur</span>
                        </a>
                        <a href="{{ route('admin.faqs.index') }}" title="Kelola FAQ Tanya Jawab" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-slate-800/80 transition-colors nav-item-link {{ request()->routeIs('admin.faqs.*') ? 'nav-link-active' : 'text-slate-300' }}">
                            <span class="w-5 text-center text-sm shrink-0 opacity-80">❓</span> 
                            <span class="sidebar-text">Kelola FAQ Tanya Jawab</span>
                        </a>
                    @endif
                </div>
                @endif

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
                <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 font-extrabold text-xs transition-colors shadow-2xs">
                    <span>🌐</span> <span>Lihat Website</span> <span>↗</span>
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex items-center gap-3 bg-slate-100 px-4 py-2 rounded-xl w-64 lg:w-72 border border-slate-200">
                    <span class="text-slate-400">🔍</span>
                    <input type="text" placeholder="Cari data siswa, guru, tagihan, rfid..." class="bg-transparent border-none text-xs font-semibold focus:outline-none w-full text-slate-700">
                </div>
            </div>

            <!-- Right Controls: 5 Color Preset Switchers & User Dropdown -->
            <div class="flex items-center gap-3 sm:gap-4">
                
                <!-- 5 Theme Gradient Color Options -->
                <div class="flex items-center gap-2 bg-slate-100 p-1.5 rounded-2xl border border-slate-200 shadow-xs">
                    <span class="text-[10px] text-slate-500 font-black uppercase px-1 hidden lg:inline">Theme:</span>
                    
                    <!-- Option 1: Emerald Robbani -->
                    <button onclick="setAdminTheme('theme-emerald')" data-theme="theme-emerald" title="Theme: Emerald Robbani" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0284c7 100%);"></button>
                    
                    <!-- Option 2: Cyber Ocean Blue -->
                    <button onclick="setAdminTheme('theme-ocean')" data-theme="theme-ocean" title="Theme: Ocean Blue" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #7c3aed 100%);"></button>
                    
                    <!-- Option 3: Magenta Violet -->
                    <button onclick="setAdminTheme('theme-magenta')" data-theme="theme-magenta" title="Theme: Magenta Violet" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #db2777 0%, #c026d3 50%, #7c3aed 100%);"></button>
                    
                    <!-- Option 4: Sunset Coral -->
                    <button onclick="setAdminTheme('theme-sunset')" data-theme="theme-sunset" title="Theme: Sunset Coral" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #e11d48 0%, #ea580c 50%, #ca8a04 100%);"></button>
                    
                    <!-- Option 5: Obsidian Gold -->
                    <button onclick="setAdminTheme('theme-gold')" data-theme="theme-gold" title="Theme: Obsidian Gold" class="theme-btn w-6 h-6 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-all shrink-0 cursor-pointer" style="background: linear-gradient(135deg, #d97706 0%, #b45309 50%, #78350f 100%);"></button>
                </div>

                <!-- User Top Profile Indicator & Logout Action -->
                @php
                    $topUserPhoto = Auth::user()->avatar 
                        ? (str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar)) 
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Admin') . '&background=0f172a&color=ffffff&bold=true';
                @endphp
                <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200">
                    <img src="{{ $topUserPhoto }}" class="w-9 h-9 rounded-full object-cover border-2 border-slate-300 shadow-xs">
                    <div class="hidden sm:block text-left">
                        <span class="block text-xs font-black text-slate-900 leading-tight">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <span class="block text-[10px] text-emerald-700 font-extrabold">Admin Portal</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline-block ml-1">
                        @csrf
                        <button type="submit" title="Keluar / Logout dari Sistem" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-700 text-slate-700 border border-slate-300 transition-colors flex items-center gap-1.5 text-xs font-black" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                            <span>🚪</span> <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
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
                    localStorage.setItem('smartedu_nav_' + groupId, 'open');
                } else {
                    groupEl.style.display = 'none';
                    if (arrowEl) arrowEl.innerText = '►';
                    localStorage.setItem('smartedu_nav_' + groupId, 'closed');
                }
            }
        }

        // Restore saved theme, active group & sidebar compact state on page load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('smartedu_admin_theme') || 'theme-emerald';
            setAdminTheme(savedTheme);

            const isCompact = localStorage.getItem('smartedu_sidebar_compact') === 'true';
            if (isCompact) {
                const sb = document.getElementById('adminSidebar');
                if (sb) sb.classList.add('sidebar-compact');
            }

            // Always expand active group containing the currently active page and ensure all sibling submenus are visible
            const activeLink = document.querySelector('.nav-link-active');
            if (activeLink) {
                const parentGroup = activeLink.closest('.group-content');
                if (parentGroup) {
                    parentGroup.style.display = 'block';
                    const parentId = parentGroup.id;
                    const arrowEl = document.getElementById('arrow-' + parentId);
                    if (arrowEl) arrowEl.innerText = '▼';

                    // Ensure all sub-links in this group are visible
                    parentGroup.querySelectorAll('.nav-item-link').forEach(link => {
                        link.style.display = 'flex';
                    });
                }
            }
        });

        // Global SweetAlert2 Toast & Dialog Helpers
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#1d1f27',
            color: '#ffffff',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            customClass: {
                popup: 'rounded-2xl border border-slate-800 shadow-2xl backdrop-blur-md text-xs font-bold'
            }
        });

        window.smartAlert = {
            toast: function(icon, title, timer = 3500) {
                return Toast.fire({ icon, title, timer });
            },
            confirmDelete: function(event, form, title = 'Konfirmasi Hapus Data', text = 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.') {
                event.preventDefault();
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#475569',
                    confirmButtonText: '🗑️ Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    background: '#1d1f27',
                    color: '#ffffff',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs',
                        confirmButton: 'rounded-xl font-black px-4 py-2 text-xs',
                        cancelButton: 'rounded-xl font-bold px-4 py-2 text-xs'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        };

        // Global SweetAlert2 Confirmation Interceptor for forms with data-confirm
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const confirmMsg = form.getAttribute('data-confirm');
            if (confirmMsg && !form.dataset.confirmed) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Tindakan',
                    text: confirmMsg,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#475569',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal',
                    background: '#1d1f27',
                    color: '#ffffff',
                    customClass: {
                        popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs',
                        confirmButton: 'rounded-xl font-black px-4 py-2 text-xs',
                        cancelButton: 'rounded-xl font-bold px-4 py-2 text-xs'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = "true";
                        form.submit();
                    }
                });
            }
        });
    </script>

    <!-- SweetAlert2 Session Flash Notifications (Auto-Dismiss with Timer) -->
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                timer: 3500,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#1d1f27',
                color: '#ffffff',
                iconColor: '#10b981',
                customClass: {
                    popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs'
                }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'error',
                title: 'Perhatian / Terjadi Kesalahan!',
                text: @json(session('error')),
                timer: 4500,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#e11d48',
                background: '#1d1f27',
                color: '#ffffff',
                iconColor: '#f43f5e',
                customClass: {
                    popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs',
                    confirmButton: 'rounded-xl font-black px-5 py-2.5 text-xs'
                }
            });
        });
    </script>
    @endif

    @if(session('warning'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: @json(session('warning')),
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#1d1f27',
                color: '#ffffff',
                iconColor: '#f59e0b',
                customClass: {
                    popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs'
                }
            });
        });
    </script>
    @endif

    @if(session('info'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: @json(session('info')),
                timer: 3500,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#1d1f27',
                color: '#ffffff',
                iconColor: '#3b82f6',
                customClass: {
                    popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs'
                }
            });
        });
    </script>
    @endif

    @if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let errorHtml = '<ul style="text-align: left; font-size: 0.85rem; padding-left: 1.2rem; list-style-type: disc; color: #fca5a5;">';
            @foreach($errors->all() as $error)
                errorHtml += '<li style="margin-bottom: 4px;">' + @json($error) + '</li>';
            @endforeach
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Validasi Data Gagal!',
                html: errorHtml,
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: true,
                confirmButtonText: 'Periksa Kembali',
                confirmButtonColor: '#e11d48',
                background: '#1d1f27',
                color: '#ffffff',
                iconColor: '#f43f5e',
                customClass: {
                    popup: 'rounded-3xl border border-slate-800 shadow-2xl p-6 text-xs',
                    confirmButton: 'rounded-xl font-black px-5 py-2.5 text-xs'
                }
            });
        });
    </script>
    @endif
</body>
</html>
