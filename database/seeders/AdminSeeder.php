<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan use Model User
use App\Models\Role; // Pastikan use Model Role

// Nama class disesuaikan dengan panduan (AdminUserSeeder)
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari Role 'admin' yang sudah dibuat oleh RoleSeeder
        $adminRole = Role::where('name', 'admin')->first();

        // 2. Buat user admin baru
        // Pastikan RoleSeeder dijalankan SEBELUM AdminUserSeeder di DatabaseSeeder.php
        if ($adminRole) {
            User::firstOrCreate(
                ['username' => 'admin'], // Cari berdasarkan username 'admin'
                [
                    'name' => 'Admin Manajer', // Ganti dengan nama Manajer
                    'username' => 'admin', // Wajib ada sesuai migrasi create_users
                    'email' => 'admin@kss.co.id', // Ganti dengan email Manajer (opsional)
                    'no_telp' => '081234567890', // Ganti (opsional)
                    'password' => bcrypt('password123'), // GANTI INI di production!
                    'status' => 'aktif',
                    'role_id' => $adminRole->id // Kolom ini sudah ada dari migrasi File 4
                ]
            );
        } else {
            // Tampilkan error jika Role 'admin' tidak ditemukan
            $this->command->error('Role "admin" tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
        }
    }
}
