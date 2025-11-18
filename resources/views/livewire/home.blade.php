<div>
    @livewire('components.header')

    {{-- Hero Section --}}
    <section class="relative h-[90vh] flex items-center justify-center overflow-hidden mt-20">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/ouaga-hero.jpg') }}')">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4">
            <div class="max-w-3xl">
                <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-fade-in">
                    {{ __('messages.hero.title') }}
                </h1>
                <p class="text-xl md:text-2xl text-white/90 mb-8 animate-fade-in">
                    {{ __('messages.hero.subtitle') }}
                </p>
                <a href="/properties" class="inline-flex items-center px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-600 transition-colors animate-fade-in">
                    {{ __('messages.hero.cta') }}
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Floating Stats --}}
        <div class="absolute bottom-10 left-0 right-0 z-10">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-4xl mx-auto">
                    <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-xl p-6 text-center text-white">
                        <svg class="h-8 w-8 mx-auto mb-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <div class="text-3xl font-bold">100+</div>
                        <div class="text-sm opacity-90">{{ __('messages.stats.houses') }}</div>
                    </div>
                    <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-xl p-6 text-center text-white">
                        <svg class="h-8 w-8 mx-auto mb-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <div class="text-3xl font-bold">50+</div>
                        <div class="text-sm opacity-90">{{ __('messages.stats.apartments') }}</div>
                    </div>
                    <div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-xl p-6 text-center text-white">
                        <svg class="h-8 w-8 mx-auto mb-2 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <div class="text-3xl font-bold">30+</div>
                        <div class="text-sm opacity-90">{{ __('messages.stats.lands') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Properties --}}
    <section class="py-20 bg-gradient-to-b from-background to-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12 animate-fade-in">
                <h2 class="text-4xl font-bold mb-4 text-foreground">
                    {{ __('messages.properties.title') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    {{ __('messages.hero.subtitle') }}
                </p>
            </div>

            @if($featuredProperties->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredProperties as $property)
                        @livewire('components.property-card', ['property' => $property], key($property->id))
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-xl text-gray-500">{{ __('messages.common.loading') }}</p>
                </div>
            @endif

            <div class="text-center mt-12">
                <a href="/properties" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    {{ __('messages.properties.view_all') }}
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-primary to-accent text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">
                {{ __('messages.cta.title') }}
            </h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                {{ __('messages.cta.subtitle') }}
            </p>
            <a href="/contact" class="inline-flex items-center px-8 py-4 bg-white text-primary rounded-lg hover:bg-gray-100 transition-colors text-lg font-semibold">
                {{ __('messages.nav.contact') }}
            </a>
        </div>
    </section>

    @livewire('components.footer')
</div>
