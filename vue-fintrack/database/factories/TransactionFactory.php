<?php

namespace Database\Factories;

use App\Enums\Kind;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
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
            'category_id' => Category::inRandomOrder()->first()?->id,
            'kind' => fake()->randomElement(Kind::values()),
            'amount' => fake()->randomFloat(2, 1, 5000),
            'description' => fake()->sentence(),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'tags' => $this->tags(),
        ];
    }

    /**
     * Indicate that the transaction is income.
     */
    public function income(): static
    {
        return $this->state(fn (array $attributes) => [
            'kind' => Kind::INCOME->value,
            'amount' => fake()->randomFloat(2, 100, 10000),
        ]);
    }

    /**
     * Indicate that the transaction is an expense.
     */
    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'kind' => Kind::EXPENSE->value,
            'amount' => fake()->randomFloat(2, 1, 1000),
        ]);
    }

    private function tags()
    {
        return fake()->optional(0.7)->passthrough([fake()->randomElements(['groceries', 'food', 'entertainment', 'travel', 'gas', 'utilities', 'subscription', 'shopping', 'health', 'education', 'salary', 'bonus'], fake()->numberBetween(0, 3))]);
    }
}
