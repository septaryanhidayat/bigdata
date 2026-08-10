<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\FeatureModule;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function dashboard()
    {
        $moduleCount = FeatureModule::count();
        $faqCount = FaqItem::count();
        $recentModules = FeatureModule::orderBy('sort_order')->take(5)->get();

        return view('admin.dashboard', compact('moduleCount', 'faqCount', 'recentModules'));
    }

    public function settings()
    {
        $settings = [
            'app_name' => SiteSetting::get('app_name', 'SmartEdu'),
            'edition_title' => SiteSetting::get('edition_title', 'SmartEdu'),
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Sekolah Islam Terpadu Digital Platform'),
            'hero_badge' => SiteSetting::get('hero_badge', 'PLATFORM MANAGEMENT SEKOLAH ISLAM TERPADU'),
            'hero_title' => SiteSetting::get('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu Terpadu & Terlengkap'),
            'hero_desc' => SiteSetting::get('hero_desc', 'SmartEdu menyajikan 21 modul digital terpadu...'),
            'bpi_badge' => SiteSetting::get('bpi_badge', 'Bina Pribadi Islami & SafeSchool'),
            'bpi_title' => SiteSetting::get('bpi_title', 'Mutabaah Yaumiyah, Al-Mathurat & Sistem Anti-Bullying'),
            'bpi_desc' => SiteSetting::get('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani...'),
            
            // Sales & Pricing Section Settings
            'show_sales_section' => SiteSetting::get('show_sales_section', '1'),
            'sales_badge' => SiteSetting::get('sales_badge', 'Penawaran Spesial & Lisensi'),
            'sales_title' => SiteSetting::get('sales_title', 'Pilihan Paket Investasi & Lisensi SmartEdu'),
            'sales_desc' => SiteSetting::get('sales_desc', 'Pilih paket sesuai kebutuhan sekolah, yayasan, atau bisnis Anda. Tanpa biaya sewa bulanan, cukup sekali bayar untuk lisensi selamanya.'),
            
            'pkg1_title' => SiteSetting::get('pkg1_title', 'Paket Source Code'),
            'pkg1_price' => SiteSetting::get('pkg1_price', 'Rp 1.500.000'),
            'pkg1_desc' => SiteSetting::get('pkg1_desc', 'Cocok untuk tim IT sekolah atau pengembang yang ingin mendeploy sendiri.'),
            'pkg1_features' => SiteSetting::get('pkg1_features', "Full Source Code Laravel 13 & SQLite/MySQL\n21 Modul Digital Terpadu Siap Pakai\nFitur SafeSchool Anti-Bullying & SmartBot AI\nDokumentasi Kode & Panduan Setup DB\nHak Milik Selamanya (Tanpa Biaya Bulanan)"),
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

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $val) {
            SiteSetting::set($key, $val);
        }

        return redirect()->back()->with('success', 'Pengaturan branding dan landing page berhasil diperbarui!');
    }

    public function modules()
    {
        $modules = FeatureModule::orderBy('sort_order')->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function toggleModule($id)
    {
        $module = FeatureModule::findOrFail($id);
        $module->is_active = !$module->is_active;
        $module->save();

        $statusText = $module->is_active ? 'DITAMPILKAN' : 'DISEMBUNYIKAN';
        return redirect()->back()->with('success', "Status modul '{$module->title}' berhasil diubah menjadi {$statusText} di landing page!");
    }

    public function createModule()
    {
        return view('admin.modules.create');
    }

    public function storeModule(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_title' => 'nullable|string|max:100',
            'category' => 'required|string',
            'category_name' => 'required|string',
            'icon' => 'required|string',
            'badge_bg' => 'nullable|string',
            'short_desc' => 'required|string',
            'full_desc' => 'required|string',
            'highlights_text' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $highlights = array_values(array_filter(array_map('trim', explode("\n", $validated['highlights_text']))));

        FeatureModule::create([
            'title' => $validated['title'],
            'short_title' => $validated['short_title'] ?? $validated['title'],
            'category' => $validated['category'],
            'category_name' => $validated['category_name'],
            'icon' => $validated['icon'],
            'badge_bg' => $validated['badge_bg'] ?? 'bg-emerald-100 text-emerald-800',
            'short_desc' => $validated['short_desc'],
            'full_desc' => $validated['full_desc'],
            'highlights' => $highlights,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul fitur baru berhasil ditambahkan!');
    }

    public function editModule($id)
    {
        $module = FeatureModule::findOrFail($id);
        return view('admin.modules.edit', compact('module'));
    }

    public function updateModule(Request $request, $id)
    {
        $module = FeatureModule::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_title' => 'nullable|string|max:100',
            'category' => 'required|string',
            'category_name' => 'required|string',
            'icon' => 'required|string',
            'badge_bg' => 'nullable|string',
            'short_desc' => 'required|string',
            'full_desc' => 'required|string',
            'highlights_text' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        $highlights = array_values(array_filter(array_map('trim', explode("\n", $validated['highlights_text']))));

        $module->update([
            'title' => $validated['title'],
            'short_title' => $validated['short_title'] ?? $validated['title'],
            'category' => $validated['category'],
            'category_name' => $validated['category_name'],
            'icon' => $validated['icon'],
            'badge_bg' => $validated['badge_bg'] ?? 'bg-emerald-100 text-emerald-800',
            'short_desc' => $validated['short_desc'],
            'full_desc' => $validated['full_desc'],
            'highlights' => $highlights,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.modules.index')->with('success', 'Modul fitur berhasil diperbarui!');
    }

    public function destroyModule($id)
    {
        $module = FeatureModule::findOrFail($id);
        $module->delete();

        return redirect()->route('admin.modules.index')->with('success', 'Modul fitur berhasil dihapus!');
    }

    public function faqs()
    {
        $faqs = FaqItem::orderBy('sort_order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
        ]);

        FaqItem::create([
            'question' => $validated['question'],
            'answer' => $validated['answer'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function destroyFaq($id)
    {
        $faq = FaqItem::findOrFail($id);
        $faq->delete();

        return redirect()->back()->with('success', 'FAQ berhasil dihapus!');
    }
}
