<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use App\Models\Hall;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some departments first
        $departments = Department::all();
        $halls = Hall::all();

        if ($departments->isEmpty() || $halls->isEmpty()) {
            $this->command->warn('Please run DepartmentSeeder and HallSeeder first!');
            return;
        }

        // Create sample students
        Student::factory(50)->create([
            'department_id' => $departments->random()->id,
            'hall_id' => $halls->random()->id,
        ]);

        // Create some specific students for testing
        $testStudents = [
            [
                'name' => 'Ahmed Rahman',
                'email' => 'ahmed.student@university.com',
                'role' => 'student',
                'student_id' => 'STU0001',
                'roll_number' => 'ROLL0001',
                'registration_number' => 'REG0001',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
            ],
            [
                'name' => 'Fatima Khan',
                'email' => 'fatima.student@university.com',
                'role' => 'student',
                'student_id' => 'STU0002',
                'roll_number' => 'ROLL0002',
                'registration_number' => 'REG0002',
                'session' => '2023-24',
                'academic_year' => '2nd',
                'semester' => '3rd',
                'status' => 'active',
            ],
            [
                'name' => 'Karim Hassan',
                'email' => 'karim.student@university.com',
                'role' => 'student',
                'student_id' => 'STU0003',
                'roll_number' => 'ROLL0003',
                'registration_number' => 'REG0003',
                'session' => '2022-23',
                'academic_year' => '4th',
                'semester' => '8th',
                'status' => 'graduated',
            ],
        ];

        foreach ($testStudents as $studentData) {
            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role' => $studentData['role'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            Student::create([
                'user_id' => $user->id,
                'department_id' => $departments->random()->id,
                'student_id' => $studentData['student_id'],
                'roll_number' => $studentData['roll_number'],
                'registration_number' => $studentData['registration_number'],
                'session' => $studentData['session'],
                'academic_year' => $studentData['academic_year'],
                'semester' => $studentData['semester'],
                'admission_date' => now()->subYears(rand(1, 4)),
                'status' => $studentData['status'],
                'hall_id' => $halls->random()->id,
                'blood_group' => 'A+',
                'guardian_name' => 'Guardian Name',
                'guardian_phone' => '01234567890',
                'cgpa' => rand(250, 400) / 100,
                'total_credits' => 160,
                'completed_credits' => $studentData['status'] === 'graduated' ? 160 : rand(0, 120),
                'is_active' => $studentData['status'] === 'active',
            ]);
        }

        $this->command->info('Students seeded successfully!');
    }
}