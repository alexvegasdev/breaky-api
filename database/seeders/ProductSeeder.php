<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Café',
                'description' => 'Café pasado de buena calidad',
                'stock' => 100,
                'price' => 2.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Chocolate',
                'description' => 'Chocolate caliente con leche',
                'stock' => 50,  
                'price' => 2.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Pan con pollo',
                'description' => 'Pan con pollo sancochado, apio y mayonesa',
                'stock' => 30,
                'price' => 3.00,
                'category_id' => 2,
            ],
            [
                'name' => 'Queque',
                'description' => 'Queque esponjoso',
                'stock' => 80,
                'price' => 1.50,
                'category_id' => 3,
            ],
        ];
        foreach ($products as $product) {
            \App\Models\Product::create($product);  
        }
    }
}
