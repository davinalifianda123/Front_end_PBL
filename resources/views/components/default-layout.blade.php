<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
            @livewireStyles
        @else
            {{-- script --}}
        @endif
    </head>
    <body class="text-[#1b1b18] min-h-screen flex lg:flex-row">
        @switch(Auth::user()->role->nama_role)
            @case("SuperAdmin")
                <x-headers.header-super-admin />
                @break
            @case("Supervisor")
                <x-headers.header-supervisor />
                @break
            @case("Admin")
                <x-headers.header-admin />
                @break
        @endswitch
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0 ">
            <main class="relative w-full px-4 py-8 lg:ml-64 ">
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @livewireScripts
    </body>
</html>
