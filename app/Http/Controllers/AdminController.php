<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('dashboard'); // <-- TETAP
    }

    public function document(){
        return view('dokumen'); // <-- TETAP
    }

    public function manage(){
        // --- LOGIKA DITAMBAHKAN ---
        $users = User::with('role')
                    ->whereHas('role', function ($query) {
                        $query->where('name', 'petugas');
                    })
                    ->get();
        // --- SELESAI ---

        return view('user-manage', [
            'users' => $users
        ]); // <-- TETAP
    }

    /**
     * Mengubah status aktif/nonaktif pengguna.
     */
    public function toggleStatus(Request $request, User $user)
    {
        try {

            $validatedData = $request->validate([
                'status' => 'required|string|in:aktif,nonaktif'
            ]);

            $user->status = $validatedData['status'];
            $user->save(); // Coba simpan

            // Kirim balasan sukses
            return response()->json([
                'success' => true,
                'newStatus' => $user->status
            ]);

        } catch (\Exception $e) {

            // --- PERBAIKAN: BLOK CATCH YANG LEBIH AMAN ---
            // Kita tidak menggunakan Log::error() untuk sementara,
            // untuk mencegah error ganda jika folder 'storage' tidak writable.

            // Kirim balasan error yang sederhana
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan di server: ' . $e->getMessage()
            ], 500);
            // --- AKHIR PERBAIKAN ---
        }
    }
}
