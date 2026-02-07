@extends('layouts.public')

@section('title', $event->title . ' - ' . $settings->company_name)
@section('description', Str::limit(strip_tags($event->description), 160))

@if($event->coverImage)
    @section('og_image', route('media.show', $event->coverImage))
@endif
@section('og_title', $event->title)
@section('og_description', Str::limit(strip_tags($event->description), 160))

@section('content')
    <!-- Hero/Cover -->
    <section class="relative">
        <div class="h-64 sm:h-80 md:h-96 bg-neutral-900 relative overflow-hidden">
            @if($event->coverImage)
                <img src="{{ route('media.show', $event->coverImage) }}" 
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/50 to-transparent"></div>
            @else
                <div class="w-full h-full bg-gradient-to-br from-neutral-800 to-neutral-900 flex items-center justify-center">
                    <svg class="w-24 h-24 text-neutral-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 to-transparent"></div>
            @endif
        </div>

        <!-- Event Info Overlay -->
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative -mt-32 z-10">
            <div class="bg-neutral-900 rounded-2xl p-6 sm:p-8 border border-white/10 shadow-2xl">
                <!-- Date Badge -->
                <div class="flex flex-wrap items-start gap-4 mb-6">
                    <div class="bg-blue-600 text-white p-4 rounded-xl text-center min-w-[80px]">
                        <div class="text-3xl font-bold">{{ $event->event_datetime->format('d') }}</div>
                        <div class="text-sm uppercase tracking-wider">{{ $event->event_datetime->translatedFormat('M') }}</div>
                        <div class="text-xs opacity-80">{{ $event->event_datetime->format('Y') }}</div>
                    </div>
                    <div class="flex-1">
                        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl text-white tracking-wide mb-3">
                            {{ $event->title }}
                        </h1>
                        
                        <div class="flex flex-wrap gap-4 text-gray-400">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $event->formatted_time }}</span>
                            </div>
                            @if($event->location)
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Two-column layout: Info + Flyer -->
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left Column: Tickets & Description -->
                    <div class="flex-1 min-w-0">
                        <!-- Ticket Links -->
                        @if($event->isUpcoming() && $event->links->count() > 0)
                            <div class="bg-neutral-800/50 rounded-xl p-6 mb-6 border border-white/5">
                                <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                    Comprar Boletos
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($event->links as $link)
                                        <a href="{{ $link->url }}" 
                                           target="_blank" 
                                           rel="noopener noreferrer"
                                           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25">
                                            {{ $link->label }}
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        @if($event->description)
                            <div class="prose prose-invert prose-lg max-w-none">
                                <h3 class="text-lg font-semibold text-white mb-4">Acerca del Evento</h3>
                                <div class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $event->description }}</div>
                            </div>
                        @endif
                    </div>

                    <!-- Right Column: Flyer Image -->
                    @if($event->flyerImage)
                        <div style="width: 40%; flex-shrink: 0;" class="hidden lg:block">
                            <div class="sticky top-20">
                                <a href="{{ route('media.show', $event->flyerImage) }}" target="_blank" class="block group">
                                    <img src="{{ route('media.show', $event->flyerImage) }}" 
                                         alt="Flyer - {{ $event->title }}"
                                         style="max-height: 500px; object-fit: contain; width: 100%;"
                                         class="rounded-xl border border-white/10 shadow-2xl group-hover:border-blue-500/30 transition-all duration-300">
                                </a>
                            </div>
                        </div>
                        <!-- Mobile flyer -->
                        <div class="lg:hidden flex justify-center">
                            <a href="{{ route('media.show', $event->flyerImage) }}" target="_blank" class="block group" style="max-width: 320px;">
                                <img src="{{ route('media.show', $event->flyerImage) }}" 
                                     alt="Flyer - {{ $event->title }}"
                                     style="max-height: 400px; object-fit: contain; width: 100%;"
                                     class="rounded-xl border border-white/10 shadow-2xl">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section (filesystem-based: public/assets/gallery/{event_id}/) -->
    @if(count($event->filesystem_gallery) > 0)
        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-1 h-8 bg-blue-500 rounded-full"></div>
                    <h2 class="font-display text-2xl sm:text-3xl text-white tracking-wide">Galería</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($event->filesystem_gallery as $photo)
                        <a href="{{ $photo['url'] }}" 
                           target="_blank"
                           class="group aspect-square bg-neutral-800 rounded-lg overflow-hidden">
                            <img src="{{ $photo['url'] }}" 
                                 alt="{{ $event->title }} - {{ $photo['filename'] }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Back Link -->
    <section class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('events.index') }}" 
               class="inline-flex items-center text-gray-400 hover:text-white transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver a Eventos
            </a>
        </div>
    </section>
@endsection
