<div>
    @livewire('components.header')

    <div class="min-h-screen bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold mb-2">{{ __('messages.promoter.manage_maintenance') }}</h1>
                <p class="text-gray-600">{{ __('messages.promoter.maintenance_subtitle') }}</p>
            </div>

            {{-- Urgent Alert --}}
            @if($urgentCount > 0)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">{{ __('messages.promoter.urgent_requests') }}</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>{{ $urgentCount }} {{ __('messages.promoter.urgent_maintenance_pending') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Success Message --}}
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filters --}}
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.common.status') }}</label>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="$set('statusFilter', 'all')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $statusFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.common.all') }}
                            </button>
                            <button wire:click="$set('statusFilter', 'pending')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $statusFilter === 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.status.pending') }}
                            </button>
                            <button wire:click="$set('statusFilter', 'in_progress')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $statusFilter === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.status.in_progress') }}
                            </button>
                            <button wire:click="$set('statusFilter', 'completed')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $statusFilter === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.status.completed') }}
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.maintenance.priority') }}</label>
                        <div class="flex flex-wrap gap-2">
                            <button wire:click="$set('priorityFilter', 'all')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $priorityFilter === 'all' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.common.all') }}
                            </button>
                            <button wire:click="$set('priorityFilter', 'urgent')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $priorityFilter === 'urgent' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.priority_urgent') }}
                            </button>
                            <button wire:click="$set('priorityFilter', 'high')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $priorityFilter === 'high' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.priority_high') }}
                            </button>
                            <button wire:click="$set('priorityFilter', 'normal')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $priorityFilter === 'normal' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.priority_normal') }}
                            </button>
                            <button wire:click="$set('priorityFilter', 'low')" 
                                    class="px-3 py-1 rounded-lg text-sm font-medium {{ $priorityFilter === 'low' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ __('messages.maintenance.priority_low') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

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
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $request->title }}</h3>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $request->priority == 'urgent' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $request->priority == 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $request->priority == 'normal' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $request->priority == 'low' ? 'bg-gray-100 text-gray-800' : '' }}">
                                            {{ __('messages.maintenance.priority_' . $request->priority) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600">
                                        {{ app()->getLocale() == 'fr' ? $request->property->title_fr : $request->property->title_en }} - 
                                        {{ $request->property->location }}
                                    </p>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ __('messages.promoter.client') }}: {{ $request->user->name }} ({{ $request->user->email }})
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold ml-4
                                    {{ $request->status == 'pending' ? 'bg-orange-100 text-orange-800' : '' }}
                                    {{ $request->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $request->status == 'completed' ? 'bg-green-100 text-green-800' : '' }}">
                                    {{ __('messages.maintenance.status.' . $request->status) }}
                                </span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <p class="text-gray-700">{{ $request->description }}</p>
                            </div>

                            @if($request->response)
                                <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                    <p class="text-sm font-semibold text-blue-800 mb-1">{{ __('messages.promoter.response') }}</p>
                                    <p class="text-sm text-blue-700">{{ $request->response }}</p>
                                    @if($request->responded_at)
                                        <p class="text-xs text-blue-600 mt-2">{{ $request->responded_at->format('d/m/Y H:i') }}</p>
                                    @endif
                                </div>
                            @endif

                            {{-- Actions --}}
                            <div class="flex flex-wrap gap-2">
                                @if($request->status === 'pending')
                                    <button wire:click="markInProgress({{ $request->id }})" 
                                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                                        {{ __('messages.promoter.actions.mark_in_progress') }}
                                    </button>
                                @endif
                                
                                @if($request->status !== 'completed')
                                    <button wire:click="openRespondModal({{ $request->id }})" 
                                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-medium">
                                        {{ $request->response ? __('messages.promoter.actions.update_response') : __('messages.promoter.actions.add_response') }}
                                    </button>
                                    
                                    <button wire:click="openCompleteModal({{ $request->id }})" 
                                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-medium">
                                        {{ __('messages.promoter.actions.mark_completed') }}
                                    </button>
                                @endif
                            </div>

                            <div class="text-xs text-gray-500 mt-4">
                                {{ __('messages.common.created') }}: {{ $request->created_at->format('d/m/Y H:i') }}
                                @if($request->completed_at)
                                    | {{ __('messages.maintenance.completed_at') }}: {{ $request->completed_at->format('d/m/Y H:i') }}
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
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">{{ __('messages.promoter.no_maintenance') }}</h3>
                    <p class="text-gray-500">{{ __('messages.promoter.no_maintenance_description') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Respond Modal --}}
    @if($showRespondModal && $selectedRequest)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeRespondModal"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6 z-50">
                    <button type="button" wire:click="closeRespondModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.promoter.add_response_title') }}</h3>
                    
                    <div class="mb-4 bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $selectedRequest->title }}</h4>
                        <p class="text-sm text-gray-700">{{ $selectedRequest->description }}</p>
                    </div>
                    
                    <form wire:submit.prevent="addResponse">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.promoter.response') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="response" rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                      placeholder="{{ __('messages.promoter.response_placeholder') }}"></textarea>
                            @error('response') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" wire:click="closeRespondModal"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                {{ __('messages.common.cancel') }}
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors">
                                {{ __('messages.common.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Complete Modal --}}
    @if($showCompleteModal && $selectedRequest)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeCompleteModal"></div>
            
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full p-6 z-50">
                    <button type="button" wire:click="closeCompleteModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">{{ __('messages.promoter.complete_maintenance') }}</h3>
                    
                    <div class="mb-4 bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $selectedRequest->title }}</h4>
                        <p class="text-sm text-gray-700">{{ $selectedRequest->description }}</p>
                    </div>
                    
                    <form wire:submit.prevent="markCompleted">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('messages.promoter.resolution_notes') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea wire:model="resolutionNotes" rows="4"
                                      class="w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                      placeholder="{{ __('messages.promoter.resolution_notes_placeholder') }}"></textarea>
                            @error('resolutionNotes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" wire:click="closeCompleteModal"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                {{ __('messages.common.cancel') }}
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                {{ __('messages.promoter.actions.mark_completed') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @livewire('components.footer')
</div>


