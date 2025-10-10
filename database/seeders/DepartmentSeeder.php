<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Computer Science and Engineering', 'code' => 'CSE', 'is_active' => true],
            ['name' => 'Electrical and Electronic Engineering', 'code' => 'EEE', 'is_active' => true],
            ['name' => 'Mechanical Engineering', 'code' => 'ME', 'is_active' => true],
            ['name' => 'Civil Engineering', 'code' => 'CE', 'is_active' => true],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
