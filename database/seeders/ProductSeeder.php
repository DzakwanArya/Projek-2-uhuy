<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $products = [
            [
                'name' => 'Pensil 2B Premium',
                'description' => 'Pensil berkualitas untuk menulis dan menggambar.',
                'category' => 'Alat Tulis',
                'price' => 5000,
                'stock' => 100,
                'image' => '1751274000_Pensil.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pulpen Gel Hitam',
                'description' => 'Pulpen nyaman dengan tinta gel hitam.',
                'category' => 'Alat Tulis',
                'price' => 8000,
                'stock' => 80,
                'image' => '1751274007_pulpen.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Buku Tulis A5',
                'description' => 'Buku tulis ukuran A5 bergaris, 100 halaman.',
                'category' => 'Buku',
                'price' => 12000,
                'stock' => 50,
                'image' => '1751274028_Buku.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($products);
    }
}
