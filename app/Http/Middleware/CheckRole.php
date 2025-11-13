<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * (Fungsi: "Satpam" yang memeriksa apakah pengguna punya peran yang benar
     * untuk mengakses rute yang dilindungi)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role (Ini adalah parameter dari web.php, misal: 'admin' atau 'petugas')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login DAN
        // 2. Cek apakah user punya relasi 'role' DAN
        // 3. Cek apakah nama role-nya sesuai dengan yang diizinkan ($role)
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role->name != $role) {

            // Jika tidak sesuai, alihkan ke dashboard mereka yang seharusnya
            // (Contoh: 'petugas' coba akses rute 'admin', akan dikembalikan ke '/user')
            if (Auth::user() && Auth::user()->role) {
                if (Auth::user()->role->name == 'admin') {
                    return redirect()->route('admin.dashboard')->with('error', 'Akses ditolak.');
                } elseif (Auth::user()->role->name == 'petugas') {
                    return redirect()->route('documents.index')->with('error', 'Akses ditolak.');
                }
            }

            // Fallback jika terjadi sesuatu (misal role tidak ada), kembali ke login
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sesi tidak valid.');
        }

        // Jika peran sesuai, izinkan request (lanjutkan ke controller)
        return $next($request);
    }
}
