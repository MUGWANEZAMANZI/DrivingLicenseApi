


<div class="bg-[#112255] min-h-screen py-6 px-2">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-extrabold text-white tracking-wide">{{ __('dashboard.title') }}</h1>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.driver.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['drivers'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.license.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['licenses'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.card.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['cards'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.penalty.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['penalties'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.penaltiesDrivers.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['penaltiesDrivers'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-3 flex flex-col items-center">
                <div class="text-base font-semibold text-[#112255] mb-1">{{ __('models.user.plural') }}</div>
                <div class="text-2xl font-extrabold text-[#112255]">{{ $stats['users'] }}</div>
            </div>
        </div>
    </div>
</div>


