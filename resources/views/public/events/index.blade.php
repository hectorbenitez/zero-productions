@extends('layouts.public')

@section('title', 'Eventos - ' . $settings->company_name)
@section('description', 'Descubre todos nuestros eventos, conciertos y espectáculos. Próximos eventos y eventos pasados.')

@section('content')
    <!-- Header -->
    <section class="py-16 bg-gradient-to-b from-neutral-900 to-neutral-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="font-display text-4xl sm:text-5xl text-white tracking-wide mb-4">Eventos</h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Descubre todos nuestros eventos, conciertos y espectáculos
            </p>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-8 bg-blue-500 rounded-full"></div>
                <h2 class="font-display text-2xl sm:text-3xl text-white tracking-wide">Próximos Eventos</h2>
            </div>

            @if($upcomingEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingEvents as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-neutral-900/50 rounded-xl border border-white/5">
                    <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-400 text-lg">No hay eventos próximos programados</p>
                    <p class="text-gray-500 mt-2">Vuelve pronto para ver nuevos eventos</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Past Events -->
    @if($pastEvents->count() > 0)
        <section class="py-16 bg-neutral-900/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-8 bg-gray-500 rounded-full"></div>
                    <h2 class="font-display text-2xl sm:text-3xl text-white tracking-wide">Eventos Pasados</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pastEvents as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
