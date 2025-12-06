<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create tickets',
            'view own tickets',
            'view all tickets',
            'assign tickets',
            'update tickets',
            'resolve tickets',
            'close tickets',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $technicianRole = Role::firstOrCreate(['name' => 'technician', 'guard_name' => 'web']);
        $technicianRole->givePermissionTo([
            'view all tickets',
            'assign tickets',
            'update tickets',
            'resolve tickets',
            'close tickets',
        ]);

        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);
        $clientRole->givePermissionTo([
            'create tickets',
            'view own tickets',
        ]);
    }
}