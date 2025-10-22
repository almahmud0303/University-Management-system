<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            AdminSeeder::class,
            DepartmentSeeder::class,
            HallSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            StaffSeeder::class,
            CourseSeeder::class,
            NoticeSeeder::class,
        ]);
    }
}
