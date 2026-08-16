@extends('admin.layout')

@section('title', 'Database Induk & Berkas SDM SIT Robbani')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner (Clean Vibrant Light Design) -->
    <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 rounded-3xl p-6 lg:p-8 text-white shadow-lg border border-emerald-500/30 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 text-white text-xs font-black tracking-wider uppercase backdrop-blur-sm border border-white/30 mb-3">
                    <span>📁</span> Arsip &amp; Database Kepegawaian Yayasan
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">Database Induk &amp; Berkas Pegawai SIT Robbani</h1>
                <p class="text-emerald-50 text-sm mt-1.5 max-w-2xl font-medium leading-relaxed">
                    Pusat arsip digital profil guru &amp; staf: KTP, KK, Ijazah, Surat Lamaran, SK Kontrak, Sertifikat Pendidik, Piagam Prestasi, NPWP, dan BPJS terintegrasi presensi mobile.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-5 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-800 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                    <span>📱</span> Monitoring Presensi Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Clean Light Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Pegawai SDM -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-blue-700 uppercase tracking-wider">Total Pegawai SDM</span>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold border border-blue-100">👥</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-slate-900">{{ $totalEmployees }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Guru &amp; Karyawan Yayasan</p>
            </div>
        </div>

        <!-- 2. Tenaga Pendidik (Guru) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-wider">Tenaga Pendidik (Guru)</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold border border-emerald-100">👨‍🏫</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-emerald-600">{{ $totalTeachers }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Ustadz &amp; Ustadzah Aktif</p>
            </div>
        </div>

        <!-- 3. Tenaga Kependidikan / Staf -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-purple-700 uppercase tracking-wider">Tenaga Kependidikan</span>
                <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold border border-purple-100">💼</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-purple-700">{{ $totalStaff }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Staf TU, Keuangan, Sarpras</p>
            </div>
        </div>

        <!-- 4. Face ID Terdaftar -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-amber-700 uppercase tracking-wider">Face ID Mobile</span>
                <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold border border-amber-100">📸</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-amber-600">{{ $enrolledFaceCount }} <span class="text-xs font-normal text-slate-400">/ {{ $totalEmployees }}</span></h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Biometrik Wajah Terverifikasi</p>
            </div>
        </div>
    </div>

    <!-- Clean Light Filter & Search Box -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5 lg:p-6 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
            <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                <span class="text-emerald-600">🔍</span> Filter &amp; Pencarian Data Pegawai
            </h3>
            <span class="text-xs text-slate-500 font-bold font-mono bg-slate-100 px-3 py-1 rounded-full">
                Menampilkan: {{ $employees->count() }} dari total {{ $employees->total() }} Data
            </span>
        </div>

        <form action="{{ route('admin.employees.index') }}" method="GET" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Search Input -->
                <div class="lg:col-span-1">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Cari Nama / NIP / Email</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search', $search) }}" 
                           placeholder="Ketik nama, NIP, email..." 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-bold text-xs border border-slate-300 focus:border-emerald-500 focus:bg-white focus:outline-none placeholder-slate-400 transition-all">
                </div>

                <!-- Unit Sekolah -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Unit Penempatan</label>
                    <select name="school_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-bold text-xs border border-slate-300 focus:border-emerald-500 focus:bg-white focus:outline-none transition-all">
                        <option value="all" {{ ($schoolId === 'all' || $schoolId === null || $schoolId === '') ? 'selected' : '' }}>Semua Unit (Yayasan + Sekolah)</option>
                        <option value="yayasan" {{ ($schoolId === 'yayasan' || $schoolId === '0') ? 'selected' : '' }}>🏛️ Yayasan Pusat</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}" {{ (string)$schoolId === (string)$sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Peran / Jabatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peran / Jabatan</label>
                    <select name="role_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 text-slate-900 font-bold text-xs border border-slate-300 focus:border-emerald-500 focus:bg-white focus:outline-none transition-all">
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tampilkan Jumlah Data</label>
                    <select name="per_page" class="w-full px-3.5 py-2.5 rounded-xl bg-emerald-50/70 text-emerald-900 font-black text-xs border border-emerald-300 focus:border-emerald-500 focus:bg-white focus:outline-none transition-all">
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
                <a href="{{ route('admin.employees.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-300 transition-colors">
                    🔄 Reset Filter
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer">
                    <span>🔍</span> Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Clean Light Employee Table Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase text-slate-700 font-black border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Pegawai &amp; Unit</th>
                        <th class="px-5 py-4">Identitas (NIK / NIP)</th>
                        <th class="px-5 py-4">Pendidikan &amp; Kontak</th>
                        <th class="px-5 py-4">Kelengkapan Berkas</th>
                        <th class="px-5 py-4">Status &amp; Face ID</th>
                        <th class="px-5 py-4 text-center">Aksi SDM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($employees as $emp)
                    @php
                        // Calculate uploaded file counts
                        $docCount = 0;
                        $docs = ['file_ktp', 'file_kk', 'file_ijazah', 'file_surat_lamaran', 'file_kontrak_kerja', 'file_sertifikat', 'file_prestasi', 'file_npwp', 'file_bpjs'];
                        foreach($docs as $d) {
                            if(!empty($emp->$d)) $docCount++;
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- Pegawai & Unit -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-2xl overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-500 shadow-sm' : 'border-slate-200' }} bg-slate-100 flex items-center justify-center shrink-0">
                                    <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($emp->full_name) . '&background=059669&color=fff&bold=true' }}" 
                                         alt="{{ $emp->full_name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <div class="font-black text-slate-900 text-sm truncate">{{ $emp->full_name }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($emp->school)
                                            @php
                                                $unitCode = strtoupper($emp->school->code);
                                                $badgeStyle = match($unitCode) {
                                                    'TKIT' => 'bg-pink-100 text-pink-800 border-pink-200',
                                                    'SDIT' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                    'SMPIT' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                                                    'SMAIT' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                    default => 'bg-slate-100 text-slate-800 border-slate-200'
                                                };
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $badgeStyle }}">
                                                {{ $emp->school->name }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                Yayasan Robbani
                                            </span>
                                        @endif

                                        <span class="text-[10px] text-slate-500 font-bold uppercase">
                                            {{ $emp->role_type ?? 'STAFF' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Identitas (NIK / NIP) -->
                        <td class="px-5 py-4 font-mono text-xs">
                            <div class="text-slate-900 font-black">NIP: {{ $emp->nip ?? '-' }}</div>
                            <div class="text-slate-600 mt-0.5">NIK: {{ $emp->nik ?? '-' }}</div>
                            <div class="text-slate-400 text-[10px]">No KK: {{ $emp->kk_number ?? '-' }}</div>
                        </td>

                        <!-- Pendidikan & Kontak -->
                        <td class="px-5 py-4 text-xs">
                            <div class="font-bold text-slate-900">
                                {{ $emp->last_education ?? 'S1' }} — {{ $emp->major ?? 'Pendidikan' }}
                            </div>
                            <div class="text-slate-700 font-mono mt-0.5">{{ $emp->phone ?? '-' }}</div>
                            <div class="text-slate-500 truncate max-w-[180px]">{{ $emp->email ?? '-' }}</div>
                        </td>

                        <!-- Kelengkapan Berkas -->
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black {{ $docCount >= 3 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                <span>📁</span> {{ $docCount }} / 9 Berkas
                            </span>
                            <div class="text-[10px] text-slate-500 mt-1">
                                KTP {{ !empty($emp->file_ktp) ? '✓' : '✗' }} • KK {{ !empty($emp->file_kk) ? '✓' : '✗' }} • Ijazah {{ !empty($emp->file_ijazah) ? '✓' : '✗' }}
                            </div>
                        </td>

                        <!-- Status & Face ID -->
                        <td class="px-5 py-4">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ ($emp->employment_status ?? 'TETAP') === 'TETAP' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                                    {{ $emp->employment_status ?? 'TETAP' }}
                                </span>
                            </div>
                            <div class="mt-1.5">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $emp->face_registered_at ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                    {{ $emp->face_registered_at ? '✓ Face ID Aktif' : 'Belum Rekam Wajah' }}
                                </span>
                            </div>
                        </td>

                        <!-- Aksi Bidang SDM -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.employees.show', $emp->id) }}" 
                                   class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300 transition-colors flex items-center gap-1 shadow-sm" 
                                   title="Lihat Profil & Berkas Pegawai">
                                    <span>👁️</span> Lihat Profil
                                </a>
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" 
                                   class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-colors flex items-center gap-1 shadow-sm" 
                                   title="Edit Biodata & Upload Berkas">
                                    <span>✏️</span> Edit Data
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500 text-xs font-medium">
                            Tidak ditemukan data pegawai sesuai kriteria filter yang Anda pilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if(method_exists($employees, 'hasPages') && $employees->hasPages())
        <div class="p-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <span class="text-xs text-slate-500 font-mono">
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
