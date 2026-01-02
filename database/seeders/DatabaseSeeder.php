<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User (Admin & Kasir)
        DB::table('users')->insert([
            [
                'name' => 'Admin Toko',
                'email' => 'admin@toko.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Kasir Budi',
                'email' => 'kasir@toko.com',
                'password' => Hash::make('password'),
                'role' => 'kasir',
            ]
        ]);

        // 2. Buat Produk Dummy
        DB::table('products')->insert([
            [
                'name' => 'Kemeja Flannel Merah',
                'price' => 150000,
                'stock' => 10, // Stok Banyak (Bisa dibeli)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Celana Chino Panjang',
                'price' => 250000,
                'stock' => 5, // Stok Sedang (Bisa dibeli)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Jaket Denim Vintage',
                'price' => 350000,
                'stock' => 1, // STOK KRITIS (Untuk Demo: Display Only)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Kaos Polos Hitam',
                'price' => 50000,
                'stock' => 20, // Barang Murah (Untuk tes beli banyak qty)
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Topi Snapback',
                'price' => 75000,
                'stock' => 1, // STOK KRITIS LAGI
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
