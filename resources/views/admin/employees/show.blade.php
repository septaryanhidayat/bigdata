@extends('admin.layout')

@section('title', 'Dossier Lengkap Pegawai: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase mb-1">
                <span>📁</span> Arsip Digital SDM Yayasan
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Curriculum Vitae &amp; Dossier Pegawai</h1>
            <p class="text-xs text-slate-500 font-medium">Rekam jejak, identitas kependudukan, arsip berkas resmi, dan riwayat presensi SDM.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs transition-colors shadow-sm flex items-center gap-1.5">
                <span>✏️</span> Edit Profil &amp; Berkas
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Main Profile Hero Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 lg:p-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="w-28 h-28 rounded-3xl overflow-hidden border-4 {{ $employee->face_registered_at ? 'border-emerald-500 shadow-lg shadow-emerald-500/20' : 'border-slate-300' }} bg-slate-100 shrink-0">
                <img src="{{ $employee->face_photo_url ? (str_starts_with($employee->face_photo_url, 'http') ? $employee->face_photo_url : asset($employee->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300' }}" 
                     alt="{{ $employee->full_name }}" 
                     class="w-full h-full object-cover">
            </div>
            
            <div class="flex-1 text-center md:text-left min-w-0 space-y-2">
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                        {{ $employee->school->name ?? 'Yayasan SIT Robbani' }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-100 text-blue-800 border border-blue-300">
                        {{ $employee->role_type }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-black bg-slate-100 text-slate-800 border border-slate-300">
                        {{ $employee->employment_status }}
                    </span>
                    <span class="px-3 py-1 rounded-full text-xs font-black {{ $employee->face_registered_at ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                        {{ $employee->face_registered_at ? '✓ Biometrik Face ID Terdaftar' : 'Belum Rekam Face ID' }}
                    </span>
                </div>

                <h2 class="text-2xl lg:text-3xl font-black text-slate-900 dark:text-white">
                    {{ $employee->title_prefix }} {{ $employee->full_name }} {{ $employee->title_suffix }}
                </h2>

                <p class="text-xs text-slate-500 font-mono font-bold">
                    NIP: {{ $employee->nip ?? '-' }} • NIK: {{ $employee->nik ?? '-' }} • No KK: {{ $employee->kk_number ?? '-' }}
                </p>

                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-xs font-medium text-slate-600 dark:text-slate-400 pt-2">
                    <span>📱 {{ $employee->phone ?? '-' }}</span>
                    <span>✉️ {{ $employee->email ?? '-' }}</span>
                    <span>📍 {{ $employee->address ?? 'Ogan Ilir, Sumatera Selatan' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2 Columns: Detailed Information & Document Archive -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Personnel Information (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Biodata & Pendidikan -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span>📋</span> Biodata &amp; Riwayat Akademik
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-400 font-bold block mb-1 uppercase text-[10px]">Tempat &amp; Tanggal Lahir</span>
                        <span class="font-extrabold text-slate-800 dark:text-white">{{ $employee->pob ?? '-' }}, {{ $employee->dob ? date('d F Y', strtotime($employee->dob)) : '-' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-400 font-bold block mb-1 uppercase text-[10px]">Jenis Kelamin / Agama</span>
                        <span class="font-extrabold text-slate-800 dark:text-white">{{ $employee->gender == 'M' ? 'Laki-laki (Ikhwan)' : 'Perempuan (Akhwat)' }} • {{ $employee->religion ?? 'ISLAM' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-400 font-bold block mb-1 uppercase text-[10px]">Status Pernikahan / Anak</span>
                        <span class="font-extrabold text-slate-800 dark:text-white">{{ $employee->marital_status ?? 'MENIKAH' }} ({{ $employee->children_count ?? 0 }} Anak) • Gol. Darah: {{ $employee->blood_type ?? '-' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-400 font-bold block mb-1 uppercase text-[10px]">TMT Mulai Bekerja (Join Date)</span>
                        <span class="font-extrabold text-emerald-600 font-mono">{{ $employee->join_date ? date('d F Y', strtotime($employee->join_date)) : '2022-07-01' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 sm:col-span-2">
                        <span class="text-slate-400 font-bold block mb-1 uppercase text-[10px]">Pendidikan Terakhir &amp; Almamater</span>
                        <span class="font-extrabold text-slate-800 dark:text-white text-sm">{{ $employee->last_education ?? 'S1' }} {{ $employee->major ? '— ' . $employee->major : '' }}</span>
                        <span class="text-xs text-slate-500 block mt-0.5">{{ $employee->university ?? 'Universitas Terdaftar' }} (Lulus Tahun: {{ $employee->graduation_year ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Presensi Selfie Terakhir -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span>📍</span> Rekap Kehadiran Presensi Mobile Terkini
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700 dark:text-slate-300">
                        <thead class="bg-slate-100 dark:bg-slate-950 uppercase font-black">
                            <tr>
                                <th class="px-4 py-2.5">Tanggal</th>
                                <th class="px-4 py-2.5">Jam Masuk</th>
                                <th class="px-4 py-2.5">Jam Pulang</th>
                                <th class="px-4 py-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-medium">
                            @forelse($recentAttendances as $att)
                            <tr>
                                <td class="px-4 py-3 font-mono font-bold">{{ $att->date }}</td>
                                <td class="px-4 py-3 font-mono text-emerald-600 font-bold">{{ $att->check_in_time ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono text-slate-500">{{ $att->check_out_time ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $att->status === 'LATE' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $att->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat presensi selfie tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Digital Document Dossier & Attachments (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center justify-between">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>📁</span> E-Berkas Digital SDM
                    </h3>
                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="text-xs font-bold text-emerald-600 hover:underline">
                        + Unggah
                    </a>
                </div>

                <div class="space-y-3 text-xs font-semibold">
                    <!-- 1. KTP -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">🪪</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">KTP Pegawai</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_ktp ? 'Terverifikasi' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_ktp)
                        <a href="{{ asset($employee->file_ktp) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 2. KK -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">👨‍👩‍👧</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">Kartu Keluarga (KK)</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_kk ? 'Terverifikasi' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_kk)
                        <a href="{{ asset($employee->file_kk) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 3. Ijazah -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">🎓</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">Ijazah &amp; Transkrip</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_ijazah ? 'Terverifikasi' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_ijazah)
                        <a href="{{ asset($employee->file_ijazah) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 4. Surat Lamaran -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">✉️</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">Surat Lamaran Kerja</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_surat_lamaran ? 'Tersimpan' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_surat_lamaran)
                        <a href="{{ asset($employee->file_surat_lamaran) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 5. Kontrak Kerja -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">📜</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">SK / Kontrak Kerja</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_kontrak_kerja ? 'Tersimpan' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_kontrak_kerja)
                        <a href="{{ asset($employee->file_kontrak_kerja) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 6. Sertifikat -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">🎖️</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">Sertifikat Pendidik</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_sertifikat ? 'Tersimpan' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_sertifikat)
                        <a href="{{ asset($employee->file_sertifikat) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>

                    <!-- 7. Piagam Prestasi -->
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="text-base">🏆</span>
                            <div>
                                <h5 class="text-slate-900 dark:text-white font-bold">Piagam Prestasi</h5>
                                <span class="text-[10px] text-slate-400">{{ $employee->file_prestasi ? 'Tersimpan' : 'Belum Diunggah' }}</span>
                            </div>
                        </div>
                        @if($employee->file_prestasi)
                        <a href="{{ asset($employee->file_prestasi) }}" target="_blank" class="px-3 py-1 rounded-lg bg-emerald-500 text-slate-950 font-black text-[11px]">Buka</a>
                        @else
                        <span class="text-[11px] text-slate-400">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
