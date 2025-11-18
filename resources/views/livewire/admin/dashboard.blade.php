<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <h1 class="text-4xl font-bold mb-8">{{ __('messages.admin.dashboard') }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.admin.total_properties') }}</p>
                        <p class="text-3xl font-bold text-primary">{{ $stats['properties'] }}</p>
                    </div>
                    <svg class="h-12 w-12 text-primary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.admin.total_bookings') }}</p>
                        <p class="text-3xl font-bold text-accent">{{ $stats['bookings'] }}</p>
                    </div>
                    <svg class="h-12 w-12 text-accent/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.admin.total_contacts') }}</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $stats['contacts'] }}</p>
                    </div>
                    <svg class="h-12 w-12 text-blue-600/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.admin.available_properties') }}</p>
                        <p class="text-3xl font-bold text-green-600">{{ $stats['available_properties'] }}</p>
                    </div>
                    <svg class="h-12 w-12 text-green-600/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="/admin/properties" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold mb-2">{{ __('messages.admin.manage_properties') }}</h3>
                <p class="text-gray-600">{{ __('messages.admin.manage_properties_desc') }}</p>
            </a>

            <a href="/admin/bookings" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold mb-2">{{ __('messages.admin.manage_bookings') }}</h3>
                <p class="text-gray-600">{{ __('messages.admin.manage_bookings_desc') }}</p>
            </a>

            <a href="/admin/contacts" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                <h3 class="text-xl font-bold mb-2">{{ __('messages.admin.manage_contacts') }}</h3>
                <p class="text-gray-600">{{ __('messages.admin.manage_contacts_desc') }}</p>
            </a>
        </div>
    </div>

    @livewire('components.footer')
</div>

