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

<div>
    <div>
        <input type="test" />
        <button type="button">Add</button>
    </div>

    <ul>
        @foreach($todos as $todo)
            <li>{{ $todo }}</li>
        @endforeach
    </ul>
</div>
