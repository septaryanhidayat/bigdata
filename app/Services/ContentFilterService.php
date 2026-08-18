<?php

namespace App\Services;

class ContentFilterService
{
    /**
     * Prohibited keywords related to gambling, online loans, SARA, violence, pornography, LGBT, alcohol, drugs, etc.
     */
    protected static array $prohibitedKeywords = [
        'slot', 'judol', 'judi', 'maxwin', 'pragmatic', 'gacor', 'teragol', 'agen777', 'togel', 'poker',
        'casino', 'pinjol', 'pinjaman online', 'kredit kilat', 'sara', 'lgbt', 'gay', 'lesbian', 'transgender',
        'porn', 'porno', 'seks', 'sex', 'bokep', 'dewasa 18+', 'mesum', 'miras', 'alkohol', 'narkoba', 'sabu',
        'kekerasan', 'judi online', 'betting', 'zeus', 'olympus', 'sbobet', 'bandar bola', 'pola auto jp',
        'scatter', 'bocor pola', 'depo', 'wd', 'withdraw'
    ];

    /**
     * Check if text contains any prohibited content.
     */
    public static function isSafe(string ...$textSources): bool
    {
        $combinedText = strtolower(implode(' ', $textSources));

        foreach (self::$prohibitedKeywords as $keyword) {
            // Check substring or word boundary match
            if (str_contains($combinedText, $keyword)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Filter an array of items (posts, news, articles, comments, galleries)
     */
    public static function filterCollection(array $items, array $fieldsToCheck = ['title', 'content', 'excerpt', 'category']): array
    {
        return array_values(array_filter($items, function ($item) use ($fieldsToCheck) {
            if (!is_array($item)) return true;

            $texts = [];
            foreach ($fieldsToCheck as $field) {
                if (isset($item[$field]) && is_string($item[$field])) {
                    $texts[] = $item[$field];
                }
            }

            return self::isSafe(...$texts);
        }));
    }
}
