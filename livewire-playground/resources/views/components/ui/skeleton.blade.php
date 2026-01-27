@props(['class' => 'h-4 w-24'])

<div {{ $attributes->merge(['class' => "bg-gray-200 rounded animate-pulse $class"]) }}></div>
