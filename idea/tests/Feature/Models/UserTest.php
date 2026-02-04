<?php

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

test('is data casting', function () {
    $user = User::factory()->create();

    expect($user->email_verified_at)->toBeInstanceOf(Carbon::class);
    expect(Hash::check('password', $user->password))->toBeTrue();
});

test('it has many ideas', function () {
    $user = User::factory()->create();

    $user->ideas()->create([
        'title' => 'Da',
        'description' => 'Doing da',
    ]);

    expect($user->ideas)->toHaveCount(1);
});
