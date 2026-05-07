<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Users
        $admin = User::firstOrCreate(
            ['email' => 'superAdmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('superAdmin'),
                'email_verified' => 1,
                'is_active' => 1,
            ]
        );

         // Roles
        $adminRole     = Role::firstOrCreate(['name' => 'admin']);
        $userRole      = Role::firstOrCreate(['name' => 'user']);
        $bloggerRole   = Role::firstOrCreate(['name' => 'blogger']);
        $sousAdminRole = Role::firstOrCreate(['name' => 'editor']);

        // ADMIN => all permissions
        $adminRole->syncPermissions(Permission::all());

        // Assign roles
        $admin->syncRoles(['admin']);
    }
}
