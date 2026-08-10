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
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Sekolah Islam Terpadu Digital Platform'),
            'hero_badge' => SiteSetting::get('hero_badge', '✨ PLATFORM MANAGEMENT SEKOLAH ISLAM TERPADU'),
            'hero_title' => SiteSetting::get('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu #1 & Terlengkap'),
            'hero_desc' => SiteSetting::get('hero_desc', 'SmartEdu menyajikan 17 Modul Produk Digital Terpadu — mengintegrasikan Akademik Adaptif (K13, Merdeka & JSIT), Presensi RFID/QR, Keuangan SPP & COA Akuntansi, POS Kantin Cashless, hingga Mutaba\'ah Yaumiyah BPI & App Mobile Banking Warga Sekolah.'),
            'bpi_badge' => SiteSetting::get('bpi_badge', '🕌 Bina Pribadi Islami (BPI)'),
            'bpi_title' => SiteSetting::get('bpi_title', 'Mutaba\'ah Yaumiyah & Al-Mathurat Digital'),
            'bpi_desc' => SiteSetting::get('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani untuk mencatat amal ibadah harian siswa di rumah (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, & Infaq) dengan validasi PIN Orang Tua.'),
        ];

        $modules = FeatureModule::orderBy('sort_order')->get();
        $faqs = FaqItem::orderBy('sort_order')->get();

        return view('welcome', compact('settings', 'modules', 'faqs'));
    }
}
