-- =======================================================
-- SmartEdu School Management System - MySQL Database Dump
-- Generated: 2026-08-10 13:18:52
-- Compatible with MySQL 5.7+ / MySQL 8.0+ / MariaDB
-- =======================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator SmartEdu', 'admin@smartedu.test', NULL, '$2y$12$8lKBaBnD8A5iRXSK3SATCuiERMXTpTRhpU1jQZ7uhA/vkr0YQiZYi', 'D4JnWdmWtAcjNTGO2E0rbakpmpOVSYV5fqGkagJE7JWh5SKxboM6uP7VZwpe', '2026-08-10 12:49:01', '2026-08-10 12:49:01');

-- --------------------------------------------------------
-- Table structure for `site_settings`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `site_settings`
INSERT INTO `site_settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('app_name', 'SmartEdu', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('edition_title', 'SmartEdu', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('school_name', 'Sekolah Islam Terpadu Robbani', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('tagline', 'Platform Digital Sekolah Islam Terpadu', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('hero_badge', 'PLATFORM MANAJEMEN SEKOLAH ISLAM TERPADU', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu & Terlengkap', '2026-08-10 12:49:01', '2026-08-10 13:14:46'),
('hero_desc', 'SmartEdu menyajikan 21 modul digital terpadu yang mengintegrasikan akademik adaptif K13, Kurikulum Merdeka, dan JSIT, presensi RFID/QR, keuangan SPP & akuntansi COA, POS kantin cashless, sistem anti-bullying, chatbot AI 24/7, tracer study alumni, hingga mutabaah yaumiyah BPI.', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('bpi_badge', 'Bina Pribadi Islami & SafeSchool', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('bpi_title', 'Mutabaah Yaumiyah, Al-Mathurat & Sistem Anti-Bullying', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani untuk pembentukan karakter siswa (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, dan Infaq) serta sistem perlindungan siswa SafeSchool dengan Panic Alarm darurat.', '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
('show_sales_section', '0', '2026-08-10 13:02:12', '2026-08-10 13:05:58'),
('sales_title', 'Pilihan Paket Investasi & Lisensi SmartEdu', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('sales_badge', 'Penawaran Spesial & Lisensi', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('sales_desc', 'Pilih paket sesuai kebutuhan sekolah, yayasan, atau bisnis Anda. Tanpa biaya sewa bulanan, cukup sekali bayar untuk lisensi selamanya.', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg1_title', 'Paket Source Code', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg1_price', 'Rp 1.500.000', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg1_desc', 'Cocok untuk tim IT sekolah atau pengembang yang ingin mendeploy sendiri.', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg1_features', 'Full Source Code Laravel 13 & SQLite/MySQL
21 Modul Digital Terpadu Siap Pakai
Fitur SafeSchool Anti-Bullying & SmartBot AI
Dokumentasi Kode & Panduan Setup DB
Hak Milik Selamanya (Tanpa Biaya Bulanan)', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg2_title', 'Paket Server + Reseller', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg2_price', 'Rp 3.000.000', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg2_badge', '🔥 BEST SELLER & RESELLER READY', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg2_desc', 'Solusi lengkap siap pakai untuk sekolah + lisensi hak jual kembali!', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg2_features', 'Semua Fitur Paket Source Code 1,5 Juta
FREE Setup & Deploy Server VPS/Cloud Sampai Live
Paket Hak Jual Kembali / Reseller Affiliate (Profit 100%)
Custom Branding Logo & Nama Sekolah Anda
Support Priority WhatsApp Direct 24/7
Free Update Patch & Bug Fix 1 Tahun', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg3_title', 'Paket Enterprise Yayasan', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg3_price', 'Rp 5.500.000', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg3_desc', 'Didesain khusus untuk yayasan dengan banyak unit/cabang sekolah.', '2026-08-10 13:02:12', '2026-08-10 13:02:12'),
('pkg3_features', 'Semua Fitur Paket 3 Juta Complete
Gratis Domain .sch.id Selama 1 Tahun
Lisensi Multi-Sekolah / Cabang Yayasan
Training Pembekalan Zoom untuk Admin & Guru (1 Bulan)
Maintenance Server & Backup Data Otomatis
Request Penyesuaian Modul Fitur Custom', '2026-08-10 13:02:12', '2026-08-10 13:02:12');

-- --------------------------------------------------------
-- Table structure for `feature_modules`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `feature_modules`;
CREATE TABLE `feature_modules` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT '🏛️',
  `badge_bg` varchar(255) NOT NULL DEFAULT 'bg-emerald-100 text-emerald-800',
  `short_desc` text NOT NULL,
  `full_desc` text NOT NULL,
  `highlights` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`highlights`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `feature_modules`
INSERT INTO `feature_modules` (`id`, `title`, `short_title`, `category`, `category_name`, `icon`, `badge_bg`, `short_desc`, `full_desc`, `highlights`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, '1. Master Data & Referensi', 'Master Data', 'akademik', 'Akademik Base', '🏛️', 'bg-emerald-50 text-emerald-700 border border-emerald-200', 'Fondasi data seluruh sistem Siakad Robbani untuk multi-sekolah, rombel, siswa, guru, dan karyawan.', 'Modul fondasi seluruh sistem Siakad Robbani. Mengelola multi-unit sekolah dalam satu instalasi, profil sekolah lengkap, kurikulum dinamis K13/Merdeka/JSIT, tahun akademik, semester, biodata siswa, guru, dan karyawan non-guru.', '[\"Fondasi data seluruh sistem Siakad Robbani\",\"Multi-sekolah: kelola banyak unit sekolah yayasan dalam 1 instalasi dan switch sekolah aktif\",\"Kurikulum K13, Merdeka, kekhasan JSIT, dan kurikulum kustom dengan komponen penilaian adaptif\",\"Tahun akademik dengan semester, tanggal efektif, dan curriculum_code per periode\",\"Tingkat\\/jenjang dan rombel\\/kelas dengan kapasitas dan wali kelas terdaftar\",\"Data siswa: CRUD, biodata lengkap, orang tua, riwayat rombel, status aktif\\/lulus\\/keluar, import dan export\",\"Data guru dan tenaga pendidik: mapel diampu, jadwal mengajar, dan akun login portal\",\"Data karyawan non-guru: TU, cleaning service, security untuk absensi dan payroll\",\"Kelola profil sekolah lengkap: nama, NPSN, alamat, kepala sekolah, logo, dan kontak\",\"Referensi mata pelajaran, ruangan, dan struktur organisasi sekolah\"]', 1, 1, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(2, '2. Akademik & Penilaian', 'E-Rapor', 'akademik', 'Kurikulum & Rapor', '📊', 'bg-blue-50 text-blue-700 border border-blue-200', 'Manajemen kurikulum K13, Merdeka, JSIT rapor, jadwal mingguan, RPP, Jurnal KBM, P5, dan Cetak Rapor PDF.', 'Modul akademik terpadu untuk menangani jadwal pelajaran mingguan bebas konflik, KOSP, RPP, penilaian dinamis per komponen K13 (KI/KD) dan Merdeka (TP, formatif, sumatif, P5), rollup nilai otomatis, hingga cetak Rapor PDF resmi.', '[\"Modul Kurikulum K13, Merdeka, JSIT rapor, dan jadwal pelajaran mingguan\",\"Dashboard akademik: ringkasan jadwal, penilaian pending, rapor belum cetak, dan kalender kegiatan sekolah\",\"Mata pelajaran per tingkat dengan bobot jam dan guru pengampu\",\"Jadwal pelajaran mingguan dengan deteksi konflik ruang dan guru otomatis\",\"Analisis beban mengajar guru: visualisasi jam mengajar per guru per minggu\",\"KOSP (Standar Operasional Sekolah) dan Program pembelajaran\",\"Penilaian K13: KI\\/KD, bobot, KKM otomatis, predikat mapel, pengetahuan dan keterampilan, sikap spiritual-sosial, penilaian diri, ekstrakurikuler, dan prestasi\",\"Penilaian Merdeka: Tujuan Pembelajaran (TP), capaian kompetensi, penilaian formatif dan sumatif, Proyek P5, dan skor proyek per siswa\",\"Agregasi nilai antar komponen dan semester ke Rapor UTS dan Semester adaptif PDF resmi\",\"Kenaikan kelas batch dan Kelulusan batch dengan cetak sertifikat PDF\",\"Jurnal KBM guru, RPP (Rencana Pelaksanaan Pembelajaran), bahan ajar, tugas, dan submisi siswa\",\"PKL, kegiatan siswa, daftar ulang, dan perkembangan karakter\"]', 1, 2, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(3, '3. Absensi RFID & QR Code', 'Presensi RFID', 'akademik', 'Presensi Realtime', '🪪', 'bg-teal-50 text-teal-700 border border-teal-200', 'Kehadiran siswa dan guru via RFID card tap, scan QR sesi kelas, pengajuan izin, dan dashboard real-time.', 'Sistem absensi modern yang mendukung kartu RFID tap, scan QR code per sesi kelas oleh siswa via portal, pengajuan izin online dengan approval wali kelas/admin, serta absensi guru dan karyawan.', '[\"Kehadiran siswa, guru, dan karyawan via RFID tap atau QR Code\",\"Sesi kelas dengan QR code unik: guru buka sesi, siswa scan via portal\",\"Mark absensi, close session, dan absensi manual legacy untuk backup\",\"Pengajuan dan persetujuan izin siswa via portal dengan approval wali kelas atau admin\",\"Laporan kehadiran per kelas atau bulan dengan export PDF dan CSV\",\"Absensi guru dan karyawan: mark manual oleh admin atau self check-in pribadi\",\"RFID card management: daftar kartu, simulasi tap, dan revoke\",\"Pengaturan absensi: jam kerja, aturan, dan toleransi keterlambatan\",\"Dashboard absensi admin dan real-time persentase kehadiran hari ini\",\"Integrasi dengan modul akademik untuk kehadiran pada e-rapor\"]', 1, 3, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(4, '4. Keuangan Sekolah & SPP', 'Keuangan SPP', 'keuangan', 'Financial & SPP', '💳', 'bg-amber-50 text-amber-800 border border-amber-200', 'Penagihan SPP otomatis, kasir kwitansi PDF, COA Akuntansi, Buku Besar, Neraca, dan Kartu Ujian.', 'Solusi finansial sekolah komprehensif. Menangani generate tagihan SPP bulanan otomatis, kasir pembayaran partial/full, diskon dan beasiswa, reminder tunggakan, COA akuntansi, jurnal otomatis, neraca, hingga arus kas.', '[\"Penagihan SPP otomatis: generate per bulan per siswa, sync tagihan jika ada perubahan biaya, pembebasan beasiswa, dan reminder tunggakan via TU\",\"Dashboard keuangan real-time: total tagihan, pembayaran hari ini, piutang siswa, dan aging tunggakan\",\"Kasir pembayaran: pencarian siswa, bayar partial\\/full, void transaksi, dan kwitansi PDF\",\"Pengaturan jenis biaya SPP, diskon, dan beasiswa\",\"Chart of Accounts (COA) dan Sub-COA untuk akuntansi sekolah\",\"Kas dan bank multi-rekening, jurnal otomatis dari transaksi kasir dan pengeluaran\",\"Buku besar, neraca, dan arus kas laporan keuangan resmi cetak PDF\",\"Pengeluaran: kategori, approval, reject, bayar, dan Anggaran tahunan rencana vs realisasi\",\"Pengaturan SPP dan Kartu Ujian sebagai syarat lunas SPP sebelum ujian\"]', 1, 4, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(5, '5. Tabungan Siswa', 'Tabungan Siswa', 'keuangan', 'Bank School', '💰', 'bg-emerald-50 text-emerald-700 border border-emerald-200', 'Rekening tabungan per siswa, teller setor/tarik, setoran kolektif massal per kelas, dan approval ortu.', 'Modul perbankan internal sekolah. Mengelola rekening tabungan siswa terhubung ke data master, teller setor/tarik tunai, setoran kolektif massal per kelas, pengajuan penarikan via portal ortu, dan closing kas harian.', '[\"Rekening tabungan per siswa terhubung ke data master\",\"Teller\\/kasir: setor tunai, tarik saldo, void, dan cetak kwitansi\",\"Setoran kolektif massal per kelas untuk efisiensi program tabungan\",\"Pengajuan penarikan: siswa\\/ortu ajukan via portal, admin approve, ortu konfirmasi via portal\",\"Program tabungan dan enrollment per siswa dengan target simpanan\",\"Closing kas harian teller tabungan\",\"Dashboard tabungan siswa dan laporan saldo per siswa, mutasi, CSV dan PDF export\",\"Portal: lihat saldo, ajukan penarikan, dan kwitansi\"]', 1, 5, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(6, '6. Kantin & POS Multi-Outlet', 'POS Kantin', 'keuangan', 'Point of Sale', '🍱', 'bg-rose-50 text-rose-700 border border-rose-200', 'POS Kantin tap kartu RFID, pre-order pesanan, limit belanja harian diatur ortu, dan settlement komisi tenant.', 'Sistem Point of Sale kantin sekolah tanpa uang tunai (cashless). Siswa belanja dengan mengetap kartu RFID, orang tua mengatur limit belanja harian via portal, pre-order makanan sebelum jam istirahat, dan settlement komisi tenant.', '[\"POS Kantin: scan\\/tap kartu siswa, checkout, struk, dan void\",\"Menu dan stok produk dengan kategori, harga, dan stok real-time\",\"Multi-outlet\\/tenant kantin dengan settlement komisi otomatis\",\"Top-up saldo kantin via teller atau portal dengan konfirmasi admin\",\"Pre-order pesanan makanan sebelum jam istirahat tanpa antre dan paket menu harian\",\"Purchase order dan supplier: receive dan hutang\",\"Kebijakan limit belanja harian diatur orang tua via portal\",\"Dashboard kantin dan laporan penjualan cetak\",\"Portal ortu\\/siswa: lihat saldo, top-up, pre-order, dan limit belanja\"]', 1, 6, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(7, '7. Payroll Pegawai', 'Payroll', 'operasional', 'Payroll & Gaji', '💵', 'bg-purple-50 text-purple-700 border border-purple-200', 'Gaji guru dan staf lengkap, PPh21 dan BPJS, lembur, kasbon cicilan otomatis, dan slip gaji digital PDF.', 'Sistem payroll otomatis sesuai kepangkatan dan golongan pegawai. Menghitung gaji pokok, tunjangan, potongan PPh21 dan BPJS, klaim lembur, kasbon, dan menerbitkan slip gaji PDF di portal pegawai.', '[\"Gaji guru dan staf lengkap dengan setup periode gaji bulanan dan tanggal cutoff\",\"Komponen gaji: gaji pokok, tunjangan, dan potongan yang dapat dikonfigurasi\",\"Golongan dan grade pegawai dengan tabel gaji otomatis\",\"Profil pegawai: rekening bank, NPWP, dan komponen gaji terdaftar\",\"Lembur: pengajuan pegawai, approval HRD, dan kalkulasi otomatis\",\"Kasbon dan pinjaman: cicilan otomatis dipotong per periode gaji\",\"Generate payroll: kalkulasi bulk, preview, approval, dan mark paid\",\"Pembayaran gaji massal: export rekening untuk transfer bank\",\"Slip gaji digital PDF email dan download per pegawai di portal\",\"Laporan PPh21 dan BPJS untuk kepatuhan pajak\",\"Portal pegawai: Slip Gaji Saya tanpa tanya HRD\"]', 1, 7, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(8, '8. Bimbingan Konseling (BK)', 'BK Online', 'akademik', 'Konseling & Poin', '🤝', 'bg-sky-50 text-sky-700 border border-sky-200', 'Rekam jejak BK, master jenis pelanggaran dan poin, booking sesi online, dan home visit log.', 'Modul BK terstruktur untuk memantau perkembangan karakter dan kedisiplinan siswa. Mencatat kasus pelanggaran dengan sistem poin/sanksi, booking sesi konseling online, dan dokumentasi home visit.', '[\"Profil BK per siswa: riwayat konseling, pelanggaran, prestasi, dan rekam jejak\",\"Master jenis pelanggaran dengan poin dan sanksi\",\"Pendaftaran dan catatan sesi konseling rahasia per kasus\",\"Manajemen kasus BK: open, in-progress, resolved, dan referred\",\"Monitoring siswa berisiko dan Home visit dengan dokumentasi foto\",\"Konseling orang tua terpisah dari sesi siswa\",\"Bimbingan karier dan tes minat bakat siswa\",\"Rujukan internal\\/eksternal, surat resmi BK, dan laporan BK cetak PDF\",\"Portal: booking konseling online\"]', 1, 8, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(9, '9. Sarana & Prasarana', 'Aset & Gedung', 'operasional', 'Asset & Inventaris', '🏫', 'bg-amber-50 text-amber-800 border border-amber-200', 'Inventaris aset barcode, visual floor plan gedung/ruangan, peminjaman aset, dan maintenance preventif.', 'Pengelolaan aset dan fasilitas sekolah. Mencatat aset tetap dengan barcode dan nilai penyusutan, visual floor plan gedung, barang habis pakai, peminjaman fasilitas, serta jadwal maintenance preventif.', '[\"Gedung dan ruangan dengan visual floor plan\",\"Aset tetap: detail per item, barcode unik, nilai perolehan, dan penyusutan\",\"Barang habis pakai: movement stock in\\/out per ruang\",\"Kendaraan sekolah: BPKB, service schedule, dan driver log\",\"Peminjaman aset\\/fasilitas: request, approve, borrow, dan return\",\"Procurement\\/pengadaan barang dengan approval chain\",\"Mutasi antar lokasi dan serah terima terdokumentasi\",\"Stock opname dengan scan barcode mobile-friendly\",\"Penghapusan aset dengan approval dan maintenance korektif\\/preventif\"]', 1, 9, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(10, '10. Perpustakaan Digital', 'E-Library', 'akademik', 'Literasi & E-Book', '📖', 'bg-emerald-50 text-emerald-700 border border-emerald-200', 'Sirkulasi pinjam/kembali scan QR, katalog E-Book PDF, denda otomatis, dan program literasi.', 'Perpustakaan fisik dan digital terpadu. Memudahkan pencarian katalog buku via ISBN, sirkulasi pinjam/kembali berbasis QR Code, perhitungan denda otomatis, dan koleksi E-Book digital.', '[\"Katalog buku dengan pencarian judul, pengarang, ISBN, dan rak buku\",\"Eksemplar per buku dengan barcode atau QR unik\",\"Sirkulasi: pinjam, kembali, perpanjang, dan denda keterlambatan otomatis\",\"Reservasi buku yang sedang dipinjam siswa lain\",\"Kunjungan perpustakaan: check-in\\/out untuk statistik\",\"Koleksi digital: upload E-Book PDF dan baca via portal\",\"Program literasi dan gemar membaca: target baca per semester dan ulasan buku\",\"Dashboard dan laporan sirkulasi cetak\"]', 1, 10, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(11, '11. E-Learning & LMS', 'E-Learning', 'akademik', 'LMS & Online Class', '📚', 'bg-indigo-50 text-indigo-700 border border-indigo-200', 'Kursus modul materi, tugas assignment, forum diskusi, live class Zoom/Meet, dan sertifikat PDF.', 'Platform E-Learning interaktif untuk pembelajaran hybrid. Menyediakan modul materi (PDF, Video, Embed), submisi tugas siswa, forum diskusi per kelas, integrasi sesi Zoom/Meet, dan auto sertifikat PDF.', '[\"Kursus dengan thumbnail, deskripsi, dan enrollment per kelas\",\"Modul dan materi: PDF, video link, text, dan embed media\",\"Assignment\\/tugas dengan deadline dan submisi file siswa\",\"Forum diskusi per kursus: thread, reply, lock, hide, dan moderasi\",\"Live learning: jadwal Zoom \\/ Google Meet dan absensi live\",\"Quiz e-learning: bank soal, acak soal, dan passing grade\",\"Progress tracking per siswa per modul dan sertifikat PDF otomatis\",\"Portal siswa: daftar kursus, selesaikan materi, submisi tugas, dan quiz online\"]', 1, 11, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(12, '12. CBT (Computer Based Test)', 'CBT Ujian', 'akademik', 'Ujian Online CBT', '💻', 'bg-purple-50 text-purple-700 border border-purple-200', 'Ujian CBT bank soal multi-type, proctoring camera snapshot, anti tab-switch, dan auto sync nilai.', 'Sistem Ujian Komputer dengan standar keamanan tinggi. Mendukung bank soal pilihan ganda, benar/salah, essay, matching, deteksi kecurangan tab-switch, proctoring foto kamera, dan autosave jawaban tiap 30 detik.', '[\"Bank soal: pilihan ganda, benar\\/salah, essay, dan matching\",\"Ujian CBT: jadwal, durasi, acak soal, dan opsi jawaban\",\"Passing grade dan ujian remedial otomatis\",\"Keamanan: mode fullscreen, tab-switch detection, dan camera snapshot proctor\",\"Autosave jawaban siswa setiap 30 detik\",\"Koreksi essay manual oleh guru\",\"Sinkronisasi nilai ke penilaian akademik otomatis dan laporan export hasil ujian\",\"Portal: daftar ujian, autosave jawaban, dan hasil\"]', 1, 12, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(13, '13. PPDB Online', 'PPDB Online', 'operasional', 'Penerimaan Siswa', '📝', 'bg-pink-50 text-pink-700 border border-pink-200', 'Penerimaan Siswa Baru wizard 5-langkah, upload dokumen, konfirmasi bayar, dan transfer master data.', 'Portal SPMB/PPDB publik end-to-end. Calon siswa mendaftar melalui wizard 5 langkah, mengunggah berkas syarat (Akta, KK, Ijazah), konfirmasi bukti bayar, dan jika diterima data otomatis masuk ke Master Siswa.', '[\"Website publik \\/ppdb dengan desain responsive\",\"Landing page PPDB publik dan Admin CMS untuk halaman, banner, FAQ, biaya, dan jadwal\",\"Registrasi akun calon siswa dengan verifikasi email\",\"Wizard 5 langkah: pribadi, orang tua, sekolah asal, nilai, dan dokumen\",\"Upload dokumen: Akta, KK, Ijazah, dan Foto dengan validasi admin\",\"Konfirmasi pembayaran: upload bukti transfer dan verifikasi TU\",\"Pengaturan gelombang pendaftaran dengan kuota dan tanggal berbeda\",\"Transfer pendaftar diterima langsung ke data siswa master\",\"Download isian Form SPMB oleh wali siswa dalam bentuk PDF\"]', 1, 13, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(14, '14. Portal Siswa & Ortu Mobile', 'Portal Ortu', 'bpi', 'Self-Service Mobile', '📱', 'bg-teal-50 text-teal-700 border border-teal-200', 'Dashboard personal mobile-friendly, multi-anak switcher ortu, kwitansi PDF, dan gamifikasi.', 'Portal mandiri untuk warga sekolah. Memberikan kemudahan bagi orang tua untuk berpindah profil anak dalam 1 akun, melihat Rapor online, mengunduh kwitansi SPP, dan menerima notifikasi in-app.', '[\"Self-service warga sekolah: Beranda dashboard personal\",\"Nilai dan rapor online serta download kwitansi pembayaran PDF\",\"Absensi: check-in\\/out, QR code, pengajuan izin, dan riwayat\",\"E-Learning dan CBT terintegrasi\",\"Tagihan dan riwayat pembayaran, Tabungan, Kantin, Konseling BK, dan Perpustakaan\",\"Multi-anak untuk orang tua: switch profil anak dengan 1 akun\",\"Slip gaji pegawai self-service untuk wali siswa yang juga pegawai\",\"Notifikasi in-app: tagihan, ujian, pengumuman, dan tampilan mobile-friendly\",\"Gamifikasi Amal: Pemberian badge digital Pejuang Subuh bagi siswa disiplin\",\"Widget dan Notifikasi Islami: Kutipan hadits harian dan pengingat waktu ibadah\"]', 1, 14, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(15, '15. Mutaba\'ah BPI & Character', 'BPI Mutaba\'ah', 'bpi', 'Bina Pribadi Islami', '🕌', 'bg-amber-50 text-amber-800 border border-amber-200', 'Laporan amal ibadah harian, validasi digital PIN ortu, Al-Mathurat dzikir, dan API Waktu Sholat Kemenag.', 'Modul Bina Pribadi Islami (BPI) khas SIT Robbani. Checklist ibadah harian anak di rumah yang diawasi orang tua via PIN digital, radar chart pencapaian karakter, modul Al-Mathurat dzikir, dan pengingat waktu sholat.', '[\"Laporan Amal Ibadah Harian: Checklist digital pelaksanaan sholat wajib, rawatib, dhuha, tahajud, tilawah, hafalan ziyadah, puasa sunnah, dan infaq harian\",\"Validasi dan Approval Orang Tua via tanda tangan digital atau PIN di Portal Ortu\",\"Dashboard BPI Graphical: Visualisasi radar chart pencapaian amal per siswa dan kelas\",\"Fitur Dzikir dan Doa Digital: Modul Al-Mathurat pagi dan petang interaktif dengan terjemahan dan tasbih virtual\",\"Pengingat Sholat dan Imsakiyah: Integrasi API Kemenag berbasis geolokasi sekolah\",\"Amal Jariyah dan Infaq Harian: Tracking donasi siswa terintegrasi ke Keuangan\"]', 1, 15, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(16, '16. Sistem & Branding Context', 'System Admin', 'operasional', 'System Architecture', '⚙️', 'bg-slate-100 text-slate-700 border border-slate-200', '12+ Role bawaan granular, custom school branding logo dan warna, serta multi-school context.', 'Arsitektur keamanan dan identitas sekolah. Mendukung 12+ role pengguna bawaan (Admin, Guru, Bendahara, BK, dll) dengan hak akses granular per modul, custom branding logo/warna, dan audit log aktivitas.', '[\"Pengaturan pengguna, role, dan multi-sekolah dengan School Context Middleware\",\"Branding: nama sekolah, aplikasi, tagline, upload logo sekolah, dan warna tema\",\"Manajemen akun pengguna: CRUD akun, reset password, dan suspend\",\"Role dan permission granular per modul dan tindakan aksi\",\"12+ Role bawaan siap pakai (Admin, Bendahara, Guru, BK, Wali Kelas, Ortu, Siswa, Karyawan) serta custom role\",\"Dashboard admin quick menu modul dan role-based home redirect\",\"Audit log aktivitas penting sistem\",\"Profil pengguna: ganti password, foto, dan kontak\"]', 1, 16, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(17, '17. HRIS & Pengembangan SDM', 'HRIS & SDM', 'operasional', 'HRIS & E-Leave', '👥', 'bg-purple-50 text-purple-700 border border-purple-200', 'Cuti E-Leave berjenjang, PKG KPI evaluasi kinerja guru, E-Recruitment pelamar, dan klaim biaya.', 'Manajemen Sumber Daya Manusia sekolah. Menangani pengajuan cuti (E-Leave), evaluasi kinerja guru (PKG KPI) berbasis rekap jurnal KBM, tracking pelamar kerja (E-Recruitment), dan klaim operasional.', '[\"Cuti dan Perizinan (E-Leave): Pengajuan cuti berjenjang via portal yang memotong saldo cuti dan payroll\",\"Manajemen Kinerja (KPI): Evaluasi kinerja pegawai (PKG) dan rekap jurnal KBM guru\",\"Rekrutmen (E-Recruitment): Tracking pelamar kerja, jadwal wawancara, dan konversi ke pegawai baru\",\"Klaim dan Reimbursement: Pengajuan dana operasional pegawai terintegrasi ke Bendahara\"]', 1, 17, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(18, '18. Anti-Bullying System & Panic Alarm', 'Anti-Bullying', 'bpi', 'Keamanan & SafeSchool', '🚨', 'bg-rose-50 text-rose-700 border border-rose-200', 'Pelaporan perundungan rahasia/anonim, Panic Alarm darurat siswa ke Satgas, dan pendampingan konseling BK.', 'Sistem Perlindungan Siswa SafeSchool & Anti-Perundungan Terpadu. Siswa dapat melaporkan insiden perundungan secara rahasia/anonim, fitur Panic Alarm darurat dengan geolokasi posisi kelas/ruang, penanganan oleh Satgas Anti-Bullying & Guru BK, serta konseling trauma healing.', '[\"Tombol Panic Alarm Darurat: Siswa dan guru menekan alarm darurat real-time dengan lokasi kelas\\/ruang ke HP Satgas Keamanan dan BK\",\"Lapor Perundungan Anonim dan Terbuka: Form laporan rahasia dengan bukti lampiran foto, video, atau kronologi insiden\",\"Manajemen Kasus Anti-Bullying: Alur penanganan terstruktur dari Laporan, Investigasi, Mediasi, Pendampingan BK, hingga Selesai\",\"Tim Satgas Anti-Bullying Sekolah: Dashboard pemantauan dan tanggap cepat insiden keamanan lingkungan sekolah\",\"Notifikasi Real-Time dan Sirene Digital: Peringatan otomatis ke Guru BK, Wali Kelas, Kepala Sekolah, dan Keamanan\",\"Konseling dan Trauma Healing: Pendampingan psikologis terstruktur untuk korban dan pembinaan edukatif untuk pelaku\",\"Survei Iklim Keamanan Sekolah: Evaluasi rutin tingkat kenyamanan dan keamanan siswa secara berkala\"]', 1, 18, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(19, '19. Chatbot AI Administrasi Sekolah', 'Chatbot AI', 'operasional', 'AI & Service Chatbot', '🤖', 'bg-indigo-50 text-indigo-700 border border-indigo-200', 'Asisten Virtual AI 24/7 untuk informasi SPP, tagihan, jadwal pelajaran, syarat PPDB, dan AI Tutor siswa.', 'Layanan Asisten Virtual Berbasis Artificial Intelligence 24/7. Membantu orang tua dan siswa menjawab pertanyaan seputar tagihan SPP, rincian biaya, jadwal pelajaran, syarat pendaftaran PPDB, pengumuman sekolah, hingga AI Tutor bantuan belajar siswa via portal & WhatsApp Gateway.', '[\"Asisten Virtual AI 24\\/7: Menjawab otomatis pertanyaan wali murid seputar informasi dan administrasi sekolah tanpa antre\",\"Integrasi Cek Tagihan dan SPP: Orang tua bertanya rincian tagihan SPP anak dan AI menyajikan data instan\",\"Layanan Informasi PPDB Otomatis: Panduan syarat pendaftaran, rincian gelombang biaya, dan jadwal seleksi calon siswa\",\"AI Tutor dan Bantuan Belajar Siswa: Menjawab pertanyaan materi pelajaran dan rekomendasi e-book perpustakaan\",\"Omnichannel Gateway: Terhubung langsung ke WhatsApp resmi sekolah dan portal website\",\"Knowledge Base Management CMS: Sekolah dapat memperbarui dan menambah basis data informasi AI dengan mudah\",\"Analitik Pertanyaan Populer: Insight tren pertanyaan wali murid untuk evaluasi kualitas pelayanan sekolah\"]', 1, 19, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(20, '20. Alumni & Tracer Study Network', 'Alumni Network', 'operasional', 'Alumni & Tracer Study', '🎓', 'bg-cyan-50 text-cyan-700 border border-cyan-200', 'Database alumni terpadu, tracer study PTN/dunia kerja, legalisir e-ijazah online, dan wakaf alumni.', 'Sistem Pengelolaan Alumni & Tracer Study Sekolah. Membantu sekolah memantau sebaran alumni di Perguruan Tinggi Negeri (PTN) / Perguruan Tinggi Luar Negeri, melacak rekam karir, memfasilitasi jejaring beasiswa, penggalangan dana wakaf & infaq alumni, serta legalisir e-ijazah digital online.', '[\"Database Alumni Terpadu: Direktori angkatan alumni dari jenjang TK, SD, SMP hingga SMA\",\"Tracer Study PTN dan Kedinasan: Pelacakan otomatis sebaran alumni di PTN favorit, Universitas luar negeri, dan karir profesional\",\"Portal Alumni Self-Service: Alumni update data profil mandiri, riwayat kuliah lanjutan, dan pekerjaan\",\"Legalisir E-Ijazah dan Transkrip Online: Pengajuan legalisir sertifikat digital terverifikasi QR Code tanpa antre\",\"Program Wakaf dan Infaq Alumni: Penggalangan beasiswa adik kelas dan fasilitas sarana prasarana almamater\",\"Jejaring Mentoring Karir dan UTBK: Sinergi alumni berbagi pengalaman persiapan kelulusan dan seleksi masuk PTN\"]', 1, 20, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(21, '21. Ekstrakurikuler & Talenta Siswa', 'Ekskul & Talenta', 'akademik', 'Ekskul & Prestasi', '🏆', 'bg-emerald-50 text-emerald-700 border border-emerald-200', 'Pendaftaran ekskul online, absensi & jurnal pembina, hall of fame prestasi, dan sertifikat digital.', 'Modul Pengelolaan Ekstrakurikuler, Klub Bakat & Portofolio Prestasi Siswa. Memfasilitasi pendaftaran ekskul online, jadwal & absensi latihan, jurnal pembina, portofolio digital kejuaraan/prestasi (Pramuka, Tahfidz, Robotik, Olahraga, Sains), serta integrasi nilai deskriptif ke E-Rapor.', '[\"Pendaftaran Ekskul Online: Siswa memilih klub ekstrakurikuler dan minat bakat mandiri via portal\",\"Manajemen Pembina dan Absensi Ekskul: Jadwal latihan, absensi keikutsertaan, dan jurnal pembina kegiatan\",\"Hall of Fame dan Etalase Prestasi: Portofolio digital piala dan piagam kejuaraan Kabupaten, Nasional, dan Internasional\",\"Sertifikat Digital Prestasi: Penerbitan sertifikat resmi penghargaan kegiatan ekskul ber-QR Code\",\"Integrasi Nilai Ekskul ke E-Rapor: Form penilaan deskriptif pembina terhubung langsung ke Rapor siswa\",\"Peta Talenta Siswa: Pemetaan minat bakat akademik dan non-akademik siswa sejak dini\"]', 1, 21, '2026-08-10 12:49:01', '2026-08-10 12:49:01');

-- --------------------------------------------------------
-- Table structure for `faq_items`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `faq_items`;
CREATE TABLE `faq_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `faq_items`
INSERT INTO `faq_items` (`id`, `question`, `answer`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Apakah SmartEdu mendukung Kurikulum K13, Kurikulum Merdeka, dan Kekhasan JSIT?', 'Ya, SmartEdu mendukung Multi-Kurikulum secara dinamis. Anda dapat mengaktifkan K13, Kurikulum Merdeka dengan Proyek P5, kekhasan JSIT, maupun kurikulum kustom per tahun akademik.', 1, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(2, 'Bagaimana cara kerja Sistem Anti-Bullying dan Panic Alarm?', 'Siswa dapat melaporkan insiden perundungan secara rahasia via portal. Dalam kondisi darurat, siswa atau guru dapat menekan tombol Panic Alarm yang langsung memicu sinyal sirene digital dan notifikasi lokasi ke HP Satgas Keamanan, Wali Kelas, dan Guru BK.', 2, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(3, 'Bagaimana Chatbot AI Administrasi Sekolah membantu Orang Tua & Siswa?', 'Chatbot AI aktif 24/7 via portal dan WhatsApp Gateway untuk menjawab pertanyaan seputar sisa tagihan SPP, rincian pembayaran, jadwal pelajaran, syarat PPDB, hingga rekomendasi buku perpustakaan secara otomatis.', 3, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(4, 'Bagaimana pengelolaan Alumni & Ekstrakurikuler di SmartEdu?', 'SmartEdu menyediakan modul Tracer Study Alumni untuk pelacakan lulusan di PTN dan dunia kerja serta legalisir ijazah online, dan Modul Ekstrakurikuler & Talenta Siswa untuk pendaftaran ekskul online, hall of fame prestasi, dan sertifikat digital.', 4, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(5, 'Bagaimana cara kerja Absensi RFID & QR Code?', 'Siswa dan staf melakukan tap kartu RFID di terminal sekolah atau scan QR Code per sesi kelas dari portal guru. Data otomatis tercatat real-time dan terintegrasi ke laporan kehadiran.', 5, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(6, 'Apakah modul Keuangan SPP terintegrasi ke Akuntansi?', 'Sangat terintegrasi. Setiap transaksi pembayaran SPP kasir atau penagihan otomatis langsung menghasilkan Jurnal Otomatis, Buku Besar, Neraca, dan Laporan Arus Kas resmi.', 6, '2026-08-10 12:49:01', '2026-08-10 12:49:01'),
(7, 'Apakah sistem mendukung Multi-Sekolah untuk Yayasan?', 'Ya, SmartEdu memiliki School Context Middleware sehingga Yayasan dapat mengelola banyak unit sekolah seperti TK, SD, SMP, dan SMA dalam 1 instalasi terpadu.', 7, '2026-08-10 12:49:01', '2026-08-10 12:49:01');

-- --------------------------------------------------------
-- Table structure for `password_reset_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `sessions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '0001_01_01_000000_create_users_table', 1),
(6, '0001_01_01_000001_create_cache_table', 1),
(7, '0001_01_01_000002_create_jobs_table', 1),
(8, '2026_08_10_000000_create_cms_tables', 1);

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
