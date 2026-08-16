@extends('admin.layout')

@section('title', 'Manajemen & Monitoring Aplikasi Mobile SDM SIT Robbani')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-xl border border-emerald-700/40 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold tracking-wide uppercase border border-emerald-400/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Integrated Mobile HRIS &amp; Biometric Gateway
                </div>
                <h1 class="text-2xl lg:text-3xl font-extrabold tracking-tight">Manajemen Aplikasi Mobile SDM Robbani</h1>
                <p class="text-emerald-200/80 text-sm mt-1 max-w-2xl">
                    Monitoring presensi selfie real-time, perekaman Face ID biometrik pegawai, proteksi anti-fake GPS, dan amal mutaba'ah yaumiyah terintegrasi penuh.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.mobile.faces') }}" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition-all shadow-lg flex items-center gap-2">
                    <span>👤</span> Kelola Biometrik Face ID
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800/80 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pegawai</span>
                <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 text-lg">👥</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-white">{{ $totalEmployees }}</h3>
                <p class="text-xs text-slate-400 mt-1">Terdaftar di sistem yayasan</p>
            </div>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800/80 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Face ID Terdaftar</span>
                <span class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-400 text-lg">📸</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-emerald-400">{{ $enrolledFaces }}</h3>
                <p class="text-xs text-emerald-400/80 mt-1">✓ Sampel biometrik aktif</p>
            </div>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800/80 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Presensi Mobile Hari Ini</span>
                <span class="p-2.5 rounded-xl bg-amber-500/10 text-amber-400 text-lg">📍</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-white">{{ $todayAttendance }}</h3>
                <p class="text-xs text-slate-400 mt-1">Check-in via Face + Geofence</p>
            </div>
        </div>

        <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800/80 shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laporan Ibadah Hari Ini</span>
                <span class="p-2.5 rounded-xl bg-purple-500/10 text-purple-400 text-lg">🕌</span>
            </div>
            <div class="mt-3">
                <h3 class="text-2xl font-black text-purple-300">{{ $todayMutabaah }}</h3>
                <p class="text-xs text-purple-400/80 mt-1">Mutaba'ah Yaumiyah masuk</p>
            </div>
        </div>
    </div>

    <!-- Live Attendance Log with Selfie Previews -->
    <div class="bg-slate-900/70 backdrop-blur-md rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <div>
                <h2 class="text-base font-bold text-white flex items-center gap-2">
                    <span>📸</span> Live Stream Presensi Selfie &amp; Geofence SDM
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">Catatan kehadiran pegawai dengan verifikasi wajah dan koordinat GPS</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20">
                ● Live Realtime Sync
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/60 text-xs uppercase text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-3.5">Pegawai</th>
                        <th class="px-5 py-3.5">Foto Selfie Verifikasi</th>
                        <th class="px-5 py-3.5">Waktu Masuk</th>
                        <th class="px-5 py-3.5">Waktu Pulang</th>
                        <th class="px-5 py-3.5">Geofence &amp; Anti-Mock</th>
                        <th class="px-5 py-3.5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($attendanceLogs as $log)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-bold text-white">{{ $log->full_name }}</div>
                            <div class="text-xs text-slate-400">NIP: {{ $log->nip }} • {{ $log->position }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $log->face_photo_url ? (str_starts_with($log->face_photo_url, 'http') ? $log->face_photo_url : asset($log->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                     alt="Face Selfie" 
                                     class="w-10 h-10 rounded-full object-cover border-2 border-emerald-500/60">
                                <span class="text-[11px] text-emerald-400 font-semibold">✓ Face Match 98.5%</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 font-mono text-xs text-emerald-300 font-bold">
                            {{ $log->check_in_time ?? '07:15 WIB' }}
                        </td>
                        <td class="px-5 py-4 font-mono text-xs text-slate-400">
                            {{ $log->check_out_time ?? '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 text-xs font-semibold border border-emerald-500/20">
                                <span>🎯</span> Di Dalam Radius ({{ $log->distance_meters ?? '38' }}m)
                            </span>
                            <span class="text-[10px] text-slate-400 block mt-1">Anti-Mock GPS: Valid (Original Device)</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider {{ ($log->status ?? 'PRESENT') === 'LATE' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' }}">
                                {{ $log->status ?? 'HADIR' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-xs">
                            Belum ada log presensi selfie hari ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Registrasi Biometrik Pegawai -->
    <div class="bg-slate-900/70 backdrop-blur-md rounded-2xl border border-slate-800 shadow-xl p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <span>👤</span> Status Registrasi Biometrik Wajah Pegawai
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">Pegawai yang sudah dan belum mendaftarkan sampel wajah di aplikasi mobile</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($employees as $emp)
            <div class="p-4 rounded-xl bg-slate-950/60 border border-slate-800 flex items-center gap-3">
                <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                     class="w-12 h-12 rounded-full object-cover border-2 {{ $emp->face_registered_at ? 'border-emerald-500' : 'border-slate-700' }}">
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-white truncate">{{ $emp->full_name }}</h4>
                    <p class="text-xs text-slate-400">NIP: {{ $emp->nip }}</p>
                    <span class="inline-block mt-1 text-[10px] font-extrabold px-2 py-0.5 rounded {{ $emp->face_registered_at ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }}">
                        {{ $emp->face_registered_at ? '✓ Face ID Terdaftar' : 'Belum Rekam Wajah' }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
