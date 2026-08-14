<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\FeatureModule;
use App\Models\FaqItem;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Classroom;
use App\Models\School;
use App\Models\Attendance;
use App\Models\SppBill;
use App\Models\SppPayment;
use App\Models\SavingsTransaction;
use App\Models\CanteenTransaction;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function dashboard(Request $request)
    {
        $schoolId = $request->get('school_id', session('dashboard_school_id', 'all'));
        session(['dashboard_school_id' => $schoolId]);

        $allSchools = School::all();
        $activeSchoolObj = ($schoolId !== 'all') ? School::find($schoolId) : null;

        $studentsQuery = Student::query();
        $teachersQuery = Employee::where('role_type', 'TEACHER');
        $staffQuery = Employee::where('role_type', 'STAFF');
        $classroomsQuery = Classroom::query();
        $subjectsQuery = \App\Models\Subject::query();
        $attendanceQuery = Attendance::query();
        $sppBillQuery = SppBill::query();
        $sppPaymentQuery = SppPayment::query();
        $canteenQuery = CanteenTransaction::query();

        if ($schoolId !== 'all') {
            $studentsQuery->where('school_id', $schoolId);
            $teachersQuery->where('school_id', $schoolId);
            $staffQuery->where('school_id', $schoolId);
            $classroomsQuery->where('school_id', $schoolId);
            $subjectsQuery->where('school_id', $schoolId);
            $attendanceQuery->where('school_id', $schoolId);
            $sppBillQuery->where('school_id', $schoolId);
            $sppPaymentQuery->whereHas('sppBill', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
            $canteenQuery->whereHas('canteenOutlet', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
        }

        $moduleCount = FeatureModule::count();
        $faqCount = FaqItem::count();
        $schoolsCount = $allSchools->count();
        $studentsCount = $studentsQuery->where('status', 'ACTIVE')->count();
        $teachersCount = $teachersQuery->count();
        $staffCount = $staffQuery->count();
        $classroomsCount = $classroomsQuery->count();
        $subjectsCount = $subjectsQuery->count();

        // Presensi Stats Today
        $today = date('Y-m-d');
        $todayAttendance = (clone $attendanceQuery)->where('date', $today)->get();
        $presentToday = $todayAttendance->where('status', 'HADIR')->count();
        $lateToday = $todayAttendance->where('status', 'TERLAMBAT')->count();
        $leaveToday = $todayAttendance->whereIn('status', ['IZIN', 'SAKIT'])->count();
        $absentToday = max(0, $studentsCount - ($presentToday + $lateToday + $leaveToday));

        // Finance Stats
        $sppTotalPaid = $sppPaymentQuery->sum('amount_paid');
        $sppBillsCount = (clone $sppBillQuery)->count();
        $sppBillsPaidCount = (clone $sppBillQuery)->where('status', 'PAID')->count();
        $sppBillsUnpaidCount = (clone $sppBillQuery)->whereIn('status', ['UNPAID', 'PARTIAL'])->count();

        $totalSavings = (clone $studentsQuery)->sum('savings_balance');
        $canteenSalesToday = $canteenQuery->sum('total_amount');

        // Realtime 10 Attendance Logs
        $recentAttendanceLogs = (clone $attendanceQuery)->with(['student.school', 'student.classroom'])
            ->latest()
            ->take(10)
            ->get();

        // Realtime 10 Transactions
        $recentTransactions = (clone $canteenQuery)->with(['student.school', 'canteenOutlet'])
            ->latest()
            ->take(10)
            ->get();

        // Schools Distribution for Chart
        $schools = School::withCount('students')->get();
        $schoolNames = $schools->pluck('name')->toArray();
        $schoolStudentCounts = $schools->pluck('students_count')->toArray();

        $recentModules = FeatureModule::orderBy('sort_order')->take(5)->get();

        return view('admin.dashboard', compact(
            'schoolId', 'allSchools', 'activeSchoolObj',
            'moduleCount', 'faqCount', 'schoolsCount', 'studentsCount', 
            'teachersCount', 'staffCount', 'classroomsCount', 'subjectsCount',
            'presentToday', 'lateToday', 'leaveToday', 'absentToday',
            'sppTotalPaid', 'sppBillsCount', 'sppBillsPaidCount', 'sppBillsUnpaidCount',
            'totalSavings', 'canteenSalesToday',
            'recentAttendanceLogs', 'recentTransactions',
            'schoolNames', 'schoolStudentCounts', 'recentModules'
        ));
    }

    public function settingsPortal()
    {
        $settings = [
            'website_theme' => SiteSetting::get('website_theme', 'theme-emerald'),
            'app_name' => SiteSetting::get('app_name', 'SmartEdu'),
            'school_name' => SiteSetting::get('school_name', 'Sekolah Islam Terpadu Robbani'),
            'tagline' => SiteSetting::get('tagline', 'Sekolah Islam Terpadu Digital Platform'),
            'school_hero_badge' => SiteSetting::get('school_hero_badge', '✨ YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI'),
            'school_hero_title' => SiteSetting::get('school_hero_title', 'Pendidikan Karakter Islami & Keunggulan Akademik Digital'),
            'school_hero_desc' => SiteSetting::get('school_hero_desc', 'Sekolah Islam Terpadu Robbani menyelenggarakan pendidikan terpadu dari jenjang TK, SD, SMP hingga SMA dengan Kurikulum Merdeka, Kekhasan JSIT, Pembiasaan Al-Qur\'an (Tahfidz), Mutaba\'ah BPI, dan Platform Digital SmartEdu.'),
            'principal_name' => SiteSetting::get('principal_name', 'Ustadz Ahmad Fauzi, S.Pd.I, M.Pd'),
            'principal_title' => SiteSetting::get('principal_title', 'Ketua Yayasan / Kepala Sekolah SIT Robbani'),
            'principal_greeting' => SiteSetting::get('principal_greeting', 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Sekolah Islam Terpadu Robbani. Kami berkomitmen mendidik ananda menjadi pribadi beriman, bertakwa, berakhlak karimah, serta siap menghadapi era digital.'),
            'ppdb_status' => SiteSetting::get('ppdb_status', 'GELOMBANG 1 DIBUKA'),
            'ppdb_desc' => SiteSetting::get('ppdb_desc', 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 telah dibuka untuk jenjang TK, SDIT, SMPIT, & SMAIT.'),
            'contact_phone' => SiteSetting::get('contact_phone', '0812-3456-7890'),
            'contact_email' => SiteSetting::get('contact_email', 'info@robbani.sch.id'),
            'contact_address' => SiteSetting::get('contact_address', 'Jl. Pendidikan Karakter No. 1-2, Kota Bandung, Jawa Barat'),
            'hero_bg_image' => SiteSetting::get('hero_bg_image', 'https://images.unsplash.com/photo-1542810634-71277d95dcbb?q=80&w=1600'),
            'hero_banner_opacity' => SiteSetting::get('hero_banner_opacity', '70'),
        ];

        return view('admin.settings.portal', compact('settings'));
    }

    public function settingsSales()
    {
        $settings = [
            'show_sales_section' => SiteSetting::get('show_sales_section', '1'),
            'sales_badge' => SiteSetting::get('sales_badge', 'Penawaran Spesial & Lisensi'),
            'sales_title' => SiteSetting::get('sales_title', 'Pilihan Paket Investasi & Lisensi SmartEdu'),
            'sales_desc' => SiteSetting::get('sales_desc', 'Pilih paket sesuai kebutuhan sekolah, yayasan, atau bisnis Anda. Tanpa biaya sewa bulanan, cukup sekali bayar untuk lisensi selamanya.'),
            'pkg1_title' => SiteSetting::get('pkg1_title', 'Paket Source Code'),
            'pkg1_price' => SiteSetting::get('pkg1_price', 'Rp 1.500.000'),
            'pkg1_desc' => SiteSetting::get('pkg1_desc', 'Cocok untuk tim IT sekolah atau pengembang yang ingin mendeploy sendiri.'),
            'pkg1_features' => SiteSetting::get('pkg1_features', "Full Source Code Laravel 13 & SQLite/MySQL\n21 Modul Digital Terpadu Siap Pakai\nFitur SafeSchool Anti-Bullying & SmartBot AI\nHak Milik Selamanya (Tanpa Biaya Bulanan)"),
            'pkg2_title' => SiteSetting::get('pkg2_title', 'Paket Server + Reseller'),
            'pkg2_price' => SiteSetting::get('pkg2_price', 'Rp 3.000.000'),
            'pkg2_badge' => SiteSetting::get('pkg2_badge', '🔥 BEST SELLER & RESELLER READY'),
            'pkg2_desc' => SiteSetting::get('pkg2_desc', 'Solusi lengkap siap pakai untuk sekolah + lisensi hak jual kembali!'),
            'pkg2_features' => SiteSetting::get('pkg2_features', "Semua Fitur Paket Source Code 1,5 Juta\nFREE Setup & Deploy Server VPS/Cloud Sampai Live\nPaket Hak Jual Kembali / Reseller Affiliate (Profit 100%)\nCustom Branding Logo & Nama Sekolah Anda"),
            'pkg3_title' => SiteSetting::get('pkg3_title', 'Paket Enterprise Yayasan'),
            'pkg3_price' => SiteSetting::get('pkg3_price', 'Rp 5.500.000'),
            'pkg3_desc' => SiteSetting::get('pkg3_desc', 'Didesain khusus untuk yayasan dengan banyak unit/cabang sekolah.'),
            'pkg3_features' => SiteSetting::get('pkg3_features', "Semua Fitur Paket 3 Juta Complete\nGratis Domain .sch.id Selama 1 Tahun\nLisensi Multi-Sekolah / Cabang Yayasan\nTraining Pembekalan Zoom untuk Admin & Guru (1 Bulan)"),
        ];

        return view('admin.settings.sales', compact('settings'));
    }

    public function settingsUnits()
    {
        $schools = School::withCount(['students', 'employees', 'classrooms'])->get();
        return view('admin.settings.units', compact('schools'));
    }

    public function editUnitProfile($code)
    {
        $cleanCode = strtolower(trim($code));
        $schoolObj = School::where('code', strtoupper($cleanCode))->first();
        
        $unitSetting = SiteSetting::get("unit_profile_{$cleanCode}");
        $unitData = $unitSetting ? json_decode($unitSetting, true) : [];

        return view('admin.settings.unit_edit', compact('cleanCode', 'schoolObj', 'unitData'));
    }

    public function updateUnitProfile(Request $request, $code)
    {
        $cleanCode = strtolower(trim($code));

        $data = [
            'name' => $request->input('name'),
            'code' => strtoupper($cleanCode),
            'npsn' => $request->input('npsn'),
            'akreditasi' => $request->input('akreditasi'),
            'tagline' => $request->input('tagline'),
            'principal_name' => $request->input('principal_name'),
            'principal_title' => $request->input('principal_title'),
            'principal_greeting' => $request->input('principal_greeting'),
            'description' => $request->input('description'),
            'vision' => $request->input('vision'),
            'missions' => array_values(array_filter(array_map('trim', explode("\n", $request->input('missions_text'))))),
            'phone' => $request->input('phone'),
            'students_count' => (int) $request->input('students_count'),
            'employees_count' => (int) $request->input('employees_count'),
            'classrooms_count' => (int) $request->input('classrooms_count'),
            'target_hafalan' => $request->input('target_hafalan'),
        ];

        // Handle Kepsek Photo upload if present
        if ($request->hasFile('principal_photo')) {
            $compressedPhoto = \App\Services\ImageOptimizer::compress($request->file('principal_photo'), 'uploads/cms', 'kepsek_' . $cleanCode . '_' . uniqid());
            if ($compressedPhoto) {
                $data['principal_photo'] = $compressedPhoto . '?v=' . time();
            }
        } else {
            $existing = SiteSetting::get("unit_profile_{$cleanCode}");
            if ($existing) {
                $exData = json_decode($existing, true);
                if (isset($exData['principal_photo'])) {
                    $data['principal_photo'] = $exData['principal_photo'];
                }
            }
        }

        SiteSetting::set("unit_profile_{$cleanCode}", json_encode($data));

        return redirect()->route('admin.settings.units')->with('success', "Profil Unit " . strtoupper($cleanCode) . " berhasil diperbarui secara mandiri!");
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');
        $fileUploaded = false;

        // 1. Process client-compressed base64 payload
        if ($request->filled('hero_bg_base64')) {
            $base64Data = $request->input('hero_bg_base64');
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Data)) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
                $decoded = base64_decode($base64Data);

                if ($decoded !== false) {
                    $folder = public_path('uploads/cms');
                    if (!file_exists($folder)) {
                        mkdir($folder, 0755, true);
                    }
                    $filename = 'hero_bg_' . uniqid() . '_' . time() . '.webp';
                    $fullPath = $folder . '/' . $filename;
                    file_put_contents($fullPath, $decoded);

                    $pathWithCacheBuster = '/uploads/cms/' . $filename . '?v=' . time();
                    SiteSetting::set('hero_bg_image', $pathWithCacheBuster);
                    $data['hero_bg_image'] = $pathWithCacheBuster;
                    $fileUploaded = true;
                }
            }
        }
        // 2. Fallback to direct file upload
        elseif ($request->hasFile('hero_bg_file')) {
            $compressedPath = \App\Services\ImageOptimizer::compress($request->file('hero_bg_file'), 'uploads/cms', 'hero_bg_' . uniqid());
            if ($compressedPath) {
                $pathWithCacheBuster = $compressedPath . '?v=' . time();
                SiteSetting::set('hero_bg_image', $pathWithCacheBuster);
                $data['hero_bg_image'] = $pathWithCacheBuster;
                $fileUploaded = true;
            }
        }

        foreach ($data as $key => $val) {
            if (in_array($key, ['hero_bg_file', 'hero_bg_base64'])) {
                continue;
            }
            SiteSetting::set($key, $val);
        }

        return redirect()->back()->with('success', 'Pengaturan branding, gambar hero banner, dan opacity berhasil diperbarui!');
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

    public function contentIndex(Request $request)
    {
        $schoolWebsiteCtrl = new \App\Http\Controllers\SchoolWebsiteController();
        
        $newsList = $schoolWebsiteCtrl->getNewsData();
        $videoList = $schoolWebsiteCtrl->getVideoData();
        $agendaList = $schoolWebsiteCtrl->getAgendaData();
        $announcementList = $schoolWebsiteCtrl->getAnnouncementData();
        $facilityList = $schoolWebsiteCtrl->getFacilityData();
        $galleryList = $schoolWebsiteCtrl->getGalleryData();
        $headerMenus = $schoolWebsiteCtrl->getHeaderMenus();

        $heroSettings = [
            'hero_badge' => SiteSetting::get('hero_badge', '✨ Penerimaan Peserta Didik Baru (PPDB) 2026/2027'),
            'hero_title' => SiteSetting::get('hero_title', 'Taman Pendidikan & Sekolah Islam Terpadu Robbani'),
            'hero_desc' => SiteSetting::get('hero_desc', 'Mencetak Generasi Qur\'ani, Berakhlak Mulia, Cerdas, dan Berprestasi Nasional di Kabupaten Ogan Ilir, Sumatera Selatan.'),
            'hero_bg_image' => SiteSetting::get('hero_bg_image', 'https://lh3.googleusercontent.com/aida/AP1WRLuf5i7pWfq9dzqqqjNB6dJ3JNiFjsv6Iv0erwSW9QTXek-Ur1VI-e_ULP2zi3qLQIbKln9GGYMrKRcDMpgsk8uELhhqxDf4J0N_tZ3ObFRa1UmfynfH5wzEfpsoQwZd8ofmDXnfj0-gwTaJjxlH2Gt_qt3XIBHF0DtXovfyqeC4E7-y7dd3rgARHyA57tjdlEywmGuLbJ1q3jagkMiPIv2sK3XpKR-CEw_Kr3hiDZtYNpxD6JtANagJSWCU'),
        ];

        $activeTab = $request->get('tab', 'hero');

        return view('admin.cms.content', compact(
            'newsList', 'videoList', 'agendaList', 'announcementList', 'facilityList', 'galleryList', 'headerMenus', 'heroSettings', 'activeTab'
        ));
    }

    public function updateCmsContent(Request $request)
    {
        $module = $request->input('module');

        if ($module === 'hero') {
            SiteSetting::set('hero_badge', $request->input('hero_badge', ''));
            SiteSetting::set('hero_title', $request->input('hero_title', ''));
            SiteSetting::set('hero_desc', $request->input('hero_desc', ''));

            if ($request->hasFile('hero_bg_file')) {
                $file = $request->file('hero_bg_file');
                $filename = 'hero_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/cms'), $filename);
                SiteSetting::set('hero_bg_image', '/uploads/cms/' . $filename);
            } elseif ($request->filled('hero_bg_image')) {
                SiteSetting::set('hero_bg_image', $request->input('hero_bg_image'));
            }

            return redirect()->route('admin.cms.content', ['tab' => 'hero'])->with('success', 'Banner Hero & Gambar Background Sekolah berhasil diperbarui!');
        }

        if ($module === 'menu') {
            $menus = $request->input('menus', []);
            $formattedMenus = [];
            foreach ($menus as $m) {
                if (!empty($m['title'])) {
                    $formattedMenus[] = [
                        'title' => $m['title'],
                        'url' => $m['url'] ?? '#',
                        'is_active' => isset($m['is_active']) && $m['is_active'] == '1' ? true : false,
                    ];
                }
            }
            SiteSetting::set('cms_header_menus', json_encode(array_values($formattedMenus)));
            return redirect()->route('admin.cms.content', ['tab' => 'menu'])->with('success', 'Pengaturan Menu Header berhasil diperbarui!');
        }

        $jsonItems = $request->input('items');

        if ($module && is_array($jsonItems)) {
            SiteSetting::set('cms_' . $module . '_data', json_encode(array_values($jsonItems)));
            return redirect()->route('admin.cms.content', ['tab' => $module])->with('success', "Data " . ucfirst($module) . " berhasil diperbarui!");
        }

        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }

    public function addCmsItem(Request $request)
    {
        $module = $request->input('module');
        $schoolWebsiteCtrl = new \App\Http\Controllers\SchoolWebsiteController();

        if ($module === 'menu') {
            $currentData = $schoolWebsiteCtrl->getHeaderMenus();
            $newItem = [
                'title' => $request->input('title', 'Menu Baru'),
                'url' => $request->input('url', '#'),
                'is_active' => true,
            ];
            $currentData[] = $newItem;
            SiteSetting::set('cms_header_menus', json_encode(array_values($currentData)));
            return redirect()->route('admin.cms.content', ['tab' => 'menu'])->with('success', 'Menu header baru berhasil ditambahkan!');
        }

        $currentData = [];
        if ($module === 'news') $currentData = $schoolWebsiteCtrl->getNewsData();
        elseif ($module === 'video') $currentData = $schoolWebsiteCtrl->getVideoData();
        elseif ($module === 'agenda') $currentData = $schoolWebsiteCtrl->getAgendaData();
        elseif ($module === 'announcement') $currentData = $schoolWebsiteCtrl->getAnnouncementData();
        elseif ($module === 'facility') $currentData = $schoolWebsiteCtrl->getFacilityData();
        elseif ($module === 'gallery') $currentData = $schoolWebsiteCtrl->getGalleryData();

        $newItem = $request->except(['_token', 'module', 'image_file', 'thumbnail_file']);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = $module . '_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cms'), $filename);
            $newItem['image'] = '/uploads/cms/' . $filename;
        }

        if ($request->hasFile('thumbnail_file')) {
            $file = $request->file('thumbnail_file');
            $filename = 'thumb_' . time() . '_' . \Illuminate\Support\Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/cms'), $filename);
            $newItem['thumbnail'] = '/uploads/cms/' . $filename;
        }
        
        // Auto-generate slug if news
        if ($module === 'news' && !empty($newItem['title'])) {
            $newItem['slug'] = \Illuminate\Support\Str::slug($newItem['title']);
        }

        array_unshift($currentData, $newItem);
        SiteSetting::set('cms_' . $module . '_data', json_encode(array_values($currentData)));

        return redirect()->route('admin.cms.content', ['tab' => $module])->with('success', 'Item baru berhasil ditambahkan!');
    }

    public function deleteCmsItem(Request $request)
    {
        $module = $request->input('module');
        $index = (int) $request->input('index');
        
        $schoolWebsiteCtrl = new \App\Http\Controllers\SchoolWebsiteController();

        if ($module === 'menu') {
            $currentData = $schoolWebsiteCtrl->getHeaderMenus();
            if (isset($currentData[$index])) {
                array_splice($currentData, $index, 1);
                SiteSetting::set('cms_header_menus', json_encode(array_values($currentData)));
                return redirect()->route('admin.cms.content', ['tab' => 'menu'])->with('success', 'Menu header berhasil dihapus!');
            }
        }

        $currentData = [];
        if ($module === 'news') $currentData = $schoolWebsiteCtrl->getNewsData();
        elseif ($module === 'video') $currentData = $schoolWebsiteCtrl->getVideoData();
        elseif ($module === 'agenda') $currentData = $schoolWebsiteCtrl->getAgendaData();
        elseif ($module === 'announcement') $currentData = $schoolWebsiteCtrl->getAnnouncementData();
        elseif ($module === 'facility') $currentData = $schoolWebsiteCtrl->getFacilityData();
        elseif ($module === 'gallery') $currentData = $schoolWebsiteCtrl->getGalleryData();

        if (isset($currentData[$index])) {
            array_splice($currentData, $index, 1);
            SiteSetting::set('cms_' . $module . '_data', json_encode(array_values($currentData)));
            return redirect()->route('admin.cms.content', ['tab' => $module])->with('success', 'Item berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan.');
    }
}

