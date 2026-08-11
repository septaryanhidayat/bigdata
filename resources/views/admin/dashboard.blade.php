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
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
            <label class="text-xs font-extrabold text-slate-700 whitespace-nowrap hidden sm:inline">Pilih Unit Sekolah:</label>
            <select name="school_id" onchange="this.form.submit()" class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-black text-xs border border-slate-800 focus:outline-none cursor-pointer w-full md:w-64 shadow-md">
                <option value="all" {{ $schoolId == 'all' ? 'selected' : '' }}>🏢 Semua Unit (Yayasan Robbani)</option>
                @foreach($allSchools as $sc)
                    <option value="{{ $sc->id }}" {{ $schoolId == $sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                @endforeach
            </select>
        </form>
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
        <div class="bg-theme-gradient text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Total Siswa</span>
                <span>🎓</span>
            </div>
            <div>
                <h4 class="text-2xl font-black">{{ $studentsCount }}</h4>
                <p class="text-[10px] opacity-90 font-bold">Siswa Aktif Terdaftar</p>
            </div>
        </div>

        <!-- Metric 2: Guru & Pendidik -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Guru & Pendidik</span>
                <span>👨‍🏫</span>
            </div>
            <div>
                <h4 class="text-2xl font-black">{{ $teachersCount }}</h4>
                <p class="text-[10px] opacity-90 font-bold">{{ $staffCount }} Staf TU Non-Guru</p>
            </div>
        </div>

        <!-- Metric 3: Rombel & Mapel -->
        <div class="bg-gradient-to-br from-cyan-500 to-blue-600 text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Rombel & Mapel</span>
                <span>🏫</span>
            </div>
            <div>
                <h4 class="text-2xl font-black">{{ $classroomsCount }} Rombel</h4>
                <p class="text-[10px] opacity-90 font-bold">{{ $subjectsCount }} Mata Pelajaran</p>
            </div>
        </div>

        <!-- Metric 4: Kasir SPP -->
        <div class="bg-gradient-to-br from-rose-500 to-orange-500 text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Penerimaan SPP</span>
                <span>💳</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate">Rp {{ number_format($sppTotalPaid, 0, ',', '.') }}</h4>
                <p class="text-[10px] opacity-90 font-bold">{{ $sppBillsPaidCount }} Lunas • {{ $sppBillsUnpaidCount }} Pending</p>
            </div>
        </div>

        <!-- Metric 5: Tabungan Siswa -->
        <div class="bg-gradient-to-br from-amber-500 to-yellow-600 text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Tabungan Siswa</span>
                <span>🏦</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h4>
                <p class="text-[10px] opacity-90 font-bold">Saldo Teller Sekolah</p>
            </div>
        </div>

        <!-- Metric 6: Kantin POS -->
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-4 rounded-3xl shadow-md space-y-2">
            <div class="flex items-center justify-between">
                <span class="text-[10px] font-black uppercase opacity-80">Kantin POS</span>
                <span>🛒</span>
            </div>
            <div>
                <h4 class="text-xl font-black truncate">Rp {{ number_format($canteenSalesToday, 0, ',', '.') }}</h4>
                <p class="text-[10px] opacity-90 font-bold">Transaksi Cashless</p>
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
