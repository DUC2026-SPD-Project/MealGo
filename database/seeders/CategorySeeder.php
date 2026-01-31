<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Beverages',
            'Snacks',
            'Household',
            'Cosmetics',
            'Fresh Food'
        ];

        foreach ($categories as $cat) {
            // Insert only if it doesn't exist
            if (!DB::table('categories')->where('name', $cat)->exists()) {
                DB::table('categories')->insert([
                    'name' => $cat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}