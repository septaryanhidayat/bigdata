<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    protected array $models = [
        'gemini-2.0-flash',
        'gemini-1.5-flash',
        'gemini-1.5-flash-8b',
        'gemini-1.5-pro',
        'gemini-pro'
    ];

    public function __construct()
    {
        $this->apiKey = (string) (config('services.gemini.key')
            ?: env('GEMINI_API_KEY')
            ?: env('GOOGLE_API_KEY', ''));
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Send raw prompt to Google Gemini AI with automatic model fallback
     */
    public function generateContent(
        string $prompt,
        ?string $systemInstruction = null,
        int $maxTokens = 1200,
        float $temperature = 0.7
    ): string {
        if (!$this->isConfigured()) {
            return '';
        }

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'maxOutputTokens' => $maxTokens,
                'temperature' => $temperature,
            ]
        ];

        if (!empty($systemInstruction)) {
            $payload['system_instruction'] = [
                'parts' => [['text' => $systemInstruction]]
            ];
        }

        foreach ($this->models as $m) {
            try {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(20)
                    ->post($this->baseUrl . "{$m}:generateContent?key=" . $this->apiKey, $payload);

                if ($response->successful()) {
                    $json = $response->json();
                    $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    if (!empty($text)) {
                        return trim($text);
                    }
                } else {
                    Log::warning("Gemini AI model {$m} returned status {$response->status()}: " . $response->body());
                }
            } catch (\Throwable $e) {
                Log::error("Gemini AI call exception on model {$m}: " . $e->getMessage());
            }
        }

        return '';
    }

    /**
     * Test Gemini API Connection Status & Latency
     */
    public function testConnection(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'model' => null,
                'latency_ms' => 0,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi di file .env server.',
            ];
        }

        $startTime = microtime(true);
        $testPrompt = "Jawab hanya 1 kata: 'TERKONEKSI'";

        foreach ($this->models as $m) {
            try {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(10)
                    ->post($this->baseUrl . "{$m}:generateContent?key=" . $this->apiKey, [
                        'contents' => [
                            ['parts' => [['text' => $testPrompt]]]
                        ],
                        'generationConfig' => ['maxOutputTokens' => 10, 'temperature' => 0.1]
                    ]);

                if ($response->successful()) {
                    $elapsed = round((microtime(true) - $startTime) * 1000);
                    $text = trim($response->json()['candidates'][0]['content']['parts'][0]['text'] ?? '');
                    return [
                        'success' => true,
                        'model' => $m,
                        'latency_ms' => $elapsed,
                        'message' => "Koneksi Google Gemini AI berhasil! Model aktif: {$m} ({$elapsed}ms). Respon: {$text}",
                    ];
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return [
            'success' => false,
            'model' => null,
            'latency_ms' => 0,
            'message' => 'Gagal menghubungi server Google Gemini API. Periksa kuota atau koneksi internet server.',
        ];
    }

    /**
     * FEATURE 1: AI CMS Article & School News Writer
     */
    public function writeArticleDraft(
        string $topic,
        string $category = 'Berita',
        string $tone = 'islami_inspiratif',
        string $unitScope = 'all'
    ): array {
        $systemInstruction = "Anda adalah Humas & Jurnalis Senior SIT Robbani Ogan Ilir di bawah naungan Yayasan Generasi Robbani Sumatera Selatan.
Tugas Anda: Membuat naskah berita/artikel sekolah yang menarik, inspiratif, bernafaskan nilai Islam Terpadu (JSIT), dan siap terbit.
FORMAT OUTPUT WAJIB: JSON murni tanpa markdown fence (```{json}). Contoh struktur JSON:
{
  \"title\": \"Judul Berita Menarik & SEO-Friendly (Max 70 karakter)\",
  \"excerpt\": \"Ringkasan 1-2 kalimat pengantar berita (Max 160 karakter)\",
  \"content\": \"<p>Isi berita lengkap minimal 3 paragraf menggunakan tag HTML seperti &lt;p&gt;, &lt;h3&gt;, &lt;blockquote&gt;, dan &lt;ul&gt;&lt;li&gt;. Gunakan bahasa Indonesia baku, santun, dan islami.</p>\",
  \"tags\": [\"SIT Robbani\", \"Prestasi\", \"Pendidikan Karakter\"],
  \"meta_description\": \"Ringkasan meta description untuk SEO Google\"
}";

        $prompt = "Topik Berita/Artikel: {$topic}\nKategori: {$category}\nNada Tulisan: {$tone}\nJenjang/Unit: {$unitScope}\n\nBuat naskah berita berkualitas tinggi dalam format JSON:";

        $raw = $this->generateContent($prompt, $systemInstruction, 1500, 0.7);
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', $raw));
        $decoded = json_decode($clean, true);

        if (is_array($decoded) && isset($decoded['title'], $decoded['content'])) {
            return [
                'success' => true,
                'data' => $decoded
            ];
        }

        // Fallback if model returned plain text
        return [
            'success' => !empty($raw),
            'data' => [
                'title' => 'Rilis Berita: ' . $topic,
                'excerpt' => mb_substr(strip_tags($raw), 0, 150) . '...',
                'content' => nl2br(e($raw)),
                'tags' => ['SIT Robbani', 'Berita Sekolah'],
                'meta_description' => mb_substr(strip_tags($raw), 0, 150)
            ]
        ];
    }

    /**
     * FEATURE 2: AI SPMB Smart Applicant Analyzer & Recommendation
     */
    public function analyzeSpmbApplicant(array $data): array
    {
        $systemInstruction = "Anda adalah Psikolog Pendidikan & Tim Seleksi Masuk SIT Robbani Ogan Ilir.
Tugas Anda menganalisis berkas dan data pendaftar murid baru (SPMB/PPDB) untuk memberikan rekomendasi peminatan, potensi bakat, serta catatan pendampingan islami.
FORMAT OUTPUT WAJIB: JSON murni tanpa markdown fence (```{json}). Struktur:
{
  \"readiness_score\": 90,
  \"student_summary\": \"Ringkasan profil dan potensi dasar ananda\",
  \"strengths\": [\"Kekuatan 1\", \"Kekuatan 2\"],
  \"recommended_programs\": [\"Kelas Tahfidz Intensif Wafa\", \"Ekskul Robotik & Coding\", \"Pramuka SIT\"],
  \"interview_notes\": \"Panduan fokus pertanyaan saat sesi wawancara orang tua & ananda\",
  \"parent_welcome_msg\": \"Pesan sambutan hangat dan doa bernuansa Islami untuk orang tua ananda (bisa dikirim via WhatsApp)\"
}";

        $name = $data['nama_lengkap'] ?? $data['name'] ?? 'Calon Santri';
        $unit = strtoupper($data['unit'] ?? $data['jenjang'] ?? 'SIT Robbani');
        $talents = $data['hobi'] ?? $data['prestasi'] ?? $data['minat'] ?? 'Umum';
        $prevSchool = $data['asal_sekolah'] ?? 'Belum ada data';
        $parentNotes = $data['catatan'] ?? $data['alasan_memilih'] ?? 'Ingin pendidikan Islam dan akhlak mulia';

        $prompt = "DATA CALON MURID BARU SPMB:
- Nama Ananda: {$name}
- Jenjang Pilihan: {$unit}
- Asal Sekolah: {$prevSchool}
- Minat / Bakat / Prestasi: {$talents}
- Catatan / Harapan Orang Tua: {$parentNotes}

Silakan analisis data di atas dan kembalikan output dalam format JSON:";

        $raw = $this->generateContent($prompt, $systemInstruction, 1200, 0.4);
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', $raw));
        $decoded = json_decode($clean, true);

        if (is_array($decoded) && isset($decoded['readiness_score'])) {
            return [
                'success' => true,
                'data' => $decoded
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal memproses analisis pendaftar dengan AI.',
            'raw' => $raw
        ];
    }

    /**
     * FEATURE 3: AI Exam & Quiz Question Generator (CBT & LMS)
     */
    public function generateQuizQuestions(
        string $subject,
        string $topic,
        string $gradeLevel = 'SMP',
        int $count = 5,
        string $difficulty = 'Sedang'
    ): array {
        $count = max(1, min($count, 10)); // Safe bounds 1-10

        $systemInstruction = "Anda adalah Guru Pengembang Soal Ujian Profesional Berstandar Kurikulum Merdeka & JSIT Indonesia di SIT Robbani.
Tugas Anda membuat bank soal pilihan ganda lengkap dengan kunci jawaban dan pembahasan.
FORMAT OUTPUT WAJIB: JSON murni tanpa markdown fence (```{json}). Struktur:
{
  \"subject\": \"{$subject}\",
  \"topic\": \"{$topic}\",
  \"grade\": \"{$gradeLevel}\",
  \"questions\": [
    {
      \"number\": 1,
      \"question\": \"Pertanyaan soal...\",
      \"options\": {
        \"A\": \"Pilihan A\",
        \"B\": \"Pilihan B\",
        \"C\": \"Pilihan C\",
        \"D\": \"Pilihan D\"
      },
      \"correct_answer\": \"A\",
      \"explanation\": \"Pembahasan singkat mengapa A benar...\"
    }
  ]
}";

        $prompt = "Mata Pelajaran: {$subject}\nTopik/Materi: {$topic}\nJenjang Kelas: {$gradeLevel}\nJumlah Soal: {$count}\nTingkat Kesulitan: {$difficulty}\n\nBuat {$count} butir soal pilihan ganda berkualitas dalam format JSON:";

        $raw = $this->generateContent($prompt, $systemInstruction, 2000, 0.5);
        $clean = trim(preg_replace('/^```(?:json)?|```$/m', '', $raw));
        $decoded = json_decode($clean, true);

        if (is_array($decoded) && !empty($decoded['questions'])) {
            return [
                'success' => true,
                'data' => $decoded
            ];
        }

        return [
            'success' => false,
            'message' => 'Gagal menghasilkan bank soal dengan AI.',
            'raw' => $raw
        ];
    }

    /**
     * FEATURE 4: AI WhatsApp Customer Service Auto-Responder
     */
    public function autoReplyWhatsApp(string $incomingMessage, ?string $senderPhone = null): string
    {
        $context = AiRagEngine::buildFullPromptContext($incomingMessage);

        $systemInstruction = "Anda adalah Customer Service Bot WhatsApp Resmi SIT Robbani Ogan Ilir (Yayasan Generasi Robbani Sumatera Selatan).
ATURAN BALASAN WHATSAPP:
1. Wajib ramah, santun, bernuansa Islami (awali 'Assalamu'alaikum Warahmatullahi Wabarakatuh').
2. Berikan jawaban ringkas, padat, dan jelas (format WhatsApp: gunakan *bold*, _italic_, dan emoji yang rapi).
3. Hanya jawab pertanyaan seputar SIT Robbani (Pendaftaran SPMB/PPDB, Biaya SPP, Jenjang TKIT/SDIT/SMPIT/SMAIT, Jadwal, Fasilitas, dan Alamat di Indralaya Ogan Ilir).
4. Di akhir balasan selalu sertakan:
   📞 *Hotline WhatsApp Admin:* 0811-747-472
   🌐 *Website Pendaftaran:* https://sitrobbani.sch.id/spmb";

        $prompt = "DATA RESMI SIT ROBBANI:\n" . $context['systemContext'] . "\n" . $context['documentContext'] . "\n\nPesan Masuk dari Wali Santri: " . $incomingMessage;

        $reply = $this->generateContent($prompt, $systemInstruction, 450, 0.3);

        if (!empty($reply)) {
            return $reply;
        }

        // Fast fallback if Gemini is offline
        return "Assalamu'alaikum Warahmatullahi Wabarakatuh Bapak/Ibu. 🙏\n\nTerima kasih telah menghubungi *SIT Robbani Ogan Ilir*. Pendaftaran SPMB Online T.A. 2026/2027 telah dibuka resmi untuk jenjang *KB/TKIT, SDIT, SMPIT, dan SMAIT*.\n\n🌐 *Portal SPMB:* https://sitrobbani.sch.id/spmb\n📞 *Hotline Panitia:* 0811-747-472\n\nAda yang dapat kami bantu lebih lanjut?";
    }
}
