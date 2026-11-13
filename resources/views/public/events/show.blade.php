@extends('layouts.public')

@section('title', $event->title . ' - ' . $settings->company_name)
@section('description', Str::limit(strip_tags($event->description), 160))

@if($event->coverImage)
    @section('og_image', route('media.show', $event->coverImage))
@endif
@section('og_title', $event->title)
@section('og_description', Str::limit(strip_tags($event->description), 160))

@php
    $date = $event->event_datetime->copy()->locale('es');
    $month = str_replace('.', '', $date->isoFormat('MMM'));
    $longDate = ucwords(str_replace('.', '', $date->isoFormat('ddd DD MMM YYYY')));
    $gallery = $event->filesystem_gallery;
@endphp

@section('content')
    <!-- Hero/Cover (full colour, fades into the ground) -->
    <section class="zp-ev-hero relative h-[440px] sm:h-[560px] overflow-hidden bg-cab">
        @if($event->coverImage)
            <img src="{{ route('media.show', $event->coverImage) }}"
                 alt="{{ $event->title }}"
                 class="w-full h-full object-cover object-top">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <img src="{{ asset('assets/logo-zero-productions-invert.png') }}" alt="" class="w-24 h-24 opacity-20">
            </div>
        @endif

        <div class="absolute inset-x-0 bottom-8 sm:bottom-10 z-10">
            <div class="zp-wrap relative">
                <x-rf-button :href="route('events.index')" variant="ghost" icon="arrow-left" class="mb-3">Volver a eventos</x-rf-button>
                <div class="pr-24 sm:pr-40">
                    @if($event->isPast())
                        <x-rf-stamp tone="bone" :tilt="-3">Evento pasado</x-rf-stamp>
                    @endif
                    <h1 @class([
                        'font-display font-black uppercase leading-[.82] tracking-[-.01em] mt-3 break-words',
                        'text-[56px] sm:text-[112px] lg:text-[180px]' => mb_strlen($event->title) <= 14,
                        'text-[44px] sm:text-[80px] lg:text-[120px]' => mb_strlen($event->title) > 14,
                    ])>
                        {{ $event->title }}
                    </h1>
                </div>
                <x-rf-date-tag :day="$date->format('d')" :month="$month"
                               class="!absolute right-4 sm:right-8 bottom-0 origin-bottom-right !rotate-[-4deg] sm:scale-[1.4]" />
            </div>
        </div>
    </section>

    <div class="zp-wrap">
        <!-- Facts -->
        <div class="flex flex-wrap gap-3 mt-6">
            <x-rf-info-chip icon="date" label="Fecha" :value="$longDate . ' · ' . $event->formatted_time" />
            @if($event->location)
                <x-rf-info-chip icon="venue" label="Lugar" :value="str_replace(', ', ' · ', $event->location)" />
            @endif
            <x-rf-info-chip icon="presenter" label="Presenta" :value="$settings->company_name ?? 'Zero Productions'" />
        </div>

        <!-- Two-column layout: Info + Flyer -->
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_420px] gap-10 lg:gap-14 mt-10 items-start">
            <!-- Left Column: Tickets & Description -->
            <div class="min-w-0">
                <!-- Ticket Links (first one is the single red action; the rest are outlines) -->
                @if($event->isUpcoming() && $event->links->count() > 0)
                    <div class="bg-amp border border-rule border-t-4 border-t-riff p-6 sm:p-8 mb-10">
                        <h3 class="font-display font-extrabold uppercase text-[28px] leading-none mb-5 flex items-center gap-3">
                            <x-rock-icon name="ticket" />
                            Comprar boletos
                        </h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($event->links as $link)
                                <a href="{{ $link->url }}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="rf-btn {{ $loop->first ? 'rf-btn-primary rf-btn-lg' : 'rf-btn-secondary rf-btn-lg' }}">
                                    {{ $link->label }}
                                    <x-rock-icon name="arrow-right" />
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Description -->
                @if($event->description)
                    <h3 class="font-display font-extrabold uppercase text-4xl leading-none mb-5">Acerca del evento</h3>
                    <div class="text-lg leading-[30px] text-ash whitespace-pre-line max-w-[640px]">{{ $event->description }}</div>
                @endif
            </div>

            <!-- Right Column: Flyer Image -->
            @if($event->flyerImage)
                <div class="max-w-[320px] sm:max-w-[420px] w-full mx-auto lg:mx-0 pr-3 pb-3 lg:sticky lg:top-24">
                    <a href="{{ route('media.show', $event->flyerImage) }}" target="_blank" class="zp-flyer focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus focus-visible:outline-offset-4">
                        <img src="{{ route('media.show', $event->flyerImage) }}"
                             alt="Flyer - {{ $event->title }}">
                    </a>
                </div>
            @endif
        </div>

        <!-- Gallery Section (filesystem-based: public/assets/gallery/{event_id}/) -->
        @if(count($gallery) > 0)
            <section class="pt-16 sm:pt-24">
                <div class="zp-sec-h">
                    <div>
                        <span class="rf-label">En vivo · {{ $date->format('d') }} {{ ucfirst($month) }} {{ $date->format('Y') }}</span>
                        <h2>Galería</h2>
                    </div>
                    <span class="font-mono text-xs text-smoke">{{ str_pad(count($gallery), 2, '0', STR_PAD_LEFT) }} {{ count($gallery) === 1 ? 'foto' : 'fotos' }}</span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                    @foreach($gallery as $photo)
                        <a href="{{ $photo['url'] }}"
                           target="_blank"
                           @class([
                               'group block overflow-hidden bg-cab border border-rule hover:border-rule-strong focus-visible:outline focus-visible:outline-2 focus-visible:outline-focus focus-visible:outline-offset-2',
                               'col-span-2 aspect-[4/3] md:aspect-auto md:h-80' => $loop->first,
                               'aspect-square md:aspect-auto md:h-80' => ! $loop->first,
                           ])>
                            <img src="{{ $photo['url'] }}"
                                 alt="{{ $event->title }} - {{ $photo['filename'] }}"
                                 class="w-full h-full object-cover transition-transform duration-[400ms] group-hover:scale-[1.04]"
                                 loading="lazy">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <div class="h-20 sm:h-24"></div>
@endsection
