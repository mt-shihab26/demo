<?php

use Livewire\Component;

new class extends Component
{
    public bool $show = false;

    public function toggle()
    {
        $this->show = ! $this->show;
    }
};
?>

<div>
    <button
        wire:click="toggle"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
    >
        + Add Post
    </button>

    <div wire:show="show" x-transition.duration.50ms>
        Hello World
    </div>
</div>
