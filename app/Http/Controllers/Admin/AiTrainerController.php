<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiKnowledgeBase;
use App\Services\AiRagEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AiTrainerController extends Controller
{
    // ─── Main Page ──────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $search    = $request->get('search', '');
        $category  = $request->get('category', '');
        $perPage   = 20;

        $query = AiKnowledgeBase::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }
        if ($category) {
            $query->where('category', $category);
        }

        $knowledgeBases = $query->paginate($perPage)->withQueryString();

        // Stats
        $totalDocs        = AiKnowledgeBase::count();
        $activeDocs       = AiKnowledgeBase::where('is_active', true)->count();
        $websiteDataCount = AiKnowledgeBase::where('source_type', 'website_data')->count();
        $uploadedCount    = AiKnowledgeBase::whereNotIn('source_type', ['website_data', 'text'])->count();
        $totalWords       = AiKnowledgeBase::sum('word_count');
        $lastSync         = AiKnowledgeBase::where('source_type', 'website_data')
                                           ->latest('processed_at')
                                           ->value('processed_at');

        $categories = [
            'spmb'         => 'SPMB / Pendaftaran',
            'akademik'     => 'Akademik & Kurikulum',
            'keuangan'     => 'Keuangan & SPP',
            'sop'          => 'SOP & Tata Tertib',
            'program'      => 'Program Unggulan',
            'fasilitas'    => 'Fasilitas Sekolah',
            'prestasi'     => 'Prestasi Siswa',
            'website_data' => 'Data Website (Auto)',
            'umum'         => 'Informasi Umum',
        ];

        $categoryStats = AiKnowledgeBase::selectRaw('category, count(*) as total')
                                         ->groupBy('category')
                                         ->pluck('total', 'category');

        return view('admin.ai_trainer.index', compact(
            'knowledgeBases', 'totalDocs', 'activeDocs',
            'websiteDataCount', 'uploadedCount', 'totalWords',
            'lastSync', 'categories', 'categoryStats', 'search', 'category'
        ));
    }

    // ─── Upload File ────────────────────────────────────────────────────────

    public function upload(Request $request)
    {
        $request->validate([
            'file'     => 'required|file|max:20480|mimes:pdf,doc,docx,xls,xlsx,txt',
            'category' => 'required|string|max:50',
            'title'    => 'nullable|string|max:255',
        ]);

        $file     = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $ext      = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();
        $title    = $request->filled('title')
            ? $request->title
            : pathinfo($fileName, PATHINFO_FILENAME);

        // Store file in storage/app/public/ai-knowledge
        $storedPath = $file->store('ai-knowledge', 'public');
        $fullPath   = storage_path('app/public/' . $storedPath);

        // Extract raw text
        $extractedText = AiRagEngine::extractText($fullPath, $ext);

        if (empty(trim($extractedText))) {
            return back()->with('error', "Gagal mengekstrak teks dari file '{$fileName}'. Pastikan file tidak terkunci password atau berupa scan gambar.");
        }

        // Ingest into knowledge base
        AiRagEngine::ingestDocument(
            title:      $title,
            category:   $request->category,
            rawText:    $extractedText,
            sourceType: strtolower($ext),
            filePath:   $storedPath,
            fileName:   $fileName,
            fileType:   $ext,
            fileSize:   $fileSize,
            uploadedBy: Auth::user()?->name ?? 'Admin',
        );

        return back()->with('success', "✅ Dokumen '{$title}' berhasil diupload & diproses ke dalam Knowledge Base AI.");
    }

    // ─── Manual Input ───────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:50',
            'content'  => 'required|string|min:10',
        ]);

        AiRagEngine::ingestDocument(
            title:      $request->title,
            category:   $request->category,
            rawText:    $request->content,
            sourceType: 'text',
            uploadedBy: Auth::user()?->name ?? 'Admin',
        );

        return back()->with('success', "✅ Pengetahuan '{$request->title}' berhasil disimpan ke Knowledge Base AI.");
    }

    // ─── Delete ─────────────────────────────────────────────────────────────

    public function destroy(Request $request, int $id)
    {
        $kb = AiKnowledgeBase::findOrFail($id);

        if ($kb->file_path) {
            Storage::disk('public')->delete($kb->file_path);
        }

        $title = $kb->title;
        $kb->delete();

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "🗑️ Dokumen '{$title}' berhasil dihapus dari Knowledge Base."
            ]);
        }

        return back()->with('success', "🗑️ Dokumen '{$title}' berhasil dihapus dari Knowledge Base.");
    }

    // ─── Bulk Delete ────────────────────────────────────────────────────────

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer']);

        $kbs = AiKnowledgeBase::whereIn('id', $request->ids)->get();
        $count = 0;

        foreach ($kbs as $kb) {
            if ($kb->file_path) {
                Storage::disk('public')->delete($kb->file_path);
            }
            $kb->delete();
            $count++;
        }

        return response()->json(['success' => true, 'message' => "✅ {$count} dokumen berhasil dihapus."]);
    }

    // ─── Toggle Active ───────────────────────────────────────────────────────

    public function toggle(int $id)
    {
        $kb            = AiKnowledgeBase::findOrFail($id);
        $kb->is_active = !$kb->is_active;
        $kb->save();

        $status = $kb->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return response()->json([
            'success'   => true,
            'is_active' => $kb->is_active,
            'message'   => "Dokumen '{$kb->title}' berhasil {$status}.",
        ]);
    }

    // ─── Auto-Sync Website Data ──────────────────────────────────────────────

    public function autoSync()
    {
        try {
            $synced = AiRagEngine::autoSyncWebsiteData();
            $total  = array_sum($synced);

            return response()->json([
                'success' => true,
                'message' => "✅ Auto-sync selesai! {$total} data berhasil disinkronisasi ke Knowledge Base AI.",
                'details' => [
                    "🗞️ Berita: {$synced['news']} item",
                    "📝 Artikel: {$synced['articles']} item",
                    "❓ FAQ: {$synced['faq']} item",
                    "🏫 Profil Unit: {$synced['profiles']} unit",
                    "⚙️ Pengaturan & Kontak: {$synced['settings']} item",
                ],
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal auto-sync: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─── Test Chat ───────────────────────────────────────────────────────────

    public function testChat(Request $request)
    {
        $request->validate(['message' => 'required|string|max:500']);

        try {
            $answer = AiRagEngine::answer($request->get('message'));
            return response()->json(['success' => true, 'answer' => $answer]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'answer'  => 'Terjadi error saat memproses pertanyaan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
