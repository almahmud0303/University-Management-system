<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@kuet.ac.bd',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01700000000',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Vice Chancellor',
            'email' => 'vc@kuet.ac.bd',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01700000001',
            'is_active' => true,
        ]);
    }
}
