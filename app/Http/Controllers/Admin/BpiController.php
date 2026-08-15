<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BpiMutabaah;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;

class BpiController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $studentsQuery = Student::with(['school', 'classroom']);

        if ($schoolId !== 'all') {
            $studentsQuery->where('school_id', $schoolId);
        }

        $students = $studentsQuery->take(20)->get();

        $mutabaahLogsQuery = BpiMutabaah::with('student.school');
        if ($schoolId !== 'all') {
            $mutabaahLogsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }
        $mutabaahLogs = $mutabaahLogsQuery->latest()->take(10)->get();

        if ($mutabaahLogs->isEmpty() && $students->isNotEmpty()) {
            foreach ($students->take(5) as $st) {
                BpiMutabaah::create([
                    'student_id' => $st->id,
                    'date' => now()->toDateString(),
                    'sholat_subuh' => true,
                    'sholat_zhuhur' => true,
                    'sholat_ashar' => true,
                    'sholat_maghrib' => true,
                    'sholat_isya' => true,
                    'dhuha' => true,
                    'tahajud' => false,
                    'tilawah_juz' => 'Juz 30 (Surah An-Naba)',
                    'hafalan_surah' => 'Surah Al-Mulk ayat 1-15',
                    'al_mathurat' => true,
                    'infaq_amount' => 5000,
                    'notes' => 'Sangat rajin dan istiqomah tilawah Al-Qur\'an',
                    'verified_by_parent' => true,
                ]);
            }
            $mutabaahLogs = BpiMutabaah::with('student.school')->latest()->take(10)->get();
        }

        return view('admin.bpi.index', compact('students', 'mutabaahLogs', 'schoolId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'tilawah_juz' => 'nullable|string',
            'hafalan_surah' => 'nullable|string',
            'infaq_amount' => 'nullable|numeric',
        ]);

        BpiMutabaah::create([
            'student_id' => $request->student_id,
            'date' => $request->date,
            'sholat_subuh' => $request->has('sholat_subuh'),
            'sholat_zhuhur' => $request->has('sholat_zhuhur'),
            'sholat_ashar' => $request->has('sholat_ashar'),
            'sholat_maghrib' => $request->has('sholat_maghrib'),
            'sholat_isya' => $request->has('sholat_isya'),
            'dhuha' => $request->has('dhuha'),
            'tahajud' => $request->has('tahajud'),
            'tilawah_juz' => $request->tilawah_juz ?? 'Juz 30',
            'hafalan_surah' => $request->hafalan_surah ?? 'Surah Al-Mulk',
            'al_mathurat' => $request->has('al_mathurat'),
            'infaq_amount' => $request->infaq_amount ?? 5000,
            'notes' => $request->notes ?? 'Amal yaumiyah terisi lengkap',
            'verified_by_parent' => true,
        ]);

        return redirect()->back()->with('success', '✓ Catatan Mutaba\'ah BPI berhasil ditambahkan!');
    }
}
