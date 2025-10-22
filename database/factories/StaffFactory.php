<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'employee_id' => $this->faker->unique()->numerify('STF####'),
            'designation' => $this->faker->randomElement(['Clerk', 'Accountant', 'Librarian', 'Maintenance Staff', 'Security Guard']),
            'department' => $this->faker->randomElement(['Administration', 'Finance', 'Library', 'Maintenance', 'Security']),
            'salary' => $this->faker->numberBetween(25000, 80000),
            'joining_date' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'employment_type' => $this->faker->randomElement(['full_time', 'part_time', 'contract']),
            'bio' => $this->faker->paragraph(),
            'location' => $this->faker->address(),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the staff is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}