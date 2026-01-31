<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. Core Settings & Users
            RoleSeeder::class,      // Creates Admin/Staff roles and default users

            // 2. Lookup Tables (Must be before products)
            CategorySeeder::class,  // Creates 'Electronics', 'Beverages', etc.
            SupplierSeeder::class,  // Creates 'Coca-Cola', 'Samsung', etc.

            // 3. Main Data (Depends on Categories & Suppliers)
            ProductSeeder::class,   // Creates dummy products linked to the above
        ]);
    }
}