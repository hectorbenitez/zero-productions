@extends('layouts.public')

@section('title', $settings->company_name . ' - Producción de Eventos')
@section('description', 'Productora de eventos y conciertos de primer nivel. Conoce nuestros próximos eventos.')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('assets/hero-background.jpg') }}" 
                 alt="" 
                 class="w-full h-full object-cover object-bottom">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>
            <!-- Gradient overlay for better text readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-neutral-950/50"></div>
        </div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <h1 class="font-display text-5xl sm:text-7xl lg:text-8xl text-white tracking-wider mb-6 animate-fade-in">
                {!! nl2br(e($settings->hero_title ?? $settings->company_name)) !!}
            </h1>
            
            @if($settings->hero_subtitle)
                <p class="text-xl sm:text-2xl text-gray-300 max-w-2xl mx-auto mb-10 animate-fade-in-delay">
                    {{ $settings->hero_subtitle }}
                </p>
            @else
                <p class="text-xl sm:text-2xl text-gray-300 max-w-2xl mx-auto mb-10 animate-fade-in-delay">
                    Producción de eventos y conciertos de primer nivel
                </p>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-delay-2">
                <a href="{{ route('events.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25">
                    Ver Eventos
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
                <a href="{{ route('contact.show') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-lg border border-white/20 transition-all duration-300">
                    Contáctanos
                </a>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    @if($upcomingEvents->count() > 0)
        <section class="py-20 bg-neutral-900/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <h2 class="font-display text-3xl sm:text-4xl text-white tracking-wide">Próximos Eventos</h2>
                        <p class="text-gray-400 mt-2">No te pierdas nuestros eventos</p>
                    </div>
                    <a href="{{ route('events.index') }}" 
                       class="hidden sm:inline-flex items-center text-blue-500 hover:text-blue-400 font-medium transition-colors">
                        Ver todos
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingEvents as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>

                <div class="mt-8 text-center sm:hidden">
                    <a href="{{ route('events.index') }}" 
                       class="inline-flex items-center text-blue-500 hover:text-blue-400 font-medium transition-colors">
                        Ver todos los eventos
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- About Section -->
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl sm:text-4xl text-white tracking-wide mb-6">Sobre Nosotros</h2>
            <p class="text-gray-300 text-lg leading-relaxed">
                Somos una productora de eventos especializada en conciertos y espectáculos en vivo. 
                Con años de experiencia en la industria, nos dedicamos a crear experiencias inolvidables 
                para nuestro público, trabajando con los mejores artistas nacionales e internacionales.
            </p>
            <div class="mt-10">
                <a href="{{ route('contact.show') }}" 
                   class="inline-flex items-center text-blue-500 hover:text-blue-400 font-medium transition-colors">
                    Conoce más sobre nosotros
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-blue-600 to-blue-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 30px 30px;"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-display text-3xl sm:text-4xl text-white tracking-wide mb-4">¿Tienes alguna pregunta?</h2>
            <p class="text-white/80 text-lg mb-8">Estamos aquí para ayudarte. Contáctanos y te responderemos lo antes posible.</p>
            <a href="{{ route('contact.show') }}" 
               class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-all duration-300 hover:scale-105">
                Contáctanos
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    .animate-fade-in-delay {
        opacity: 0;
        animation: fadeIn 0.8s ease-out 0.2s forwards;
    }
    .animate-fade-in-delay-2 {
        opacity: 0;
        animation: fadeIn 0.8s ease-out 0.4s forwards;
    }
</style>
@endpush
