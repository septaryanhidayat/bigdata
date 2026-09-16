<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BpiMutabaah;
use App\Models\Student;
use App\Models\School;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class BpiController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $studentsQuery = Student::with(['school', 'classroom']);

        if ($schoolId) {
            $studentsQuery->where('school_id', $schoolId);
        }

        $students = $studentsQuery->take(25)->get();

        $mutabaahLogsQuery = BpiMutabaah::with(['student.school', 'student.classroom']);
        if ($schoolId) {
            $mutabaahLogsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $mutabaahLogs = $mutabaahLogsQuery->latest()->take(25)->get();

        return view('admin.bpi.index', compact('students', 'mutabaahLogs', 'schoolId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'tilawah_juz' => 'nullable|string|max:100',
            'hafalan_surah' => 'nullable|string|max:100',
            'infaq_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $student = Student::findOrFail($request->student_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Siswa ini bukan dari unit sekolah Anda.');
        }

        $bpi = BpiMutabaah::create([
            'student_id' => $request->student_id,
            'date' => $request->date,
            'sholat_subuh' => $request->boolean('sholat_subuh'),
            'sholat_zhuhur' => $request->boolean('sholat_zhuhur'),
            'sholat_ashar' => $request->boolean('sholat_ashar'),
            'sholat_maghrib' => $request->boolean('sholat_maghrib'),
            'sholat_isya' => $request->boolean('sholat_isya'),
            'dhuha' => $request->boolean('dhuha'),
            'tahajud' => $request->boolean('tahajud'),
            'tilawah_juz' => $request->tilawah_juz ?: null,
            'hafalan_surah' => $request->hafalan_surah ?: null,
            'al_mathurat' => $request->boolean('al_mathurat'),
            'infaq_amount' => $request->infaq_amount ? (float) $request->infaq_amount : 0,
            'notes' => $request->notes ?: null,
            'verified_by_parent' => true,
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'CATAT MUTABAAH BPI',
                'model_type' => 'BpiMutabaah',
                'model_id' => $bpi->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Catatan Mutaba\'ah BPI berhasil disimpan!');
    }

    public function destroy($id)
    {
        $bpi = BpiMutabaah::with('student')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $bpi->student && $bpi->student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus catatan BPI unit ini.');
        }

        $bpi->delete();
        return redirect()->back()->with('success', '✓ Catatan Mutaba\'ah BPI berhasil dihapus.');
    }
}
