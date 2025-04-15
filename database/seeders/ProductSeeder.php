<?php

namespace Database\Seeders;

use App\Models\Product;
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
                'description' => 'Sobre Documento',
                'tax' => 'IVA 5%',
                'price' => 5000,
                'is_active' => true,
            ],
            [
                'description' => 'Caja Pequeña',
                'tax' => 'IVA 10%',
                'price' => 15000,
                'is_active' => true,
            ],
            [
                'description' => 'Caja Mediana',
                'tax' => 'IVA 10%',
                'price' => 25000,
                'is_active' => true,
            ],
            [
                'description' => 'Caja Grande',
                'tax' => 'IVA 10%',
                'price' => 40000,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
