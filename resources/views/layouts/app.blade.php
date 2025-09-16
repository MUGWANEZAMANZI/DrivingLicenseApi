<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
     <img src="{{ asset('Logo_acf.png') }}" alt="Logo" class="h-16 w-auto">
     
    <title>{{ config('app.name', 'Police Revolutionnaire Congolaise') }}</title>
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="h-full bg-gray-50 text-gray-900">
<div class="min-h-screen flex">
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex md:flex-col">
        <div class="p-4 text-xl font-semibold">{{ config('app.name', 'Driving License') }}</div>
        <nav class="flex-1 p-2 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('dashboard.title') }}</a>
            <a href="{{ route('drivers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.driver.plural') }}</a>
            <a href="{{ route('licenses.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.license.plural') }}</a>
            <a href="{{ route('cards.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.card.plural') }}</a>
            <a href="{{ route('penalties.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.penalty.plural') }}</a>
            <a href="{{ route('penaltiesDrivers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.penaltiesDrivers.plural') }}</a>
            <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">{{ __('models.user.plural') }}</a>
        </nav>
    </aside>
    <main class="flex-1">
        <header class="bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center">
            <div class="md:hidden">
                <a href="{{ route('dashboard') }}" class="font-semibold">{{ config('app.name', 'Driving License') }}</a>
            </div>
            <div class="space-x-2">
                <a href="{{ url('locale/en') }}" class="px-2 py-1 text-sm border rounded">EN</a>
                <a href="{{ url('locale/fr') }}" class="px-2 py-1 text-sm border rounded">FR</a>
            </div>
        </header>
        <div class="p-4">
            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </main>
</div>
@livewireScripts
</body>
</html>


