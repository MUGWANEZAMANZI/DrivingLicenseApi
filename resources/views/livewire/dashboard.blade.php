
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">{{ __('dashboard.title') }}</h1>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.driver.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['drivers'] }}</div>
        </div>
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.license.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['licenses'] }}</div>
        </div>
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.card.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['cards'] }}</div>
        </div>
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.penalty.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['penalties'] }}</div>
        </div>
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.penaltiesDrivers.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['penaltiesDrivers'] }}</div>
        </div>
        <div class="bg-white rounded-lg border p-4">
            <div class="text-sm text-gray-500">{{ __('models.user.plural') }}</div>
            <div class="text-3xl font-bold">{{ $stats['users'] }}</div>
        </div>
    </div>
</div>


