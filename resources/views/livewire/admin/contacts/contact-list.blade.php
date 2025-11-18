<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <h1 class="text-4xl font-bold mb-8">{{ __('messages.admin.contacts') }}</h1>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.email') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.subject') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.date') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contacts as $contact)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $contact->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $contact->email }}</td>
                            <td class="px-6 py-4">{{ $contact->subject }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $contact->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="delete({{ $contact->id }})" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('{{ __('messages.admin.confirm_delete') }}')">{{ __('messages.admin.delete') }}</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    </div>

    @livewire('components.footer')
</div>

