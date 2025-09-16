<div class="bg-[#112255]">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">{{ __('models.penaltiesDrivers.plural') }}</h1>
        <a href="{{ route('penaltiesDrivers.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">{{ __('Create') }}</a>
    </div>

    <div class="mb-4">
        <input type="text" wire:model.live="search" class="w-full text-white md:w-80 border rounded px-3 py-2" placeholder="{{ __('Search') }}...">
    </div>

    <div class="bg-white rounded-md border overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.penaltiesDrivers.fields.driver_id') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.penaltiesDrivers.fields.penalty_id') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.penaltiesDrivers.fields.amount') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.penaltiesDrivers.fields.isPaid') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $row)
                <tr>
                    <td class="px-4 py-2">{{ $row->id }}</td>
                    <td class="px-4 py-2">{{ optional($row->driver)->name }} {{ optional($row->driver)->surName }}</td>
                    <td class="px-4 py-2">{{ optional($row->penalty)->penaltyType }}</td>
                    <td class="px-4 py-2">{{ number_format($row->amount, 2) }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 text-xs rounded {{ $row->isPaid ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $row->isPaid ? __('Yes') : __('No') }}</span>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a class="text-blue-600 hover:underline" href="{{ route('penaltiesDrivers.edit', $row) }}">{{ __('Edit') }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
</div>


