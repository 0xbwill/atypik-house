<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ 'AtypikHouse - location de logement atypique' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" aria-label="link">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" aria-label="link" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" aria-label="link">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="//unpkg.com/alpinejs" defer></script>
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
            {{-- <div>
                <a class="logo" href="{{ route('home.index') }}" wire:navigate>
                    <img class="w-48 mb-4" src="{{ url('/images/logo full.png') }}" alt="Logo">
                </a>
            </div> --}}

            <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
