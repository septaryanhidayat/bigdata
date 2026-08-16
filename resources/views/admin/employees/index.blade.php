@extends('admin.layout')

@section('title', 'Database Induk & E-Berkas SDM SIT Robbani')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-2xl border-2 border-emerald-500/40 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-400/20 text-emerald-300 text-xs font-black tracking-wider uppercase border border-emerald-400/40 mb-3">
                    <span>📁</span> Arsip &amp; Database Kepegawaian Yayasan
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">Database Induk &amp; E-Berkas SDM SIT Robbani</h1>
                <p class="text-emerald-100 text-sm mt-1.5 max-w-2xl font-medium leading-relaxed">
                    Pusat arsip digital profil guru &amp; staf: KTP, KK, Ijazah, Surat Lamaran, SK Kontrak, Sertifikat Pendidik, Piagam Prestasi, NPWP, dan BPJS terintegrasi sistem presensi mobile.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition-all flex items-center gap-2">
                    <span>📱</span> Monitoring Presensi Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- 4 High-Contrast Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Pegawai SDM -->
        <div class="bg-slate-900 rounded-2xl p-5 border-2 border-slate-700 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-blue-400 uppercase tracking-wider">Total Pegawai SDM</span>
                <span class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-300 flex items-center justify-center text-lg">👥</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-white">{{ $totalEmployees }}</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium">Guru &amp; Karyawan Yayasan</p>
            </div>
        </div>

        <!-- 2. Tenaga Pendidik (Guru) -->
        <div class="bg-slate-900 rounded-2xl p-5 border-2 border-emerald-700 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-emerald-400 uppercase tracking-wider">Tenaga Pendidik (Guru)</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center text-lg">👨‍🏫</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-emerald-400">{{ $totalTeachers }}</h3>
                <p class="text-xs text-emerald-300/80 mt-1 font-medium">Ustadz &amp; Ustadzah Aktif</p>
            </div>
        </div>

        <!-- 3. Tenaga Kependidikan / Staf -->
        <div class="bg-slate-900 rounded-2xl p-5 border-2 border-purple-700 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-purple-400 uppercase tracking-wider">Tenaga Kependidikan</span>
                <span class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-300 flex items-center justify-center text-lg">💼</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-purple-300">{{ $totalStaff }}</h3>
                <p class="text-xs text-purple-300/80 mt-1 font-medium">Staf TU, Keuangan, Sarpras</p>
            </div>
        </div>

        <!-- 4. Face ID Terdaftar -->
        <div class="bg-slate-900 rounded-2xl p-5 border-2 border-amber-700 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-amber-400 uppercase tracking-wider">Face ID Mobile</span>
                <span class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center text-lg">📸</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-amber-300">{{ $enrolledFaceCount }} <span class="text-xs font-normal text-slate-400">/ {{ $totalEmployees }}</span></h3>
                <p class="text-xs text-amber-300/80 mt-1 font-medium">Biometrik Wajah Terverifikasi</p>
            </div>
        </div>
    </div>

    <!-- Advanced Filter & Search Box -->
    <div class="bg-slate-900 rounded-3xl border-2 border-slate-700 shadow-xl p-5 lg:p-6 text-white space-y-4">
        <div class="flex items-center justify-between border-b border-slate-800 pb-3">
            <h3 class="text-sm font-black text-emerald-400 flex items-center gap-2">
                <span>🔍</span> Filter &amp; Pencarian Database SDM
            </h3>
            <span class="text-xs text-slate-400 font-bold font-mono">
                Menampilkan: {{ $employees->count() }} dari {{ $employees->total() }} Data
            </span>
        </div>

        <form action="{{ route('admin.employees.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="lg:col-span-1">
                    <label class="block text-xs font-bold text-slate-300 mb-1">Cari Nama / NIP / Email</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search', $search) }}" 
                           placeholder="Ketik nama, NIP, no HP..." 
                           class="w-full px-3.5 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs border-2 border-slate-600 focus:border-emerald-400 focus:outline-none placeholder-slate-400">
                </div>

                <!-- Unit Sekolah -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Unit Penempatan</label>
                    <select name="school_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs border-2 border-slate-600 focus:border-emerald-400 focus:outline-none">
                        <option value="all" {{ ($schoolId === 'all' || $schoolId === null || $schoolId === '') ? 'selected' : '' }}>Semua Unit (Yayasan + Sekolah)</option>
                        <option value="yayasan" {{ ($schoolId === 'yayasan' || $schoolId === '0') ? 'selected' : '' }}>🏛️ Yayasan Pusat</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}" {{ (string)$schoolId === (string)$sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Peran / Jabatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Peran / Jabatan</label>
                    <select name="role_type" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 text-white font-bold text-xs border-2 border-slate-600 focus:border-emerald-400 focus:outline-none">
                        <option value="all" {{ ($roleType === 'all' || empty($roleType)) ? 'selected' : '' }}>Semua Jabatan</option>
                        <option value="GURU" {{ $roleType === 'GURU' ? 'selected' : '' }}>👨‍🏫 Tenaga Pendidik (Guru)</option>
                        <option value="HEADMASTER" {{ $roleType === 'HEADMASTER' ? 'selected' : '' }}>👑 Kepala Unit / Pimpinan</option>
                        <option value="STAFF" {{ $roleType === 'STAFF' ? 'selected' : '' }}>💼 Tenaga Kependidikan (Staf)</option>
                        <option value="STAFF_TU" {{ $roleType === 'STAFF_TU' ? 'selected' : '' }}>📋 Tata Usaha (TU)</option>
                        <option value="STAFF_KEUANGAN" {{ $roleType === 'STAFF_KEUANGAN' ? 'selected' : '' }}>💳 Keuangan / Bendahara</option>
                    </select>
                </div>

                <!-- Tampilkan Jumlah Data (Per Page) -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Tampilkan Jumlah Data</label>
                    <select name="per_page" class="w-full px-3.5 py-2 rounded-xl bg-slate-800 text-emerald-300 font-black text-xs border-2 border-slate-600 focus:border-emerald-400 focus:outline-none">
                        <option value="15" {{ (string)$perPage === '15' ? 'selected' : '' }}>15 Data per Halaman</option>
                        <option value="25" {{ (string)$perPage === '25' ? 'selected' : '' }}>25 Data per Halaman</option>
                        <option value="50" {{ (string)$perPage === '50' ? 'selected' : '' }}>50 Data per Halaman</option>
                        <option value="100" {{ (string)$perPage === '100' ? 'selected' : '' }}>100 Data per Halaman</option>
                        <option value="500" {{ (string)$perPage === '500' ? 'selected' : '' }}>500 Data per Halaman</option>
                        <option value="1000" {{ (string)$perPage === '1000' ? 'selected' : '' }}>1.000 Data per Halaman</option>
                        <option value="all" {{ $perPage === 'all' ? 'selected' : '' }}>⭐ Tampilkan SEMUA DATA (1 Halaman)</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-xs border border-slate-700 transition-colors">
                    🔄 Reset Filter
                </a>
                <button type="submit" class="px-6 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition-all shadow-lg hover:shadow-emerald-500/25 flex items-center gap-2 cursor-pointer">
                    <span>🔍</span> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Employee Table Card -->
    <div class="bg-slate-900 text-white rounded-3xl border-2 border-slate-700 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-200">
                <thead class="bg-slate-950 text-xs uppercase text-slate-300 font-black border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-4">Pegawai &amp; Unit</th>
                        <th class="px-5 py-4">Identitas (NIK / NIP)</th>
                        <th class="px-5 py-4">Pendidikan &amp; Kontak</th>
                        <th class="px-5 py-4">Kelengkapan E-Berkas</th>
                        <th class="px-5 py-4">Status &amp; Face ID</th>
                        <th class="px-5 py-4 text-center">Aksi Bidang SDM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($employees as $emp)
                    @php
                        // Calculate uploaded file counts
                        $docCount = 0;
                        $docs = ['file_ktp', 'file_kk', 'file_ijazah', 'file_surat_lamaran', 'file_kontrak_kerja', 'file_sertifikat', 'file_prestasi', 'file_npwp', 'file_bpjs'];
                        foreach($docs as $d) {
                            if(!empty($emp->$d)) $docCount++;
                        }
                    @endphp
                    <tr class="hover:bg-slate-800/60 transition-colors">
                        <!-- Pegawai & Unit -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-400 shadow-md' : 'border-slate-700' }} bg-slate-800 flex items-center justify-center shrink-0">
                                    <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($emp->full_name) . '&background=059669&color=fff&bold=true' }}" 
                                         alt="{{ $emp->full_name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <div class="font-black text-white text-sm truncate">{{ $emp->full_name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($emp->school)
                                            @php
                                                $unitCode = strtoupper($emp->school->code);
                                                $badgeStyle = match($unitCode) {
                                                    'TKIT' => 'bg-pink-500/20 text-pink-300 border-pink-500/40',
                                                    'SDIT' => 'bg-blue-500/20 text-blue-300 border-blue-500/40',
                                                    'SMPIT' => 'bg-indigo-500/20 text-indigo-300 border-indigo-500/40',
                                                    'SMAIT' => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                                                    default => 'bg-slate-700 text-slate-300 border-slate-600'
                                                };
                                            @endphp
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black border {{ $badgeStyle }}">
                                                {{ $emp->school->name }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-emerald-500/20 text-emerald-300 border border-emerald-500/40">
                                                Yayasan Robbani
                                            </span>
                                        @endif

                                        <span class="text-[10px] text-slate-400 font-semibold uppercase">
                                            {{ $emp->role_type ?? 'STAFF' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Identitas (NIK / NIP) -->
                        <td class="px-5 py-4 font-mono text-xs">
                            <div class="text-white font-black">NIP: {{ $emp->nip ?? '-' }}</div>
                            <div class="text-slate-400 mt-0.5">NIK: {{ $emp->nik ?? '-' }}</div>
                            <div class="text-slate-500 text-[10px]">No KK: {{ $emp->kk_number ?? '-' }}</div>
                        </td>

                        <!-- Pendidikan & Kontak -->
                        <td class="px-5 py-4 text-xs">
                            <div class="font-bold text-white">
                                {{ $emp->last_education ?? 'S1' }} — {{ $emp->major ?? 'Pendidikan' }}
                            </div>
                            <div class="text-slate-300 font-mono mt-0.5">{{ $emp->phone ?? '-' }}</div>
                            <div class="text-slate-400 truncate max-w-[180px]">{{ $emp->email ?? '-' }}</div>
                        </td>

                        <!-- Kelengkapan E-Berkas -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black {{ $docCount >= 3 ? 'bg-emerald-950 text-emerald-300 border border-emerald-600' : 'bg-amber-950 text-amber-300 border border-amber-600' }}">
                                <span>📁</span> {{ $docCount }} / 9 Berkas
                            </span>
                            <div class="text-[10px] text-slate-400 mt-1">
                                KTP {{ !empty($emp->file_ktp) ? '✓' : '✗' }} • KK {{ !empty($emp->file_kk) ? '✓' : '✗' }} • Ijazah {{ !empty($emp->file_ijazah) ? '✓' : '✗' }}
                            </div>
                        </td>

                        <!-- Status & Face ID -->
                        <td class="px-5 py-4">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ ($emp->employment_status ?? 'TETAP') === 'TETAP' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40' : 'bg-amber-500/20 text-amber-300 border border-amber-500/40' }}">
                                    {{ $emp->employment_status ?? 'TETAP' }}
                                </span>
                            </div>
                            <div class="mt-1.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $emp->face_registered_at ? 'bg-emerald-950 text-emerald-300 border border-emerald-700' : 'bg-rose-950 text-rose-300 border border-rose-700' }}">
                                    {{ $emp->face_registered_at ? '✓ Face ID Aktif' : 'Belum Rekam Wajah' }}
                                </span>
                            </div>
                        </td>

                        <!-- Aksi Bidang SDM -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.employees.show', $emp->id) }}" 
                                   class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-600 transition-colors flex items-center gap-1 shadow-sm" 
                                   title="Lihat Dossier & Berkas">
                                    <span>👁️</span> Dossier
                                </a>
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" 
                                   class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition-colors flex items-center gap-1 shadow-sm" 
                                   title="Edit & Upload Berkas">
                                    <span>✏️</span> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs font-medium">
                            Tidak ditemukan data pegawai sesuai kriteria filter yang Anda pilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if(method_exists($employees, 'hasPages') && $employees->hasPages())
        <div class="p-4 border-t border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-950/60">
            <span class="text-xs text-slate-400 font-mono">
                Menampilkan baris {{ $employees->firstItem() ?? 0 }} - {{ $employees->lastItem() ?? 0 }} dari total {{ $employees->total() }} pegawai
            </span>
            <div>
                {{ $employees->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
