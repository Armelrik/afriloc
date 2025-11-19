<div>
    @livewire('components.header')

    <div class="min-h-screen bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8">{{ __('messages.promoter.messages') }}</h1>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 h-[600px]">
                    {{-- Conversations List --}}
                    <div class="border-r border-gray-200 overflow-y-auto">
                        <div class="p-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="font-semibold text-gray-700">{{ __('messages.messaging.conversations') }}</h2>
                        </div>
                        
                        @if($conversations->count() > 0)
                            @foreach($conversations as $conversation)
                                <button wire:click="selectConversation({{ $conversation['user']->id }})"
                                        class="w-full p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors text-left
                                            {{ $selectedConversation == $conversation['user']->id ? 'bg-primary-50' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="font-semibold">{{ $conversation['user']->name }}</h3>
                                            <p class="text-sm text-gray-500">{{ $conversation['user']->email }}</p>
                                            @if($conversation['last_message'])
                                                <p class="text-xs text-gray-400 mt-1 truncate">
                                                    {{ Str::limit($conversation['last_message']->message, 50) }}
                                                </p>
                                            @endif
                                        </div>
                                        @if($conversation['unread_count'] > 0)
                                            <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full ml-2">
                                                {{ $conversation['unread_count'] }}
                                            </span>
                                        @endif
                                    </div>
                                </button>
                            @endforeach
                        @else
                            <div class="p-8 text-center text-gray-500">
                                <p>{{ __('messages.messaging.no_conversations') }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Messages Area --}}
                    <div class="md:col-span-2 flex flex-col">
                        @if($selectedConversation)
                            {{-- Messages Header --}}
                            <div class="p-4 bg-gray-50 border-b border-gray-200">
                                @php
                                    $selectedUser = \App\Models\User::find($selectedConversation);
                                @endphp
                                <h3 class="font-semibold">{{ $selectedUser->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $selectedUser->email }}</p>
                            </div>

                            {{-- Messages List --}}
                            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                                @foreach($messages as $message)
                                    <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[70%] {{ $message->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-gray-200 text-gray-800' }} 
                                                    rounded-lg px-4 py-2">
                                            <p>{{ $message->message }}</p>
                                            <p class="text-xs mt-1 {{ $message->sender_id == Auth::id() ? 'text-primary-100' : 'text-gray-500' }}">
                                                {{ $message->created_at->format('d/m/Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Message Input --}}
                            <form wire:submit.prevent="sendMessage" class="p-4 bg-gray-50 border-t border-gray-200">
                                <div class="flex gap-2">
                                    <input type="text" wire:model="messageContent" 
                                           class="flex-1 rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50"
                                           placeholder="{{ __('messages.messaging.type_message') }}" />
                                    <button type="submit" 
                                            class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors font-medium">
                                        {{ __('messages.common.send') }}
                                    </button>
                                </div>
                                @error('messageContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </form>
                        @else
                            <div class="flex-1 flex items-center justify-center text-gray-500">
                                <div class="text-center">
                                    <svg class="w-24 h-24 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p>{{ __('messages.messaging.select_conversation') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('components.footer')

    <script>
        // Auto-scroll to bottom of messages
        document.addEventListener('livewire:load', function () {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        Livewire.hook('message.processed', () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</div>


