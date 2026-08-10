<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\AuthController;

// Public Promotional Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Login Route for Auth Middleware
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');

// Admin Authentication & CMS Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin CMS Dashboard & Feature Manager
    Route::middleware('auth')->group(function () {
        Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');
        
        // Settings & Branding
        Route::get('/settings', [CmsController::class, 'settings'])->name('settings');
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
    });
});
