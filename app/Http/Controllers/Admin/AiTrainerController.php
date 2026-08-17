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
        $totalDocs      = AiKnowledgeBase::count();
        $activeDocs     = AiKnowledgeBase::where('is_active', true)->count();
        $websiteDataCount = AiKnowledgeBase::where('source_type', 'website_data')->count();
        $uploadedCount  = AiKnowledgeBase::whereNotIn('source_type', ['website_data', 'text'])->count();
        $totalWords     = AiKnowledgeBase::sum('word_count');
        $lastSync       = AiKnowledgeBase::where('source_type', 'website_data')
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
            'file'     => 'required|file|mimes:pdf,doc,docx,xls,xlsx,txt|max:20480',
            'title'    => 'nullable|string|max:255',
            'category' => 'required|string|in:spmb,akademik,keuangan,sop,program,fasilitas,prestasi,umum',
        ], [
            'file.mimes' => 'Format file yang didukung: PDF, Word (.docx), Excel (.xlsx), TXT.',
            'file.max'   => 'Ukuran file maksimal 20 MB.',
        ]);

        $file      = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileName  = $file->getClientOriginalName();
        $fileSize  = $file->getSize();
        $title     = $request->get('title') ?: pathinfo($fileName, PATHINFO_FILENAME);
        $title     = str_replace(['_', '-'], ' ', $title);

        // Store file in ai_knowledge directory
        $storedPath = $file->store('ai_knowledge', 'public');
        $fullPath   = storage_path('app/public/' . $storedPath);

        // Extract text
        $rawText = AiRagEngine::extractTextFromFile($fullPath, $extension);

        if (empty(trim($rawText)) || strlen(trim($rawText)) < 20) {
            // Cleanup stored file
            Storage::disk('public')->delete($storedPath);
            return back()->with('error', "Gagal mengekstrak teks dari file '{$fileName}'. Pastikan file tidak terenkripsi/password-protected.");
        }

        // Ingest into knowledge base
        AiRagEngine::ingestDocument(
            title:      $title,
            category:   $request->get('category'),
            rawText:    $rawText,
            filePath:   $storedPath,
            fileName:   $fileName,
            fileType:   $extension,
            fileSize:   $fileSize,
            uploadedBy: Auth::user()->name ?? Auth::user()->email,
            sourceType: $extension,
        );

        return back()->with('success', "✅ File '{$fileName}' berhasil diproses dan ditambahkan ke Knowledge Base AI!");
    }

    // ─── Manual Text Input ──────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|in:spmb,akademik,keuangan,sop,program,fasilitas,prestasi,umum',
            'content'  => 'required|string|min:30',
        ]);

        AiRagEngine::ingestDocument(
            title:      $request->get('title'),
            category:   $request->get('category'),
            rawText:    $request->get('content'),
            uploadedBy: Auth::user()->name ?? Auth::user()->email,
            sourceType: 'text',
        );

        return back()->with('success', "✅ Pengetahuan '{$request->title}' berhasil ditambahkan ke Knowledge Base AI!");
    }

    // ─── Delete ─────────────────────────────────────────────────────────────

    public function destroy(int $id)
    {
        $kb = AiKnowledgeBase::findOrFail($id);

        // Delete physical file if exists
        if ($kb->file_path) {
            Storage::disk('public')->delete($kb->file_path);
        }

        $kb->delete();

        return back()->with('success', "🗑️ Dokumen '{$kb->title}' berhasil dihapus dari Knowledge Base.");
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
