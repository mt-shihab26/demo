<?php

use Livewire\Component;

new class extends Component
{
    public $todos = [
        'Take out trash',
        'Do dishes',
    ];
};
?>

<div class="max-w-md mx-auto p-4">
    <div class="flex gap-2 mb-4">
        <input type="test" class="flex-1 px-3 rounded-none py-2 border border-gray-300" />
        <button type="button" class="px-4 py-2 bg-black text-white">Add</button>
    </div>

    <ul class="space-y-1">
        @foreach($todos as $todo)
            <li class="px-3 py-2 border-b border-gray-200">{{ $todo }}</li>
        @endforeach
    </ul>
</div>
