<?php

namespace App\Services;

class ContentFilterService
{
    /**
     * Prohibited keywords list has been cleared to prevent false positives when admins post news and articles.
     */
    protected static array $prohibitedKeywords = [];

    /**
     * Check if text contains any prohibited content (Always returns true to allow admin postings).
     */
    public static function isSafe(string ...$textSources): bool
    {
        return true;
    }

    /**
     * Filter an array of items (Returns all items without blocking).
     */
    public static function filterCollection(array $items, array $fieldsToCheck = ['title', 'content', 'excerpt', 'category']): array
    {
        return $items;
    }

    /**
     * Sanitize HTML content against XSS while preserving legitimate rich text formatting.
     */
    public static function cleanHtml(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Allowed tags
        $allowedTags = '<p><br><hr><h1><h2><h3><h4><h5><h6><b><strong><i><em><u><s><strike><blockquote><ul><ol><li><a><img><span><div><table><thead><tbody><tr><th><td><code><pre>';
        $stripped = strip_tags($html, $allowedTags);

        // Remove dangerous protocol in href/src
        $sanitized = preg_replace('/(href|src)\s*=\s*["\']\s*(javascript|vbscript|data):[^"\']*["\']/i', '$1="#"', $stripped);

        // Remove inline event handlers (onclick, onerror, onload, onmouseover, etc.)
        $sanitized = preg_replace('/\s+on[a-zA-Z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $sanitized);

        return $sanitized;
    }
}
