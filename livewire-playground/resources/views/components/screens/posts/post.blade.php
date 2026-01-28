<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component
{
    public Post $post;

    public function postUpdated()
    {
        $this->dispatch('post-updated');
    }
};
?>

<tr class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->id }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $post->title }}</td>
    <td class="px-6 py-4 text-sm text-gray-500 max-w-md truncate">{{ $post->content }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right flex items-center text-sm font-medium">
        <livewire:screens.posts.form :post="$post" @post-updated="postUpdated" />
        <button
            class="text-red-600 hover:text-red-900 p-1"
            title="Delete"
            type="button"
            wire:click="delete({{ $post->id }})"
            wire:confirm="Are you sure, you want to delete this '#{{ $post->id }}' post?"
        >
            <x-icons.delete class="w-5 h-5" />
        </button>
    </td>
</tr>
