<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <img src="{{ asset('Logo_afc.png') }}" alt="Logo" class="h-16 w-auto">
         
         <!-- n
        <title>{{ config('app.name', 'Police Revolutionnaire Congolaise') }}</title>
         <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
        <div class="flex justify-center items-center h-32">
            <span class="text-xl font-semibold text-center">{{ __('admin.for_admin_use_only') }}</span>

        </div>
        <div class="flex justify-center mt-8">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ __('Login') }}
            </a>
        </div>
        
        
    

                    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                        All rights reserved. &copy; {{ date('Y') }} <span href="" class="underline hover:text-black dark:hover:text-white">Police - RDC</span>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
