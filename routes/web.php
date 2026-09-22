<?php

use App\Http\Controllers\Admin\AwardController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\LanguageSettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Public Frontend Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Backend Routes
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin.user'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projects', ProjectController::class)->except(['show']);
        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::resource('awards', AwardController::class)->except(['show']);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('settings/language', [LanguageSettingController::class, 'edit'])->name('settings.language.edit');
        Route::put('settings/language', [LanguageSettingController::class, 'update'])->name('settings.language.update');
    });
