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
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\MobileHrisAdminController;
use App\Http\Controllers\Admin\EmployeeDossierController;
use App\Http\Controllers\PublicLetterVerificationController;
use App\Http\Controllers\Admin\AiTrainerController;

// ==========================================================================
// SUBDOMAIN ROUTING (spmb.sitrobbani.sch.id, ppdb.sitrobbani.sch.id, tk/sd/smp/sma.sitrobbani.sch.id)
// ==========================================================================
Route::domain('spmb.sitrobbani.sch.id')->group(function () {
    // 1. Landing Page SPMB
    Route::get('/', [SchoolWebsiteController::class, 'spmbLanding'])->name('subdomain.spmb');
    Route::get('/spmb', [SchoolWebsiteController::class, 'spmbLanding']);
    Route::get('/ppdb', [SchoolWebsiteController::class, 'spmbLanding']);

    // 2. Formulir Registrasi Online
    Route::get('/daftar', [SchoolWebsiteController::class, 'ppdbForm'])->name('subdomain.spmb.form');
    Route::get('/spmb/daftar', [SchoolWebsiteController::class, 'ppdbForm']);
    Route::get('/ppdb/daftar', [SchoolWebsiteController::class, 'ppdbForm']);

    // 3. Submit Pendaftaran (Mendukung Seluruh Endpoint POST)
    Route::post('/daftar', [SchoolWebsiteController::class, 'storePpdb'])->name('subdomain.spmb.store');
    Route::post('/spmb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/ppdb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/spmb', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/ppdb', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/', [SchoolWebsiteController::class, 'storePpdb']);

    // 4. Cek Status & Unduh Berkas
    Route::get('/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus'])->name('subdomain.spmb.check-status');
    Route::get('/spmb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus']);
    Route::get('/ppdb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus']);
    Route::get('/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf'])->name('subdomain.spmb.download-pdf');
    Route::get('/spmb/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf']);
    Route::get('/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb'])->name('subdomain.spmb.verify');
    Route::get('/spmb/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb']);

    // 5. Navigasi ke Web Utama & Login Portal
    Route::get('/web-utama', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/portal', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/login', fn() => redirect()->to('https://sitrobbani.sch.id/login'));
    Route::get('/admin/{any?}', fn($any = '') => redirect()->to('https://sitrobbani.sch.id/admin' . ($any ? '/' . $any : '')))->where('any', '.*');
});

Route::domain('ppdb.sitrobbani.sch.id')->group(function () {
    Route::get('/', [SchoolWebsiteController::class, 'spmbLanding'])->name('subdomain.ppdb');
    Route::get('/spmb', [SchoolWebsiteController::class, 'spmbLanding']);
    Route::get('/ppdb', [SchoolWebsiteController::class, 'spmbLanding']);
    Route::get('/daftar', [SchoolWebsiteController::class, 'ppdbForm'])->name('subdomain.ppdb.form');
    Route::get('/spmb/daftar', [SchoolWebsiteController::class, 'ppdbForm']);
    Route::get('/ppdb/daftar', [SchoolWebsiteController::class, 'ppdbForm']);
    Route::post('/daftar', [SchoolWebsiteController::class, 'storePpdb'])->name('subdomain.ppdb.store');
    Route::post('/spmb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/ppdb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/spmb', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/ppdb', [SchoolWebsiteController::class, 'storePpdb']);
    Route::post('/', [SchoolWebsiteController::class, 'storePpdb']);
    Route::get('/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus'])->name('subdomain.ppdb.check-status');
    Route::get('/spmb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus']);
    Route::get('/ppdb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus']);
    Route::get('/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf'])->name('subdomain.ppdb.download-pdf');
    Route::get('/spmb/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf']);
    Route::get('/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb'])->name('subdomain.ppdb.verify');
    Route::get('/spmb/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb']);

    Route::get('/web-utama', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/portal', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/login', fn() => redirect()->to('https://sitrobbani.sch.id/login'));
    Route::get('/admin/{any?}', fn($any = '') => redirect()->to('https://sitrobbani.sch.id/admin' . ($any ? '/' . $any : '')))->where('any', '.*');
});

Route::domain('{subdomain}.sitrobbani.sch.id')->group(function () {
    // 1. Auth & Admin Portal Redirection (Wajib ke Domain Utama Agar Session Aman)
    Route::get('/login', fn() => redirect()->to('https://sitrobbani.sch.id/login'));
    Route::get('/admin/{any?}', fn($any = '') => redirect()->to('https://sitrobbani.sch.id/admin' . ($any ? '/' . $any : '')))->where('any', '.*');
    Route::get('/web-utama', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/portal', fn() => redirect()->to('https://sitrobbani.sch.id'));
    Route::get('/portal-utama', fn() => redirect()->to('https://sitrobbani.sch.id'));

    // 2. Redirect SPMB ke Subdomain spmb.sitrobbani.sch.id dengan parameter unit sekolah terkait
    Route::get('/spmb', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? '';
        return redirect()->to('https://spmb.sitrobbani.sch.id' . ($code ? '?unit=' . $code : ''));
    });
    Route::get('/daftar', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? '';
        return redirect()->to('https://spmb.sitrobbani.sch.id/daftar' . ($code ? '?unit=' . $code : ''));
    });
    Route::get('/ppdb', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? '';
        return redirect()->to('https://spmb.sitrobbani.sch.id' . ($code ? '?unit=' . $code : ''));
    });

    // 3. Layanan Terpadu Two-Segment Subpages
    Route::get('/layanan/kunjungan', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->unitLayananKunjunganPage($code) : redirect()->to('https://sitrobbani.sch.id');
    });
    Route::post('/layanan/kunjungan', function ($subdomain, \Illuminate\Http\Request $request) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->storeLayananKunjungan($request, $code) : redirect()->to('https://sitrobbani.sch.id');
    });
    Route::get('/layanan/kerjasama', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->unitLayananKerjasamaPage($code) : redirect()->to('https://sitrobbani.sch.id');
    });
    Route::post('/layanan/kerjasama', function ($subdomain, \Illuminate\Http\Request $request) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->storeLayananKerjasama($request, $code) : redirect()->to('https://sitrobbani.sch.id');
    });
    Route::get('/layanan/sewa', function ($subdomain) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->unitLayananSewaPage($code) : redirect()->to('https://sitrobbani.sch.id');
    });
    Route::post('/layanan/sewa', function ($subdomain, \Illuminate\Http\Request $request) {
        $map = ['tk' => 'tkit', 'tkit' => 'tkit', 'kb' => 'tkit', 'tpa' => 'tkit', 'sd' => 'sdit', 'sdit' => 'sdit', 'smp' => 'smpit', 'smpit' => 'smpit', 'sma' => 'smait', 'smait' => 'smait'];
        $code = $map[strtolower($subdomain)] ?? null;
        return $code ? app(SchoolWebsiteController::class)->storeLayananSewa($request, $code) : redirect()->to('https://sitrobbani.sch.id');
    });

    // 4. Dukungan Prefix /unit/{code} & /unit/{code}/{page} pada Subdomain
    Route::get('/unit/{code}', function ($subdomain, $code) {
        return app(SchoolWebsiteController::class)->unitProfile($code);
    });
    Route::get('/unit/{code}/{page}', function ($subdomain, $code, $page) {
        return redirect()->to('/' . $page);
    });

    // 5. Beranda Unit Subdomain
    Route::get('/', function ($subdomain) {
        $map = [
            'tk' => 'tkit',
            'tkit' => 'tkit',
            'kb' => 'tkit',
            'tpa' => 'tkit',
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

    // 6. Seluruh Sub-halaman Profil Unit
    Route::get('/{page}', function ($subdomain, $page) {
        $map = [
            'tk' => 'tkit',
            'tkit' => 'tkit',
            'kb' => 'tkit',
            'tpa' => 'tkit',
            'sd' => 'sdit',
            'sdit' => 'sdit',
            'smp' => 'smpit',
            'smpit' => 'smpit',
            'sma' => 'smait',
            'smait' => 'smait',
        ];
        $code = $map[strtolower($subdomain)] ?? null;
        if (!$code) {
            return redirect()->to('https://sitrobbani.sch.id');
        }
        $controller = app(SchoolWebsiteController::class);
        if ($page === 'visi-misi' || $page === 'visi_misi' || $page === 'visi-dan-misi') return $controller->unitVisiMisiPage($code);
        if ($page === 'sambutan' || $page === 'sambutan-kepala-sekolah') return $controller->unitSambutanPage($code);
        if ($page === 'sejarah') return $controller->unitSejarahPage($code);
        if ($page === 'profil' || $page === 'tentang-kami') return $controller->unitProfilPage($code);
        if ($page === 'dewan-guru' || $page === 'guru') return $controller->unitDewanGuruPage($code);
        if ($page === 'fasilitas') return $controller->unitFasilitasPage($code);
        if ($page === 'program-unggulan' || $page === 'program') return $controller->unitProgramUnggulanPage($code);
        if ($page === 'struktur-organisasi' || $page === 'struktur') return $controller->unitStrukturOrganisasiPage($code);
        if ($page === 'agenda') return $controller->unitAgendaPage($code);
        if ($page === 'pengumuman') return $controller->unitPengumumanPage($code);
        if ($page === 'galeri') return $controller->unitGaleriPage($code);
        if ($page === 'video') return $controller->unitVideoPage($code);
        if ($page === 'download') return $controller->unitDownloadPage($code);
        if ($page === 'e-book' || $page === 'ebook') return $controller->unitEbookPage($code);
        if ($page === 'hymne-mars' || $page === 'mars') return $controller->unitHymneMarsPage($code);
        if ($page === 'logo') return $controller->unitLogoPage($code);
        if ($page === 'layanan' || $page === 'layanan-terpadu') return $controller->unitLayananPage($code);
        if ($page === 'izin-sekolah' || $page === 'layanan-kunjungan') return $controller->unitLayananKunjunganPage($code);
        if ($page === 'permohonan-kerja-sama' || $page === 'layanan-kerjasama') return $controller->unitLayananKerjasamaPage($code);
        if ($page === 'sewa-barang' || $page === 'layanan-sewa') return $controller->unitLayananSewaPage($code);
        if ($page === 'hubungi' || $page === 'kontak') return $controller->unitHubungiPage($code);
        if ($page === 'testimoni' || $page === 'testimonial') return $controller->unitTestimoniPage($code);
        if ($page === 'artikel' || $page === 'berita') return $controller->unitArtikelPage($code);
        return $controller->unitProfile($code);
    });
});

// Public School / Foundation Profile Website (Standard Routes)
Route::get('/', [SchoolWebsiteController::class, 'index'])->name('home');
Route::get('/profil', [SchoolWebsiteController::class, 'profil'])->name('school.profil');
Route::get('/unit/{code}', [SchoolWebsiteController::class, 'unitProfile'])->name('school.unit');
Route::get('/unit/{code}/profil', [SchoolWebsiteController::class, 'unitProfilPage'])->name('school.unit.profil');
Route::get('/unit/{code}/tentang-kami', [SchoolWebsiteController::class, 'unitProfilPage'])->name('school.unit.tentang-kami');
Route::get('/unit/{code}/visi-misi', [SchoolWebsiteController::class, 'unitVisiMisiPage'])->name('school.unit.visi-misi');
Route::get('/unit/{code}/visi-dan-misi', [SchoolWebsiteController::class, 'unitVisiMisiPage'])->name('school.unit.visi-dan-misi');
Route::get('/unit/{code}/sambutan', [SchoolWebsiteController::class, 'unitSambutanPage'])->name('school.unit.sambutan');
Route::get('/unit/{code}/sambutan-kepala-sekolah', [SchoolWebsiteController::class, 'unitSambutanPage'])->name('school.unit.sambutan-kepala-sekolah');
Route::get('/unit/{code}/sejarah', [SchoolWebsiteController::class, 'unitSejarahPage'])->name('school.unit.sejarah');
Route::get('/unit/{code}/dewan-guru', [SchoolWebsiteController::class, 'unitDewanGuruPage'])->name('school.unit.dewan-guru');
Route::get('/unit/{code}/guru', [SchoolWebsiteController::class, 'unitDewanGuruPage'])->name('school.unit.guru');
Route::get('/unit/{code}/fasilitas', [SchoolWebsiteController::class, 'unitFasilitasPage'])->name('school.unit.fasilitas');
Route::get('/unit/{code}/program-unggulan', [SchoolWebsiteController::class, 'unitProgramUnggulanPage'])->name('school.unit.program-unggulan');
Route::get('/unit/{code}/program', [SchoolWebsiteController::class, 'unitProgramUnggulanPage'])->name('school.unit.program');
Route::get('/unit/{code}/struktur-organisasi', [SchoolWebsiteController::class, 'unitStrukturOrganisasiPage'])->name('school.unit.struktur-organisasi');
Route::get('/unit/{code}/struktur', [SchoolWebsiteController::class, 'unitStrukturOrganisasiPage'])->name('school.unit.struktur');
Route::get('/unit/{code}/agenda', [SchoolWebsiteController::class, 'unitAgendaPage'])->name('school.unit.agenda');
Route::get('/unit/{code}/pengumuman', [SchoolWebsiteController::class, 'unitPengumumanPage'])->name('school.unit.pengumuman');
Route::get('/unit/{code}/galeri', [SchoolWebsiteController::class, 'unitGaleriPage'])->name('school.unit.galeri');
Route::get('/unit/{code}/video', [SchoolWebsiteController::class, 'unitVideoPage'])->name('school.unit.video');
Route::get('/unit/{code}/download', [SchoolWebsiteController::class, 'unitDownloadPage'])->name('school.unit.download');
Route::get('/unit/{code}/e-book', [SchoolWebsiteController::class, 'unitEbookPage'])->name('school.unit.e-book');
Route::get('/unit/{code}/ebook', [SchoolWebsiteController::class, 'unitEbookPage'])->name('school.unit.ebook');
Route::get('/unit/{code}/hymne-mars', [SchoolWebsiteController::class, 'unitHymneMarsPage'])->name('school.unit.hymne-mars');
Route::get('/unit/{code}/mars', [SchoolWebsiteController::class, 'unitHymneMarsPage'])->name('school.unit.mars');
Route::get('/unit/{code}/logo', [SchoolWebsiteController::class, 'unitLogoPage'])->name('school.unit.logo');
Route::get('/unit/{code}/layanan', [SchoolWebsiteController::class, 'unitLayananPage'])->name('school.unit.layanan');
Route::get('/unit/{code}/layanan-terpadu', [SchoolWebsiteController::class, 'unitLayananPage'])->name('school.unit.layanan-terpadu');
Route::get('/unit/{code}/layanan/kunjungan', [SchoolWebsiteController::class, 'unitLayananKunjunganPage'])->name('school.unit.layanan.kunjungan');
Route::get('/unit/{code}/izin-sekolah', [SchoolWebsiteController::class, 'unitLayananKunjunganPage'])->name('school.unit.izin-sekolah');
Route::get('/unit/{code}/layanan/kerjasama', [SchoolWebsiteController::class, 'unitLayananKerjasamaPage'])->name('school.unit.layanan.kerjasama');
Route::get('/unit/{code}/permohonan-kerja-sama', [SchoolWebsiteController::class, 'unitLayananKerjasamaPage'])->name('school.unit.permohonan-kerja-sama');
Route::get('/unit/{code}/layanan/sewa', [SchoolWebsiteController::class, 'unitLayananSewaPage'])->name('school.unit.layanan.sewa');
Route::get('/unit/{code}/sewa-barang', [SchoolWebsiteController::class, 'unitLayananSewaPage'])->name('school.unit.sewa-barang');
Route::get('/unit/{code}/hubungi', [SchoolWebsiteController::class, 'unitHubungiPage'])->name('school.unit.hubungi');
Route::get('/unit/{code}/kontak', [SchoolWebsiteController::class, 'unitHubungiPage'])->name('school.unit.kontak');
Route::get('/unit/{code}/testimoni', [SchoolWebsiteController::class, 'unitTestimoniPage'])->name('school.unit.testimoni');
Route::get('/unit/{code}/testimonial', [SchoolWebsiteController::class, 'unitTestimoniPage'])->name('school.unit.testimonial');
Route::get('/unit/{code}/artikel', [SchoolWebsiteController::class, 'unitArtikelPage'])->name('school.unit.artikel');
Route::get('/unit/{code}/berita', [SchoolWebsiteController::class, 'unitArtikelPage'])->name('school.unit.berita');

Route::post('/unit/{code}/layanan/kunjungan', [SchoolWebsiteController::class, 'storeLayananKunjungan'])->name('school.unit.layanan.kunjungan.store');
Route::post('/unit/{code}/layanan/kerjasama', [SchoolWebsiteController::class, 'storeLayananKerjasama'])->name('school.unit.layanan.kerjasama.store');
Route::post('/unit/{code}/layanan/sewa', [SchoolWebsiteController::class, 'storeLayananSewa'])->name('school.unit.layanan.sewa.store');

Route::get('/berita', [SchoolWebsiteController::class, 'beritaIndex'])->name('school.berita');
Route::get('/berita/{slug}', [SchoolWebsiteController::class, 'beritaShow'])->name('school.berita.show');

Route::get('/artikel', [SchoolWebsiteController::class, 'artikelIndex'])->name('school.artikel');
Route::get('/artikel/{slug}', [SchoolWebsiteController::class, 'artikelShow'])->name('school.artikel.show');

Route::get('/fasilitas', [SchoolWebsiteController::class, 'fasilitas'])->name('school.fasilitas');

Route::get('/layanan', [SchoolWebsiteController::class, 'layanan'])->name('school.layanan');
Route::get('/layanan-terpadu', [SchoolWebsiteController::class, 'layanan']);
Route::get('/layanan/kunjungan', [SchoolWebsiteController::class, 'layananKunjungan'])->name('school.layanan.kunjungan');
Route::post('/layanan/kunjungan', [SchoolWebsiteController::class, 'storeLayananKunjungan'])->name('school.layanan.kunjungan.store');

Route::get('/layanan/kerjasama', [SchoolWebsiteController::class, 'layananKerjasama'])->name('school.layanan.kerjasama');
Route::post('/layanan/kerjasama', [SchoolWebsiteController::class, 'storeLayananKerjasama'])->name('school.layanan.kerjasama.store');

Route::get('/layanan/sewa', [SchoolWebsiteController::class, 'layananSewa'])->name('school.layanan.sewa');
Route::post('/layanan/sewa', [SchoolWebsiteController::class, 'storeLayananSewa'])->name('school.layanan.sewa.store');

// SPMB & PPDB Routes (Redesigned Landing Page & Full Registration Form)
Route::get('/spmb', [SchoolWebsiteController::class, 'spmbLanding'])->name('school.spmb');
Route::get('/ppdb', [SchoolWebsiteController::class, 'spmbLanding'])->name('school.ppdb');
Route::get('/spmb/daftar', [SchoolWebsiteController::class, 'ppdbForm'])->name('school.spmb.form');
Route::get('/ppdb/daftar', [SchoolWebsiteController::class, 'ppdbForm'])->name('school.ppdb.form');
Route::post('/spmb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
Route::post('/ppdb/daftar', [SchoolWebsiteController::class, 'storePpdb']);
Route::post('/ppdb', [SchoolWebsiteController::class, 'storePpdb'])->name('school.ppdb.store');
Route::post('/spmb', [SchoolWebsiteController::class, 'storePpdb'])->name('school.spmb.store');
Route::get('/spmb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus'])->name('school.spmb.check-status');
Route::get('/ppdb/cek-status', [SchoolWebsiteController::class, 'checkSpmbStatus'])->name('school.ppdb.check-status');
Route::get('/spmb/download-pdf/{id}', [SchoolWebsiteController::class, 'downloadSpmbPdf'])->name('school.spmb.download-pdf');
Route::get('/spmb/verify/{regNumber}', [SchoolWebsiteController::class, 'verifySpmb'])->name('school.spmb.verify');

Route::get('/e-spp', [SchoolWebsiteController::class, 'eSppCheck'])->name('school.espp');
Route::post('/chat-ai', [SchoolWebsiteController::class, 'chatAi'])->name('school.chat-ai');

// SmartEdu 21-Module Sales & Product Showcase Page
Route::get('/sales', [LandingPageController::class, 'index'])->name('sales');

// Verifikasi Publik Keaslian Dokumen & TTE (Scan QR Code)
Route::get('/verifikasi-surat/{token}', [PublicLetterVerificationController::class, 'verify'])->name('letter.verify');

// Login Route for Auth Middleware
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Logout Routes (GET & POST)
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Authentication & CMS Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin CMS Dashboard & Feature Manager
    Route::middleware('auth')->group(function () {
        
        // 1. Dashboard Utama (Bisa diakses seluruh role pengguna)
        Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');
        
        // 2a. Pengelolaan Profil Website Unit & Publikasi Berita Unit (Super Admin, Ketua Yayasan, Kepala Unit, Staf TU, Humas Yayasan, Admin Web Unit)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,STAFF_TU,HUMAS,ADMIN_WEB_UNIT')->group(function () {
            Route::get('/settings/units', [CmsController::class, 'settingsUnits'])->name('settings.units');
            Route::get('/settings/units/{code}/edit', [CmsController::class, 'editUnitProfile'])->name('settings.units.edit');
            Route::post('/settings/units/{code}/update', [CmsController::class, 'updateUnitProfile'])->name('settings.units.update');

            Route::get('/cms/content', [CmsController::class, 'contentIndex'])->name('cms.content');
            Route::post('/cms/content/update', [CmsController::class, 'updateCmsContent'])->name('cms.content.update');
            Route::post('/cms/content/item/add', [CmsController::class, 'addCmsItem'])->name('cms.content.add');
            Route::match(['post', 'delete'], '/cms/content/item/delete', [CmsController::class, 'deleteCmsItem'])->name('cms.content.delete');
            Route::get('/cms/post/create', [CmsController::class, 'createPost'])->name('cms.post.create');
            Route::get('/cms/post/edit', [CmsController::class, 'editPost'])->name('cms.post.edit');
            Route::post('/cms/post/save', [CmsController::class, 'savePost'])->name('cms.post.save');
            Route::post('/cms/foundation-profile', [CmsController::class, 'updateFoundationProfile'])->name('cms.foundation-profile.update');
        });

        // 2b. Pengaturan Website Utama Portal Yayasan (Super Admin, Ketua Yayasan, Humas Yayasan)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HUMAS')->group(function () {
            Route::get('/settings', [CmsController::class, 'settingsPortal'])->name('settings');
            Route::get('/settings/portal', [CmsController::class, 'settingsPortal'])->name('settings.portal');
            Route::post('/settings', [CmsController::class, 'updateSettings'])->name('settings.update');
            Route::post('/cms/import-wordpress', [CmsController::class, 'importWordPress'])->name('cms.import-wordpress');
            Route::post('/cms/auto-categorize', [CmsController::class, 'autoCategorizeContent'])->name('cms.auto-categorize');
            
            // Permohonan Layanan Publik (Kunjungan, Kerjasama, Sewa)
            Route::get('/public-services', [CmsController::class, 'publicServiceRequests'])->name('public-services.index');
            Route::post('/public-services/{id}/status', [CmsController::class, 'updatePublicServiceStatus'])->name('public-services.update-status');
            Route::delete('/public-services/{id}', [CmsController::class, 'destroyPublicServiceRequest'])->name('public-services.destroy');
        });

        // 2c. Pengaturan Konten Landing Page & Formulir SPMB (Super Admin, Ketua Yayasan, Kepala Unit Sekolah, Admin Web Unit, TU, Humas, Panitia PPDB)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,ADMIN_WEB_UNIT,STAFF_TU,HUMAS,PANITIA_PPDB')->group(function () {
            Route::get('/settings/spmb', [CmsController::class, 'settingsSpmb'])->name('settings.spmb');
            Route::post('/settings/spmb', [CmsController::class, 'updateSettingsSpmb'])->name('settings.spmb.update');
        });

        // 2c. Pengaturan Global Portal Yayasan, Manajemen Akun, Lisensi Sales, Modul, & Pusat Kontrol (Super Admin & Ketua Yayasan)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN')->group(function () {
            // Manajemen Akun & Hak Akses Pengguna
            Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
            Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
            Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
            Route::post('/users/{id}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
            Route::post('/users/{id}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
            Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
            Route::get('/users-export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users.export');

            Route::get('/settings/sales', [CmsController::class, 'settingsSales'])->name('settings.sales');

            Route::get('/modules', [CmsController::class, 'modules'])->name('modules.index');
            Route::post('/modules/{id}/toggle', [CmsController::class, 'toggleModule'])->name('modules.toggle');
            Route::get('/modules/create', [CmsController::class, 'createModule'])->name('modules.create');
            Route::post('/modules', [CmsController::class, 'storeModule'])->name('modules.store');
            Route::get('/modules/{id}/edit', [CmsController::class, 'editModule'])->name('modules.edit');
            Route::put('/modules/{id}', [CmsController::class, 'updateModule'])->name('modules.update');
            Route::delete('/modules/{id}', [CmsController::class, 'destroyModule'])->name('modules.destroy');

            Route::get('/faqs', [CmsController::class, 'faqs'])->name('faqs.index');
            Route::post('/faqs', [CmsController::class, 'storeFaq'])->name('faqs.store');
            Route::delete('/faqs/{id}', [CmsController::class, 'destroyFaq'])->name('faqs.destroy');

            Route::post('/system-errors/{id}/resolve', [CmsController::class, 'resolveSystemError'])->name('system-errors.resolve');
            Route::post('/system-errors/run-auto-mitigation', [CmsController::class, 'runAutoMitigation'])->name('system-errors.auto-mitigation');
            Route::post('/system-errors/simulate-test-error', [CmsController::class, 'simulateTestError'])->name('system-errors.simulate');
            Route::post('/system-errors/log-client-error', [CmsController::class, 'logClientError'])->name('system-errors.log-client');

            Route::post('/system-control/set-mode', [CmsController::class, 'setTrafficMode'])->name('system-control.set-mode');
            Route::post('/system-control/purge-sessions', [CmsController::class, 'purgeExpiredSessions'])->name('system-control.purge-sessions');
            Route::post('/system-control/optimize-db-pool', [CmsController::class, 'optimizeDbPool'])->name('system-control.optimize-db-pool');
        });

        // 3. Modul 15: Mutaba'ah BPI & Character Building (Super Admin, Kepala Sekolah, Guru, Musyrif)
        Route::middleware('role:SUPER_ADMIN,HEADMASTER,TEACHER,MUSYRIF_ASRAMA')->group(function () {
            Route::get('/bpi', [BpiController::class, 'index'])->name('bpi.index');
            Route::post('/bpi', [BpiController::class, 'store'])->name('bpi.store');
            Route::delete('/bpi/{id}', [BpiController::class, 'destroy'])->name('bpi.destroy');
        });

        // 4. Modul 7 & 17: HRIS, Database SDM Pegangan Yayasan & Aplikasi Mobile (Super Admin, Ketua Yayasan, Kepala Sekolah, Bendahara, TU)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,STAFF_KEUANGAN,STAFF_TU')->group(function () {
            // Database Induk & E-Berkas Lengkap SDM
            Route::get('/employees', [EmployeeDossierController::class, 'index'])->name('employees.index');
            Route::get('/employees/{id}', [EmployeeDossierController::class, 'show'])->name('employees.show');
            Route::get('/employees/{id}/edit', [EmployeeDossierController::class, 'edit'])->name('employees.edit');
            Route::put('/employees/{id}', [EmployeeDossierController::class, 'update'])->name('employees.update');

            // Payroll & Gaji
            Route::get('/payroll', [HrisPayrollController::class, 'index'])->name('payroll.index');
            Route::post('/payroll/generate', [HrisPayrollController::class, 'generate'])->name('payroll.generate');
            Route::delete('/payroll/{id}', [HrisPayrollController::class, 'destroy'])->name('payroll.destroy');
            
            // Aplikasi Mobile SDM & Biometrik Wajah & Geofence GPS
            Route::get('/mobile-hris', [MobileHrisAdminController::class, 'index'])->name('mobile.index');
            Route::get('/mobile-hris/faces', [MobileHrisAdminController::class, 'faceBiometrics'])->name('mobile.faces');
            Route::get('/mobile-hris/geofence', [MobileHrisAdminController::class, 'geofenceSettings'])->name('mobile.geofence');
            Route::post('/mobile-hris/geofence/{id}', [MobileHrisAdminController::class, 'updateGeofence'])->name('mobile.geofence.update');
        });

        // 5. Modul 12 & 13: CBT Ujian & PPDB Manager (Super Admin, Ketua Yayasan, Kepala Unit Sekolah, Admin Web Unit, TU, Humas, Panitia PPDB)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,ADMIN_WEB_UNIT,STAFF_TU,HUMAS,PANITIA_PPDB')->group(function () {
            Route::get('/cbt', [CbtPpdbController::class, 'cbtIndex'])->name('cbt.index');
            Route::post('/cbt', [CbtPpdbController::class, 'storeCbtExam'])->name('cbt.store');
            Route::delete('/cbt/{id}', [CbtPpdbController::class, 'destroyExam'])->name('cbt.destroy');
            Route::post('/cbt/questions', [CbtPpdbController::class, 'storeQuestion'])->name('cbt.questions.store');
            
            // PPDB / SPMB Online Full CRUD & Export
            Route::get('/ppdb-admin', [CbtPpdbController::class, 'ppdbIndex'])->name('ppdb-admin.index');
            Route::post('/ppdb-admin', [CbtPpdbController::class, 'storePpdbAdmin'])->name('ppdb-admin.store');
            Route::get('/ppdb-admin/export', [CbtPpdbController::class, 'exportPpdb'])->name('ppdb-admin.export');
            Route::get('/ppdb-admin/{id}/detail', [CbtPpdbController::class, 'detailPpdb'])->name('ppdb-admin.detail');
            Route::put('/ppdb-admin/{id}', [CbtPpdbController::class, 'updatePpdbAdmin'])->name('ppdb-admin.update');
            Route::post('/ppdb-admin/{id}/status', [CbtPpdbController::class, 'updatePpdbStatus'])->name('ppdb-admin.update-status');
            Route::delete('/ppdb-admin/{id}', [CbtPpdbController::class, 'destroyPpdb'])->name('ppdb-admin.destroy');
            Route::get('/ppdb-admin/{id}/download-pdf', [CbtPpdbController::class, 'downloadSpmbPdf'])->name('ppdb-admin.download-pdf');
        });

        // 6. Modul 9: Sarpras Aset & Barcode (Super Admin, Ketua Yayasan, Kepala Sekolah, Petugas Sarpras)
        Route::middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,PETUGAS_SARPRAS')->group(function () {
            Route::get('/sarpras', [SarprasController::class, 'index'])->name('sarpras.index');
            Route::post('/sarpras', [SarprasController::class, 'store'])->name('sarpras.store');
            Route::delete('/sarpras/{id}', [SarprasController::class, 'destroy'])->name('sarpras.destroy');
        });

        // 7. Modul 10: Perpustakaan Digital E-Library (Super Admin, Kepala Sekolah, Pustakawan, Guru)
        Route::middleware('role:SUPER_ADMIN,HEADMASTER,PETUGAS_PERPUS,TEACHER')->group(function () {
            Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
            Route::post('/library', [LibraryController::class, 'store'])->name('library.store');
            Route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
        });

        // 8. Modul 11: E-Learning LMS (Super Admin, Kepala Sekolah, Guru)
        Route::middleware('role:SUPER_ADMIN,HEADMASTER,TEACHER')->group(function () {
            Route::get('/lms', [LmsController::class, 'index'])->name('lms.index');
            Route::post('/lms', [LmsController::class, 'store'])->name('lms.store');
            Route::delete('/lms/{id}', [LmsController::class, 'destroy'])->name('lms.destroy');
        });

        // 9. Modul 8: BK Online & Poin Siswa (Super Admin, Kepala Sekolah, Guru BK, Guru)
        Route::middleware('role:SUPER_ADMIN,HEADMASTER,GURU_BK,TEACHER')->group(function () {
            Route::get('/bk', [BkController::class, 'index'])->name('bk.index');
            Route::post('/bk', [BkController::class, 'store'])->name('bk.store');
            Route::delete('/bk/{id}', [BkController::class, 'destroy'])->name('bk.destroy');
        });

        // 10. Modul 1: Master Data Management (Super Admin, Kepala Sekolah, Tata Usaha)
        Route::prefix('master')->name('master.')->middleware('role:SUPER_ADMIN,HEADMASTER,STAFF_TU')->group(function () {
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

        // 11. Modul 2: Core Akademik, Penilaian & E-Rapor SIT (Super Admin, Kepala Sekolah, TU, Guru)
        Route::prefix('academic')->name('academic.')->middleware('role:SUPER_ADMIN,HEADMASTER,STAFF_TU,TEACHER')->group(function () {
            Route::get('/schedules', [AcademicController::class, 'schedules'])->name('schedules');
            Route::post('/schedules', [AcademicController::class, 'storeSchedule'])->name('schedules.store');
            Route::delete('/schedules/{id}', [AcademicController::class, 'destroySchedule'])->name('schedules.destroy');
            Route::get('/journals', [AcademicController::class, 'journals'])->name('journals');
            Route::post('/journals', [AcademicController::class, 'storeJournal'])->name('journals.store');
            Route::delete('/journals/{id}', [AcademicController::class, 'destroyJournal'])->name('journals.destroy');
            Route::get('/grades', [AcademicController::class, 'grades'])->name('grades');
            Route::delete('/grades/{id}', [AcademicController::class, 'destroyGrade'])->name('grades.destroy');
            Route::post('/grades/batch', [AcademicController::class, 'batchStoreGrades'])->name('grades.batch.store');
            Route::post('/grades/quran', [AcademicController::class, 'storeQuranGrade'])->name('grades.quran.store');
            Route::post('/grades/quran/batch', [AcademicController::class, 'batchStoreQuran'])->name('grades.quran.batch.store');
            Route::post('/grades/character', [AcademicController::class, 'storeCharacterGrade'])->name('grades.character.store');
            Route::post('/grades/character/batch', [AcademicController::class, 'batchStoreCharacter'])->name('grades.character.batch.store');
            Route::post('/grades/homeroom', [AcademicController::class, 'storeHomeroomNote'])->name('grades.homeroom.store');
            Route::post('/grades/homeroom/batch', [AcademicController::class, 'batchStoreHomeroom'])->name('grades.homeroom.batch.store');
            Route::post('/grades/settings', [AcademicController::class, 'storeReportSettings'])->name('grades.settings.store');
            Route::post('/classrooms/save', [AcademicController::class, 'saveClassroom'])->name('classrooms.save');
            Route::post('/classrooms/delete/{classroomId}', [AcademicController::class, 'deleteClassroom'])->name('classrooms.delete');
            Route::post('/classrooms/{classroomId}/signature', [AcademicController::class, 'uploadHomeroomSignature'])->name('classrooms.signature');

            Route::post('/students/save', [AcademicController::class, 'saveStudent'])->name('students.save');
            Route::post('/students/delete/{studentId}', [AcademicController::class, 'deleteStudent'])->name('students.delete');
            Route::get('/students/template', [AcademicController::class, 'downloadStudentTemplate'])->name('students.template');
            Route::post('/students/import', [AcademicController::class, 'importStudents'])->name('students.import');
            Route::post('/students/sync-master', [AcademicController::class, 'syncMasterStudents'])->name('students.sync.master');

            Route::post('/subjects/save', [AcademicController::class, 'saveSubject'])->name('subjects.save');
            Route::post('/subjects/delete/{subjectId}', [AcademicController::class, 'deleteSubject'])->name('subjects.delete');
            Route::get('/subjects/template', [AcademicController::class, 'downloadSubjectTemplate'])->name('subjects.template');
            Route::post('/subjects/import', [AcademicController::class, 'importSubjects'])->name('subjects.import');

            Route::post('/extracurriculars/save', [AcademicController::class, 'saveExtracurricular'])->name('extracurriculars.save');
            Route::post('/extracurriculars/delete/{id}', [AcademicController::class, 'deleteExtracurricular'])->name('extracurriculars.delete');

            Route::post('/p5/save', [AcademicController::class, 'saveProjectP5'])->name('p5.save');
            Route::get('/report-card/{studentId}', [AcademicController::class, 'reportCard'])->name('report-card');
            Route::get('/leger/export', [AcademicController::class, 'exportLeger'])->name('leger.export');

            // AI Smart Assistant (Google Gemini AI Studio)
            Route::post('/ai/generate-homeroom', [AcademicController::class, 'aiGenerateHomeroom'])->name('ai.homeroom');
            Route::post('/ai/generate-homeroom-alias', [AcademicController::class, 'aiGenerateHomeroom'])->name('ai.generate.homeroom');
            Route::post('/ai/generate-narrative', [AcademicController::class, 'aiGenerateNarrative'])->name('ai.narrative');
            Route::post('/ai/generate-narrative-alias', [AcademicController::class, 'aiGenerateNarrative'])->name('ai.generate.narrative');
            Route::post('/ai/generate-quran', [AcademicController::class, 'aiGenerateQuran'])->name('ai.quran');
            Route::post('/ai/generate-quran-alias', [AcademicController::class, 'aiGenerateQuran'])->name('ai.generate.quran');
            Route::match(['get', 'post'], '/ai/analyze-class', [AcademicController::class, 'aiAnalyzeClass'])->name('ai.analyze-class');
            Route::match(['get', 'post'], '/ai/analyze-class-alias', [AcademicController::class, 'aiAnalyzeClass'])->name('ai.analyze.class');

            // Manajemen Pengguna Unit (Khusus Kepala Sekolah & Super Admin)
            Route::post('/users/save', [AcademicController::class, 'saveUnitUser'])->name('users.save');
            Route::post('/users/delete/{id}', [AcademicController::class, 'deleteUnitUser'])->name('users.delete');
        });

        // 12. Modul 3: Absensi Realtime RFID & QR Code (Super Admin, Kepala Sekolah, TU, Guru, Guru BK)
        Route::prefix('attendance')->name('attendance.')->middleware('role:SUPER_ADMIN,HEADMASTER,STAFF_TU,TEACHER,GURU_BK')->group(function () {
            Route::get('/', [AttendanceController::class, 'index'])->name('index');
            Route::post('/tap-rfid', [AttendanceController::class, 'tapRfidSimulator'])->name('tap-rfid');
            Route::get('/leaves', [AttendanceController::class, 'leaves'])->name('leaves');
            Route::post('/leaves', [AttendanceController::class, 'storeLeave'])->name('leaves.store');
        });

        // 13. Modul 4: Keuangan Sekolah, SPP & Akuntansi (Super Admin, Ketua Yayasan, Bendahara)
        Route::prefix('finance')->name('finance.')->middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,STAFF_KEUANGAN')->group(function () {
            Route::get('/spp-bills', [FinanceController::class, 'sppBills'])->name('spp-bills');
            Route::post('/spp-bills', [FinanceController::class, 'storeSppBill'])->name('spp-bills.store');
            Route::post('/spp-bills/{billId}/pay', [FinanceController::class, 'paySpp'])->name('spp-bills.pay');
            Route::get('/receipt/{paymentId}', [FinanceController::class, 'printReceipt'])->name('receipt');
            Route::get('/coa', [FinanceController::class, 'coa'])->name('coa');
            Route::post('/coa', [FinanceController::class, 'storeCoa'])->name('coa.store');
        });

        // 14. Modul 5: Tabungan Siswa (Super Admin, Bendahara)
        Route::prefix('savings')->name('savings.')->middleware('role:SUPER_ADMIN,STAFF_KEUANGAN')->group(function () {
            Route::get('/', [SavingsController::class, 'index'])->name('index');
            Route::post('/', [SavingsController::class, 'storeTransaction'])->name('store');
        });

        // 15. Modul 6: Kantin & POS Multi-Outlet RFID (Super Admin, Bendahara, Kasir Kantin)
        Route::prefix('canteen')->name('canteen.')->middleware('role:SUPER_ADMIN,STAFF_KEUANGAN,PETUGAS_KANTIN')->group(function () {
            Route::get('/', [CanteenController::class, 'index'])->name('index');
            Route::post('/outlets', [CanteenController::class, 'storeOutlet'])->name('outlets.store');
            Route::delete('/outlets/{id}', [CanteenController::class, 'destroyOutlet'])->name('outlets.destroy');
            Route::post('/products', [CanteenController::class, 'storeProduct'])->name('products.store');
            Route::delete('/products/{id}', [CanteenController::class, 'destroyProduct'])->name('products.destroy');
            Route::post('/checkout', [CanteenController::class, 'checkoutPos'])->name('checkout');
        });

        // 16. Modul 22: Sistem Persuratan & TTE (Super Admin, Ketua Yayasan, Kepala Sekolah, TU)
        Route::prefix('letters')->name('letters.')->middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER,STAFF_TU')->group(function () {
            Route::get('/', [LetterController::class, 'index'])->name('index');
            
            // Surat Masuk & Disposisi
            Route::get('/incoming', [LetterController::class, 'incoming'])->name('incoming');
            Route::post('/incoming', [LetterController::class, 'storeIncoming'])->name('incoming.store');
            
            // Surat Keluar & Draft Engine
            Route::get('/outgoing', [LetterController::class, 'outgoing'])->name('outgoing');
            Route::post('/outgoing', [LetterController::class, 'storeOutgoing'])->name('outgoing.store');
            Route::post('/outgoing/{id}/update', [LetterController::class, 'updateOutgoing'])->name('outgoing.update');
            Route::delete('/{id}', [LetterController::class, 'destroy'])->name('destroy');
            
            // Lembar Disposisi Pimpinan
            Route::get('/dispositions', [LetterController::class, 'dispositions'])->name('dispositions');
            Route::post('/dispositions', [LetterController::class, 'storeDisposition'])->name('dispositions.store');
            Route::post('/dispositions/{id}/update', [LetterController::class, 'updateDispositionStatus'])->name('dispositions.update');
            
            // Otoritas TTE & Bulk Signing
            Route::get('/tte-queue', [LetterController::class, 'tteQueue'])->name('tte-queue');
            Route::post('/sign/{id}', [LetterController::class, 'signLetter'])->name('sign');
            Route::post('/bulk-sign', [LetterController::class, 'bulkSign'])->name('bulk-sign');
            
            // Template Baku & E-Filing Arsip
            Route::get('/templates', [LetterController::class, 'templates'])->name('templates');
            Route::post('/templates', [LetterController::class, 'storeTemplate'])->name('templates.store');
            Route::get('/archive', [LetterController::class, 'archive'])->name('archive');
            Route::get('/preview-pdf/{id}', [LetterController::class, 'previewPdf'])->name('preview-pdf');
            Route::get('/tracking/{id}', [LetterController::class, 'tracking'])->name('tracking');
        });

        // 17. AI Knowledge Base Trainer (Super Admin, Ketua Yayasan, Kepala Sekolah)
        Route::prefix('ai-trainer')->name('ai-trainer.')->middleware('role:SUPER_ADMIN,YAYASAN_CHAIRMAN,HEADMASTER')->group(function () {
            Route::get('/', [AiTrainerController::class, 'index'])->name('index');
            Route::post('/upload', [AiTrainerController::class, 'upload'])->name('upload');
            Route::post('/store', [AiTrainerController::class, 'store'])->name('store');
            Route::delete('/{id}', [AiTrainerController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle', [AiTrainerController::class, 'toggle'])->name('toggle');
            Route::post('/auto-sync', [AiTrainerController::class, 'autoSync'])->name('auto-sync');
            Route::post('/test-chat', [AiTrainerController::class, 'testChat'])->name('test-chat');
            Route::post('/bulk-delete', [AiTrainerController::class, 'bulkDelete'])->name('bulk-delete');
        });
    });
});

// ==========================================================================
// SEARCH ENGINE OPTIMIZATION (SEO) & WORDPRESS 301 MIGRATION ROUTES
// ==========================================================================
Route::get('/sitemap.xml', [SchoolWebsiteController::class, 'sitemapXml'])->name('seo.sitemap');
Route::get('/robots.txt', [SchoolWebsiteController::class, 'robotsTxt'])->name('seo.robots');

// Legacy WordPress category & tag 301 redirects
Route::get('/category/{category}', [SchoolWebsiteController::class, 'handleWordPressLegacyRedirect'])->name('wp.category');
Route::get('/tag/{tag}', [SchoolWebsiteController::class, 'handleWordPressLegacyRedirect'])->name('wp.tag');

// Legacy WordPress permalink structures (e.g. /2022/08/16/slug or /2026/08/slug)
Route::get('/{year}/{month}/{day}/{slug}', [SchoolWebsiteController::class, 'handleWordPressLegacyRedirect'])
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{2}', 'day' => '[0-9]{2}']);
Route::get('/{year}/{month}/{slug}', [SchoolWebsiteController::class, 'handleWordPressLegacyRedirect'])
    ->where(['year' => '[0-9]{4}', 'month' => '[0-9]{2}']);

