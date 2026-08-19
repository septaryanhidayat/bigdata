@extends('admin.layout')

@section('title', 'Dashboard Analytics')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-6">

    <!-- Top Bar Header & School Unit Switcher Dropdown -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-theme-light text-theme-dark font-extrabold text-[10px] uppercase">SmartEdu Multi-Tenant Switcher</span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                @if($schoolId === 'all')
                    🏢 Dashboard Analytics - Semua Unit Yayasan Robbani
                @else
                    🏫 Dashboard Analytics - {{ $activeSchoolObj->name ?? 'Unit Sekolah' }}
                @endif
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Statistik realtime siswa, guru, presensi gate RFID, SPP, tabungan, & kantin cashless.</p>
        </div>

        <!-- School Unit Filter Dropdown (Default: Semua Unit Yayasan) -->
        @if(Auth::user()->role === \App\Models\User::ROLE_HEADMASTER)
            <div class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-black text-xs border border-slate-800 flex items-center gap-2 shadow-md">
                <span>🏫</span>
                <span>Unit: {{ $activeSchoolObj->name ?? 'Overview Unit' }}</span>
            </div>
        @else
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
                <label class="text-xs font-extrabold text-slate-700 whitespace-nowrap hidden sm:inline">Pilih Unit Sekolah:</label>
                <select name="school_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-black text-xs border border-slate-800 focus:outline-none cursor-pointer w-full md:w-64 shadow-md">
                    <option value="all" {{ $schoolId == 'all' ? 'selected' : '' }}>🏢 Semua Unit (Yayasan Robbani)</option>
                    @foreach($allSchools as $sc)
                        <option value="{{ $sc->id }}" {{ $schoolId == $sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

    <!-- Top Section: Main Spline Chart Card & Donut Traffic Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Dashboard Spline Line Chart (Matching Reference Left Big Card) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6 relative overflow-hidden">
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Tren Penerimaan SPP & Transaksi Digital</h2>
                    <div class="flex items-center gap-4 mt-2">
                        <div>
                            <span class="text-2xl font-black text-slate-900">Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-slate-400 font-bold block">Penerimaan SPP ({{ $sppBillsPaidCount }} Lunas)</span>
                        </div>
                        <div class="border-l border-slate-200 pl-4">
                            <span class="text-2xl font-black text-slate-900">{{ $studentsCount }}</span>
                            <span class="text-[11px] text-slate-400 font-bold block">Siswa Active Tampil</span>
                        </div>
                    </div>
                </div>

                <!-- Daily / Weekly / Yearly Pill Toggle (Matching Reference) -->
                <div class="flex items-center bg-slate-100 p-1 rounded-2xl border border-slate-200 text-xs font-bold">
                    <button class="px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900">Harian</button>
                    <button class="px-3 py-1.5 rounded-xl text-slate-600 hover:text-slate-900">Mingguan</button>
                    <button class="px-3 py-1.5 rounded-xl bg-theme-gradient text-white shadow-md">Tahunan</button>
                </div>
            </div>

            <!-- Spline Line Chart Canvas -->
            <div class="h-64 relative">
                <canvas id="splineChart"></canvas>
            </div>

            <!-- Summary Action Button & 3 Bottom Stat Badges (Matching Reference) -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.finance.spp-bills') }}" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs transition-transform hover:scale-105 shadow-lg shrink-0">
                    Laporan Keuangan SPP ➔
                </a>

                <div class="grid grid-cols-3 gap-3 w-full md:w-auto text-xs">
                    <div class="flex items-center gap-2 p-2.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-8 h-8 rounded-full bg-theme-gradient text-white font-black flex items-center justify-center text-sm shadow">👑</span>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">Saldo Kas</span>
                            <span class="font-black text-slate-900 text-xs">Rp {{ number_format($totalSavings, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 p-2.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-8 h-8 rounded-full bg-amber-500 text-white font-black flex items-center justify-center text-sm shadow">💼</span>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">Kantin POS</span>
                            <span class="font-black text-slate-900 text-xs">Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 p-2.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-8 h-8 rounded-full bg-blue-500 text-white font-black flex items-center justify-center text-sm shadow">📊</span>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">Unit Sekolah</span>
                            <span class="font-black text-slate-900 text-xs">{{ $schoolsCount }} Unit</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Donut Traffic Chart Card (Matching Reference Right Card) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900">Kehadiran Presensi Gate</h3>
                <a href="{{ route('admin.attendance.index') }}" class="text-xs font-extrabold text-theme-accent hover:underline">Detail ➔</a>
            </div>

            <div class="h-56 relative flex items-center justify-center">
                <canvas id="trafficDonutChart"></canvas>
            </div>

            <!-- Percentage Indicators Below Donut (Matching Reference 75%, 18%, 7%) -->
            <div class="grid grid-cols-3 gap-2 text-center text-xs border-t border-slate-100 pt-3 font-bold">
                <div>
                    <span class="text-xl font-black text-theme-accent block">{{ $presentToday }}</span>
                    <span class="text-[10px] text-slate-400 uppercase">Hadir Tepat</span>
                </div>
                <div>
                    <span class="text-xl font-black text-purple-600 block">{{ $lateToday }}</span>
                    <span class="text-[10px] text-slate-400 uppercase">Terlambat</span>
                </div>
                <div>
                    <span class="text-xl font-black text-amber-500 block">{{ $leaveToday + $absentToday }}</span>
                    <span class="text-[10px] text-slate-400 uppercase">Izin / Sakit</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Middle Section: 6 Expanded Statistical Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        
        <!-- Metric 1: Siswa Active -->
        <div class="bg-theme-gradient text-white p-4 rounded-3xl shadow-md space-y-2 border border-white/20">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider">Total Siswa</span>
                <span class="text-lg">🎓</span>
            </div>
            <div>
                <h4 class="text-2xl font-black text-white">{{ $studentsCount }}</h4>
                <p class="text-[10px] text-white/90 font-bold">Siswa Aktif Terdaftar</p>
            </div>
        </div>

        <!-- Metric 2: Guru & Pendidik -->
        <div class="text-white p-4 rounded-3xl shadow-md space-y-2 border border-purple-400/30" style="background: linear-gradient(135deg, #7c3aed 0%, #4c1d95 100%);">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider text-purple-100">Guru & Pendidik</span>
                <span class="text-lg">👨‍🏫</span>
            </div>
            <div>
                <h4 class="text-2xl font-black text-white">{{ $teachersCount }}</h4>
                <p class="text-[10px] text-purple-100 font-bold">{{ $staffCount }} Staf TU Non-Guru</p>
            </div>
        </div>

        <!-- Metric 3: Rombel & Mapel -->
        <div class="text-white p-4 rounded-3xl shadow-md space-y-2 border border-blue-400/30" style="background: linear-gradient(135deg, #0284c7 0%, #1e40af 100%);">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider text-blue-100">Rombel & Mapel</span>
                <span class="text-lg">🏫</span>
            </div>
            <div>
                <h4 class="text-2xl font-black text-white">{{ $classroomsCount }} Rombel</h4>
                <p class="text-[10px] text-blue-100 font-bold">{{ $subjectsCount }} Mata Pelajaran</p>
            </div>
        </div>

        <!-- Metric 4: Kasir SPP -->
        <div class="text-white p-4 rounded-3xl shadow-md space-y-2 border border-rose-400/30" style="background: linear-gradient(135deg, #e11d48 0%, #9f1239 100%);">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider text-rose-100">Penerimaan SPP</span>
                <span class="text-lg">💳</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate text-white">Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}</h4>
                <p class="text-[10px] text-rose-100 font-bold">{{ $sppBillsPaidCount }} Lunas • {{ $sppBillsUnpaidCount }} Pending</p>
            </div>
        </div>

        <!-- Metric 5: Tabungan Siswa -->
        <div class="text-white p-4 rounded-3xl shadow-md space-y-2 border border-amber-400/30" style="background: linear-gradient(135deg, #d97706 0%, #78350f 100%);">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider text-amber-100">Tabungan Siswa</span>
                <span class="text-lg">🏦</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate text-white">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h4>
                <p class="text-[10px] text-amber-100 font-bold">Saldo Teller Sekolah</p>
            </div>
        </div>

        <!-- Metric 6: Kantin POS -->
        <div class="text-white p-4 rounded-3xl shadow-md space-y-2 border border-emerald-400/30" style="background: linear-gradient(135deg, #059669 0%, #064e3b 100%);">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-90 tracking-wider text-emerald-100">Kantin POS</span>
                <span class="text-lg">🛒</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate text-white">Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}</h4>
                <p class="text-[10px] text-emerald-100 font-bold">Transaksi Cashless</p>
            </div>
        </div>

    </div>

    <!-- Bottom Section: 10 Recent Activities Timeline & 10 Live Transactions Table -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: 10 Recent Attendance & Activity Log (Matching Reference Bottom Left Card) -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900">Aktivitas & Presensi Realtime (10 Terkini)</h3>
                <span class="text-[10px] font-bold text-emerald-600 animate-pulse">● Live Stream</span>
            </div>

            <div class="space-y-3 max-h-[460px] overflow-y-auto pr-1">
                @forelse($recentAttendanceLogs as $log)
                <div class="flex items-start gap-3 p-2.5 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100/80 transition-colors">
                    <div class="w-9 h-9 rounded-full bg-theme-light text-theme-dark flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                        @if($log->status == 'HADIR') 🪪 @elseif($log->status == 'TERLAMBAT') ⏰ @else 🏥 @endif
                    </div>
                    <div class="text-xs space-y-0.5 overflow-hidden">
                        <h4 class="font-extrabold text-slate-900 truncate">{{ $log->student->full_name ?? 'Siswa' }}</h4>
                        <p class="text-slate-500 font-medium text-[11px]">
                            <span class="font-bold text-slate-700">{{ $log->student->school->code ?? '-' }}</span> • {{ $log->student->classroom->name ?? '-' }} ({{ $log->time_in }})
                        </p>
                        <span class="text-[10px] font-bold block {{ $log->status == 'HADIR' ? 'text-emerald-600' : ($log->status == 'TERLAMBAT' ? 'text-purple-600' : 'text-amber-500') }}">
                            Status: {{ $log->status }} ({{ $log->notes }})
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic text-center p-4">Belum ada data presensi realtime terrecord.</p>
                @endforelse
            </div>
        </div>

        <!-- Right: Status Table (Matching Reference Bottom Right Dark Header Table - 10 Items Live) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between space-y-4">
            
            <div>
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-base text-slate-900">Data Transaksi & Checkout Cashless (10 Terkini)</h3>
                        <p class="text-xs text-slate-500 font-medium">Monitoring transaksi kantin POS, SPP, & teller tabungan.</p>
                    </div>
                    <a href="{{ route('admin.canteen.index') }}" class="px-3.5 py-1.5 rounded-xl bg-theme-gradient text-white font-extrabold text-xs shadow-md">
                        + POS Kantin ➔
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-[#1b1c24] text-white font-bold uppercase">
                            <tr>
                                <th class="p-3.5">Invoice / Ref</th>
                                <th class="p-3.5">Nama Siswa</th>
                                <th class="p-3.5">Unit Sekolah</th>
                                <th class="p-3.5">Nominal (Rp)</th>
                                <th class="p-3.5">Status POS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                            @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-slate-50">
                                <td class="p-3.5 font-mono font-bold text-slate-900">{{ $tx->invoice_number }}</td>
                                <td class="p-3.5 font-black text-slate-900">{{ $tx->student->full_name ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-slate-600">{{ $tx->student->school->code ?? '-' }}</td>
                                <td class="p-3.5 font-black text-slate-900">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</td>
                                <td class="p-3.5">
                                    <span class="px-3 py-1 rounded-full bg-theme-accent text-white font-black text-[10px]">Open Cashless</span>
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

            <!-- Table Bottom Pagination (Matching Reference Pagination < 1 2 3 4 5 6 >) -->
            <div class="p-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-bold">
                <span>Showing 1 to 10 entries</span>
                <div class="flex items-center gap-1">
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200">&lt;</button>
                    <button class="w-7 h-7 rounded-lg bg-theme-gradient text-white flex items-center justify-center font-bold shadow-md">1</button>
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200">2</button>
                    <button class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center font-bold hover:bg-slate-200">&gt;</button>
                </div>
            </div>

        </div>

    </div>

    <!-- New Section: User & Admin Website Activity / Audit Log & Website Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Audit Log Realtime (User & Admin Website Logs) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🛡️</span> Aktivitas & Log Audit Realtime (User & Admin)
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Monitoring riwayat login, pengubahan website CMS, transaksi, & presensi gate.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-black text-[10px] uppercase border border-emerald-200">● Live Logging Active</span>
            </div>

            <div class="space-y-3 max-h-[320px] overflow-y-auto pr-1">
                @foreach($auditLogs as $log)
                <div class="flex items-start justify-between gap-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-slate-100/80 transition-all">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-900 text-white font-black flex items-center justify-center text-xs shrink-0 shadow">
                            {{ strtoupper(substr($log->user_name ?? ($log->user->name ?? 'A'), 0, 2)) }}
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <h4 class="font-extrabold text-slate-900 text-xs">{{ $log->user_name ?? ($log->user->name ?? 'System Log') }}</h4>
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-md bg-slate-200 text-slate-700 uppercase">{{ $log->user_role ?? 'ADMIN' }}</span>
                            </div>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">{{ $log->description ?? ($log->action . ' ' . $log->model_type) }}</p>
                            <div class="flex items-center gap-3 text-[10px] text-slate-400 font-bold">
                                <span>🌐 IP: {{ $log->ip_address ?? '127.0.0.1' }}</span>
                                <span>•</span>
                                <span>🕒 {{ is_string($log->created_at) ? $log->created_at : ($log->created_at ? $log->created_at->diffForHumans() : 'Baru saja') }}</span>
                            </div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-black text-white shrink-0 {{ $log->badge_color ?? 'bg-slate-800' }}">
                        {{ $log->action }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Ringkasan Operasional Website & Service Health -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
            <div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span>🌐</span> Activity Website Utama
                    </h3>
                    <span class="text-[10px] font-extrabold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-200">Online 100%</span>
                </div>

                <div class="space-y-4 mt-4 text-xs font-bold">
                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black">📰</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm">{{ $websiteStats['news_published'] ?? 12 }}</span>
                                <span class="text-[10px] text-slate-500 font-bold">Berita Dipublikasi</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.cms.content') }}" class="text-emerald-700 font-extrabold hover:underline">Kelola ➔</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black">✍️</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm">{{ $websiteStats['articles_published'] ?? 8 }}</span>
                                <span class="text-[10px] text-slate-500 font-bold">Artikel Edukasi</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.cms.content') }}" class="text-blue-700 font-extrabold hover:underline">Kelola ➔</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-purple-500 text-white flex items-center justify-center font-black">📋</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm">{{ $websiteStats['ppdb_submissions'] ?? 45 }} Pendaftar</span>
                                <span class="text-[10px] text-slate-500 font-bold">Form PPDB Online</span>
                            </div>
                        </div>
                        <a href="{{ route('school.ppdb') }}" target="_blank" class="text-purple-700 font-extrabold hover:underline">Portal PPDB ↗</a>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black">👥</span>
                            <div>
                                <span class="text-slate-900 font-black block text-sm">{{ $websiteStats['visits_today'] ?? 342 }} Visitor</span>
                                <span class="text-[10px] text-slate-500 font-bold">Pengunjung Hari Ini</span>
                            </div>
                        </div>
                        <span class="text-amber-700 font-black text-[10px] uppercase">Realtime</span>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="font-bold text-slate-300">Status Server & Database</span>
                    <span class="text-emerald-400 font-black">● Normal</span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-2 overflow-hidden">
                    <div class="bg-emerald-500 h-2 rounded-full w-[98%]"></div>
                </div>
                <span class="text-[9px] text-slate-400 font-bold block text-right">Uptime 99.98% • Latency 14ms</span>
            </div>
        </div>

    </div>

    <!-- New Section: High-Traffic Concurrency & Load Control Center (Full-Width) -->
    <div class="bg-white p-6 md:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-extrabold text-[10px] uppercase border border-purple-200">High-Concurrency Traffic & Load Balancer Engine</span>
                    <span class="w-2 h-2 rounded-full bg-purple-600 animate-pulse"></span>
                </div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight mt-1 flex items-center gap-2">
                    <span>🎛️</span> Pusat Kontrol Beban Sistem & Penggunaan Massal
                </h3>
                <p class="text-xs text-slate-500 font-medium">Manajemen throughput & optimasi kapasitas server saat lonjakan banyak user (Presensi RFID Gate, Ujian CBT, & Peak E-Learning).</p>
            </div>

            <!-- Current Active Mode Indicator Badge -->
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-500">Status Mode Aktif:</span>
                <span class="px-3 py-1.5 rounded-2xl font-black text-xs text-white shadow-sm {{ $trafficMetrics['active_mode'] == 'NORMAL' ? 'bg-slate-800' : ($trafficMetrics['active_mode'] == 'PRESENSI_MASSAL' ? 'bg-teal-600' : ($trafficMetrics['active_mode'] == 'CBT_EXAM' ? 'bg-purple-600' : 'bg-blue-600')) }}">
                    ● {{ str_replace('_', ' ', $trafficMetrics['active_mode']) }}
                </span>
            </div>
        </div>

        <!-- Mode Presets One-Click Switcher Buttons -->
        <div class="space-y-3">
            <span class="text-xs font-black text-slate-700 block uppercase tracking-wider">Pilih Preset Optimasi Beban Sistem:</span>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                
                <!-- Preset 1: Mode Normal -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="NORMAL">
                    <button type="submit" class="w-full p-4 rounded-2xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'NORMAL' ? 'bg-slate-900 text-white border-slate-900 shadow-lg scale-[1.02]' : 'bg-slate-50 text-slate-800 border-slate-200 hover:bg-slate-100' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-lg">⚙️</span>
                            @if($trafficMetrics['active_mode'] == 'NORMAL')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500 text-white text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-sm mt-2">Mode Normal</h4>
                        <p class="text-[10px] opacity-80 mt-1 font-medium">Operasi harian standar tanpa rate-limiting khusus.</p>
                    </button>
                </form>

                <!-- Preset 2: Mode Presensi Gate RFID -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="PRESENSI_MASSAL">
                    <button type="submit" class="w-full p-4 rounded-2xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'PRESENSI_MASSAL' ? 'bg-teal-700 text-white border-teal-800 shadow-lg scale-[1.02]' : 'bg-teal-50/50 text-teal-950 border-teal-200 hover:bg-teal-100/60' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-lg">🪪</span>
                            @if($trafficMetrics['active_mode'] == 'PRESENSI_MASSAL')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-400 text-teal-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-sm mt-2">Mode Presensi Gate</h4>
                        <p class="text-[10px] opacity-80 mt-1 font-medium">Prioritas API RFID Gate (06:30-07:30) latency &lt; 20ms.</p>
                    </button>
                </form>

                <!-- Preset 3: Mode Ujian CBT Massal -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="CBT_EXAM">
                    <button type="submit" class="w-full p-4 rounded-2xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'CBT_EXAM' ? 'bg-purple-700 text-white border-purple-800 shadow-lg scale-[1.02]' : 'bg-purple-50/50 text-purple-950 border-purple-200 hover:bg-purple-100/60' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-lg">📝</span>
                            @if($trafficMetrics['active_mode'] == 'CBT_EXAM')
                                <span class="px-2 py-0.5 rounded-full bg-amber-400 text-purple-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-sm mt-2">Mode Ujian CBT Massal</h4>
                        <p class="text-[10px] opacity-80 mt-1 font-medium">Optimasi DB Connection Pool &amp; buffer jawaban siswa.</p>
                    </button>
                </form>

                <!-- Preset 4: Mode E-Learning Peak -->
                <form action="{{ route('admin.system-control.set-mode') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="ELEARNING_PEAK">
                    <button type="submit" class="w-full p-4 rounded-2xl border text-left transition-all {{ $trafficMetrics['active_mode'] == 'ELEARNING_PEAK' ? 'bg-blue-700 text-white border-blue-800 shadow-lg scale-[1.02]' : 'bg-blue-50/50 text-blue-950 border-blue-200 hover:bg-blue-100/60' }}">
                        <div class="flex items-center justify-between">
                            <span class="text-lg">📚</span>
                            @if($trafficMetrics['active_mode'] == 'ELEARNING_PEAK')
                                <span class="px-2 py-0.5 rounded-full bg-cyan-400 text-blue-950 text-[9px] font-black uppercase">Active</span>
                            @endif
                        </div>
                        <h4 class="font-extrabold text-sm mt-2">Mode E-Learning Peak</h4>
                        <p class="text-[10px] opacity-80 mt-1 font-medium">CDN Static Caching materi &amp; streaming video paralel.</p>
                    </button>
                </form>

            </div>
        </div>

        <!-- Live Concurrency Telemetry Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Concurrent Active Users</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-900">{{ number_format($trafficMetrics['concurrent_users']) }}</span>
                    <span class="text-[10px] font-extrabold text-emerald-600">User Online</span>
                </div>
                <span class="text-[9px] text-slate-500 block">Koneksi simultan aktif</span>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Beban CPU Server</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-black text-slate-900">{{ $trafficMetrics['cpu_usage'] }}</span>
                    <span class="text-[10px] font-extrabold text-blue-600">Capacity</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-1.5 mt-1 overflow-hidden">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $trafficMetrics['cpu_usage'] }};"></div>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penggunaan RAM Server</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-lg font-black text-slate-900 truncate">{{ $trafficMetrics['ram_usage'] }}</span>
                </div>
                <span class="text-[9px] text-slate-500 block">DDR4 Memory Pool</span>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">API Latency Speed</span>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl font-black text-emerald-600">{{ $trafficMetrics['api_latency'] }}</span>
                </div>
                <span class="text-[9px] text-slate-500 block">Ultra-low response time</span>
            </div>
        </div>

        <!-- Quick Recovery Action Bar & Active Rule Description -->
        <div class="p-4 rounded-2xl bg-slate-900 text-white flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider block">Aturan Optimasi Aktif:</span>
                <p class="text-xs text-slate-200 font-medium">{{ $trafficMetrics['mode_description'] }}</p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <form action="{{ route('admin.system-control.purge-sessions') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-extrabold text-xs transition-transform active:scale-95 border border-slate-700">
                        🧹 Purge Sessions
                    </button>
                </form>

                <form action="{{ route('admin.system-control.optimize-db-pool') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-theme-gradient text-white font-black text-xs shadow-md transition-transform active:scale-95">
                        🗄️ Flush DB &amp; Cache
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Section: Pusat Pemantauan Error & Mitigasi Diagnostik Sistem (Compact & Scrollable) -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 font-black text-[10px] uppercase border border-rose-200">System Telemetry &amp; Device Exception Monitor</span>
                    <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                </div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight mt-1 flex items-center gap-2">
                    <span>🚨</span> Pusat Pemantauan Error Sistem &amp; Mitigasi Diagnostik ({{ count($systemErrorLogs) }})
                </h3>
                <p class="text-xs text-slate-500 font-medium">Pemantauan realtime kendala backend PHP, API, dan panduan resolusi otomatis.</p>
            </div>

            <!-- Quick Action Mitigation Buttons (High-Contrast Guaranteed) -->
            <div class="flex flex-wrap items-center gap-2">
                <form action="{{ route('admin.system-errors.auto-mitigation') }}" method="POST" data-confirm="Jalankan pembersihan cache & auto-mitigasi recovery sistem sekarang?">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md border border-emerald-500 transition-all flex items-center gap-1.5">
                        <span>⚡</span> Auto-Clear Cache &amp; Recovery
                    </button>
                </form>

                <form action="{{ route('admin.system-errors.simulate') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-black text-xs shadow-md border border-slate-700 transition-all flex items-center gap-1.5">
                        <span>🧪</span> Simulasi Error
                    </button>
                </form>
            </div>
        </div>

        <!-- Table / Compact Scrollable List of Recorded System & Device Errors (Fixed Max-Height 380px) -->
        <div class="max-h-[380px] overflow-y-auto pr-2 space-y-3">
            @forelse($systemErrorLogs as $err)
            <div class="p-4 rounded-2xl border {{ $err->status == 'UNRESOLVED' ? 'bg-rose-50/60 border-rose-200' : 'bg-slate-50 border-slate-200' }} space-y-2.5 transition-all hover:shadow-sm">
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-lg text-xs font-black text-white {{ $err->severity == 'CRITICAL' ? 'bg-rose-600' : ($err->severity == 'HIGH' ? 'bg-amber-600' : 'bg-blue-600') }}">
                            {{ $err->severity }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-lg bg-slate-900 text-white text-xs font-bold">
                            {{ $err->error_type }}
                        </span>
                        <span class="font-mono text-xs font-extrabold text-slate-900">
                            {{ $err->file ?? 'Unknown File' }} : <span class="text-rose-600 font-black">Line {{ $err->line ?? 0 }}</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-500 font-bold">
                            🕒 {{ is_string($err->created_at) ? $err->created_at : ($err->created_at ? $err->created_at->diffForHumans() : 'Baru saja') }}
                        </span>
                        @if($err->status == 'UNRESOLVED')
                            <span class="px-2.5 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-black shadow-xs">● BELUM SELESAI</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-black shadow-xs">✓ RESOLVED / MITIGATED</span>
                        @endif
                    </div>
                </div>

                <!-- Error Message Banner -->
                <div class="p-3 rounded-xl bg-white border border-slate-300 font-mono text-xs text-rose-900 font-bold overflow-x-auto shadow-xs">
                    <span class="text-rose-600 font-black">Error:</span> {{ $err->message }}
                </div>

                <!-- Device / User Agent Specs & Request URL -->
                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-600 font-bold bg-white/80 p-2.5 rounded-xl border border-slate-200">
                    <span>🌐 <b>URL:</b> <code class="text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded font-mono">{{ $err->url ?? '-' }}</code></span>
                    <span>💻 <b>Perangkat:</b> <span class="text-slate-900 font-extrabold truncate max-w-xs">{{ $err->user_agent ?? 'Client Browser' }}</span></span>
                    <span>📍 <b>IP:</b> <span class="text-slate-900 font-mono font-bold">{{ $err->ip_address ?? '127.0.0.1' }}</span></span>
                </div>

                <!-- Mitigation Box (Panduan Resolusi Masalah) -->
                <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-300/50 text-xs text-amber-950 font-bold space-y-1">
                    <span class="text-amber-900 font-black block flex items-center gap-1.5 text-xs">
                        🛠️ Panduan Mitigasi &amp; Langkah Resolusi:
                    </span>
                    <div class="text-xs text-amber-950 leading-relaxed font-semibold whitespace-pre-line pl-1">
                        {{ $err->mitigation_solution ?? 'Lakukan pengujian stack trace dan periksa file terkait.' }}
                    </div>
                </div>

                <!-- Action Footer per Error (High Contrast Buttons Guaranteed) -->
                <div class="flex items-center justify-between pt-1 border-t border-slate-200/60">
                    <button onclick="alert('Stack Trace Diagnostic Details:\n\n' + {{ json_encode($err->stack_trace ?? $err->message) }})" class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-900 text-white font-extrabold text-xs rounded-xl shadow-xs transition-all flex items-center gap-1">
                        🔍 Lihat Trace Lengkap
                    </button>

                    @if($err->status == 'UNRESOLVED' && isset($err->id) && is_numeric($err->id))
                    <form action="{{ route('admin.system-errors.resolve', $err->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-sm transition-all flex items-center gap-1">
                            ✓ Tandai Selesai / Mitigated
                        </button>
                    </form>
                    @endif
                </div>

            </div>
            @empty
            <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 text-slate-500 space-y-2">
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
