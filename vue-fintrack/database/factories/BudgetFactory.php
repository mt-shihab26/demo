<?php

namespace Database\Factories;

use App\Enums\Period;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'amount' => fake()->randomFloat(2, 100, 5000),
            'period' => fake()->randomElement(Period::values()),
        ];
    }

    /**
     * Indicate that the budget is for monthly period.
     */
    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'period' => Period::MONTHLY->value,
        ]);
    }

    /**
     * Indicate that the budget is for weekly period.
     */
    public function weekly(): static
    {
        return $this->state(fn (array $attributes) => [
            'period' => Period::WEEKLY->value,
        ]);
    }

    /**
     * Set a specific amount for the budget.
     */
    public function amount(float $amount): static
    {
        return $this->state(fn (array $attributes) => [
            'amount' => $amount,
        ]);
    }
}
