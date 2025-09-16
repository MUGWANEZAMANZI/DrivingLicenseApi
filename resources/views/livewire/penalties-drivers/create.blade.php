<div class="max-w-3xl">
    <h1 class="text-2xl font-semibold mb-4">{{ __('Create') }} {{ __('models.penaltiesDrivers.singular') }}</h1>

    <form wire:submit.prevent="save" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">{{ __('models.penaltiesDrivers.fields.driver_id') }}</label>
                <select wire:model.defer="item.driver_id" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    @foreach($drivers as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} {{ $d->surName }}</option>
                    @endforeach
                </select>
                @error('item.driver_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.penaltiesDrivers.fields.penalty_id') }}</label>
                <select wire:model.defer="item.penalty_id" class="w-full border rounded px-3 py-2">
                    <option value="">--</option>
                    @foreach($penalties as $p)
                        <option value="{{ $p->id }}">{{ $p->penaltyType }}</option>
                    @endforeach
                </select>
                @error('item.penalty_id') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.penaltiesDrivers.fields.amount') }}</label>
                <input type="number" step="0.01" wire:model.defer="item.amount" class="w-full border rounded px-3 py-2">
                @error('item.amount') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">{{ __('models.penaltiesDrivers.fields.dateIssued') }}</label>
                <input type="date" wire:model.defer="item.dateIssued" class="w-full border rounded px-3 py-2">
                @error('item.dateIssued') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" wire:model.defer="item.isPaid" class="rounded">
                    <span>{{ __('models.penaltiesDrivers.fields.isPaid') }}</span>
                </label>
                @error('item.isPaid') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">{{ __('Save') }}</button>
            <a href="{{ route('penaltiesDrivers.index') }}" class="ml-2 px-4 py-2 border rounded">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>


