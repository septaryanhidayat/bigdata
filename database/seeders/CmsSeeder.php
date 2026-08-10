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
            'school_name' => 'Sekolah Islam Terpadu Robbani',
            'tagline' => 'Sekolah Islam Terpadu Digital Platform',
            'hero_badge' => '✨ PLATFORM MANAGEMENT SEKOLAH ISLAM TERPADU',
            'hero_title' => 'Ekosistem Digital Sekolah Islam Terpadu #1 & Terlengkap',
            'hero_desc' => 'SmartEdu menyajikan 17 Modul Produk Digital Terpadu — mengintegrasikan Akademik Adaptif (K13, Merdeka & JSIT), Presensi RFID/QR, Keuangan SPP & COA Akuntansi, POS Kantin Cashless, hingga Mutaba\'ah Yaumiyah BPI & App Mobile Banking Warga Sekolah.',
            'bpi_badge' => '🕌 Bina Pribadi Islami (BPI)',
            'bpi_title' => 'Mutaba\'ah Yaumiyah & Al-Mathurat Digital',
            'bpi_desc' => 'Fitur khas Sekolah Islam Terpadu Robbani untuk mencatat amal ibadah harian siswa di rumah (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, & Infaq) dengan validasi PIN Orang Tua.',
        ];

        foreach ($settings as $key => $val) {
            SiteSetting::set($key, $val);
        }

        // FAQs
        $faqs = [
            [
                'question' => 'Apakah SmartEdu mendukung Kurikulum K13 dan Kurikulum Merdeka sekaligus?',
                'answer' => 'Ya! SmartEdu mendukung Multi-Kurikulum secara dinamis. Anda dapat mengaktifkan K13, Kurikulum Merdeka (dengan Proyek P5), kekhasan JSIT, maupun kurikulum kustom per tahun akademik.',
                'sort_order' => 1
            ],
            [
                'question' => 'Bagaimana cara kerja Absensi RFID & QR Code?',
                'answer' => 'Siswa & staf melakukan tap kartu RFID di terminal sekolah atau scan QR Code per sesi kelas dari portal guru. Data otomatis tercatat real-time.',
                'sort_order' => 2
            ],
            [
                'question' => 'Apakah modul Keuangan SPP terintegrasi ke Akuntansi?',
                'answer' => 'Sangat terintegrasi! Setiap transaksi pembayaran SPP kasir atau penagihan otomatis langsung menghasilkan Jurnal Otomatis, Buku Besar, Neraca, dan Laporan Arus Kas.',
                'sort_order' => 3
            ],
            [
                'question' => 'Bagaimana orang tua membatasi saldo belanja kantin anak?',
                'answer' => 'Orang tua mengatur limit belanja harian anak via Portal Ortu Mobile. Saat anak mengetap kartu di POS Kantin, sistem otomatis memverifikasi limit belanja.',
                'sort_order' => 4
            ],
            [
                'question' => 'Apakah sistem mendukung Multi-Sekolah untuk Yayasan?',
                'answer' => 'Ya, SmartEdu memiliki School Context Middleware sehingga Yayasan dapat mengelola banyak unit (TK, SD, SMP, SMA) dalam 1 instalasi terpadu.',
                'sort_order' => 5
            ]
        ];

        FaqItem::truncate();
        foreach ($faqs as $faq) {
            FaqItem::create($faq);
        }

        // 17 Feature Modules
        $modules = [
            [
                'title' => '1. Master Data & Referensi',
                'short_title' => 'Master Data',
                'category' => 'akademik',
                'category_name' => 'Akademik Base',
                'icon' => '🏛️',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'short_desc' => 'Fondasi Big Data Siakad Robbani untuk kelola multi-sekolah, struktur organisasi, siswa, guru & staff.',
                'full_desc' => 'Modul fondasi seluruh sistem Big Data Siakad Robbani. Mengelola multi-unit sekolah dalam 1 instalasi, profil sekolah lengkap, kurikulum dinamis K13/Merdeka/JSIT, tahun akademik, semester, biodata siswa, guru & karyawan non-guru.',
                'highlights' => [
                    "Fondasi data seluruh sistem Big Data Siakad Robbani",
                    "Multi-sekolah: profil sekolah & switch unit aktif yayasan",
                    "Kurikulum K13, Merdeka, kekhasan JSIT & kurikulum kustom",
                    "Tahun akademik dengan curriculum_code per periode",
                    "Semester, tingkat/jenjang, rombel & wali kelas assigned",
                    "Data siswa: biodata lengkap, orang tua, riwayat rombel, status aktif/lulus",
                    "Data guru & tenaga pendidik + portal login",
                    "Data karyawan non-guru (TU, cleaning service, security)",
                    "Referensi mapel, ruang & struktur organisasi sekolah"
                ],
                'sort_order' => 1
            ],
            [
                'title' => '2. Akademik & Penilaian',
                'short_title' => 'E-Rapor',
                'category' => 'akademik',
                'category_name' => 'Kurikulum & Rapor',
                'icon' => '📊',
                'badge_bg' => 'bg-blue-100 text-blue-800',
                'short_desc' => 'Manajemen kurikulum terbesar dengan K13, Merdeka, Proyek P5, RPP/Jurnal KBM, & E-Rapor PDF.',
                'full_desc' => 'Modul akademik terlengkap untuk menangani jadwal pelajaran mingguan bebas konflik, KOSP, RPP, penilaian dinamis per komponen K13 (KI/KD) & Merdeka (TP, formatif, sumatif, P5), rollup nilai otomatis, hingga cetak Rapor PDF resmi.',
                'highlights' => [
                    "Modul terlargest: K13, Merdeka, JSIT Rapor, jadwal mingguan",
                    "Dashboard akademik & kalender kegiatan sekolah",
                    "Jadwal mingguan dengan deteksi konflik ruang/guru otomatis",
                    "Analisis beban mengajar guru per minggu",
                    "KOSP (Standar Operasional Sekolah) & RPP pembelajaraan",
                    "Penilaian K13: KI/KD, bobot, KKM otomatis, predikat",
                    "Penilaian Merdeka: TP, formatif, sumatif, Proyek P5 & skor proyek",
                    "Rollup / agregasi nilai -> Rapor UTS & Semester PDF",
                    "Kenaikan kelas batch & kelulusan batch + sertifikat PDF"
                ],
                'sort_order' => 2
            ],
            [
                'title' => '3. Absensi RFID & QR Code',
                'short_title' => 'RFID Absensi',
                'category' => 'akademik',
                'category_name' => 'Presensi Realtime',
                'icon' => '🪪',
                'badge_bg' => 'bg-teal-100 text-teal-800',
                'short_desc' => 'Presensi siswa & staff dengan RFID card tap, scan QR sesi kelas, pengajuan izin, & real-time dashboard.',
                'full_desc' => 'Sistem absensi modern yang mendukung kartu RFID tap, scan QR code per sesi kelas oleh siswa via portal, pengajuan izin online dengan approval wali kelas, serta absensi guru/karyawan.',
                'highlights' => [
                    "Kehadiran siswa, guru & karyawan via RFID tap / QR code",
                    "Sesi kelas QR code unik - guru buka sesi, siswa scan via portal",
                    "Mark absensi, close session & absensi manual legacy backup",
                    "Pengajuan & persetujuan izin siswa via portal",
                    "RFID card management: register, simulate, revoke",
                    "Dashboard absensi real-time: % kehadiran hari ini",
                    "Self check-in absensi pribadi guru/karyawan",
                    "Laporan absensi PDF & CSV export per kelas/bulan"
                ],
                'sort_order' => 3
            ],
            [
                'title' => '4. Keuangan Sekolah & SPP',
                'short_title' => 'Bayar SPP',
                'category' => 'keuangan',
                'category_name' => 'Financial & SPP',
                'icon' => '💳',
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Penagihan SPP otomatis, kasir kwitansi PDF, COA Akuntansi, Buku Besar, Neraca & Arus Kas.',
                'full_desc' => 'Solusi finansial sekolah komprehensif. Menangani generate tagihan SPP bulanan otomatis, kasir pembayaran, diskon & beasiswa, reminder tunggakan, COA akuntansi, jurnal otomatis, neraca hingga arus kas.',
                'highlights' => [
                    "Penagihan SPP otomatis: generate, sync, waive, reminder bulanan",
                    "Kasir pembayaran: search siswa, bayar partial/full, void, kwitansi PDF",
                    "Piutang siswa & aging tunggakan follow-up TU",
                    "Chart of Accounts (COA) & Sub-COA akuntansi sekolah proper",
                    "Kas & bank multi-rekening, jurnal otomatis dari kasir & pengeluaran",
                    "Buku besar, neraca & laporan arus kas resmi",
                    "Syarat lunas SPP untuk penerbitan Kartu Ujian",
                    "Anggaran tahunan: rencana vs realisasi per kategori"
                ],
                'sort_order' => 4
            ],
            [
                'title' => '5. Tabungan Siswa',
                'short_title' => 'Tabungan',
                'category' => 'keuangan',
                'category_name' => 'Bank School',
                'icon' => '💰',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'short_desc' => 'Rekening tabungan per siswa, teller setor/tarik, setoran kolektif kelas, & approval orang tua.',
                'full_desc' => 'Modul perbankan internal sekolah. Mengelola rekening tabungan siswa terhubung ke data master, teller setor/tarik tunai, setoran kolektif massal per kelas, dan pengajuan penarikan via portal ortu.',
                'highlights' => [
                    "Rekening tabungan per siswa terhubung ke data master",
                    "Teller/kasir: setor tunai, tarik saldo, void, cetak kwitansi",
                    "Setoran kolektif: input massal per kelas efisien",
                    "Pengajuan penarikan: siswa/ortu ajukan, admin approve via portal",
                    "Program tabungan & enrollment target simpanan",
                    "Closing kas harian teller tabungan",
                    "Laporan saldo per siswa, mutasi, CSV & PDF export"
                ],
                'sort_order' => 5
            ],
            [
                'title' => '6. Kantin & POS Multi-Outlet',
                'short_title' => 'Kantin POS',
                'category' => 'keuangan',
                'category_name' => 'Point of Sale',
                'icon' => '🍱',
                'badge_bg' => 'bg-rose-100 text-rose-800',
                'short_desc' => 'POS Kantin tap kartu RFID, pre-order makanan, limit belanja harian diatur ortu, & komisi tenant.',
                'full_desc' => 'Sistem Point of Sale kantin sekolah tanpa uang tunai (cashless). Siswa belanja dengan mengetap kartu RFID, orang tua mengatur limit belanja harian via portal, dan pesanan makanan dapat di pre-order.',
                'highlights' => [
                    "POS Kantin: checkout tap kartu RFID siswa, void, cetak struk",
                    "Menu produk, kategori, harga & stok real-time (stock-in)",
                    "Multi-outlet / tenant kantin (settlement komisi otomatis)",
                    "Top-up saldo kantin via teller atau portal ortu",
                    "Pre-order pesanan makanan sebelum jam istirahat",
                    "Kebijakan limit belanja harian diatur ortu via portal"
                ],
                'sort_order' => 6
            ],
            [
                'title' => '7. Payroll & HRIS Pegawai',
                'short_title' => 'Payroll',
                'category' => 'operasional',
                'category_name' => 'Payroll & SDM',
                'icon' => '💵',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'short_desc' => 'Penggajian guru & staff, PPh21 & BPJS, lembur, kasbon cicilan, & slip gaji digital PDF.',
                'full_desc' => 'Sistem payroll otomatis sesuai kepangkatan/golongan pegawai. Menghitung gaji pokok, tunjangan, potongan PPh21 & BPJS, klaim lembur, kasbon, dan menerbitkan slip gaji PDF di portal pegawai.',
                'highlights' => [
                    "Periode gaji bulanan dengan tanggal cutoff configurable",
                    "Komponen gaji: gaji pokok, tunjangan, potongan PPh21 & BPJS",
                    "Golongan & grade pegawai dengan tabel gaji otomatis",
                    "Lembur: pengajuan pegawai, approval HRD & kalkulasi otomatis",
                    "Kasbon & pinjaman: cicilan otomatis memotong gaji",
                    "Generate payroll bulk, preview, approval & mark paid",
                    "Pembayaran massal: export rekening transfer bank",
                    "Slip gaji digital PDF (/my-payroll portal pegawai)"
                ],
                'sort_order' => 7
            ],
            [
                'title' => '8. Bimbingan Konseling (BK)',
                'short_title' => 'BK Online',
                'category' => 'akademik',
                'category_name' => 'Konseling & Poin',
                'icon' => '🤝',
                'badge_bg' => 'bg-sky-100 text-sky-800',
                'short_desc' => 'Rekam jejak konseling, master jenis pelanggaran & poin, booking sesi online, & home visit log.',
                'full_desc' => 'Modul BK terstruktur untuk memantau perkembangan karakter dan kedisiplinan siswa. Mencatat kasus pelanggaran dengan sistem poin/sanksi, booking sesi konseling online, dan dokumentasi home visit.',
                'highlights' => [
                    "Profil BK per siswa: riwayat konseling, pelanggaran & prestasi",
                    "Master jenis pelanggaran dengan poin & sanksi",
                    "Pendaftaran konseling: siswa booking via portal, guru BK confirm",
                    "Catatan sesi konseling confidential per kasus",
                    "Manajemen kasus: open, in-progress, resolved, referred",
                    "Monitoring siswa berisiko & dokumentasi foto Home Visit",
                    "Konseling orang tua terpisah & tes minat bakat"
                ],
                'sort_order' => 8
            ],
            [
                'title' => '9. Sarana & Prasarana',
                'short_title' => 'Aset & Gedung',
                'category' => 'operasional',
                'category_name' => 'Asset & Inventaris',
                'icon' => '🏫',
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Inventaris aset barcode, visual floor plan gedung/ruangan, peminjaman aset, & maintenance preventif.',
                'full_desc' => 'Pengelolaan aset dan fasilitas sekolah. Mencatat aset tetap dengan barcode & nilai penyusutan, visual floor plan gedung, barang habis pakai, peminjaman fasilitas, serta jadwal maintenance preventif.',
                'highlights' => [
                    "Gedung & ruangan dengan visual floor plan",
                    "Aset tetap: barcode unik, nilai perolehan, penyusutan",
                    "Barang habis pakai: stock in/out movement per ruang",
                    "Kendaraan sekolah: BPKB, service schedule, driver log",
                    "Peminjaman aset: request -> approve -> borrow -> return",
                    "Procurement / pengadaan barang dengan approval chain",
                    "Stock opname dengan scan barcode mobile-friendly",
                    "Jadwal maintenance preventif & reminder otomatis"
                ],
                'sort_order' => 9
            ],
            [
                'title' => '10. Perpustakaan Digital',
                'short_title' => 'E-Library',
                'category' => 'akademik',
                'category_name' => 'Literasi & E-Book',
                'icon' => '📖',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'short_desc' => 'Sirkulasi pinjam/kembali scan QR, katalog E-Book PDF, denda otomatis, & program literasi.',
                'full_desc' => 'Perpustakaan fisik dan digital terpadu. Memudahkan pencarian katalog buku via ISBN, sirkulasi pinjam/kembali berbasis QR Code, perhitungan denda otomatis, dan koleksi E-Book digital.',
                'highlights' => [
                    "Katalog buku dengan pencarian judul, pengarang, ISBN",
                    "Eksemplar per buku dengan barcode/QR unik",
                    "Sirkulasi: pinjam, kembali, perpanjang, denda keterlambatan otomatis",
                    "Reservasi buku yang sedang dipinjam siswa lain",
                    "Koleksi digital: upload E-Book PDF & baca via portal",
                    "Program literasi: target baca per semester & log ulasan",
                    "Kunjungan perpustakaan check-in/out statistik"
                ],
                'sort_order' => 10
            ],
            [
                'title' => '11. E-Learning & LMS',
                'short_title' => 'E-Learning',
                'category' => 'akademik',
                'category_name' => 'LMS & Online Class',
                'icon' => '📚',
                'badge_bg' => 'bg-indigo-100 text-indigo-800',
                'short_desc' => 'Kursus modul materi, tugas assignment, forum diskusi, live class Zoom/Meet, & sertifikat PDF.',
                'full_desc' => 'Platform E-Learning interaktif untuk pembelajaran hybrid. Menyediakan modul materi (PDF, Video, Embed), submisi tugas siswa, forum diskusi per kelas, integrasi sesi Zoom/Meet, dan auto sertifikat PDF.',
                'highlights' => [
                    "Kursus dengan thumbnail, deskripsi & enrollment per kelas",
                    "Modul & materi: PDF, video link, text & embed media",
                    "Assignment / tugas dengan deadline & submisi file siswa",
                    "Forum diskusi per kursus dengan thread, reply & moderasi",
                    "Live learning: jadwal Zoom / Google Meet & absensi live",
                    "Quiz e-learning: bank soal, random & passing grade",
                    "Progress tracking per siswa per modul & sertifikat PDF otomatis"
                ],
                'sort_order' => 11
            ],
            [
                'title' => '12. CBT (Computer Based Test)',
                'short_title' => 'CBT Ujian',
                'category' => 'akademik',
                'category_name' => 'Ujian Online CBT',
                'icon' => '💻',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'short_desc' => 'Ujian CBT bank soal multi-type, proctoring camera snapshot, anti tab-switch, & auto sync nilai.',
                'full_desc' => 'Sistem Ujian Komputer dengan standar keamanan tinggi. Mendukung bank soal pilihan ganda, benar/salah, essay, matching, deteksi kecurangan tab-switch, proctoring foto kamera, dan autosave jawaban tiap 30 detik.',
                'highlights' => [
                    "Bank soal: pilihan ganda, benar/salah, essay, matching",
                    "Multi bank soal per mata pelajaran & tingkat",
                    "Ujian CBT: jadwal, durasi, acak soal & opsi jawaban",
                    "Passing grade & ujian remedial otomatis",
                    "Keamanan: fullscreen mode, tab-switch detection, camera snapshot proctor",
                    "Autosave jawaban siswa setiap 30 detik",
                    "Koreksi essay manual oleh guru & auto sync ke Penilaian Akademik"
                ],
                'sort_order' => 12
            ],
            [
                'title' => '13. PPDB Online',
                'short_title' => 'PPDB Online',
                'category' => 'operasional',
                'category_name' => 'Penerimaan Siswa',
                'icon' => '📝',
                'badge_bg' => 'bg-pink-100 text-pink-800',
                'short_desc' => 'Penerimaan Siswa Baru wizard 5-langkah, upload dokumen, konfirmasi bayar, & transfer master data.',
                'full_desc' => 'Portal SPMB/PPDB publik end-to-end. Calon siswa mendaftar melalui wizard 5 langkah, mengunggah berkas syarat (Akta, KK, Ijazah), konfirmasi bukti bayar, dan jika diterima data otomatis masuk ke Master Siswa.',
                'highlights' => [
                    "Website publik /ppdb dengan desain ultra responsive",
                    "Admin CMS: kelola halaman, banner, jadwal & gelombang pendaftaran",
                    "Registrasi akun calon siswa dengan verifikasi email",
                    "Wizard 5 langkah: pribadi, ortu, sekolah asal, nilai & dokumen",
                    "Upload berkas: Akta, KK, Ijazah, Foto dengan validasi admin",
                    "Konfirmasi pembayaran: upload bukti transfer & verifikasi TU",
                    "Transfer pendaftar diterima -> data siswa master otomatis",
                    "Cetak formulir & Form SPMB PDF oleh orang tua"
                ],
                'sort_order' => 13
            ],
            [
                'title' => '14. Portal Siswa & Ortu Mobile',
                'short_title' => 'Portal Ortu',
                'category' => 'bpi',
                'category_name' => 'Self-Service Mobile',
                'icon' => '📱',
                'badge_bg' => 'bg-teal-100 text-teal-800',
                'short_desc' => 'Dashboard personal mobile-friendly, multi-anak switcher ortu, kwitansi PDF, & gamifikasi.',
                'full_desc' => 'Portal mandiri untuk warga sekolah. Memberikan kemudahan bagi orang tua untuk berpindah profil anak dalam 1 akun, melihat Rapor online, mengunduh kwitansi SPP, dan menerima notifikasi in-app.',
                'highlights' => [
                    "Beranda dashboard personal siswa & orang tua",
                    "Multi-anak untuk orang tua: switch profil anak dengan 1 akun",
                    "Rapor online & download kwitansi pembayaran PDF",
                    "Absensi: check-in/out, scan QR & pengajuan izin",
                    "Notifikasi in-app: tagihan, ujian, pengumuman & jadwal sholat",
                    "Mobile-friendly: akses lancar via browser HP tanpa install app",
                    "Gamifikasi Amal: pemberian badge digital ('Pejuang Subuh', dll)"
                ],
                'sort_order' => 14
            ],
            [
                'title' => '15. Mutaba\'ah BPI & Character',
                'short_title' => 'BPI Mutaba\'ah',
                'category' => 'bpi',
                'category_name' => 'Islamic Character',
                'icon' => '📿',
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Laporan amal ibadah harian, validasi digital PIN ortu, Al-Mathurat dzikir & API Waktu Sholat Kemenag.',
                'full_desc' => 'Modul Bina Pribadi Islami (BPI) khas SIT Robbani. Checklist ibadah harian anak di rumah yang diawasi orang tua via PIN digital, radar chart pencapaian karakter, modul Al-Mathurat dzikir, dan pengingat waktu sholat.',
                'highlights' => [
                    "Checklist digital ibadah: sholat wajib, rawatib, dhuha, tahajud, tilawah, hafalan",
                    "Validasi & Approval Orang Tua via tanda tangan digital / PIN",
                    "Dashboard BPI graphical: radar chart pencapaian amal per kelas/siswa",
                    "Fitur Dzikir & Do'a Digital: Al-Mathurat pagi-petang + counter tasbih",
                    "Integrasi API Jadwal Sholat Kemenag berbasis geolokasi sekolah",
                    "Countdown waktu ibadah di header portal (Siswa, Guru, Ortu)",
                    "Tracking Amal Jariyah / Infaq Harian terintegrasi ke Keuangan"
                ],
                'sort_order' => 15
            ],
            [
                'title' => '16. Sistem & Branding Context',
                'short_title' => 'System Admin',
                'category' => 'operasional',
                'category_name' => 'System Architecture',
                'icon' => '⚙️',
                'badge_bg' => 'bg-slate-200 text-slate-800',
                'short_desc' => '12+ Role bawaan granular, custom school branding (logo & warna), & multi-school context.',
                'full_desc' => 'Arsitektur keamanan dan identitas sekolah. Mendukung 12+ role pengguna bawaan (Admin, Guru, Bendahara, BK, dll) dengan hak akses granular per modul, custom branding logo/warna, dan audit log aktivitas.',
                'highlights' => [
                    "12+ Role bawaan siap pakai (Admin, Bendahara, Guru, BK, Wali Kelas, Ortu, Siswa, DLL)",
                    "Role & permission granular per modul dan tindakan aksi",
                    "Branding sekolah: logo, warna primary/dark/accent & nama aplikasi",
                    "Multi-sekolah dengan School Context Middleware",
                    "User management: CRUD akun, reset password, suspend",
                    "Audit log aktivitas penting untuk transparansi sistem"
                ],
                'sort_order' => 16
            ],
            [
                'title' => '17. HRIS & Pengembangan SDM',
                'short_title' => 'HRIS & SDM',
                'category' => 'operasional',
                'category_name' => 'SDM & E-Leave',
                'icon' => '👥',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'short_desc' => 'Pengajuan cuti E-Leave berjenjang, PKG KPI evaluasi kinerja guru, E-Recruitment, & klaim biaya.',
                'full_desc' => 'Manajemen Sumber Daya Manusia sekolah. Menangani pengajuan cuti (E-Leave), evaluasi kinerja guru (PKG KPI) berbasis rekap jurnal KBM, tracking pelamar kerja (E-Recruitment), dan klaim operasional.',
                'highlights' => [
                    "Cuti & Perizinan (E-Leave): pengajuan cuti berjenjang via portal",
                    "Saldo cuti terupdate otomatis & memotong komponen payroll",
                    "Manajemen Kinerja (KPI / PKG): evaluasi kinerja pegawai & jurnal KBM guru",
                    "Rekrutmen (E-Recruitment): tracking pelamar -> konversi pegawai baru",
                    "Klaim & Reimbursement operasional terintegrasi ke Bendahara"
                ],
                'sort_order' => 17
            ]
        ];

        FeatureModule::truncate();
        foreach ($modules as $mod) {
            FeatureModule::create($mod);
        }
    }
}
