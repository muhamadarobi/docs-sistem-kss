<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * (Fungsi: Jika pengguna SUDAH login dan mencoba mengakses halaman login,
     * lempar mereka ke dashboard yang benar sesuai peran. Ini memperbaiki bug "Ingat Saya")
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                $user = Auth::user();

                // --- PERBAIKAN PENTING ---
                // Pastikan relasi 'role' dimuat, terutama untuk "Remember Me"
                $user->loadMissing('role');
                // --- AKHIR PERBAIKAN ---

                if ($user && $user->role) {
                    if ($user->role->name == 'admin') {
                        // Arahkan admin ke dashboard admin
                        return redirect()->route('admin.dashboard');
                    } elseif ($user->role->name == 'petugas') {
                        // Arahkan petugas ke dashboard petugas
                        return redirect()->route('documents.index');
                    }
                }

                // Fallback default jika ada peran lain atau role tidak terdefinisi
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
