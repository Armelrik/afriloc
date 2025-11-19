<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold mb-8">{{ __('messages.payment.title') }}</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Payment Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        @if($paymentStatus['is_fully_paid'])
                            {{-- Fully Paid --}}
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto mb-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-green-600 mb-2">{{ __('messages.payment.fully_paid') }}</h2>
                                <p class="text-gray-600 mb-6">{{ __('messages.payment.fully_paid_desc') }}</p>
                                <a href="{{ route('client.bookings') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600">
                                    {{ __('messages.payment.view_bookings') }}
                                </a>
                            </div>
                        @else
                            {{-- Payment Form --}}
                            <form wire:submit.prevent="processPayment">
                                {{-- Payment Method Selection --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('messages.payment.method') }}</label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-primary transition-all {{ $payment_method === 'mobile_money' ? 'border-primary bg-primary/5' : 'border-gray-200' }}">
                                            <input type="radio" wire:model.live="payment_method" value="mobile_money" class="sr-only">
                                            <div class="flex-1">
                                                <div class="font-semibold">{{ __('messages.payment.mobile_money') }}</div>
                                                <div class="text-xs text-gray-500">Mobicash, Orange, Moov</div>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-primary transition-all {{ $payment_method === 'card' ? 'border-primary bg-primary/5' : 'border-gray-200' }}">
                                            <input type="radio" wire:model.live="payment_method" value="card" class="sr-only">
                                            <div class="flex-1">
                                                <div class="font-semibold">{{ __('messages.payment.card') }}</div>
                                                <div class="text-xs text-gray-500">Visa, Mastercard</div>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-primary transition-all {{ $payment_method === 'bank_transfer' ? 'border-primary bg-primary/5' : 'border-gray-200' }}">
                                            <input type="radio" wire:model.live="payment_method" value="bank_transfer" class="sr-only">
                                            <div class="flex-1">
                                                <div class="font-semibold">{{ __('messages.payment.bank_transfer') }}</div>
                                                <div class="text-xs text-gray-500">{{ __('messages.payment.manual_verification') }}</div>
                                            </div>
                                        </label>

                                        <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-primary transition-all {{ $payment_method === 'cash' ? 'border-primary bg-primary/5' : 'border-gray-200' }}">
                                            <input type="radio" wire:model.live="payment_method" value="cash" class="sr-only">
                                            <div class="flex-1">
                                                <div class="font-semibold">{{ __('messages.payment.cash') }}</div>
                                                <div class="text-xs text-gray-500">{{ __('messages.payment.pay_in_person') }}</div>
                                            </div>
                                        </label>
                                    </div>
                                    @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                {{-- Amount --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.amount') }}</label>
                                    <input type="number" wire:model="amount" step="0.01" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="0">
                                    @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                {{-- Mobile Money Fields --}}
                                @if($payment_method === 'mobile_money')
                                    <div class="space-y-4 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.provider') }}</label>
                                            <select wire:model="payment_provider" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                                <option value="">{{ __('messages.payment.select_provider') }}</option>
                                                <option value="mobicash">Mobicash</option>
                                                <option value="orange_money">Orange Money</option>
                                                <option value="moov_money">Moov Money</option>
                                            </select>
                                            @error('payment_provider') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.phone_number') }}</label>
                                            <input type="tel" wire:model="phone_number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="+226 XX XX XX XX">
                                            @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif

                                {{-- Card Fields --}}
                                @if($payment_method === 'card')
                                    <div class="space-y-4 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.card_type') }}</label>
                                            <select wire:model="payment_provider" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                                <option value="">{{ __('messages.payment.select_card') }}</option>
                                                <option value="visa">Visa</option>
                                                <option value="mastercard">Mastercard</option>
                                            </select>
                                            @error('payment_provider') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.card_holder') }}</label>
                                            <input type="text" wire:model="card_holder" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="{{ __('messages.payment.name_on_card') }}">
                                            @error('card_holder') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.card_number') }}</label>
                                            <input type="text" wire:model="card_number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="4111 1111 1111 1111">
                                            @error('card_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.expiry_date') }}</label>
                                                <input type="text" wire:model="expiry_date" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="MM/YY">
                                                @error('expiry_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.cvv') }}</label>
                                                <input type="text" wire:model="cvv" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary" placeholder="123">
                                                @error('cvv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Bank Transfer Fields --}}
                                @if($payment_method === 'bank_transfer')
                                    <div class="space-y-4 mb-6">
                                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                                            {{ __('messages.payment.bank_transfer_instructions') }}
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.bank_name') }}</label>
                                            <input type="text" wire:model="bank_name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                            @error('bank_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.payment.transfer_reference') }}</label>
                                            <input type="text" wire:model="transfer_reference" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                                            @error('transfer_reference') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                @endif

                                {{-- Cash Payment Info --}}
                                @if($payment_method === 'cash')
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                        <p class="text-sm text-yellow-800">{{ __('messages.payment.cash_instructions') }}</p>
                                    </div>
                                @endif

                                {{-- Submit Button --}}
                                <button type="submit" 
                                        wire:loading.attr="disabled" 
                                        wire:target="processPayment"
                                        class="w-full bg-gradient-to-r from-primary to-accent text-white py-3 rounded-lg font-semibold hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span wire:loading.remove wire:target="processPayment">{{ __('messages.payment.submit') }}</span>
                                    <span wire:loading wire:target="processPayment">{{ __('messages.payment.processing') }}</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                {{-- Booking Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h3 class="font-bold text-lg mb-4">{{ __('messages.payment.booking_summary') }}</h3>
                        
                        <div class="mb-4">
                            <img src="{{ asset('images/' . basename($booking->property->images[0] ?? 'default.jpg')) }}" 
                                 alt="{{ $booking->property->title_en }}" 
                                 class="w-full h-32 object-cover rounded-lg mb-2">
                            <h4 class="font-semibold">{{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }}</h4>
                        </div>

                        <div class="space-y-2 text-sm border-t pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('messages.payment.total_amount') }}:</span>
                                <span class="font-semibold">{{ number_format($paymentStatus['total_due'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>{{ __('messages.payment.paid') }}:</span>
                                <span class="font-semibold">{{ number_format($paymentStatus['total_paid'], 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-orange-600 border-t pt-2">
                                <span class="font-semibold">{{ __('messages.payment.remaining') }}:</span>
                                <span class="font-bold">{{ number_format($paymentStatus['remaining'], 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                        {{-- Payment Progress --}}
                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary h-2 rounded-full" style="width: {{ ($paymentStatus['total_paid'] / $paymentStatus['total_due']) * 100 }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1 text-center">
                                {{ number_format(($paymentStatus['total_paid'] / $paymentStatus['total_due']) * 100, 0) }}% {{ __('messages.payment.paid_label') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.footer')

    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
