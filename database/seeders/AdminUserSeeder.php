<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@university.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Department Head User
        User::firstOrCreate(
            ['email' => 'head@university.com'],
            [
                'name' => 'Department Head',
                'password' => Hash::make('password'),
                'role' => 'department_head',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Teacher User
        User::firstOrCreate(
            ['email' => 'teacher@university.com'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Student User
        User::firstOrCreate(
            ['email' => 'student@university.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create Staff User
        User::firstOrCreate(
            ['email' => 'staff@university.com'],
            [
                'name' => 'Staff User',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}