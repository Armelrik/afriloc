<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold text-primary mb-4">AfriLoc</h3>
                <p class="text-gray-400">{{ __('messages.footer.description') }}</p>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.footer.links') }}</h4>
                <ul class="space-y-2">
                    <li><a href="/" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.nav.home') }}</a></li>
                    <li><a href="/properties" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.nav.properties') }}</a></li>
                    <li><a href="/contact" class="text-gray-400 hover:text-white transition-colors">{{ __('messages.nav.contact') }}</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.footer.contact_us') }}</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Email: info@afriloc.com</li>
                    <li>Phone: +226 XX XX XX XX</li>
                    <li>Ouagadougou, Burkina Faso</li>
                </ul>
            </div>
            
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ __('messages.footer.follow_us') }}</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} AfriLoc. {{ __('messages.footer.rights') }}</p>
        </div>
    </div>
</footer>
