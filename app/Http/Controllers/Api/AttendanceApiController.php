<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceApiController extends Controller
{
    /**
     * Tap RFID Gate / Scanner Terminal Endpoint
     */
    public function tapRfid(Request $request)
    {
        $request->validate([
            'rfid_tag' => 'required|string',
        ]);

        $student = Student::where('rfid_tag', $request->rfid_tag)->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Kartu RFID tidak terdaftar dalam sistem Siakad!',
            ], 404);
        }

        $today = date('Y-m-d');
        $nowTime = date('H:i:s');

        $attendance = Attendance::firstOrCreate(
            [
                'student_id' => $student->id,
                'date' => $today,
            ],
            [
                'school_id' => $student->school_id,
                'time_in' => $nowTime,
                'status' => ($nowTime > '07:15:00') ? 'TERLAMBAT' : 'HADIR',
                'method' => 'RFID_GATE',
                'notes' => 'Tap RFID Gate Sekolah',
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Presensi berhasil dicatat!',
            'data' => [
                'student_name' => $student->full_name,
                'nis' => $student->nis,
                'school' => $student->school->name ?? '-',
                'status' => $attendance->status,
                'time_in' => $attendance->time_in,
            ]
        ]);
    }
}
