<x-filament::guest-layout>
    <div class="flex justify-center mt-10">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-24 w-auto">
            </div>

            <x-filament::auth-card>
                {{ $slot }}
            </x-filament::auth-card>
        </div>
    </div>
</x-filament::guest-layout>
