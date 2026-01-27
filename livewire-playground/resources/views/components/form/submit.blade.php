@props(['icon' => null, "label" => ""])

<button
    type="submit"
    {{ $attributes->merge(['class' => 'data-loading:opacity-50 items-center gap-1 flex px-4 py-2 text-sm cursor-pointer font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg']) }}
>
    <x-icons.loading class="not-in-data-loading:hidden size-4" />
    @if($icon)
        <x-dynamic-component :component="'icons.' . $icon" class="in-data-loading:hidden size-4" />
    @endif
    {{ $label }}
</button>
