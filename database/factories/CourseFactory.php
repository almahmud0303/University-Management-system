<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'course_code' => $this->faker->unique()->bothify('CSE###'),
            'description' => $this->faker->paragraph(),
            'credits' => $this->faker->numberBetween(1, 4),
            'department_id' => Department::factory(),
            'teacher_id' => Teacher::factory(),
            'academic_year' => $this->faker->numberBetween(2020, 2024),
            'semester' => $this->faker->numberBetween(1, 8),
            'max_students' => $this->faker->numberBetween(30, 100),
            'course_type' => $this->faker->randomElement(['theory', 'lab', 'project', 'thesis']),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the course is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the course is a lab course.
     */
    public function lab(): static
    {
        return $this->state(fn (array $attributes) => [
            'course_type' => 'lab',
            'credits' => 1,
        ]);
    }

    /**
     * Indicate that the course is a theory course.
     */
    public function theory(): static
    {
        return $this->state(fn (array $attributes) => [
            'course_type' => 'theory',
            'credits' => $this->faker->numberBetween(2, 4),
        ]);
    }
}
