@props(['label', 'name', 'rows' => 4])

<x-form.wrapper>
    <x-form.label :text="$label" />
    <textarea
        rows="{{ $rows }}"
        id="{{ $name }}"
        name="{{ $name }}"
        wire:model="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none']) }}
    ></textarea>
    <x-form.error :name="$name" />
</x-form.wrapper>
