<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="bg-gray-100 min-h-screen">
        @include("partils/layouts/app/sidebar")

        <main class="ml-64 p-6">
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
