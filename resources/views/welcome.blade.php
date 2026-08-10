<!DOCTYPE html>
<html lang="id" x-data="{ 
    darkMode: false,
    activeCategory: 'all',
    activeConceptTab: 'siswa',
    selectedModule: null,
    faqOpen: null,
    toggleTheme() {
        this.darkMode = !this.darkMode;
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['app_name'] }} - {{ $settings['school_name'] }} | Official Digital Ecosystem</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        [x-cloak] { display: none !important; }
        
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #ffffff;
        }
        .dark ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 text-black dark:text-cyan-300 transition-colors duration-300 antialiased min-h-screen">

    <!-- ========================================== -->
    <!-- HEADER BAR                                 -->
    <!-- ========================================== -->
    <header class="sticky top-0 z-40 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Official SmartEdu Logo -->
            <a href="#" class="flex items-center gap-3 group">
                <img src="/images/smartedu_logo.png" alt="SmartEdu Logo" class="h-10 w-auto object-contain hover:scale-102 transition-transform">
                <div class="hidden sm:block border-l border-slate-200 dark:border-slate-800 pl-3">
                    <span class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider block">Robbani Edition</span>
                    <span class="text-[10px] text-teal-700 dark:text-cyan-400 font-bold block">{{ $settings['school_name'] }}</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-extrabold">
                <a href="#fitur" class="text-teal-800 dark:text-white hover:text-teal-600 transition-colors">17 Modul Fitur</a>
                <a href="#konsep-aplikasi" class="text-teal-800 dark:text-white hover:text-teal-600 transition-colors">Konsep Tampilan Apps</a>
                <a href="#faq" class="text-teal-800 dark:text-white hover:text-teal-600 transition-colors">FAQ</a>
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-xl bg-teal-50 dark:bg-slate-800 text-teal-800 dark:text-cyan-300 border border-teal-200 dark:border-slate-700 hover:bg-teal-100 font-black text-xs flex items-center gap-1.5 shadow-sm">
                    <span>⚙️ CMS Admin</span>
                </a>
            </nav>

            <!-- Light / Dark Mode Toggle Button -->
            <button @click="toggleTheme()" 
                    class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 text-xs font-black transition-all flex items-center gap-2 shadow-sm">
                <span x-show="!darkMode">☀️ Light Mode</span>
                <span x-show="darkMode" x-cloak>🌙 Dark Mode</span>
            </button>
        </div>
    </header>

    <!-- ========================================== -->
    <!-- HERO SECTION                               -->
    <!-- Light Mode: Background White, Title Teal/Navy, Text Black -->
    <!-- Dark Mode: Background Dark, Title White, Text Cyan        -->
    <!-- ========================================== -->
    <section class="py-16 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Text Content -->
            <div class="lg:col-span-7 space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-cyan-300 border border-teal-300 dark:border-teal-800 text-xs font-black shadow-sm">
                    <span>{{ $settings['hero_badge'] }}</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-black text-teal-800 dark:text-white tracking-tight leading-tight">
                    {{ $settings['hero_title'] }}
                </h1>

                <p class="text-base sm:text-lg text-black dark:text-cyan-300 leading-relaxed font-extrabold">
                    {{ $settings['hero_desc'] }}
                </p>

                <!-- Stats Bar -->
                <div class="pt-4 grid grid-cols-3 gap-4 border-t border-slate-200 dark:border-slate-800">
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 text-center shadow-sm">
                        <h3 class="text-2xl font-black text-teal-800 dark:text-white">{{ count($modules) }}+</h3>
                        <p class="text-xs text-black dark:text-cyan-300 font-extrabold mt-1">Modul Digital</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 text-center shadow-sm">
                        <h3 class="text-2xl font-black text-teal-800 dark:text-white">100%</h3>
                        <p class="text-xs text-black dark:text-cyan-300 font-extrabold mt-1">Terintegrasi</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 text-center shadow-sm">
                        <h3 class="text-2xl font-black text-amber-600 dark:text-amber-400">Multi</h3>
                        <p class="text-xs text-black dark:text-cyan-300 font-extrabold mt-1">Unit Sekolah</p>
                    </div>
                </div>
            </div>

            <!-- Right 3D Visual Graphic -->
            <div class="lg:col-span-5 flex justify-center">
                <div class="w-full max-w-md bg-white dark:bg-slate-900 p-3 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl">
                    <img src="/images/hero_3d_illustration_1786347707126.png" 
                         alt="SmartEdu 3D Ecosystem" 
                         class="w-full h-auto rounded-2xl object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- KATALOG 17 MODUL FITUR LENGKAP             -->
    <!-- Light Mode: Card White, Title Green, Text Black -->
    <!-- Dark Mode: Card Dark, Title White, Text Cyan   -->
    <!-- ========================================== -->
    <section id="fitur" class="py-20 max-w-7xl mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto space-y-3 mb-10">
            <span class="px-3.5 py-1.5 rounded-full bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-cyan-300 border border-teal-300 dark:border-teal-800 text-xs font-black uppercase tracking-wider">
                Katalog Produk Digital
            </span>
            <h2 class="text-3xl font-black text-teal-800 dark:text-white tracking-tight">
                Preview Semua Modul Fitur SmartEdu
            </h2>
            <p class="text-black dark:text-cyan-300 text-sm font-bold">
                Solusi lengkap dari manajemen data dasar, kurikulum akademik, keuangan, hingga pembentukan karakter siswa.
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <button @click="activeCategory = 'all'" 
                    :class="{ 'bg-teal-800 dark:bg-teal-600 text-white': activeCategory === 'all', 'bg-white dark:bg-slate-900 text-black dark:text-slate-200 border border-slate-300 dark:border-slate-800': activeCategory !== 'all' }"
                    class="px-4 py-2 rounded-xl font-black text-xs transition-all shadow-sm">
                Semua Modul ({{ count($modules) }})
            </button>
            <button @click="activeCategory = 'akademik'" 
                    :class="{ 'bg-teal-800 dark:bg-teal-600 text-white': activeCategory === 'akademik', 'bg-white dark:bg-slate-900 text-black dark:text-slate-200 border border-slate-300 dark:border-slate-800': activeCategory !== 'akademik' }"
                    class="px-4 py-2 rounded-xl font-black text-xs transition-all shadow-sm">
                🎓 Akademik & Rapor
            </button>
            <button @click="activeCategory = 'keuangan'" 
                    :class="{ 'bg-teal-800 dark:bg-teal-600 text-white': activeCategory === 'keuangan', 'bg-white dark:bg-slate-900 text-black dark:text-slate-200 border border-slate-300 dark:border-slate-800': activeCategory !== 'keuangan' }"
                    class="px-4 py-2 rounded-xl font-black text-xs transition-all shadow-sm">
                💰 Keuangan & POS
            </button>
            <button @click="activeCategory = 'bpi'" 
                    :class="{ 'bg-teal-800 dark:bg-teal-600 text-white': activeCategory === 'bpi', 'bg-white dark:bg-slate-900 text-black dark:text-slate-200 border border-slate-300 dark:border-slate-800': activeCategory !== 'bpi' }"
                    class="px-4 py-2 rounded-xl font-black text-xs transition-all shadow-sm">
                🕌 BPI & Character
            </button>
            <button @click="activeCategory = 'operasional'" 
                    :class="{ 'bg-teal-800 dark:bg-teal-600 text-white': activeCategory === 'operasional', 'bg-white dark:bg-slate-900 text-black dark:text-slate-200 border border-slate-300 dark:border-slate-800': activeCategory !== 'operasional' }"
                    class="px-4 py-2 rounded-xl font-black text-xs transition-all shadow-sm">
                ⚙️ HRIS & Operasional
            </button>
        </div>

        <!-- 17 Cards Grid (Ultra High Contrast) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($modules as $mod)
            <div x-show="activeCategory === 'all' || activeCategory === '{{ $mod->category }}'" 
                 @click="selectedModule = {{ json_encode($mod) }}"
                 class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-md hover:shadow-xl hover:border-teal-600 transition-all cursor-pointer flex flex-col justify-between group relative overflow-hidden">
                
                <!-- Gradient Line Header Accent -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500"></div>

                <div>
                    <div class="flex items-center justify-between mb-3 mt-1">
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 dark:bg-slate-800 text-2xl flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform">
                            {{ $mod->icon }}
                        </div>
                        <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                            {{ $mod->category_name }}
                        </span>
                    </div>

                    <h3 class="text-lg font-black text-teal-800 dark:text-white tracking-tight mb-2 group-hover:text-teal-600 transition-colors">
                        {{ $mod->title }}
                    </h3>
                    <p class="text-xs text-black dark:text-cyan-300 leading-relaxed font-bold mb-4">
                        {{ $mod->short_desc }}
                    </p>

                    <ul class="space-y-2 mb-4">
                        @if(is_array($mod->highlights))
                            @foreach(array_slice($mod->highlights, 0, 3) as $item)
                            <li class="flex items-start gap-2 text-xs text-black dark:text-slate-200 font-extrabold">
                                <span class="text-teal-600 dark:text-cyan-400 font-black">✓</span>
                                <span>{{ $item }}</span>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs font-black text-teal-800 dark:text-white">
                    <span>Lihat Sub-Modul</span>
                    <span class="group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- CONCEPT SHOWCASE: MOBILE APPS & DASHBOARDS -->
    <!-- (Replaces Mutaba'ah Standalone Section)   -->
    <!-- ========================================== -->
    <section id="konsep-aplikasi" class="py-20 bg-gradient-to-br from-slate-900 via-slate-950 to-teal-950 text-white relative overflow-hidden shadow-2xl">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto space-y-3 mb-12">
                <span class="px-4 py-1.5 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase tracking-wider shadow">
                    ✨ Rencana Konsep Tampilan Aplikasi & Dashboard
                </span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                    Gambaran Konsep Antarmuka Pengguna SmartEdu
                </h2>
                <p class="text-teal-100 text-sm font-bold leading-relaxed">
                    Setiap peran pengguna (Orang Tua, Siswa, Guru, Bendahara, HRD, dan Admin Yayasan) memiliki tampilan dashboard & mobile app yang dirancang khusus untuk kenyamanan maksimal.
                </p>
            </div>

            <!-- Concept Interactive Selector Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                <button @click="activeConceptTab = 'siswa'" 
                        :class="{ 'bg-amber-400 text-slate-950 shadow-lg scale-105': activeConceptTab === 'siswa', 'bg-slate-800/90 text-slate-200 border border-slate-700': activeConceptTab !== 'siswa' }"
                        class="px-5 py-2.5 rounded-2xl font-black text-xs transition-all flex items-center gap-2">
                    <span>📱 App Siswa & Ortu</span>
                </button>
                <button @click="activeConceptTab = 'guru'" 
                        :class="{ 'bg-amber-400 text-slate-950 shadow-lg scale-105': activeConceptTab === 'guru', 'bg-slate-800/90 text-slate-200 border border-slate-700': activeConceptTab !== 'guru' }"
                        class="px-5 py-2.5 rounded-2xl font-black text-xs transition-all flex items-center gap-2">
                    <span>👨‍🏫 App Guru & Staf</span>
                </button>
                <button @click="activeConceptTab = 'keuangan'" 
                        :class="{ 'bg-amber-400 text-slate-950 shadow-lg scale-105': activeConceptTab === 'keuangan', 'bg-slate-800/90 text-slate-200 border border-slate-700': activeConceptTab !== 'keuangan' }"
                        class="px-5 py-2.5 rounded-2xl font-black text-xs transition-all flex items-center gap-2">
                    <span>💳 Dashboard Keuangan</span>
                </button>
                <button @click="activeConceptTab = 'admin'" 
                        :class="{ 'bg-amber-400 text-slate-950 shadow-lg scale-105': activeConceptTab === 'admin', 'bg-slate-800/90 text-slate-200 border border-slate-700': activeConceptTab !== 'admin' }"
                        class="px-5 py-2.5 rounded-2xl font-black text-xs transition-all flex items-center gap-2">
                    <span>📊 Dashboard Admin & HR</span>
                </button>
            </div>

            <!-- Tab 1: App Siswa & Ortu -->
            <div x-show="activeConceptTab === 'siswa'" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <span class="px-3.5 py-1 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/40 text-xs font-bold uppercase">1. Mobile Banking Style App Ortu & Siswa</span>
                    <h3 class="text-2xl font-black text-white">Kemudahan Monitoring Pendidikan Anak dari Genggaman</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Orang tua dapat memantau status SPP, mendownload kwitansi PDF, mengontrol limit belanja kantin anak, serta memvalidasi laporan Mutaba'ah BPI harian anak dengan PIN digital.
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-xs font-bold pt-2">
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Saldo Tabungan & Kantin</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ E-Rapor Online PDF</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Multi-Anak Switcher</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Mutaba'ah PIN Approval</div>
                    </div>
                </div>
                <div class="lg:col-span-6 flex justify-center">
                    <img src="/images/mobile_app_mockup_3d_1786347823826.png" alt="Concept Mobile App Siswa" class="w-full max-w-sm rounded-3xl shadow-2xl border-4 border-teal-500">
                </div>
            </div>

            <!-- Tab 2: App Guru & Karyawan -->
            <div x-show="activeConceptTab === 'guru'" x-cloak class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <span class="px-3.5 py-1 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/40 text-xs font-bold uppercase">2. Portal Mobile Guru & Tenaga Pendidik</span>
                    <h3 class="text-2xl font-black text-white">Self-Service Presensi, Jurnal KBM & Slip Gaji PDF</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Guru & staf karyawan dapat membuka sesi presensi kelas via QR Code, mengunggah RPP/Jurnal KBM, mengunduh Slip Gaji digital PDF (/my-payroll), dan mengajukan cuti E-Leave.
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-xs font-bold pt-2">
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Buka Sesi QR Presensi</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Input Penilaian TP & P5</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Slip Gaji Self-Service</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Pengajuan E-Leave Cuti</div>
                    </div>
                </div>
                <div class="lg:col-span-6 flex justify-center">
                    <img src="/images/app_staff_3d_1786349857677.png" alt="Concept Staff Mobile App" class="w-full max-w-sm rounded-3xl shadow-2xl border-4 border-teal-500">
                </div>
            </div>

            <!-- Tab 3: Dashboard Keuangan -->
            <div x-show="activeConceptTab === 'keuangan'" x-cloak class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <span class="px-3.5 py-1 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/40 text-xs font-bold uppercase">3. Dashboard Bendahara & POS Kasir</span>
                    <h3 class="text-2xl font-black text-white">Otomatisasi Tagihan SPP, COA Akuntansi & Neraca</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Mendukung transaksi kasir pembayaran cepat, penagihan SPP massal otomatis, piutang tunggakan siswa, pencatatan Jurnal Otomatis, Buku Besar, Neraca, hingga Laporan Arus Kas resmi.
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-xs font-bold pt-2">
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Auto SPP Generator</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ COA & Sub-COA Chart</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Laporan Neraca & Cashflow</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Settlement POS Kantin</div>
                    </div>
                </div>
                <div class="lg:col-span-6 flex justify-center">
                    <img src="/images/dashboard_finance_3d_1786349818671.png" alt="Concept Finance Dashboard" class="w-full max-w-md rounded-2xl shadow-2xl border-4 border-teal-500">
                </div>
            </div>

            <!-- Tab 4: Dashboard Admin & HR -->
            <div x-show="activeConceptTab === 'admin'" x-cloak class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6 space-y-4">
                    <span class="px-3.5 py-1 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/40 text-xs font-bold uppercase">4. Executive Dashboard Yayasan & Admin</span>
                    <h3 class="text-2xl font-black text-white">Multi-School Context & Manajemen Hak Akses 12+ Role</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Yayasan dan Kepala Sekolah dapat mengontrol multi-unit sekolah (TK, SD, SMP, SMA), memantau rekap statistik presensi, penilaian KPI guru, rekrutmen pegawai baru, dan audit log keamanan.
                    </p>
                    <div class="grid grid-cols-2 gap-3 text-xs font-bold pt-2">
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ Multi-School Middleware</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ 12+ Role Permissions</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ KPI & Evaluasi Kinerja</div>
                        <div class="p-3 rounded-xl bg-slate-800/90 border border-slate-700">✓ System Audit Log</div>
                    </div>
                </div>
                <div class="lg:col-span-6 flex justify-center">
                    <img src="/images/dashboard_admin_3d_1786349842846.png" alt="Concept Admin Dashboard" class="w-full max-w-md rounded-2xl shadow-2xl border-4 border-teal-500">
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FAQ ACCORDION                              -->
    <!-- ========================================== -->
    <section id="faq" class="py-16 max-w-4xl mx-auto px-6">
        <div class="text-center space-y-3 mb-10">
            <span class="px-3.5 py-1.5 rounded-full bg-teal-100 dark:bg-teal-950 text-teal-900 dark:text-cyan-300 border border-teal-300 dark:border-teal-800 text-xs font-black uppercase tracking-wider">
                Tanya Jawab
            </span>
            <h2 class="text-3xl font-black text-teal-800 dark:text-white tracking-tight">FAQ Seputar SmartEdu</h2>
        </div>

        <div class="space-y-3">
            @foreach($faqs as $fIndex => $faq)
            <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-300 dark:border-slate-800 shadow-sm overflow-hidden">
                <button @click="faqOpen = (faqOpen === {{ $fIndex }} ? null : {{ $fIndex }})" class="w-full p-4 text-left font-black text-sm text-teal-800 dark:text-white flex items-center justify-between">
                    <span>{{ $faq->question }}</span>
                    <span x-text="faqOpen === {{ $fIndex }} ? '−' : '+'" class="text-teal-700 dark:text-cyan-400 font-black text-lg"></span>
                </button>
                <div x-show="faqOpen === {{ $fIndex }}" x-collapse class="px-4 pb-4 text-xs text-black dark:text-cyan-300 font-bold leading-relaxed border-t border-slate-200 dark:border-slate-800 pt-3">
                    <p>{{ $faq->answer }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FOOTER WITH OFFICIAL LOGO                  -->
    <!-- ========================================== -->
    <footer class="bg-slate-900 text-white py-10 border-t border-slate-800 text-xs font-bold">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="/images/smartedu_logo.png" alt="SmartEdu Logo" class="h-8 w-auto object-contain">
                <span class="font-extrabold text-sm text-white border-l border-slate-800 pl-3">{{ $settings['school_name'] }}</span>
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="text-cyan-400 hover:underline">CMS Admin Login</a>
                <span>•</span>
                <p>© 2026 SmartEdu Robbani (Laravel 13 & PHP 8.4)</p>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- MODAL POPUP SUB-MODUL                      -->
    <!-- ========================================== -->
    <div x-show="selectedModule !== null" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm" @keydown.escape.window="selectedModule = null">
        <div class="bg-white dark:bg-slate-900 w-full max-w-xl rounded-2xl p-6 border border-slate-300 dark:border-slate-800 shadow-2xl relative max-h-[85vh] overflow-y-auto" @click.away="selectedModule = null">
            <button @click="selectedModule = null" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-black dark:text-white font-bold flex items-center justify-center hover:bg-slate-200">✕</button>

            <template x-if="selectedModule">
                <div class="space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-slate-800 pb-3">
                        <div class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-slate-800 text-2xl flex items-center justify-center" x-text="selectedModule.icon"></div>
                        <div>
                            <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded bg-teal-100 text-teal-900 dark:bg-teal-950 dark:text-cyan-300" x-text="selectedModule.category_name"></span>
                            <h3 class="text-xl font-black text-teal-800 dark:text-white mt-1" x-text="selectedModule.title"></h3>
                        </div>
                    </div>

                    <p class="text-xs text-black dark:text-cyan-300 leading-relaxed font-bold" x-text="selectedModule.full_desc"></p>

                    <div>
                        <h4 class="font-black text-xs text-slate-900 dark:text-white mb-2">Sub-Modul & Fitur Detail:</h4>
                        <ul class="space-y-1.5 text-xs font-extrabold text-black dark:text-slate-200">
                            <template x-for="item in selectedModule.highlights" :key="item">
                                <li class="flex items-start gap-2 p-2 rounded-lg bg-slate-50 dark:bg-slate-800/60">
                                    <span class="text-teal-700 dark:text-cyan-400 font-black">✓</span>
                                    <span x-text="item"></span>
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="pt-3 border-t border-slate-200 dark:border-slate-800 flex justify-end">
                        <button @click="selectedModule = null" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-bold text-xs">Tutup</button>
                    </div>
                </div>
            </template>
        </div>
    </div>
</body>
</html>
