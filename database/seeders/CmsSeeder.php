<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\FeatureModule;
use App\Models\FaqItem;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // Site Settings
        $settings = [
            'app_name' => 'SmartEdu',
            'edition_title' => 'SmartEdu',
            'school_name' => 'Sekolah Islam Terpadu Robbani',
            'tagline' => 'Platform Digital Sekolah Islam Terpadu',
            'hero_badge' => 'PLATFORM MANAJEMEN SEKOLAH ISLAM TERPADU',
            'hero_title' => 'Ekosistem Digital Sekolah Islam Terpadu Terpadu & Terlengkap',
            'hero_desc' => 'SmartEdu menyajikan 21 modul digital terpadu yang mengintegrasikan akademik adaptif K13, Kurikulum Merdeka, dan JSIT, presensi RFID/QR, keuangan SPP & akuntansi COA, POS kantin cashless, sistem anti-bullying, chatbot AI 24/7, tracer study alumni, hingga mutabaah yaumiyah BPI.',
            'bpi_badge' => 'Bina Pribadi Islami & SafeSchool',
            'bpi_title' => 'Mutabaah Yaumiyah, Al-Mathurat & Sistem Anti-Bullying',
            'bpi_desc' => 'Fitur khas Sekolah Islam Terpadu Robbani untuk pembentukan karakter siswa (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, dan Infaq) serta sistem perlindungan siswa SafeSchool dengan Panic Alarm darurat.',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }

        // FAQs
        $faqs = [
            [
                'question' => 'Apakah SmartEdu mendukung Kurikulum K13, Kurikulum Merdeka, dan Kekhasan JSIT?',
                'answer' => 'Ya, SmartEdu mendukung Multi-Kurikulum secara dinamis. Anda dapat mengaktifkan K13, Kurikulum Merdeka dengan Proyek P5, kekhasan JSIT, maupun kurikulum kustom per tahun akademik.',
                'sort_order' => 1
            ],
            [
                'question' => 'Bagaimana cara kerja Sistem Anti-Bullying dan Panic Alarm?',
                'answer' => 'Siswa dapat melaporkan insiden perundungan secara rahasia via portal. Dalam kondisi darurat, siswa atau guru dapat menekan tombol Panic Alarm yang langsung memicu sinyal sirene digital dan notifikasi lokasi ke HP Satgas Keamanan, Wali Kelas, dan Guru BK.',
                'sort_order' => 2
            ],
            [
                'question' => 'Bagaimana Chatbot AI Administrasi Sekolah membantu Orang Tua & Siswa?',
                'answer' => 'Chatbot AI aktif 24/7 via portal dan WhatsApp Gateway untuk menjawab pertanyaan seputar sisa tagihan SPP, rincian pembayaran, jadwal pelajaran, syarat PPDB, hingga rekomendasi buku perpustakaan secara otomatis.',
                'sort_order' => 3
            ],
            [
                'question' => 'Bagaimana pengelolaan Alumni & Ekstrakurikuler di SmartEdu?',
                'answer' => 'SmartEdu menyediakan modul Tracer Study Alumni untuk pelacakan lulusan di PTN dan dunia kerja serta legalisir ijazah online, dan Modul Ekstrakurikuler & Talenta Siswa untuk pendaftaran ekskul online, hall of fame prestasi, dan sertifikat digital.',
                'sort_order' => 4
            ],
            [
                'question' => 'Bagaimana cara kerja Absensi RFID & QR Code?',
                'answer' => 'Siswa dan staf melakukan tap kartu RFID di terminal sekolah atau scan QR Code per sesi kelas dari portal guru. Data otomatis tercatat real-time dan terintegrasi ke laporan kehadiran.',
                'sort_order' => 5
            ],
            [
                'question' => 'Apakah modul Keuangan SPP terintegrasi ke Akuntansi?',
                'answer' => 'Sangat terintegrasi. Setiap transaksi pembayaran SPP kasir atau penagihan otomatis langsung menghasilkan Jurnal Otomatis, Buku Besar, Neraca, dan Laporan Arus Kas resmi.',
                'sort_order' => 6
            ],
            [
                'question' => 'Apakah sistem mendukung Multi-Sekolah untuk Yayasan?',
                'answer' => 'Ya, SmartEdu memiliki School Context Middleware sehingga Yayasan dapat mengelola banyak unit sekolah seperti TK, SD, SMP, dan SMA dalam 1 instalasi terpadu.',
                'sort_order' => 7
            ]
        ];

        FaqItem::truncate();
        foreach ($faqs as $faq) {
            FaqItem::create($faq);
        }

        // 21 Feature Modules (Clean Text, No em-dashes, No AI buzzwords)
        $modules = [
            [
                'title' => '1. Master Data & Referensi',
                'short_title' => 'Master Data',
                'category' => 'akademik',
                'category_name' => 'Akademik Base',
                'icon' => '🏛️',
                'badge_bg' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'short_desc' => 'Fondasi data seluruh sistem Siakad Robbani untuk multi-sekolah, rombel, siswa, guru, dan karyawan.',
                'full_desc' => 'Modul fondasi seluruh sistem Siakad Robbani. Mengelola multi-unit sekolah dalam satu instalasi, profil sekolah lengkap, kurikulum dinamis K13/Merdeka/JSIT, tahun akademik, semester, biodata siswa, guru, dan karyawan non-guru.',
                'highlights' => [
                    "Fondasi data seluruh sistem Siakad Robbani",
                    "Multi-sekolah: kelola banyak unit sekolah yayasan dalam 1 instalasi dan switch sekolah aktif",
                    "Kurikulum K13, Merdeka, kekhasan JSIT, dan kurikulum kustom dengan komponen penilaian adaptif",
                    "Tahun akademik dengan semester, tanggal efektif, dan curriculum_code per periode",
                    "Tingkat/jenjang dan rombel/kelas dengan kapasitas dan wali kelas terdaftar",
                    "Data siswa: CRUD, biodata lengkap, orang tua, riwayat rombel, status aktif/lulus/keluar, import dan export",
                    "Data guru dan tenaga pendidik: mapel diampu, jadwal mengajar, dan akun login portal",
                    "Data karyawan non-guru: TU, cleaning service, security untuk absensi dan payroll",
                    "Kelola profil sekolah lengkap: nama, NPSN, alamat, kepala sekolah, logo, dan kontak",
                    "Referensi mata pelajaran, ruangan, dan struktur organisasi sekolah"
                ],
                'sort_order' => 1
            ],
            [
                'title' => '2. Akademik & Penilaian',
                'short_title' => 'E-Rapor',
                'category' => 'akademik',
                'category_name' => 'Kurikulum & Rapor',
                'icon' => '📊',
                'badge_bg' => 'bg-blue-50 text-blue-700 border border-blue-200',
                'short_desc' => 'Manajemen kurikulum K13, Merdeka, JSIT rapor, jadwal mingguan, RPP, Jurnal KBM, P5, dan Cetak Rapor PDF.',
                'full_desc' => 'Modul akademik terpadu untuk menangani jadwal pelajaran mingguan bebas konflik, KOSP, RPP, penilaian dinamis per komponen K13 (KI/KD) dan Merdeka (TP, formatif, sumatif, P5), rollup nilai otomatis, hingga cetak Rapor PDF resmi.',
                'highlights' => [
                    "Modul Kurikulum K13, Merdeka, JSIT rapor, dan jadwal pelajaran mingguan",
                    "Dashboard akademik: ringkasan jadwal, penilaian pending, rapor belum cetak, dan kalender kegiatan sekolah",
                    "Mata pelajaran per tingkat dengan bobot jam dan guru pengampu",
                    "Jadwal pelajaran mingguan dengan deteksi konflik ruang dan guru otomatis",
                    "Analisis beban mengajar guru: visualisasi jam mengajar per guru per minggu",
                    "KOSP (Standar Operasional Sekolah) dan Program pembelajaran",
                    "Penilaian K13: KI/KD, bobot, KKM otomatis, predikat mapel, pengetahuan dan keterampilan, sikap spiritual-sosial, penilaian diri, ekstrakurikuler, dan prestasi",
                    "Penilaian Merdeka: Tujuan Pembelajaran (TP), capaian kompetensi, penilaian formatif dan sumatif, Proyek P5, dan skor proyek per siswa",
                    "Agregasi nilai antar komponen dan semester ke Rapor UTS dan Semester adaptif PDF resmi",
                    "Kenaikan kelas batch dan Kelulusan batch dengan cetak sertifikat PDF",
                    "Jurnal KBM guru, RPP (Rencana Pelaksanaan Pembelajaran), bahan ajar, tugas, dan submisi siswa",
                    "PKL, kegiatan siswa, daftar ulang, dan perkembangan karakter"
                ],
                'sort_order' => 2
            ],
            [
                'title' => '3. Absensi RFID & QR Code',
                'short_title' => 'Presensi RFID',
                'category' => 'akademik',
                'category_name' => 'Presensi Realtime',
                'icon' => '🪪',
                'badge_bg' => 'bg-teal-50 text-teal-700 border border-teal-200',
                'short_desc' => 'Kehadiran siswa dan guru via RFID card tap, scan QR sesi kelas, pengajuan izin, dan dashboard real-time.',
                'full_desc' => 'Sistem absensi modern yang mendukung kartu RFID tap, scan QR code per sesi kelas oleh siswa via portal, pengajuan izin online dengan approval wali kelas/admin, serta absensi guru dan karyawan.',
                'highlights' => [
                    "Kehadiran siswa, guru, dan karyawan via RFID tap atau QR Code",
                    "Sesi kelas dengan QR code unik: guru buka sesi, siswa scan via portal",
                    "Mark absensi, close session, dan absensi manual legacy untuk backup",
                    "Pengajuan dan persetujuan izin siswa via portal dengan approval wali kelas atau admin",
                    "Laporan kehadiran per kelas atau bulan dengan export PDF dan CSV",
                    "Absensi guru dan karyawan: mark manual oleh admin atau self check-in pribadi",
                    "RFID card management: daftar kartu, simulasi tap, dan revoke",
                    "Pengaturan absensi: jam kerja, aturan, dan toleransi keterlambatan",
                    "Dashboard absensi admin dan real-time persentase kehadiran hari ini",
                    "Integrasi dengan modul akademik untuk kehadiran pada e-rapor"
                ],
                'sort_order' => 3
            ],
            [
                'title' => '4. Keuangan Sekolah & SPP',
                'short_title' => 'Keuangan SPP',
                'category' => 'keuangan',
                'category_name' => 'Financial & SPP',
                'icon' => '💳',
                'badge_bg' => 'bg-amber-50 text-amber-800 border border-amber-200',
                'short_desc' => 'Penagihan SPP otomatis, kasir kwitansi PDF, COA Akuntansi, Buku Besar, Neraca, dan Kartu Ujian.',
                'full_desc' => 'Solusi finansial sekolah komprehensif. Menangani generate tagihan SPP bulanan otomatis, kasir pembayaran partial/full, diskon dan beasiswa, reminder tunggakan, COA akuntansi, jurnal otomatis, neraca, hingga arus kas.',
                'highlights' => [
                    "Penagihan SPP otomatis: generate per bulan per siswa, sync tagihan jika ada perubahan biaya, pembebasan beasiswa, dan reminder tunggakan via TU",
                    "Dashboard keuangan real-time: total tagihan, pembayaran hari ini, piutang siswa, dan aging tunggakan",
                    "Kasir pembayaran: pencarian siswa, bayar partial/full, void transaksi, dan kwitansi PDF",
                    "Pengaturan jenis biaya SPP, diskon, dan beasiswa",
                    "Chart of Accounts (COA) dan Sub-COA untuk akuntansi sekolah",
                    "Kas dan bank multi-rekening, jurnal otomatis dari transaksi kasir dan pengeluaran",
                    "Buku besar, neraca, dan arus kas laporan keuangan resmi cetak PDF",
                    "Pengeluaran: kategori, approval, reject, bayar, dan Anggaran tahunan rencana vs realisasi",
                    "Pengaturan SPP dan Kartu Ujian sebagai syarat lunas SPP sebelum ujian"
                ],
                'sort_order' => 4
            ],
            [
                'title' => '5. Tabungan Siswa',
                'short_title' => 'Tabungan Siswa',
                'category' => 'keuangan',
                'category_name' => 'Bank School',
                'icon' => '💰',
                'badge_bg' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'short_desc' => 'Rekening tabungan per siswa, teller setor/tarik, setoran kolektif massal per kelas, dan approval ortu.',
                'full_desc' => 'Modul perbankan internal sekolah. Mengelola rekening tabungan siswa terhubung ke data master, teller setor/tarik tunai, setoran kolektif massal per kelas, pengajuan penarikan via portal ortu, dan closing kas harian.',
                'highlights' => [
                    "Rekening tabungan per siswa terhubung ke data master",
                    "Teller/kasir: setor tunai, tarik saldo, void, dan cetak kwitansi",
                    "Setoran kolektif massal per kelas untuk efisiensi program tabungan",
                    "Pengajuan penarikan: siswa/ortu ajukan via portal, admin approve, ortu konfirmasi via portal",
                    "Program tabungan dan enrollment per siswa dengan target simpanan",
                    "Closing kas harian teller tabungan",
                    "Dashboard tabungan siswa dan laporan saldo per siswa, mutasi, CSV dan PDF export",
                    "Portal: lihat saldo, ajukan penarikan, dan kwitansi"
                ],
                'sort_order' => 5
            ],
            [
                'title' => '6. Kantin & POS Multi-Outlet',
                'short_title' => 'POS Kantin',
                'category' => 'keuangan',
                'category_name' => 'Point of Sale',
                'icon' => '🍱',
                'badge_bg' => 'bg-rose-50 text-rose-700 border border-rose-200',
                'short_desc' => 'POS Kantin tap kartu RFID, pre-order pesanan, limit belanja harian diatur ortu, dan settlement komisi tenant.',
                'full_desc' => 'Sistem Point of Sale kantin sekolah tanpa uang tunai (cashless). Siswa belanja dengan mengetap kartu RFID, orang tua mengatur limit belanja harian via portal, pre-order makanan sebelum jam istirahat, dan settlement komisi tenant.',
                'highlights' => [
                    "POS Kantin: scan/tap kartu siswa, checkout, struk, dan void",
                    "Menu dan stok produk dengan kategori, harga, dan stok real-time",
                    "Multi-outlet/tenant kantin dengan settlement komisi otomatis",
                    "Top-up saldo kantin via teller atau portal dengan konfirmasi admin",
                    "Pre-order pesanan makanan sebelum jam istirahat tanpa antre dan paket menu harian",
                    "Purchase order dan supplier: receive dan hutang",
                    "Kebijakan limit belanja harian diatur orang tua via portal",
                    "Dashboard kantin dan laporan penjualan cetak",
                    "Portal ortu/siswa: lihat saldo, top-up, pre-order, dan limit belanja"
                ],
                'sort_order' => 6
            ],
            [
                'title' => '7. Payroll Pegawai',
                'short_title' => 'Payroll',
                'category' => 'operasional',
                'category_name' => 'Payroll & Gaji',
                'icon' => '💵',
                'badge_bg' => 'bg-purple-50 text-purple-700 border border-purple-200',
                'short_desc' => 'Gaji guru dan staf lengkap, PPh21 dan BPJS, lembur, kasbon cicilan otomatis, dan slip gaji digital PDF.',
                'full_desc' => 'Sistem payroll otomatis sesuai kepangkatan dan golongan pegawai. Menghitung gaji pokok, tunjangan, potongan PPh21 dan BPJS, klaim lembur, kasbon, dan menerbitkan slip gaji PDF di portal pegawai.',
                'highlights' => [
                    "Gaji guru dan staf lengkap dengan setup periode gaji bulanan dan tanggal cutoff",
                    "Komponen gaji: gaji pokok, tunjangan, dan potongan yang dapat dikonfigurasi",
                    "Golongan dan grade pegawai dengan tabel gaji otomatis",
                    "Profil pegawai: rekening bank, NPWP, dan komponen gaji terdaftar",
                    "Lembur: pengajuan pegawai, approval HRD, dan kalkulasi otomatis",
                    "Kasbon dan pinjaman: cicilan otomatis dipotong per periode gaji",
                    "Generate payroll: kalkulasi bulk, preview, approval, dan mark paid",
                    "Pembayaran gaji massal: export rekening untuk transfer bank",
                    "Slip gaji digital PDF email dan download per pegawai di portal",
                    "Laporan PPh21 dan BPJS untuk kepatuhan pajak",
                    "Portal pegawai: Slip Gaji Saya tanpa tanya HRD"
                ],
                'sort_order' => 7
            ],
            [
                'title' => '8. Bimbingan Konseling (BK)',
                'short_title' => 'BK Online',
                'category' => 'akademik',
                'category_name' => 'Konseling & Poin',
                'icon' => '🤝',
                'badge_bg' => 'bg-sky-50 text-sky-700 border border-sky-200',
                'short_desc' => 'Rekam jejak BK, master jenis pelanggaran dan poin, booking sesi online, dan home visit log.',
                'full_desc' => 'Modul BK terstruktur untuk memantau perkembangan karakter dan kedisiplinan siswa. Mencatat kasus pelanggaran dengan sistem poin/sanksi, booking sesi konseling online, dan dokumentasi home visit.',
                'highlights' => [
                    "Profil BK per siswa: riwayat konseling, pelanggaran, prestasi, dan rekam jejak",
                    "Master jenis pelanggaran dengan poin dan sanksi",
                    "Pendaftaran dan catatan sesi konseling rahasia per kasus",
                    "Manajemen kasus BK: open, in-progress, resolved, dan referred",
                    "Monitoring siswa berisiko dan Home visit dengan dokumentasi foto",
                    "Konseling orang tua terpisah dari sesi siswa",
                    "Bimbingan karier dan tes minat bakat siswa",
                    "Rujukan internal/eksternal, surat resmi BK, dan laporan BK cetak PDF",
                    "Portal: booking konseling online"
                ],
                'sort_order' => 8
            ],
            [
                'title' => '9. Sarana & Prasarana',
                'short_title' => 'Aset & Gedung',
                'category' => 'operasional',
                'category_name' => 'Asset & Inventaris',
                'icon' => '🏫',
                'badge_bg' => 'bg-amber-50 text-amber-800 border border-amber-200',
                'short_desc' => 'Inventaris aset barcode, visual floor plan gedung/ruangan, peminjaman aset, dan maintenance preventif.',
                'full_desc' => 'Pengelolaan aset dan fasilitas sekolah. Mencatat aset tetap dengan barcode dan nilai penyusutan, visual floor plan gedung, barang habis pakai, peminjaman fasilitas, serta jadwal maintenance preventif.',
                'highlights' => [
                    "Gedung dan ruangan dengan visual floor plan",
                    "Aset tetap: detail per item, barcode unik, nilai perolehan, dan penyusutan",
                    "Barang habis pakai: movement stock in/out per ruang",
                    "Kendaraan sekolah: BPKB, service schedule, dan driver log",
                    "Peminjaman aset/fasilitas: request, approve, borrow, dan return",
                    "Procurement/pengadaan barang dengan approval chain",
                    "Mutasi antar lokasi dan serah terima terdokumentasi",
                    "Stock opname dengan scan barcode mobile-friendly",
                    "Penghapusan aset dengan approval dan maintenance korektif/preventif"
                ],
                'sort_order' => 9
            ],
            [
                'title' => '10. Perpustakaan Digital',
                'short_title' => 'E-Library',
                'category' => 'akademik',
                'category_name' => 'Literasi & E-Book',
                'icon' => '📖',
                'badge_bg' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'short_desc' => 'Sirkulasi pinjam/kembali scan QR, katalog E-Book PDF, denda otomatis, dan program literasi.',
                'full_desc' => 'Perpustakaan fisik dan digital terpadu. Memudahkan pencarian katalog buku via ISBN, sirkulasi pinjam/kembali berbasis QR Code, perhitungan denda otomatis, dan koleksi E-Book digital.',
                'highlights' => [
                    "Katalog buku dengan pencarian judul, pengarang, ISBN, dan rak buku",
                    "Eksemplar per buku dengan barcode atau QR unik",
                    "Sirkulasi: pinjam, kembali, perpanjang, dan denda keterlambatan otomatis",
                    "Reservasi buku yang sedang dipinjam siswa lain",
                    "Kunjungan perpustakaan: check-in/out untuk statistik",
                    "Koleksi digital: upload E-Book PDF dan baca via portal",
                    "Program literasi dan gemar membaca: target baca per semester dan ulasan buku",
                    "Dashboard dan laporan sirkulasi cetak"
                ],
                'sort_order' => 10
            ],
            [
                'title' => '11. E-Learning & LMS',
                'short_title' => 'E-Learning',
                'category' => 'akademik',
                'category_name' => 'LMS & Online Class',
                'icon' => '📚',
                'badge_bg' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                'short_desc' => 'Kursus modul materi, tugas assignment, forum diskusi, live class Zoom/Meet, dan sertifikat PDF.',
                'full_desc' => 'Platform E-Learning interaktif untuk pembelajaran hybrid. Menyediakan modul materi (PDF, Video, Embed), submisi tugas siswa, forum diskusi per kelas, integrasi sesi Zoom/Meet, dan auto sertifikat PDF.',
                'highlights' => [
                    "Kursus dengan thumbnail, deskripsi, dan enrollment per kelas",
                    "Modul dan materi: PDF, video link, text, dan embed media",
                    "Assignment/tugas dengan deadline dan submisi file siswa",
                    "Forum diskusi per kursus: thread, reply, lock, hide, dan moderasi",
                    "Live learning: jadwal Zoom / Google Meet dan absensi live",
                    "Quiz e-learning: bank soal, acak soal, dan passing grade",
                    "Progress tracking per siswa per modul dan sertifikat PDF otomatis",
                    "Portal siswa: daftar kursus, selesaikan materi, submisi tugas, dan quiz online"
                ],
                'sort_order' => 11
            ],
            [
                'title' => '12. CBT (Computer Based Test)',
                'short_title' => 'CBT Ujian',
                'category' => 'akademik',
                'category_name' => 'Ujian Online CBT',
                'icon' => '💻',
                'badge_bg' => 'bg-purple-50 text-purple-700 border border-purple-200',
                'short_desc' => 'Ujian CBT bank soal multi-type, proctoring camera snapshot, anti tab-switch, dan auto sync nilai.',
                'full_desc' => 'Sistem Ujian Komputer dengan standar keamanan tinggi. Mendukung bank soal pilihan ganda, benar/salah, essay, matching, deteksi kecurangan tab-switch, proctoring foto kamera, dan autosave jawaban tiap 30 detik.',
                'highlights' => [
                    "Bank soal: pilihan ganda, benar/salah, essay, dan matching",
                    "Ujian CBT: jadwal, durasi, acak soal, dan opsi jawaban",
                    "Passing grade dan ujian remedial otomatis",
                    "Keamanan: mode fullscreen, tab-switch detection, dan camera snapshot proctor",
                    "Autosave jawaban siswa setiap 30 detik",
                    "Koreksi essay manual oleh guru",
                    "Sinkronisasi nilai ke penilaian akademik otomatis dan laporan export hasil ujian",
                    "Portal: daftar ujian, autosave jawaban, dan hasil"
                ],
                'sort_order' => 12
            ],
            [
                'title' => '13. PPDB Online',
                'short_title' => 'PPDB Online',
                'category' => 'operasional',
                'category_name' => 'Penerimaan Siswa',
                'icon' => '📝',
                'badge_bg' => 'bg-pink-50 text-pink-700 border border-pink-200',
                'short_desc' => 'Penerimaan Siswa Baru wizard 5-langkah, upload dokumen, konfirmasi bayar, dan transfer master data.',
                'full_desc' => 'Portal SPMB/PPDB publik end-to-end. Calon siswa mendaftar melalui wizard 5 langkah, mengunggah berkas syarat (Akta, KK, Ijazah), konfirmasi bukti bayar, dan jika diterima data otomatis masuk ke Master Siswa.',
                'highlights' => [
                    "Website publik /ppdb dengan desain responsive",
                    "Landing page PPDB publik dan Admin CMS untuk halaman, banner, FAQ, biaya, dan jadwal",
                    "Registrasi akun calon siswa dengan verifikasi email",
                    "Wizard 5 langkah: pribadi, orang tua, sekolah asal, nilai, dan dokumen",
                    "Upload dokumen: Akta, KK, Ijazah, dan Foto dengan validasi admin",
                    "Konfirmasi pembayaran: upload bukti transfer dan verifikasi TU",
                    "Pengaturan gelombang pendaftaran dengan kuota dan tanggal berbeda",
                    "Transfer pendaftar diterima langsung ke data siswa master",
                    "Download isian Form SPMB oleh wali siswa dalam bentuk PDF"
                ],
                'sort_order' => 13
            ],
            [
                'title' => '14. Portal Siswa & Ortu Mobile',
                'short_title' => 'Portal Ortu',
                'category' => 'bpi',
                'category_name' => 'Self-Service Mobile',
                'icon' => '📱',
                'badge_bg' => 'bg-teal-50 text-teal-700 border border-teal-200',
                'short_desc' => 'Dashboard personal mobile-friendly, multi-anak switcher ortu, kwitansi PDF, dan gamifikasi.',
                'full_desc' => 'Portal mandiri untuk warga sekolah. Memberikan kemudahan bagi orang tua untuk berpindah profil anak dalam 1 akun, melihat Rapor online, mengunduh kwitansi SPP, dan menerima notifikasi in-app.',
                'highlights' => [
                    "Self-service warga sekolah: Beranda dashboard personal",
                    "Nilai dan rapor online serta download kwitansi pembayaran PDF",
                    "Absensi: check-in/out, QR code, pengajuan izin, dan riwayat",
                    "E-Learning dan CBT terintegrasi",
                    "Tagihan dan riwayat pembayaran, Tabungan, Kantin, Konseling BK, dan Perpustakaan",
                    "Multi-anak untuk orang tua: switch profil anak dengan 1 akun",
                    "Slip gaji pegawai self-service untuk wali siswa yang juga pegawai",
                    "Notifikasi in-app: tagihan, ujian, pengumuman, dan tampilan mobile-friendly",
                    "Gamifikasi Amal: Pemberian badge digital Pejuang Subuh bagi siswa disiplin",
                    "Widget dan Notifikasi Islami: Kutipan hadits harian dan pengingat waktu ibadah"
                ],
                'sort_order' => 14
            ],
            [
                'title' => '15. Mutaba\'ah BPI & Character',
                'short_title' => 'BPI Mutaba\'ah',
                'category' => 'bpi',
                'category_name' => 'Bina Pribadi Islami',
                'icon' => '🕌',
                'badge_bg' => 'bg-amber-50 text-amber-800 border border-amber-200',
                'short_desc' => 'Laporan amal ibadah harian, validasi digital PIN ortu, Al-Mathurat dzikir, dan API Waktu Sholat Kemenag.',
                'full_desc' => 'Modul Bina Pribadi Islami (BPI) khas SIT Robbani. Checklist ibadah harian anak di rumah yang diawasi orang tua via PIN digital, radar chart pencapaian karakter, modul Al-Mathurat dzikir, dan pengingat waktu sholat.',
                'highlights' => [
                    "Laporan Amal Ibadah Harian: Checklist digital pelaksanaan sholat wajib, rawatib, dhuha, tahajud, tilawah, hafalan ziyadah, puasa sunnah, dan infaq harian",
                    "Validasi dan Approval Orang Tua via tanda tangan digital atau PIN di Portal Ortu",
                    "Dashboard BPI Graphical: Visualisasi radar chart pencapaian amal per siswa dan kelas",
                    "Fitur Dzikir dan Doa Digital: Modul Al-Mathurat pagi dan petang interaktif dengan terjemahan dan tasbih virtual",
                    "Pengingat Sholat dan Imsakiyah: Integrasi API Kemenag berbasis geolokasi sekolah",
                    "Amal Jariyah dan Infaq Harian: Tracking donasi siswa terintegrasi ke Keuangan"
                ],
                'sort_order' => 15
            ],
            [
                'title' => '16. Sistem & Branding Context',
                'short_title' => 'System Admin',
                'category' => 'operasional',
                'category_name' => 'System Architecture',
                'icon' => '⚙️',
                'badge_bg' => 'bg-slate-100 text-slate-700 border border-slate-200',
                'short_desc' => '12+ Role bawaan granular, custom school branding logo dan warna, serta multi-school context.',
                'full_desc' => 'Arsitektur keamanan dan identitas sekolah. Mendukung 12+ role pengguna bawaan (Admin, Guru, Bendahara, BK, dll) dengan hak akses granular per modul, custom branding logo/warna, dan audit log aktivitas.',
                'highlights' => [
                    "Pengaturan pengguna, role, dan multi-sekolah dengan School Context Middleware",
                    "Branding: nama sekolah, aplikasi, tagline, upload logo sekolah, dan warna tema",
                    "Manajemen akun pengguna: CRUD akun, reset password, dan suspend",
                    "Role dan permission granular per modul dan tindakan aksi",
                    "12+ Role bawaan siap pakai (Admin, Bendahara, Guru, BK, Wali Kelas, Ortu, Siswa, Karyawan) serta custom role",
                    "Dashboard admin quick menu modul dan role-based home redirect",
                    "Audit log aktivitas penting sistem",
                    "Profil pengguna: ganti password, foto, dan kontak"
                ],
                'sort_order' => 16
            ],
            [
                'title' => '17. HRIS & Pengembangan SDM',
                'short_title' => 'HRIS & SDM',
                'category' => 'operasional',
                'category_name' => 'HRIS & E-Leave',
                'icon' => '👥',
                'badge_bg' => 'bg-purple-50 text-purple-700 border border-purple-200',
                'short_desc' => 'Cuti E-Leave berjenjang, PKG KPI evaluasi kinerja guru, E-Recruitment pelamar, dan klaim biaya.',
                'full_desc' => 'Manajemen Sumber Daya Manusia sekolah. Menangani pengajuan cuti (E-Leave), evaluasi kinerja guru (PKG KPI) berbasis rekap jurnal KBM, tracking pelamar kerja (E-Recruitment), dan klaim operasional.',
                'highlights' => [
                    "Cuti dan Perizinan (E-Leave): Pengajuan cuti berjenjang via portal yang memotong saldo cuti dan payroll",
                    "Manajemen Kinerja (KPI): Evaluasi kinerja pegawai (PKG) dan rekap jurnal KBM guru",
                    "Rekrutmen (E-Recruitment): Tracking pelamar kerja, jadwal wawancara, dan konversi ke pegawai baru",
                    "Klaim dan Reimbursement: Pengajuan dana operasional pegawai terintegrasi ke Bendahara"
                ],
                'sort_order' => 17
            ],
            [
                'title' => '18. Anti-Bullying System & Panic Alarm',
                'short_title' => 'Anti-Bullying',
                'category' => 'bpi',
                'category_name' => 'Keamanan & SafeSchool',
                'icon' => '🚨',
                'badge_bg' => 'bg-rose-50 text-rose-700 border border-rose-200',
                'short_desc' => 'Pelaporan perundungan rahasia/anonim, Panic Alarm darurat siswa ke Satgas, dan pendampingan konseling BK.',
                'full_desc' => 'Sistem Perlindungan Siswa SafeSchool & Anti-Perundungan Terpadu. Siswa dapat melaporkan insiden perundungan secara rahasia/anonim, fitur Panic Alarm darurat dengan geolokasi posisi kelas/ruang, penanganan oleh Satgas Anti-Bullying & Guru BK, serta konseling trauma healing.',
                'highlights' => [
                    "Tombol Panic Alarm Darurat: Siswa dan guru menekan alarm darurat real-time dengan lokasi kelas/ruang ke HP Satgas Keamanan dan BK",
                    "Lapor Perundungan Anonim dan Terbuka: Form laporan rahasia dengan bukti lampiran foto, video, atau kronologi insiden",
                    "Manajemen Kasus Anti-Bullying: Alur penanganan terstruktur dari Laporan, Investigasi, Mediasi, Pendampingan BK, hingga Selesai",
                    "Tim Satgas Anti-Bullying Sekolah: Dashboard pemantauan dan tanggap cepat insiden keamanan lingkungan sekolah",
                    "Notifikasi Real-Time dan Sirene Digital: Peringatan otomatis ke Guru BK, Wali Kelas, Kepala Sekolah, dan Keamanan",
                    "Konseling dan Trauma Healing: Pendampingan psikologis terstruktur untuk korban dan pembinaan edukatif untuk pelaku",
                    "Survei Iklim Keamanan Sekolah: Evaluasi rutin tingkat kenyamanan dan keamanan siswa secara berkala"
                ],
                'sort_order' => 18
            ],
            [
                'title' => '19. Chatbot AI Administrasi Sekolah',
                'short_title' => 'Chatbot AI',
                'category' => 'operasional',
                'category_name' => 'AI & Service Chatbot',
                'icon' => '🤖',
                'badge_bg' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                'short_desc' => 'Asisten Virtual AI 24/7 untuk informasi SPP, tagihan, jadwal pelajaran, syarat PPDB, dan AI Tutor siswa.',
                'full_desc' => 'Layanan Asisten Virtual Berbasis Artificial Intelligence 24/7. Membantu orang tua dan siswa menjawab pertanyaan seputar tagihan SPP, rincian biaya, jadwal pelajaran, syarat pendaftaran PPDB, pengumuman sekolah, hingga AI Tutor bantuan belajar siswa via portal & WhatsApp Gateway.',
                'highlights' => [
                    "Asisten Virtual AI 24/7: Menjawab otomatis pertanyaan wali murid seputar informasi dan administrasi sekolah tanpa antre",
                    "Integrasi Cek Tagihan dan SPP: Orang tua bertanya rincian tagihan SPP anak dan AI menyajikan data instan",
                    "Layanan Informasi PPDB Otomatis: Panduan syarat pendaftaran, rincian gelombang biaya, dan jadwal seleksi calon siswa",
                    "AI Tutor dan Bantuan Belajar Siswa: Menjawab pertanyaan materi pelajaran dan rekomendasi e-book perpustakaan",
                    "Omnichannel Gateway: Terhubung langsung ke WhatsApp resmi sekolah dan portal website",
                    "Knowledge Base Management CMS: Sekolah dapat memperbarui dan menambah basis data informasi AI dengan mudah",
                    "Analitik Pertanyaan Populer: Insight tren pertanyaan wali murid untuk evaluasi kualitas pelayanan sekolah"
                ],
                'sort_order' => 19
            ],
            [
                'title' => '20. Alumni & Tracer Study Network',
                'short_title' => 'Alumni Network',
                'category' => 'operasional',
                'category_name' => 'Alumni & Tracer Study',
                'icon' => '🎓',
                'badge_bg' => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                'short_desc' => 'Database alumni terpadu, tracer study PTN/dunia kerja, legalisir e-ijazah online, dan wakaf alumni.',
                'full_desc' => 'Sistem Pengelolaan Alumni & Tracer Study Sekolah. Membantu sekolah memantau sebaran alumni di Perguruan Tinggi Negeri (PTN) / Perguruan Tinggi Luar Negeri, melacak rekam karir, memfasilitasi jejaring beasiswa, penggalangan dana wakaf & infaq alumni, serta legalisir e-ijazah digital online.',
                'highlights' => [
                    "Database Alumni Terpadu: Direktori angkatan alumni dari jenjang TK, SD, SMP hingga SMA",
                    "Tracer Study PTN dan Kedinasan: Pelacakan otomatis sebaran alumni di PTN favorit, Universitas luar negeri, dan karir profesional",
                    "Portal Alumni Self-Service: Alumni update data profil mandiri, riwayat kuliah lanjutan, dan pekerjaan",
                    "Legalisir E-Ijazah dan Transkrip Online: Pengajuan legalisir sertifikat digital terverifikasi QR Code tanpa antre",
                    "Program Wakaf dan Infaq Alumni: Penggalangan beasiswa adik kelas dan fasilitas sarana prasarana almamater",
                    "Jejaring Mentoring Karir dan UTBK: Sinergi alumni berbagi pengalaman persiapan kelulusan dan seleksi masuk PTN"
                ],
                'sort_order' => 20
            ],
            [
                'title' => '21. Ekstrakurikuler & Talenta Siswa',
                'short_title' => 'Ekskul & Talenta',
                'category' => 'akademik',
                'category_name' => 'Ekskul & Prestasi',
                'icon' => '🏆',
                'badge_bg' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'short_desc' => 'Pendaftaran ekskul online, absensi & jurnal pembina, hall of fame prestasi, dan sertifikat digital.',
                'full_desc' => 'Modul Pengelolaan Ekstrakurikuler, Klub Bakat & Portofolio Prestasi Siswa. Memfasilitasi pendaftaran ekskul online, jadwal & absensi latihan, jurnal pembina, portofolio digital kejuaraan/prestasi (Pramuka, Tahfidz, Robotik, Olahraga, Sains), serta integrasi nilai deskriptif ke E-Rapor.',
                'highlights' => [
                    "Pendaftaran Ekskul Online: Siswa memilih klub ekstrakurikuler dan minat bakat mandiri via portal",
                    "Manajemen Pembina dan Absensi Ekskul: Jadwal latihan, absensi keikutsertaan, dan jurnal pembina kegiatan",
                    "Hall of Fame dan Etalase Prestasi: Portofolio digital piala dan piagam kejuaraan Kabupaten, Nasional, dan Internasional",
                    "Sertifikat Digital Prestasi: Penerbitan sertifikat resmi penghargaan kegiatan ekskul ber-QR Code",
                    "Integrasi Nilai Ekskul ke E-Rapor: Form penilaan deskriptif pembina terhubung langsung ke Rapor siswa",
                    "Peta Talenta Siswa: Pemetaan minat bakat akademik dan non-akademik siswa sejak dini"
                ],
                'sort_order' => 21
            ]
        ];

        FeatureModule::truncate();
        foreach ($modules as $mod) {
            FeatureModule::create($mod);
        }
    }
}
