<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\FeatureModule;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => SiteSetting::get('app_name', 'SmartEdu'),
            'edition_title' => SiteSetting::get('edition_title', 'SmartEdu'),
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Platform Digital Sekolah Islam Terpadu'),
            'hero_badge' => SiteSetting::get('hero_badge', 'PLATFORM MANAJEMEN SEKOLAH ISLAM TERPADU'),
            'hero_title' => SiteSetting::get('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu & Terlengkap'),
            'hero_desc' => SiteSetting::get('hero_desc', 'SmartEdu menyajikan 25 modul digital terpadu yang mengintegrasikan akademik adaptif K13, Kurikulum Merdeka, dan JSIT, presensi RFID/QR, keuangan SPP & akuntansi COA, POS kantin cashless, sistem anti-bullying, chatbot AI 24/7, tracer study alumni, e-arsip persuratan, hingga layanan publik mandiri.'),
            'bpi_badge' => SiteSetting::get('bpi_badge', 'Bina Pribadi Islami & SafeSchool'),
            'bpi_title' => SiteSetting::get('bpi_title', 'Mutabaah Yaumiyah, Al-Mathurat & Sistem Anti-Bullying'),
            'bpi_desc' => SiteSetting::get('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani untuk pembentukan karakter siswa (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, dan Infaq) serta sistem perlindungan siswa SafeSchool dengan Panic Alarm darurat.'),
            
            // Sales & Pricing Settings
            'show_sales_section' => SiteSetting::get('show_sales_section', '1'),
            'sales_badge' => SiteSetting::get('sales_badge', 'Penawaran Spesial & Lisensi'),
            'sales_title' => SiteSetting::get('sales_title', 'Pilihan Paket Investasi & Lisensi SmartEdu'),
            'sales_desc' => SiteSetting::get('sales_desc', 'Pilih paket sesuai kebutuhan sekolah, yayasan, atau bisnis Anda. Tanpa biaya sewa bulanan, cukup sekali bayar untuk lisensi selamanya.'),
            
            'pkg1_title' => SiteSetting::get('pkg1_title', 'Paket Source Code'),
            'pkg1_price' => SiteSetting::get('pkg1_price', 'Rp 1.500.000'),
            'pkg1_desc' => SiteSetting::get('pkg1_desc', 'Cocok untuk tim IT sekolah atau pengembang yang ingin mendeploy sendiri.'),
            'pkg1_features' => SiteSetting::get('pkg1_features', "Full Source Code Laravel 13 & SQLite/MySQL\n25 Modul Digital Terpadu Siap Pakai\nFitur SafeSchool Anti-Bullying & SmartBot AI\nDokumentasi Kode & Panduan Setup DB\nHak Milik Selamanya (Tanpa Biaya Bulanan)"),
            'pkg1_link' => SiteSetting::get('pkg1_link', 'https://wa.me/6281234567890?text=Halo%20SmartEdu,%20saya%20tertarik%20membeli%20Paket%20Source%20Code%201,5%20Juta'),
            
            'pkg2_title' => SiteSetting::get('pkg2_title', 'Paket Server + Reseller'),
            'pkg2_price' => SiteSetting::get('pkg2_price', 'Rp 3.000.000'),
            'pkg2_badge' => SiteSetting::get('pkg2_badge', '🔥 BEST SELLER & RESELLER READY'),
            'pkg2_desc' => SiteSetting::get('pkg2_desc', 'Solusi lengkap siap pakai untuk sekolah + lisensi hak jual kembali!'),
            'pkg2_features' => SiteSetting::get('pkg2_features', "Semua Fitur Paket Source Code 1,5 Juta\nFREE Setup & Deploy Server VPS/Cloud Sampai Live\nPaket Hak Jual Kembali / Reseller Affiliate (Profit 100%)\nCustom Branding Logo & Nama Sekolah Anda\nSupport Priority WhatsApp Direct 24/7\nFree Update Patch & Bug Fix 1 Tahun"),
            'pkg2_link' => SiteSetting::get('pkg2_link', 'https://wa.me/6281234567890?text=Halo%20SmartEdu,%20saya%20tertarik%20membeli%20Paket%20Complete%20Server%20%2B%20Reseller%203%20Juta'),
            
            'pkg3_title' => SiteSetting::get('pkg3_title', 'Paket Enterprise Yayasan'),
            'pkg3_price' => SiteSetting::get('pkg3_price', 'Rp 5.500.000'),
            'pkg3_desc' => SiteSetting::get('pkg3_desc', 'Didesain khusus untuk yayasan dengan banyak unit/cabang sekolah.'),
            'pkg3_features' => SiteSetting::get('pkg3_features', "Semua Fitur Paket 3 Juta Complete\nGratis Domain .sch.id Selama 1 Tahun\nLisensi Multi-Sekolah / Cabang Yayasan\nTraining Pembekalan Zoom untuk Admin & Guru (1 Bulan)\nMaintenance Server & Backup Data Otomatis\nRequest Penyesuaian Modul Fitur Custom"),
            'pkg3_link' => SiteSetting::get('pkg3_link', 'https://wa.me/6281234567890?text=Halo%20SmartEdu,%20saya%20tertarik%20konsultasi%20Paket%20Enterprise%20Yayasan'),
        ];

        $modules = FeatureModule::where('is_active', true)->orderBy('sort_order')->get();
        $faqs = FaqItem::orderBy('sort_order')->get();

        return view('welcome', compact('settings', 'modules', 'faqs'));
    }
}
