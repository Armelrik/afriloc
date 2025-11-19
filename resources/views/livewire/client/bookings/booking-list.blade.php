<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ __('messages.client.my_bookings') }}</h1>
            <p class="text-gray-600">{{ __('messages.client.bookings_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('statusFilter', 'all')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.common.all') }}
                </button>
                <button wire:click="$set('statusFilter', 'pending')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.pending') }}
                </button>
                <button wire:click="$set('statusFilter', 'confirmed')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.confirmed') }}
                </button>
                <button wire:click="$set('statusFilter', 'active')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'active' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.active') }}
                </button>
                <button wire:click="$set('statusFilter', 'completed')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'completed' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.completed') }}
                </button>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Bookings List --}}
        @if($bookings->count() > 0)
            <div class="space-y-4">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-4">
                                {{-- Property Image --}}
                                @if($booking->property->images && count($booking->property->images) > 0)
                                    <img src="{{ asset('images/' . basename($booking->property->images[0])) }}" 
                                         alt="{{ $booking->property->title_en }}" 
                                         class="w-full md:w-48 h-48 object-cover rounded-lg">
                                @endif

                                {{-- Booking Details --}}
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold mb-1">
                                                {{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }}
                                            </h3>
                                            <p class="text-gray-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $booking->property->location }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $booking->status == 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $booking->status == 'active' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $booking->status == 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ __('messages.booking.status.' . $booking->status) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('messages.booking.start_date') }}</p>
                                            <p class="font-semibold">{{ $booking->start_date->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('messages.booking.end_date') }}</p>
                                            <p class="font-semibold">{{ $booking->end_date->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('messages.booking.duration') }}</p>
                                            <p class="font-semibold">{{ $booking->start_date->diffInDays($booking->end_date) }} {{ __('messages.common.days') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">{{ __('messages.booking.total_amount') }}</p>
                                            <p class="font-bold text-primary">{{ number_format($booking->total_amount, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                    </div>

                                    {{-- Payment Status --}}
                                    <div class="mb-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $booking->payment_status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ __('messages.payment.status.' . $booking->payment_status) }}
                                        </span>
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('properties.show', $booking->property_id) }}" 
                                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                            {{ __('messages.common.view_property') }}
                                        </a>
                                        @if($booking->payment_status !== 'completed')
                                            <a href="{{ route('payment.show', $booking->id) }}" 
                                               class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                                                {{ __('messages.payment.pay_now') }}
                                            </a>
                                        @endif
                                        @if($booking->status === 'pending')
                                            <button wire:click="cancelBooking({{ $booking->id }})" 
                                                    wire:confirm="{{ __('messages.booking.confirm_cancel') }}"
                                                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                                {{ __('messages.common.cancel') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.client.no_bookings') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('messages.client.no_bookings_description') }}</p>
                <a href="{{ route('properties.index') }}" 
                   class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                    {{ __('messages.client.browse_properties') }}
                </a>
            </div>
        @endif
    </div>

    @livewire('components.footer')
</div>

