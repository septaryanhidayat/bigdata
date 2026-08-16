<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

class MobileHrisAdminController extends Controller
{
    /**
     * Dashboard Manajemen & Monitoring Aplikasi Mobile SDM SIT Robbani
     */
    public function index(Request $request)
    {
        $schoolId = session('selected_school_id', 1);

        // 1. Total statistik
        $totalEmployees = DB::table('employees')->where('school_id', $schoolId)->count();
        if ($totalEmployees === 0) {
            $totalEmployees = DB::table('employees')->count();
        }

        $enrolledFaces = DB::table('employees')
            ->whereNotNull('face_registered_at')
            ->count();

        $todayAttendance = DB::table('employee_attendance_logs')
            ->whereDate('date', now()->toDateString())
            ->count();

        $todayMutabaah = DB::table('sdm_mutabaah_logs')
            ->whereDate('date', now()->toDateString())
            ->count();

        // 2. Log Presensi Mobile Hari Ini (dengan foto selfie & GPS)
        $attendanceLogs = DB::table('employee_attendance_logs')
            ->join('employees', 'employee_attendance_logs.employee_id', '=', 'employees.id')
            ->select('employee_attendance_logs.*', 'employees.full_name', 'employees.nip', 'employees.position', 'employees.face_photo_url')
            ->orderBy('employee_attendance_logs.id', 'desc')
            ->limit(15)
            ->get();

        // 3. Daftar Pegawai & Status Perekaman Biometrik Wajah (Face ID)
        $employees = DB::table('employees')
            ->orderBy('id', 'asc')
            ->limit(20)
            ->get();

        return view('admin.mobile.index', compact(
            'totalEmployees',
            'enrolledFaces',
            'todayAttendance',
            'todayMutabaah',
            'attendanceLogs',
            'employees'
        ));
    }

    /**
     * Halaman Khusus Manajemen Biometrik Wajah Pegawai
     */
    public function faceBiometrics(Request $request)
    {
        $employees = DB::table('employees')
            ->orderBy('face_registered_at', 'desc')
            ->paginate(15);

        return view('admin.mobile.faces', compact('employees'));
    }
}
