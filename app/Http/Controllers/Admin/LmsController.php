<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LmsMaterial;
use App\Models\School;
use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $materialsQuery = LmsMaterial::with('school');

        if ($schoolId !== 'all') {
            $materialsQuery->where('school_id', $schoolId);
        }

        $materials = $materialsQuery->latest()->get();

        if ($materials->isEmpty()) {
            $samples = [
                ['subject' => 'Pendidikan Agama Islam (PAI)', 'title' => 'Modul 01: Adab & Akhlak Penuntut Ilmu', 'type' => 'PDF', 'desc' => 'Materi E-Book PDF Pembelajaran PAI Kelas 7'],
                ['subject' => 'Matematika Terpadu', 'title' => 'Video Pembelajaran: Persamaan Kuadrat & Matriks', 'type' => 'VIDEO', 'desc' => 'Video Tutorial Interaktif KBM Matematika'],
                ['subject' => 'IPA Terpadu & Fisika', 'title' => 'Tugas Mandiri: Analisis Hukum Newton & Gravitasi', 'type' => 'ASSIGNMENT', 'desc' => 'Pengumpulan lembar kerja siswa'],
            ];

            foreach ($samples as $m) {
                LmsMaterial::create([
                    'school_id' => ($schoolId !== 'all') ? $schoolId : School::first()?->id,
                    'subject_name' => $m['subject'],
                    'title' => $m['title'],
                    'description' => $m['desc'],
                    'type' => $m['type'],
                    'file_url' => 'https://sitrobbani.sch.id/lms/materials/sample.pdf',
                ]);
            }
            $materials = LmsMaterial::with('school')->latest()->get();
        }

        return view('admin.lms.index', compact('materials', 'schoolId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string',
            'title' => 'required|string',
            'type' => 'required|in:PDF,VIDEO,ASSIGNMENT',
            'description' => 'nullable|string',
        ]);

        $schoolId = session('dashboard_school_id', 'all');
        $validated['school_id'] = ($schoolId !== 'all') ? $schoolId : School::first()?->id;
        $validated['file_url'] = 'https://sitrobbani.sch.id/lms/materials/sample.pdf';

        $mat = LmsMaterial::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'UPLOAD MATERI LMS',
                'model_type' => 'LmsMaterial',
                'model_id' => $mat->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Materi E-Learning LMS Baru Berhasil Diunggah!');
    }
}
