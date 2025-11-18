<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 cursor-pointer" 
     onclick="window.location.href='/properties/{{ $property->id }}'">
    <div class="relative h-64 overflow-hidden">
        @if($property->images && count($property->images) > 0)
            <img src="{{ asset('images/' . basename($property->images[0])) }}" alt="{{ $property->title_en }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
        @else
            <div class="w-full h-full bg-gray-300 flex items-center justify-center">
                <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
        @endif
        @if($property->featured)
            <div class="absolute top-4 right-4 bg-accent text-white px-3 py-1 rounded-full text-sm font-semibold">
                {{ __('messages.properties.featured') }}
            </div>
        @endif
        <div class="absolute top-4 left-4 bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold capitalize">
            {{ $property->type }}
        </div>
    </div>
    
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-2">
            {{ app()->getLocale() == 'fr' ? $property->title_fr : $property->title_en }}
        </h3>
        
        <p class="text-gray-600 mb-4 line-clamp-2">
            {{ app()->getLocale() == 'fr' ? $property->description_fr : $property->description_en }}
        </p>
        
        <div class="flex items-center text-gray-600 mb-4">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-sm">{{ $property->location }}</span>
        </div>
        
        @if($property->bedrooms || $property->bathrooms || $property->area)
            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                @if($property->bedrooms)
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>{{ $property->bedrooms }} {{ __('messages.properties.bedrooms') }}</span>
                    </div>
                @endif
                @if($property->bathrooms)
                    <div class="flex items-center">
                        <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $property->bathrooms }} {{ __('messages.properties.bathrooms') }}</span>
                    </div>
                @endif
                @if($property->area)
                    <div class="flex items-center">
                        <span>{{ $property->area }} m²</span>
                    </div>
                @endif
            </div>
        @endif
        
        <div class="flex items-center justify-between pt-4 border-t">
            <div class="text-2xl font-bold text-primary">
                {{ number_format($property->price, 0, ',', ' ') }} FCFA
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $property->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ __(  'messages.properties.status.' . $property->status) }}
            </span>
        </div>
    </div>
</div>
