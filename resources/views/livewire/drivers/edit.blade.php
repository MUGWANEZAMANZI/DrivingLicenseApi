<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Edit') }} {{ __('models.driver.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.name') }}</label>
                <input type="text" wire:model.defer="driver.name" class="w-full border rounded px-3 py-2">
                @error('driver.name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.surName') }}</label>
                <input type="text" wire:model.defer="driver.surName" class="w-full border rounded px-3 py-2">
                @error('driver.surName') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.email') }}</label>
                <input type="email" wire:model.defer="driver.email" class="w-full border rounded px-3 py-2">
                @error('driver.email') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.phone') }}</label>
                <input type="text" wire:model.defer="driver.phone" class="w-full border rounded px-3 py-2">
                @error('driver.phone') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.address') }}</label>
                <input type="text" wire:model.defer="driver.address" class="w-full border rounded px-3 py-2">
                @error('driver.address') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.bloodGroup') }}</label>
                <input type="text" wire:model.defer="driver.bloodGroup" class="w-full border rounded px-3 py-2">
                @error('driver.bloodGroup') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.nationalId') }}</label>
                <input type="text" wire:model.defer="driver.nationalId" class="w-full border rounded px-3 py-2">
                @error('driver.nationalId') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.driver.fields.profileImage') }}</label>
                <input type="text" wire:model.defer="driver.profileImage" class="w-full border rounded px-3 py-2">
                @error('driver.profileImage') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('drivers.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


