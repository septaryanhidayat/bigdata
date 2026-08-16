@extends('admin.layout')

@section('title', 'Database Induk & E-Berkas Pegawai SDM SIT Robbani')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-2xl border border-emerald-500/30 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-400/20 text-emerald-300 text-xs font-black tracking-wider uppercase border border-emerald-400/40 mb-3">
                    <span>📑</span> Arsip &amp; Database Pegangan Yayasan
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight">Database Induk &amp; E-Berkas SDM SIT Robbani</h1>
                <p class="text-emerald-100 text-sm mt-1.5 max-w-2xl font-medium">
                    Pusat arsip profil lengkap guru &amp; staf: KTP, KK, Ijazah, Surat Lamaran, SK Kontrak, Sertifikat Pendidik, Piagam Prestasi, NPWP, dan BPJS terintegrasi sistem presensi.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-emerald-300 font-bold text-xs border border-slate-700 transition-all flex items-center gap-2">
                    <span>📱</span> Monitoring Presensi Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 uppercase tracking-wider">Total Pegawai SDM</span>
                <span class="p-2.5 rounded-xl bg-blue-50 text-blue-600 text-lg">👥</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalEmployees }}</h3>
                <p class="text-xs text-slate-500 mt-1">Guru &amp; Karyawan Yayasan</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-emerald-200 dark:border-emerald-800/60 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-wider">Tenaga Pendidik (Guru)</span>
                <span class="p-2.5 rounded-xl bg-emerald-50 text-emerald-600 text-lg">👨‍🏫</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-emerald-600">{{ $totalTeachers }}</h3>
                <p class="text-xs text-emerald-700/80 mt-1">Ustadz &amp; Ustadzah</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-purple-200 dark:border-purple-800/60 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-purple-700 uppercase tracking-wider">Tenaga Kependidikan</span>
                <span class="p-2.5 rounded-xl bg-purple-50 text-purple-600 text-lg">💼</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-purple-600">{{ $totalStaff }}</h3>
                <p class="text-xs text-purple-700/80 mt-1">Staf TU, Keuangan, Sarpras</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-amber-200 dark:border-amber-800/60 shadow-sm">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-amber-700 uppercase tracking-wider">Berkas Digital Lengkap</span>
                <span class="p-2.5 rounded-xl bg-amber-50 text-amber-600 text-lg">📁</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-amber-600">{{ $completeDossierCount }}</h3>
                <p class="text-xs text-amber-700/80 mt-1">KTP, KK &amp; Ijazah terunggah</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-sm">
        <form method="GET" action="{{ route('admin.employees.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase mb-1">Cari Pegawai</label>
                <input type="text" name="search" value="{{ $search }}" placeholder="Nama, NIP, NIK, Telp..." class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase mb-1">Unit Sekolah</label>
                <select name="school_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                    <option value="all">Semua Unit (Yayasan)</option>
                    @foreach($schools as $s)
                    <option value="{{ $s->id }}" {{ $schoolId == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase mb-1">Peran / Jabatan</label>
                <select name="role_type" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                    <option value="">Semua Peran</option>
                    <option value="TEACHER" {{ $roleType == 'TEACHER' ? 'selected' : '' }}>Guru / Tenaga Pendidik</option>
                    <option value="HEADMASTER" {{ $roleType == 'HEADMASTER' ? 'selected' : '' }}>Kepala Sekolah</option>
                    <option value="STAFF" {{ $roleType == 'STAFF' ? 'selected' : '' }}>Staf Karyawan</option>
                    <option value="COUNSELOR" {{ $roleType == 'COUNSELOR' ? 'selected' : '' }}>Guru BK / Konselor</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-black text-slate-500 uppercase mb-1">Status Kepegawaian</label>
                <select name="employment_status" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                    <option value="">Semua Status</option>
                    <option value="PERMANENT" {{ $status == 'PERMANENT' ? 'selected' : '' }}>Pegawai Tetap (GTY/PTY)</option>
                    <option value="CONTRACT" {{ $status == 'CONTRACT' ? 'selected' : '' }}>Pegawai Kontrak</option>
                    <option value="HONORARY" {{ $status == 'HONORARY' ? 'selected' : '' }}>Guru Honorer / Magang</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition-colors shadow-sm">
                    🔍 Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table of Employees -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-950 text-xs uppercase text-slate-700 dark:text-slate-300 font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Pegawai &amp; Unit</th>
                        <th class="px-6 py-4">Identitas (NIK / NIP)</th>
                        <th class="px-6 py-4">Pendidikan &amp; Kontak</th>
                        <th class="px-6 py-4">Kelengkapan E-Berkas</th>
                        <th class="px-6 py-4">Status &amp; Face ID</th>
                        <th class="px-6 py-4 text-center">Aksi Bidang SDM</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($employees as $emp)
                    @php
                        $dossierCount = 0;
                        if($emp->file_ktp) $dossierCount++;
                        if($emp->file_kk) $dossierCount++;
                        if($emp->file_ijazah) $dossierCount++;
                        if($emp->file_surat_lamaran) $dossierCount++;
                        if($emp->file_kontrak_kerja) $dossierCount++;
                        if($emp->file_sertifikat) $dossierCount++;
                        if($emp->file_prestasi) $dossierCount++;
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 rounded-full overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-500' : 'border-slate-300' }} bg-slate-100 shrink-0">
                                    <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $emp->full_name }}</h4>
                                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold">{{ $emp->school->name ?? 'Yayasan Robbani' }}</span>
                                    <span class="block text-[11px] text-slate-400 font-semibold">{{ $emp->role_type }} • {{ $emp->employment_status }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 font-mono text-xs">
                            <div class="text-slate-800 dark:text-slate-200 font-bold">NIP: {{ $emp->nip ?? '-' }}</div>
                            <div class="text-slate-500 dark:text-slate-400">NIK: {{ $emp->nik ?? '-' }}</div>
                            <div class="text-slate-400 text-[10px]">No KK: {{ $emp->kk_number ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4 text-xs">
                            <div class="font-bold text-slate-800 dark:text-slate-200">{{ $emp->last_education ?? 'S1' }} {{ $emp->major ? '— ' . $emp->major : '' }}</div>
                            <div class="text-slate-500 dark:text-slate-400">{{ $emp->phone ?? '-' }}</div>
                            <div class="text-slate-400 text-[10px] truncate max-w-[150px]">{{ $emp->email ?? '-' }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $dossierCount >= 4 ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                                    📁 {{ $dossierCount }} / 7 Berkas
                                </span>
                            </div>
                            <div class="flex items-center gap-1.5 mt-1.5 text-[10px] text-slate-500 font-semibold">
                                <span class="{{ $emp->file_ktp ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ $emp->file_ktp ? '✓ KTP' : '— KTP' }}</span>
                                <span>•</span>
                                <span class="{{ $emp->file_kk ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ $emp->file_kk ? '✓ KK' : '— KK' }}</span>
                                <span>•</span>
                                <span class="{{ $emp->file_ijazah ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ $emp->file_ijazah ? '✓ Ijazah' : '— Ijazah' }}</span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $emp->face_registered_at ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-300' }}">
                                {{ $emp->face_registered_at ? '✓ Face ID Aktif' : 'Belum Rekam Wajah' }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.employees.show', $emp->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300 transition-colors" title="Lihat Dossier & Berkas">
                                    👁️ Dossier
                                </a>
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" class="px-3 py-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition-colors shadow-sm" title="Edit Profil & Berkas">
                                    ✏️ Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-xs font-semibold">
                            Tidak ada data pegawai yang sesuai dengan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
