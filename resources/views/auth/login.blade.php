
<div class="min-h-screen flex flex-col justify-center items-center bg-[#112255] font-sans">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
        <div class="flex justify-center mb-6">
            <a href='/'><img src="{{ asset('Logo_afc.png') }}" alt="Logo" class="h-20 w-auto"></a>
        </div>
        <h2 class="text-3xl font-extrabold mb-6 text-center ">Connexion Sécurisée</h2>
        @if(session('error'))
            <div class="mb-4 text-red-600 text-center">{{ session('error') }}</div>
        @endif
        <form wire:submit.prevent="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-[#112255] mb-1">Email</label>
                <input type="email" wire:model.live="email" id="email" required autofocus class="w-full px-4 py-2 border-2 border-[#112255] rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-semibold text-[#112255] mb-1">Mot de passe</label>
                <input type="password" wire:model.live="password" id="password" required class="w-full px-4 py-2 border-2 border-[#112255] rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <button type="submit" class="w-full py-3 bg-yellow-500 text-[#112255] font-bold rounded shadow hover:bg-yellow-400 transition relative" wire:loading.attr="disabled" wire:target="login">
                <span wire:loading.remove wire:target="login">Se connecter</span>
                <span wire:loading wire:target="login" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2 text-[#112255]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Chargement...
                </span>
            </button>
        </form>
    </div>
    <footer class="mt-8 text-white/70 text-sm text-center">
        &copy; {{ date('Y') }} Police - RDC. Tous droits réservés.
    </footer>
</div>

