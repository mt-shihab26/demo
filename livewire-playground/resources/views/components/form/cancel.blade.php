<button
    type="button"
    {{ $attributes->merge(["class" => "px-4 flex gap-1 items-center py-2 cursor-pointer text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg"]) }}
>
    <x-icons.cancel class="size-4" />
    Cancel
</button>
