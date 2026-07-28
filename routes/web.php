<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ProfileController as BackendProfileController;
use App\Http\Controllers\Google2FAController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/admin/verification-google2fa-code', [Google2FAController::class, 'showSetupForm'])->name('google2fa.code');
    Route::post('/admin/verification-google2fa-code', [Google2FAController::class, 'enable2FA'])->name('google2fa.login');
});

Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/profile', [BackendProfileController::class, 'index'])->name('admin.profile');
    Route::post('/admin/profile', [BackendProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/admin/change-password', [BackendProfileController::class, 'changePassword'])->name('admin.change-password');
});

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/verification-code', [AdminController::class, 'verificationCode'])->name('custom.verification.code');
Route::post('/admin/verification-code', [AdminController::class, 'verificationCodeLogin'])->name('custom.verification.code.login');



Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

require __DIR__.'/auth.php';
