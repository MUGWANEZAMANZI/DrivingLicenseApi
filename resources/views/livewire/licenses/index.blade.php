<div class="bg-[#112255]">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">{{ __('models.license.plural') }}</h1>
        <a href="{{ route('licenses.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">{{ __('Create') }}</a>
    </div>

    <div class="mb-4">
        <input type="text" wire:model.live="search" class="w-full text-white md:w-80 border rounded px-3 py-2" placeholder="{{ __('Search') }}...">
    </div>

    <div class="bg-white rounded-md border overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.license.fields.licenseNumber') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.license.fields.driverId') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('models.license.fields.expiryDate') }}</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($licenses as $license)
                <tr>
                    <td class="px-4 py-2">{{ $license->id }}</td>
                    <td class="px-4 py-2">{{ $license->licenseNumber }}</td>
                    <td class="px-4 py-2">{{ $license->driver?->name }} {{ $license->driver?->surName }}</td>
                    <td class="px-4 py-2">{{ $license->expiryDate }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a class="text-blue-600 hover:underline" href="{{ route('licenses.edit', $license) }}">{{ __('Edit') }}</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $licenses->links() }}</div>
</div>


