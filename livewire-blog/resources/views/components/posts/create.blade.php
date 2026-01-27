<?php

use Livewire\Component;

new class extends Component
{
    public bool $show = true;

    public function toggle()
    {
        $this->show = ! $this->show;
    }
};
?>

<div>
    <button
        wire:click="toggle"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
    >
        + Add Post
    </button>
    <div wire:show="show" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-black/50" wire:click="toggle"></div>
        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-lg">
            <div class="flex items-center justify-between p-4">
                <h3 class="text-lg font-semibold text-gray-900">Create Post</h3>
                <button wire:click="toggle" class="text-gray-400 hover:text-gray-600">
                    <x-icons.close class="w-5 h-5" />
                </button>
            </div>
            <form class="p-4 space-y-4">
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Title</span>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none" />
                </label>
                <label class="block">
                    <span class="block text-sm font-medium text-gray-700 mb-1">Content</span>
                    <textarea rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none"></textarea>
                </label>
                <div class="flex justify-end gap-3 p-4">
                    <button wire:click="toggle" type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
