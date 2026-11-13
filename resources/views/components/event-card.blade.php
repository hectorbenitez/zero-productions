@props(['event', 'showStatus' => false])

@php
    $date = $event->event_datetime->copy()->locale('es');
@endphp

<a href="{{ route('events.show', $event) }}" class="rf-card">
    <!-- Cover Image (always full colour) -->
    <div class="rf-card-media">
        @if($event->coverImage)
            <img src="{{ route('media.show', $event->coverImage) }}"
                 alt="{{ $event->title }}"
                 loading="lazy">
        @else
            <div class="rf-card-placeholder">
                <img src="{{ asset('assets/logo-zero-productions-invert.png') }}" alt="">
            </div>
        @endif

        @if($showStatus && $event->status === 'draft')
            <div class="rf-card-status">
                <x-rf-stamp tone="volt" :tilt="-3">Borrador</x-rf-stamp>
            </div>
        @elseif($event->isPast())
            <div class="rf-card-status">
                <x-rf-stamp tone="bone" :tilt="-3">Evento pasado</x-rf-stamp>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="rf-card-body">
        <x-rf-date-tag :day="$date->format('d')" :month="str_replace('.', '', $date->isoFormat('MMM'))" />

        <h3 class="rf-card-title line-clamp-2">{{ $event->title }}</h3>

        <p class="rf-card-meta">
            <x-rock-icon name="date" />
            <span>{{ ucwords(str_replace('.', '', $date->isoFormat('ddd DD MMM YYYY'))) }}</span>
        </p>

        @if($event->location)
            <p class="rf-card-meta">
                <x-rock-icon name="venue" />
                <span class="truncate">{{ str_replace(', ', ' · ', $event->location) }}</span>
            </p>
        @endif

        <div class="rf-card-cta">
            <span>{{ $event->isPast() ? 'Ver evento y galería' : 'Ver evento y boletos' }}</span>
            <x-rock-icon name="arrow-right" @class(['!text-ash' => $event->isPast()]) />
        </div>
    </div>
</a>
