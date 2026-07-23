<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/verification-code', [AdminController::class, 'verificationCode'])->name('custom.verification.code');
Route::post('/admin/verification-code', [AdminController::class, 'verificationCodeLogin'])->name('custom.verification.code.login');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

require __DIR__.'/auth.php';
