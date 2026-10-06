@extends('admin.academic.layout')

@section('title', 'E-Rapor Terpadu SIT - ' . ($activeSchool->name ?? 'SmartEdu'))

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6 pb-12">

    <!-- ========================================================================= -->
    <!-- MENU 1: DASHBOARD PROGRES E-RAPOR -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? 'dashboard') === 'dashboard')
    <div class="space-y-6">
        
        <!-- Top Row: Welcome Banner & Status Input Nilai -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Left Banner: Selamat Datang (8 Cols) -->
            <div class="lg:col-span-8 bg-[#064e3b] text-white p-6 rounded-2xl border border-emerald-800 shadow-sm flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-800/80 border border-emerald-700 flex items-center justify-center text-3xl shadow-inner shrink-0">
                    🛡️
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap mb-1">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-950 text-emerald-200 text-[10px] font-black uppercase tracking-wider border border-emerald-700">
                            Aplikasi e-Rapor SIT Terpadu
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black uppercase tracking-wider">
                            {{ $activeAcademicYear->name ?? '2026/2027' }} - {{ $activeAcademicYear->semester ?? 'Ganjil' }}
                        </span>
                    </div>
                    <h2 class="text-lg sm:text-xl font-black tracking-tight text-white leading-snug">
                        Selamat Datang di Halaman Admin e-Rapor {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </h2>
                    <p class="text-xs text-emerald-100 font-medium mt-1">
                        Anda sedang login sebagai <strong class="text-amber-300 font-black">{{ $userRoleLabel }}</strong> • Kurikulum Merdeka & Standar Mutu JSIT Indonesia
                    </p>
                </div>
            </div>

            <!-- Right Banner: Status Input Nilai (4 Cols) -->
            <div class="lg:col-span-4 bg-[#0f172a] text-white p-6 rounded-2xl border border-slate-800 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-black uppercase tracking-wider text-slate-400">Status Sistem Rapor</span>
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                        </span>
                    </div>
                    <h3 class="text-sm font-black text-white leading-snug">
                        Input Nilai Guru & Wali: <span class="text-emerald-400 font-black">DIBUKA</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">
                        Pendidik dan wali kelas dapat menginput capaian akademik, Wafa, dan karakter.
                    </p>
                </div>
                
                <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-medium">Batas Pengisian:</span>
                    <span class="font-bold text-amber-300">20 Desember 2026</span>
                </div>
            </div>

        </div>

        <!-- 5 Executive KPI Cards (High Impact Summary) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
            <!-- KPI 1: Rata-Rata Nilai Unit -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 hover:border-emerald-500 transition">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-black">
                    📈
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider truncate">Rata-Rata Unit</p>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $averageUnitScore > 0 ? $averageUnitScore : '-' }}</div>
                    <p class="text-[10px] {{ $averageUnitScore >= 85 ? 'text-emerald-700' : ($averageUnitScore >= 75 ? 'text-blue-700' : ($averageUnitScore > 0 ? 'text-amber-700' : 'text-slate-400')) }} font-extrabold mt-0.5 truncate">
                        @if($averageUnitScore >= 85) Predikat Sangat Baik (A)
                        @elseif($averageUnitScore >= 75) Predikat Baik (B)
                        @elseif($averageUnitScore >= 65) Predikat Cukup (C)
                        @elseif($averageUnitScore > 0) Predikat Perlu Bimbingan (D)
                        @else Belum Ada Nilai
                        @endif
                    </p>
                </div>
            </div>

            <!-- KPI 2: Kinerja Wali Kelas Unit -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 hover:border-purple-500 transition">
                <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl shrink-0 font-black">
                    🧑‍🏫
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider truncate">Kinerja Wali Kelas</p>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $completedWaliCount ?? 0 }} / {{ $totalClassrooms }}</div>
                    <p class="text-[10px] text-purple-700 font-extrabold mt-0.5 truncate">{{ $totalClassrooms > 0 ? round((($completedWaliCount ?? 0) / $totalClassrooms) * 100) : 0 }}% Rombel Tuntas</p>
                </div>
            </div>

            <!-- KPI 3: Capaian Tahfidz Target -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 hover:border-teal-500 transition">
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl shrink-0 font-black">
                    📖
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider truncate">Tuntas Tahfidz</p>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $tahfidzCompletionPct ?? '0%' }}</div>
                    <p class="text-[10px] text-teal-700 font-extrabold mt-0.5 truncate">{{ $rekapWafa }} dari {{ $totalSchoolStudents }} teruji</p>
                </div>
            </div>

            <!-- KPI 4: Tujuan Pembelajaran (TP) -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 hover:border-blue-500 transition">
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0 font-black">
                    🎯
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider truncate">Tujuan Belajar (TP)</p>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $totalTpCount ?? 0 }} TP</div>
                    <p class="text-[10px] text-blue-700 font-extrabold mt-0.5 truncate">Kurikulum Merdeka</p>
                </div>
            </div>

            <!-- KPI 5: Kesiapan Dokumen Cetak -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-3.5 hover:border-amber-500 transition">
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0 font-black">
                    🖨️
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider truncate">Rapor Siap Cetak</p>
                    <div class="text-xl sm:text-2xl font-black text-slate-900 leading-tight">{{ $readyToPrintCount ?? 0 }} / {{ $totalSchoolStudents }}</div>
                    <p class="text-[10px] text-amber-700 font-extrabold mt-0.5 truncate">Komponen lengkap</p>
                </div>
            </div>
        </div>

        <!-- AI Assistant Banner (High-Contrast Rich Emerald-Navy Gradient) -->
        <div class="p-5 rounded-2xl shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border border-emerald-600/40"
             style="background: linear-gradient(135deg, #022c22 0%, #0f172a 50%, #042f2e 100%) !important; color: #ffffff !important;">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shrink-0 shadow-inner"
                     style="background: rgba(16, 185, 129, 0.25); border: 1px solid rgba(52, 211, 153, 0.5);">
                    ✨
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded text-[10px] font-black uppercase tracking-wider"
                              style="background: rgba(16, 185, 129, 0.3); border: 1px solid rgba(52, 211, 153, 0.6); color: #6ee7b7;">
                            Robbani AI Assistant (Smart Engine)
                        </span>
                        <span class="text-[10px] font-bold" style="color: #34d399;">● Terhubung Aktif</span>
                    </div>
                    <h3 class="text-sm font-black mt-1" style="color: #ffffff !important;">Robbani AI Evaluasi & Penulisan Rapor SIT Otomatis</h3>
                    <p class="text-xs font-medium mt-0.5" style="color: #e2e8f0 !important;">
                        Membuat narasi capaian pembelajaran, evaluasi tilawah Wafa, catatan motivasi wali kelas Islami, dan analisis kesiapan kelas secara otomatis.
                    </p>
                </div>
            </div>
                <button type="button" onclick="openAiClassAnalysisModal('all', 'Seluruh Rombel Unit {{ addslashes($activeSchool->name ?? 'SIT Robbani') }}')" 
                        class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-black text-xs transition cursor-pointer shadow-md active:scale-95 hover:opacity-90"
                        style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%) !important; color: #022c22 !important; border: 1px solid #34d399;">
                    <span>✨</span>
                    <span>Analisis AI Kesiapan Rapor (Semua Kelas)</span>
                </button>
        </div>

        <!-- Section: REKAP DATA (High-Contrast Clean Cards & Action Links) -->
        <div class="space-y-0">
            <!-- Header Bar -->
            <div class="bg-[#0f172a] text-white px-6 py-3.5 rounded-t-2xl text-xs font-black tracking-wider uppercase flex items-center justify-between border-b border-slate-800">
                <span class="flex items-center gap-2">
                    <span>📊</span> <span>REKAPITULASI DATA e-RAPOR (UNIT {{ strtoupper($activeSchool->code ?? 'UNIT') }})</span>
                </span>
                <span class="text-[11px] text-emerald-300 font-bold bg-emerald-950 px-3 py-1 rounded-lg border border-emerald-700">
                    Total: {{ $totalSchoolStudents }} Siswa Aktif
                </span>
            </div>

            <!-- Content Grid (8 Cols Metrics + 4 Cols Actions) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 bg-white p-6 rounded-b-2xl border border-t-0 border-slate-200 shadow-sm">
                
                <!-- Left 8 Clean Solid Cards (8 Cols) -->
                <div class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-3.5">
                    
                    <!-- 1. Siswa -->
                    <div class="bg-white border border-slate-200 hover:border-blue-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                            <span class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-sm font-bold">🎓</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-slate-900">{{ $totalSchoolStudents }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Terdaftar di unit</p>
                        </div>
                    </div>

                    <!-- 2. Rombel -->
                    <div class="bg-white border border-slate-200 hover:border-emerald-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Rombel Kelas</span>
                            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm font-bold">🏫</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-slate-900">{{ $totalClassrooms }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Rombel aktif</p>
                        </div>
                    </div>

                    <!-- 3. Guru & KS -->
                    <div class="bg-white border border-slate-200 hover:border-purple-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Guru & KS</span>
                            <span class="w-7 h-7 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center text-sm font-bold">🧑‍🏫</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-slate-900">{{ $rekapGuru }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Pendidik unit</p>
                        </div>
                    </div>

                    <!-- 4. Mata Pelajaran -->
                    <div class="bg-white border border-slate-200 hover:border-amber-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Mata Pelajaran</span>
                            <span class="w-7 h-7 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-sm font-bold">📖</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-slate-900">{{ $totalSubjects }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Merdeka & JSIT</p>
                        </div>
                    </div>

                    <!-- 5. Tujuan Pembelajaran (TP) -->
                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp']) }}" 
                       class="bg-white border border-slate-200 hover:border-emerald-500 p-3.5 rounded-xl shadow-xs transition space-y-1.5 group block">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider group-hover:text-emerald-700 transition">Tujuan Belajar (TP)</span>
                            <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition-transform">🎯</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-emerald-800">{{ $totalTpCount ?? 0 }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">TP aktif semester ini</p>
                        </div>
                    </a>

                    <!-- 6. Wafa -->
                    <div class="bg-white border border-slate-200 hover:border-teal-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Al-Qur'an Wafa</span>
                            <span class="w-7 h-7 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-sm font-bold">✨</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-teal-800">{{ $rekapWafa }} / {{ $totalSchoolStudents }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Siswa terinput Wafa</p>
                        </div>
                    </div>

                    <!-- 7. Karakter -->
                    <div class="bg-white border border-slate-200 hover:border-indigo-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Karakter 7 SKL</span>
                            <span class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-sm font-bold">🌙</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-indigo-800">{{ $rekapKarakter }} / {{ $totalSchoolStudents }}</div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Standar mutu JSIT</p>
                        </div>
                    </div>

                    <!-- 8. Projek P5 & Ekstrakurikuler -->
                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'p5']) }}" 
                       class="bg-white border border-slate-200 hover:border-violet-400 p-3.5 rounded-xl shadow-xs transition space-y-1.5 group block">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider group-hover:text-violet-700 transition">P5 & Ekskul</span>
                            <span class="w-7 h-7 rounded-lg bg-violet-50 text-violet-700 flex items-center justify-center text-sm font-bold group-hover:scale-110 transition-transform">🌟</span>
                        </div>
                        <div>
                            <div class="text-xl font-black text-violet-900">{{ $totalP5Count ?? 0 }} <span class="text-xs text-slate-500 font-bold">P5</span> • {{ $totalEkskulCount ?? 0 }} <span class="text-xs text-slate-500 font-bold">Ekskul</span></div>
                            <p class="text-[10px] text-slate-500 font-medium truncate">Ko-kurikuler & bakat</p>
                        </div>
                    </a>

                </div>

                <!-- Right 4 High-Contrast Action Cards (4 Cols) -->
                <div class="lg:col-span-4 grid grid-cols-1 gap-2.5">
                    
                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'classrooms']) }}" 
                       class="bg-[#064e3b] hover:bg-[#047857] text-white p-3 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div class="min-w-0">
                            <p class="text-xs font-black uppercase tracking-tight text-white truncate">Atur Rombel & Wali Kelas</p>
                            <p class="text-[10px] text-emerald-200 mt-0.5 truncate">Penetapan rombongan belajar & guru wali</p>
                        </div>
                        <span class="w-7 h-7 rounded-lg bg-emerald-800 flex items-center justify-center text-xs font-black group-hover:scale-110 transition-transform text-white shrink-0 ml-2">🏫</span>
                    </a>

                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'students']) }}" 
                       class="bg-[#0f172a] hover:bg-slate-800 text-white p-3 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div class="min-w-0">
                            <p class="text-xs font-black uppercase tracking-tight text-white truncate">Kelola Master Data Siswa</p>
                            <p class="text-[10px] text-slate-300 mt-0.5 truncate">Tambah & perbarui data siswa unit ini</p>
                        </div>
                        <span class="w-7 h-7 rounded-lg bg-slate-800 flex items-center justify-center text-xs font-black group-hover:scale-110 transition-transform text-white shrink-0 ml-2">👥</span>
                    </a>

                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp']) }}" 
                       class="bg-emerald-800 hover:bg-emerald-900 text-white p-3 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div class="min-w-0">
                            <p class="text-xs font-black uppercase tracking-tight text-white truncate">Tujuan Pembelajaran (TP)</p>
                            <p class="text-[10px] text-emerald-200 mt-0.5 truncate">Kelola rumusan capaian rapor kurikulum</p>
                        </div>
                        <span class="w-7 h-7 rounded-lg bg-emerald-950 flex items-center justify-center text-xs font-black group-hover:scale-110 transition-transform text-white shrink-0 ml-2">🎯</span>
                    </a>

                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'settings']) }}" 
                       class="bg-amber-600 hover:bg-amber-700 text-white p-3 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div class="min-w-0">
                            <p class="text-xs font-black uppercase tracking-tight text-white truncate">Upload Kop Surat & TTD</p>
                            <p class="text-[10px] text-amber-100 mt-0.5 truncate">Upload gambar kop cetak resmi rapor</p>
                        </div>
                        <span class="w-7 h-7 rounded-lg bg-amber-700 flex items-center justify-center text-xs font-black group-hover:scale-110 transition-transform text-white shrink-0 ml-2">🖼️</span>
                    </a>

                </div>

            </div>
        </div>

        <!-- ============================================================= -->
        <!-- INTERACTIVE CHARTS (CHART.JS - PROGRES, RADAR 7 SKL, PREDIKAT) -->
        <!-- ============================================================= -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Chart 1: Progres Rombel (7 Cols) -->
            <div class="lg:col-span-7 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span>📊</span> <span>Progres Kelengkapan Nilai per Rombel Kelas</span>
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium">Persentase capaian pengisian rapor terpadu (Mapel, Wafa, Karakter & Walas)</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 text-[10px] font-black border border-emerald-200">
                        Realtime Data
                    </span>
                </div>
                <div class="h-72 w-full relative">
                    <canvas id="chartRombelProgress"></canvas>
                </div>
            </div>

            <!-- Chart 2: Radar 7 SKL JSIT (5 Cols) -->
            <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-3 gap-2">
                    <div>
                        <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span>🎯</span> <span>Radar Capaian 7 SKL JSIT</span>
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium">Distribusi standar mutu kepribadian Islam terpadu</p>
                    </div>
                    <div class="flex items-center gap-1.5 shrink-0">
                        <select id="filterSklRadarClass" onchange="updateSklRadar(this.value)" 
                                class="text-xs font-bold rounded-lg border border-indigo-200 bg-indigo-50/90 text-indigo-900 py-1 px-2.5 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 cursor-pointer shadow-2xs">
                            <option value="all">Semua Kelas (Unit)</option>
                            @foreach($classrooms as $cls)
                                <option value="{{ $cls->id }}" {{ ($selectedClassroomId ?? null) == $cls->id ? 'selected' : '' }}>{{ $cls->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="h-64 w-full relative flex items-center justify-center">
                    <canvas id="chartSklRadar"></canvas>
                </div>
            </div>

            <!-- Chart 3: Donut Predikat (12 Cols) -->
            <div class="lg:col-span-12 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-100 pb-3 gap-2">
                    <div>
                        <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span>🍩</span> <span>Sebaran Predikat Capaian Akademik & Tilawah Al-Qur'an</span>
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium">Proporsi predikat Mumtaz (A), Jayyid Jiddan (B), Jayyid (C), dan Maqbul (D) di unit {{ $activeSchool->name ?? 'SIT Robbani' }}</p>
                    </div>
                    <div class="flex items-center gap-3 text-[11px] font-bold">
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> Mumtaz (A)</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Jayyid Jiddan (B)</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Jayyid (C)</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-rose-500"></span> Maqbul (D)</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-center mt-3">
                    <div class="md:col-span-4 h-56 relative flex items-center justify-center">
                        <canvas id="chartPredikatDonut"></canvas>
                    </div>
                    <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-center">
                            <div class="text-xs font-bold text-emerald-800 uppercase">Mumtaz (A)</div>
                            <div class="text-2xl font-black text-emerald-950 mt-1">{{ $chartPredicates['A'] ?? $chartPredicates[0] ?? 0 }}</div>
                            <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">Nilai &ge; 85</div>
                        </div>
                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-center">
                            <div class="text-xs font-bold text-blue-800 uppercase">Jayyid Jiddan (B)</div>
                            <div class="text-2xl font-black text-blue-950 mt-1">{{ $chartPredicates['B'] ?? $chartPredicates[1] ?? 0 }}</div>
                            <div class="text-[10px] text-blue-700 font-semibold mt-0.5">Nilai 75 - 84</div>
                        </div>
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-center">
                            <div class="text-xs font-bold text-amber-800 uppercase">Jayyid (C)</div>
                            <div class="text-2xl font-black text-amber-950 mt-1">{{ $chartPredicates['C'] ?? $chartPredicates[2] ?? 0 }}</div>
                            <div class="text-[10px] text-amber-700 font-semibold mt-0.5">Nilai 65 - 74</div>
                        </div>
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-center">
                            <div class="text-xs font-bold text-rose-800 uppercase">Maqbul (D)</div>
                            <div class="text-2xl font-black text-rose-950 mt-1">{{ $chartPredicates['D'] ?? $chartPredicates[3] ?? 0 }}</div>
                            <div class="text-[10px] text-rose-700 font-semibold mt-0.5">Perlu Remedial</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Section: STATUS KERJA ADMINISTRATOR & KEPALA UNIT (100% REAL DATA AUDIT) -->
        <div class="space-y-0">
            <!-- Header Bar -->
            <div class="bg-[#0f172a] text-white px-6 py-3.5 rounded-t-2xl text-xs font-black tracking-wider uppercase flex items-center justify-between">
                <span>STATUS KERJA ADMINISTRATOR & KEPALA UNIT (AUDIT DATA REAL)</span>
                <span class="text-[10px] text-slate-400 font-medium">Berdasarkan data tersimpan di database</span>
            </div>

            <!-- Subtitle Bar -->
            <div class="px-6 py-2.5 bg-slate-100 border-x border-slate-200 text-slate-700 text-xs font-bold">
                Rincian Kesiapan & Alur Kerja Utama Unit {{ $activeSchool->name ?? 'SIT Robbani' }} :
            </div>

            <!-- Checklist Table with 100% Real Calculations -->
            <div class="overflow-x-auto bg-white border border-slate-200 rounded-b-2xl shadow-sm">
                <table class="w-full text-left text-xs min-w-[720px]">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3">Jenis Kegiatan Administrator & Kepala Unit</th>
                            <th class="px-5 py-3 text-center w-52">Status Pekerjaan</th>
                            <th class="px-5 py-3 text-center w-48">Progress Real</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        
                        <!-- Row 1: Upload Gambar Kop Surat -->
                        @php
                            $hasKopImage = !empty($reportSetting?->kop_image_url);
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">1</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Upload Kop Surat Resmi, Stempel & TTD Digital
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hasKopImage)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>Kop Terpasang</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✕</span> <span>Belum Upload</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="{{ $hasKopImage ? 'bg-emerald-600' : 'bg-slate-400' }} h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasKopImage ? 100 : 0 }}%">
                                        {{ $hasKopImage ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2: Rombel -->
                        @php
                            $hasClasses = $totalClassrooms > 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">2</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Penetapan Rombongan Belajar (Rombel) Unit
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hasClasses)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>{{ $totalClassrooms }} Rombel Terbentuk</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✕</span> <span>Belum Ada Rombel</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasClasses ? 100 : 0 }}%">
                                        {{ $hasClasses ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3: Wali Kelas -->
                        @php
                            $waliPct = $totalClassrooms > 0 ? round(($assignedWaliCount / $totalClassrooms) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">3</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Penetapan Guru Wali Kelas Setiap Rombel
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($waliPct >= 100)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>Lengkap ({{ $assignedWaliCount }}/{{ $totalClassrooms }})</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>⏳</span> <span>{{ $assignedWaliCount }}/{{ $totalClassrooms }} Ditetapkan</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $waliPct }}%">
                                        {{ $waliPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4: Siswa -->
                        @php
                            $hasStudents = $totalSchoolStudents > 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">4</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Verifikasi Master Data Siswa Unit
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hasStudents)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>{{ $totalSchoolStudents }} Siswa Terdaftar</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✕</span> <span>Belum Ada Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasStudents ? 100 : 0 }}%">
                                        {{ $hasStudents ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5: Tujuan Pembelajaran (TP) -->
                        @php
                            $hasTp = ($totalTpCount ?? 0) > 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">5</td>
                            <td class="px-5 py-3 font-semibold text-slate-900 flex items-center gap-2">
                                <span>Penyusunan Tujuan Pembelajaran (TP Kurikulum Merdeka)</span>
                                <span class="px-2 py-0.5 rounded text-[9px] font-extrabold bg-emerald-100 text-emerald-800">BARU</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hasTp)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>{{ $totalTpCount }} TP Terstandar</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>⏳</span> <span>Belum Ada TP</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasTp ? 100 : 0 }}%">
                                        {{ $hasTp ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 6: Mapel -->
                        @php
                            $mapelPct = $totalSchoolStudents > 0 ? round(($rekapMapel / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">6</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Input Nilai Mapel & Ketercapaian TP
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($mapelPct >= 100)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Tuntas 100%</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>⏳</span> <span>{{ $rekapMapel }}/{{ $totalSchoolStudents }} Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $mapelPct }}%">
                                        {{ $mapelPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 7: Wafa -->
                        @php
                            $wafaPct = $totalSchoolStudents > 0 ? round(($rekapWafa / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">7</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Penilaian Tilawah Al-Qur'an (Metode Wafa)
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($wafaPct >= 100)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Tuntas 100%</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>⏳</span> <span>{{ $rekapWafa }}/{{ $totalSchoolStudents }} Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $wafaPct }}%">
                                        {{ $wafaPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 8: Karakter -->
                        @php
                            $charPct = $totalSchoolStudents > 0 ? round(($rekapKarakter / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">8</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Penilaian Karakter (7 SKL Standar JSIT)
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($charPct >= 100)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Tuntas 100%</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>⏳</span> <span>{{ $rekapKarakter }}/{{ $totalSchoolStudents }} Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $charPct }}%">
                                        {{ $charPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 9: Ko-Kurikuler & Projek P5 -->
                        @php
                            $hasP5 = ($totalP5Count ?? 0) > 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">9</td>
                            <td class="px-5 py-3 font-semibold text-slate-900 flex items-center gap-2">
                                <span>Asesmen Projek P5 & Ekstrakurikuler</span>
                                <span class="px-2 py-0.5 rounded text-[9px] font-extrabold bg-violet-100 text-violet-800">BARU</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hasP5)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>{{ $totalP5Count }} Projek P5 Aktif</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>⏳</span> <span>Projek Disiapkan</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasP5 ? 100 : 0 }}%">
                                        {{ $hasP5 ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 10: Wali Kelas -->
                        @php
                            $hrPct = $totalSchoolStudents > 0 ? round(($rekapHomeroom / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3 text-center text-slate-400 font-bold">10</td>
                            <td class="px-5 py-3 font-semibold text-slate-900">
                                Catatan Wali Kelas & Rekap Presensi
                            </td>
                            <td class="px-5 py-3 text-center">
                                @if($hrPct >= 100)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Tuntas 100%</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-amber-100 text-amber-900 border border-amber-300 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>⏳</span> <span>{{ $rekapHomeroom }}/{{ $totalSchoolStudents }} Siswa</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-3.5 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-3.5 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hrPct }}%">
                                        {{ $hrPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section: MATRIKS KINERJA WALI KELAS & AUDIT KELENGKAPAN RAPOR -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Header Bar -->
            <div class="px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-3 bg-gradient-to-r from-slate-50 to-white">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-800 text-xs">📊</span>
                        <h3 class="font-black text-sm text-slate-900">Matriks Kinerja Wali Kelas & Audit Kelengkapan Rapor</h3>
                        <span class="px-2 py-0.5 rounded text-[9px] font-black bg-blue-100 text-blue-800 uppercase tracking-wide">Unit {{ $activeSchool->code ?? 'SDIT' }}</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Monitoring komprehensif pengisian nilai Mapel & TP, Wafa, Karakter JSIT, P5, Catatan Walas, dan Kesiapan Cetak</p>
                </div>
                <!-- Mini KPI Badges di Header -->
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="px-3 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 text-[11px] font-black inline-flex items-center gap-1.5 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>{{ $completedWaliCount }} Rombel Tuntas (100%)</span>
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-sky-50 border border-sky-200 text-sky-800 text-[11px] font-black inline-flex items-center gap-1.5 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                        <span>{{ $inProgressWaliCount }} Dalam Proses</span>
                    </span>
                    <span class="px-3 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-black inline-flex items-center gap-1.5 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>{{ $notStartedWaliCount }} Belum Mengisi</span>
                    </span>
                </div>
            </div>

            <!-- Tabel Matriks Lebar Anti-Truncate -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs min-w-[1240px]">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3.5 text-center w-12">No</th>
                            <th class="px-4 py-3.5 min-w-[170px]">Rombel Kelas</th>
                            <th class="px-4 py-3.5 min-w-[200px]">Wali Kelas & Kontak</th>
                            <th class="px-3 py-3.5 text-center w-28">Mapel & TP</th>
                            <th class="px-3 py-3.5 text-center w-28">Wafa & Tahfidz</th>
                            <th class="px-3 py-3.5 text-center w-28">Karakter 7 SKL</th>
                            <th class="px-3 py-3.5 text-center w-28">P5 & Ekskul</th>
                            <th class="px-3 py-3.5 text-center w-28">Catatan Walas</th>
                            <th class="px-3 py-3.5 text-center w-24">Rata Nilai</th>
                            <th class="px-3 py-3.5 text-center w-28">Siap Cetak</th>
                            <th class="px-4 py-3.5 text-center w-36">Progres Kinerja</th>
                            <th class="px-4 py-3.5 text-center min-w-[220px] whitespace-nowrap">Aksi Kepala Sekolah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($classroomProgress as $clsId => $data)
                        @php
                            $walasName = $data['classroom']->homeroomTeacher->name ?? 'Belum Ditugaskan';
                            $walasPhone = $data['wali_phone'] ?? '';
                            $walasNip = $data['wali_nip'] ?? '';
                            $pct = (int) $data['percentage'];
                            $stCount = (int) $data['student_count'];
                            $readyCount = (int) ($data['ready_count'] ?? 0);
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <!-- 1. No -->
                            <td class="px-4 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>

                            <!-- 2. Rombel Kelas -->
                            <td class="px-4 py-3.5">
                                <div class="font-black text-slate-900 text-xs flex items-center gap-1.5">
                                    <span>🏫</span>
                                    <span>{{ $data['classroom']->name }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-bold">
                                        {{ $stCount }} Siswa
                                    </span>
                                    @if($stCount == 0)
                                        <span class="px-1.5 py-0.5 rounded bg-rose-50 text-rose-700 text-[9px] font-black border border-rose-200">Kosong</span>
                                    @endif
                                </div>
                            </td>

                            <!-- 3. Wali Kelas & Kontak -->
                            <td class="px-4 py-3.5">
                                <div class="font-bold text-slate-900 text-xs">
                                    {{ $walasName }}
                                </div>
                                <div class="flex items-center gap-2 mt-1 flex-wrap">
                                    @if(!empty($walasNip))
                                        <span class="text-[10px] text-slate-500 font-semibold">NIP. {{ $walasNip }}</span>
                                    @endif
                                    @if(!empty($walasPhone))
                                        <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[9px] font-black inline-flex items-center gap-0.5 border border-emerald-200">
                                            <span>WA:</span> <span>{{ $walasPhone }}</span>
                                        </span>
                                    @else
                                        <span class="text-[9px] text-slate-400 italic">No HP belum ada</span>
                                    @endif
                                </div>
                            </td>

                            <!-- 4. Mapel & TP -->
                            <td class="px-3 py-3.5 text-center">
                                @if($data['mapel_count'] > 0)
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Terisi</span>
                                    </span>
                                    <div class="text-[9px] text-emerald-700 font-bold mt-0.5">TP Terhubung</div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>

                            <!-- 5. Wafa & Tahfidz -->
                            <td class="px-3 py-3.5 text-center">
                                @if($data['quran_count'] > 0)
                                    <span class="px-2.5 py-1 rounded-md bg-teal-100 text-teal-900 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Terisi</span>
                                    </span>
                                    <div class="text-[9px] text-teal-700 font-bold mt-0.5">Metode Wafa</div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>

                            <!-- 6. Karakter 7 SKL -->
                            <td class="px-3 py-3.5 text-center">
                                @if($data['char_count'] > 0)
                                    <span class="px-2.5 py-1 rounded-md bg-indigo-100 text-indigo-900 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>7 SKL Terisi</span>
                                    </span>
                                    <div class="text-[9px] text-indigo-700 font-bold mt-0.5">Standar JSIT</div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>

                            <!-- 7. P5 & Ekskul -->
                            <td class="px-3 py-3.5 text-center">
                                @if(($data['p5_count'] ?? 0) > 0)
                                    <span class="px-2.5 py-1 rounded-md bg-violet-100 text-violet-900 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>{{ $data['p5_count'] }} Projek</span>
                                    </span>
                                    <div class="text-[9px] text-violet-700 font-bold mt-0.5">Kokurikuler</div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum Ada</span>
                                @endif
                            </td>

                            <!-- 8. Catatan Walas -->
                            <td class="px-3 py-3.5 text-center">
                                @if($data['hr_count'] > 0)
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 text-[10px] font-black inline-flex items-center gap-1">
                                        <span>✓</span> <span>Terisi</span>
                                    </span>
                                    <div class="text-[9px] text-emerald-700 font-bold mt-0.5">Presensi OK</div>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>

                            <!-- 9. Rata-rata Nilai -->
                            <td class="px-3 py-3.5 text-center">
                                @if(!empty($data['avg_score']))
                                    <span class="px-2 py-1 rounded-md bg-emerald-50 text-emerald-900 font-black text-xs border border-emerald-200">
                                        {{ number_format($data['avg_score'], 1) }}
                                    </span>
                                @else
                                    <span class="text-slate-400 font-bold">-</span>
                                @endif
                            </td>

                            <!-- 10. Siap Cetak -->
                            <td class="px-3 py-3.5 text-center">
                                @if($stCount > 0 && $readyCount == $stCount)
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 font-black text-[10px] border border-emerald-300 inline-flex items-center gap-1">
                                        <span>✓</span> <span>{{ $readyCount }}/{{ $stCount }} Siswa</span>
                                    </span>
                                @elseif($readyCount > 0)
                                    <span class="px-2 py-1 rounded-md bg-amber-100 text-amber-900 font-black text-[10px] border border-amber-300 inline-flex items-center gap-1">
                                        <span>⏳</span> <span>{{ $readyCount }}/{{ $stCount }} Siswa</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 font-bold text-[10px]">
                                        0/{{ $stCount }} Siswa
                                    </span>
                                @endif
                            </td>

                            <!-- 11. Progres Kinerja -->
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-200 rounded-full h-3 overflow-hidden shadow-2xs">
                                        <div class="h-3 rounded-full transition-all flex items-center justify-center text-[9px] font-black text-white {{ $pct >= 100 ? 'bg-emerald-600' : ($pct >= 60 ? 'bg-sky-600' : ($pct > 0 ? 'bg-amber-500' : 'bg-slate-300')) }}" 
                                             style="width: {{ $pct }}%">
                                        </div>
                                    </div>
                                    <span class="text-[11px] font-black {{ $pct >= 100 ? 'text-emerald-700' : ($pct > 0 ? 'text-slate-800' : 'text-slate-400') }} w-9 text-right">
                                        {{ $pct }}%
                                    </span>
                                </div>
                                <div class="mt-1 text-[9px] font-extrabold uppercase tracking-wider {{ $pct >= 100 ? 'text-emerald-600' : ($pct >= 60 ? 'text-sky-600' : ($pct > 0 ? 'text-amber-600' : 'text-slate-400')) }}">
                                    @if($pct >= 100)
                                        ✓ Tuntas 100%
                                    @elseif($pct >= 60)
                                        ⚡ Tahap Akhir
                                    @elseif($pct > 0)
                                        ⏳ Sedang Berjalan
                                    @else
                                        Belum Dimulai
                                    @endif
                                </div>
                            </td>

                            <!-- 12. Aksi Kepala Sekolah -->
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <!-- Tombol AI Evaluasi -->
                                    <button type="button" 
                                            onclick="openAiClassAnalysisModal({{ $data['classroom']->id }}, '{{ addslashes($data['classroom']->name) }}')" 
                                            class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-black text-[10px] transition shadow-2xs cursor-pointer active:scale-95"
                                            title="Analisis Kesiapan Rapor Kelas via Robbani AI">
                                        <span>✨</span>
                                        <span>AI Evaluasi</span>
                                    </button>

                                    <!-- Tombol WhatsApp Reminder (Quick Follow Up Walas) -->
                                    <button type="button" 
                                            onclick="openWaliReminderModal('{{ addslashes($walasName) }}', '{{ addslashes($data['classroom']->name) }}', '{{ $walasPhone }}', {{ $pct }}, {{ $stCount }})"
                                            class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg {{ $pct >= 100 ? 'bg-slate-100 text-slate-600 hover:bg-slate-200 border-slate-300' : 'bg-green-50 hover:bg-green-100 text-green-800 border-green-300' }} border font-black text-[10px] transition shadow-2xs cursor-pointer active:scale-95"
                                            title="Kirim Pesan Pengingat Resmi ke Wali Kelas">
                                        <span>📲</span>
                                        <span>{{ $pct >= 100 ? 'Apresiasi' : 'Ingatkan WA' }}</span>
                                    </button>

                                    <!-- Tombol Buka Kelas -->
                                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'classroom_id' => $data['classroom']->id, 'menu' => 'academic']) }}" 
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1.5 rounded-lg bg-[#064e3b] hover:bg-[#047857] text-white font-black text-[11px] transition shadow-2xs whitespace-nowrap active:scale-95"
                                       title="Buka Pengisian & Detail Nilai Rombel Ini">
                                        <span>Buka Kelas</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="px-6 py-8 text-center text-slate-500">
                                Belum ada rombel kelas yang terdaftar untuk unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: MANAJEMEN PENGGUNA & GURU UNIT (KHUSUS KEPSEK & SUPER ADMIN) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'users')
    <div class="space-y-6">
        <!-- Header Info & Action -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Hak Akses Kepala Sekolah
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Manajemen Pengguna & Pendidik Unit
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Kepala Sekolah dapat menambah akun baru, mengedit data guru/staf, dan mengatur ulang kata sandi (reset password) akun di unit kerjanya.
                </p>
            </div>

            <div>
                <button onclick="openTambahUserModal()" 
                        class="px-4 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs inline-flex whitespace-nowrap items-center gap-2 shadow-xs transition cursor-pointer active:scale-95">
                    <span>➕</span> <span>Tambah Pengguna Baru</span>
                </button>
            </div>
        </div>

        <!-- User Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Daftar Akun Pengguna Terdaftar di Unit {{ $activeSchool->name ?? 'SIT Robbani' }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Hanya akun unit sekolah Anda yang tampil dan dapat dikelola secara aman</p>
                </div>
                <span class="px-3 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-xs">
                    Total: {{ count($unitUsers) }} Pengguna
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3">Nama Lengkap</th>
                            <th class="px-5 py-3">Email Login</th>
                            <th class="px-5 py-3 text-center">Peran / Hak Akses</th>
                            <th class="px-5 py-3 text-center">Terdaftar Sejak</th>
                            <th class="px-5 py-3 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($unitUsers as $idx => $u)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $idx + 1 }}</td>
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center text-xs font-black">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </span>
                                    <span>{{ $u->name }}</span>
                                    @if(auth()->id() == $u->id)
                                    <span class="px-1.5 py-0.5 rounded bg-amber-100 text-amber-800 text-[9px] font-extrabold">Anda</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-mono text-[11px]">{{ $u->email }}</td>
                            <td class="px-5 py-3.5 text-center">
                                @if($u->role === 'HEADMASTER')
                                    <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[10px]">Kepala Sekolah</span>
                                @elseif($u->role === 'TEACHER')
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">Guru & Wali Kelas</span>
                                @elseif($u->role === 'STAFF_TU')
                                    <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px]">Operator / Tata Usaha</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-800 font-black text-[10px]">{{ $u->role }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center text-slate-500 text-[11px]">
                                {{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" onclick="openEditUserModal({{ json_encode($u) }})" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer" 
                                            title="Edit Akun & Reset Password">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    @if(auth()->id() != $u->id && $u->role !== 'SUPER_ADMIN')
                                    <form action="{{ route('admin.academic.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }} dari unit sekolah ini?')" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Akun">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada akun guru/staf terdaftar di unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah / Edit Pengguna -->
        <div id="modalUserManage" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
            <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
                <div class="px-6 py-4 bg-[#0f172a] text-white flex items-center justify-between">
                    <h3 id="modalUserTitle" class="font-black text-sm text-white">Tambah Pengguna Baru</h3>
                    <button type="button" onclick="closeUserModal()" class="text-slate-400 hover:text-white cursor-pointer font-bold text-lg">&times;</button>
                </div>
                <form action="{{ route('admin.academic.users.save') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="user_id" id="formUserId" value="">

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap & Gelar *</label>
                        <input type="text" name="name" id="formUserName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Contoh: Ustadz Ahmad Fauzi, S.Pd.">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Email Login *</label>
                        <input type="email" name="email" id="formUserEmail" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="nama@sitrobbani.sch.id">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Peran / Hak Akses *</label>
                        <select name="role" id="formUserRole" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold focus:ring-2 focus:ring-emerald-500 focus:outline-none bg-white">
                            <option value="TEACHER">Guru Mapel & Wali Kelas (Pendidik)</option>
                            <option value="STAFF_TU">Operator Sekolah / Tata Usaha</option>
                            @if(auth()->user()?->isSuperAdmin())
                            <option value="HEADMASTER">Kepala Sekolah Unit</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi (Password) <span id="pwdNotice" class="text-slate-400 font-normal">*</span></label>
                        <input type="password" name="password" id="formUserPassword" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium focus:ring-2 focus:ring-emerald-500 focus:outline-none" placeholder="Minimal 6 karakter">
                        <p id="pwdHelp" class="text-[10px] text-slate-500 mt-1 hidden">Kosongkan jika tidak ingin mengubah password lama.</p>
                    </div>

                    <div class="pt-2 flex items-center justify-end gap-2.5">
                        <button type="button" onclick="closeUserModal()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs cursor-pointer transition">Batal</button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs cursor-pointer shadow-xs transition active:scale-95">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: MASTER DATA SISWA UNIT (KEPSEK & OPERATOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'students')
    <div class="space-y-6">
        
        <!-- Header Info & Action -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Master Data Siswa
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Data Siswa Unit
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Kelola data peserta didik, nomor induk (NIS/NISN), serta penempatan rombel kelas untuk unit sekolah Anda.
                </p>
            </div>

            <!-- Action Buttons: Tarik Master, Kirim ke Master, Tambah Siswa, Download Template, Import CSV -->
            <div class="flex items-center gap-2.5 flex-wrap sm:shrink-0">
                <form method="POST" action="{{ route('admin.academic.students.sync.master') }}" class="inline">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <button type="submit" 
                            onclick="return confirm('Tarik dan perbarui data siswa dari Data Master Siswa ke e-Rapor unit {{ $activeSchool->name ?? '' }}?')"
                            class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition cursor-pointer shadow-xs active:scale-95"
                            title="Tarik data siswa dari Data Master Siswa ke e-Rapor unit ini">
                        <span>📥</span> <span>Tarik dari Data Master</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.academic.students.push.master') }}" class="inline">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <button type="submit" 
                            onclick="return confirm('Sinkronkan seluruh data siswa yang diinput di e-Rapor ke Data Master Siswa (dan buatkan akun portal siswa)?')"
                            class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition cursor-pointer shadow-xs active:scale-95"
                            title="Tarik/sinkronkan data yang diinput di e-Rapor ke tabel data master siswa">
                        <span>📤</span> <span>Sinkronkan ke Data Master</span>
                    </button>
                </form>

                <a href="{{ route('admin.academic.students.template') }}" 
                   class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition border border-slate-300 shadow-2xs">
                    <span>📄</span> <span>Template CSV</span>
                </a>
                <button onclick="document.getElementById('modalImportSiswa').classList.remove('hidden')" 
                        class="px-3 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-black text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition cursor-pointer shadow-2xs">
                    <span>📥</span> <span>Import CSV</span>
                </button>
                <button onclick="openTambahSiswaModal()" 
                        class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs inline-flex whitespace-nowrap items-center gap-2 shadow-xs transition cursor-pointer active:scale-95">
                    <span>➕</span> <span>Tambah Siswa Baru</span>
                </button>
            </div>
        </div>

        <!-- Modal Import Siswa CSV -->
        <div id="modalImportSiswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>📤</span> <span>Import Data Siswa (CSV)</span>
                    </h3>
                    <button onclick="document.getElementById('modalImportSiswa').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.students.import') }}" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">

                    <div class="p-3 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 text-xs">
                        <p class="font-bold mb-1">📋 Petunjuk Import Sesuai e-Rapor:</p>
                        <p>1. Unduh <a href="{{ route('admin.academic.students.template') }}" class="underline font-black text-emerald-900">Format Template CSV Siswa</a>.</p>
                        <p>2. Kolom: NIS, NISN, Nama_Lengkap, Jenis_Kelamin_L_P, Nama_Rombel.</p>
                        <p>3. Jika rombel belum ada, sistem akan otomatis membuatnya.</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pilih File CSV Siswa:</label>
                        <input type="file" name="csv_file" required accept=".csv,.txt" 
                               class="w-full text-xs font-semibold rounded-xl border border-slate-300 p-2 bg-slate-50 focus:bg-white">
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalImportSiswa').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Unggah & Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 flex-wrap w-full sm:w-auto">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="students">

                <span class="text-xs font-bold text-slate-700">Filter Rombel:</span>
                <select name="classroom_id" onchange="this.form.submit()" class="text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    <option value="">-- Semua Rombel ({{ $unitStudents->count() }} Siswa) --</option>
                    @if($unitStudents->whereNull('classroom_id')->count() > 0)
                        <option value="unassigned" {{ $selectedClassroomId === 'unassigned' ? 'selected' : '' }} class="text-amber-700 font-bold">
                            ⚠️ Belum Masuk Rombel ({{ $unitStudents->whereNull('classroom_id')->count() }} Siswa)
                        </option>
                    @endif
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} ({{ \App\Models\Student::where('classroom_id', $cls->id)->count() }} Siswa)
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="w-full sm:w-72">
                <input type="text" id="searchSiswaInput" oninput="filterSiswaTable()" 
                       placeholder="Cari nama siswa atau NIS..." 
                       class="w-full text-xs rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600">
            </div>
        </div>

        @if($unitStudents->whereNull('classroom_id')->count() > 0)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-amber-900 flex items-start gap-3 text-xs">
            <span class="text-lg">⚠️</span>
            <div class="flex-1">
                <p class="font-extrabold text-amber-900">Perhatian: Ada {{ $unitStudents->whereNull('classroom_id')->count() }} siswa di unit ini yang belum dimasukkan ke Rombel / Kelas!</p>
                <p class="text-amber-700 mt-0.5">Siswa yang belum memiliki rombel tidak akan muncul saat pengisian nilai e-Rapor kelas. Silakan klik tombol <b>Edit</b> pada baris siswa di tabel bawah untuk menentukan rombel/kelasnya.</p>
            </div>
            <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'students', 'classroom_id' => 'unassigned']) }}" 
               class="px-3 py-1.5 rounded-lg bg-amber-200 hover:bg-amber-300 text-amber-900 font-bold shrink-0 transition">
                Filter Siswa Tanpa Rombel
            </a>
        </div>
        @endif

        <!-- Modal Tambah / Update Siswa Lengkap -->
        <div id="modalTambahSiswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4 overflow-y-auto">
            <div class="bg-white rounded-2xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 my-8 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3 shrink-0">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>🎓</span> <span id="titleModalSiswa">Tambah / Perbarui Data Siswa Lengkap</span>
                    </h3>
                    <button onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.students.save') }}" enctype="multipart/form-data" class="space-y-4 text-xs overflow-y-auto pr-1 flex-1">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="student_id" id="input_student_id" value="">

                    <!-- Bagian Unggah Pas Foto Siswa (3x4) -->
                    <div class="bg-emerald-50/70 p-3.5 rounded-xl border border-emerald-200 flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-24 h-32 rounded-xl border-2 border-dashed border-emerald-300 bg-white flex flex-col items-center justify-center overflow-hidden shrink-0 shadow-xs relative">
                            <img id="preview_student_photo" src="" alt="Pratinjau Foto" class="w-full h-full object-cover hidden">
                            <div id="placeholder_student_photo" class="text-center p-2 text-slate-400">
                                <span class="text-2xl block mb-1">📷</span>
                                <span class="text-[10px] font-bold text-slate-600 block">Pas Foto 3x4</span>
                            </div>
                        </div>
                        <div class="flex-1 space-y-1.5 w-full">
                            <label class="block font-black text-slate-800 text-xs">Unggah Pas Foto Siswa (Format 3x4):</label>
                            <p class="text-[11px] text-slate-600 leading-relaxed">
                                Foto ini otomatis tampil di Lembar 3 (Identitas Siswa) Rapor. Pilih file foto siswa (JPG, JPEG, PNG, maks 2MB).
                            </p>
                            <input type="file" name="photo" id="input_photo" accept="image/png, image/jpeg, image/jpg" onchange="previewStudentPhoto(this)"
                                   class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 file:cursor-pointer cursor-pointer">
                        </div>
                    </div>

                    <!-- Bagian 1: Data Pokok Siswa -->
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-black text-slate-800 uppercase text-[11px] flex items-center gap-1.5">
                            <span>📌</span> <span>1. Data Pokok Siswa & Rombel</span>
                        </h4>
                        
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Rombongan Belajar (Rombel):</label>
                            <select name="classroom_id" id="input_classroom_id" required class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                                @foreach($classrooms as $cls)
                                    <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                                        {{ $cls->name }} (Wali: {{ $cls->homeroomTeacher->name ?? 'Belum ada' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nomor Induk Siswa (NIS):</label>
                                <input type="text" name="nis" id="input_nis" required placeholder="Contoh: 20260101" 
                                       class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">NISN (10 Digit):</label>
                                <input type="text" name="nisn" id="input_nisn" placeholder="10 digit NISN..." 
                                       class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Siswa:</label>
                                <input type="text" name="full_name" id="input_full_name" required placeholder="Nama lengkap sesuai akta lahir..." 
                                       class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Panggilan:</label>
                                <input type="text" name="nickname" id="input_nickname" placeholder="Nama panggilan..." 
                                       class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin:</label>
                            <select name="gender" id="input_gender" required class="w-full font-bold rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                                <option value="M">Laki-laki (Ikhwan)</option>
                                <option value="F">Perempuan (Akhwat)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bagian 2: Kelahiran & Pendidikan Sebelumnya -->
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-black text-slate-800 uppercase text-[11px] flex items-center gap-1.5">
                            <span>🎂</span> <span>2. Kelahiran, Agama & Asal Sekolah</span>
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Tempat Lahir:</label>
                                <input type="text" name="birth_place" id="input_birth_place" placeholder="Contoh: Palembang / Ogan Ilir" 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Tanggal Lahir:</label>
                                <input type="date" name="birth_date" id="input_birth_date" 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Agama:</label>
                                <input type="text" name="religion" id="input_religion" value="Islam" 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Pendidikan / Sekolah Sebelumnya:</label>
                            <input type="text" name="previous_school" id="input_previous_school" placeholder="Contoh: SD IT Robbani / TK IT Robbani" 
                                   class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Bagian 3: Data Orang Tua & Wali -->
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-black text-slate-800 uppercase text-[11px] flex items-center gap-1.5">
                            <span>👨‍👩‍👧</span> <span>3. Data Orang Tua & Wali Siswa</span>
                        </h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Ayah Kandung:</label>
                                <input type="text" name="father_name" id="input_father_name" placeholder="Nama ayah..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pekerjaan Ayah:</label>
                                <input type="text" name="father_job" id="input_father_job" placeholder="Pekerjaan ayah (e.g. Wiraswasta, PNS)..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Ibu Kandung:</label>
                                <input type="text" name="mother_name" id="input_mother_name" placeholder="Nama ibu..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pekerjaan Ibu:</label>
                                <input type="text" name="mother_job" id="input_mother_job" placeholder="Pekerjaan ibu (e.g. Ibu Rumah Tangga, Guru)..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Wali (Opsional):</label>
                                <input type="text" name="guardian_name" id="input_guardian_name" placeholder="Nama wali..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Pekerjaan Wali:</label>
                                <input type="text" name="guardian_job" id="input_guardian_job" placeholder="Pekerjaan wali..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Alamat Wali:</label>
                                <input type="text" name="guardian_address" id="input_guardian_address" placeholder="Alamat wali..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>
                    </div>

                    <!-- Bagian 4: Alamat Domisili Siswa -->
                    <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 space-y-3">
                        <h4 class="font-black text-slate-800 uppercase text-[11px] flex items-center gap-1.5">
                            <span>🏡</span> <span>4. Alamat Tempat Tinggal Siswa</span>
                        </h4>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap / Jalan / RT / RW:</label>
                            <textarea name="address" id="input_address" rows="2" placeholder="Jalan, Gang, Blok, No Rumah..." 
                                      class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600"></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Desa / Kelurahan:</label>
                                <input type="text" name="village" id="input_village" placeholder="Kelurahan..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kecamatan:</label>
                                <input type="text" name="district" id="input_district" placeholder="Kecamatan..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kabupaten / Kota:</label>
                                <input type="text" name="city" id="input_city" placeholder="Kab / Kota..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Provinsi:</label>
                                <input type="text" name="province" id="input_province" value="Sumatera Selatan" 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kode Pos:</label>
                                <input type="text" name="postal_code" id="input_postal_code" placeholder="Kode pos..." 
                                       class="w-full font-medium rounded-xl border border-slate-300 p-2 bg-white focus:border-emerald-600">
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2 shrink-0">
                        <button type="button" onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs active:scale-95">
                            💾 Simpan Seluruh Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Counter Ringkasan Pas Foto & Data Siswa -->
        @php
            if ($selectedClassroomId === 'unassigned') {
                $displayedStudents = $unitStudents->whereNull('classroom_id');
            } elseif ($selectedClassroomId) {
                $displayedStudents = $unitStudents->where('classroom_id', $selectedClassroomId);
            } else {
                $displayedStudents = $unitStudents;
            }
            $withPhotoCount = $displayedStudents->filter(fn($s) => !empty($s->photo_path))->count();
            $withoutPhotoCount = $displayedStudents->filter(fn($s) => empty($s->photo_path))->count();
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div class="bg-white p-3.5 rounded-xl border border-slate-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block">Total Siswa Terfilter</span>
                    <span class="text-lg font-black text-slate-900">{{ $displayedStudents->count() }} <span class="text-xs font-semibold text-slate-400">Siswa</span></span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-lg">
                    🎓
                </div>
            </div>
            <div class="bg-white p-3.5 rounded-xl border border-emerald-200 shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block">Sudah Ada Pas Foto</span>
                    <span class="text-lg font-black text-emerald-800">{{ $withPhotoCount }} <span class="text-xs font-semibold text-emerald-600">Siswa ({{ $displayedStudents->count() > 0 ? round(($withPhotoCount / $displayedStudents->count()) * 100) : 0 }}%)</span></span>
                </div>
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg">
                    🖼️
                </div>
            </div>
            <div class="bg-white p-3.5 rounded-xl border {{ $withoutPhotoCount > 0 ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200' }} shadow-2xs flex items-center justify-between">
                <div>
                    <span class="text-[11px] font-bold {{ $withoutPhotoCount > 0 ? 'text-rose-700' : 'text-slate-500' }} uppercase tracking-wider block">Belum Ada Pas Foto</span>
                    <span class="text-lg font-black {{ $withoutPhotoCount > 0 ? 'text-rose-700' : 'text-slate-700' }}">{{ $withoutPhotoCount }} <span class="text-xs font-semibold {{ $withoutPhotoCount > 0 ? 'text-rose-500' : 'text-slate-400' }}">Siswa</span></span>
                </div>
                <div class="w-9 h-9 rounded-xl {{ $withoutPhotoCount > 0 ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center text-lg">
                    📷
                </div>
            </div>
        </div>

        <!-- Student Table List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Daftar Siswa Unit (Total: {{ $unitStudents->count() }} Siswa)</h3>
                    <p class="text-xs text-slate-500 font-medium">Menampilkan seluruh peserta didik aktif pada unit {{ $activeSchool->name ?? 'SIT Robbani' }}. Pas foto otomatis dikompres format WebP untuk lembar rapor.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="tableSiswaUnit">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-3 py-3 text-center w-20">Pas Foto</th>
                            <th class="px-4 py-3 w-32">NIS / NISN</th>
                            <th class="px-4 py-3">Nama Lengkap Siswa</th>
                            <th class="px-4 py-3 text-center w-24">L / P</th>
                            <th class="px-4 py-3 min-w-[200px] whitespace-nowrap">Rombel / Kelas</th>
                            <th class="px-4 py-3 text-center w-28">Status</th>
                            <th class="px-4 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($displayedStudents as $st)
                        <tr class="hover:bg-slate-50/75 transition-colors siswa-row" data-name="{{ strtolower($st->full_name) }}" data-nis="{{ $st->nis }}">
                            <td class="px-4 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            
                            <!-- Kolom Pas Foto Siswa (WebP Compact & Badge Indikator) -->
                            <td class="px-3 py-3 text-center">
                                @php
                                    $stDataArrForPhoto = [
                                        'id' => $st->id,
                                        'nis' => $st->nis,
                                        'nisn' => $st->nisn ?? '',
                                        'full_name' => $st->full_name,
                                        'nickname' => $st->nickname ?? '',
                                        'gender' => $st->gender,
                                        'classroom_id' => $st->classroom_id,
                                        'birth_place' => $st->pob ?? $st->birth_place ?? '',
                                        'birth_date' => $st->dob ? \Carbon\Carbon::parse($st->dob)->format('Y-m-d') : '',
                                        'religion' => $st->religion ?? 'Islam',
                                        'previous_school' => $st->previous_school ?? '',
                                        'address' => $st->address ?? '',
                                        'village' => $st->village ?? '',
                                        'district' => $st->district ?? '',
                                        'city' => $st->city ?? '',
                                        'province' => $st->province ?? 'Sumatera Selatan',
                                        'postal_code' => $st->postal_code ?? '',
                                        'father_name' => $st->father_name ?? '',
                                        'father_job' => $st->father_job ?? '',
                                        'mother_name' => $st->mother_name ?? '',
                                        'mother_job' => $st->mother_job ?? '',
                                        'guardian_name' => $st->guardian_name ?? '',
                                        'guardian_job' => $st->guardian_job ?? '',
                                        'guardian_address' => $st->guardian_address ?? '',
                                        'photo_path' => $st->photo_path ?? '',
                                    ];
                                @endphp
                                @if(!empty($st->photo_path))
                                    <div class="inline-flex flex-col items-center group cursor-pointer" onclick="editSiswaLengkap({{ json_encode($stDataArrForPhoto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }})" title="Klik untuk ganti pas foto">
                                        <img src="{{ asset($st->photo_path) }}" alt="{{ $st->full_name }}" 
                                             class="w-10 h-13 object-cover rounded-lg border border-slate-200 shadow-2xs group-hover:scale-105 transition-transform" 
                                             onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($st->full_name) }}&background=cbd5e1&color=475569';">
                                    </div>
                                @else
                                    <button type="button" onclick="editSiswaLengkap({{ json_encode($stDataArrForPhoto, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }})" 
                                            class="inline-flex flex-col items-center group cursor-pointer" title="Klik untuk unggah pas foto">
                                        <div class="w-10 h-13 rounded-lg border border-slate-300 bg-slate-100 flex flex-col items-center justify-center text-slate-400 group-hover:bg-slate-200 group-hover:border-slate-400 transition shadow-2xs">
                                            <svg class="w-6 h-6 text-slate-400 group-hover:text-slate-600 transition" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    </button>
                                @endif
                            </td>

                            <td class="px-4 py-3 font-mono font-bold text-slate-700">
                                <div>{{ $st->nis }}</div>
                                @if($st->nisn)
                                    <div class="text-[10px] text-slate-400">{{ $st->nisn }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-extrabold text-slate-900 text-xs">{{ $st->full_name }}</p>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($st->gender === 'M' || $st->gender === 'L')
                                    <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 text-[10px] font-black">L</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-rose-100 text-rose-800 text-[10px] font-black">P</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap">
                                @if($st->classroom)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60 font-black text-xs whitespace-nowrap">
                                        {{ $st->classroom->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-amber-100 text-amber-800 border border-amber-300 font-bold text-xs whitespace-nowrap">
                                        ⚠️ Belum Ada Rombel
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    @php
                                        $stDataArr = $stDataArrForPhoto;
                                    @endphp
                                    <button onclick="editSiswaLengkap({{ json_encode($stDataArr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) }})" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer"
                                            title="Edit Data Siswa">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    <a href="{{ route('admin.academic.report-card', $st->id) }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-sky-300 bg-sky-50 text-sky-700 hover:bg-sky-100 hover:border-sky-400 transition shadow-2xs"
                                       title="Lihat Pratinjau Rapor">
                                        <span>📄</span> <span>Rapor</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.academic.students.delete', $st->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ addslashes($st->full_name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Siswa">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-500">
                                Belum ada siswa terdaftar pada rombel / unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function filterSiswaTable() {
            const query = document.getElementById('searchSiswaInput').value.toLowerCase();
            const rows = document.querySelectorAll('.siswa-row');
            rows.forEach(r => {
                const name = r.getAttribute('data-name') || '';
                const nis = r.getAttribute('data-nis') || '';
                if (name.includes(query) || nis.includes(query)) {
                    r.style.display = '';
                } else {
                    r.style.display = 'none';
                }
            });
        }

        function previewStudentPhoto(input) {
            const preview = document.getElementById('preview_student_photo');
            const placeholder = document.getElementById('placeholder_student_photo');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function openTambahSiswaModal() {
            document.getElementById('titleModalSiswa').innerText = 'Tambah Siswa Baru';
            const studentIdInput = document.getElementById('input_student_id');
            if (studentIdInput) studentIdInput.value = '';
            const photoInput = document.getElementById('input_photo');
            if (photoInput) photoInput.value = '';
            const preview = document.getElementById('preview_student_photo');
            const placeholder = document.getElementById('placeholder_student_photo');
            if (preview) { preview.src = ''; preview.classList.add('hidden'); }
            if (placeholder) placeholder.classList.remove('hidden');

            document.getElementById('input_nis').value = '';
            document.getElementById('input_nisn').value = '';
            document.getElementById('input_full_name').value = '';
            document.getElementById('input_nickname').value = '';
            document.getElementById('input_birth_place').value = '';
            document.getElementById('input_birth_date').value = '';
            document.getElementById('input_religion').value = 'Islam';
            document.getElementById('input_previous_school').value = '';
            document.getElementById('input_father_name').value = '';
            document.getElementById('input_father_job').value = '';
            document.getElementById('input_mother_name').value = '';
            document.getElementById('input_mother_job').value = '';
            document.getElementById('input_guardian_name').value = '';
            document.getElementById('input_guardian_job').value = '';
            document.getElementById('input_guardian_address').value = '';
            document.getElementById('input_address').value = '';
            document.getElementById('input_village').value = '';
            document.getElementById('input_district').value = '';
            document.getElementById('input_city').value = '';
            document.getElementById('input_province').value = 'Sumatera Selatan';
            document.getElementById('input_postal_code').value = '';
            document.getElementById('modalTambahSiswa').classList.remove('hidden');
        }

        function editSiswaLengkap(data) {
            document.getElementById('titleModalSiswa').innerText = 'Perbarui Data Siswa: ' + data.full_name;
            const studentIdInput = document.getElementById('input_student_id');
            if (studentIdInput) studentIdInput.value = data.id || '';
            const photoInput = document.getElementById('input_photo');
            if (photoInput) photoInput.value = '';
            
            const preview = document.getElementById('preview_student_photo');
            const placeholder = document.getElementById('placeholder_student_photo');
            if (data.photo_path) {
                if (preview) {
                    preview.src = '{{ asset("") }}' + data.photo_path;
                    preview.classList.remove('hidden');
                }
                if (placeholder) placeholder.classList.add('hidden');
            } else {
                if (preview) { preview.src = ''; preview.classList.add('hidden'); }
                if (placeholder) placeholder.classList.remove('hidden');
            }

            document.getElementById('input_nis').value = data.nis || '';
            document.getElementById('input_nisn').value = data.nisn || '';
            document.getElementById('input_full_name').value = data.full_name || '';
            document.getElementById('input_nickname').value = data.nickname || '';
            document.getElementById('input_gender').value = (data.gender === 'M' || data.gender === 'L') ? 'M' : 'F';
            const selectCls = document.getElementById('input_classroom_id');
            if (selectCls && data.classroom_id) selectCls.value = data.classroom_id;
            
            document.getElementById('input_birth_place').value = data.birth_place || '';
            document.getElementById('input_birth_date').value = data.birth_date || '';
            document.getElementById('input_religion').value = data.religion || 'Islam';
            document.getElementById('input_previous_school').value = data.previous_school || '';

            document.getElementById('input_father_name').value = data.father_name || '';
            document.getElementById('input_father_job').value = data.father_job || '';
            document.getElementById('input_mother_name').value = data.mother_name || '';
            document.getElementById('input_mother_job').value = data.mother_job || '';
            document.getElementById('input_guardian_name').value = data.guardian_name || '';
            document.getElementById('input_guardian_job').value = data.guardian_job || '';
            document.getElementById('input_guardian_address').value = data.guardian_address || '';

            document.getElementById('input_address').value = data.address || '';
            document.getElementById('input_village').value = data.village || '';
            document.getElementById('input_district').value = data.district || '';
            document.getElementById('input_city').value = data.city || '';
            document.getElementById('input_province').value = data.province || 'Sumatera Selatan';
            document.getElementById('input_postal_code').value = data.postal_code || '';

            document.getElementById('modalTambahSiswa').classList.remove('hidden');
        }

        function editSiswa(nis, nisn, name, gender, classroomId) {
            editSiswaLengkap({
                nis: nis,
                nisn: nisn,
                full_name: name,
                gender: gender,
                classroom_id: classroomId
            });
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: SETTING ROMBEL & PENETAPAN WALI KELAS (KEPSEK & OPERATOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'classrooms')
    <div class="space-y-6">
        
        <!-- Header Info -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Rombongan Belajar & Wali Kelas
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Setting Rombel & Penetapan Wali Kelas
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Kelola data rombongan belajar, kapasitas kelas, penetapan guru wali kelas, serta tanda tangan digital rapor.
                </p>
            </div>

            <!-- Tombol Tambah Rombel Baru -->
            <button onclick="bukaModalTambahRombel()" 
                    class="px-4 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs flex items-center gap-2 shadow-sm transition cursor-pointer active:scale-95 shrink-0">
                <span>➕</span> <span>Tambah Rombel Baru</span>
            </button>
        </div>

        <!-- Quick Stats Rombel -->
        @php
            $totalRombelStudents = $classrooms->sum(fn($c) => \App\Models\Student::where('classroom_id', $c->id)->count());
            $totalWaliAssigned = $classrooms->whereNotNull('homeroom_teacher_id')->count();
        @endphp
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3.5">
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg font-black shrink-0">
                    🏫
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase text-slate-400">Total Rombel</span>
                    <p class="text-base font-black text-slate-900 leading-tight">{{ $classrooms->count() }} Kelas</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-lg font-black shrink-0">
                    👥
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase text-slate-400">Siswa di Rombel</span>
                    <p class="text-base font-black text-slate-900 leading-tight">{{ $totalRombelStudents }} Siswa</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-lg font-black shrink-0">
                    👨‍🏫
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase text-slate-400">Wali Kelas Terisi</span>
                    <p class="text-base font-black text-slate-900 leading-tight">{{ $totalWaliAssigned }} / {{ $classrooms->count() }} Kelas</p>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-lg font-black shrink-0">
                    📌
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase text-slate-400">Tingkat / Jenjang</span>
                    <p class="text-base font-black text-slate-900 leading-tight">{{ $schoolLevels->count() }} Tingkat</p>
                </div>
            </div>
        </div>

        <!-- Modal Tambah & Edit Rombel Lengkap (CRUD Rombel) -->
        <div id="modalRombel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] flex flex-col">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-lg font-black shadow-xs">
                            🏫
                        </div>
                        <div>
                            <h3 class="font-black text-sm text-slate-900" id="modalRombelTitle">Formulir Rombongan Belajar</h3>
                            <p class="text-[11px] text-slate-500 font-medium">Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}</p>
                        </div>
                    </div>
                    <button onclick="tutupModalRombel()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center font-bold text-sm transition cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.classrooms.save') }}" class="space-y-3.5 text-xs overflow-y-auto flex-1 pr-1">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="classroom_id" id="input_classroom_id_modal" value="">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Rombel / Kelas <span class="text-rose-500">*</span>:</label>
                        <input type="text" name="name" id="input_rombel_name" required placeholder="Contoh: Kelas 1A, 1-Abu Bakar, Kelas 7A Tahfidz" 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tingkat (Level) Sesuai Unit <span class="text-rose-500">*</span>:</label>
                        <select name="level_id" id="input_rombel_level_id" required class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                            @foreach($schoolLevels as $lvl)
                                <option value="{{ $lvl->id }}">{{ $lvl->name }} (Kode: {{ $lvl->code }})</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-400 mt-1">Disesuaikan otomatis dengan jenjang unit {{ $activeSchool->name ?? 'sekolah' }} (Total {{ $schoolLevels->count() }} tingkat).</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tetapkan Guru Wali Kelas:</label>
                        <select name="homeroom_teacher_id" id="input_rombel_teacher_id" class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                            <option value="">-- Belum Ditetapkan / Pilih Nanti --</option>
                            @foreach($schoolTeachers as $tc)
                                <option value="{{ $tc->id }}">{{ $tc->name }} (NIP: {{ $tc->nip ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kapasitas Maksimal Siswa:</label>
                            <input type="number" name="capacity" id="input_rombel_capacity" value="28" min="1" max="100" 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kode / Nama Ruangan:</label>
                            <input type="text" name="room_number" id="input_rombel_room" placeholder="Contoh: SD-101, R.01" 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="tutupModalRombel()" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-md active:scale-95">
                            💾 Simpan Data Rombel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table of Classrooms (CRUD Rombel & Wali Kelas) -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Daftar Rombel & Wali Kelas Aktif</h3>
                    <p class="text-xs text-slate-500 font-medium">Klik <b>Edit</b> untuk mengubah nama, tingkat, kapasitas, dan wali kelas rombel</p>
                </div>
                <span class="px-3 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-black">
                    Total: {{ $classrooms->count() }} Rombel Aktif
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-4 py-3">Rombongan Belajar</th>
                            <th class="px-4 py-3">Wali Kelas & TTD Digital</th>
                            <th class="px-4 py-3 text-center">Kapasitas & Siswa</th>
                            <th class="px-4 py-3 text-center">Ruangan</th>
                            <th class="px-4 py-3 text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($classrooms as $cls)
                        @php
                            $stCount = \App\Models\Student::where('classroom_id', $cls->id)->count();
                            $lvlName = $cls->level->name ?? ('Tingkat ' . $cls->level_id);
                            $cap = $cls->capacity ?? 28;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-4 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            
                            <!-- Rombel & Tingkat -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-sm font-black shrink-0">
                                        🏫
                                    </span>
                                    <div>
                                        <div class="font-black text-slate-900 text-sm leading-snug">{{ $cls->name }}</div>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="px-2 py-0.2 rounded-md bg-blue-50 text-blue-800 border border-blue-200 text-[10px] font-black">
                                                {{ $lvlName }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 font-mono">ID: #{{ $cls->id }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Wali Kelas & TTD Digital -->
                            <td class="px-4 py-3.5">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        @if($cls->homeroomTeacher)
                                            <div class="font-bold text-slate-900 text-xs flex items-center gap-1.5">
                                                <span>👨‍🏫</span>
                                                <span>{{ $cls->homeroomTeacher->name }}</span>
                                            </div>
                                            <div class="text-[10px] text-slate-500 font-medium mt-0.5">
                                                NIP: {{ $cls->homeroomTeacher->nip ?? '-' }}
                                            </div>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-bold inline-flex items-center gap-1">
                                                <span>⚠️</span> Belum Ditetapkan
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Mini TTD Preview & Upload -->
                                    <div class="shrink-0 flex items-center gap-1.5">
                                        @if(!empty($cls->homeroom_signature_path))
                                            <img src="{{ asset($cls->homeroom_signature_path) }}" 
                                                 class="h-6 w-auto object-contain border border-slate-200 rounded p-0.5 bg-white shadow-2xs" 
                                                 alt="TTD" title="TTD Digital Aktif">
                                            <span class="text-[9px] font-black text-emerald-700 bg-emerald-50 px-1 py-0.5 rounded border border-emerald-200">✓ TTD</span>
                                        @endif
                                        <form method="POST" action="{{ route('admin.academic.classrooms.signature', $cls->id) }}" enctype="multipart/form-data" class="inline">
                                            @csrf
                                            <label class="cursor-pointer px-2 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] border border-slate-300 transition shadow-2xs inline-flex items-center gap-1" title="Upload Tanda Tangan Digital">
                                                <span>✍️</span> <span>{{ !empty($cls->homeroom_signature_path) ? 'Ganti' : 'Upload TTD' }}</span>
                                                <input type="file" name="homeroom_signature" accept="image/*" class="hidden" onchange="this.form.submit()">
                                            </label>
                                        </form>
                                    </div>
                                </div>
                            </td>

                            <!-- Kapasitas & Siswa Terdaftar -->
                            <td class="px-4 py-3.5 text-center">
                                <span class="px-2.5 py-1 rounded-lg {{ $stCount > 0 ? 'bg-emerald-50 text-emerald-800 border-emerald-200/60' : 'bg-slate-100 text-slate-600 border-slate-200' }} border font-black text-xs inline-flex items-center gap-1">
                                    <span>👥</span> <span>{{ $stCount }} / {{ $cap }} Siswa</span>
                                </span>
                            </td>

                            <!-- Ruangan -->
                            <td class="px-4 py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[11px] border border-slate-200">
                                    {{ $cls->room_number ?: 'Ruang Kelas' }}
                                </span>
                            </td>

                            <!-- Aksi (Edit & Hapus Rombel) -->
                            <td class="px-4 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <!-- Tombol Edit Rombel -->
                                    <button type="button" 
                                            onclick="bukaModalEditRombel({{ $cls->id }}, '{{ addslashes($cls->name) }}', {{ $cls->level_id ?? 'null' }}, {{ $cls->capacity ?? 28 }}, '{{ addslashes($cls->room_number ?? '') }}', {{ $cls->homeroom_teacher_id ?? 'null' }})"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer" 
                                            title="Edit Rombel">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>

                                    <!-- Tombol Hapus Rombel -->
                                    <form method="POST" action="{{ route('admin.academic.classrooms.delete', $cls->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rombel {{ addslashes($cls->name) }}? Sebanyak {{ $stCount }} siswa di kelas ini akan dialihkan ke status belum masuk rombel.');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Rombel">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada rombongan belajar yang dibuat untuk unit ini. Silakan klik tombol <b>➕ Tambah Rombel Baru</b> di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Script Helper CRUD Rombel -->
    <script>
        function bukaModalTambahRombel() {
            document.getElementById('modalRombelTitle').innerText = 'Tambah Rombel Baru';
            document.getElementById('input_classroom_id_modal').value = '';
            document.getElementById('input_rombel_name').value = '';
            document.getElementById('input_rombel_capacity').value = '28';
            document.getElementById('input_rombel_room').value = '';
            document.getElementById('input_rombel_teacher_id').value = '';
            const selLvl = document.getElementById('input_rombel_level_id');
            if (selLvl && selLvl.options.length > 0) selLvl.selectedIndex = 0;
            document.getElementById('modalRombel').classList.remove('hidden');
        }

        function bukaModalEditRombel(id, name, levelId, capacity, roomNumber, teacherId) {
            document.getElementById('modalRombelTitle').innerText = 'Edit Rombongan Belajar: ' + name;
            document.getElementById('input_classroom_id_modal').value = id;
            document.getElementById('input_rombel_name').value = name;
            document.getElementById('input_rombel_capacity').value = capacity || 28;
            document.getElementById('input_rombel_room').value = roomNumber || '';
            
            const selLvl = document.getElementById('input_rombel_level_id');
            if (selLvl && levelId) selLvl.value = levelId;

            const selTch = document.getElementById('input_rombel_teacher_id');
            if (selTch) selTch.value = teacherId ? teacherId : '';

            document.getElementById('modalRombel').classList.remove('hidden');
        }

        function tutupModalRombel() {
            document.getElementById('modalRombel').classList.add('hidden');
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: DATA MATA PELAJARAN (KEPSEK & OPERATOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'subjects')
    <div class="space-y-6">
        <!-- Action Buttons: Tambah Mapel, Download Template, Import CSV -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Mata Pelajaran & Kurikulum
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Mata Pelajaran & Muatan Kurikulum SIT
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Daftar mata pelajaran yang diajarkan pada unit ini, meliputi Kurikulum Merdeka, Standar JSIT Indonesia, dan Muatan Lokal.
                </p>
            </div>

            <div class="flex items-center gap-2.5 flex-wrap sm:shrink-0">
                <a href="{{ route('admin.academic.subjects.template') }}" 
                   class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition border border-slate-300 shadow-2xs">
                    <span>📥</span> <span>Format Template CSV</span>
                </a>
                <button onclick="document.getElementById('modalImportMapel').classList.remove('hidden')" 
                        class="px-3 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-black text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition cursor-pointer shadow-2xs">
                    <span>📤</span> <span>Upload / Import CSV</span>
                </button>
                <button onclick="openTambahMapelModal()" 
                        class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs inline-flex whitespace-nowrap items-center gap-2 shadow-xs transition cursor-pointer active:scale-95">
                    <span>➕</span> <span>Tambah Mapel Baru</span>
                </button>
            </div>
        </div>

        <!-- Modal Import Mapel CSV -->
        <div id="modalImportMapel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>📤</span> <span>Import Mata Pelajaran (CSV)</span>
                    </h3>
                    <button onclick="document.getElementById('modalImportMapel').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.subjects.import') }}" enctype="multipart/form-data" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">

                    <div class="p-3 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 text-xs">
                        <p class="font-bold mb-1">📋 Petunjuk Import Mapel:</p>
                        <p>1. Unduh <a href="{{ route('admin.academic.subjects.template') }}" class="underline font-black text-emerald-900">Format Template CSV Mapel</a>.</p>
                        <p>2. Kolom: Kode_Mapel, Nama_Mata_Pelajaran, Kelompok_Kurikulum, KKTP_KKM.</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pilih File CSV Mapel:</label>
                        <input type="file" name="csv_file" required accept=".csv,.txt" 
                               class="w-full text-xs font-semibold rounded-xl border border-slate-300 p-2 bg-slate-50 focus:bg-white">
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalImportMapel').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Unggah & Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Tambah / Update Mapel -->
        <div id="modalTambahMapel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>📚</span> <span id="titleModalMapel">Tambah / Perbarui Mata Pelajaran</span>
                    </h3>
                    <button onclick="document.getElementById('modalTambahMapel').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.subjects.save') }}" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="subject_id" id="input_subject_id" value="">

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kode Mapel:</label>
                            <input type="text" name="code" id="input_subject_code" required placeholder="e.g. PAI-01" 
                                   class="w-full font-mono font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600 uppercase">
                        </div>
                        <div class="col-span-2">
                            <label class="block font-bold text-slate-700 mb-1">Nama Mata Pelajaran:</label>
                            <input type="text" name="name" id="input_subject_name" required placeholder="Nama lengkap mata pelajaran..." 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kelompok Kurikulum:</label>
                            <select name="category" id="input_subject_category" class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                                <option value="NASIONAL">Kurikulum Nasional (Kemendikbud)</option>
                                <option value="KEKHASAN">Kekhasan JSIT Indonesia</option>
                                <option value="QURAN">Al-Qur'an (Tahsin Wafa & Tahfidz)</option>
                                <option value="MULOK">Muatan Lokal</option>
                                <option value="Kelompok A (Umum)">Kelompok A (Umum)</option>
                                <option value="Kelompok B (Muatan Khusus JSIT)">Kelompok B (Muatan Khusus JSIT)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">KKTP / KKM (0-100):</label>
                            <input type="number" min="0" max="100" name="passing_grade" id="input_subject_kktp" value="75" required 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalTambahMapel').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Simpan Mata Pelajaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Subjects Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="font-black text-sm text-slate-900">Daftar Mata Pelajaran (Total: {{ $subjects->count() }} Mapel)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3 w-32">Kode Mapel</th>
                            <th class="px-5 py-3">Nama Mata Pelajaran</th>
                            <th class="px-5 py-3 min-w-[200px]">Kelompok Kurikulum</th>
                            <th class="px-5 py-3 text-center w-28">KKTP / KKM</th>
                            <th class="px-5 py-3 text-center w-28">Status</th>
                            <th class="px-5 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($subjects as $sb)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3.5 font-mono font-bold text-slate-700">
                                {{ $sb->code ?? 'MP-' . $sb->id }}
                            </td>
                            <td class="px-5 py-3.5 font-black text-slate-900">
                                {{ $sb->name }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @php
                                    $cat = $sb->category ?? 'NASIONAL';
                                    $catLabel = 'Kurikulum Nasional';
                                    $badgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                                    $u = strtoupper($cat);
                                    if ($u === 'KEKHASAN' || str_contains($u, 'JSIT')) {
                                        $catLabel = 'Kekhasan JSIT';
                                        $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                                    } elseif ($u === 'QURAN' || str_contains($u, 'TAHSIN') || str_contains($u, 'TAHFIDZ') || str_contains($u, 'WAFA')) {
                                        $catLabel = 'Al-Qur\'an / Wafa';
                                        $badgeClass = 'bg-teal-50 text-teal-800 border-teal-200';
                                    } elseif ($u === 'MULOK' || str_contains($u, 'LOKAL')) {
                                        $catLabel = 'Muatan Lokal';
                                        $badgeClass = 'bg-purple-50 text-purple-800 border-purple-200';
                                    } elseif (str_contains($u, 'UMUM') || $u === 'NASIONAL') {
                                        $catLabel = 'Kurikulum Nasional';
                                        $badgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                                    }
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold whitespace-nowrap inline-flex items-center border {{ $badgeClass }}">
                                    {{ $catLabel }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-slate-800">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-800 font-black border border-emerald-200">
                                    {{ $sb->passing_grade ?? 75 }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editMapel('{{ $sb->id }}', '{{ $sb->code }}', '{{ addslashes($sb->name) }}', '{{ $sb->category }}', '{{ $sb->passing_grade }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer"
                                            title="Edit Mapel">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.subjects.delete', $sb->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mapel {{ addslashes($sb->name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Mapel">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                Belum ada mata pelajaran yang dikonfigurasi untuk unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function openTambahMapelModal() {
            document.getElementById('titleModalMapel').innerText = 'Tambah Mata Pelajaran Baru';
            document.getElementById('input_subject_id').value = '';
            document.getElementById('input_subject_code').value = '';
            document.getElementById('input_subject_name').value = '';
            document.getElementById('input_subject_category').value = 'NASIONAL';
            document.getElementById('input_subject_kktp').value = '75';
            document.getElementById('modalTambahMapel').classList.remove('hidden');
        }

        function editMapel(id, code, name, category, kktp) {
            document.getElementById('titleModalMapel').innerText = 'Perbarui Mata Pelajaran';
            document.getElementById('input_subject_id').value = id;
            document.getElementById('input_subject_code').value = code;
            document.getElementById('input_subject_name').value = name;
            
            const catSelect = document.getElementById('input_subject_category');
            if (catSelect) {
                let matched = false;
                for (let i = 0; i < catSelect.options.length; i++) {
                    if (catSelect.options[i].value.toLowerCase() === (category || '').toLowerCase()) {
                        catSelect.selectedIndex = i;
                        matched = true;
                        break;
                    }
                }
                if (!matched) {
                    const u = (category || '').toUpperCase();
                    if (u.includes('NASIONAL') || u.includes('UMUM')) catSelect.value = 'NASIONAL';
                    else if (u.includes('JSIT') || u.includes('KHAS')) catSelect.value = 'KEKHASAN';
                    else if (u.includes('QURAN') || u.includes('TAHSIN') || u.includes('TAHFIDZ')) catSelect.value = 'QURAN';
                    else if (u.includes('MULOK') || u.includes('LOKAL')) catSelect.value = 'MULOK';
                    else catSelect.value = 'NASIONAL';
                }
            }

            document.getElementById('input_subject_kktp').value = kktp || 75;
            document.getElementById('modalTambahMapel').classList.remove('hidden');
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: TUJUAN PEMBELAJARAN (TP) - KURIKULUM MERDEKA -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'tp')
    <div class="space-y-6">
        <!-- Header Banner & Penjelasan Fungsi TP -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Kurikulum Merdeka Kemendikbudristek
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <span>🎯</span> <span>Tujuan Pembelajaran (TP) Mata Pelajaran</span>
                </h2>
                <p class="text-xs text-slate-600 max-w-3xl leading-relaxed">
                    <strong>Fungsi TP di e-Rapor:</strong> Tujuan Pembelajaran (TP) diturunkan dari Capaian Pembelajaran (CP) sebagai acuan penilaian formatif & sumatif. Ketercapaian TP oleh siswa digunakan oleh sistem untuk <em>menyusun narasi deskripsi capaian kompetensi tertinggi & terendah</em> pada rapor secara otomatis dan seragam.
                </p>
            </div>
            <div class="flex items-center gap-2.5 flex-wrap shrink-0">
                <form method="POST" action="{{ route('admin.academic.tp.seed') }}">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
                    <button type="submit" onclick="return confirm('Generate otomatis paket Tujuan Pembelajaran standar Kurikulum Merdeka untuk semua mata pelajaran di unit ini?')"
                            class="px-4 py-2.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-700 font-black text-xs flex items-center gap-2 transition cursor-pointer shadow-xs active:scale-95">
                        <span>⚡</span>
                        <span>Generate Paket TP Standar</span>
                    </button>
                </form>
                <button type="button" onclick="bukaModalTambahTp()"
                        class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition cursor-pointer shadow-sm active:scale-95">
                    <span>➕</span>
                    <span>Tambah TP Baru</span>
                </button>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="tp">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Filter Mata Pelajaran:</label>
                    <select name="subject_id" onchange="this.form.submit()" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                        <option value="">-- Semua Mata Pelajaran --</option>
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}" {{ request('subject_id') == $sb->id ? 'selected' : '' }}>
                                {{ $sb->name }} ({{ $sb->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tingkat Kelas / Fase:</label>
                    <select name="grade_level" onchange="this.form.submit()" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                        <option value="Semua">Semua Tingkat</option>
                        @if($isSmp)
                            <option value="Kelas 7" {{ request('grade_level') == 'Kelas 7' ? 'selected' : '' }}>Kelas 7 (Fase D)</option>
                            <option value="Kelas 8" {{ request('grade_level') == 'Kelas 8' ? 'selected' : '' }}>Kelas 8 (Fase D)</option>
                            <option value="Kelas 9" {{ request('grade_level') == 'Kelas 9' ? 'selected' : '' }}>Kelas 9 (Fase D)</option>
                        @else
                            <option value="Kelas 1" {{ request('grade_level') == 'Kelas 1' ? 'selected' : '' }}>Kelas 1 (Fase A)</option>
                            <option value="Kelas 2" {{ request('grade_level') == 'Kelas 2' ? 'selected' : '' }}>Kelas 2 (Fase A)</option>
                            <option value="Kelas 3" {{ request('grade_level') == 'Kelas 3' ? 'selected' : '' }}>Kelas 3 (Fase B)</option>
                            <option value="Kelas 4" {{ request('grade_level') == 'Kelas 4' ? 'selected' : '' }}>Kelas 4 (Fase B)</option>
                            <option value="Kelas 5" {{ request('grade_level') == 'Kelas 5' ? 'selected' : '' }}>Kelas 5 (Fase C)</option>
                            <option value="Kelas 6" {{ request('grade_level') == 'Kelas 6' ? 'selected' : '' }}>Kelas 6 (Fase C)</option>
                        @endif
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs transition">
                        🔍 Filter
                    </button>
                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp']) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Tabel Daftar TP -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                    <h3 class="font-black text-sm text-slate-900">
                        Daftar Tujuan Pembelajaran Aktif (Total: {{ ($learningObjectives ?? collect([]))->count() }} TP)
                    </h3>
                </div>
                <span class="text-xs font-bold text-slate-500">Tahun Ajaran: {{ $activeAcademicYear->name ?? '2025/2026' }} • Semester Genap</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-4 py-3 text-center min-w-[120px] whitespace-nowrap">Kode TP</th>
                            <th class="px-4 py-3 w-48">Mata Pelajaran</th>
                            <th class="px-4 py-3 min-w-[280px]">Ringkasan Capaian (Digunakan di Rapor)</th>
                            <th class="px-4 py-3 min-w-[320px]">Deskripsi Lengkap Tujuan Pembelajaran</th>
                            <th class="px-4 py-3 text-center w-24">Tingkat</th>
                            <th class="px-4 py-3 text-center w-24">Status</th>
                            <th class="px-4 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse(($learningObjectives ?? collect([])) as $tp)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap shrink-0">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-300 font-mono text-xs font-black text-emerald-800 whitespace-nowrap inline-block shadow-2xs">
                                    {{ $tp->code }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-bold text-slate-900 block">{{ $tp->subject->name ?? '-' }}</span>
                                <span class="text-[10px] text-slate-500 font-semibold font-mono">{{ $tp->subject->code ?? '' }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-extrabold text-slate-900 leading-snug">{{ $tp->short_desc }}</p>
                                <span class="text-[10px] text-emerald-700 font-bold">Auto-narasi rapor: "Menunjukkan penguasaan... dalam {{ $tp->short_desc }}"</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 leading-relaxed">
                                {{ $tp->description ?: $tp->short_desc }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $tp->grade_level ?: 'Semua' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($tp->is_active)
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px]">Non-aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <button type="button" onclick="editTp({{ json_encode($tp) }})"
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer"
                                            title="Edit TP">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.tp.delete', $tp->id) }}" onsubmit="return confirm('Hapus Tujuan Pembelajaran {{ $tp->code }}?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus TP">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-medium">
                                <div class="max-w-md mx-auto space-y-3">
                                    <div class="text-4xl">🎯</div>
                                    <h4 class="font-bold text-slate-800 text-sm">Belum Ada Tujuan Pembelajaran (TP)</h4>
                                    <p class="text-xs text-slate-500">
                                        Silakan klik tombol <strong>"Generate Paket TP Standar"</strong> di atas untuk membuat TP otomatis sesuai standar Kurikulum Merdeka Kemendikbudristek untuk semua mapel unit ini.
                                    </p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah / Edit Tujuan Pembelajaran (TP) -->
    <div id="modalTambahTp" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
        <div class="bg-white w-full max-w-xl rounded-2xl shadow-xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
            <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-lg">🎯</span>
                    <h3 class="font-bold text-sm" id="modalTpTitle">Tambah Tujuan Pembelajaran (TP)</h3>
                </div>
                <button type="button" onclick="tutupModalTambahTp()" class="text-slate-400 hover:text-white text-lg cursor-pointer">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.academic.tp.save') }}" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id ?? 1 }}">
                <input type="hidden" name="id" id="tp_id" value="">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Pilih Mata Pelajaran *</label>
                    <select name="subject_id" id="tp_subject_id" required class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}">{{ $sb->name }} ({{ $sb->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Kode TP *</label>
                        <input type="text" name="code" id="tp_code" required placeholder="Contoh: TP 1" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 p-2.5 uppercase focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Tingkat Kelas</label>
                        <select name="grade_level" id="tp_grade_level" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                            <option value="Semua">Semua Tingkat</option>
                            @if($isSmp)
                                <option value="Kelas 7">Kelas 7</option>
                                <option value="Kelas 8">Kelas 8</option>
                                <option value="Kelas 9">Kelas 9</option>
                            @else
                                <option value="Kelas 1">Kelas 1</option>
                                <option value="Kelas 2">Kelas 2</option>
                                <option value="Kelas 3">Kelas 3</option>
                                <option value="Kelas 4">Kelas 4</option>
                                <option value="Kelas 5">Kelas 5</option>
                                <option value="Kelas 6">Kelas 6</option>
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Urut</label>
                        <input type="number" name="order_number" id="tp_order_number" value="1" min="1" max="20" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">
                        Ringkasan Capaian TP (Digunakan dalam Kalimat Rapor) *
                    </label>
                    <input type="text" name="short_desc" id="tp_short_desc" required placeholder="Contoh: memahami konsep bilangan cacah dan nilai tempat" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                    <p class="text-[11px] text-slate-500 mt-1">
                        💡 <em>Tips Kurikulum Merdeka:</em> Gunakan kata kerja operasional bentuk pasif/aktif seperti: "memahami...", "menganalisis...", "mempraktikkan...", "menyajikan...".
                    </p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap Capaian Pembelajaran</label>
                    <textarea name="description" id="tp_description" rows="3" placeholder="Deskripsi lengkap tujuan pembelajaran dalam silabus/ATP..." class="w-full text-xs text-slate-800 rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 leading-relaxed"></textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                        <input type="checkbox" name="is_active" id="tp_is_active" value="1" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span>Aktifkan Tujuan Pembelajaran Ini</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="tutupModalTambahTp()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition cursor-pointer shadow-sm active:scale-95">
                            Simpan TP
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalTambahTp() {
            document.getElementById('modalTpTitle').innerText = 'Tambah Tujuan Pembelajaran (TP)';
            document.getElementById('tp_id').value = '';
            document.getElementById('tp_code').value = 'TP ';
            document.getElementById('tp_short_desc').value = '';
            document.getElementById('tp_description').value = '';
            document.getElementById('tp_order_number').value = '1';
            document.getElementById('tp_is_active').checked = true;
            document.getElementById('modalTambahTp').classList.remove('hidden');
        }

        function tutupModalTambahTp() {
            document.getElementById('modalTambahTp').classList.add('hidden');
        }

        function editTp(tp) {
            document.getElementById('modalTpTitle').innerText = 'Edit Tujuan Pembelajaran (' + tp.code + ')';
            document.getElementById('tp_id').value = tp.id;
            document.getElementById('tp_subject_id').value = tp.subject_id;
            document.getElementById('tp_code').value = tp.code;
            document.getElementById('tp_short_desc').value = tp.short_desc || '';
            document.getElementById('tp_description').value = tp.description || '';
            document.getElementById('tp_grade_level').value = tp.grade_level || 'Semua';
            document.getElementById('tp_order_number').value = tp.order_number || 1;
            document.getElementById('tp_is_active').checked = Boolean(tp.is_active);
            document.getElementById('modalTambahTp').classList.remove('hidden');
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: DATA EKSTRAKURIKULER (KEPSEK & OPERATOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'extracurriculars')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Ekstrakurikuler Unit
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Daftar Kegiatan Ekstrakurikuler
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Kelola kegiatan pengembangan bakat dan minat siswa serta pelatih/pembina penanggung jawab (Bab IV.F.7 e-Rapor SD).
                </p>
            </div>

            <button onclick="openTambahEkskulModal()" 
                    class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs flex items-center gap-2 shadow-xs transition cursor-pointer active:scale-95">
                <span>➕</span> <span>Tambah Ekskul Baru</span>
            </button>
        </div>

        <!-- Modal Tambah / Update Ekskul -->
        <div id="modalTambahEkskul" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>🥋</span> <span id="titleModalEkskul">Tambah / Edit Ekstrakurikuler</span>
                    </h3>
                    <button onclick="document.getElementById('modalTambahEkskul').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.extracurriculars.save') }}" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="id" id="input_ekskul_id" value="">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Ekstrakurikuler:</label>
                        <input type="text" name="name" id="input_ekskul_name" required placeholder="Contoh: Pramuka SIT, Panahan, Koding, Futsal..." 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Pembina / Pelatih:</label>
                        <input type="text" name="coach_name" id="input_ekskul_coach" placeholder="Contoh: Kak Dani / Ustadz Hasan..." 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Keterangan / Jadwal Latihan:</label>
                        <textarea name="description" id="input_ekskul_desc" rows="2" placeholder="Contoh: Setiap hari Sabtu pukul 08.00 - 10.00 WIB..." 
                                  class="w-full font-medium rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600"></textarea>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalTambahEkskul').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Simpan Ekstrakurikuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Ekskul -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="font-black text-sm text-slate-900">Daftar Ekstrakurikuler (Total: {{ $extracurriculars->count() }} Kegiatan)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3 w-56">Nama Ekstrakurikuler</th>
                            <th class="px-5 py-3 w-52">Pembina / Pelatih</th>
                            <th class="px-5 py-3">Keterangan / Jadwal</th>
                            <th class="px-5 py-3 text-center w-24">Status</th>
                            <th class="px-5 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($extracurriculars as $ek)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3.5 font-black text-slate-900 text-sm">
                                {{ $ek->name }}
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-700">
                                {{ $ek->coach_name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $ek->description ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editEkskul('{{ $ek->id }}', '{{ addslashes($ek->name) }}', '{{ addslashes($ek->coach_name ?? '') }}', '{{ addslashes($ek->description ?? '') }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer"
                                            title="Edit Ekskul">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.extracurriculars.delete', $ek->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekskul {{ addslashes($ek->name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Ekskul">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                Belum ada ekstrakurikuler yang ditambahkan pada unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function openTambahEkskulModal() {
            document.getElementById('titleModalEkskul').innerText = 'Tambah Ekstrakurikuler Baru';
            document.getElementById('input_ekskul_id').value = '';
            document.getElementById('input_ekskul_name').value = '';
            document.getElementById('input_ekskul_coach').value = '';
            document.getElementById('input_ekskul_desc').value = '';
            document.getElementById('modalTambahEkskul').classList.remove('hidden');
        }

        function editEkskul(id, name, coach, desc) {
            document.getElementById('titleModalEkskul').innerText = 'Perbarui Ekstrakurikuler';
            document.getElementById('input_ekskul_id').value = id;
            document.getElementById('input_ekskul_name').value = name;
            document.getElementById('input_ekskul_coach').value = coach;
            document.getElementById('input_ekskul_desc').value = desc;
            document.getElementById('modalTambahEkskul').classList.remove('hidden');
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU: DATA KO-KURIKULER & PROJEK P5 (KEPSEK & OPERATOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'p5')
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Ko-Kurikuler & P5
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">
                    Projek Penguatan Profil Pelajar Pancasila (P5)
                </h2>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    Pengelolaan tema projek, nama kegiatan, dan koordinator projek kokurikuler sesuai standar resmi e-Rapor SD (Bab IV.G & IV.I).
                </p>
            </div>

            <button onclick="openTambahP5Modal()" 
                    class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs flex items-center gap-2 shadow-xs transition cursor-pointer active:scale-95">
                <span>➕</span> <span>Tambah Projek P5</span>
            </button>
        </div>

        <!-- Modal Tambah / Update Projek P5 -->
        <div id="modalTambahP5" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>🌱</span> <span id="titleModalP5">Tambah / Edit Projek P5</span>
                    </h3>
                    <button onclick="document.getElementById('modalTambahP5').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.p5.save') }}" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                    <input type="hidden" name="id" id="input_p5_id" value="">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tema Projek P5 / Kemendikbud:</label>
                        <select name="theme" id="input_p5_theme" required class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                            <option value="Gaya Hidup Berkelanjutan">Gaya Hidup Berkelanjutan</option>
                            <option value="Kearifan Lokal">Kearifan Lokal</option>
                            <option value="Bhinneka Tunggal Ika">Bhinneka Tunggal Ika</option>
                            <option value="Bangunlah Jiwa dan Raganya">Bangunlah Jiwa dan Raganya</option>
                            <option value="Suara Demokrasi">Suara Demokrasi</option>
                            <option value="Rekayasa dan Teknologi">Rekayasa dan Teknologi</option>
                            <option value="Kewirausahaan">Kewirausahaan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul / Nama Kegiatan Projek:</label>
                        <input type="text" name="title" id="input_p5_title" required placeholder="Contoh: Pengolahan Sampah Organik Menjadi Kompos Berguna..." 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Koordinator Projek:</label>
                        <input type="text" name="coordinator_name" id="input_p5_coordinator" placeholder="Nama koordinator projek..." 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat Projek:</label>
                        <textarea name="description" id="input_p5_desc" rows="2" placeholder="Tujuan dan deskripsi kegiatan projek..." 
                                  class="w-full font-medium rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600"></textarea>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalTambahP5').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Simpan Projek P5
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table P5 -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h3 class="font-black text-sm text-slate-900">Daftar Projek P5 (Total: {{ $p5Projects->count() }} Projek)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3 w-52">Tema Projek</th>
                            <th class="px-5 py-3 font-bold">Judul Kegiatan Projek</th>
                            <th class="px-5 py-3 w-48">Koordinator</th>
                            <th class="px-5 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($p5Projects as $p5)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black">
                                    {{ $p5->theme }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="font-black text-slate-900 text-sm">{{ $p5->title }}</p>
                                <p class="text-[11px] text-slate-500 font-medium">{{ $p5->description ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-700">
                                {{ $p5->coordinator_name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editP5('{{ $p5->id }}', '{{ addslashes($p5->theme) }}', '{{ addslashes($p5->title) }}', '{{ addslashes($p5->coordinator_name ?? '') }}', '{{ addslashes($p5->description ?? '') }}')" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:border-amber-400 transition shadow-2xs cursor-pointer"
                                            title="Edit Projek P5">
                                        <span>✏️</span> <span>Edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.p5.delete', $p5->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus projek {{ addslashes($p5->title) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg border border-rose-300 bg-rose-50 text-rose-700 hover:bg-rose-100 hover:border-rose-400 transition shadow-2xs cursor-pointer" 
                                                title="Hapus Projek P5">
                                            <span>🗑️</span> <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Belum ada projek P5 / kokurikuler yang ditambahkan pada unit ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function openTambahP5Modal() {
            document.getElementById('titleModalP5').innerText = 'Tambah Projek P5 Baru';
            document.getElementById('input_p5_id').value = '';
            document.getElementById('input_p5_title').value = '';
            document.getElementById('input_p5_coordinator').value = '';
            document.getElementById('input_p5_desc').value = '';
            document.getElementById('modalTambahP5').classList.remove('hidden');
        }

        function editP5(id, theme, title, coordinator, desc) {
            document.getElementById('titleModalP5').innerText = 'Perbarui Projek P5';
            document.getElementById('input_p5_id').value = id;
            document.getElementById('input_p5_theme').value = theme;
            document.getElementById('input_p5_title').value = title;
            document.getElementById('input_p5_coordinator').value = coordinator;
            document.getElementById('input_p5_desc').value = desc;
            document.getElementById('modalTambahP5').classList.remove('hidden');
        }
    </script>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 2: NILAI MATA PELAJARAN (GURU MAPEL - SPREADSHEET INPUT 1 KELAS) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'academic')
    <div class="space-y-5">
        
        <!-- Filter Bar (Pilih Kelas & Mapel) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="academic">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">1. Pilih Rombel / Kelas:</label>
                    <select name="classroom_id" onchange="this.form.submit()" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                        @foreach($classrooms as $cls)
                            <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                                {{ $cls->name }} ({{ $cls->homeroomTeacher->name ?? 'Wali: -' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">2. Pilih Mata Pelajaran:</label>
                    <select name="subject_id" onchange="this.form.submit()" class="w-full text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600">
                        @foreach($subjects as $sb)
                            <option value="{{ $sb->id }}" {{ $selectedSubjectId == $sb->id ? 'selected' : '' }}>
                                {{ $sb->name }} ({{ $sb->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Tahun Ajaran & Semester:</label>
                    <div class="px-3 py-2 rounded-xl bg-slate-100 border border-slate-200 text-xs font-bold text-slate-700">
                        {{ $activeAcademicYear->name ?? '2026/2027' }} - {{ $activeAcademicYear->semester ?? 'Ganjil' }}
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Standar Capaian (KKTP):</label>
                    <div class="px-3 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-xs font-black text-emerald-800">
                        KKTP: 75 (Kurikulum Merdeka)
                    </div>
                </div>
            </form>
        </div>

        <!-- Gradebook Table Form (Batch Input All Students in Class) -->
        <form method="POST" action="{{ route('admin.academic.grades.batch.store') }}" id="batchGradeForm">
            @csrf
            <input type="hidden" name="school_id" value="{{ $schoolId }}">
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroomId }}">
            <input type="hidden" name="subject_id" value="{{ $selectedSubjectId }}">
            <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id ?? 1 }}">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <!-- Toolbar Header -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                            <h3 class="font-black text-sm text-slate-900">
                                Buku Nilai Kelas: <span class="text-emerald-700">{{ $selectedClassroom->name ?? 'Semua Kelas' }}</span>
                            </h3>
                        </div>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">
                            Mata Pelajaran: <strong>{{ $selectedSubject->name ?? 'Semua Mapel' }}</strong> • Total: {{ $classStudents->count() }} Siswa
                        </p>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button type="button" onclick="generateAllNarrativesAi()" 
                                class="px-3 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-700 font-bold text-xs flex items-center gap-1.5 transition cursor-pointer">
                            <span>✨</span> <span>Robbani AI Narasi Kelas</span>
                        </button>
                        <button type="button" onclick="autoGenerateAllDescriptions()" 
                                class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition cursor-pointer">
                            <span>⚡</span> <span>Template Otomatis</span>
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                            <span>💾</span> <span>SIMPAN SEMUA NILAI KELAS</span>
                        </button>
                    </div>
                </div>

                <!-- Banner Informasi Tujuan Pembelajaran (TP) Aktif di Rapor (Struktur Grid Rapi) -->
                <div class="px-6 py-4 bg-emerald-50/90 border-b border-emerald-200 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-2 border-b border-emerald-100">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-800 text-white font-black text-xs shadow-xs">
                                <span>🎯</span> <span>Tujuan Pembelajaran (TP) Aktif di Rapor:</span>
                            </span>
                            <span class="text-xs font-black text-emerald-950">
                                {{ $selectedSubject->name ?? 'Mata Pelajaran' }}
                            </span>
                            <button type="button" onclick="bukaModalPetunjukTp()" 
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-white hover:bg-emerald-100 border border-emerald-300 text-emerald-800 font-bold text-xs transition cursor-pointer shadow-2xs">
                                <span>ℹ️</span> <span>Info Petunjuk TP Rapor</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp', 'subject_id' => $selectedSubjectId]) }}" 
                               class="px-3 py-1.5 rounded-lg bg-white hover:bg-emerald-100 border border-emerald-300 text-emerald-800 text-xs font-black transition flex items-center gap-1.5 shadow-2xs">
                                <span>⚙️</span> <span>Kelola TP Mapel Ini</span>
                            </a>
                        </div>
                    </div>

                    <!-- Grid Kartu TP Aktif -->
                    @if(($activeLearningObjectives ?? collect())->isNotEmpty())
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5">
                            @foreach($activeLearningObjectives as $atp)
                                <div class="bg-white rounded-xl border border-emerald-200/90 p-2.5 shadow-2xs hover:border-emerald-400 hover:shadow-xs transition flex items-start gap-2.5" title="{{ $atp->description }}">
                                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-900 font-mono font-black text-[11px] shrink-0 border border-emerald-200 whitespace-nowrap inline-block">
                                        {{ $atp->code }}
                                    </span>
                                    <p class="text-xs font-bold text-slate-800 leading-snug line-clamp-2">
                                        {{ $atp->short_desc }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 bg-white/80 rounded-xl border border-dashed border-emerald-300 flex items-center justify-between text-xs text-slate-600">
                            <div class="flex items-center gap-2">
                                <span class="text-base">ℹ️</span>
                                <span>Belum ada Tujuan Pembelajaran (TP) yang diaktifkan untuk mata pelajaran ini.</span>
                            </div>
                            <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp', 'subject_id' => $selectedSubjectId]) }}" 
                               class="text-emerald-700 font-bold hover:underline">
                                Tambahkan TP sekarang &rarr;
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Spreadsheet Grid (Kompak Pas 1 Layar) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-3 py-2.5 text-center w-10">No</th>
                                <th class="px-3 py-2.5 w-44">Nama Lengkap & NIS</th>
                                <th class="px-2 py-2.5 text-center w-20">Formatif (TP)</th>
                                <th class="px-2 py-2.5 text-center w-20">Sumatif (SAS)</th>
                                <th class="px-2 py-2.5 text-center w-16">Nilai Akhir</th>
                                <th class="px-2 py-2.5 text-center w-24">Predikat</th>
                                <th class="px-3 py-2.5 min-w-[240px]">Deskripsi Capaian Kompetensi (Rapor)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $existing = $existingGrades->get($student->id);
                                $score = $existing ? $existing->score : null;
                                $displayScore = $score !== null ? ((float)$score == intval($score) ? intval($score) : $score) : '';
                                $tpScore = $existing && isset($existing->score_tp) ? $existing->score_tp : $displayScore;
                                $sasScore = $existing && isset($existing->score_sas) ? $existing->score_sas : $displayScore;
                                $notes = $existing ? $existing->notes : '';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 py-2.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2.5">
                                    <p class="font-black text-slate-900 text-xs leading-snug line-clamp-1">{{ $student->full_name }}</p>
                                    <p class="text-[10px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                                    <input type="hidden" name="grades[{{ $student->id }}][score]" id="score_{{ $student->id }}" value="{{ $displayScore }}">
                                </td>
                                
                                <!-- Input Nilai Formatif (TP) -->
                                <td class="px-2 py-2.5 text-center">
                                    <input type="number" min="0" max="100" step="any"
                                           name="grades[{{ $student->id }}][score_tp]" 
                                           id="tp_{{ $student->id }}" 
                                           value="{{ $tpScore }}" 
                                           placeholder="0"
                                           oninput="calcRow({{ $student->id }})"
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 px-1 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white">
                                </td>

                                <!-- Input Nilai Sumatif (SAS) -->
                                <td class="px-2 py-2.5 text-center">
                                    <input type="number" min="0" max="100" step="any"
                                           name="grades[{{ $student->id }}][score_sas]" 
                                           id="sas_{{ $student->id }}" 
                                           value="{{ $sasScore }}" 
                                           placeholder="0"
                                           oninput="calcRow({{ $student->id }})"
                                           class="w-16 text-center font-black text-xs rounded-lg border border-slate-300 py-1 px-1 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-emerald-50/40">
                                </td>

                                <!-- Nilai Akhir (Auto Calculated) -->
                                <td class="px-2 py-2.5 text-center">
                                    <span id="final_{{ $student->id }}" class="font-black text-xs text-slate-900 bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                        {{ $displayScore !== '' ? $displayScore : '-' }}
                                    </span>
                                </td>

                                <!-- Predikat Badge -->
                                <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                    @if($score !== null && $score !== '')
                                        <span id="pred_{{ $student->id }}" class="px-2 py-0.5 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center {{ $score >= 85 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : ($score >= 75 ? 'bg-blue-100 text-blue-800 border border-blue-300' : ($score >= 65 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-rose-100 text-rose-800 border border-rose-300')) }}">
                                            {{ $score >= 85 ? 'A (Istimewa)' : ($score >= 75 ? 'B (Baik)' : ($score >= 65 ? 'C (Cukup)' : 'D (Perlu Bimbingan)')) }}
                                        </span>
                                    @else
                                        <span id="pred_{{ $student->id }}" class="px-2 py-0.5 rounded-md text-[10px] font-bold text-slate-400 bg-slate-100 border border-slate-200 inline-flex items-center justify-center">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <!-- Narasi / Deskripsi Capaian Pembelajaran -->
                                <td class="px-3 py-2.5">
                                    <div class="flex items-center justify-between gap-1 mb-1">
                                        <span class="text-[10px] text-slate-500 font-bold">Narasi Capaian (CP/TP):</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="bukaModalPilihTp('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-black text-[10px] border border-emerald-300 transition cursor-pointer flex items-center gap-1"
                                                    title="Pilih Tujuan Pembelajaran yang dikuasai dan perlu bimbingan">
                                                <span>🎯 Pilih TP</span>
                                            </button>
                                            <button type="button" onclick="generateAiNarrativeSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-black text-[10px] border border-indigo-200 transition cursor-pointer flex items-center gap-1"
                                                    title="Generate narasi otomatis menggunakan Robbani AI">
                                                <span>✨ AI Narasi</span>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea name="grades[{{ $student->id }}][notes]" 
                                              id="notes_{{ $student->id }}" 
                                              rows="2" 
                                              placeholder="Pilih TP atau klik AI Narasi..."
                                              class="w-full text-xs text-slate-800 rounded-lg border border-slate-300 p-1.5 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white leading-relaxed resize-y">{{ $notes }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Tidak ada siswa di kelas yang dipilih. Silakan pilih kelas lain melalui filter di atas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Action Bar -->
                @if($classStudents->isNotEmpty())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-slate-500 font-semibold">
                        💡 Tips Guru: Masukkan angka nilai SAS (0-100), tekan tombol "Generate Narasi Otomatis" atau "🎯 Pilih TP", lalu klik "Simpan Semua Nilai Kelas".
                    </p>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN SEMUA NILAI KELAS</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

        <!-- MODAL PILIH CAPAIAN TUJUAN PEMBELAJARAN (TP) SESUAI STANDAR KURIKULUM MERDEKA -->
        <div id="modalPilihTp" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 max-h-[92vh] flex flex-col">
                <div class="px-6 py-4 bg-slate-900 text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">🎯</span>
                        <div>
                            <h3 class="font-black text-sm" id="modalPilihTpTitle">Pilih Capaian Tujuan Pembelajaran (TP)</h3>
                            <p class="text-[11px] text-slate-300 font-semibold" id="modalPilihTpSubtitle">Mata Pelajaran: {{ $selectedSubject->name ?? 'Mata Pelajaran' }}</p>
                        </div>
                    </div>
                    <button type="button" onclick="tutupModalPilihTp()" class="text-slate-400 hover:text-white text-xl cursor-pointer">&times;</button>
                </div>

                <div class="p-6 overflow-y-auto space-y-5 flex-1">
                    @if(($activeLearningObjectives ?? collect())->isEmpty())
                        <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs">
                            <p class="font-extrabold flex items-center gap-1.5 mb-1">
                                <span>⚠️</span> Belum Ada Tujuan Pembelajaran (TP) Terdaftar untuk Mapel Ini
                            </p>
                            <p class="text-amber-800 mb-3">
                                Anda dapat mengaktifkan atau generate paket TP standar terlebih dahulu di menu Tujuan Pembelajaran.
                            </p>
                            <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'tp', 'subject_id' => $selectedSubjectId]) }}" 
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition">
                                <span>🎯</span> Buka Pengaturan TP Sekarang
                            </a>
                        </div>
                    @else
                        <!-- TP Tertinggi / Dikuasai Baik -->
                        <div>
                            <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                                1. Tujuan Pembelajaran yang Dicapai Optimal (Sangat Baik):
                            </label>
                            <div class="space-y-2 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                                @foreach($activeLearningObjectives as $tp)
                                    <label class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-white border border-transparent hover:border-slate-200 transition cursor-pointer text-xs">
                                        <input type="checkbox" name="tp_optimal" value="{{ $tp->short_desc }}" onchange="updatePreviewKalimatTp()" class="mt-0.5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 tp-optimal-check" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="leading-relaxed">
                                            <strong class="text-emerald-800 font-extrabold mr-1 whitespace-nowrap font-mono inline-block">[{{ $tp->code }}]</strong>
                                            <span class="text-slate-800 font-bold">{{ $tp->short_desc }}</span>
                                            @if($tp->description && $tp->description !== $tp->short_desc)
                                                <p class="text-[11px] text-slate-500 mt-0.5">{{ Str::limit($tp->description, 100) }}</p>
                                            @endif
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- TP Terendah / Perlu Pendampingan -->
                        <div>
                            <label class="block text-xs font-black text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                2. Tujuan Pembelajaran yang Perlu Peningkatan / Pendampingan:
                            </label>
                            <div class="space-y-2 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                                <label class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-white border border-transparent hover:border-slate-200 transition cursor-pointer text-xs font-bold text-slate-700">
                                    <input type="radio" name="tp_need_help" value="" checked onchange="updatePreviewKalimatTp()" class="text-emerald-600 focus:ring-emerald-500 border-slate-300">
                                    <span>Tidak ada (Tuntas seluruh TP dengan optimal)</span>
                                </label>
                                @foreach($activeLearningObjectives as $tp)
                                    <label class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-white border border-transparent hover:border-slate-200 transition cursor-pointer text-xs">
                                        <input type="radio" name="tp_need_help" value="{{ $tp->short_desc }}" onchange="updatePreviewKalimatTp()" class="mt-0.5 text-amber-600 focus:ring-amber-500 border-slate-300">
                                        <div class="leading-relaxed">
                                            <strong class="text-amber-800 font-extrabold mr-1 whitespace-nowrap font-mono inline-block">[{{ $tp->code }}]</strong>
                                            <span class="text-slate-800 font-bold">{{ $tp->short_desc }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pratinjau Teks Rapor Otomatis -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                                    <span>📝</span> Pratinjau Kalimat Deskripsi Rapor:
                                </label>
                                <span class="text-[10px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    Standar Panduan e-Rapor Kemendikbud
                                </span>
                            </div>
                            <textarea id="previewKalimatTp" rows="3" class="w-full text-xs font-semibold text-slate-800 rounded-xl border border-slate-300 p-3 bg-slate-50 focus:bg-white focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 leading-relaxed"></textarea>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between shrink-0">
                    <button type="button" onclick="tutupModalPilihTp()" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-xs transition cursor-pointer">
                        Batal
                    </button>
                    @if(($activeLearningObjectives ?? collect())->isNotEmpty())
                        <button type="button" onclick="terapkanTpKeRapor()" class="px-5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition cursor-pointer shadow-md active:scale-95 flex items-center gap-1.5">
                            <span>✅</span> Terapkan ke Rapor Siswa
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- MODAL PETUNJUK RESMI PENILAIAN & TP KURIKULUM MERDEKA -->
        <div id="modalPetunjukTp" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200 max-h-[92vh] flex flex-col">
                <div class="px-6 py-4 bg-emerald-900 text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">📖</span>
                        <div>
                            <h3 class="font-black text-sm">Petunjuk Penilaian & Tujuan Pembelajaran (TP)</h3>
                            <p class="text-[11px] text-emerald-200 font-semibold">Standar Resmi Kurikulum Merdeka & Standar Mutu JSIT Indonesia</p>
                        </div>
                    </div>
                    <button type="button" onclick="tutupModalPetunjukTp()" class="text-emerald-300 hover:text-white text-xl cursor-pointer">&times;</button>
                </div>

                <div class="p-6 overflow-y-auto space-y-4 text-xs leading-relaxed text-slate-700 flex-1">
                    <div class="bg-emerald-50/80 p-4 rounded-2xl border border-emerald-200 space-y-2">
                        <h4 class="font-black text-emerald-950 flex items-center gap-2">
                            <span>1.</span> <span>Struktur Penilaian Mata Pelajaran</span>
                        </h4>
                        <ul class="list-disc pl-5 space-y-1 text-slate-700">
                            <li><strong>Nilai Formatif (TP):</strong> Diambil dari rata-rata asesmen proses capaian Tujuan Pembelajaran harian.</li>
                            <li><strong>Nilai Sumatif (SAS/SAT):</strong> Asesmen akhir semester untuk mengukur ketercapaian seluruh kompetensi.</li>
                            <li><strong>Nilai Akhir Rapor:</strong> Dihitung otomatis: <code>(Rata-rata Formatif + Sumatif SAS) / 2</code>.</li>
                        </ul>
                    </div>

                    <div class="bg-blue-50/80 p-4 rounded-2xl border border-blue-200 space-y-2">
                        <h4 class="font-black text-blue-950 flex items-center gap-2">
                            <span>2.</span> <span>Ketentuan Tujuan Pembelajaran (TP) Aktif</span>
                        </h4>
                        <ul class="list-disc pl-5 space-y-1 text-slate-700">
                            <li>Setiap mata pelajaran disarankan memiliki <strong>3 hingga 5 TP aktif</strong> per semester.</li>
                            <li>TP aktif akan ditampilkan pada ringkasan rapor dan menjadi dasar pemilihan kalimat capaian kompetensi siswa.</li>
                            <li>Gunakan tombol <strong>"Kelola TP Mapel Ini"</strong> untuk menambah, mengedit, atau menonaktifkan TP.</li>
                        </ul>
                    </div>

                    <div class="bg-purple-50/80 p-4 rounded-2xl border border-purple-200 space-y-2">
                        <h4 class="font-black text-purple-950 flex items-center gap-2">
                            <span>3.</span> <span>Penyusunan Narasi Capaian Rapor Siswa</span>
                        </h4>
                        <ul class="list-disc pl-5 space-y-1 text-slate-700">
                            <li>Format standar resmi memuat dua aspek utama: <strong>kompetensi tertinggi (dikuasai)</strong> dan <strong>kompetensi yang perlu ditingkatkan (bimbingan)</strong>.</li>
                            <li>Gunakan fitur <strong>"🎯 Pilih TP"</strong> pada tiap baris siswa untuk memilih otomatis, atau gunakan <strong>"✨ Robbani AI Narasi"</strong> untuk narasi pedagogis Islami otomatis.</li>
                        </ul>
                    </div>

                    <div class="bg-amber-50/80 p-4 rounded-2xl border border-amber-200 space-y-1.5">
                        <h4 class="font-black text-amber-950 flex items-center gap-2">
                            <span>💡</span> <span>Kekhasan Sekolah Islam Terpadu (SIT)</span>
                        </h4>
                        <p class="text-amber-900">
                            Selain capaian kognitif, lembar rapor SIT mencantumkan Evaluasi Al-Qur'an (Metode Wafa & Tahfidz) serta Radar Karakter 7 SKL JSIT yang terintegrasi langsung dalam modul ini.
                        </p>
                    </div>
                </div>

                <div class="px-6 py-3.5 bg-slate-50 border-t border-slate-200 flex justify-end shrink-0">
                    <button type="button" onclick="tutupModalPetunjukTp()" class="px-5 py-2 rounded-xl bg-emerald-800 hover:bg-emerald-900 text-white font-black text-xs transition cursor-pointer">
                        Saya Mengerti
                    </button>
                </div>
            </div>
        </div>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 3: NILAI AL-QUR'AN METODE WAFA & TAHFIDZ (GURU AL-QUR'AN) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'quran')
    <div class="space-y-5">
        
        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 flex-wrap">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="quran">

                <span class="text-xs font-bold text-slate-700">Pilih Kelas:</span>
                <select name="classroom_id" onchange="this.form.submit()" class="text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-teal-600 focus:ring-1 focus:ring-teal-600">
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="flex items-center gap-2 bg-teal-50 px-3 py-1.5 rounded-xl border border-teal-200 text-xs font-bold text-teal-900">
                <span>📖</span> <span>Metode Wafa: 5 Buku Tahsin, Irama Hijaz Wafa, & Ujian Tasmi' Sekali Duduk</span>
            </div>
        </div>

        <!-- Gradebook Wafa Form -->
        <form method="POST" action="{{ route('admin.academic.grades.quran.batch.store') }}">
            @csrf
            <input type="hidden" name="school_id" value="{{ $schoolId }}">
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroomId }}">
            <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id ?? 1 }}">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <!-- Toolbar Header -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-black text-sm text-slate-900">
                            Buku Nilai Al-Qur'an (Metode Wafa & Tahfidz) – {{ str_starts_with($selectedClassroom->name ?? '', 'Kelas') ? $selectedClassroom->name : 'Kelas ' . ($selectedClassroom->name ?? '') }}
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">
                            Penilaian Tahsin 4 Aspek (Makhraj, Tajwid, Lagu Hijaz, Adab) serta Evaluasi Target Ziyadah Tahfidz
                        </p>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap shrink-0">
                        @if($classStudents->isNotEmpty())
                        <button type="button" onclick="applyAllQuranTemplates()"
                                class="px-3 py-2 rounded-xl bg-teal-50 hover:bg-teal-100 border border-teal-300 text-teal-800 font-black text-xs flex items-center gap-1.5 transition cursor-pointer shadow-2xs"
                                title="Otomatis isi catatan Al-Qur'an semua siswa sesuai nilai makhraj, tajwid, dan jilid riil">
                            <span>📋</span> <span>Template Semua Siswa</span>
                        </button>
                        <button type="button" onclick="generateAllQuranAi()"
                                class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-300 text-emerald-800 font-black text-xs flex items-center gap-1.5 transition cursor-pointer shadow-2xs"
                                title="Generate evaluasi Al-Qur'an AI untuk semua siswa secara berurutan">
                            <span>✨</span> <span>AI Semua Siswa</span>
                        </button>
                        @endif
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95 whitespace-nowrap">
                            <span>💾</span> <span>SIMPAN NILAI AL-QUR'AN</span>
                        </button>
                    </div>
                </div>

                <!-- Table Grid (Kompak Pas 1 Layar) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-2.5 py-2.5 text-center w-10">No</th>
                                <th class="px-3 py-2.5 w-40">Nama Siswa</th>
                                <th class="px-2 py-2.5 w-32">Jilid Wafa & Hal</th>
                                <th class="px-1.5 py-2.5 text-center min-w-[64px] w-18">Makhraj</th>
                                <th class="px-1.5 py-2.5 text-center min-w-[64px] w-18">Tajwid</th>
                                <th class="px-1.5 py-2.5 text-center min-w-[64px] w-18">Hijaz</th>
                                <th class="px-1.5 py-2.5 text-center min-w-[64px] w-18">Adab</th>
                                <th class="px-2 py-2.5 w-36">Capaian Tahfidz</th>
                                <th class="px-2 py-2.5 w-32">Ujian Tasmi'</th>
                                <th class="px-3 py-2.5 min-w-[260px]">Catatan Ustadz Pengampu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $q = $existingQuran->get($student->id);
                                $scores = is_array($q?->tahsin_scores) ? $q->tahsin_scores : (json_decode($q?->tahsin_scores ?? '', true) ?: []);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-2.5 py-2.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2.5">
                                    <p class="font-black text-slate-900 text-xs leading-snug line-clamp-1">{{ $student->full_name }}</p>
                                    <p class="text-[10px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                                </td>
                                
                                <!-- Jilid Wafa -->
                                <td class="px-2 py-2.5">
                                    <input type="text" name="quran[{{ $student->id }}][tahsin_level]" 
                                           id="quran_level_{{ $student->id }}"
                                           value="{{ $q->tahsin_level ?? '' }}"
                                           placeholder="Buku Wafa 1-5 / Hal..."
                                           class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-2 focus:border-teal-600 bg-white">
                                </td>

                                <!-- 4 Aspek Wafa -->
                                <td class="px-1.5 py-2.5 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][makhraj]" 
                                           id="quran_makhraj_{{ $student->id }}"
                                           value="{{ $scores['makhraj'] ?? '' }}"
                                           placeholder="0"
                                           class="w-16 min-w-[56px] text-center font-bold text-xs rounded-lg border border-slate-300 py-1.5 focus:border-teal-600 bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-1.5 py-2.5 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][tajwid]" 
                                           id="quran_tajwid_{{ $student->id }}"
                                           value="{{ $scores['tajwid'] ?? '' }}"
                                           placeholder="0"
                                           class="w-16 min-w-[56px] text-center font-bold text-xs rounded-lg border border-slate-300 py-1.5 focus:border-teal-600 bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-1.5 py-2.5 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][lagu_hijaz]" 
                                           id="quran_hijaz_{{ $student->id }}"
                                           value="{{ $scores['lagu_hijaz'] ?? '' }}"
                                           placeholder="0"
                                           class="w-16 min-w-[56px] text-center font-bold text-xs rounded-lg border border-slate-300 py-1.5 focus:border-teal-600 bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-1.5 py-2.5 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][adab]" 
                                           id="quran_adab_{{ $student->id }}"
                                           value="{{ $scores['adab'] ?? '' }}"
                                           placeholder="0"
                                           class="w-16 min-w-[56px] text-center font-bold text-xs rounded-lg border border-slate-300 py-1.5 focus:border-teal-600 bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>

                                <!-- Tahfidz Achievement -->
                                <td class="px-2 py-2.5">
                                    <input type="text" name="quran[{{ $student->id }}][tahfidz_achievement]" 
                                           id="quran_tahfidz_{{ $student->id }}"
                                           value="{{ $q->tahfidz_achievement ?? '' }}"
                                           placeholder="Target Juz / Surat..."
                                           class="w-full text-xs font-semibold rounded-lg border border-slate-300 py-1 px-2 focus:border-teal-600 bg-white">
                                </td>

                                <!-- Ujian Tasmi' -->
                                <td class="px-2 py-2.5">
                                    <select name="quran[{{ $student->id }}][tasmi_exam_result]" 
                                            id="quran_tasmi_{{ $student->id }}"
                                            class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-1.5 focus:border-teal-600 bg-white">
                                        <option value="Belum Mengambil Ujian Tasmi'" {{ ($q->tasmi_exam_result ?? '') == 'Belum Mengambil Ujian Tasmi\'' || empty($q?->tasmi_exam_result) ? 'selected' : '' }}>Belum Tasmi'</option>
                                        <option value="Lulus Ujian Tasmi' Sekali Duduk Predikat Mumtaz" {{ ($q->tasmi_exam_result ?? '') == 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Mumtaz' ? 'selected' : '' }}>Lulus Mumtaz</option>
                                        <option value="Lulus Ujian Tasmi' Sekali Duduk Predikat Jayyid Jiddan" {{ ($q->tasmi_exam_result ?? '') == 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Jayyid Jiddan' ? 'selected' : '' }}>Lulus Jayyid Jiddan</option>
                                    </select>
                                </td>

                                <!-- Catatan Ustadz -->
                                <td class="px-3 py-2.5">
                                    <div class="flex items-center justify-between gap-1 mb-1">
                                        <span class="text-[10px] text-slate-500 font-bold">Catatan Pengampu:</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="applyQuranTemplateSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-teal-50 hover:bg-teal-100 text-teal-800 font-black text-[10px] border border-teal-200 transition cursor-pointer flex items-center gap-1"
                                                    title="Terapkan template evaluasi sesuai angka makhraj/tajwid baris ini">
                                                <span>📋 Template</span>
                                            </button>
                                            <button type="button" onclick="generateAiQuranSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-black text-[10px] border border-emerald-200 transition cursor-pointer flex items-center gap-1"
                                                    title="Generate evaluasi Al-Qur'an AI berbasis nilai makhraj, tajwid, dan tahfidz riil siswa">
                                                <span>✨ AI Evaluasi</span>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea rows="2" name="quran[{{ $student->id }}][tahsin_notes]" 
                                              id="quran_notes_{{ $student->id }}"
                                              placeholder="Catatan tahsin, makhraj, dan capaian..."
                                              class="w-full text-xs rounded-lg border border-slate-300 p-1.5 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 bg-white leading-relaxed resize-y">{{ $q->tahsin_notes ?? '' }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Tidak ada siswa di kelas yang dipilih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($classStudents->isNotEmpty())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-semibold">Total {{ $classStudents->count() }} Siswa siap dievaluasi</span>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-black text-xs flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN NILAI AL-QUR'AN KELAS</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 4: KARAKTER 7 SKL JSIT (PEMBINA BPI / GURU KARAKTER) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'character')
    <div class="space-y-5">
        
        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 flex-wrap">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="character">

                <span class="text-xs font-bold text-slate-700">Pilih Kelas:</span>
                <select name="classroom_id" onchange="this.form.submit()" class="text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600">
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="flex items-center gap-2 bg-indigo-50 px-3 py-1.5 rounded-xl border border-indigo-200 text-xs font-bold text-indigo-900">
                <span>🌙</span> <span>Standar 7 SKL JSIT: SB (Sangat Baik), B (Baik), MB (Mulai Berkembang), PB (Perlu Bimbingan)</span>
            </div>
        </div>

        <!-- Gradebook Character Form -->
        <form method="POST" action="{{ route('admin.academic.grades.character.batch.store') }}">
            @csrf
            <input type="hidden" name="school_id" value="{{ $schoolId }}">
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroomId }}">
            <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id ?? 1 }}">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-black text-sm text-slate-900">
                            Evaluasi Karakter 7 SKL JSIT & Bina Pribadi Islami (BPI) - Kelas {{ $selectedClassroom->name ?? '' }}
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">
                            Evaluasi 7 Standar Kompetensi Lulusan SIT dan Rekap Pembiasaan Ibadah Yaumiyah
                        </p>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap shrink-0">
                        @if($classStudents->isNotEmpty())
                        <button type="button" onclick="applyAllBpiTemplates()"
                                class="px-3 py-2 rounded-xl bg-indigo-50 hover:bg-indigo-100 border border-indigo-300 text-indigo-800 font-black text-xs flex items-center gap-1.5 transition cursor-pointer shadow-2xs"
                                title="Otomatis isi catatan semua siswa sesuai capaian 7 SKL masing-masing">
                            <span>📋</span> <span>Template Semua Siswa</span>
                        </button>
                        <button type="button" onclick="generateAllBpiAi()"
                                class="px-3 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 border border-purple-300 text-purple-800 font-black text-xs flex items-center gap-1.5 transition cursor-pointer shadow-2xs"
                                title="Generate evaluasi AI untuk semua siswa secara berurutan">
                            <span>✨</span> <span>AI Semua Siswa</span>
                        </button>
                        @endif
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                            <span>💾</span> <span>SIMPAN EVALUASI BPI</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="px-3 py-3 text-center w-10">No</th>
                                <th class="px-3 py-3 w-44">Nama Siswa</th>
                                <th class="px-2 py-3 text-center" title="1. Salimul Aqidah">1. Aqidah</th>
                                <th class="px-2 py-3 text-center" title="2. Shahihul Ibadah">2. Ibadah</th>
                                <th class="px-2 py-3 text-center" title="3. Matinul Khuluq">3. Akhlak</th>
                                <th class="px-2 py-3 text-center" title="4. Qowiyyul Jismi">4. Fisik</th>
                                <th class="px-2 py-3 text-center" title="5. Mutsaqqoful Fikri">5. Wawasan</th>
                                <th class="px-2 py-3 text-center" title="6. Qodirun 'alal Kasbi">6. Mandiri</th>
                                <th class="px-2 py-3 text-center" title="7. Munazzhomun">7. Disiplin</th>
                                <th class="px-3 py-3 w-40">Shalat Fardhu</th>
                                <th class="px-4 py-3 min-w-[360px]">Catatan Pembina BPI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $c = $existingCharacter->get($student->id);
                                $ind = $c->indicator_scores ?? [];
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-3 py-3">
                                    <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $student->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                                </td>

                                <!-- 7 SKL Selects -->
                                @php
                                    $sklFields = [
                                        'salimul_aqidah' => 'Aqidah',
                                        'shahihul_ibadah' => 'Ibadah',
                                        'matinul_khuluq' => 'Akhlak',
                                        'qowiyyul_jismi' => 'Fisik',
                                        'mutsaqqoful_fikri' => 'Wawasan',
                                        'qodirun_alal_kasbi' => 'Mandiri',
                                        'munazzhomun' => 'Disiplin',
                                    ];
                                @endphp

                                @foreach($sklFields as $sklKey => $sklLabel)
                                <td class="px-2 py-3 text-center">
                                    <select name="character[{{ $student->id }}][indicators][{{ $sklKey }}]" 
                                            id="skl_{{ $student->id }}_{{ $sklKey }}"
                                            class="text-xs font-black rounded-lg border border-slate-300 py-1 px-1 bg-white text-center focus:border-indigo-600">
                                        <option value="SB" {{ ($ind[$sklKey] ?? 'SB') == 'SB' ? 'selected' : '' }}>SB</option>
                                        <option value="B" {{ ($ind[$sklKey] ?? '') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="MB" {{ ($ind[$sklKey] ?? '') == 'MB' ? 'selected' : '' }}>MB</option>
                                        <option value="PB" {{ ($ind[$sklKey] ?? '') == 'PB' ? 'selected' : '' }}>PB</option>
                                    </select>
                                </td>
                                @endforeach

                                <td class="px-3 py-3">
                                    <select name="character[{{ $student->id }}][mutabaah_sholat_fardhu]" 
                                            id="sholat_{{ $student->id }}"
                                            class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-2 focus:border-indigo-600 bg-white">
                                        <option value="Selalu Berjamaah di Masjid" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Selalu Berjamaah di Masjid' ? 'selected' : '' }}>Selalu Berjamaah</option>
                                        <option value="Sering Berjamaah" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Sering Berjamaah' ? 'selected' : '' }}>Sering Berjamaah</option>
                                        <option value="Perlu Pembiasaan" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Perlu Pembiasaan' ? 'selected' : '' }}>Perlu Pembiasaan</option>
                                    </select>
                                </td>

                                <td class="px-4 py-3 min-w-[360px]">
                                    <div class="flex items-center justify-between gap-1 mb-1.5">
                                        <span class="text-[10px] text-slate-500 font-bold">Catatan Perkembangan Karakter:</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="applyBpiTemplateSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-indigo-50 hover:bg-indigo-100 text-indigo-800 font-black text-[10px] border border-indigo-200 transition cursor-pointer flex items-center gap-1"
                                                    title="Terapkan template deskripsi sesuai nilai 7 SKL baris ini">
                                                <span>📋 Template</span>
                                            </button>
                                            <button type="button" onclick="generateAiBpiSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-purple-50 hover:bg-purple-100 text-purple-700 font-black text-[10px] border border-purple-200 transition cursor-pointer flex items-center gap-1"
                                                    title="Generate catatan BPI menggunakan kecerdasan buatan berbasis nilai riil 7 SKL">
                                                <span>✨ AI BPI</span>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea name="character[{{ $student->id }}][bpi_mentor_notes]" 
                                              id="bpi_notes_{{ $student->id }}"
                                              rows="2"
                                              placeholder="Klik '📋 Template' atau '✨ AI BPI' untuk mengisi deskripsi sesuai nilai siswa..."
                                              class="w-full text-xs font-medium text-slate-800 rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 leading-relaxed shadow-2xs resize-y">{{ $c->bpi_mentor_notes ?? '' }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Tidak ada siswa di kelas yang dipilih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($classStudents->isNotEmpty())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-semibold">Total {{ $classStudents->count() }} Siswa</span>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white font-black text-xs flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN EVALUASI KARAKTER KELAS</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 5: MENU WALI KELAS (PRESENSI, FISIK & CATATAN RAPOR) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'homeroom')
    <div class="space-y-5">
        
        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 flex-wrap">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="homeroom">

                <span class="text-xs font-bold text-slate-700">Pilih Kelas Binaan:</span>
                <select name="classroom_id" onchange="this.form.submit()" class="text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} ({{ $cls->homeroomTeacher->name ?? 'Wali: -' }})
                        </option>
                    @endforeach
                </select>
            </form>

            <div class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-xl border border-blue-200 text-xs font-bold text-blue-900">
                <span>📋</span> <span>Wali Kelas bertanggung jawab atas data Presensi (S/I/A), Fisik (TB/BB), dan Catatan Akhir Rapor</span>
            </div>
        </div>

        <!-- Gradebook Homeroom Form -->
        <form method="POST" action="{{ route('admin.academic.grades.homeroom.batch.store') }}">
            @csrf
            <input type="hidden" name="school_id" value="{{ $schoolId }}">
            <input type="hidden" name="classroom_id" value="{{ $selectedClassroomId }}">
            <input type="hidden" name="academic_year_id" value="{{ $activeAcademicYear->id ?? 1 }}">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-black text-sm text-slate-900">
                            Rekap Kehadiran, Fisik & Catatan Wali Kelas - {{ $selectedClassroom->name ?? '' }}
                        </h3>
                        <p class="text-xs text-slate-500 font-semibold mt-0.5">
                            Wali Kelas: <strong>{{ $selectedClassroom->homeroomTeacher->name ?? 'Ustadz / Ustadzah' }}</strong>
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="applyAllHomeroomTemplates()"
                                class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-black text-xs border border-emerald-200 transition cursor-pointer flex items-center gap-1.5 active:scale-95" title="Generate narasi catatan berbasis kehadiran & karakter otomatis untuk semua siswa">
                            <span>⚡</span> <span>Template Otomatis Semua</span>
                        </button>
                        <button type="button" onclick="generateAllHomeroomAi()"
                                class="px-3 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 font-black text-xs border border-purple-200 transition cursor-pointer flex items-center gap-1.5 active:scale-95" title="Generate narasi motivasi AI untuk semua siswa">
                            <span>✨</span> <span>AI Motivasi Semua</span>
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                            <span>💾</span> <span>SIMPAN REKAP WALI KELAS</span>
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="px-3 py-3 text-center w-10">No</th>
                                <th class="px-3 py-3 w-48">Nama Siswa</th>
                                <th class="px-2 py-3 text-center w-20 min-w-[70px]" title="Sakit (Hari)">S</th>
                                <th class="px-2 py-3 text-center w-20 min-w-[70px]" title="Izin (Hari)">I</th>
                                <th class="px-2 py-3 text-center w-20 min-w-[70px]" title="Alpa / Tanpa Keterangan">A</th>
                                <th class="px-2 py-3 text-center w-24 min-w-[85px]">TB (cm)</th>
                                <th class="px-2 py-3 text-center w-24 min-w-[85px]">BB (kg)</th>
                                <th class="px-3 py-3 min-w-[170px]">Ekstrakurikuler</th>
                                <th class="px-4 py-3 min-w-[360px]">Catatan Perkembangan & Motivasi Wali Kelas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $hr = $existingHomeroom->get($student->id);
                                $ekskul = $hr->extracurriculars[0]['name'] ?? 'Pramuka SIT';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-3 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-3 py-3">
                                    <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $student->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                                </td>

                                <!-- S / I / A (Wider boxes with disabled spinners to prevent truncation) -->
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][sick_count]" 
                                           id="sick_{{ $student->id }}"
                                           value="{{ $hr->sick_count ?? 0 }}" 
                                           class="w-16 min-w-[58px] text-center font-black text-xs rounded-xl border border-slate-300 px-1 py-1.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][permission_count]" 
                                           id="permission_{{ $student->id }}"
                                           value="{{ $hr->permission_count ?? 0 }}" 
                                           class="w-16 min-w-[58px] text-center font-black text-xs rounded-xl border border-slate-300 px-1 py-1.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][absent_count]" 
                                           id="absent_{{ $student->id }}"
                                           value="{{ $hr->absent_count ?? 0 }}" 
                                           class="w-16 min-w-[58px] text-center font-black text-xs rounded-xl border border-slate-300 px-1 py-1.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>

                                <!-- TB / BB (Wider boxes for 3-digit decimals) -->
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" name="homeroom[{{ $student->id }}][height_cm]" 
                                           value="{{ $hr->height_cm ?? 148.5 }}" 
                                           class="w-20 min-w-[76px] text-center font-bold text-xs rounded-xl border border-slate-300 px-1.5 py-1.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" name="homeroom[{{ $student->id }}][weight_kg]" 
                                           value="{{ $hr->weight_kg ?? 41.5 }}" 
                                           class="w-20 min-w-[76px] text-center font-bold text-xs rounded-xl border border-slate-300 px-1.5 py-1.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 shadow-2xs [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </td>

                                <!-- Ekskul -->
                                <td class="px-3 py-3 min-w-[170px]">
                                    <input type="text" name="homeroom[{{ $student->id }}][ekskul_name]" 
                                           value="{{ $ekskul }}" 
                                           placeholder="Nama Ekskul"
                                           class="w-full text-xs font-semibold rounded-lg border border-slate-300 py-1.5 px-2 focus:border-blue-600 bg-white shadow-2xs">
                                </td>

                                <!-- Catatan Wali Kelas -->
                                <td class="px-4 py-3 min-w-[360px]">
                                    <div class="flex items-center justify-between gap-1 mb-1.5">
                                        <span class="text-[10px] text-slate-500 font-bold">Catatan Perkembangan & Motivasi:</span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" onclick="applyHomeroomTemplateSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-black text-[10px] border border-emerald-200 transition cursor-pointer flex items-center gap-1" title="Template Narasi Presensi & Karakter Otomatis">
                                                <span>⚡ Template</span>
                                            </button>
                                            <button type="button" onclick="generateAiHomeroomSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                    class="px-2 py-0.5 rounded-md bg-purple-50 hover:bg-purple-100 text-purple-700 font-black text-[10px] border border-purple-200 transition cursor-pointer flex items-center gap-1">
                                                <span>✨ AI Motivasi</span>
                                            </button>
                                        </div>
                                    </div>
                                    <textarea name="homeroom[{{ $student->id }}][notes]" rows="3" 
                                              id="homeroom_notes_{{ $student->id }}"
                                              placeholder="Catatan perkembangan karakter dan motivasi belajar ananda..."
                                              class="w-full text-xs font-medium text-slate-800 rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600 leading-relaxed shadow-2xs resize-y">{{ $hr->notes ?? 'Pertahankan semangat belajar dan prestasi ananda. Tingkatkan ketekunan dalam mengeksplorasi ilmu baru serta istiqomah dalam ibadah yaumiyah.' }}</textarea>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    Tidak ada siswa di kelas yang dipilih.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($classStudents->isNotEmpty())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-semibold">Total {{ $classStudents->count() }} Siswa</span>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-black text-xs flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN REKAP WALI KELAS</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 6: PUSAT CETAK RAPOR & LEGER (PILIHAN GABUNGAN & TERPISAH) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'print')
    <div class="space-y-5">
        
        <!-- Filter Bar & Leger Print Button -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.academic.grades') }}" class="flex items-center gap-3 flex-wrap">
                <input type="hidden" name="school_id" value="{{ $schoolId }}">
                <input type="hidden" name="menu" value="print">

                <span class="text-xs font-bold text-slate-700">Pilih Kelas:</span>
                <select name="classroom_id" onchange="this.form.submit()" class="text-xs font-bold text-slate-800 rounded-xl border border-slate-300 px-3 py-2 bg-slate-50 focus:bg-white focus:border-purple-600 focus:ring-1 focus:ring-purple-600">
                    @foreach($classrooms as $cls)
                        <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                            {{ $cls->name }} ({{ $cls->homeroomTeacher->name ?? 'Wali: -' }})
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Big Leger Print Button -->
            <!-- Leger & Word Action Buttons (Cetak PDF, Download Excel, Download Word 1 Kelas) -->
            @if($classStudents->isNotEmpty())
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.academic.report-card', [$classStudents->first()->id, 'type' => 'leger']) }}" 
                   target="_blank"
                   class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                    <span>📊</span> <span>CETAK LEGER NILAI (PDF)</span>
                </a>
                <a href="{{ route('admin.academic.leger.export', ['classroom_id' => $selectedClassroomId]) }}" 
                   class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                    <span>📥</span> <span>DOWNLOAD LEGER (EXCEL)</span>
                </a>
                <a href="{{ route('admin.academic.classrooms.report-card.word', $selectedClassroomId) }}" 
                   class="px-4 py-2.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95"
                   title="Download Seluruh Rapor Siswa Kelas Ini dalam Format Word (.doc) yang Siap Diedit Manual">
                    <span>📝</span> <span>DOWNLOAD WORD 1 KELAS (.DOC)</span>
                </a>
            </div>
            @endif
        </div>

        <!-- Student Print Checklist Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                <h3 class="font-black text-sm text-slate-900">
                    Daftar Siswa & Status Kelayakan Cetak Rapor - {{ $selectedClassroom->name ?? '' }}
                </h3>
                <p class="text-xs text-slate-500 font-semibold mt-0.5">
                    Pilih opsi <strong>Rapor Gabungan (All-in-One)</strong> untuk mencetak buku rapor lengkap, atau opsi <strong>Word (.doc)</strong> untuk mengedit manual.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-4 py-3 w-56">Nama Siswa & NIS</th>
                            <th class="px-4 py-3 text-center">Nilai Mapel</th>
                            <th class="px-4 py-3 text-center">Wafa</th>
                            <th class="px-4 py-3 text-center">Karakter</th>
                            <th class="px-4 py-3 text-center">Wali Kelas</th>
                            <th class="px-4 py-3 text-center">Status Rapor</th>
                            <th class="px-4 py-3 text-center min-w-[380px]">Aksi Cetak & Unduh Dokumen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800">
                        @forelse($classStudents as $student)
                        @php
                            $stReady = $printReadiness[$student->id] ?? ['mapel' => true, 'quran' => true, 'character' => true, 'homeroom' => true, 'is_ready' => true];
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3.5">
                                <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $student->full_name }}</p>
                                <p class="text-[11px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if($stReady['mapel'])
                                     <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Lengkap</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-extrabold">⏳ Belum</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if($stReady['quran'])
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-extrabold">⏳ Belum</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if($stReady['character'])
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-extrabold">⏳ Belum</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                @if($stReady['homeroom'])
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-800 text-[10px] font-extrabold">⏳ Belum</span>
                                @endif
                            </td>

                            <td class="px-4 py-3.5 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-900">
                                    🟢 Siap Cetak
                                </span>
                            </td>

                            <!-- Action Buttons in One Crisp Horizontal Row -->
                            <td class="px-4 py-3.5 text-center min-w-[380px] whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5 flex-wrap">
                                    <!-- 1. All in One PDF -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'all_in_one']) }}" 
                                       target="_blank"
                                       class="px-2.5 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition shadow-2xs inline-flex items-center gap-1">
                                        <span>🖨️</span> <span>Gabungan</span>
                                    </a>

                                    <!-- 2. Download Word (.doc) -->
                                    <a href="{{ route('admin.academic.report-card.word', $student->id) }}" 
                                       title="Download e-Rapor Microsoft Word (.doc) yang dapat diedit manual"
                                       class="px-2.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-2xs inline-flex items-center gap-1">
                                        <span>📝</span> <span>Word (.doc)</span>
                                    </a>

                                    <!-- 3. Akademik Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'academic']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Mata Pelajaran"
                                       class="px-2 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
                                        Akademik
                                    </a>

                                    <!-- 4. Wafa Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'quran']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Al-Qur'an Wafa & Tahfidz"
                                       class="px-2 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
                                        Wafa
                                    </a>

                                    <!-- 5. Karakter Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'character']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Karakter JSIT & BPI"
                                       class="px-2 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
                                        Karakter
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-slate-500 font-medium">
                                Tidak ada siswa di kelas yang dipilih.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @endif

    <!-- ========================================================================= -->
    <!-- MENU 7: PENGATURAN KOP SURAT, LOGO, DAN TANDA TANGAN (TANPA FORM DUPLIKAT) -->
    <!-- ========================================================================= -->
    @if(($activeMenu ?? '') === 'settings')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Settings Form -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
            <div class="border-b border-slate-200 pb-4">
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Pengaturan Cetak Dokumen Rapor
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[11px] font-bold">
                        Unit: {{ $activeSchool->name ?? 'SIT Robbani' }}
                    </span>
                </div>
                <h3 class="font-black text-lg text-slate-900">Upload Gambar Kop Surat & Tanda Tangan Resmi</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Unggah gambar kop surat resmi yayasan, stempel, dan tanda tangan digital kepala sekolah. Format gambar kop surat akan langsung dicetak pada lembar rapor siswa.
                </p>
            </div>

            <form method="POST" action="{{ route('admin.academic.grades.settings.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="school_id" value="{{ $schoolId }}">

                <!-- 1. GAMBAR KOP SURAT UTAMA (UTAMA & WAJIB DIGUNAKAN CETAK) -->
                <div class="p-4 bg-emerald-50/60 rounded-2xl border-2 border-emerald-200/80 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <label class="block text-xs font-black text-emerald-950 uppercase tracking-wide">
                                🖼️ 1. Gambar Banner Kop Surat Resmi Sekolah / Yayasan
                            </label>
                            <p class="text-[11px] text-emerald-800 font-medium mt-0.5">
                                Cukup upload gambar kop surat resmi (PNG/JPG). Kop surat ini otomatis digunakan pada bagian atas cetakan seluruh rapor siswa.
                            </p>
                        </div>
                        <span class="px-2 py-0.5 rounded-md bg-emerald-700 text-white font-extrabold text-[10px] uppercase shrink-0">
                            Digunakan Rapor
                        </span>
                    </div>

                    @if(!empty($reportSetting?->kop_image_url))
                        <div class="p-3 bg-white rounded-xl border border-emerald-300/80 shadow-xs space-y-2">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="font-bold text-emerald-900 flex items-center gap-1.5">
                                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-600"></span> Kop Surat Aktif:
                                </span>
                                <span class="font-mono text-slate-500 text-[10px] truncate max-w-xs">{{ $reportSetting->kop_image_url }}</span>
                            </div>
                            <div class="bg-slate-50 p-2 rounded-lg border border-slate-200 flex items-center justify-center max-h-28 overflow-hidden">
                                <img src="{{ asset($reportSetting->kop_image_url) }}" class="max-h-24 w-auto object-contain" alt="Kop Surat Aktif">
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih Berkas Gambar Kop Baru (PNG/JPG/WebP):</label>
                        <input type="file" name="kop_image_file" accept="image/png,image/jpeg,image/webp" id="input_kop_file"
                               onchange="previewKopImage(this)"
                               class="w-full text-xs file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 border border-slate-300 rounded-xl p-1.5 bg-white cursor-pointer shadow-2xs">
                        <p class="text-[10px] text-slate-500 mt-1">Ukuran rekomendasi: Lebar 1200px - 2400px (Rasio banner kop A4).</p>
                    </div>
                </div>

                @php
                    $isTkSchool = !empty($activeSchool) && (
                        str_contains(strtolower($activeSchool->name ?? ''), 'tk') || 
                        str_contains(strtolower($activeSchool->level ?? ''), 'tk') ||
                        str_contains(strtolower($activeSchool->name ?? ''), 'paud')
                    );
                    $defaultAccreditation = $reportSetting?->accreditation ?: ($isTkSchool ? 'Terakreditasi A (BAN-PAUD)' : 'Terakreditasi B (BAN-S/M)');
                    $defaultNssNds = $reportSetting?->nss_nds ?: ($isTkSchool ? '-' : '102110304001');
                    $currentSigMode = $reportSetting?->signature_mode ?: 'both';
                @endphp

                <!-- 2. TITIMANGSA & AKREDITASI RAPOR -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kota Titimangsa Rapor:</label>
                        <input type="text" name="report_city" id="setting_city" 
                               value="{{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Titimangsa Pembagian:</label>
                        <input type="text" name="report_date" id="setting_date" 
                               value="{{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                </div>

                <!-- AKREDITASI & IDENTITAS NSS/NDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Status Akreditasi Sekolah (Profil & Cover):</label>
                        <input type="text" name="accreditation" id="setting_accreditation" 
                               value="{{ $defaultAccreditation }}"
                               placeholder="Contoh: Terakreditasi B (BAN-S/M) atau Terakreditasi A"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                        <p class="text-[10px] text-slate-500 mt-1">Standar: SD & SMP = Terakreditasi B, TK = Terakreditasi A. Bisa diedit bebas.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">NSS / NDS Satuan Pendidikan:</label>
                        <input type="text" name="nss_nds" id="setting_nss_nds" 
                               value="{{ $defaultNssNds }}"
                               placeholder="Contoh: 102110304001"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                        <p class="text-[10px] text-slate-500 mt-1">Dicetak pada Lembar 2 Profil Satuan Pendidikan.</p>
                    </div>
                </div>

                <!-- 3. DATA PENANDATANGAN KEPALA SEKOLAH -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kepala Sekolah / Penandatangan:</label>
                        <input type="text" name="principal_name" id="setting_principal" 
                               value="{{ $reportSetting->principal_name ?? ($activeSchool->principal_name ?? 'Nur Amalia, S.Pd., Gr') }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">NIP / NIY Kepala Sekolah:</label>
                        <input type="text" name="principal_nip" id="setting_nip" 
                               value="{{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                </div>

                <!-- 4. UPLOAD BERKAS PENDUKUNG (STEMPEL & TANDA TANGAN) -->
                <div class="pt-3 border-t border-slate-200 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span>🖋️</span> <span>Pengaturan Stempel & Tanda Tangan Digital</span>
                        </h4>
                    </div>

                    <!-- Pilihan Mode Tanda Tangan & Cap (Mencegah Stempel Menimpa / Dobel) -->
                    <div class="p-3.5 bg-blue-50/70 rounded-xl border border-blue-200 space-y-2">
                        <label class="block text-xs font-black text-blue-950">
                            ⚙️ Pilihan Mode Tanda Tangan & Cap Stempel pada Rapor:
                        </label>
                        <select name="signature_mode" id="setting_sig_mode" onchange="updatePreviewSigMode(this.value)"
                                class="w-full text-xs font-bold text-slate-800 rounded-xl border border-blue-300 p-2.5 bg-white focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                            <option value="ttd_has_stamp" {{ $currentSigMode === 'ttd_has_stamp' ? 'selected' : '' }}>
                                🌟 File Tanda Tangan Sudah Berisi Cap/Stempel (Sembunyikan Stempel Digital Otomatis)
                            </option>
                            <option value="both" {{ $currentSigMode === 'both' ? 'selected' : '' }}>
                                Tampilkan Stempel Digital & Tanda Tangan Digital Terpisah (Default)
                            </option>
                            <option value="ttd_only" {{ $currentSigMode === 'ttd_only' ? 'selected' : '' }}>
                                Hanya Tanda Tangan Digital (Kosongkan / Sembunyikan Stempel)
                            </option>
                            <option value="stamp_only" {{ $currentSigMode === 'stamp_only' ? 'selected' : '' }}>
                                Hanya Stempel Digital (Kosongkan / Sembunyikan Tanda Tangan)
                            </option>
                            <option value="none" {{ $currentSigMode === 'none' ? 'selected' : '' }}>
                                Kosongkan Keduanya (Untuk Ditandatangani & Dicap Basah Manual)
                            </option>
                        </select>
                        <p class="text-[11px] text-blue-800 leading-relaxed">
                            💡 <b>Gunakan opsi pertama</b> jika file scan tanda tangan Anda sudah menyatu dengan cap stempel sekolah, agar tidak terjadi stempel ganda yang saling menimpa.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Stempel Resmi Sekolah -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Stempel Resmi Sekolah (PNG Transparan):</label>
                            @if(!empty($reportSetting?->stamp_image_url))
                                <div class="flex items-center justify-between gap-2 p-2 bg-white rounded-lg border border-slate-200">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-10 w-auto object-contain" alt="Stempel">
                                        <div class="text-[10px] text-slate-600 truncate">
                                            <span class="font-bold text-emerald-700">Aktif:</span> {{ basename($reportSetting->stamp_image_url) }}
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center gap-1 text-[10px] text-rose-600 font-bold shrink-0 cursor-pointer">
                                        <input type="checkbox" name="clear_stamp" value="1" class="rounded text-rose-600">
                                        <span>Hapus/Kosongkan</span>
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="stamp_image_file" accept="image/png,image/webp" 
                                   class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                            <p class="text-[10px] text-slate-500">Gunakan PNG dengan background transparan. Bisa dikosongkan jika tidak diperlukan.</p>
                        </div>

                        <!-- Tanda Tangan Digital Kepala Sekolah -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Tanda Tangan Kepala Sekolah (PNG Transparan):</label>
                            @if(!empty($reportSetting?->principal_signature_url))
                                <div class="flex items-center justify-between gap-2 p-2 bg-white rounded-lg border border-slate-200">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-10 w-auto object-contain" alt="TTD">
                                        <div class="text-[10px] text-slate-600 truncate">
                                            <span class="font-bold text-emerald-700">Aktif:</span> {{ basename($reportSetting->principal_signature_url) }}
                                        </div>
                                    </div>
                                    <label class="inline-flex items-center gap-1 text-[10px] text-rose-600 font-bold shrink-0 cursor-pointer">
                                        <input type="checkbox" name="clear_signature" value="1" class="rounded text-rose-600">
                                        <span>Hapus/Kosongkan</span>
                                    </label>
                                </div>
                            @endif
                            <input type="file" name="principal_signature_file" accept="image/png,image/webp" 
                                   class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                            <p class="text-[10px] text-slate-500">Gunakan PNG dengan background transparan. Bisa dikosongkan jika tidak diperlukan.</p>
                        </div>
                    </div>

                    <!-- Logo Cover Depan e-Rapor -->
                    <div class="p-3.5 bg-emerald-50/60 rounded-xl border border-emerald-300 space-y-2">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <label class="block text-xs font-black text-emerald-950 uppercase">🖼️ 2. Logo Resmi Sekolah / Yayasan untuk Cover Depan E-Rapor</label>
                                <p class="text-[10px] text-emerald-800 font-medium">Logo ini otomatis dicetak di lembar cover depan rapor siswa (bersih tanpa border luar).</p>
                            </div>
                            <span class="px-2 py-0.5 rounded bg-emerald-700 text-white font-extrabold text-[9px] uppercase">Cover Rapor</span>
                        </div>
                        @if(!empty($reportSetting?->school_logo_url))
                            <div class="flex items-center justify-between gap-2 p-2 bg-white rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3 min-w-0">
                                    <img src="{{ asset($reportSetting->school_logo_url) }}" class="h-12 w-auto object-contain" alt="Logo Cover">
                                    <div class="text-[10px] text-slate-600 truncate">
                                        <span class="font-bold text-emerald-700">Logo Cover Aktif:</span> {{ basename($reportSetting->school_logo_url) }}
                                    </div>
                                </div>
                                <label class="inline-flex items-center gap-1 text-[10px] text-rose-600 font-bold shrink-0 cursor-pointer">
                                    <input type="checkbox" name="clear_logo" value="1" class="rounded text-rose-600">
                                    <span>Reset ke Default</span>
                                </label>
                            </div>
                        @elseif(!empty($activeSchool->logo_url))
                            <div class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-200">
                                <img src="{{ asset($activeSchool->logo_url) }}" class="h-12 w-auto object-contain" alt="Logo Cover">
                                <div class="text-[10px] text-slate-600 truncate">
                                    <span class="font-bold text-emerald-700">Logo Master Sekolah:</span> {{ basename($activeSchool->logo_url) }}
                                </div>
                            </div>
                        @endif
                        <input type="file" name="school_logo_file" accept="image/png,image/jpeg,image/svg+xml,image/webp" 
                               class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-sm flex items-center justify-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN GAMBAR KOP, LOGO COVER & PENGATURAN CETAK</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Right Column: Live Visual Preview of Report Header & Signatures -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm sticky top-6">
                <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
                    <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider">Preview Hasil Cetak Rapor</h4>
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase">
                        Realtime Preview
                    </span>
                </div>

                <!-- Mock Paper Layout -->
                <div class="bg-white p-6 rounded-xl border border-slate-300 shadow-xs space-y-5">
                    
                    <!-- Preview Kop Surat Gambar Langsung -->
                    <div id="preview_kop_container" class="border-b-2 border-slate-900 pb-3 text-center">
                        @if(!empty($reportSetting?->kop_image_url))
                            <img id="preview_kop_img" src="{{ asset($reportSetting->kop_image_url) }}" class="w-full max-h-28 object-contain mx-auto" alt="Kop Surat">
                        @else
                            <div id="preview_kop_placeholder" class="py-6 bg-slate-50 border border-dashed border-slate-300 rounded-lg text-center">
                                <span class="text-2xl">🏛️</span>
                                <p class="text-xs font-bold text-slate-700 mt-1">Kop Surat Belum Diupload</p>
                                <p class="text-[10px] text-slate-400">Silakan pilih berkas banner kop surat resmi pada formulir di sebelah kiri.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Mock Content Area -->
                    <div class="py-8 text-center text-slate-400 font-sans text-xs italic bg-slate-50/75 rounded-lg border border-dashed border-slate-200 space-y-1">
                        <p class="font-bold text-slate-500 not-italic">LEMBAR HASIL BELAJAR PESERTA DIDIK</p>
                        <p class="text-[11px]">[ Capaian Nilai Akademik, Wafa Quran, dan Karakter Siswa ]</p>
                    </div>

                    <!-- Preview Signature & Stamp -->
                    <div class="border-t border-slate-200 pt-4 flex justify-end font-sans">
                        <div class="text-center w-56 space-y-1">
                            <p class="text-[11px] text-slate-700 font-medium">
                                <span id="preview_city">{{ (!empty($reportSetting?->report_city) && !str_contains($reportSetting->report_city, 'Bandung')) ? $reportSetting->report_city : 'Ogan Ilir' }}</span>, 
                                <span id="preview_date">{{ (!empty($reportSetting?->report_date) && !str_contains($reportSetting->report_date, 'Desember')) ? $reportSetting->report_date : '18 Juni 2026' }}</span>
                            </p>
                            <p class="text-[11px] font-bold text-slate-900">Kepala Sekolah,</p>
                            
                            @php
                                $pvSigMode = $reportSetting?->signature_mode ?? 'both';
                                $pvShowStamp = in_array($pvSigMode, ['both', 'stamp_only']) && !empty($reportSetting?->stamp_image_url);
                                $pvShowSig = in_array($pvSigMode, ['both', 'ttd_has_stamp', 'ttd_only']) && !empty($reportSetting?->principal_signature_url);
                            @endphp
                            <!-- Stamp & TTD Graphic Mockup -->
                            <div class="h-20 my-1 flex items-center justify-center relative" id="preview_sig_wrapper">
                                @if(!empty($reportSetting?->stamp_image_url))
                                    <img id="preview_stamp_img" src="{{ asset($reportSetting->stamp_image_url) }}" class="h-20 w-auto object-contain absolute opacity-80 left-2 pointer-events-none {{ $pvShowStamp ? '' : 'hidden' }}" alt="Stempel">
                                @endif
                                @if(!empty($reportSetting?->principal_signature_url))
                                    <img id="preview_sig_img" src="{{ asset($reportSetting->principal_signature_url) }}" class="h-16 w-auto object-contain relative z-10 {{ $pvShowSig ? '' : 'hidden' }}" alt="TTD">
                                @endif
                                <span id="preview_sig_placeholder" class="font-serif italic text-slate-400 text-xs {{ ($pvShowStamp || $pvShowSig) ? 'hidden' : '' }}">(Tanda Tangan & Stempel Kosong)</span>
                            </div>

                            <p id="preview_principal" class="text-xs font-black text-slate-900 underline">
                                {{ $reportSetting->principal_name ?? 'Nur Amalia, S.Pd., Gr' }}
                            </p>
                            <p class="text-[10px] text-slate-600 font-semibold">
                                NIP: <span id="preview_nip">{{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                    <p class="text-[11px] text-slate-600 font-medium">
                        💡 Gambar Kop Surat dan Logo Cover yang Anda upload di atas akan dicetak pada seluruh format rapor siswa.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Section 2: Edit Profil Resmi Sekolah Unit Lengkap -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6 mt-6">
        <div class="border-b border-slate-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[11px] font-extrabold uppercase tracking-wide">
                        Profil Resmi Sekolah Unit
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-bold">
                        Sinkronisasi Data Master
                    </span>
                </div>
                <h3 class="font-black text-lg text-slate-900">🏫 Kelola Data Sekolah (Lembar Profil Rapor)</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Perbarui nama sekolah, NPSN, alamat lengkap, desa, kecamatan, kontak, serta data kepala sekolah. Data ini otomatis dicetak pada Lembar 2 (Profil Sekolah) e-Rapor dan tersimpan ke Data Master Sekolah.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.academic.school.profile.save') }}" class="space-y-5 text-xs">
            @csrf
            <input type="hidden" name="school_id" value="{{ $schoolId }}">

            <!-- 1. Identitas Lembaga, NPSN, Akreditasi & NSS/NDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Resmi Sekolah:</label>
                    <input type="text" name="name" required 
                           value="{{ $activeSchool->name ?? '' }}" 
                           placeholder="Contoh: SMP Islam Terpadu Robbani"
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">NPSN Sekolah:</label>
                    <input type="text" name="npsn" 
                           value="{{ $activeSchool->npsn ?? '' }}" 
                           placeholder="Contoh: 70014022"
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Akreditasi Sekolah (Profil & Cover):</label>
                    <input type="text" name="accreditation" 
                           value="{{ $reportSetting?->accreditation ?? ($isTkSchool ? 'Terakreditasi A (BAN-PAUD)' : 'Terakreditasi B (BAN-S/M)') }}" 
                           placeholder="Contoh: Terakreditasi B (BAN-S/M)"
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                    <p class="text-[10px] text-slate-500 mt-1">SD dan SMP = Terakreditasi B, TK = Terakreditasi A. Bebas diedit kapan saja.</p>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">NSS / NDS Sekolah:</label>
                    <input type="text" name="nss_nds" 
                           value="{{ $reportSetting?->nss_nds ?? ($isTkSchool ? '-' : '102110304001') }}" 
                           placeholder="Contoh: 102110304001"
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                    <p class="text-[10px] text-slate-500 mt-1">Dicetak pada baris ke-3 tabel Lembar 2 Profil Sekolah.</p>
                </div>
            </div>

            <!-- 2. Alamat Lengkap & Wilayah -->
            <div>
                <label class="block font-bold text-slate-700 mb-1">Alamat Jalan / Gedung Sekolah:</label>
                <input type="text" name="address" 
                       value="{{ $activeSchool->address ?? '' }}" 
                       placeholder="Contoh: Jl Sarjana Gg. Padang Guci Kel. Timbangan"
                       class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kelurahan / Desa:</label>
                    <input type="text" name="village" 
                           value="{{ $activeSchool->village ?? 'Timbangan' }}" 
                           placeholder="Kelurahan..."
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kecamatan:</label>
                    <input type="text" name="district" 
                           value="{{ $activeSchool->district ?? 'Indralaya Utara' }}" 
                           placeholder="Kecamatan..."
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kabupaten / Kota:</label>
                    <input type="text" name="city" 
                           value="{{ $activeSchool->city ?? 'Ogan Ilir' }}" 
                           placeholder="Kabupaten / Kota..."
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Provinsi:</label>
                    <input type="text" name="province" 
                           value="{{ $activeSchool->province ?? 'Sumatera Selatan' }}" 
                           placeholder="Provinsi..."
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
            </div>

            <!-- 3. Kontak, Website & Kode Pos -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kode Pos:</label>
                    <input type="text" name="postal_code" 
                           value="{{ $activeSchool->postal_code ?? '30662' }}" 
                           placeholder="30662"
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Telepon / HP:</label>
                    <input type="text" name="phone" 
                           value="{{ $activeSchool->phone ?? '+62 853-7719-3977' }}" 
                           placeholder="+62 853-7719-3977"
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email Resmi Sekolah:</label>
                    <input type="email" name="email" 
                           value="{{ $activeSchool->email ?? ($isSmp ? 'smpit@sitrobbani.sch.id' : 'sdit@sitrobbani.sch.id') }}" 
                           placeholder="smpit@sitrobbani.sch.id"
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Website Resmi:</label>
                    <input type="text" name="website" 
                           value="{{ $activeSchool->website ?? ($isSmp ? 'www.smp.sitrobbani.sch.id' : 'www.sitrobbani.sch.id') }}" 
                           placeholder="www.smp.sitrobbani.sch.id"
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
            </div>

            <!-- 4. Pimpinan Sekolah & Titimangsa Rapor -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-2 border-t border-slate-200">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Kepala Sekolah:</label>
                    <input type="text" name="principal_name" 
                           value="{{ $reportSetting->principal_name ?? ($activeSchool->principal_name ?? ($isSmp ? 'Tia Wulandari, S.Pd.,Gr.' : 'Nur Amalia, S.Pd., Gr')) }}" 
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">NIP / NIY Kepala Sekolah:</label>
                    <input type="text" name="principal_nip" 
                           value="{{ $reportSetting->principal_nip ?? ($activeSchool->principal_nip ?? ($isSmp ? '142062021012' : '19850315 200904 1 003')) }}" 
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kota Titimangsa Rapor:</label>
                    <input type="text" name="report_city" 
                           value="{{ $reportSetting->report_city ?? 'Ogan Ilir' }}" 
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggal Titimangsa Pembagian:</label>
                    <input type="text" name="report_date" 
                           value="{{ $reportSetting->report_date ?? ($isSmp ? '19 Juni 2026' : '18 Juni 2026') }}" 
                           class="w-full font-semibold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-blue-600 text-slate-900">
                </div>
            </div>

            <!-- Submit Profil Sekolah -->
            <div class="pt-3 border-t border-slate-200 flex justify-end">
                <button type="submit" 
                        class="px-6 py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-black text-xs inline-flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                    <span>💾</span> <span>SIMPAN DATA PROFIL SEKOLAH (MASTER & E-RAPOR)</span>
                </button>
            </div>
        </form>
    </div>
    @endif

</div>

<!-- Modal Analisis Kesiapan Rapor Kelas oleh Robbani AI -->
<div id="modalAiClassAnalysis" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-3xl max-w-3xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center text-lg font-black shadow-md shadow-purple-200">
                    ✨
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900" id="modalAiTitle">Analisis Kesiapan Rapor oleh Robbani AI</h3>
                    <p class="text-[11px] text-slate-500 font-medium" id="modalAiSubtitle">Audit kelengkapan nilai, korelasi capaian karakter & rekomendasi cetak rapor</p>
                </div>
            </div>
            <button onclick="closeAiClassAnalysisModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center font-bold text-sm transition cursor-pointer">✕</button>
        </div>
        <div class="overflow-y-auto flex-1 pr-2 space-y-3" id="modalAiContent">
            <div class="py-12 text-center text-slate-500 space-y-3">
                <div class="inline-block animate-spin text-3xl">✨</div>
                <p class="text-xs font-bold text-slate-600">Robbani AI sedang menganalisis data rombel secara mendalam...</p>
                <p class="text-[11px] text-slate-400">Mohon tunggu beberapa detik...</p>
            </div>
        </div>
        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
            <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Powered by Robbani AI Intelligent Core</span>
            </span>
            <div class="flex items-center gap-2">
                <button type="button" id="btnCopyAiAnalysis" onclick="copyAiClassAnalysis()" class="hidden px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer flex items-center gap-1.5">
                    <span>📋</span> <span>Salin Analisis</span>
                </button>
                <button type="button" onclick="closeAiClassAnalysisModal()" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal WhatsApp Reminder untuk Wali Kelas (Follow Up Kepala Sekolah) -->
<div id="modalWaliReminder" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center text-lg font-black shadow-md shadow-emerald-200">
                    📲
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900">Follow Up & Pengingat Wali Kelas</h3>
                    <p class="text-[11px] text-slate-500 font-medium">Kirim pesan resmi Kepala Sekolah via WhatsApp</p>
                </div>
            </div>
            <button onclick="closeWaliReminderModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center font-bold text-sm transition cursor-pointer">✕</button>
        </div>

        <!-- Body -->
        <div class="overflow-y-auto flex-1 pr-1 space-y-4 text-xs">
            <!-- Profil Walas Box -->
            <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-500 text-[11px] uppercase">Rombel Kelas:</span>
                    <span class="font-black text-slate-900 text-xs" id="reminderClassName">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-500 text-[11px] uppercase">Wali Kelas:</span>
                    <span class="font-black text-emerald-800 text-xs" id="reminderWalasName">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-500 text-[11px] uppercase">No. WhatsApp:</span>
                    <span class="font-black text-slate-800 text-xs" id="reminderWalasPhone">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="font-bold text-slate-500 text-[11px] uppercase">Progres Saat Ini:</span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-black" id="reminderProgressBadge">-</span>
                </div>
            </div>

            <!-- Template Type Selector -->
            <div>
                <label class="block font-bold text-slate-700 mb-1.5 text-[11px] uppercase">Pilih Template Pesan:</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="setReminderTemplate('standard')" id="btnTplStandard" class="px-2.5 py-1.5 rounded-xl border border-emerald-500 bg-emerald-50 text-emerald-800 font-bold text-[10px] text-center transition cursor-pointer">
                        Standar Rapor
                    </button>
                    <button type="button" onclick="setReminderTemplate('urgent')" id="btnTplUrgent" class="px-2.5 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-bold text-[10px] text-center transition cursor-pointer">
                        Batas Akhir (Urgent)
                    </button>
                    <button type="button" onclick="setReminderTemplate('appreciation')" id="btnTplAppreciation" class="px-2.5 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-bold text-[10px] text-center transition cursor-pointer">
                        Apresiasi Tuntas
                    </button>
                </div>
            </div>

            <!-- Preview Pesan Textarea -->
            <div>
                <label class="block font-bold text-slate-700 mb-1 text-[11px] uppercase">Isi Pesan WhatsApp (Dapat Diedit):</label>
                <textarea id="reminderMessageText" rows="6" class="w-full p-3 rounded-xl border border-slate-200 text-xs text-slate-800 leading-relaxed font-mono focus:ring-2 focus:ring-emerald-500 focus:outline-hidden resize-none bg-slate-50/50"></textarea>
            </div>
            
            <div id="reminderNoPhoneNotice" class="hidden p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-[11px] font-medium">
                ⚠️ Nomor telepon belum terdaftar di data pegawai. Anda tetap dapat menyalin pesan dan mengirimkannya secara manual, atau menambahkan nomor HP di menu Pengguna & Guru.
            </div>
        </div>

        <!-- Footer -->
        <div class="pt-3 border-t border-slate-200 flex items-center justify-between gap-2">
            <button type="button" onclick="copyWaliReminderText()" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer flex items-center gap-1.5 active:scale-95">
                <span>📋</span> <span>Salin Pesan</span>
            </button>
            <div class="flex items-center gap-2">
                <button type="button" onclick="closeWaliReminderModal()" class="px-4 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btnSendWa" onclick="sendWaliReminderWa()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition cursor-pointer flex items-center gap-1.5 shadow-md shadow-emerald-200 active:scale-95">
                    <span>💬</span> <span>Kirim via WhatsApp</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Realtime Helper Scripts -->
<script>
    // Inisialisasi Chart.js jika pada halaman dashboard
    @if(($activeMenu ?? 'dashboard') === 'dashboard')
    document.addEventListener('DOMContentLoaded', function() {
        const rombelLabels = {!! json_encode($chartClassroomLabels ?? []) !!};
        const rombelValues = {!! json_encode($chartClassroomValues ?? []) !!};
        const sklLabels = {!! json_encode($chartSklLabels ?? []) !!};
        const sklValues = {!! json_encode($chartSklValues ?? []) !!};
        const sklPerClass = {!! json_encode($chartSklPerClass ?? []) !!};
        const predicates = {!! json_encode($chartPredicates ?? ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0]) !!};

        // 1. Chart Progress Rombel (Horizontal Bar)
        const ctxRombel = document.getElementById('chartRombelProgress');
        if (ctxRombel && rombelLabels.length > 0) {
            new Chart(ctxRombel, {
                type: 'bar',
                data: {
                    labels: rombelLabels,
                    datasets: [{
                        label: 'Kelengkapan (%)',
                        data: rombelValues,
                        backgroundColor: rombelValues.map(v => v >= 100 ? '#059669' : (v >= 75 ? '#0284c7' : '#d97706')),
                        borderRadius: 8,
                        barThickness: 18,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: { left: 4, right: 16, top: 4, bottom: 4 }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ` Kesiapan Rapor: ${context.parsed.x}%`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            min: 0,
                            max: 100,
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10, weight: 'bold' }, callback: v => v + '%' }
                        },
                        y: {
                            grid: { display: false },
                            ticks: { 
                                font: { size: 11, weight: '600' }, 
                                color: '#334155',
                                autoSkip: false
                            }
                        }
                    }
                }
            });
        }

        // 2. Chart Radar 7 SKL JSIT (Dapat dicek per kelas maupun unit)
        const ctxSkl = document.getElementById('chartSklRadar');
        let chartSklInstance = null;

        if (ctxSkl && sklLabels.length > 0) {
            chartSklInstance = new Chart(ctxSkl, {
                type: 'radar',
                data: {
                    labels: sklLabels,
                    datasets: [{
                        label: 'Capaian 7 SKL (%)',
                        data: sklValues,
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
                        borderColor: '#4f46e5',
                        pointBackgroundColor: '#4338ca',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#4338ca',
                        borderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        r: {
                            min: 0,
                            max: 100,
                            ticks: { stepSize: 25, font: { size: 9 }, backdropColor: 'transparent' },
                            grid: { color: '#e2e8f0' },
                            angleLines: { color: '#f1f5f9' },
                            pointLabels: { font: { size: 10, weight: 'bold' }, color: '#475569' }
                        }
                    }
                }
            });
        }

        window.updateSklRadar = function(classId) {
            if (!chartSklInstance) return;
            const targetData = sklPerClass[classId] || sklPerClass['all'] || { values: sklValues, name: 'Semua Kelas' };
            chartSklInstance.data.datasets[0].data = targetData.values;
            chartSklInstance.data.datasets[0].label = 'Capaian 7 SKL - ' + (targetData.name || 'Kelas');
            chartSklInstance.update();
        };

        // Otomatis sesuaikan jika ada kelas aktif yang dipilih di filter awal
        const initialRadarClass = document.getElementById('filterSklRadarClass');
        if (initialRadarClass && initialRadarClass.value && initialRadarClass.value !== 'all') {
            window.updateSklRadar(initialRadarClass.value);
        }

        // 3. Chart Donut Predikat
        const ctxPred = document.getElementById('chartPredikatDonut');
        if (ctxPred) {
            new Chart(ctxPred, {
                type: 'doughnut',
                data: {
                    labels: ['A (Istimewa)', 'B (Baik)', 'C (Cukup)', 'D (Bimbingan)'],
                    datasets: [{
                        data: [predicates.A || 0, predicates.B || 0, predicates.C || 0, predicates.D || 0],
                        backgroundColor: ['#059669', '#0284c7', '#d97706', '#e11d48'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { font: { size: 10, weight: 'bold' }, boxWidth: 12, padding: 12 }
                        }
                    }
                }
            });
        }
    });
    @endif

    // =========================================================================
    // MARKDOWN PARSER & CLEANER ROBBANI AI
    // =========================================================================
    function renderMarkdownToHtml(markdown) {
        if (!markdown) return '';
        // Sanitize any stray fake letterhead lines
        markdown = markdown
            .replace(/^[*\s]*KEMENTERIAN.*$/gmi, '')
            .replace(/^[*\s]*SEKOLAH ISLAM TERPADU.*KEMENTERIAN.*$/gmi, '')
            .replace(/^[*\s]*Kantor Konsultan.*$/gmi, '')
            .replace(/^[*\s]*Konsultan Penjaminan.*$/gmi, '')
            .replace(/^[*\s]*Kepada Yth.*$/gmi, '')
            .replace(/^[*\s]*Dari:\s*.*$/gmi, '')
            .replace(/^[*\s]*Perihal:\s*.*$/gmi, '')
            .replace(/^[*\s]*Tanggal:\s*.*$/gmi, '')
            .trim();

        const lines = markdown.split('\n');
        let html = '<div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-3 text-xs leading-relaxed text-slate-800">';
        let inList = false;

        for (let rawLine of lines) {
            let line = rawLine.trim();
            if (!line) {
                if (inList) {
                    html += '</ul>';
                    inList = false;
                }
                continue;
            }

            // Horizontal dividers
            if (/^---$|^___$|^\*\*\*$/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                html += '<hr class="border-slate-200 my-2.5">';
                continue;
            }

            // Parse inline bold, italic, and code
            let formattedLine = line
                .replace(/\*\*(.*?)\*\*/g, '<strong class="font-black text-slate-950">$1</strong>')
                .replace(/__(.*?)__/g, '<strong class="font-black text-slate-950">$1</strong>')
                .replace(/\*(.*?)\*/g, '<em class="italic text-emerald-950 font-semibold">$1</em>')
                .replace(/_(.*?)_/g, '<em class="italic text-emerald-950 font-semibold">$1</em>');

            // Headers
            if (/^####\s+/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                html += `<h5 class="font-black text-slate-900 text-xs mt-3.5 mb-1.5 flex items-center gap-1.5 text-emerald-950 bg-emerald-50/80 px-3 py-1.5 rounded-xl border border-emerald-200"><span>🏫</span><span>${formattedLine.replace(/^####\s+/, '')}</span></h5>`;
            } else if (/^###\s+/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                html += `<h4 class="font-black text-slate-900 text-xs mt-4 mb-2 border-b border-emerald-200 pb-1.5 flex items-center gap-1.5 text-emerald-950"><span>📌</span><span>${formattedLine.replace(/^###\s+/, '')}</span></h4>`;
            } else if (/^##\s+/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                html += `<h3 class="font-black text-slate-950 text-sm mt-5 mb-2.5 border-b-2 border-emerald-500 pb-1 flex items-center gap-2 text-emerald-950"><span>✨</span><span>${formattedLine.replace(/^##\s+/, '')}</span></h3>`;
            } else if (/^#\s+/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                html += `<h2 class="font-black text-emerald-950 text-base mt-4 mb-2">${formattedLine.replace(/^#\s+/, '')}</h2>`;
            } else if (/^(\*|-|•)\s+/.test(line)) {
                if (!inList) {
                    html += '<ul class="space-y-1.5 my-2 pl-1">';
                    inList = true;
                }
                let itemText = formattedLine.replace(/^(\*|-|•)\s+/, '');
                html += `<li class="flex items-start gap-2 text-slate-800"><span class="text-emerald-600 mt-0.5 shrink-0 font-bold">•</span><span>${itemText}</span></li>`;
            } else if (/^\d+\.\s+/.test(line)) {
                if (inList) { html += '</ul>'; inList = false; }
                let itemText = formattedLine.replace(/^\d+\.\s+/, '');
                let num = line.match(/^(\d+)\./)[1];
                html += `<div class="flex items-start gap-2.5 my-2 text-slate-900"><span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 font-black text-[10px] shrink-0">${num}</span><div class="leading-relaxed">${itemText}</div></div>`;
            } else {
                if (inList) { html += '</ul>'; inList = false; }
                html += `<p class="leading-relaxed text-slate-800 my-1">${formattedLine}</p>`;
            }
        }
        if (inList) {
            html += '</ul>';
        }
        html += '</div>';
        return html;
    }

    function cleanMarkdownForInput(text) {
        if (!text) return '';
        return text
            .replace(/\*\*(.*?)\*\*/g, '$1')
            .replace(/\*(.*?)\*/g, '$1')
            .replace(/^#+\s*/gm, '')
            .replace(/^[-•*]\s*/gm, '')
            .trim();
    }

    // AI & User Management Helper Functions
    let lastAiAnalysisText = '';

    function openAiClassAnalysisModal(classroomId, classroomName) {
        const modal = document.getElementById('modalAiClassAnalysis');
        const title = document.getElementById('modalAiTitle');
        const subtitle = document.getElementById('modalAiSubtitle');
        const content = document.getElementById('modalAiContent');
        const btnCopy = document.getElementById('btnCopyAiAnalysis');

        if (!modal) return;

        modal.classList.remove('hidden');
        title.innerText = classroomName ? `Analisis AI: ${classroomName}` : 'Analisis Kesiapan Rapor Seluruh Unit';
        subtitle.innerText = 'Mengaudit kelengkapan data & rekomendasi kesiapan cetak rapor...';
        btnCopy.classList.add('hidden');
        content.innerHTML = `
            <div class="py-14 text-center text-slate-500 space-y-3">
                <div class="inline-block animate-spin text-4xl">✨</div>
                <p class="text-sm font-black text-slate-700">Robbani AI sedang menganalisis data...</p>
                <p class="text-xs text-slate-400">Menghubungkan data nilai, Wafa, dan karakter JSIT...</p>
            </div>
        `;

        const schoolId = '{{ $schoolId ?? 1 }}';
        let url = `{{ route('admin.academic.ai.analyze-class') }}?school_id=${schoolId}`;
        if (classroomId) {
            url += `&classroom_id=${classroomId}`;
        }

        fetch(url, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                lastAiAnalysisText = data.analysis;
                btnCopy.classList.remove('hidden');
                
                let matrixCardsHtml = '';
                if (data.class_summaries && data.class_summaries.length > 0) {
                    matrixCardsHtml = `
                        <div class="mb-4 bg-slate-50/80 border border-slate-200/80 p-3.5 rounded-2xl">
                            <div class="flex items-center justify-between mb-2.5 pb-2 border-b border-slate-200/80">
                                <span class="text-[11px] font-black uppercase text-slate-800 tracking-wider flex items-center gap-1.5">
                                    <span>🏫</span> <span>Audit Status Seluruh Rombel (${data.class_summaries.length} Kelas Terdaftar)</span>
                                </span>
                                <span class="text-[10px] font-extrabold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-300">
                                    ${data.classroom_name || 'Seluruh Kelas'}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                    `;
                    data.class_summaries.forEach(c => {
                        const isDone = c.progress_pct >= 100;
                        const isProgress = c.progress_pct > 0 && c.progress_pct < 100;
                        const badgeClass = isDone 
                            ? 'bg-emerald-100 text-emerald-900 border-emerald-300' 
                            : (isProgress ? 'bg-amber-100 text-amber-900 border-amber-300' : 'bg-rose-50 text-rose-800 border-rose-300');
                        
                        matrixCardsHtml += `
                            <div class="p-2.5 bg-white rounded-xl border border-slate-200 flex items-center justify-between gap-2 shadow-2xs">
                                <div class="min-w-0">
                                    <p class="font-black text-slate-900 text-xs truncate">${c.name}</p>
                                    <p class="text-[10px] text-slate-500 font-medium truncate">Wali: <strong>${c.walas}</strong> • ${c.students} Siswa</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black border ${badgeClass} shrink-0 whitespace-nowrap">
                                    ${c.status}
                                </span>
                            </div>
                        `;
                    });
                    matrixCardsHtml += `
                            </div>
                        </div>
                    `;
                }

                content.innerHTML = matrixCardsHtml + renderMarkdownToHtml(data.analysis);
            } else {
                content.innerHTML = `
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs">
                        <p class="font-bold">Gagal melakukan analisis AI:</p>
                        <p class="mt-1">${data.message || 'Terjadi kesalahan sistem.'}</p>
                    </div>
                `;
            }
        })
        .catch(err => {
            content.innerHTML = `
                <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-xs">
                    <p class="font-bold">Gagal terhubung ke layanan AI:</p>
                    <p class="mt-1">${err.message}</p>
                </div>
            `;
        });
    }

    function closeAiClassAnalysisModal() {
        const modal = document.getElementById('modalAiClassAnalysis');
        if (modal) modal.classList.add('hidden');
    }

    function copyAiClassAnalysis() {
        if (!lastAiAnalysisText) return;
        navigator.clipboard.writeText(lastAiAnalysisText).then(() => {
            alert('Teks analisis AI berhasil disalin ke clipboard!');
        });
    }

    // =========================================================================
    // HELPER PENGINGAT & FOLLOW UP WALI KELAS VIA WHATSAPP (KEPALA SEKOLAH)
    // =========================================================================
    let currentReminderData = {
        name: '',
        classroom: '',
        phone: '',
        pct: 0,
        stCount: 0,
        type: 'standard'
    };

    function openWaliReminderModal(walasName, className, phone, pct, stCount) {
        currentReminderData = {
            name: walasName,
            classroom: className,
            phone: phone ? phone.trim() : '',
            pct: pct,
            stCount: stCount,
            type: pct >= 100 ? 'appreciation' : 'standard'
        };

        const modal = document.getElementById('modalWaliReminder');
        if (!modal) return;

        const elClass = document.getElementById('reminderClassName');
        const elWalas = document.getElementById('reminderWalasName');
        const elPhone = document.getElementById('reminderWalasPhone');
        if (elClass) elClass.innerText = className;
        if (elWalas) elWalas.innerText = walasName;
        if (elPhone) elPhone.innerText = phone ? phone : 'Belum tercatat';

        const pBadge = document.getElementById('reminderProgressBadge');
        if (pBadge) {
            pBadge.innerText = `${pct}% (${pct >= 100 ? 'Tuntas' : (pct > 0 ? 'Sedang Berjalan' : 'Belum Mulai')})`;
            pBadge.className = `px-2 py-0.5 rounded text-[10px] font-black ${pct >= 100 ? 'bg-emerald-100 text-emerald-800' : (pct > 0 ? 'bg-sky-100 text-sky-800' : 'bg-slate-100 text-slate-600')}`;
        }

        const notice = document.getElementById('reminderNoPhoneNotice');
        const btnSendWa = document.getElementById('btnSendWa');
        if (!phone) {
            if (notice) notice.classList.remove('hidden');
            if (btnSendWa) {
                btnSendWa.classList.add('opacity-50', 'cursor-not-allowed');
                btnSendWa.title = 'Nomor telepon belum tersedia';
            }
        } else {
            if (notice) notice.classList.add('hidden');
            if (btnSendWa) {
                btnSendWa.classList.remove('opacity-50', 'cursor-not-allowed');
                btnSendWa.title = 'Buka WhatsApp Web / App';
            }
        }

        setReminderTemplate(currentReminderData.type);
        modal.classList.remove('hidden');
    }

    function closeWaliReminderModal() {
        const modal = document.getElementById('modalWaliReminder');
        if (modal) modal.classList.add('hidden');
    }

    function setReminderTemplate(tpl) {
        currentReminderData.type = tpl;
        const d = currentReminderData;
        const schoolName = '{{ $activeSchool->name ?? "SDIT Robbani" }}';

        ['Standard', 'Urgent', 'Appreciation'].forEach(k => {
            const btn = document.getElementById('btnTpl' + k);
            if (btn) {
                if (k.toLowerCase() === tpl.toLowerCase()) {
                    btn.className = 'px-2.5 py-1.5 rounded-xl border border-emerald-500 bg-emerald-50 text-emerald-800 font-bold text-[10px] text-center transition cursor-pointer';
                } else {
                    btn.className = 'px-2.5 py-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-bold text-[10px] text-center transition cursor-pointer';
                }
            }
        });

        let msg = '';
        if (tpl === 'urgent') {
            msg = `Assalamu'alaikum Wr. Wb. Ustadz/Ustadzah ${d.name},\n\n` +
                  `Izin mengingatkan batas waktu pengisian nilai e-Rapor SIT Terpadu untuk kelas *${d.classroom}* di ${schoolName}.\n` +
                  `Saat ini capaian pengisian berada pada *${d.pct}%*.\n\n` +
                  `Mohon berkenan untuk segera melengkapi penilaian Mapel/TP, Wafa, Karakter, dan catatan wali kelas sebelum batas waktu penutupan sistem. Jazakumullah khairan katsiran atas dedikasi dan kerjasamanya.\n\n` +
                  `Wassalamu'alaikum Wr. Wb.\n` +
                  `_Kepala Sekolah ${schoolName}_`;
        } else if (tpl === 'appreciation') {
            msg = `Assalamu'alaikum Wr. Wb. Ustadz/Ustadzah ${d.name},\n\n` +
                  `Alhamdulillah, kami sampaikan apresiasi dan terima kasih atas ketuntasan pengisian e-Rapor SIT Terpadu kelas *${d.classroom}* yang telah mencapai *100% tuntas*.\n\n` +
                  `Semoga setiap ikhtiar dan bimbingan Ustadz/Ustadzah menjadi amal jariyah yang penuh berkah di sisi Allah SWT. Aamiin ya Rabbal 'Alamin.\n\n` +
                  `Wassalamu'alaikum Wr. Wb.\n` +
                  `_Kepala Sekolah ${schoolName}_`;
        } else {
            msg = `Assalamu'alaikum Wr. Wb. Ustadz/Ustadzah ${d.name},\n\n` +
                  `Semoga senantiasa dalam keadaan sehat dan dalam lindungan Allah SWT.\n\n` +
                  `Menginfokan status pengisian e-Rapor SIT Terpadu untuk kelas *${d.classroom}* saat ini mencapai *${d.pct}%* (${d.stCount} siswa).\n` +
                  `Mohon dapat dicek kembali kelengkapan nilai Mata Pelajaran & TP, Al-Qur'an Wafa, 7 Karakter SKL, P5, serta Catatan Wali Kelas.\n\n` +
                  `Jazakumullah khairan katsiran.\n\n` +
                  `Wassalamu'alaikum Wr. Wb.\n` +
                  `_Kepala Sekolah ${schoolName}_`;
        }

        const ta = document.getElementById('reminderMessageText');
        if (ta) ta.value = msg;
    }

    function sendWaliReminderWa() {
        const phone = currentReminderData.phone;
        const text = document.getElementById('reminderMessageText').value;
        if (!phone) {
            alert('Nomor WhatsApp belum tersedia di data guru. Silakan gunakan tombol Salin Pesan untuk mengirim secara manual.');
            return;
        }

        let cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.slice(1);
        }

        const url = `https://wa.me/${cleanPhone}?text=${encodeURIComponent(text)}`;
        window.open(url, '_blank');
    }

    function copyWaliReminderText() {
        const text = document.getElementById('reminderMessageText').value;
        navigator.clipboard.writeText(text).then(() => {
            if (window.Swal) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pesan Disalin!',
                    text: 'Teks pesan WhatsApp siap dikirimkan ke Wali Kelas.',
                    timer: 1600,
                    showConfirmButton: false
                });
            } else {
                alert('Pesan berhasil disalin ke clipboard!');
            }
        });
    }

    function generateAiNarrativeSingle(studentId, studentName) {
        const textarea = document.getElementById('notes_' + studentId);
        const scoreInput = document.getElementById('score_' + studentId);
        const sasInput = document.getElementById('sas_' + studentId);
        const tpInput = document.getElementById('tp_' + studentId);
        let score = null;
        if (scoreInput && scoreInput.value !== '') score = parseFloat(scoreInput.value);
        else if (sasInput && sasInput.value !== '') score = parseFloat(sasInput.value);
        else if (tpInput && tpInput.value !== '') score = parseFloat(tpInput.value);
        if (score === null || isNaN(score)) score = 0;
        const subjectName = '{{ $selectedSubject->name ?? "Mata Pelajaran" }}';

        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang menyusun narasi capaian dengan Robbani AI...';
        textarea.disabled = true;

        fetch('{{ route("admin.academic.ai.generate.narrative") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                subject_name: subjectName,
                score: score
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            const content = data.narrative || data.text || data.note;
            if (data.status === 'success' && content) {
                textarea.value = cleanMarkdownForInput(content);
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat narasi dengan AI.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    function generateAiHomeroomSingle(studentId, studentName) {
        const textarea = document.getElementById('homeroom_notes_' + studentId);
        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang membuat catatan motivasi islami dengan Robbani AI...';
        textarea.disabled = true;

        const sick = parseInt(document.getElementById('sick_' + studentId)?.value) || 0;
        const permission = parseInt(document.getElementById('permission_' + studentId)?.value) || 0;
        const absent = parseInt(document.getElementById('absent_' + studentId)?.value) || 0;

        fetch('{{ route("admin.academic.ai.generate.homeroom") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                academic_average: 88,
                average_score: 88,
                sick_count: sick,
                permission_count: permission,
                absent_count: absent
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            const content = data.note || data.narrative || data.text;
            if (data.status === 'success' && content) {
                textarea.value = cleanMarkdownForInput(content);
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat catatan dengan AI.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    function applyHomeroomTemplateSingle(studentId, studentName) {
        const textarea = document.getElementById('homeroom_notes_' + studentId);
        if (!textarea) return;

        const sick = parseInt(document.getElementById('sick_' + studentId)?.value) || 0;
        const permission = parseInt(document.getElementById('permission_' + studentId)?.value) || 0;
        const absent = parseInt(document.getElementById('absent_' + studentId)?.value) || 0;

        let attendanceNote = '';
        if (absent >= 3) {
            attendanceNote = ` Perhatian khusus pada kehadiran: Ananda memiliki catatan alpa ${absent} hari. Mohon kerja sama dan pendampingan intensif orang tua di rumah agar ananda lebih berdisiplin dan teratur hadir di sekolah.`;
        } else if (absent === 0 && sick === 0 && permission === 0) {
            attendanceNote = ` Alhamdulillah, kehadiran Ananda sangat disiplin dan prima (kehadiran penuh 100%). Pertahankan keistiqomahan ini.`;
        } else if (sick >= 4) {
            attendanceNote = ` Semoga ananda senantiasa dikaruniai kesehatan afiat dan dilindungi Allah SWT agar terus dapat belajar dan beribadah dengan optimal.`;
        } else if (absent > 0) {
            attendanceNote = ` Catatan kehadiran: terdapat ${absent} hari alpa. Diharapkan ananda lebih meningkatkan ketertiban hadir di semester berikutnya.`;
        }

        const baseNote = `Alhamdulillah, Ananda ${studentName} menunjukkan perkembangan karakter dan kesungguhan belajar yang baik di sekolah. Senantiasa istiqomah dalam ibadah yaumiyah, menghormati ustadz/ustadzah, serta rukun dan peduli terhadap teman.`;

        textarea.value = baseNote + attendanceNote;
    }

    function applyAllHomeroomTemplates() {
        const buttons = document.querySelectorAll('button[onclick^="applyHomeroomTemplateSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel Wali Kelas untuk diterapkan template.');
            return;
        }
        buttons.forEach(btn => btn.click());
    }

    async function generateAllHomeroomAi() {
        const buttons = document.querySelectorAll('button[onclick^="generateAiHomeroomSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel Wali Kelas.');
            return;
        }
        if (!confirm('Apakah Anda ingin membuat catatan motivasi wali kelas berbasis AI untuk ' + buttons.length + ' siswa di kelas ini?')) {
            return;
        }
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].click();
            await new Promise(r => setTimeout(r, 800));
        }
    }

    function applyQuranTemplateSingle(studentId, studentName) {
        const textarea = document.getElementById('quran_notes_' + studentId);
        if (!textarea) return;

        const makhrajVal = document.getElementById('quran_makhraj_' + studentId)?.value;
        const tajwidVal = document.getElementById('quran_tajwid_' + studentId)?.value;
        const makhraj = (makhrajVal !== '' && !isNaN(makhrajVal)) ? parseFloat(makhrajVal) : 0;
        const tajwid = (tajwidVal !== '' && !isNaN(tajwidVal)) ? parseFloat(tajwidVal) : 0;
        const achievement = document.getElementById('quran_tahfidz_' + studentId)?.value || 'Juz 30';

        let text = '';
        if (makhraj <= 0 && tajwid <= 0) {
            text = `Belum ada data penilaian tilawah Al-Qur'an dan tahfidz untuk Ananda ${studentName}. Mohon lengkapi penilaian makhraj, tajwid, dan capaian surah/juz.`;
        } else if (makhraj < 70 || tajwid < 70) {
            text = `Ananda ${studentName} memerlukan bimbingan intensif dan latihan talaqqi pada pelafalan makharijul huruf serta ketepatan tajwid. Tingkatkan muraja'ah yaumiyah agar hafalan ${achievement} semakin mutqin.`;
        } else if (makhraj >= 88 && tajwid >= 88) {
            text = `MasyaAllah, Ananda ${studentName} melantunkan ayat Al-Qur'an dengan irama Hijaz Wafa yang sangat merdu, tartil, dan makharijul huruf yang fasih. Capaian ${achievement} sangat baik; pertahankan keistiqomahan muraja'ah.`;
        } else {
            text = `Alhamdulillah, Ananda ${studentName} menunjukkan kelancaran membaca Al-Qur'an dan penguasaan nada Hijaz Wafa yang baik. Terus tingkatkan ketertiban tajwid serta keistiqomahan muraja'ah hafalan ${achievement}.`;
        }
        textarea.value = text;
    }

    function applyAllQuranTemplates() {
        const buttons = document.querySelectorAll('button[onclick^="applyQuranTemplateSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel Al-Qur\'an untuk diterapkan template.');
            return;
        }
        buttons.forEach(btn => btn.click());
    }

    async function generateAllQuranAi() {
        const buttons = document.querySelectorAll('button[onclick^="generateAiQuranSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel Al-Qur\'an.');
            return;
        }
        if (!confirm('Apakah Anda ingin men-generate evaluasi Al-Qur\'an berbasis AI untuk semua ' + buttons.length + ' siswa di kelas ini?')) {
            return;
        }
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].click();
            await new Promise(r => setTimeout(r, 800));
        }
    }

    function generateAiQuranSingle(studentId, studentName) {
        const textarea = document.getElementById('quran_notes_' + studentId);
        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang menyusun evaluasi tahsin & tahfidz Wafa dengan Robbani AI...';
        textarea.disabled = true;

        const level = document.getElementById('quran_level_' + studentId)?.value || 'Buku Wafa 3-4';
        const makhrajVal = document.getElementById('quran_makhraj_' + studentId)?.value;
        const tajwidVal = document.getElementById('quran_tajwid_' + studentId)?.value;
        const makhraj = (makhrajVal !== '' && !isNaN(makhrajVal)) ? parseFloat(makhrajVal) : 0;
        const tajwid = (tajwidVal !== '' && !isNaN(tajwidVal)) ? parseFloat(tajwidVal) : 0;
        const achievement = document.getElementById('quran_tahfidz_' + studentId)?.value || 'Juz 30';

        fetch('{{ route("admin.academic.ai.generate.quran") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                tahsin_level: level,
                makhraj_score: makhraj,
                tajwid_score: tajwid,
                tahfidz_achievement: achievement
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            const content = data.evaluation || data.narrative || data.text;
            if (data.status === 'success' && content) {
                textarea.value = cleanMarkdownForInput(content);
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat evaluasi dengan AI.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    function applyBpiTemplateSingle(studentId, studentName) {
        const textarea = document.getElementById('bpi_notes_' + studentId);
        if (!textarea) return;

        const sklNames = {
            'salimul_aqidah': 'Akidah yang Lurus',
            'shahihul_ibadah': 'Ibadah yang Benar',
            'matinul_khuluq': 'Akhlak yang Mulia',
            'qowiyyul_jismi': 'Kekuatan Fisik & Kesehatan',
            'mutsaqqoful_fikri': 'Wawasan & Pemikiran Luas',
            'qodirun_alal_kasbi': 'Kemandirian',
            'munazzhomun': 'Keteraturan & Disiplin'
        };

        const pbList = [];
        let sbCount = 0;

        ['salimul_aqidah', 'shahihul_ibadah', 'matinul_khuluq', 'qowiyyul_jismi', 'mutsaqqoful_fikri', 'qodirun_alal_kasbi', 'munazzhomun'].forEach(key => {
            const val = document.getElementById('skl_' + studentId + '_' + key)?.value;
            if (val === 'PB') {
                pbList.push(sklNames[key] || key);
            } else if (val === 'SB') {
                sbCount++;
            }
        });

        const sholat = document.getElementById('sholat_' + studentId)?.value || '';

        let text = '';
        if (pbList.length > 0) {
            text = `Ananda ${studentName} memerlukan bimbingan khusus dan pembiasaan berkelanjutan pada aspek ${pbList.join(', ')}. Perlu pendampingan intensif dari orang tua dan pembina dalam pembiasaan ibadah yaumiyah dan penegakan adab islami.`;
        } else if (sbCount >= 5 && sholat.toLowerCase().includes('selalu')) {
            text = `MasyaAllah, Ananda ${studentName} menunjukkan profil kepribadian muslim teladan, kokoh aqidahnya, tertib dalam ibadah yaumiyah, santun dalam berakhlak, serta istiqomah dalam shalat fardhu berjamaah.`;
        } else {
            text = `Alhamdulillah, Ananda ${studentName} menunjukkan perkembangan karakter islami yang baik dan tertib dalam mengikuti pembiasaan ibadah di sekolah. Terus tingkatkan keistiqomahan shalat fardhu dan pembiasaan adab yaumiyah.`;
        }

        textarea.value = text;
    }

    function applyAllBpiTemplates() {
        const buttons = document.querySelectorAll('button[onclick^="applyBpiTemplateSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel BPI untuk diterapkan template.');
            return;
        }
        buttons.forEach(btn => btn.click());
    }

    async function generateAllBpiAi() {
        const buttons = document.querySelectorAll('button[onclick^="generateAiBpiSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di tabel BPI.');
            return;
        }
        if (!confirm('Apakah Anda ingin men-generate evaluasi BPI berbasis AI untuk semua ' + buttons.length + ' siswa di kelas ini?')) {
            return;
        }
        for (let i = 0; i < buttons.length; i++) {
            buttons[i].click();
            await new Promise(r => setTimeout(r, 800));
        }
    }

    function generateAiBpiSingle(studentId, studentName) {
        const textarea = document.getElementById('bpi_notes_' + studentId);
        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang menyusun evaluasi karakter 7 SKL JSIT & BPI dengan Robbani AI...';
        textarea.disabled = true;

        const indicators = {};
        ['salimul_aqidah', 'shahihul_ibadah', 'matinul_khuluq', 'qowiyyul_jismi', 'mutsaqqoful_fikri', 'qodirun_alal_kasbi', 'munazzhomun'].forEach(key => {
            const el = document.getElementById('skl_' + studentId + '_' + key);
            if (el) indicators[key] = el.value;
        });

        const sholat = document.getElementById('sholat_' + studentId)?.value || 'Selalu Berjamaah di Masjid';

        fetch('{{ route("admin.academic.ai.generate.bpi") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                indicators: indicators,
                sholat_fardhu: sholat
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            const content = data.evaluation || data.narrative || data.text || data.note;
            if (data.status === 'success' && content) {
                textarea.value = cleanMarkdownForInput(content);
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat evaluasi BPI dengan AI.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    // AI Generate Batch untuk seluruh siswa di kelas (Sequential dengan delay agar tidak terkena limit)
    async function generateAllNarrativesAi() {
        const buttons = document.querySelectorAll('button[onclick^="generateAiNarrativeSingle"]');
        if (buttons.length === 0) {
            alert('Tidak ada siswa di kelas ini untuk digenerate.');
            return;
        }

        if (!confirm('Apakah Anda ingin men-generate narasi capaian pembelajaran berbasis Robbani AI untuk semua ' + buttons.length + ' siswa di kelas ini?')) {
            return;
        }

        for (let i = 0; i < buttons.length; i++) {
            buttons[i].click();
            // Jeda 800ms antar panggilan agar stabil
            await new Promise(r => setTimeout(r, 800));
        }
    }

    // User Management Modal Functions (Sinkron 100% dengan modalUserManage)
    function openTambahUserModal() {
        const modal = document.getElementById('modalUserManage') || document.getElementById('modalTambahUser');
        const title = document.getElementById('modalUserTitle') || document.getElementById('titleModalUser');
        const idInput = document.getElementById('formUserId') || document.getElementById('input_user_id');
        const nameInput = document.getElementById('formUserName') || document.getElementById('input_user_name');
        const emailInput = document.getElementById('formUserEmail') || document.getElementById('input_user_email');
        const roleSelect = document.getElementById('formUserRole') || document.getElementById('input_user_role');
        const pwdHelp = document.getElementById('pwdHelp') || document.getElementById('user_pwd_help');
        const pwdNotice = document.getElementById('pwdNotice');
        const pwdInput = document.getElementById('formUserPassword') || document.getElementById('input_user_pwd');

        if (title) title.innerText = 'Tambah Pengguna & Guru Baru';
        if (idInput) idInput.value = '';
        if (nameInput) nameInput.value = '';
        if (emailInput) emailInput.value = '';
        if (roleSelect) roleSelect.value = 'TEACHER';
        if (pwdHelp) pwdHelp.classList.add('hidden');
        if (pwdNotice) pwdNotice.innerText = '* (Wajib)';
        if (pwdInput) {
            pwdInput.required = true;
            pwdInput.value = '';
            pwdInput.placeholder = 'Minimal 6 karakter';
        }

        if (modal) modal.classList.remove('hidden');
    }

    function openEditUserModal(arg1, arg2, arg3, arg4) {
        let id, name, email, role;
        if (typeof arg1 === 'object' && arg1 !== null) {
            id = arg1.id;
            name = arg1.name;
            email = arg1.email;
            role = arg1.role;
        } else {
            id = arg1;
            name = arg2;
            email = arg3;
            role = arg4;
        }

        const modal = document.getElementById('modalUserManage') || document.getElementById('modalTambahUser');
        const title = document.getElementById('modalUserTitle') || document.getElementById('titleModalUser');
        const idInput = document.getElementById('formUserId') || document.getElementById('input_user_id');
        const nameInput = document.getElementById('formUserName') || document.getElementById('input_user_name');
        const emailInput = document.getElementById('formUserEmail') || document.getElementById('input_user_email');
        const roleSelect = document.getElementById('formUserRole') || document.getElementById('input_user_role');
        const pwdHelp = document.getElementById('pwdHelp') || document.getElementById('user_pwd_help');
        const pwdNotice = document.getElementById('pwdNotice');
        const pwdInput = document.getElementById('formUserPassword') || document.getElementById('input_user_pwd');

        if (title) title.innerText = 'Edit Data Akun: ' + (name || '');
        if (idInput) idInput.value = id || '';
        if (nameInput) nameInput.value = name || '';
        if (emailInput) emailInput.value = email || '';
        if (roleSelect && role) roleSelect.value = role;
        if (pwdHelp) pwdHelp.classList.remove('hidden');
        if (pwdNotice) pwdNotice.innerText = '(Kosongkan jika tidak ganti password)';
        if (pwdInput) {
            pwdInput.required = false;
            pwdInput.value = '';
            pwdInput.placeholder = 'Kosongkan jika tidak ingin mengubah kata sandi';
        }

        if (modal) modal.classList.remove('hidden');
    }

    function closeUserModal() {
        const modal = document.getElementById('modalUserManage') || document.getElementById('modalTambahUser');
        if (modal) modal.classList.add('hidden');
    }
    // Live calculate for Academic Grid
    function calcRow(studentId) {
        const tpInput = document.getElementById('tp_' + studentId);
        const sasInput = document.getElementById('sas_' + studentId);
        const finalElem = document.getElementById('final_' + studentId);
        const scoreInput = document.getElementById('score_' + studentId);
        const predElem = document.getElementById('pred_' + studentId);

        let tp = tpInput && tpInput.value !== '' ? parseFloat(tpInput.value) : null;
        let sas = sasInput && sasInput.value !== '' ? parseFloat(sasInput.value) : null;
        
        let finalScore = 0;
        if (sas !== null && tp !== null && !isNaN(sas) && !isNaN(tp)) {
            finalScore = Math.round((tp + sas) / 2);
        } else if (sas !== null && !isNaN(sas)) {
            finalScore = sas;
        } else if (tp !== null && !isNaN(tp)) {
            finalScore = tp;
        }

        if (finalElem) finalElem.innerText = Math.round(finalScore);
        if (scoreInput) scoreInput.value = Math.round(finalScore);

        if (predElem) {
            if (finalScore >= 85) {
                predElem.innerText = 'A (Istimewa)';
                predElem.className = 'px-2.5 py-1 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center bg-emerald-100 text-emerald-800 border border-emerald-300';
            } else if (finalScore >= 75) {
                predElem.innerText = 'B (Baik)';
                predElem.className = 'px-2.5 py-1 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center bg-blue-100 text-blue-800 border border-blue-300';
            } else if (finalScore >= 65) {
                predElem.innerText = 'C (Cukup)';
                predElem.className = 'px-2.5 py-1 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center bg-amber-100 text-amber-800 border border-amber-300';
            } else {
                predElem.innerText = 'D (Perlu Bimbingan)';
                predElem.className = 'px-2.5 py-1 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center bg-rose-100 text-rose-800 border border-rose-300';
            }
        }
    }

    // Modal Petunjuk Resmi Penilaian & TP Kurikulum Merdeka
    function bukaModalPetunjukTp() {
        const modal = document.getElementById('modalPetunjukTp');
        if (modal) modal.classList.remove('hidden');
    }

    function tutupModalPetunjukTp() {
        const modal = document.getElementById('modalPetunjukTp');
        if (modal) modal.classList.add('hidden');
    }

    // Modal & Logika Pemilihan Capaian Tujuan Pembelajaran (TP) Per Siswa
    let currentStudentIdForTp = null;
    let currentStudentNameForTp = '';

    function bukaModalPilihTp(studentId, studentName) {
        currentStudentIdForTp = studentId;
        currentStudentNameForTp = studentName;
        
        const titleEl = document.getElementById('modalPilihTpTitle');
        if (titleEl) {
            titleEl.innerText = 'Pilih Capaian TP: ' + studentName;
        }

        // Reset checkbox optimal: centang yang pertama secara default
        const checks = document.querySelectorAll('.tp-optimal-check');
        checks.forEach((c, idx) => {
            c.checked = (idx === 0);
        });

        // Reset radio perlu bimbingan: set ke "Tidak ada"
        const radios = document.querySelectorAll('input[name="tp_need_help"]');
        radios.forEach(r => {
            if (r.value === '') r.checked = true;
        });

        updatePreviewKalimatTp();
        const modal = document.getElementById('modalPilihTp');
        if (modal) modal.classList.remove('hidden');
    }

    function tutupModalPilihTp() {
        const modal = document.getElementById('modalPilihTp');
        if (modal) modal.classList.add('hidden');
    }

    function updatePreviewKalimatTp() {
        const optimalChecks = document.querySelectorAll('.tp-optimal-check:checked');
        const optimalList = Array.from(optimalChecks).map(c => c.value.trim()).filter(Boolean);

        const needHelpRadio = document.querySelector('input[name="tp_need_help"]:checked');
        const needHelp = needHelpRadio ? needHelpRadio.value.trim() : '';

        let previewText = '';
        if (optimalList.length > 0) {
            previewText = 'Menunjukkan penguasaan yang sangat baik dalam ' + optimalList.join(' serta ') + '.';
        } else {
            previewText = 'Menunjukkan penguasaan materi yang baik secara umum.';
        }

        if (needHelp) {
            previewText += ' Namun perlu bimbingan dan pendampingan pada: ' + needHelp + '.';
        } else {
            previewText += ' Mempertahankan capaian pembelajaran yang konsisten dan optimal.';
        }

        const previewEl = document.getElementById('previewKalimatTp');
        if (previewEl) {
            previewEl.value = previewText;
        }
    }

    function terapkanTpKeRapor() {
        if (!currentStudentIdForTp) return;
        const previewEl = document.getElementById('previewKalimatTp');
        const targetTa = document.getElementById('notes_' + currentStudentIdForTp);
        if (targetTa && previewEl) {
            targetTa.value = previewEl.value;
        }
        tutupModalPilihTp();
    }

    // Auto generate standardized Kurikulum Merdeka descriptions with Active TPs / Subject-Specific Syllabus
    function autoGenerateAllDescriptions() {
        const textareas = document.querySelectorAll('textarea[id^="notes_"]');
        const subjectName = '{{ $selectedSubject->name ?? "Mata Pelajaran" }}';
        const sLower = subjectName.toLowerCase();
        const activeTpsData = @json($activeLearningObjectives ?? []);
        let count = 0;

        textareas.forEach(ta => {
            const studentId = ta.id.replace('notes_', '');
            const scoreInput = document.getElementById('score_' + studentId);
            const sasInput = document.getElementById('sas_' + studentId);
            const tpInput = document.getElementById('tp_' + studentId);
            let score = null;
            if (scoreInput && scoreInput.value !== '') {
                score = parseFloat(scoreInput.value);
            } else if (sasInput && sasInput.value !== '') {
                score = parseFloat(sasInput.value);
            } else if (tpInput && tpInput.value !== '') {
                score = parseFloat(tpInput.value);
            }

            let narrative = '';

            // 0. Siswa yang nilainya masih 0 atau belum dinilai tidak boleh mendapatkan narasi pujian palsu
            if (score === null || isNaN(score) || score <= 0) {
                narrative = `Belum ada penilaian capaian kompetensi untuk mata pelajaran ${subjectName} / memerlukan bimbingan intensif dan remedial terpadu.`;
            }
            // 1. Jika guru telah mendefinisikan Tujuan Pembelajaran (TP) aktif untuk mata pelajaran ini
            else if (activeTpsData && activeTpsData.length > 0) {
                const tpFirst = activeTpsData[0]?.short_desc || '';
                const tpSecond = activeTpsData[1]?.short_desc || '';
                const tpLast = activeTpsData[activeTpsData.length - 1]?.short_desc || '';

                if (score >= 88) {
                    narrative = 'Menunjukkan penguasaan yang sangat baik dalam ' + tpFirst + (tpSecond ? ' serta ' + tpSecond : '') + '. Mempertahankan kemandirian belajar yang istimewa.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam ' + tpFirst + '.' + (activeTpsData.length > 1 ? ' Perlu bimbingan dan pendampingan berkelanjutan pada: ' + tpLast + '.' : '');
                } else if (score >= 68) {
                    narrative = 'Cukup menguasai kompetensi dasar dalam ' + tpFirst + ', namun perlu bimbingan dan latihan lebih giat pada: ' + (tpLast || tpFirst) + '.';
                } else {
                    narrative = 'Memerlukan pendampingan intensif dari guru dan orang tua untuk mencapai ketuntasan dalam ' + tpFirst + '.';
                }
            }
            // 2. Fallback ke silabus spesifik nama mata pelajaran jika belum ada data TP kustom
            else if (sLower.includes('agama') || sLower.includes('pai') || sLower.includes('islam')) {
                if (score >= 88) {
                    narrative = 'Menunjukkan penguasaan yang sangat istimewa dalam memahami Asmaul Husna (Ar-Rahman, Ar-Rahim), surah Al-Ikhlas, dan membiasakan adab hidup bersih serta bersyukur.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam memahami surah Al-Ikhlas dan adab bersyukur; santun dan tertib dalam mengikuti pembiasaan ibadah di kelas.';
                } else if (score >= 68) {
                    narrative = 'Cukup menguasai materi Asmaul Husna, namun perlu bimbingan berkelanjutan dalam ketertiban bacaan sholat dan doa harian.';
                } else {
                    narrative = 'Memerlukan pendampingan dan bimbingan terpadu untuk mencapai ketuntasan tujuan pembelajaran utama adab dan rukun iman.';
                }
            } else if (sLower.includes('pancasila') || sLower.includes('pkn')) {
                if (score >= 88) {
                    narrative = 'Menunjukkan penguasaan yang sangat istimewa dalam mengenal simbol sila Pancasila, aturan di rumah dan sekolah, serta aktif menjaga kerukunan.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam memahami aturan di sekolah dan simbol Pancasila; konsisten menerapkan adab antre dan musyawarah.';
                } else if (score >= 68) {
                    narrative = 'Cukup memahami simbol negara, namun perlu pendampingan dalam penerapan aturan kebersamaan dan musyawarah di kelas.';
                } else {
                    narrative = 'Perlu bimbingan dan pembiasaan terpadu untuk menaati tata tertib kelas dan menghargai keberagaman teman.';
                }
            } else if (sLower.includes('indonesia') || sLower.includes('bin')) {
                if (score >= 88) {
                    narrative = 'Sangat terampil dalam menyimak instruksi lisan, bertanya jawab secara santun, serta runtut menceritakan kembali pokok cerita naratif.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan kemampuan yang baik dalam menyimak dan berbicara santun; aktif merespons pertanyaan pemantik dari guru.';
                } else if (score >= 68) {
                    narrative = 'Cukup mampu memahami isi bacaan pendek, namun memerlukan latihan tambahan pada kerapian menulis permulaan dan tanda baca.';
                } else {
                    narrative = 'Memerlukan bimbingan intensif dalam merangkai suku kata dan menyusun kalimat sederhana secara runtut.';
                }
            } else if (sLower.includes('matematika') || sLower.includes('mtk')) {
                if (score >= 88) {
                    narrative = 'Menunjukkan penguasaan yang sangat istimewa dalam pengukuran panjang satuan tidak baku, membaca data piktogram, serta bernalar logis mandiri.';
                } else if (score >= 78) {
                    narrative = 'Mampu membandingkan panjang objek secara langsung dan memahami konsep penjumlahan bilangan cacah dengan baik.';
                } else if (score >= 68) {
                    narrative = 'Cukup memahami perbandingan panjang benda, namun perlu pendampingan bertahap pada operasi hitung pengurangan bertingkat.';
                } else {
                    narrative = 'Perlu bimbingan intensif dan penggunaan benda konkret dalam menyelesaikan operasi dasar matematika.';
                }
            } else if (sLower.includes('tari') || sLower.includes('seni tari')) {
                if (score >= 88) {
                    narrative = 'Sangat terampil meragakan koordinasi gerak tari sesuai irama, berekspresi percaya diri, dan menjaga norma kesopanan islami.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam meragakan ragam gerak tari dan antusias mengikuti latihan berpasangan.';
                } else if (score >= 68) {
                    narrative = 'Cukup mampu mengikuti tempo gerak tari, namun perlu penguatan kelenturan tubuh dan percaya diri.';
                } else {
                    narrative = 'Memerlukan bimbingan berkelanjutan dalam menyelaraskan gerak tubuh dengan ketukan irama.';
                }
            } else if (sLower.includes('pjok') || sLower.includes('olahraga')) {
                if (score >= 88) {
                    narrative = 'Sangat terampil mempraktikkan gerak dasar lokomotor dan non-lokomotor serta konsisten membiasakan gaya hidup sehat aktif.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam koordinasi pola gerak dasar dan antusias dalam berolahraga teratur.';
                } else if (score >= 68) {
                    narrative = 'Cukup aktif dalam aktivitas fisik, namun perlu bimbingan pada ketepatan gerak manipulatif melempar dan menangkap.';
                } else {
                    narrative = 'Memerlukan pendampingan untuk meningkatkan daya tahan jasmani dan keberanian bergerak aktif.';
                }
            } else if (sLower.includes('inggris') || sLower.includes('english')) {
                if (score >= 88) {
                    narrative = 'Sangat cakap menyebutkan kosakata angka 1-10, hewan peliharaan, serta santun mengucapkan sapaan sehari-hari.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam menghafal kosakata dasar dan merespons instruksi sederhana dalam bahasa Inggris.';
                } else if (score >= 68) {
                    narrative = 'Cukup menguasai kosakata benda sekitar, namun perlu dorongan untuk berani melafalkannya secara mandiri.';
                } else {
                    narrative = 'Memerlukan latihan bertahap dalam pengenalan bunyi kata dan pelafalan kosakata dasar bahasa Inggris.';
                }
            } else if (sLower.includes('koding') || sLower.includes('kka') || sLower.includes('komputer')) {
                if (score >= 88) {
                    narrative = 'Sangat unggul dalam memahami pola logika urutan algoritma visual dan memanfaatkan media digital secara cerdas beradab.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam menyusun blok perintah digital sederhana dan berdisiplin di lab komputer.';
                } else if (score >= 68) {
                    narrative = 'Cukup memahami pengenalan perangkat, namun perlu pendampingan dalam logika penyelesaian pola bertingkat.';
                } else {
                    narrative = 'Memerlukan pendampingan dasar dalam pengoperasian antarmuka komputer dan instruksi digital.';
                }
            } else if (sLower.includes('arab')) {
                if (score >= 88) {
                    narrative = 'Sangat fasih melafalkan mufradat anggota tubuh, perlengkapan sekolah, dan menyapa dengan ungkapan islami.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan yang baik dalam mengenal kosakata dasar bahasa Arab dan antusias menirukan pelafalan.';
                } else if (score >= 68) {
                    narrative = 'Cukup mengenal arti mufradat dasar, namun perlu penguatan pada pengucapan makhraj huruf arab.';
                } else {
                    narrative = 'Memerlukan bimbingan bertahap dalam mengingat arti kata dan bunyi kosakata bahasa Arab harian.';
                }
            } else if (sLower.includes('tahsin') || sLower.includes('wafa')) {
                if (score >= 88) {
                    narrative = 'Sangat istimewa dalam melantunkan ayat suci dengan nada Hijaz Wafa yang tertib makhraj serta tartil.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan penguasaan tilawah yang baik dan tertib tajwid; antusias dan tertib dalam halaqah Al-Qur\'an.';
                } else if (score >= 68) {
                    narrative = 'Cukup lancar membaca ayat, namun perlu pendampingan pada konsistensi mad thobi\'i 2 harakat.';
                } else {
                    narrative = 'Memerlukan talaqqi intensif untuk meluruskan makharijul huruf hijaiyah bersambung.';
                }
            } else if (sLower.includes('tahfidz')) {
                if (score >= 88) {
                    narrative = 'Menunjukkan hafalan surah Juz 30 yang sangat mutqin, lancar tanpa keraguan, dan istiqamah dalam muraja\'ah.';
                } else if (score >= 78) {
                    narrative = 'Menunjukkan kelancaran ziyadah hafalan yang baik dan konsisten mengulang hafalan di sekolah.';
                } else if (score >= 68) {
                    narrative = 'Cukup baik dalam hafalan surah pendek, namun perlu pendampingan muraja\'ah teratur di rumah.';
                } else {
                    narrative = 'Memerlukan bimbingan intensif dan jadwal muraja\'ah khusus bersama orang tua di rumah.';
                }
            } else {
                if (score >= 88) {
                    narrative = `Menunjukkan penguasaan yang sangat istimewa pada capaian pembelajaran ${subjectName}, aktif bernalar kritis, dan mandiri menyelesaikan tugas.`;
                } else if (score >= 78) {
                    narrative = `Menunjukkan penguasaan yang baik pada materi pokok ${subjectName}; rajin dan konsisten mengikuti KBM.`;
                } else if (score >= 68) {
                    narrative = `Cukup menguasai capaian pembelajaran ${subjectName}, namun memerlukan latihan pada soal aplikasi terapan.`;
                } else {
                    narrative = `Memerlukan bimbingan dan remedial terpadu untuk mencapai ketuntasan kompetensi utama ${subjectName}.`;
                }
            }

            ta.value = narrative;
            count++;
        });

        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Generate Narasi',
                text: 'Narasi capaian pembelajaran spesifik ' + subjectName + ' berhasil dibuat untuk ' + count + ' siswa!',
                timer: 1800,
                showConfirmButton: false
            });
        }
    }

    // Dynamic Kop Image Preview when file selected
    function previewKopImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('preview_kop_container');
                if (container) {
                    container.innerHTML = '<img src="' + e.target.result + '" class="w-full max-h-28 object-contain mx-auto" alt="Preview Kop">';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Live preview update for Report Settings text
    function updatePreview() {
        const cityText = document.getElementById('setting_city');
        const dateText = document.getElementById('setting_date');
        const princText = document.getElementById('setting_principal');
        const nipText = document.getElementById('setting_nip');

        if (cityText && document.getElementById('preview_city')) {
            document.getElementById('preview_city').innerText = cityText.value;
        }
        if (dateText && document.getElementById('preview_date')) {
            document.getElementById('preview_date').innerText = dateText.value;
        }
        if (princText && document.getElementById('preview_principal')) {
            document.getElementById('preview_principal').innerText = princText.value;
        }
        if (nipText && document.getElementById('preview_nip')) {
            document.getElementById('preview_nip').innerText = nipText.value;
        }
    }

    // Live preview update for Signature & Stamp visibility mode
    function updatePreviewSigMode(mode) {
        const stamp = document.getElementById('preview_stamp_img');
        const sig = document.getElementById('preview_sig_img');
        const placeholder = document.getElementById('preview_sig_placeholder');
        const showStamp = (mode === 'both' || mode === 'stamp_only');
        const showSig = (mode === 'both' || mode === 'ttd_has_stamp' || mode === 'ttd_only');
        
        if (stamp) stamp.classList.toggle('hidden', !showStamp);
        if (sig) sig.classList.toggle('hidden', !showSig);
        if (placeholder) {
            const anyVisible = (stamp && showStamp) || (sig && showSig);
            placeholder.classList.toggle('hidden', anyVisible);
        }
    }

    // =========================================================================
    // FITUR AUTO-SAVE & PENYIMPANAN SEMENTARA (DRAFT PERSISTENCE PADA REFRESH)
    // =========================================================================
    document.addEventListener('DOMContentLoaded', function() {
        const activeMenu = '{{ $activeMenu ?? "dashboard" }}';
        const schoolId = '{{ $schoolId ?? 1 }}';
        const classroomId = '{{ $selectedClassroomId ?? 0 }}';
        const subjectId = '{{ $selectedSubjectId ?? 0 }}';

        // Hanya aktif pada tab pengisian nilai & catatan
        const inputMenus = ['academic', 'quran', 'character', 'notes'];
        if (!inputMenus.includes(activeMenu)) return;

        const draftKey = `smartedu_draft_${activeMenu}_${schoolId}_${classroomId}_${subjectId}`;
        const activeForm = document.querySelector('form[action*="grades/batch"], form[action*="grades/quran/batch"], form[action*="grades/character/batch"], form[action*="grades/homeroom/batch"]');
        if (!activeForm) return;

        // 1. Cek & Pulihkan Draf jika Ada
        try {
            const savedDraft = localStorage.getItem(draftKey);
            if (savedDraft) {
                const draftData = JSON.parse(savedDraft);
                if (draftData && draftData.fields && Object.keys(draftData.fields).length > 0) {
                    let restoreCount = 0;
                    Object.entries(draftData.fields).forEach(([name, val]) => {
                        const field = activeForm.elements[name];
                        if (field && field.value !== val) {
                            field.value = val;
                            restoreCount++;
                            // Trigger calculation jika form akademik
                            if (name.includes('[score_tp]') || name.includes('[score_sas]')) {
                                const idMatch = name.match(/\[(\d+)\]/);
                                if (idMatch && typeof calcRow === 'function') {
                                    calcRow(idMatch[1]);
                                }
                            }
                        }
                    });

                    if (restoreCount > 0) {
                        // Tampilkan banner notifikasi pemulihan draf
                        const alertDiv = document.createElement('div');
                        alertDiv.id = 'draftRecoveryBanner';
                        alertDiv.className = 'mb-4 p-3.5 bg-amber-50 border border-amber-300 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-amber-900 font-bold shadow-xs';
                        alertDiv.innerHTML = `
                            <div class="flex items-center gap-2">
                                <span class="text-base">💾</span>
                                <span><strong>Draf Pengisian Dipulihkan Otomatis:</strong> Ada data ketikan yang belum tersimpan ke server (${draftData.time || 'baru saja'}).</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span id="autoSaveIndicator" class="text-[10px] text-amber-700 font-bold">Auto-Save Aktif ✓</span>
                                <button type="button" onclick="discardLocalDraft('${draftKey}')" class="px-2.5 py-1 bg-amber-200 hover:bg-amber-300 text-amber-950 font-black rounded-lg text-[11px] cursor-pointer transition">
                                    Hapus Draf
                                </button>
                            </div>
                        `;
                        activeForm.parentNode.insertBefore(alertDiv, activeForm);
                    }
                }
            }
        } catch (e) {
            console.warn('Gagal memulihkan draf lokal:', e);
        }

        // 2. Debounced Auto-Save Listener
        let autoSaveTimer = null;
        activeForm.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                const fields = {};
                const elements = activeForm.elements;
                for (let i = 0; i < elements.length; i++) {
                    const el = elements[i];
                    if (el.name && el.name.startsWith(activeMenu) || el.name.startsWith('grades[') || el.name.startsWith('quran[') || el.name.startsWith('character[') || el.name.startsWith('notes[')) {
                        fields[el.name] = el.value;
                    }
                }

                const now = new Date();
                const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                localStorage.setItem(draftKey, JSON.stringify({
                    time: timeStr,
                    fields: fields
                }));

                // Update visual status
                let ind = document.getElementById('autoSaveIndicator');
                if (!ind) {
                    const headerToolbar = activeForm.querySelector('.bg-slate-50');
                    if (headerToolbar) {
                        ind = document.createElement('span');
                        ind.id = 'autoSaveIndicator';
                        ind.className = 'text-[11px] text-emerald-800 font-bold bg-emerald-100 px-2.5 py-1 rounded-lg border border-emerald-300 inline-flex items-center gap-1';
                        headerToolbar.appendChild(ind);
                    }
                }
                if (ind) {
                    ind.innerHTML = `💾 Draf tersimpan lokal (${timeStr})`;
                }
            }, 500);
        });

        // 3. Hapus Draf Saat Form Berhasil Disimpan / Submit
        activeForm.addEventListener('submit', function() {
            localStorage.removeItem(draftKey);
        });
    });

    function discardLocalDraft(key) {
        if (confirm('Apakah Anda yakin ingin membuang draf lokal ini dan memuat ulang data server asli?')) {
            localStorage.removeItem(key);
            window.location.reload();
        }
    }
</script>
@endsection
