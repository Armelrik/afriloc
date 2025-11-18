<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $tenantRole = Role::firstOrCreate(['name' => 'tenant']);

        // Create permissions
        $permissions = [
            'manage-properties',
            'manage-bookings',
            'manage-users',
            'manage-contacts',
            'create-properties',
            'edit-properties',
            'delete-properties',
            'view-bookings',
            'update-bookings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $ownerRole->givePermissionTo(['create-properties', 'edit-properties', 'view-bookings']);
        $tenantRole->givePermissionTo(['view-bookings']);
    }
}
