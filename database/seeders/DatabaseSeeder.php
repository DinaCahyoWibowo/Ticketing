<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Membuat Akun SPV (Yang Mendelegasikan)
        User::create([
            'name' => 'Supervisor IT',
            'email' => 'spv@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'spv',
        ]);

        // 2. Membuat Akun Staff IT (Yang Mengerjakan)
        User::create([
            'name' => 'Andi Staff IT',
            'email' => 'andi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'it_staff',
        ]);

        User::create([
            'name' => 'Budi Staff IT',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'it_staff',
        ]);

        // 3. Membuat Akun Karyawan (Yang Membuat Tiket)
        User::create([
            'name' => 'Karyawan Biasa',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'karyawan',
        ]);
    }
}