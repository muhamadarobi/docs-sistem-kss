<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentsController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/document', [AdminController::class, 'document'])->name('admin.document');
Route::get('/manage', [AdminController::class, 'manage'])->name('admin.usermanage');

Route::get('/user', [DocumentsController::class, 'index'])->name('documents.index');
