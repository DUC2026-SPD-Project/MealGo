<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Permissions
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'view stock']);
        Permission::create(['name' => 'manage stock']); // Add/Edit/Delete products
        Permission::create(['name' => 'make sales']);
        Permission::create(['name' => 'manage employees']);

        // 2. Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);

        // 3. Assign Permissions to Roles
        // Admin gets EVERYTHING
        $adminRole->givePermissionTo(Permission::all());

        // Staff gets specific access
        $staffRole->givePermissionTo(['view stock', 'make sales']);

        // 4. Create Default Users (So you can log in)
        
        // Admin User
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Staff User
        $staff = User::create([
            'name' => 'Staff Member',
            'email' => 'staff@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole('staff');
    }
}