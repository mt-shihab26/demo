<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.app', ['title' => 'Hello World'])] class extends Component
{
    //
};
?>

<div class="flex items-center flex-col justify-center h-screen">
    Hello World
</div>
