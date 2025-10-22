<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'employee_id' => $this->faker->unique()->numerify('TCH####'),
            'designation' => $this->faker->randomElement(['Professor', 'Associate Professor', 'Assistant Professor', 'Lecturer']),
            'qualification' => $this->faker->randomElement(['PhD', 'MSc', 'MEng', 'MBA']),
            'salary' => $this->faker->numberBetween(50000, 150000),
            'joining_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'employment_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'specialization' => $this->faker->sentence(3),
            'is_department_head' => false,
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the teacher is a department head.
     */
    public function departmentHead(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_department_head' => true,
            'designation' => 'Professor',
        ]);
    }

    /**
     * Indicate that the teacher is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}