<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Menampilkan halaman login.
     * Sesuai dengan route: Route::get('/', [UserController::class, 'index'])->name('user.login');
     */
    public function index()
    {
        // Pastikan Anda memiliki view di resources/views/auth/login.blade.php
        return view('auth.index');
    }

    /**
     * Memproses upaya login.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba untuk login
        // Kita juga tambahkan pengecekan 'status' => 'aktif'
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => 'aktif'])) {
            $request->session()->regenerate();

            // Redirect ke dashboard setelah login berhasil
            // Anda bisa tambahkan logika redirect berdasarkan role di sini
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Memproses logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('user.login')); // Redirect kembali ke halaman login
    }
}
