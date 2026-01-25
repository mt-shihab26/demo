<?php

use Livewire\Component;

new class extends Component
{
    public $count = 0;

    public function increment(int $by)
    {
        $this->count += $by;
    }
};
?>

<div>
    <div>Count: {{ $count }} </div>
    <button type="button" wire:click="increment(2)">Increment By 2</button>
</div>
