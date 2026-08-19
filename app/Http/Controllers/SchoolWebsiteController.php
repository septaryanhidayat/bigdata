<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\School;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Classroom;
use Illuminate\Http\Request;

class SchoolWebsiteController extends Controller
{
    public function index()
    {
        $settings = [
            'school_name' => SiteSetting::get('school_name', 'Yayasan Generasi Robbani Sumatera Selatan'),
            'tagline' => SiteSetting::get('tagline', 'Official Website Sekolah Islam Terpadu Robbani Ogan Ilir (KB/TKIT, SDIT, SMPIT, SMAIT)'),
            'hero_badge' => SiteSetting::get('hero_badge', '✨ Penerimaan Peserta Didik Baru (PPDB) 2026/2027'),
            'hero_title' => SiteSetting::get('hero_title', 'Sekolah Islam Terpadu Robbani Ogan Ilir'),
            'hero_desc' => SiteSetting::get('hero_desc', 'Mencetak Generasi Qur\'ani, Berakhlak Mulia, Cerdas, dan Berprestasi Nasional di Kabupaten Ogan Ilir, Sumatera Selatan.'),
            'hero_bg_image' => SiteSetting::get('hero_bg_image', '/uploads/cms/hero_bg_6a7f4563c3595_1786725731.webp'),
            'hero_banner_opacity' => SiteSetting::get('hero_banner_opacity', '70'),
            'principal_greeting' => SiteSetting::get('principal_greeting', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Yayasan Generasi Robbani Sumatera Selatan. Kami berkomitmen mendidik ananda menjadi pribadi beriman, bertakwa, berakhlak karimah, hafidz Al-Qur\'an, serta menguasai ilmu pengetahuan dan teknologi.'),
            'principal_name' => SiteSetting::get('principal_name', 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd'),
            'principal_title' => SiteSetting::get('principal_title', 'Ketua Yayasan Generasi Robbani Sumatera Selatan'),
            'ppdb_status' => SiteSetting::get('ppdb_status', 'SPMB / PPDB TELAH DIBUKA!'),
            'ppdb_desc' => SiteSetting::get('ppdb_desc', 'Ayo Menjadi Bagian SIT Robbani Ogan Ilir Tahun Ajaran 2026/2027 untuk jenjang KB/TKIT, SDIT, SMPIT, & SMAIT.'),
            'contact_phone' => SiteSetting::get('contact_phone', '0811747472'),
            'contact_email' => SiteSetting::get('contact_email', 'info@sitrobbani.sch.id'),
            'contact_address' => SiteSetting::get('contact_address', 'Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan'),
            'website_theme' => SiteSetting::get('website_theme', 'theme-emerald'),
            'logo_light' => SiteSetting::get('logo_light', '/images/logo robbani light.png'),
            'logo_dark' => SiteSetting::get('logo_dark', '/images/logo robbani dark.png'),
            'website_favicon' => SiteSetting::get('website_favicon', '/favicon.png'),
            'social_share_image' => SiteSetting::get('social_share_image', '/images/logo robbani light.png'),
            'principal_photo' => SiteSetting::get('principal_photo', '/images/logo robbani light.png'),
        ];

        $schools = School::withCount(['students', 'employees', 'classrooms'])->where('is_active', true)->get();
        $allSchoolsList = School::all();
        $schoolsKeyed = $allSchoolsList->keyBy(fn($s) => strtoupper($s->code));
        $totalStudents = Student::count();
        $totalEmployees = Employee::count();
        $totalClassrooms = Classroom::count();

        // Data Berita, Artikel, Fasilitas Native
        $newsList = $this->getNewsData();
        $articleList = $this->getArticleData();
        $facilityList = $this->getFacilityData();

        // Testimoni Wali Murid & Alumni Scraped
        $testimonialList = [
            [
                'name' => 'ECILIA OKTARINA, SE., MM.',
                'title' => 'Bapenda Provinsi Sumsel',
                'text' => 'Tenaga pendidik profesional dan berkompeten sangat menunjang pembelajaran. Terjalinnya kedekatan antara guru, anak, dan orang tua. Pelajaran ilmu agama serta sopan santun yang diajarkan sangat menonjol. Sekolah Robbani adalah pilihan tepat di masa globalisasi.',
                'avatar' => '/images/avatar-gray-person.svg'
            ],
            [
                'name' => 'RENNI SUSANTI, A.Md. Kep.',
                'title' => 'Perawat RSUD Ogan Ilir',
                'text' => 'Sekolah Robbani merupakan sekolah pilihan terbaik saat ini. Pembelajarannya sangat bagus, gurunya muda dan berkompeten, serta fondasi agamanya sangat kuat. Hubungan silaturahmi antara guru, siswa, dan ortu sangat erat.',
                'avatar' => '/images/avatar-gray-person.svg'
            ],
            [
                'name' => 'Bunda Mazaya',
                'title' => 'Wali Murid Alumni SDIT Robbani',
                'text' => 'Alhamdulillah selama anak saya Mazaya bersekolah di sini, banyak ilmu yang didapat terutama pengetahuan Agama, hafalan Al-Qur\'an bertambah, dan sering ikut perlombaan sehingga bertambah percaya dirinya.',
                'avatar' => '/images/avatar-gray-person.svg'
            ],
            [
                'name' => 'Calvin',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolah di Robbani enak, punya banyak teman, sekolahnya nyaman, fasilitasnya bagus, gurunya baik dan ramah, ada satpam yang stay terus jadi sekolahnya aman.',
                'avatar' => '/images/avatar-gray-person.svg'
            ],
            [
                'name' => 'Faiz',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolahnya menyenangkan, gurunya ramah, ruang kelas ber-AC jadi sangat nyaman saat belajar.',
                'avatar' => '/images/avatar-gray-person.svg'
            ],
            [
                'name' => 'Anaya Tahta',
                'title' => 'Alumni SIT Robbani TA 2020/2021',
                'text' => 'Selama sekolah di ROBBANI saya mendapatkan banyak ilmu bermanfaat, dapat menyelesaikan hafalan beberapa juz, serta diajarkan disiplin dan bertanggung jawab. Terimakasih ustadz dan bunda atas bimbingannya.',
                'avatar' => '/images/avatar-gray-person.svg'
            ]
        ];

        // Aplikasi & Portal Digital Native
        $digitalApps = [
            [
                'name' => 'ARSI (E-SPP)',
                'desc' => 'Aplikasi Robbani Student Information untuk kemudahan cek tagihan dan pembayaran SPP online.',
                'url' => route('school.espp'),
                'icon' => '💳'
            ],
            [
                'name' => 'E-Learning (LMS)',
                'desc' => 'Portal Beranda Digital LMS untuk materi pelajaran, tugas online, dan kelas interaktif.',
                'url' => route('home'),
                'icon' => '📖'
            ],
            [
                'name' => 'E-Library',
                'desc' => 'Perpustakaan digital resmi SIT Robbani untuk membaca buku online.',
                'url' => route('school.fasilitas'),
                'icon' => '📚'
            ],
            [
                'name' => 'SIM SIT Robbani',
                'desc' => 'Sistem Informasi Manajemen Terpadu untuk manajemen operasional dan akademik.',
                'url' => route('admin.dashboard'),
                'icon' => '💻'
            ],
            [
                'name' => 'PPDB Online',
                'desc' => 'Portal Pendaftaran Peserta Didik Baru SIT Robbani Ogan Ilir.',
                'url' => route('school.ppdb'),
                'icon' => '📝'
            ]
        ];

        // Layanan Terpadu Native
        $integratedServices = [
            [
                'title' => 'Izin Kunjungan Sekolah',
                'desc' => 'Form permohonan izin kunjungan studi banding atau silaturahmi ke SIT Robbani Ogan Ilir.',
                'url' => route('school.layanan.kunjungan'),
                'icon' => '🚌'
            ],
            [
                'title' => 'Permohonan Kerjasama',
                'desc' => 'Layanan kemitraan dan sinergi program pendidikan, sosial, dan dakwah.',
                'url' => route('school.layanan.kerjasama'),
                'icon' => '🤝'
            ],
            [
                'title' => 'Permohonan Sewa Fasilitas',
                'desc' => 'Layanan permohonan pemanfaatan aula, fasilitas lapangan, dan sarana sekolah.',
                'url' => route('school.layanan.sewa'),
                'icon' => '🏢'
            ]
        ];

        // Data Video, Agenda, Pengumuman, Fasilitas, Galeri & Header Menu Native / Dynamic CMS
        $videoList = $this->getVideoData();
        $agendaList = $this->getAgendaData();
        $announcementList = $this->getAnnouncementData();
        $galleryList = $this->getGalleryData();
        $headerMenus = $this->getHeaderMenus();

        // Fetch unit profiles & principal info for TKIT, SDIT, SMPIT, SMAIT
        $unitCodes = ['tkit', 'sdit', 'smpit', 'smait'];
        $unitProfiles = [];
        
        $unitDefaults = [
            'tkit' => [
                'name' => 'KB/TKIT Robbani',
                'principal_name' => 'Ustdz. Nurhidayah, S.Pd.I',
                'principal_title' => 'Kepala KB/TKIT Robbani',
                'principal_photo' => '/images/mockup_mobile_1.png',
                'desc' => 'Kelompok Bermain & TK Islam Terpadu Terakreditasi A.'
            ],
            'sdit' => [
                'name' => 'SDIT Robbani',
                'principal_name' => 'Ustdz. M. Ridwan, S.Pd',
                'principal_title' => 'Kepala SDIT Robbani',
                'principal_photo' => '/images/mockup_mobile_2.png',
                'desc' => 'Sekolah Dasar Islam Terpadu Terakreditasi B & Program Tahfidz.'
            ],
            'smpit' => [
                'name' => 'SMPIT Robbani',
                'principal_name' => 'Tia Wulandari, S.Pd., Gr.',
                'principal_title' => 'Kepala Sekolah SMPIT',
                'principal_photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104531-1_3fa9a06a.jpeg',
                'desc' => 'Sekolah Menengah Pertama Islam Terpadu Terakreditasi B (Fullday School).'
            ],
            'smait' => [
                'name' => 'SMAIT Robbani',
                'principal_name' => '—',
                'principal_title' => 'Kepala SMAIT Robbani',
                'principal_photo' => '',
                'desc' => 'Sekolah Menengah Atas dengan program unggulan sains & IT (Coming Soon).'
            ],
        ];

        foreach ($unitCodes as $c) {
            $json = SiteSetting::get("unit_profile_{$c}");
            $parsed = $json ? json_decode($json, true) : [];
            $unitProfiles[$c] = array_merge($unitDefaults[$c], array_filter($parsed ?? [], fn($v) => !is_null($v) && $v !== ''));
        }

        return view('school.home', compact(
            'settings',
            'schools',
            'totalStudents',
            'totalEmployees',
            'totalClassrooms',
            'newsList',
            'articleList',
            'facilityList',
            'testimonialList',
            'digitalApps',
            'integratedServices',
            'videoList',
            'agendaList',
            'announcementList',
            'galleryList',
            'headerMenus',
            'unitProfiles',
            'schoolsKeyed'
        ));
    }

    public function getFoundationProfile()
    {
        $cmsJson = SiteSetting::get('foundation_profile_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data)) return $data;
        }

        return [
            'name' => 'Yayasan Generasi Robbani Sumatera Selatan',
            'tagline' => 'Penyelenggara Pendidikan Islam Terpadu (KB/TKIT, SDIT, SMPIT, & SMAIT Robbani Ogan Ilir)',
            'founded_year' => '2014',
            'chairman_name' => 'Sughesti Wulandari, S.Pd',
            'chairman_title' => 'Ketua Yayasan Generasi Robbani Sumatera Selatan',
            'chairman_photo' => '/images/logo-robbani-official.png',
            'chairman_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh.<br><br>Alhamdulillah, puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT yang telah melimpahkan rahmat, hidayah, dan inayah-Nya kepada kita semua. Sholawat serta salam semoga senantiasa tercurah kepada junjungan kita Nabi Besar Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.<br><br>Yayasan Generasi Robbani Sumatera Selatan berkomitmen penuh menghadirkan ekosistem pendidikan Islam Terpadu yang unggul, berkarakter Qur\'ani, dan adaptif terhadap perkembangan sains teknologi digital di Kabupaten Ogan Ilir.',
            'vision' => 'Menjadi Lembaga Pendidikan Islam Terpadu Pilihan Utama di Sumatera Selatan yang Mencetak Generasi Rabbani Beriman, Hafidz Al-Qur\'an, Berakhlak Karimah, Unggul Akademik, dan Siap Memimpin di Era Digital.',
            'missions' => [
                'Menyelenggarakan pendidikan Islam Terpadu berstandar JSIT dari usia dini (TK) hingga jenjang menengah atas (SMA).',
                'Membina kecintaan terhadap Al-Qur\'an melalui target hafalan bertahap dan pendampingan adab islami.',
                'Mengembangkan kecerdasan digital, kepemimpinan, dan kemandirian berprestasi secara berkelanjutan.',
                'Membangun sinergi kokoh antara sekolah, wali murid, dan masyarakat dalam membentuk karakter anak.'
            ],
            'pillars' => [
                ['title' => 'Pembiasaan & Tahfidz Al-Qur\'an', 'desc' => 'Target hafalan mutqin Juz 30 & Juz 1–5 dengan bimbingan ustadz-ustadzah teruji.', 'icon' => '📖'],
                ['title' => 'Bina Pribadi Islami (BPI)', 'desc' => 'Pembinaan akhlak, adab harian, mabit, dan mutabaah yaumiyah secara terukur.', 'icon' => '🤲'],
                ['title' => 'Integrasi Kurikulum JSIT & Merdeka', 'desc' => 'Perpaduan standar akademis nasional Kurikulum Merdeka dengan kekhasan JSIT.', 'icon' => '🎓'],
                ['title' => 'Ekosistem Digital SmartEdu', 'desc' => 'Presensi RFID gate, E-SPP cashless, dan portal belajar digital modern.', 'icon' => '💻'],
                ['title' => 'Sinergi Orang Tua & Sekolah', 'desc' => 'Komunikasi intensif melalui Parenting Session dan POMG berkala.', 'icon' => '🤝']
            ],
            'executives' => [
                ['name' => 'Sughesti Wulandari, S.Pd', 'role' => 'Ketua Yayasan', 'photo' => '/images/logo-robbani-official.png']
            ]
        ];
    }

    public function profil()
    {
        $settings = $this->getSettings();
        $schools = School::where('is_active', true)->get();
        $foundationProfile = $this->getFoundationProfile();
        return view('school.profil', compact('settings', 'schools', 'foundationProfile'));
    }

    public function unitProfile($code)
    {
        $cleanCode = strtolower($code);
        if ($cleanCode === 'kbtkit') {
            $cleanCode = 'tkit';
        }

        $cleanCode = strtolower(trim($code));
        $school = School::withCount(['students', 'employees', 'classrooms'])
            ->where('code', strtoupper($cleanCode))
            ->first();

        // Get dynamic unit profile override from SiteSetting if available
        $dynamicUnitSetting = SiteSetting::get("unit_profile_{$cleanCode}");
        $customUnit = $dynamicUnitSetting ? json_decode($dynamicUnitSetting, true) : null;

        $unitMap = [
            'tkit' => [
                'name' => 'KB & TKIT Robbani Ogan Ilir',
                'code' => 'TKIT',
                'npsn' => '69888765',
                'akreditasi' => 'Terakreditasi Unggul (A)',
                'kurikulum' => 'JSIT & Merdeka PAUD',
                'tagline' => 'Tumbuh Ceria, Berakhlak Mulia, & Hafiz Juz 30 Cilik',
                'principal_name' => 'Ani Oktar Yansi, S.Pd.I',
                'principal_title' => 'Kepala KB/TKIT Robbani',
                'principal_photo' => '/uploads/media/gtk_tk_ani-oktar-yansi-spd-i-scaled_0a6337c9.jpg',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di KB/TKIT Robbani Ogan Ilir. Masa usia dini adalah masa keemasan (golden age) untuk menanamkan pondasi aqidah, adab islami, serta kecintaan pada Al-Qur\'an melalui suasana bermain yang edukatif dan menggembirakan.',
                'description' => 'Kelompok Bermain & Taman Kanak-Kanak Islam Terpadu Terakreditasi A di Ogan Ilir. Membina fitrah anak sejak dini dengan pendekatan sentra, pembiasaan hafalan surat-surat pendek Juz 30, doa harian, kemandirian, dan stimulasi motorik terpadu.',
                'vision' => 'Menjadi Lembaga PAUD Islam Terpadu Unggulan dalam Membentuk Karakter Anak Sholeh, Ceria, dan Berakhlak Qur\'ani.',
                'missions' => [
                    'Menanamkan aqidah yang lurus dan pembiasaan ibadah harian sejak usia dini.',
                    'Membimbing hafalan Al-Qur\'an Juz 30 dengan metode nasyid yang menyenangkan.',
                    'Mengembangkan potensi kecerdasan majemuk (multiple intelligences) dan motorik anak melalui bermain berbasis sentra.',
                    'Membangun sinergi harmonis antara sekolah dan keluarga dalam mendampingi tumbuh kembang ananda.'
                ],
                'phone' => '0811747472',
                'students_count' => 120,
                'employees_count' => 14,
                'classrooms_count' => 6,
                'target_hafalan' => 'Juz 30 (Surah Pendek)',
                'programs' => [
                    ['title' => 'Tahfidz Juz 30 Cilik', 'icon' => '📖', 'desc' => 'Metode hafalan Al-Qur\'an nada nasyid yang menyenangkan khusus anak usia 3-6 tahun.'],
                    ['title' => 'Adab & Doa Harian', 'icon' => '🤲', 'desc' => 'Pembiasaan sholat dhuha berjamaah, doa harian, dan adab islami harian.'],
                    ['title' => 'Sentra Edukatif & Motorik', 'icon' => '🎨', 'desc' => 'Eksplorasi sensorik, seni lukis, balok konstruksi, dan permainan ketangkasan fisik.'],
                    ['title' => 'Billingual Basic Kids', 'icon' => '🗣️', 'desc' => 'Pengenalan kosakata dasar Bahasa Arab & Inggris sehari-hari melalui kuis & lagu.']
                ],
                'teachers' => [
                    ['name' => 'Dia Fitri Yani, S.Pd', 'role' => 'Guru Sentra Balok & Motorik', 'photo' => '/uploads/media/gtk_tk_dia_9992b8e6.jpeg'],
                    ['name' => 'Nopitri Rosah, S.Pd', 'role' => 'Guru Sentra Persiapan & Literasi', 'photo' => '/uploads/media/gtk_tk_ocha_ce0626c2.jpeg'],
                    ['name' => 'Susanti, S.Pd.I', 'role' => 'Guru Tahfidz Al-Qur\'an & PAI', 'photo' => '/uploads/media/gtk_tk_susan_5fcc63ea.jpeg'],
                    ['name' => 'Yunisa, S.Pd', 'role' => 'Guru Sentra Main Peran & Bahasa', 'photo' => '/uploads/media/gtk_tk_yunisa_2de7f85f.jpeg'],
                    ['name' => 'Zahrotun Jannati, S.Pd', 'role' => 'Guru Sentra Bahan Alam & Ibadah', 'photo' => '/uploads/media/gtk_tk_zahro_5e0084ad.jpeg'],
                    ['name' => 'Rojanah, S.E', 'role' => 'Staff Keuangan & Tata Usaha', 'photo' => '/uploads/media/gtk_tk_4-scaled_640e548f.jpg'],
                    ['name' => 'Minarti, S.Pd', 'role' => 'Guru Sentra Seni & Kreativitas', 'photo' => '/uploads/media/gtk_tk_5-scaled_67583fbf.jpg'],
                    ['name' => 'Neli Wati, S.Pd', 'role' => 'Guru Kelas Kelompok Bermain (KB)', 'photo' => '/uploads/media/gtk_tk_6-scaled_b4639f16.jpg'],
                    ['name' => 'Putri Nabila, S.Pd', 'role' => 'Guru Pendamping & Motorik Anak', 'photo' => '/uploads/media/gtk_tk_7-scaled_b0b5f4cd.jpg'],
                    ['name' => 'Rhodotun Nikmah, S.Pd', 'role' => 'Guru Sentra Imtaq & Doa Harian', 'photo' => '/uploads/media/gtk_tk_8-scaled_d8ee33e6.jpg'],
                    ['name' => 'Rizqy Maharani B. P., S.Pd', 'role' => 'Guru Bilingual Basic Kids', 'photo' => '/uploads/media/gtk_tk_9-scaled_6b8397e4.jpg'],
                    ['name' => 'Aisyah Enjelita, S.Pd', 'role' => 'Staff Administrasi & Layanan Siswa', 'photo' => '/uploads/media/gtk_tk_whatsapp-image-2025-10-08-at-085210_5e9ab9e6.jpeg']
                ],
                'alumni' => [
                    ['name' => 'Bunda Mazaya', 'title' => 'Wali Murid TKIT Robbani', 'text' => 'Anak saya Mazaya menjadi sangat mandiri, rajin sholat, dan hafal surah pendek dengan lagu yang fasih.', 'avatar' => '/uploads/media/galeri_tk_whatsapp-image-2025-11-24-at-100627_b216eee9.jpeg'],
                    ['name' => 'Renni Susanti, A.Md.Kep', 'title' => 'Perawat & Wali Murid', 'text' => 'Lingkungan TKIT Robbani sangat bersih, aman, dan ustadzah pendidiknya sangat ramah membimbing anak.', 'avatar' => '/uploads/media/galeri_tk_whatsapp-image-2025-11-24-at-102111_3544c740.jpeg']
                ],
                'facilities' => [
                    ['title' => 'Loker di Setiap Kelas', 'badge' => 'Kemandirian Anak', 'icon' => '🎒', 'desc' => 'Setiap anak mempunyai loker pribadi masing-masing di kelasnya.', 'image' => '/uploads/media/tkit_post_Loker-scaled_a03171c9.jpeg'],
                    ['title' => 'Permainan Outdoor', 'badge' => 'Motorik Kasar', 'icon' => '🛝', 'desc' => 'Tempat Permainan Outdoor yang nyaman, bersih dan dilengkapi oleh CCTV.', 'image' => '/uploads/media/tkit_post_WhatsApp-Image-2025-11-04-at-09_52__03a061e9.jpeg'],
                    ['title' => 'Tempat Wudhu Anti-Slip', 'badge' => 'Pembiasaan Ibadah', 'icon' => '💧', 'desc' => 'Tempat wudhu yang bersih dan alas lantai anti slip dan dilengkapi dengan CCTV.', 'image' => '/uploads/media/tkit_post_WhatsApp-Image-2025-11-05-at-10_00__9f198ecf.jpeg'],
                    ['title' => 'Teras Bersih & CCTV', 'badge' => 'Area Bermain', 'icon' => '🌿', 'desc' => 'Teras yang bersih dan dilengkapi CCTV, tempat anak main diluar ruangan yang nyaman.', 'image' => '/uploads/media/tkit_post_WhatsApp-Image-2025-11-05-at-10_07__c2bf2e5f.jpeg']
                ]
            ],
            'sdit' => [
                'name' => 'SDIT Robbani Ogan Ilir',
                'code' => 'SDIT',
                'npsn' => '69985678',
                'akreditasi' => 'Terakreditasi B',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Mencetak Generasi Qur\'ani, Berkarakter Karimah, & Cerdas Sains',
                'principal_name' => 'Nur Amalia, S.Pd',
                'principal_title' => 'Kepala Sekolah SDIT Robbani Ogan Ilir',
                'principal_photo' => '/uploads/media/gtk_sd_nur-amalia-s-pd_99acbccf.png',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di SDIT Robbani. Kami berkomitmen memberikan pendidikan dasar terbaik yang menyeimbangkan antara capaian hafalan Al-Qur\'an, akademik sains unggulan, serta kepemimpinan berakhlak mulia.',
                'description' => 'Sekolah Dasar Islam Terpadu berakreditasi B di Ogan Ilir. Memadukan Kurikulum Merdeka Nasional Terintegrasi Kekhasan JSIT (Jaringan Sekolah Islam Terpadu), Tahfidz Al-Qur\'an 3-5 Juz Mutqin, Sains Olimpic Club, Koding Digital, & Pembentukan Karakter Islam.',
                'vision' => 'Menjadi Sekolah Dasar Islam Terpadu Model dalam Mencetak Generasi Qur\'ani, Cerdas Berakhlak, dan Berprestasi Nasional.',
                'missions' => [
                    'Menyelenggarakan bimbingan Al-Qur\'an dengan target kelulusan minimal 3-5 Juz secara mutqin.',
                    'Menerapkan Kurikulum Merdeka Terintegrasi Kekhasan JSIT dan pembiasaan ibadah harian.',
                    'Mengembangkan minat bakat siswa dalam bidang sains, koding digital, seni, dan kepanduan.',
                    'Membentuk karakter kepemimpinan islami melalui pembinaan Bina Pribadi Islam (BPI).'
                ],
                'phone' => '0811747472',
                'students_count' => 450,
                'employees_count' => 38,
                'classrooms_count' => 18,
                'target_hafalan' => '3 - 5 Juz Mutqin',
                'programs' => [
                    ['title' => 'Tahfidz Al-Qur\'an 3-5 Juz', 'icon' => '📖', 'desc' => 'Bimbingan tasmi\', murojaah harian, dan wisuda tahfidz tahunan bersama hafidz tersertifikasi.'],
                    ['title' => 'Bina Pribadi Islam (BPI)', 'icon' => '🌟', 'desc' => 'Mentoring kelompok kecil untuk penanaman aqidah, karakter, dan kepemimpinan islami.'],
                    ['title' => 'Koding & Science Club', 'icon' => '💻', 'desc' => 'Pembelajaran dasar pemograman, robotik sederhana, dan eksperimen sains sekolah.'],
                    ['title' => 'Pramuka SIT & Archery', 'icon' => '🏹', 'desc' => 'Kegiatan kepanduan khas JSIT, panahan sunnah, serta ketangkasan fisik outdoor.']
                ],
                'teachers' => [
                    ['name' => 'Nur Amalia, S.Pd', 'role' => 'Kepala Sekolah', 'photo' => '/uploads/media/gtk_sd_nur-amalia-s-pd_99acbccf.png'],
                    ['name' => 'Dian Kemala Astuti, S.Pd', 'role' => 'Wakil Kepala Sekolah', 'photo' => '/uploads/media/gtk_sd_dian-kemala-astuti-spd_e347e53e.png'],
                    ['name' => 'Ranti Saputri, S.TP', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_ranti-saputri-s-tp_5199b18b.png'],
                    ['name' => 'Rini Nur Aisyah, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_rini-nur-aisyah-spd_62500a42.png'],
                    ['name' => 'Verda Novita Sari, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_verda-novita-sari-spd_ad452dad.png'],
                    ['name' => 'Dwi Misgiyati, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_dwi-misgiyati-spd-1_e732e7cf.png'],
                    ['name' => 'Marisa, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_marisa-spd_130e5322.png'],
                    ['name' => 'Veti Susanti, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_veti-susanti-spd-1_59757bcc.png'],
                    ['name' => 'Annisa Fatihah Salsabila, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_annisa-fatihah-salsabila-spd_44fd8f4a.png'],
                    ['name' => 'Risfina Ayu Rochmayani, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_risfina-ayu-rochmayani-spd_3791bc4c.png'],
                    ['name' => 'Yara Dwinadia, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_yara-dwinadia-spd_3fc4a612.png'],
                    ['name' => 'Rika Damayanti, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_rika-damayanti-spd-1_7a98d317.png'],
                    ['name' => 'Reni Zahara, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_reni-zahara-s-pd_bab4d1d8.png'],
                    ['name' => 'Dita Irfaul Khasanah, S.Si', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_dita-irfaul-khasanah-ssi_57bffe6b.png'],
                    ['name' => 'Sarah Salsabilah, S.Pd', 'role' => 'Guru Kelas', 'photo' => '/uploads/media/gtk_sd_sarah-salsabilah-spd-1_f536c3f5.png'],
                    ['name' => 'Anisa, S.Pd', 'role' => 'Guru Kelas & Guru TTQ', 'photo' => '/uploads/media/gtk_sd_anisa-spd_c33d9a96.png'],
                    ['name' => 'Apriliah, S.Ag', 'role' => 'Guru Kelas & Guru TTQ', 'photo' => '/uploads/media/gtk_sd_annisa-fatihah-salsabila-spd-2_d59d918b.png'],
                    ['name' => 'Sholahuddin Gultom, S.Pd', 'role' => 'Guru Kelas & Guru Olahraga', 'photo' => '/uploads/media/gtk_sd_sholahudin-gultom-spd_b287c1f1.png'],
                    ['name' => 'Ahmad Firdaus', 'role' => 'Guru Kelas & Guru Olahraga', 'photo' => '/uploads/media/gtk_sd_ahmad-firdaus_265113a5.png'],
                    ['name' => 'Risma Nia, S.Sos', 'role' => 'Staff TU', 'photo' => '/uploads/media/gtk_sd_risma-nia-ssos_5f30d015.png'],
                    ['name' => 'Fredy Kurniawan', 'role' => 'Security', 'photo' => '/uploads/media/gtk_sd_fredy-kurniawan_977beb19.png'],
                ],
                'alumni' => [
                    ['name' => 'Ecilia Oktarina, SE., MM.', 'title' => 'Wali Murid SDIT Robbani', 'text' => 'Pendidikan karakter dan kepemimpinan di SDIT Robbani sangat terasa perubahannya pada kebiasaan sholat anak di rumah.', 'avatar' => '/uploads/media/gtk_sd_nur-amalia-s-pd_99acbccf.png'],
                    ['name' => 'Anaya Tahta', 'title' => 'Alumni SDIT Robbani 2020', 'text' => 'Selama di SDIT Robbani saya mendapatkan hafalan Al-Qur\'an beberapa juz dan fondasi akademik sains yang kuat.', 'avatar' => '/uploads/media/gtk_sd_ranti-saputri-s-tp_5199b18b.png']
                ],
                'facilities' => [
                    ['title' => 'Kolam Renang Sekolah', 'badge' => 'Fasilitas Unggulan SDIT', 'icon' => '🏊‍♂️', 'desc' => 'SD Islam Terpadu Robbani memiliki kolam renang sendiri di sekolah dan memiliki ekskul renang yang rutin dilaksanakan.', 'image' => '/uploads/media/fasilitas_sd_img-20250117-wa0010-scaled_4afcf92f.jpg'],
                    ['title' => 'Ruang Kelas Ber-AC', 'badge' => 'Ruang Belajar', 'icon' => '❄️', 'desc' => 'SD Islam Terpadu Robbani memiliki ruang kelas yang semuanya didesain senyaman mungkin melalui penyediaan fasilitas AC dan penerangan.', 'image' => '/uploads/media/fasilitas_sd_ruang-kls_a2b54fd4.jpg'],
                    ['title' => 'Mushola atau Saung', 'badge' => 'Sarana Ibadah', 'icon' => '🕌', 'desc' => 'SD Islam Terpadu Robbani memiliki mushola atau saung yang didesain unik sehingga siswa terasa nyaman ketika beribadah.', 'image' => '/uploads/media/fasilitas_sd_saung_f3942ec8.jpg'],
                    ['title' => 'Aula Sekolah', 'badge' => 'Gedung Pertemuan', 'icon' => '🏛️', 'desc' => 'SD Islam Terpadu Robbani memiliki ruangan aula yang biasanya digunakan untuk event, seminar, atau kegiatan upacara sekolah.', 'image' => '/uploads/media/fasilitas_sd_img-20250719-wa0064-scaled_f5e59e9a.jpg'],
                    ['title' => 'Lapangan Olahraga', 'badge' => 'Area Ketangkasan', 'icon' => '⚽', 'desc' => 'SD Islam Terpadu Robbani mempunyai lapangan olahraga di ruang terbuka sebagai pelataran aktivitas fisik siswa.', 'image' => '/uploads/media/fasilitas_sd_img-20241105-110318-scaled_531016d4.jpg']
                ]
            ],
            'smpit' => [
                'name' => 'SMP IT ROBBANI',
                'code' => 'SMPIT',
                'npsn' => '69989012',
                'akreditasi' => 'Terakreditasi B',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Because Every Child is Unique (Berbasis Digital & Pendidikan Karakter)',
                'principal_name' => 'Tia Wulandari, S.Pd., Gr.',
                'principal_title' => 'Kepala Sekolah SMP IT Robbani Ogan Ilir',
                'principal_photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104531-1_3fa9a06a.jpeg',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi SMP IT Robbani Ogan Ilir. Kami memadukan kecerdasan digital, pembinaan akhlak mulia, tahfidz Al-Qur\'an, dan pembelajaran berpusat pada keunikan setiap siswa (Because Every Child is Unique) untuk melahirkan generasi robbani yang beriman, bertaqwa, unggul dalam IPTEK, serta berwawasan global.',
                'description' => 'SMP IT Robbani adalah sekolah menengah pertama Islam terpadu unggulan di Ogan Ilir yang memadukan kecerdasan digital (SIPAKAR V2), kemuliaan akhlak, tahfidz Al-Qur\'an, dan pendidikan karakter islami (Fullday School). Alamat: Jln. Sarjana Padang Guci, Kelurahan Timbangan, Kecamatan Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan.',
                'vision' => 'Menjadi Sekolah Menengah Pertama Terbaik di Indonesia pada tahun 2032',
                'missions' => [
                    'Membentuk Peserta Didik yang cerdas, kreatif dan terpuji berdasarkan nilai Islam dan pendidikan Karakter',
                    'Membentuk Guru dan Tenaga Kependidikan yang handal dan Profesional',
                    'Menjadi lembaga Pendidikan yang Kokoh dan terkelola secara Optimal',
                    'Membangun kerjasama dengan orang tua Peserta Didik, masyarakat dan stake holder lainnya'
                ],
                'phone' => '085377193977',
                'students_count' => 280,
                'employees_count' => 12,
                'classrooms_count' => 10,
                'target_hafalan' => '5 - 10 Juz Mutqin',
                'programs' => [
                    ['title' => 'SIPAKAR V2 Digital Learning', 'icon' => '💻', 'desc' => 'Pembelajaran digital terintegrasi sistem presensi, modul CBT, dan rekam jejak hafalan.'],
                    ['title' => 'Fullday School & Karakter Islami', 'icon' => '🏫', 'desc' => 'Pembiasaan ibadah harian, sholat dhuha & dhuhur berjamaah, mentoring adab, dan kemandirian.'],
                    ['title' => 'Tahfidz Al-Qur\'an 5-10 Juz', 'icon' => '📜', 'desc' => 'Bimbingan tasmi\', murojaah berkala, dan wisuda tahfidz dengan target hafalan mutqin.'],
                    ['title' => 'Bilingual Club (Arab & Inggris)', 'icon' => '🌍', 'desc' => 'Pembiasaan percakapan harian 2 bahasa asing dan pembinaan public speaking siswa.']
                ],
                'teachers' => [
                    ['name' => 'Tia Wulandari, S.Pd., Gr.', 'role' => 'Kepala Sekolah SMPIT', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104531-1_3fa9a06a.jpeg'],
                    ['name' => 'Atika Junie Astuti, S.P', 'role' => 'Guru IPA, TTQ & BPI', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-110541_b299e525.jpeg'],
                    ['name' => 'Nini Anggraini, S.Pd', 'role' => 'Guru Hadist, PAI & TTQ', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104530_30ee68d0.jpeg'],
                    ['name' => 'Sulis Setya Ningsih, S.Pd', 'role' => 'Guru IPS & Seni Teater', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104532_3126be1f.jpeg'],
                    ['name' => 'Anita Septia, S.Pd', 'role' => 'Guru Bahasa Indonesia', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104531-2_2f796280.jpeg'],
                    ['name' => 'Rifda Saugina, S.Pd', 'role' => 'Guru Bahasa Inggris', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104530-1_2c9bcfe7.jpeg'],
                    ['name' => 'Nurbaiti Mafaza, Lc', 'role' => 'Guru Bahasa Arab & TTQ', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104530-2_065e94be.jpeg'],
                    ['name' => 'Ega Maharani, S.Si., Gr.', 'role' => 'Guru Matematika & TIK', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104531_eb838cb9.jpeg'],
                    ['name' => 'Syaifudin, S.Sn', 'role' => 'Guru PJOK & Seni Rupa', 'photo' => '/uploads/media/whatsapp-image-2024-12-03-at-104527_df1d1872.jpeg'],
                    ['name' => 'Nurul Hamida Yanti, S.E.', 'role' => 'Guru PAI, Hadist & TTQ', 'photo' => '/uploads/media/guru-smp-3_4_20250930_141746_0000_c5eaee11.png'],
                    ['name' => 'Muhammad Yusuf, S.Sos', 'role' => 'Guru PKN & Bahasa Inggris', 'photo' => '/uploads/media/guru-smp-3_4_20250811_094836_0002_09c00b0d.png'],
                    ['name' => 'Adelia Jesika, S.Pd', 'role' => 'Staff Tata Usaha', 'photo' => '/uploads/media/guru-smp-3_4_20250930_141708_0000_17aa18d5.png']
                ],
                'alumni' => [
                    ['name' => 'Bismad Kuntakana Fadta Al-Rafly', 'title' => 'Siswa Berprestasi - Atlet Taekwondo PORPROV & Internasional', 'text' => 'Di SMP IT Robbani saya didukung penuh untuk berprestasi di tingkat nasional tanpa meninggalkan hafalan Al-Qur\'an.', 'avatar' => '/uploads/media/img20251124075603-scaled_0267776a.jpg'],
                    ['name' => 'Faiz', 'title' => 'Alumni SMPIT Robbani', 'text' => 'Pendidikan di SMPIT Robbani melatih saya mandiri, disiplin ibadah harian, dan hafal Al-Qur\'an.', 'avatar' => '/images/mockup_mobile_5.png'],
                    ['name' => 'Calvin', 'title' => 'Siswa SMPIT Robbani', 'text' => 'Fasilitas belajarnya lengkap, ruang kelas nyaman ber-AC, gurunya ramah dan selalu mendampingi siswa.', 'avatar' => '/images/mockup_mobile_4.png']
                ],
                'facilities' => [
                    ['title' => 'Gedung Sekolah Representatif', 'badge' => 'Gedung Utama', 'icon' => '🏢', 'desc' => 'Gedung sekolah SMPIT Robbani yang bersih, kokoh, representatif, serta dilengkapi sistem pengamanan dan lingkungan asri.', 'image' => '/uploads/media/smpit_post_IMG20241017130510-scaled_9f90cc01.jpg'],
                    ['title' => 'Ruang Kelas Digital Ber-AC', 'badge' => 'Ruang Kelas', 'icon' => '💻', 'desc' => 'SMP IT Robbani memiliki ruang kelas yang nyaman. Setiap ruang kelas di SMP IT Robbani sudah memiliki fasilitas AC, Kipas Angin, Loker dan Pojok Baca.', 'image' => '/uploads/media/smpit_post_WhatsApp-Image-2024-12-02-at-07_19__829cf6ca.jpeg'],
                    ['title' => 'Toilet Bersih & Higienis', 'badge' => 'Sanitasi', 'icon' => '🚾', 'desc' => 'SMP IT Robbani memiliki toilet bersih dan nyaman yang dilengkapi dengan wastafel, Toilet duduk dan jongkok bagi siswa.', 'image' => '/uploads/media/smpit_post_WhatsApp-Image-2024-12-02-at-07_33__9d557901.jpeg'],
                    ['title' => 'Tablet Digital Siswa', 'badge' => 'Teknologi Pembelajaran', 'icon' => '📱', 'desc' => 'Siswa SMP IT Robbani mendapatkan fasilitas Tablet bagi siswanya untuk menunjang proses pembelajaran digital.', 'image' => '/uploads/media/smpit_post_WhatsApp-Image-2024-12-03-at-10_49__3ee84d3e.jpeg'],
                    ['title' => 'Kantin Sehat Sekolah', 'badge' => 'Nutrisi Siswa', 'icon' => '🍱', 'desc' => 'Kantin sehat dan bersih menunjang gizi serta kebutuhan konsumsi harian siswa SMPIT Robbani.', 'image' => '/uploads/media/smpit_post_IMG20250811095348-scaled_6c4155a3.jpg'],
                    ['title' => 'Lapangan Olahraga Sekolah', 'badge' => 'Area Olahraga', 'icon' => '🏀', 'desc' => 'Lapangan olahraga terbuka untuk aktivitas futsal, basket, memanah, volly, dan kegiatan fisik santri.', 'image' => '/uploads/media/smpit_post_IMG20250827110303-scaled_7c511924.jpg']
                ]
            ],
            'smait' => [
                'name' => 'SMAIT Robbani Ogan Ilir',
                'code' => 'SMAIT',
                'npsn' => '69983456',
                'akreditasi' => 'Dalam Tahap Persiapan',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Center of Excellence: Science, IT, Tahfidz 10-30 Juz, & Mentoring PTN',
                'principal_name' => '—',
                'principal_title' => 'Kepala Sekolah SMAIT Robbani',
                'principal_photo' => '',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. SMAIT Robbani dipersiapkan untuk mengantarkan para siswa memimpin masa depan, unggul dalam seleksi UTBK PTN ternama (UI, ITB, UGM, UNSRI), serta berjiwa Huffazh Al-Qur\'an yang tangguh.',
                'description' => 'Sekolah Menengah Atas Islam Terpadu jenjang lanjutan berfokus pada persiapan tembus PTN Favorit & Beasiswa Luar Negeri, Tahfidz Al-Qur\'an 10-30 Juz berijazah sanad, serta Riset Sains & Leadership (Coming Soon).',
                'vision' => 'Menjadi SMAIT Unggulan Nasional dalam Melahirkan Ilmuwan Muslim, Huffazh Al-Qur\'an, dan Pemimpin Masa Depan.',
                'missions' => [
                    'Menyelenggarakan bimbingan intensif UTBK-SNBT dan seleksi PTN / Beasiswa Luar Negeri.',
                    'Melahirkan lulusan berjiwa Huffazh Al-Qur\'an target 10-30 Juz berijazah sanad.',
                    'Mendorong riset sains remaja, inovasi koding digital, dan karya ilmiah tingkat nasional.',
                    'Membentuk karakter kader dakwah dan pemimpin berintegritas tinggi.'
                ],
                'phone' => '0811747472',
                'students_count' => 0,
                'employees_count' => 0,
                'classrooms_count' => 0,
                'target_hafalan' => '10 - 30 Juz (Huffazh)',
                'programs' => [
                    ['title' => 'Bimbingan Intensif PTN & Beasiswa', 'icon' => '🎓', 'desc' => 'Tryout SNBT berkala, pemetaan jurusan, dan pendampingan lolos perguruan tinggi ternama.'],
                    ['title' => 'Tahfidz 10-30 Juz & Sanad', 'icon' => '📖', 'desc' => 'Program khusus siswa tahfidz dengan target mutqin dan persiapan pengambilan sanad.'],
                    ['title' => 'Riset Sains & Technology Project', 'icon' => '🧪', 'desc' => 'Penelitian ilmiah remaja, karya tulis ilmiah, dan proyek teknologi buatan siswa.'],
                    ['title' => 'Public Speaking & Leadership', 'icon' => '🎙️', 'desc' => 'Latihan pidato 3 bahasa, manajemen organisasi OSIS, dan debat internasional.']
                ],
                'teachers' => [],
                'alumni' => [],
                'facilities' => [
                    ['title' => 'Laboratorium Komputer & Coding', 'badge' => 'Laboratorium Digital', 'icon' => '💻', 'desc' => 'Fasilitas komputer berspesifikasi tinggi untuk simulasi UTBK, koding, dan karya digital.', 'image' => '/images/mockup_desktop_1.png'],
                    ['title' => 'Laboratorium Sains Terpadu', 'badge' => 'Riset & Eksperimen', 'icon' => '🔬', 'desc' => 'Ruang praktikum Kimia, Fisika, dan Biologi lengkap untuk persiapan Olimpiade Sains.', 'image' => '/images/mockup_desktop_2.png'],
                    ['title' => 'Perpustakaan Digital & Riset', 'badge' => 'Pusat Belajar', 'icon' => '📚', 'desc' => 'Akses e-book internasional, jurnal sains, serta area riset privat seleksi PTN.', 'image' => '/images/mockup_desktop_3.png'],
                    ['title' => 'Ruang Kelas Multimedia Ber-AC', 'badge' => 'Ruang Belajar', 'icon' => '🏫', 'desc' => 'Ruang kelas modern ber-AC dilengkapi proyektor smart board & internet cepat.', 'image' => '/images/mockup_desktop_4.png']
                ]
            ]
        ];

        $uKey = isset($unitMap[$cleanCode]) ? $cleanCode : 'sdit';
        $defaultInfo = $unitMap[$uKey];

        // Merge custom setting if present
        $info = array_merge($defaultInfo, array_filter($customUnit ?? []));

        if (empty($info['programs'])) {
            $info['programs'] = $defaultInfo['programs'] ?? [];
        }
        if (empty($info['facilities'])) {
            $info['facilities'] = $defaultInfo['facilities'] ?? [];
        }
        if (empty($info['ekskul'])) {
            $info['ekskul'] = $defaultInfo['ekskul'] ?? [];
        }
        if (empty($info['teachers'])) {
            $info['teachers'] = $defaultInfo['teachers'] ?? [];
        }

        if ($school) {
            $school->name = $info['name'];
            $school->npsn = $info['npsn'];
            $school->principal_name = $info['principal_name'];
            $school->description = $info['description'];
            $school->phone = $info['phone'];
        } else {
            $school = (object) [
                'id' => 1,
                'name' => $info['name'],
                'code' => $info['code'],
                'npsn' => $info['npsn'],
                'principal_name' => $info['principal_name'],
                'description' => $info['description'],
                'phone' => $info['phone'],
                'students_count' => $info['students_count'],
                'employees_count' => $info['employees_count'],
                'classrooms_count' => $info['classrooms_count'],
                'programs' => $info['programs'],
            ];
        }

        $students = Student::where('school_id', $school->id ?? 1)->where(function($q) { $q->where('status', 'aktif')->orWhere('status', 'ACTIVE'); })->take(10)->get();
        $teachers = Employee::where('school_id', $school->id ?? 1)->where('is_active', true)->take(8)->get();
        $classrooms = Classroom::where('school_id', $school->id ?? 1)->with('level')->get();

        $settings = $this->getSettings();
        $headerMenus = $this->getHeaderMenus();

        // Filter unit news strictly relevant to this unit
        $allNews = $this->getNewsData();
        $unitNews = collect($allNews)->filter(function($item) use ($cleanCode) {
            $u = strtolower($item['unit'] ?? '');
            $cat = strtolower($item['category'] ?? '');
            return $u === $cleanCode || str_contains($cat, $cleanCode) || str_contains(strtolower($item['title'] ?? ''), $cleanCode);
        })->values()->take(6);

        if ($unitNews->isEmpty()) {
            $unitNews = collect($allNews)->take(6);
        }

        // Filter unit articles strictly relevant to this unit
        $allArticles = $this->getArticleData();
        $unitArticles = collect($allArticles)->filter(function($item) use ($cleanCode) {
            $u = strtolower($item['unit'] ?? '');
            $cat = strtolower($item['category'] ?? '');
            return $u === $cleanCode || str_contains($cat, $cleanCode) || str_contains(strtolower($item['title'] ?? ''), $cleanCode);
        })->values()->take(6);

        if ($unitArticles->isEmpty()) {
            $unitArticles = collect($allArticles)->take(6);
        }

        $unitFacilities = !empty($info['facilities']) ? $info['facilities'] : ($defaultInfo['facilities'] ?? $this->getFacilityData());
        $unitEkskul = !empty($info['ekskul']) ? $info['ekskul'] : ($defaultInfo['ekskul'] ?? []);
        $unitGallery = !empty($info['gallery']) ? $info['gallery'] : $this->getGalleryData();

        // Unit Videos: fallback to global video list if empty
        $unitVideos = $info['videos'] ?? [];
        if (empty($unitVideos)) {
            $globalVideos = $this->getVideoData();
            $unitVideos = array_map(function($v) {
                return [
                    'title' => $v['title'],
                    'url' => 'https://www.youtube.com/watch?v=' . ($v['youtube_id'] ?? ''),
                    'embed_id' => $v['youtube_id'] ?? '',
                    'image' => $v['thumbnail'] ?? '/images/mockup_desktop_4.png',
                    'date' => 'Dokumentasi Video Resmi',
                    'desc' => $v['desc'] ?? $v['title']
                ];
            }, $globalVideos);
        }

        // Unit Agendas: fallback to global agendas if empty
        $unitAgendas = $info['agenda'] ?? [];
        if (empty($unitAgendas)) {
            $allAgendas = $this->getAgendaData();
            $unitAgendas = array_map(function($ag) {
                return [
                    'title' => $ag['title'],
                    'date' => ($ag['date_day'] ?? '25') . ' ' . ($ag['date_month'] ?? 'AGU') . ' ' . ($ag['year'] ?? '2026'),
                    'time' => $ag['time'] ?? '08:00 WIB',
                    'location' => $ag['location'] ?? 'Kampus SIT Robbani',
                    'desc' => $ag['category'] ?? 'Kegiatan Terjadwal Unit'
                ];
            }, $allAgendas);
        }

        // Unit Announcements: fallback to global announcements if empty
        $unitAnnouncements = $info['announcements'] ?? [];
        if (empty($unitAnnouncements)) {
            $allAnnouncements = $this->getAnnouncementData();
            $unitAnnouncements = array_map(function($an) {
                return [
                    'title' => $an['title'],
                    'date' => $an['date'] ?? '17 Agustus 2026',
                    'summary' => $an['summary'] ?? '',
                    'link' => $an['link'] ?? route('school.berita')
                ];
            }, $allAnnouncements);
        }

        return view('school.unit', compact(
            'school', 'info', 'students', 'teachers', 'classrooms', 'settings', 'headerMenus',
            'unitNews', 'unitArticles', 'unitFacilities', 'unitEkskul', 'unitGallery', 'unitVideos', 'unitAgendas', 'unitAnnouncements'
        ));
    }

    public function beritaIndex()
    {
        $settings = $this->getSettings();
        $newsList = $this->getNewsData();
        return view('school.berita.index', compact('settings', 'newsList'));
    }

    public function beritaShow($slug)
    {
        $settings = $this->getSettings();
        $newsList = $this->getNewsData();
        $news = collect($newsList)->firstWhere('slug', $slug);
        
        if (!$news) {
            $news = collect($newsList)->first(function($item) use ($slug) {
                return \Illuminate\Support\Str::slug($item['title']) === $slug;
            }) ?? $newsList[0];
        }

        $recentNews = collect($newsList)->where('slug', '!=', $news['slug'])->take(4);
        $announcementList = $this->getAnnouncementData();
        $agendaList = $this->getAgendaData();
        $headerMenus = $this->getHeaderMenus();
        
        return view('school.berita.show', compact('settings', 'news', 'recentNews', 'announcementList', 'agendaList', 'headerMenus'));
    }

    /**
     * Dynamic XML Sitemap Generator for Googlebot & Search Engine Crawlers
     */
    public function sitemapXml()
    {
        $baseUrl = rtrim(config('app.url', url('/')), '/');
        $newsList = $this->getNewsData();
        $articleList = $this->getArticleData();
        $schools = School::where('is_active', true)->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // Static core routes
        $staticRoutes = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/profil', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/berita', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/artikel', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/fasilitas', 'priority' => '0.7', 'changefreq' => 'monthly'],
            ['loc' => $baseUrl . '/ppdb', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['loc' => $baseUrl . '/e-spp', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['loc' => $baseUrl . '/sales', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ];

        // Unit profile routes
        foreach (['tkit', 'sdit', 'smpit', 'smait'] as $u) {
            $staticRoutes[] = [
                'loc' => $baseUrl . '/unit/' . $u,
                'priority' => '0.85',
                'changefreq' => 'weekly'
            ];
        }

        foreach ($staticRoutes as $r) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($r['loc'], ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>" . $r['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $r['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // Dynamic News URLs
        foreach ($newsList as $item) {
            $slug = $item['slug'] ?? \Illuminate\Support\Str::slug($item['title'] ?? '');
            if (!$slug) continue;
            
            $url = $baseUrl . '/berita/' . $slug;
            $rawDate = $item['date'] ?? null;
            $lastmod = date('Y-m-d');
            if ($rawDate && strtotime($rawDate)) {
                $lastmod = date('Y-m-d', strtotime($rawDate));
            }

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.80</priority>\n";
            if (!empty($item['image'])) {
                $imgUrl = str_starts_with($item['image'], 'http') ? $item['image'] : $baseUrl . $item['image'];
                $xml .= "    <image:image>\n";
                $xml .= "      <image:loc>" . htmlspecialchars($imgUrl, ENT_XML1) . "</image:loc>\n";
                $xml .= "      <image:title>" . htmlspecialchars($item['title'] ?? '', ENT_XML1) . "</image:title>\n";
                $xml .= "    </image:image>\n";
            }
            $xml .= "  </url>\n";
        }

        // Dynamic Islamic Article URLs
        foreach ($articleList as $art) {
            $slug = $art['slug'] ?? \Illuminate\Support\Str::slug($art['title'] ?? '');
            if (!$slug) continue;
            
            $url = $baseUrl . '/artikel/' . $slug;
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($url, ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>" . date('Y-m-d') . "</lastmod>\n";
            $xml .= "    <changefreq>monthly</changefreq>\n";
            $xml .= "    <priority>0.70</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'X-Robots-Tag' => 'noindex'
        ]);
    }

    /**
     * Dynamic Robots.txt Handler
     */
    public function robotsTxt()
    {
        $baseUrl = rtrim(config('app.url', url('/')), '/');
        
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /login\n";
        $content .= "Disallow: /up\n";
        $content .= "Disallow: /scratch/\n";
        $content .= "\n";
        $content .= "Sitemap: {$baseUrl}/sitemap.xml\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8'
        ]);
    }

    /**
     * WordPress Legacy 301 Permanent Redirect Handler to Preserve SEO Traffic
     */
    public function handleWordPressLegacyRedirect(Request $request, $p1 = null, $p2 = null, $p3 = null, $p4 = null)
    {
        $newsList = $this->getNewsData();
        
        // Match slug from any parameter
        $possibleSlugs = array_filter([$p4, $p3, $p2, $p1]);
        $slugToMatch = end($possibleSlugs);

        // 1. Check legacy query string `?p=123` or `?page_id=123`
        if ($request->has('p') || $request->has('page_id')) {
            $postParam = $request->query('p') ?? $request->query('page_id');
            // If post matches by ID or title keyword
            return redirect()->route('school.berita', [], 301);
        }

        // 2. Check legacy category route `/category/{cat}`
        if ($p1 === 'category' && $p2) {
            return redirect()->route('school.berita', ['category' => $p2], 301);
        }

        // 3. Check legacy tag route `/tag/{tag}`
        if ($p1 === 'tag' && $p2) {
            return redirect()->route('school.berita', ['tag' => $p2], 301);
        }

        // 4. Try matching slug against imported news items
        if ($slugToMatch) {
            $cleanSlug = \Illuminate\Support\Str::slug(rtrim($slugToMatch, '/'));
            $matched = collect($newsList)->first(function($item) use ($cleanSlug) {
                return ($item['slug'] ?? '') === $cleanSlug || \Illuminate\Support\Str::slug($item['title'] ?? '') === $cleanSlug;
            });

            if ($matched) {
                return redirect()->route('school.berita.show', $matched['slug'], 301);
            }
        }

        // Fallback to berita index with 301 permanent redirect
        return redirect()->route('school.berita', [], 301);
    }

    public function artikelIndex()
    {
        $settings = $this->getSettings();
        $articleList = $this->getArticleData();
        return view('school.artikel.index', compact('settings', 'articleList'));
    }

    public function artikelShow($slug)
    {
        $settings = $this->getSettings();
        $articleList = $this->getArticleData();
        $article = collect($articleList)->firstWhere('slug', $slug) ?? $articleList[0];
        $recentArticles = collect($articleList)->where('slug', '!=', $article['slug'])->take(2);

        return view('school.artikel.show', compact('settings', 'article', 'recentArticles'));
    }

    public function fasilitas()
    {
        $settings = $this->getSettings();
        $facilityList = $this->getFacilityData();
        return view('school.fasilitas', compact('settings', 'facilityList'));
    }

    public function layananKunjungan()
    {
        $settings = $this->getSettings();
        $activeTab = 'kunjungan';
        return view('school.layanan.index', compact('settings', 'activeTab'));
    }

    public function storeLayananKunjungan(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'tgl_kunjungan' => 'required|date',
            'jumlah_peserta' => 'required|integer',
            'tujuan' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $request->file('file_dokumen')->store('layanan_kunjungan', 'public');
        }

        return redirect()->back()->with('success', 'Permohonan Izin Kunjungan Sekolah berhasil dikirim! Tim Humas Yayasan Generasi Robbani akan menghubungi Anda melalui WhatsApp/Email.');
    }

    public function layananKerjasama()
    {
        $settings = $this->getSettings();
        $activeTab = 'kerjasama';
        return view('school.layanan.index', compact('settings', 'activeTab'));
    }

    public function storeLayananKerjasama(Request $request)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'nama_kontak' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string',
            'jenis_kerjasama' => 'required|string',
            'deskripsi' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $request->file('file_dokumen')->store('layanan_kerjasama', 'public');
        }

        return redirect()->back()->with('success', 'Permohonan Kerjasama & Kemitraan telah diterima! Tim Kemitraan SIT Robbani Ogan Ilir akan memproses proposal Anda.');
    }

    public function layananSewa()
    {
        $settings = $this->getSettings();
        $facilityList = $this->getFacilityData();
        $activeTab = 'sewa';
        return view('school.layanan.index', compact('settings', 'facilityList', 'activeTab'));
    }

    public function storeLayananSewa(Request $request)
    {
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'no_hp' => 'required|string',
            'fasilitas_disewa' => 'required|string',
            'tgl_sewa' => 'required|date',
            'keperluan' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('file_dokumen')) {
            $request->file('file_dokumen')->store('layanan_sewa', 'public');
        }

        return redirect()->back()->with('success', 'Permohonan Sewa Fasilitas Sekolah telah diajukan! Pengelola sarana prasarana akan mengonfirmasi jadwal & ketersediaan.');
    }

    public function ppdbForm()
    {
        $settings = $this->getSettings();
        $schools = School::where('is_active', true)->get();
        return view('school.ppdb', compact('settings', 'schools'));
    }

    public function storePpdb(Request $request)
    {
        $validated = $request->validate([
            'school_code' => 'required|string',
            'jalur_pendaftaran' => 'nullable|string',
            'nama_lengkap' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'nik_siswa' => 'nullable|numeric|digits:16',
            'nisn' => 'nullable|numeric|digits_between:8,12',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/',
            'tanggal_lahir' => 'required|date',
            'sekolah_asal' => 'nullable|string',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara' => 'nullable|integer|min:0',
            // Data Ayah & Ibu
            'nama_ayah' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'nik_ayah' => 'nullable|numeric|digits:16',
            'pekerjaan_ayah' => 'nullable|string',
            'pendidikan_ayah' => 'nullable|string',
            'no_hp_ayah' => 'required|string|regex:/^[0-9\+\-\s]+$/',
            'email_ortu' => 'required|email',
            'penghasilan_ayah' => 'nullable|string',
            'nama_ibu' => 'nullable|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'nik_ibu' => 'nullable|numeric|digits:16',
            'pekerjaan_ibu' => 'nullable|string',
            'pendidikan_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string|regex:/^[0-9\+\-\s]+$/',
            // Data Wali
            'nama_wali' => 'nullable|string',
            'hubungan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
            // Domisili
            'alamat' => 'required|string',
            'kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            // Sibling Info
            'has_sibling' => 'nullable|string',
            'sibling_info' => 'nullable|string',
            // File Uploads
            'pas_foto' => 'nullable|file|mimes:jpg,jpeg,png|max:5000',
            'ktp_ortu' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000',
        ]);

        $uploadedDocs = [];
        $uploadFields = ['pas_foto', 'ktp_ortu', 'kartu_keluarga', 'bukti_transfer'];
        
        foreach ($uploadFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $file = $request->file($field);
                $filename = time() . '_' . $field . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/spmb'), $filename);
                $uploadedDocs[$field] = '/uploads/spmb/' . $filename;
            } else {
                $uploadedDocs[$field] = null;
            }
        }

        $schoolCode = strtoupper($request->school_code);
        $schoolObj = School::where('code', $schoolCode)->first() ?? School::first();

        $fees = [
            'TKIT' => 200000,
            'SDIT' => 250000,
            'SMPIT' => 300000,
            'SMAIT' => 350000,
        ];
        $registrationFee = $fees[$schoolCode] ?? 250000;

        $noRegistrasi = 'SPMB-2026-' . $schoolCode . '-' . rand(10000, 99999);

        $detailsArray = array_merge($validated, [
            'registration_fee' => $registrationFee,
            'uploaded_docs' => $uploadedDocs,
            'submitted_at' => now()->toDateTimeString(),
        ]);

        $reg = \App\Models\PpdbRegistration::create([
            'school_id' => $schoolObj->id ?? 1,
            'registration_number' => $noRegistrasi,
            'full_name' => $request->nama_lengkap,
            'parent_name' => $request->nama_ayah,
            'phone_number' => $request->no_hp_ayah,
            'target_level' => $schoolCode,
            'previous_school' => $request->sekolah_asal ?? 'TK/SD Asal',
            'status' => 'PENDING',
            'registration_fee' => $registrationFee,
            'fee_paid' => !empty($uploadedDocs['bukti_transfer']),
            'details_json' => json_encode($detailsArray),
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => 1,
                'action' => 'PENDAFTARAN SPMB ONLINE',
                'model_type' => 'PpdbRegistration',
                'model_id' => $reg->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('spmb_success_data', [
            'registration_id' => $reg->id,
            'registration_number' => $noRegistrasi,
            'student_name' => $request->nama_lengkap,
            'target_level' => $schoolCode,
            'parent_phone' => $request->no_hp_ayah,
            'date' => now()->translatedFormat('d F Y H:i'),
        ]);
    }

    public function downloadSpmbPdf($id)
    {
        $settings = $this->getSettings();
        $registration = \App\Models\PpdbRegistration::findOrFail($id);
        return view('school.spmb_pdf', compact('settings', 'registration'));
    }

    public function verifySpmb($regNumber)
    {
        $settings = $this->getSettings();
        $registration = \App\Models\PpdbRegistration::where('registration_number', $regNumber)->firstOrFail();
        return view('school.spmb_verify', compact('settings', 'registration'));
    }

    public function eSppCheck(Request $request = null)
    {
        $request = $request ?? request();
        $settings = $this->getSettings();
        $student = null;
        $bills = collect();

        if ($request->has('nisn') && !empty($request->nisn)) {
            $student = Student::where('nisn', $request->nisn)->orWhere('nis', $request->nisn)->first();
            if ($student) {
                $bills = \App\Models\SppBill::where('student_id', $student->id)->orderBy('created_at', 'desc')->get();
            }
        }

        return view('school.espp', compact('settings', 'student', 'bills'));
    }

    public function getSettings()
    {
        return [
            'school_name' => SiteSetting::get('school_name', 'Yayasan Generasi Robbani Sumatera Selatan'),
            'tagline' => SiteSetting::get('tagline', 'Official Website Sekolah Islam Terpadu Robbani Ogan Ilir (KB/TKIT, SDIT, SMPIT, SMAIT)'),
            'hero_badge' => SiteSetting::get('hero_badge', '✨ YAYASAN GENERASI ROBBANI SUMATERA SELATAN'),
            'hero_title' => SiteSetting::get('hero_title', 'Membentuk Generasi Rabbani Berakhlak Mulia & Berprestasi Digital'),
            'hero_desc' => SiteSetting::get('hero_desc', 'Yayasan Generasi Robbani Sumatera Selatan menyelenggarakan pendidikan Islam Terpadu unggul dari jenjang KB/TKIT Robbani, SDIT Robbani, SMPIT Robbani, hingga SMAIT Robbani di Ogan Ilir dengan Kurikulum Merdeka, Kekhasan JSIT, Tahfidz Al-Qur\'an, dan Ekosistem Digital.'),
            'principal_greeting' => SiteSetting::get('principal_greeting', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Yayasan Generasi Robbani Sumatera Selatan. Kami berkomitmen mendidik ananda menjadi pribadi beriman, bertakwa, berakhlak karimah, hafidz Al-Qur\'an, serta menguasai ilmu pengetahuan dan teknologi.'),
            'principal_name' => SiteSetting::get('principal_name', 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd'),
            'principal_title' => SiteSetting::get('principal_title', 'Ketua Yayasan Generasi Robbani Sumatera Selatan'),
            'ppdb_status' => SiteSetting::get('ppdb_status', 'SPMB / PPDB TELAH DIBUKA!'),
            'ppdb_desc' => SiteSetting::get('ppdb_desc', 'Ayo Menjadi Bagian SIT Robbani Ogan Ilir Tahun Ajaran 2026/2027 untuk jenjang KB/TKIT, SDIT, SMPIT, & SMAIT.'),
            'contact_phone' => SiteSetting::get('contact_phone', '0811747472'),
            'contact_email' => SiteSetting::get('contact_email', 'info@sitrobbani.sch.id'),
            'contact_address' => SiteSetting::get('contact_address', 'Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan'),
            'website_theme' => SiteSetting::get('website_theme', 'theme-emerald'),
            'school_logo' => SiteSetting::get('school_logo', SiteSetting::get('logo_light', '/images/smartedu_logo.jpg')),
            'logo_light' => SiteSetting::get('logo_light', SiteSetting::get('school_logo', '/images/smartedu_logo.jpg')),
            'logo_dark' => SiteSetting::get('logo_dark', SiteSetting::get('school_logo', '/images/smartedu_logo.jpg')),
        ];
    }

    public function getNewsData()
    {
        $cmsJson = SiteSetting::get('cms_news_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                // Ensure always sorted by date timestamp DESC (newest 2026 first)
                usort($data, function($a, $b) {
                    $tA = isset($a['timestamp']) ? (int)$a['timestamp'] : strtotime($a['date'] ?? 'now');
                    $tB = isset($b['timestamp']) ? (int)$b['timestamp'] : strtotime($b['date'] ?? 'now');
                    return $tB <=> $tA;
                });
                return $data;
            }
        }

        return [
            [
                'title' => 'Puncak Tema & Pentas Seni Cilik Siswa KB/TKIT Robbani Ogan Ilir',
                'slug' => 'puncak-tema-pentas-seni-cilik-siswa-kbtkit-robbani-ogan-ilir',
                'category' => 'KB/TKIT',
                'date' => '12 Agustus 2026',
                'author' => 'Humas KB/TKIT Robbani',
                'image' => '/images/mockup_mobile_1.png',
                'excerpt' => 'Keceriaan dan kebersamaan siswa cilik KB/TKIT Robbani Ogan Ilir saat mengekspresikan bakat hafalan surah pendek, doa harian, & kreasi mewarnai bersama bundanya.',
                'content' => 'Ogan Ilir — Suasana penuh warna dan keceriaan mewarnai aula KB/TKIT Robbani Ogan Ilir dalam gelaran Puncak Tema & Pentas Seni Cilik Siswa Usia Dini Tahun Ajaran 2026/2027.<br><br>Acara ini diselenggarakan sebagai wadah apresiasi tumbuh kembang, keberanian, dan kreativitas siswa cilik KB/TKIT Robbani setelah menyelesaikan tema pembelajaran semester ganjil.<br><br>Para siswa dengan percaya diri menampilkan unjuk bakat hafalan surah-surah pendek Al-Qur\'an (Juz Amma), perkataan thoyyibah, doa harian, tarian kreasi nusantara islami, serta fashion show pakaian adat.<br><br>Kepala KB/TKIT Robbani, Ustdz. Nurhidayah, S.Pd.I, menyampaikan rasa syukur dan haru atas perkembangan adab dan kemandirian ananda. "Pendidikan usia dini di SIT Robbani dirancang dengan metode belajar seraya bermain yang menyenangkan, menanamkan nilai-nilai keislaman sejak dini, serta membangun ikatan kasih sayang yang erat antara guru, anak, dan orang tua," tutur beliau.'
            ],
            [
                'title' => 'Pramuka SIT & Supercamp Karakter Siswa SDIT Robbani 2026',
                'slug' => 'pramuka-sit-supercamp-karakter-siswa-sdit-robbani-2026',
                'category' => 'SDIT',
                'date' => '08 Agustus 2026',
                'author' => 'Pembina Pramuka SDIT',
                'image' => '/images/mockup_mobile_2.png',
                'excerpt' => 'Pelatihan kemandirian, ketangkasan, dan mabit malam bina iman takwa siswa penggalang SDIT Robbani Ogan Ilir.',
                'content' => 'Ogan Ilir — Ratusan siswa penggalang Sekolah Dasar Islam Terpadu (SDIT) Robbani Ogan Ilir antusias mengikuti kegiatan Perkemahan Sabtu-Minggu (Persami) & Supercamp Karakter Pramuka SIT 2026 di Bumi Perkemahan Kampus Terpadu Robbani.<br><br>Kegiatan yang mengusung tema "Tangguh, Mandiri, Berakhlak Karimah, dan Siap Memimpin" ini diisi dengan berbagai materi ketangkasan, sandi morse, pioneering tali temali, penjelajahan alam halang rintang, serta pertunjukan api unggun.<br><br>Selain ketangkasan fisik, peserta diajak memperdalam ruhani melalui sholat qiyamul lail berjamaah, munasabah malam bina iman takwa (MABIT), dan tahfidz bersama di bawah bimbingan ustadz-ustadzah pendamping.<br><br>Kepala SDIT Robbani, Ustdz. M. Ridwan, S.Pd, mengapresiasi tinggi kedisiplinan para siswa. Kegiatan outdoor ini merupakan sarana efektif menempa jiwa kepemimpinan, kepedulian sosial, serta rasa ukhuwah antar sesama siswa.'
            ],
            [
                'title' => 'Kepala SMP IT Robbani Ogan Ilir Raih Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah Sumatera Selatan 2026',
                'slug' => 'kepsek-smp-it-robbani-raih-peserta-terbaik-iii',
                'category' => 'SMPIT',
                'date' => '31 Juli 2026',
                'author' => 'Humas SIT Robbani',
                'image' => '/images/hero_3d_illustration_1786347707126.png',
                'excerpt' => 'Alhamdulillah, Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir berhasil meraih Penghargaan Peserta Terbaik III dalam Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan.',
                'content' => 'Ogan Ilir — Sebuah kebanggaan besar kembali diukir oleh keluarga besar Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir. Ibu Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir, berhasil meraih penghargaan sebagai Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan Tahun 2026.<br><br>Kegiatan diklat ini diselenggarakan oleh Dinas Pendidikan Provinsi Sumatera Selatan sebagai upaya meningkatkan kompetensi kepemimpinan manajerial, kewirausahaan, dan supervisi akademik kepala sekolah di era transformasi digital.<br><br>Dalam kesempatannya, Ibu Tia Wulandari menyampaikan rasa syukur dan dedikasi atas pencapaian ini kepada seluruh jajaran ustadz-ustadzah, siswa, dan orang tua murid di SIT Robbani Ogan Ilir. "Penghargaan ini merupakan motivasi bagi kami untuk terus berinovasi dan menghadirkan tata kelola sekolah Islam terpadu yang profesional, berkarakter, dan berdaya saing tinggi," tutur beliau.'
            ],
            [
                'title' => 'Siswa SMAIT Robbani Lolos Seleksi PTN Favorit & Beasiswa Luar Negeri 2026',
                'slug' => 'siswa-smait-robbani-lolos-seleksi-ptn-favorit-beasiswa-luar-negeri-2026',
                'category' => 'SMAIT',
                'date' => '20 Juli 2026',
                'author' => 'Tim Bimbingan Konseling SMAIT',
                'image' => '/images/mockup_mobile_4.png',
                'excerpt' => 'Capaian membanggakan alumni SMAIT Robbani tembus jalur SNBP, SNBT, dan beasiswa perguruan tinggi ternama di dalam maupun luar negeri.',
                'content' => 'Ogan Ilir — Kualitas lulusan Sekolah Menengah Atas Islam Terpadu (SMAIT) Robbani Ogan Ilir kembali terbukti di kancah nasional dan internasional. Berdasarkan pengumuman resmi kelulusan PTN 2026, puluhan alumni SMAIT Robbani berhasil diterima di Perguruan Tinggi Negeri (PTN) favorit seperti Universitas Sriwijaya, ITB, UGM, UNDIP, serta Universitas Al-Azhar Kairo.<br><br>Keberhasilan ini tidak lepas dari kombinasi bimbingan akademik intensif, try out UTBK berkala, serta program matrikulasi tahfidz dan penguasaan Bahasa Arab & Inggris yang menjadi ciri khas SMAIT Robbani.<br><br>Kepala SMAIT Robbani, Ustdz. Ahmad Subagja, M.Si, mengungkapkan rasa bangga atas perjuangan para siswa. "Alhamdulillah, keberhasilan ini adalah buah dari kerja keras siswa, doa dari orang tua, dan kesabaran dewan guru yang membimbing dengan hati," ungkap beliau.'
            ],
            [
                'title' => 'Kegiatan Fun Cooking & Edukasi Gizi Siswa Usia Dini TKIT Robbani',
                'slug' => 'kegiatan-fun-cooking-edukasi-gizi-siswa-usia-dini-tkit-robbani',
                'category' => 'KB/TKIT',
                'date' => '05 Juli 2026',
                'author' => 'Tim Kurikulum TKIT',
                'image' => '/images/mockup_desktop_1.png',
                'excerpt' => 'Mengenalkan makanan sehat halal dan thoyyib sejak dini melalui praktik memasak menyenangkan bersama ustazah dan wali murid.',
                'content' => 'Ogan Ilir — Para siswa cilik KB/TKIT Robbani antusias mengikuti kegiatan Fun Cooking & Edukasi Makanan Sehat Halalan Thoyyiban di halaman sekolah.<br><br>Dengan mengenakan celemek dan topi koki cilik, para siswa diajak membuat kreasi bekal sehat berupa bento sayur, salad buah, dan jus buah segar.<br><br>Melalui kegiatan ini, siswa belajar mengenalkan jenis sayuran, buah-buahan, serta kebiasaan mencuci tangan dan membaca doa sebelum dan sesudah makan.'
            ],
            [
                'title' => 'Munaqosyah Tahfidz Juz 29 & 30 Terbuka SDIT Robbani Ogan Ilir',
                'slug' => 'munaqosyah-tahfidz-juz-29-30-terbuka-sdit-robbani-ogan-ilir',
                'category' => 'SDIT',
                'date' => '18 Juni 2026',
                'author' => 'Tim Al-Qur\'an SDIT',
                'image' => '/images/mockup_desktop_2.png',
                'excerpt' => 'Ujian hafalan Al-Qur\'an terbuka siswa SDIT Robbani di hadapan para penguji munaqisy dan orang tua siswa.',
                'content' => 'Ogan Ilir — Puluhan siswa SDIT Robbani Ogan Ilir mengikuti ujian Munaqosyah Tahfidz Al-Qur\'an Juz 29 dan 30 secara terbuka di Masjid Kampus Robbani.<br><br>Setiap siswa diuji sambung ayat, tajwid, makhraj huruf, dan kelancaran hafalan oleh tim penguji eksternal dari Lembaga Pengembangan Pendidikan Al-Qur\'an.<br><br>Orang tua siswa yang hadir dibuat terharu dan meneteskan air mata bahagia menyaksikan kemampuan hafalan ananda yang lancar dan tartil.'
            ],
            [
                'title' => 'Olimpiade Sains & Kebumian: Tim Siswa SMPIT Robbani Sabet Emas',
                'slug' => 'olimpiade-sains-kebumian-tim-siswa-smpit-robbani-sabet-emas',
                'category' => 'SMPIT',
                'date' => '10 Juni 2026',
                'author' => 'Tim Prestasi SMPIT',
                'image' => '/images/mockup_desktop_3.png',
                'excerpt' => 'Perjuangan tim olimpiade sains SMPIT Robbani dalam kompetisi akademik tingkat regional Sumatera Selatan.',
                'content' => 'Ogan Ilir — Tim Sains dan Matematika SMPIT Robbani Ogan Ilir kembali mengukir prestasi gemilang dengan meraih 2 Medali Emas dan 3 Medali Perak dalam Olimpiade Sains Islam & Kebumian 2026.<br><br>Para siswa mampu menyelesaikan soal-soal penalaran fisika, biologi, dan matematika terintegrasi nilai-nilai Al-Qur\'an dengan perolehan skor tertinggi.<br><br>Prestasi ini membuktikan bahwa pendidikan Islam Terpadu di SMPIT Robbani mampu melahirkan generasi ahli sains yang tetap memegang teguh akidah islamiyah.'
            ],
            [
                'title' => 'Workshop IoT & Coding Mobile App Siswa SMAIT Robbani 2026',
                'slug' => 'workshop-iot-coding-mobile-app-siswa-smait-robbani-2026',
                'category' => 'SMAIT',
                'date' => '28 Mei 2026',
                'author' => 'Laboratorium Komputer SMAIT',
                'image' => '/images/mockup_desktop_4.png',
                'excerpt' => 'Pelatihan pemrograman aplikasi android dan teknologi internet of things (IoT) berbasis dakwah digital siswa SMAIT Robbani.',
                'content' => 'Ogan Ilir — Dalam rangka membekali siswa dengan keterampilan abad 21, SMAIT Robbani Ogan Ilir menggelar Workshop Coding & IoT Development selama 3 hari.<br><br>Para siswa diajarkan merancang aplikasi mobile berbasis Android, sistem otomasi sensor cerdas (Internet of Things), serta manajemen database cloud.<br><br>Karya-karya inovasi siswa seperti sistem presensi digital dan pengingat waktu sholat otomatis dipresentasikan di hadapan para penguji dan praktisi IT.'
            ]
        ];

        // AUTOMATED SAFETY FILTER: Remove judol, pinjol, SARA, pornography, etc.
        return \App\Services\ContentFilterService::filterCollection($newsList);
    }

    public function getArticleData()
    {
        $cmsJson = SiteSetting::get('cms_article_data');
        $data = [];
        if ($cmsJson) {
            $parsed = json_decode($cmsJson, true);
            if (is_array($parsed) && count($parsed) > 0) {
                $data = $parsed;
            }
        }

        if (empty($data)) {
            $data = [
                [
                    'title' => 'Tata Cara Sholat Tasbih dan Keutamaannya',
                    'slug' => 'tata-cara-sholat-tasbih-dan-keutamaannya',
                    'category' => 'Artikel Keislaman',
                    'date' => '06 Maret 2026',
                    'author' => 'Tim Bina Pribadi Islami',
                    'image' => '/images/hero_3d_illustration_1786347707126.png',
                    'excerpt' => 'Sholat Tasbih merupakan salah satu sholat sunnah yang dianjurkan untuk dikerjakan oleh umat Islam. Sholat ini memiliki keistimewaan karena di dalamnya dipenuhi kalimat tasbih.',
                    'content' => 'Sholat Tasbih merupakan salah satu sholat sunnah yang dianjurkan untuk dikerjakan oleh umat Islam, baik dilaksanakan pada siang hari maupun malam hari.<br><br><strong>Keutamaan Sholat Tasbih:</strong><br>1. Menggugurkan dosa-dosa kecil maupun besar.<br>2. Menjadikan hati lebih tenang dan dekat dengan Allah SWT.<br>3. Meneladani sunnah Rasulullah SAW dan arahan kepada Sayyidina Abbas RA.<br><br><strong>Tata Cara Pelaksanaan:</strong><br>Sholat Tasbih dikerjakan sebanyak 4 rakaat. Dalam setiap rakaatnya, dibaca kalimat tasbih <i>"Subhanallah walhamdulillah wala ilaha illallah wallahu akbar"</i> sebanyak 75 kali (total 300 kali tasbih dalam 4 rakaat).'
                ],
                [
                    'title' => 'Membangun Karakter Rabbani Melalui Pembiasaan Mutabaah Yaumiyah & Bina Pribadi Islami',
                    'slug' => 'membangun-karakter-rabbani-melalui-mutabaah-yaumiyah-bpi',
                    'category' => 'Artikel Edukasi',
                    'date' => '18 Februari 2026',
                    'author' => 'Tim Kurikulum JSIT',
                    'image' => '/images/bpi_mutabaah_3d_1786347836635.png',
                    'excerpt' => 'Pembentukan karakter generasi Rabbani diawali dengan pembiasaan sholat 5 waktu tepat waktu, tilawah Al-Qur\'an, hafalan ziyadah, dan keterlibatan aktif wali murid.',
                    'content' => 'Pembentukan karakter siswa tidak hanya cukup dilakukan melalui teori di dalam kelas, namun membutuhkan pembiasaan (amaliyah yaumiyah) yang konsisten.<br><br>Melalui modul Bina Pribadi Islami (BPI) dan Mutabaah Yaumiyah di SIT Robbani Ogan Ilir, siswa dibimbing untuk melatih kedisiplinan ibadah mandiri: Sholat Fardhu tepat waktu, Sholat Dhuha, Tahajud, Tilawah harian, hafalan ayat Al-Qur\'an, serta bakti kepada orang tua.'
                ]
            ];
        }

        // Sort DESC by date/timestamp
        usort($data, function($a, $b) {
            $tA = isset($a['timestamp']) ? (int)$a['timestamp'] : strtotime($a['date'] ?? 'now');
            $tB = isset($b['timestamp']) ? (int)$b['timestamp'] : strtotime($b['date'] ?? 'now');
            return $tB <=> $tA;
        });

        // AUTOMATED SAFETY FILTER: Remove judol, pinjol, SARA, pornography, etc.
        return \App\Services\ContentFilterService::filterCollection($data);
    }

    public function getFacilityData()
    {
        $cmsJson = SiteSetting::get('cms_facility_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'title' => 'Ruang Kelas Nyaman Ber-AC',
                'desc' => 'Setiap ruang kelas di SIT Robbani Ogan Ilir dilengkapi dengan pendingin udara (AC), pencahayaan optimal, loker siswa, dan perlengkapan multimedia LCD proyektor.',
                'icon' => '❄️',
                'image' => '/images/mockup_desktop_1.png'
            ],
            [
                'title' => 'Masjid & Sarana Ibadah',
                'desc' => 'Pusat pembinaan karakter spiritual siswa untuk pelaksanaan sholat berjamaah, halaqah Tahfidz Al-Qur\'an, dan kegiatan Bina Pribadi Islami (BPI).',
                'icon' => '🕌',
                'image' => '/images/hero_3d_illustration_1786347707126.png'
            ],
            [
                'title' => 'Perpustakaan Digital & E-Library',
                'desc' => 'Fasilitas perpustakaan fisik dan digital (E-Library) dengan koleksi ribuan buku pelajaran, sains, keislaman, majalah anak, dan literasi umum.',
                'icon' => '📚',
                'image' => '/images/mockup_desktop_2.png'
            ],
            [
                'title' => 'Laboratorium Komputer & IT',
                'desc' => 'Sarana laboratorium komputer modern terintegrasi jaringan internet tinggi untuk pembelajaran literasi digital, koding, dan Asesmen Nasional (ANBK).',
                'icon' => '💻',
                'image' => '/images/mockup_desktop_3.png'
            ],
            [
                'title' => 'Playground & Arena Olahraga',
                'desc' => 'Fasilitas bermain anak usia dini (outdoor playground) dan lapangan olahraga serbaguna untuk olahraga futsal, basket, bulutangkis, dan panahan.',
                'icon' => '⚽',
                'image' => '/images/mockup_desktop_4.png'
            ],
            [
                'title' => 'Keamanan CCTV & Satpam 24 Jam',
                'desc' => 'Lingkungan sekolah dipantau sistem keamanan CCTV terpadu di setiap sudut dan petugas keamanan (security) siap siaga 24 jam demi kenyamanan peserta didik.',
                'icon' => '🛡️',
                'image' => '/images/mockup_desktop_5.png'
            ]
        ];
    }

    public function getVideoData()
    {
        $cmsJson = SiteSetting::get('cms_video_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'title' => 'JINGLE SIT ROBBANI OGAN ILIR',
                'category' => 'Profil Video',
                'duration' => '03:15',
                'youtube_id' => 'Q-vZ49vP1_c',
                'thumbnail' => 'https://img.youtube.com/vi/Q-vZ49vP1_c/hqdefault.jpg',
                'desc' => 'Jingle resmi Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir - Membangun Generasi Qur\'ani dan Berakhlak Karimah.'
            ],
            [
                'title' => 'After Movie Masa Pengenalan Lingkungan Sekolah (MPLS) SIT Robbani Ogan Ilir 2026',
                'category' => 'Dokumentasi Acara',
                'duration' => '04:30',
                'youtube_id' => '8yp0GZL27fU',
                'thumbnail' => 'https://img.youtube.com/vi/8yp0GZL27fU/hqdefault.jpg',
                'desc' => 'Keseruan dan antusiasme siswa baru dalam rangkaian kegiatan Masa Pengenalan Lingkungan Sekolah (MPLS) 2026.'
            ],
            [
                'title' => 'Wisuda Tahfidz & Haflah Akhirussanah 2026 | After Movie SIT Robbani Ogan Ilir',
                'category' => 'Wisuda Tahfidz',
                'duration' => '06:45',
                'youtube_id' => 'lhFR6TrEWxY',
                'thumbnail' => 'https://img.youtube.com/vi/lhFR6TrEWxY/hqdefault.jpg',
                'desc' => 'Momen khidmat dan haru prosesi wisuda tahfidz Al-Qur’an serta pelepasan siswa SIT Robbani Ogan Ilir.'
            ],
            [
                'title' => 'Tebar Kebahagiaan Idul Adha 1447 H | After Movie Qurban Dompet Sosial Robbani 2026',
                'category' => 'Kegiatan Sosial',
                'duration' => '05:10',
                'youtube_id' => '9gBk0Fss9yw',
                'thumbnail' => 'https://img.youtube.com/vi/9gBk0Fss9yw/hqdefault.jpg',
                'desc' => 'Penyembelihan dan pendistribusian hewan qurban bersama Dompet Sosial Robbani Peduli untuk masyarakat.'
            ],
            [
                'title' => '[After Movie] Manasik Haji Anak KB TK IT Robbani Ogan Ilir 2026',
                'category' => 'KB/TKIT',
                'duration' => '03:50',
                'youtube_id' => '5ifsHX2orZ8',
                'thumbnail' => 'https://img.youtube.com/vi/5ifsHX2orZ8/hqdefault.jpg',
                'desc' => 'Praktik manasik haji cilik siswa KB/TKIT Robbani Ogan Ilir mengenalkan rukun Islam kelima sejak usia dini.'
            ],
            [
                'title' => 'Lucunya Kartini Cilik! After Movie Kartini Day KB TK Islam Terpadu Robbani Ogan Ilir 2026',
                'category' => 'KB/TKIT',
                'duration' => '04:15',
                'youtube_id' => 'Vj0e1PCWqJo',
                'thumbnail' => 'https://img.youtube.com/vi/Vj0e1PCWqJo/hqdefault.jpg',
                'desc' => 'Pentas seni, fashion show pakaian adat nusantara, dan ekspresi keberanian siswa usia dini KB/TKIT Robbani.'
            ],
            [
                'title' => 'After Movie Qur’an Camp 2026 SD IT Robbani | Momen Tak Terlupakan',
                'category' => 'SDIT',
                'duration' => '05:40',
                'youtube_id' => 'ug0lt6LlYSs',
                'thumbnail' => 'https://img.youtube.com/vi/ug0lt6LlYSs/hqdefault.jpg',
                'desc' => 'Perkemahan Qur\'an Camp siswa SDIT Robbani mengasah hafalan Al-Qur\'an, kemandirian, dan ukhuwah islamiyah.'
            ],
            [
                'title' => 'Belajar Sambil Wisata Edukasi KB-TKIT Robbani Goes to UNSRI',
                'category' => 'KB/TKIT',
                'duration' => '03:45',
                'youtube_id' => 'tFjiILUphjY',
                'thumbnail' => 'https://img.youtube.com/vi/tFjiILUphjY/hqdefault.jpg',
                'desc' => 'Kunjungan field trip edukatif siswa cilik KB-TKIT Robbani mengenal kampus dan lingkungan alam terbuka.'
            ],
            [
                'title' => 'Robbani Talent Show Bikin Terpukau | After Movie SMP IT Robbani 2026',
                'category' => 'SMPIT',
                'duration' => '06:12',
                'youtube_id' => 'cCRXQhYNF38',
                'thumbnail' => 'https://img.youtube.com/vi/cCRXQhYNF38/hqdefault.jpg',
                'desc' => 'Unjuk bakat seni islami, pidato 3 bahasa, sains robotika, dan kreasi siswa SMP IT Robbani Ogan Ilir.'
            ],
            [
                'title' => 'Anak KB-TK IT Robbani Belajar Pesawat di Poltekbang Palembang [After Movie 2026]',
                'category' => 'KB/TKIT',
                'duration' => '04:20',
                'youtube_id' => 'RyVRofyKPP0',
                'thumbnail' => 'https://img.youtube.com/vi/RyVRofyKPP0/hqdefault.jpg',
                'desc' => 'Eksplorasi dunia penerbangan dan edukasi cita-cita siswa usia dini di Politeknik Penerbangan Palembang.'
            ],
            [
                'title' => 'After Movie Pesantren Ramadhan SD Islam Terpadu Robbani Ogan Ilir 2026',
                'category' => 'SDIT',
                'duration' => '05:05',
                'youtube_id' => 'wWCsYWuLbMI',
                'thumbnail' => 'https://img.youtube.com/vi/wWCsYWuLbMI/hqdefault.jpg',
                'desc' => 'Keseruan kegiatan pesantren kilat Ramadhan, tadarus Al-Qur\'an, dan santunan anak yatim SDIT Robbani.'
            ],
            [
                'title' => 'After Movie Pesantren Ramadhan SMP Islam Terpadu Robbani Ogan Ilir 2026',
                'category' => 'SMPIT',
                'duration' => '05:30',
                'youtube_id' => 'oZBAzQdiLK0',
                'thumbnail' => 'https://img.youtube.com/vi/oZBAzQdiLK0/hqdefault.jpg',
                'desc' => 'Mabit malam bina iman takwa, kajian fiqih remaja, dan qiyamul lail siswa SMP IT Robbani Ogan Ilir.'
            ]
        ];
    }

    public function getAgendaData()
    {
        $cmsJson = SiteSetting::get('cms_agenda_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'title' => 'Simulasi ANBK & Asesmen Digital Berbasis Komputer',
                'date_day' => '25',
                'date_month' => 'AGU',
                'year' => '2026',
                'time' => '07.30 - 12.00 WIB',
                'location' => 'Lab Komputer SMPIT & SMAIT Robbani',
                'category' => 'Akademik'
            ],
            [
                'title' => 'Supercamp Tahfidz Al-Qur’an & Mabit Siswa',
                'date_day' => '10',
                'date_month' => 'SEP',
                'year' => '2026',
                'time' => '16.00 WIB - Selesai',
                'location' => 'Masjid Utama SIT Robbani Ogan Ilir',
                'category' => 'BPI & Tahfidz'
            ],
            [
                'title' => 'Peringatan Hari Sumpah Pemuda & Panggung Aksi Siswa',
                'date_day' => '28',
                'date_month' => 'OKT',
                'year' => '2026',
                'time' => '08.00 - 15.00 WIB',
                'location' => 'Aula Pertemuan Robbani',
                'category' => 'Kreativitas'
            ],
            [
                'title' => 'Penyerahan Laporan Hasil Belajar (Rapor) Semester Ganjil',
                'date_day' => '18',
                'date_month' => 'DES',
                'year' => '2026',
                'time' => '08.00 - 12.00 WIB',
                'location' => 'Gedung Unit KB/TK, SD, SMP, SMA',
                'category' => 'Rapor'
            ],
            [
                'title' => 'Olimpiade Sains & Seni Islam (OSSI) Antar Unit Robbani',
                'date_day' => '15',
                'date_month' => 'JAN',
                'year' => '2027',
                'time' => '07.30 - 16.00 WIB',
                'location' => 'Kompleks Terpadu SIT Robbani Ogan Ilir',
                'category' => 'Kompetisi'
            ]
        ];
    }

    public function getAnnouncementData()
    {
        $cmsJson = SiteSetting::get('cms_announcement_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'title' => 'Hasil Seleksi Administrasi Rekrutmen Guru & Pegawai TA 2026/2027',
                'date' => '07 Mei 2026',
                'category' => 'Rekrutmen SDM',
                'summary' => 'Peserta yang dinyatakan lulus tahap administrasi diwajibkan mengikuti Ujian Microteaching & Wawancara Keislaman.',
                'link' => route('school.berita.show', 'pengumuman-kelulusan-tahap-administrasi-rekrutmen-guru-dan-pegawai-sit-robbani-2026')
            ],
            [
                'title' => 'Pembukaan Pendaftaran SPMB / PPDB Online Gelombang 1',
                'date' => '01 April 2026',
                'category' => 'PPDB Online',
                'summary' => 'Pendaftaran peserta didik baru resmi dibuka untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir.',
                'link' => route('school.ppdb')
            ],
            [
                'title' => 'Edaran Pelaksanaan Penilaian Akhir Semester (PAS) Ganjil',
                'date' => '01 November 2026',
                'category' => 'Edaran Akademik',
                'summary' => 'Dihimbau kepada seluruh orang tua siswa untuk mendampingi belajar ananda selama pekan PAS berlangsung.',
                'link' => route('school.berita')
            ],
            [
                'title' => 'Jadwal Libur Semester & Penyegaran Awal Tahun Pelajaran',
                'date' => '20 Desember 2026',
                'category' => 'Pengumuman Resmi',
                'summary' => 'Informasi kalender pendidikan libur semester ganjil dan tanggal aktif kembali KBM semester genap.',
                'link' => route('school.berita')
            ],
            [
                'title' => 'Undangan Parent Teacher Meeting (PTM) Konsultasi Perkembangan Siswa',
                'date' => '10 Januari 2027',
                'category' => 'Wali Murid',
                'summary' => 'Pertemuan silaturahmi ustadz wali kelas dan orang tua murid mengenai evaluasi hafalan dan akademik ananda.',
                'link' => route('school.berita')
            ]
        ];
    }

    public function getGalleryData()
    {
        $cmsJson = SiteSetting::get('cms_gallery_data');
        $merged = [];
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                $merged = $data;
            }
        }

        // Merge authentic galleries from unit profiles (TKIT, SDIT, SMPIT, SMAIT)
        $units = ['tkit', 'sdit', 'smpit', 'smait'];
        foreach ($units as $u) {
            $profileJson = SiteSetting::get('unit_profile_' . $u);
            if ($profileJson) {
                $prof = json_decode($profileJson, true);
                if (isset($prof['gallery']) && is_array($prof['gallery'])) {
                    foreach ($prof['gallery'] as $g) {
                        if (!isset($g['desc']) || empty($g['desc'])) {
                            $g['desc'] = "Dokumentasi kegiatan " . strtoupper($u) . " SIT Robbani Ogan Ilir.";
                        }
                        $merged[] = $g;
                    }
                }
            }
        }

        if (count($merged) > 0) {
            return array_values($merged);
        }

        return [
            [
                'title' => 'Wisuda & Haflah Tahfidz Al-Qur\'an Siswa',
                'category' => 'Wisuda & Tahfidz',
                'image' => '/uploads/media/1-e1643012044561_a09877b7.jpeg',
                'desc' => 'Momen khidmat wisuda tahfidz Al-Qur’an dan apresiasi capaian hafalan siswa SIT Robbani.'
            ],
            [
                'title' => 'Kompleks & Sarana Belajar SIT Robbani',
                'category' => 'Fasilitas Kampus',
                'image' => '/uploads/media/2_7c039504.png',
                'desc' => 'Kompleks persekolahan yang asri, kondusif, dan dilengkapi sarana pembelajaran modern.'
            ],
            [
                'title' => 'Keceriaan Belajar Siswa KB/TKIT Robbani',
                'category' => 'KB/TKIT Robbani',
                'image' => '/uploads/media/img20220127093650-scaled_e1faddf6.jpg',
                'desc' => 'Aktivitas belajar motorik ceria, pengenalan adab islami, dan hafalan surah pendek sejak dini.'
            ],
            [
                'title' => 'Pembelajaran Digital & Lab Komputer',
                'category' => 'Sarana & Teknologi',
                'image' => '/uploads/media/3_0996b3f3.png',
                'desc' => 'Siswa berlatih koding, literasi digital interaktif, dan simulasi Asesmen Nasional.'
            ]
        ];
    }

    public function getHeaderMenus()
    {
        $cmsJson = SiteSetting::get('cms_header_menus');
        $menus = [];
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                $menus = $data;
            }
        }

        if (empty($menus)) {
            $menus = [
                ['title' => 'Beranda', 'url' => route('home'), 'is_active' => true],
                ['title' => 'Profil', 'url' => route('school.profil'), 'is_active' => true],
                ['title' => 'Layanan', 'url' => route('school.layanan.kunjungan'), 'is_active' => true],
                ['title' => 'Unit', 'url' => '#unit-sekolah', 'is_active' => true],
                ['title' => 'Berita', 'url' => route('school.berita'), 'is_active' => true],
                ['title' => 'Artikel', 'url' => route('school.artikel'), 'is_active' => true],
                ['title' => 'Sarana & Prasarana', 'url' => '#sarana-prasarana', 'is_active' => true],
                ['title' => 'Galeri', 'url' => '#galeri-sekolah', 'is_active' => true],
                ['title' => 'E-SPP', 'url' => route('school.espp'), 'is_active' => true],
            ];
        } else {
            $hasLayanan = false;
            foreach ($menus as $m) {
                if (isset($m['title']) && strtolower($m['title']) === 'layanan') {
                    $hasLayanan = true;
                    break;
                }
            }
            if (!$hasLayanan) {
                // Insert Layanan right after Profil
                array_splice($menus, 2, 0, [['title' => 'Layanan', 'url' => route('school.layanan.kunjungan'), 'is_active' => true]]);
            }
        }

        return $menus;
    }

    /**
     * Handle Robbani AI Assistant Chat Requests (Integrated with Document RAG Knowledge Base & SmartEdu DB)
     */
    public function chatAi(Request $request)
    {
        try {
            $ip = $request->ip();
            $executed = \Illuminate\Support\Facades\RateLimiter::attempt(
                'chat-ai:' . $ip,
                $perMinute = 15,
                function() {},
                $decaySeconds = 60
            );

            if (!$executed) {
                return response()->json([
                    'status' => 'error',
                    'answer' => 'Mohon maaf, Anda mengirim terlalu banyak pesan dalam waktu singkat. Silakan tunggu 1 menit lagi untuk melanjutkan pertanyaan.'
                ]);
            }

            $message = trim($request->input('message', ''));
            if (empty($message)) {
                return response()->json([
                    'status' => 'error',
                    'answer' => 'Mohon maaf, pesan Anda tidak boleh kosong. Silakan tuliskan pertanyaan Anda seputar SIT Robbani atau sistem SmartEdu.'
                ]);
            }

            $answer = \App\Services\AiRagEngine::answer($message);

            return response()->json([
                'status' => 'success',
                'answer' => $answer
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'success',
                'answer' => "Assalamu'alaikum! Terima kasih telah bertanya. SIT Robbani Ogan Ilir menyelenggarakan jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.\n\nSilakan kunjungi menu **Pendaftaran SPMB** (`/ppdb`) atau hubungi WhatsApp Hotline Admin di **0811747472**."
            ]);
        }
    }
}
