<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // -------------------------
        // Define permissions
        // -------------------------
        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role Management
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission Management
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',

            // Shipping Management
            'manage governates',
            'manage cities',
            'manage locations',
            'manage shipping rates',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // -------------------------
        // Define roles
        // -------------------------
        $roles = [
            'Admin',
            'Manager',
            'Employee',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // -------------------------
        // Assign permissions
        // -------------------------
        $admin = Role::where('name', 'Admin')->first();
        $manager = Role::where('name', 'Manager')->first();
        $employee = Role::where('name', 'Employee')->first();

        // Admin → all permissions
        $admin->givePermissionTo(Permission::all());

        // Manager → manage users (view, edit) + manage shipping
        $manager->givePermissionTo([
            'view users',
            'edit users',
            'manage governates',
            'manage cities',
            'manage locations',
            'manage shipping rates',
        ]);

        // Employee → view users + view shipping data only
        $employee->givePermissionTo([
            'view users',
            'manage shipping rates',
        ]);
    }
}
