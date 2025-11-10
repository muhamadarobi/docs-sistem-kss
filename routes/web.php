<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\UserController;

// === RUTE UNTUK TAMU (YANG BELUM LOGIN) ===
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/', [UserController::class, 'index'])->name('user.login');
    // Rute ini untuk menangani data yang dikirim dari form login
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.process');
});


// === RUTE YANG DILINDUNGI (WAJIB LOGIN) ===
Route::middleware(['auth'])->group(function () {

    // Rute ini untuk proses logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/document', [AdminController::class, 'document'])->name('admin.document');
    Route::get('/manage', [AdminController::class, 'manage'])->name('admin.usermanage');

    // User
    Route::get('/user', [DocumentsController::class, 'index'])->name('documents.index');

});
