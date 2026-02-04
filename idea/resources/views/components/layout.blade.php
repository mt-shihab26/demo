@props(["class" => ""])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-foreground">
    <x-header />
    <main class="max-w-7xl mx-auto px-6">
        <div class="flex min-h-[calc(100svh-4rem-1px)] items-center justify-center {{ $class }}">
            {{ $slot }}
        </div>
    </main>
</body>
</html>
