<?php
$links = [
    [
        'label' => 'Home',
        'route' => 'home',
        'icon' => 'home',
    ],
    [
        'label' => 'Counter',
        'route' => 'counter',
        'icon' => 'counter',
    ],
    [
        'label' => 'Todos',
        'route' => 'todos',
        'icon' => 'todos',
    ],
    [
        'label' => 'Posts',
        'route' => 'posts',
        'icon' => 'posts',
    ],
];
?>

<aside class="fixed top-0 left-0 z-40 w-64 h-screen bg-white border-r border-gray-200">
    <div class="flex flex-col h-full">
        <nav class="flex-1 px-3 py-4 overflow-y-auto">
            <ul class="space-y-2">
                @foreach($links as $link)
                    <li wire:key="{{ $link['route'] }}">
                        <a
                            href="{{ route($link['route']) }}"
                            wire:navigate
                            class="flex items-center underline px-4 py-3 text-gray-600 rounded-lg transition-colors duration-200 hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs($link['route']) ? 'bg-gray-100 text-gray-900' : '' }}"
                    >
                            @if(\Illuminate\Support\Facades\View::exists('components.icons.' . $link['icon']))
                                <x-dynamic-component :component="'icons.' . $link['icon']" class="w-5 h-5" />
                            @endif
                            <span class="ml-3 font-medium">{{ $link['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
