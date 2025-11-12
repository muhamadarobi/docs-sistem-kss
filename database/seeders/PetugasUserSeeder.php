<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class PetugasUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cari Role 'petugas'
        $petugasRole = Role::where('name', 'petugas')->first();

        // 2. Pastikan role-nya ada
        if ($petugasRole) {

            // 3. Buat Petugas Contoh 1
            User::firstOrCreate(
                ['username' => 'petugas1'], // Cari berdasarkan username
                [
                    'name' => 'Petugas Lapangan Satu',
                    'username' => 'petugas1',
                    'email' => 'petugas1@kss.co.id',
                    'no_telp' => '081111111111',
                    'password' => bcrypt('password123'),
                    'status' => 'aktif',
                    'role_id' => $petugasRole->id
                ]
            );

            // 4. Buat Petugas Contoh 2
            User::firstOrCreate(
                ['username' => 'petugas2'], // Cari berdasarkan username
                [
                    'name' => 'Petugas Lapangan Dua',
                    'username' => 'petugas2',
                    'email' => 'petugas2@kss.co.id',
                    'no_telp' => '082222222222',
                    'password' => bcrypt('password123'),
                    'status' => 'aktif',
                    'role_id' => $petugasRole->id
                ]
            );

        } else {
            $this->command->error('Role "petugas" tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
        }
    }
}
