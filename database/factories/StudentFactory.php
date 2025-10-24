<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Models\Department;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'department_id' => Department::inRandomOrder()->first()?->id ?? 1,
            'student_id' => $this->faker->unique()->numerify('STU####'),
            'roll_number' => $this->faker->unique()->numerify('ROLL####'),
            'registration_number' => $this->faker->unique()->numerify('REG####'),
            'session' => $this->faker->randomElement(['2020-21', '2021-22', '2022-23', '2023-24']),
            'academic_year' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th']),
            'semester' => $this->faker->randomElement(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th']),
            'admission_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'status' => $this->faker->randomElement(['active', 'inactive', 'graduated', 'suspended']),
            'hall_id' => Hall::inRandomOrder()->first()?->id ?? 1,
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'guardian_name' => $this->faker->name(),
            'guardian_phone' => $this->faker->phoneNumber(),
            'cgpa' => $this->faker->randomFloat(2, 2.0, 4.0),
            'total_credits' => $this->faker->numberBetween(120, 160),
            'completed_credits' => $this->faker->numberBetween(0, 120),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the student is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the student is graduated.
     */
    public function graduated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'graduated',
            'is_active' => false,
            'completed_credits' => $attributes['total_credits'],
        ]);
    }
}