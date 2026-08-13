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
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/testi1.png'
            ],
            [
                'name' => 'RENNI SUSANTI, A.Md. Kep.',
                'title' => 'Perawat RSUD Ogan Ilir',
                'text' => 'Sekolah Robbani merupakan sekolah pilihan terbaik saat ini. Pembelajarannya sangat bagus, gurunya muda dan berkompeten, serta fondasi agamanya sangat kuat. Hubungan silaturahmi antara guru, siswa, dan ortu sangat erat.',
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/testi2.png'
            ],
            [
                'name' => 'Bunda Mazaya',
                'title' => 'Wali Murid Alumni SDIT Robbani',
                'text' => 'Alhamdulillah selama anak saya Mazaya bersekolah di sini, banyak ilmu yang didapat terutama pengetahuan Agama, hafalan Al-Qur\'an bertambah, dan sering ikut perlombaan sehingga bertambah percaya dirinya.',
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/WhatsApp-Image-2022-01-25-at-18.38.24-e1643114298553.jpeg'
            ],
            [
                'name' => 'Calvin',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolah di Robbani enak, punya banyak teman, sekolahnya nyaman, fasilitasnya bagus, gurunya baik dan ramah, ada satpam yang stay terus jadi sekolahnya aman.',
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/03/XA.png'
            ],
            [
                'name' => 'Faiz',
                'title' => 'Siswa SDIT Robbani',
                'text' => 'Sekolahnya menyenangkan, gurunya ramah, ruang kelas ber-AC jadi sangat nyaman saat belajar.',
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/03/FAIZ-768x768.png'
            ],
            [
                'name' => 'Anaya Tahta',
                'title' => 'Alumni SIT Robbani TA 2020/2021',
                'text' => 'Selama sekolah di ROBBANI saya mendapatkan banyak ilmu bermanfaat, dapat menyelesaikan hafalan beberapa juz, serta diajarkan disiplin dan bertanggung jawab. Terimakasih ustadz dan bunda atas bimbingannya.',
                'avatar' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/TK.png'
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

        // Data Video, Agenda, Pengumuman Native
        $videoList = $this->getVideoData();
        $agendaList = $this->getAgendaData();
        $announcementList = $this->getAnnouncementData();

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
            'announcementList'
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
        $school = School::withCount(['students', 'employees', 'classrooms'])
            ->where('code', strtoupper($code))
            ->firstOrFail();

        $students = Student::where('school_id', $school->id)->where('status', 'aktif')->take(10)->get();
        $teachers = Employee::where('school_id', $school->id)->where('status', 'aktif')->take(8)->get();
        $classrooms = Classroom::where('school_id', $school->id)->with('level')->get();

        $settings = $this->getSettings();

        return view('school.unit', compact('school', 'students', 'teachers', 'classrooms', 'settings'));
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
        $news = collect($newsList)->firstWhere('slug', $slug) ?? $newsList[0];
        $recentNews = collect($newsList)->where('slug', '!=', $news['slug'])->take(3);
        
        return view('school.berita.show', compact('settings', 'news', 'recentNews'));
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
        $request->validate([
            'school_code' => 'required|string',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'nama_ortu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string',
            'alamat' => 'required|string',
        ]);

        $noRegistrasi = 'PPDB-' . strtoupper($request->school_code) . '-' . rand(10000, 99999);

        return redirect()->back()->with('success', 'Pendaftaran PPDB Berhasil! Nomor Registrasi Ananda: ' . $noRegistrasi . '. Panitia PPDB SIT Robbani akan menghubungi Anda untuk tahapan observasi & wawancara.');
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

    private function getSettings()
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
        ];
    }

    private function getNewsData()
    {
        return [
            [
                'title' => 'Kepala SMP IT Robbani Ogan Ilir Raih Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah Sumatera Selatan 2026',
                'slug' => 'kepsek-smp-it-robbani-raih-peserta-terbaik-iii',
                'category' => 'Berita',
                'date' => '31 Juli 2026',
                'author' => 'Humas SIT Robbani',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/07/1000264778-1024x683.webp',
                'excerpt' => 'Alhamdulillah, Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir berhasil meraih Penghargaan Peserta Terbaik III dalam Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan.',
                'content' => 'Ogan Ilir — Sebuah kebanggaan besar kembali diukir oleh keluarga besar Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir. Ibu Tia Wulandari, S.Pd., Kepala SMP IT Robbani Ogan Ilir, berhasil meraih penghargaan sebagai Peserta Terbaik III pada Diklat Manajemen Kepala Sekolah tingkat Provinsi Sumatera Selatan Tahun 2026.<br><br>Kegiatan diklat ini diselenggarakan oleh Dinas Pendidikan Provinsi Sumatera Selatan sebagai upaya meningkatkan kompetensi kepemimpinan manajerial, kewirausahaan, dan supervisi akademik kepala sekolah di era transformasi digital.<br><br>Dalam kesempatannya, Ibu Tia Wulandari menyampaikan rasa syukur dan dedikasi atas pencapaian ini kepada seluruh jajaran ustadz-ustadzah, siswa, dan orang tua murid di SIT Robbani Ogan Ilir. "Penghargaan ini merupakan motivasi bagi kami untuk terus berinovasi dan menghadirkan tata kelola sekolah Islam terpadu yang profesional, berkarakter, dan berdaya saing tinggi," tutur beliau.'
            ],
            [
                'title' => 'Rayakan Perjalanan Pendidikan dan Cinta Al-Qur’an, SIT Robbani Ogan Ilir Gelar Haflah Akhirussanah & Wisuda Tahfidz 2026',
                'slug' => 'rayakan-perjalanan-pendidikan-dan-cinta-al-quran-sit-robbani-wisuda-tahfidz-2026',
                'category' => 'Berita',
                'date' => '15 Juni 2026',
                'author' => 'Panitia Haflah Robbani',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png',
                'excerpt' => 'Ogan Ilir — Suasana penuh haru, syukur, dan kebanggaan menyelimuti pelaksanaan Haflah Akhirussanah & Wisuda Tahfidz SIT Robbani Ogan Ilir tahun ajaran 2025/2026.',
                'content' => 'Ogan Ilir, 15 Juni 2026 — Suasana khidmat, haru, dan melimpah keberkahan mewarnai gedung acara pelaksanaan Haflah Akhirussanah & Wisuda Tahfidz Al-Qur’an SIT Robbani Ogan Ilir.<br><br>Sebanyak puluhan wisudawan dari jenjang TKIT, SDIT, SMPIT, dan SMAIT Robbani dengan bangga dipasangkan mahkota dan menerima ijazah kelulusan serta sertifikat tahfidz hafalan Al-Qur\'an (1 Juz hingga 5 Juz).<br><br>Acara dihadiri oleh jajaran pengurus Yayasan Generasi Robbani Sumatera Selatan, Dinas Pendidikan Ogan Ilir, tokoh masyarakat, dan ratusan wali murid yang meneteskan air mata bahagia menyaksikan wisuda ananda.'
            ],
            [
                'title' => '[PRESS RELEASE] Penyembelihan Hewan Qurban Dompet Sosial Robbani Peduli x SIT ROBBANI OGAN ILIR',
                'slug' => 'press-release-penyembelihan-hewan-qurban-dompet-sosial-robbani-peduli',
                'category' => 'Berita',
                'date' => '02 Juni 2026',
                'author' => 'Dompet Sosial Robbani',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/06/2-819x1024.jpg',
                'excerpt' => 'Ogan Ilir – Dalam semangat berbagi dan meneladani keikhlasan Nabi Ibrahim AS, Dompet Sosial Robbani Peduli berkolaborasi dengan SIT Robbani menyelenggarakan penyembelihan hewan qurban.',
                'content' => 'Ogan Ilir — Menyemarakkan Hari Raya Idul Adha 1447 H, Lembaga Dompet Sosial Robbani Peduli berkolaborasi dengan Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir sukses melaksanakan penyembelihan dan pendistribusian paket hewan qurban.<br><br>Daging qurban didistribusikan kepada masyarakat di sekitar lingkungan sekolah, kaum dhuafa, anak yatim, serta keluarga besar pegawai dan guru SIT Robbani.<br><br>Kegiatan ini menjadi wadah edukasi praktis bagi para siswa untuk meneladani sifat kedermawanan, empati sosial, dan ketakwaan Nabi Ibrahim AS dan Nabi Ismail AS.'
            ],
            [
                'title' => 'Pengumuman Kelulusan Tahap Administrasi Rekrutmen Guru dan Pegawai SIT Robbani Tahun Ajaran 2026/2027',
                'slug' => 'pengumuman-kelulusan-tahap-administrasi-rekrutmen-guru-dan-pegawai-sit-robbani-2026',
                'category' => 'Pengumuman',
                'date' => '07 Mei 2026',
                'author' => 'Tim Rekrutmen SDM',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/07/image-1-1024x608.webp',
                'excerpt' => 'Assalamu’alaikum wr. wb. Alhamdulillahirabbil ‘alamin, berdasarkan hasil seleksi administrasi Rekrutmen Guru dan Pegawai Sekolah Islam Terpadu Robbani Ogan Ilir Tahun Ajaran 2026/2027.',
                'content' => 'Assalamu’alaikum Warahmatullahi Wabarakatuh.<br><br>Alhamdulillahirabbil ‘alamin, berdasarkan verifikasi dokumen dan seleksi administrasi Rekrutmen Guru dan Pegawai Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir Tahun Ajaran 2026/2027, Panitia Seleksi SDM menetapkan nama-nama pelamar yang dinyatakan LULUS Seleksi Administrasi.<br><br>Peserta yang lulus berhak mengikuti tahapan Ujian Microteaching & Wawancara Keislaman. Detail jadwal dan lokasi tes dikirimkan melalui WhatsApp/Email resmi panitia.'
            ]
        ];
    }

    private function getArticleData()
    {
        return [
            [
                'title' => 'Tata Cara Sholat Tasbih dan Keutamaannya',
                'slug' => 'tata-cara-sholat-tasbih-dan-keutamaannya',
                'category' => 'Artikel Keislaman',
                'date' => '06 Maret 2026',
                'author' => 'Tim Bina Pribadi Islami',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/07/1-Copy-1024x678.webp',
                'excerpt' => 'Sholat Tasbih merupakan salah satu sholat sunnah yang dianjurkan untuk dikerjakan oleh umat Islam. Sholat ini memiliki keistimewaan karena di dalamnya dipenuhi kalimat tasbih.',
                'content' => 'Sholat Tasbih merupakan salah satu sholat sunnah yang dianjurkan untuk dikerjakan oleh umat Islam, baik dilaksanakan pada siang hari maupun malam hari.<br><br><strong>Keutamaan Sholat Tasbih:</strong><br>1. Menggugurkan dosa-dosa kecil maupun besar.<br>2. Menjadikan hati lebih tenang dan dekat dengan Allah SWT.<br>3. Meneladani sunnah Rasulullah SAW dan arahan kepada Sayyidina Abbas RA.<br><br><strong>Tata Cara Pelaksanaan:</strong><br>Sholat Tasbih dikerjakan sebanyak 4 rakaat. Dalam setiap rakaatnya, dibaca kalimat tasbih <i>"Subhanallah walhamdulillah wala ilaha illallah wallahu akbar"</i> sebanyak 75 kali (total 300 kali tasbih dalam 4 rakaat).'
            ],
            [
                'title' => 'Membangun Karakter Rabbani Melalui Pembiasaan Mutabaah Yaumiyah & Bina Pribadi Islami',
                'slug' => 'membangun-karakter-rabbani-melalui-mutabaah-yaumiyah-bpi',
                'category' => 'Artikel Edukasi',
                'date' => '18 Februari 2026',
                'author' => 'Tim Kurikulum JSIT',
                'image' => 'https://sitrobbani.sch.id/wp-content/uploads/2023/11/book.png',
                'excerpt' => 'Pembentukan karakter generasi Rabbani diawali dengan pembiasaan sholat 5 waktu tepat waktu, tilawah Al-Qur\'an, hafalan ziyadah, dan keterlibatan aktif wali murid.',
                'content' => 'Pembentukan karakter siswa tidak hanya cukup dilakukan melalui teori di dalam kelas, namun membutuhkan pembiasaan (amaliyah yaumiyah) yang konsisten.<br><br>Melalui modul Bina Pribadi Islami (BPI) dan Mutabaah Yaumiyah di SIT Robbani Ogan Ilir, siswa dibimbing untuk melatih kedisiplinan ibadah mandiri: Sholat Fardhu tepat waktu, Sholat Dhuha, Tahajud, Tilawah harian, hafalan ayat Al-Qur\'an, serta bakti kepada orang tua.'
            ]
        ];
    }

    private function getFacilityData()
    {
        return [
            [
                'title' => 'Ruang Kelas Nyaman Ber-AC',
                'desc' => 'Setiap ruang kelas di SIT Robbani Ogan Ilir dilengkapi dengan pendingin udara (AC), pencahayaan optimal, loker siswa, dan perlengkapan multimedia LCD proyektor.',
                'icon' => '❄️'
            ],
            [
                'title' => 'Masjid & Sarana Ibadah',
                'desc' => 'Pusat pembinaan karakter spiritual siswa untuk pelaksanaan sholat berjamaah, halaqah Tahfidz Al-Qur\'an, dan kegiatan Bina Pribadi Islami (BPI).',
                'icon' => '🕌'
            ],
            [
                'title' => 'Perpustakaan Digital & E-Library',
                'desc' => 'Fasilitas perpustakaan fisik dan digital (E-Library) dengan koleksi ribuan buku pelajaran, sains, keislaman, majalah anak, dan literasi umum.',
                'icon' => '📚'
            ],
            [
                'title' => 'Laboratorium Komputer & IT',
                'desc' => 'Sarana laboratorium komputer modern terintegrasi jaringan internet tinggi untuk pembelajaran literasi digital, koding, dan Asesmen Nasional (ANBK).',
                'icon' => '💻'
            ],
            [
                'title' => 'Playground & Arena Olahraga',
                'desc' => 'Fasilitas bermain anak usia dini (outdoor playground) dan lapangan olahraga serbaguna untuk olahraga futsal, basket, bulutangkis, dan panahan.',
                'icon' => '⚽'
            ],
            [
                'title' => 'Keamanan CCTV & Satpam 24 Jam',
                'desc' => 'Lingkungan sekolah dipantau sistem keamanan CCTV terpadu di setiap sudut dan petugas keamanan (security) siap siaga 24 jam demi kenyamanan peserta didik.',
                'icon' => '🛡️'
            ]
        ];
    }

    private function getVideoData()
    {
        return [
            [
                'title' => 'Profil Resmi SIT Robbani Ogan Ilir 2026',
                'category' => 'Profil Video',
                'duration' => '04:25',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => 'https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png',
                'desc' => 'Video sinematik profil Yayasan Generasi Robbani Sumatera Selatan dan 4 unit sekolah unggulan di Ogan Ilir.'
            ],
            [
                'title' => 'Haflah Akhirussanah & Wisuda Tahfidz Al-Qur’an 2026',
                'category' => 'Dokumentasi Acara',
                'duration' => '08:12',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/07/1000264778-1024x683.webp',
                'desc' => 'Suasana haru dan penuh kebanggaan saat prosesi wisuda tahfidz Al-Qur’an para siswa SIT Robbani.'
            ],
            [
                'title' => 'Ekosistem Digital ARSI & Pembelajaran LMS Robbani',
                'category' => 'Teknologi Digital',
                'duration' => '03:40',
                'youtube_id' => 'dQw4w9WgXcQ',
                'thumbnail' => 'https://sitrobbani.sch.id/wp-content/uploads/2026/07/image-1-1024x608.webp',
                'desc' => 'Kemudahan akses wali murid memantau presensi, SPP, dan E-Learning di SIT Robbani Ogan Ilir.'
            ]
        ];
    }

    private function getAgendaData()
    {
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
            ]
        ];
    }

    private function getAnnouncementData()
    {
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
            ]
        ];
    }
}
