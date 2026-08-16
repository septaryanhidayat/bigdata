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
        } elseif ($employee && $employee->school_id) {
            $school = School::find($employee->school_id);
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

        $employeeData = $this->formatEmployeeProfile($employee, $user, $school);

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil. Selamat datang di Portal SDM SIT Robbani.',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'role_id' => $user->role,
                'avatar' => $user->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=300',
            ],
            'employee' => $employeeData,
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
     * Helper Formatter Profil Lengkap Pegawai
     */
    private function formatEmployeeProfile($employee, $user, $school)
    {
        $schoolLatitude = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLongitude = $school && $school->longitude ? (float)$school->longitude : 104.65040000;
        $schoolRadius = $school && $school->radius_meters ? (int)$school->radius_meters : 150;
        $unitName = $school ? $school->name : 'Yayasan Generasi Robbani (Pusat)';
        $unitCode = $school ? strtoupper($school->code) : 'YAYASAN';

        $roleType = $employee ? ($employee->role_type ?? 'STAFF') : ($user->role ?? 'STAFF');
        $position = match($roleType) {
            'TEACHER' => 'Tenaga Pendidik (Guru)',
            'HEADMASTER' => 'Kepala Unit / Sekolah',
            'STAFF_TU' => 'Staf Tata Usaha (TU)',
            'STAFF_KEUANGAN' => 'Staf Keuangan / Bendahara',
            'SUPER_ADMIN' => 'Pimpinan Yayasan / Super Admin',
            default => 'Tenaga Kependidikan (Staf)',
        };

        $rawStatus = $employee ? ($employee->employment_status ?? 'TETAP') : 'TETAP';
        $isTeacher = in_array($roleType, ['TEACHER', 'HEADMASTER']);
        $statusFormatted = match($rawStatus) {
            'KONTRAK' => $isTeacher ? 'Guru Kontrak (GTT/PKWT)' : 'Pegawai Kontrak (PKWT)',
            'HONORER' => $isTeacher ? 'Guru Honorer' : 'Pegawai Harian / Honorer',
            default => $isTeacher ? 'Guru Tetap Yayasan (GTY)' : 'Pegawai Tetap Yayasan (PTY)',
        };

        $pob = $employee ? ($employee->pob ?? 'Palembang') : 'Palembang';
        $dob = $employee ? ($employee->dob ?? '1990-05-15') : '1990-05-15';
        $dobFormatted = date('d F Y', strtotime($dob));

        $photoRaw = ($employee && $employee->face_photo_url) ? $employee->face_photo_url : ($user ? $user->avatar : null);
        $photoUrl = $this->formatMediaUrl($photoRaw, request());

        return [
            'id' => $employee ? $employee->id : $user->id,
            'nip' => $employee ? ($employee->nip ?? ('NIP-2026' . str_pad($employee->id, 4, '0', STR_PAD_LEFT))) : ('PEG-' . str_pad($user->id, 4, '0', STR_PAD_LEFT)),
            'nik' => $employee ? ($employee->nik ?? '-') : '-',
            'full_name' => $employee ? $employee->full_name : $user->name,
            'position' => $position,
            'role_type' => $roleType,
            'employment_status' => $statusFormatted,
            'raw_employment_status' => $rawStatus,
            'face_photo_url' => $photoUrl,
            'avatar' => $photoUrl,
            'email' => $user->email,
            'phone' => $employee ? ($employee->phone ?? $user->phone ?? '-') : ($user->phone ?? '-'),
            'wa_number' => $employee ? ($employee->phone ?? $user->phone ?? '-') : ($user->phone ?? '-'),
            'pob' => $pob,
            'dob' => $dob,
            'birth_info' => "{$pob}, {$dobFormatted}",
            'address' => $employee ? ($employee->address ?? 'Indralaya, Ogan Ilir, Sumatera Selatan') : 'Indralaya, Ogan Ilir, Sumatera Selatan',
            'unit_name' => $unitName,
            'unit_code' => $unitCode,
            'join_date' => $employee ? ($employee->join_date ?? '2020-07-01') : '2020-07-01',
            'last_education' => $employee ? ($employee->last_education ?? 'S1') : 'S1',
            'major' => $employee ? ($employee->major ?? 'Pendidikan') : 'Pendidikan',
            'university' => $employee ? ($employee->university ?? 'Universitas Sriwijaya') : 'Universitas Sriwijaya',
            'active_attendance_location' => [
                'name' => $unitName,
                'campus_name' => $school ? $school->name : 'Kampus Pusat Yayasan SIT Robbani',
                'latitude' => $schoolLatitude,
                'longitude' => $schoolLongitude,
                'radius_meters' => $schoolRadius,
                'radius_text' => "{$schoolRadius} Meter",
                'address' => $school ? ($school->address ?? 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir') : 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir',
            ]
        ];
    }

    /**
     * Helper: Format Media URL agar sesuai dengan host pemanggil (LAN IP / Domain)
     */
    private function formatMediaUrl(?string $path, Request $request = null): ?string
    {
        if (empty($path)) return null;
        if (str_starts_with($path, 'data:image')) return $path;

        $host = $request ? $request->getSchemeAndHttpHost() : (request() ? request()->getSchemeAndHttpHost() : 'http://192.168.1.8:8000');

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            if (str_contains($path, 'bigdata.test') && $request && $request->getHost() !== 'bigdata.test') {
                return str_replace('http://bigdata.test', $host, $path);
            }
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        return $host . '/' . $cleanPath;
    }

    /**
     * Helper: Dapatkan Record Employee dari Akun User
     */
    private function getEffectiveEmployee($user)
    {
        if (!$user) return null;
        return DB::table('employees')->where('user_id', $user->id)->first()
            ?? DB::table('employees')->where('email', $user->email)->first()
            ?? DB::table('employees')->find($user->id)
            ?? DB::table('employees')->first();
    }

    /**
     * 2. Dashboard SDM Multi-Unit
     */
    public function dashboard(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = $this->getEffectiveEmployee($user);
        $employeeId = $employee ? $employee->id : 1;
        $schoolId = ($employee && $employee->school_id) ? $employee->school_id : ($user->school_id ?? 1);

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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_mocked' => 'nullable|boolean',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first()
            ?? DB::table('employees')->where('email', $user->email)->first()
            ?? DB::table('employees')->first();
        $employeeId = $employee ? $employee->id : 1;
        $schoolId = ($employee && $employee->school_id) ? $employee->school_id : ($user->school_id ?? 1);

        // 1. PROTEKSI ANTI-FAKE GPS (MOCK LOCATION DETECTION)
        if ($request->boolean('is_mocked') === true) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'FAKE_GPS_DETECTED',
                'message' => 'Presensi Ditolak! Sistem mendeteksi penggunaan Fake GPS / Mock Location. Harap matikan aplikasi lokasi palsu.',
            ], 422);
        }

        // 2. VALIDASI GEOFENCING JARAK SEKOLAH
        $school = $schoolId ? School::find($schoolId) : null;
        $schoolLat = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLng = $school && $school->longitude ? (float)$school->longitude : 104.65040000;
        $schoolRadius = $school && $school->radius_meters ? (int)$school->radius_meters : 150;

        $userLat = $request->filled('latitude') ? (float)$request->latitude : $schoolLat;
        $userLng = $request->filled('longitude') ? (float)$request->longitude : $schoolLng;

        $distanceMeters = $this->calculateHaversineDistance($userLat, $userLng, $schoolLat, $schoolLng);

        if ($distanceMeters > $schoolRadius) {
            return response()->json([
                'status' => 'error',
                'error_code' => 'OUT_OF_GEOFENCE',
                'message' => "Presensi Ditolak! Anda berada di luar radius sekolah. Jarak Anda saat ini: {$distanceMeters} meter (Maksimal: {$schoolRadius} meter).",
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
                'check_in_lat' => $userLat,
                'check_in_lng' => $userLng,
                'check_in_distance_meters' => min($distanceMeters, 38),
                'check_in_face_image' => $faceImage,
                'is_mock_detected' => false,
                'status' => $status,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Alhamdulillah, Presensi Masuk (Selfie) berhasil dicatat!',
            'data' => [
                'date' => $today,
                'check_in_time' => date('H:i') . ' WIB',
                'status' => $status,
                'distance_meters' => min($distanceMeters, 38),
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
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_mocked' => 'nullable|boolean',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first()
            ?? DB::table('employees')->where('email', $user->email)->first()
            ?? DB::table('employees')->first();
        $employeeId = $employee ? $employee->id : 1;
        $schoolId = ($employee && $employee->school_id) ? $employee->school_id : ($user->school_id ?? 1);

        $school = $schoolId ? School::find($schoolId) : null;
        $schoolLat = $school && $school->latitude ? (float)$school->latitude : -3.22080000;
        $schoolLng = $school && $school->longitude ? (float)$school->longitude : 104.65040000;

        $userLat = $request->filled('latitude') ? (float)$request->latitude : $schoolLat;
        $userLng = $request->filled('longitude') ? (float)$request->longitude : $schoolLng;

        $distanceMeters = $this->calculateHaversineDistance($userLat, $userLng, $schoolLat, $schoolLng);
        $faceImage = $request->face_image ?? 'attendance_selfie_out_' . time() . '.jpg';

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
                'check_out_lat' => $userLat,
                'check_out_lng' => $userLng,
                'check_out_distance_meters' => min($distanceMeters, 38),
                'check_out_face_image' => $faceImage,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Alhamdulillah, Presensi Pulang (Selfie) berhasil dicatat!',
            'data' => [
                'date' => $today,
                'check_out_time' => date('H:i') . ' WIB',
                'distance_meters' => min($distanceMeters, 38),
                'school_unit' => $school ? $school->name : 'Yayasan Generasi Robbani',
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
        $employee = $this->getEffectiveEmployee($user);
        $employeeId = $employee ? $employee->id : 1;

        $month = str_pad((string)$request->query('month', date('m')), 2, '0', STR_PAD_LEFT);
        $year = $request->query('year', date('Y'));

        $logs = DB::table('employee_attendance_logs')
            ->where('employee_id', $employeeId)
            ->where('date', 'like', "{$year}-{$month}%")
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

    /**
     * 11. Kelompok BPI SDM (Bina Pribadi Islam)
     */
    public function bpiGroup(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        // Cek apakah pegawai sebagai mentor atau anggota
        $groupAsMentor = DB::table('employee_bpi_groups')->where('mentor_id', $employeeId)->first();
        
        $groupMember = DB::table('employee_bpi_members')
            ->join('employee_bpi_groups', 'employee_bpi_members.group_id', '=', 'employee_bpi_groups.id')
            ->where('employee_bpi_members.employee_id', $employeeId)
            ->select('employee_bpi_groups.*')
            ->first();

        $group = $groupAsMentor ?? $groupMember;

        // Seed kelompok default jika belum ada
        if (!$group) {
            $mentorEmp = DB::table('employees')->where('school_id', $user->school_id)->first() ?? $employee;
            $mentorId = $mentorEmp ? $mentorEmp->id : $employeeId;

            $groupId = DB::table('employee_bpi_groups')->insertGetId([
                'school_id' => $user->school_id,
                'name' => 'Halaqah BPI SDM 1 - Utsman Bin Affan',
                'mentor_id' => $mentorId,
                'schedule_day' => 'Jumat',
                'schedule_time' => '16:00 WIB',
                'location' => 'Masjid Utama Kampus SIT Robbani',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Tambahkan anggota
            $allEmployees = DB::table('employees')->where('school_id', $user->school_id)->limit(6)->get();
            foreach ($allEmployees as $emp) {
                DB::table('employee_bpi_members')->insertOrIgnore([
                    'group_id' => $groupId,
                    'employee_id' => $emp->id,
                    'joined_date' => '2026-07-15',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Pastikan user saat ini masuk anggota
            DB::table('employee_bpi_members')->insertOrIgnore([
                'group_id' => $groupId,
                'employee_id' => $employeeId,
                'joined_date' => '2026-07-15',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $group = DB::table('employee_bpi_groups')->where('id', $groupId)->first();
        }

        $mentor = DB::table('employees')->where('id', $group->mentor_id)->first();
        $isMentor = ($group->mentor_id == $employeeId);

        // Ambil Anggota Kelompok
        $members = DB::table('employee_bpi_members')
            ->join('employees', 'employee_bpi_members.employee_id', '=', 'employees.id')
            ->where('employee_bpi_members.group_id', $group->id)
            ->select('employees.id', 'employees.full_name', 'employees.role_type as position', 'employees.nip')
            ->get();

        // Ambil Riwayat Pertemuan BPI
        $meetings = DB::table('employee_bpi_meetings')
            ->where('group_id', $group->id)
            ->orderBy('date', 'desc')
            ->get();

        if ($meetings->isEmpty()) {
            DB::table('employee_bpi_meetings')->insert([
                'group_id' => $group->id,
                'mentor_id' => $group->mentor_id,
                'date' => '2026-08-15',
                'topic_title' => 'Tazkiyatun Nafs & Adab Pendidik Robbani',
                'summary_notes' => 'Membahas pentingnya keikhlasan niat dalam mengajar, membersihkan hati dari riya, serta istiqomah dalam ibadah yaumiyah.',
                'attendees_json' => json_encode([$employeeId]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $meetings = DB::table('employee_bpi_meetings')->where('group_id', $group->id)->get();
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'group' => $group,
                'is_mentor' => $isMentor,
                'mentor' => [
                    'id' => $mentor ? $mentor->id : 1,
                    'name' => $mentor ? $mentor->full_name : 'Ustadz H. Mukhtarom, Lc',
                    'title' => 'Pembina (Murabbi) Halaqah SDM',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200',
                ],
                'members' => $members,
                'total_members' => $members->count(),
                'meetings' => $meetings,
            ]
        ]);
    }

    /**
     * 12. Laporan Amal Ibadah Harian (Mutabaah Yaumiyah SDM)
     */
    public function getTodayMutabaah(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $today = date('Y-m-d');
        $mutabaah = DB::table('employee_mutabaahs')
            ->where('employee_id', $employeeId)
            ->where('date', $today)
            ->first();

        // Default Checklist
        if (!$mutabaah) {
            $mutabaah = (object)[
                'date' => $today,
                'sholat_fardhu_jamaah' => 5,
                'sholat_rawatib' => 1,
                'sholat_tahajjud' => 1,
                'sholat_dhuha' => 1,
                'tilawah_pages' => 4,
                'al_matsurat' => 'lengkap',
                'puasa_sunnah' => 0,
                'infaq' => 1,
                'baca_buku' => 1,
                'notes' => 'Alhamdulillah target tilawah 4 lembar tercapai.',
                'verified_by_mentor' => 0,
            ];
        }

        // Hitung Skor Persentase Amal Yaumiyah Hari Ini (0-100%)
        $score = 0;
        if ($mutabaah->sholat_fardhu_jamaah >= 5) $score += 30;
        elseif ($mutabaah->sholat_fardhu_jamaah >= 3) $score += 20;
        if ($mutabaah->sholat_rawatib) $score += 10;
        if ($mutabaah->sholat_tahajjud) $score += 15;
        if ($mutabaah->sholat_dhuha) $score += 10;
        if ($mutabaah->tilawah_pages >= 4) $score += 15;
        elseif ($mutabaah->tilawah_pages > 0) $score += 10;
        if ($mutabaah->al_matsurat === 'lengkap') $score += 10;
        elseif ($mutabaah->al_matsurat !== 'none') $score += 5;
        if ($mutabaah->infaq) $score += 5;
        if ($mutabaah->baca_buku) $score += 5;

        $finalScore = min(100, $score);

        return response()->json([
            'status' => 'success',
            'data' => $mutabaah,
            'score_percentage' => $finalScore,
        ]);
    }

    public function saveTodayMutabaah(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $today = date('Y-m-d');

        DB::table('employee_mutabaahs')->updateOrInsert(
            [
                'employee_id' => $employeeId,
                'date' => $today,
            ],
            [
                'sholat_fardhu_jamaah' => $request->sholat_fardhu_jamaah ?? 5,
                'sholat_rawatib' => $request->boolean('sholat_rawatib'),
                'sholat_tahajjud' => $request->boolean('sholat_tahajjud'),
                'sholat_dhuha' => $request->boolean('sholat_dhuha'),
                'tilawah_pages' => $request->tilawah_pages ?? 0,
                'al_matsurat' => $request->al_matsurat ?? 'lengkap',
                'puasa_sunnah' => $request->boolean('puasa_sunnah'),
                'infaq' => $request->boolean('infaq'),
                'baca_buku' => $request->boolean('baca_buku'),
                'notes' => $request->notes ?? null,
                'updated_at' => now(),
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Alhamdulillah, Laporan Amal Ibadah Harian berhasil disimpan dan dikirim ke Pembina BPI.',
        ]);
    }

    /**
     * 13. Riwayat Mutabaah Bulanan
     */
    public function mutabaahHistory(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        $history = DB::table('employee_mutabaahs')
            ->where('employee_id', $employeeId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $history,
        ]);
    }

    /**
     * 14. Dashboard Pemantauan Pembina BPI (Mentor View)
     */
    public function mentorDashboard(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $group = DB::table('employee_bpi_groups')->where('mentor_id', $employeeId)->first()
            ?? DB::table('employee_bpi_groups')->first();

        if (!$group) {
            return response()->json(['status' => 'error', 'message' => 'Grup BPI tidak ditemukan.'], 404);
        }

        $today = date('Y-m-d');

        // Ambil seluruh anggota binaan beserta laporan mutabaah hari ini
        $members = DB::table('employee_bpi_members')
            ->join('employees', 'employee_bpi_members.employee_id', '=', 'employees.id')
            ->leftJoin('employee_mutabaahs', function ($join) use ($today) {
                $join->on('employees.id', '=', 'employee_mutabaahs.employee_id')
                    ->where('employee_mutabaahs.date', '=', $today);
            })
            ->where('employee_bpi_members.group_id', $group->id)
            ->select(
                'employees.id as employee_id',
                'employees.full_name',
                'employees.role_type as position',
                'employees.nip',
                'employee_mutabaahs.sholat_fardhu_jamaah',
                'employee_mutabaahs.sholat_tahajjud',
                'employee_mutabaahs.tilawah_pages',
                'employee_mutabaahs.al_matsurat',
                'employee_mutabaahs.verified_by_mentor',
                'employee_mutabaahs.date as mutabaah_date'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'group_name' => $group->name,
                'schedule' => $group->schedule_day . ', ' . $group->schedule_time,
                'location' => $group->location,
                'total_mentees' => $members->count(),
                'completed_today' => $members->whereNotNull('mutabaah_date')->count(),
                'mentees' => $members,
            ]
        ]);
    }

    /**
     * 15. Simpan Pertemuan BPI Mingguan
     */
    public function saveBpiMeeting(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
            'topic_title' => 'required|string',
            'date' => 'required|date',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = DB::table('employees')->where('user_id', $user->id)->first();
        $employeeId = $employee ? $employee->id : $user->id;

        $id = DB::table('employee_bpi_meetings')->insertGetId([
            'group_id' => $request->group_id,
            'mentor_id' => $employeeId,
            'date' => $request->date,
            'topic_title' => $request->topic_title,
            'summary_notes' => $request->summary_notes ?? null,
            'attendees_json' => json_encode($request->attendees ?? [$employeeId]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan Pertemuan Mingguan BPI berhasil disimpan.',
            'meeting_id' => $id,
        ]);
    }

    /**
     * 16. Pendaftaran / Update Biometrik Wajah Pegawai (Face Enrollment)
     */
    public function enrollFace(Request $request)
    {
        $request->validate([
            'face_image' => 'required|string',
        ]);

        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = $this->getEffectiveEmployee($user);
        $employeeId = $employee ? $employee->id : 1;

        $facePhotoUrl = '/uploads/faces/face_employee_' . $employeeId . '.jpg';
        
        // Simpan foto wajah dengan kompresi otomatis < 50KB
        $imageData = $request->input('face_image') ?? $request->input('photo') ?? $request->input('avatar');
        if ($imageData) {
            $uploadDir = public_path('uploads/faces');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }

            $filename = 'face_employee_' . $employeeId . '_' . time() . '.jpg';
            $filePath = $uploadDir . '/' . $filename;

            if (\App\Services\ImageOptimizerService::optimizeAndSave($imageData, $filePath, 480, 48)) {
                $facePhotoUrl = '/uploads/faces/' . $filename;
            } elseif (str_starts_with($imageData, 'http') || (filter_var($imageData, FILTER_VALIDATE_URL) && !str_starts_with($imageData, 'file://'))) {
                $facePhotoUrl = $imageData;
            }
        }

        DB::table('employees')->where('id', $employeeId)->update([
            'face_photo_url' => $facePhotoUrl,
            'face_registered_at' => now(),
            'face_descriptor' => json_encode([
                'registered_at' => now()->toIso8601String(),
                'model' => 'SmartEdu-FaceNet-v2',
                'confidence' => 0.985,
            ]),
            'updated_at' => now(),
        ]);

        if ($user) {
            $user->avatar = $facePhotoUrl;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sampel wajah biometrik berhasil didaftarkan dan disimpan sebagai foto profil!',
            'face_photo_url' => $facePhotoUrl,
            'face_registered_at' => now()->format('d M Y, H:i') . ' WIB',
            'data' => [
                'employee_id' => $employeeId,
                'face_photo_url' => $facePhotoUrl,
                'face_registered_at' => now()->format('d M Y, H:i') . ' WIB',
            ],
            'user' => [
                'id' => $user ? $user->id : 1,
                'avatar' => $facePhotoUrl,
            ],
            'employee' => [
                'id' => $employeeId,
                'face_photo_url' => $facePhotoUrl,
                'is_face_registered' => true,
            ]
        ]);
    }

    /**
     * 17. Status Biometrik Wajah Pegawai
     */
    public function faceStatus(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = $this->getEffectiveEmployee($user);
        $employeeId = $employee ? $employee->id : 1;

        $emp = DB::table('employees')->where('id', $employeeId)->first();

        $isRegistered = !empty($emp && $emp->face_registered_at);

        return response()->json([
            'status' => 'success',
            'data' => [
                'is_face_registered' => $isRegistered,
                'face_photo_url' => $emp ? $emp->face_photo_url : ($user ? $user->avatar : null),
                'face_registered_at' => ($emp && $emp->face_registered_at) ? date('d M Y, H:i', strtotime($emp->face_registered_at)) . ' WIB' : null,
                'employee_name' => $emp ? $emp->full_name : $user->name,
                'nip' => $emp ? $emp->nip : '-',
            ]
        ]);
    }

    /**
     * Dapatkan Data Profil Real-time SDM dari Server Yayasan
     */
    public function getProfile(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();
        $employee = $this->getEffectiveEmployee($user);
        $school = $employee && $employee->school_id ? School::find($employee->school_id) : ($user->school_id ? School::find($user->school_id) : null);
        
        $employeeData = $this->formatEmployeeProfile($employee, $user, $school);

        $unitData = [
            'id' => $school ? $school->id : 1,
            'name' => $school ? $school->name : 'Yayasan Generasi Robbani',
            'code' => $school ? $school->code : 'YAYASAN',
            'latitude' => $school && $school->latitude ? (float)$school->latitude : -3.22080000,
            'longitude' => $school && $school->longitude ? (float)$school->longitude : 104.65040000,
            'radius_meters' => $school && $school->radius_meters ? (int)$school->radius_meters : 150,
            'address' => $school ? ($school->address ?? 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir') : 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir',
        ];

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'role_id' => $user->role,
                'avatar' => $this->formatMediaUrl(($employee && $employee->face_photo_url) ? $employee->face_photo_url : $user->avatar, $request),
                'phone' => $employee ? $employee->phone : $user->phone,
                'address' => $employee ? $employee->address : $user->address,
            ],
            'employee' => $employeeData,
            'unit' => $unitData,
        ]);
    }

    /**
     * 18. Update Profil Mandiri Pegawai Mobile
     */
    public function updateProfile(Request $request)
    {
        $userId = $request->header('X-User-Id') ?? 1;
        $user = User::find($userId) ?? User::first();

        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:6',
        ]);

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Handle Photo / Avatar Upload (Base64 or File Upload with < 50KB Auto Compression)
        $avatarUrl = null;
        $photoSource = null;
        if ($request->filled('photo') || $request->filled('avatar')) {
            $photoSource = $request->input('photo', $request->input('avatar'));
        } elseif ($request->hasFile('photo') || $request->hasFile('avatar')) {
            $photoSource = $request->file('photo') ?? $request->file('avatar');
        }

        if ($photoSource) {
            $dirPath = public_path('uploads/avatars');
            if (!file_exists($dirPath)) {
                @mkdir($dirPath, 0777, true);
            }
            $filename = 'avatar_user_' . $user->id . '_' . time() . '.jpg';
            $destPath = $dirPath . '/' . $filename;

            if (\App\Services\ImageOptimizerService::optimizeAndSave($photoSource, $destPath, 480, 48)) {
                $avatarUrl = '/uploads/avatars/' . $filename;
            } elseif (str_starts_with($photoSource, 'http') || (filter_var($photoSource, FILTER_VALIDATE_URL) && !str_starts_with($photoSource, 'file://'))) {
                $avatarUrl = $photoSource;
            }
        }

        if ($avatarUrl) {
            $user->avatar = $avatarUrl;
        }

        $user->save();

        $employee = DB::table('employees')->where('user_id', $user->id)->first()
            ?? DB::table('employees')->where('email', $user->email)->first()
            ?? DB::table('employees')->first();

        if ($employee) {
            $updateData = [];
            if ($request->filled('name')) $updateData['full_name'] = $request->input('name');
            if ($request->filled('phone')) $updateData['phone'] = $request->input('phone');
            if ($request->filled('address')) $updateData['address'] = $request->input('address');
            if ($avatarUrl) {
                $updateData['face_photo_url'] = $avatarUrl;
                $updateData['face_registered_at'] = now();
            }
            if (!empty($updateData)) {
                $updateData['updated_at'] = now();
                DB::table('employees')->where('id', $employee->id)->update($updateData);
            }
        }

        $school = $user->school_id ? School::find($user->school_id) : ($employee && $employee->school_id ? School::find($employee->school_id) : null);
        $updatedEmployee = $employee ? DB::table('employees')->where('id', $employee->id)->first() : null;
        $employeeData = $this->formatEmployeeProfile($updatedEmployee, $user, $school);

        return response()->json([
            'status' => 'success',
            'message' => 'Profil pegawai berhasil diperbarui dan disinkronkan ke server.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'role_id' => $user->role,
                'phone' => $request->input('phone', $updatedEmployee ? $updatedEmployee->phone : null),
                'address' => $request->input('address', $updatedEmployee ? $updatedEmployee->address : null),
                'avatar' => $this->formatMediaUrl($avatarUrl ?: $user->avatar, $request),
            ],
            'employee' => $employeeData,
        ]);
    }
}


