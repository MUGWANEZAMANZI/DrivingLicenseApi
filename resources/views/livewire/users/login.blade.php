<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <form wire:submit.prevent="login">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('Logo_acf.png') }}" alt="Logo" class="h-16 w-auto">
        </div>
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

        @if ($error)
            <div class="mb-4 text-red-600">{{ $error }}</div>
        @endif

        <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold">Email</label>
            <input type="email" id="email" wire:model.defer="email" class="w-full border rounded px-3 py-2" required autofocus>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold">Password</label>
            <input type="password" id="password" wire:model.defer="password" class="w-full border rounded px-3 py-2" required>
            @error('password') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" id="remember" wire:model="remember" class="mr-2">
            <label for="remember">Remember me</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    </form>
</div>
