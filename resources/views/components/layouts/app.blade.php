<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <img src="{{ asset('Logo_afc.png') }}" alt="Logo" class="h-16 w-auto"> --}}
    <title>{{ config('app.name') }}</title>
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <main class="container mx-auto py-8">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
