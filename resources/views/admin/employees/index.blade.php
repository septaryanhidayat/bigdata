@extends('admin.layout')

@section('title', 'Database Induk & E-Berkas SDM SIT Robbani')

@section('content')
<div class="space-y-6">
    <!-- Header Hero Banner (Clean Executive Light Design) -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-md border border-emerald-600/30 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 text-white text-xs font-black tracking-wider uppercase backdrop-blur-sm border border-white/20 mb-3">
                    <span>📁</span> Pusat Data Kepegawaian &amp; E-Berkas Yayasan
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">Database Induk &amp; Berkas Pegawai SIT Robbani</h1>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1.5 max-w-2xl font-medium leading-relaxed">
                    Pusat arsip digital profil guru &amp; staf: KTP, KK, Ijazah, Surat Lamaran, SK Kontrak, Sertifikat, Prestasi, NPWP, dan BPJS terintegrasi presensi mobile.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-5 py-2.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-900 font-extrabold text-xs shadow-md transition-all flex items-center gap-2">
                    <span>📱</span> Monitoring Presensi Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Clean Light Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Total Pegawai SDM -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 border-l-4 border-l-blue-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Total Pegawai SDM</span>
                <span class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold border border-blue-100">👥</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-slate-900">{{ $totalEmployees }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Guru &amp; Karyawan Yayasan</p>
            </div>
        </div>

        <!-- 2. Tenaga Pendidik (Guru) -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 border-l-4 border-l-emerald-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Tenaga Pendidik (Guru)</span>
                <span class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold border border-emerald-100">👨‍🏫</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-emerald-700">{{ $totalTeachers }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Ustadz &amp; Ustadzah Aktif</p>
            </div>
        </div>

        <!-- 3. Tenaga Kependidikan / Staf -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 border-l-4 border-l-purple-600 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Tenaga Kependidikan</span>
                <span class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold border border-purple-100">💼</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-purple-700">{{ $totalStaff }}</h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Staf TU, Keuangan &amp; Layanan</p>
            </div>
        </div>

        <!-- 4. Face ID Biometrik -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200 border-l-4 border-l-amber-500 shadow-sm hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Face ID Terdaftar</span>
                <span class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold border border-amber-100">📸</span>
            </div>
            <div class="mt-3">
                <h3 class="text-3xl font-black text-amber-700">{{ $enrolledFaces ?? $enrolledFaceCount ?? 0 }} <span class="text-base text-slate-400 font-semibold">/ {{ $totalEmployees ?? 0 }}</span></h3>
                <p class="text-xs text-slate-500 mt-1 font-medium">Wajah Aktif Presensi Mobile</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('admin.employees.index') }}" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3.5">
                <div class="flex items-center gap-2">
                    <span class="text-base">🔍</span>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider">Filter &amp; Pencarian Data Pegawai</h3>
                </div>
                <div class="text-xs text-slate-500 font-semibold">
                    Menampilkan <span class="font-black text-slate-900">{{ $employees->total() }}</span> pegawai terdaftar
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
                <!-- 1. Search Keyword -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Cari Nama / NIP / NIK</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Ketik nama atau nomor identitas..." 
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-semibold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <!-- 2. Unit Penempatan -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Unit Penempatan</label>
                    <select name="school_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="">Semua Unit (Yayasan &amp; Sekolah)</option>
                        <option value="yayasan" {{ request('school_id') === 'yayasan' ? 'selected' : '' }}>🏛️ Yayasan Generasi Robbani</option>
                        @foreach($schools as $sc)
                            <option value="{{ $sc->id }}" {{ request('school_id') == $sc->id ? 'selected' : '' }}>
                                🏫 {{ $sc->name }} ({{ $sc->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Peran / Jabatan -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Peran / Jabatan</label>
                    <select name="role_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="all" {{ request('role_type') === 'all' ? 'selected' : '' }}>Semua Jabatan</option>
                        <option value="TEACHER" {{ request('role_type') === 'TEACHER' ? 'selected' : '' }}>Tenaga Pendidik (Guru)</option>
                        <option value="HEADMASTER" {{ request('role_type') === 'HEADMASTER' ? 'selected' : '' }}>Kepala Unit / Sekolah</option>
                        <option value="STAFF" {{ request('role_type') === 'STAFF' ? 'selected' : '' }}>Tenaga Kependidikan (Staf)</option>
                        <option value="STAFF_TU" {{ request('role_type') === 'STAFF_TU' ? 'selected' : '' }}>Tata Usaha (TU)</option>
                        <option value="STAFF_KEUANGAN" {{ request('role_type') === 'STAFF_KEUANGAN' ? 'selected' : '' }}>Keuangan / Bendahara</option>
                    </select>
                </div>

                <!-- 4. Jumlah Tampilan Data (Per Page) -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Tampilkan Jumlah Data</label>
                    <select name="per_page" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="15" {{ request('per_page', '25') == '15' ? 'selected' : '' }}>15 data per halaman</option>
                        <option value="25" {{ request('per_page', '25') == '25' ? 'selected' : '' }}>25 data per halaman</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 data per halaman</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 data per halaman</option>
                        <option value="500" {{ request('per_page') == '500' ? 'selected' : '' }}>500 data per halaman</option>
                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>Semua Data Sekaligus</option>
                    </select>
                </div>

                <!-- 5. Tombol Aksi Filter -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-black shadow-sm transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                        <span>🔍</span> Terapkan
                    </button>
                    <a href="{{ route('admin.employees.index') }}" class="py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold border border-slate-300 transition-colors" title="Reset Filter">
                        🔄
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Main Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 border-b border-slate-200 text-[11px] font-black text-slate-700 uppercase tracking-wider">
                        <th class="px-5 py-4 w-12 text-center">No</th>
                        <th class="px-5 py-4 min-w-[260px]">Pegawai &amp; Penugasan</th>
                        <th class="px-5 py-4 min-w-[200px]">NIP &amp; Kependudukan</th>
                        <th class="px-5 py-4 min-w-[200px]">Kontak &amp; Alamat</th>
                        <th class="px-5 py-4 min-w-[180px]">Pendidikan Formal</th>
                        <th class="px-5 py-4 text-center min-w-[120px]">E-Berkas</th>
                        <th class="px-5 py-4 min-w-[140px]">Status &amp; Face ID</th>
                        <th class="px-5 py-4 text-center min-w-[170px]">Aksi SDM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium">
                    @forelse($employees as $index => $emp)
                    @php
                        // Hitung jumlah berkas terunggah
                        $docCount = 0;
                        $docs = ['file_ktp', 'file_kk', 'file_ijazah', 'file_surat_lamaran', 'file_kontrak_kerja', 'file_sertifikat', 'file_prestasi', 'file_npwp', 'file_bpjs'];
                        foreach ($docs as $d) {
                            if (!empty($emp->$d)) $docCount++;
                        }

                        // Photo Source
                        $empPhoto = $emp->face_photo_url 
                            ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) 
                            : ($emp->user && $emp->user->avatar ? (str_starts_with($emp->user->avatar, 'http') ? $emp->user->avatar : asset($emp->user->avatar)) : 'https://ui-avatars.com/api/?name=' . urlencode($emp->full_name) . '&background=059669&color=fff&bold=true&size=120');

                        // Role Formatting
                        $roleTitle = match($emp->role_type) {
                            'TEACHER' => 'Tenaga Pendidik (Guru)',
                            'HEADMASTER' => 'Kepala Unit / Sekolah',
                            'STAFF_TU' => 'Tata Usaha (TU)',
                            'STAFF_KEUANGAN' => 'Keuangan / Bendahara',
                            'SUPER_ADMIN' => 'Pimpinan Yayasan',
                            default => 'Tenaga Kependidikan (Staf)',
                        };

                        // Status Formatting
                        $statusBadgeColor = match($emp->employment_status) {
                            'TETAP' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                            'KONTRAK' => 'bg-blue-100 text-blue-900 border-blue-300',
                            default => 'bg-amber-100 text-amber-900 border-amber-300',
                        };

                        // Unit Badge Formatting
                        $unitBadgeStyle = 'bg-slate-100 text-slate-800 border-slate-200';
                        $unitName = '🏛️ Yayasan Pusat';
                        if ($emp->school) {
                            $code = strtoupper($emp->school->code);
                            $unitName = $emp->school->name;
                            $unitBadgeStyle = match($code) {
                                'TKIT' => 'bg-pink-100 text-pink-900 border-pink-300',
                                'SDIT' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
                                'SMPIT' => 'bg-blue-100 text-blue-900 border-blue-300',
                                'SMAIT' => 'bg-purple-100 text-purple-900 border-purple-300',
                                default => 'bg-slate-100 text-slate-800 border-slate-200'
                            };
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <!-- No -->
                        <td class="px-5 py-4 text-center font-bold text-slate-400">
                            {{ method_exists($employees, 'firstItem') && $employees->firstItem() ? $employees->firstItem() + $index : $index + 1 }}
                        </td>

                        <!-- Pegawai & Unit -->
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-12 h-12 rounded-2xl overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-500 shadow-sm' : 'border-slate-200' }} bg-slate-100 flex items-center justify-center shrink-0">
                                    <img src="{{ $empPhoto }}" 
                                         alt="{{ $emp->full_name }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('admin.employees.show', $emp->id) }}" class="font-black text-slate-900 text-sm hover:text-emerald-700 transition-colors truncate block">
                                        {{ $emp->full_name }}
                                    </a>
                                    <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black border {{ $unitBadgeStyle }}">
                                            {{ $unitName }}
                                        </span>
                                        <span class="text-[11px] text-slate-600 font-bold">
                                            • {{ $roleTitle }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Identitas (NIP, NIK, KK) -->
                        <td class="px-5 py-4 font-mono text-xs">
                            <div class="text-slate-900 font-bold flex items-center gap-1.5">
                                <span class="text-[10px] text-slate-400 font-sans uppercase">NIP:</span>
                                <span>{{ $emp->nip ?? '-' }}</span>
                            </div>
                            <div class="text-slate-700 mt-1 flex items-center gap-1.5">
                                <span class="text-[10px] text-slate-400 font-sans uppercase">NIK:</span>
                                <span>{{ $emp->nik ?? '-' }}</span>
                            </div>
                            <div class="text-slate-500 text-[11px] mt-0.5 flex items-center gap-1.5">
                                <span class="text-[10px] text-slate-400 font-sans uppercase">KK:</span>
                                <span>{{ $emp->kk_number ?? '-' }}</span>
                            </div>
                        </td>

                        <!-- Kontak & Domisili -->
                        <td class="px-5 py-4 text-xs">
                            @if(!empty($emp->phone))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $emp->phone) }}" target="_blank" class="text-emerald-700 font-black font-mono hover:underline flex items-center gap-1">
                                <span>💬</span> {{ $emp->phone }}
                            </a>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif

                            <div class="text-slate-600 mt-1 truncate max-w-[190px]">
                                {{ $emp->email ?? '-' }}
                            </div>
                            <div class="text-slate-400 text-[11px] mt-0.5 truncate max-w-[190px]">
                                📍 {{ $emp->address ?? 'Ogan Ilir' }}
                            </div>
                        </td>

                        <!-- Pendidikan Formal -->
                        <td class="px-5 py-4 text-xs">
                            <div class="font-black text-slate-900">
                                {{ $emp->last_education ?? 'S1' }} {{ $emp->major ? '— ' . $emp->major : '' }}
                            </div>
                            <div class="text-slate-500 text-[11px] mt-0.5 truncate max-w-[170px]">
                                {{ $emp->university ?? 'Universitas Terdaftar' }}
                            </div>
                        </td>

                        <!-- Kelengkapan Berkas -->
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-xs font-black {{ $docCount >= 3 ? 'bg-emerald-50 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                <span>📁</span> {{ $docCount }} / 9 Berkas
                            </span>
                        </td>

                        <!-- Status & Face ID -->
                        <td class="px-5 py-4 space-y-1.5">
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase border {{ $statusBadgeColor }}">
                                    {{ $emp->employment_status ?? 'TETAP' }}
                                </span>
                            </div>
                            <div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $emp->face_registered_at ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-500 border border-slate-200' }}">
                                    {{ $emp->face_registered_at ? '✓ Face ID Aktif' : 'Belum Ada Foto' }}
                                </span>
                            </div>
                        </td>

                        <!-- Aksi SDM -->
                        <td class="px-5 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.employees.show', $emp->id) }}" 
                                   class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300 transition-colors shadow-xs flex items-center gap-1" 
                                   title="Lihat Profil & Berkas Pegawai">
                                    <span>👁️</span> Profil
                                </a>
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" 
                                   class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-colors shadow-xs flex items-center gap-1" 
                                   title="Edit Biodata & Upload Berkas">
                                    <span>✏️</span> Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-400 text-xs font-semibold">
                            Tidak ditemukan data pegawai yang sesuai dengan filter pencarian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if(method_exists($employees, 'hasPages') && $employees->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-slate-600 font-semibold">
                Menampilkan <span class="font-black text-slate-900">{{ $employees->firstItem() }}</span> s/d <span class="font-black text-slate-900">{{ $employees->lastItem() }}</span> dari total <span class="font-black text-slate-900">{{ $employees->total() }}</span> pegawai
            </div>
            <div>
                {{ $employees->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
