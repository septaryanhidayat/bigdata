<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LmsMaterial;
use App\Models\School;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class LmsController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $materialsQuery = LmsMaterial::with('school');

        if ($schoolId) {
            $materialsQuery->where('school_id', $schoolId);
        }

        $materials = $materialsQuery->latest()->get();

        return view('admin.lms.index', compact('materials', 'schoolId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'type' => 'required|in:PDF,VIDEO,ASSIGNMENT',
            'description' => 'nullable|string',
            'material_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,mp4,zip|max:30720',
            'external_url' => 'nullable|url|max:500',
        ]);

        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $targetSchoolId = $schoolId ?: ($request->school_id ?? School::first()?->id ?? 1);

        $fileUrl = $request->external_url;
        if ($request->hasFile('material_file')) {
            $path = $request->file('material_file')->store('lms_materials', 'public');
            $fileUrl = '/storage/' . $path;
        }

        $mat = LmsMaterial::create([
            'school_id' => $targetSchoolId,
            'subject_name' => $validated['subject_name'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'file_url' => $fileUrl ?: '#',
        ]);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'UPLOAD MATERI LMS',
                'model_type' => 'LmsMaterial',
                'model_id' => $mat->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Materi E-Learning LMS Baru Berhasil Diunggah!');
    }

    public function destroy($id)
    {
        $material = LmsMaterial::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $material->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus materi e-learning unit ini.');
        }

        $material->delete();
        return redirect()->back()->with('success', '✓ Materi e-learning berhasil dihapus.');
    }
}
