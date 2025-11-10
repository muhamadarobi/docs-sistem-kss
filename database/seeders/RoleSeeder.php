<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Pastikan Anda use Model Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate agar aman jika seeder dijalankan berkali-kali.
        // Ini akan membuat data jika 'name' = 'admin' belum ada.
        Role::firstOrCreate(['name' => 'admin']);

        // Ini akan membuat data jika 'name' = 'petugas' belum ada.
        Role::firstOrCreate(['name' => 'petugas']);
    }
}
