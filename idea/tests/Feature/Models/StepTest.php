<?php

use App\Models\Step;

test('is data casting', function () {
    $step = Step::factory()->create();

    expect($step->completed)->toBeBoolean();
});
