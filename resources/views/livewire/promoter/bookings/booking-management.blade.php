<div>
    @livewire('components.header')

    <div class="min-h-screen bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">{{ __('messages.promoter.manage_bookings') }}</h1>
                <p class="text-gray-600">{{ __('messages.promoter.bookings_subtitle') }}</p>
            </div>

            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button wire:click="$set('statusFilter', 'all')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.common.all') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'pending')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.booking.status.pending') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'confirmed')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.booking.status.confirmed') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'active')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'active' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.booking.status.active') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'completed')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'completed' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.booking.status.completed') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'cancelled')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.booking.status.cancelled') }}
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
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row gap-4">
                                    {{-- Property Info --}}
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-4">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-1">
                                                    {{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }}
                                                </h3>
                                                <p class="text-gray-600 flex items-center gap-1 text-sm">
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

                                        {{-- Client Info --}}
                                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                            <h4 class="font-semibold text-gray-700 mb-2">{{ __('messages.promoter.client_info') }}</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                                <div><span class="text-gray-600">{{ __('messages.common.name') }}:</span> <span class="font-medium">{{ $booking->customer_name }}</span></div>
                                                <div><span class="text-gray-600">{{ __('messages.common.email') }}:</span> <span class="font-medium">{{ $booking->customer_email }}</span></div>
                                                <div><span class="text-gray-600">{{ __('messages.common.phone') }}:</span> <span class="font-medium">{{ $booking->customer_phone }}</span></div>
                                                <div><span class="text-gray-600">{{ __('messages.booking.num_people') }}:</span> <span class="font-medium">{{ $booking->num_people }}</span></div>
                                            </div>
                                        </div>

                                        {{-- Booking Details --}}
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
                                                <p class="text-sm text-gray-500">{{ __('messages.booking.total_amount') }}</p>
                                                <p class="font-bold text-primary">{{ number_format($booking->total_amount, 0, ',', ' ') }} FCFA</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500">{{ __('messages.promoter.your_amount') }}</p>
                                                <p class="font-bold text-accent">{{ number_format($booking->promoter_amount, 0, ',', ' ') }} FCFA</p>
                                            </div>
                                        </div>

                                        {{-- Payment Status --}}
                                        <div class="mb-4">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $booking->payment_status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $booking->payment_status == 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $booking->payment_status == 'partial' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                {{ __('messages.payment.status.' . $booking->payment_status) }}
                                            </span>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex flex-wrap gap-2">
                                            <button wire:click="viewDetails({{ $booking->id }})" 
                                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                                                {{ __('messages.common.view_details') }}
                                            </button>
                                            
                                            @if($booking->status === 'pending')
                                                <button wire:click="confirmBooking({{ $booking->id }})" 
                                                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium">
                                                    {{ __('messages.promoter.actions.confirm') }}
                                                </button>
                                                <button wire:click="openRejectModal({{ $booking->id }})" 
                                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                                                    {{ __('messages.promoter.actions.reject') }}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.promoter.no_bookings') }}</h3>
                    <p class="text-gray-500">{{ __('messages.promoter.no_bookings_description') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Reject Modal --}}
    @if($showRejectModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeRejectModal"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6 z-50">
                    <button type="button" wire:click="closeRejectModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.promoter.reject_booking') }}</h3>
                    
                    <form wire:submit.prevent="rejectBooking">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.promoter.rejection_reason') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="rejectionReason" rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                      placeholder="{{ __('messages.promoter.rejection_reason_placeholder') }}"></textarea>
                            @error('rejectionReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" wire:click="closeRejectModal"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                {{ __('messages.common.cancel') }}
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                {{ __('messages.promoter.actions.reject') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Details Modal --}}
    @if($showDetails && $selectedBooking)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeDetails"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full p-6 z-50 max-h-[90vh] overflow-y-auto">
                    <button type="button" wire:click="closeDetails" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.booking.details') }}</h3>
                    
                    <div class="space-y-6">
                        {{-- Property Info --}}
                        <div>
                            <h4 class="font-bold text-lg mb-3">{{ __('messages.properties.property') }}</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="font-semibold text-lg">{{ app()->getLocale() == 'fr' ? $selectedBooking->property->title_fr : $selectedBooking->property->title_en }}</p>
                                <p class="text-gray-600">{{ $selectedBooking->property->location }}</p>
                            </div>
                        </div>

                        {{-- Client Info --}}
                        <div>
                            <h4 class="font-bold text-lg mb-3">{{ __('messages.promoter.client_info') }}</h4>
                            <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-2 gap-4">
                                <div><span class="text-gray-600">{{ __('messages.common.name') }}:</span> <span class="font-medium">{{ $selectedBooking->customer_name }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.common.email') }}:</span> <span class="font-medium">{{ $selectedBooking->customer_email }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.common.phone') }}:</span> <span class="font-medium">{{ $selectedBooking->customer_phone }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.booking.num_people') }}:</span> <span class="font-medium">{{ $selectedBooking->num_people }}</span></div>
                            </div>
                        </div>

                        {{-- Booking Info --}}
                        <div>
                            <h4 class="font-bold text-lg mb-3">{{ __('messages.booking.booking_info') }}</h4>
                            <div class="bg-gray-50 rounded-lg p-4 grid grid-cols-2 gap-4">
                                <div><span class="text-gray-600">{{ __('messages.booking.start_date') }}:</span> <span class="font-medium">{{ $selectedBooking->start_date->format('d/m/Y') }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.booking.end_date') }}:</span> <span class="font-medium">{{ $selectedBooking->end_date->format('d/m/Y') }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.booking.rental_duration') }}:</span> <span class="font-medium">{{ $selectedBooking->rental_duration }} {{ __('messages.booking.frequency.' . $selectedBooking->rental_frequency) }}</span></div>
                                <div><span class="text-gray-600">{{ __('messages.booking.status_label') }}:</span> <span class="font-medium">{{ __('messages.booking.status.' . $selectedBooking->status) }}</span></div>
                            </div>
                        </div>

                        {{-- Payment Info --}}
                        <div>
                            <h4 class="font-bold text-lg mb-3">{{ __('messages.payment.payment_info') }}</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div><span class="text-gray-600">{{ __('messages.booking.total_rent') }}:</span> <span class="font-bold text-lg">{{ number_format($selectedBooking->total_rent, 0, ',', ' ') }} FCFA</span></div>
                                    <div><span class="text-gray-600">{{ __('messages.booking.deposit') }}:</span> <span class="font-medium">{{ number_format($selectedBooking->deposit_paid, 0, ',', ' ') }} FCFA</span></div>
                                    <div><span class="text-gray-600">{{ __('messages.promoter.commission') }}:</span> <span class="font-medium">{{ number_format($selectedBooking->platform_commission, 0, ',', ' ') }} FCFA</span></div>
                                    <div><span class="text-gray-600">{{ __('messages.promoter.your_amount') }}:</span> <span class="font-bold text-lg text-accent">{{ number_format($selectedBooking->promoter_amount, 0, ',', ' ') }} FCFA</span></div>
                                </div>
                                <div><span class="text-gray-600">{{ __('messages.payment.status_label') }}:</span> 
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold ml-2
                                        {{ $selectedBooking->payment_status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                        {{ __('messages.payment.status.' . $selectedBooking->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Comments --}}
                        @if($selectedBooking->comments)
                            <div>
                                <h4 class="font-bold text-lg mb-3">{{ __('messages.common.comments') }}</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p>{{ $selectedBooking->comments }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    @livewire('components.footer')
</div>


