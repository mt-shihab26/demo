<?php

use App\Models\Post;
use Livewire\Component;

new class extends Component
{
    public string $sort = 'latest';

    public function delete(Post $post)
    {
        $post->delete();
    }

    public function render()
    {
        sleep(1);

        $posts = Post::query()
            ->when($this->sort === 'latest', fn ($q) => $q->latest())
            ->when($this->sort === 'oldest', fn ($q) => $q->oldest())
            ->get();

        return $this
            ->view(['posts' => $posts])
            ->layout('layouts.app')
            ->title('Posts');
    }
};
?>

<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Posts</h1>
        <livewire:screens.posts.form @post-created="$refresh" />
    </div>

    <div class="mb-4 flex justify-end">
        <x-table.select
            name="sort"
            data-dim-sorting
            :options="[
                [ 'value' => 'latest', 'label' => 'Latest' ],
                [ 'value' => 'oldest', 'label' => 'Oldest' ],
                [ 'value' => 'popular', 'label' => 'Popular' ],
            ]"
        />
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden [*:has([data-dim-sorting][data-loading])_&]:opacity-50">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($posts as $post)
                    <tr wire:key="{{ $post->id }}" class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $post->title }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-md truncate">{{ $post->content }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right flex items-center text-sm font-medium">
                            <livewire:screens.posts.form :post="$post" @post-updated="$refresh" />
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
