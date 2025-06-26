<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name' => 'Laptop', 'purchase_price' => 50000, 'sell_price' => 65000, 'opening_stock' => 20],
            ['name' => 'Smartphone', 'purchase_price' => 15000, 'sell_price' => 20000, 'opening_stock' => 50],
            ['name' => 'Keyboard', 'purchase_price' => 700, 'sell_price' => 1000, 'opening_stock' => 100],
            ['name' => 'Mouse', 'purchase_price' => 500, 'sell_price' => 800, 'opening_stock' => 120],
            ['name' => 'Monitor', 'purchase_price' => 8000, 'sell_price' => 10000, 'opening_stock' => 30],
            ['name' => 'Printer', 'purchase_price' => 10000, 'sell_price' => 13000, 'opening_stock' => 10],
            ['name' => 'Headphones', 'purchase_price' => 1200, 'sell_price' => 1800, 'opening_stock' => 80],
            ['name' => 'Router', 'purchase_price' => 2000, 'sell_price' => 2500, 'opening_stock' => 40],
            ['name' => 'Webcam', 'purchase_price' => 1500, 'sell_price' => 2200, 'opening_stock' => 25],
            ['name' => 'Speakers', 'purchase_price' => 3000, 'sell_price' => 4000, 'opening_stock' => 60],
        ];

        foreach ($products as $product) {
            Product::create([
                ...$product,
                'current_stock' => $product['opening_stock']
            ]);
        }
    }
}
