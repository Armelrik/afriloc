<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ __('messages.client.maintenance_requests') }}</h1>
                <p class="text-gray-600">{{ __('messages.client.maintenance_subtitle') }}</p>
            </div>
            <button wire:click="toggleCreateForm" 
                    class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-semibold">
                {{ $showCreateForm ? __('messages.common.cancel') : __('messages.maintenance.create_request') }}
            </button>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Create Form --}}
        @if($showCreateForm)
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold mb-6">{{ __('messages.maintenance.new_request') }}</h2>
                
                <form wire:submit.prevent="submitRequest" class="space-y-6">
                    {{-- Property Selection --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.maintenance.select_property') }} <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="booking_id" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">{{ __('messages.common.select') }}</option>
                            @foreach($activeBookings as $booking)
                                <option value="{{ $booking->id }}">
                                    {{ app()->getLocale() == 'fr' ? $booking->property->title_fr : $booking->property->title_en }} 
                                    - {{ $booking->property->location }}
                                </option>
                            @endforeach
                        </select>
                        @error('booking_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.maintenance.title') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="title" 
                               class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                               placeholder="{{ __('messages.maintenance.title_placeholder') }}">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Priority --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.maintenance.priority') }} <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="priority" class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="low">{{ __('messages.maintenance.priority_low') }}</option>
                            <option value="normal">{{ __('messages.maintenance.priority_normal') }}</option>
                            <option value="high">{{ __('messages.maintenance.priority_high') }}</option>
                            <option value="urgent">{{ __('messages.maintenance.priority_urgent') }}</option>
                        </select>
                        @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.maintenance.description') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="description" rows="4"
                                  class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                  placeholder="{{ __('messages.maintenance.description_placeholder') }}"></textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-semibold">
                            {{ __('messages.maintenance.submit_request') }}
                        </button>
                    </div>
                </form>
            </div>
        @endif

        {{-- Maintenance Requests List --}}
        @if($maintenanceRequests->count() > 0)
            <div class="space-y-4">
                @foreach($maintenanceRequests as $request)
                    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 
                        {{ $request->priority == 'urgent' ? 'border-red-500' : '' }}
                        {{ $request->priority == 'high' ? 'border-orange-500' : '' }}
                        {{ $request->priority == 'normal' ? 'border-blue-500' : '' }}
                        {{ $request->priority == 'low' ? 'border-gray-500' : '' }}">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold mb-1">{{ $request->title }}</h3>
                                <p class="text-gray-600 text-sm">
                                    {{ app()->getLocale() == 'fr' ? $request->booking->property->title_fr : $request->booking->property->title_en }}
                                    - {{ $request->booking->property->location }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $request->status == 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $request->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $request->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $request->status == 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ __('messages.maintenance.status.' . $request->status) }}
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $request->priority == 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $request->priority == 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $request->priority == 'normal' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $request->priority == 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ __('messages.maintenance.priority_' . $request->priority) }}
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4">{{ $request->description }}</p>

                        @if($request->resolution_notes)
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                <p class="text-sm font-semibold text-green-800 mb-1">{{ __('messages.maintenance.resolution') }}</p>
                                <p class="text-sm text-green-700">{{ $request->resolution_notes }}</p>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-sm text-gray-500">
                            <span>{{ __('messages.common.created') }}: {{ $request->created_at->format('d/m/Y H:i') }}</span>
                            @if($request->resolved_at)
                                <span>{{ __('messages.maintenance.resolved') }}: {{ $request->resolved_at->format('d/m/Y H:i') }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $maintenanceRequests->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.client.no_maintenance') }}</h3>
                <p class="text-gray-500 mb-6">{{ __('messages.client.no_maintenance_description') }}</p>
            </div>
        @endif
    </div>

    @livewire('components.footer')
</div>

