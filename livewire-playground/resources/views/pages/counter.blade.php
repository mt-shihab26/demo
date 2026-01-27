<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app', ['title' => 'Counter'])] class extends Component
{
    //
};
?>

<div>
    <livewire:screens.counter />

    <div x-data="{ count: 0 }" class="mt-10">
        <span x-text="count"></span>
        <button type='button' @click="count++">Increment</button>
    </div>
</div>
