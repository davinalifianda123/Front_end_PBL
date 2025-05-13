<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts & Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    @endif
</head>
<body class="text-[#1b1b18] min-h-screen">
    <!-- Layout Container -->
    <div class="flex flex-col h-screen">
        <!-- Navbar Fixed (mulai setelah sidebar) -->
        <header class="fixed top-0 left-64 right-0 h-16 z-50 ">
            <x-navbar />
        </header>

        <!-- Main Content Area -->
        <div class="flex flex-1 pt-16"> <!-- pt-16 untuk navbar fixed -->
            <!-- Sidebar Fixed (full height) -->
            <aside class="fixed left-0 top-0 bottom-0 w-64 bg-white border-r border-gray-200 z-40">
                @switch(Auth::user()->role->nama_role)
                    @case("SuperAdmin")<x-headers.header-super-admin />@break
                    @case("Supervisor")<x-headers.header-supervisor />@break
                    @case("Admin")<x-headers.header-admin />@break
                @endswitch
            </aside>

            <!-- Main Content (offset untuk sidebar) -->
            <main class="flex-1 ml-64 p-4 overflow-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @livewireScripts
</body>
</html>