<div>
    @livewire('components.header')

    <div class="min-h-screen bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ __('messages.promoter.manage_renewals') }}</h1>
                    <p class="text-gray-600">{{ __('messages.promoter.renewals_subtitle') }}</p>
                </div>
                <button wire:click="toggleInitiateForm" 
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-semibold">
                    {{ $showInitiateForm ? __('messages.common.cancel') : __('messages.promoter.initiate_renewal') }}
                </button>
            </div>

            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Upcoming Expirations Alert --}}
            @if($upcomingExpirations->count() > 0)
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-orange-800">{{ __('messages.promoter.upcoming_expirations') }}</h3>
                            <div class="mt-2 text-sm text-orange-700">
                                <p>{{ $upcomingExpirations->count() }} {{ __('messages.promoter.leases_expiring_soon') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Initiate Renewal Form --}}
            @if($showInitiateForm)
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-bold mb-6">{{ __('messages.promoter.initiate_renewal_form') }}</h2>
                    
                    <form wire:submit.prevent="initiateRenewal" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.promoter.select_booking') }} <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="selectedBookingId" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                <option value="">{{ __('messages.common.select') }}</option>
                                @foreach($activeBookings as $booking)
                                    <option value="{{ $booking->id }}">
                                        {{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }} 
                                        - {{ $booking->customer_name }} 
                                        ({{ __('messages.renewal.expires') }}: {{ $booking->end_date->format('d/m/Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedBookingId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('messages.renewal.new_end_date') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="newEndDate" 
                                       class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('newEndDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('messages.renewal.amount') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="renewalAmount" 
                                       class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                       placeholder="0">
                                @error('renewalAmount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('messages.renewal.duration') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="renewalDuration" min="1"
                                       class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                @error('renewalDuration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('messages.renewal.frequency') }} <span class="text-red-500">*</span>
                                </label>
                                <select wire:model="renewalFrequency" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option value="daily">{{ __('messages.booking.frequency.daily') }}</option>
                                    <option value="weekly">{{ __('messages.booking.frequency.weekly') }}</option>
                                    <option value="monthly">{{ __('messages.booking.frequency.monthly') }}</option>
                                    <option value="yearly">{{ __('messages.booking.frequency.yearly') }}</option>
                                </select>
                                @error('renewalFrequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.common.notes') }}
                            </label>
                            <textarea wire:model="notes" rows="3"
                                      class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                      placeholder="{{ __('messages.promoter.renewal_notes_placeholder') }}"></textarea>
                            @error('notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-semibold">
                                {{ __('messages.promoter.create_renewal') }}
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button wire:click="$set('statusFilter', 'all')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.common.all') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'pending')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.renewal.status.pending') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'approved')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.renewal.status.approved') }}
                    </button>
                    <button wire:click="$set('statusFilter', 'rejected')" 
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ __('messages.renewal.status.rejected') }}
                    </button>
                </div>
            </div>

            {{-- Renewals List --}}
            @if($renewals->count() > 0)
                <div class="space-y-4">
                    @foreach($renewals as $renewal)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ app()->getLocale() == 'fr' ? $renewal->property->title_fr : $renewal->property->title_en }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $renewal->property->location }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ __('messages.promoter.client') }}: {{ $renewal->user->name }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $renewal->status == 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $renewal->status == 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $renewal->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ __('messages.renewal.status.' . $renewal->status) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('messages.renewal.current_end') }}</p>
                                    <p class="font-semibold">{{ $renewal->current_end_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('messages.renewal.new_end_date') }}</p>
                                    <p class="font-semibold">{{ $renewal->new_end_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('messages.renewal.duration') }}</p>
                                    <p class="font-semibold">{{ $renewal->renewal_duration }} {{ __('messages.booking.frequency.' . $renewal->renewal_frequency) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">{{ __('messages.renewal.amount') }}</p>
                                    <p class="font-bold text-primary">{{ number_format($renewal->renewal_amount, 0, ',', ' ') }} FCFA</p>
                                </div>
                            </div>

                            @if($renewal->notes)
                                <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm text-gray-700">{{ $renewal->notes }}</p>
                                </div>
                            @endif

                            @if($renewal->rejection_reason)
                                <div class="bg-red-50 rounded-lg p-3 mb-4">
                                    <p class="text-sm font-semibold text-red-800 mb-1">{{ __('messages.promoter.rejection_reason') }}</p>
                                    <p class="text-sm text-red-700">{{ $renewal->rejection_reason }}</p>
                                </div>
                            @endif

                            {{-- Actions --}}
                            @if($renewal->status === 'pending')
                                <div class="flex gap-2">
                                    <button wire:click="approveRenewal({{ $renewal->id }})" 
                                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium">
                                        {{ __('messages.promoter.actions.approve') }}
                                    </button>
                                    <button wire:click="openRejectModal({{ $renewal->id }})" 
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                                        {{ __('messages.promoter.actions.reject') }}
                                    </button>
                                </div>
                            @endif

                            <div class="text-xs text-gray-500 mt-4">
                                {{ __('messages.common.requested') }}: {{ $renewal->created_at->format('d/m/Y H:i') }}
                                @if($renewal->approved_at)
                                    | {{ __('messages.renewal.approved_at') }}: {{ $renewal->approved_at->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $renewals->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.promoter.no_renewals') }}</h3>
                    <p class="text-gray-500">{{ __('messages.promoter.no_renewals_description') }}</p>
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

                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.promoter.reject_renewal') }}</h3>
                    
                    <form wire:submit.prevent="rejectRenewal">
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

    @livewire('components.footer')
</div>


