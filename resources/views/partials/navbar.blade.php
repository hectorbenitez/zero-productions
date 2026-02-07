<nav class="bg-black/90 backdrop-blur-md sticky top-0 z-50 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo-zero-productions-invert.png') }}" 
                         alt="{{ $settings->company_name ?? 'Zero Productions' }}" 
                         class="h-8 w-auto object-contain">
                    <span class="text-white font-semibold text-lg tracking-wide">Zero Productions</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                <a href="{{ route('home') }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-blue-500' : 'text-gray-300 hover:text-white' }}">
                    Inicio
                </a>
                <a href="{{ route('events.index') }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('events.*') ? 'text-blue-500' : 'text-gray-300 hover:text-white' }}">
                    Eventos
                </a>
                <a href="{{ route('contact.show') }}" 
                   class="text-sm font-medium transition-colors {{ request()->routeIs('contact.*') ? 'text-blue-500' : 'text-gray-300 hover:text-white' }}">
                    Contacto
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button" id="mobile-menu-button" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-black/95 border-t border-white/10">
            <a href="{{ route('home') }}" 
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-blue-500 bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                Inicio
            </a>
            <a href="{{ route('events.index') }}" 
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('events.*') ? 'text-blue-500 bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                Eventos
            </a>
            <a href="{{ route('contact.show') }}" 
               class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('contact.*') ? 'text-blue-500 bg-white/5' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                Contacto
            </a>
        </div>
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
