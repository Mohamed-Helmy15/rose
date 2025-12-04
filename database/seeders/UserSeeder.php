<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles exist
        $roles = ['Admin', 'Manager', 'Employee'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Admin',
                'phone' => '01000000000',
                'password' => Hash::make('password'),
                'role' => 'Admin',
                'is_active' => true,
            ]
        );
        $admin->assignRole('Admin');

        // Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Main Manager',
                'phone' => '01000000001',
                'password' => Hash::make('password'),
                'role' => 'Manager',
                'is_active' => true,
            ]
        );
        $manager->assignRole('Manager');

        // Employee
        $employee = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Store Employee',
                'phone' => '01000000002',
                'password' => Hash::make('password'),
                'role' => 'Employee',
                'is_active' => true,
            ]
        );
        $employee->assignRole('Employee');
    }
}
