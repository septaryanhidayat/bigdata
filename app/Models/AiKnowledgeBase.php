<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiKnowledgeBase extends Model
{
    protected $table = 'ai_knowledge_bases';

    protected $fillable = [
        'title',
        'category',
        'source_type',
        'file_path',
        'file_name',
        'raw_content',
        'summary',
        'keywords',
        'is_active',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Search relevant knowledge base chunks matching a user's natural query
     */
    public static function findRelevantKnowledge(string $query, int $limit = 4): array
    {
        $queryWords = array_filter(
            preg_split('/[\s,\.\?\!\;\:\-]+/', strtolower(trim($query))),
            fn($w) => strlen($w) >= 3
        );

        if (empty($queryWords)) {
            return [];
        }

        $allDocs = static::where('is_active', true)->get();
        $scoredDocs = [];

        foreach ($allDocs as $doc) {
            $score = 0;
            $haystack = strtolower($doc->title . ' ' . $doc->category . ' ' . ($doc->summary ?? '') . ' ' . $doc->raw_content);
            $docKeywords = is_array($doc->keywords) ? array_map('strtolower', $doc->keywords) : [];

            foreach ($queryWords as $word) {
                // Exact word match in title gives high boost
                if (str_contains(strtolower($doc->title), $word)) {
                    $score += 15;
                }
                // Keyword match
                if (in_array($word, $docKeywords)) {
                    $score += 10;
                }
                // Word match in content
                $count = substr_count($haystack, $word);
                if ($count > 0) {
                    $score += min($count, 5) * 2;
                }
            }

            if ($score > 0) {
                $scoredDocs[] = [
                    'doc' => $doc,
                    'score' => $score,
                ];
            }
        }

        // Sort by score descending
        usort($scoredDocs, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_map(fn($item) => $item['doc'], array_slice($scoredDocs, 0, $limit));
    }
}
