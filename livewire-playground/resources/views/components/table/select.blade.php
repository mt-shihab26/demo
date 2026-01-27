@props(["name" => null, "class" => "", "options" => []])

<select
    id="{{ $name }}"
    name="{{ $name }}"
    wire:model.live="{{ $name }}"
    {{ $attributes->merge(["class" => "px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none cursor-pointer $class"]) }}
>
    @foreach($options as $option)
        <option wire:key="option['value']" value="{{ $option['value'] }}" class="py-2 text-gray-700">
            {{ $option['label'] }}
        </option>
    @endforeach
</select>
