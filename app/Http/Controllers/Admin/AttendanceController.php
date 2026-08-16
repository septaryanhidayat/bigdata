<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\StudentLeave;
use App\Models\Student;
use App\Models\School;
use App\Models\Guardian;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Modul 3.1: Log Realtime Absensi RFID Gate & QR Sesi
     */
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $schoolId = session('dashboard_school_id', 'all');

        $attendancesQuery = Attendance::with(['student.school', 'student.classroom'])->where('date', $today);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);
        $presentQuery = Attendance::where('date', $today)->where('status', 'HADIR');
        $lateQuery = Attendance::where('date', $today)->where('status', 'TERLAMBAT');

        if ($schoolId !== 'all') {
            $attendancesQuery->where('school_id', $schoolId);
            $studentsQuery->where('school_id', $schoolId);
            $presentQuery->where('school_id', $schoolId);
            $lateQuery->where('school_id', $schoolId);
        }

        $attendances = $attendancesQuery->latest()->paginate(20);
        $studentsCount = $studentsQuery->count();
        if ($studentsCount === 0) {
            $studentsCount = ($schoolId !== 'all') ? Student::where('school_id', $schoolId)->count() : Student::count();
        }

        $presentCount = $presentQuery->count();
        $lateCount = $lateQuery->count();
        $absentCount = max(0, $studentsCount - ($presentCount + $lateCount));

        return view('admin.attendance.index', compact('attendances', 'presentCount', 'lateCount', 'absentCount', 'studentsCount', 'today', 'schoolId'));
    }

    /**
     * Simulator RFID Tap Terminal Gate Scanner
     */
    public function tapRfidSimulator(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        $student = Student::where('rfid_tag', $request->rfid_tag)->first();

        if (!$student) {
            $student = Student::first();
        }

        if (!$student) {
            return redirect()->back()->with('error', 'Kartu RFID tidak dikenali dan belum ada data siswa!');
        }

        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        $att = Attendance::firstOrCreate(
            ['student_id' => $student->id, 'date' => $today],
            [
                'school_id' => $student->school_id ?? 1,
                'time_in' => $nowTime,
                'status' => ($nowTime > '07:15:00') ? 'TERLAMBAT' : 'HADIR',
                'method' => 'RFID_GATE',
                'notes' => 'Tap RFID Simulator Gate',
            ]
        );

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'PRESENSI RFID GATE',
                'model_type' => 'Attendance',
                'model_id' => $att->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ [RFID GATE TAP OK] Siswa: ' . $student->full_name . ' | Jam Masuk: ' . $nowTime);
    }

    /**
     * Modul 3.2: Pengajuan Izin & Sakit Siswa
     */
    public function leaves(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');

        $leavesQuery = StudentLeave::with(['student.school', 'student.classroom', 'guardian']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId !== 'all') {
            $leavesQuery->whereHas('student', fn($q) => $q->where('school_id', $schoolId));
            $studentsQuery->where('school_id', $schoolId);
        }

        $leaves = $leavesQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = ($schoolId !== 'all') ? Student::where('school_id', $schoolId)->get() : Student::all();
        }

        return view('admin.attendance.leaves', compact('leaves', 'students', 'schoolId'));
    }

    public function storeLeave(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string',
        ]);

        $student = Student::find($request->student_id);
        $leaveType = in_array(strtoupper($request->leave_type), ['SAKIT', 'IZIN', 'LAINNYA']) ? strtoupper($request->leave_type) : 'IZIN';
        $guardianId = $student->guardian_id ?? Guardian::first()?->id ?? 1;

        $lve = StudentLeave::create([
            'student_id' => $student->id,
            'guardian_id' => $guardianId,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'type' => $leaveType,
            'reason' => $request->reason,
            'status' => 'APPROVED',
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'IZIN SAKIT',
                'model_type' => 'StudentLeave',
                'model_id' => $lve->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', 'Pengajuan Izin Siswa Berhasil Disetujui!');
    }
}
