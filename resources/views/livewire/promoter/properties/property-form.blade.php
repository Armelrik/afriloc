<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">{{ $propertyId ? __('Edit Property') : __('Add New Property') }}</h1>
        
        <form wire:submit.prevent="save" class="bg-white rounded-lg shadow p-8 space-y-6">
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Title (French)') }} *</label>
                    <input type="text" wire:model="title_fr" class="w-full px-4 py-2 border rounded-lg">
                    @error('title_fr') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Title (English)') }}</label>
                    <input type="text" wire:model="title_en" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Description (French)') }} *</label>
                    <textarea wire:model="description_fr" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                    @error('description_fr') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Description (English)') }}</label>
                    <textarea wire:model="description_en" rows="4" class="w-full px-4 py-2 border rounded-lg"></textarea>
                </div>
            </div>

            <!-- Property Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Type') }} *</label>
                    <select wire:model="type" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">{{ __('Select type') }}</option>
                        <option value="apartment">{{ __('Apartment') }}</option>
                        <option value="house">{{ __('House') }}</option>
                        <option value="villa">{{ __('Villa') }}</option>
                        <option value="studio">{{ __('Studio') }}</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Bedrooms') }} *</label>
                    <input type="number" wire:model="bedrooms" class="w-full px-4 py-2 border rounded-lg">
                    @error('bedrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Bathrooms') }} *</label>
                    <input type="number" wire:model="bathrooms" class="w-full px-4 py-2 border rounded-lg">
                    @error('bathrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Price') }} * (FCFA)</label>
                    <input type="number" wire:model="price" class="w-full px-4 py-2 border rounded-lg">
                    @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Rental Frequency') }} *</label>
                    <select wire:model="rental_frequency" class="w-full px-4 py-2 border rounded-lg">
                        <option value="daily">{{ __('Daily') }}</option>
                        <option value="weekly">{{ __('Weekly') }}</option>
                        <option value="monthly">{{ __('Monthly') }}</option>
                        <option value="yearly">{{ __('Yearly') }}</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Monthly Rent') }} (FCFA)</label>
                    <input type="number" wire:model="monthly_rent" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Deposit') }} (FCFA)</label>
                    <input type="number" wire:model="deposit_amount" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Advance Payment') }} (FCFA)</label>
                    <input type="number" wire:model="advance_payment" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>

            <!-- Location -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Location') }} *</label>
                    <input type="text" wire:model="location" class="w-full px-4 py-2 border rounded-lg">
                    @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Area') }} * (m²)</label>
                    <input type="number" wire:model="area" class="w-full px-4 py-2 border rounded-lg">
                    @error('area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">{{ __('Address') }} *</label>
                <textarea wire:model="address" rows="2" class="w-full px-4 py-2 border rounded-lg"></textarea>
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Options -->
            <div class="flex gap-6">
                <label class="flex items-center">
                    <input type="checkbox" wire:model="is_for_rent" class="mr-2">
                    {{ __('Available for Rent') }}
                </label>
                <label class="flex items-center">
                    <input type="checkbox" wire:model="is_for_sale" class="mr-2">
                    {{ __('Available for Sale') }}
                </label>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('promoter.properties') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">
                    {{ $propertyId ? __('Update Property') : __('Create Property') }}
                </button>
            </div>
        </form>
    </div>
</div>
