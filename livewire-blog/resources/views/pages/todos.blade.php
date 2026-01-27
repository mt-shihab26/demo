<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app', ['title' => 'Todos'])] class extends Component
{
    //
};
?>

<div>
    <livewire:todos />
</div>
