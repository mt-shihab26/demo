<?php

use App\Enums\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Collection;

test('is data casting', function () {
    $idea = Idea::factory()->create();

    expect($idea->links)->toBeInstanceOf(Collection::class);
    expect($idea->status)->toBeInstanceOf(IdeaStatus::class);
});

test('it belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test('it can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->refresh()->steps)->toHaveCount(1);
});
