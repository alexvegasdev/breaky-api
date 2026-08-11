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
                'price' => 2.00,
            ],
            [
                'name' => 'Chocolate',
                'description' => 'Chocolate caliente con leche',
                'price' => 2.00,
            ],
            [
                'name' => 'Pan con pollo',
                'description' => 'Pan con pollo sancochado, apio y mayonesa',
                'price' => 3.00,
            ],
            [
                'name' => 'Queque',
                'description' => 'Queque esponjoso',
                'price' => 1.50,
            ],
        ];
        foreach ($products as $product) {
            \App\Models\Product::create($product);  
        }
    }
}
