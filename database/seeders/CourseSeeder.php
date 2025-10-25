<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create some departments and teachers first
        $departments = Department::all();
        $teachers = Teacher::all();

        if ($departments->isEmpty() || $teachers->isEmpty()) {
            $this->command->warn('Please run DepartmentSeeder and TeacherSeeder first!');
            return;
        }

        // Create sample courses
        Course::factory(30)->create([
            'department_id' => $departments->random()->id,
            'teacher_id' => $teachers->random()->id,
        ]);

        // Create some specific courses for testing
        $testCourses = [
            [
                'title' => 'Data Structures and Algorithms',
                'course_code' => 'CSE101',
                'description' => 'Introduction to fundamental data structures and algorithms',
                'credits' => 3,

                'course_type' => 'theory',
            ],
            [
                'title' => 'Database Management Systems',
                'course_code' => 'CSE102',
                'description' => 'Design and implementation of database systems',
                'credits' => 3,
                'course_type' => 'theory',
            ],
            [
                'title' => 'Programming Lab I',
                'course_code' => 'CSE103',
                'description' => 'Practical programming exercises',
                'credits' => 1,
                'course_type' => 'lab',
            ],
            [
                'title' => 'Software Engineering',
                'course_code' => 'CSE201',
                'description' => 'Software development methodologies and practices',
                'credits' => 3,
                'course_type' => 'theory',
            ],
            [
                'title' => 'Final Year Project',
                'course_code' => 'CSE401',
                'description' => 'Capstone project for final year students',
                'credits' => 6,
                'course_type' => 'project',
            ],
        ];

        foreach ($testCourses as $courseData) {
            Course::create([
                'title' => $courseData['title'],
                'course_code' => $courseData['course_code'],
                'description' => $courseData['description'],
                'credits' => $courseData['credits'],
                'department_id' => $departments->random()->id,
                'teacher_id' => $teachers->random()->id,
                'academic_year' => 2024,
                'semester' => rand(1, 8),
                'max_students' => rand(30, 80),
                'course_type' => $courseData['course_type'],
                'is_active' => true,
            ]);
        }

        $this->command->info('Courses seeded successfully!');
    }
}
