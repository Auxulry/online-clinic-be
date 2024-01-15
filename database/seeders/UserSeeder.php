<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.com',
            'password' => bcrypt('Admin123'),
            'is_admin' => true,
            'is_verified' => true,
            'gender' => 0,
            'nik' => 1234,
            'address' => 'address',
            'phone' => '+62',
            'birthdate' => '2000-12-09'
        ]);
        User::create([
            'name' => 'Akbar',
            'email' => 'akbar@klinik.com',
            'password' => bcrypt('Admin123'),
            'is_admin' => false,
            'is_verified' => false,
            'gender' => 0,
            'nik' => 1234567890,
            'address' => 'address',
            'phone' => '+6287893355332',
            'birthdate' => '2000-12-09'
        ]);
    }
}
