<?php

use Livewire\Component;

new class extends Component
{
    public $count = 0;

    public function increment(int $by)
    {
        $this->count += $by;
    }

    public function decrement(int $by)
    {
        $this->count -= $by;
    }
};
?>

<div class="flex flex-col">
    <div>Count: {{ $count }} </div>
    <button class="cursor-pointer" type="button" wire:click="increment(2)">Increment By 2</button>
    <button class="cursor-pointer"  type="button" wire:click="decrement(2)">Decrement By 2</button>
</div>
