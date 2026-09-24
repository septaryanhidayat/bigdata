@extends('admin.layout')

@section('title', 'Dashboard Analytics')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">

    <!-- Top Bar Header & School Unit Switcher Dropdown -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-[10px] uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Multi-Tenant System Active
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1.5 flex items-center gap-2">
                @if($schoolId === 'all')
                    <span>🏢</span> Dashboard Analytics — Semua Unit Yayasan Robbani
                @else
                    <span>🏫</span> Dashboard Analytics — {{ $activeSchoolObj->name ?? 'Unit Sekolah' }}
                @endif
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Statistik realtime siswa, pendidik, presensi gate RFID, SPP, tabungan, &amp; transaksi cashless.</p>
        </div>

        <!-- School Unit Filter Dropdown -->
        @if(Auth::user()->role === \App\Models\User::ROLE_HEADMASTER)
            <div class="px-3.5 py-2 rounded-xl bg-slate-900 text-white font-extrabold text-xs border border-slate-800 flex items-center gap-2 shadow-xs shrink-0">
                <span>🏫</span>
                <span>Unit: {{ $activeSchoolObj->name ?? 'Overview Unit' }}</span>
            </div>
        @else
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2.5 w-full md:w-auto shrink-0">
                <label class="text-xs font-bold text-slate-600 whitespace-nowrap hidden lg:inline">Pilih Unit:</label>
                <div class="relative w-full md:w-64">
                    <select name="school_id" onchange="this.form.submit()" class="w-full pl-3 pr-8 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs border border-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-700 cursor-pointer shadow-xs transition-colors appearance-none">
                        <option value="all" {{ $schoolId == 'all' ? 'selected' : '' }}>🏢 Semua Unit (Yayasan Robbani)</option>
                        @foreach($allSchools as $sc)
                            <option value="{{ $sc->id }}" {{ $schoolId == $sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-2.5 pointer-events-none text-slate-400 text-xs">
                        ▼
                    </div>
                </div>
            </form>
        @endif
    </div>

    <!-- Top Section: Main Spline Chart Card & Donut Traffic Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Dashboard Spline Line Chart -->
        <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-6 relative overflow-hidden">
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-lg font-black text-slate-900 tracking-tight">Tren Penerimaan SPP &amp; Transaksi Digital</h2>
                    <div class="flex items-center gap-4 mt-2">
                        <div>
                            <span class="text-xl sm:text-2xl font-black text-slate-900">Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-slate-500 font-bold block">Penerimaan SPP ({{ $sppBillsPaidCount }} Lunas)</span>
                        </div>
                        <div class="border-l border-slate-200 pl-4">
                            <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $studentsCount }}</span>
                            <span class="text-[11px] text-slate-500 font-bold block">Siswa Aktif Terdata</span>
                        </div>
                    </div>
                </div>

                <!-- Daily / Weekly / Yearly Pill Toggle -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200 text-xs font-bold">
                    <button class="px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-colors">Harian</button>
                    <button class="px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-colors">Mingguan</button>
                    <button class="px-3 py-1.5 rounded-lg bg-theme-gradient text-white shadow-xs">Tahunan</button>
                </div>
            </div>

            <!-- Spline Line Chart Canvas -->
            <div class="h-64 relative">
                <canvas id="splineChart"></canvas>
            </div>

            <!-- Summary Action Button & 3 Bottom Stat Badges -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.finance.spp-bills') }}" class="w-full md:w-auto px-4 py-2 rounded-xl bg-theme-gradient text-white font-black text-xs transition-transform hover:scale-102 active:scale-98 shadow-xs flex items-center justify-center gap-1.5 shrink-0">
                    <span>Laporan Keuangan SPP</span>
                    <span>➔</span>
                </a>

                <div class="grid grid-cols-3 gap-2 sm:gap-3 w-full md:w-auto text-xs">
                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="w-7 h-7 rounded-lg bg-violet-100 text-violet-700 font-black flex items-center justify-center text-xs shrink-0">🏦</span>
                        <div class="overflow-hidden">
                            <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider truncate">Saldo Kas</span>
                            <span class="font-extrabold text-slate-900 text-xs truncate block">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 font-black flex items-center justify-center text-xs shrink-0">🛒</span>
                        <div class="overflow-hidden">
                            <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider truncate">Kantin POS</span>
                            <span class="font-extrabold text-slate-900 text-xs truncate block">Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2.5 p-2 rounded-xl bg-slate-50 border border-slate-200/80">
                        <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 font-black flex items-center justify-center text-xs shrink-0">🏛️</span>
                        <div class="overflow-hidden">
                            <span class="text-[9px] text-slate-400 font-bold block uppercase tracking-wider truncate">Unit Lembaga</span>
                            <span class="font-extrabold text-slate-900 text-xs truncate block">{{ $schoolsCount }} Unit</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Donut Traffic Chart Card with Center Percentage Indicator -->
        @php
            $totalAttendanceToday = $presentToday + $lateToday + $leaveToday + $absentToday;
            $attendancePercentage = $totalAttendanceToday > 0 ? round(($presentToday / $totalAttendanceToday) * 100) : 0;
        @endphp
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900">Kehadiran Presensi Gate</h3>
                    <p class="text-[11px] text-slate-400 font-semibold">Live tap RFID &amp; QR Code</p>
                </div>
                <a href="{{ route('admin.attendance.index') }}" class="text-xs font-extrabold text-theme-accent hover:underline flex items-center gap-1">
                    Detail <span>➔</span>
                </a>
            </div>

            <!-- Donut Canvas with Center Percentage Overlay -->
            <div class="h-52 relative flex items-center justify-center">
                <canvas id="trafficDonutChart"></canvas>
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                    <span class="text-2xl font-black text-slate-900 tracking-tight">{{ $attendancePercentage }}%</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Hadir Tepat</span>
                </div>
            </div>

            <!-- 3 Modern Status Indicators Below Donut -->
            <div class="grid grid-cols-3 gap-2 text-center text-xs border-t border-slate-100 pt-3.5 font-bold">
                <div class="p-2 rounded-xl bg-emerald-50/70 border border-emerald-100">
                    <span class="text-lg font-black text-emerald-700 block">{{ $presentToday }}</span>
                    <span class="text-[10px] text-emerald-600 uppercase font-extrabold">Hadir</span>
                </div>
                <div class="p-2 rounded-xl bg-purple-50/70 border border-purple-100">
                    <span class="text-lg font-black text-purple-700 block">{{ $lateToday }}</span>
                    <span class="text-[10px] text-purple-600 uppercase font-extrabold">Telat</span>
                </div>
                <div class="p-2 rounded-xl bg-amber-50/70 border border-amber-100">
                    <span class="text-lg font-black text-amber-700 block">{{ $leaveToday + $absentToday }}</span>
                    <span class="text-[10px] text-amber-600 uppercase font-extrabold">Izin/Sakit</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Middle Section: 6 World-Class Statistical KPI Metric Cards (Clean, Modern & Legible) -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3.5 sm:gap-4">
        
        <!-- Metric 1: Siswa Active -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Siswa</span>
                <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    🎓
                </div>
            </div>
            <div>
                <h4 class="text-2xl font-black text-slate-900 tracking-tight leading-none">{{ $studentsCount }}</h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Siswa Aktif Terdaftar
                </p>
            </div>
        </div>

        <!-- Metric 2: Guru & Pendidik -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pendidik</span>
                <div class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 border border-purple-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    👨‍🏫
                </div>
            </div>
            <div>
                <h4 class="text-2xl font-black text-slate-900 tracking-tight leading-none">{{ $teachersCount }}</h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span> {{ $staffCount }} Staf TU Non-Guru
                </p>
            </div>
        </div>

        <!-- Metric 3: Rombel & Mapel -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kelas</span>
                <div class="w-8 h-8 rounded-xl bg-sky-50 text-sky-600 border border-sky-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    🏫
                </div>
            </div>
            <div>
                <h4 class="text-2xl font-black text-slate-900 tracking-tight leading-none">{{ $classroomsCount }} <span class="text-xs font-bold text-slate-500">Rombel</span></h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span> {{ $subjectsCount }} Mata Pelajaran
                </p>
            </div>
        </div>

        <!-- Metric 4: Kasir SPP -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kasir SPP</span>
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 border border-rose-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    💳
                </div>
            </div>
            <div>
                <h4 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-none truncate" title="Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}">
                    Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}
                </h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1 truncate">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ $sppBillsPaidCount }} Lunas • {{ $sppBillsUnpaidCount }} Pending
                </p>
            </div>
        </div>

        <!-- Metric 5: Tabungan Siswa -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tabungan</span>
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 border border-amber-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    🏦
                </div>
            </div>
            <div>
                <h4 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-none truncate" title="Rp {{ number_format($totalSavings, 0, ',', '.') }}">
                    Rp {{ number_format($totalSavings, 0, ',', '.') }}
                </h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Saldo Teller Sekolah
                </p>
            </div>
        </div>

        <!-- Metric 6: Kantin POS -->
        <div class="bg-white border border-slate-200/90 rounded-2xl p-4.5 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kantin POS</span>
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 border border-teal-100/80 flex items-center justify-center text-sm font-bold shadow-2xs">
                    🛒
                </div>
            </div>
            <div>
                <h4 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight leading-none truncate" title="Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}">
                    Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}
                </h4>
                <p class="text-[11px] text-slate-500 font-semibold mt-1.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span> Transaksi Cashless
                </p>
            </div>
        </div>

    </div>

    <!-- Bottom Section: 10 Recent Activities Timeline & 10 Live Transactions Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: 10 Recent Attendance & Activity Log -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-black text-slate-900">Aktivitas &amp; Presensi Realtime</h3>
                    <p class="text-[11px] text-slate-400 font-semibold">10 riwayat tap RFID terkini</p>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Stream
                </span>
            </div>

            <div class="space-y-2.5 max-h-[460px] overflow-y-auto pr-1">
                @forelse($recentAttendanceLogs as $log)
                <div class="flex items-start gap-3 p-2.5 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-100/80 transition-colors">
                    <div class="w-8 h-8 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-bold text-sm shrink-0 shadow-2xs">
                        @if($log->status == 'HADIR') 🪪 @elseif($log->status == 'TERLAMBAT') ⏰ @else 🏥 @endif
                    </div>
                    <div class="text-xs space-y-0.5 overflow-hidden flex-1 min-w-0">
                        <h4 class="font-extrabold text-slate-900 truncate">{{ $log->student->full_name ?? 'Siswa' }}</h4>
                        <p class="text-slate-500 font-medium text-[11px] truncate">
                            <span class="font-bold text-slate-700">{{ $log->student->school->code ?? '-' }}</span> • {{ $log->student->classroom->name ?? '-' }} ({{ $log->time_in }})
                        </p>
                        <span class="text-[10px] font-bold block {{ $log->status == 'HADIR' ? 'text-emerald-600' : ($log->status == 'TERLAMBAT' ? 'text-purple-600' : 'text-amber-600') }}">
                            Status: {{ $log->status }} ({{ $log->notes ?? 'Tap Gate RFID' }})
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic text-center p-4">Belum ada data presensi realtime terrecord.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Status Table (Matching Reference Bottom Right Clean Modern Table) -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between">
            
            <div>
                <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="font-black text-base text-slate-900">Data Transaksi &amp; Checkout Cashless (10 Terkini)</h3>
                        <p class="text-xs text-slate-500 font-medium">Monitoring transaksi kantin POS, SPP, &amp; teller tabungan.</p>
                    </div>
                    <a href="{{ route('admin.canteen.index') }}" class="px-3.5 py-1.5 rounded-xl bg-theme-gradient text-white font-extrabold text-xs shadow-xs hover:scale-102 transition-transform shrink-0">
                        + POS Kantin ➔
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/90 text-slate-500 font-bold uppercase tracking-wider text-[11px] border-b border-slate-200">
                            <tr>
                                <th class="p-3.5 whitespace-nowrap">Invoice / Ref</th>
                                <th class="p-3.5">Nama Siswa</th>
                                <th class="p-3.5 whitespace-nowrap">Unit Sekolah</th>
                                <th class="p-3.5 whitespace-nowrap">Nominal (Rp)</th>
                                <th class="p-3.5 whitespace-nowrap">Status Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                            @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="p-3.5 font-mono font-extrabold text-slate-900 whitespace-nowrap">{{ $tx->invoice_number }}</td>
                                <td class="p-3.5 font-bold text-slate-900 truncate max-w-[140px]">{{ $tx->student->full_name ?? '-' }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-bold text-[10px]">
                                        {{ $tx->student->school->code ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-3.5 font-black text-slate-900 whitespace-nowrap">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-[10px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Open Cashless
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-slate-400 italic">Belum ada transaksi kantin POS terrecord.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Table Bottom Pagination (Clean Modern Style) -->
            <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-bold">
                <span>Menampilkan 10 entri terkini</span>
                <div class="flex items-center gap-1">
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200 transition-colors">&lt;</button>
                    <button class="w-7 h-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold shadow-xs">1</button>
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200 transition-colors">2</button>
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200 transition-colors">&gt;</button>
                </div>
            </div>

        </div>

    </div>

    <!-- Section: User & Admin Website Activity / Audit Log & Website Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Audit Log Realtime (User & Admin Website Logs) -->
        <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🛡️</span> Aktivitas &amp; Log Audit Realtime
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Monitoring riwayat login, pengubahan website CMS, transaksi, &amp; presensi gate.</p>
                </div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px] uppercase border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Logging
                </span>
            </div>

            <div class="space-y-2.5 max-h-[320px] overflow-y-auto pr-1">
                @foreach($auditLogs as $log)
                <div class="flex items-start justify-between gap-3 p-3 rounded-xl bg-slate-50/80 border border-slate-200/70 hover:bg-slate-100/80 transition-all">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-slate-900 text-white font-bold flex items-center justify-center text-xs shrink-0 shadow-2xs">
                            {{ strtoupper(substr($log->user_name ?? ($log->user->name ?? 'A'), 0, 2)) }}
                        </div>
                        <div class="space-y-0.5 min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="font-extrabold text-slate-900 text-xs truncate">{{ $log->user_name ?? ($log->user->name ?? 'System Log') }}</h4>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 uppercase shrink-0">{{ $log->user_role ?? 'ADMIN' }}</span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $log->description ?? ($log->action . ' ' . $log->model_type) }}</p>
                            <div class="flex items-center gap-2 text-[10px] text-slate-400 font-semibold pt-0.5">
                                <span>🌐 {{ $log->ip_address ?? '127.0.0.1' }}</span>
                                <span>•</span>
                                <span>🕒 {{ is_string($log->created_at) ? $log->created_at : ($log->created_at ? $log->created_at->diffForHumans() : 'Baru saja') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-extrabold text-white shrink-0 {{ $log->badge_color ?? 'bg-slate-800' }}">
                        {{ $log->action }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ringkasan Operasional Website & Service Health -->
        <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🌐</span> Website &amp; Portal Publik
                    </h3>
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-700 bg-blue-50 px-2.5 py-0.5 rounded-full border border-blue-200">
                        Online 100%
                    </span>
                </div>

                <div class="space-y-3 mt-3.5 text-xs font-bold">
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm">📰</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm leading-tight">{{ $websiteStats['news_published'] ?? 12 }}</span>
                                <span class="text-[10px] text-slate-500 font-medium">Berita Dipublikasi</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.cms.content') }}" class="text-emerald-700 font-bold hover:underline text-xs">Kelola ➔</a>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">✍️</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm leading-tight">{{ $websiteStats['articles_published'] ?? 8 }}</span>
                                <span class="text-[10px] text-slate-500 font-medium">Artikel Edukasi</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.cms.content') }}" class="text-blue-700 font-bold hover:underline text-xs">Kelola ➔</a>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">📋</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm leading-tight">{{ $websiteStats['ppdb_submissions'] ?? 45 }} Siswa</span>
                                <span class="text-[10px] text-slate-500 font-medium">Pendaftar SPMB Online</span>
                            </div>
                        </div>
                        <a href="{{ route('school.spmb') }}" target="_blank" class="text-purple-700 font-bold hover:underline text-xs">Portal ↗</a>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-center justify-between hover:bg-slate-100/70 transition-colors">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">👥</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm leading-tight">{{ $websiteStats['visits_today'] ?? 342 }} Visitor</span>
                                <span class="text-[10px] text-slate-500 font-medium">Pengunjung Hari Ini</span>
                            </div>
                        </div>
                        <span class="text-amber-700 font-bold text-[10px] uppercase">Realtime</span>
                    </div>
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-900 text-white space-y-2 shadow-2xs">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="font-bold text-slate-300">Status Server &amp; DB Pool</span>
                    <span class="text-emerald-400 font-black flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Normal
                    </span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-emerald-500 h-1.5 rounded-full w-[98%]"></div>
                </div>
                <span class="text-[9px] text-slate-400 font-semibold block text-right">Uptime 99.98% • Latency 14ms</span>
            </div>
        </div>

    </div>

    <!-- Section: High-Traffic Concurrency & Load Control Center (Full-Width) -->
    <div class="bg-white p-5 sm:p-6 md:p-7 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 font-bold text-[10px] uppercase border border-purple-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-600 animate-pulse"></span>
                        High-Concurrency Engine
                    </span>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight mt-1 flex items-center gap-2">
                    <span>🎛️</span> Pusat Kontrol Beban Sistem &amp; Penggunaan Massal
                </h3>
                <p class="text-xs text-slate-500 font-medium">Manajemen throughput &amp; optimasi kapasitas server saat lonjakan user (Presensi RFID, Ujian CBT, &amp; Peak E-Learning).</p>
            </div>

            <!-- Current Active Mode Indicator Badge -->
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-xs font-bold text-slate-500">Mode Aktif:</span>
                <span class="px-3 py-1 rounded-xl font-bold text-xs text-white shadow-2xs {{ $trafficMetrics['active_mode'] == 'NORMAL' ? 'bg-slate-900' : ($trafficMetrics['active_mode'] == 'PRESENSI_MASSAL' ? 'bg-teal-700' : ($trafficMetrics['active_mode'] == 'CBT_EXAM' ? 'bg-purple-700' : 'bg-blue-700')) }}">
                    ● {{ str_replace('_', ' ', $trafficMetrics['active_mode']) }}
                </span>
            </div>
        </div>

        <!-- Mode Presets One-Click Switcher Buttons -->
        <div class="space-y-2.5">
            <span class="text-[11px] font-extrabold text-slate-500 block uppercase tracking-wider">Pilih Preset Optimasi Beban:</span>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                
                <!-- Preset 1: Mode Normal -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="NORMAL">
                    <button type="submit" class="w-full p-4 rounded-xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'NORMAL' ? 'bg-slate-900 text-white border-slate-900 shadow-sm ring-2 ring-slate-800' : 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100/80' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-base">⚙️</span>
                            @if($trafficMetrics['active_mode'] == 'NORMAL')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500 text-white text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-xs mt-2">Mode Normal</h4>
                        <p class="text-[10px] opacity-80 mt-0.5 font-medium leading-tight">Operasi harian standar yayasan.</p>
                    </button>
                </form>

                <!-- Preset 2: Mode Presensi Gate RFID -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="PRESENSI_MASSAL">
                    <button type="submit" class="w-full p-4 rounded-xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'PRESENSI_MASSAL' ? 'bg-teal-700 text-white border-teal-800 shadow-sm ring-2 ring-teal-600' : 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100/80' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-base">🪪</span>
                            @if($trafficMetrics['active_mode'] == 'PRESENSI_MASSAL')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-400 text-teal-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-xs mt-2">Mode Presensi Gate</h4>
                        <p class="text-[10px] opacity-80 mt-0.5 font-medium leading-tight">Prioritas API RFID Gate latency &lt; 20ms.</p>
                    </button>
                </form>

                <!-- Preset 3: Mode Ujian CBT Massal -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="CBT_EXAM">
                    <button type="submit" class="w-full p-4 rounded-xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'CBT_EXAM' ? 'bg-purple-700 text-white border-purple-800 shadow-sm ring-2 ring-purple-600' : 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100/80' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-base">📝</span>
                            @if($trafficMetrics['active_mode'] == 'CBT_EXAM')
                                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-purple-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-xs mt-2">Mode Ujian CBT Massal</h4>
                        <p class="text-[10px] opacity-80 mt-0.5 font-medium leading-tight">Optimasi pool DB &amp; buffer jawaban.</p>
                    </button>
                </form>

                <!-- Preset 4: Mode E-Learning Peak -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="ELEARNING_PEAK">
                    <button type="submit" class="w-full p-4 rounded-xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'ELEARNING_PEAK' ? 'bg-blue-700 text-white border-blue-800 shadow-sm ring-2 ring-blue-600' : 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100/80' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-base">📚</span>
                            @if($trafficMetrics['active_mode'] == 'ELEARNING_PEAK')
                                <span class="px-2 py-0.5 rounded-full bg-cyan-400 text-blue-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-xs mt-2">Mode E-Learning Peak</h4>
                        <p class="text-[10px] opacity-80 mt-0.5 font-medium leading-tight">CDN caching materi &amp; streaming video.</p>
                    </button>
                </form>

            </div>
        </div>

        <!-- Live Concurrency Telemetry Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3.5 pt-1">
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Concurrent Users</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-black text-slate-900">{{ number_format($trafficMetrics['concurrent_users']) }}</span>
                    <span class="text-[10px] font-extrabold text-emerald-600">Online</span>
                </div>
                <span class="text-[9px] text-slate-500 block">Koneksi simultan aktif</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Beban CPU Server</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl sm:text-2xl font-black text-slate-900">{{ $trafficMetrics['cpu_usage'] }}</span>
                    <span class="text-[10px] font-extrabold text-blue-600">Capacity</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-1 mt-1 overflow-hidden">
                    <div class="bg-blue-600 h-1 rounded-full" style="width: {{ $trafficMetrics['cpu_usage'] }};"></div>
                </div>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penggunaan RAM</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-base sm:text-lg font-black text-slate-900 truncate">{{ $trafficMetrics['ram_usage'] }}</span>
                </div>
                <span class="text-[9px] text-slate-500 block">DDR4 Memory Pool</span>
            </div>

            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">API Latency Speed</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-lg sm:text-xl font-black text-emerald-600">{{ $trafficMetrics['api_latency'] }}</span>
                </div>
                <span class="text-[9px] text-slate-500 block">Response time cepat</span>
            </div>
        </div>

        <!-- Quick Recovery Action Bar & Active Rule Description -->
        <div class="p-4 rounded-xl bg-slate-900 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-0.5">
                <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider block">Aturan Optimasi Aktif:</span>
                <p class="text-xs text-slate-200 font-medium">{{ $trafficMetrics['mode_description'] }}</p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <form action="{{ route('admin.system-control.purge-sessions') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs transition-transform active:scale-95 border border-slate-700">
                        🧹 Purge Sessions
                    </button>
                </form>

                <form action="{{ route('admin.system-control.optimize-db-pool') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-theme-gradient text-white font-black text-xs shadow-xs transition-transform active:scale-95">
                        🗄️ Flush DB &amp; Cache
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Section: Pusat Pemantauan Error & Mitigasi Diagnostik Sistem -->
    <div class="bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-100 pb-3.5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 font-bold text-[10px] uppercase border border-rose-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-ping"></span>
                        System Exception Telemetry
                    </span>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight mt-1 flex items-center gap-2">
                    <span>🚨</span> Pusat Pemantauan Error Sistem &amp; Mitigasi Diagnostik ({{ count($systemErrorLogs) }})
                </h3>
                <p class="text-xs text-slate-500 font-medium">Pemantauan realtime kendala backend PHP, API, dan panduan resolusi otomatis.</p>
            </div>

            <!-- Quick Action Mitigation Buttons -->
            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('admin.system-errors.auto-mitigation') }}" method="POST" data-confirm="Jalankan pembersihan cache & auto-mitigasi recovery sistem sekarang?">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-xs transition-all flex items-center gap-1.5">
                        <span>⚡</span> Auto-Clear Cache &amp; Recovery
                    </button>
                </form>

                <form action="{{ route('admin.system-errors.simulate') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs shadow-xs border border-slate-700 transition-all flex items-center gap-1.5">
                        <span>🧪</span> Simulasi Error
                    </button>
                </form>
            </div>
        </div>

        <!-- Table / Scrollable List of Recorded System & Device Errors -->
        <div class="max-h-[380px] overflow-y-auto pr-2 space-y-3">
            @forelse($systemErrorLogs as $err)
            <div class="p-4 rounded-xl border {{ $err->status == 'UNRESOLVED' ? 'bg-rose-50/50 border-rose-200' : 'bg-slate-50/80 border-slate-200' }} space-y-2.5 transition-all hover:shadow-2xs">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-black text-white {{ $err->severity == 'CRITICAL' ? 'bg-rose-600' : ($err->severity == 'HIGH' ? 'bg-amber-600' : 'bg-blue-600') }}">
                            {{ $err->severity }}
                        </span>
                        <span class="px-2 py-0.5 rounded-md bg-slate-900 text-white text-[10px] font-bold">
                            {{ $err->error_type }}
                        </span>
                        <span class="font-mono text-xs font-extrabold text-slate-900">
                            {{ $err->file ?? 'Unknown File' }} : <span class="text-rose-600 font-black">Line {{ $err->line ?? 0 }}</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-500 font-medium">
                            🕒 {{ is_string($err->created_at) ? $log->created_at : ($err->created_at ? $err->created_at->diffForHumans() : 'Baru saja') }}
                        </span>
                        @if($err->status == 'UNRESOLVED')
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-black shadow-2xs">● BELUM SELESAI</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-black shadow-2xs">✓ RESOLVED / MITIGATED</span>
                        @endif
                    </div>
                </div>

                <!-- Error Message Banner -->
                <div class="p-3 rounded-xl bg-white border border-slate-300 font-mono text-xs text-rose-900 font-bold overflow-x-auto shadow-2xs">
                    <span class="text-rose-600 font-black">Error:</span> {{ $err->message }}
                </div>

                <!-- Device / User Agent Specs & Request URL -->
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-600 font-semibold bg-white p-2.5 rounded-xl border border-slate-200">
                    <span>🌐 <b>URL:</b> <code class="text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded font-mono">{{ $err->url ?? '-' }}</code></span>
                    <span>💻 <b>Perangkat:</b> <span class="text-slate-900 font-bold truncate max-w-xs">{{ $err->user_agent ?? 'Client Browser' }}</span></span>
                    <span>📍 <b>IP:</b> <span class="text-slate-900 font-mono font-bold">{{ $err->ip_address ?? '127.0.0.1' }}</span></span>
                </div>

                <!-- Mitigation Box (Panduan Resolusi Masalah) -->
                <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-300/50 text-xs text-amber-950 font-medium space-y-1">
                    <span class="text-amber-900 font-black block flex items-center gap-1.5 text-xs">
                        🛠️ Panduan Mitigasi &amp; Langkah Resolusi:
                    </span>
                    <div class="text-xs text-amber-950 leading-relaxed whitespace-pre-line pl-1">
                        {{ $err->mitigation_solution ?? 'Lakukan pengujian stack trace dan periksa file terkait.' }}
                    </div>
                </div>

                <!-- Action Footer per Error -->
                <div class="flex items-center justify-between pt-1 border-t border-slate-200/60">
                    <button onclick="alert('Stack Trace Diagnostic Details:\n\n' + {{ json_encode($err->stack_trace ?? $err->message) }})" class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-extrabold text-xs rounded-xl shadow-2xs transition-all flex items-center gap-1">
                        🔍 Lihat Trace Lengkap
                    </button>

                    @if($err->status == 'UNRESOLVED' && isset($err->id) && is_numeric($err->id))
                    <form action="{{ route('admin.system-errors.resolve', $err->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-2xs transition-all flex items-center gap-1">
                            ✓ Tandai Selesai / Mitigated
                        </button>
                    </form>
                    @endif
                </div>

            </div>
            @empty
            <div class="p-8 text-center bg-slate-50 rounded-xl border border-slate-200 text-slate-500 space-y-2">
                <span class="text-3xl block">🎉</span>
                <p class="font-bold text-xs">Sistem Berjalan 100% Normal. Belum Ada Error Terekam.</p>
            </div>
            @endforelse
        </div>

    </div>

</div>

<!-- Chart.js Setup for Wavy Gradient Spline Line Chart & Donut Chart -->
<script>
    let splineChartInstance = null;
    let donutChartInstance = null;

    const themeColorsMap = {
        'theme-magenta': { primary: '#ec4899', secondary: '#8b5cf6', accent: '#f59e0b', rgbaPrimary: 'rgba(236, 72, 153, 0.4)' },
        'theme-emerald': { primary: '#10b981', secondary: '#06b6d4', accent: '#eab308', rgbaPrimary: 'rgba(16, 185, 129, 0.4)' },
        'theme-ocean': { primary: '#3b82f6', secondary: '#8b5cf6', accent: '#f59e0b', rgbaPrimary: 'rgba(59, 130, 246, 0.4)' },
        'theme-sunset': { primary: '#f43f5e', secondary: '#f97316', accent: '#eab308', rgbaPrimary: 'rgba(244, 63, 94, 0.4)' },
        'theme-gold': { primary: '#f59e0b', secondary: '#b45309', accent: '#10b981', rgbaPrimary: 'rgba(245, 158, 11, 0.4)' }
    };

    function initOrUpdateCharts() {
        const currentTheme = localStorage.getItem('smartedu_admin_theme') || 'theme-magenta';
        const colors = themeColorsMap[currentTheme] || themeColorsMap['theme-magenta'];

        // 1. Spline Area Line Chart
        const ctxSpline = document.getElementById('splineChart').getContext('2d');
        
        const gradientTheme = ctxSpline.createLinearGradient(0, 0, 0, 250);
        gradientTheme.addColorStop(0, colors.rgbaPrimary);
        gradientTheme.addColorStop(1, 'rgba(255, 255, 255, 0.0)');

        const gradientYellow = ctxSpline.createLinearGradient(0, 0, 0, 250);
        gradientYellow.addColorStop(0, 'rgba(245, 158, 11, 0.4)');
        gradientYellow.addColorStop(1, 'rgba(245, 158, 11, 0.0)');

        if (splineChartInstance) {
            splineChartInstance.destroy();
        }

        splineChartInstance = new Chart(ctxSpline, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                datasets: [
                    {
                        label: 'Pemasukan SPP (Juta Rp)',
                        data: [12, 18, 14, 28, 20, 25, 35, 45],
                        borderColor: colors.primary,
                        borderWidth: 3,
                        backgroundColor: gradientTheme,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: colors.primary,
                        pointRadius: 4
                    },
                    {
                        label: 'Tabungan & POS Kantin (Juta Rp)',
                        data: [8, 12, 19, 15, 22, 18, 30, 26],
                        borderColor: '#f59e0b',
                        borderWidth: 3,
                        backgroundColor: gradientYellow,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#f59e0b',
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { font: { weight: 'bold', size: 11 } } }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true, grid: { color: 'rgba(226, 232, 240, 0.6)' } }
                }
            }
        });

        // 2. Donut Traffic Chart
        const ctxDonut = document.getElementById('trafficDonutChart').getContext('2d');
        if (donutChartInstance) {
            donutChartInstance.destroy();
        }

        donutChartInstance = new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: ['Hadir Tepat Waktu', 'Terlambat Tap', 'Izin / Sakit'],
                datasets: [{
                    data: [{{ $presentToday }}, {{ $lateToday }}, {{ $leaveToday + $absentToday }}],
                    backgroundColor: [colors.primary, colors.secondary, '#f59e0b'],
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        initOrUpdateCharts();
    });

    window.addEventListener("adminThemeChanged", function () {
        initOrUpdateCharts();
    });
</script>
@endsection
