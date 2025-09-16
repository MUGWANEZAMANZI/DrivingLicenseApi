<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded shadow">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('Logo_afc.png') }}" alt="Logo" class="h-16 w-auto">
        </div>
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif
        <form wire:submit.prevent="login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model.live="email" id="email" required autofocus class="w-full px-3 py-2 border rounded">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" wire:model.live="password" id="password" required class="w-full px-3 py-2 border rounded">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 relative" wire:loading.attr="disabled" wire:target="login">
                <span wire:loading.remove wire:target="login">Login</span>
                <span wire:loading wire:target="login" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    Loading...
                </span>
            </button>
        </form>
    </div>
</div>

