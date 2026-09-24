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
            'principal_name' => SiteSetting::get('principal_name', 'Sughesti wulandari, S.Pd'),
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
            'principal_photo' => SiteSetting::get('principal_photo', '/uploads/media/press-release-employee-10-scaled_b06e4c83.webp'),
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
                'principal_name' => 'Ani Oktar Yansi, S.Pd.I',
                'principal_title' => 'Kepala KB/TKIT Robbani',
                'principal_photo' => '/uploads/media/ani-oktar-yansi-spd-i-scaled_0a6337c9.jpg',
                'desc' => 'Kelompok Bermain & TK Islam Terpadu Terakreditasi A.'
            ],
            'sdit' => [
                'name' => 'SDIT Robbani',
                'principal_name' => 'Nur Amalia, S.Pd.,Gr',
                'principal_title' => 'Kepala SDIT Robbani',
                'principal_photo' => '/uploads/media/gtk_sd_nur-amalia-s-pd_99acbccf.png',
                'desc' => 'Sekolah Dasar Islam Terpadu Terakreditasi B & Program Tahfidz.'
            ],
            'smpit' => [
                'name' => 'SMPIT Robbani',
                'principal_name' => 'Tia Wulandari, S.Pd., Gr.',
                'principal_title' => 'Kepala Sekolah SMPIT',
                'principal_photo' => '/uploads/media/094bd24f5cbf61735c098a3e594dd544.webp',
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

    public function getUnitData($code)
    {
        $cleanCode = strtolower(trim($code));
        if ($cleanCode === 'kbtkit') {
            $cleanCode = 'tkit';
        }
        $schoolCode = $cleanCode;
        $school = School::withCount(['students', 'employees', 'classrooms'])
            ->where('code', strtoupper($cleanCode))
            ->first();

        // Get dynamic unit profile override from SiteSetting if available
        $dynamicUnitSetting = SiteSetting::get("unit_profile_{$cleanCode}");
        $customUnit = null;
        if ($dynamicUnitSetting) {
            $customUnit = json_decode($dynamicUnitSetting, true);
            if (!$customUnit && is_string($dynamicUnitSetting)) {
                $customUnit = json_decode(stripcslashes($dynamicUnitSetting), true);
            }
        }

        if (!$customUnit) {
            $cachePath = database_path('authentic_unit_data.json');
            if (!file_exists($cachePath)) {
                $cachePath = storage_path('app/authentic_unit_data.json');
            }
            if (file_exists($cachePath)) {
                $cachedAll = json_decode(file_get_contents($cachePath), true);
                if (!empty($cachedAll[$cleanCode])) {
                    $customUnit = $cachedAll[$cleanCode];
                }
            }
        }

        $themeTokens = [
            'smpit' => [
                'primary' => '#4338ca',
                'primary_dark' => '#312e81',
                'primary_light' => '#6366f1',
                'electric_blue' => '#2563eb',
                'gold' => '#f59e0b',
                'gold_light' => '#fbbf24',
                'dark' => '#0f172a',
                'dark_container' => '#1e1b4b',
                'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
                'hero_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
                'badge_bg' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
                'badge_pill' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                'accent_text' => 'text-indigo-600',
                'btn_primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
                'btn_gold' => 'bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950',
                'border_accent' => 'border-indigo-600',
                'bg_light' => 'bg-indigo-50/70',
                'top_bar' => '#0f172a',
            ],
            'tkit' => [
                'primary' => '#ea580c',
                'primary_dark' => '#78350f',
                'primary_light' => '#f97316',
                'electric_blue' => '#ea580c',
                'gold' => '#f59e0b',
                'gold_light' => '#fbbf24',
                'dark' => '#0f172a',
                'dark_container' => '#431407',
                'nav_gradient' => 'from-stone-950 via-orange-950 to-amber-950',
                'hero_gradient' => 'from-[#78350f] via-[#c2410c] to-[#ea580c]',
                'badge_bg' => 'bg-orange-100 text-orange-800 border-orange-200',
                'badge_pill' => 'bg-orange-50 text-orange-700 border border-orange-200',
                'accent_text' => 'text-orange-600',
                'btn_primary' => 'bg-orange-600 hover:bg-orange-700 text-white',
                'btn_gold' => 'bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950',
                'border_accent' => 'border-orange-600',
                'bg_light' => 'bg-orange-50/70',
                'top_bar' => '#0f172a',
            ],
            'sdit' => [
                'primary' => '#065f46',
                'primary_dark' => '#003828',
                'primary_light' => '#10b981',
                'electric_blue' => '#059669',
                'gold' => '#f59e0b',
                'gold_light' => '#fbbf24',
                'dark' => '#0f172a',
                'dark_container' => '#022c22',
                'nav_gradient' => 'from-stone-950 via-emerald-950 to-teal-950',
                'hero_gradient' => 'from-[#003828] via-[#065f46] to-[#047857]',
                'badge_bg' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'badge_pill' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'accent_text' => 'text-emerald-600',
                'btn_primary' => 'bg-emerald-700 hover:bg-emerald-800 text-white',
                'btn_gold' => 'bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950',
                'border_accent' => 'border-emerald-600',
                'bg_light' => 'bg-emerald-50/70',
                'top_bar' => '#0f172a',
            ],
            'smait' => [
                'primary' => '#6d28d9',
                'primary_dark' => '#1e1b4b',
                'primary_light' => '#8b5cf6',
                'electric_blue' => '#7c3aed',
                'gold' => '#f59e0b',
                'gold_light' => '#fbbf24',
                'dark' => '#0f172a',
                'dark_container' => '#2e1065',
                'nav_gradient' => 'from-stone-950 via-purple-950 to-indigo-950',
                'hero_gradient' => 'from-[#1e1b4b] via-[#4c1d95] to-[#6d28d9]',
                'badge_bg' => 'bg-purple-100 text-purple-800 border-purple-200',
                'badge_pill' => 'bg-purple-50 text-purple-700 border border-purple-200',
                'accent_text' => 'text-purple-600',
                'btn_primary' => 'bg-purple-700 hover:bg-purple-800 text-white',
                'btn_gold' => 'bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950',
                'border_accent' => 'border-purple-600',
                'bg_light' => 'bg-purple-50/70',
                'top_bar' => '#0f172a',
            ],
        ];

        $unitMap = $this->getDefaultUnitMap($themeTokens);

        $uKey = isset($unitMap[$cleanCode]) ? $cleanCode : 'sdit';
        $defaultInfo = $unitMap[$uKey];

        // Merge custom setting if present
        $info = array_merge($defaultInfo, array_filter($customUnit ?? []));

        if ($cleanCode === 'smait') {
            $info['teachers'] = [];
            $info['facilities'] = [];
            $info['ekskul'] = [];
            $info['programs'] = [];
            $info['gallery'] = [];
            $info['videos'] = [];
            $info['agenda'] = [];
            $info['announcements'] = [];
            $info['alumni'] = [];
            $info['prestasi'] = [];
            $info['students_count'] = 0;
            $info['employees_count'] = 0;
            $info['classrooms_count'] = 0;
            $info['status'] = 'BELUM_DIBUKA';
            $info['tagline'] = 'Sekolah Menengah Atas Islam Terpadu - Segera Dibuka';
            $info['principal_name'] = 'Tahap Persiapan Operasional';
            $info['principal_title'] = 'Kepala Sekolah';
            $info['principal_greeting'] = 'Pendidikan jenjang SMA IT Robbani saat ini sedang dalam tahap persiapan sarana prasarana dan perizinan operasional resmi. Insya Allah segera hadir untuk melahirkan generasi pemimpin bangsa yang Qur\'ani dan berwawasan teknologi global.';
            $info['description'] = 'SMA IT Robbani saat ini dalam tahap persiapan pembukaan dan perizinan operasional. Program pendidikan dirancang untuk mempersiapkan siswa menuju perguruan tinggi unggulan dan penguasaan ilmu syar\'i serta sains teknologi modern.';

            $students = collect([]);
            $teachers = collect([]);
            $classrooms = collect([]);
            $unitNews = collect([]);
            $unitArticles = collect([]);
            $unitFacilities = [];
            $unitEkskul = [];
            $unitGallery = [];
            $unitPrestasi = [];
            $unitVideos = [];
            $unitAgendas = [];
            $unitAnnouncements = [];
            $unitPrograms = [];
            $unitAlumni = [];
        } else {
            foreach (['programs', 'facilities', 'ekskul'] as $key) {
                $userItems = !empty($info[$key]) && is_array($info[$key]) ? $info[$key] : [];
                $defaultItems = $defaultInfo[$key] ?? [];
                if (empty($userItems)) {
                    $info[$key] = $defaultItems;
                    continue;
                }
                foreach ($userItems as $idx => &$uItem) {
                    if (empty($uItem['image']) || str_contains($uItem['image'], 'mockup_desktop')) {
                        $matchedDefault = null;
                        foreach ($defaultItems as $dItem) {
                            if (strtolower(trim($dItem['title'] ?? '')) === strtolower(trim($uItem['title'] ?? ''))) {
                                $matchedDefault = $dItem;
                                break;
                            }
                        }
                        if (!$matchedDefault && isset($defaultItems[$idx])) {
                            $matchedDefault = $defaultItems[$idx];
                        }
                        if ($matchedDefault && !empty($matchedDefault['image'])) {
                            $uItem['image'] = $matchedDefault['image'];
                        }
                    }
                }
                unset($uItem);
                $info[$key] = $userItems;
            }

            // Sanitasi dan validasi foto kepala sekolah & banner dari artefak dummy
            if (empty($info['principal_photo']) || str_contains($info['principal_photo'], 'uploads/dewan') || str_contains($info['principal_photo'], 'kepsek_smpit')) {
                $info['principal_photo'] = $defaultInfo['principal_photo'] ?? '/uploads/media/094bd24f5cbf61735c098a3e594dd544.webp';
            }
            if (empty($info['hero_bg_image']) || str_contains($info['hero_bg_image'], 'herobg_smpit')) {
                $info['hero_bg_image'] = $defaultInfo['hero_bg_image'] ?? '/uploads/cms/banner-hero.webp';
            }
            if (empty($info['hero_image']) || str_contains($info['hero_image'], 'hero_smpit')) {
                $info['hero_image'] = $defaultInfo['hero_image'] ?? $info['hero_bg_image'];
            }
            if (empty($info['campus_photo']) || str_contains($info['campus_photo'], 'herobg_smpit')) {
                $info['campus_photo'] = $defaultInfo['campus_photo'] ?? $info['hero_bg_image'];
            }

            if (empty($info['teachers'])) {
                $info['teachers'] = $defaultInfo['teachers'] ?? [];
            } else {
                // Bersihkan referensi dummy /uploads/dewan dan path 404 pada data guru
                foreach ($info['teachers'] as &$tcItem) {
                    $p = $tcItem['photo'] ?? '';
                    if (empty($p) || str_contains($p, 'uploads/dewan') || str_contains($p, 'guru_smpit')) {
                        $matchedPhoto = null;
                        foreach ($defaultInfo['teachers'] ?? [] as $dTeach) {
                            if (strtolower(trim($dTeach['name'] ?? '')) === strtolower(trim($tcItem['name'] ?? ''))) {
                                $matchedPhoto = $dTeach['photo'] ?? null;
                                break;
                            }
                        }
                        $tcItem['photo'] = $matchedPhoto ?: '/images/avatar-gray-person.svg';
                    }
                }
                unset($tcItem);
            }

            // Sanitasi seluruh referensi /uploads/dewan yang tersisa pada seluruh data info unit (alumni, fasilitas, ekskul, dll)
            array_walk_recursive($info, function (&$val, $key) {
                if (is_string($val) && str_contains($val, 'uploads/dewan')) {
                    $val = '/images/avatar-gray-person.svg';
                }
            });

            $students = Student::where('school_id', $school->id ?? 1)->where(function($q) { $q->where('status', 'aktif')->orWhere('status', 'ACTIVE'); })->take(10)->get();
            $teachers = Employee::where('school_id', $school->id ?? 1)->where('is_active', true)->take(8)->get();
            $classrooms = Classroom::where('school_id', $school->id ?? 1)->with('level')->get();

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
            $unitPrestasi = !empty($info['prestasi']) ? $info['prestasi'] : ($defaultInfo['prestasi'] ?? []);

            $unitVideos = $info['videos'] ?? [];
            if (empty($unitVideos)) {
                $globalVideos = $this->getVideoData();
                $unitVideos = array_map(function($v) {
                    $ytId = $v['youtube_id'] ?? $v['embed_id'] ?? '';
                    if (empty($ytId) && !empty($v['url'])) {
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $v['url'], $match)) {
                            $ytId = $match[1];
                        }
                    }
                    $thumb = !empty($ytId) ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : ($v['thumbnail'] ?? $v['image'] ?? '/images/mockup_desktop_4.png');
                    return [
                        'title' => $v['title'],
                        'url' => !empty($ytId) ? 'https://www.youtube.com/watch?v=' . $ytId : ($v['url'] ?? 'https://youtube.com'),
                        'embed_id' => $ytId,
                        'thumbnail' => $thumb,
                        'image' => $thumb,
                        'date' => $v['date'] ?? 'Dokumentasi Video Resmi',
                        'desc' => $v['desc'] ?? $v['title']
                    ];
                }, $globalVideos);
            } else {
                $unitVideos = array_map(function($v) {
                    $ytId = $v['embed_id'] ?? $v['youtube_id'] ?? '';
                    if (empty($ytId) && !empty($v['url'])) {
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $v['url'], $match)) {
                            $ytId = $match[1];
                        }
                    }
                    $thumb = !empty($ytId) ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : ($v['thumbnail'] ?? $v['image'] ?? '/images/mockup_desktop_4.png');
                    $v['embed_id'] = $ytId;
                    $v['thumbnail'] = $thumb;
                    $v['image'] = $thumb;
                    return $v;
                }, $unitVideos);
            }

            $xmlData = $this->getXmlUnitEventsAndAnnouncements($cleanCode);
            
            $unitAgendas = !empty($info['agenda']) ? $info['agenda'] : $xmlData['agenda'];
            if (empty($unitAgendas)) {
                $allAgendas = $this->getAgendaData();
                $unitAgendas = array_map(function($ag) {
                    return [
                        'title' => $ag['title'],
                        'date_day' => $ag['date_day'] ?? '25',
                        'date_month' => $ag['date_month'] ?? 'AGU',
                        'date' => ($ag['date_day'] ?? '25') . ' ' . ($ag['date_month'] ?? 'AGU') . ' ' . ($ag['year'] ?? '2026'),
                        'time' => $ag['time'] ?? '08:00 WIB',
                        'location' => $ag['location'] ?? 'Kampus Sekolah',
                        'desc' => $ag['category'] ?? 'Kegiatan Terjadwal Unit'
                    ];
                }, $allAgendas);
            } else {
                foreach ($unitAgendas as &$agItem) {
                    if (empty($agItem['date_day'])) {
                        $agItem['date_day'] = '15';
                    }
                    if (empty($agItem['date_month'])) {
                        $agItem['date_month'] = 'AGU';
                    }
                }
                unset($agItem);
            }

            $unitAnnouncements = !empty($info['announcements']) ? $info['announcements'] : $xmlData['announcements'];
            if (empty($unitAnnouncements)) {
                $allAnnouncements = $this->getAnnouncementData();
                $unitAnnouncements = array_map(function($an) {
                    return [
                        'title' => $an['title'],
                        'date' => $an['date'] ?? '17 Agustus 2026',
                        'category' => $an['category'] ?? 'Pengumuman Resmi',
                        'summary' => $an['summary'] ?? '',
                        'link' => $an['link'] ?? route('school.berita')
                    ];
                }, $allAnnouncements);
            }

            $unitPrograms = !empty($info['programs']) ? $info['programs'] : ($defaultInfo['programs'] ?? $defaultInfo['ekskul'] ?? $unitEkskul);
            $unitAlumni = !empty($info['alumni']) ? $info['alumni'] : [];
        }

        // Sanitasi global seluruh referensi /uploads/dewan yang tersisa pada seluruh data info unit (termasuk SMAIT)
        array_walk_recursive($info, function (&$val, $key) {
            if (is_string($val) && str_contains($val, 'uploads/dewan')) {
                $val = '/images/avatar-gray-person.svg';
            }
        });
        if (empty($info['principal_photo']) || str_contains($info['principal_photo'], 'uploads/dewan') || str_contains($info['principal_photo'], 'kepsek_smpit')) {
            $info['principal_photo'] = $defaultInfo['principal_photo'] ?? '/images/avatar-gray-person.svg';
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

        $settings = $this->getSettings();
        $headerMenus = $this->getHeaderMenus();

        $currentHost = request()->getHost();
        $subdomains = ['tk', 'tkit', 'sd', 'sdit', 'smp', 'smpit', 'sma', 'smait', 'spmb'];
        $parts = explode('.', $currentHost);
        if (count($parts) >= 3 && in_array(strtolower($parts[0]), $subdomains)) {
            array_shift($parts);
            $portalUrl = request()->getScheme() . '://' . implode('.', $parts);
        } elseif (str_contains($currentHost, 'sitrobbani.sch.id')) {
            $portalUrl = 'https://sitrobbani.sch.id';
        } else {
            $portalUrl = config('app.url') ?: route('home');
        }

        $unitPrograms = !empty($info['programs']) ? $info['programs'] : ($defaultInfo['programs'] ?? $defaultInfo['ekskul'] ?? $unitEkskul);
        $unitAlumni = !empty($info['alumni']) ? $info['alumni'] : [];

        return compact(
            'school', 'info', 'students', 'teachers', 'classrooms', 'settings', 'headerMenus',
            'unitNews', 'unitArticles', 'unitFacilities', 'unitEkskul', 'unitGallery', 'unitVideos', 'unitAgendas', 'unitAnnouncements', 'unitPrestasi',
            'unitPrograms', 'unitAlumni',
            'schoolCode', 'portalUrl'
        );
    }

    public function unitProfile($code)
    {
        $page = request()->query('page');
        if ($page === 'visi-misi' || $page === 'visi_misi' || $page === 'visi-dan-misi') {
            return $this->unitVisiMisiPage($code);
        }
        if ($page === 'sambutan' || $page === 'sambutan-kepala-sekolah') {
            return $this->unitSambutanPage($code);
        }
        if ($page === 'sejarah') {
            return $this->unitSejarahPage($code);
        }
        if ($page === 'profil' || $page === 'tentang-kami') {
            return $this->unitProfilPage($code);
        }
        if ($page === 'dewan-guru' || $page === 'guru') {
            return $this->unitDewanGuruPage($code);
        }
        if ($page === 'fasilitas') {
            return $this->unitFasilitasPage($code);
        }
        if ($page === 'program-unggulan' || $page === 'program') {
            return $this->unitProgramUnggulanPage($code);
        }
        if ($page === 'struktur-organisasi' || $page === 'struktur') {
            return $this->unitStrukturOrganisasiPage($code);
        }
        if ($page === 'agenda') {
            return $this->unitAgendaPage($code);
        }
        if ($page === 'pengumuman') {
            return $this->unitPengumumanPage($code);
        }
        if ($page === 'galeri') {
            return $this->unitGaleriPage($code);
        }
        if ($page === 'video') {
            return $this->unitVideoPage($code);
        }
        if ($page === 'download') {
            return $this->unitDownloadPage($code);
        }
        if ($page === 'e-book' || $page === 'ebook') {
            return $this->unitEbookPage($code);
        }
        if ($page === 'hymne-mars' || $page === 'mars') {
            return $this->unitHymneMarsPage($code);
        }
        if ($page === 'logo') {
            return $this->unitLogoPage($code);
        }
        if ($page === 'layanan' || $page === 'layanan-terpadu') {
            return $this->unitLayananPage($code);
        }
        if ($page === 'izin-sekolah' || $page === 'layanan/kunjungan' || $page === 'kunjungan') {
            return $this->unitLayananKunjunganPage($code);
        }
        if ($page === 'permohonan-kerja-sama' || $page === 'layanan/kerjasama' || $page === 'kerjasama') {
            return $this->unitLayananKerjasamaPage($code);
        }
        if ($page === 'sewa-barang' || $page === 'layanan/sewa' || $page === 'sewa') {
            return $this->unitLayananSewaPage($code);
        }
        if ($page === 'hubungi' || $page === 'kontak') {
            return $this->unitHubungiPage($code);
        }
        if ($page === 'testimoni' || $page === 'testimonial') {
            return $this->unitTestimoniPage($code);
        }
        if ($page === 'artikel' || $page === 'berita') {
            return $this->unitArtikelPage($code);
        }

        $data = $this->getUnitData($code);
        return view('school.unit.home', $data);
    }

    public function unitProfilPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.profil', $data);
    }

    public function unitVisiMisiPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.visi-misi', $data);
    }

    public function unitSambutanPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.sambutan', $data);
    }

    public function unitSejarahPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.sejarah', $data);
    }

    public function unitDewanGuruPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.dewan-guru', $data);
    }

    public function unitFasilitasPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.fasilitas', $data);
    }

    public function unitProgramUnggulanPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.program-unggulan', $data);
    }

    public function unitStrukturOrganisasiPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.struktur-organisasi', $data);
    }

    public function unitAgendaPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.agenda', $data);
    }

    public function unitPengumumanPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.pengumuman', $data);
    }

    public function unitGaleriPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.galeri', $data);
    }

    public function unitVideoPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.video', $data);
    }

    public function unitDownloadPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.download', $data);
    }

    public function unitEbookPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.e-book', $data);
    }

    public function unitHymneMarsPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.hymne-mars', $data);
    }

    public function unitLogoPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.logo', $data);
    }

    public function unitLayananPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.layanan', $data);
    }

    public function unitLayananKunjunganPage($code)
    {
        $data = $this->getUnitData($code);
        $activeTab = 'kunjungan';
        return view('school.unit.layanan.kunjungan', array_merge($data, compact('activeTab')));
    }

    public function unitLayananKerjasamaPage($code)
    {
        $data = $this->getUnitData($code);
        $activeTab = 'kerjasama';
        return view('school.unit.layanan.kerjasama', array_merge($data, compact('activeTab')));
    }

    public function unitLayananSewaPage($code)
    {
        $data = $this->getUnitData($code);
        $activeTab = 'sewa';
        return view('school.unit.layanan.sewa', array_merge($data, compact('activeTab')));
    }

    public function unitHubungiPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.hubungi', $data);
    }

    public function unitTestimoniPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.testimoni', $data);
    }

    public function unitArtikelPage($code)
    {
        $data = $this->getUnitData($code);
        return view('school.unit.artikel', $data);
    }

    public function beritaIndex(\Illuminate\Http\Request $request)
    {
        $settings = $this->getSettings();
        $newsList = $this->getNewsData();
        $activeCategory = strtolower($request->query('category') ?? $request->query('unit') ?? 'all');
        return view('school.berita.index', compact('settings', 'newsList', 'activeCategory'));
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

    public function storeLayananKunjungan(Request $request, $code = null)
    {
        $request->validate([
            'instansi' => 'required|string|max:255',
            'nama_pemohon' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:50',
            'tgl_kunjungan' => 'required|date',
            'jumlah_peserta' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:2000',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $docPath = null;
        if ($request->hasFile('file_dokumen')) {
            $docPath = $request->file('file_dokumen')->store('layanan_kunjungan', 'public');
        }

        \App\Models\PublicServiceRequest::create([
            'request_type' => 'kunjungan',
            'institution_name' => $request->instansi,
            'applicant_name' => $request->nama_pemohon,
            'email' => $request->email,
            'phone_number' => $request->no_hp,
            'event_date' => $request->tgl_kunjungan,
            'participants_count' => $request->jumlah_peserta,
            'facility_or_type' => 'Kunjungan & Studi Banding' . ($code ? ' - Unit ' . strtoupper($code) : ''),
            'purpose_description' => $request->tujuan,
            'document_path' => $docPath,
            'status' => 'PENDING',
        ]);

        return redirect()->back()->with('success', 'Permohonan Izin Kunjungan Sekolah berhasil dikirim! Tim Humas akan menghubungi Anda melalui WhatsApp/Email.');
    }

    public function layananKerjasama()
    {
        $settings = $this->getSettings();
        $activeTab = 'kerjasama';
        return view('school.layanan.index', compact('settings', 'activeTab'));
    }

    public function storeLayananKerjasama(Request $request, $code = null)
    {
        $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'nama_kontak' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_hp' => 'required|string|max:50',
            'jenis_kerjasama' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:3000',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $docPath = null;
        if ($request->hasFile('file_dokumen')) {
            $docPath = $request->file('file_dokumen')->store('layanan_kerjasama', 'public');
        }

        \App\Models\PublicServiceRequest::create([
            'request_type' => 'kerjasama',
            'institution_name' => $request->nama_lembaga,
            'applicant_name' => $request->nama_kontak,
            'email' => $request->email,
            'phone_number' => $request->no_hp,
            'facility_or_type' => $request->jenis_kerjasama . ($code ? ' - Unit ' . strtoupper($code) : ''),
            'purpose_description' => $request->deskripsi,
            'document_path' => $docPath,
            'status' => 'PENDING',
        ]);

        return redirect()->back()->with('success', 'Permohonan Kerjasama & Kemitraan telah diterima! Tim Kemitraan SIT Robbani akan memproses proposal Anda.');
    }

    public function layananSewa()
    {
        $settings = $this->getSettings();
        $facilityList = $this->getFacilityData();
        $activeTab = 'sewa';
        return view('school.layanan.index', compact('settings', 'facilityList', 'activeTab'));
    }

    public function storeLayananSewa(Request $request, $code = null)
    {
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'no_hp' => 'required|string|max:50',
            'fasilitas_disewa' => 'required|string|max:255',
            'tgl_sewa' => 'required|date',
            'keperluan' => 'required|string|max:2000',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $docPath = null;
        if ($request->hasFile('file_dokumen')) {
            $docPath = $request->file('file_dokumen')->store('layanan_sewa', 'public');
        }

        \App\Models\PublicServiceRequest::create([
            'request_type' => 'sewa',
            'institution_name' => $request->nama_penyewa,
            'applicant_name' => $request->nama_penyewa,
            'phone_number' => $request->no_hp,
            'event_date' => $request->tgl_sewa,
            'facility_or_type' => $request->fasilitas_disewa,
            'purpose_description' => $request->keperluan,
            'document_path' => $docPath,
            'status' => 'PENDING',
        ]);

        return redirect()->back()->with('success', 'Permohonan Sewa Fasilitas Sekolah telah diajukan! Pengelola sarana prasarana akan mengonfirmasi jadwal & ketersediaan.');
    }

    public function spmbLanding(Request $request)
    {
        $settings = $this->getSettings();
        $schools = School::where('is_active', true)->get();
        return view('school.spmb_landing', compact('settings', 'schools'));
    }

    public function ppdbForm(Request $request)
    {
        $settings = $this->getSettings();
        $schools = School::where('is_active', true)->get();
        $selectedUnit = strtoupper($request->query('jenjang', $request->query('unit', $request->query('school_code', ''))));
        return view('school.ppdb', compact('settings', 'schools', 'selectedUnit'));
    }

    public function checkSpmbStatus(Request $request)
    {
        $q = trim($request->input('q', $request->input('reg', '')));
        if (empty($q)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['found' => false, 'message' => 'Masukkan nomor registrasi atau NISN.']);
            }
            return redirect()->route('school.spmb')->with('error', 'Silakan masukkan nomor registrasi SPMB Anda.');
        }

        $registration = \App\Models\PpdbRegistration::where('registration_number', $q)
            ->orWhere('registration_number', 'LIKE', '%' . $q . '%')
            ->orWhere('phone_number', $q)
            ->latest()
            ->first();

        if ($request->ajax() || $request->wantsJson()) {
            if (!$registration) {
                return response()->json(['found' => false, 'message' => 'Data registrasi tidak ditemukan. Pastikan nomor pendaftaran sudah benar.']);
            }

            return response()->json([
                'found' => true,
                'registration' => [
                    'id' => $registration->id,
                    'registration_number' => $registration->registration_number,
                    'full_name' => $registration->full_name,
                    'target_level' => $registration->target_level,
                    'parent_name' => $registration->parent_name,
                    'phone_number' => $registration->phone_number,
                    'status' => $registration->status,
                    'fee_paid' => $registration->fee_paid,
                    'registration_fee' => $registration->registration_fee,
                    'created_at' => $registration->created_at ? $registration->created_at->translatedFormat('d F Y H:i') : '-',
                    'pdf_url' => route('school.spmb.download-pdf', $registration->id),
                ]
            ]);
        }

        if (!$registration) {
            return redirect()->route('school.spmb')->with('spmb_not_found', 'Nomor registrasi "' . $q . '" tidak ditemukan.');
        }

        return redirect()->route('school.spmb')->with('spmb_found_record', $registration);
    }

    public function storePpdb(Request $request)
    {
        $validated = $request->validate([
            'school_code' => 'required|string',
            'jalur_pendaftaran' => 'nullable|string',
            // IDENTITAS PESERTA DIDIK (F-SPMB)
            'nama_lengkap' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'nik_siswa' => 'nullable|numeric|digits:16',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'nullable|integer|min:1',
            'jumlah_saudara' => 'nullable|integer|min:0',
            'status_ortu' => 'nullable|string',
            'tempat_tinggal_anak' => 'nullable|string',
            'tempat_tinggal_lainnya' => 'nullable|string',
            // ALAMAT
            'alamat' => 'required|string',
            'dusun' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'bahasa_sehari_hari' => 'nullable|string',
            'bahasa_lainnya' => 'nullable|string',
            // DATA SEKOLAH
            'nisn' => 'nullable|numeric|digits_between:8,12',
            'masuk_kelas' => 'nullable|string',
            'status_siswa' => 'nullable|string',
            'kategori_sekolah_asal' => 'nullable|string',
            'sekolah_asal' => 'nullable|string',
            'prestasi' => 'nullable|string',
            // DATA KESEHATAN
            'tinggi_badan' => 'nullable|numeric|min:30|max:250',
            'berat_badan' => 'nullable|numeric|min:5|max:200',
            'golongan_darah' => 'nullable|string',
            'penyakit_pernah' => 'nullable|string',
            'penyakit_sedang' => 'nullable|string',
            'kelainan_fisik' => 'nullable|string',
            // MODA TRANSPORTASI
            'jarak_ke_sekolah' => 'nullable|string',
            'transportasi' => 'nullable|string',
            // DATA AYAH KANDUNG
            'nama_ayah' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'tempat_lahir_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'nik_ayah' => 'nullable|numeric|digits:16',
            'pendidikan_ayah' => 'nullable|string',
            'pekerjaan_ayah' => 'nullable|string',
            'instansi_ayah' => 'nullable|string',
            'bidang_keahlian_ayah' => 'nullable|string',
            'no_hp_ayah' => 'required|string|regex:/^[0-9\+\-\s]+$/',
            'email_ortu' => 'nullable|email',
            'penghasilan_ayah' => 'nullable|string',
            // DATA IBU KANDUNG
            'nama_ibu' => 'required|string|regex:/^[a-zA-Z\s\.\,\'\-]+$/|max:255',
            'tempat_lahir_ibu' => 'nullable|string',
            'tanggal_lahir_ibu' => 'nullable|date',
            'nik_ibu' => 'nullable|numeric|digits:16',
            'pendidikan_ibu' => 'nullable|string',
            'pekerjaan_ibu' => 'nullable|string',
            'instansi_ibu' => 'nullable|string',
            'alamat_ibu' => 'nullable|string',
            'no_hp_ibu' => 'nullable|string|regex:/^[0-9\+\-\s]+$/',
            'penghasilan_ibu' => 'nullable|string',
            // DATA WALI (OPSIONAL)
            'nama_wali' => 'nullable|string',
            'hubungan_wali' => 'nullable|string',
            'no_hp_wali' => 'nullable|string',
            // INFORMASI PENDAFTARAN
            'info_pendaftaran' => 'nullable|string',
            'info_pendaftaran_lainnya' => 'nullable|string',
            // File Uploads
            'pas_foto' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:5000',
            'ktp_ortu' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5000',
            'kartu_keluarga' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5000',
            'akta_kelahiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5000',
            'bukti_transfer' => 'nullable|file|mimes:jpg,jpeg,png,pdf,webp|max:5000',
        ]);

        $uploadedDocs = [];
        $uploadFields = ['pas_foto', 'ktp_ortu', 'kartu_keluarga', 'akta_kelahiran', 'bukti_transfer'];
        
        $uploadDir = public_path('uploads/spmb');
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0775, true);
        }

        foreach ($uploadFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $file = $request->file($field);
                $clientExt = strtolower($file->getClientOriginalExtension());
                $ext = in_array($clientExt, ['jpg', 'jpeg', 'png', 'pdf', 'webp']) ? $clientExt : 'jpg';
                $filename = time() . '_' . $field . '_' . rand(100, 999) . '.' . $ext;
                $file->move($uploadDir, $filename);
                $uploadedDocs[$field] = '/uploads/spmb/' . $filename;
            } else {
                $uploadedDocs[$field] = null;
            }
        }

        $schoolCode = strtoupper($request->school_code);
        $schoolObj = School::where('code', $schoolCode)->first() ?? School::first();

        $fees = [
            'TPA' => 200000,
            'KB' => 200000,
            'TK' => 200000,
            'TKIT' => 200000,
            'SD' => 250000,
            'SDIT' => 250000,
            'SMP' => 300000,
            'SMPIT' => 300000,
            'SMA' => 350000,
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
            'previous_school' => $request->sekolah_asal ?? 'Sekolah Asal',
            'status' => 'PENDING',
            'registration_fee' => $registrationFee,
            'fee_paid' => !empty($uploadedDocs['bukti_transfer']),
            'details_json' => $detailsArray,
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

        if (is_numeric($id)) {
            $registration = \App\Models\PpdbRegistration::findOrFail($id);
            $requestReg = request('reg');
            if (!auth()->check() && $requestReg && $requestReg !== $registration->registration_number) {
                abort(403, 'Akses tidak sah: Nomor registrasi verifikasi tidak sesuai.');
            }
        } else {
            $registration = \App\Models\PpdbRegistration::where('registration_number', $id)->firstOrFail();
        }

        return view('school.spmb_pdf', compact('settings', 'registration'));
    }

    public function verifySpmb($regNumber)
    {
        $settings = $this->getSettings();
        $registration = \App\Models\PpdbRegistration::where('registration_number', $regNumber)->firstOrFail();
        return view('school.spmb_verify', compact('settings', 'registration'));
    }

    public function eSppCheck(?Request $request = null)
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
                // Deduplicate by title slug & sort newest first
                $uniqueMap = [];
                foreach ($data as $item) {
                    $key = \Illuminate\Support\Str::slug($item['title'] ?? '');
                    if (!empty($key) && !isset($uniqueMap[$key])) {
                        $uniqueMap[$key] = $item;
                    }
                }
                foreach ($uniqueMap as &$uItem) {
                    if (!empty($uItem['image']) && (str_contains($uItem['image'], 'post_1787071061') || str_contains($uItem['image'], 'img20251124075603-scaled_0267776a'))) {
                        $uItem['image'] = '/uploads/media/smpit_post_IMG20251124075603-scaled_6e6f5f2c.jpg';
                    }
                }
                unset($uItem);
                $data = array_values($uniqueMap);
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
                'image' => '/uploads/media/img20220127093650-scaled_e1faddf6.jpg',
                'excerpt' => 'Keceriaan dan kebersamaan siswa cilik KB/TKIT Robbani Ogan Ilir saat mengekspresikan bakat hafalan surah pendek, doa harian, & kreasi mewarnai bersama bundanya.',
                'content' => 'Ogan Ilir — Suasana penuh warna dan keceriaan mewarnai aula KB/TKIT Robbani Ogan Ilir dalam gelaran Puncak Tema & Pentas Seni Cilik Siswa Usia Dini Tahun Ajaran 2026/2027.<br><br>Acara ini diselenggarakan sebagai wadah apresiasi tumbuh kembang, keberanian, dan kreativitas siswa cilik KB/TKIT Robbani setelah menyelesaikan tema pembelajaran semester ganjil.<br><br>Para siswa dengan percaya diri menampilkan unjuk bakat hafalan surah-surah pendek Al-Qur\'an (Juz Amma), perkataan thoyyibah, doa harian, tarian kreasi nusantara islami, serta fashion show pakaian adat.<br><br>Kepala KB/TKIT Robbani, Ani Oktar Yansi, S.Pd.I, menyampaikan rasa syukur dan haru atas perkembangan adab dan kemandirian ananda.'
            ],
            [
                'title' => 'Pramuka SIT & Supercamp Karakter Siswa SDIT Robbani 2026',
                'slug' => 'pramuka-sit-supercamp-karakter-siswa-sdit-robbani-2026',
                'category' => 'SDIT',
                'date' => '08 Agustus 2026',
                'author' => 'Pembina Pramuka SDIT',
                'image' => '/uploads/media/1-e1643012044561_a09877b7.jpeg',
                'excerpt' => 'Pelatihan kemandirian, ketangkasan, dan mabit malam bina iman takwa siswa penggalang SDIT Robbani Ogan Ilir.',
                'content' => 'Ogan Ilir — Ratusan siswa penggalang Sekolah Dasar Islam Terpadu (SDIT) Robbani Ogan Ilir antusias mengikuti kegiatan Perkemahan Sabtu-Minggu (Persami) & Supercamp Karakter Pramuka SIT 2026 di Bumi Perkemahan Kampus Terpadu Robbani.<br><br>Kegiatan yang mengusung tema "Tangguh, Mandiri, Berakhlak Karimah, dan Siap Memimpin" ini diisi dengan berbagai materi ketangkasan, sandi morse, pioneering tali temali, penjelajahan alam halang rintang, serta pertunjukan api unggun.'
            ],
            [
                'title' => 'Kepala SMP IT Robbani Ogan Ilir Raih Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah Sumatera Selatan 2026',
                'slug' => 'kepsek-smp-it-robbani-raih-peserta-terbaik-iii',
                'category' => 'SMPIT',
                'date' => '31 Juli 2026',
                'author' => 'Humas SIT Robbani',
                'image' => '/uploads/media/smpit_post_IMG20251124075603-scaled_6e6f5f2c.jpg',
                'excerpt' => 'Alhamdulillah, Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir berhasil meraih Penghargaan Peserta Terbaik III dalam Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan.',
                'content' => 'Ogan Ilir — Sebuah kebanggaan besar kembali diukir oleh keluarga besar Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir. Ibu Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir, berhasil meraih penghargaan sebagai Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan Tahun 2026.'
            ],
            [
                'title' => 'Siswa SMAIT Robbani Lolos Seleksi PTN Favorit & Beasiswa Luar Negeri 2026',
                'slug' => 'siswa-smait-robbani-lolos-seleksi-ptn-favorit-beasiswa-luar-negeri-2026',
                'category' => 'SMAIT',
                'date' => '20 Juli 2026',
                'author' => 'Tim Bimbingan Konseling SMAIT',
                'image' => '/uploads/media/5_b3b7f870.jpg',
                'excerpt' => 'Capaian membanggakan alumni SMAIT Robbani tembus jalur SNBP, SNBT, dan beasiswa perguruan tinggi ternama di dalam maupun luar negeri.',
                'content' => 'Ogan Ilir — Kualitas lulusan Sekolah Menengah Atas Islam Terpadu (SMAIT) Robbani Ogan Ilir kembali terbukti di kancah nasional dan internasional. Berdasarkan pengumuman resmi kelulusan PTN 2026, puluhan alumni SMAIT Robbani berhasil diterima di Perguruan Tinggi Negeri (PTN) favorit seperti Universitas Sriwijaya, ITB, UGM, UNDIP, serta Universitas Al-Azhar Kairo.'
            ],
            [
                'title' => 'Kegiatan Fun Cooking & Edukasi Gizi Siswa Usia Dini TKIT Robbani',
                'slug' => 'kegiatan-fun-cooking-edukasi-gizi-siswa-usia-dini-tkit-robbani',
                'category' => 'KB/TKIT',
                'date' => '05 Juli 2026',
                'author' => 'Tim Kurikulum TKIT',
                'image' => '/uploads/media/3_0996b3f3.png',
                'excerpt' => 'Mengenalkan makanan sehat halal dan thoyyib sejak dini melalui praktik memasak menyenangkan bersama ustazah dan wali murid.',
                'content' => 'Ogan Ilir — Para siswa cilik KB/TKIT Robbani antusias mengikuti kegiatan Fun Cooking & Edukasi Makanan Sehat Halalan Thoyyiban di halaman sekolah.'
            ],
            [
                'title' => 'Munaqosyah Tahfidz Juz 29 & 30 Terbuka SDIT Robbani Ogan Ilir',
                'slug' => 'munaqosyah-tahfidz-juz-29-30-terbuka-sdit-robbani-ogan-ilir',
                'category' => 'SDIT',
                'date' => '18 Juni 2026',
                'author' => 'Tim Al-Qur\'an SDIT',
                'image' => '/uploads/media/2_7c039504.png',
                'excerpt' => 'Ujian hafalan Al-Qur\'an terbuka siswa SDIT Robbani di hadapan para penguji munaqisy dan orang tua siswa.',
                'content' => 'Ogan Ilir — Puluhan siswa SDIT Robbani Ogan Ilir mengikuti ujian Munaqosyah Tahfidz Al-Qur\'an Juz 29 dan 30 secara terbuka di Masjid Kampus Robbani.'
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
                // Deduplicate by title slug
                $uniqueMap = [];
                foreach ($parsed as $item) {
                    $key = \Illuminate\Support\Str::slug($item['title'] ?? '');
                    if (!empty($key) && !isset($uniqueMap[$key])) {
                        $uniqueMap[$key] = $item;
                    }
                }
                $data = array_values($uniqueMap);
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
                'desc' => 'Unjuk bakat seni islami, pidato 3 bahasa, sains koding digital, dan kreasi siswa SMP IT Robbani Ogan Ilir.'
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

    /**
     * Dynamically parse XML backup files to extract Unit Agendas and Announcements
     */
    private function getXmlUnitEventsAndAnnouncements($code)
    {
        $cleanCode = strtolower($code);
        if ($cleanCode === 'kbtkit') $cleanCode = 'tkit';
        
        $xmlMap = [
            'sdit' => public_path('uploads/xml/sdislamterpadurobbani.WordPress.2026-08-17.xml'),
            'smpit' => public_path('uploads/xml/smpitrobbani.WordPress.2026-08-17.xml'),
            'tkit' => public_path('uploads/xml/tkitrobbani.WordPress.2026-08-17.xml'),
            'sit' => public_path('uploads/xml/sitrobbani.WordPress.2026-08-16.xml'),
        ];
        
        $filePath = $xmlMap[$cleanCode] ?? $xmlMap['sdit'];
        if (!file_exists($filePath)) {
            $filePath = $xmlMap['sit'];
        }
        
        $monthNamesIndo = [
            '01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR', '05' => 'MEI', '06' => 'JUN',
            '07' => 'JUL', '08' => 'AGU', '09' => 'SEP', '10' => 'OKT', '11' => 'NOV', '12' => 'DES'
        ];
        $monthNamesFull = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $agendas = [];
        $announcements = [];
        
        if (file_exists($filePath)) {
            $xml = @simplexml_load_file($filePath);
            if ($xml) {
                $ns = $xml->getNamespaces(true);
                foreach ($xml->channel->item as $item) {
                    $wp = $item->children($ns['wp'] ?? []);
                    if (!$wp) continue;
                    $status = (string)$wp->status;
                    if ($status !== 'publish') continue;
                    
                    $postType = (string)$wp->post_type;
                    $title = (string)$item->title;
                    $content = strip_tags((string)($item->children($ns['content'] ?? [])->encoded ?? ''));
                    $postDate = (string)$wp->post_date;
                    
                    $cats = [];
                    foreach ($item->category as $cat) {
                        $cats[] = strtolower((string)$cat);
                    }
                    $catStr = implode(' ', $cats);
                    
                    $year = substr($postDate, 0, 4);
                    $month = substr($postDate, 5, 2);
                    $day = substr($postDate, 8, 2);
                    
                    $dateDay = $day ? sprintf('%02d', intval($day)) : '15';
                    $dateMonth = $monthNamesIndo[$month] ?? 'AGU';
                    $fullFormattedDate = ($day ? intval($day) . ' ' : '') . ($monthNamesFull[$month] ?? 'Agustus') . ' ' . ($year ?: '2026');
                    
                    if ($postType === 'agenda' || $postType === 'event' || str_contains($catStr, 'agenda') || str_contains($catStr, 'kegiatan') || str_contains(strtolower($title), 'agenda')) {
                        $agendas[] = [
                            'title' => $title,
                            'date_day' => $dateDay,
                            'date_month' => $dateMonth,
                            'date' => $fullFormattedDate,
                            'time' => '08:00 WIB - Selesai',
                            'location' => 'Kampus SIT Robbani',
                            'desc' => mb_strimwidth(trim(preg_replace('/\s+/', ' ', $content)), 0, 140, '...'),
                            'category' => 'Agenda Unit',
                        ];
                    }
                    
                    if ($postType === 'pengumuman' || str_contains($catStr, 'pengumuman') || str_contains($catStr, 'info') || str_contains(strtolower($title), 'pengumuman')) {
                        $announcements[] = [
                            'title' => $title,
                            'date' => $fullFormattedDate,
                            'category' => 'Pengumuman Resmi',
                            'summary' => mb_strimwidth(trim(preg_replace('/\s+/', ' ', $content)), 0, 160, '...'),
                            'link' => '#',
                        ];
                    }
                }
            }
        }

        // If agendas or announcements empty for unit, pull fallback from SIT main XML
        if (empty($agendas) && file_exists($xmlMap['sit'])) {
            $sitData = $this->getXmlUnitEventsAndAnnouncements('sit');
            $agendas = array_slice($sitData['agenda'], 0, 5);
        }
        if (empty($announcements) && file_exists($xmlMap['sit'])) {
            $sitData = isset($sitData) ? $sitData : $this->getXmlUnitEventsAndAnnouncements('sit');
            $announcements = array_slice($sitData['announcements'], 0, 4);
        }

        return ['agenda' => $agendas, 'announcements' => $announcements];
    }

public function getDefaultUnitMap(array $themeTokens): array
    {
        return [
            'tkit' => [
                'name' => 'KB & TKIT Robbani Ogan Ilir',
                'code' => 'TKIT',
                'npsn' => '69888765',
                'akreditasi' => 'Terakreditasi Unggul (A)',
                'sub_badge' => 'KABUPATEN OGAN ILIR - Terakreditasi Unggul (A)',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Tumbuh Ceria, Berakhlak Mulia, & Hafiz Juz 30 Cilik',
                'principal_name' => 'Ani Oktar Yansi, S.Pd.I',
                'principal_title' => 'Kepala KB/TKIT Robbani',
                'principal_photo' => '/uploads/media/0a6337c9cb242ba8dfdca2fe9001e634.webp',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di KB/TKIT Robbani Ogan Ilir. Masa usia dini adalah masa keemasan (golden age) untuk menanamkan pondasi aqidah, adab islami, serta kecintaan pada Al-Qur\'an melalui suasana bermain yang edukatif dan menggembirakan.',
                'description' => 'Kelompok Bermain & Taman Kanak-Kanak Islam Terpadu Terakreditasi A di Ogan Ilir. Membina fitrah anak sejak dini dengan pendekatan sentra, pembiasaan hafalan surat-surat pendek Juz 30, doa harian, kemandirian, dan stimulasi motorik terpadu.',
                'vision' => 'Menjadi Lembaga PAUD Islam Terpadu Unggulan dalam Membentuk Karakter Anak Sholeh, Ceria, dan Berakhlak Qur\'ani.',
                'missions' => array (
  0 => 'Menanamkan aqidah yang lurus dan pembiasaan ibadah harian sejak usia dini.',
  1 => 'Membimbing hafalan Al-Qur\'an Juz 30 dengan metode nasyid yang menyenangkan.',
  2 => 'Mengembangkan potensi kecerdasan majemuk (multiple intelligences) dan motorik anak melalui bermain berbasis sentra.',
  3 => 'Membangun sinergi harmonis antara sekolah dan keluarga dalam mendampingi tumbuh kembang ananda.',
),
                'history' => [
                    'title' => 'Membangun Generasi Emas TKIT Robbani Ogan Ilir',
                    'badge' => 'Jejak Langkah & Perkembangan',
                    'image' => '/uploads/cms/hero_tkit_6a86ae75539c1_6a86ae7577583.webp?v=1787211382',
                    'paragraphs' => array (
  0 => 'KB & TKIT Robbani Ogan Ilir didirikan di bawah naungan Yayasan Generasi Robbani Sumatera Selatan sebagai wujud komitmen memberikan pendidikan Islam terpadu berkualitas di Kabupaten Ogan Ilir.',
  1 => 'Mengembangkan kurikulum terpadu nasional dan kekhasan JSIT (Jaringan Sekolah Islam Terpadu), pembinaan tahfidz Al-Qur\'an mutqin, serta penguatan adab Islami dan kemandirian peserta didik.',
  2 => 'Didukung oleh sarana pembelajaran modern, tenaga pendidik bersertifikasi dan berdedikasi tinggi, serta lingkungan kampus yang asri dan aman, kami terus berinovasi membina generasi Qur\'ani yang siap memimpin peradaban masa depan.',
),
                ],
                'phone' => '0811747472',
                'whatsapp' => '0811747472',
                'email' => 'tkit@sitrobbani.sch.id',
                'city' => 'Indralaya, Ogan Ilir, Sumatera Selatan',
                'address' => 'Jalan Sarjana Kompleks SIT Robbani, Kelurahan Timbangan, Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan',
                'domain' => 'sitrobbani.sch.id',
                'logo' => '/images/logo_tkit.png',
                'flyer' => '/images/spmb/flyer-spmb-sit-robbani.webp',
                'campus_photo' => '/uploads/cms/herobg_tkit_6a86ae753bcf1_6a86ae7541657.webp?v=1787211381',
                'hero_bg_image' => '/uploads/cms/herobg_tkit_6a86ae753bcf1_6a86ae7541657.webp?v=1787211381',
                'hero_image' => '/uploads/cms/hero_tkit_6a86ae75539c1_6a86ae7577583.webp?v=1787211382',
                'students_count' => 125,
                'employees_count' => 14,
                'classrooms_count' => 6,
                'target_hafalan' => 'Juz 30 (Surah Pendek)',
                'theme' => $themeTokens['tkit'] ?? [],
                'programs' => array (
  0 => 
  array (
    'title' => 'Tahfidz Juz 30 Cilik',
    'icon' => 'ud83dudcd6',
    'desc' => 'Metode hafalan Al-Qur\'an nada nasyid yang menyenangkan khusus anak usia 3-6 tahun.',
  ),
  1 => 
  array (
    'title' => 'Adab & Doa Harian',
    'icon' => 'ud83eudd32',
    'desc' => 'Pembiasaan sholat dhuha berjamaah, doa harian, dan adab islami harian.',
  ),
  2 => 
  array (
    'title' => 'Sentra Edukatif & Motorik',
    'icon' => 'ud83cudfa8',
    'desc' => 'Eksplorasi sensorik, seni lukis, balok konstruksi, dan permainan ketangkasan fisik.',
  ),
  3 => 
  array (
    'title' => 'Bilingual Basic Kids',
    'icon' => 'ud83dudde3ufe0f',
    'desc' => 'Pengenalan kosakata dasar Bahasa Arab & Inggris sehari-hari melalui kuis & lagu.',
  ),
),
                'teachers' => array (
  0 => 
  array (
    'name' => 'Ani Oktar Yansi, S. Pd I',
    'role' => 'Kepala Sekolah',
    'photo' => '/uploads/media/0a6337c9cb242ba8dfdca2fe9001e634.webp',
    'bio' => '',
  ),
  1 => 
  array (
    'name' => 'Minarti, S. Pd I',
    'role' => 'Wali Kelas TK B Madinah',
    'photo' => '/uploads/media/67583fbf32e4f099e55e00493bcbf466.webp',
    'bio' => '',
  ),
  2 => 
  array (
    'name' => 'Neliwati, S. Pd I',
    'role' => 'Wali Kelas TK B Thoif',
    'photo' => '/uploads/media/b4639f16b7f19bc9a041587438035200.webp',
    'bio' => '',
  ),
  3 => 
  array (
    'name' => 'Roudhotun Nikmah',
    'role' => 'Wali Kelas TK B Mekkah',
    'photo' => '/uploads/media/d8ee33e64d7fd13065d8fc2c9e02e409.webp',
    'bio' => '',
  ),
  4 => 
  array (
    'name' => 'Putri Nabila',
    'role' => 'Wali Kelas TK A Jeddah',
    'photo' => '/uploads/media/b0b5f4cd1d3d4fefeb336822281d7f18.webp',
    'bio' => '',
  ),
  5 => 
  array (
    'name' => 'Rizqy Maharani Bally Putri',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/6b8397e4ad6e5a31ded355f3989d7289.webp',
    'bio' => '',
  ),
  6 => 
  array (
    'name' => 'Aisyah Enjelita',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/5e9ab9e6b15d5c5ddea8771f1c953eae.webp',
    'bio' => '',
  ),
  7 => 
  array (
    'name' => 'Rojanah, S. E',
    'role' => 'Staf Tata Usaha',
    'photo' => '/uploads/media/640e548fab367863513f963a991315bc.webp',
    'bio' => '',
  ),
  8 => 
  array (
    'name' => 'Zahrotun Jannati, S. Pd',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/5e0084ad2f57ae058642690c8c1a4cd9.webp',
    'bio' => '',
  ),
  9 => 
  array (
    'name' => 'Dia Fitri Yani, S. Pd',
    'role' => 'Wali Kelas TK B Khuldi',
    'photo' => '/uploads/media/9992b8e60d9e172f8cb19d80e3186ada.webp',
    'bio' => '',
  ),
  10 => 
  array (
    'name' => 'Susanti',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/5fcc63ea95d5074983dc2cedcc16e9f7.webp',
    'bio' => '',
  ),
  11 => 
  array (
    'name' => 'Nopitri Rosah',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/ce0626c270809b61baa3716fd2bff30c.webp',
    'bio' => '',
  ),
  12 => 
  array (
    'name' => 'Yunisa',
    'role' => 'Guru Pendamping',
    'photo' => '/uploads/media/2de7f85f98084d58c9e5e39c6e22d6e2.webp',
    'bio' => '',
  ),
),
                'facilities' => array (
  0 => 
  array (
    'title' => 'AC dan Kipas Angin',
    'badge' => 'Ruang Sentra',
    'icon' => 'u2744ufe0f',
    'desc' => 'Setiap ruang kelas difasilitasi AC dan 1 Kipas Angin untuk kenyamanan putra-putri.',
    'image' => '/uploads/media/9886a6359963734aeff52fe2722f6f66.webp',
  ),
  1 => 
  array (
    'title' => 'CCTV SafeSchool',
    'badge' => 'Keamanan 24 Jam',
    'icon' => 'ud83dudcf9',
    'desc' => 'Ada 2 CCTV di Sekolah KB-TKIT Robbani (di Ruang Musholah dan teras depan).',
    'image' => '/uploads/media/547adebc4f93eab5a596657e9a3ec5e5.webp',
  ),
  2 => 
  array (
    'title' => 'Mainan Edukasi (APE)',
    'badge' => 'Alat Peraga Edukatif',
    'icon' => 'ud83eudde9',
    'desc' => 'Tersedianya Mainan Edukasi yang telah ditempatkan pada boxnya masing-masing.',
    'image' => '/uploads/media/85012e3fd9937ba6fceef60d897d6395.webp',
  ),
  3 => 
  array (
    'title' => 'Loker di Setiap Ruang Kelas',
    'badge' => 'Kemandirian Anak',
    'icon' => 'ud83cudf92',
    'desc' => 'Setiap anak mempunyai loker pribadi masing-masing di kelasnya.',
    'image' => '/uploads/media/a03171c93d1b0c041041e808e6978801.webp',
  ),
  4 => 
  array (
    'title' => 'Permainan Outdoor',
    'badge' => 'Motorik Kasar',
    'icon' => 'ud83dudedd',
    'desc' => 'Tempat Permainan Outdoor yang nyaman, bersih dan dilengkapi oleh CCTV.',
    'image' => '/uploads/media/03a061e945d5a65215c12493a62241a0.webp',
  ),
  5 => 
  array (
    'title' => 'Tempat Wudhu Anti-Slip',
    'badge' => 'Pembiasaan Ibadah',
    'icon' => 'ud83dudca7',
    'desc' => 'Tempat wudhu yang bersih dan alas lantai anti slip dan dilengkapi dengan CCTV.',
    'image' => '/uploads/media/9f198ecf2fe44380495912ce98afd903.webp',
  ),
  6 => 
  array (
    'title' => 'Teras Bersih & CCTV',
    'badge' => 'Area Bermain',
    'icon' => 'ud83cudf3f',
    'desc' => 'Teras yang bersih dan dilengkapi CCTV, tempat anak main diluar ruangan yang nyaman dan bersih.',
    'image' => '/uploads/media/c2bf2e5fe89eb1309a4a64b766c0ca47.webp',
  ),
),
                'ekskul' => array (
  0 => 
  array (
    'title' => 'Circle Time',
    'badge' => 'Pembiasaan Pagi',
    'icon' => 'u2b55',
    'desc' => 'Kegiatan berkumpul melingkar di pagi hari untuk menyapa guru, berdoa bersama, dan melatih keberanian berbicara anak.',
    'image' => '/uploads/media/357ed421243a08af1835d30e2b7483ac.webp',
  ),
  1 => 
  array (
    'title' => 'Inspirasi Pagi',
    'badge' => 'Karakter & Aqidah',
    'icon' => 'ud83cudf05',
    'desc' => 'Penyampaian cerita inspiratif islami, teladan nabi & sahabat untuk menumbuhkan cinta kebaikan sejak usia dini.',
    'image' => '/uploads/media/8540f0076698b271a82b928c95d53b5f.webp',
  ),
  2 => 
  array (
    'title' => 'Tiket Masuk Kelas',
    'badge' => 'Adab & Disiplin',
    'icon' => 'ud83cudf9fufe0f',
    'desc' => 'Pembiasaan mengucap salam, adab mencium tangan guru, dan kuis hafalan ringan sebelum memasuki ruang kelas.',
    'image' => '/uploads/media/b4d2e4c2b99cb1587d30ad397f1730a7.webp',
  ),
  3 => 
  array (
    'title' => 'Cuci Tangan Bersih',
    'badge' => 'Pola Hidup Sehat',
    'icon' => 'ud83euddfc',
    'desc' => 'Edukasi mencuci tangan 6 langkah dengan sabun sebelum dan sesudah beraktivitas.',
    'image' => '/uploads/media/a2edf0efc2f2646a8e00b067e43e9841.webp',
  ),
  4 => 
  array (
    'title' => 'Makan Bersama & Adab Makan',
    'badge' => 'Kemandirian & Adab',
    'icon' => 'ud83cudf71',
    'desc' => 'Makan bersama dengan membaca doa, menggunakan tangan kanan, dan merapikan tempat makan sendiri.',
    'image' => '/uploads/media/5528721d7989987e2692b604838a3b89.webp',
  ),
  5 => 
  array (
    'title' => 'Gosok Gigi Bersama',
    'badge' => 'Kesehatan Gigi',
    'icon' => 'ud83eudea5',
    'desc' => 'Pembiasaan merawat kesehatan gigi secara rutin bersama teman-teman yang menyenangkan.',
    'image' => '/uploads/media/eb4530fc3d7718a2ae3e567fa8af2d33.webp',
  ),
),
                'gallery' => array (
  0 => 
  array (
    'title' => 'Kegiatan Circle Time Pagi Anak TKIT',
    'image' => '/uploads/media/357ed421243a08af1835d30e2b7483ac.webp',
    'category' => 'Pembiasaan Pagi',
  ),
  1 => 
  array (
    'title' => 'Inspirasi Pagi & Dongeng Islami',
    'image' => '/uploads/media/8540f0076698b271a82b928c95d53b5f.webp',
    'category' => 'Karakter & Aqidah',
  ),
  2 => 
  array (
    'title' => 'Pembiasaan Tiket Masuk Kelas & Salam Guru',
    'image' => '/uploads/media/b4d2e4c2b99cb1587d30ad397f1730a7.webp',
    'category' => 'Adab & Disiplin',
  ),
  3 => 
  array (
    'title' => 'Praktek Cuci Tangan 6 Langkah Bersih',
    'image' => '/uploads/media/a2edf0efc2f2646a8e00b067e43e9841.webp',
    'category' => 'Pola Hidup Sehat',
  ),
  4 => 
  array (
    'title' => 'Makan Bersama & Penerapan Adab Makan',
    'image' => '/uploads/media/5528721d7989987e2692b604838a3b89.webp',
    'category' => 'Adab Makan',
  ),
  5 => 
  array (
    'title' => 'Kegiatan Gosok Gigi Bersama Teman',
    'image' => '/uploads/media/eb4530fc3d7718a2ae3e567fa8af2d33.webp',
    'category' => 'Kesehatan Anak',
  ),
  6 => 
  array (
    'title' => 'Prestasi Gebyar PAUD Indralaya Utara',
    'image' => '/uploads/media/ef14c234fecf57b1c249623c05afddb8.webp',
    'category' => 'Prestasi Siswa',
  ),
  7 => 
  array (
    'title' => 'Kunjungan Belajar Himapaudi Ogan Ilir',
    'image' => '/uploads/media/99a3811fc324653d93e3c25b6ac1f4a5.webp',
    'category' => 'Studi Edukasi',
  ),
),
                'alumni' => [
                    ['name' => 'Wali Murid TKIT Robbani', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di SIT Robbani luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Alumni Berprestasi', 'title' => 'Alumni SIT Robbani', 'text' => 'Fasilitas belajar modern dan bimbingan para asatidz sangat mendukung minat siswa di bidang sains dan tahfidz.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Bunda Siswa', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/images/avatar-gray-person.svg'],
                ],
            ],
            'sdit' => [
                'name' => 'SDIT Robbani Ogan Ilir',
                'code' => 'SDIT',
                'npsn' => '69985678',
                'akreditasi' => 'Terakreditasi B',
                'sub_badge' => 'KABUPATEN OGAN ILIR - Terakreditasi B',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Mencetak Generasi Qur\'ani, Berakhlak Mulia, & Cerdas Sains',
                'principal_name' => 'Nur Amalia, S.Pd.Gr',
                'principal_title' => 'Kepala Sekolah SDIT Robbani Ogan Ilir',
                'principal_photo' => '/uploads/media/99acbccf4209ca4a2b23e2b9a53f2b4e.webp',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di SDIT Robbani. Kami berkomitmen memberikan pendidikan dasar terbaik yang menyeimbangkan antara capaian hafalan Al-Qur\'an, akademik sains unggulan, serta kepemimpinan berakhlak mulia.',
                'description' => 'Sekolah Dasar Islam Terpadu berakreditasi B di Ogan Ilir. Memadukan Kurikulum Merdeka Nasional dengan Kekhasan JSIT (Jaringan Sekolah Islam Terpadu), Tahfidz Al-Qur\'an 3-5 Juz Mutqin, Sains Olimpic Club, Koding Digital, & Pembentukan Karakter Islam.',
                'vision' => 'Menjadi Sekolah Dasar Islam Terpadu Model dalam Mencetak Generasi Qur\'ani, Cerdas Berakhlak, dan Berprestasi Nasional.',
                'missions' => array (
  0 => 'Menyelenggarakan bimbingan Al-Qur\'an dengan target kelulusan minimal 3-5 Juz secara mutqin.',
  1 => 'Menerapkan Kurikulum Merdeka terintegrasi nilai-nilai keislaman dan pembiasaan ibadah harian.',
  2 => 'Mengembangkan minat bakat siswa dalam bidang sains, koding digital, seni, dan kepanduan.',
  3 => 'Membentuk karakter kepemimpinan islami melalui pembinaan Bina Pribadi Islam (BPI).',
),
                'history' => [
                    'title' => 'Membangun Generasi Emas SDIT Robbani Ogan Ilir',
                    'badge' => 'Jejak Langkah & Perkembangan',
                    'image' => '/uploads/cms/hero_sdit_6a84900389001_6a8490038bb82.webp?v=1787072515',
                    'paragraphs' => array (
  0 => 'SDIT Robbani Ogan Ilir didirikan di bawah naungan Yayasan Generasi Robbani Sumatera Selatan sebagai wujud komitmen memberikan pendidikan Islam terpadu berkualitas di Kabupaten Ogan Ilir.',
  1 => 'Mengembangkan kurikulum terpadu nasional dan kekhasan JSIT (Jaringan Sekolah Islam Terpadu), pembinaan tahfidz Al-Qur\'an mutqin, serta penguatan adab Islami dan kemandirian peserta didik.',
  2 => 'Didukung oleh sarana pembelajaran modern, tenaga pendidik bersertifikasi dan berdedikasi tinggi, serta lingkungan kampus yang asri dan aman, kami terus berinovasi membina generasi Qur\'ani yang siap memimpin peradaban masa depan.',
),
                ],
                'phone' => '0811747472',
                'whatsapp' => '0811747472',
                'email' => 'sdit@sitrobbani.sch.id',
                'city' => 'Indralaya, Ogan Ilir, Sumatera Selatan',
                'address' => 'Jalan Sarjana Kompleks SIT Robbani, Kelurahan Timbangan, Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan',
                'domain' => 'sitrobbani.sch.id',
                'logo' => '/images/logo_sdit.png',
                'flyer' => '/images/spmb/flyer-spmb-sit-robbani.webp',
                'campus_photo' => '/uploads/cms/herobg_sdit_6a84900376afc_6a84900379a4b.webp?v=1787072515',
                'hero_bg_image' => '/uploads/cms/herobg_sdit_6a84900376afc_6a84900379a4b.webp?v=1787072515',
                'hero_image' => '/uploads/cms/hero_sdit_6a84900389001_6a8490038bb82.webp?v=1787072515',
                'students_count' => 450,
                'employees_count' => 38,
                'classrooms_count' => 18,
                'target_hafalan' => '3 - 5 Juz Mutqin',
                'theme' => $themeTokens['sdit'] ?? [],
                'programs' => array (
  0 => 
  array (
    'title' => 'Tahfidz Al-Qur\'an 3-5 Juz Mutqin',
    'icon' => 'ud83dudcd6',
    'desc' => 'Bimbingan tasmi\', murojaah harian, dan wisuda tahfidz tahunan bersama hafidz tersertifikasi.',
  ),
  1 => 
  array (
    'title' => 'Bina Pribadi Islam (BPI) & Adab Karimah',
    'icon' => 'ud83cudf1f',
    'desc' => 'Mentoring kelompok kecil untuk penanaman aqidah lurus, pembiasaan ibadah harian, dan kepemimpinan.',
  ),
  2 => 
  array (
    'title' => 'Koding Cilik & Science Club',
    'icon' => 'ud83dudcbb',
    'desc' => 'Pembelajaran logika pemograman dasar, Koding sederhana, dan laboratorium eksperimen sains.',
  ),
  3 => 
  array (
    'title' => 'Pramuka SIT & Archery (Panahan)',
    'icon' => 'ud83cudff9',
    'desc' => 'Kegiatan kepanduan khas JSIT, panahan sunnah, ketangkasan fisik outdoor, dan ekskul renang.',
  ),
),
                'teachers' => array (
  0 => 
  array (
    'name' => 'Sholahuddin Gultom',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/b287c1f165cafe88c54bd2ec9bc6c0cd.webp',
    'bio' => '',
  ),
  1 => 
  array (
    'name' => 'Rini Nur Aisah, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/62500a42dce9094e4f0a7accd68910ef.webp',
    'bio' => '',
  ),
  2 => 
  array (
    'name' => 'Erina, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/cb2206e48bb0edc5b5e0a40384358aaf.webp',
    'bio' => '',
  ),
  3 => 
  array (
    'name' => 'Nur Amalia, S.Pd',
    'role' => 'Kepala Sekolah',
    'photo' => '/uploads/media/99acbccf4209ca4a2b23e2b9a53f2b4e.webp',
    'bio' => '',
  ),
  4 => 
  array (
    'name' => 'Verda Novita Sari, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/ad452dad9895890a6e5fd20c0e57e891.webp',
    'bio' => '',
  ),
  5 => 
  array (
    'name' => 'Ranti Saputri, S.TP',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/5199b18b81aa79a2d1ac2938b3b74474.webp',
    'bio' => '',
  ),
  6 => 
  array (
    'name' => 'Veti Susanti, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/59757bcc8773617abf01370f063693e3.webp',
    'bio' => '',
  ),
  7 => 
  array (
    'name' => 'Marisa, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/130e5322d5638b046f0f39dedefb5135.webp',
    'bio' => '',
  ),
  8 => 
  array (
    'name' => 'Atainah Ul Hukma, S.Si',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/1710e9009670596fd55d27b0961c70c6.webp',
    'bio' => '',
  ),
  9 => 
  array (
    'name' => 'Anisa, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/c33d9a961dcc730923dc3e1eebbec213.webp',
    'bio' => '',
  ),
  10 => 
  array (
    'name' => 'Apriliah, S.Ag',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/d59d918ba4d4d55513a9f54a5a4fbdb6.webp',
    'bio' => '',
  ),
  11 => 
  array (
    'name' => 'Reni Zahara, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/bab4d1d86b5a4afa525351df078a4a3b.webp',
    'bio' => '',
  ),
  12 => 
  array (
    'name' => 'Annisa Fatihah Salsabila, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/44fd8f4a0d30b1f84d527b20e1a3e13a.webp',
    'bio' => '',
  ),
  13 => 
  array (
    'name' => 'Risma Nia, S.Sos',
    'role' => 'Staff TU',
    'photo' => '/uploads/media/5f30d015dae97bb98eb2a9664070adc0.webp',
    'bio' => '',
  ),
  14 => 
  array (
    'name' => 'Ahmad Firdaus',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/265113a5da019241f34d1abdb76aabeb.webp',
    'bio' => '',
  ),
  15 => 
  array (
    'name' => 'Risfina Ayu Rochmayani, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/3791bc4cc53993b30d9c10d3965670b6.webp',
    'bio' => '',
  ),
  16 => 
  array (
    'name' => 'Dian Kemala Astuti, S.Pd',
    'role' => 'Wakil Kepala Sekolah',
    'photo' => '/uploads/media/e347e53e9e6fc8fd8db36c149ecbd214.webp',
    'bio' => '',
  ),
  17 => 
  array (
    'name' => 'Yara Dwinadia, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/3fc4a612f506c4cc398fa20ade537ce0.webp',
    'bio' => '',
  ),
  18 => 
  array (
    'name' => 'Dwi Misgiyati, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/e732e7cf3f89cfd4489b7df194399437.webp',
    'bio' => '',
  ),
  19 => 
  array (
    'name' => 'Dita Irfaul Khasanah, S.Si',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/57bffe6b9aee48a59b5c4a627a8e0199.webp',
    'bio' => '',
  ),
  20 => 
  array (
    'name' => 'Rika Damayanti, S.Pd',
    'role' => 'Guru Kelas',
    'photo' => '/uploads/media/7a98d317fbd63a71b4187e8ff63b1ca2.webp',
    'bio' => '',
  ),
  21 => 
  array (
    'name' => 'Sarah Salsabilah, S.Pd',
    'role' => 'Guru TTQ',
    'photo' => '/uploads/media/f536c3f56567554b4572ef5b850803ce.webp',
    'bio' => '',
  ),
  22 => 
  array (
    'name' => 'Fredy Kurniawan',
    'role' => 'Security',
    'photo' => '/uploads/media/977beb19c66dcc0f881e751e5ffd444a.webp',
    'bio' => '',
  ),
  23 => 
  array (
    'name' => 'Desnawan Linggarjati S.',
    'role' => 'Office Boy',
    'photo' => '/uploads/media/760bb8a1e8f449dfe4cbb1c23ad1e641.webp',
    'bio' => '',
  ),
),
                'facilities' => array (
  0 => 
  array (
    'title' => 'Kolam Renang Sekolah',
    'badge' => 'Fasilitas Unggulan SDIT',
    'icon' => 'ud83cudfcau200du2642ufe0f',
    'desc' => 'SD Islam Terpadu Robbani memiliki kolam renang sendiri di area sekolah untuk kegiatan ekskul dan olahraga air siswa.',
    'image' => '/images/facilities/kolam_renang_sdit.jpg',
  ),
  1 => 
  array (
    'title' => 'Ruang Kelas Nyaman Ber-AC',
    'badge' => 'Ruang Belajar',
    'icon' => 'u2744ufe0f',
    'desc' => 'Ruang kelas SDIT Robbani didesain senyaman mungkin lengkap dengan AC, Kipas Angin, Loker, dan Pojok Baca.',
    'image' => '/images/facilities/ruang_kelas_sdit.jpg',
  ),
  2 => 
  array (
    'title' => 'Mushola Saung Unik',
    'badge' => 'Sarana Ibadah',
    'icon' => 'ud83dudd4c',
    'desc' => 'Sarana ibadah khas berupa saung terbuka unik untuk tempat sholat berjamaah dan halaqoh BPI.',
    'image' => '/images/facilities/mushola_sdit.jpg',
  ),
  3 => 
  array (
    'title' => 'Aula Pertemuan Sekolah',
    'badge' => 'Gedung Pertemuan',
    'icon' => 'ud83cudfdbufe0f',
    'desc' => 'Aula serbaguna indoor untuk pertemuan orang tua, pentas seni siswa, dan event sekolah.',
    'image' => '/images/facilities/aula_sdit.jpg',
  ),
  4 => 
  array (
    'title' => 'Lapangan Olahraga Outdoor',
    'badge' => 'Area Ketangkasan',
    'icon' => 'u26bd',
    'desc' => 'Lapangan olahraga terbuka untuk aktivitas futsal, senam, panahan, dan kegiatan fisik outdoor siswa SDIT.',
    'image' => '/images/facilities/lapangan_sdit.jpg',
  ),
),
                'ekskul' => array (
  0 => 
  array (
    'title' => 'Ekskul Futsal SDIT',
    'badge' => 'Olahraga Tim',
    'icon' => 'u26bd',
    'desc' => 'Pengembangan bakat olahraga futsal, kekompakan tim, dan ketangkasan fisik siswa SDIT.',
    'image' => '/images/ekskul/sd_futsal.webp',
  ),
  1 => 
  array (
    'title' => 'Ekskul Memanah (Archery)',
    'badge' => 'Olahraga Sunnah',
    'icon' => 'ud83cudff9',
    'desc' => 'Melatih fokus, konsentrasi, ketenangan emosi, dan kedisiplinan diri sejak dini.',
    'image' => '/images/ekskul/sd_panahan.webp',
  ),
  2 => 
  array (
    'title' => 'Ekskul Coding Digital Cilik',
    'badge' => 'Teknologi & IT',
    'icon' => 'ud83dudcbb',
    'desc' => 'Pembelajaran logika pemograman dasar dan pemikiran komputasi untuk siswa SDIT.',
    'image' => '/images/ekskul/sd_coding.webp',
  ),
  3 => 
  array (
    'title' => 'Ekskul Seni Tari Tradisional',
    'badge' => 'Seni Budaya',
    'icon' => 'ud83dudc83',
    'desc' => 'Pelatihan seni tari kreasi islami dan apresiasi budaya nusantara.',
    'image' => '/images/ekskul/sd_seni.webp',
  ),
  4 => 
  array (
    'title' => 'Life Skill Bulu Tangkis',
    'badge' => 'Olahraga Kebugaran',
    'icon' => 'ud83cudff8',
    'desc' => 'Latihan ketangkasan refleksi, kelincahan, dan kebugaran jasmani siswa.',
    'image' => '/images/ekskul/bulu_tangkis.webp',
  ),
  5 => 
  array (
    'title' => 'Life Skill Tahfidz Intensive',
    'badge' => 'Al-Qur\'an',
    'icon' => 'ud83dudcd6',
    'desc' => 'Halaqoh pendalaman hafalan Al-Qur\'an dengan bimbingan metode talaqqi.',
    'image' => '/images/ekskul/tahfidz.webp',
  ),
),
                'gallery' => array (
),
                'alumni' => [
                    ['name' => 'Wali Murid SDIT Robbani', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di SIT Robbani luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Alumni Berprestasi', 'title' => 'Alumni SIT Robbani', 'text' => 'Fasilitas belajar modern dan bimbingan para asatidz sangat mendukung minat siswa di bidang sains dan tahfidz.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Bunda Siswa', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/images/avatar-gray-person.svg'],
                ],
            ],
            'smpit' => [
                'name' => 'SMP ISLAM TERPADU ROBBANI',
                'code' => 'SMPIT',
                'npsn' => '70031580',
                'akreditasi' => 'Terakreditasi B',
                'sub_badge' => 'KABUPATEN OGAN ILIR - Terakreditasi B',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Because Every Child is Unique (Berbasis Digital & Pendidikan Karakter)',
                'principal_name' => 'Tia Wulandari, S.Pd., Gr.',
                'principal_title' => 'Kepala SMPIT Robbani Ogan Ilir',
                'principal_photo' => '/uploads/media/094bd24f5cbf61735c098a3e594dd544.webp',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi SMP IT Robbani Ogan Ilir. Kami memadukan kecerdasan digital, pembinaan akhlak mulia, tahfidz Al-Qur\'an, dan pembelajaran berpusat pada keunikan setiap siswa (Because Every Child is Unique) untuk melahirkan generasi robbani yang beriman, bertaqwa, unggul dalam IPTEK, serta berwawasan global.',
                'description' => 'SMP IT Robbani adalah sekolah menengah pertama Islam terpadu unggulan di Ogan Ilir yang memadukan kecerdasan digital (SIPAKAR V2), kemuliaan akhlak, tahfidz Al-Qur\'an, dan pendidikan karakter islami (Fullday School). Alamat: Jln. Sarjana Padang Guci, Kelurahan Timbangan, Kecamatan Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan.',
                'vision' => 'Terwujudnya Generasi Robbani yang Beriman, Mandiri, Kreatif, Adaptif, dan Bernalar Kritis dalam penguasaan ilmu pengetahuan dan teknologi.',
                'missions' => array (
  0 => 'Memperkuat iman, takwa, dan karakter religius peserta didik melalui pembiasaan ibadah dan Pendidikan karakter.',
  1 => 'Mengembangkan kemandirian, kreativitas, dan nalar kritis peserta didik melalui pembelajaran bermakna dan berbasis proyek.',
  2 => 'Mengintegrasikan teknologi digital dalam pembelajaran dan penilaian untuk meningkatkan literasi serta keterampilan berpikir kritis dan kreatif.',
  3 => 'Membangun kolaborasi yang sinergis antara sekolah, orang tua, dan masyarakat dalam mendukung pengembangan potensi dan karakter peserta didik.',
),
                'history' => [
                    'title' => 'Membangun Generasi Emas SMPIT Robbani Ogan Ilir',
                    'badge' => 'Jejak Langkah & Perkembangan',
                    'image' => '/uploads/cms/hero_smpit_6a848f38bf580_6a848f38c1bc5.webp?v=1787072312',
                    'paragraphs' => array (
  0 => 'SMP ISLAM TERPADU ROBBANI didirikan di bawah naungan Yayasan Generasi Robbani Sumatera Selatan sebagai wujud komitmen memberikan pendidikan Islam terpadu berkualitas di Kabupaten Ogan Ilir.',
  1 => 'Mengembangkan kurikulum terpadu nasional dan kekhasan JSIT (Jaringan Sekolah Islam Terpadu), pembinaan tahfidz Al-Qur\'an mutqin, serta penguatan adab Islami dan kemandirian peserta didik.',
  2 => 'Didukung oleh sarana pembelajaran modern, tenaga pendidik bersertifikasi dan berdedikasi tinggi, serta lingkungan kampus yang asri dan aman, kami terus berinovasi membina generasi Qur\'ani yang siap memimpin peradaban masa depan.',
),
                ],
                'phone' => '085377193977',
                'whatsapp' => '085377193977',
                'email' => 'smpit@sitrobbani.sch.id',
                'city' => 'Indralaya, Ogan Ilir, Sumatera Selatan',
                'address' => 'Jln. Sarjana Padang Guci, Kelurahan Timbangan, Kecamatan Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan',
                'domain' => 'sitrobbani.sch.id',
                'logo' => '/images/logo_smpit.png',
                'flyer' => '/images/spmb/flyer-spmb-sit-robbani.webp',
                'campus_photo' => '/uploads/media/smpit_post_IMG20241017130510-scaled_9f90cc01.jpg',
                'hero_bg_image' => '/uploads/media/smpit_post_20251119_082653-scaled_ca9746db.jpg',
                'hero_image' => '/uploads/media/smpit_post_IMG-20260713-WA0032-scaled_b6afa939.jpg',
                'principal_name' => 'Tia Wulandari, S.Pd., Gr.',
                'principal_title' => 'Kepala SMPIT Robbani Ogan Ilir',
                'principal_photo' => '/uploads/media/094bd24f5cbf61735c098a3e594dd544.webp',
                'students_count' => 58,
                'employees_count' => 12,
                'classrooms_count' => 3,
                'target_hafalan' => '3-5 Juz',
                'theme' => $themeTokens['smpit'] ?? [],
                'programs' => array (
  0 => 
  array (
    'title' => 'SIPAKAR V2 Digital Learning',
    'icon' => '💻',
    'desc' => 'Pembelajaran digital terintegrasi sistem presensi RFID, modul CBT online, dan rekam jejak mutabaah yaumiyah siswa.',
  ),
  1 => 
  array (
    'title' => 'Program Unggulan Tahsin Tahfidz Qur\'an (5-10 Juz)',
    'icon' => '📖',
    'desc' => 'Pembinaan intensif membaca (Tahsin) & menghafal (Tahfidz) 5-10 Juz Al-Qur\'an dengan metode talaqqi dan murojaah berkala.',
  ),
  2 => 
  array (
    'title' => 'Program Unggulan Bina Pribadi Islam (BPI)',
    'icon' => '🌟',
    'desc' => 'Pembinaan karakter komprehensif (Fullday School) melalui mentoring kelompok kecil, sholat dhuha & dhuhur berjamaah, serta adab harian.',
  ),
  3 => 
  array (
    'title' => 'Bilingual & Public Speaking Club',
    'icon' => '🌍',
    'desc' => 'Pembiasaan percakapan harian Bahasa Arab & Inggris serta pelatihan kepemimpinan dan public speaking siswa.',
  ),
),
                'teachers' => array (
  0 => 
  array (
    'name' => 'Tia Wulandari, S.Pd., Gr.',
    'role' => 'Kepala SMPIT Robbani',
    'photo' => '/uploads/media/094bd24f5cbf61735c098a3e594dd544.webp',
    'bio' => 'Kepala Sekolah SMPIT Robbani berdedikasi memimpin pendidikan Islam terpadu berkualitas.',
  ),
  1 => 
  array (
    'name' => 'Atika Junie Astuti, S.P',
    'role' => 'Guru IPA, TTQ, & BPI',
    'photo' => '/uploads/media/b2c738bc73172000c348fe9732dbecf6.webp',
    'bio' => 'Guru mata pelajaran IPA, TTQ dan Pembina Karakter BPI siswa SMPIT Robbani.',
  ),
  2 => 
  array (
    'name' => 'Sulis Setya Ningsih, S.Pd',
    'role' => 'Guru IPS & Seni Teater',
    'photo' => '/uploads/media/d3e51bd52edb07d8614fe2565072e0c5.webp',
    'bio' => 'Guru mata pelajaran IPS dan pembimbing apresiasi seni teater siswa.',
  ),
  3 => 
  array (
    'name' => 'Anita Septia, S.Pd',
    'role' => 'Guru Bahasa Indonesia',
    'photo' => '/uploads/media/1a306591b4f11e6554f591c37690d5b8.webp',
    'bio' => 'Guru Bahasa Indonesia berdedikasi membina literasi dan kecakapan berbahasa.',
  ),
  4 => 
  array (
    'name' => 'Nurbaiti Mafaza, Lc',
    'role' => 'Guru Bahasa Arab & TTQ',
    'photo' => '/uploads/media/8a9b894e3694bf33b6f404e78dbe0aa4.webp',
    'bio' => 'Lulusan Al-Azhar Kairo, mengampu Bahasa Arab dan bimbingan TTQ mutqin.',
  ),
  5 => 
  array (
    'name' => 'Ega Maharani, S.Si., Gr.',
    'role' => 'Guru Matematika & TIK',
    'photo' => '/uploads/media/594dd0069de306c30552420e1b926084.webp',
    'bio' => 'Guru Matematika dan TIK membina logika sains dan keterampilan digital.',
  ),
  6 => 
  array (
    'name' => 'Syaifudin, S.Sn., Gr.',
    'role' => 'Guru PJOK & Seni Rupa',
    'photo' => '/uploads/media/83f5cdfe22b97802cb88ecddf4a22486.webp',
    'bio' => 'Lulusan ISI Yogyakarta, mengajar PJOK dan seni rupa kriya siswa.',
  ),
  7 => 
  array (
    'name' => 'Nini Anggraini, S.Pd',
    'role' => 'Guru Hadist, PAI & TTQ',
    'photo' => '/uploads/media/54a2d99ab10745e07564015cfc1228ee.webp',
    'bio' => 'Pembina mata pelajaran Hadist, PAI, serta pembiasaan hafalan Qur\'an.',
  ),
  8 => 
  array (
    'name' => 'Rifda Saugina, S.Pd',
    'role' => 'Guru Bahasa Inggris',
    'photo' => '/uploads/media/1ab1778a6021f1ce288cf0e3b8031046.webp',
    'bio' => 'Guru Bahasa Inggris dan pembina English Club SMPIT Robbani.',
  ),
  9 => 
  array (
    'name' => 'Nurul Hamida Yanti, S.E.',
    'role' => 'Guru PAI, Hadist & TTQ',
    'photo' => '/uploads/media/b839d8b384fd3d66b6c08bdb59e54839.webp',
    'bio' => 'Guru mata pelajaran PAI, Hadits dan Tahsin Tahfidz Al-Qur\'an.',
  ),
  10 => 
  array (
    'name' => 'Adelia Jesika, S.Pd',
    'role' => 'Staff Tata Usaha',
    'photo' => '/uploads/media/105be986293de8c41c1e9c49bd4c40ce.webp',
    'bio' => 'Staff Tata Usaha dan pelayanan administrasi akademik SMPIT Robbani.',
  ),
  11 => 
  array (
    'name' => 'Muhammad Yusuf, S.Sos',
    'role' => 'Staff Keuangan & Karakter',
    'photo' => '/uploads/media/3c2fedb6aea0123567c6132ad53e8814.webp',
    'bio' => 'Staff Keuangan dan pembina ketertiban serta karakter islami siswa.',
  ),
),
                'facilities' => array (
  0 => 
  array (
    'title' => 'Gedung Sekolah Representatif',
    'badge' => 'Gedung Utama',
    'icon' => 'ud83cudfe2',
    'desc' => 'Gedung sekolah SMPIT Robbani yang bersih, kokoh, representatif, serta dilengkapi sistem pengamanan dan lingkungan asri.',
    'image' => '/images/facilities/gedung_smpit.jpg',
  ),
  1 => 
  array (
    'title' => 'Ruang Kelas Digital Ber-AC',
    'badge' => 'Ruang Kelas',
    'icon' => 'ud83dudcbb',
    'desc' => 'SMP IT Robbani memiliki ruang kelas yang nyaman. Setiap ruang kelas di SMP IT Robbani sudah memiliki fasilitas AC, Kipas Angin, Loker dan Pojok Baca untuk menunjang pembelajaran dan kenyamanan pada saat proses pembelajaran siswa.',
    'image' => '/images/facilities/ruang_kelas_smpit.jpg',
  ),
  2 => 
  array (
    'title' => 'Toilet Bersih & Higienis',
    'badge' => 'Sanitasi',
    'icon' => 'ud83dudebe',
    'desc' => 'SMP IT Robbani memiliki toilet bersih dan nyaman yang dilengkapi dengan wastafel, Toilet duduk dan jongkok bagi siswa.',
    'image' => '/images/facilities/toilet_smpit.jpg',
  ),
  3 => 
  array (
    'title' => 'Tablet Digital Siswa',
    'badge' => 'Teknologi Pembelajaran',
    'icon' => 'ud83dudcf1',
    'desc' => 'Siswa SMP IT Robbani mendapatkan fasilitas Tablet bagi siswanya untuk menunjang proses pembelajaran digital anak.',
    'image' => '/images/facilities/tablet_smpit.jpg',
  ),
  4 => 
  array (
    'title' => 'Kantin Sehat Sekolah',
    'badge' => 'Nutrisi Siswa',
    'icon' => 'ud83cudf71',
    'desc' => 'Kantin sehat dan bersih menunjang gizi serta kebutuhan konsumsi harian siswa SMPIT Robbani.',
    'image' => '/images/facilities/kantin_smpit.jpg',
  ),
  5 => 
  array (
    'title' => 'Lapangan Olahraga Sekolah',
    'badge' => 'Area Olahraga',
    'icon' => 'ud83cudfc0',
    'desc' => 'Lapangan olahraga terbuka untuk aktivitas futsal, basket, memanah, volly, dan kegiatan fisik siswa SMPIT.',
    'image' => '/images/facilities/lapangan_smpit.jpg',
  ),
),
                'ekskul' => array (
  0 => 
  array (
    'title' => 'Futsal SMPIT Robbani',
    'badge' => 'Olahraga Tim',
    'icon' => 'u26bd',
    'desc' => 'Wadah bagi siswa SMPIT Robbani mengembangkan bakat olahraga futsal, ketangkasan fisik, dan kerja sama tim.',
    'image' => '/images/ekskul/futsal.webp',
  ),
  1 => 
  array (
    'title' => 'Panahan Sunnah (Archery)',
    'badge' => 'Olahraga Sunnah',
    'icon' => 'ud83cudff9',
    'desc' => 'Melatih fokus, ketenangan emosi, ketepatan sasaran, dan kedisiplinan siswa.',
    'image' => '/images/ekskul/panahan.webp',
  ),
  2 => 
  array (
    'title' => 'Coding & Keterampilan Digital',
    'badge' => 'Teknologi & IT',
    'icon' => 'ud83dudcbb',
    'desc' => 'Wadah siswa menguasai logika pemograman dasar, pembuatan website, dan teknologi masa depan.',
    'image' => '/images/ekskul/coding.webp',
  ),
  3 => 
  array (
    'title' => 'Seni Tari Kreasi Islami',
    'badge' => 'Seni Budaya',
    'icon' => 'ud83dudc83',
    'desc' => 'Mengembangkan minat bakat siswa dibidang seni tari kreasi bernuansa islami dan seni nusantara.',
    'image' => '/images/ekskul/seni_tari.webp',
  ),
  4 => 
  array (
    'title' => 'Public Speaking & Leadership',
    'badge' => 'Komunikasi & Bahasa',
    'icon' => 'ud83cudf99ufe0f',
    'desc' => 'Menggali dan mengembangkan potensi kepemimpinan serta orator publik dalam berbagai forum siswa.',
    'image' => '/images/ekskul/public_speaking.webp',
  ),
  5 => 
  array (
    'title' => 'English Club SMPIT',
    'badge' => 'Bahasa Asing',
    'icon' => 'ud83cudf0d',
    'desc' => 'Lingkungan belajar Bahasa Inggris yang interaktif, komunikatif, dan menyenangkan.',
    'image' => '/images/ekskul/english_club.webp',
  ),
  6 => 
  array (
    'title' => 'Pramuka SIT Robbani',
    'badge' => 'Kepanduan Wajib',
    'icon' => 'ud83cudfd5ufe0f',
    'desc' => 'Kegiatan kepanduan khas JSIT untuk melatih kemandirian, kepemimpinan, dan kecintaan alam.',
    'image' => '/images/ekskul/pramuka.webp',
  ),
  7 => 
  array (
    'title' => 'Digital Art & Graphic Design',
    'badge' => 'Desain & Media',
    'icon' => 'ud83cudfa8',
    'desc' => 'Melatih kreativitas siswa dalam bidang desain grafis, ilustrasi digital, dan media publikasi.',
    'image' => '/images/ekskul/digital_art.webp',
  ),
),
                'gallery' => array (
),
                'alumni' => [
                    ['name' => 'Wali Murid SMPIT Robbani', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di SIT Robbani luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Alumni Berprestasi', 'title' => 'Alumni SIT Robbani', 'text' => 'Fasilitas belajar modern dan bimbingan para asatidz sangat mendukung minat siswa di bidang sains dan tahfidz.', 'avatar' => '/images/avatar-gray-person.svg'],
                    ['name' => 'Bunda Siswa', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/images/avatar-gray-person.svg'],
                ],
            ],
            'smait' => [
                'name' => 'SMA IT Robbani',
                'code' => 'SMAIT',
                'npsn' => '69989912',
                'akreditasi' => 'Terakreditasi B',
                'sub_badge' => 'KABUPATEN OGAN ILIR - Tahap Persiapan Operasional',
                'kurikulum' => 'Merdeka & Kekhasan JSIT',
                'tagline' => 'Sekolah Menengah Atas Islam Terpadu - Segera Dibuka',
                'principal_name' => 'Tahap Persiapan Operasional',
                'principal_title' => 'Kepala Sekolah',
                'principal_photo' => '/images/logo-robbani-official.png',
                'principal_greeting' => 'Pendidikan tingkat SMA IT Robbani saat ini sedang dalam tahap persiapan sarana prasarana dan perizinan operasional resmi. Insya Allah segera hadir untuk melahirkan generasi pemimpin bangsa yang Qur\'ani dan berwawasan teknologi global.',
                'description' => 'SMA IT Robbani saat ini dalam tahap persiapan pembukaan dan perizinan operasional resmi. Program pendidikan dirancang untuk mempersiapkan siswa menuju perguruan tinggi unggulan dan penguasaan ilmu syar\'i serta sains teknologi modern.',
                'vision' => 'Menjadi Lembaga Pendidikan Menengah Atas Islam Terkemuka yang Mencetak Cendekia Qur\'ani, Unggul dalam Riset Sains & Teknologi, serta Berkarakter Pemimpin Global.',
                'missions' => [
                    'Menghantarkan siswa menguasai hafalan Al-Qur\'an mutqin serta memahami dasar-dasar ilmu syariah.',
                    'Mempersiapkan siswa secara intensif menembus PTN favorit dalam negeri dan beasiswa perguruan tinggi luar negeri.',
                    'Membekali siswa keterampilan riset ilmiah, computational thinking, dan kecerdasan buatan.',
                    'Membina kedewasaan, kemandirian, dan ukhuwah islamiyah melalui kehidupan kampus yang terstruktur dan bermartabat.',
                ],
                'history' => [
                    'title' => 'Tahap Persiapan SMA IT Robbani Ogan Ilir',
                    'badge' => 'Jejak Langkah & Perkembangan',
                    'image' => '/images/logo-robbani-official.png',
                    'paragraphs' => [
                        'Pendidikan tingkat SMA IT Robbani didirikan di bawah naungan Yayasan Generasi Robbani Sumatera Selatan sebagai wujud komitmen memberikan kesinambungan pendidikan Islam terpadu lanjutan di Kabupaten Ogan Ilir.',
                        'Saat ini institusi sedang merampungkan pemenuhan sarana laboratorium modern, asrama, dan perizinan dinas terkait.',
                        'Insya Allah SMA IT Robbani akan segera membuka penerimaan peserta didik baru begitu seluruh proses legalitas dan sarana siap.',
                    ],
                ],
                'phone' => '0811747472',
                'whatsapp' => '0811747472',
                'email' => 'smait@sitrobbani.sch.id',
                'city' => 'Indralaya, Ogan Ilir, Sumatera Selatan',
                'address' => 'Jalan Sarjana Kompleks SIT Robbani, Kelurahan Timbangan, Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan',
                'domain' => 'sitrobbani.sch.id',
                'logo' => '/images/logo_smait.png',
                'flyer' => '/images/spmb/flyer-spmb-sit-robbani.webp',
                'campus_photo' => '/images/logo-robbani-official.png',
                'hero_bg_image' => '',
                'hero_image' => '',
                'students_count' => 0,
                'employees_count' => 0,
                'classrooms_count' => 0,
                'target_hafalan' => '10 - 30 Juz',
                'theme' => $themeTokens['smait'] ?? [],
                'programs' => [],
                'teachers' => [],
                'facilities' => [],
                'ekskul' => [],
                'prestasi' => [],
                'gallery' => [],
                'videos' => [],
                'agenda' => [],
                'announcements' => [],
                'alumni' => [],
                'status' => 'BELUM_DIBUKA',
            ],
        ];
    }

}
