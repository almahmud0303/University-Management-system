<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample staff
        Staff::factory(15)->create();

        // Create some specific staff for testing
        $testStaff = [
            [
                'name' => 'Abdul Karim',
                'email' => 'abdul.staff@university.com',
                'role' => 'staff',
                'employee_id' => 'STF0001',
                'designation' => 'Clerk',
                'department' => 'Administration',
            ],
            [
                'name' => 'Rashida Begum',
                'email' => 'rashida.staff@university.com',
                'role' => 'staff',
                'employee_id' => 'STF0002',
                'designation' => 'Librarian',
                'department' => 'Library',
            ],
            [
                'name' => 'Mohammad Hossain',
                'email' => 'hossain.staff@university.com',
                'role' => 'staff',
                'employee_id' => 'STF0003',
                'designation' => 'Accountant',
                'department' => 'Finance',
            ],
        ];

        foreach ($testStaff as $staffData) {
            $user = User::create([
                'name' => $staffData['name'],
                'email' => $staffData['email'],
                'password' => Hash::make('password'),
                'role' => $staffData['role'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            Staff::create([
                'user_id' => $user->id,
                'employee_id' => $staffData['employee_id'],
                'designation' => $staffData['designation'],
                'department' => $staffData['department'],
                'salary' => rand(25000, 80000),
                'joining_date' => now()->subYears(rand(1, 5)),
                'employment_type' => 'full_time',
                'bio' => 'Experienced staff member',
                'location' => 'Main Campus',
                'is_active' => true,
            ]);
        }

        $this->command->info('Staff seeded successfully!');
    }
}