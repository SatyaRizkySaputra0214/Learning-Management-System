<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@lmsbahasa.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Guru
        User::create([
            'username' => 'guru1',
            'nama_lengkap' => 'John Doe',
            'email' => 'guru1@lmsbahasa.com',
            'role' => 'guru',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'username' => 'guru2',
            'nama_lengkap' => 'Jane Smith',
            'email' => 'guru2@lmsbahasa.com',
            'role' => 'guru',
            'password' => Hash::make('password'),
        ]);

        // Murid
        User::create([
            'username' => 'murid1',
            'nama_lengkap' => 'Ahmad Rizki',
            'email' => 'murid1@lmsbahasa.com',
            'role' => 'murid',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'username' => 'murid2',
            'nama_lengkap' => 'Siti Nurhaliza',
            'email' => 'murid2@lmsbahasa.com',
            'role' => 'murid',
            'password' => Hash::make('password'),
        ]);
    }
}
