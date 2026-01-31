<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get IDs of Categories (Safely)
        // We use firstOrCreate just in case CategorySeeder didn't run, 
        // preventing the "Duplicate Entry" error.
        $electronics = Category::firstOrCreate(['name' => 'Electronics']);
        $beverages = Category::firstOrCreate(['name' => 'Beverages']);

        // 2. Get IDs of Suppliers (Safely)
        $samsung = Supplier::firstOrCreate(['name' => 'Samsung Cambodia']);
        $coke = Supplier::firstOrCreate(['name' => 'Coca-Cola Company']);

        // 3. Create Products
        // We check if the product exists first to avoid duplicates if you run seed twice.
        
        $products = [
            [
                'name_en' => 'iPhone 15 Pro',
                'name_kh' => 'អាយហ្វូន 15 Pro',
                'barcode' => '8850001',
                'category_id' => $electronics->id,
                'supplier_id' => $samsung->id,
                'cost_price' => 900.00,
                'sale_price' => 1200.00,
                'qty' => 10,
                'image' => null,
            ],
            [
                'name_en' => 'Coca Cola Can',
                'name_kh' => 'កូកាកូឡា',
                'barcode' => '8850002',
                'category_id' => $beverages->id,
                'supplier_id' => $coke->id,
                'cost_price' => 0.50,
                'sale_price' => 1.00,
                'qty' => 100,
                'image' => null,
            ]
        ];

        foreach ($products as $item) {
            Product::firstOrCreate(
                ['barcode' => $item['barcode']], // Check unique barcode
                $item // If not found, create with this data
            );
        }
    }
}