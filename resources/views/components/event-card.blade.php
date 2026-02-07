@props(['event', 'showStatus' => false])

<a href="{{ route('events.show', $event) }}" 
   class="group block bg-neutral-900 rounded-xl overflow-hidden border border-white/5 hover:border-blue-500/50 transition-all duration-300 hover:-translate-y-1">
    <!-- Cover Image -->
    <div class="aspect-[16/9] bg-neutral-800 relative overflow-hidden">
        @if($event->coverImage)
            <img src="{{ route('media.show', $event->coverImage) }}" 
                 alt="{{ $event->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-neutral-800 to-neutral-900">
                <svg class="w-16 h-16 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                </svg>
            </div>
        @endif

        @if($showStatus && $event->status === 'draft')
            <div class="absolute top-2 right-2 bg-yellow-500 text-black text-xs font-semibold px-2 py-1 rounded">
                Borrador
            </div>
        @endif

        @if($event->isPast())
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="text-white/80 text-sm font-medium uppercase tracking-wider">Evento pasado</span>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-5">
        <!-- Date Badge -->
        <div class="flex items-center gap-2 mb-3">
            <div class="bg-blue-500 text-white text-xs font-bold px-2 py-1 rounded">
                {{ $event->event_datetime->format('d') }}
                <span class="uppercase">{{ $event->event_datetime->translatedFormat('M') }}</span>
            </div>
            <span class="text-gray-400 text-sm">{{ $event->event_datetime->format('Y') }}</span>
        </div>

        <!-- Title -->
        <h3 class="text-lg font-semibold text-white group-hover:text-blue-500 transition-colors line-clamp-2 mb-2">
            {{ $event->title }}
        </h3>

        <!-- Location -->
        @if($event->location)
            <p class="text-gray-400 text-sm flex items-center gap-1">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="truncate">{{ $event->location }}</span>
            </p>
        @endif
    </div>
</a>
