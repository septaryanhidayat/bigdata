<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Admin\CmsController;

// Public Promotional Landing Page
Route::get('/', [LandingPageController::class, 'index'])->name('home');

// Admin CMS Dashboard & Feature Manager
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [CmsController::class, 'dashboard'])->name('dashboard');
    
    // Settings & Branding
    Route::get('/settings', [CmsController::class, 'settings'])->name('settings');
    Route::post('/settings', [CmsController::class, 'updateSettings'])->name('settings.update');

    // Modules Management
    Route::get('/modules', [CmsController::class, 'modules'])->name('modules.index');
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
