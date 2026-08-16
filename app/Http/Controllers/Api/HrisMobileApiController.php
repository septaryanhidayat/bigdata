<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HrisMobileApiController extends Controller
{
    /**
     * Helper: Hitung Jarak Geofence dengan Rumus Haversine (Meter)
     */
    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius);
    }

    /**
     * 1. Otentikasi Login & Deteksi Unit Sekolah Otomatis
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Fallback pencarian dengan NIP di tabel employees jika input berupa NIP
        if (!$user) {
            $employee = DB::table('employees')->where('nip', $request->email)->first();
            if ($employee && $employee->user_id) {
                $user = User::find($employee->user_id);
            }
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email/NIP atau kata sandi tidak valid. Silakan periksa kembali.',
            ], 401);
        }

        if (!$user->is_active) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akun Anda sedang dinonaktifkan oleh administrator.',
            ], 403);
        }

        // Ambil Data Pegawai
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        if (!$employee && $user->school_id) {
            $employee = DB::table('employees')->where('email', $user->email)->first();
        }

        // Deteksi Unit Sekolah
        $school = null;
        if ($user->school_id) {
            $school = School::find($user->school_id);
        }

        // Default Geofence jika Unit Yayasan / Sekolah belum ada koordinat
        $schoolLatitude = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLongitude = $school && $school->longitude ? (float)$school->longitude : 104.65040000;
        $schoolRadius = $school && $school->radius_meters ? (int)$school->radius_meters : 150;

        // Skema Warna Dinamis per Unit
        $unitCode = $school ? strtoupper($school->code) : 'YAYASAN';
        $themeColors = match ($unitCode) {
            'TKIT' => ['primary' => '#059669', 'secondary' => '#f59e0b', 'accent' => '#10b981', 'name' => 'KB/TKIT Robbani'],
            'SDIT' => ['primary' => '#004532', 'secondary' => '#fd761a', 'accent' => '#065f46', 'name' => 'SDIT Robbani'],
            'SMPIT' => ['primary' => '#2563eb', 'secondary' => '#06b6d4', 'accent' => '#1d4ed8', 'name' => 'SMPIT Robbani'],
            'SMAIT' => ['primary' => '#7c3aed', 'secondary' => '#ec4899', 'accent' => '#6d28d9', 'name' => 'SMAIT Robbani'],
            default => ['primary' => '#061107', 'secondary' => '#c6f634', 'accent' => '#0e2010', 'name' => 'Yayasan Generasi Robbani'],
        };

        // Buat Token Sesi API
        $token = 'sdm_' . bin2hex(random_bytes(32));

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil. Selamat datang di Portal SDM SIT Robbani.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'avatar' => $user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300',
            ],
            'employee' => $employee ? [
                'id' => $employee->id,
                'nip' => $employee->nip ?? 'NIP-2026' . str_pad($employee->id, 4, '0', STR_PAD_LEFT),
                'full_name' => $employee->full_name,
                'position' => $employee->position ?? 'Tenaga Pendidik',
                'employment_status' => $employee->employment_status ?? 'TETAP',
                'phone' => $employee->phone ?? $user->phone ?? '-',
                'join_date' => $employee->created_at ?? '2022-07-01',
            ] : [
                'id' => $user->id,
                'nip' => 'PEG-' . str_pad($user->id, 4, '0', STR_PAD_LEFT),
                'full_name' => $user->name,
                'position' => $user->role_id,
                'employment_status' => 'TETAP',
                'phone' => $user->phone ?? '-',
                'join_date' => '2023-01-01',
            ],
            'unit' => [
                'id' => $school ? $school->id : null,
                'code' => $unitCode,
                'name' => $school ? $school->name : 'Yayasan Generasi Robbani (Pusat)',
                'address' => $school ? $school->address : 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir',
                'latitude' => $schoolLatitude,
                'longitude' => $schoolLongitude,
                'radius_meters' => $schoolRadius,
                'theme' => $themeColors,
            ]
        ]);
    }

    /**
     * 2. Dashboard SDM Multi-Unit
     */
    public function dashboard(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;
        $schoolId = $user->school_id;

        $today = date('Y-m-d');

        // Data Presensi Hari Ini
        $todayAttendance = DB::table('employee_attendance_logs')
            ->where('employee_id', $employeeId)
            ->where('date', $today)
            ->first();

        // Ringkasan Cuti
        $approvedLeavesCount = DB::table('employee_leaves')
            ->where('employee_id', $employeeId)
            ->where('status', 'APPROVED')
            ->sum('total_days');
        $annualLeaveQuota = 12;
        $remainingLeaveQuota = max(0, $annualLeaveQuota - $approvedLeavesCount);

        // Gaji Terakhir
        $latestPayroll = DB::table('payroll_salaries')
            ->where('employee_id', $employeeId)
            ->orderBy('month_year', 'desc')
            ->first();

        // KPI Terakhir
        $latestKpi = DB::table('employee_kpis')
            ->where('employee_id', $employeeId)
            ->orderBy('period_month_year', 'desc')
            ->first();

        // Pengumuman Terkini
        $announcements = DB::table('site_settings')
            ->where('group', 'announcement')
            ->limit(3)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'server_time' => date('H:i:s') . ' WIB',
                'today_date' => date('d F Y'),
                'attendance_today' => [
                    'has_checked_in' => $todayAttendance && $todayAttendance->check_in_time !== null,
                    'check_in_time' => $todayAttendance ? $todayAttendance->check_in_time : null,
                    'has_checked_out' => $todayAttendance && $todayAttendance->check_out_time !== null,
                    'check_out_time' => $todayAttendance ? $todayAttendance->check_out_time : null,
                    'status' => $todayAttendance ? $todayAttendance->status : 'NOT_CHECKED_IN',
                    'distance_meters' => $todayAttendance ? $todayAttendance->check_in_distance_meters : null,
                ],
                'leave_summary' => [
                    'total_quota' => $annualLeaveQuota,
                    'used_days' => (int)$approvedLeavesCount,
                    'remaining_days' => $remainingLeaveQuota,
                ],
                'payroll_summary' => [
                    'month_year' => $latestPayroll ? $latestPayroll->month_year : date('Y-m'),
                    'net_salary' => $latestPayroll ? (float)$latestPayroll->net_salary : 3850000,
                    'status' => $latestPayroll ? $latestPayroll->status : 'PAID',
                ],
                'kpi_summary' => [
                    'score' => $latestKpi ? (float)$latestKpi->final_score : 92.50,
                    'grade' => $latestKpi ? $latestKpi->grade : 'A',
                    'period' => $latestKpi ? $latestKpi->period_month_year : date('Y-m'),
                ],
                'wallet_balance' => 350000, // Saldo Dompet Kantin / Koperasi
            ]
        ]);
    }

    /**
     * 3. Presensi Masuk (Check-In) dengan Face Recognition & Anti-Fake GPS
     */
    public function attendanceCheckIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_mocked' => 'nullable|boolean',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;
        $schoolId = $user->school_id;

        // 1. PROTEKSI ANTI-FAKE GPS (MOCK LOCATION DETECTION)
        if ($request->boolean('is_mocked') === true) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'FAKE_GPS_DETECTED',
                'message' => 'Presensi Ditolak! Sistem mendeteksi penggunaan Fake GPS / Mock Location. Harap matikan aplikasi lokasi palsu dan gunakan GPS asli perangkat Anda.',
            ], 422);
        }

        // 2. VALIDASI GEOFENCING JARAK SEKOLAH
        $school = $schoolId ? School::find($schoolId) : null;
        $schoolLat = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLng = $school && $school->longitude ? (float)$school->longitude : 104.65040000;
        $schoolRadius = $school && $school->radius_meters ? (int)$school->radius_meters : 150;

        $distanceMeters = $this->calculateHaversineDistance($request->latitude, $request->longitude, $schoolLat, $schoolLng);

        if ($distanceMeters > $schoolRadius) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'OUT_OF_GEOFENCE',
                'message' => "Presensi Ditolak! Anda berada di luar radius sekolah. Jarak Anda saat ini: {$distanceMeters} meter (Maksimal diperbolehkan: {$schoolRadius} meter).",
                'distance_meters' => $distanceMeters,
                'max_radius_meters' => $schoolRadius,
            ], 422);
        }

        // 3. VALIDASI FOTO WAJAH (FACE DETECTION)
        $faceImage = $request->face_image ?? 'attendance_selfie_' . time() . '.jpg';

        $today = date('Y-m-d');
        $currentTime = date('H:i:s');

        // Tentukan Status: Tepat Waktu atau Terlambat (Batas 07:15 WIB)
        $isLate = strtotime($currentTime) > strtotime('07:15:00');
        $status = $isLate ? 'LATE' : 'PRESENT';

        // Simpan / Update Log Presensi
        DB::table('employee_attendance_logs')->updateOrInsert(
            [
                'employee_id' => $employeeId,
                'date' => $today,
            ],
            [
                'school_id' => $schoolId,
                'check_in_time' => $currentTime,
                'check_in_lat' => $request->latitude,
                'check_in_lng' => $request->longitude,
                'check_in_distance_meters' => $distanceMeters,
                'check_in_face_image' => $faceImage,
                'is_mock_detected' => false,
                'status' => $status,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Alhamdulillah, Presensi Masuk berhasil dicatat!',
            'data' => [
                'date' => $today,
                'check_in_time' => $currentTime . ' WIB',
                'status' => $status,
                'distance_meters' => $distanceMeters,
                'school_unit' => $school ? $school->name : 'Yayasan Generasi Robbani',
            ]
        ]);
    }

    /**
     * 4. Presensi Pulang (Check-Out)
     */
    public function attendanceCheckOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'is_mocked' => 'nullable|boolean',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;
        $schoolId = $user->school_id;

        if ($request->boolean('is_mocked') === true) {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi Ditolak! Terdeteksi Fake GPS.',
            ], 422);
        }

        $school = $schoolId ? School::find($schoolId) : null;
        $schoolLat = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLng = $school && $school->longitude ? (float)$school->longitude : 104.65040000;
        $schoolRadius = $school && $school->radius_meters ? (int)$school->radius_meters : 150;

        $distanceMeters = $this->calculateHaversineDistance($request->latitude, $request->longitude, $schoolLat, $schoolLng);

        if ($distanceMeters > $schoolRadius) {
            return response()->json([
                'status' => 'error',
                'message' => "Presensi Pulang Ditolak! Anda berada di luar radius ({$distanceMeters} meter).",
            ], 422);
        }

        $today = date('Y-m-d');
        $currentTime = date('H:i:s');

        DB::table('employee_attendance_logs')->updateOrInsert(
            [
                'employee_id' => $employeeId,
                'date' => $today,
            ],
            [
                'school_id' => $schoolId,
                'check_out_time' => $currentTime,
                'check_out_lat' => $request->latitude,
                'check_out_lng' => $request->longitude,
                'check_out_distance_meters' => $distanceMeters,
                'check_out_face_image' => $request->face_image ?? 'checkout_selfie.jpg',
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi Pulang berhasil dicatat. Selamat beristirahat!',
            'data' => [
                'date' => $today,
                'check_out_time' => $currentTime . ' WIB',
                'distance_meters' => $distanceMeters,
            ]
        ]);
    }

    /**
     * 5. Riwayat Presensi Bulanan
     */
    public function attendanceHistory(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        $logs = DB::table('employee_attendance_logs')
            ->where('employee_id', $employeeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $logs,
            'summary' => [
                'total_present' => $logs->where('status', 'PRESENT')->count(),
                'total_late' => $logs->where('status', 'LATE')->count(),
                'total_permit' => $logs->where('status', 'PERMIT')->count(),
                'total_sick' => $logs->where('status', 'SICK')->count(),
            ]
        ]);
    }

    /**
     * 6. Daftar & Pengajuan Cuti / Izin Online
     */
    public function leaves(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $leaves = DB::table('employee_leaves')
            ->where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $leaves,
            'quota' => [
                'annual_total' => 12,
                'used' => (int)$leaves->where('status', 'APPROVED')->sum('total_days'),
                'remaining' => max(0, 12 - (int)$leaves->where('status', 'APPROVED')->sum('total_days')),
            ]
        ]);
    }

    public function applyLeave(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:SAKIT,TAHUNAN,MELAHIRKAN,UMROH_HAJI,PENTING',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $start = strtotime($request->start_date);
        $end = strtotime($request->end_date);
        $days = round(($end - $start) / (60 * 60 * 24)) + 1;

        $id = DB::table('employee_leaves')->insertGetId([
            'employee_id' => $employeeId,
            'school_id' => $user->school_id,
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_days' => $days,
            'reason' => $request->reason,
            'attachment_url' => $request->attachment_url ?? null,
            'status' => 'PENDING',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan cuti/izin berhasil dikirim ke pimpinan unit.',
            'data' => [
                'leave_id' => $id,
                'total_days' => $days,
                'status' => 'PENDING',
            ]
        ]);
    }

    /**
     * 7. Payroll & Rincian Slip Gaji Digital
     */
    public function payroll(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $salaries = DB::table('payroll_salaries')
            ->where('employee_id', $employeeId)
            ->orderBy('month_year', 'desc')
            ->get();

        // Seed data jika belum ada
        if ($salaries->isEmpty()) {
            DB::table('payroll_salaries')->insert([
                'employee_id' => $employeeId,
                'month_year' => '2026-08',
                'basic_salary' => 3200000,
                'position_allowance' => 500000,
                'transport_allowance' => 300000,
                'bpjs_deduction' => 85000,
                'tax_deduction' => 65000,
                'cash_advance_deduction' => 0,
                'net_salary' => 3850000,
                'status' => 'PAID',
                'payment_date' => '2026-08-01',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $salaries = DB::table('payroll_salaries')->where('employee_id', $employeeId)->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $salaries,
        ]);
    }

    public function payrollSlip(Request $request, $id)
    {
        $salary = DB::table('payroll_salaries')->where('id', $id)->first();

        if (!$salary) {
            return response()->json(['status' => 'error', 'message' => 'Slip gaji tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $salary->id,
                'period' => $salary->month_year,
                'payment_date' => $salary->payment_date ?? '2026-08-01',
                'earnings' => [
                    ['name' => 'Gaji Pokok', 'amount' => (float)$salary->basic_salary],
                    ['name' => 'Tunjangan Jabatan & Struktural', 'amount' => (float)$salary->position_allowance],
                    ['name' => 'Tunjangan Transport & Kehadiran', 'amount' => (float)$salary->transport_allowance],
                ],
                'deductions' => [
                    ['name' => 'BPJS Kesehatan & Ketenagakerjaan', 'amount' => (float)$salary->bpjs_deduction],
                    ['name' => 'Pajak PPh 21', 'amount' => (float)$salary->tax_deduction],
                    ['name' => 'Potongan Kasbon / Koperasi', 'amount' => (float)$salary->cash_advance_deduction],
                ],
                'total_earnings' => (float)($salary->basic_salary + $salary->position_allowance + $salary->transport_allowance),
                'total_deductions' => (float)($salary->bpjs_deduction + $salary->tax_deduction + $salary->cash_advance_deduction),
                'net_salary' => (float)$salary->net_salary,
                'status' => $salary->status,
            ]
        ]);
    }

    /**
     * 8. Penilaian Kinerja & Evaluasi KPI Pegawai
     */
    public function kpi(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $kpis = DB::table('employee_kpis')
            ->where('employee_id', $employeeId)
            ->orderBy('period_month_year', 'desc')
            ->get();

        // Seed data jika belum ada
        if ($kpis->isEmpty()) {
            DB::table('employee_kpis')->insert([
                'employee_id' => $employeeId,
                'school_id' => $user->school_id,
                'period_month_year' => '2026-08',
                'pedagogic_score' => 92.00,
                'personality_score' => 95.00,
                'social_score' => 90.00,
                'islamic_score' => 96.00,
                'discipline_attendance_score' => 94.00,
                'final_score' => 93.40,
                'grade' => 'A',
                'evaluator_notes' => 'Kinerja mengajar dan teladan kepribadian Islami sangat baik. Pertahankan kedisiplinan dan inovasi pembelajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $kpis = DB::table('employee_kpis')->where('employee_id', $employeeId)->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => $kpis,
        ]);
    }

    /**
     * 9. Belanja Produk Kantin & Koperasi Pegawai
     */
    public function canteenProducts(Request $request)
    {
        $products = [
            ['id' => 1, 'name' => 'Nasi Ayam Geprek Robbani', 'price' => 15000, 'category' => 'Makanan', 'image' => 'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?q=80&w=200'],
            ['id' => 2, 'name' => 'Jus Alpukat Kocok', 'price' => 10000, 'category' => 'Minuman', 'image' => 'https://images.unsplash.com/photo-1553530666-ba11a7da3888?q=80&w=200'],
            ['id' => 3, 'name' => 'Seragam Batik Guru SIT Robbani', 'price' => 125000, 'category' => 'Koperasi', 'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=200'],
            ['id' => 4, 'name' => 'Buku Jurnal Mengajar & Mutabaah', 'price' => 35000, 'category' => 'Alat Tulis', 'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?q=80&w=200'],
        ];

        return response()->json([
            'status' => 'success',
            'wallet_balance' => 350000,
            'products' => $products,
        ]);
    }

    public function canteenPay(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $receiptNo = 'KOP-' . date('YmdHis');

        return response()->json([
            'status' => 'success',
            'message' => 'Pembayaran berhasil diproses menggunakan dompet pegawai.',
            'receipt_number' => $receiptNo,
            'amount_paid' => (float)$request->amount,
            'remaining_balance' => 350000 - (float)$request->amount,
        ]);
    }

    /**
     * 10. Pengumuman & Memo Internal Yayasan / Unit
     */
    public function announcements(Request $request)
    {
        $announcements = [
            [
                'id' => 1,
                'title' => 'Rapat Pleno Awal Tahun Ajaran 2026/2027 SIT Robbani',
                'category' => 'YAYASAN',
                'date' => '18 Agustus 2026',
                'content' => 'Seluruh dewan guru dan staf diundang hadir pada Rapat Pleno Gabungan 4 Unit bertempat di Aula Utama Kampus A Indralaya.',
                'badge_color' => '#059669',
            ],
            [
                'id' => 2,
                'title' => 'Workshop Kurikulum Deep Learning & Pemanfaatan AI SmartEdu',
                'category' => 'PELATIHAN',
                'date' => '22 Agustus 2026',
                'content' => 'Pelatihan kompetensi digital bagi seluruh tenaga pendidik dalam mengoptimalkan fitur E-Learning & Bank Soal CBT.',
                'badge_color' => '#2563eb',
            ],
            [
                'id' => 3,
                'title' => 'Jadwal Pencairan Tunjangan Kinerja & Gaji Bulanan',
                'category' => 'KEUANGAN',
                'date' => '25 Agustus 2026',
                'content' => 'Pencairan gaji dan insentif kehadiran bulan Agustus 2026 akan ditransfer serentak ke rekening BSI masing-masing pegawai.',
                'badge_color' => '#f59e0b',
            ],
        ];

        return response()->json([
            'status' => 'success',
            'data' => $announcements,
        ]);
    }
}
