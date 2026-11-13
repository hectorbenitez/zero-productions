@extends('layouts.public')

@section('title', $settings->company_name . ' - Producción de Eventos')
@section('description', 'Productora de eventos y conciertos de primer nivel. Conoce nuestros próximos eventos.')

@php
    // Split the hero title: first line (or word) in bone, the rest in red
    $heroTitle = trim($settings->hero_title ?? $settings->company_name);
    $heroLines = preg_split('/\R/', $heroTitle, 2);
    if (count($heroLines) < 2) {
        $heroLines = explode(' ', $heroTitle, 2);
    }
@endphp

@section('content')
    <!-- Hero Section -->
    <section class="zp-hero relative h-[640px] sm:h-[800px] sm:max-h-[calc(100vh-72px)] sm:min-h-[560px] overflow-hidden bg-void">
        <img src="{{ asset('assets/hero-background.jpg') }}"
             alt=""
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-x-0 bottom-10 sm:bottom-[72px] z-10">
            <div class="zp-wrap">
                <span class="rf-label !text-bone">
                    {{ 'Productora de conciertos'.($settings->address ? ' · '.$settings->address : '') }}
                </span>

                <h1 class="font-display font-black uppercase text-[72px] sm:text-[120px] lg:text-[168px] leading-[.84] tracking-[-.015em] mt-4 mb-5">
                    {{ $heroLines[0] }}
                    @if(isset($heroLines[1]))
                        <span class="block text-riff-text">{{ $heroLines[1] }}</span>
                    @endif
                </h1>

                <p class="text-[17px] leading-[26px] sm:text-xl sm:leading-[30px] text-bone max-w-xl mb-8">
                    {{ $settings->hero_subtitle ?: 'Producción de eventos y conciertos de primer nivel' }}
                </p>

                <div class="flex flex-wrap gap-4">
                    <x-rf-button :href="route('events.index')" size="lg" icon-right="arrow-right">Ver eventos</x-rf-button>
                    <x-rf-button :href="route('contact.show')" variant="secondary" size="lg">Contáctanos</x-rf-button>
                </div>
            </div>
        </div>
    </section>

    <!-- Lineup strip: names of the events on the grid -->
    @if($events->count() > 0)
        <div class="zp-lineup" aria-label="Bandas que hemos traído">
            <div class="zp-lineup-in">
                @foreach($events->concat($events) as $event)
                    <span @if($loop->index >= $events->count()) aria-hidden="true" @endif>{{ $event->title }}</span>
                    <x-rock-icon name="bolt" />
                @endforeach
            </div>
        </div>
    @endif

    <div class="zp-wrap">
        <!-- Events Section -->
        @if($events->count() > 0)
            <section class="pt-16 sm:pt-24">
                <div class="zp-sec-h">
                    <div>
                        <span class="rf-label">Agenda</span>
                        <h2>Eventos</h2>
                        <p>No te pierdas lo que viene y revive nuestros eventos pasados.</p>
                    </div>
                    <x-rf-button :href="route('events.index')" variant="ghost" icon-right="arrow-right">Ver todos</x-rf-button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10 pt-4">
                    @foreach($events as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>
            </section>
        @endif

        <!-- About Section -->
        <section class="pt-16 sm:pt-24">
            <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-6 lg:gap-16 items-start">
                <div>
                    <span class="rf-label">Quiénes somos</span>
                    <h2 class="font-display font-black uppercase text-[64px] sm:text-[96px] leading-[.86] mt-2">Sobre nosotros</h2>
                </div>
                <div>
                    <p class="text-lg leading-[30px] text-ash mb-6 first-line:text-bone">
                        Somos una productora de eventos especializada en conciertos y espectáculos en vivo.
                        Con años de experiencia en la industria, nos dedicamos a crear experiencias inolvidables
                        para nuestro público, trabajando con los mejores artistas nacionales e internacionales.
                    </p>
                    <x-rf-button :href="route('contact.show')" variant="ghost" icon-right="arrow-right">Conoce más sobre nosotros</x-rf-button>
                </div>
            </div>
        </section>
    </div>

    <!-- CTA Section -->
    <section class="mt-20 sm:mt-28 bg-riff text-on-riff">
        <div class="zp-wrap flex flex-col sm:flex-row items-start sm:items-center justify-between gap-8 py-14">
            <div>
                <h2 class="font-display font-black uppercase text-[52px] sm:text-[80px] leading-[.88]">¿Tienes alguna pregunta?</h2>
                <p class="text-lg leading-7 mt-3 max-w-[520px]">Estamos aquí para ayudarte. Contáctanos y te responderemos lo antes posible.</p>
            </div>
            <a href="{{ route('contact.show') }}" class="rf-btn rf-btn-lg zp-btn-ink shrink-0">
                Contáctanos
                <x-rock-icon name="arrow-right" />
            </a>
        </div>
    </section>
@endsection
