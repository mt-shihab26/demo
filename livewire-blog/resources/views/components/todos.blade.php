<?php

use Livewire\Component;

new class extends Component
{
    public string $todo = '';

    public $todos = [
        'Take out trash',
        'Do dishes',
    ];

    public function add()
    {
        $this->todos[] = $this->todo;

        /* $this->todo = ''; */
        $this->reset('todo');
    }
};
?>

<div class="max-w-md mx-auto p-4 space-y-4">
    <div>Current Todo: {{ $todo }}</div>

    <form
        class="flex gap-2"
        wire:submit="add"
    >
        <input
            type="test"
            class="flex-1 px-3 rounded-none py-2 border border-gray-300"
            {{-- wire:model.live.debounce.5ms="todo" --}}
            {{-- wire:model.change="todo" --}}
            wire:model.blur="todo"
        />
        <button
            type="submit"
            class="px-4 py-2 bg-black text-white"
        >
            Add
        </button>
    </form>

    <ul class="space-y-1">
        @foreach($todos as $todo)
            <li class="px-3 py-2 border-b border-gray-200">{{ $todo }}</li>
        @endforeach
    </ul>
</div>
