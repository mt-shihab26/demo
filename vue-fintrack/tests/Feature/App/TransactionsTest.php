<?php

use App\Enums\Kind;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;

describe('Transactions Index', function () {
    it('displays transactions page', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('app.transactions.index'));

        $response->assertOk();
    });

    it('displays user transactions with categories', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('app.transactions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('app/Transactions')
            ->has('transactions', 1)
            ->has('categories', 1)
        );
    });

    it('does not display other users transactions', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);
        Transaction::factory()->create([
            'user_id' => $user2->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user1)
            ->get(route('app.transactions.index'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('app/Transactions')
            ->has('transactions', 0)
        );
    });

    it('requires authentication', function () {
        $response = $this
            ->get(route('app.transactions.index'));

        $response->assertRedirect(route('login'));
    });
});

describe('Transactions Store', function () {
    it('creates a new transaction successfully', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $transactionData = [
            'category_id' => $category->id,
            'kind' => Kind::EXPENSE->value,
            'amount' => 100.50,
            'description' => 'Test transaction',
            'date' => '2024-01-15',
            'tags' => ['food', 'groceries'],
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), $transactionData);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Transaction created successfully.');

        expect(Transaction::where([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'kind' => Kind::EXPENSE,
            'amount' => 100.50,
            'description' => 'Test transaction',
        ])->exists())->toBeTrue();
    });

    it('creates transaction with income kind', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::INCOME->value,
                'amount' => 2500.00,
                'description' => 'Salary payment',
                'date' => '2024-01-01',
            ]);

        $response->assertRedirect();

        expect(Transaction::where([
            'user_id' => $user->id,
            'kind' => Kind::INCOME,
            'amount' => 2500.00,
        ])->exists())->toBeTrue();
    });

    it('creates transaction without tags', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 50.00,
                'description' => 'Coffee',
                'date' => '2024-01-15',
            ]);

        $response->assertRedirect();

        expect(Transaction::where([
            'user_id' => $user->id,
            'description' => 'Coffee',
        ])->exists())->toBeTrue();
    });

    it('prevents creating transaction with another users category', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);

        $response = $this
            ->actingAs($user1)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Unauthorized transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('category_id');

        expect(Transaction::where([
            'user_id' => $user1->id,
            'category_id' => $category->id,
        ])->exists())->toBeFalse();
    });

    it('requires authentication', function () {
        $user = User::factory()->create();
        $category = Category::factory()->for($user)->create();

        $response = $this
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertRedirect(route('login'));
    });

    it('validates required fields', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), []);

        $response->assertSessionHasErrors([
            'category_id',
            'kind',
            'amount',
            'description',
            'date',
        ]);
    });

    it('validates category_id exists', function () {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => 999999,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('category_id');
    });

    it('validates kind is valid enum value', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => 'invalid_kind',
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('kind');
    });

    it('validates amount is numeric and positive', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => -100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('amount');

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 'not_a_number',
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('amount');
    });

    it('validates amount is within range', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 0.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('amount');

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 1000000.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('amount');
    });

    it('validates description length', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => str_repeat('a', 1001), // Too long
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('description');
    });

    it('validates date format', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => 'invalid-date',
            ]);

        $response->assertSessionHasErrors('date');
    });

    it('validates tags format', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
                'tags' => 'not_an_array',
            ]);

        $response->assertSessionHasErrors('tags');

        $response = $this
            ->actingAs($user)
            ->post(route('app.transactions.store'), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Test transaction',
                'date' => '2024-01-15',
                'tags' => [str_repeat('a', 51)], // Tag too long
            ]);

        $response->assertSessionHasErrors('tags.0');
    });
});

describe('Transactions Update', function () {
    it('updates transaction successfully', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $newCategory = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'kind' => Kind::EXPENSE,
            'amount' => 100.00,
            'description' => 'Original description',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.transactions.update', $transaction), [
                'category_id' => $newCategory->id,
                'kind' => Kind::INCOME->value,
                'amount' => 200.50,
                'description' => 'Updated description',
                'date' => '2024-02-15',
                'tags' => ['updated', 'tags'],
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Transaction updated successfully.');

        $transaction->refresh();

        expect($transaction->category_id)->toBe($newCategory->id);
        expect($transaction->kind)->toBe(Kind::INCOME);
        expect($transaction->amount)->toBe('200.50');
        expect($transaction->description)->toBe('Updated description');
        expect($transaction->tags)->toBe(['updated', 'tags']);
    });

    it('prevents updating another users transaction', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user2->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user1)
            ->patch(route('app.transactions.update', $transaction), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 999.99,
                'description' => 'Hacked description',
                'date' => '2024-01-15',
            ]);

        $response->assertForbidden();
    });

    it('prevents updating transaction with another users category', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $userCategory = Category::factory()->create(['user_id' => $user1->id]);
        $otherCategory = Category::factory()->create(['user_id' => $user2->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user1->id,
            'category_id' => $userCategory->id,
        ]);

        $response = $this
            ->actingAs($user1)
            ->patch(route('app.transactions.update', $transaction), [
                'category_id' => $otherCategory->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Updated description',
                'date' => '2024-01-15',
            ]);

        $response->assertSessionHasErrors('category_id');
    });

    it('requires authentication', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->patch(route('app.transactions.update', $transaction), [
                'category_id' => $category->id,
                'kind' => Kind::EXPENSE->value,
                'amount' => 100.00,
                'description' => 'Updated description',
                'date' => '2024-01-15',
            ]);

        $response->assertRedirect(route('login'));
    });

    it('validates all required fields', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->patch(route('app.transactions.update', $transaction), [
                'category_id' => '',
                'kind' => 'invalid',
                'amount' => 'not_numeric',
                'description' => '',
                'date' => 'invalid-date',
            ]);

        $response->assertSessionHasErrors([
            'category_id',
            'kind',
            'amount',
            'description',
            'date',
        ]);
    });
});

describe('Transactions Delete', function () {
    it('deletes transaction successfully', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('app.transactions.destroy', $transaction));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Transaction deleted successfully.');

        expect(Transaction::find($transaction->id))->toBeNull();
    });

    it('prevents deleting another users transaction', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user2->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user2->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->actingAs($user1)
            ->delete(route('app.transactions.destroy', $transaction));

        $response->assertForbidden();

        expect(Transaction::find($transaction->id))->not->toBeNull();
    });

    it('requires authentication', function () {
        $user = User::factory()->create();
        $category = Category::factory()->create(['user_id' => $user->id]);
        $transaction = Transaction::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $response = $this
            ->delete(route('app.transactions.destroy', $transaction));

        $response->assertRedirect(route('login'));
    });
});
