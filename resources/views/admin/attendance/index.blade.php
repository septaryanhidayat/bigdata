@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 3: Sub-Modul 3.1</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Absensi Realtime RFID & QR Code Gate</h1>
            <p class="text-xs text-slate-500 font-medium">Monitoring kehadiran realtime gate sekolah, tap kartu RFID, scan QR sesi, & simulator gate.</p>
        </div>
    </div>

    <!-- Live Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center space-y-1">
            <span class="text-[10px] font-bold text-slate-400 uppercase">Siswa Terdaftar</span>
            <h3 class="text-3xl font-black text-slate-900">{{ $studentsCount }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center space-y-1">
            <span class="text-[10px] font-bold text-emerald-600 uppercase">Hadir Tepat Waktu</span>
            <h3 class="text-3xl font-black text-emerald-600">{{ $presentCount }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center space-y-1">
            <span class="text-[10px] font-bold text-amber-600 uppercase">Terlambat Tap</span>
            <h3 class="text-3xl font-black text-amber-600">{{ $lateCount }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center space-y-1">
            <span class="text-[10px] font-bold text-rose-600 uppercase">Belum Absen / Alpha</span>
            <h3 class="text-3xl font-black text-rose-600">{{ $absentCount }}</h3>
        </div>
    </div>

    <!-- RFID Simulator Terminal -->
    <div class="bg-gradient-to-r from-slate-950 to-emerald-950 text-white p-6 rounded-2xl border border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider">🪪 Hardware Terminal Simulator Gate Scanner</span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 text-[10px] font-black">ONLINE 24/7</span>
        </div>

        <form action="{{ route('admin.attendance.tap-rfid') }}" method="POST" class="flex items-center gap-3">
            @csrf
            <input type="text" name="rfid_tag" value="RFID-STU-7001" required placeholder="Scan / Tempelkan Kartu RFID Siswa..." class="flex-1 px-4 py-3 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-sm">
            <button type="submit" class="px-6 py-3 rounded-xl bg-amber-400 text-slate-950 font-black text-xs hover:bg-amber-300 transition-colors shadow">
                Simulasi Tap RFID Gate ➔
            </button>
        </form>
    </div>

    <!-- Table Log Absensi Hari Ini -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Log Presensi Realtime Hari Ini ({{ $today }})</h3>
            <span class="text-xs text-slate-400 font-bold">Total Tap: {{ $attendances->total() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Waktu Tap</th>
                        <th class="p-4">Siswa</th>
                        <th class="p-4">Unit & Rombel</th>
                        <th class="p-4">Metode Absen</th>
                        <th class="p-4">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($attendances as $att)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-extrabold text-slate-900">{{ $att->time_in }} WIB</td>
                        <td class="p-4">
                            <span class="font-black text-slate-900 block">{{ $att->student->full_name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">NIS: {{ $att->student->nis ?? '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-emerald-800 block">{{ $att->student->school->code ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">{{ $att->student->classroom->name ?? '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-mono bg-slate-100 text-slate-700 border">
                                🪪 {{ $att->method }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($att->status == 'HADIR')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">HADIR TEPAT WAKTU</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[10px]">TERLAMBAT</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
