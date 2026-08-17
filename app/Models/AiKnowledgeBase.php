<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AiKnowledgeBase extends Model
{
    protected $table = 'ai_knowledge_bases';

    protected $fillable = [
        'title',
        'category',
        'source_type',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'word_count',
        'chunk_count',
        'processed_at',
        'uploaded_by',
        'raw_content',
        'summary',
        'keywords',
        'is_active',
    ];

    protected $casts = [
        'keywords'     => 'array',
        'is_active'    => 'boolean',
        'processed_at' => 'datetime',
    ];

    // ─── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeWebsiteData($query)
    {
        return $query->where('source_type', 'website_data');
    }

    public function scopeUploadedFiles($query)
    {
        return $query->whereNotIn('source_type', ['website_data', 'text']);
    }

    // ─── Accessors ──────────────────────────────────────────────────────────

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes < 1024)       return "{$bytes} B";
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 2) . ' MB';
    }

    public function getCategoryLabelAttribute(): string
    {
        $labels = [
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
        return $labels[$this->category] ?? ucfirst($this->category);
    }

    public function getCategoryColorAttribute(): string
    {
        $colors = [
            'spmb'         => 'bg-emerald-100 text-emerald-800',
            'akademik'     => 'bg-blue-100 text-blue-800',
            'keuangan'     => 'bg-amber-100 text-amber-800',
            'sop'          => 'bg-red-100 text-red-800',
            'program'      => 'bg-purple-100 text-purple-800',
            'fasilitas'    => 'bg-cyan-100 text-cyan-800',
            'prestasi'     => 'bg-orange-100 text-orange-800',
            'website_data' => 'bg-slate-100 text-slate-700',
            'umum'         => 'bg-gray-100 text-gray-700',
        ];
        return $colors[$this->category] ?? 'bg-gray-100 text-gray-700';
    }

    /**
     * Search relevant knowledge base chunks matching a user's natural query.
     */
    public static function findRelevantKnowledge(string $query, int $limit = 5): array
    {
        $queryWords = array_filter(
            preg_split('/[\s,\.?\!;\:\-]+/', strtolower(trim($query))),
            fn($w) => strlen($w) >= 3
        );

        if (empty($queryWords)) {
            return [];
        }

        $allDocs = static::where('is_active', true)->get();
        $scoredDocs = [];

        foreach ($allDocs as $doc) {
            $score = 0;
            $haystack = strtolower(
                $doc->title . ' ' . $doc->category . ' ' .
                ($doc->summary ?? '') . ' ' . $doc->raw_content
            );
            $docKeywords = is_array($doc->keywords)
                ? array_map('strtolower', $doc->keywords)
                : [];

            foreach ($queryWords as $word) {
                if (str_contains(strtolower($doc->title), $word)) {
                    $score += 15;
                }
                if (in_array($word, $docKeywords)) {
                    $score += 10;
                }
                $count = substr_count($haystack, $word);
                if ($count > 0) {
                    $score += min($count, 5) * 2;
                }
            }

            if ($score > 0) {
                $scoredDocs[] = ['doc' => $doc, 'score' => $score];
            }
        }

        usort($scoredDocs, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_map(fn($item) => $item['doc'], array_slice($scoredDocs, 0, $limit));
    }
}
