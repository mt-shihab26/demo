<?php

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

describe('Budget Index', function () {
    it('displays budgets page with user budgets', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        Budget::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('app.budgets.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('app/Budgets')
                ->has('budgets', 1)
                ->has('categories')
            );
    });

    it('only shows budgets for authenticated user', function () {
        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create(['user_id' => $otherUser->id]);
        Budget::factory()->create(['category_id' => $otherCategory->id]);

        $userCategory = Category::factory()->create(['user_id' => $this->user->id]);
        Budget::factory()->create(['category_id' => $userCategory->id]);

        $response = $this->get(route('app.budgets.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('budgets', 1)
            );
    });

    it('shows categories without budgets', function () {
        Category::factory()->count(3)->create(['user_id' => $this->user->id]);
        $categoryWithBudget = Category::factory()->create(['user_id' => $this->user->id]);
        Budget::factory()->create(['category_id' => $categoryWithBudget->id]);

        $response = $this->get(route('app.budgets.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->has('categories', 3)
            );
    });
});

describe('Budget Store', function () {
    it('creates a new budget successfully', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);

        $budgetData = [
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ];

        $response = $this->post(route('app.budgets.store'), $budgetData);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Budget created successfully.');

        $this->assertDatabaseHas('budgets', $budgetData);
    });

    it('validates required fields', function () {
        $response = $this->post(route('app.budgets.store'), []);

        $response->assertSessionHasErrors(['category_id', 'amount', 'period']);
    });

    it('validates category belongs to user', function () {
        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->post(route('app.budgets.store'), [
            'category_id' => $otherCategory->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    });

    it('validates category does not already have a budget', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        Budget::factory()->create(['category_id' => $category->id]);

        $response = $this->post(route('app.budgets.store'), [
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'monthly',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    });

    it('validates amount is positive', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);

        $response = $this->post(route('app.budgets.store'), [
            'category_id' => $category->id,
            'amount' => 0,
            'period' => 'monthly',
        ]);

        $response->assertSessionHasErrors(['amount']);
    });

    it('validates period is valid', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);

        $response = $this->post(route('app.budgets.store'), [
            'category_id' => $category->id,
            'amount' => 500.00,
            'period' => 'invalid',
        ]);

        $response->assertSessionHasErrors(['period']);
    });
});

describe('Budget Update', function () {
    it('updates budget successfully', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $budget = Budget::factory()->create(['category_id' => $category->id]);

        $updateData = [
            'category_id' => $category->id,
            'amount' => 750.00,
            'period' => 'weekly',
        ];

        $response = $this->patch(route('app.budgets.update', $budget), $updateData);

        $response->assertRedirect()
            ->assertSessionHas('success', 'Budget updated successfully.');

        $this->assertDatabaseHas('budgets', [
            'id' => $budget->id,
            ...$updateData,
        ]);
    });

    it('prevents updating budget that does not belong to user', function () {
        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create(['user_id' => $otherUser->id]);
        $otherBudget = Budget::factory()->create(['category_id' => $otherCategory->id]);

        $response = $this->patch(route('app.budgets.update', $otherBudget), [
            'category_id' => $otherCategory->id,
            'amount' => 750.00,
            'period' => 'weekly',
        ]);

        $response->assertForbidden();
    });

    it('validates category belongs to user when updating', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $budget = Budget::factory()->create(['category_id' => $category->id]);

        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->patch(route('app.budgets.update', $budget), [
            'category_id' => $otherCategory->id,
            'amount' => 750.00,
            'period' => 'weekly',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    });

    it('allows updating to same category', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $budget = Budget::factory()->create(['category_id' => $category->id]);

        $response = $this->patch(route('app.budgets.update', $budget), [
            'category_id' => $category->id,
            'amount' => 750.00,
            'period' => 'weekly',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('success');
    });

    it('prevents updating to category that already has a budget', function () {
        $category1 = Category::factory()->create(['user_id' => $this->user->id]);
        $category2 = Category::factory()->create(['user_id' => $this->user->id]);

        $budget1 = Budget::factory()->create(['category_id' => $category1->id]);
        Budget::factory()->create(['category_id' => $category2->id]);

        $response = $this->patch(route('app.budgets.update', $budget1), [
            'category_id' => $category2->id,
            'amount' => 750.00,
            'period' => 'weekly',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    });
});

describe('Budget Delete', function () {
    it('deletes budget successfully', function () {
        $category = Category::factory()->create(['user_id' => $this->user->id]);
        $budget = Budget::factory()->create(['category_id' => $category->id]);

        $response = $this->delete(route('app.budgets.destroy', $budget));

        $response->assertRedirect()
            ->assertSessionHas('success', 'Budget deleted successfully.');

        $this->assertDatabaseMissing('budgets', ['id' => $budget->id]);
    });

    it('prevents deleting budget that does not belong to user', function () {
        $otherUser = User::factory()->create();
        $otherCategory = Category::factory()->create(['user_id' => $otherUser->id]);
        $otherBudget = Budget::factory()->create(['category_id' => $otherCategory->id]);

        $response = $this->delete(route('app.budgets.destroy', $otherBudget));

        $response->assertForbidden();

        $this->assertDatabaseHas('budgets', ['id' => $otherBudget->id]);
    });
});

describe('Authentication', function () {
    it('requires authentication for all budget routes', function () {
        Auth::logout();

        $this->get(route('app.budgets.index'))->assertRedirect(route('login'));
        $this->post(route('app.budgets.store'))->assertRedirect(route('login'));

        $budget = Budget::factory()->create();
        $this->patch(route('app.budgets.update', $budget))->assertRedirect(route('login'));
        $this->delete(route('app.budgets.destroy', $budget))->assertRedirect(route('login'));
    });
});
