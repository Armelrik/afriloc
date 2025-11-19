<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <h1 class="text-3xl font-bold mb-8">{{ __('messages.client.dashboard') }}</h1>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Active Bookings --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.client.active_bookings') }}</p>
                        <p class="text-3xl font-bold text-primary">{{ $stats['active_bookings'] }}</p>
                    </div>
                    <svg class="w-12 h-12 text-primary opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
            </div>

            {{-- Pending Payments --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.client.pending_payments') }}</p>
                        <p class="text-3xl font-bold text-orange-500">{{ $stats['pending_payments'] }}</p>
                    </div>
                    <svg class="w-12 h-12 text-orange-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Maintenance Requests --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.client.maintenance_requests') }}</p>
                        <p class="text-3xl font-bold text-blue-500">{{ $stats['maintenance_requests'] }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Unread Messages --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.client.unread_messages') }}</p>
                        <p class="text-3xl font-bold text-green-500">{{ $unreadMessages }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-500 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Recent Bookings --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">{{ __('messages.client.recent_bookings') }}</h2>
                        <a href="{{ route('client.bookings') }}" class="text-primary hover:text-primary-600">
                            {{ __('messages.common.view_all') }} →
                        </a>
                    </div>

                    @if($recentBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentBookings as $booking)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-all">
                                    <div class="flex items-start gap-4">
                                        @if($booking->property->images && count($booking->property->images) > 0)
                                            <img src="{{ asset('images/' . basename($booking->property->images[0])) }}" 
                                                 alt="{{ $booking->property->title_en }}" 
                                                 class="w-20 h-20 object-cover rounded-lg">
                                        @endif
                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }}</h3>
                                            <p class="text-sm text-gray-600">{{ $booking->property->location }}</p>
                                            <div class="flex gap-4 mt-2 text-sm">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                                    {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                                    {{ __('messages.booking.status.' . $booking->status) }}
                                                </span>
                                                <span class="text-gray-600">
                                                    {{ $booking->start_date->format('d/m/Y') }} - {{ $booking->end_date->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-primary">{{ number_format($booking->total_amount, 0, ',', ' ') }} FCFA</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">{{ __('messages.client.no_bookings') }}</p>
                    @endif
                </div>

                {{-- Recent Maintenance Requests --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">{{ __('messages.client.maintenance_history') }}</h2>
                        <a href="{{ route('client.maintenance.index') }}" class="text-primary hover:text-primary-600">
                            {{ __('messages.common.view_all') }} →
                        </a>
                    </div>

                    @if($recentMaintenanceRequests->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentMaintenanceRequests as $request)
                                <div class="border-l-4 {{ $request->priority == 'urgent' ? 'border-red-500' : 'border-blue-500' }} pl-4 py-2">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold">{{ $request->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $request->property->location }}</p>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $request->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ __('messages.maintenance.status.' . $request->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">{{ __('messages.client.no_maintenance') }}</p>
                    @endif
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Upcoming Renewals --}}
                <div class="bg-gradient-to-br from-primary to-accent text-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4">{{ __('messages.client.upcoming_renewals') }}</h3>
                    
                    @if($upcomingRenewals->count() > 0)
                        <div class="space-y-3">
                            @foreach($upcomingRenewals as $renewal)
                                <div class="bg-white/10 backdrop-blur-md rounded-lg p-3">
                                    <p class="font-semibold text-sm">{{ app()->getLocale() == 'fr' ? $renewal->property->title_fr : $renewal->property->title_en }}</p>
                                    <p class="text-xs opacity-90">{{ __('messages.renewal.expires') }}: {{ $renewal->current_end_date->format('d/m/Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-white/80 text-sm">{{ __('messages.client.no_renewals') }}</p>
                    @endif
                </div>

                {{-- Pending Payments --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4">{{ __('messages.client.pending_payments_title') }}</h3>
                    
                    @if($pendingPayments->count() > 0)
                        <div class="space-y-3">
                            @foreach($pendingPayments as $payment)
                                <div class="border rounded-lg p-3">
                                    <p class="font-semibold text-sm">{{ number_format($payment->amount, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-xs text-gray-600">{{ $payment->booking->property->location }}</p>
                                    <a href="{{ route('payment.show', $payment->booking_id) }}" class="text-xs text-primary hover:underline">
                                        {{ __('messages.payment.pay_now') }} →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">{{ __('messages.client.no_pending_payments') }}</p>
                    @endif
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h3 class="text-lg font-bold mb-4">{{ __('messages.client.quick_actions') }}</h3>
                    <div class="space-y-2">
                        <a href="{{ route('properties.index') }}" class="block w-full px-4 py-2 bg-primary text-white text-center rounded-lg hover:bg-primary-600 transition-colors">
                            {{ __('messages.client.browse_properties') }}
                        </a>
                        <a href="{{ route('client.maintenance.create') }}" class="block w-full px-4 py-2 border-2 border-primary text-primary text-center rounded-lg hover:bg-primary hover:text-white transition-colors">
                            {{ __('messages.client.submit_maintenance') }}
                        </a>
                        <a href="{{ route('client.messages') }}" class="block w-full px-4 py-2 border-2 border-gray-300 text-gray-700 text-center rounded-lg hover:bg-gray-100 transition-colors">
                            {{ __('messages.client.view_messages') }}
                            @if($unreadMessages > 0)
                                <span class="ml-2 px-2 py-1 bg-red-500 text-white text-xs rounded-full">{{ $unreadMessages }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.footer')
</div>
