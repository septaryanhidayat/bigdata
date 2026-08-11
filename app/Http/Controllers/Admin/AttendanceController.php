<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\StudentLeave;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Modul 3.1: Log Realtime Absensi RFID Gate & QR Sesi
     */
    public function index(Request $request)
    {
        $today = date('Y-m-d');
        $attendances = Attendance::with(['student.school', 'student.classroom'])->where('date', $today)->latest()->paginate(20);

        $studentsCount = Student::where('status', 'AKTIF')->count();
        $presentCount = Attendance::where('date', $today)->where('status', 'HADIR')->count();
        $lateCount = Attendance::where('date', $today)->where('status', 'TERLAMBAT')->count();
        $absentCount = max(0, $studentsCount - ($presentCount + $lateCount));

        return view('admin.attendance.index', compact('attendances', 'presentCount', 'lateCount', 'absentCount', 'studentsCount', 'today'));
    }

    /**
     * Simulator RFID Tap Terminal Gate Scanner
     */
    public function tapRfidSimulator(Request $request)
    {
        $request->validate(['rfid_tag' => 'required|string']);

        $student = Student::where('rfid_tag', $request->rfid_tag)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Kartu RFID tidak dikenali!');
        }

        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        Attendance::firstOrCreate(
            ['student_id' => $student->id, 'date' => $today],
            [
                'school_id' => $student->school_id,
                'time_in' => $nowTime,
                'status' => ($nowTime > '07:15:00') ? 'TERLAMBAT' : 'HADIR',
                'method' => 'RFID_GATE',
                'notes' => 'Tap RFID Simulator Gate',
            ]
        );

        return redirect()->back()->with('success', "Presensi RFID Berhasil! {$student->full_name} ({$student->nis}) tercatat HADIR.");
    }

    /**
     * Modul 3.2: Pengajuan Izin & Sakit Online
     */
    public function leaves()
    {
        $leaves = StudentLeave::with(['student', 'school'])->latest()->paginate(15);
        $students = Student::where('status', 'AKTIF')->get();

        return view('admin.attendance.leaves', compact('leaves', 'students'));
    }

    public function storeLeave(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'leave_type' => 'required|in:SAKIT,IZIN,DISPENSASI',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'reason' => 'required|string',
        ]);

        $student = Student::find($request->student_id);
        $validated['school_id'] = $student->school_id;
        $validated['status'] = 'APPROVED';

        StudentLeave::create($validated);

        return redirect()->back()->with('success', 'Pengajuan Izin Siswa Berhasil Disetujui!');
    }
}
