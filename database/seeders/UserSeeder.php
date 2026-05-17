<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@crm.com',
            'current_tenant_id' => null,
        ]);

        $superAdmin->assignRole('super-admin');


        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {

            $admin = User::factory()->create([
                'name' => "Admin {$tenant->name}",
                'email' => "admin_{$tenant->id}@crm.test",
                'current_tenant_id' => $tenant->id,
            ]);
            $admin->assignRole('admin');
            
            DB::table('tenant_user')->insert([
                'tenant_id' => $tenant->id,
                'user_id' => $admin->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($i = 1; $i <= 2; $i++) {
                $seller = User::factory()->create([
                    'name' => "Seller {$i} {$tenant->name}",
                    'email' => "seller{$i}_{$tenant->id}@crm.test",
                    'current_tenant_id' => $tenant->id,
                ]);
                $seller->assignRole('seller');

                DB::table('tenant_user')->insert([
                    'tenant_id' => $tenant->id,
                    'user_id' => $seller->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
