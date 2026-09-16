<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BkRecord;
use App\Models\Student;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BkController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $studentsQuery = Student::with(['school', 'classroom']);

        if ($schoolId) {
            $studentsQuery->where('school_id', $schoolId);
        }

        $students = $studentsQuery->get();
        
        $recordsQuery = BkRecord::with('student.school', 'student.classroom');
        if ($schoolId) {
            $recordsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $records = $recordsQuery->latest()->take(25)->get();

        return view('admin.bk.index', compact('records', 'students', 'schoolId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:VIOLATION,ACHIEVEMENT',
            'title' => 'required|string',
            'points' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Siswa ini bukan dari unit sekolah Anda.');
        }

        $validated['date'] = now()->toDateString();
        $bk = BkRecord::create($validated);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'CATATAN BK (' . $request->type . ')',
                'model_type' => 'BkRecord',
                'model_id' => $bk->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Record Catatan BK Siswa Berhasil Disimpan!');
    }

    public function destroy($id)
    {
        $record = BkRecord::with('student')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $record->student && $record->student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus catatan BK unit ini.');
        }

        $record->delete();
        return redirect()->back()->with('success', '✓ Catatan BK berhasil dihapus.');
    }
}
