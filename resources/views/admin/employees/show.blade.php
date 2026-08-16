@extends('admin.layout')

@section('title', 'Profil & Berkas Pegawai: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Back Bar (Clean Light) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.employees.index') }}" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-base transition-colors border border-slate-200">
                ←
            </a>
            <div>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase">
                    📁 Profil &amp; Berkas Pegawai
                </span>
                <h1 class="text-xl font-black text-slate-900 mt-0.5">{{ $employee->full_name }}</h1>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs transition-colors shadow-sm flex items-center gap-1.5">
                <span>✏️</span> Edit Data &amp; Berkas
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-300 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-5 py-4 rounded-2xl font-bold text-xs flex items-center gap-2 shadow-xs">
        <span class="text-base">✓</span> {{ session('success') }}
    </div>
    @endif

    <!-- Main Grid: Left Profile Card, Right Files -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Biodata Pribadi & Info Kepegawaian (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Hero Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
                    <div class="w-24 h-24 rounded-3xl overflow-hidden border-2 {{ $employee->face_registered_at ? 'border-emerald-500 shadow-md' : 'border-slate-200' }} bg-slate-100 flex items-center justify-center shrink-0">
                        <img src="{{ $employee->face_photo_url ? (str_starts_with($employee->face_photo_url, 'http') ? $employee->face_photo_url : asset($employee->face_photo_url)) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->full_name) . '&background=059669&color=fff&bold=true&size=200' }}" 
                             alt="{{ $employee->full_name }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <div class="text-center sm:text-left flex-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1.5">
                            @if($employee->school)
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-black border border-blue-200">
                                    {{ $employee->school->name }} ({{ $employee->school->code }})
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black border border-emerald-200">
                                    🏛️ Yayasan Generasi Robbani
                                </span>
                            @endif

                            <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-black uppercase border border-purple-200">
                                {{ $employee->role_type ?? 'STAFF' }}
                            </span>

                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-black uppercase border border-amber-200">
                                {{ $employee->employment_status ?? 'TETAP' }}
                            </span>
                        </div>

                        <h2 class="text-2xl font-black text-slate-900">{{ $employee->full_name }}</h2>
                        <p class="text-xs text-slate-500 font-mono mt-0.5">
                            NIP: {{ $employee->nip ?? '-' }} • NIK: {{ $employee->nik ?? '-' }}
                        </p>

                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-3 text-xs text-slate-600 font-medium">
                            <span class="flex items-center gap-1.5">
                                <span>📞</span> {{ $employee->phone ?? '-' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span>✉️</span> {{ $employee->email ?? '-' }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span>📍</span> {{ $employee->address ?? 'Ogan Ilir, Sumatera Selatan' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-4 border-t border-slate-100 text-xs">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-500 font-bold block mb-1 uppercase text-[10px]">Tempat &amp; Tanggal Lahir</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $employee->pob ?? 'Palembang' }}, {{ $employee->dob ? date('d F Y', strtotime($employee->dob)) : '-' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-500 font-bold block mb-1 uppercase text-[10px]">Agama &amp; Golongan Darah</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $employee->religion ?? 'Islam' }} (Gol. Darah: {{ $employee->blood_type ?? 'O' }})</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-500 font-bold block mb-1 uppercase text-[10px]">Status Pernikahan &amp; Anak</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $employee->marital_status ?? 'Menikah' }} ({{ $employee->children_count ?? 0 }} Anak)</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="text-slate-500 font-bold block mb-1 uppercase text-[10px]">Tanggal Mulai Bergabung</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $employee->join_date ? date('d F Y', strtotime($employee->join_date)) : '1 Juli 2020' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 sm:col-span-2">
                        <span class="text-slate-500 font-bold block mb-1 uppercase text-[10px]">Pendidikan Terakhir &amp; Almamater</span>
                        <span class="font-extrabold text-slate-900 text-sm">{{ $employee->last_education ?? 'S1' }} {{ $employee->major ? '— ' . $employee->major : '' }}</span>
                        <span class="text-xs text-slate-500 block mt-0.5">{{ $employee->university ?? 'Universitas Terdaftar' }} (Lulus: {{ $employee->graduation_year ?? '-' }})</span>
                    </div>
                </div>
            </div>

            <!-- Riwayat Presensi Selfie Terakhir -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span>📍</span> Rekap Kehadiran Presensi Mobile Terkini
                </h3>

                @php
                    $logs = $recentAttendances ?? $attendanceLogs ?? [];
                @endphp

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-700">
                        <thead class="bg-slate-50 uppercase font-black text-slate-700 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Jam Masuk</th>
                                <th class="px-4 py-3">Jam Pulang</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @forelse($logs as $att)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono font-bold text-slate-900">{{ $att->date }}</td>
                                <td class="px-4 py-3 font-mono text-emerald-700 font-bold">{{ $att->check_in_time ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono text-slate-500">{{ $att->check_out_time ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ ($att->status ?? '') === 'LATE' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $att->status ?? 'ON_TIME' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada riwayat presensi mobile tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Digital Document Attachments (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                            <span>📁</span> Dokumen &amp; Berkas SDM
                        </h3>
                        <p class="text-[11px] text-slate-500 mt-0.5">Status: {{ $uploadedCount ?? 0 }} dari 9 Berkas Terunggah</p>
                    </div>
                    <a href="{{ route('admin.employees.edit', $employee->id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200">
                        + Unggah
                    </a>
                </div>

                <div class="space-y-3 text-xs font-semibold">
                    @foreach($dossierFiles as $doc)
                    <div class="p-3.5 rounded-2xl border {{ !empty($doc['val']) ? 'bg-emerald-50/50 border-emerald-200' : 'bg-slate-50 border-slate-200' }} flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="text-lg shrink-0">{{ $doc['icon'] }}</span>
                            <div class="truncate">
                                <div class="font-bold text-slate-900 truncate">{{ $doc['title'] }}</div>
                                <div class="text-[10px] {{ !empty($doc['val']) ? 'text-emerald-700 font-bold' : 'text-slate-400' }}">
                                    {{ !empty($doc['val']) ? '✓ Sudah Terunggah' : 'Belum Ada Dokumen' }}
                                </div>
                            </div>
                        </div>

                        @if(!empty($doc['val']))
                        <a href="{{ asset($doc['val']) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-extrabold shrink-0 shadow-sm">
                            Lihat
                        </a>
                        @else
                        <a href="{{ route('admin.employees.edit', $employee->id) }}" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-[11px] font-bold shrink-0">
                            Unggah
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Face ID Biometric Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span>📸</span> Biometrik Face ID Mobile
                </h3>
                <div class="text-xs space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Status Face ID:</span>
                        <span class="font-black {{ $employee->face_registered_at ? 'text-emerald-700' : 'text-rose-600' }}">
                            {{ $employee->face_registered_at ? '✓ Terdaftar Aktif' : 'Belum Didaftarkan' }}
                        </span>
                    </div>
                    @if($employee->face_registered_at)
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Waktu Rekam:</span>
                        <span class="font-mono text-slate-700 font-bold">{{ date('d M Y, H:i', strtotime($employee->face_registered_at)) }} WIB</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
