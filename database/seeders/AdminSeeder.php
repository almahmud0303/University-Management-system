<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kuet.ac.bd'],
            [
                'name' => 'System Administrator',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '01700000000',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'vc@kuet.ac.bd'],
            [
                'name' => 'Vice Chancellor',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '01700000001',
                'is_active' => true,
            ]
        );
    }
}
