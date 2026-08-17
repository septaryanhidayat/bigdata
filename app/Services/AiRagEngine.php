<?php

namespace App\Services;

use App\Models\AiKnowledgeBase;
use App\Models\AcademicYear;
use App\Models\School;
use App\Models\PpdbRegistration;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiRagEngine
{
    /**
     * Extract plain text from an uploaded PDF document
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

        // Extract PDF text objects (stream ... endstream and BT ... ET blocks)
        if (preg_match_all('/BT[\s\S]*?ET/m', $content, $matches)) {
            foreach ($matches[0] as $block) {
                // Extract strings in parentheses e.g. (Hello World) Tj or [(Hello) -10 (World)] TJ
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

        // If simple regex couldn't extract enough plain text, extract raw printable ASCII sequences
        if (strlen(trim($text)) < 50) {
            preg_match_all('/[\x20-\x7E\r\n\t]{4,}/', $content, $asciiMatches);
            $rawStrings = implode(' ', $asciiMatches[0] ?? []);
            // Clean up PDF syntax artifacts
            $cleaned = preg_replace('/(\/[A-Za-z0-9_\-\.]+|\bobj\b|\bendobj\b|\bstream\b|\bendstream\b|\bxref\b|\btrailer\b)/i', ' ', $rawStrings);
            $text = preg_replace('/\s+/', ' ', $cleaned);
        }

        return trim($text);
    }

    /**
     * Ingest a PDF file into the AI Knowledge Base with keyword generation
     */
    public static function ingestDocument(string $title, string $category, string $rawText, ?string $filePath = null, ?string $fileName = null): AiKnowledgeBase
    {
        // Extract top keywords automatically
        $words = preg_split('/[\s,\.\?\!\;\:\(\)\[\]\"\'\/\-]+/', strtolower($rawText));
        $stopwords = ['dan', 'yang', 'di', 'ke', 'dari', 'ini', 'itu', 'untuk', 'pada', 'adalah', 'sebagai', 'dengan', 'atau', 'akan', 'oleh', 'karena', 'saat', 'para', 'bisa', 'dapat', 'oleh', 'juga', 'kami', 'kita', 'saya', 'anda', 'mereka', 'the', 'and', 'for', 'with', 'from'];
        $frequency = [];

        foreach ($words as $w) {
            $w = trim($w);
            if (strlen($w) >= 3 && !in_array($w, $stopwords) && !is_numeric($w)) {
                $frequency[$w] = ($frequency[$w] ?? 0) + 1;
            }
        }

        arsort($frequency);
        $topKeywords = array_slice(array_keys($frequency), 0, 15);

        return AiKnowledgeBase::create([
            'title' => $title,
            'category' => $category,
            'source_type' => $filePath ? 'pdf' : 'text',
            'file_path' => $filePath,
            'file_name' => $fileName,
            'raw_content' => $rawText,
            'summary' => Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($rawText))), 250),
            'keywords' => $topKeywords,
            'is_active' => true,
        ]);
    }

    /**
     * Real-Time Context Engine: Merges live SmartEdu database facts + retrieved RAG document chunks
     */
    public static function buildFullPromptContext(string $userMessage): array
    {
        // 1. Live SmartEdu Ecosystem Facts
        $schools = School::where('is_active', true)->get();
        $academicYear = AcademicYear::where('is_active', true)->first();
        $totalPpdb = PpdbRegistration::count();
        $principalName = SiteSetting::get('principal_name', 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd');
        $contactPhone = SiteSetting::get('contact_phone', '0811747472');
        $contactEmail = SiteSetting::get('contact_email', 'info@sitrobbani.sch.id');
        $contactAddress = SiteSetting::get('contact_address', 'Jl. Lintas Timur Km 35 Indralaya, Ogan Ilir, Sumatera Selatan');

        $systemContext = "=== DATA RESMI & REALTIME SISTEM SMARTEDU SIT ROBBANI ===\n";
        $systemContext .= "• Lembaga: SIT Robbani Ogan Ilir (Yayasan Generasi Robbani Sumatera Selatan)\n";
        $systemContext .= "• Pimpinan: {$principalName}\n";
        $systemContext .= "• Alamat Kampus: {$contactAddress}\n";
        $systemContext .= "• Kontak Hotline WA: {$contactPhone} | Email: {$contactEmail}\n";
        $systemContext .= "• Tahun Ajaran Aktif: " . ($academicYear ? $academicYear->name : '2026/2027') . "\n";
        $systemContext .= "• Total Pendaftar SPMB Online Masuk: {$totalPpdb} calon siswa\n";
        $systemContext .= "• Unit Sekolah Aktif:\n";
        foreach ($schools as $s) {
            $systemContext .= "  - [{$s->code}] {$s->name} ({$s->level}) - Akreditasi {$s->accreditation}\n";
        }

        // 2. Retrieve Relevant Documents from AI Knowledge Base (RAG)
        $relevantDocs = AiKnowledgeBase::findRelevantKnowledge($userMessage, 3);
        $documentContext = "";

        if (!empty($relevantDocs)) {
            $documentContext .= "\n=== DOKUMEN & KNOWLEDGE BASE TERKAIT (RAG INGESTION) ===\n";
            foreach ($relevantDocs as $idx => $doc) {
                $docSnippet = Str::limit($doc->raw_content, 800);
                $documentContext .= "[" . ($idx + 1) . "] Dokumen: '{$doc->title}' (Kategori: {$doc->category})\n";
                $documentContext .= "Isi Cuplikan Dokumen:\n{$docSnippet}\n\n";
            }
        }

        return [
            'systemContext' => $systemContext,
            'documentContext' => $documentContext,
            'relevantDocs' => $relevantDocs,
            'contactPhone' => $contactPhone,
            'contactAddress' => $contactAddress,
            'principalName' => $principalName,
        ];
    }

    /**
     * Generate AI Response using Gemini API or Smart Fallback Synthesizer
     */
    public static function answer(string $userMessage): string
    {
        $context = self::buildFullPromptContext($userMessage);
        $geminiKey = env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY');

        if (!empty($geminiKey)) {
            try {
                $fullPrompt = "Anda adalah 'Robbani SmartEdu AI Assistant', asisten AI cerdas resmi SIT Robbani Ogan Ilir yang didukung oleh Knowledge Base dokumen sekolah dan data realtime SmartEdu.\n\n";
                $fullPrompt .= "Tugas Anda:\n";
                $fullPrompt .= "1. Jawab pertanyaan pengunjung secara ramah, santun, islami, dan akurat berdasarkan fakta dokumen dan data sistem di bawah ini.\n";
                $fullPrompt .= "2. Jika jawaban bersumber dari dokumen yang diberikan, sebutkan nama dokumennya (misal: 'Berdasarkan Panduan SPMB / SOP Siswa...').\n";
                $fullPrompt .= "3. Format jawaban menggunakan Markdown rapi dengan poin/bullet agar mudah dibaca.\n\n";
                $fullPrompt .= $context['systemContext'] . "\n";
                $fullPrompt .= $context['documentContext'] . "\n";
                $fullPrompt .= "Pertanyaan Pengunjung: {$userMessage}";

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->timeout(10)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $geminiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $fullPrompt]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $aiText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if (!empty($aiText)) {
                        return trim($aiText);
                    }
                }
            } catch (\Throwable $e) {
                // Fallback to local RAG synthesis
            }
        }

        // Local Intelligent RAG Synthesis Engine (Offline / Standalone fallback)
        $q = strtolower($userMessage);

        // Check if there are relevant documents retrieved
        if (!empty($context['relevantDocs'])) {
            $topDoc = $context['relevantDocs'][0];
            $docExcerpt = Str::limit($topDoc->raw_content, 450);
            return "Assalamu'alaikum! Terkait pertanyaan Anda, berikut informasi dari dokumen resmi **{$topDoc->title}**:\n\n" .
                   "📄 **Rangkuman Dokumen:**\n{$docExcerpt}\n\n" .
                   "💡 Anda juga dapat menghubungi Panitia / Humas SIT Robbani melalui WhatsApp di **{$context['contactPhone']}** untuk informasi lebih detail.";
        }

        // Rule-based live system queries
        if (str_contains($q, 'daftar') || str_contains($q, 'spmb') || str_contains($q, 'ppdb') || str_contains($q, 'syarat') || str_contains($q, 'biaya')) {
            return "Assalamu'alaikum! Pendaftaran Siswa Baru (SPMB / PPDB Online) SIT Robbani Ogan Ilir Tahun Ajaran Aktif saat ini telah dibuka untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.\n\n" .
                   "📌 **Layanan Cepat:**\n" .
                   "• **Formulir Online**: Menu **[Pendaftaran SPMB]** (`/ppdb`)\n" .
                   "• **Cek Tagihan / SPP**: Menu **[Portal E-SPP]** (`/e-spp`)\n" .
                   "• **Hotline WhatsApp**: **{$context['contactPhone']}**\n" .
                   "• **Lokasi Kampus**: {$context['contactAddress']}";
        }

        if (str_contains($q, 'unit') || str_contains($q, 'tk') || str_contains($q, 'sd') || str_contains($q, 'smp') || str_contains($q, 'sma')) {
            return "SIT Robbani Ogan Ilir membina 4 Unit Pendidikan Islam Terpadu Unggulan:\n\n" .
                   "1. **KB/TKIT Robbani**: Pembentukan adab, kemandirian anak usia dini, & hafalan doa harian.\n" .
                   "2. **SDIT Robbani**: Kurikulum Merdeka Terpadu & Tahfidz Al-Qur'an (Juz 30 & 29).\n" .
                   "3. **SMPIT Robbani**: Pembinaan karakter kepemimpinan, riset ilmiah remaja, & BPI.\n" .
                   "4. **SMAIT Robbani**: Persiapan PTN Unggulan, Program IT Coding, & Tahfidz Lanjutan.\n\n" .
                   "Pimpinan: **{$context['principalName']}**.";
        }

        return "Assalamu'alaikum! Terima kasih telah menghubungi **Robbani SmartEdu AI Assistant**.\n\n" .
               "Asisten ini terintegrasi langsung dengan database sistem SmartEdu dan Dokumen Pengetahuan SIT Robbani Ogan Ilir.\n\n" .
               "Anda dapat menanyakan hal-hal seputar:\n" .
               "• Informasi SPMB / PPDB Online 2026/2027\n" .
               "• Rincian Biaya & Cek E-SPP Siswa\n" .
               "• Profil Unit KB/TKIT, SDIT, SMPIT, dan SMAIT\n" .
               "• Dokumen SOP, Tata Tertib & Kurikulum Tahfidz\n\n" .
               "Silakan ketik pertanyaan spesifik Anda atau hubungi kami di WhatsApp **{$context['contactPhone']}**.";
    }
}
