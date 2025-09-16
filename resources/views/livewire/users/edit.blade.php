<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Edit') }} {{ __('models.user.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.user.fields.name') }}</label>
                <input type="text" wire:model.defer="user.name" class="w-full border rounded px-3 py-2">
                @error('user.name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.user.fields.email') }}</label>
                <input type="email" wire:model.defer="user.email" class="w-full border rounded px-3 py-2">
                @error('user.email') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.user.fields.password') }}</label>
                <input type="password" wire:model.defer="password" class="w-full border rounded px-3 py-2" placeholder="••••••">
                @error('password') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('users.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


