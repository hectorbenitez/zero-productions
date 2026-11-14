@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <x-rf-page-header eyebrow="Panel" title="Dashboard" sub="Bienvenido al panel de administración" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Total eventos', 'value' => $stats['total_events'], 'sub' => 'En el sitio'],
            ['label' => 'Publicados', 'value' => $stats['published_events'], 'sub' => 'Visibles al público'],
            ['label' => 'Próximos', 'value' => $stats['upcoming_events'], 'sub' => 'Con fecha por venir'],
            ['label' => 'Mensajes', 'value' => $stats['contact_messages'], 'sub' => 'Desde contacto'],
        ] as $stat)
            <div class="rf-stat">
                <span class="rf-label">{{ $stat['label'] }}</span>
                <p class="rf-stat-value">{{ $stat['value'] }}</p>
                <p class="rf-stat-sub">{{ $stat['sub'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <section class="rf-panel rf-panel-flat">
            <div class="rf-panel-h">
                <h2>Próximos eventos</h2>
                <a href="{{ route('admin.events.index') }}" class="rf-link">Ver todos <x-rock-icon name="arrow-right" /></a>
            </div>
            <div class="rf-panel-b">
                @if($upcomingEvents->count() > 0)
                    <div class="divide-y divide-rule">
                        @foreach($upcomingEvents as $event)
                            @php($date = $event->event_datetime->copy()->locale('es'))
                            <a href="{{ route('admin.events.edit', $event) }}" class="flex items-center gap-5 py-4 first:pt-0 last:pb-0 group focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus">
                                <x-rf-date-tag class="shrink-0" :day="$date->format('d')" :month="str_replace('.', '', $date->isoFormat('MMM'))" />
                                <div class="flex-1 min-w-0">
                                    <p class="font-display font-extrabold text-xl uppercase leading-tight truncate group-hover:text-riff-text transition-colors">{{ $event->title }}</p>
                                    <p class="text-sm text-ash truncate">{{ $date->isoFormat('MMMM YYYY') }} · {{ $event->location ?? 'Sin ubicación' }}</p>
                                </div>
                                <x-rock-icon name="arrow-right" class="text-smoke group-hover:text-riff-text transition-colors" />
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-smoke text-center py-8">No hay eventos próximos</p>
                @endif
            </div>
        </section>

        <!-- Recent Messages -->
        <section class="rf-panel rf-panel-flat">
            <div class="rf-panel-h">
                <h2>Mensajes recientes</h2>
                <a href="{{ route('admin.contact-messages.index') }}" class="rf-link">Ver todos <x-rock-icon name="arrow-right" /></a>
            </div>
            <div class="rf-panel-b">
                @if($recentMessages->count() > 0)
                    <div class="divide-y divide-rule">
                        @foreach($recentMessages as $message)
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="block py-4 first:pt-0 last:pb-0 group focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus">
                                <div class="flex items-center justify-between gap-4 mb-1">
                                    <p class="font-semibold group-hover:text-riff-text transition-colors">{{ $message->name }}</p>
                                    <span class="rf-code shrink-0">{{ $message->created_at->locale('es')->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-ash truncate">{{ $message->message }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-smoke text-center py-8">No hay mensajes</p>
                @endif
            </div>
        </section>
    </div>
@endsection
