{{-- Viewer overlay for the lightbox() Alpine component. Place inside the x-data element. --}}
<template x-teleport="body">
    <div x-show="isOpen" x-cloak x-transition.opacity.duration.150ms
         x-ref="dialog"
         @keydown.window="onKey($event)"
         @touchstart.passive="touchStart($event)" @touchend.passive="touchEnd($event)"
         role="dialog" aria-modal="true" aria-label="Galería de imágenes"
         class="fixed inset-0 z-[100] flex flex-col bg-void/[.97] text-bone">
        {{-- Top bar --}}
        <div class="flex items-center justify-between px-4 sm:px-6 h-16 shrink-0 border-b border-rule">
            <span class="font-mono text-xs text-ash" x-text="counter" x-show="items.length > 1"></span>
            <span x-show="items.length < 2"></span>
            <button type="button" x-ref="close" @click="close()"
                    class="zp-lb-btn" aria-label="Cerrar">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        {{-- Image (click on the empty area closes) --}}
        <div class="relative flex-1 min-h-0 flex items-center justify-center p-4 sm:p-8" @click.self="close()">
            <img :src="current.src" :alt="current.alt"
                 class="max-w-full max-h-full object-contain select-none border-2 border-rule"
                 draggable="false">

            <button type="button" x-show="items.length > 1" @click="prev()"
                    class="zp-lb-btn absolute left-2 sm:left-6 top-1/2 -translate-y-1/2" aria-label="Anterior">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 5l-7 7 7 7"/></svg>
            </button>
            <button type="button" x-show="items.length > 1" @click="next()"
                    class="zp-lb-btn absolute right-2 sm:right-6 top-1/2 -translate-y-1/2" aria-label="Siguiente">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
    </div>
</template>
