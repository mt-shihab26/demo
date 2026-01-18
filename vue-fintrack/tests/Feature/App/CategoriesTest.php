<?php

use App\Enums\Kind;
use App\Models\Category;
use App\Models\User;

describe('Categories Index', function () {
    it('displays categories page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.categories.index'));

        $response->assertOk();
    });

    it('requires authentication', function () {
        $response = $this
            ->get(route('app.categories.index'));

        $response->assertRedirect(route('login'));
    });
});

describe('Categories Store', function () {
    it('creates a new category successfully', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('app.categories.store'), [
                'name' => 'Test Category',
                'kind' => Kind::EXPENSE->value,
                'color' => '#ff0000',
            ]);

        $response->assertRedirect();

        expect(Category::where([
            'name' => 'Test Category',
            'user_id' => $user->id,
            'kind' => Kind::EXPENSE,
            'color' => '#ff0000',
        ])->exists())->toBeTrue();
    });

    it('requires authentication', function () {
        $response = $this
            ->post(route('app.categories.store'), [
                'name' => 'Test Category',
                'kind' => Kind::EXPENSE->value,
                'color' => '#ff0000',
            ]);

        $response->assertRedirect(route('login'));
    });

    it('validates required fields', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('app.categories.store'), [
                'name' => '', // empty name
                'kind' => 'invalid', // invalid kind
                'color' => 'not-a-color', // invalid color
            ]);

        $response->assertSessionHasErrors(['name', 'kind', 'color']);
    });
});

describe('Categories Update', function () {
    it('updates category successfully', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create([
            'user_id' => $user->id,
            'name' => 'Original Name',
            'kind' => Kind::EXPENSE,
            'color' => '#ff0000',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.categories.update', $category), [
                'name' => 'Updated Name',
                'kind' => Kind::INCOME->value,
                'color' => '#00ff00',
            ]);

        $response->assertRedirect();

        $category->refresh();

        expect($category->name)->toBe('Updated Name');
        expect($category->kind)->toBe(Kind::INCOME);
        expect($category->color)->toBe('#00ff00');
    });

    it('prevents updating another users category', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);

        $response = $this
            ->actingAs($user1)
            ->patch(route('app.categories.update', $category), [
                'name' => 'Hacked Name',
            ]);

        $response->assertForbidden();
    });

    it('requires authentication', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->patch(route('app.categories.update', $category), [
                'name' => 'Updated Name',
            ]);

        $response->assertRedirect(route('login'));
    });

    it('validates required fields', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.categories.update', $category), [
                'name' => '', // empty name
                'kind' => 'invalid', // invalid kind
            ]);

        $response->assertSessionHasErrors(['name', 'kind']);
    });
});

describe('Categories Delete', function () {
    it('deletes category successfully', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->delete(route('app.categories.destroy', $category));

        $response->assertRedirect();

        expect(Category::find($category->id))->toBeNull();
    });

    it('prevents deleting another users category', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);

        $response = $this
            ->actingAs($user1)
            ->delete(route('app.categories.destroy', $category));

        $response->assertForbidden();

        expect(Category::find($category->id))->not->toBeNull();
    });

    it('requires authentication', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->delete(route('app.categories.destroy', $category));

        $response->assertRedirect(route('login'));
    });
});
