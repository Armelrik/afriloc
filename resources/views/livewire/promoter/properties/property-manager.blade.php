<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">{{ __('My Properties') }}</h1>
            <a href="{{ route('promoter.properties.create') }}" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">
                {{ __('Add New Property') }}
            </a>
        </div>
        
        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" wire:model.live="search" placeholder="{{ __('Search properties...') }}" 
                           class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <select wire:model.live="filterStatus" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="available">{{ __('Available') }}</option>
                        <option value="rented">{{ __('Rented') }}</option>
                        <option value="sold">{{ __('Sold') }}</option>
                        <option value="maintenance">{{ __('Maintenance') }}</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Properties List -->
        <div class="space-y-4">
            @forelse ($properties as $property)
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2">{{ $property->title_fr }}</h3>
                            <p class="text-gray-600 mb-2">{{ Str::limit($property->description_fr, 150) }}</p>
                            <div class="flex gap-4 text-sm text-gray-500">
                                <span>{{ $property->type }}</span>
                                <span>{{ $property->bedrooms }} {{ __('beds') }}</span>
                                <span>{{ number_format($property->price, 0) }} FCFA</span>
                            </div>
                            <div class="mt-2">
                                <span class="px-3 py-1 text-xs rounded-full 
                                    {{ $property->availability_status === 'available' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($property->availability_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('promoter.properties.edit', $property->id) }}" 
                               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                {{ __('Edit') }}
                            </a>
                            <button wire:click="deleteProperty({{ $property->id }})" 
                                    wire:confirm="{{ __('Are you sure you want to delete this property?') }}"
                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                {{ __('Delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <p class="text-gray-500 mb-4">{{ __('No properties yet') }}</p>
                    <a href="{{ route('promoter.properties.create') }}" class="inline-block px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600">
                        {{ __('Add Your First Property') }}
                    </a>
                </div>
            @endforelse
        </div>
        
        <div class="mt-6">
            {{ $properties->links() }}
        </div>
    </div>
</div>
