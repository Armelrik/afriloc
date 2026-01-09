<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="max-w-6xl mx-auto">
            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Success Modal -->
            @if($showSuccessModal)
                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>

                        <!-- Center modal -->
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                        <!-- Modal panel -->
                        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <!-- Success Icon -->
                                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                                    <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>

                                <!-- Content -->
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modal-title">
                                        Réservation Envoyée !
                                    </h3>
                                    <div class="mt-4">
                                        <p class="text-base text-gray-600">
                                            Votre demande de réservation a été envoyée avec succès.
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            Le propriétaire recevra une notification et vous répondra dans les plus brefs délais.
                                        </p>
                                    </div>

                                    <!-- Reservation Details -->
                                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Propriété :</span>
                                                <span class="font-semibold text-gray-900">{{ $property->titre }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Période :</span>
                                                <span class="font-semibold text-gray-900">
                                                    {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Montant total :</span>
                                                <span class="font-bold text-primary text-lg">{{ number_format($calculatedCosts['total_due'], 0, ',', ' ') }} FCFA</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Statut :</span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    En attente
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-6 sm:mt-8 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                <button 
                                    type="button" 
                                    wire:click="viewReservation"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-3 bg-primary text-base font-medium text-white hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:col-start-2 sm:text-sm transition-colors"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Voir ma réservation
                                </button>
                                <button 
                                    type="button" 
                                    wire:click="closeModal"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 sm:col-start-1 sm:text-sm transition-colors"
                                >
                                    Fermer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-primary to-primary-600 text-white px-8 py-6">
                    <h2 class="text-3xl font-bold">Réservation</h2>
                    <p class="text-primary-100 mt-2">{{ $property->titre }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                            {{ ucfirst($property->type_bien) }}
                        </span>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm">
                            @switch($property->frequence_location)
                                @case('quotidien')
                                    Location journalière
                                    @break
                                @case('hebdomadaire')
                                    Location hebdomadaire
                                    @break
                                @case('mensuel')
                                    Location mensuelle
                                    @break
                                @case('annuel')
                                    Location annuelle
                                    @break
                            @endswitch
                        </span>
                    </div>
                </div>
                
                <form wire:submit.prevent="submit" class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Form Fields -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Customer Information -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Vos informations
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nom complet <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            wire:model="customer_name" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                            placeholder="Jean Dupont"
                                        >
                                        @error('customer_name') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="email" 
                                            wire:model="customer_email" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                            placeholder="email@example.com"
                                        >
                                        @error('customer_email') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Téléphone <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="tel" 
                                            wire:model="customer_phone" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                            placeholder="+226 XX XX XX XX"
                                        >
                                        @error('customer_phone') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nombre de personnes <span class="text-red-500">*</span>
                                        </label>
                                        <input 
                                            type="number" 
                                            wire:model="num_people" 
                                            min="1" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                        >
                                        @error('num_people') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Booking Details - Dynamic based on frequency -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-xl font-semibold mb-6 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Détails de la réservation
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Duration Field -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            @switch($property->frequence_location)
                                                @case('quotidien')
                                                    Nombre de jours <span class="text-red-500">*</span>
                                                    @break
                                                @case('hebdomadaire')
                                                    Nombre de semaines <span class="text-red-500">*</span>
                                                    @break
                                                @case('mensuel')
                                                    Nombre de mois <span class="text-red-500">*</span>
                                                    @break
                                                @case('annuel')
                                                    Nombre d'années <span class="text-red-500">*</span>
                                                    @break
                                            @endswitch
                                        </label>
                                        <input 
                                            type="number" 
                                            wire:model.live="rental_duration" 
                                            min="1" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                        >
                                        @error('rental_duration') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Start Date - Only for daily/weekly rentals -->
                                    @if(in_array($property->frequence_location, ['quotidien', 'hebdomadaire']))
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Date d'arrivée <span class="text-red-500">*</span>
                                            </label>
                                            <input 
                                                type="date" 
                                                wire:model.live="start_date" 
                                                min="{{ $minDate }}"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                            >
                                            @error('start_date') 
                                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                            @enderror
                                        </div>
                                    @endif

                                    <!-- Calculated Dates Display -->
                                    <div class="md:col-span-2 bg-blue-50 border border-blue-200 rounded-lg p-4 mt-2">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-600 font-medium">Date de début :</span>
                                                <span class="ml-2 text-gray-900 font-semibold">
                                                    @if($start_date)
                                                        {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
                                                    @else
                                                        Non définie
                                                    @endif
                                                </span>
                                                @if(in_array($property->frequence_location, ['mensuel', 'annuel']))
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        Après validation par le propriétaire
                                                    </p>
                                                @endif
                                            </div>
                                            <div>
                                                <span class="text-gray-600 font-medium">Date de fin :</span>
                                                <span class="ml-2 text-gray-900 font-semibold">
                                                    @if($end_date)
                                                        {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                                                    @else
                                                        Non définie
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Comments -->
                                    <div class="md:col-span-2 mt-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Commentaires ou demandes spéciales
                                        </label>
                                        <textarea 
                                            wire:model="comments" 
                                            rows="4" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition" 
                                            placeholder="Précisez vos besoins particuliers, horaire d'arrivée souhaité, etc."
                                        ></textarea>
                                        @error('comments') 
                                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Cost Summary -->
                        <div class="lg:col-span-1">
                            @if (!empty($calculatedCosts))
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 sticky top-4 border border-gray-200">
                                    <h3 class="text-xl font-semibold mb-6 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        Résumé des coûts
                                    </h3>
                                    
                                    <div class="space-y-4">
                                        <!-- Payment Breakdown -->
                                        <div class="bg-white rounded-lg p-4 space-y-3">
                                            <!-- Total Rent -->
                                            @if (isset($calculatedCosts['total_rent']) && $calculatedCosts['total_rent'] > 0)
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-900">Loyer total</span>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            {{ number_format($calculatedCosts['base_rent'], 0, ',', ' ') }} FCFA × {{ $rental_duration }}
                                                            @switch($property->frequence_location)
                                                                @case('quotidien')
                                                                    jour(s)
                                                                    @break
                                                                @case('hebdomadaire')
                                                                    semaine(s)
                                                                    @break
                                                                @case('mensuel')
                                                                    mois
                                                                    @break
                                                                @case('annuel')
                                                                    an(s)
                                                                    @break
                                                            @endswitch
                                                        </div>
                                                    </div>
                                                    <span class="font-semibold text-gray-900">{{ number_format($calculatedCosts['total_rent'], 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                <div class="border-t border-gray-200"></div>
                                            @endif

                                            <!-- Deposit -->
                                            @if (isset($calculatedCosts['deposit']) && $calculatedCosts['deposit'] > 0)
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-900">Caution</span>
                                                        <div class="text-xs text-gray-500 mt-1">Remboursable en fin de bail</div>
                                                    </div>
                                                    <span class="font-semibold text-gray-900">{{ number_format($calculatedCosts['deposit'], 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                <div class="border-t border-gray-200"></div>
                                            @endif

                                            <!-- Platform Commission -->
                                            @if (isset($calculatedCosts['platform_commission']) && $calculatedCosts['platform_commission'] > 0)
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-900">Commission plateforme</span>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            Frais de service (1 
                                                            @switch($property->frequence_location)
                                                                @case('quotidien')
                                                                    jour
                                                                    @break
                                                                @case('hebdomadaire')
                                                                    semaine
                                                                    @break
                                                                @case('mensuel')
                                                                    mois
                                                                    @break
                                                                @case('annuel')
                                                                    année
                                                                    @break
                                                            @endswitch)
                                                        </div>
                                                    </div>
                                                    <span class="font-semibold text-gray-900">{{ number_format($calculatedCosts['platform_commission'], 0, ',', ' ') }} FCFA</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Total Section -->
                                        @if(isset($calculatedCosts['total_due']))
                                            <div class="bg-gradient-to-r from-primary to-primary-600 text-white rounded-lg p-5 shadow-lg">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <span class="text-sm text-primary-100">Total à payer</span>
                                                        <div class="text-2xl font-bold mt-1">{{ number_format($calculatedCosts['total_due'], 0, ',', ' ') }} FCFA</div>
                                                    </div>
                                                    <svg class="w-12 h-12 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Additional Info -->
                                        @if(isset($calculatedCosts['base_rent']))
                                            <div class="bg-white rounded-lg p-4 space-y-2 text-xs text-gray-600">
                                                <div class="flex justify-between">
                                                    <span>Loyer unitaire</span>
                                                    <span class="font-semibold">{{ number_format($calculatedCosts['base_rent'], 0, ',', ' ') }} FCFA</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>Durée de la location</span>
                                                    <span class="font-semibold">{{ $rental_duration }} 
                                                        @switch($property->frequence_location)
                                                            @case('quotidien')
                                                                jour(s)
                                                                @break
                                                            @case('hebdomadaire')
                                                                semaine(s)
                                                                @break
                                                            @case('mensuel')
                                                                mois
                                                                @break
                                                            @case('annuel')
                                                                an(s)
                                                                @break
                                                        @endswitch
                                                    </span>
                                                </div>
                                                @if(isset($calculatedCosts['promoter_amount']))
                                                    <div class="border-t pt-2 mt-2">
                                                        <div class="flex justify-between text-green-700">
                                                            <span>Montant pour le propriétaire</span>
                                                            <span class="font-semibold">{{ number_format($calculatedCosts['promoter_amount'], 0, ',', ' ') }} FCFA</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Info Box -->
                                    <div class="mt-6 bg-blue-50 border-l-4 border-primary rounded p-4">
                                        <div class="flex">
                                            <svg class="w-5 h-5 text-primary mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div class="text-xs text-gray-700">
                                                <p class="font-semibold mb-2">À savoir :</p>
                                                <ul class="space-y-1 list-disc list-inside">
                                                    <li>Votre réservation sera confirmée par le propriétaire</li>
                                                    <li>La caution vous sera remboursée en fin de bail</li>
                                                    <li>La commission (1 
                                                        @switch($property->frequence_location)
                                                            @case('quotidien')
                                                                jour
                                                                @break
                                                            @case('hebdomadaire')
                                                                semaine
                                                                @break
                                                            @case('mensuel')
                                                                mois
                                                                @break
                                                            @case('annuel')
                                                                année
                                                                @break
                                                        @endswitch
                                                    ) est prélevée une seule fois</li>
                                                    <li>Un reçu vous sera envoyé par email</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('properties.show', $propertyId) }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                            Annuler
                        </a>
                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center gap-2"
                        >
                            <svg wire:loading.remove class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <svg wire:loading class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Envoyer la demande</span>
                            <span wire:loading>Envoi en cours...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @livewire('components.footer')
</div>