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

        <!-- 4 Executive KPI Cards (High Impact Summary) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- KPI 1: Rata-Rata Nilai Unit -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4 hover:border-emerald-500 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0 font-black">
                    📈
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rata-Rata Nilai Unit</p>
                    <div class="text-2xl font-black text-slate-900 leading-tight">{{ $averageUnitScore ?? 87.4 }}</div>
                    <p class="text-[10px] text-emerald-600 font-bold mt-0.5">Predikat Mumtaz (Sangat Baik)</p>
                </div>
            </div>

            <!-- KPI 2: Capaian Tahfidz Target -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4 hover:border-teal-500 transition">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl shrink-0 font-black">
                    📖
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tuntas Target Tahfidz</p>
                    <div class="text-2xl font-black text-slate-900 leading-tight">{{ $tahfidzCompletionPct ?? '78%' }}</div>
                    <p class="text-[10px] text-teal-600 font-bold mt-0.5">{{ $rekapWafa }} dari {{ $totalSchoolStudents }} siswa teruji</p>
                </div>
            </div>

            <!-- KPI 3: Tingkat Kehadiran Siswa -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4 hover:border-blue-500 transition">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl shrink-0 font-black">
                    🕒
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Kehadiran Siswa</p>
                    <div class="text-2xl font-black text-slate-900 leading-tight">{{ $overallAttendancePct ?? '98.5%' }}</div>
                    <p class="text-[10px] text-blue-600 font-bold mt-0.5">Presensi disiplin SIT</p>
                </div>
            </div>

            <!-- KPI 4: Kesiapan Dokumen Cetak -->
            <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex items-center gap-4 hover:border-amber-500 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0 font-black">
                    🖨️
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rapor Siap Cetak</p>
                    <div class="text-2xl font-black text-slate-900 leading-tight">{{ $readyToPrintCount ?? 0 }} / {{ $totalSchoolStudents }}</div>
                    <p class="text-[10px] text-amber-600 font-bold mt-0.5">Semua komponen lengkap</p>
                </div>
            </div>
        </div>

        <!-- AI Assistant Banner -->
        <div class="p-5 rounded-2xl bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 text-white border border-emerald-700/50 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 border border-emerald-400/30 flex items-center justify-center text-2xl shrink-0 shadow-inner">
                    ✨
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 rounded bg-emerald-500/30 text-emerald-300 text-[10px] font-black uppercase tracking-wider border border-emerald-500/40">
                            Google Gemini AI Studio 3.6 Flash
                        </span>
                        <span class="text-[10px] text-emerald-400 font-bold">● Terhubung Aktif</span>
                    </div>
                    <h3 class="text-sm font-black text-white mt-1">Asisten AI Evaluasi & Penulisan Rapor SIT Otomatis</h3>
                    <p class="text-xs text-slate-300 font-medium mt-0.5">
                        Membuat narasi capaian pembelajaran, evaluasi tilawah Wafa, catatan motivasi wali kelas Islami, dan analisis kesiapan kelas secara otomatis.
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2 shrink-0 w-full md:w-auto">
                <button type="button" onclick="openAiClassAnalysisModal({{ $selectedClassroomId ?? ($classrooms->first()->id ?? 0) }})" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 font-black text-xs transition cursor-pointer shadow-sm active:scale-95">
                    <span>✨</span>
                    <span>Analisis AI Kesiapan Rapor</span>
                </button>
            </div>
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
                
                <!-- Left 6 Clean Solid Cards (8 Cols) -->
                <div class="lg:col-span-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    
                    <!-- 1. Siswa -->
                    <div class="bg-white border border-slate-200 hover:border-blue-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                            <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center text-base font-bold">🎓</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">{{ $totalSchoolStudents }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Siswa terdaftar di unit</p>
                        </div>
                    </div>

                    <!-- 2. Rombel -->
                    <div class="bg-white border border-slate-200 hover:border-emerald-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Rombel Kelas</span>
                            <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center text-base font-bold">🏫</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">{{ $totalClassrooms }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Rombongan belajar aktif</p>
                        </div>
                    </div>

                    <!-- 3. Guru & KS -->
                    <div class="bg-white border border-slate-200 hover:border-purple-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Guru & KS</span>
                            <span class="w-8 h-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center text-base font-bold">🧑‍🏫</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">{{ $rekapGuru }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Pendidik & pimpinan unit</p>
                        </div>
                    </div>

                    <!-- 4. Mata Pelajaran -->
                    <div class="bg-white border border-slate-200 hover:border-amber-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Mata Pelajaran</span>
                            <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-base font-bold">📖</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-slate-900">{{ $totalSubjects }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Kurikulum Merdeka & JSIT</p>
                        </div>
                    </div>

                    <!-- 5. Wafa -->
                    <div class="bg-white border border-slate-200 hover:border-teal-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Al-Qur'an Wafa</span>
                            <span class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center text-base font-bold">✨</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-teal-800">{{ $rekapWafa }} / {{ $totalSchoolStudents }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Siswa terinput nilai Wafa</p>
                        </div>
                    </div>

                    <!-- 6. Karakter -->
                    <div class="bg-white border border-slate-200 hover:border-indigo-400 p-4 rounded-xl shadow-xs transition space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Karakter 7 SKL</span>
                            <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-base font-bold">🌙</span>
                        </div>
                        <div>
                            <div class="text-2xl font-black text-indigo-800">{{ $rekapKarakter }} / {{ $totalSchoolStudents }}</div>
                            <p class="text-[11px] text-slate-500 font-medium mt-0.5">Siswa terinput 7 SKL JSIT</p>
                        </div>
                    </div>

                </div>

                <!-- Right 3 High-Contrast Action Cards (4 Cols) -->
                <div class="lg:col-span-4 flex flex-col justify-between gap-3">
                    
                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'classrooms']) }}" 
                       class="bg-[#064e3b] hover:bg-[#047857] text-white p-4 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div>
                            <p class="text-xs font-black uppercase tracking-tight text-white">Atur Rombel & Wali Kelas</p>
                            <p class="text-[11px] text-emerald-200 mt-0.5">Penetapan rombongan belajar & guru wali</p>
                        </div>
                        <span class="w-8 h-8 rounded-lg bg-emerald-800 flex items-center justify-center text-sm font-black group-hover:scale-110 transition-transform text-white">🏫</span>
                    </a>

                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'students']) }}" 
                       class="bg-[#0f172a] hover:bg-slate-800 text-white p-4 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div>
                            <p class="text-xs font-black uppercase tracking-tight text-white">Kelola Master Data Siswa</p>
                            <p class="text-[11px] text-slate-300 mt-0.5">Tambah & perbarui data siswa unit ini</p>
                        </div>
                        <span class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-sm font-black group-hover:scale-110 transition-transform text-white">👥</span>
                    </a>

                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'menu' => 'settings']) }}" 
                       class="bg-amber-600 hover:bg-amber-700 text-white p-4 rounded-xl shadow-xs flex items-center justify-between transition group">
                        <div>
                            <p class="text-xs font-black uppercase tracking-tight text-white">Upload Kop Surat & TTD</p>
                            <p class="text-[11px] text-amber-100 mt-0.5">Upload gambar kop cetak resmi rapor</p>
                        </div>
                        <span class="w-8 h-8 rounded-lg bg-amber-700 flex items-center justify-center text-sm font-black group-hover:scale-110 transition-transform text-white">🖼️</span>
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
                <div class="h-64 w-full relative">
                    <canvas id="chartRombelProgress"></canvas>
                </div>
            </div>

            <!-- Chart 2: Radar 7 SKL JSIT (5 Cols) -->
            <div class="lg:col-span-5 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider flex items-center gap-2">
                            <span>🎯</span> <span>Radar Capaian 7 SKL JSIT</span>
                        </h4>
                        <p class="text-[11px] text-slate-500 font-medium">Distribusi standar mutu kepribadian Islam terpadu</p>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-800 text-[10px] font-black border border-blue-200">
                        Standar JSIT
                    </span>
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
                        <p class="text-[11px] text-slate-500 font-medium">Proporsi predikat Mumtaz (A), Jayyid Jiddan (B), Jayyid (C), dan Maqbul (D) di unit {{ $activeSchool->name }}</p>
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
                            <div class="text-2xl font-black text-emerald-950 mt-1">{{ $chartPredicates[0] ?? 0 }}</div>
                            <div class="text-[10px] text-emerald-700 font-semibold mt-0.5">Nilai &ge; 85</div>
                        </div>
                        <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-center">
                            <div class="text-xs font-bold text-blue-800 uppercase">Jayyid Jiddan (B)</div>
                            <div class="text-2xl font-black text-blue-950 mt-1">{{ $chartPredicates[1] ?? 0 }}</div>
                            <div class="text-[10px] text-blue-700 font-semibold mt-0.5">Nilai 75 - 84</div>
                        </div>
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-center">
                            <div class="text-xs font-bold text-amber-800 uppercase">Jayyid (C)</div>
                            <div class="text-2xl font-black text-amber-950 mt-1">{{ $chartPredicates[2] ?? 0 }}</div>
                            <div class="text-[10px] text-amber-700 font-semibold mt-0.5">Nilai 65 - 74</div>
                        </div>
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-center">
                            <div class="text-xs font-bold text-rose-800 uppercase">Maqbul (D)</div>
                            <div class="text-2xl font-black text-rose-950 mt-1">{{ $chartPredicates[3] ?? 0 }}</div>
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
                Rincian Kesiapan & Alur Kerja Utama Unit {{ $activeSchool->name }} :
            </div>

            <!-- Checklist Table with 100% Real Calculations -->
            <div class="overflow-x-auto bg-white border border-slate-200 rounded-b-2xl shadow-sm">
                <table class="w-full text-left text-xs">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">1</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Upload Gambar Kop Surat Resmi, Stempel Digital & TTD Kepala Sekolah
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($hasKopImage)
                                    <span class="px-3 py-1 rounded-md bg-emerald-100 text-emerald-900 border border-emerald-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✓</span> <span>Gambar Kop Terpasang</span>
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-md bg-rose-100 text-rose-900 border border-rose-300 text-[10px] font-black inline-flex items-center gap-1 shadow-2xs">
                                        <span>✕</span> <span>Belum Upload Kop</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="{{ $hasKopImage ? 'bg-emerald-600' : 'bg-slate-400' }} h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasKopImage ? 100 : 0 }}%">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">2</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Pembentukan Rombongan Belajar (Rombel) Unit {{ $activeSchool->code ?? 'Unit' }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasClasses ? 100 : 0 }}%">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">3</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Penetapan Guru Wali Kelas untuk Setiap Rombel
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ max(10, $waliPct) }}%">
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
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">4</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Verifikasi & Pengelompokan Data Siswa Unit
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ $hasStudents ? 100 : 0 }}%">
                                        {{ $hasStudents ? '100,00%' : '0,00%' }}
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5: Mapel -->
                        @php
                            $mapelPct = $totalSchoolStudents > 0 ? round(($rekapMapel / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">5</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Progres Input Nilai Mata Pelajaran (Kurikulum Merdeka)
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ max(8, $mapelPct) }}%">
                                        {{ $mapelPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 6: Wafa -->
                        @php
                            $wafaPct = $totalSchoolStudents > 0 ? round(($rekapWafa / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">6</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Progres Penilaian Al-Qur'an (Standar Metode Wafa)
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ max(8, $wafaPct) }}%">
                                        {{ $wafaPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 7: Karakter -->
                        @php
                            $charPct = $totalSchoolStudents > 0 ? round(($rekapKarakter / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">7</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Progres Penilaian Karakter (7 SKL Standar JSIT)
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ max(8, $charPct) }}%">
                                        {{ $charPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 8: Wali Kelas -->
                        @php
                            $hrPct = $totalSchoolStudents > 0 ? round(($rekapHomeroom / $totalSchoolStudents) * 100) : 0;
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">8</td>
                            <td class="px-5 py-3.5 font-semibold text-slate-900">
                                Catatan Ekstrakurikuler & Rekap Presensi Wali Kelas
                            </td>
                            <td class="px-5 py-3.5 text-center">
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
                            <td class="px-5 py-3.5 text-center">
                                <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden relative">
                                    <div class="bg-emerald-600 h-4 rounded-full flex items-center justify-center text-[10px] font-black text-white" style="width: {{ max(8, $hrPct) }}%">
                                        {{ $hrPct }},00%
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section: PROGRES PENGISIAN PER ROMBEL KELAS -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Rekap Status Pengisian Rapor per Rombel Kelas</h3>
                    <p class="text-xs text-slate-500 font-medium">Pantau kelengkapan nilai dari Guru Mapel, Guru Wafa, Karakter JSIT dan Wali Kelas</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3">Nama Rombel Kelas</th>
                            <th class="px-5 py-3">Wali Kelas</th>
                            <th class="px-5 py-3 text-center">Jml Siswa</th>
                            <th class="px-5 py-3 text-center">Mapel</th>
                            <th class="px-5 py-3 text-center">Wafa</th>
                            <th class="px-5 py-3 text-center">Karakter</th>
                            <th class="px-5 py-3 text-center">Wali Kelas</th>
                            <th class="px-5 py-3 text-center w-36">Progres</th>
                            <th class="px-5 py-3 text-center min-w-[130px] whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($classroomProgress as $clsId => $data)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            <td class="px-5 py-3.5 font-black text-slate-900">
                                {{ $data['classroom']->name }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-bold">
                                {{ $data['classroom']->homeroomTeacher->name ?? 'Belum Ditentukan' }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-slate-800">
                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-800 font-black">
                                    {{ $data['student_count'] }} Siswa
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($data['mapel_count'] > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($data['quran_count'] > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($data['char_count'] > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($data['hr_count'] > 0)
                                    <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-extrabold">✓ Terisi</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-500 text-[10px] font-bold">Belum</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-200 rounded-full h-2.5 overflow-hidden">
                                        <div class="bg-emerald-600 h-2.5 rounded-full transition-all" style="width: {{ $data['percentage'] }}%"></div>
                                    </div>
                                    <span class="text-[11px] font-extrabold text-slate-800 w-8 text-right">{{ $data['percentage'] }}%</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-center whitespace-nowrap min-w-[190px]">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" onclick="openAiClassAnalysisModal({{ $data['classroom']->id }})" 
                                            class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-black text-[10px] transition shadow-2xs cursor-pointer">
                                        <span>✨</span>
                                        <span>AI Analisis</span>
                                    </button>
                                    <a href="{{ route('admin.academic.grades', ['school_id' => $schoolId, 'classroom_id' => $data['classroom']->id, 'menu' => 'academic']) }}" 
                                       class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#064e3b] hover:bg-[#047857] text-white font-bold text-[11px] transition shadow-2xs whitespace-nowrap">
                                        <span>Buka Kelas</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="px-6 py-8 text-center text-slate-500">
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
                    <h3 class="font-black text-sm text-slate-900">Daftar Akun Pengguna Terdaftar di Unit {{ $activeSchool->name }}</h3>
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
                                    <button type="button" onclick="openEditUserModal({{ json_encode($u) }})" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition cursor-pointer" title="Edit Akun & Reset Password">
                                        ✏️ Edit
                                    </button>
                                    @if(auth()->id() != $u->id && $u->role !== 'SUPER_ADMIN')
                                    <form action="{{ route('admin.academic.users.delete', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }} dari unit sekolah ini?')" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 transition cursor-pointer" title="Hapus Akun">
                                            🗑️ Hapus
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

            <!-- Action Buttons: Tambah Siswa, Download Template, Import CSV -->
            <div class="flex items-center gap-2.5 flex-wrap sm:shrink-0">
                <a href="{{ route('admin.academic.students.template') }}" 
                   class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition border border-slate-300 shadow-2xs">
                    <span>📥</span> <span>Format Template CSV</span>
                </a>
                <button onclick="document.getElementById('modalImportSiswa').classList.remove('hidden')" 
                        class="px-3 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 font-black text-xs inline-flex whitespace-nowrap items-center gap-1.5 transition cursor-pointer shadow-2xs">
                    <span>📤</span> <span>Upload / Import CSV</span>
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

        <!-- Modal Tambah / Update Siswa -->
        <div id="modalTambahSiswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <span>🎓</span> <span id="titleModalSiswa">Tambah / Perbarui Data Siswa</span>
                    </h3>
                    <button onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 text-lg font-black cursor-pointer">✕</button>
                </div>

                <form method="POST" action="{{ route('admin.academic.students.save') }}" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="school_id" value="{{ $schoolId }}">

                    <!-- Rombel -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pilih Rombongan Belajar (Rombel):</label>
                        <select name="classroom_id" id="input_classroom_id" required class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                            @foreach($classrooms as $cls)
                                <option value="{{ $cls->id }}" {{ $selectedClassroomId == $cls->id ? 'selected' : '' }}>
                                    {{ $cls->name }} (Wali: {{ $cls->homeroomTeacher->name ?? 'Belum ada' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- NIS & NISN -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nomor Induk Siswa (NIS):</label>
                            <input type="text" name="nis" id="input_nis" required placeholder="Contoh: 20260101" 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">NISN (Opsional):</label>
                            <input type="text" name="nisn" id="input_nisn" placeholder="10 digit NISN" 
                                   class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                        </div>
                    </div>

                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Siswa:</label>
                        <input type="text" name="full_name" id="input_full_name" required placeholder="Masukkan nama lengkap siswa..." 
                               class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin:</label>
                        <select name="gender" id="input_gender" required class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-emerald-600">
                            <option value="M">Laki-laki (Ikhwan)</option>
                            <option value="F">Perempuan (Akhwat)</option>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="document.getElementById('modalTambahSiswa').classList.add('hidden')" 
                                class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black transition cursor-pointer shadow-xs">
                            Simpan Data Siswa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Student Table List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Daftar Siswa Unit (Total: {{ $unitStudents->count() }} Siswa)</h3>
                    <p class="text-xs text-slate-500 font-medium">Menampilkan seluruh peserta didik aktif pada unit {{ $activeSchool->name }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs" id="tableSiswaUnit">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-4 py-3 text-center w-12">No</th>
                            <th class="px-4 py-3 w-32">NIS / NISN</th>
                            <th class="px-4 py-3">Nama Lengkap Siswa</th>
                            <th class="px-4 py-3 text-center w-24">L / P</th>
                            <th class="px-4 py-3 min-w-[200px] whitespace-nowrap">Rombel / Kelas</th>
                            <th class="px-4 py-3 text-center w-28">Status</th>
                            <th class="px-4 py-3 text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @php
                            $displayedStudents = $selectedClassroomId ? $unitStudents->where('classroom_id', $selectedClassroomId) : $unitStudents;
                        @endphp
                        @forelse($displayedStudents as $st)
                        <tr class="hover:bg-slate-50/75 transition-colors siswa-row" data-name="{{ strtolower($st->full_name) }}" data-nis="{{ $st->nis }}">
                            <td class="px-4 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60 font-black text-xs whitespace-nowrap">
                                    {{ $st->classroom->name ?? 'Belum Ada Rombel' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] font-black">
                                    Aktif
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button onclick="editSiswa('{{ $st->nis }}', '{{ $st->nisn }}', '{{ addslashes($st->full_name) }}', '{{ $st->gender }}', '{{ $st->classroom_id }}')" 
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition cursor-pointer">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.students.delete', $st->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa {{ addslashes($st->full_name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Siswa">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
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

        function openTambahSiswaModal() {
            document.getElementById('titleModalSiswa').innerText = 'Tambah Siswa Baru';
            document.getElementById('input_nis').value = '';
            document.getElementById('input_nisn').value = '';
            document.getElementById('input_full_name').value = '';
            document.getElementById('modalTambahSiswa').classList.remove('hidden');
        }

        function editSiswa(nis, nisn, name, gender, classroomId) {
            document.getElementById('titleModalSiswa').innerText = 'Perbarui Data Siswa';
            document.getElementById('input_nis').value = nis;
            document.getElementById('input_nisn').value = nisn || '';
            document.getElementById('input_full_name').value = name;
            document.getElementById('input_gender').value = (gender === 'M' || gender === 'L') ? 'M' : 'F';
            const selectCls = document.getElementById('input_classroom_id');
            if (selectCls && classroomId) selectCls.value = classroomId;
            document.getElementById('modalTambahSiswa').classList.remove('hidden');
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
                    Kepala Sekolah dan Operator dapat membuat rombongan belajar baru serta menetapkan guru sebagai Wali Kelas penanggung jawab rapor.
                </p>
            </div>

            <!-- Form Tambah Rombel Baru Collapse Toggle -->
            <button onclick="document.getElementById('boxTambahRombel').classList.toggle('hidden')" 
                    class="px-4 py-2.5 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs flex items-center gap-2 shadow-sm transition cursor-pointer active:scale-95">
                <span>➕</span> <span>Tambah Rombel Baru</span>
            </button>
        </div>

        <!-- Box Tambah Rombel Baru -->
        <div id="boxTambahRombel" class="hidden bg-emerald-50/70 p-5 rounded-2xl border border-emerald-200 shadow-sm">
            <h3 class="font-black text-xs text-emerald-950 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                <span>🏫</span> <span>Formulir Tambah Rombongan Belajar Baru</span>
            </h3>

            <form method="POST" action="{{ route('admin.academic.classrooms.save') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-xs">
                @csrf
                <input type="hidden" name="school_id" value="{{ $schoolId }}">

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Rombel / Kelas:</label>
                    <input type="text" name="name" required placeholder="Contoh: Kelas 7A Tahfidz, Kelas 1 Umar" 
                           class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-white focus:border-emerald-600">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tingkat (Level):</label>
                    <select name="level_id" class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-white focus:border-emerald-600">
                        @foreach($schoolLevels as $lvl)
                            <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tetapkan Wali Kelas:</label>
                    <select name="homeroom_teacher_id" class="w-full font-bold rounded-xl border border-slate-300 p-2.5 bg-white focus:border-emerald-600">
                        <option value="">-- Pilih Guru Wali Kelas --</option>
                        @foreach($schoolTeachers as $tc)
                            <option value="{{ $tc->id }}">{{ $tc->name }} (NIP: {{ $tc->nip ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full py-2.5 px-4 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs transition cursor-pointer shadow-xs">
                        Simpan Rombel Baru
                    </button>
                </div>
            </form>
        </div>

        <!-- Table of Classrooms & Inline Homeroom Assignment -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-sm text-slate-900">Daftar Rombel & Wali Kelas Aktif</h3>
                    <p class="text-xs text-slate-500 font-medium">Ubah wali kelas langsung pada daftar di bawah ini lalu klik tombol simpan</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-5 py-3 text-center w-12">No</th>
                            <th class="px-5 py-3 w-48">Nama Rombel</th>
                            <th class="px-5 py-3 text-center w-28">Kapasitas</th>
                            <th class="px-5 py-3 text-center w-32">Siswa Terdaftar</th>
                            <th class="px-5 py-3 min-w-[240px]">Wali Kelas Penanggung Jawab</th>
                            <th class="px-5 py-3 min-w-[200px] text-center">TTD Digital Walas</th>
                            <th class="px-5 py-3 text-center w-20">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-800 font-medium">
                        @forelse($classrooms as $cls)
                        <tr class="hover:bg-slate-50/75 transition-colors">
                            <td class="px-5 py-3.5 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                            
                            <td class="px-5 py-3.5">
                                <span class="font-black text-slate-900 text-sm">{{ $cls->name }}</span>
                                <p class="text-[10px] text-slate-400">ID: #{{ $cls->id }}</p>
                            </td>

                            <td class="px-5 py-3.5 text-center font-bold text-slate-700">
                                {{ $cls->capacity ?? 30 }} Siswa
                            </td>

                            <td class="px-5 py-3.5 text-center">
                                @php
                                    $stCount = \App\Models\Student::where('classroom_id', $cls->id)->whereIn('status', ['ACTIVE', 'AKTIF'])->count();
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60 font-black text-xs">
                                    {{ $stCount }} Siswa
                                </span>
                            </td>

                            <!-- Form Penetapan Wali Kelas Langsung -->
                            <td class="px-5 py-3.5">
                                <form method="POST" action="{{ route('admin.academic.classrooms.save') }}" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="school_id" value="{{ $schoolId }}">
                                    <input type="hidden" name="classroom_id" value="{{ $cls->id }}">
                                    <input type="hidden" name="name" value="{{ $cls->name }}">

                                    <select name="homeroom_teacher_id" class="flex-1 text-xs font-bold rounded-xl border border-slate-300 p-2 bg-slate-50 focus:bg-white focus:border-emerald-600">
                                        <option value="">-- Belum Ditetapkan --</option>
                                        @foreach($schoolTeachers as $tc)
                                            <option value="{{ $tc->id }}" {{ $cls->homeroom_teacher_id == $tc->id ? 'selected' : '' }}>
                                                {{ $tc->name }} (NIP: {{ $tc->nip ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" 
                                            class="px-3 py-2 rounded-xl bg-[#064e3b] hover:bg-[#047857] text-white font-black text-xs transition cursor-pointer shrink-0 shadow-2xs">
                                        💾 Simpan
                                    </button>
                                </form>
                            </td>

                            <!-- Upload TTD Digital Wali Kelas -->
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex flex-col items-center gap-1.5">
                                    @if(!empty($cls->homeroom_signature_path))
                                        <div class="flex items-center gap-2">
                                            <img src="{{ asset($cls->homeroom_signature_path) }}" class="h-8 w-auto object-contain border border-slate-200 rounded p-0.5 bg-white shadow-2xs" alt="TTD Walas">
                                            <span class="text-[10px] text-emerald-700 font-extrabold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">✓ Aktif</span>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('admin.academic.classrooms.signature', $cls->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <label class="cursor-pointer px-3 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] border border-slate-300 transition shadow-2xs inline-flex items-center gap-1">
                                            <span>{{ !empty($cls->homeroom_signature_path) ? '✏️ Ganti TTD' : '📤 Upload TTD Walas' }}</span>
                                            <input type="file" name="homeroom_signature" accept="image/*" class="hidden" onchange="this.form.submit()">
                                        </label>
                                    </form>
                                </div>
                            </td>

                            <!-- Aksi Hapus Rombel -->
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <form method="POST" action="{{ route('admin.academic.classrooms.delete', $cls->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rombel {{ $cls->name }}?');">
                                    @csrf
                                    <button type="submit" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Rombel">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-500">
                                Belum ada rombongan belajar yang dibuat untuk unit ini.
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
                                <option value="Kelompok A (Umum)">Kelompok A (Umum)</option>
                                <option value="Kelompok B (Muatan Khusus JSIT)">Kelompok B (Muatan Khusus JSIT)</option>
                                <option value="Muatan Lokal">Muatan Lokal</option>
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
                                    $cat = $sb->category ?? 'Kelompok A (Umum)';
                                    if (strtoupper($cat) === 'UMUM') $cat = 'Kelompok A (Umum)';
                                    if (strtoupper($cat) === 'JSIT') $cat = 'Kelompok B (Muatan Khusus JSIT)';
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold whitespace-nowrap inline-flex items-center {{ str_contains($cat, 'JSIT') ? 'bg-amber-50 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    {{ $cat }}
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
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition cursor-pointer">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.subjects.delete', $sb->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mapel {{ addslashes($sb->name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Mapel">
                                            🗑️
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
            document.getElementById('input_subject_kktp').value = '75';
            document.getElementById('modalTambahMapel').classList.remove('hidden');
        }

        function editMapel(id, code, name, category, kktp) {
            document.getElementById('titleModalMapel').innerText = 'Perbarui Mata Pelajaran';
            document.getElementById('input_subject_id').value = id;
            document.getElementById('input_subject_code').value = code;
            document.getElementById('input_subject_name').value = name;
            document.getElementById('input_subject_category').value = category || 'Kelompok A (Umum)';
            document.getElementById('input_subject_kktp').value = kktp || 75;
            document.getElementById('modalTambahMapel').classList.remove('hidden');
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
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition cursor-pointer">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.extracurriculars.delete', $ek->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekskul {{ addslashes($ek->name) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Ekskul">
                                            🗑️
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
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[11px] transition cursor-pointer">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.academic.p5.delete', $p5->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus projek {{ addslashes($p5->title) }}?');" class="inline">
                                        @csrf
                                        <button type="submit" class="p-1 rounded-lg text-rose-600 hover:bg-rose-50 transition cursor-pointer" title="Hapus Projek">
                                            🗑️
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

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="autoGenerateAllDescriptions()" 
                                class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition cursor-pointer">
                            <span>⚡</span> <span>Generate Narasi Otomatis</span>
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                            <span>💾</span> <span>SIMPAN SEMUA NILAI KELAS</span>
                        </button>
                    </div>
                </div>

                <!-- Spreadsheet Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-4 py-3 text-center w-12">No</th>
                                <th class="px-4 py-3 w-56">Nama Lengkap & NIS</th>
                                <th class="px-4 py-3 text-center w-28">Nilai Formatif (TP)</th>
                                <th class="px-4 py-3 text-center w-28">Sumatif (SAS)</th>
                                <th class="px-4 py-3 text-center w-24">Nilai Akhir</th>
                                <th class="px-4 py-3 text-center min-w-[120px]">Predikat</th>
                                <th class="px-4 py-3 min-w-[320px]">Deskripsi Capaian Kompetensi (Rapor)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $existing = $existingGrades->get($student->id);
                                $score = $existing->score ?? 85;
                                $notes = $existing->notes ?? '';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $student->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-semibold mt-0.5">NIS: {{ $student->nis }}</p>
                                </td>
                                
                                <!-- Input Nilai Formatif (TP) -->
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" 
                                           name="grades[{{ $student->id }}][score_tp]" 
                                           id="tp_{{ $student->id }}" 
                                           value="{{ $score }}" 
                                           oninput="calcRow({{ $student->id }})"
                                           class="w-20 text-center font-bold text-xs rounded-lg border border-slate-300 py-1.5 px-2 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 table-input bg-white">
                                </td>

                                <!-- Input Nilai Sumatif (SAS) -->
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" 
                                           name="grades[{{ $student->id }}][score_sas]" 
                                           id="sas_{{ $student->id }}"
                                           value="{{ $score }}" 
                                           oninput="calcRow({{ $student->id }})"
                                           class="w-20 text-center font-black text-xs rounded-lg border border-slate-300 py-1.5 px-2 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 table-input bg-emerald-50/50">
                                </td>

                                <!-- Nilai Akhir (Auto Calculated) -->
                                <td class="px-4 py-3 text-center">
                                    <span id="final_{{ $student->id }}" class="font-black text-xs text-slate-900 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200">
                                        {{ $score }}
                                    </span>
                                </td>

                                <!-- Predikat Badge -->
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <span id="pred_{{ $student->id }}" class="px-2.5 py-1 rounded-md text-[10px] font-black inline-flex whitespace-nowrap items-center justify-center {{ $score >= 85 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : ($score >= 75 ? 'bg-blue-100 text-blue-800 border border-blue-300' : 'bg-amber-100 text-amber-800 border border-amber-300') }}">
                                        {{ $score >= 85 ? 'A (Istimewa)' : ($score >= 75 ? 'B (Baik)' : 'C (Cukup)') }}
                                    </span>
                                </td>

                                <!-- Narasi / Deskripsi Capaian Pembelajaran -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-between gap-1 mb-1.5">
                                        <span class="text-[10px] text-slate-500 font-bold">Narasi Capaian (CP/TP):</span>
                                        <button type="button" onclick="generateAiNarrativeSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                class="px-2 py-0.5 rounded-md bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-black text-[10px] border border-indigo-200 transition cursor-pointer flex items-center gap-1">
                                            <span>✨ AI Narasi</span>
                                        </button>
                                    </div>
                                    <textarea name="grades[{{ $student->id }}][notes]" 
                                              id="notes_{{ $student->id }}" 
                                              rows="2" 
                                              placeholder="Contoh: Menunjukkan penguasaan yang sangat baik dalam menganalisis materi..."
                                              class="w-full text-xs text-slate-800 rounded-lg border border-slate-300 p-2 focus:border-emerald-600 focus:ring-1 focus:ring-emerald-600 bg-white leading-relaxed">{{ $notes }}</textarea>
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
                        💡 Tips Guru: Masukkan angka nilai SAS (0-100), tekan tombol "Generate Narasi Otomatis" bila narasi belum diisi, lalu klik "Simpan Semua Nilai Kelas".
                    </p>
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN SEMUA NILAI KELAS</span>
                    </button>
                </div>
                @endif
            </div>
        </form>

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

                    <button type="submit" 
                            class="px-4 py-2 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95 whitespace-nowrap">
                        <span>💾</span> <span>SIMPAN NILAI AL-QUR'AN KELAS</span>
                    </button>
                </div>

                <!-- Table Grid -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                            <tr>
                                <th class="px-4 py-3 text-center w-12">No</th>
                                <th class="px-4 py-3 w-48">Nama Siswa</th>
                                <th class="px-4 py-3 min-w-[170px]">Jilid / Buku Wafa & Hal</th>
                                <th class="px-4 py-3 text-center w-24">Makhraj</th>
                                <th class="px-4 py-3 text-center w-24">Tajwid</th>
                                <th class="px-4 py-3 text-center w-24">Lagu Hijaz</th>
                                <th class="px-4 py-3 text-center w-24">Adab</th>
                                <th class="px-4 py-3 min-w-[240px]">Target & Capaian Tahfidz</th>
                                <th class="px-4 py-3 min-w-[160px]">Ujian Tasmi'</th>
                                <th class="px-4 py-3 min-w-[280px]">Catatan Ustadz Pengampu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-800">
                            @forelse($classStudents as $student)
                            @php
                                $q = $existingQuran->get($student->id);
                                $scores = $q->tahsin_scores ?? ['makhraj' => 90, 'tajwid' => 88, 'lagu_hijaz' => 90, 'adab' => 92];
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-4 py-3 text-center text-slate-400 font-bold">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-extrabold text-slate-900 text-xs leading-snug">{{ $student->full_name }}</p>
                                    <p class="text-[11px] text-slate-500 font-semibold">NIS: {{ $student->nis }}</p>
                                </td>
                                
                                <!-- Jilid Wafa -->
                                <td class="px-4 py-3">
                                    <input type="text" name="quran[{{ $student->id }}][tahsin_level]" 
                                           value="{{ $q->tahsin_level ?? 'Buku Wafa 3 Hal 25' }}"
                                           placeholder="e.g. Buku Wafa 3 Hal 25"
                                           class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-2 focus:border-teal-600 bg-white">
                                </td>

                                <!-- 4 Aspek Wafa -->
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][makhraj]" 
                                           value="{{ $scores['makhraj'] ?? 90 }}"
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 focus:border-teal-600 bg-white">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][tajwid]" 
                                           value="{{ $scores['tajwid'] ?? 88 }}"
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 focus:border-teal-600 bg-white">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][lagu_hijaz]" 
                                           value="{{ $scores['lagu_hijaz'] ?? 90 }}"
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 focus:border-teal-600 bg-white">
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <input type="number" min="0" max="100" name="quran[{{ $student->id }}][adab]" 
                                           value="{{ $scores['adab'] ?? 92 }}"
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 focus:border-teal-600 bg-white">
                                </td>

                                <!-- Tahfidz Achievement -->
                                <td class="px-4 py-3 min-w-[200px]">
                                    <input type="text" name="quran[{{ $student->id }}][tahfidz_achievement]" 
                                           value="{{ $q->tahfidz_achievement ?? 'Tuntas Juz 30 Surat Al-A\'la s/d An-Nas' }}"
                                           placeholder="Capaian Ziyadah"
                                           class="w-full text-xs font-semibold rounded-lg border border-slate-300 py-1 px-2 focus:border-teal-600 bg-white">
                                </td>

                                <!-- Ujian Tasmi' -->
                                <td class="px-4 py-3">
                                    <select name="quran[{{ $student->id }}][tasmi_exam_result]" 
                                            class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-2 focus:border-teal-600 bg-white">
                                        <option value="Lulus Ujian Tasmi' Sekali Duduk Predikat Mumtaz" {{ ($q->tasmi_exam_result ?? '') == 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Mumtaz' ? 'selected' : '' }}>Lulus Mumtaz</option>
                                        <option value="Lulus Ujian Tasmi' Sekali Duduk Predikat Jayyid Jiddan" {{ ($q->tasmi_exam_result ?? '') == 'Lulus Ujian Tasmi\' Sekali Duduk Predikat Jayyid Jiddan' ? 'selected' : '' }}>Lulus Jayyid Jiddan</option>
                                        <option value="Belum Mengambil Ujian Tasmi'" {{ ($q->tasmi_exam_result ?? '') == 'Belum Mengambil Ujian Tasmi\'' ? 'selected' : '' }}>Belum Tasmi'</option>
                                    </select>
                                </td>

                                <!-- Catatan Ustadz -->
                                <td class="px-4 py-3 min-w-[280px]">
                                    <div class="flex items-center justify-between gap-1 mb-1.5">
                                        <span class="text-[10px] text-slate-500 font-bold">Catatan Ustadz Pengampu:</span>
                                        <button type="button" onclick="generateAiQuranSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                class="px-2 py-0.5 rounded-md bg-teal-50 hover:bg-teal-100 text-teal-800 font-black text-[10px] border border-teal-200 transition cursor-pointer flex items-center gap-1">
                                            <span>✨ AI Evaluasi</span>
                                        </button>
                                    </div>
                                    <textarea rows="2" name="quran[{{ $student->id }}][tahsin_notes]" 
                                              id="quran_notes_{{ $student->id }}"
                                              placeholder="Catatan tahsin & capaian..."
                                              class="w-full text-xs rounded-lg border border-slate-300 p-2 focus:border-teal-600 focus:ring-1 focus:ring-teal-600 bg-white leading-relaxed resize-y">{{ $q->tahsin_notes ?? 'Fasih dalam melantunkan nada Hijaz Wafa dan makharijul huruf sangat rapi.' }}</textarea>
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

                    <button type="submit" 
                            class="px-4 py-2 rounded-xl bg-indigo-700 hover:bg-indigo-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN EVALUASI KARAKTER KELAS</span>
                    </button>
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
                                <th class="px-4 py-3 min-w-[340px]">Catatan Pembina BPI</th>
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
                                            class="w-full text-xs font-bold rounded-lg border border-slate-300 py-1 px-2 focus:border-indigo-600 bg-white">
                                        <option value="Selalu Berjamaah di Masjid" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Selalu Berjamaah di Masjid' ? 'selected' : '' }}>Selalu Berjamaah</option>
                                        <option value="Sering Berjamaah" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Sering Berjamaah' ? 'selected' : '' }}>Sering Berjamaah</option>
                                        <option value="Perlu Pembiasaan" {{ ($c->mutabaah_sholat_fardhu ?? '') == 'Perlu Pembiasaan' ? 'selected' : '' }}>Perlu Pembiasaan</option>
                                    </select>
                                </td>

                                <td class="px-4 py-3 min-w-[340px]">
                                    <textarea name="character[{{ $student->id }}][bpi_mentor_notes]" rows="2"
                                              placeholder="Catatan perkembangan ibadah dan pembinaan karakter ananda..."
                                              class="w-full text-xs font-medium text-slate-800 rounded-xl border border-slate-300 p-2.5 bg-slate-50 focus:bg-white focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 leading-relaxed shadow-2xs resize-y">{{ $c->bpi_mentor_notes ?? 'Ananda menunjukkan profil karakter muslim yang tangguh, istiqomah dalam ibadah yaumiyah dan adab islami.' }}</textarea>
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

                    <button type="submit" 
                            class="px-4 py-2 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN REKAP WALI KELAS</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100/75 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="px-3 py-3 text-center w-10">No</th>
                                <th class="px-3 py-3 w-48">Nama Siswa</th>
                                <th class="px-2 py-3 text-center w-16" title="Sakit (Hari)">S</th>
                                <th class="px-2 py-3 text-center w-16" title="Izin (Hari)">I</th>
                                <th class="px-2 py-3 text-center w-16" title="Alpa / Tanpa Keterangan">A</th>
                                <th class="px-2 py-3 text-center w-20">TB (cm)</th>
                                <th class="px-2 py-3 text-center w-20">BB (kg)</th>
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

                                <!-- S / I / A -->
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][sick_count]" 
                                           value="{{ $hr->sick_count ?? 0 }}" 
                                           class="w-12 text-center font-black text-xs rounded-lg border border-slate-300 py-1 bg-white focus:border-blue-600">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][permission_count]" 
                                           value="{{ $hr->permission_count ?? 0 }}" 
                                           class="w-12 text-center font-black text-xs rounded-lg border border-slate-300 py-1 bg-white focus:border-blue-600">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" min="0" name="homeroom[{{ $student->id }}][absent_count]" 
                                           value="{{ $hr->absent_count ?? 0 }}" 
                                           class="w-12 text-center font-black text-xs rounded-lg border border-slate-300 py-1 bg-white focus:border-blue-600">
                                </td>

                                <!-- TB / BB -->
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" name="homeroom[{{ $student->id }}][height_cm]" 
                                           value="{{ $hr->height_cm ?? 148.5 }}" 
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 bg-white focus:border-blue-600">
                                </td>
                                <td class="px-2 py-3 text-center">
                                    <input type="number" step="0.1" name="homeroom[{{ $student->id }}][weight_kg]" 
                                           value="{{ $hr->weight_kg ?? 41.5 }}" 
                                           class="w-16 text-center font-bold text-xs rounded-lg border border-slate-300 py-1 bg-white focus:border-blue-600">
                                </td>

                                <!-- Ekskul -->
                                <td class="px-3 py-3 min-w-[170px]">
                                    <input type="text" name="homeroom[{{ $student->id }}][ekskul_name]" 
                                           value="{{ $ekskul }}" 
                                           placeholder="Nama Ekskul"
                                           class="w-full text-xs font-semibold rounded-lg border border-slate-300 py-1 px-2 focus:border-blue-600 bg-white">
                                </td>

                                <!-- Catatan Wali Kelas -->
                                <td class="px-4 py-3 min-w-[360px]">
                                    <div class="flex items-center justify-between gap-1 mb-1.5">
                                        <span class="text-[10px] text-slate-500 font-bold">Catatan Perkembangan & Motivasi:</span>
                                        <button type="button" onclick="generateAiHomeroomSingle('{{ $student->id }}', '{{ addslashes($student->full_name) }}')" 
                                                class="px-2 py-0.5 rounded-md bg-purple-50 hover:bg-purple-100 text-purple-700 font-black text-[10px] border border-purple-200 transition cursor-pointer flex items-center gap-1">
                                            <span>✨ AI Motivasi</span>
                                        </button>
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
            <!-- Leger Action Buttons (Cetak PDF & Download Excel) -->
            @if($classStudents->isNotEmpty())
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('admin.academic.report-card', [$classStudents->first()->id, 'type' => 'leger']) }}" 
                   target="_blank"
                   class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                    <span>📊</span> <span>CETAK LEGER NILAI (PDF)</span>
                </a>
                <a href="{{ route('admin.academic.leger.export', ['classroom_id' => $selectedClassroomId]) }}" 
                   class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs flex items-center gap-2 transition shadow-sm cursor-pointer active:scale-95">
                    <span>📥</span> <span>DOWNLOAD LEGER (EXCEL / CSV)</span>
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
                    Pilih opsi <strong>Rapor Gabungan (All-in-One)</strong> untuk mencetak buku rapor lengkap, atau opsi terpisah sesuai kebutuhan.
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
                            <th class="px-4 py-3 text-center min-w-[360px]">Aksi Cetak Dokumen</th>
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
                            <td class="px-4 py-3.5 text-center min-w-[360px] whitespace-nowrap">
                                <div class="inline-flex items-center justify-center gap-1.5">
                                    <!-- 1. All in One -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'all_in_one']) }}" 
                                       target="_blank"
                                       class="px-3 py-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition shadow-2xs inline-flex items-center gap-1">
                                        <span>🖨️</span> <span>Gabungan</span>
                                    </a>

                                    <!-- 2. Akademik Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'academic']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Mata Pelajaran"
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
                                        Akademik
                                    </a>

                                    <!-- 3. Wafa Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'quran']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Al-Qur'an Wafa & Tahfidz"
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
                                        Wafa
                                    </a>

                                    <!-- 4. Karakter Terpisah -->
                                    <a href="{{ route('admin.academic.report-card', [$student->id, 'type' => 'character']) }}" 
                                       target="_blank"
                                       title="Cetak Khusus Nilai Karakter JSIT & BPI"
                                       class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 font-extrabold text-xs transition">
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

                <!-- 2. TITIMANGSA RAPOR -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Kota Titimangsa Rapor:</label>
                        <input type="text" name="report_city" id="setting_city" 
                               value="{{ $reportSetting->report_city ?? 'Bandung' }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Tanggal Titimangsa Pembagian:</label>
                        <input type="text" name="report_date" id="setting_date" 
                               value="{{ $reportSetting->report_date ?? '20 Desember 2026' }}"
                               oninput="updatePreview()"
                               class="w-full text-xs font-bold rounded-xl border border-slate-300 p-2.5 focus:border-emerald-600 bg-slate-50 focus:bg-white text-slate-900">
                    </div>
                </div>

                <!-- 3. DATA PENANDATANGAN KEPALA SEKOLAH -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Kepala Sekolah / Penandatangan:</label>
                        <input type="text" name="principal_name" id="setting_principal" 
                               value="{{ $reportSetting->principal_name ?? ($activeSchool->principal_name ?? 'Ustadzah Tia Wulandari, S.Pd') }}"
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
                    <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider flex items-center gap-1.5">
                        <span>🖋️</span> <span>Upload Stempel & Tanda Tangan Digital</span>
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Stempel Resmi Sekolah -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Stempel Resmi Sekolah (PNG Transparan):</label>
                            @if(!empty($reportSetting?->stamp_image_url))
                                <div class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-200">
                                    <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-10 w-auto object-contain" alt="Stempel">
                                    <div class="text-[10px] text-slate-600 truncate">
                                        <span class="font-bold text-emerald-700">Aktif:</span> {{ basename($reportSetting->stamp_image_url) }}
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="stamp_image_file" accept="image/png,image/webp" 
                                   class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                            <p class="text-[10px] text-slate-500">Gunakan PNG dengan background transparan.</p>
                        </div>

                        <!-- Tanda Tangan Digital Kepala Sekolah -->
                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                            <label class="block text-xs font-bold text-slate-800">Tanda Tangan Kepala Sekolah (PNG Transparan):</label>
                            @if(!empty($reportSetting?->principal_signature_url))
                                <div class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-200">
                                    <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-10 w-auto object-contain" alt="TTD">
                                    <div class="text-[10px] text-slate-600 truncate">
                                        <span class="font-bold text-emerald-700">Aktif:</span> {{ basename($reportSetting->principal_signature_url) }}
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="principal_signature_file" accept="image/png,image/webp" 
                                   class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                            <p class="text-[10px] text-slate-500">Gunakan PNG dengan background transparan.</p>
                        </div>
                    </div>

                    <!-- Logo Cadangan (Opsional) -->
                    <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                        <label class="block text-xs font-bold text-slate-800">Logo Tambahan Yayasan/JSIT (Opsional):</label>
                        @if(!empty($reportSetting?->school_logo_url))
                            <div class="flex items-center gap-3 p-2 bg-white rounded-lg border border-slate-200">
                                <img src="{{ asset($reportSetting->school_logo_url) }}" class="h-10 w-auto object-contain" alt="Logo">
                                <div class="text-[10px] text-slate-600 truncate">
                                    <span class="font-bold text-emerald-700">Aktif:</span> {{ basename($reportSetting->school_logo_url) }}
                                </div>
                            </div>
                        @endif
                        <input type="file" name="school_logo_file" accept="image/png,image/jpeg,image/svg+xml,image/webp" 
                               class="w-full text-xs file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white hover:file:bg-slate-800 border border-slate-300 rounded-xl p-1 bg-white cursor-pointer">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-sm flex items-center justify-center gap-2 transition shadow-md cursor-pointer active:scale-95">
                        <span>💾</span> <span>SIMPAN GAMBAR KOP & PENGATURAN CETAK RAPOR</span>
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
                                <span id="preview_city">{{ $reportSetting->report_city ?? 'Bandung' }}</span>, 
                                <span id="preview_date">{{ $reportSetting->report_date ?? '20 Desember 2026' }}</span>
                            </p>
                            <p class="text-[11px] font-bold text-slate-900">Kepala Sekolah,</p>
                            
                            <!-- Stamp & TTD Graphic Mockup -->
                            <div class="h-20 my-1 flex items-center justify-center relative">
                                @if(!empty($reportSetting?->stamp_image_url))
                                    <img src="{{ asset($reportSetting->stamp_image_url) }}" class="h-20 w-auto object-contain absolute opacity-80 left-2 pointer-events-none" alt="Stempel">
                                @endif
                                @if(!empty($reportSetting?->principal_signature_url))
                                    <img src="{{ asset($reportSetting->principal_signature_url) }}" class="h-16 w-auto object-contain relative z-10" alt="TTD">
                                @else
                                    <span class="font-serif italic text-slate-400 text-xs">(Tanda Tangan & Stempel)</span>
                                @endif
                            </div>

                            <p id="preview_principal" class="text-xs font-black text-slate-900 underline">
                                {{ $reportSetting->principal_name ?? 'Ustadzah Tia Wulandari, S.Pd' }}
                            </p>
                            <p class="text-[10px] text-slate-600 font-semibold">
                                NIP: <span id="preview_nip">{{ $reportSetting->principal_nip ?? '19850315 200904 1 003' }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-center">
                    <p class="text-[11px] text-slate-600 font-medium">
                        💡 Gambar Kop Surat yang Anda upload di atas akan dicetak pada seluruh format rapor siswa (All-in-One, Akademik, Wafa, Karakter, dan Leger).
                    </p>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>

<!-- Modal Analisis Kesiapan Rapor Kelas oleh Google Gemini AI -->
<div id="modalAiClassAnalysis" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 shadow-2xl border border-slate-200 space-y-4 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between border-b border-slate-200 pb-3">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center text-lg font-black shadow-md shadow-purple-200">
                    ✨
                </div>
                <div>
                    <h3 class="font-black text-sm text-slate-900" id="modalAiTitle">Analisis Kesiapan Rapor oleh Google Gemini AI</h3>
                    <p class="text-[11px] text-slate-500 font-medium" id="modalAiSubtitle">Audit kelengkapan nilai, korelasi capaian karakter & rekomendasi cetak rapor</p>
                </div>
            </div>
            <button onclick="closeAiClassAnalysisModal()" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-700 flex items-center justify-center font-bold text-sm transition cursor-pointer">✕</button>
        </div>
        <div class="overflow-y-auto flex-1 pr-2 space-y-3" id="modalAiContent">
            <div class="py-12 text-center text-slate-500 space-y-3">
                <div class="inline-block animate-spin text-3xl">✨</div>
                <p class="text-xs font-bold text-slate-600">Google Gemini sedang menganalisis data rombel secara mendalam...</p>
                <p class="text-[11px] text-slate-400">Mohon tunggu beberapa detik...</p>
            </div>
        </div>
        <div class="pt-3 border-t border-slate-200 flex items-center justify-between">
            <span class="text-[10px] text-slate-400 font-semibold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Powered by Google AI Studio (Gemini 3.6 Flash)</span>
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

<!-- Realtime Helper Scripts -->
<script>
    // Inisialisasi Chart.js jika pada halaman dashboard
    @if(($activeMenu ?? 'dashboard') === 'dashboard')
    document.addEventListener('DOMContentLoaded', function() {
        const rombelLabels = {!! json_encode($chartClassroomLabels ?? []) !!};
        const rombelValues = {!! json_encode($chartClassroomValues ?? []) !!};
        const sklLabels = {!! json_encode($chartSklLabels ?? []) !!};
        const sklValues = {!! json_encode($chartSklValues ?? []) !!};
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
                            ticks: { font: { size: 11, weight: '600' }, color: '#334155' }
                        }
                    }
                }
            });
        }

        // 2. Chart Radar 7 SKL JSIT
        const ctxSkl = document.getElementById('chartSklRadar');
        if (ctxSkl && sklLabels.length > 0) {
            new Chart(ctxSkl, {
                type: 'radar',
                data: {
                    labels: sklLabels,
                    datasets: [{
                        label: 'Capaian Karakter (%)',
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
                <p class="text-sm font-black text-slate-700">Google Gemini sedang menganalisis data...</p>
                <p class="text-xs text-slate-400">Menghubungkan data nilai, Wafa, dan karakter JSIT...</p>
            </div>
        `;

        const schoolId = '{{ $schoolId ?? 1 }}';
        let url = `{{ route('admin.academic.ai.analyze.class') }}?school_id=${schoolId}`;
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
                
                const lines = data.analysis.split('\n').filter(l => l.trim() !== '');
                let formattedHtml = `<div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-100 space-y-3 text-xs leading-relaxed text-slate-800">`;
                lines.forEach(l => {
                    if (l.startsWith('**') || l.startsWith('#') || l.startsWith('1.') || l.startsWith('2.') || l.startsWith('3.')) {
                        formattedHtml += `<p class="font-bold text-slate-900 mt-2">${l.replace(/\*\*/g, '')}</p>`;
                    } else if (l.startsWith('-') || l.startsWith('•')) {
                        formattedHtml += `<p class="pl-4 border-l-2 border-purple-300 py-0.5 text-slate-700">${l.replace(/^[-•]\s*/, '')}</p>`;
                    } else {
                        formattedHtml += `<p class="text-slate-700">${l}</p>`;
                    }
                });
                formattedHtml += `</div>`;
                
                content.innerHTML = formattedHtml;
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

    function generateAiNarrativeSingle(studentId, studentName) {
        const textarea = document.getElementById('notes_' + studentId);
        const sasInput = document.getElementById('sas_' + studentId);
        const score = sasInput ? sasInput.value : 85;
        const subjectName = '{{ $selectedSubject->name ?? "Mata Pelajaran" }}';

        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang menyusun narasi capaian dengan Google Gemini...';
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
            if (data.status === 'success' && data.narrative) {
                textarea.value = data.narrative;
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat narasi.');
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
        textarea.value = '✨ Sedang membuat catatan motivasi islami dengan Google Gemini...';
        textarea.disabled = true;

        fetch('{{ route("admin.academic.ai.generate.homeroom") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                average_score: 85
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            if (data.status === 'success' && data.note) {
                textarea.value = data.note;
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat catatan.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    function generateAiQuranSingle(studentId, studentName) {
        const textarea = document.getElementById('quran_notes_' + studentId);
        if (!textarea) return;

        const originalVal = textarea.value;
        textarea.value = '✨ Sedang menyusun evaluasi tahsin & tahfidz Wafa dengan Google Gemini...';
        textarea.disabled = true;

        fetch('{{ route("admin.academic.ai.generate.quran") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_name: studentName,
                level: 'Buku Wafa 3-4',
                makhraj: 90,
                tajwid: 88,
                adab: 92,
                achievement: 'Juz 30'
            })
        })
        .then(res => res.json())
        .then(data => {
            textarea.disabled = false;
            if (data.status === 'success' && data.evaluation) {
                textarea.value = data.evaluation;
            } else {
                textarea.value = originalVal;
                alert(data.message || 'Gagal membuat evaluasi.');
            }
        })
        .catch(err => {
            textarea.disabled = false;
            textarea.value = originalVal;
            alert('Gagal menghubungi AI: ' + err.message);
        });
    }

    // User Management Modal Functions
    function openTambahUserModal() {
        const title = document.getElementById('titleModalUser');
        const idInput = document.getElementById('input_user_id');
        const nameInput = document.getElementById('input_user_name');
        const emailInput = document.getElementById('input_user_email');
        const phoneInput = document.getElementById('input_user_phone');
        const roleSelect = document.getElementById('input_user_role');
        const pwdHelp = document.getElementById('user_pwd_help');
        const pwdInput = document.getElementById('input_user_pwd');

        if (title) title.innerText = 'Tambah Guru / Operator Baru';
        if (idInput) idInput.value = '';
        if (nameInput) nameInput.value = '';
        if (emailInput) emailInput.value = '';
        if (phoneInput) phoneInput.value = '';
        if (roleSelect) roleSelect.value = 'TEACHER';
        if (pwdHelp) pwdHelp.classList.add('hidden');
        if (pwdInput) {
            pwdInput.required = true;
            pwdInput.placeholder = 'Minimal 6 karakter';
        }

        const modal = document.getElementById('modalTambahUser');
        if (modal) modal.classList.remove('hidden');
    }

    function openEditUserModal(id, name, email, role, phone, isActive) {
        const title = document.getElementById('titleModalUser');
        const idInput = document.getElementById('input_user_id');
        const nameInput = document.getElementById('input_user_name');
        const emailInput = document.getElementById('input_user_email');
        const phoneInput = document.getElementById('input_user_phone');
        const roleSelect = document.getElementById('input_user_role');
        const activeSelect = document.getElementById('input_user_active');
        const pwdHelp = document.getElementById('user_pwd_help');
        const pwdInput = document.getElementById('input_user_pwd');

        if (title) title.innerText = 'Edit Data Pengguna Unit';
        if (idInput) idInput.value = id;
        if (nameInput) nameInput.value = name;
        if (emailInput) emailInput.value = email;
        if (phoneInput) phoneInput.value = phone || '';
        if (roleSelect) roleSelect.value = role;
        if (activeSelect) activeSelect.value = isActive ? '1' : '0';
        if (pwdHelp) pwdHelp.classList.remove('hidden');
        if (pwdInput) {
            pwdInput.required = false;
            pwdInput.placeholder = 'Kosongkan jika tidak ingin mengubah kata sandi';
        }

        const modal = document.getElementById('modalTambahUser');
        if (modal) modal.classList.remove('hidden');
    }

    function closeUserModal() {
        const modal = document.getElementById('modalTambahUser');
        if (modal) modal.classList.add('hidden');
    }
    // Live calculate for Academic Grid
    function calcRow(studentId) {
        const tpInput = document.getElementById('tp_' + studentId);
        const sasInput = document.getElementById('sas_' + studentId);
        const finalElem = document.getElementById('final_' + studentId);
        const predElem = document.getElementById('pred_' + studentId);

        let tp = tpInput ? parseFloat(tpInput.value) || 0 : 0;
        let sas = sasInput ? parseFloat(sasInput.value) || 0 : 0;
        
        let finalScore = sas > 0 ? sas : tp;
        finalElem.innerText = Math.round(finalScore);

        if (finalScore >= 85) {
            predElem.innerText = 'A (Istimewa)';
            predElem.className = 'px-2 py-0.5 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-800';
        } else if (finalScore >= 75) {
            predElem.innerText = 'B (Baik)';
            predElem.className = 'px-2 py-0.5 rounded-md text-[10px] font-black bg-blue-100 text-blue-800';
        } else if (finalScore >= 65) {
            predElem.innerText = 'C (Cukup)';
            predElem.className = 'px-2 py-0.5 rounded-md text-[10px] font-black bg-amber-100 text-amber-800';
        } else {
            predElem.innerText = 'D (Perlu Bimbingan)';
            predElem.className = 'px-2 py-0.5 rounded-md text-[10px] font-black bg-rose-100 text-rose-800';
        }
    }

    // Auto generate standardized Kurikulum Merdeka descriptions
    function autoGenerateAllDescriptions() {
        const textareas = document.querySelectorAll('textarea[id^="notes_"]');
        let count = 0;
        textareas.forEach(ta => {
            const studentId = ta.id.replace('notes_', '');
            const sasInput = document.getElementById('sas_' + studentId);
            const score = sasInput ? parseFloat(sasInput.value) || 80 : 80;

            if (score >= 90) {
                ta.value = 'Menunjukkan penguasaan capaian pembelajaran yang istimewa (Mumtaz) pada seluruh materi serta mampu bernalar kritis secara mandiri.';
            } else if (score >= 80) {
                ta.value = 'Menunjukkan penguasaan capaian pembelajaran yang sangat baik dalam memahami konsep materi dan aktif berdiskusi.';
            } else if (score >= 70) {
                ta.value = 'Menunjukkan penguasaan capaian pembelajaran yang cukup baik, perlu sedikit peningkatan latihan pemecahan masalah.';
            } else {
                ta.value = 'Memerlukan bimbingan dan remedial berkelanjutan untuk mencapai ketuntasan tujuan pembelajaran.';
            }
            count++;
        });

        if (window.Swal) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Generate Narasi',
                text: 'Narasi capaian pembelajaran telah dibuatkan otomatis untuk ' + count + ' siswa!',
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
