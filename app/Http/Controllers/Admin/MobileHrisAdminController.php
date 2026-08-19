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
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        // 1. Total statistik
        $empQuery = DB::table('employees');
        if ($schoolId) {
            $empQuery->where('school_id', $schoolId);
        }
        $totalEmployees = $empQuery->count();

        $faceQuery = DB::table('employees')->whereNotNull('face_registered_at');
        if ($schoolId) {
            $faceQuery->where('school_id', $schoolId);
        }
        $enrolledFaces = $faceQuery->count();

        $todayAttendance = 0;
        if (Schema::hasTable('employee_attendance_logs')) {
            $attQ = DB::table('employee_attendance_logs')->whereDate('date', now()->toDateString());
            if ($schoolId) {
                $attQ->join('employees', 'employee_attendance_logs.employee_id', '=', 'employees.id')
                     ->where('employees.school_id', $schoolId);
            }
            $todayAttendance = $attQ->count();
        }

        $todayMutabaah = 0;

        // 2. Log Presensi Mobile Hari Ini (dengan foto selfie & GPS)
        $attLogsQuery = DB::table('employee_attendance_logs')
            ->join('employees', 'employee_attendance_logs.employee_id', '=', 'employees.id')
            ->select('employee_attendance_logs.*', 'employees.full_name', 'employees.nip', 'employees.role_type as position', 'employees.face_photo_url');
        if ($schoolId) {
            $attLogsQuery->where('employees.school_id', $schoolId);
        }
        $attendanceLogs = $attLogsQuery->orderBy('employee_attendance_logs.id', 'desc')->limit(15)->get();

        // 3. Daftar Pegawai & Status Perekaman Biometrik Wajah (Face ID)
        $empListQuery = DB::table('employees');
        if ($schoolId) {
            $empListQuery->where('school_id', $schoolId);
        }
        $employees = $empListQuery->orderBy('id', 'asc')->limit(20)->get();

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
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $query = DB::table('employees');
        if ($schoolId) {
            $query->where('school_id', $schoolId);
        }
        $employees = $query->orderBy('face_registered_at', 'desc')->paginate(15);

        return view('admin.mobile.faces', compact('employees'));
    }

    /**
     * Halaman Pengaturan Titik Koordinat GPS & Geofence Unit Sekolah
     */
    public function geofenceSettings(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $schools = $schoolId ? \App\Models\School::where('id', $schoolId)->get() : \App\Models\School::orderBy('id', 'asc')->get();
        return view('admin.mobile.geofence', compact('schools'));
    }

    /**
     * Update Titik Koordinat GPS & Radius Presensi Unit
     */
    public function updateGeofence(Request $request, $id)
    {
        $effectiveSchoolId = auth()->user()?->getEffectiveSchoolId();
        if ($effectiveSchoolId && (int)$effectiveSchoolId !== (int)$id) {
            return redirect()->back()->with('error', '⛔ Anda tidak memiliki otoritas mengubah lokasi geofence unit lain.');
        }

        $school = \App\Models\School::findOrFail($id);

        $rawLat = trim((string)$request->input('latitude'));
        $rawLng = trim((string)$request->input('longitude'));

        // Support full copy-paste from Google Maps e.g. "-3.220800, 104.650400"
        if (str_contains($rawLat, ',')) {
            $parts = explode(',', $rawLat);
            if (count($parts) >= 2 && empty($rawLng)) {
                $rawLat = trim($parts[0]);
                $rawLng = trim($parts[1]);
            }
        }

        $cleanLat = str_replace([' ', ','], ['', '.'], $rawLat);
        $cleanLng = str_replace([' ', ','], ['', '.'], $rawLng);
        $rawRadius = (int) preg_replace('/[^0-9]/', '', (string)$request->input('radius_meters', 150));

        $lat = is_numeric($cleanLat) ? (float)$cleanLat : (float)($school->latitude ?? -3.22080000);
        $lng = is_numeric($cleanLng) ? (float)$cleanLng : (float)($school->longitude ?? 104.65040000);
        $radius = ($rawRadius >= 10 && $rawRadius <= 50000) ? $rawRadius : (int)($school->radius_meters ?? 150);

        $school->latitude = $lat;
        $school->longitude = $lng;
        $school->radius_meters = $radius;
        if ($request->filled('address')) {
            $school->address = $request->input('address');
        }
        $school->save();

        return redirect()->route('admin.mobile.geofence')
            ->with('success', "✓ Titik Koordinat Peta ({$lat}, {$lng}) & Radius Presensi ({$radius}m) untuk {$school->name} Berhasil Disimpan!");
    }
}
