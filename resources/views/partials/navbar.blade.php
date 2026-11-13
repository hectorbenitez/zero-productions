@php
    $navItems = [
        ['label' => 'Inicio', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Eventos', 'route' => 'events.index', 'active' => request()->routeIs('events.*')],
        ['label' => 'Contacto', 'route' => 'contact.show', 'active' => request()->routeIs('contact.*')],
    ];
@endphp
<nav class="sticky top-0 z-50 bg-void/95 border-b border-rule">
    <div class="zp-wrap">
        <div class="flex items-center justify-between h-[72px]">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 min-w-0 text-bone focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus focus-visible:outline-offset-2">
                <img src="{{ asset('assets/logo-zero-productions-invert.png') }}"
                     alt=""
                     class="h-8 w-8 sm:h-10 sm:w-10 object-contain shrink-0">
                <span class="font-display font-black uppercase text-lg sm:text-[26px] leading-none tracking-[.02em] whitespace-nowrap">{{ $settings->company_name ?? 'Zero Productions' }}</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-7 shrink-0">
                <!-- Desktop Menu -->
                <div class="hidden sm:flex rf-nav">
                    @foreach($navItems as $item)
                        <a href="{{ route($item['route']) }}" @class(['is-active' => $item['active']]) @if($item['active']) aria-current="page" @endif>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>

                <a href="https://tickets.zero-productions.com" class="rf-btn rf-btn-secondary !px-3 sm:!px-3.5 !py-2 !text-xs">
                    Boletos
                    <x-rock-icon name="ticket" />
                </a>

                <!-- Mobile menu button -->
                <button type="button" id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false"
                        class="sm:hidden inline-flex items-center justify-center w-10 h-10 border-2 border-rule-strong text-bone hover:border-bone focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus focus-visible:outline-offset-2">
                    <span class="sr-only">Abrir menú</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="square" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden sm:hidden border-t border-rule bg-amp" id="mobile-menu">
        @foreach($navItems as $item)
            <a href="{{ route($item['route']) }}"
               @class([
                   'block px-4 py-4 border-b border-rule border-l-4 font-bold text-sm uppercase tracking-[.12em]',
                   'border-l-riff text-bone bg-cab' => $item['active'],
                   'border-l-transparent text-ash hover:text-bone hover:bg-cab' => ! $item['active'],
               ])>
                {{ $item['label'] }}
            </a>
        @endforeach
    </div>
</nav>

<script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', menu.classList.contains('hidden') ? 'false' : 'true');
    });
</script>
