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
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Sekolah Islam Terpadu Digital Platform'),
            'hero_badge' => SiteSetting::get('hero_badge', '✨ PLATFORM MANAGEMENT SEKOLAH ISLAM TERPADU'),
            'hero_title' => SiteSetting::get('hero_title', 'Ekosistem Digital Sekolah Islam Terpadu #1 & Terlengkap'),
            'hero_desc' => SiteSetting::get('hero_desc', 'SmartEdu menyajikan 17 Modul Produk Digital Terpadu...'),
            'bpi_badge' => SiteSetting::get('bpi_badge', '🕌 Bina Pribadi Islami (BPI)'),
            'bpi_title' => SiteSetting::get('bpi_title', 'Mutaba\'ah Yaumiyah & Al-Mathurat Digital'),
            'bpi_desc' => SiteSetting::get('bpi_desc', 'Fitur khas Sekolah Islam Terpadu Robbani...'),
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
