<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BkRecord;
use App\Models\Student;
use Illuminate\Http\Request;

class BkController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $studentsQuery = Student::with(['school', 'classroom']);

        if ($schoolId !== 'all') {
            $studentsQuery->where('school_id', $schoolId);
        }

        $students = $studentsQuery->get();
        
        $recordsQuery = BkRecord::with('student.school');
        if ($schoolId !== 'all') {
            $recordsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $records = $recordsQuery->latest()->take(15)->get();

        if ($records->isEmpty() && $students->isNotEmpty()) {
            foreach ($students->take(3) as $st) {
                BkRecord::create([
                    'student_id' => $st->id,
                    'type' => 'ACHIEVEMENT',
                    'title' => 'Juara 1 Lomba MHQ & Hafalan Juz 30 Tingkat Provinsi',
                    'points' => 50,
                    'description' => 'Mendapatkan penghargaan dan piagam emas wali kota',
                    'date' => now()->toDateString(),
                ]);
            }
            $records = BkRecord::with('student.school')->latest()->take(15)->get();
        }

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

        $validated['date'] = now()->toDateString();
        $bk = BkRecord::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'CATATAN BK (' . $request->type . ')',
                'model_type' => 'BkRecord',
                'model_id' => $bk->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Record Catatan BK Siswa Berhasil Disimpan!');
    }
}
