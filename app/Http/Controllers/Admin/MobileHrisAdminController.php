<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        $todayAttendance = 0;
        if (Schema::hasTable('employee_attendance_logs')) {
            $todayAttendance = DB::table('employee_attendance_logs')
                ->whereDate('date', now()->toDateString())
                ->count();
        }

        $todayMutabaah = 0;
        if (Schema::hasTable('employee_mutabaahs')) {
            $todayMutabaah = DB::table('employee_mutabaahs')
                ->whereDate('date', now()->toDateString())
                ->count();
        } elseif (Schema::hasTable('bpi_mutabaahs')) {
            $todayMutabaah = DB::table('bpi_mutabaahs')
                ->whereDate('date', now()->toDateString())
                ->count();
        }

        // 2. Log Presensi Mobile Hari Ini (dengan foto selfie & GPS)
        $attendanceLogs = DB::table('employee_attendance_logs')
            ->join('employees', 'employee_attendance_logs.employee_id', '=', 'employees.id')
            ->select('employee_attendance_logs.*', 'employees.full_name', 'employees.nip', 'employees.role_type as position', 'employees.face_photo_url')
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

    /**
     * Halaman Pengaturan Titik Koordinat GPS & Geofence Unit Sekolah
     */
    public function geofenceSettings(Request $request)
    {
        $schools = \App\Models\School::orderBy('id', 'asc')->get();
        return view('admin.mobile.geofence', compact('schools'));
    }

    /**
     * Update Titik Koordinat GPS & Radius Presensi Unit
     */
    public function updateGeofence(Request $request, $id)
    {
        $school = \App\Models\School::findOrFail($id);

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_meters' => 'required|integer|min:20|max:5000',
            'address' => 'nullable|string|max:500',
        ]);

        $school->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius_meters' => $request->radius_meters,
            'address' => $request->address ?? $school->address,
        ]);

        return redirect()->back()->with('success', "✓ Titik Koordinat Peta & Radius Presensi untuk {$school->name} Berhasil Disimpan!");
    }
}
