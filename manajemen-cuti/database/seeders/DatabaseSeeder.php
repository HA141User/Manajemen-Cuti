<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User ADMIN
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@company.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'join_date' => '2020-01-01',
        ]);

        // 2. Buat User HRD
        User::create([
            'name' => 'HR Manager',
            'username' => 'hrd',
            'email' => 'hrd@company.com',
            'password' => Hash::make('password'),
            'role' => 'hrd',
            'join_date' => '2021-01-01',
        ]);

        // 3. Buat User KETUA DIVISI (Awalnya belum punya divisi)
        $leader = User::create([
            'name' => 'Pak Budi (IT Lead)',
            'username' => 'budi_leader',
            'email' => 'budi@company.com',
            'password' => Hash::make('password'),
            'role' => 'leader',
            'join_date' => '2022-01-01',
        ]);

        // 4. Buat DIVISI IT dan set Pak Budi sebagai ketua
        $division = Division::create([
            'name' => 'Information Technology',
            'description' => 'Divisi ngurusin kodingan',
            'leader_id' => $leader->id, // Set Leader
        ]);

        // Update Pak Budi supaya masuk ke divisi IT juga sebagai member
        $leader->update(['division_id' => $division->id]);

        // 5. Buat User KARYAWAN (Bawahan Pak Budi)
        User::create([
            'name' => 'Andi Staff',
            'username' => 'andi_staff',
            'email' => 'andi@company.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'division_id' => $division->id, // Masuk divisi IT
            'join_date' => '2023-01-01',
        ]);

        // 6. Buat Karyawan Freelance (Tanpa Divisi) untuk tes fitur admin
        User::create([
            'name' => 'Siti Probation',
            'username' => 'siti',
            'email' => 'siti@company.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'join_date' => date('Y-m-d'), // Baru masuk hari ini
        ]);
    }
}