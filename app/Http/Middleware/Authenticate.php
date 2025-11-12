<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
// Kita tidak perlu AuthenticationException lagi
// use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Pastikan ini 'login' sesuai perubahan yang Anda buat
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array<string>  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // --- INI ADALAH LOGIKA BARU ---

        // Jika ini request API, lempar error JSON (default)
        if ($request->expectsJson()) {
            // Untuk API, kita lempar error
            abort(response()->json(['message' => 'Unauthenticated.'], 401));
        }

        // Jika ini request WEB:
        // Jangan lempar exception. Langsung kembalikan redirect
        // dan tambahkan pesan flash 'error' secara manual.
        return redirect()->guest(route('login'))
            ->with('error', 'Anda harus login terlebih dahulu.');
    }
}
