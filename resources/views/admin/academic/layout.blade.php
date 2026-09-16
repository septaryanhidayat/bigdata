<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi e-Rapor SIT Terpadu') - SmartEdu</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f1f5f9; color: #0f172a; }
        .table-input:focus {
            outline: 2px solid #059669 !important;
            border-color: #059669 !important;
            background-color: #ecfdf5 !important;
        }
        .sidebar-transition {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex antialiased">

    <!-- Dedicated E-Rapor Sidebar (Inspired by Kemdikbud e-Rapor, Prestigious SIT Emerald Theme) -->
    <aside id="eraporSidebar" class="w-64 bg-slate-900 text-white flex flex-col shrink-0 border-r border-slate-800 sidebar-transition z-40">
        <!-- Sidebar Brand Header -->
        <div class="h-16 px-4 flex items-center justify-between border-b border-slate-800 bg-slate-950/60">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-lg shadow-sm shrink-0">
                    🏫
                </div>
                <div class="truncate">
                    <h2 class="font-black text-sm text-white tracking-tight leading-none">e-Rapor SIT</h2>
                    <span class="text-[10px] font-extrabold text-emerald-400 uppercase tracking-wide">
                        {{ $activeSchool->code ?? 'ROBBANI' }}
                    </span>
                </div>
            </div>
            <button onclick="toggleSidebar()" title="Sembunyikan / Tampilkan Sidebar" class="w-8 h-8 rounded-lg hover:bg-slate-800 text-slate-400 hover:text-white flex items-center justify-center text-xs transition cursor-pointer">
                ⇤
            </button>
        </div>

        <!-- Sidebar Navigation Menu -->
        <div class="flex-1 overflow-y-auto px-3 py-4 space-y-5 scrollbar-none text-xs font-semibold">
            
            <!-- Group 1: UTAMA -->
            <div class="space-y-1">
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'dashboard']) }}" 
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-colors {{ ($activeMenu ?? 'dashboard') === 'dashboard' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🎛️</span>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Group 2: DATA MASTER & ROMBEL (Kepsek, Operator & Super Admin) -->
            <div class="space-y-1">
                <div class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Data Master Unit
                </div>

                <!-- 1. Data Siswa Unit -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'students']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'students' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">👥</span>
                    <span>Data Siswa Unit</span>
                </a>

                <!-- 2. Data Rombel & Wali Kelas -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'classrooms']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'classrooms' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🏫</span>
                    <span>Rombel & Wali Kelas</span>
                </a>

                <!-- 3. Data Mata Pelajaran -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'subjects']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'subjects' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">📚</span>
                    <span>Mata Pelajaran</span>
                </a>

                <!-- 4. Ekstrakurikuler -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'extracurriculars']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'extracurriculars' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🥋</span>
                    <span>Ekstrakurikuler</span>
                </a>

                <!-- 5. Ko-Kurikuler / P5 -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'p5']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'p5' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🌱</span>
                    <span>Ko-Kurikuler / P5</span>
                </a>

                <!-- 6. Pengguna & Guru Unit (Kepsek & Super Admin) -->
                @if(auth()->user()?->isSuperAdmin() || auth()->user()?->isHeadmaster() || auth()->user()?->role === 'HEADMASTER')
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'users']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'users' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">👤</span>
                    <span>Pengguna & Guru Unit</span>
                </a>
                @endif
            </div>

            <!-- Group 3: PENILAIAN E-RAPOR -->
            <div class="space-y-1">
                <div class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Penilaian Rapor
                </div>

                <!-- 1. Nilai Mapel (Guru Mapel) -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'academic']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'academic' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">📝</span>
                    <span>Nilai Mata Pelajaran</span>
                </a>

                <!-- 2. Al-Qur'an Wafa (Guru Qur'an) -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'quran']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'quran' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">📖</span>
                    <span>Al-Qur'an Metode Wafa</span>
                </a>

                <!-- 3. Karakter 7 SKL JSIT -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'character']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'character' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🌙</span>
                    <span>Karakter 7 SKL JSIT</span>
                </a>

                <!-- 4. Menu Wali Kelas -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'homeroom']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'homeroom' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">📋</span>
                    <span>Menu Wali Kelas</span>
                </a>
            </div>

            <!-- Group 4: CETAK & PENGATURAN -->
            <div class="space-y-1">
                <div class="px-3 text-[10px] font-extrabold text-slate-500 uppercase tracking-wider">
                    Laporan & Cetak
                </div>

                <!-- 1. Cetak Rapor & Leger -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'print']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'print' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">🖨️</span>
                    <span>Cetak Nilai & Leger</span>
                </a>

                <!-- 2. Pengaturan Kop & TTD -->
                <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'settings']) }}" 
                   class="flex items-center gap-3 px-3 py-2 rounded-xl transition-colors {{ ($activeMenu ?? '') === 'settings' ? 'bg-emerald-600 text-white font-black shadow-sm' : 'text-slate-300 hover:text-white hover:bg-slate-800/80' }}">
                    <span class="text-base">⚙️</span>
                    <span>Kop & Tanda Tangan</span>
                </a>
            </div>

        </div>

        <!-- Sidebar Footer Actions -->
        <div class="p-3 border-t border-slate-800 bg-slate-950/40 space-y-1.5">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-2.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs transition">
                <span>🏛️</span> <span>Menu Utama Yayasan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-rose-400 hover:bg-rose-500/10 font-bold text-xs transition cursor-pointer">
                    <span>🚪</span> <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top App Bar (Solid High-Contrast SIT Theme - Inspired by e-Rapor Kemendikdasmen) -->
        <header class="bg-[#064e3b] border-b border-[#047857] text-white h-16 shadow-sm shrink-0 flex items-center justify-between px-4 sm:px-6 z-30">
            
            <!-- Left: Toggle & Title Info -->
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" title="Toggle Sidebar" class="w-9 h-9 rounded-xl bg-[#047857] hover:bg-[#059669] text-white flex items-center justify-center text-sm font-bold transition cursor-pointer shadow-2xs">
                    ☰
                </button>
                <div>
                    <h1 class="font-black text-sm sm:text-base text-white tracking-tight leading-tight">
                        Aplikasi e-Rapor SIT Terpadu | {{ $activeAcademicYear->name ?? '2026/2027' }} ({{ $activeAcademicYear->semester ?? 'Ganjil' }})
                    </h1>
                    <p class="text-xs text-emerald-200 font-bold tracking-wide mt-0.5">
                        {{ $activeSchool->name ?? 'SIT Robbani' }} • Kurikulum Merdeka & Standar JSIT
                    </p>
                </div>
            </div>

            @if(Auth::user()->isSuperAdmin())
            <!-- Center: Multi-Unit Switcher Pills (Super Admin Yayasan Saja) -->
            <div class="hidden lg:flex items-center gap-1.5 bg-[#022c22] p-1 rounded-xl border border-emerald-700/60 shadow-inner">
                <span class="text-[10px] font-black text-emerald-300 px-2 uppercase tracking-wider">Unit:</span>
                @foreach($schools as $sc)
                    <a href="{{ route('admin.academic.grades', ['school_id' => $sc->id, 'menu' => $activeMenu ?? 'dashboard']) }}" 
                       class="px-3 py-1 rounded-lg text-xs font-black transition-all {{ ($schoolId ?? 1) == $sc->id ? 'bg-white text-emerald-950 shadow-xs' : 'text-emerald-200 hover:text-white hover:bg-emerald-800/60' }}">
                        {{ $sc->code }}
                    </a>
                @endforeach
            </div>
            @else
            <!-- Center: Locked School Unit Display for Unit Operator / Teacher / Principal -->
            <div class="hidden lg:flex items-center gap-2 bg-[#022c22] px-3.5 py-1.5 rounded-xl border border-emerald-700/60 shadow-inner text-xs font-black">
                <span class="text-emerald-400 font-extrabold uppercase tracking-wider text-[11px]">🏫 Unit Kerja:</span>
                <span class="bg-emerald-800/90 text-white px-2.5 py-0.5 rounded-md border border-emerald-600/50 font-black tracking-wide">{{ $activeSchool->name ?? 'Unit Sekolah' }}</span>
                <span class="text-[10px] text-emerald-300 font-bold bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-700/40">🔒 Terisolasi</span>
            </div>
            @endif

            <!-- Right: Guide Button & User Profile -->
            <div class="flex items-center gap-3">
                <!-- Button Panduan Penggunaan Modal -->
                <button onclick="openPanduanModal()" 
                        title="Buku Petunjuk Alur Penggunaan e-Rapor SIT" 
                        class="px-3 py-1.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-amber-950 font-black text-xs flex items-center gap-1.5 shadow-sm transition active:scale-95 cursor-pointer">
                    <span>💡</span> <span class="hidden md:inline">Petunjuk e-Rapor</span>
                </button>

                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black text-white leading-tight">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md bg-[#022c22] text-emerald-300 border border-emerald-700/50 text-[10px] font-black uppercase">
                        {{ Auth::user()?->isSuperAdmin() ? 'Super Admin Yayasan' : (Auth::user()?->isHeadmaster() ? 'Kepala Sekolah' : (Auth::user()?->isTeacher() ? 'Guru & Wali Kelas' : (Auth::user()?->isStaffTu() ? 'Operator TU' : 'Staf Akademik'))) }}
                    </span>
                </div>

                <div class="w-10 h-10 rounded-full bg-emerald-900 border-2 border-emerald-400 flex items-center justify-center text-white font-black text-sm shadow-xs overflow-hidden shrink-0">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 2)) }}
                </div>
            </div>

        </header>

        <!-- Main Body Content (Full Width) -->
        <main class="flex-1 overflow-y-auto w-full px-4 sm:px-6 lg:px-8 py-6">
            
            <!-- Flash Alert -->
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-950 font-bold text-xs flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-emerald-600 text-white flex items-center justify-center text-[10px] font-black">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-800 font-bold hover:text-emerald-950 text-sm">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-950 font-bold text-xs flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-rose-600 text-white flex items-center justify-center text-[10px] font-black">✕</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-800 font-bold hover:text-rose-950 text-sm">✕</button>
                </div>
            @endif

            @yield('content')

        </main>

        <!-- Clean Footer -->
        <footer class="bg-white border-t border-slate-200 py-3 text-center text-xs text-slate-500 font-medium shrink-0">
            <div class="w-full px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>Aplikasi e-Rapor SIT Terpadu • Standar Kurikulum Merdeka & JSIT Indonesia</span>
                <span class="font-bold text-slate-700">T.A. {{ $activeAcademicYear->name ?? '2026/2027' }} ({{ $activeAcademicYear->semester ?? 'Ganjil' }})</span>
            </div>
        </footer>

    </div>

    <!-- ========================================================================= -->
    <!-- MODAL POPUP PETUNJUK PENGGUNAAN LENGKAP E-RAPOR SIT TERPADU -->
    <!-- ========================================================================= -->
    <div id="modalPanduanErapor" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/70 backdrop-blur-xs p-4 sm:p-6 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-4xl w-full my-auto shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[90vh]">
            
            <!-- Modal Header -->
            <div class="bg-[#064e3b] p-6 text-white shrink-0 flex items-start justify-between border-b border-[#047857]">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-800/80 border border-emerald-400/40 flex items-center justify-center text-2xl shadow-inner shrink-0">
                        📖
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-amber-950 text-[10px] font-black uppercase tracking-wider">
                                Panduan Resmi
                            </span>
                            <span class="text-xs text-emerald-200 font-semibold">
                                Standar Kurikulum Merdeka, Wafa & 7 SKL JSIT
                            </span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-black text-white tracking-tight leading-snug">
                            Buku Petunjuk Pengoperasian e-Rapor SIT Terpadu
                        </h2>
                        <p class="text-xs text-emerald-100 font-medium mt-0.5">
                            Pelajari alur pengisian nilai, pengelolaan master data, hingga pencetakan rapor dan rekap leger kelas.
                        </p>
                    </div>
                </div>

                <button onclick="closePanduanModal()" class="w-8 h-8 rounded-full bg-emerald-900/60 hover:bg-emerald-900 text-emerald-200 hover:text-white flex items-center justify-center font-bold text-sm transition cursor-pointer shrink-0">
                    ✕
                </button>
            </div>

            <!-- Modal Content (Scrollable) -->
            <div class="p-6 overflow-y-auto space-y-6 text-slate-800 text-xs leading-relaxed divide-y divide-slate-100">
                
                <!-- Intro Card -->
                <div class="bg-emerald-50/80 border border-emerald-200 p-4 rounded-2xl flex items-start gap-3">
                    <span class="text-xl shrink-0">💡</span>
                    <div>
                        <h4 class="font-black text-emerald-950 text-xs mb-1">Alur Kerja Cepat & Aman</h4>
                        <p class="text-emerald-900 text-[11px]">
                            Aplikasi e-Rapor ini telah disesuaikan dengan pedoman e-Rapor Kemendikdasmen 2025.1 serta kekhasan Sekolah Islam Terpadu. Seluruh input data dilengkapi fitur <strong>Penyimpanan Draf Otomatis (Auto-Save)</strong>, sehingga ketikan Anda aman dan tidak akan hilang meskipun halaman ter-refresh secara tidak sengaja.
                        </p>
                    </div>
                </div>

                <!-- 6 Alur Langkah Pengoperasian -->
                <div class="pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Langkah 1 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">1</span>
                            <h4 class="font-black text-slate-900 text-xs">Setup Data Master (Kepsek & Operator)</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li><strong>Data Siswa:</strong> Tambah siswa baru, unduh Format Template CSV, atau lakukan bulk upload file CSV.</li>
                            <li><strong>Data Rombel:</strong> Tetapkan wali kelas dan <strong>Upload Tanda Tangan Digital</strong> wali kelas agar otomatis tercetak di rapor.</li>
                            <li><strong>Mata Pelajaran:</strong> Atur kurikulum (Umum, Muatan JSIT, Mulok) dan KKTP/KKM.</li>
                        </ul>
                    </div>

                    <!-- Langkah 2 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">2</span>
                            <h4 class="font-black text-slate-900 text-xs">Penilaian Capaian Akademik (Guru Mapel)</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li>Pilih rombel dan mata pelajaran yang diampu melalui filter atas.</li>
                            <li>Input Nilai Formatif / TP dan Nilai Sumatif Akhir (SAS).</li>
                            <li>Sistem secara otomatis menghitung Nilai Akhir, Predikat, dan Draft Narasi Capaian Pembelajaran secara realtime.</li>
                        </ul>
                    </div>

                    <!-- Langkah 3 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-teal-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">3</span>
                            <h4 class="font-black text-slate-900 text-xs">Nilai Al-Qur'an Metode Wafa (Pengampu Quran)</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li>Tentukan level/buku Wafa yang dipelajari siswa saat ini.</li>
                            <li>Beri penilaian pada 4 Aspek Tahsin: Makhraj, Tajwid, Lagu Hijaz Wafa, dan Adab.</li>
                            <li>Catat capaian target Ziyadah Tahfidz dan kelulusan Ujian Tasmi' sekali duduk.</li>
                        </ul>
                    </div>

                    <!-- Langkah 4 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-amber-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">4</span>
                            <h4 class="font-black text-slate-900 text-xs">Evaluasi Karakter 7 SKL JSIT & BPI (Wali Kelas)</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li>Isi skor capaian pada 7 Standar Kompetensi Lulusan (SKL) JSIT.</li>
                            <li>Tuliskan narasi pembinaan mutaba'ah ibadah harian dan Bina Pribadi Islami (BPI) pada kolom catatan luas yang tersedia.</li>
                        </ul>
                    </div>

                    <!-- Langkah 5 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-purple-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">5</span>
                            <h4 class="font-black text-slate-900 text-xs">Catatan Perkembangan & Presensi (Wali Kelas)</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li>Masukkan rekap jumlah hari ketidakhadiran (Sakit, Izin, Alpa).</li>
                            <li>Tuliskan deskripsi pesan dan motivasi perkembangan ananda untuk orang tua pada lembar rapor akhir semester.</li>
                        </ul>
                    </div>

                    <!-- Langkah 6 -->
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/60 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-rose-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">6</span>
                            <h4 class="font-black text-slate-900 text-xs">Cetak Dokumen Rapor & Download Leger</h4>
                        </div>
                        <ul class="text-[11px] text-slate-600 space-y-1 list-disc list-inside">
                            <li>Pilih cetak dokumen: <strong>Rapor Gabungan (All-in-One)</strong>, Rapor Akademik, Rapor Wafa, atau Rapor Karakter.</li>
                            <li>Cetak Rekap Leger Nilai dalam format <strong>Landscape A4</strong> otomatis atau unduh file <strong>Excel / CSV</strong>.</li>
                        </ul>
                    </div>

                    <!-- Langkah 7: Asisten Cerdas Google Gemini AI -->
                    <div class="p-4 rounded-2xl border border-emerald-300 bg-emerald-50/50 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">✨</span>
                            <h4 class="font-black text-emerald-900 text-xs">Asisten Cerdas Google Gemini AI Terintegrasi</h4>
                        </div>
                        <ul class="text-[11px] text-emerald-800 space-y-1 list-disc list-inside">
                            <li><strong>AI Narasi Capaian Pembelajaran:</strong> Klik tombol ✨ di samping form nilai mapel untuk membuat deskripsi CP Kurikulum Merdeka otomatis.</li>
                            <li><strong>AI Catatan Motivasi Wali Kelas:</strong> Menuliskan catatan motivasi hangat, Islami, dan bernada positif secara instan berdasarkan nilai & karakter.</li>
                            <li><strong>AI Evaluasi Wafa & Tahfidz:</strong> Evaluasi perkembangan makhraj, tajwid lagu Hijaz, dan target hafalan otomatis.</li>
                            <li><strong>AI Analisis Rapor Kelas:</strong> Membantu Kepala Sekolah & Wali Kelas meninjau tren nilai dan rekomendasi taktis rombel.</li>
                        </ul>
                    </div>

                    <!-- Langkah 8: Hak Akses Kepala Sekolah & Pengguna Unit -->
                    <div class="p-4 rounded-2xl border border-blue-200 bg-blue-50/50 space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-blue-700 text-white font-black text-[11px] flex items-center justify-center shrink-0">👥</span>
                            <h4 class="font-black text-blue-900 text-xs">Manajemen Akun Pengguna oleh Kepala Sekolah</h4>
                        </div>
                        <ul class="text-[11px] text-blue-800 space-y-1 list-disc list-inside">
                            <li>Kepala Sekolah dapat menambah, mengedit profil, dan mengatur ulang kata sandi (reset password) akun Guru Mapel, Wali Kelas, dan Staf TU di unitnya.</li>
                            <li>Terisolasi aman: Kepala Sekolah tidak dapat mengubah akun Super Admin atau mengakses data akun di unit sekolah lain.</li>
                        </ul>
                    </div>

                </div>

                <!-- Hak Akses & Isolasi Unit -->
                <div class="pt-4">
                    <h4 class="font-black text-slate-900 text-xs mb-2 flex items-center gap-1.5">
                        <span>🔒</span> <span>Keamanan & Isolasi Data Antar Unit</span>
                    </h4>
                    <p class="text-[11px] text-slate-600">
                        Setiap akun Guru, Wali Kelas, Operator TU, dan Kepala Sekolah terkunci secara otomatis pada unit kerjanya masing-masing (TKIT, SDIT, SMPIT, atau SMAIT). Data siswa, nilai, dan rapor terisolasi penuh sehingga setiap unit hanya dapat mengelola data sekolahnya sendiri. Hanya akun Super Admin Yayasan yang memiliki hak lintas unit.
                    </p>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="p-5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 shrink-0">
                <label class="flex items-center gap-2 cursor-pointer text-[11px] font-bold text-slate-700 select-none">
                    <input type="checkbox" id="chkDismissGuide" class="rounded text-emerald-700 focus:ring-emerald-600 cursor-pointer">
                    <span>Jangan tampilkan panduan ini secara otomatis lagi saat masuk e-Rapor</span>
                </label>

                <button onclick="closePanduanModal()" 
                        class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs transition cursor-pointer shadow-sm active:scale-95">
                    Saya Mengerti & Mulai Gunakan e-Rapor →
                </button>
            </div>

        </div>
    </div>

    <!-- Toggle Sidebar & Guide Modal Script -->
    <script>
        function toggleSidebar() {
            const sb = document.getElementById('eraporSidebar');
            if (sb) {
                sb.classList.toggle('-ml-64');
            }
        }

        function openPanduanModal() {
            const m = document.getElementById('modalPanduanErapor');
            if (m) m.classList.remove('hidden');
        }

        function closePanduanModal() {
            const m = document.getElementById('modalPanduanErapor');
            if (m) m.classList.add('hidden');
            
            const chk = document.getElementById('chkDismissGuide');
            if (chk && chk.checked) {
                localStorage.setItem('smartedu_erapor_guide_dismissed', 'true');
            }
        }

        // Auto open on first visit ONLY when on dashboard page!
        document.addEventListener('DOMContentLoaded', function() {
            @if(($activeMenu ?? 'dashboard') === 'dashboard')
            const dismissed = localStorage.getItem('smartedu_erapor_guide_dismissed');
            if (dismissed !== 'true') {
                openPanduanModal();
            }
            @endif
        });
    </script>
</body>
</html>
