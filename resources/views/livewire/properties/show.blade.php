<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Image Gallery --}}
                @if($property->images && count($property->images) > 0)
                    <div class="mb-8">
                        <img src="{{ asset('images/' . basename($property->images[0])) }}" alt="{{ $property->title_en }}" 
                             class="w-full h-96 object-cover rounded-xl shadow-lg">
                    </div>
                @endif

                <h1 class="text-4xl font-bold mb-4">
                    {{ app()->getLocale() == 'fr' ? $property->title_fr : $property->title_en }}
                </h1>

                <div class="flex items-center space-x-4 mb-6 text-gray-600">
                    <span class="flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        {{ $property->location }}
                    </span>
                    <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-sm font-semibold capitalize">
                        {{ $property->type }}
                    </span>
                </div>

                <div class="prose max-w-none mb-8">
                    <h2>{{ __('messages.properties.description') }}</h2>
                    <p>{{ app()->getLocale() == 'fr' ? $property->description_fr : $property->description_en }}</p>
                </div>

                {{-- Features --}}
                @if($property->bedrooms || $property->bathrooms || $property->area)
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold mb-4">{{ __('messages.properties.features') }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @if($property->bedrooms)
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span>{{ $property->bedrooms }} {{ __('messages.properties.bedrooms') }}</span>
                                </div>
                            @endif
                            @if($property->bathrooms)
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $property->bathrooms }} {{ __('messages.properties.bathrooms') }}</span>
                                </div>
                            @endif
                            @if($property->area)
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                    </svg>
                                    <span>{{ $property->area }} m²</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-lg sticky top-24">
                    <div class="text-3xl font-bold text-primary mb-2">
                        {{ number_format($property->price, 0, ',', ' ') }} FCFA
                    </div>
                    @if($property->rental_frequency)
                        <p class="text-gray-600 mb-6">{{ __('messages.properties.per_' . $property->rental_frequency) }}</p>
                    @else
                        <p class="text-gray-600 mb-6">{{ __('messages.properties.per_month') }}</p>
                    @endif

                    @if($property->availability_status == 'available')
                        @auth
                            @if(auth()->user()->isClient() || auth()->user()->isAdmin())
                                <a href="{{ route('booking.create', $property->id) }}" 
                                   class="block w-full bg-gradient-to-r from-primary to-accent text-white text-center py-3 rounded-lg hover:shadow-xl transition-all hover:scale-105 font-semibold mb-3">
                                    {{ __('messages.properties.book_now') }}
                                </a>
                            @endif
                        @else
                            <button onclick="Livewire.dispatch('openLoginModal')" 
                                    class="block w-full bg-gradient-to-r from-primary to-accent text-white text-center py-3 rounded-lg hover:shadow-xl transition-all hover:scale-105 font-semibold mb-3">
                                {{ __('messages.booking.login_to_book') }}
                            </button>
                        @endauth
                    @endif

                    <a href="/contact?property={{ $property->id }}" 
                       class="block w-full bg-white border-2 border-primary text-primary text-center py-3 rounded-lg hover:bg-primary hover:text-white transition-colors mb-4">
                        {{ __('messages.properties.contact') }}
                    </a>

                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-2">{{ __('messages.properties.status_label') }}</h4>
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold 
                                     {{ $property->availability_status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ __('messages.properties.status.' . $property->availability_status) }}
                        </span>
                    </div>

                    @if($property->address)
                        <div class="border-t pt-4 mt-4">
                            <h4 class="font-semibold mb-2">{{ __('messages.properties.address') }}</h4>
                            <p class="text-gray-600">{{ $property->address }}</p>
                        </div>
                    @endif

                    {{-- Rental Details --}}
                    <div class="border-t pt-4 mt-4">
                        <h4 class="font-semibold mb-3">{{ __('messages.booking.rental_details') }}</h4>
                        <div class="space-y-2 text-sm">
                            @if($property->monthly_rent)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('messages.booking.monthly_rent') }}:</span>
                                    <span class="font-semibold">{{ number_format($property->monthly_rent, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                            @if($property->deposit_amount)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('messages.booking.deposit') }}:</span>
                                    <span class="font-semibold">{{ number_format($property->deposit_amount, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                            @if($property->advance_payment)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">{{ __('messages.booking.advance') }}:</span>
                                    <span class="font-semibold">{{ number_format($property->advance_payment, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.footer')
</div>
