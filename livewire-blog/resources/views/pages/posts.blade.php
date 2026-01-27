<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        return $this->view([
            'posts' => [],
        ]);
    }
};
?>

<div>
    Hello Posts
</div>
