<?php

namespace Database\Factories;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement(['general', 'academic', 'exam', 'fee', 'library', 'event']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'target_roles' => $this->faker->randomElements(['admin', 'teacher', 'student', 'staff', 'department_head'], $this->faker->numberBetween(1, 3)),
            'publish_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'is_published' => $this->faker->boolean(80),
            'is_pinned' => $this->faker->boolean(20),
        ];
    }

    /**
     * Indicate that the notice is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the notice is pinned.
     */
    public function pinned(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_pinned' => true,
            'is_published' => true,
        ]);
    }

    /**
     * Indicate that the notice is urgent.
     */
    public function urgent(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'urgent',
            'is_published' => true,
            'is_pinned' => true,
        ]);
    }
}
