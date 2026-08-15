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
            'hero_title' => SiteSetting::get('hero_title', 'Taman Pendidikan & Sekolah Islam Terpadu Robbani'),
            'hero_desc' => SiteSetting::get('hero_desc', 'Mencetak Generasi Qur\'ani, Berakhlak Mulia, Cerdas, dan Berprestasi Nasional di Kabupaten Ogan Ilir, Sumatera Selatan.'),
            'hero_bg_image' => SiteSetting::get('hero_bg_image', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1600'),
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
                'avatar' => '/images/mockup_mobile_1.png'
            ],
            [
                'name' => 'RENNI SUSANTI, A.Md. Kep.',
                'title' => 'Perawat RSUD Ogan Ilir',
                'text' => 'Sekolah Robbani merupakan sekolah pilihan terbaik saat ini. Pembelajarannya sangat bagus, gurunya muda dan berkompeten, serta fondasi agamanya sangat kuat. Hubungan silaturahmi antara guru, siswa, dan ortu sangat erat.',
                'avatar' => '/images/mockup_mobile_2.png'
            ],
            [
                'name' => 'Bunda Mazaya',
                'title' => 'Wali Murid Alumni SDIT Robbani',
                'text' => 'Alhamdulillah selama anak saya Mazaya bersekolah di sini, banyak ilmu yang didapat terutama pengetahuan Agama, hafalan Al-Qur\'an bertambah, dan sering ikut perlombaan sehingga bertambah percaya dirinya.',
                'avatar' => '/images/mockup_mobile_3.png'
            ],
            [
                'name' => 'Calvin',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolah di Robbani enak, punya banyak teman, sekolahnya nyaman, fasilitasnya bagus, gurunya baik dan ramah, ada satpam yang stay terus jadi sekolahnya aman.',
                'avatar' => '/images/mockup_mobile_4.png'
            ],
            [
                'name' => 'Faiz',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolahnya menyenangkan, gurunya ramah, ruang kelas ber-AC jadi sangat nyaman saat belajar.',
                'avatar' => '/images/mockup_mobile_5.png'
            ],
            [
                'name' => 'Anaya Tahta',
                'title' => 'Alumni SIT Robbani TA 2020/2021',
                'text' => 'Selama sekolah di ROBBANI saya mendapatkan banyak ilmu bermanfaat, dapat menyelesaikan hafalan beberapa juz, serta diajarkan disiplin dan bertanggung jawab. Terimakasih ustadz dan bunda atas bimbingannya.',
                'avatar' => '/images/logo-robbani-official.png'
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
                'desc' => 'Kelompok Bermain & TK Islam Terpadu berakreditasi unggul.'
            ],
            'sdit' => [
                'name' => 'SDIT Robbani',
                'principal_name' => 'Ustdz. M. Ridwan, S.Pd',
                'principal_title' => 'Kepala SDIT Robbani',
                'principal_photo' => '/images/mockup_mobile_2.png',
                'desc' => 'Sekolah Dasar Islam Terpadu berakreditasi A & Tahfidz.'
            ],
            'smpit' => [
                'name' => 'SMPIT Robbani',
                'principal_name' => 'Ustdz. Tia Wulandari, S.Pd',
                'principal_title' => 'Kepala SMPIT Robbani',
                'principal_photo' => '/images/hero_3d_illustration_1786347707126.png',
                'desc' => 'Sekolah Menengah Pertama berasrama (boarding) / fullday.'
            ],
            'smait' => [
                'name' => 'SMAIT Robbani',
                'principal_name' => 'Ustdz. Ahmad Subagja, M.Si',
                'principal_title' => 'Kepala SMAIT Robbani',
                'principal_photo' => '/images/mockup_mobile_4.png',
                'desc' => 'Sekolah Menengah Atas dengan program unggulan sains & IT.'
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
            'unitProfiles'
        ));
    }

    public function profil()
    {
        $settings = $this->getSettings();
        $schools = School::where('is_active', true)->get();
        return view('school.profil', compact('settings', 'schools'));
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
                'npsn' => '69981234',
                'akreditasi' => 'Terakreditasi Unggul (A)',
                'tagline' => 'Tumbuh Ceria, Berakhlak Mulia, & Hafiz Juz 30 Cilik',
                'principal_name' => 'Bunda Hj. Nurhayati, S.Pd.AUD',
                'principal_title' => 'Kepala Sekolah KB/TKIT Robbani Ogan Ilir',
                'principal_photo' => '/images/logo-robbani-official.png',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Periode emas anak usia dini adalah masa terpenting pembentukan karakter dan kecintaan pada Al-Qur\'an. Kami menghadirkan suasana belajar yang gembira, bernilai islami, dan mengedukasi motorik anak secara optimal.',
                'description' => 'Kelompok Bermain dan Taman Kanak-Kanak Islam Terpadu unggulan di Ogan Ilir. Fokus pada pembentukan adab islami, pembiasaan hafalan Al-Qur\'an Juz 30 sejak dini melalui metode fun-learning, pengembangan motorik ceria, serta literasi sosial dalam lingkungan islami yang hangat dan aman.',
                'vision' => 'Menjadi Lembaga Pendidikan Anak Usia Dini Islam Terpadu Rujukan dalam Pembentukan Adab, Karakter Qur\'ani, dan Keceriaan Belajar.',
                'missions' => [
                    'Menanamkan aqidah islami dan kecintaan pada Al-Qur\'an sejak usia dini.',
                    'Membiasakan adab islami harian, doa-doa sunnah, dan gerakan sholat secara mandiri.',
                    'Mengembangkan potensi motorik, sensorik, dan kreativitas anak melalui pembelajaran berbasis sentra.',
                    'Membangun sinergi kemitraan yang hangat dan komunikatif antara sekolah dan orang tua.'
                ],
                'phone' => '0811747472',
                'students_count' => 120,
                'employees_count' => 15,
                'classrooms_count' => 6,
                'target_hafalan' => 'Juz 30 (Surah Pendek)',
                'programs' => [
                    ['title' => 'Tahfidz Juz 30 Cilik', 'icon' => '📖', 'desc' => 'Metode hafalan Al-Qur\'an nada nasyid yang menyenangkan khusus anak usia 3-6 tahun.'],
                    ['title' => 'Adab & Doa Harian', 'icon' => '🤲', 'desc' => 'Pembiasaan sholat dhuha berjamaah, doa harian, dan adab islami harian.'],
                    ['title' => 'Sentra Edukatif & Motorik', 'icon' => '🎨', 'desc' => 'Eksplorasi sensorik, seni lukis, balok konstruksi, dan permainan ketangkasan fisik.'],
                    ['title' => 'Billingual Basic Kids', 'icon' => '🗣️', 'desc' => 'Pengenalan kosakata dasar Bahasa Arab & Inggris sehari-hari melalui kuis & lagu.']
                ],
                'teachers' => [
                    ['name' => 'Bunda Hj. Nurhayati, S.Pd.AUD', 'role' => 'Kepala Sekolah TKIT', 'photo' => '/images/mockup_mobile_1.png'],
                    ['name' => 'Bunda Siti Aminah, S.Pd', 'role' => 'Guru Wali Kelas TK-B1', 'photo' => '/images/mockup_mobile_2.png'],
                    ['name' => 'Bunda Rina Marlina, S.Pd.I', 'role' => 'Guru Tahfidz Cilik', 'photo' => '/images/mockup_mobile_3.png'],
                    ['name' => 'Bunda Khadijah, A.Md', 'role' => 'Guru Sentra Seni & Kreativitas', 'photo' => '/images/mockup_mobile_4.png']
                ],
                'alumni' => [
                    ['name' => 'Bunda Mazaya', 'title' => 'Wali Murid TKIT Robbani', 'text' => 'Anak saya Mazaya menjadi sangat mandiri, rajin sholat, dan hafal surah pendek dengan lagu yang fasih.', 'avatar' => '/images/mockup_mobile_3.png'],
                    ['name' => 'Renni Susanti, A.Md.Kep', 'title' => 'Perawat & Wali Murid', 'text' => 'Lingkungan TKIT Robbani sangat bersih, aman, dan ustadzah pendidiknya sangat ramah membimbing anak.', 'avatar' => '/images/mockup_mobile_2.png']
                ]
            ],
            'sdit' => [
                'name' => 'SDIT Robbani Ogan Ilir',
                'code' => 'SDIT',
                'npsn' => '69985678',
                'akreditasi' => 'Terakreditasi A (Unggul)',
                'tagline' => 'Mencetak Generasi Qur\'ani, Berkarakter Karimah, & Cerdas Sains',
                'principal_name' => 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd',
                'principal_title' => 'Kepala Sekolah SDIT Robbani Ogan Ilir',
                'principal_photo' => '/images/logo-robbani-official.png',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di SDIT Robbani. Kami berkomitmen memberikan pendidikan dasar terbaik yang menyeimbangkan antara capaian hafalan Al-Qur\'an, akademik sains unggulan, serta kepemimpinan berakhlak mulia.',
                'description' => 'Sekolah Dasar Islam Terpadu berakreditasi A unggulan Ogan Ilir. Memadukan Kurikulum Merdeka Nasional dengan Kekhasan JSIT (Jaringan Sekolah Islam Terpadu), Tahfidz Al-Qur\'an 3-5 Juz Mutqin, Sains Olimpic Club, Koding Digital, & Pembentukan Karakter Islam.',
                'vision' => 'Menjadi Sekolah Dasar Islam Terpadu Model dalam Mencetak Generasi Qur\'ani, Cerdas Berakhlak, dan Berprestasi Nasional.',
                'missions' => [
                    'Menyelenggarakan bimbingan Al-Qur\'an dengan target kelulusan minimal 3-5 Juz secara mutqin.',
                    'Menerapkan Kurikulum Merdeka terintegrasi nilai-nilai keislaman dan pembiasaan ibadah harian.',
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
                    ['name' => 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd', 'role' => 'Kepala Sekolah SDIT', 'photo' => '/images/mockup_mobile_1.png'],
                    ['name' => 'Ustadz M. Yusuf, S.Pd.I', 'role' => 'Waka Kesiswaan & Guru Tahfidz', 'photo' => '/images/mockup_mobile_2.png'],
                    ['name' => 'Ustadzah Fatimah, S.Si', 'role' => 'Guru Wali Kelas 5 & Pembina Sains', 'photo' => '/images/mockup_mobile_3.png'],
                    ['name' => 'Ustadz Rizky Pratama, S.Kom', 'role' => 'Guru IT & Koding Digital', 'photo' => '/images/mockup_mobile_4.png']
                ],
                'alumni' => [
                    ['name' => 'Ecilia Oktarina, SE., MM.', 'title' => 'Wali Murid SDIT Robbani', 'text' => 'Pendidikan karakter dan kepemimpinan di SDIT Robbani sangat terasa perubahannya pada kebiasaan sholat anak di rumah.', 'avatar' => '/images/mockup_mobile_1.png'],
                    ['name' => 'Anaya Tahta', 'title' => 'Alumni SDIT Robbani 2020', 'text' => 'Selama di SDIT Robbani saya mendapatkan hafalan Al-Qur\'an beberapa juz dan fondasi akademik sains yang kuat.', 'avatar' => '/images/logo-robbani-official.png']
                ]
            ],
            'smpit' => [
                'name' => 'SMP IT ROBBANI',
                'code' => 'SMPIT',
                'npsn' => '69989012',
                'akreditasi' => 'Terakreditasi A (Unggul)',
                'tagline' => 'Because Every Child is Unique (Berbasis Digital & Pendidikan Karakter)',
                'principal_name' => 'Ustadz Muhammad Ridwan, S.Si, M.Pd',
                'principal_title' => 'Kepala Sekolah SMP IT Robbani Ogan Ilir',
                'principal_photo' => '/images/logo-robbani-official.png',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di SMP IT Robbani. Kami memadukan kecerdasan digital (SIPAKAR V2) dan kemuliaan akhlak pada santri untuk melahirkan generasi Rabbani yang beriman, bertaqwa, unggul dalam IPTEK, serta berwawasan global.',
                'description' => 'SMP IT Robbani adalah sekolah menengah pertama Islam terpadu yang memadukan kecerdasan digital, kemuliaan akhlak, tahfidz Al-Qur\'an, dan pendidikan karakter mandiri (Boarding & Fullday). Alamat: Jln. Sarjana Padang Guci, Kelurahan Timbangan, Kecamatan Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan.',
                'vision' => 'Melahirkan Generasi Rabbani yang Beriman dan Bertaqwa, Unggul dalam Ilmu Pengetahuan dan Teknologi serta Berwawasan Global.',
                'missions' => [
                    'Mengadakan kegiatan keagamaan secara rutin dan teratur untuk menumbuhkan penghayatan dan pengamalan nilai-nilai ajaran agama Islam.',
                    'Membina dan menumbuhkan budaya disiplin dan berkarakter.',
                    'Melaksanakan pengajaran secara efektif dan menyenangkan dengan penerapan teknologi pendidikan (SIPAKAR V2).',
                    'Membimbing dan mengarahkan setiap murid untuk mengenali potensi diri, sehingga dapat mengembangkan talenta sebagai kecakapan hidupnya.',
                    'Menumbuhkan daya juang serta semangat yang tinggi dalam belajar dan bekerja keras untuk meraih prestasi dan peduli terhadap lingkungan.'
                ],
                'phone' => '085377193977',
                'students_count' => 280,
                'employees_count' => 26,
                'classrooms_count' => 10,
                'target_hafalan' => '5 - 10 Juz Mutqin',
                'programs' => [
                    ['title' => 'SIPAKAR V2 Digital Learning', 'icon' => '💻', 'desc' => 'Pembelajaran digital terintegrasi sistem presensi, modul CBT, dan rekam jejak hafalan.'],
                    ['title' => 'Boarding & Fullday System', 'icon' => '🏫', 'desc' => 'Pengasuhan 24 jam dengan pembiasaan tahajud, subuh berjamaah, dan disiplin tinggi.'],
                    ['title' => 'Tahfidz Intensive 5-10 Juz', 'icon' => '📜', 'desc' => 'Karantina tahfidz berkala dengan target hafalan mutqin dan pemahaman Al-Qur\'an.'],
                    ['title' => 'English & Arabic Active Club', 'icon' => '🌍', 'desc' => 'Pembiasaan percakapan harian 2 bahasa asing dan lomba public speaking.']
                ],
                'teachers' => [
                    ['name' => 'Ustadz M. Ridwan, S.Si, M.Pd', 'role' => 'Kepala Sekolah SMPIT', 'photo' => '/images/mockup_mobile_1.png'],
                    ['name' => 'Ustadz Farhan, Lc', 'role' => 'Guru Bahasa Arab & Musyrif', 'photo' => '/images/mockup_mobile_2.png'],
                    ['name' => 'Ustadzah Syifa, S.Pd', 'role' => 'Guru Matematika & Pembina OSN', 'photo' => '/images/mockup_mobile_3.png'],
                    ['name' => 'Ustadz Abdullah, S.Pd.I', 'role' => 'Pembina Tahfidz & Keasramaan', 'photo' => '/images/mockup_mobile_4.png']
                ],
                'alumni' => [
                    ['name' => 'Faiz', 'title' => 'Alumni SMPIT Robbani', 'text' => 'Kehidupan di asrama SMPIT melatih saya mandiri, disiplin ibadah malam, dan hafal 7 juz Al-Qur\'an.', 'avatar' => '/images/mockup_mobile_5.png'],
                    ['name' => 'Calvin', 'title' => 'Siswa Boarding SMPIT', 'text' => 'Fasilitas asramanya lengkap, gurunya ramah dan selalu mendampingi saat belajar malam.', 'avatar' => '/images/mockup_mobile_4.png']
                ]
            ],
            'smait' => [
                'name' => 'SMAIT Robbani Ogan Ilir',
                'code' => 'SMAIT',
                'npsn' => '69983456',
                'akreditasi' => 'Terakreditasi A (Unggul)',
                'tagline' => 'Center of Excellence: Science, IT, Tahfidz 10-30 Juz, & Mentoring PTN',
                'principal_name' => 'Ustadz Syamsul Bahri, M.Sc',
                'principal_title' => 'Kepala Sekolah SMAIT Robbani Ogan Ilir',
                'principal_photo' => '/images/logo-robbani-official.png',
                'principal_greeting' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. SMAIT Robbani mengantarkan para santri lulusan untuk memimpin dunia, unggul dalam seleksi UTBK PTN ternama (UI, ITB, UGM, UNSRI), serta berjiwa Huffazh Al-Qur\'an yang tangguh.',
                'description' => 'Sekolah Menengah Atas Islam Terpadu jenjang lanjutan berfokus pada persiapan tembus PTN Favorit & Beasiswa Luar Negeri, Tahfidz Al-Qur\'an 10-30 Juz berijazah sanad, serta Riset Sains & Leadership.',
                'vision' => 'Menjadi SMAIT Unggulan Nasional dalam Melahirkan Ilmuwan Muslim, Huffazh Al-Qur\'an, dan Pemimpin Masa Depan.',
                'missions' => [
                    'Menyelenggarakan bimbingan intensif UTBK-SNBT dan seleksi PTN / Beasiswa Luar Negeri.',
                    'Melahirkan lulusan berjiwa Huffazh Al-Qur\'an target 10-30 Juz berijazah sanad.',
                    'Mendorong riset sains remaja, inovasi koding digital, dan karya ilmiah tingkat nasional.',
                    'Membentuk karakter kader dakwah dan pemimpin berintegritas tinggi.'
                ],
                'phone' => '0811747472',
                'students_count' => 190,
                'employees_count' => 22,
                'classrooms_count' => 8,
                'target_hafalan' => '10 - 30 Juz (Huffazh)',
                'programs' => [
                    ['title' => 'Bimbingan Intensif PTN & Beasiswa', 'icon' => '🎓', 'desc' => 'Tryout SNBT berkala, pemetaan jurusan, dan pendampingan lolos perguruan tinggi ternama.'],
                    ['title' => 'Tahfidz 10-30 Juz & Sanad', 'icon' => '📖', 'desc' => 'Program khusus santri tahfidz dengan target mutqin dan persiapan pengambilan sanad.'],
                    ['title' => 'Riset Sains & Technology Project', 'icon' => '🧪', 'desc' => 'Penelitian ilmiah remaja, karya tulis ilmiah, dan proyek teknologi buatan siswa.'],
                    ['title' => 'Public Speaking & Leadership', 'icon' => '🎙️', 'desc' => 'Latihan pidato 3 bahasa, manajemen organisasi OSIS, dan debat internasional.']
                ],
                'teachers' => [
                    ['name' => 'Ustadz Syamsul Bahri, M.Sc', 'role' => 'Kepala Sekolah SMAIT', 'photo' => '/images/mockup_mobile_1.png'],
                    ['name' => 'Ustadz Dr. H. Burhanuddin, M.A', 'role' => 'Guru Al-Qur\'an & Hadits', 'photo' => '/images/mockup_mobile_2.png'],
                    ['name' => 'Ustadzah Intan, M.Pd', 'role' => 'Koordinator Bimbingan PTN / Fisika', 'photo' => '/images/mockup_mobile_3.png'],
                    ['name' => 'Ustadz Ahmad Zaki, S.T', 'role' => 'Pembina Coding & Robotik', 'photo' => '/images/mockup_mobile_4.png']
                ],
                'alumni' => [
                    ['name' => 'Ahmad Rivaldi', 'title' => 'Alumni SMAIT - Mahasiswa ITB', 'text' => 'Didikan di SMAIT Robbani membuat saya siap bersaing di ITB sambil tetap menjaga hafalan Al-Qur\'an.', 'avatar' => '/images/mockup_mobile_5.png'],
                    ['name' => 'Siti Humaira', 'title' => 'Alumni SMAIT - Kedokteran UNSRI', 'text' => 'Bimbingan sains dan motivasi di SMAIT Robbani sangat membantu kelulusan saya di Kedokteran.', 'avatar' => '/images/logo-robbani-official.png']
                ]
            ]
        ];

        $uKey = isset($unitMap[$cleanCode]) ? $cleanCode : 'sdit';
        $defaultInfo = $unitMap[$uKey];

        // Merge custom setting if present
        $info = array_merge($defaultInfo, $customUnit ?? []);

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

        $students = Student::where('school_id', $school->id ?? 1)->where('status', 'aktif')->take(10)->get();
        $teachers = Employee::where('school_id', $school->id ?? 1)->where('status', 'aktif')->take(8)->get();
        $classrooms = Classroom::where('school_id', $school->id ?? 1)->with('level')->get();

        $settings = $this->getSettings();
        $headerMenus = $this->getHeaderMenus();

        return view('school.unit', compact('school', 'info', 'students', 'teachers', 'classrooms', 'settings', 'headerMenus'));
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
        return view('school.layanan.kunjungan', compact('settings'));
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
        ]);

        return redirect()->back()->with('success', 'Permohonan Izin Kunjungan Sekolah berhasil dikirim! Tim Humas Yayasan Generasi Robbani akan menghubungi Anda melalui WhatsApp/Email.');
    }

    public function layananKerjasama()
    {
        $settings = $this->getSettings();
        return view('school.layanan.kerjasama', compact('settings'));
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
        ]);

        return redirect()->back()->with('success', 'Permohonan Kerjasama & Kemitraan telah diterima! Tim Kemitraan SIT Robbani Ogan Ilir akan memproses proposal Anda.');
    }

    public function layananSewa()
    {
        $settings = $this->getSettings();
        $facilityList = $this->getFacilityData();
        return view('school.layanan.sewa', compact('settings', 'facilityList'));
    }

    public function storeLayananSewa(Request $request)
    {
        $request->validate([
            'nama_penyewa' => 'required|string|max:255',
            'no_hp' => 'required|string',
            'fasilitas_disewa' => 'required|string',
            'tgl_sewa' => 'required|date',
            'keperluan' => 'required|string',
        ]);

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

    public function eSppCheck(Request $request)
    {
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
                return $data;
            }
        }

        return [
            [
                'title' => 'Puncak Tema & Pentas Seni Cilik Santri KB/TKIT Robbani Ogan Ilir',
                'slug' => 'puncak-tema-pentas-seni-cilik-santri-kbtkit-robbani-ogan-ilir',
                'category' => 'KB/TKIT',
                'date' => '12 Agustus 2026',
                'author' => 'Humas KB/TKIT Robbani',
                'image' => '/images/mockup_mobile_1.png',
                'excerpt' => 'Keceriaan dan kebersamaan santri cilik KB/TKIT Robbani Ogan Ilir saat mengekspresikan bakat hafalan surah pendek, doa harian, & kreasi mewarnai bersama bundanya.',
                'content' => 'Ogan Ilir — Suasana penuh warna dan keceriaan mewarnai aula KB/TKIT Robbani Ogan Ilir dalam gelaran Puncak Tema & Pentas Seni Cilik Santri Usia Dini Tahun Ajaran 2026/2027.<br><br>Acara ini diselenggarakan sebagai wadah apresiasi tumbuh kembang, keberanian, dan kreativitas santri cilik KB/TKIT Robbani setelah menyelesaikan tema pembelajaran semester ganjil.<br><br>Para santri dengan percaya diri menampilkan unjuk bakat hafalan surah-surah pendek Al-Qur\'an (Juz Amma), perkataan thoyyibah, doa harian, tarian kreasi nusantara islami, serta fashion show pakaian adat.<br><br>Kepala KB/TKIT Robbani, Ustdz. Nurhidayah, S.Pd.I, menyampaikan rasa syukur dan haru atas perkembangan adab dan kemandirian ananda. "Pendidikan usia dini di SIT Robbani dirancang dengan metode belajar seraya bermain yang menyenangkan, menanamkan nilai-nilai keislaman sejak dini, serta membangun ikatan kasih sayang yang erat antara guru, anak, dan orang tua," tutur beliau.'
            ],
            [
                'title' => 'Pramuka SIT & Supercamp Karakter Siswa SDIT Robbani 2026',
                'slug' => 'pramuka-sit-supercamp-karakter-siswa-sdit-robbani-2026',
                'category' => 'SDIT',
                'date' => '08 Agustus 2026',
                'author' => 'Pembina Pramuka SDIT',
                'image' => '/images/mockup_mobile_2.png',
                'excerpt' => 'Pelatihan kemandirian, ketangkasan, dan mabit malam bina iman takwa santri penggalang SDIT Robbani Ogan Ilir.',
                'content' => 'Ogan Ilir — Ratusan santri penggalang Sekolah Dasar Islam Terpadu (SDIT) Robbani Ogan Ilir antusias mengikuti kegiatan Perkemahan Sabtu-Minggu (Persami) & Supercamp Karakter Pramuka SIT 2026 di Bumi Perkemahan Kampus Terpadu Robbani.<br><br>Kegiatan yang mengusung tema "Tangguh, Mandiri, Berakhlak Karimah, dan Siap Memimpin" ini diisi dengan berbagai materi ketangkasan, sandi morse, pioneering tali temali, penjelajahan alam halang rintang, serta pertunjukan api unggun.<br><br>Selain ketangkasan fisik, peserta diajak memperdalam ruhani melalui sholat qiyamul lail berjamaah, munasabah malam bina iman takwa (MABIT), dan tahfidz bersama di bawah bimbingan ustadz-ustadzah pendamping.<br><br>Kepala SDIT Robbani, Ustdz. M. Ridwan, S.Pd, mengapresiasi tinggi kedisiplinan para santri. Kegiatan outdoor ini merupakan sarana efektif menempa jiwa kepemimpinan, kepedulian sosial, serta rasa ukhuwah antar sesama siswa.'
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
                'title' => 'Santri SMAIT Robbani Lolos Seleksi PTN Favorit & Beasiswa Luar Negeri 2026',
                'slug' => 'santri-smait-robbani-lolos-seleksi-ptn-favorit-beasiswa-luar-negeri-2026',
                'category' => 'SMAIT',
                'date' => '20 Juli 2026',
                'author' => 'Tim Bimbingan Konseling SMAIT',
                'image' => '/images/mockup_mobile_4.png',
                'excerpt' => 'Capaian membanggakan alumni SMAIT Robbani tembus jalur SNBP, SNBT, dan beasiswa perguruan tinggi ternama di dalam maupun luar negeri.',
                'content' => 'Ogan Ilir — Kualitas lulusan Sekolah Menengah Atas Islam Terpadu (SMAIT) Robbani Ogan Ilir kembali terbukti di kancah nasional dan internasional. Berdasarkan pengumuman resmi kelulusan PTN 2026, puluhan alumni SMAIT Robbani berhasil diterima di Perguruan Tinggi Negeri (PTN) favorit seperti Universitas Sriwijaya, ITB, UGM, UNDIP, serta Universitas Al-Azhar Kairo.<br><br>Keberhasilan ini tidak lepas dari kombinasi bimbingan akademik intensif, try out UTBK berkala, serta program matrikulasi tahfidz dan penguasaan Bahasa Arab & Inggris yang menjadi ciri khas SMAIT Robbani.<br><br>Kepala SMAIT Robbani, Ustdz. Ahmad Subagja, M.Si, mengungkapkan rasa bangga atas perjuangan para santri. "Alhamdulillah, keberhasilan ini adalah buah dari kerja keras santri, doa dari orang tua, dan kesabaran dewan guru yang membimbing dengan hati," ungkap beliau.'
            ],
            [
                'title' => 'Kegiatan Fun Cooking & Edukasi Gizi Santri Usia Dini TKIT Robbani',
                'slug' => 'kegiatan-fun-cooking-edukasi-gizi-santri-usia-dini-tkit-robbani',
                'category' => 'KB/TKIT',
                'date' => '05 Juli 2026',
                'author' => 'Tim Kurikulum TKIT',
                'image' => '/images/mockup_desktop_1.png',
                'excerpt' => 'Mengenalkan makanan sehat halal dan thoyyib sejak dini melalui praktik memasak menyenangkan bersama ustazah dan wali santri.',
                'content' => 'Ogan Ilir — Para santri cilik KB/TKIT Robbani antusias mengikuti kegiatan Fun Cooking & Edukasi Makanan Sehat Halalan Thoyyiban di halaman sekolah.<br><br>Dengan mengenakan celemek dan topi koki cilik, para santri diajak membuat kreasi bekal sehat berupa bento sayur, salad buah, dan jus buah segar.<br><br>Melalui kegiatan ini, santri belajar mengenalkan jenis sayuran, buah-buahan, serta kebiasaan mencuci tangan dan membaca doa sebelum dan sesudah makan.'
            ],
            [
                'title' => 'Munaqosyah Tahfidz Juz 29 & 30 Terbuka SDIT Robbani Ogan Ilir',
                'slug' => 'munaqosyah-tahfidz-juz-29-30-terbuka-sdit-robbani-ogan-ilir',
                'category' => 'SDIT',
                'date' => '18 Juni 2026',
                'author' => 'Tim Al-Qur\'an SDIT',
                'image' => '/images/mockup_desktop_2.png',
                'excerpt' => 'Ujian hafalan Al-Qur\'an terbuka siswa SDIT Robbani di hadapan para penguji munaqisy dan orang tua santri.',
                'content' => 'Ogan Ilir — Puluhan santri SDIT Robbani Ogan Ilir mengikuti ujian Munaqosyah Tahfidz Al-Qur\'an Juz 29 dan 30 secara terbuka di Masjid Kampus Robbani.<br><br>Setiap santri diuji sambung ayat, tajwid, makhraj huruf, dan kelancaran hafalan oleh tim penguji eksternal dari Lembaga Pengembangan Pendidikan Al-Qur\'an.<br><br>Orang tua santri yang hadir dibuat terharu dan meneteskan air mata bahagia menyaksikan kemampuan hafalan ananda yang lancar dan tartil.'
            ],
            [
                'title' => 'Olimpiade Sains & Kebumian: Tim Santri SMPIT Robbani Sabet Emas',
                'slug' => 'olimpiade-sains-kebumian-tim-santri-smpit-robbani-sabet-emas',
                'category' => 'SMPIT',
                'date' => '10 Juni 2026',
                'author' => 'Tim Prestasi SMPIT',
                'image' => '/images/mockup_desktop_3.png',
                'excerpt' => 'Perjuangan tim olimpiade sains SMPIT Robbani dalam kompetisi akademik tingkat regional Sumatera Selatan.',
                'content' => 'Ogan Ilir — Tim Sains dan Matematika SMPIT Robbani Ogan Ilir kembali mengukir prestasi gemilang dengan meraih 2 Medali Emas dan 3 Medali Perak dalam Olimpiade Sains Islam & Kebumian 2026.<br><br>Para santri mampu menyelesaikan soal-soal penalaran fisika, biologi, dan matematika terintegrasi nilai-nilai Al-Qur\'an dengan perolehan skor tertinggi.<br><br>Prestasi ini membuktikan bahwa pendidikan Islam Terpadu di SMPIT Robbani mampu melahirkan generasi ahli sains yang tetap memegang teguh akidah islamiyah.'
            ],
            [
                'title' => 'Workshop IoT & Coding Mobile App Santri SMAIT Robbani 2026',
                'slug' => 'workshop-iot-coding-mobile-app-santri-smait-robbani-2026',
                'category' => 'SMAIT',
                'date' => '28 Mei 2026',
                'author' => 'Laboratorium Komputer SMAIT',
                'image' => '/images/mockup_desktop_4.png',
                'excerpt' => 'Pelatihan pemrograman aplikasi android dan teknologi internet of things (IoT) berbasis dakwah digital santri SMAIT Robbani.',
                'content' => 'Ogan Ilir — Dalam rangka membekali santri dengan keterampilan abad 21, SMAIT Robbani Ogan Ilir menggelar Workshop Coding & IoT Development selama 3 hari.<br><br>Para santri diajarkan merancang aplikasi mobile berbasis Android, sistem otomasi sensor cerdas (Internet of Things), serta manajemen database cloud.<br><br>Karya-karya inovasi santri seperti sistem presensi digital dan pengingat waktu sholat otomatis dipresentasikan di hadapan para penguji dan praktisi IT.'
            ]
        ];
    }

    public function getArticleData()
    {
        $cmsJson = SiteSetting::get('cms_article_data');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
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
                'title' => 'Profil Resmi SIT Robbani Ogan Ilir 2026',
                'category' => 'Profil Video',
                'duration' => '04:25',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/mockup_desktop_1.png',
                'desc' => 'Video sinematik profil Yayasan Generasi Robbani Sumatera Selatan dan 4 unit sekolah unggulan di Ogan Ilir.'
            ],
            [
                'title' => 'Haflah Akhirussanah & Wisuda Tahfidz Al-Qur’an 2026',
                'category' => 'Dokumentasi Acara',
                'duration' => '08:12',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/hero_3d_illustration_1786347707126.png',
                'desc' => 'Suasana haru dan penuh kebanggaan saat prosesi wisuda tahfidz Al-Qur’an para siswa SIT Robbani.'
            ],
            [
                'title' => 'Ekosistem Digital ARSI & Pembelajaran LMS Robbani',
                'category' => 'Teknologi Digital',
                'duration' => '03:40',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/dashboard_admin_3d_1786349842846.png',
                'desc' => 'Kemudahan akses wali murid memantau presensi, SPP, dan E-Learning di SIT Robbani Ogan Ilir.'
            ],
            [
                'title' => 'Kegiatan Pramuka SIT Robbani & Supercamp Tahfidz',
                'category' => 'Kegiatan Ekstrakurikuler',
                'duration' => '05:15',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/mockup_desktop_2.png',
                'desc' => 'Dokumentasi kegiatan alam terbuka, kemandirian siswa, dan mabit pembentukan karakter Rabbani.'
            ],
            [
                'title' => 'Keseruan Belajar Sains & Praktikum Lab Komputer',
                'category' => 'Pembelajaran Digital',
                'duration' => '04:10',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/mockup_desktop_3.png',
                'desc' => 'Momen kebersamaan siswa saat eksplorasi sains, robotika, dan pembelajaran interaktif di sekolah.'
            ],
            [
                'title' => 'Pentas Seni & Panggung Aksi Kreativitas Siswa Robbani',
                'category' => 'Seni & Bakat',
                'duration' => '06:30',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => '/images/mockup_desktop_4.png',
                'desc' => 'Penampilan bakat nasyid, pidato 3 bahasa, memanah, dan kreasi seni Islami santri SIT Robbani.'
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
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            [
                'title' => 'Prosesi Haflah & Wisuda Tahfidz Al-Qur\'an',
                'category' => 'Wisuda & Tahfidz',
                'image' => '/images/hero_3d_illustration_1786347707126.png',
                'desc' => 'Momen kebanggaan wisudawan tahfidz menerima sertifikat hafalan Al-Qur’an.'
            ],
            [
                'title' => 'Gedung & Lingkungan Asri SIT Robbani',
                'category' => 'Fasilitas Kampus',
                'image' => '/images/mockup_desktop_1.png',
                'desc' => 'Kompleks persekolahan yang bersih, asri, kondusif, dan dilengkapi fasilitas modern.'
            ],
            [
                'title' => 'Pelaksanaan Qurban Dompet Sosial Robbani',
                'category' => 'Bakti Sosial',
                'image' => '/images/mockup_desktop_2.png',
                'desc' => 'Kebersamaan civitas akademika dan masyarakat dalam penyembelihan hewan qurban.'
            ],
            [
                'title' => 'Pembelajaran Digital di Lab Komputer',
                'category' => 'Sarana & Teknologi',
                'image' => '/images/mockup_desktop_3.png',
                'desc' => 'Siswa berlatih koding, literasi digital, dan Asesmen Komputer (ANBK).'
            ],
            [
                'title' => 'Kegiatan Literasi Perpustakaan Digital',
                'category' => 'Perpustakaan',
                'image' => '/images/mockup_desktop_4.png',
                'desc' => 'Siswa menikmati koleksi buku fisik dan e-library perpustakaan SIT Robbani.'
            ],
            [
                'title' => 'Penghargaan Kepala Sekolah Terbaik III Sumsel',
                'category' => 'Prestasi Pendidik',
                'image' => '/images/hero_3d_illustration_1786347707126.png',
                'desc' => 'Penerimaan sertifikat diklat manajemen kepala sekolah tingkat Provinsi Sumatera Selatan.'
            ]
        ];
    }

    public function getHeaderMenus()
    {
        $cmsJson = SiteSetting::get('cms_header_menus');
        if ($cmsJson) {
            $data = json_decode($cmsJson, true);
            if (is_array($data) && count($data) > 0) {
                return $data;
            }
        }

        return [
            ['title' => 'Beranda', 'url' => route('home'), 'is_active' => true],
            ['title' => 'Profil', 'url' => route('school.profil'), 'is_active' => true],
            ['title' => 'Unit', 'url' => '#unit-sekolah', 'is_active' => true],
            ['title' => 'Berita', 'url' => route('school.berita'), 'is_active' => true],
            ['title' => 'Artikel', 'url' => route('school.artikel'), 'is_active' => true],
            ['title' => 'Sarana & Prasarana', 'url' => '#sarana-prasarana', 'is_active' => true],
            ['title' => 'Galeri', 'url' => '#galeri-sekolah', 'is_active' => true],
            ['title' => 'E-SPP', 'url' => route('school.espp'), 'is_active' => true],
        ];
    }
}

