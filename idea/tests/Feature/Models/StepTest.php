<?php

use App\Models\Idea;
use App\Models\Step;

test('is data casting', function () {
    $step = Step::factory()->create();

    expect($step->completed)->toBeBool();
});

test('it belongs to idea', function () {
    $step = Step::factory()->create();

    expect($step->idea)->toBeInstanceOf(Idea::class);
});
