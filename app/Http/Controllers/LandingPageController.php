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
            'hero_title' => SiteSetting::get('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu Terpadu & Terlengkap'),
            'hero_desc' => SiteSetting::get('hero_desc', 'SmartEdu menyajikan 21 modul digital terpadu yang mengintegrasikan akademik adaptif K13, Kurikulum Merdeka, dan JSIT, presensi RFID/QR, keuangan SPP & akuntansi COA, POS kantin cashless, sistem anti-bullying, chatbot AI 24/7, tracer study alumni, hingga mutabaah yaumiyah BPI.'),
            'bpi_badge' => SiteSetting::get('bpi_badge', 'Bina Pribadi Islami & SafeSchool'),
            'bpi_title' => SiteSetting::get('bpi_title', 'Mutabaah Yaumiyah, Al-Mathurat & Sistem Anti-Bullying'),
            'bpi_desc' => SiteSetting::get('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani untuk pembentukan karakter siswa (Sholat 5 waktu, Dhuha, Tahajud, Tilawah, Hafalan Ziyadah, dan Infaq) serta sistem perlindungan siswa SafeSchool dengan Panic Alarm darurat.'),
        ];

        $modules = FeatureModule::orderBy('sort_order')->get();
        $faqs = FaqItem::orderBy('sort_order')->get();

        return view('welcome', compact('settings', 'modules', 'faqs'));
    }
}
