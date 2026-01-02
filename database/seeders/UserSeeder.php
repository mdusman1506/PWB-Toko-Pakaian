<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin
        DB::table('users')->insert([
            'name' => 'Admin Toko',
            'email' => 'admin@toko.com',
            'password' => Hash::make('123456'), // Password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Akun Kasir
        DB::table('users')->insert([
            'name' => 'Usman',
            'email' => 'kasir@toko.com',
            'password' => Hash::make('123456'), // Password
            'role' => 'kasir',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
