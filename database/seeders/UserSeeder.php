<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Dr. Ahmad Wijaya',
            'email' => 'dokter@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'phone' => '081234567891',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Nurse Siti',
            'email' => 'perawat@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'perawat',
            'phone' => '081234567892',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Staff Registrasi',
            'email' => 'registrasi@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'registrasi',
            'phone' => '081234567893',
            'is_active' => true,
        ]);
    }
}