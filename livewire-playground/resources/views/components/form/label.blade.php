@props(['text'])

<span {{ $attributes->merge(['class' => 'block text-sm font-medium text-gray-700 mb-1']) }}>
    {{ $text }}
</span>
