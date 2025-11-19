<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold text-center mb-8">{{ __('Become a Promoter') }}</h2>
            
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="flex-1 text-center">
                            <div class="w-10 h-10 mx-auto rounded-full {{ $step >= $i ? 'bg-primary text-white' : 'bg-gray-200' }} flex items-center justify-center">
                                {{ $i }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <form wire:submit.prevent="{{ $step === 4 ? 'submit' : 'nextStep' }}">
                <!-- Step 1: User Account -->
                @if ($step === 1)
                    <div>
                        <h3 class="text-xl font-semibold mb-4">{{ __('Account Information') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Full Name') }}</label>
                            <input type="text" wire:model="name" class="w-full px-4 py-2 border rounded-lg">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Email') }}</label>
                            <input type="email" wire:model="email" class="w-full px-4 py-2 border rounded-lg">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Password') }}</label>
                            <input type="password" wire:model="password" class="w-full px-4 py-2 border rounded-lg">
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Confirm Password') }}</label>
                            <input type="password" wire:model="password_confirmation" class="w-full px-4 py-2 border rounded-lg">
                        </div>
                    </div>
                @endif

                <!-- Step 2: Professional Info -->
                @if ($step === 2)
                    <div>
                        <h3 class="text-xl font-semibold mb-4">{{ __('Professional Information') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Company Name') }} ({{ __('Optional') }})</label>
                            <input type="text" wire:model="company_name" class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Phone') }}</label>
                            <input type="tel" wire:model="phone" class="w-full px-4 py-2 border rounded-lg">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('WhatsApp') }} ({{ __('Optional') }})</label>
                            <input type="tel" wire:model="whatsapp" class="w-full px-4 py-2 border rounded-lg">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Address') }}</label>
                            <textarea wire:model="address" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 3: Identity Documents -->
                @if ($step === 3)
                    <div>
                        <h3 class="text-xl font-semibold mb-4">{{ __('Identity Documents') }}</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('ID Number') }} (CNIB, Passport, etc.)</label>
                            <input type="text" wire:model="identification_number" class="w-full px-4 py-2 border rounded-lg">
                            @error('identification_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Upload ID Document') }}</label>
                            <input type="file" wire:model="identification_document" class="w-full px-4 py-2 border rounded-lg">
                            @error('identification_document') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 4: Bank Account -->
                @if ($step === 4)
                    <div>
                        <h3 class="text-xl font-semibold mb-4">{{ __('Bank Account') }} ({{ __('Optional') }})</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">{{ __('Bank Account Number') }}</label>
                            <input type="text" wire:model="bank_account" class="w-full px-4 py-2 border rounded-lg">
                            <p class="text-sm text-gray-500 mt-1">{{ __('This information can be added later') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="flex justify-between mt-8">
                    @if ($step > 1)
                        <button type="button" wire:click="previousStep" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            {{ __('Previous') }}
                        </button>
                    @else
                        <div></div>
                    @endif

                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">
                        {{ $step === 4 ? __('Submit Application') : __('Next') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
