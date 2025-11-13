<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\UserController;

// === RUTE UNTUK TAMU (YANG BELUM LOGIN) ===
// Dilindungi oleh middleware 'guest'
Route::middleware(['guest'])->group(function () {
    // Halaman login
    Route::get('/', [UserController::class, 'index'])->name('login');
    // Proses login
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.process');
});


// === RUTE UMUM (SUDAH LOGIN, TAPI UNTUK SEMUA ROLE) ===
// Dilindungi oleh middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // Proses logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});


// === RUTE KHUSUS ADMIN ===
// Dilindungi 'auth' (harus login) DAN 'role:admin' (harus admin)
// INILAH PERBAIKANNYA:
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/document', [AdminController::class, 'document'])->name('admin.document');
    Route::get('/manage', [AdminController::class, 'manage'])->name('admin.usermanage');

    Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.user.toggleStatus');
    Route::post('/manage/store', [AdminController::class, 'store'])->name('admin.user.store');

});


// === RUTE KHUSUS PETUGAS ===
// Dilindungi 'auth' (harus login) DAN 'role:petugas' (harus petugas)
// INILAH PERBAIKANNYA:
Route::middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/user', [DocumentsController::class, 'index'])->name('documents.index');
    // Tambahkan rute petugas lainnya di sini jika ada...

});
