<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Log;
// (PENTING) Pastikan Carbon di-use atau gunakan helper now()
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Dokumen Masuk (Hari Ini)
        $dokumenMasukHariIni = Document::whereDate('created_at', today())->count();

        // 2. Statistik Petugas Lapangan
        $petugasLapangan = User::whereHas('role', function ($query) {
                                $query->where('name', 'petugas');
                            })->count();

        // 3. Statistik Dokumen Bulan Ini
        $dokumenBulanIni = Document::whereMonth('created_at', today()->month)
                                 ->whereYear('created_at', today()->year)
                                 ->count();

        // 4. Statistik Total Arsip
        $totalArsip = Document::count();

        // --- (MODIFIKASI UTAMA DI SINI) ---
        // Mengambil dokumen hanya dari 24 jam terakhir
        $notifikasiTerbaru = Document::with('user', 'documentType')
                                    ->where('created_at', '>=', now()->subDay()) // Ambil data >= waktu sekarang dikurang 1 hari
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        // ----------------------------------

        return view('dashboard', compact(
            'dokumenMasukHariIni',
            'petugasLapangan',
            'dokumenBulanIni',
            'totalArsip',
            'notifikasiTerbaru'
        ));
    }

    // ... (Sisa fungsi document, manage, toggleStatus TETAP SAMA, tidak perlu diubah) ...

    public function document(Request $request)
    {
        $documentTypes = DocumentType::orderBy('name', 'asc')->get();
        $query = Document::query()->with('user', 'documentType');
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->cari . '%')
                  ->orWhere('notes', 'like', '%' . $request->cari . '%');
            });
        }
        if ($request->filled('jenis')) {
            $query->where('document_type_id', $request->jenis);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('event_date', $request->tanggal);
        }
        $documents = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        return view('dokumen', compact('documents', 'documentTypes'));
    }

    public function manage(){
        $users = User::with('role')
                 ->whereHas('role', function ($query) {
                     $query->where('name', 'petugas');
                 })
                 ->get();

        return view('user-manage', [
            'users' => $users
        ]);
    }

    public function toggleStatus(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'status' => 'required|string|in:aktif,nonaktif'
            ]);
            $user->status = $validatedData['status'];
            $user->save();
            return response()->json([
                'success' => true,
                'newStatus' => $user->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan di server: ' . $e->getMessage()
            ], 500);
        }
    }
}
