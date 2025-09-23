<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'iPhone 15',
            'price' => 1200,
            'description' => 'Latest Apple smartphone',
            'exp_date' => now()->addYear(),
            'img_url' => 'https://example.com/iphone15.jpg',
            'quantity' => 50,
            'category_id' => 1,
            'user_id' => 1,
        ]);

        Product::create([
            'name' => 'T-Shirt',
            'price' => 25,
            'description' => 'Cotton T-shirt',
            'exp_date' => now()->addMonths(6),
            'img_url' => 'https://example.com/tshirt.jpg',
            'quantity' => 200,
            'category_id' => 2,
            'user_id' => 2,
        ]);

        Product::create([
            'name' => 'Harry Potter',
            'price' => 15,
            'description' => 'Famous book',
            'exp_date' => now()->addMonths(12),
            'img_url' => 'https://example.com/harrypotter.jpg',
            'quantity' => 100,
            'category_id' => 3,
            'user_id' => 3,
        ]);
    }
}
