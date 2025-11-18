<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <h1 class="text-4xl font-bold mb-8">{{ __('messages.properties.title') }}</h1>

        {{-- Filters --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.properties.search') }}</label>
                    <input type="text" wire:model.live="search" placeholder="{{ __('messages.properties.search_placeholder') }}" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.properties.type') }}</label>
                    <select wire:model.live="typeFilter" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                        <option value="">{{ __('messages.properties.all_types') }}</option>
                        <option value="house">{{ __('messages.properties.house') }}</option>
                        <option value="apartment">{{ __('messages.properties.apartment') }}</option>
                        <option value="land">{{ __('messages.properties.land') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.properties.min_price') }}</label>
                    <input type="number" wire:model.live="minPrice" placeholder="Min" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.properties.max_price') }}</label>
                    <input type="number" wire:model.live="maxPrice" placeholder="Max" 
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
                </div>
            </div>
        </div>

        {{-- Properties Grid --}}
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($properties as $property)
                    @livewire('components.property-card', ['property' => $property], key($property->id))
                @endforeach
            </div>

            <div class="mt-8">
                {{ $properties->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <p class="text-xl text-gray-500">{{ __('messages.properties.no_results') }}</p>
            </div>
        @endif
    </div>

    @livewire('components.footer')
</div>
