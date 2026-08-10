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
                'question' => 'Apakah SmartEdu mendukung Kurikulum K13, Kurikulum Merdeka, dan Kekhasan JSIT?',
                'answer' => 'Ya! SmartEdu mendukung Multi-Kurikulum secara dinamis. Anda dapat mengaktifkan K13, Kurikulum Merdeka (dengan Proyek P5), kekhasan JSIT, maupun kurikulum kustom per tahun akademik.',
                'sort_order' => 1
            ],
            [
                'question' => 'Bagaimana cara kerja Absensi RFID & QR Code?',
                'answer' => 'Siswa & staf melakukan tap kartu RFID di terminal sekolah atau scan QR Code per sesi kelas dari portal guru. Data otomatis tercatat real-time dan terintegrasi ke laporan kehadiran.',
                'sort_order' => 2
            ],
            [
                'question' => 'Apakah modul Keuangan SPP terintegrasi ke Akuntansi?',
                'answer' => 'Sangat terintegrasi! Setiap transaksi pembayaran SPP kasir atau penagihan otomatis langsung menghasilkan Jurnal Otomatis, Buku Besar, Neraca, dan Laporan Arus Kas resmi.',
                'sort_order' => 3
            ],
            [
                'question' => 'Bagaimana orang tua membatasi saldo belanja kantin anak?',
                'answer' => 'Orang tua mengatur limit belanja harian anak via Portal Ortu Mobile. Saat anak mengetap kartu di POS Kantin, sistem otomatis memverifikasi limit belanja harian.',
                'sort_order' => 4
            ],
            [
                'question' => 'Apakah sistem mendukung Multi-Sekolah untuk Yayasan?',
                'answer' => 'Ya, SmartEdu memiliki School Context Middleware sehingga Yayasan dapat mengelola banyak unit sekolah (TK, SD, SMP, SMA) dalam 1 instalasi terpadu.',
                'sort_order' => 5
            ]
        ];

        FaqItem::truncate();
        foreach ($faqs as $faq) {
            FaqItem::create($faq);
        }

        // 17 Feature Modules based on PDF "Fitur-fitur utama setiap modul SMART EDU ROBBANI"
        $modules = [
            [
                'title' => '1. Master Data & Referensi',
                'short_title' => 'Master Data',
                'category' => 'akademik',
                'category_name' => 'Akademik Base',
                'icon' => '🏛️',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'short_desc' => 'Fondasi data seluruh sistem Big Data Siakad Robbani untuk multi-sekolah, rombel, siswa, guru & karyawan.',
                'full_desc' => 'Modul fondasi seluruh sistem Big Data Siakad Robbani. Mengelola multi-unit sekolah dalam satu instalasi, profil sekolah lengkap, kurikulum dinamis K13/Merdeka/JSIT, tahun akademik, semester, biodata siswa, guru & karyawan non-guru.',
                'highlights' => [
                    "Fondasi data seluruh sistem Big Data Siakad Robbani",
                    "Multi-sekolah: kelola banyak unit sekolah (yayasan) dalam 1 instalasi & switch sekolah aktif",
                    "Kurikulum K13, Merdeka, kekhasan JSIT dan kurikulum kustom (komponen penilaian menyesuaikan)",
                    "Tahun akademik dengan semester, tanggal efektif, dan curriculum_code per periode",
                    "Tingkat/jenjang dan rombel/kelas dengan kapasitas dan wali kelas assigned",
                    "Data siswa: CRUD, biodata lengkap, orang tua, riwayat rombel, status aktif/lulus/keluar, import/export",
                    "Data guru & tenaga pendidik: mapel diampu, jadwal mengajar, akun login portal",
                    "Data karyawan non-guru: TU, cleaning service, security - untuk absensi & payroll",
                    "Kelola profil sekolah lengkap: nama, NPSN, alamat, kepala sekolah, logo, dan kontak",
                    "Referensi mapel, ruang, dan struktur organisasi sekolah"
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
                'short_desc' => 'Modul terlargest - K13, Merdeka, JSIT rapor, jadwal mingguan, RPP/Jurnal KBM, P5 & Cetak Rapor PDF.',
                'full_desc' => 'Modul akademik terlargest untuk menangani jadwal pelajaran mingguan bebas konflik, KOSP, RPP, penilaian dinamis per komponen K13 (KI/KD) & Merdeka (TP, formatif, sumatif, P5), rollup nilai otomatis, hingga cetak Rapor PDF resmi.',
                'highlights' => [
                    "Modul terlargest: K13, Merdeka, JSIT rapor, dan jadwal pelajaran",
                    "Dashboard akademik: ringkasan jadwal, penilaian pending, rapor belum cetak & kalender kegiatan sekolah",
                    "Mata pelajaran per tingkat dengan bobot jam dan guru pengampu",
                    "Jadwal pelajaran mingguan dengan deteksi konflik ruang/guru otomatis",
                    "Analisis beban mengajar guru: visualisasi jam mengajar per guru per minggu",
                    "KOSP (Standar Operasional Sekolah) & Program pembelajaran",
                    "Penilaian K13: KI/KD, bobot, KKM otomatis, predikat mapel, pengetahuan & keterampilan, sikap spiritual-sosial, penilaian diri & teman sebaya, ekstrakurikuler, prestasi",
                    "Penilaian Merdeka: Tujuan Pembelajaran (TP) & capaian kompetensi, penilaian formatif & sumatif, Proyek P5 & skor proyek per siswa",
                    "Rollup / agregasi nilai antar komponen & semester -> Rapor UTS & Semester adaptif PDF resmi",
                    "Kenaikan kelas batch (generate, finalisasi, override manual per siswa) & Kelulusan batch + sertifikat PDF",
                    "Jurnal KBM guru, rekap, RPP (Rencana Pelaksanaan Pembelajaran), bahan ajar, tugas & submisi siswa",
                    "PKL, kegiatan siswa, daftar ulang, & perkembangan karakter"
                ],
                'sort_order' => 2
            ],
            [
                'title' => '3. Absensi RFID & QR Code',
                'short_title' => 'Presensi RFID',
                'category' => 'akademik',
                'category_name' => 'Presensi Realtime',
                'icon' => '🪪',
                'badge_bg' => 'bg-teal-100 text-teal-800',
                'short_desc' => 'Kehadiran siswa & guru via RFID card tap, scan QR sesi kelas, pengajuan izin, & dashboard real-time.',
                'full_desc' => 'Sistem absensi modern yang mendukung kartu RFID tap, scan QR code per sesi kelas oleh siswa via portal, pengajuan izin online dengan approval wali kelas/admin, serta absensi guru/karyawan.',
                'highlights' => [
                    "Kehadiran siswa, guru & karyawan via RFID tap / QR Code",
                    "Sesi kelas dengan QR code unik - guru buka sesi, siswa scan via portal",
                    "Mark absensi, close session, & absensi manual legacy untuk backup jika QR tidak tersedia",
                    "Pengajuan & persetujuan izin siswa via portal (approval wali kelas/admin)",
                    "Laporan kehadiran per kelas/bulan - export PDF & CSV",
                    "Absensi guru & karyawan: mark manual oleh admin atau self check-in pribadi",
                    "RFID card management: daftar kartu, simulasi tap, revoke",
                    "Pengaturan absensi: jam, aturan, toleransi",
                    "Dashboard absensi admin/kurikulum & real-time: persentase kehadiran hari ini",
                    "Integrasi dengan modul akademik - kehadiran affect rapor jika dikonfigurasi"
                ],
                'sort_order' => 3
            ],
            [
                'title' => '4. Keuangan Sekolah & SPP',
                'short_title' => 'Keuangan SPP',
                'category' => 'keuangan',
                'category_name' => 'Financial & SPP',
                'icon' => '💳',
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Penagihan SPP otomatis, kasir kwitansi PDF, COA Akuntansi, Buku Besar, Neraca & Kartu Ujian.',
                'full_desc' => 'Solusi finansial sekolah komprehensif. Menangani generate tagihan SPP bulanan otomatis, kasir pembayaran partial/full, diskon & beasiswa, reminder tunggakan, COA akuntansi, jurnal otomatis, neraca hingga arus kas.',
                'highlights' => [
                    "Penagihan SPP otomatis: generate per bulan per siswa, sync tagihan jika ada perubahan biaya, waive/bebas tagihan beasiswa penuh, reminder tunggakan via export list follow-up TU",
                    "Dashboard keuangan real-time: total tagihan, pembayaran hari ini, piutang siswa & aging tunggakan",
                    "Kasir pembayaran: search siswa, bayar partial/full, void transaksi, kwitansi PDF",
                    "Jenis biaya/SPP, diskon & beasiswa",
                    "Chart of Accounts (COA) & Sub-COA untuk akuntansi sekolah yang proper",
                    "Kas & bank multi-rekening, jurnal otomatis dari transaksi kasir & pengeluaran",
                    "Buku besar, neraca, arus kas - laporan keuangan resmi cetak PDF",
                    "Pengeluaran: kategori, approval, reject, bayar & Anggaran tahunan (rencana vs realisasi per kategori)",
                    "Pengaturan SPP & Kartu Ujian (syarat lunas SPP sebelum boleh ujian)"
                ],
                'sort_order' => 4
            ],
            [
                'title' => '5. Tabungan Siswa',
                'short_title' => 'Tabungan Siswa',
                'category' => 'keuangan',
                'category_name' => 'Bank School',
                'icon' => '💰',
                'badge_bg' => 'bg-emerald-100 text-emerald-800',
                'short_desc' => 'Rekening tabungan per siswa, teller setor/tarik, setoran kolektif massal per kelas, & approval ortu.',
                'full_desc' => 'Modul perbankan internal sekolah. Mengelola rekening tabungan siswa terhubung ke data master, teller setor/tarik tunai, setoran kolektif massal per kelas, pengajuan penarikan via portal ortu, dan closing kas harian.',
                'highlights' => [
                    "Rekening tabungan per siswa terhubung ke data master",
                    "Teller/kasir: setor tunai, tarik saldo, void, cetak kwitansi",
                    "Setoran kolektif (mass deposit): input massal per kelas - efisien untuk program tabungan",
                    "Pengajuan penarikan: siswa/ortu ajukan via portal, admin approve, ortu konfirmasi via portal",
                    "Program tabungan & enrollment per siswa dengan target dan bunga (jika ada)",
                    "Closing kas harian teller tabungan",
                    "Dashboard tabungan siswa & Laporan saldo per siswa, mutasi, CSV/PDF export",
                    "Portal: lihat saldo, ajukan penarikan, kwitansi"
                ],
                'sort_order' => 5
            ],
            [
                'title' => '6. Kantin & POS Multi-Outlet',
                'short_title' => 'POS Kantin',
                'category' => 'keuangan',
                'category_name' => 'Point of Sale',
                'icon' => '🍱',
                'badge_bg' => 'bg-rose-100 text-rose-800',
                'short_desc' => 'POS Kantin tap kartu RFID, pre-order pesanan, limit belanja harian diatur ortu, & settlement komisi tenant.',
                'full_desc' => 'Sistem Point of Sale kantin sekolah tanpa uang tunai (cashless). Siswa belanja dengan mengetap kartu RFID, orang tua mengatur limit belanja harian via portal, pre-order makanan sebelum jam istirahat, dan settlement komisi tenant.',
                'highlights' => [
                    "POS Kantin: scan/tap kartu siswa, checkout, struk, void",
                    "Menu & stok produk dengan kategori, harga, stok real-time (stock-in dari supplier, alert stok minimum)",
                    "Multi-outlet/tenant kantin: kantin A, kantin B - settlement komisi otomatis",
                    "Top-up saldo kantin via teller atau portal (konfirmasi admin)",
                    "Pre-order pesanan makanan sebelum jam istirahat (ambil tanpa antre) & Paket menu harian harga promo",
                    "Purchase order & supplier (receive, hutang)",
                    "Kebijakan limit belanja harian - orang tua set via portal",
                    "Dashboard kantin & Laporan penjualan cetak",
                    "Portal ortu/siswa: lihat saldo, top-up, pre-order, limit belanja"
                ],
                'sort_order' => 6
            ],
            [
                'title' => '7. Payroll Pegawai',
                'short_title' => 'Payroll',
                'category' => 'operasional',
                'category_name' => 'Payroll & Gaji',
                'icon' => '💵',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'short_desc' => 'Gaji guru & staff lengkap, PPh21 & BPJS, lembur, kasbon cicilan otomatis, & slip gaji digital PDF.',
                'full_desc' => 'Sistem payroll otomatis sesuai kepangkatan/golongan pegawai. Menghitung gaji pokok, tunjangan, potongan PPh21 & BPJS, klaim lembur, kasbon, dan menerbitkan slip gaji PDF di portal pegawai.',
                'highlights' => [
                    "Gaji guru & staff lengkap dengan setup periode gaji bulanan & tanggal cutoff",
                    "Komponen gaji: gaji pokok, tunjangan, potongan - configurable",
                    "Golongan & grade pegawai dengan tabel gaji otomatis",
                    "Profil pegawai: rekening bank, NPWP, komponen assigned",
                    "Lembur: pengajuan pegawai, approval HRD, hitung otomatis",
                    "Kasbon & pinjaman: cicilan otomatis dipotong per periode",
                    "Generate payroll: kalkulasi bulk, preview, approval, mark paid",
                    "Pembayaran gaji massal: export rekening untuk transfer bank",
                    "Slip gaji digital PDF - email/download per pegawai (/my-payroll)",
                    "Laporan PPh21 & BPJS untuk compliance pajak - cetak",
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
                'badge_bg' => 'bg-sky-100 text-sky-800',
                'short_desc' => 'Rekam jejak BK, master jenis pelanggaran & poin, booking sesi online, & home visit log.',
                'full_desc' => 'Modul BK terstruktur untuk memantau perkembangan karakter dan kedisiplinan siswa. Mencatat kasus pelanggaran dengan sistem poin/sanksi, booking sesi konseling online, dan dokumentasi home visit.',
                'highlights' => [
                    "Profil BK per siswa: riwayat konseling, pelanggaran, prestasi & rekam jejak",
                    "Master jenis pelanggaran dengan poin & sanksi",
                    "Pendaftaran & catatan sesi konseling confidential per kasus (siswa booking via portal, guru BK confirm)",
                    "Manajemen kasus BK: open, in-progress, resolved, referred",
                    "Monitoring siswa berisiko & Home visit dengan dokumentasi foto",
                    "Konseling orang tua terpisah dari sesi siswa",
                    "Bimbingan karier & tes minat bakat SMK/SMA",
                    "Rujukan internal/eksternal, Surat & dokumen resmi BK, Laporan BK cetak PDF",
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
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Inventaris aset barcode, visual floor plan gedung/ruangan, peminjaman aset, & maintenance preventif.',
                'full_desc' => 'Pengelolaan aset dan fasilitas sekolah. Mencatat aset tetap dengan barcode & nilai penyusutan, visual floor plan gedung, barang habis pakai, peminjaman fasilitas, serta jadwal maintenance preventif.',
                'highlights' => [
                    "Gedung & ruangan dengan visual floor plan",
                    "Aset tetap: detail per item, barcode unik, nilai perolehan, penyusutan",
                    "Barang habis pakai: movement / stock in/out per ruang",
                    "Kendaraan sekolah: BPKB, service schedule, driver log",
                    "Peminjaman aset/fasilitas: request -> approve -> borrow -> return",
                    "Procurement / pengadaan barang dengan approval chain",
                    "Mutasi antar lokasi & serah terima documented",
                    "Stock opname dengan scan barcode mobile-friendly",
                    "Penghapusan aset dengan approval & Maintenance korektif/preventif (jadwal otomatis & reminder)"
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
                    "Katalog buku dengan pencarian judul, pengarang, ISBN & rak buku",
                    "Eksemplar per buku dengan barcode/QR unik",
                    "Sirkulasi: pinjam, kembali (scan QR/manual), perpanjang, denda keterlambatan otomatis",
                    "Reservasi buku yang sedang dipinjam siswa lain",
                    "Kunjungan perpustakaan: check-in/out untuk statistik",
                    "Koleksi digital: upload E-Book PDF & baca via portal",
                    "Program literasi & gemar membaca: target baca per semester & log ulasan buku siswa (moderasi admin)",
                    "Dashboard & Laporan sirkulasi cetak"
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
                    "Modul & materi: PDF, video link, text, embed media",
                    "Assignment / tugas dengan deadline & submisi file siswa",
                    "Forum diskusi per kursus: thread, reply, lock, hide & moderasi",
                    "Live learning: jadwal Zoom / Google Meet & absensi live",
                    "Quiz e-learning: bank soal, random & passing grade",
                    "Progress tracking per siswa per modul & Sertifikat kursus download PDF otomatis jika lulus",
                    "Portal: daftar kursus, progress, selesaikan materi, submisi tugas, forum & reply, join live session, quiz online"
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
                    "Bank soal: pilihan ganda, benar/salah, essay, matching (multi bank per mapel & tingkat)",
                    "Ujian CBT: jadwal, durasi, acak soal & opsi jawaban",
                    "Passing grade & ujian remedial otomatis",
                    "Keamanan: fullscreen mode, tab-switch detection, snapshot camera proctor",
                    "Autosave jawaban siswa setiap 30 detik",
                    "Koreksi essay manual oleh guru",
                    "Sinkronisasi nilai ke penilaian akademik otomatis & Laporan export hasil ujian",
                    "Portal: daftar ujian, autosave jawaban, hasil"
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
                    "Landing page PPDB publik & Admin CMS (edit halaman, menu, logo, banner, FAQ, biaya, jadwal)",
                    "Registrasi akun calon siswa dengan email verification",
                    "Wizard 5 langkah: pribadi, ortu, sekolah asal, nilai, dokumen",
                    "Upload dokumen: akta, KK, ijazah, foto - dengan validasi admin",
                    "Konfirmasi pembayaran: upload bukti transfer, verifikasi admin/TU",
                    "Pengaturan gelombang pendaftaran dengan kuota & tanggal berbeda",
                    "Transfer pendaftar diterima -> data siswa master otomatis",
                    "Download isian Form SPMB oleh wali siswa dalam bentuk PDF / cetak formulir & rekap PDF export"
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
                    "Self-service warga sekolah: Beranda dashboard personal",
                    "Nilai & rapor online & Download kwitansi pembayaran PDF",
                    "Absensi: check-in/out, QR code, pengajuan izin, riwayat",
                    "E-Learning & CBT terintegrasi",
                    "Tagihan & riwayat pembayaran, Tabungan (saldo, penarikan, approval ortu), Kantin (saldo, top-up, pre-order, limit), Konseling BK (booking online), Perpustakaan (katalog, pinjaman, digital)",
                    "Multi-anak untuk orang tua: switch profil anak dengan 1 akun",
                    "Slip gaji pegawai self-service (jika wali siswa juga pegawai)",
                    "Notifikasi in-app: tagihan, ujian, pengumuman & Mobile-friendly via browser HP",
                    "Gamifikasi Amal: Pemberian badge digital ('Pejuang Subuh', dll) bagi siswa yang disiplin mengisi mutaba'ah harian",
                    "Widget & Notifikasi Islami: Kutipan hadits harian, notifikasi in-app, dan pengingat waktu ibadah"
                ],
                'sort_order' => 14
            ],
            [
                'title' => '15. Mutaba\'ah BPI & Character',
                'short_title' => 'BPI Mutaba\'ah',
                'category' => 'bpi',
                'category_name' => 'Bina Pribadi Islami',
                'icon' => '🕌',
                'badge_bg' => 'bg-amber-100 text-amber-900',
                'short_desc' => 'Laporan amal ibadah harian, validasi digital PIN ortu, Al-Mathurat dzikir & API Waktu Sholat Kemenag.',
                'full_desc' => 'Modul Bina Pribadi Islami (BPI) khas SIT Robbani. Checklist ibadah harian anak di rumah yang diawasi orang tua via PIN digital, radar chart pencapaian karakter, modul Al-Mathurat dzikir, dan pengingat waktu sholat.',
                'highlights' => [
                    "Laporan Amal Ibadah Harian: Checklist digital pelaksanaan sholat wajib, rawatib, dhuha, tahajud, tilawah, hafalan (ziyadah), puasa sunnah, dan infaq harian",
                    "Validasi & Approval Orang Tua: Ortu wajib memvalidasi (tanda tangan digital / PIN) laporan amal ibadah anak saat di rumah via Portal Ortu",
                    "Dashboard BPI (Graphical): Visualisasi radar/bar chart pencapaian amal per siswa/kelas sebagai acuan wali kelas untuk catatan perkembangan karakter di Rapor",
                    "Fitur Dzikir & Do'a Digital: Modul Al-Mathurat (pagi-petang) interaktif dengan teks Arab, terjemahan, dan counter tasbih virtual",
                    "Pengingat Sholat & Imsakiyah: Integrasi API jadwal Kemenag berbasis geolokasi sekolah. Menampilkan hitung mundur (countdown) waktu sholat di semua header portal aplikasi (Siswa, Guru, Ortu)",
                    "Amal Jariyah / Infaq Harian: Tracking donasi atau infaq siswa yang terintegrasi langsung dengan mutasi akun di Modul Keuangan sekolah"
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
                    "Users, roles, multi-sekolah dengan School Context Middleware",
                    "Branding: nama sekolah & aplikasi, tagline, upload & hapus logo sekolah, warna tema (primary, dark, accent)",
                    "Manajemen akun pengguna CRUD: reset password, suspend",
                    "Role & permission granular per modul & aksi",
                    "12+ Role bawaan siap pakai (Admin, Bendahara, Guru, BK, Wali Kelas, Ortu, Siswa, Karyawan, DLL) + bisa tambah custom role",
                    "Dashboard admin quick menu modul & role-based home redirect",
                    "Audit log aktivitas penting (opsional)",
                    "Profil user: ganti password, foto, kontak"
                ],
                'sort_order' => 16
            ],
            [
                'title' => '17. HRIS & Pengembangan SDM',
                'short_title' => 'HRIS & SDM',
                'category' => 'operasional',
                'category_name' => 'HRIS & E-Leave',
                'icon' => '👥',
                'badge_bg' => 'bg-purple-100 text-purple-800',
                'short_desc' => 'Cuti E-Leave berjenjang, PKG KPI evaluasi kinerja guru, E-Recruitment pelamar, & klaim biaya.',
                'full_desc' => 'Manajemen Sumber Daya Manusia sekolah. Menangani pengajuan cuti (E-Leave), evaluasi kinerja guru (PKG KPI) berbasis rekap jurnal KBM, tracking pelamar kerja (E-Recruitment), dan klaim operasional.',
                'highlights' => [
                    "Cuti & Perizinan (E-Leave): Pengajuan cuti (tahunan, melahirkan, sakit, haji/umrah) berjenjang via portal. Saldo cuti terupdate dan memotong komponen payroll",
                    "Manajemen Kinerja (KPI): Evaluasi kinerja pegawai (PKG), rekap jurnal KBM guru untuk bahan metrik penilaian HRD",
                    "Rekrutmen (E-Recruitment): Tracking pelamar kerja, jadwal wawancara, konversi otomatis data pelamar menjadi pegawai baru",
                    "Klaim & Reimbursement: Pengajuan dana operasional pegawai (misal: transport home visit) terintegrasi ke modul Bendahara"
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
