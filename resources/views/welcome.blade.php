
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Police Revolutionnaire Congolaise') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-[#112255] min-h-screen text-white">
    <div class="flex flex-col min-h-screen">
        <header class="flex items-center justify-between px-8 py-6 bg-[#112255] shadow-md">
            <div class="flex items-center gap-4">
                <img src="{{ asset('Logo_afc.png') }}" alt="Logo" class="h-16 w-auto">
                <span class="text-3xl font-bold tracking-wide uppercase">{{ config('app.name', 'Police Revolutionnaire Congolaise') }}</span>
            </div>
            <a href="{{ route('login') }}" class="px-6 py-2 bg-yellow-500 text-[#112255] font-bold rounded shadow hover:bg-yellow-400 transition">Login</a>
        </header>

        <main class="flex-1 flex flex-col items-center justify-center px-4">
            <div class="max-w-2xl text-center mt-12">
                <h1 class="text-4xl font-extrabold mb-4">Bienvenue à la Police Révolutionnaire Congolaise</h1>
                <p class="text-lg mb-8 text-white/80">Pour la sécurité, la justice et la paix en République Démocratique du Congo.<br>Accédez à la plateforme de gestion des permis de conduire, cartes, et infractions.</p>
                <a href="{{ route('login') }}" class="inline-block px-8 py-3 bg-yellow-500 text-[#112255] font-bold rounded shadow hover:bg-yellow-400 transition text-lg">Accéder à l'espace sécurisé</a>
            </div>
        </main>

        <footer class="py-8 text-center text-sm text-white/70 border-t border-white/10 mt-auto">
            &copy; {{ date('Y') }} Police - RDC. Tous droits réservés.
        </footer>
    </div>
</body>
</html>
