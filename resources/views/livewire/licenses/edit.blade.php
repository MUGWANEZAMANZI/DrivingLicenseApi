<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Edit') }} {{ __('models.license.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.license.fields.driverId') }}</label>
                <select wire:model.defer="license.driverId" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    @foreach($drivers as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} {{ $d->surName }}</option>
                    @endforeach
                </select>
                @error('license.driverId') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.license.fields.licenseNumber') }}</label>
                <input type="text" wire:model.defer="license.licenseNumber" class="w-full border rounded px-3 py-2">
                @error('license.licenseNumber') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.license.fields.plateNumber') }}</label>
                <input type="text" wire:model.defer="license.plateNumber" class="w-full border rounded px-3 py-2">
                @error('license.plateNumber') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.license.fields.issueDate') }}</label>
                <input type="date" wire:model.defer="license.issueDate" class="w-full border rounded px-3 py-2">
                @error('license.issueDate') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.license.fields.expiryDate') }}</label>
                <input type="date" wire:model.defer="license.expiryDate" class="w-full border rounded px-3 py-2">
                @error('license.expiryDate') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.license.fields.dateLieuDelivrance') }}</label>
                <input type="text" wire:model.defer="license.dateLieuDelivrance" class="w-full border rounded px-3 py-2">
                @error('license.dateLieuDelivrance') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.license.fields.licensesAllowed') }}</label>
                <input type="text" wire:model.defer="license.licensesAllowed" class="w-full border rounded px-3 py-2">
                @error('license.licensesAllowed') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.license.fields.allowedCategories') }}</label>
                <input type="text" wire:model.defer="license.allowedCategories" class="w-full border rounded px-3 py-2">
                @error('license.allowedCategories') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('licenses.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


