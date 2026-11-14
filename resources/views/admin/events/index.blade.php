@extends('layouts.admin')

@section('title', 'Eventos')

@section('content')
    <x-rf-page-header eyebrow="Panel" title="Eventos" sub="Gestiona los eventos del sitio">
        <x-rf-button :href="route('admin.events.create')" variant="primary">
            <x-rock-icon name="plus" />
            Nuevo Evento
        </x-rf-button>
    </x-rf-page-header>

    @if($events->count() > 0)
        <div class="rf-table-wrap">
            <table class="rf-table">
                <thead>
                    <tr>
                        <th class="w-16">ID</th>
                        <th>Evento</th>
                        <th>Fecha</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                <span class="rf-code">{{ $event->id }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 overflow-hidden bg-cab border border-rule flex-shrink-0">
                                        @if($event->coverImage)
                                            <img src="{{ route('media.show', $event->coverImage) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-smoke">
                                                <x-rock-icon name="image" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 max-w-[16rem]">
                                        <p class="font-display font-extrabold text-lg uppercase leading-tight truncate">{{ $event->title }}</p>
                                        <p class="rf-code truncate">/eventos/{{ $event->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <p class="font-mono">{{ $event->event_datetime->format('d/m/Y') }}</p>
                                <p class="rf-code">{{ $event->event_datetime->format('H:i') }}</p>
                            </td>
                            <td class="text-ash min-w-[9rem]">
                                {{ $event->location ?? '-' }}
                            </td>
                            <td>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($event->status === 'published')
                                        <x-rf-stamp tone="ok" :tilt="0" class="text-xs">Publicado</x-rf-stamp>
                                    @else
                                        <x-rf-stamp tone="volt" :tilt="0" class="text-xs">Borrador</x-rf-stamp>
                                    @endif
                                    @if($event->is_highlighted)
                                        <x-rf-stamp tone="riff" :tilt="0" :icon="null" class="text-xs whitespace-nowrap" title="Evento destacado">★ Destacado</x-rf-stamp>
                                    @endif
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <x-rf-icon-button icon="edit" label="Editar" :href="route('admin.events.edit', $event)" />
                                    <x-rf-icon-button icon="external" label="Ver en el sitio" :href="route('events.show', $event)" target="_blank" />
                                    <form action="{{ route('admin.events.destroy', $event) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este evento?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-rf-icon-button icon="trash" label="Eliminar" tone="danger" type="submit" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($events->hasPages())
                <div class="px-4 py-4 border-t border-rule">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="rf-panel rf-panel-flat text-center py-12 px-6">
            <x-rock-icon name="date" class="text-smoke mx-auto mb-4" />
            <p class="text-ash mb-4">No hay eventos todavía</p>
            <a href="{{ route('admin.events.create') }}" class="rf-link">
                Crear el primer evento <x-rock-icon name="arrow-right" />
            </a>
        </div>
    @endif
@endsection
