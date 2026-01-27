<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('screens.posts.create')
        ->assertStatus(200);
});
