<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Edit') }} {{ __('models.card.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm mb-1">{{ __('models.card.fields.license_id') }}</label>
                <select wire:model.defer="card.license_id" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    @foreach($licenses as $l)
                        <option value="{{ $l->id }}">{{ $l->licenseNumber }} — {{ $l->driver?->name }} {{ $l->driver?->surName }}</option>
                    @endforeach
                </select>
                @error('card.license_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.card.fields.cardNumber') }}</label>
                <input type="text" wire:model.defer="card.cardNumber" class="w-full border rounded px-3 py-2">
                @error('card.cardNumber') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.card.fields.secret') }}</label>
                <input type="text" wire:model.defer="card.secret" class="w-full border rounded px-3 py-2">
                @error('card.secret') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.card.fields.programmedDate') }}</label>
                <input type="date" wire:model.defer="card.programmedDate" class="w-full border rounded px-3 py-2">
                @error('card.programmedDate') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('cards.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


