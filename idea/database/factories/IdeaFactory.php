<?php

namespace Database\Factories;

use App\Enums\IdeaStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id,
            'title' => fake()->sentence(),
            'description' => fake()->optional()->paragraph(),
            'links' => collect(range(1, fake()->numberBetween(0, 4)))->map(fn () => fake()->url()),
            'status' => fake()->randomElement(IdeaStatus::class)->value,
            'image' => fake()->optional()->image(),
        ];
    }
}
