@php use Illuminate\Support\Facades\Storage; @endphp
<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ __('messages.client.my_bookings') }}</h1>
            <p class="text-gray-600">{{ __('messages.client.bookings_subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('statusFilter', 'all')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.common.all') }}
                </button>
                <button wire:click="$set('statusFilter', 'pending')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.pending') }}
                </button>
                <button wire:click="$set('statusFilter', 'confirmed')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.confirmed') }}
                </button>
                <button wire:click="$set('statusFilter', 'active')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'active' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.active') }}
                </button>
                <button wire:click="$set('statusFilter', 'completed')" 
                        class="px-4 py-2 rounded-lg {{ $statusFilter === 'completed' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    {{ __('messages.booking.status.completed') }}
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
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row gap-4">
                                {{-- Property Image --}}
                                @if($booking->bien->medias && $booking->bien->medias->where('type_media', 'IMAGE')->count() > 0)
                                    @php
                                        $image = $booking->bien->medias->where('type_media', 'IMAGE')->first();
                                    @endphp
                                    <img src="{{ Storage::url($image->url_media) }}" 
                                         alt="{{ $booking->bien->titre }}" 
                                         class="w-full md:w-48 h-48 object-cover rounded-lg">
                                @endif

                                {{-- Booking Details --}}
                                <div class="flex-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-xl font-bold mb-1">
                                                {{ $booking->bien->titre }}
                                            </h3>
                                            <p class="text-gray-600 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $booking->bien->ville }}@if($booking->bien->quartier), {{ $booking->bien->quartier }}@endif
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $booking->statut == 'CONFIRME' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $booking->statut == 'EN_ATTENTE' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $booking->statut == 'TERMINE' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $booking->statut == 'ANNULE' ? 'bg-red-100 text-red-800' : '' }}">
                                            @switch($booking->statut)
                                                @case('EN_ATTENTE')
                                                    En attente
                                                    @break
                                                @case('CONFIRME')
                                                    Confirmée
                                                    @break
                                                @case('TERMINE')
                                                    Terminée
                                                    @break
                                                @case('ANNULE')
                                                    Annulée
                                                    @break
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Date de début</p>
                                            <p class="font-semibold">{{ $booking->date_debut->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Date de fin</p>
                                            <p class="font-semibold">{{ $booking->date_fin->format('d/m/Y') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Durée</p>
                                            <p class="font-semibold">{{ $booking->date_debut->diffInDays($booking->date_fin) }} jours</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Montant total</p>
                                            <p class="font-bold text-primary">{{ number_format($booking->montant_total, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                    </div>

                                    {{-- Payment Status --}}
                                    <div class="mb-4">
                                        @if($booking->paiement)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Payée
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                En attente de paiement
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex gap-2">
                                        <a href="{{ route('properties.show', $booking->bien_id) }}" 
                                           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                            Voir la propriété
                                        </a>
                                        @if(!$booking->paiement)
                                            <a href="{{ route('payment.show', $booking->id) }}" 
                                               class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                                                Payer maintenant
                                            </a>
                                        @endif
                                        @if($booking->statut === 'EN_ATTENTE')
                                            <button wire:click="cancelBooking({{ $booking->id }})" 
                                                    wire:confirm="Êtes-vous sûr de vouloir annuler cette réservation ?"
                                                    class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                                                Annuler
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune réservation</h3>
                <p class="text-gray-500 mb-6">Vous n'avez pas encore fait de réservation.</p>
                <a href="{{ route('properties.index') }}" 
                   class="inline-block px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                    Parcourir les propriétés
                </a>
            </div>
        @endif
    </div>

    @livewire('components.footer')
</div>

