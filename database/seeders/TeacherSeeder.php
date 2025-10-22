<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some departments first
        $departments = Department::all();

        if ($departments->isEmpty()) {
            $this->command->warn('Please run DepartmentSeeder first!');
            return;
        }

        // Create sample teachers
        Teacher::factory(20)->create([
            'department_id' => $departments->random()->id,
        ]);

        // Create some specific teachers for testing
        $testTeachers = [
            [
                'name' => 'Dr. Mohammad Ali',
                'email' => 'mohammad.teacher@university.com',
                'role' => 'teacher',
                'employee_id' => 'TCH0001',
                'designation' => 'Professor',
                'qualification' => 'PhD',
                'is_department_head' => true,
            ],
            [
                'name' => 'Dr. Sarah Ahmed',
                'email' => 'sarah.teacher@university.com',
                'role' => 'teacher',
                'employee_id' => 'TCH0002',
                'designation' => 'Associate Professor',
                'qualification' => 'PhD',
                'is_department_head' => false,
            ],
            [
                'name' => 'Mr. Hasan Khan',
                'email' => 'hasan.teacher@university.com',
                'role' => 'teacher',
                'employee_id' => 'TCH0003',
                'designation' => 'Assistant Professor',
                'qualification' => 'MSc',
                'is_department_head' => false,
            ],
        ];

        foreach ($testTeachers as $teacherData) {
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role' => $teacherData['role'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'department_id' => $departments->random()->id,
                'employee_id' => $teacherData['employee_id'],
                'designation' => $teacherData['designation'],
                'qualification' => $teacherData['qualification'],
                'salary' => rand(50000, 150000),
                'joining_date' => now()->subYears(rand(1, 10)),
                'employment_type' => 'full-time',
                'specialization' => 'Computer Science',
                'is_department_head' => $teacherData['is_department_head'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Teachers seeded successfully!');
    }
}