<div>
<div 
    x-data="{ sidebarOpen: @entangle('isOpen') }"
    class="bg-gradient-to-b from-gray-900 to-gray-800 text-white w-64 flex-shrink-0 hidden md:flex md:flex-col transition-all duration-300"
    :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
    
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-700">
        <div x-show="sidebarOpen" class="flex items-center space-x-2">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-xl font-bold">AfriLoc</span>
        </div>
        <svg x-show="!sidebarOpen" class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="px-3 space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.dashboard') }}</span>
            </a>

            <!-- Properties -->
            <a href="{{ route('admin.properties') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.properties') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.properties') }}</span>
            </a>

            <!-- Bookings -->
            <a href="{{ route('admin.bookings') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.bookings') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.bookings') }}</span>
            </a>

            <!-- Promoters -->
            <a href="{{ route('admin.promoters') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors relative
                      {{ request()->routeIs('admin.promoters') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.promoters') }}</span>
                @if($pendingPromotersCount > 0)
                    <span x-show="sidebarOpen" class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                        {{ $pendingPromotersCount }}
                    </span>
                @endif
            </a>

            <!-- Contacts - Désactivé (modèle supprimé) -->
            {{-- <a href="{{ route('admin.contacts') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.contacts') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.contacts') }}</span>
            </a> --}}

            <!-- Payments -->
            <a href="{{ route('admin.payments') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.payments') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.payments') }}</span>
            </a>

            <!-- Validations -->
            <a href="{{ route('admin.validations.index') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors relative
                      {{ request()->routeIs('admin.validations*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Validations</span>
                @php
                    $pendingValidations = \App\Models\DemandeValidation::where('statut', 'EN_ATTENTE')->count();
                @endphp
                @if($pendingValidations > 0)
                    <span x-show="sidebarOpen" class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                        {{ $pendingValidations }}
                    </span>
                @endif
            </a>

            <!-- Commissions -->
            <a href="{{ route('admin.commissions.index') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.commissions*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Commissions</span>
            </a>

            <!-- Clients -->
            <a href="{{ route('admin.clients.index') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.clients*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Clients</span>
            </a>

            <!-- Notifications -->
            <a href="{{ route('admin.notifications.index') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.notifications*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Notifications</span>
            </a>

            <!-- Settings -->
            <a href="{{ route('admin.settings') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.settings*') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">Paramètres</span>
            </a>

            <!-- Renewals - Désactivé (modèle supprimé) -->
            {{-- <a href="{{ route('admin.renewals') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors
                      {{ request()->routeIs('admin.renewals') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.renewals') }}</span>
            </a> --}}

            <!-- Maintenance - Désactivé (modèle supprimé) -->
            {{-- <a href="{{ route('admin.maintenance') }}" 
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors relative
                      {{ request()->routeIs('admin.maintenance') ? 'bg-primary text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-show="sidebarOpen" class="ml-3">{{ __('messages.admin.maintenance') }}</span>
                @if($urgentMaintenanceCount > 0)
                    <span x-show="sidebarOpen" class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">
                        {{ $urgentMaintenanceCount }}
                    </span>
                @endif
            </a> --}}
        </div>
    </nav>

    <!-- Footer -->
    <div class="p-4 border-t border-gray-700">
        <button 
            wire:click="toggleSidebar"
            class="w-full flex items-center justify-center px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
            <svg x-show="sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="!sidebarOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>
    </div>
</div>

<!-- Mobile Sidebar Toggle -->
<div class="md:hidden fixed bottom-4 right-4 z-50">
    <button 
        @click="$dispatch('toggle-mobile-menu')"
        class="bg-primary text-white p-3 rounded-full shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</div>
</div>

