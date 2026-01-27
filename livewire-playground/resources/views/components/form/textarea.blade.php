@props(['label', 'name', 'rows' => 4, 'placeholder' => '', 'showWords' => false, 'showCharacters' => false])

<x-form.wrapper>
    <x-form.label :text="$label" />
    <textarea
        rows="{{ $rows }}"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        wire:model="{{ $name }}"
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none resize-none']) }}
    ></textarea>
    <x-form.error :name="$name" />
    @if($showCharacters)
        <div class="text-right">
            <small class="text-gray-500">Characters: <span x-text="$wire.{{ $name }}.length"></span></small>
        </div>
    @endif
    @if($showWords)
        <div class="text-right">
            <small class="text-gray-500">Words: <span x-text="$wire.{{ $name }}.length === 0 ? 0 : $wire.{{ $name }}.split(' ').length"></span></small>
        </div>
    @endif
</x-form.wrapper>
