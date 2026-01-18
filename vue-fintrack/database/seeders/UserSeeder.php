<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'currency' => Currency::BDT->value,
            'push_notifications' => true,
            'email_notifications' => false,
            'budget_alerts' => false,
            'weekly_reports' => false,
        ]);
    }
}
