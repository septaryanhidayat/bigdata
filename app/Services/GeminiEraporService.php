<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiEraporService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';

    public function __construct()
    {
        $this->apiKey = (string) (config('services.gemini.key') 
            ?: env('GEMINI_API_KEY') 
            ?: env('GOOGLE_API_KEY', ''));
            
        $this->model = env('GEMINI_MODEL', 'gemini-3.6-flash');
    }

    /**
     * Send prompt to Google Gemini AI with automatic fallbacks
     */
    public function generateContent(string $prompt, int $maxTokens = 800, float $temperature = 0.7): string
    {
        $modelsToTry = array_unique([$this->model, 'gemini-3.6-flash', 'gemini-flash-latest', 'gemini-3-flash-preview']);

        foreach ($modelsToTry as $m) {
            try {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(18)
                    ->post($this->baseUrl . "{$m}:generateContent?key=" . $this->apiKey, [
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
                            'thinkingConfig' => ['thinkingBudget' => 0]
                        ]
                    ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $clean = trim(str_replace(['```markdown', '```html', '```'], '', $text));
                    if (!empty($clean)) {
                        return $clean;
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
     * Generate Islamic motivational Homeroom Notes for Student Report Card
     */
    public function generateHomeroomNote(
        string $studentName,
        float $academicAverage = 85.0,
        string $characterHighlights = 'Sholeh, santun, dan rajin sholat berjamaah',
        string $attendanceInfo = 'Hadir 100% tanpa alpha',
        string $ekskulInfo = 'Pramuka SIT & Tahfidz Club'
    ): string {
        $prompt = "Anda adalah Wali Kelas di Sekolah Islam Terpadu (SIT) yang bijaksana, hangat, dan penuh kasih sayang.
Tuliskan 1 paragraf catatan wali kelas resmi untuk buku rapor siswa berikut:
- Nama Siswa: {$studentName}
- Nilai Rata-rata Akademik: {$academicAverage}
- Karakter & Ibadah 7 SKL JSIT: {$characterHighlights}
- Catatan Kehadiran: {$attendanceInfo}
- Ekstrakurikuler: {$ekskulInfo}

Kriteria Penulisan:
1. Bahasa Indonesia yang baku, santun, hangat, mengalir, dan Islami (boleh diawali ucapan syukur / doa seperti 'Alhamdulillah', 'Barakallahu fiik', atau doa keberkahan).
2. Apresiasi capaian ananda secara spesifik dan berikan kalimat motivasi untuk semester berikutnya agar semakin istiqamah.
3. Maksimal 1 paragraf (3 hingga 5 kalimat padat dan bermakna).
4. JANGAN gunakan bullet points, langsung teks narasi mengalir.";

        $aiText = $this->generateContent($prompt, 500, 0.7);

        if (!empty($aiText)) {
            return $aiText;
        }

        // Fallback jika API offline
        if ($academicAverage >= 88) {
            return "Alhamdulillah, selamat dan barakallah untuk Ananda {$studentName} atas capaian prestasi belajar yang sangat membanggakan di semester ini. Karakter ananda yang santun, tekun, dan istiqamah dalam ibadah merupakan keteladanan yang mulia di kelas. Teruslah pertahankan semangat menuntut ilmu dan rendah hati dalam menggapai cita-cita luhur demi kemuliaan umat.";
        } elseif ($academicAverage >= 78) {
            return "Alhamdulillah, Ananda {$studentName} telah menunjukkan usaha yang baik dan perkembangan belajar yang positif sepanjang semester ini. Pertahankan kebiasaan baik dalam ibadah dan terus tingkatkan fokus pada pemahaman konsep pelajaran yang menantang. Kami yakin dengan kesungguhan dan doa, ananda mampu meraih prestasi yang jauh lebih gemilang.";
        } else {
            return "Ananda {$studentName} memiliki potensi bakat yang besar untuk terus berkembang. Tingkatkan kedisiplinan mengulang pelajaran di rumah, kuatkan interaksi dengan Al-Qur'an, dan jangan ragu berdiskusi aktif dengan guru di kelas. Kami senantiasa mendoakan kemudahan ananda dalam meraih keberkahan ilmu.";
        }
    }

    /**
     * Generate Kurikulum Merdeka Capaian Pembelajaran (CP) narrative
     */
    public function generateSubjectNarrative(
        string $studentName,
        string $subjectName,
        float $score,
        string $competencyContext = 'Tujuan Pembelajaran Semester Ini'
    ): string {
        $prompt = "Anda adalah Guru Pengampu Mata Pelajaran {$subjectName} di Sekolah Islam Terpadu (SIT) yang menerapkan Kurikulum Merdeka.
Buatkan deskripsi narasi Capaian Pembelajaran (CP/TP) rapor resmi untuk:
- Nama Siswa: {$studentName}
- Mata Pelajaran: {$subjectName}
- Nilai Akhir: {$score} (Skala 0-100)
- Materi / Capaian: {$competencyContext}

Kriteria:
1. Sesuai kaidah Kurikulum Merdeka Kemendikbudristek & Standar Mutu JSIT (menyebutkan capaian tertinggi yang dikuasai dengan baik dan aspek yang perlu bimbingan/peningkatan jika nilai < 80).
2. Maksimal 2 kalimat terstruktur, ringkas, objektif, dan bernada positif.
3. Output HANYA teks narasi tanpa tanda kutip atau penjelasan tambahan.";

        $aiText = $this->generateContent($prompt, 300, 0.6);

        if (!empty($aiText)) {
            return $aiText;
        }

        // Fallback
        if ($score >= 90) {
            return "Menunjukkan penguasaan capaian pembelajaran yang sangat istimewa dalam {$competencyContext}, bernalar kritis tinggi, serta mampu menyelesaikan tugas pemecahan masalah secara mandiri.";
        } elseif ($score >= 80) {
            return "Menunjukkan penguasaan capaian pembelajaran yang amat baik dalam {$competencyContext}, aktif dalam proses pembelajaran, dan konsisten menunjukkan kemajuan belajar.";
        } elseif ($score >= 70) {
            return "Menunjukkan penguasaan capaian pembelajaran yang cukup baik pada sebagian besar materi {$competencyContext}, namun perlu pendampingan pada latihan soal lanjutan.";
        } else {
            return "Perlu bimbingan dan penguatan secara berkelanjutan untuk mencapai ketuntasan tujuan pembelajaran utama pada mata pelajaran {$subjectName}.";
        }
    }

    /**
     * Generate Al-Qur'an Wafa & Tahfidz Evaluation
     */
    public function generateQuranEvaluation(
        string $studentName,
        string $tahsinLevel = 'Buku Wafa 3 Hal 25',
        float $makhrajScore = 88,
        float $tajwidScore = 90,
        string $tahfidzTarget = 'Juz 30 (An-Naba s/d An-Nas)',
        string $tahfidzAchievement = 'Tuntas Juz 30'
    ): string {
        $prompt = "Anda adalah Koordinator Al-Qur'an Metode Wafa dan Penguji Tahfidz di Sekolah Islam Terpadu (SIT).
Tuliskan 1-2 kalimat evaluasi catatan ustadz pengampu Al-Qur'an untuk buku rapor:
- Nama Siswa: {$studentName}
- Tingkat Tahsin Wafa: {$tahsinLevel}
- Nilai Makharijul Huruf: {$makhrajScore}
- Nilai Kaidah Tajwid: {$tajwidScore}
- Target & Capaian Tahfidz: Target ({$tahfidzTarget}), Capaian ({$tahfidzAchievement})

Kriteria:
1. Kalimat yang santun, menyemangati, dan mengapresiasi keindahan tilawah lagu Hijaz Wafa serta kelancaran (itqan) hafalan Al-Qur'an.
2. Maksimal 2 kalimat padat.";

        $aiText = $this->generateContent($prompt, 300, 0.6);

        if (!empty($aiText)) {
            return $aiText;
        }

        return "Ananda menunjukkan kecintaan yang tulus pada Al-Qur'an, makhraj dan mad terlafalkan dengan fasih menggunakan irama nada Wafa Hijaz. Terus kuatkan muraja'ah harian agar hafalan {$tahfidzAchievement} senantiasa mutqin.";
    }

    /**
     * Analyze Classroom Assessment Readiness for Headmaster & Teachers
     */
    public function analyzeClassroomReadiness(string $classroomName, array $stats): string
    {
        $prompt = "Anda adalah Konsultan Mutu Pendidikan Islam Terpadu (SIT) & Kurikulum Merdeka.
Berikan analisis eksekutif singkat (2-3 paragraf) untuk Kepala Sekolah dan Wali Kelas mengenai kesiapan rapor rombongan belajar:
- Nama Kelas: {$classroomName}
- Total Siswa: " . ($stats['total_students'] ?? 0) . "
- Progres Nilai Mapel: " . ($stats['mapel_progress'] ?? '0%') . "
- Progres Nilai Wafa & Tahfidz: " . ($stats['quran_progress'] ?? '0%') . "
- Progres Karakter 7 SKL JSIT: " . ($stats['character_progress'] ?? '0%') . "
- Progres Catatan Wali Kelas: " . ($stats['homeroom_progress'] ?? '0%') . "
- Rata-rata Nilai Kelas: " . ($stats['average_score'] ?? '0') . "

Struktur Jawaban:
1. Paragraf 1: Ringkasan tingkat kesiapan dan capaian umum kelas.
2. Paragraf 2: Identifikasi aspek yang paling perlu dipercepat atau diselesaikan sebelum batas akhir cetak rapor.
3. Paragraf 3: Rekomendasi taktis untuk Wali Kelas dan Kepala Sekolah.";

        $aiText = $this->generateContent($prompt, 700, 0.7);

        if (!empty($aiText)) {
            return $aiText;
        }

        return "Rombongan belajar {$classroomName} secara umum menunjukkan kesiapan yang sangat baik. Mayoritas capaian penilaian akademik dan tilawah Wafa telah terinput ke dalam pangkalan data rapor. Disarankan bagi Bapak/Ibu Wali Kelas untuk menuntaskan sinkronisasi catatan ekstrakurikuler dan presensi agar dokumen siap dicetak sebelum tanggal penyerahan rapor.";
    }
}
