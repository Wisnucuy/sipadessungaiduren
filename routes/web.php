<?php

use Illuminate\Support\Facades\Route;

// ── Controllers Warga ──────────────────────────────
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Warga\DashboardController;
use App\Http\Controllers\Warga\ApplicationController;
use App\Http\Controllers\Warga\ProfileController;

// ── Controllers Admin ──────────────────────────────
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController
    as AdminDashboardController;
use App\Http\Controllers\Admin\ApplicationController
    as AdminApplicationController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\LetterTypeController;
use App\Http\Controllers\Admin\VillageProfileController;
use App\Http\Controllers\Admin\SettingController;

// ============================================================
// HALAMAN PUBLIK
// ============================================================

Route::get('/', function () {
    return view('landing');
})->name('home');

// ============================================================
// AUTH WARGA
// ============================================================

Route::get('/register', [RegisterController::class, 'showRegisterForm'])
    ->name('register');
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.post');
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// ============================================================
// HALAMAN WARGA (harus login)
// ============================================================

Route::middleware(['auth.warga'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('warga.dashboard');

    // Profil Warga
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('warga.profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('warga.profile.update');
    Route::put('/profile/password',
        [ProfileController::class, 'changePassword'])
        ->name('warga.profile.password');

    // Pengajuan Surat
    Route::prefix('applications')->name('warga.applications.')
        ->group(function () {
            Route::get('/', [ApplicationController::class, 'index'])
                ->name('index');
            Route::get('/create', [ApplicationController::class, 'create'])
                ->name('create');
            Route::post('/', [ApplicationController::class, 'store'])
                ->name('store');
            Route::get('/{id}/edit', [ApplicationController::class, 'edit'])
                ->name('edit');
            Route::put('/{id}', [ApplicationController::class, 'update'])
                ->name('update');
            Route::delete('/{id}', [ApplicationController::class, 'destroy'])
                ->name('destroy');
            Route::get('/{id}', [ApplicationController::class, 'show'])
                ->name('show');
        });

});

// ============================================================
// ADMIN
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {

    // Auth Admin
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('login');
    Route::post('/login', [AdminLoginController::class, 'login'])
        ->name('login.post');
    Route::post('/logout', [AdminLoginController::class, 'logout'])
        ->name('logout');

    Route::middleware(['auth.admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard',
            [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Pengajuan
        Route::prefix('applications')->name('applications.')
            ->group(function () {
                Route::get('/',
                    [AdminApplicationController::class, 'index'])
                    ->name('index');
                Route::get('/{id}/pdf',
                    [PdfController::class, 'generate'])
                    ->name('pdf');
                Route::post('/{id}/verify',
                    [AdminApplicationController::class, 'verify'])
                    ->name('verify');
                Route::post('/{id}/approve',
                    [AdminApplicationController::class, 'approve'])
                    ->name('approve');
                Route::post('/{id}/reject',
                    [AdminApplicationController::class, 'reject'])
                    ->name('reject');
                Route::post('/{id}/complete',
                    [AdminApplicationController::class, 'complete'])
                    ->name('complete');
                Route::get('/{id}',
                    [AdminApplicationController::class, 'show'])
                    ->name('show');
            });

        // Jenis Surat
        Route::prefix('letter-types')->name('letter-types.')
            ->group(function () {
                Route::get('/',
                    [LetterTypeController::class, 'index'])
                    ->name('index');
                Route::get('/create',
                    [LetterTypeController::class, 'create'])
                    ->name('create');
                Route::post('/',
                    [LetterTypeController::class, 'store'])
                    ->name('store');
                Route::get('/{id}/edit',
                    [LetterTypeController::class, 'edit'])
                    ->name('edit');
                Route::put('/{id}',
                    [LetterTypeController::class, 'update'])
                    ->name('update');
                Route::post('/{id}/toggle',
                    [LetterTypeController::class, 'toggleStatus'])
                    ->name('toggle');
                Route::delete('/{id}',
                    [LetterTypeController::class, 'destroy'])
                    ->name('destroy');
            });

        // Profil Desa
        Route::get('/village-profile/edit',
            [VillageProfileController::class, 'edit'])
            ->name('village-profile.edit');
        Route::put('/village-profile',
            [VillageProfileController::class, 'update'])
            ->name('village-profile.update');

        // Pengaturan Admin
        Route::prefix('settings')->name('settings.')
            ->group(function () {
                Route::get('/',
                    [SettingController::class, 'index'])
                    ->name('index');
                Route::get('/create',
                    [SettingController::class, 'create'])
                    ->name('create');
                Route::post('/',
                    [SettingController::class, 'store'])
                    ->name('store');
                Route::get('/{id}/edit',
                    [SettingController::class, 'edit'])
                    ->name('edit');
                Route::put('/{id}',
                    [SettingController::class, 'update'])
                    ->name('update');
                Route::put('/{id}/password',
                    [SettingController::class, 'changePassword'])
                    ->name('password');
                Route::delete('/{id}',
                    [SettingController::class, 'destroy'])
                    ->name('destroy');
            });

    });

});