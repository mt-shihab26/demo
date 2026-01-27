<?php

use App\Models\Post;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

new class extends Component
{
    public ?Post $post = null;

    #[Rule('required|string|max:255', as: 'da title')]
    public string $title = '';

    #[Rule('required|string', as: 'body')]
    public string $content = '';

    public function mount()
    {
        $this->title = $this->post?->title ?? '';
        $this->content = $this->post?->content ?? '';
    }

    public function save()
    {
        sleep(1);

        $this->validate();

        User::query()->first()->posts()->create([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset('title', 'content');
        $this->dispatch('post-created');
    }

    public function update()
    {
        $this->validate();

        $this->post->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->reset('title', 'content');
        $this->dispatch('post-updated');
    }
};
?>

<div x-data="{ show: false }">
    @if($post)
        <button
            class="text-blue-600 hover:text-blue-900 p-1"
            title="Edit"
            @click="show = !show"
        >
            <x-icons.edit class="w-5 h-5" />
        </button>
    @else
        <button
            @click="show = !show"
            class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
        >
            <x-icons.plus class="w-5 h-5" />
            Add Post
        </button>
    @endif

    <div
        class="fixed inset-0 z-50 flex items-center justify-center"
        x-show="show"
        x-cloak
        x-transition
        x-on:post-updated.window="show = false"
        x-on:post-created.window="show = false"
    >
        <div
            class="fixed inset-0 bg-black/50"
            @click="show = !show"
        >
        </div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="flex items-center justify-between p-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $post ? "Update Post" : "Create Post 2" }}
                </h3>
                <button
                    class="text-gray-400 cursor-pointer hover:text-gray-600"
                    @click="show = !show"
                >
                    <x-icons.close class="w-5 h-5" />
                </button>
            </div>
            <form
                class="p-4 space-y-4"
                wire:submit="{{ $post ? 'update' : 'save' }}"
            >
                <x-form.input
                    label="Title"
                    name="title"
                    placeholder="Enter post title..."
                />
                <x-form.textarea
                    label="Content"
                    name="content"
                    placeholder="Write your content here..."
                    show-characters
                    show-words
                />
                <div class="flex justify-end gap-3 p-4">
                    <button
                        type="button"
                        class="px-4 py-2 cursor-pointer text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg"
                        @click="show = !show"
                    >
                        Cancel
                    </button>
                    <x-form.submit :icon="$post ? 'edit' : 'plus'">
                        {{ $post ? 'Update Post' : 'Create Post' }}
                    </x-form.submit>
                </div>
            </form>
        </div>
    </div>
</div>
