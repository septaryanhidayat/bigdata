<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\AiRagEngine;

class AiKnowledgeSeeder extends Seeder
{
    /**
     * Seed initial knowledge base documents for AI RAG Engine
     */
    public function run(): void
    {
        $docs = [
            [
                'title' => 'Brosur & Panduan Pendaftaran SPMB 2026/2027 SIT Robbani',
                'category' => 'spmb',
                'content' => "Penerimaan Santri Baru (SPMB) SIT Robbani Ogan Ilir Tahun Ajaran 2026/2027 dibuka melalui 3 Jalur:\n" .
                             "1. Jalur Prestasi (Bebas Tes Akademik & Diskon Infaq 50% untuk Juara MTQ / OSN minimal tingkat Kabupaten).\n" .
                             "2. Jalur Reguler (Tes Observasi Kesiapan Belajar, Wawancara Orang Tua, dan Tes Membaca Al-Qur'an).\n" .
                             "3. Jalur Afirmasi Yatim & Dhuafa (Beasiswa Penuh Pendidikan dari LAZIS Robbani).\n\n" .
                             "Syarat Berkas:\n" .
                             "- Fotokopi Akta Kelahiran (2 lembar)\n" .
                             "- Fotokopi Kartu Keluarga (KK) & KTP Orang Tua\n" .
                             "- Pas Foto 3x4 berwarna (4 lembar)\n" .
                             "- Surat Keterangan Lulus / NISN dari sekolah asal\n\n" .
                             "Jadwal Gelombang 1: 1 Oktober - 31 Desember 2025\n" .
                             "Jadwal Gelombang 2: 2 Januari - 31 Maret 2026\n" .
                             "Pendaftaran online dapat diakses di menu /ppdb atau melalui WhatsApp Panitia di 0811747472.",
            ],
            [
                'title' => 'Kurikulum Tahfidz Al-Qur\'an & Target Capaian Santri',
                'category' => 'kurikulum',
                'content' => "Program Unggulan Tahfidz Al-Qur'an SIT Robbani Ogan Ilir menggunakan Metode Talaqqi, Tikrar, dan Tasmi' Terpadu:\n" .
                             "• KB/TKIT: Target Hafalan Juz 30 (Surat An-Nas s/d Ad-Dhuha) + 20 Hadits Pilihan + Doa Harian.\n" .
                             "• SDIT: Target Lulus Minimal 3 Juz (Juz 30, Juz 29, dan Juz 28) dengan Tajwid & Makharijul Huruf bersanad.\n" .
                             "• SMPIT: Target Lulus Minimal 5 Juz (Juz 1 s/d Juz 5) serta Mutaba'ah Tilawah 1 Juz per Hari (One Day One Juz).\n" .
                             "• SMAIT: Program Takhassus Tahfidz 10 - 30 Juz untuk persiapan beasiswa Timur Tengah dan PTN jalur Hafidz Qur'an.\n\n" .
                             "Setiap semester diadakan Haflah Akhirussanah & Wisuda Tahfidz Qur'an disaksikan orang tua santri.",
            ],
            [
                'title' => 'Tata Tertib, Seragam & SOP Santri SIT Robbani',
                'category' => 'sop',
                'content' => "Standar Operasional Prosedur (SOP) Kehidupan Santri di Kampus SIT Robbani:\n" .
                             "1. Jam Kedatangan: Pukul 06.45 WIB untuk mengikuti Dhuha Berjamaah & Zikir Pagi Al-Ma'tsurat.\n" .
                             "2. Jam Kepulangan: Pukul 15.30 WIB (Fullday School) setelah Shalat Ashar Berjamaah.\n" .
                             "3. Seragam Sekolah:\n" .
                             "   - Senin & Selasa: Seragam Putih Hijau Khas Robbani + Jilbab Syar'i / Peci Hitam.\n" .
                             "   - Rabu: Seragam Batik Robbani.\n" .
                             "   - Kamis: Seragam Pramuka SIT.\n" .
                             "   - Jumat: Seragam Olahraga / Gamis Putih.\n" .
                             "4. Aturan Digital & Gadget: Santri tidak diperkenankan membawa smartphone kecuali pada hari pembelajaran digital menggunakan iPad / Laptop di Lab Multimedia.",
            ],
            [
                'title' => 'Panduan Pembayaran SPP Online & E-Wallet SmartEdu',
                'category' => 'keuangan',
                'content' => "SIT Robbani menerapkan sistem pembayaran SPP Cashless & Realtime melalui Portal SmartEdu E-SPP:\n" .
                             "1. Buka halaman web menu /e-spp pada website utama.\n" .
                             "2. Masukkan NIS / NISN santri.\n" .
                             "3. Sistem akan menampilkan rincian tagihan (SPP Bulanan, Katering, Antar Jemput, Kegiatan).\n" .
                             "4. Klik tombol 'Bayar Online' untuk mendapatkan Virtual Account (BSI, Bank Mandiri, BRI, BCA, BNI) atau QRIS.\n" .
                             "5. Setelah pembayaran berhasil, kuitansi digital otomatis terbit dan tercatat di buku tabungan santri.",
            ],
        ];

        foreach ($docs as $d) {
            AiRagEngine::ingestDocument($d['title'], $d['category'], $d['content']);
        }
    }
}
