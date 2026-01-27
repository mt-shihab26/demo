<?php

use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

new class extends Component
{
    #[Rule(['required', 'string', 'max: 255'], as: 'da title')]
    public string $title = '';

    #[Rule(['required', 'string'], as: 'body')]
    public string $content = '';

    public function save()
    {
        $this->validate();

        User::query()->first()->posts()->create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset('title', 'content');
        $this->dispatch('post-created');
    }
};
?>

<div x-data="{ show: false }">
    <button
        @click="show = !show"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
    >
        + Add Post
    </button>
    <div
        class="fixed inset-0 z-50 flex items-center justify-center"
        x-show="show"
        x-cloak
        x-transition
        x-on:post-created.window="show = !show"
    >
        <div
            class="fixed inset-0 bg-black/50"
            @click="show = !show"
        >
        </div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="flex items-center justify-between p-4">
                <h3 class="text-lg font-semibold text-gray-900">Create Post</h3>
                <button
                    class="text-gray-400 hover:text-gray-600"
                    @click="show = !show"
                >
                    <x-icons.close class="w-5 h-5" />
                </button>
            </div>
            <form
                class="p-4 space-y-4"
                wire:submit="save"
            >
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Title</span>
                    <input
                        type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        wire:model="title"
                    />
                    @error("title")
                        <em>{{ $message }}</em>
                    @enderror
                </label>
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Content</span>
                    <textarea
                        rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"
                        wire:model="content"
                    >
                    </textarea>
                    @error("content")
                        <em>{{ $message }}</em>
                    @enderror
                </label>
                <div class="flex justify-end gap-3 p-4">
                    <button
                        type="button"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg"
                        @click="show = !show"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg"
                    >
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
