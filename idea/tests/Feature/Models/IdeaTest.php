<?php

use App\Models\Idea;
use App\Models\User;

test('it belongs to a user', function () {
    User::factory()->create();

    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});
