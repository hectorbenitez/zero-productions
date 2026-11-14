<header class="sticky top-0 z-30 h-16 bg-void/95 border-b border-rule flex items-center justify-between px-4 lg:px-8">
    <button type="button" class="rf-iconbtn lg:hidden" id="open-sidebar" aria-label="Abrir menú">
        <x-rock-icon name="menu" />
    </button>
    <span class="rf-label hidden lg:inline">Panel de administración</span>

    <div class="flex items-center gap-3">
        <span class="rf-code text-ash">{{ Auth::user()->name }}</span>
    </div>
</header>
