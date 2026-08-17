<?php

namespace App\Services;

use App\Models\AiKnowledgeBase;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\PpdbRegistration;
use App\Models\SiteSetting;
use App\Models\FaqItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiRagEngine
{
    // =========================================================================
    // FILE TEXT EXTRACTORS
    // =========================================================================

    /**
     * Extract plain text from a PDF file
     */
    public static function extractTextFromPdf(string $filePath): string
    {
        if (!file_exists($filePath)) {
            return '';
        }

        $content = @file_get_contents($filePath);
        if (!$content) {
            return '';
        }

        $text = '';

        if (preg_match_all('/BT[\s\S]*?ET/m', $content, $matches)) {
            foreach ($matches[0] as $block) {
                if (preg_match_all('/\((.*?)\)\s*T[jJ]/s', $block, $strMatches)) {
                    $text .= implode(' ', $strMatches[1]) . "\n";
                } elseif (preg_match_all('/\[(.*?)\]\s*TJ/s', $block, $tjMatches)) {
                    foreach ($tjMatches[1] as $tj) {
                        if (preg_match_all('/\((.*?)\)/s', $tj, $innerMatches)) {
                            $text .= implode('', $innerMatches[1]) . ' ';
                        }
                    }
                    $text .= "\n";
                }
            }
        }

        if (strlen(trim($text)) < 50) {
            preg_match_all('/[\x20-\x7E\r\n\t]{4,}/', $content, $asciiMatches);
            $rawStrings = implode(' ', $asciiMatches[0] ?? []);
            $cleaned = preg_replace('/(\/[A-Za-z0-9_\-\.]+|\bobj\b|\bendobj\b|\bstream\b|\bendstream\b|\bxref\b|\btrailer\b)/i', ' ', $rawStrings);
            $text = preg_replace('/\s+/', ' ', $cleaned);
        }

        return trim($text);
    }

    /**
     * Extract plain text from a Word .docx file (via ZIP + XML parsing)
     */
    public static function extractTextFromWord(string $filePath): string
    {
        if (!file_exists($filePath) || !class_exists('ZipArchive')) {
            return '';
        }

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return '';
        }

        $text = '';

        // word/document.xml is the main content file in .docx
        $xmlContent = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xmlContent) {
            return '';
        }

        // Strip XML tags, decode entities, clean whitespace
        $xmlContent = preg_replace('/<w:br[^>]*\/>/', "\n", $xmlContent);
        $xmlContent = preg_replace('/<\/w:p>/', "\n", $xmlContent);
        $xmlContent = preg_replace('/<[^>]+>/', '', $xmlContent);
        $text = html_entity_decode($xmlContent, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    /**
     * Extract plain text from an Excel .xlsx file (via ZIP + XML parsing)
     */
    public static function extractTextFromExcel(string $filePath): string
    {
        if (!file_exists($filePath) || !class_exists('ZipArchive')) {
            return '';
        }

        $zip = new \ZipArchive();
        if ($zip->open($filePath) !== true) {
            return '';
        }

        // Extract shared strings (cell values are stored by index reference)
        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml) {
            preg_match_all('/<si>.*?<\/si>/s', $sharedXml, $siMatches);
            foreach ($siMatches[0] as $si) {
                preg_match_all('/<t(?:\s[^>]*)?>([^<]*)<\/t>/', $si, $tMatches);
                $sharedStrings[] = implode('', $tMatches[1]);
            }
        }

        // Extract data from all sheets
        $textRows = [];
        for ($sheet = 1; $sheet <= 20; $sheet++) {
            $sheetXml = $zip->getFromName("xl/worksheets/sheet{$sheet}.xml");
            if (!$sheetXml) {
                break;
            }

            preg_match_all('/<row[^>]*>(.*?)<\/row>/s', $sheetXml, $rowMatches);
            foreach ($rowMatches[1] as $row) {
                $cells = [];
                preg_match_all('/<c[^>]*>(.*?)<\/c>/s', $row, $cellMatches);
                foreach ($cellMatches[0] as $cell) {
                    // Check if cell is a shared string (type t="s")
                    if (preg_match('/t="s"/', $cell)) {
                        preg_match('/<v>(\d+)<\/v>/', $cell, $vMatch);
                        $idx = (int)($vMatch[1] ?? -1);
                        $cells[] = $sharedStrings[$idx] ?? '';
                    } else {
                        preg_match('/<v>([^<]*)<\/v>/', $cell, $vMatch);
                        $cells[] = $vMatch[1] ?? '';
                    }
                }
                $rowText = implode(' | ', array_filter($cells, fn($c) => trim($c) !== ''));
                if (!empty($rowText)) {
                    $textRows[] = $rowText;
                }
            }
        }

        $zip->close();

        return trim(implode("\n", $textRows));
    }

    /**
     * Extract text from any supported file based on extension
     */
    public static function extractTextFromFile(string $filePath, string $extension): string
    {
        $ext = strtolower(ltrim($extension, '.'));
        return match ($ext) {
            'pdf'        => self::extractTextFromPdf($filePath),
            'docx', 'doc' => self::extractTextFromWord($filePath),
            'xlsx', 'xls' => self::extractTextFromExcel($filePath),
            'txt'        => @file_get_contents($filePath) ?: '',
            default      => '',
        };
    }

    // =========================================================================
    // INGESTION
    // =========================================================================

    /**
     * Ingest a document into the AI Knowledge Base with keyword generation
     */
    public static function ingestDocument(
        string $title,
        string $category,
        string $rawText,
        ?string $filePath = null,
        ?string $fileName = null,
        ?string $fileType = null,
        ?int $fileSize = null,
        ?string $uploadedBy = null,
        string $sourceType = 'text'
    ): AiKnowledgeBase {
        $words = preg_split('/[\s,\.?\!;\:\(\)\[\]\"\'\/\-]+/', strtolower($rawText));
        $stopwords = [
            'dan', 'yang', 'di', 'ke', 'dari', 'ini', 'itu', 'untuk', 'pada', 'adalah',
            'sebagai', 'dengan', 'atau', 'akan', 'oleh', 'karena', 'saat', 'para', 'bisa',
            'dapat', 'juga', 'kami', 'kita', 'saya', 'anda', 'mereka', 'the', 'and', 'for',
            'with', 'from', 'dalam', 'bahwa', 'telah', 'sudah', 'tidak', 'ada', 'bagi',
            'sekolah', 'robbani', 'siswa', 'guru',
        ];
        $frequency = [];

        foreach ($words as $w) {
            $w = trim($w);
            if (strlen($w) >= 3 && !in_array($w, $stopwords) && !is_numeric($w)) {
                $frequency[$w] = ($frequency[$w] ?? 0) + 1;
            }
        }

        arsort($frequency);
        $topKeywords = array_slice(array_keys($frequency), 0, 20);
        $wordCount   = str_word_count(strip_tags($rawText));

        return AiKnowledgeBase::create([
            'title'        => $title,
            'category'     => $category,
            'source_type'  => $sourceType,
            'file_path'    => $filePath,
            'file_name'    => $fileName,
            'file_type'    => $fileType,
            'file_size'    => $fileSize,
            'word_count'   => $wordCount,
            'chunk_count'  => 1,
            'processed_at' => now(),
            'uploaded_by'  => $uploadedBy,
            'raw_content'  => $rawText,
            'summary'      => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($rawText))), 300),
            'keywords'     => $topKeywords,
            'is_active'    => true,
        ]);
    }

    // =========================================================================
    // AUTO-SYNC WEBSITE DATA TO KNOWLEDGE BASE
    // =========================================================================

    /**
     * Auto-sync all website data (news, articles, FAQ, profiles) into the AI KB.
     * Deletes old website_data entries before re-syncing to keep data fresh.
     * Returns count of items synced.
     */
    public static function autoSyncWebsiteData(): array
    {
        $synced = ['news' => 0, 'articles' => 0, 'faq' => 0, 'profiles' => 0, 'settings' => 0];

        // 1. Remove all existing auto-synced website data
        AiKnowledgeBase::where('source_type', 'website_data')->delete();

        // 2. Sync Berita (News)
        $cmsNewsJson = SiteSetting::get('cms_news_data');
        if ($cmsNewsJson) {
            $newsItems = json_decode($cmsNewsJson, true) ?: [];
            foreach (array_slice($newsItems, 0, 100) as $item) {
                $text  = "BERITA: {$item['title']}\n";
                $text .= "Kategori: " . ($item['category'] ?? 'Umum') . "\n";
                $text .= "Unit: " . ($item['unit'] ?? '-') . "\n";
                $text .= "Tanggal: " . ($item['date'] ?? '') . "\n\n";
                $text .= strip_tags($item['excerpt'] ?? $item['content'] ?? '');

                self::ingestDocument(
                    title:      "Berita: " . Str::limit($item['title'], 100),
                    category:   'website_data',
                    rawText:    $text,
                    sourceType: 'website_data',
                    uploadedBy: 'System Auto-Sync',
                );
                $synced['news']++;
            }
        }

        // 3. Sync Artikel
        $cmsArticleJson = SiteSetting::get('cms_article_data');
        if ($cmsArticleJson) {
            $articles = json_decode($cmsArticleJson, true) ?: [];
            foreach (array_slice($articles, 0, 80) as $item) {
                $text  = "ARTIKEL: {$item['title']}\n";
                $text .= "Kategori: " . ($item['category'] ?? 'Umum') . "\n";
                $text .= "Tanggal: " . ($item['date'] ?? '') . "\n\n";
                $text .= strip_tags($item['excerpt'] ?? $item['content'] ?? '');

                self::ingestDocument(
                    title:      "Artikel: " . Str::limit($item['title'], 100),
                    category:   'website_data',
                    rawText:    $text,
                    sourceType: 'website_data',
                    uploadedBy: 'System Auto-Sync',
                );
                $synced['articles']++;
            }
        }

        // 4. Sync FAQ
        $faqs = FaqItem::where('is_active', true)->get();
        foreach ($faqs as $faq) {
            $text  = "PERTANYAAN UMUM (FAQ): {$faq->question}\n\nJAWABAN:\n{$faq->answer}";
            self::ingestDocument(
                title:      "FAQ: " . Str::limit($faq->question, 100),
                category:   'umum',
                rawText:    $text,
                sourceType: 'website_data',
                uploadedBy: 'System Auto-Sync',
            );
            $synced['faq']++;
        }

        // 5. Sync Unit Profiles
        $unitKeys = ['unit_profile_tkit', 'unit_profile_sdit', 'unit_profile_smpit', 'unit_profile_smait'];
        $unitNames = ['KB/TKIT Robbani', 'SDIT Robbani', 'SMPIT Robbani', 'SMAIT Robbani'];
        foreach ($unitKeys as $idx => $key) {
            $profileJson = SiteSetting::get($key);
            if ($profileJson) {
                $p = json_decode($profileJson, true) ?: [];
                $text  = "PROFIL UNIT: {$unitNames[$idx]}\n";
                $text .= "Kepala Sekolah: " . ($p['principal_name'] ?? '-') . "\n";
                $text .= "Jabatan: " . ($p['principal_title'] ?? '-') . "\n";
                $text .= "Akreditasi: " . ($p['akreditasi'] ?? '-') . "\n";
                $text .= "Visi: " . ($p['vision'] ?? '-') . "\n";
                $text .= "Misi: " . ($p['mission'] ?? '-') . "\n";
                $text .= "Tagline: " . ($p['tagline'] ?? '-') . "\n";
                $text .= "Prestasi: " . ($p['achievements'] ?? '-') . "\n";
                $text .= "Program Unggulan: " . ($p['programs'] ?? '-') . "\n";
                $text .= "Ekskul: " . ($p['extracurriculars'] ?? '-') . "\n";

                self::ingestDocument(
                    title:      "Profil Unit: {$unitNames[$idx]}",
                    category:   'website_data',
                    rawText:    $text,
                    sourceType: 'website_data',
                    uploadedBy: 'System Auto-Sync',
                );
                $synced['profiles']++;
            }
        }

        // 6. Sync general school settings
        $settings = [
            'contact_phone'   => SiteSetting::get('contact_phone', ''),
            'contact_email'   => SiteSetting::get('contact_email', ''),
            'contact_address' => SiteSetting::get('contact_address', ''),
            'principal_name'  => SiteSetting::get('principal_name', ''),
            'school_vision'   => SiteSetting::get('school_vision', ''),
            'school_mission'  => SiteSetting::get('school_mission', ''),
            'school_history'  => SiteSetting::get('school_history', ''),
        ];

        $schools = School::where('is_active', true)->get();
        $settingText  = "INFORMASI RESMI SIT ROBBANI:\n";
        $settingText .= "Direktur / Pimpinan Yayasan: {$settings['principal_name']}\n";
        $settingText .= "Alamat Kampus: {$settings['contact_address']}\n";
        $settingText .= "Nomor Hotline WhatsApp: {$settings['contact_phone']}\n";
        $settingText .= "Email Resmi: {$settings['contact_email']}\n";
        $settingText .= "Visi Lembaga: {$settings['school_vision']}\n";
        $settingText .= "Misi Lembaga: {$settings['school_mission']}\n";
        $settingText .= "Sejarah Singkat: {$settings['school_history']}\n\n";
        $settingText .= "UNIT SEKOLAH AKTIF:\n";
        foreach ($schools as $s) {
            $settingText .= "• [{$s->code}] {$s->name} (Akreditasi: {$s->accreditation})\n";
        }

        self::ingestDocument(
            title:      'Informasi Resmi & Kontak SIT Robbani',
            category:   'umum',
            rawText:    $settingText,
            sourceType: 'website_data',
            uploadedBy: 'System Auto-Sync',
        );
        $synced['settings']++;

        return $synced;
    }

    // =========================================================================
    // CONTEXT BUILDER
    // =========================================================================

    /**
     * Build full prompt context with realtime DB + RAG documents
     */
    public static function buildFullPromptContext(string $userMessage): array
    {
        $schools       = School::where('is_active', true)->get();
        $academicYear  = AcademicYear::where('is_active', true)->first();
        $totalPpdb     = PpdbRegistration::count();
        $principalName = SiteSetting::get('principal_name', 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd');
        $contactPhone  = SiteSetting::get('contact_phone', '0811747472');
        $contactEmail  = SiteSetting::get('contact_email', 'info@sitrobbani.sch.id');
        $contactAddress = SiteSetting::get('contact_address', 'Jl. Lintas Timur Km 35 Indralaya, Ogan Ilir, Sumatera Selatan');

        // ── Live System Context ──────────────────────────────────────────────
        $systemContext  = "=== DATA RESMI & REALTIME SISTEM SMARTEDU SIT ROBBANI ===\n";
        $systemContext .= "• Lembaga: SIT Robbani Ogan Ilir (Yayasan Generasi Robbani Sumatera Selatan)\n";
        $systemContext .= "• Pimpinan: {$principalName}\n";
        $systemContext .= "• Alamat Kampus: {$contactAddress}\n";
        $systemContext .= "• Kontak Hotline WA: {$contactPhone} | Email: {$contactEmail}\n";
        $systemContext .= "• Tahun Ajaran Aktif: " . ($academicYear ? $academicYear->name : '2026/2027') . "\n";
        $systemContext .= "• Total Pendaftar SPMB Online: {$totalPpdb} calon siswa\n";
        $systemContext .= "• Unit Sekolah Aktif:\n";
        foreach ($schools as $s) {
            $systemContext .= "  - [{$s->code}] {$s->name} ({$s->level}) - Akreditasi {$s->accreditation}\n";
        }

        // ── RAG: Retrieve relevant documents ────────────────────────────────
        $relevantDocs    = AiKnowledgeBase::findRelevantKnowledge($userMessage, 5);
        $documentContext = '';

        if (!empty($relevantDocs)) {
            $documentContext .= "\n=== DOKUMEN & KNOWLEDGE BASE TERKAIT (RAG) ===\n";
            foreach ($relevantDocs as $idx => $doc) {
                $docSnippet       = Str::limit($doc->raw_content, 1000);
                $documentContext .= '[' . ($idx + 1) . "] Dokumen: '{$doc->title}' (Kategori: {$doc->category_label})\n";
                $documentContext .= "Isi:\n{$docSnippet}\n\n";
            }
        }

        return [
            'systemContext'  => $systemContext,
            'documentContext' => $documentContext,
            'relevantDocs'   => $relevantDocs,
            'contactPhone'   => $contactPhone,
            'contactAddress' => $contactAddress,
            'principalName'  => $principalName,
        ];
    }

    // =========================================================================
    // AI ANSWER ENGINE
    // =========================================================================

    /**
     * Generate AI response using Gemini API with RAG context, or local fallback
     */
    public static function answer(string $userMessage): string
    {
        $context   = self::buildFullPromptContext($userMessage);
        $geminiKey = env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');

        if (!empty($geminiKey)) {
            try {
                $fullPrompt  = "Anda adalah 'Robbani SmartEdu AI Assistant', asisten AI resmi SIT Robbani Ogan Ilir yang cerdas, ramah, dan berpengetahuan luas tentang sekolah ini.\n\n";
                $fullPrompt .= "PANDUAN JAWABAN:\n";
                $fullPrompt .= "1. Jawab dengan ramah, santun, dan bernuansa islami (gunakan Assalamu'alaikum di awal bila perlu).\n";
                $fullPrompt .= "2. Gunakan data resmi dari sistem SmartEdu dan dokumen knowledge base di bawah ini.\n";
                $fullPrompt .= "3. Jika jawaban bersumber dari dokumen tertentu, sebutkan nama dokumennya.\n";
                $fullPrompt .= "4. Format jawaban dengan poin/bullet yang rapi dan mudah dibaca.\n";
                $fullPrompt .= "5. Jika tidak menemukan informasi yang diminta, sarankan untuk menghubungi admin melalui WhatsApp.\n\n";
                $fullPrompt .= $context['systemContext'] . "\n";
                $fullPrompt .= $context['documentContext'] . "\n";
                $fullPrompt .= "Pertanyaan Pengguna: {$userMessage}";

                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(15)
                    ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $geminiKey, [
                        'contents' => [[
                            'parts' => [['text' => $fullPrompt]]
                        ]],
                        'generationConfig' => [
                            'temperature'    => 0.4,
                            'maxOutputTokens' => 1024,
                        ],
                    ]);

                if ($response->successful()) {
                    $aiText = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if (!empty($aiText)) {
                        return trim($aiText);
                    }
                }
            } catch (\Throwable $e) {
                // Fallback to local RAG synthesis below
            }
        }

        // ── Local Intelligent RAG Fallback ──────────────────────────────────
        $q = strtolower($userMessage);

        if (!empty($context['relevantDocs'])) {
            $topDoc     = $context['relevantDocs'][0];
            $docExcerpt = Str::limit($topDoc->raw_content, 500);
            return "Assalamu'alaikum! Terkait pertanyaan Anda, berikut informasi dari **{$topDoc->title}**:\n\n" .
                   "📄 **Ringkasan:**\n{$docExcerpt}\n\n" .
                   "💬 Untuk informasi lebih lengkap, hubungi kami di WhatsApp: **{$context['contactPhone']}**";
        }

        if (str_contains($q, 'daftar') || str_contains($q, 'spmb') || str_contains($q, 'ppdb') ||
            str_contains($q, 'syarat') || str_contains($q, 'biaya')) {
            return "Assalamu'alaikum! Pendaftaran Siswa Baru (SPMB/PPDB Online) SIT Robbani saat ini telah dibuka untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT.\n\n" .
                   "📌 **Layanan Cepat:**\n" .
                   "• **Formulir Online**: `/ppdb`\n" .
                   "• **Cek E-SPP**: `/e-spp`\n" .
                   "• **WhatsApp**: **{$context['contactPhone']}**\n" .
                   "• **Alamat**: {$context['contactAddress']}";
        }

        if (str_contains($q, 'unit') || str_contains($q, 'tk') || str_contains($q, 'sd') ||
            str_contains($q, 'smp') || str_contains($q, 'sma')) {
            return "SIT Robbani membina 4 Unit Pendidikan Islam Terpadu:\n\n" .
                   "1. **KB/TKIT Robbani** — Akreditasi A — Adab & hafalan usia dini\n" .
                   "2. **SDIT Robbani** — Akreditasi B — Kurikulum Merdeka + Tahfidz\n" .
                   "3. **SMPIT Robbani** — Akreditasi B — Fullday School + Digital\n" .
                   "4. **SMAIT Robbani** — Coming Soon — Sains & IT Terpadu\n\n" .
                   "Pimpinan: **{$context['principalName']}**.";
        }

        return "Assalamu'alaikum! Terima kasih menghubungi **Robbani SmartEdu AI Assistant**.\n\n" .
               "Anda dapat bertanya tentang:\n" .
               "• Informasi SPMB / PPDB Online\n" .
               "• Biaya sekolah & E-SPP\n" .
               "• Profil KB/TKIT, SDIT, SMPIT, SMAIT\n" .
               "• SOP, tata tertib, kurikulum tahfidz\n" .
               "• Berita & kegiatan terbaru\n\n" .
               "Atau hubungi kami di WhatsApp: **{$context['contactPhone']}**";
    }
}
