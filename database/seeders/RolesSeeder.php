<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions = [
            'manage users',
            'manage customers',
            'manage leads',
            'view reports',
            'assign leads'
        ];

        $sellerPermissions = [
            'view own leads',
            'update own leads',
            'view own customers',
            'create activities'
        ];

        $allPermissions = array_merge($adminPermissions, $sellerPermissions);

        foreach ($allPermissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $seller = Role::firstOrCreate(['name' => 'seller']);

        $admin->syncPermissions($adminPermissions);
        $seller->syncPermissions($sellerPermissions);

        $superAdmin->syncPermissions($allPermissions);
    }
}
