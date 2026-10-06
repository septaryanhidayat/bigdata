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
        if ($score <= 0) {
            return "Belum ada penilaian capaian kompetensi / memerlukan bimbingan intensif dan remedial terpadu pada seluruh tujuan pembelajaran {$subjectName}.";
        }

        $syllabus = self::getSubjectSyllabus($subjectName);
        $context = !empty($competencyContext) && $competencyContext !== 'Tujuan Pembelajaran Semester Ini' 
            ? $competencyContext 
            : $syllabus['context'];

        $highSkill = $syllabus['high'];
        $impSkill = $syllabus['improve'];

        $scoreContext = $score < 65 
            ? "PERINGATAN: Nilai siswa rendah/belum tuntas ({$score}). DILARANG memuji. Nyatakan secara tegas dan santun bahwa siswa perlu bimbingan intensif dan remedial pada {$impSkill}."
            : ($score < 75 ? "Nilai cukup ({$score}): sebutkan cukup menguasai {$highSkill} namun butuh bimbingan pada {$impSkill}." : "Nilai baik/sangat baik ({$score}): berikan apresiasi capaian {$highSkill}.");

        $prompt = "Anda adalah Guru Pengampu Mata Pelajaran '{$subjectName}' di Sekolah Dasar Islam Terpadu (SDIT Robbani) yang menerapkan Kurikulum Merdeka.
Tuliskan 1 kalimat resmi narasi Capaian Pembelajaran rapor untuk siswa:
- Nama Siswa: {$studentName}
- Mata Pelajaran: {$subjectName}
- Nilai Akhir: {$score} (Skala 0-100)
- Materi Pokok / TP: {$context}
- Arahan Nada: {$scoreContext}

PERATURAN KETAT:
1. Output HANYA SATU kalimat langsung siap cetak (maksimal 25-35 kata).
2. DILARANG memberi judul, pengantar ('Berikut adalah...'), bullet points, markdown, atau opsi pilihan.
3. JIKA nilai < 65, JANGAN gunakan kata 'menunjukkan penguasaan yang baik'. Fokus pada materi yang perlu dibimbing dan diremedial.";

        $aiText = $this->generateContent($prompt, 200, 0.6);

        if (!empty($aiText)) {
            // Bersihkan jika model masih menyertakan kata pengantar
            $lines = explode("\n", $aiText);
            foreach ($lines as $line) {
                $trimmed = trim(str_replace(['*', '"', "'", '-'], '', $line));
                if (str_starts_with(strtolower($trimmed), 'berikut') || str_starts_with(strtolower($trimmed), 'pilihan')) {
                    continue;
                }
                if (strlen($trimmed) > 20) {
                    return $trimmed;
                }
            }
        }

        // =========================================================================
        // FALLBACK CERDAS & SPESIFIK MATERI (TIDAK MONOTON / BUKAN TEMPLATE GENERIK)
        // =========================================================================
        if ($score >= 85) {
            // Predikat A (Istimewa / Mumtaz)
            return "Menunjukkan penguasaan yang sangat baik dalam {$highSkill}, memiliki nalar kritis yang tinggi, serta mandiri dalam menyelesaikan tugas.";
        } elseif ($score >= 75) {
            // Predikat B (Baik / Jayyid)
            return "Menunjukkan penguasaan yang baik dalam {$highSkill}; aktif berpartisipasi dalam pembelajaran dan konsisten menyelesaikan tugas.";
        } elseif ($score >= 65) {
            // Predikat C (Cukup / Maqbul)
            return "Cukup menguasai kompetensi dasar {$highSkill}, namun memerlukan pendampingan dan latihan lebih lanjut dalam {$impSkill}.";
        } else {
            // Predikat D (Perlu Bimbingan / Remedial)
            return "Memerlukan bimbingan intensif dan remedial terpadu pada tujuan pembelajaran: {$impSkill}. Belum mencapai ketuntasan minimal kompetensi yang diujikan.";
        }
    }

    /**
     * Generate Islamic motivational Homeroom Notes for Student Report Card
     */
    public function generateHomeroomNote(
        string $studentName,
        float $academicAverage = 85.0,
        string $characterHighlights = 'Sholeh, santun, dan rajin sholat berjamaah',
        string $attendanceInfo = '',
        string $ekskulInfo = 'Pramuka SIT & Tahfidz Club',
        int $sickCount = 0,
        int $permissionCount = 0,
        int $absentCount = 0
    ): string {
        if (empty($attendanceInfo) || ($absentCount > 0 && str_contains(strtolower($attendanceInfo), '100%'))) {
            if ($absentCount >= 3) {
                $attendanceInfo = "Tercatat {$absentCount} hari Alpha (tanpa keterangan)";
            } elseif ($absentCount > 0) {
                $attendanceInfo = "Tercatat {$absentCount} hari Alpha";
            } elseif ($sickCount >= 5) {
                $attendanceInfo = "Sakit {$sickCount} hari";
            } elseif ($absentCount === 0 && ($sickCount + $permissionCount) <= 2) {
                $attendanceInfo = "Hadir 100% tepat waktu tanpa alpha";
            } else {
                $attendanceInfo = "Sakit: {$sickCount}, Izin: {$permissionCount}, Alpha: {$absentCount}";
            }
        }

        $attendanceRule = '';
        if ($absentCount >= 3) {
            $attendanceRule = "PERINGATAN KERAS: Siswa memiliki catatan Alpha {$absentCount} hari! DILARANG KERAS memuji kehadiran 100%! WAJIB sertakan kalimat tegas dan santun mengenai pentingnya kerja sama orang tua dalam meningkatkan kedisiplinan hadir dan mengurangi alpa.";
        } elseif ($absentCount > 0) {
            $attendanceRule = "PERINGATAN: Siswa memiliki catatan Alpha {$absentCount} hari! DILARANG memuji kehadiran 100%! Sertakan dorongan untuk meningkatkan ketertiban kehadiran.";
        } elseif ($sickCount >= 5) {
            $attendanceRule = "Siswa sering izin sakit ({$sickCount} hari), sertakan doa kesehatan dan kebugaran.";
        } elseif ($absentCount == 0 && ($sickCount + $permissionCount) <= 2) {
            $attendanceRule = "Kehadiran sangat tertib (100% tanpa alpha), berikan apresiasi kedisiplinan hadir yang prima.";
        }

        $prompt = "Anda adalah Wali Kelas di SDIT Robbani.
Tuliskan 1 paragraf pendek (2-3 kalimat, maks 45 kata) catatan wali kelas resmi di buku rapor:
- Nama Siswa: {$studentName}
- Nilai Rata-rata: {$academicAverage}
- Karakter & Ibadah: {$characterHighlights}
- Kehadiran: {$attendanceInfo} (Sakit: {$sickCount}, Izin: {$permissionCount}, Alpha: {$absentCount})
- Catatan Khusus Kehadiran: {$attendanceRule}
- Ekstrakurikuler: {$ekskulInfo}

Kriteria:
1. Awali dengan doa/syukur islami ('Alhamdulillah', 'Barakallahu fiik').
2. Sampaikan pesan prestasi belajar dan karakter.
3. JIKA ada alpha atau ketidakhadiran tinggi, ingatkan kedisiplinan secara santun dan tegas.
4. Output HANYA narasi siap cetak tanpa bullet points atau pengantar.";

        $aiText = $this->generateContent($prompt, 350, 0.7);

        if (!empty($aiText)) {
            $lines = explode("\n", $aiText);
            foreach ($lines as $line) {
                $trimmed = trim(str_replace(['*', '"'], '', $line));
                if (strlen($trimmed) > 35 && !str_starts_with(strtolower($trimmed), 'berikut')) {
                    return $trimmed;
                }
            }
        }

        // Fallback islami berkualitas tinggi dengan pengaruh absensi nyata
        $attendanceClause = '';
        if ($absentCount >= 3) {
            $attendanceClause = " Perlu perhatian khusus dan bimbingan orang tua dalam meningkatkan kedisiplinan kehadiran di sekolah serta meminimalisir ketidakhadiran tanpa keterangan (alpha {$absentCount} hari).";
        } elseif ($absentCount > 0) {
            $attendanceClause = " Tingkatkan lagi ketertiban dan kehadiran di kelas agar tidak tertinggal materi pembelajaran.";
        } elseif ($sickCount >= 5) {
            $attendanceClause = " Semoga Ananda senantiasa diberikan kesehatan dan kebugaran agar dapat mengikuti KBM secara optimal.";
        } else {
            $attendanceClause = " Kedisiplinan kehadiran Ananda di sekolah sangat baik dan patut dipertahankan.";
        }

        if ($academicAverage >= 85) {
            return "Alhamdulillah, barakallahu fiik Ananda {$studentName} atas capaian prestasi belajar yang sangat istimewa di semester ini. Akhlak ananda yang santun dan istiqomah dalam ibadah menjadi teladan baik bagi teman-teman.{$attendanceClause}";
        } elseif ($academicAverage >= 75) {
            return "Alhamdulillah, Ananda {$studentName} menunjukkan perkembangan belajar yang positif dan aktif dalam kegiatan kelas. Terus tingkatkan ketekunan dalam memahami materi pelajaran serta istiqomahkan ibadah yaumiyah.{$attendanceClause}";
        } elseif ($academicAverage > 0) {
            return "Ananda {$studentName} memerlukan pendampingan dan bimbingan lebih intensif dalam mengulang pelajaran di rumah. Tingkatkan fokus belajar, ketelitian, dan motivasi berprestasi di semester berikutnya.{$attendanceClause}";
        } else {
            return "Ananda {$studentName} perlu bimbingan intensif dan kerjasama erat antara wali kelas serta orang tua dalam memantau KBM dan penyelesaian tugas belajar.{$attendanceClause}";
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
        // Cek jika nilai kosong atau 0
        if ($makhrajScore <= 0 && $tajwidScore <= 0) {
            return "Belum ada data penilaian tilawah Al-Qur'an / Ananda memerlukan pendampingan dan asesmen awal jilid Wafa dan tajwid.";
        }

        $isLowScore = ($makhrajScore > 0 && $makhrajScore < 70) || ($tajwidScore > 0 && $tajwidScore < 70);
        $scoreContext = $isLowScore ? "PERINGATAN: Nilai rendah ({$makhrajScore}/{$tajwidScore}). DILARANG memuji merdu/fasih. Berikan arahan latihan talaqqi intensif dan perbaikan makhraj/tajwid" : "Nilai sangat baik: berikan apresiasi nada Hijaz tartil";

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
            if (strlen($trimmed) > 25 && !str_starts_with(strtolower($trimmed), 'berikut')) {
                return $trimmed;
            }
        }

        // Fallback berjenjang sesuai nilai riil santri (tidak ada pujian palsu)
        if ($isLowScore) {
            return "Ananda {$studentName} memerlukan bimbingan intensif dan latihan talaqqi khusus pada pelafalan makharijul huruf serta ketepatan tajwid. Belum mencapai target kelancaran jilid Wafa.";
        } elseif ($makhrajScore >= 85 && $tajwidScore >= 85) {
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
        $stCount = (int) ($stats['total_students'] ?? 0);
        $mapelPct = (int) str_replace('%', '', $stats['mapel_progress'] ?? '0');
        $quranPct = (int) str_replace('%', '', $stats['quran_progress'] ?? '0');
        $charPct = (int) str_replace('%', '', $stats['character_progress'] ?? '0');
        $hrPct = (int) str_replace('%', '', $stats['homeroom_progress'] ?? '0');
        $walas = $stats['walas'] ?? 'Wali Kelas';

        if ($stCount === 0) {
            return "### 1. Status Kesiapan: {$classroomName}\n\n" .
                "Rombongan belajar saat ini tercatat **Belum Memiliki Siswa Aktif (0 Siswa)**. Seluruh komponen nilai (Mapel, Al-Qur'an, Karakter JSIT, dan Catatan Walas) belum dapat diinput.\n\n" .
                "### 2. Arahan Tindak Lanjut\n\n" .
                "Operator TU dan Kurikulum perlu segera melakukan penempatan siswa ke dalam rombel ini agar wali kelas ({$walas}) dapat mulai mengisi rapor.";
        }

        $prompt = "Anda adalah Asisten Analitik Sistem e-Rapor SIT Terpadu.
Berikan audit analitis kesiapan pencetakan rapor untuk rombel berikut kepada Kepala Sekolah:
- Rombel: {$classroomName} (Wali Kelas: {$walas})
- Total Siswa: {$stCount} Siswa
- Progres Nilai Mapel: {$stats['mapel_progress']}
- Progres Al-Qur'an (Wafa/TTQ): {$stats['quran_progress']}
- Progres Karakter 7 SKL JSIT: {$stats['character_progress']}
- Progres Catatan Walas & Presensi: {$stats['homeroom_progress']}
- Rata-rata Nilai: " . ($stats['average_score'] ?? '0') . "

ATURAN FORMAT STRICT (WAJIB DIPATUHI):
- DILARANG membuat kop surat resmi, nama kementerian/dinas, 'Kepada Yth', 'Dari:', 'Perihal:', 'Tanggal:', nomor surat, atau salam/tanda tangan penutup.
- Tulis langsung laporan analisis dashboard internal dalam 3 bagian dengan heading ###:
  ### 1. Status Kesiapan Rombel {$classroomName}
  ### 2. Evaluasi Komponen & Tanggung Jawab Wali Kelas ({$walas})
  ### 3. Rekomendasi Taktis Kepala Sekolah & Kurikulum";

        $aiText = $this->generateContent($prompt, 500, 0.7);

        if (!empty($aiText)) {
            // Bersihkan jika ada artefak surat
            return preg_replace('/^[*\s]*(KEMENTERIAN|Kantor Konsultan|Kepada Yth|Dari:|Perihal:|Tanggal:).*$/mi', '', $aiText);
        }

        // Fallback realistis sesuai angka progres riil
        if ($mapelPct >= 90 && $quranPct >= 90 && $charPct >= 90 && $hrPct >= 90) {
            return "### 1. Status Kesiapan Rombel {$classroomName} (TUNTAS 100%)\n\n" .
                "Alhamdulillah, rombongan belajar **{$classroomName}** di bawah bimbingan Ustadz/Ustadzah **{$walas}** telah menyelesaikan seluruh penginputan nilai (Mapel, Al-Qur'an Wafa, 7 SKL JSIT, dan Catatan Walas). Rapor siap dipratinjau dan dicetak resmi.\n\n" .
                "### 2. Evaluasi Komponen & Tanggung Jawab Wali Kelas ({$walas})\n\n" .
                "- Seluruh {$stCount} siswa memiliki kelengkapan nilai sempurna.\n" .
                "- Rata-rata kelas: " . ($stats['average_score'] ?? '0') . "\n\n" .
                "### 3. Rekomendasi Taktis Kepala Sekolah & Kurikulum\n\n" .
                "Lakukan validasi akhir dan proses cetak atau pembagian rapor digital.";
        }

        $kurang = [];
        if ($mapelPct < 80) $kurang[] = "Nilai Mapel ({$stats['mapel_progress']})";
        if ($quranPct < 80) $kurang[] = "Nilai Al-Qur'an Wafa ({$stats['quran_progress']})";
        if ($charPct < 80) $kurang[] = "Karakter 7 SKL ({$stats['character_progress']})";
        if ($hrPct < 80) $kurang[] = "Catatan Walas/Presensi ({$stats['homeroom_progress']})";
        $kurangStr = implode(', ', $kurang);

        return "### 1. Status Kesiapan Rombel {$classroomName} (DALAM PROSES)\n\n" .
            "Rombongan belajar **{$classroomName}** ({$stCount} siswa) asuhan Ustadz/Ustadzah **{$walas}** saat ini masih dalam proses pengisian.\n\n" .
            "### 2. Evaluasi Komponen & Tanggung Jawab Wali Kelas ({$walas})\n\n" .
            "- Komponen yang masih belum lengkap: **{$kurangStr}**.\n" .
            "- Penginputan harus segera diselesaikan sebelum batas waktu cetak rapor.\n\n" .
            "### 3. Rekomendasi Taktis Kepala Sekolah & Kurikulum\n\n" .
            "Kepala Sekolah disarankan segera menghubungi Wali Kelas ({$walas}) melalui WhatsApp atau koordinasi langsung agar menuntaskan sisa komponen di atas.";
    }

    /**
     * Audit Kesiapan Rapor Seluruh Rombel di Unit Sekolah
     */
    public function analyzeSchoolOverallReadiness(string $schoolName, array $classSummaries, array $overallStats): string
    {
        $totalCls = $overallStats['total_classrooms'] ?? 0;
        $totalSt = $overallStats['total_students'] ?? 0;
        $tuntasCount = $overallStats['completed_count'] ?? 0;
        $inProgCount = $overallStats['in_progress_count'] ?? 0;
        $emptyCount = $overallStats['empty_count'] ?? 0;

        $summaryTable = "";
        foreach ($classSummaries as $c) {
            $summaryTable .= "- **{$c['name']}** (Wali: {$c['walas']}): {$c['status']} ({$c['students']} siswa) — Catatan: {$c['note']}\n";
        }

        $prompt = "Anda adalah Asisten Analitik Sistem e-Rapor SIT Terpadu.
Tugas Anda adalah membuat laporan audit analitik kesiapan e-Rapor semester untuk Unit {$schoolName} yang ditujukan langsung kepada Kepala Sekolah dan Koordinator Kurikulum.

PENTING - ATURAN FORMAT STRICT (WAJIB DIPATUHI):
1. DILARANG KERAS MEMBUAT FORMAT SURAT RESMI ATAU KOP SURAT!
   - JANGAN membuat nama Kementerian, Dinas, Kantor Konsultan, dsb.
   - JANGAN menulis 'Kepada Yth', 'Dari:', 'Perihal:', 'Tanggal:', nomor surat, pembuka/penutup surat dinas.
   - Ini adalah tampilan modul dashboard sistem e-Rapor, BUKAN surat edaran.
2. WAJIB MENGULAS SELURUH {$totalCls} ROMBEL KELAS SATU PER SATU TANPA KECUALI!
   - Sebutkan dan ulas SEMUA {$totalCls} rombel yang tercantum dalam data di bawah, baik yang sudah ada nilainya MAUPUN KELAS YANG MASIH KOSONG / BELUM MENGISI SAMA SEKALI.
   - Untuk rombel yang belum mengisi nilai atau belum ada siswa, evaluasi secara tegas apa kendalanya, apa yang belum diisi oleh wali kelasnya (Mapel, Wafa, Karakter, Catatan Walas), dan apa yang harus segera dilakukan sebelum batas waktu.
3. Gunakan format Markdown yang rapi dengan heading ### dan bullet point.

DATA KELENGKAPAN UNIT {$schoolName}:
- Total Rombongan Belajar: {$totalCls} Rombel (Total {$totalSt} Siswa Aktif)
- Rombel Tuntas (100% Lengkap): {$tuntasCount} Rombel
- Rombel Sedang Proses Pengisian: {$inProgCount} Rombel
- Rombel Belum Mengisi / Masih Kosong: {$emptyCount} Rombel

DATA SETIAP ROMBEL KELAS:
{$summaryTable}

SUSUNAN LAPORAN (WAJIB MENGIKUTI 3 POIN BERIKUT):
### 1. Ringkasan Kesiapan e-Rapor Unit {$schoolName}
(Tuliskan persentase kesiapan unit, jumlah rombel yang sudah siap cetak vs yang masih tertinggal, dan estimasi beban kerja sebelum batas akhir).

### 2. Audit & Evaluasi Rinci Seluruh Rombel Kelas (Wajib Bahas Semua {$totalCls} Kelas Satu Per Satu)
(Bahaskan SEMUA {$totalCls} rombel di atas satu demi satu tanpa melewatkan satupun):
- Ulas rombel yang sudah tuntas (apresiasi wali kelasnya).
- Ulas rombel yang sedang berproses atau BELUM MENGISI SAMA SEKALI / KOSONG (sebutkan nama kelas, nama wali kelas, apa saja komponen yang masih 0%, dan tegaskan urgensi pengisian).

### 3. Instruksi & Tindak Lanjut Kepala Sekolah
(Langkah konkret pimpinan: jadwal batas akhir, pengingat via WhatsApp untuk wali kelas yang belum mengisi, dan plotting siswa jika ada rombel yang belum berpenghuni).";

        $aiText = $this->generateContent($prompt, 700, 0.7);

        if (!empty($aiText)) {
            // Bersihkan jika ada artefak surat
            $cleaned = preg_replace('/^[*\s]*(KEMENTERIAN|Kantor Konsultan|Kepada Yth|Dari:|Perihal:|Tanggal:).*$/mi', '', $aiText);
            return trim($cleaned);
        }

        $detailRombel = "";
        foreach ($classSummaries as $c) {
            $detailRombel .= "#### Rombel {$c['name']} (Wali: {$c['walas']})\n" .
                "- **Status:** {$c['status']} ({$c['students']} siswa)\n" .
                "- **Rincian Data:** {$c['note']}\n";
            if ($c['progress_pct'] >= 100) {
                $detailRombel .= "- **Evaluasi:** Alhamdulillah seluruh komponen rapor telah tuntas 100% dan siap dicetak resmi.\n\n";
            } elseif ($c['students'] === 0) {
                $detailRombel .= "- **Evaluasi:** Rombel belum memiliki data siswa terdaftar. Operator/Kurikulum perlu melakukan plotting siswa.\n\n";
            } else {
                $detailRombel .= "- **Evaluasi:** Wali kelas ({$c['walas']}) belum menuntaskan penginputan. Perlu segera dilengkapi sebelum batas waktu pengisian.\n\n";
            }
        }

        return "### 1. Ringkasan Kesiapan e-Rapor Unit {$schoolName}\n\n" .
            "Dari total **{$totalCls} Rombel** ({$totalSt} Siswa), tercatat **{$tuntasCount} rombel tuntas 100%**, **{$inProgCount} rombel dalam proses pengisian**, dan **{$emptyCount} rombel belum mengisi / masih kosong**.\n\n" .
            "### 2. Audit & Evaluasi Rinci Seluruh Rombel Kelas\n\n" .
            $detailRombel .
            "### 3. Instruksi & Tindak Lanjut Kepala Sekolah\n\n" .
            "1. **Rombel Tuntas:** Berikan apresiasi kepada wali kelas yang telah menyelesaikan pengisian 100% dan lakukan pratinjau cetak rapor.\n" .
            "2. **Rombel Belum Mengisi / Kosong:** Kepala Sekolah segera mengirimkan pesan pengingat kepada wali kelas yang bersangkutan untuk menuntaskan nilai Mapel, Al-Qur'an Wafa, Karakter 7 SKL, dan Catatan Walas sebelum batas waktu.\n" .
            "3. **Rombel 0 Siswa:** Pastikan operator TU atau staf akademik menyelesaikan pembagian rombel siswa jika kelas tersebut aktif semester ini.";
    }
}
