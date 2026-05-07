<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Users Permissions
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'show user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        // Permissions Permissions
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'show permissions']);
        Permission::create(['name' => 'show permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);

        // Roles Permissions
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'show roles']);
        Permission::create(['name' => 'show role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);
    }
}
