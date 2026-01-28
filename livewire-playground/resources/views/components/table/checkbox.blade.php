@props(["value" => null, "model" => null])

<input
    type="checkbox"
    value="{{ $value }}"
    @if($model) wire:model="{{ $model }}" @endif
    {{ $attributes->merge(["class" => "h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer"]) }}
/>
