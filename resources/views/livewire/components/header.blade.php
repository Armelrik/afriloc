<header class="fixed top-0 left-0 right-0 z-50 bg-white shadow-md">
    <nav class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <a href="/" class="text-2xl font-bold text-primary">
                AfriLoc
            </a>

            <div class="hidden md:flex items-center space-x-6">
                <a href="/" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.home') }}</a>
                <a href="/properties" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.properties') }}</a>
                <a href="/contact" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.contact') }}</a>
                
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="/admin" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.admin') }}</a>
                    @endif
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.logout') }}</button>
                    </form>
                @else
                    <a href="/login" class="text-gray-700 hover:text-primary transition-colors">{{ __('messages.nav.login') }}</a>
                @endauth

                {{-- Language Switcher --}}
                <div class="flex items-center space-x-2">
                    <button wire:click="switchLanguage('en')" class="px-2 py-1 {{ app()->getLocale() == 'en' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }} rounded">
                        EN
                    </button>
                    <button wire:click="switchLanguage('fr')" class="px-2 py-1 {{ app()->getLocale() == 'fr' ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700' }} rounded">
                        FR
                    </button>
                </div>
            </div>

            {{-- Mobile menu button --}}
            <button class="md:hidden p-2" onclick="toggleMobileMenu()">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </nav>
</header>

<script>
    function toggleMobileMenu() {
        // Simple mobile menu toggle - can be enhanced
        alert('Mobile menu - to be implemented');
    }
</script>
