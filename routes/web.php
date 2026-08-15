<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\AuthController;

use App\Http\Controllers\SchoolWebsiteController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\AcademicController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\SavingsController;
use App\Http\Controllers\Admin\CanteenController;
use App\Http\Controllers\Admin\BpiController;
use App\Http\Controllers\Admin\HrisPayrollController;
use App\Http\Controllers\Admin\CbtPpdbController;
use App\Http\Controllers\Admin\SarprasController;
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\LmsController;
use App\Http\Controllers\Admin\BkController;

// ==========================================================================
// SUBDOMAIN ROUTING (spmb.sitrobbani.sch.id, tk/sd/smp/sma.sitrobbani.sch.id)
// ==========================================================================
Route::domain('spmb.sitrobbani.sch.id')->group(function () {
    Route::get('/', [SchoolWebsiteController::class, 'ppdbForm'])->name('subdomain.spmb');
    Route::post('/', [SchoolWebsiteController::class, 'storePpdb']);
});

Route::domain('{subdomain}.sitrobbani.sch.id')->group(function () {
    Route::get('/', function ($subdomain) {
        $map = [
            'tk' => 'tkit',
            'tkit' => 'tkit',
            'sd' => 'sdit',
            'sdit' => 'sdit',
            'smp' => 'smpit',
            'smpit' => 'smpit',
            'sma' => 'smait',
            'smait' => 'smait',
        ];
        $code = $map[strtolower($subdomain)] ?? null;
        if ($code) {
            return app(SchoolWebsiteController::class)->unitProfile($code);
        }
        return app(SchoolWebsiteController::class)->index();
    });
});

// Public School / Foundation Profile Website (Standard Routes)
Route::get('/', [SchoolWebsiteController::class, 'index'])->name('home');
Route::get('/profil', [SchoolWebsiteController::class, 'profil'])->name('school.profil');
Route::get('/unit/{code}', [SchoolWebsiteController::class, 'unitProfile'])->name('school.unit');

Route::get('/berita', [SchoolWebsiteController::class, 'beritaIndex'])->name('school.berita');
Route::get('/berita/{slug}', [SchoolWebsiteController::class, 'beritaShow'])->name('school.berita.show');

Route::get('/artikel', [SchoolWebsiteController::class, 'artikelIndex'])->name('school.artikel');
Route::get('/artikel/{slug}', [SchoolWebsiteController::class, 'artikelShow'])->name('school.artikel.show');

Route::get('/fasilitas', [SchoolWebsiteController::class, 'fasilitas'])->name('school.fasilitas');

Route::get('/layanan/kunjungan', [SchoolWebsiteController::class, 'layananKunjungan'])->name('school.layanan.kunjungan');
Route::post('/layanan/kunjungan', [SchoolWebsiteController::class, 'storeLayananKunjungan'])->name('school.layanan.kunjungan.store');

Route::get('/layanan/kerjasama', [SchoolWebsiteController::class, 'layananKerjasama'])->name('school.layanan.kerjasama');
Route::post('/layanan/kerjasama', [SchoolWebsiteController::class, 'storeLayananKerjasama'])->name('school.layanan.kerjasama.store');

Route::get('/layanan/sewa', [SchoolWebsiteController::class, 'layananSewa'])->name('school.layanan.sewa');
Route::post('/layanan/sewa', [SchoolWebsiteController::class, 'storeLayananSewa'])->name('school.layanan.sewa.store');

Route::get('/ppdb', [SchoolWebsiteController::class, 'ppdbForm'])->name('school.ppdb');
Route::post('/ppdb', [SchoolWebsiteController::class, 'storePpdb'])->name('school.ppdb.store');
Route::get('/spmb/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf'])->name('school.spmb.download-pdf');
Route::get('/spmb/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb'])->name('school.spmb.verify');

Route::get('/e-spp', [SchoolWebsiteController::class, 'eSppCheck'])->name('school.espp');

// SmartEdu 21-Module Sales & Product Showcase Page
Route::get('/sales', [LandingPageController::class, 'index'])->name('sales');

// Login Route for Auth Middleware
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');

// Admin Authentication & CMS Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin CMS Dashboard & Feature Manager
    Route::middleware('auth')->group(function () {
        Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');
        
        // Dynamic Web Content Management (Berita, Video, Agenda, Pengumuman, Sarana Prasarana, Galeri)
        Route::get('/cms/content', [CmsController::class, 'contentIndex'])->name('cms.content');
        Route::post('/cms/content/update', [CmsController::class, 'updateCmsContent'])->name('cms.content.update');
        Route::post('/cms/content/item/add', [CmsController::class, 'addCmsItem'])->name('cms.content.add');
        Route::delete('/cms/content/item/delete', [CmsController::class, 'deleteCmsItem'])->name('cms.content.delete');

        // Settings & Branding Modules
        Route::get('/settings', [CmsController::class, 'settingsPortal'])->name('settings');
        Route::get('/settings/portal', [CmsController::class, 'settingsPortal'])->name('settings.portal');
        Route::get('/settings/sales', [CmsController::class, 'settingsSales'])->name('settings.sales');
        Route::get('/settings/units', [CmsController::class, 'settingsUnits'])->name('settings.units');
        Route::get('/settings/units/{code}/edit', [CmsController::class, 'editUnitProfile'])->name('settings.units.edit');
        Route::post('/settings/units/{code}/update', [CmsController::class, 'updateUnitProfile'])->name('settings.units.update');
        Route::post('/settings', [CmsController::class, 'updateSettings'])->name('settings.update');

        // Modules Management & Show/Hide Toggles
        Route::get('/modules', [CmsController::class, 'modules'])->name('modules.index');
        Route::post('/modules/{id}/toggle', [CmsController::class, 'toggleModule'])->name('modules.toggle');
        Route::get('/modules/create', [CmsController::class, 'createModule'])->name('modules.create');
        Route::post('/modules', [CmsController::class, 'storeModule'])->name('modules.store');
        Route::get('/modules/{id}/edit', [CmsController::class, 'editModule'])->name('modules.edit');
        Route::put('/modules/{id}', [CmsController::class, 'updateModule'])->name('modules.update');
        Route::delete('/modules/{id}', [CmsController::class, 'destroyModule'])->name('modules.destroy');

        // FAQs Management
        Route::get('/faqs', [CmsController::class, 'faqs'])->name('faqs.index');
        Route::post('/faqs', [CmsController::class, 'storeFaq'])->name('faqs.store');
        Route::delete('/faqs/{id}', [CmsController::class, 'destroyFaq'])->name('faqs.destroy');

        // System Error Monitoring & Mitigation Center
        Route::post('/system-errors/{id}/resolve', [CmsController::class, 'resolveSystemError'])->name('system-errors.resolve');
        Route::post('/system-errors/run-auto-mitigation', [CmsController::class, 'runAutoMitigation'])->name('system-errors.auto-mitigation');
        Route::post('/system-errors/simulate-test-error', [CmsController::class, 'simulateTestError'])->name('system-errors.simulate');
        Route::post('/system-errors/log-client-error', [CmsController::class, 'logClientError'])->name('system-errors.log-client');

        // System Concurrency & High-Traffic Load Control Center
        Route::post('/system-control/set-mode', [CmsController::class, 'setTrafficMode'])->name('system-control.set-mode');
        Route::post('/system-control/purge-sessions', [CmsController::class, 'purgeExpiredSessions'])->name('system-control.purge-sessions');
        Route::post('/system-control/optimize-db-pool', [CmsController::class, 'optimizeDbPool'])->name('system-control.optimize-db-pool');

        // Modul 15: Mutaba'ah BPI & Character Building
        Route::get('/bpi', [BpiController::class, 'index'])->name('bpi.index');
        Route::post('/bpi', [BpiController::class, 'store'])->name('bpi.store');

        // Modul 7 & 17: HRIS & E-Payroll Pegawai
        Route::get('/payroll', [HrisPayrollController::class, 'index'])->name('payroll.index');
        Route::post('/payroll/generate', [HrisPayrollController::class, 'generate'])->name('payroll.generate');

        // Modul 12 & 13: CBT Ujian & PPDB Manager
        Route::get('/cbt', [CbtPpdbController::class, 'cbtIndex'])->name('cbt.index');
        Route::post('/cbt', [CbtPpdbController::class, 'storeCbtExam'])->name('cbt.store');
        Route::post('/cbt/questions', [CbtPpdbController::class, 'storeQuestion'])->name('cbt.questions.store');
        Route::get('/ppdb-admin', [CbtPpdbController::class, 'ppdbIndex'])->name('ppdb-admin.index');
        Route::post('/ppdb-admin/{id}/status', [CbtPpdbController::class, 'updatePpdbStatus'])->name('ppdb-admin.update-status');
        Route::get('/ppdb-admin/{id}/download-pdf', [CbtPpdbController::class, 'downloadSpmbPdf'])->name('ppdb-admin.download-pdf');

        // Modul 9: Sarpras Aset & Barcode
        Route::get('/sarpras', [SarprasController::class, 'index'])->name('sarpras.index');
        Route::post('/sarpras', [SarprasController::class, 'store'])->name('sarpras.store');

        // Modul 10: Perpustakaan Digital E-Library
        Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
        Route::post('/library', [LibraryController::class, 'store'])->name('library.store');

        // Modul 11: E-Learning LMS
        Route::get('/lms', [LmsController::class, 'index'])->name('lms.index');
        Route::post('/lms', [LmsController::class, 'store'])->name('lms.store');

        // Modul 8: BK Online & Poin Siswa
        Route::get('/bk', [BkController::class, 'index'])->name('bk.index');
        Route::post('/bk', [BkController::class, 'store'])->name('bk.store');

        // Modul 1: Master Data Management Base
        Route::prefix('master')->name('master.')->group(function () {
            Route::get('/', [MasterDataController::class, 'index'])->name('index');
            Route::post('/switch-school', [MasterDataController::class, 'switchSchool'])->name('switch-school');
            
            Route::get('/schools', [MasterDataController::class, 'schools'])->name('schools');
            Route::post('/schools', [MasterDataController::class, 'storeSchool'])->name('schools.store');
            Route::put('/schools/{id}', [MasterDataController::class, 'updateSchool'])->name('schools.update');
            Route::get('/curriculums', [MasterDataController::class, 'curriculums'])->name('curriculums');
            Route::post('/curriculums', [MasterDataController::class, 'storeAcademicYear'])->name('curriculums.store');
            Route::get('/classrooms', [MasterDataController::class, 'classrooms'])->name('classrooms');
            Route::post('/classrooms', [MasterDataController::class, 'storeClassroom'])->name('classrooms.store');
            Route::get('/students', [MasterDataController::class, 'students'])->name('students');
            Route::post('/students', [MasterDataController::class, 'storeStudent'])->name('students.store');
            Route::get('/students/export', [MasterDataController::class, 'exportStudents'])->name('students.export');
            Route::post('/students/import', [MasterDataController::class, 'importStudents'])->name('students.import');
            Route::get('/teachers', [MasterDataController::class, 'teachers'])->name('teachers');
            Route::post('/teachers', [MasterDataController::class, 'storeTeacher'])->name('teachers.store');
            Route::get('/teachers/export', [MasterDataController::class, 'exportTeachers'])->name('teachers.export');
            Route::get('/employees', [MasterDataController::class, 'employees'])->name('employees');
            Route::get('/references', [MasterDataController::class, 'references'])->name('references');
            Route::post('/subjects', [MasterDataController::class, 'storeSubject'])->name('subjects.store');
            Route::post('/rooms', [MasterDataController::class, 'storeRoom'])->name('rooms.store');
        });

        // Modul 2: Core Akademik, Penilaian & E-Rapor
        Route::prefix('academic')->name('academic.')->group(function () {
            Route::get('/schedules', [AcademicController::class, 'schedules'])->name('schedules');
            Route::post('/schedules', [AcademicController::class, 'storeSchedule'])->name('schedules.store');
            Route::get('/journals', [AcademicController::class, 'journals'])->name('journals');
            Route::post('/journals', [AcademicController::class, 'storeJournal'])->name('journals.store');
            Route::get('/grades', [AcademicController::class, 'grades'])->name('grades');
            Route::post('/grades', [AcademicController::class, 'storeGrade'])->name('grades.store');
            Route::get('/report-card/{studentId}', [AcademicController::class, 'reportCard'])->name('report-card');
        });

        // Modul 3: Absensi Realtime RFID & QR Code Gate
        Route::prefix('attendance')->name('attendance.')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
            Route::post('/tap-rfid', [AttendanceController::class, 'tapRfidSimulator'])->name('tap-rfid');
            Route::get('/leaves', [AttendanceController::class, 'leaves'])->name('leaves');
            Route::post('/leaves', [AttendanceController::class, 'storeLeave'])->name('leaves.store');
        });

        // Modul 4: Keuangan Sekolah, SPP & Akuntansi COA
        Route::prefix('finance')->name('finance.')->group(function () {
            Route::get('/spp-bills', [FinanceController::class, 'sppBills'])->name('spp-bills');
            Route::post('/spp-bills', [FinanceController::class, 'storeSppBill'])->name('spp-bills.store');
            Route::post('/spp-bills/{billId}/pay', [FinanceController::class, 'paySpp'])->name('spp-bills.pay');
            Route::get('/receipt/{paymentId}', [FinanceController::class, 'printReceipt'])->name('receipt');
            Route::get('/coa', [FinanceController::class, 'coa'])->name('coa');
            Route::post('/coa', [FinanceController::class, 'storeCoa'])->name('coa.store');
        });

        // Modul 5: Tabungan Siswa
        Route::prefix('savings')->name('savings.')->group(function () {
            Route::get('/', [SavingsController::class, 'index'])->name('index');
            Route::post('/', [SavingsController::class, 'storeTransaction'])->name('store');
        });

        // Modul 6: Kantin & POS Multi-Outlet (Cashless RFID Tap)
        Route::prefix('canteen')->name('canteen.')->group(function () {
            Route::get('/', [CanteenController::class, 'index'])->name('index');
            Route::post('/outlets', [CanteenController::class, 'storeOutlet'])->name('outlets.store');
            Route::post('/products', [CanteenController::class, 'storeProduct'])->name('products.store');
            Route::post('/checkout', [CanteenController::class, 'checkoutPos'])->name('checkout');
        });
    });
});
