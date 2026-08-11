<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;

// API v1 Endpoints for Android Apps & Hardware Terminals
Route::prefix('v1')->group(function () {
    // Tap RFID Gate Terminal
    Route::post('/attendance/tap-rfid', [AttendanceApiController::class, 'tapRfid']);
});
