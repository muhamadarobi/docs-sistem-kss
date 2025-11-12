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

        // --- MODIFIKASI DISINI ---
        // Tambahkan $request->boolean('remember') untuk mengaktifkan checkbox "Ingat Saya"
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password'], 'status' => 'aktif'], $request->boolean('remember'))) {
            $request->session()->regenerate();

            // === MODIFIKASI DIMULAI DI SINI ===

            // Ambil data user yang baru saja login
            $user = Auth::user();

            // Muat relasi 'role' (pastikan model App\Models\Role ada)
            $user->load('role');

            // Cek nama role
            if ($user->role && $user->role->name === 'petugas') {
                // Jika role adalah 'petugas', redirect ke 'documents.index'
                return redirect()->intended(route('documents.index'));
            }

            // Jika bukan 'petugas' (misal 'admin'), redirect ke dashboard
            return redirect()->intended(route('admin.dashboard'));
            // === MODIFIKASI SELESAI ===
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

        return redirect(route('login')); // Redirect kembali ke halaman login
    }
}
