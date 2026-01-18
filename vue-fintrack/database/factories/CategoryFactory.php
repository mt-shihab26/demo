<?php

namespace Database\Factories;

use App\Enums\Kind;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $colorOptions = [
            '#059669', // Green
            '#dc2626', // Red
            '#f59e0b', // Orange
            '#7c3aed', // Purple
            '#4b5563', // Gray
            '#10b981', // Teal
            '#3b82f6', // Blue
            '#ef4444', // Rose
            '#8b5cf6', // Indigo
            '#06b6d4', // Cyan
        ];

        return [
            'user_id' => User::inRandomOrder()->first()?->id,
            'name' => fake()->words(2, true),
            'kind' => fake()->randomElement([Kind::INCOME->value, Kind::EXPENSE->value]),
            'color' => fake()->randomElement($colorOptions),
        ];
    }

    /**
     * Indicate that the category is for income.
     */
    public function income(): static
    {
        return $this->state(fn (array $attributes) => [
            'kind' => Kind::INCOME->value,
        ]);
    }

    /**
     * Indicate that the category is for expenses.
     */
    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'kind' => Kind::EXPENSE->value,
        ]);
    }
}
