<div class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center justify-between px-6">
    <!-- Left Side - Page Title / Breadcrumb -->
    <div class="flex items-center">
        <h1 class="text-xl font-semibold text-gray-800">
            @if(request()->routeIs('admin.dashboard'))
                {{ __('messages.admin.dashboard') }}
            @elseif(request()->routeIs('admin.properties'))
                {{ __('messages.admin.properties') }}
            @elseif(request()->routeIs('admin.bookings'))
                {{ __('messages.admin.bookings') }}
            @elseif(request()->routeIs('admin.promoters'))
                {{ __('messages.admin.promoters') }}
            @elseif(request()->routeIs('admin.contacts'))
                {{ __('messages.admin.contacts') }}
            @elseif(request()->routeIs('admin.payments'))
                {{ __('messages.admin.payments') }}
            @elseif(request()->routeIs('admin.renewals'))
                {{ __('messages.admin.renewals') }}
            @elseif(request()->routeIs('admin.maintenance'))
                {{ __('messages.admin.maintenance') }}
            @else
                {{ __('messages.admin.admin_panel') }}
            @endif
        </h1>
    </div>

    <!-- Right Side - Actions -->
    <div class="flex items-center space-x-4">
        <!-- Language Switcher -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-1 text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                </svg>
                <span class="text-sm font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" 
                 @click.away="open = !open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-32 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                <button wire:click="changeLanguage('fr')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <span class="mr-2">🇫🇷</span> Français
                </button>
                <button wire:click="changeLanguage('en')" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <span class="mr-2">🇬🇧</span> English
                </button>
            </div>
        </div>

        <!-- Notifications -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                @endif
            </button>

            <div x-show="open" 
                 @click.away="open = !open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-900">{{ __('messages.admin.notifications') }}</h3>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:text-blue-800">
                            Tout marquer comme lu
                        </button>
                    @endif
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @forelse($notifications ?? [] as $notification)
                        <a href="#" 
                           wire:click="markAsRead({{ $notification->id }})"
                           class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 transition-colors">
                            <div class="flex items-start">
                                @php
                                    $iconClass = match($notification->type) {
                                        'VALIDATION' => 'fas fa-check-circle text-green-500',
                                        'RESERVATION' => 'fas fa-calendar-check text-blue-500',
                                        'PAIEMENT' => 'fas fa-dollar-sign text-yellow-500',
                                        'REJET' => 'fas fa-times-circle text-red-500',
                                        default => 'fas fa-bell text-gray-500',
                                    };
                                @endphp
                                <i class="{{ $iconClass }} mr-3 mt-1"></i>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($notification->contenu, 60) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $notification->date_envoi ? $notification->date_envoi->diffForHumans() : '' }}
                                        @if($notification->priorite === 'URGENTE')
                                            <span class="ml-2 text-red-600 font-semibold">Urgent</span>
                                        @elseif($notification->priorite === 'HAUTE')
                                            <span class="ml-2 text-orange-600">Haute</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-gray-500 text-sm">
                            <i class="far fa-bell fa-2x mb-2 text-gray-300"></i>
                            <p>{{ __('messages.admin.no_notifications') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- User Menu -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-100 transition-colors">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary to-accent rounded-full flex items-center justify-center">
                        <span class="text-white text-sm font-semibold">{{ strtoupper(substr($user->nom ?? $user->name ?? 'A', 0, 1) . substr($user->prenom ?? $user->name ?? 'D', 0, 1)) }}</span>
                    </div>
                    <div class="hidden md:block text-left">
                        <div class="text-sm font-medium text-gray-900">{{ ($user->nom ?? '') . ' ' . ($user->prenom ?? '') ?: $user->name }}</div>
                        <div class="text-xs text-gray-500">{{ __('messages.admin.administrator') }}</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-show="open" 
                 @click.away="open = !open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                <div class="px-4 py-3 border-b border-gray-200">
                    <p class="text-sm font-medium text-gray-900">{{ ($user->nom ?? '') . ' ' . ($user->prenom ?? '') ?: $user->name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                </div>
                
                <a href="/" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    {{ __('messages.admin.view_site') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        {{ __('messages.nav.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
