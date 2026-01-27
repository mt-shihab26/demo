@props(['label', 'name', 'type' => 'text'])

<x-form.wrapper>
    <x-form.label :text="$label" />
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        wire:model="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none']) }}
    />
    <x-form.error :name="$name" />
</x-form.wrapper>
