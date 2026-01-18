<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $categories->take(8)->each(function ($category, $index) {
            Budget::factory()
                ->state(['category_id' => $category->id])
                ->when($index < 5, fn ($factory) => $factory->monthly(), fn ($factory) => $factory->weekly())
                ->create();
        });
    }
}
