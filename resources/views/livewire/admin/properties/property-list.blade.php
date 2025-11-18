<div>
    @livewire('components.header')

    <div class="container mx-auto px-4 py-24">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold">{{ __('messages.admin.properties') }}</h1>
            <a href="/admin/properties/create" class="bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary-600 transition-colors">
                {{ __('messages.admin.add_property') }}
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.title') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.type') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.price') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.status') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.admin.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($properties as $property)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $property->title_en }}</td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">{{ $property->type }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($property->price) }} FCFA</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $property->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $property->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/properties/{{ $property->id }}" class="text-blue-600 hover:text-blue-900 mr-3">{{ __('messages.admin.view') }}</a>
                                <button wire:click="delete({{ $property->id }})" class="text-red-600 hover:text-red-900" 
                                        onclick="return confirm('{{ __('messages.admin.confirm_delete') }}')">{{ __('messages.admin.delete') }}</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $properties->links() }}
        </div>
    </div>

    @livewire('components.footer')
</div>

