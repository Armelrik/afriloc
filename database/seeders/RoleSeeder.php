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
        $promoterRole = Role::firstOrCreate(['name' => 'promoter']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Create permissions
        $permissions = [
            // Admin permissions
            'manage-properties',
            'manage-bookings',
            'manage-users',
            'manage-contacts',
            'manage-promoters',
            'approve-promoters',
            'manage-commissions',
            
            // Promoter permissions
            'manage-own-properties',
            'create-properties',
            'edit-own-properties',
            'delete-own-properties',
            'view-own-bookings',
            'manage-profile',
            'view-own-earnings',
            
            // Client permissions
            'create-bookings',
            'view-own-bookings',
            'manage-own-profile',
            
            // Shared permissions
            'view-properties',
            'view-bookings',
            'update-bookings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        // Admin has all permissions
        $adminRole->givePermissionTo(Permission::all());
        
        // Promoter permissions
        $promoterRole->givePermissionTo([
            'manage-own-properties',
            'create-properties',
            'edit-own-properties',
            'delete-own-properties',
            'view-own-bookings',
            'manage-profile',
            'view-own-earnings',
            'view-properties',
        ]);
        
        // Client permissions
        $clientRole->givePermissionTo([
            'create-bookings',
            'view-own-bookings',
            'manage-own-profile',
            'view-properties',
        ]);
    }
}
