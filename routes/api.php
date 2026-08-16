<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\HrisMobileApiController;

// API v1 Endpoints for Android Apps, Hardware Terminals & Mobile HRIS
Route::prefix('v1')->group(function () {
    // 1. Tap RFID Gate Terminal
    Route::post('/attendance/tap-rfid', [AttendanceApiController::class, 'tapRfid']);

    // 2. Mobile HRIS SDM SIT Robbani Endpoints
    Route::prefix('mobile')->group(function () {
        // Auth
        Route::post('/auth/login', [HrisMobileApiController::class, 'login']);

        // Dashboard & Profile
        Route::get('/dashboard', [HrisMobileApiController::class, 'dashboard']);

        // Presensi Face Recognition & Anti-Fake GPS
        Route::post('/attendance/check-in', [HrisMobileApiController::class, 'attendanceCheckIn']);
        Route::post('/attendance/check-out', [HrisMobileApiController::class, 'attendanceCheckOut']);
        Route::get('/attendance/history', [HrisMobileApiController::class, 'attendanceHistory']);

        // Izin & Cuti
        Route::get('/leaves', [HrisMobileApiController::class, 'leaves']);
        Route::post('/leaves/apply', [HrisMobileApiController::class, 'applyLeave']);

        // Payroll & Slip Gaji
        Route::get('/payroll', [HrisMobileApiController::class, 'payroll']);
        Route::get('/payroll/{id}/slip', [HrisMobileApiController::class, 'payrollSlip']);

        // KPI & Kinerja
        Route::get('/kpi', [HrisMobileApiController::class, 'kpi']);

        // Belanja Produk Kantin/Koperasi
        Route::get('/canteen/products', [HrisMobileApiController::class, 'canteenProducts']);
        Route::post('/canteen/pay', [HrisMobileApiController::class, 'canteenPay']);

        // BPI (Bina Pribadi Islam) & Mutabaah Yaumiyah SDM
        Route::get('/bpi/my-group', [HrisMobileApiController::class, 'bpiGroup']);
        Route::get('/bpi/mutabaah/today', [HrisMobileApiController::class, 'getTodayMutabaah']);
        Route::post('/bpi/mutabaah/save', [HrisMobileApiController::class, 'saveTodayMutabaah']);
        Route::get('/bpi/mutabaah/history', [HrisMobileApiController::class, 'mutabaahHistory']);
        Route::get('/bpi/mentor/dashboard', [HrisMobileApiController::class, 'mentorDashboard']);
        Route::post('/bpi/meetings/record', [HrisMobileApiController::class, 'saveBpiMeeting']);

        // Pendaftaran & Biometrik Wajah (Face Enrollment)
        Route::post('/face/enroll', [HrisMobileApiController::class, 'enrollFace']);
        Route::get('/face/status', [HrisMobileApiController::class, 'faceStatus']);

        // Pengumuman & Memo
        Route::get('/announcements', [HrisMobileApiController::class, 'announcements']);
    });
});
