<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// --- TAMBAHKAN USE STATEMENT INI ---
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
// --- AKHIR TAMBAHAN ---

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // --- TAMBAHKAN BLOK INI ---
        // Ini mendaftarkan middleware 'role' kita ("Satpam")
        $middleware->alias([
            'role' => CheckRole::class,
        ]);
        // --- AKHIR TAMBAHAN ---

        // Ini adalah konfigurasi default Laravel 11
        // untuk mengarahkan pengguna yang belum login
        $middleware->redirectGuestsTo(fn () => route('login'));

        // Dan ini untuk mengarahkan pengguna yang sudah login
        // (Middleware RedirectIfAuthenticated.php kita yang utama,
        // tapi ini adalah fallback yang baik)
        $middleware->redirectUsersTo(function () {
            if (auth()->check()) {
                // Pastikan role dimuat
                $user = auth()->user();
                $user->loadMissing('role'); // Penting untuk "Ingat Saya"

                if ($user->role && $user->role->name == 'admin') {
                    return route('admin.dashboard');
                }
                if ($user->role && $user->role->name == 'petugas') {
                    return route('documents.index');
                }
            }
            return '/'; // fallback
        });

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
