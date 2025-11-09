<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DocumentType; // Pastikan Anda use Model

class DocumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar jenis dokumen dari gambar Anda + tambahan
        $types = [
            'Surat Keluar',
            'Surat Masuk',
            'Serah Terima Barang',
            'Pnbp',
            'Notulen Pemeliharaan',
            'Sewa Forklift',
            'Permintaan Barang',
            'Laporan Bulanan Angkutan',
            'Bongkar Muat',
            'Dokumen SOP', // Tambahan sesuai permintaan
            'Lainnya' // Selalu siapkan opsi 'Lainnya'
        ];

        foreach ($types as $type) {
            // Gunakan firstOrCreate agar aman jika seeder dijalankan berkali-kali
            // Ini akan membuat data jika belum ada, atau mengabaikannya jika sudah ada.
            DocumentType::firstOrCreate(['name' => $type]);
        }
    }
}
