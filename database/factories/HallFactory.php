<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hall>
 */
class HallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hall::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Shahid Minar Hall', 'Liberation War Hall', 'Bangabandhu Hall', 'Rokeya Hall', 'Nazrul Hall']),
            'code' => $this->faker->unique()->bothify('HALL##'),
            'description' => $this->faker->paragraph(),
            'capacity' => $this->faker->numberBetween(100, 500),
            'facilities' => [
                'wifi' => true,
                'cafeteria' => true,
                'library' => true,
                'gym' => $this->faker->boolean(),
                'laundry' => $this->faker->boolean(),
            ],
            'location' => $this->faker->address(),
            'type' => $this->faker->randomElement(['male', 'female', 'mixed']),
            'is_available' => true,
        ];
    }

    /**
     * Indicate that the hall is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_available' => true,
        ]);
    }

    /**
     * Indicate that the hall is for male students.
     */
    public function male(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'male',
        ]);
    }

    /**
     * Indicate that the hall is for female students.
     */
    public function female(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'female',
        ]);
    }
}
