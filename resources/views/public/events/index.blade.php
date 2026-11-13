@extends('layouts.public')

@section('title', 'Eventos - ' . $settings->company_name)
@section('description', 'Descubre todos nuestros eventos, conciertos y espectáculos. Próximos eventos y eventos pasados.')

@section('content')
    <div class="zp-wrap">
        <!-- Header -->
        <section class="pt-14 pb-10 sm:pt-[72px] sm:pb-12 border-b-2 border-rule">
            <span class="rf-label">Agenda</span>
            <h1 class="font-display font-black uppercase text-[76px] sm:text-[144px] leading-[.84] mt-3 mb-4">Eventos</h1>
            <p class="text-[17px] leading-[26px] sm:text-xl sm:leading-[30px] text-ash">
                Descubre todos nuestros eventos, conciertos y espectáculos.
            </p>
        </section>

        <!-- Upcoming Events -->
        <section class="pt-14 sm:pt-16">
            <div class="zp-sec-h">
                <div>
                    <span class="rf-label">Lo que viene</span>
                    <h2>Próximos eventos</h2>
                </div>
                @if($upcomingEvents->count() > 0)
                    <span class="font-mono text-xs text-smoke">{{ str_pad($upcomingEvents->count(), 2, '0', STR_PAD_LEFT) }} {{ $upcomingEvents->count() === 1 ? 'evento' : 'eventos' }}</span>
                @endif
            </div>

            @if($upcomingEvents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10 pt-4">
                    @foreach($upcomingEvents as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center text-center py-12 px-6 bg-cab border border-dashed border-rule-strong">
                    <x-rock-icon name="date" size="48" class="text-ash mb-4" />
                    <p class="text-bone text-lg font-semibold">No hay eventos próximos programados</p>
                    <p class="text-ash mt-2">Vuelve pronto para ver nuevos eventos.</p>
                </div>
            @endif
        </section>

        <!-- Past Events -->
        @if($pastEvents->count() > 0)
            <section class="pt-16 sm:pt-24">
                <div class="zp-sec-h">
                    <div>
                        <span class="rf-label">Archivo</span>
                        <h2>Eventos pasados</h2>
                    </div>
                    <span class="font-mono text-xs text-smoke">{{ str_pad($pastEvents->count(), 2, '0', STR_PAD_LEFT) }} {{ $pastEvents->count() === 1 ? 'evento' : 'eventos' }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10 pt-4">
                    @foreach($pastEvents as $event)
                        @include('components.event-card', ['event' => $event])
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <div class="h-20 sm:h-24"></div>
@endsection
