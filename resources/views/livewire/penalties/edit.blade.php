<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Edit') }} {{ __('models.penalty.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.penalty.fields.penaltyType') }}</label>
                <input type="text" wire:model.defer="penalty.penaltyType" class="w-full border rounded px-3 py-2">
                @error('penalty.penaltyType') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.penalty.fields.amount') }}</label>
                <input type="number" step="0.01" wire:model.defer="penalty.amount" class="w-full border rounded px-3 py-2">
                @error('penalty.amount') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('penalties.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


