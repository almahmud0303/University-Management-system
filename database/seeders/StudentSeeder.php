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

        // Create sample students using factory
        Student::factory(100)->create([
            'department_id' => $departments->random()->id,
            'hall_id' => $halls->random()->id,
        ]);

        // Create comprehensive demo students for testing
        $demoStudents = [
            // Computer Science & Engineering Students
            [
                'name' => 'Ahmed Rahman',
                'email' => 'ahmed.rahman@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023001',
                'roll_number' => 'CSE2023001',
                'registration_number' => 'REG2023001',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.75,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Fatima Khan',
                'email' => 'fatima.khan@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023002',
                'roll_number' => 'CSE2023002',
                'registration_number' => 'REG2023002',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.85,
                'completed_credits' => 40,
            ],
            [
                'name' => 'Karim Hassan',
                'email' => 'karim.hassan@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2022001',
                'roll_number' => 'CSE2022001',
                'registration_number' => 'REG2022001',
                'session' => '2022-23',
                'academic_year' => '2nd',
                'semester' => '3rd',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.65,
                'completed_credits' => 60,
            ],
            [
                'name' => 'Sara Ahmed',
                'email' => 'sara.ahmed@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2022002',
                'roll_number' => 'CSE2022002',
                'registration_number' => 'REG2022002',
                'session' => '2022-23',
                'academic_year' => '2nd',
                'semester' => '4th',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.90,
                'completed_credits' => 80,
            ],
            [
                'name' => 'Mohammad Ali',
                'email' => 'mohammad.ali@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2021001',
                'roll_number' => 'CSE2021001',
                'registration_number' => 'REG2021001',
                'session' => '2021-22',
                'academic_year' => '3rd',
                'semester' => '5th',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.55,
                'completed_credits' => 100,
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat.jahan@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2021002',
                'roll_number' => 'CSE2021002',
                'registration_number' => 'REG2021002',
                'session' => '2021-22',
                'academic_year' => '3rd',
                'semester' => '6th',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.80,
                'completed_credits' => 120,
            ],
            [
                'name' => 'Rakib Hasan',
                'email' => 'rakib.hasan@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2020001',
                'roll_number' => 'CSE2020001',
                'registration_number' => 'REG2020001',
                'session' => '2020-21',
                'academic_year' => '4th',
                'semester' => '7th',
                'status' => 'active',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.70,
                'completed_credits' => 140,
            ],
            [
                'name' => 'Tasnim Rahman',
                'email' => 'tasnim.rahman@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2020002',
                'roll_number' => 'CSE2020002',
                'registration_number' => 'REG2020002',
                'session' => '2020-21',
                'academic_year' => '4th',
                'semester' => '8th',
                'status' => 'graduated',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.95,
                'completed_credits' => 160,
            ],

            // Electrical & Electronic Engineering Students
            [
                'name' => 'Imran Hossain',
                'email' => 'imran.hossain@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023003',
                'roll_number' => 'EEE2023001',
                'registration_number' => 'REG2023003',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Electrical & Electronic Engineering',
                'cgpa' => 3.60,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Rashida Begum',
                'email' => 'rashida.begum@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023004',
                'roll_number' => 'EEE2023002',
                'registration_number' => 'REG2023004',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Electrical & Electronic Engineering',
                'cgpa' => 3.75,
                'completed_credits' => 40,
            ],
            [
                'name' => 'Shahidul Islam',
                'email' => 'shahidul.islam@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2022003',
                'roll_number' => 'EEE2022001',
                'registration_number' => 'REG2022003',
                'session' => '2022-23',
                'academic_year' => '2nd',
                'semester' => '3rd',
                'status' => 'active',
                'department' => 'Electrical & Electronic Engineering',
                'cgpa' => 3.50,
                'completed_credits' => 60,
            ],
            [
                'name' => 'Nasrin Akter',
                'email' => 'nasrin.akter@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2022004',
                'roll_number' => 'EEE2022002',
                'registration_number' => 'REG2022004',
                'session' => '2022-23',
                'academic_year' => '2nd',
                'semester' => '4th',
                'status' => 'active',
                'department' => 'Electrical & Electronic Engineering',
                'cgpa' => 3.85,
                'completed_credits' => 80,
            ],

            // Mechanical Engineering Students
            [
                'name' => 'Abdul Kader',
                'email' => 'abdul.kader@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023005',
                'roll_number' => 'ME2023001',
                'registration_number' => 'REG2023005',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Mechanical Engineering',
                'cgpa' => 3.45,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Salma Khatun',
                'email' => 'salma.khatun@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023006',
                'roll_number' => 'ME2023002',
                'registration_number' => 'REG2023006',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Mechanical Engineering',
                'cgpa' => 3.70,
                'completed_credits' => 40,
            ],
            [
                'name' => 'Mahmudul Hasan',
                'email' => 'mahmudul.hasan@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2022005',
                'roll_number' => 'ME2022001',
                'registration_number' => 'REG2022005',
                'session' => '2022-23',
                'academic_year' => '2nd',
                'semester' => '3rd',
                'status' => 'active',
                'department' => 'Mechanical Engineering',
                'cgpa' => 3.60,
                'completed_credits' => 60,
            ],

            // Civil Engineering Students
            [
                'name' => 'Rokeya Sultana',
                'email' => 'rokeya.sultana@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023007',
                'roll_number' => 'CE2023001',
                'registration_number' => 'REG2023007',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Civil Engineering',
                'cgpa' => 3.80,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Kamrul Islam',
                'email' => 'kamrul.islam@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023008',
                'roll_number' => 'CE2023002',
                'registration_number' => 'REG2023008',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Civil Engineering',
                'cgpa' => 3.65,
                'completed_credits' => 40,
            ],

            // Textile Engineering Students
            [
                'name' => 'Farhana Yasmin',
                'email' => 'farhana.yasmin@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023009',
                'roll_number' => 'TE2023001',
                'registration_number' => 'REG2023009',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Textile Engineering',
                'cgpa' => 3.55,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Sajjad Hossain',
                'email' => 'sajjad.hossain@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023010',
                'roll_number' => 'TE2023002',
                'registration_number' => 'REG2023010',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Textile Engineering',
                'cgpa' => 3.75,
                'completed_credits' => 40,
            ],

            // Industrial Engineering Students
            [
                'name' => 'Mst. Roksana',
                'email' => 'roksana@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023011',
                'roll_number' => 'IE2023001',
                'registration_number' => 'REG2023011',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Industrial Engineering',
                'cgpa' => 3.70,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Arifur Rahman',
                'email' => 'arifur.rahman@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023012',
                'roll_number' => 'IE2023002',
                'registration_number' => 'REG2023012',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Industrial Engineering',
                'cgpa' => 3.85,
                'completed_credits' => 40,
            ],

            // Architecture Students
            [
                'name' => 'Nazmul Haque',
                'email' => 'nazmul.haque@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023013',
                'roll_number' => 'ARCH2023001',
                'registration_number' => 'REG2023013',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '1st',
                'status' => 'active',
                'department' => 'Architecture',
                'cgpa' => 3.90,
                'completed_credits' => 20,
            ],
            [
                'name' => 'Sharmin Akter',
                'email' => 'sharmin.akter@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2023014',
                'roll_number' => 'ARCH2023002',
                'registration_number' => 'REG2023014',
                'session' => '2023-24',
                'academic_year' => '1st',
                'semester' => '2nd',
                'status' => 'active',
                'department' => 'Architecture',
                'cgpa' => 3.65,
                'completed_credits' => 40,
            ],

            // Some graduated students
            [
                'name' => 'Dr. Mohammad Ali',
                'email' => 'mohammad.ali.grad@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2019001',
                'roll_number' => 'CSE2019001',
                'registration_number' => 'REG2019001',
                'session' => '2019-20',
                'academic_year' => '4th',
                'semester' => '8th',
                'status' => 'graduated',
                'department' => 'Computer Science & Engineering',
                'cgpa' => 3.95,
                'completed_credits' => 160,
            ],
            [
                'name' => 'Dr. Fatema Khatun',
                'email' => 'fatema.khatun.grad@student.kuet.ac.bd',
                'role' => 'student',
                'student_id' => 'STU2019002',
                'roll_number' => 'EEE2019001',
                'registration_number' => 'REG2019002',
                'session' => '2019-20',
                'academic_year' => '4th',
                'semester' => '8th',
                'status' => 'graduated',
                'department' => 'Electrical & Electronic Engineering',
                'cgpa' => 3.88,
                'completed_credits' => 160,
            ],
        ];

        foreach ($demoStudents as $studentData) {
            // Find department by name
            $department = $departments->where('name', $studentData['department'])->first();
            if (!$department) {
                $department = $departments->random();
            }

            $user = User::create([
                'name' => $studentData['name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password'),
                'role' => $studentData['role'],
                'is_active' => $studentData['status'] === 'active',
                'email_verified_at' => now(),
            ]);

            Student::create([
                'user_id' => $user->id,
                'department_id' => $department->id,
                'student_id' => $studentData['student_id'],
                'roll_number' => $studentData['roll_number'],
                'registration_number' => $studentData['registration_number'],
                'session' => $studentData['session'],
                'academic_year' => $studentData['academic_year'],
                'semester' => $studentData['semester'],
                'admission_date' => now()->subYears(rand(1, 4)),
                'status' => $studentData['status'],
                'hall_id' => $halls->random()->id,
                'blood_group' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'][rand(0, 7)],
                'guardian_name' => 'Guardian of ' . $studentData['name'],
                'guardian_phone' => '01' . rand(100000000, 999999999),
                'cgpa' => $studentData['cgpa'],
                'total_credits' => 160,
                'completed_credits' => $studentData['completed_credits'],
                'is_active' => $studentData['status'] === 'active',
            ]);
        }

        $this->command->info('Demo students seeded successfully! Total: ' . (100 + count($demoStudents)) . ' students');
    }
}