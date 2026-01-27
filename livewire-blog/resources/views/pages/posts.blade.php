<?php

use Livewire\Component;

new class extends Component
{
    public function render()
    {
        $data = [
            'posts' => [
                [
                    'id' => 1,
                    'title' => 'Hello World',
                    'content' => 'Welcome this is livewire application',
                ],
                [
                    'id' => 2,
                    'title' => 'Getting Started with Livewire',
                    'content' => 'Livewire is a full-stack framework for Laravel that makes building dynamic interfaces simple.',
                ],
                [
                    'id' => 3,
                    'title' => 'Tailwind CSS Tips',
                    'content' => 'Learn how to create beautiful designs with utility-first CSS framework.',
                ],
            ],
        ];

        return $this
            ->view($data)
            ->layout('layouts.app')
            ->title('Posts');
    }
};
?>

<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Posts</h1>
        <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
            + Add Post
        </button>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($posts as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $post['id'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $post['title'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-md truncate">{{ $post['content'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <button class="text-blue-600 hover:text-blue-900">Edit</button>
                            <button class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
