<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'Coca-Cola Company', 'phone' => '012-333-444'],
            ['name' => 'Samsung Cambodia', 'phone' => '010-999-888'],
            ['name' => 'Unilever', 'phone' => '011-222-333'],
        ];

        foreach ($suppliers as $sup) {
            DB::table('suppliers')->insert([
                'name' => $sup['name'],
                'phone' => $sup['phone'],
                'address' => 'Phnom Penh, Cambodia',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}