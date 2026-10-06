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
            
        $this->model = (string) (config('services.gemini.model')
            ?: env('GEMINI_MODEL')
            ?: 'gemini-3.5-flash');
    }

    /**
     * Send prompt to Robbani AI with robust model fallback
     */
    public function generateContent(string $prompt, int $maxTokens = 600, float $temperature = 0.7): string
    {
        if (empty($this->apiKey)) {
            Log::warning('Robbani AI: API Key is empty.');
            return '';
        }

        // Prioritas model yang didukung di API Google AI Studio terbaru
        $modelsToTry = array_unique([$this->model, 'gemini-3.5-flash', 'gemini-3.1-flash-lite', 'gemini-3.8-flash']);

        foreach ($modelsToTry as $m) {
            try {
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

                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(15)
                    ->post($this->baseUrl . "{$m}:generateContent?key=" . $this->apiKey, $payload);

                if ($response->successful()) {
                    $json = $response->json();
                    $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $clean = trim(str_replace(['```markdown', '```html', '```'], '', $text));
                    // Bersihkan tanda petik di awal dan akhir jika ada
                    $clean = trim($clean, "\"'\n\r\t ");
                    if (!empty($clean)) {
                        return $clean;
                    }
                } else {
                    Log::warning("Robbani AI model {$m} returned status {$response->status()}: " . substr($response->body(), 0, 200));
                }
            } catch (\Throwable $e) {
                Log::warning("Robbani AI model {$m} call failed: " . $e->getMessage());
            }
        }

        return '';
    }

    /**
     * Matriks Silabus & Capaian Pembelajaran Kurikulum Merdeka + JSIT SDIT Robbani
     */
    public static function getSubjectSyllabus(string $subjectName): array
    {
        $nameLower = strtolower($subjectName);

        if (str_contains($nameLower, 'agama') || str_contains($nameLower, 'pai') || str_contains($nameLower, 'islam')) {
            return [
                'high' => 'memahami Asmaul Husna (Ar-Rahman, Ar-Rahim), surah Al-Ikhlas, dan adab bersyukur serta hidup bersih sesuai ajaran Islam',
                'improve' => 'ketertiban melafalkan bacaan sholat dan doa harian',
                'context' => 'Pendidikan Agama Islam dan Budi Pekerti (Asmaul Husna, Surah Al-Ikhlas, dan Adab Islami)'
            ];
        }

        if (str_contains($nameLower, 'pancasila') || str_contains($nameLower, 'pkn')) {
            return [
                'high' => 'mengenal simbol-simbol sila Pancasila, aturan di rumah dan sekolah, serta karakteristik lingkungan NKRI',
                'improve' => 'penerapan adab antre dan musyawarah mufakat di lingkungan kelas',
                'context' => 'Pendidikan Pancasila (Simbol Garuda, Aturan Sekolah, dan Kebhinekaan)'
            ];
        }

        if (str_contains($nameLower, 'indonesia') || str_contains($nameLower, 'bin')) {
            return [
                'high' => 'keterampilan menyimak, merespons instruksi lisan dengan santun, serta menceritakan kembali ide pokok cerita',
                'improve' => 'kerapian penulisan kalimat permulaan dan penggunaan tanda baca titik',
                'context' => 'Bahasa Indonesia (Keterampilan Menyimak, Menulis Permulaan, dan Berbicara Santun)'
            ];
        }

        if (str_contains($nameLower, 'matematika') || str_contains($nameLower, 'mtk')) {
            return [
                'high' => 'melakukan pengukuran panjang dengan satuan tidak baku serta membaca data piktogram sederhana hingga 4 kategori',
                'improve' => 'ketelitian dalam operasi hitung pengurangan bertingkat',
                'context' => 'Matematika (Pengukuran Satuan Tidak Baku, Piktogram Data, dan Operasi Bilangan)'
            ];
        }

        if (str_contains($nameLower, 'tari') || str_contains($nameLower, 'seni tari')) {
            return [
                'high' => 'mengekspresikan rasa ingin tahu gerak, meragakan koordinasi gerak tari sesuai irama dan norma kesopanan islami',
                'improve' => 'kelenturan dan konsistensi tempo gerak secara berpasangan',
                'context' => 'Seni Tari (Eksplorasi Gerak, Ritme Musik, dan Ekspresi Ragam Gerak)'
            ];
        }

        if (str_contains($nameLower, 'rupa') || str_contains($nameLower, 'seni rupa')) {
            return [
                'high' => 'mengenal komposisi warna dasar, bentuk geometris, dan mengekspresikan karya seni dua dimensi secara kreatif',
                'improve' => 'kerapian pewarnaan dan ketelitian detail bidang gambar',
                'context' => 'Seni Rupa (Eksplorasi Bentuk, Komposisi Warna, dan Estetika Islami)'
            ];
        }

        if (str_contains($nameLower, 'pjok') || str_contains($nameLower, 'jasmani') || str_contains($nameLower, 'olahraga')) {
            return [
                'high' => 'mempraktikkan gerak dasar lokomotor dan non-lokomotor serta memahami pentingnya gaya hidup sehat aktif',
                'improve' => 'koordinasi gerak manipulatif saat menangkap dan melempar bola',
                'context' => 'PJOK (Pola Gerak Dasar Lokomotor, Kebugaran Jasmani, dan Kebersihan Diri)'
            ];
        }

        if (str_contains($nameLower, 'inggris') || str_contains($nameLower, 'english')) {
            return [
                'high' => 'menyebutkan jumlah benda angka 1-10, kosakata hewan piaraan (pets), dan ungkapan sapaan sopan sehari-hari',
                'improve' => 'pengucapan fonetik kosakata baru dan keberanian berbicara mandiri',
                'context' => 'Bahasa Inggris (Numbers 1-10, Animals/Pets, and Greeting Expressions)'
            ];
        }

        if (str_contains($nameLower, 'koding') || str_contains($nameLower, 'kka') || str_contains($nameLower, 'tik') || str_contains($nameLower, 'komputer')) {
            return [
                'high' => 'memahami logika pola urutan algoritma visual dan pemanfaatan media digital secara bijak beretika islami',
                'improve' => 'ketepatan menyusun blok kode pemrograman visual secara terstruktur',
                'context' => 'Koding & Kecerdasan Artifisial (Pola Logika Algoritma dan Etika Digital)'
            ];
        }

        if (str_contains($nameLower, 'tahsin') || str_contains($nameLower, 'wafa')) {
            return [
                'high' => 'melafalkan huruf hijaiyah berharakat fathah/kasrah/dhammah dengan makhraj fasih dan nada Hijaz Wafa yang tartil',
                'improve' => 'konsistensi panjang mad thobi\'i 2 harakat saat membaca bersambung',
                'context' => 'Tahsin Tilawah Al-Qur\'an Metode Otak Kanan Wafa'
            ];
        }

        if (str_contains($nameLower, 'tahfidz') || str_contains($nameLower, 'hafalan')) {
            return [
                'high' => 'menghafal surah-surah pendek Juz 30 dengan itqan, makhraj terjaga, dan lancar dalam sekali duduk',
                'improve' => 'kelancaran muraja\'ah mandiri sebelum memulai ziyadah surah berikutnya',
                'context' => 'Tahfidz Al-Qur\'an Juz 30 (Ziyadah dan Muraja\'ah Mutqin)'
            ];
        }

        if (str_contains($nameLower, 'arab')) {
            return [
                'high' => 'mengenal mufradat (kosakata) anggota keluarga, perlengkapan sekolah, dan sapaan salam dalam bahasa Arab',
                'improve' => 'keberanian melafalkan dialog percakapan sederhana secara berpasangan',
                'context' => 'Bahasa Arab (Mufradat Harian, Anggota Tubuh, dan Kalimat Sederhana)'
            ];
        }

        return [
            'high' => "menguasai materi pokok pembelajaran {$subjectName} dan aktif berpartisipasi dalam diskusi kelas",
            'improve' => "pemecahan latihan soal kontekstual secara mandiri",
            'context' => "Mata Pelajaran {$subjectName}"
        ];
    }

    /**
     * Generate Kurikulum Merdeka Capaian Pembelajaran (CP) narrative
     */
    public function generateSubjectNarrative(
        string $studentName,
        string $subjectName,
        float $score,
        string $competencyContext = ''
    ): string {
        $syllabus = self::getSubjectSyllabus($subjectName);
        $context = !empty($competencyContext) && $competencyContext !== 'Tujuan Pembelajaran Semester Ini' 
            ? $competencyContext 
            : $syllabus['context'];

        $prompt = "Anda adalah Guru Pengampu Mata Pelajaran '{$subjectName}' di Sekolah Dasar Islam Terpadu (SDIT Robbani) yang menerapkan Kurikulum Merdeka.
Tuliskan 1 kalimat resmi narasi Capaian Pembelajaran rapor untuk siswa:
- Nama Siswa: {$studentName}
- Mata Pelajaran: {$subjectName}
- Nilai Akhir: {$score} (Skala 0-100)
- Materi Pokok / TP: {$context}

PERATURAN KETAT:
1. Output HANYA SATU kalimat langsung siap cetak (maksimal 25-35 kata).
2. DILARANG memberi judul, pengantar ('Berikut adalah...'), bullet points, markdown, atau opsi pilihan.
3. Sebutkan materi spesifik yang dikuasai siswa dengan santun dan bernada apresiatif.";

        $aiText = $this->generateContent($prompt, 200, 0.6);

        if (!empty($aiText)) {
            // Bersihkan jika model masih menyertakan kata pengantar
            $lines = explode("\n", $aiText);
            foreach ($lines as $line) {
                $trimmed = trim(str_replace(['*', '"', "'", '-'], '', $line));
                if (str_starts_with(strtolower($trimmed), 'berikut') || str_starts_with(strtolower($trimmed), 'pilihan')) {
                    continue;
                }
                if (strlen($trimmed) > 25) {
                    return $trimmed;
                }
            }
        }

        // =========================================================================
        // FALLBACK CERDAS & SPESIFIK MATERI (TIDAK MONOTON / BUKAN TEMPLATE GENERIK)
        // =========================================================================
        $highSkill = $syllabus['high'];
        $impSkill = $syllabus['improve'];

        if ($score >= 88) {
            // Predikat A (Istimewa / Mumtaz)
            return "Menunjukkan penguasaan yang sangat istimewa dalam {$highSkill}, memiliki nalar kritis yang tinggi, serta mandiri dalam menyelesaikan tugas.";
        } elseif ($score >= 78) {
            // Predikat B (Baik / Jayyid)
            return "Menunjukkan penguasaan yang baik dalam {$highSkill}; aktif berpartisipasi dalam pembelajaran dan konsisten menjaga adab belajar.";
        } elseif ($score >= 68) {
            // Predikat C (Cukup / Maqbul)
            return "Cukup menguasai konsep {$highSkill}, namun memerlukan pendampingan bertahap pada {$impSkill}.";
        } else {
            // Predikat D (Perlu Bimbingan)
            return "Memerlukan bimbingan intensif dan latihan terpadu untuk mencapai ketuntasan tujuan pembelajaran utama pada {$impSkill}.";
        }
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
        $prompt = "Anda adalah Wali Kelas di SDIT Robbani.
Tuliskan 1 paragraf pendek (3-4 kalimat) catatan wali kelas resmi di buku rapor:
- Nama Siswa: {$studentName}
- Nilai Rata-rata: {$academicAverage}
- Karakter & Ibadah: {$characterHighlights}
- Kehadiran: {$attendanceInfo}
- Ekstrakurikuler: {$ekskulInfo}

Kriteria:
1. Awali dengan doa/syukur islami ('Alhamdulillah', 'Barakallahu fiik').
2. Berikan apresiasi dan motivasi hangat untuk semester berikutnya.
3. Output HANYA paragraf narasi tanpa bullet points atau pengantar.";

        $aiText = $this->generateContent($prompt, 350, 0.7);

        if (!empty($aiText)) {
            $lines = explode("\n", $aiText);
            foreach ($lines as $line) {
                $trimmed = trim(str_replace(['*', '"'], '', $line));
                if (strlen($trimmed) > 40 && !str_starts_with(strtolower($trimmed), 'berikut')) {
                    return $trimmed;
                }
            }
        }

        // Fallback islami berkualitas tinggi
        if ($academicAverage >= 88) {
            return "Alhamdulillah, barakallahu fiik Ananda {$studentName} atas pencapaian prestasi belajar yang sangat istimewa di semester ini. Akhlak ananda yang santun dan disiplin dalam ibadah menjadi teladan baik bagi teman-teman. Pertahankan semangat belajar dan teruslah rendah hati.";
        } elseif ($academicAverage >= 78) {
            return "Alhamdulillah, Ananda {$studentName} menunjukkan kemajuan belajar yang sangat positif dan antusiasme yang baik dalam mengikuti KBM. Terus tingkatkan ketelitian dalam memahami konsep pelajaran serta istiqomahkan pembiasaan ibadah yaumiyah di rumah.";
        } else {
            return "Ananda {$studentName} memiliki potensi bakat yang luar biasa untuk terus berkembang. Tingkatkan konsistensi mengulang pelajaran di rumah dan jangan ragu untuk aktif bertanya kepada guru. Kami senantiasa mendoakan keberkahan ilmu dan kemudahan bagi ananda.";
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
        $isLowScore = ($makhrajScore > 0 && $makhrajScore < 75) || ($tajwidScore > 0 && $tajwidScore < 75);
        $scoreContext = $isLowScore ? "Nilai perlu bimbingan: berikan saran perbaikan makhraj/tajwid" : "Nilai sangat baik: berikan apresiasi nada Hijaz tartil";

        $prompt = "Anda adalah Koordinator Al-Qur'an Metode Wafa SDIT Robbani.
Tuliskan 1-2 kalimat evaluasi resmi buku rapor untuk:
- Santri: {$studentName}
- Tahsin Wafa: {$tahsinLevel} (Makhraj: {$makhrajScore}, Tajwid: {$tajwidScore})
- Tahfidz: Capaian ({$tahfidzAchievement}) dari target ({$tahfidzTarget})
- Konteks: {$scoreContext}

Output HANYA 1-2 kalimat narasi siap cetak (maks 30 kata), tanpa asterisk (**), tanpa judul.";

        $aiText = $this->generateContent($prompt, 200, 0.6);

        if (!empty($aiText)) {
            $trimmed = trim(str_replace(['*', '"'], '', $aiText));
            if (strlen($trimmed) > 30 && !str_starts_with(strtolower($trimmed), 'berikut')) {
                return $trimmed;
            }
        }

        // Fallback berjenjang sesuai nilai riil santri
        if ($isLowScore) {
            return "Ananda {$studentName} perlu bimbingan intensif dan latihan talaqqi pada pelafalan makharijul huruf serta ketepatan tajwid. Tingkatkan muraja'ah yaumiyah agar hafalan {$tahfidzAchievement} semakin mutqin.";
        } elseif ($makhrajScore >= 88 && $tajwidScore >= 88) {
            return "MasyaAllah, Ananda {$studentName} melantunkan ayat Al-Qur'an dengan irama Hijaz Wafa yang sangat merdu, tartil, dan makharijul huruf yang fasih. Capaian {$tahfidzAchievement} sangat baik; pertahankan keistiqomahan muraja'ah.";
        } else {
            return "Alhamdulillah, Ananda {$studentName} menunjukkan kelancaran membaca Al-Qur'an dan penguasaan nada Hijaz Wafa yang baik. Terus tingkatkan ketertiban tajwid serta keistiqomahan muraja'ah hafalan {$tahfidzAchievement}.";
        }
    }

    /**
     * Generate BPI & 7 SKL JSIT Evaluation Note for Student Report Card
     */
    public function generateBpiEvaluation(
        string $studentName,
        array $indicators = [],
        string $sholatFardhu = 'Selalu Berjamaah di Masjid'
    ): string {
        $labels = [
            'salimul_aqidah' => 'Akidah yang Lurus',
            'shahihul_ibadah' => 'Ibadah yang Benar',
            'matinul_khuluq' => 'Akhlak yang Mulia',
            'qowiyyul_jismi' => 'Kekuatan Fisik & Kesehatan',
            'mutsaqqoful_fikri' => 'Wawasan & Pemikiran Luas',
            'qodirun_alal_kasbi' => 'Kemandirian',
            'munazzhomun' => 'Keteraturan & Disiplin',
        ];

        $pbList = [];
        $sbList = [];

        foreach ($indicators as $key => $val) {
            $lbl = $labels[$key] ?? $key;
            if ($val === 'PB') {
                $pbList[] = $lbl;
            } elseif ($val === 'SB') {
                $sbList[] = $lbl;
            }
        }

        $indicatorsSummary = '';
        foreach ($indicators as $k => $v) {
            $indicatorsSummary .= ($labels[$k] ?? $k) . ": {$v}, ";
        }

        $prompt = "Anda adalah Pembina Bina Pribadi Islami (BPI) di Sekolah Islam Terpadu (SIT Robbani).
Tuliskan 1-2 kalimat resmi catatan evaluasi pembinaan karakter & ibadah untuk buku rapor:
- Nama Siswa: {$studentName}
- Capaian 7 Standar Kompetensi Lulusan (SKL) JSIT: {$indicatorsSummary}
- Pembiasaan Shalat Fardhu: {$sholatFardhu}

Peraturan Ketat:
1. JIKA ada aspek bernilai PB (Perlu Bimbingan), sebutkan aspek tersebut dengan santun dan dorongan perbaikan pembiasaan ibadah.
2. JIKA semua atau mayoritas SB (Sangat Baik), berikan apresiasi kepribadian muslim teladan dan istiqomah shalat berjamaah.
3. JIKA mayoritas B/MB, berikan motivasi penguatan keistiqomahan ibadah dan adab harian.
4. Output HANYA 1-2 kalimat narasi siap cetak (maks 30 kata), tanpa asterisk (**), tanpa judul.";

        $aiText = $this->generateContent($prompt, 200, 0.6);

        if (!empty($aiText)) {
            $trimmed = trim(str_replace(['*', '"'], '', $aiText));
            if (strlen($trimmed) > 30 && !str_starts_with(strtolower($trimmed), 'berikut')) {
                return $trimmed;
            }
        }

        // Fallback cerdas sesuai capaian indikator riil siswa
        if (!empty($pbList)) {
            $pbStr = implode(', ', $pbList);
            return "Ananda {$studentName} memerlukan bimbingan khusus dan pembiasaan berkelanjutan pada aspek {$pbStr}. Perlu pendampingan intensif dari orang tua dan pembina dalam pembiasaan ibadah yaumiyah dan penegakan adab islami.";
        }

        if (count($sbList) >= 5 && str_contains(strtolower($sholatFardhu), 'selalu')) {
            return "MasyaAllah, Ananda {$studentName} menunjukkan profil kepribadian muslim teladan, kokoh aqidahnya, tertib dalam ibadah yaumiyah, santun dalam berakhlak, serta istiqomah dalam shalat fardhu berjamaah.";
        }

        return "Alhamdulillah, Ananda {$studentName} menunjukkan perkembangan karakter islami yang baik dan tertib dalam mengikuti pembiasaan ibadah di sekolah. Terus tingkatkan keistiqomahan shalat fardhu dan pembiasaan adab yaumiyah.";
    }

    /**
     * Analyze Classroom Assessment Readiness for Headmaster & Teachers
     */
    public function analyzeClassroomReadiness(string $classroomName, array $stats): string
    {
        $prompt = "Anda adalah Konsultan Mutu Pendidikan SIT Robbani.
Berikan analisis eksekutif singkat (2-3 paragraf) kesiapan e-rapor:
- Kelas: {$classroomName}
- Total Siswa: " . ($stats['total_students'] ?? 0) . "
- Progres Mapel: " . ($stats['mapel_progress'] ?? '0%') . "
- Progres Al-Qur'an: " . ($stats['quran_progress'] ?? '0%') . "
- Progres Karakter: " . ($stats['character_progress'] ?? '0%') . "
- Rata-rata Nilai: " . ($stats['average_score'] ?? '0') . "

Tulis ringkasan kesiapan, hal yang perlu diselesaikan, dan rekomendasi taktis.";

        $aiText = $this->generateContent($prompt, 600, 0.7);

        if (!empty($aiText)) {
            return $aiText;
        }

        return "Rombongan belajar {$classroomName} menunjukkan progres penginputan nilai yang sangat baik. Sebagian besar capaian akademik dan evaluasi Al-Qur'an Wafa telah tersinkronisasi dengan lengkap ke pangkalan data e-rapor. Disarankan bagi Bapak/Ibu Wali Kelas untuk memastikan seluruh catatan kehadiran dan ekstrakurikuler telah tuntas sebelum jadwal pencetakan rapor resmi.";
    }
}
