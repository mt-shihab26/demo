<?php

use App\Models\Post;
use Livewire\Attributes\Lazy;
use Livewire\Component;

new #[Lazy] class extends Component
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

@placeholder
<div class="max-w-6xl">
    <div class="flex items-center justify-between mb-6">
        <x-ui.skeleton class="h-8 w-32" />
        <x-ui.skeleton class="h-10 w-28 rounded-lg" />
    </div>
    <div class="mb-4 flex justify-end">
        <x-ui.skeleton class="h-10 w-32 rounded-lg" />
    </div>
    <x-table.skeleton :rows="10" :cols="4" />
</div>
@endplaceholder

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
                    <livewire:screens.posts.post wire:key="{{ $post->id }}" :post="$post" @post-updated="$refresh" />
                @endforeach
            </tbody>
        </table>
    </div>
</div>
