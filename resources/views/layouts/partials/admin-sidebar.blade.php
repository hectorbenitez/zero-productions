@php
    $adminNav = [
        ['route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
        ['route' => 'admin.events.index', 'match' => 'admin.events.*', 'icon' => 'date', 'label' => 'Eventos'],
        ['route' => 'admin.settings.edit', 'match' => 'admin.settings.*', 'icon' => 'settings', 'label' => 'Configuración'],
        ['route' => 'admin.contact-messages.index', 'match' => 'admin.contact-messages.*', 'icon' => 'mail', 'label' => 'Mensajes'],
    ];
@endphp
<aside class="fixed inset-y-0 left-0 z-50 w-64 bg-amp border-r border-rule transform -translate-x-full lg:translate-x-0 transition-transform duration-200" id="sidebar">
    <div class="flex items-center justify-between h-16 px-4 border-b border-rule">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus">
            <img src="{{ asset('assets/logo-zero-productions-invert.png') }}" alt="Zero Productions" class="h-6 w-auto object-contain">
            <span class="rf-label text-riff-text">Admin</span>
        </a>
        <button type="button" class="rf-iconbtn lg:hidden" id="close-sidebar" aria-label="Cerrar menú">
            <x-rock-icon name="close" />
        </button>
    </div>

    <nav class="rf-sidenav" aria-label="Administración">
        @foreach($adminNav as $item)
            <a href="{{ route($item['route']) }}" @class(['rf-side-link', 'rf-side-on' => request()->routeIs($item['match'])])
               @if(request()->routeIs($item['match'])) aria-current="page" @endif>
                <x-rock-icon :name="$item['icon']" />
                {{ $item['label'] }}
            </a>
        @endforeach

        <div class="rf-side-rule"></div>

        <a href="{{ route('home') }}" target="_blank" class="rf-side-link">
            <x-rock-icon name="external" />
            Ver Sitio
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="rf-side-link">
                <x-rock-icon name="logout" />
                Cerrar Sesión
            </button>
        </form>
    </nav>
</aside>

<div class="fixed inset-0 bg-void/80 z-40 lg:hidden hidden" id="sidebar-overlay"></div>
