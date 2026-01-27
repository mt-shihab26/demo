<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app', ['title' => 'Counter'])] class extends Component
{
    //
};
?>

<div>
    <livewire:counter />
</div>
