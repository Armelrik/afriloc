<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold mb-8">{{ __('Book Property') }}: {{ $property->title_fr }}</h2>
            
            <form wire:submit.prevent="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Customer Information -->
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold mb-4">{{ __('Your Information') }}</h3>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Full Name') }}</label>
                        <input type="text" wire:model="customer_name" class="w-full px-4 py-2 border rounded-lg">
                        @error('customer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Email') }}</label>
                        <input type="email" wire:model="customer_email" class="w-full px-4 py-2 border rounded-lg">
                        @error('customer_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Phone') }}</label>
                        <input type="tel" wire:model="customer_phone" class="w-full px-4 py-2 border rounded-lg">
                        @error('customer_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Number of People') }}</label>
                        <input type="number" wire:model="num_people" min="1" class="w-full px-4 py-2 border rounded-lg">
                        @error('num_people') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Booking Details -->
                    <div class="md:col-span-2">
                        <h3 class="text-xl font-semibold mb-4 mt-6">{{ __('Booking Details') }}</h3>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Start Date') }}</label>
                        <input type="date" wire:model="start_date" class="w-full px-4 py-2 border rounded-lg">
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('End Date') }}</label>
                        <input type="date" wire:model="end_date" class="w-full px-4 py-2 border rounded-lg">
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Rental Duration') }}</label>
                        <input type="number" wire:model.live="rental_duration" min="1" class="w-full px-4 py-2 border rounded-lg">
                        @error('rental_duration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Frequency') }}</label>
                        <select wire:model.live="rental_frequency" class="w-full px-4 py-2 border rounded-lg">
                            <option value="daily">{{ __('Daily') }}</option>
                            <option value="weekly">{{ __('Weekly') }}</option>
                            <option value="monthly">{{ __('Monthly') }}</option>
                            <option value="yearly">{{ __('Yearly') }}</option>
                        </select>
                        @error('rental_frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2">{{ __('Comments') }}</label>
                        <textarea wire:model="comments" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                    </div>

                    <!-- Cost Summary -->
                    @if (!empty($calculatedCosts))
                        <div class="md:col-span-2 bg-gray-50 rounded-lg p-6 mt-6">
                            <h3 class="text-xl font-semibold mb-4">{{ __('Cost Summary') }}</h3>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span>{{ __('Base Rent') }} ({{ $rental_duration }} {{ __($rental_frequency) }})</span>
                                    <span class="font-semibold">{{ number_format($calculatedCosts['total_rent'], 0) }} FCFA</span>
                                </div>
                                @if ($calculatedCosts['deposit'] > 0)
                                    <div class="flex justify-between">
                                        <span>{{ __('Deposit') }}</span>
                                        <span class="font-semibold">{{ number_format($calculatedCosts['deposit'], 0) }} FCFA</span>
                                    </div>
                                @endif
                                @if ($calculatedCosts['advance'] > 0)
                                    <div class="flex justify-between">
                                        <span>{{ __('Advance Payment') }}</span>
                                        <span class="font-semibold">{{ number_format($calculatedCosts['advance'], 0) }} FCFA</span>
                                    </div>
                                @endif
                                <div class="border-t pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span>{{ __('Total Due') }}</span>
                                        <span class="text-primary">{{ number_format($calculatedCosts['total_due'], 0) }} FCFA</span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 mt-2">
                                    <p>{{ __('Platform commission') }}: {{ number_format($calculatedCosts['commission'], 0) }} FCFA</p>
                                    <p>{{ __('Amount to promoter') }}: {{ number_format($calculatedCosts['promoter_amount'], 0) }} FCFA</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="md:col-span-2 flex justify-end gap-4 mt-6">
                        <a href="{{ route('properties.show', $propertyId) }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            {{ __('Cancel') }}
                        </a>
                        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">
                            {{ __('Submit Booking Request') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
