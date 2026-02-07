@extends('layouts.admin')

@section('title', 'Eventos')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Eventos</h1>
            <p class="text-gray-600">Gestiona los eventos del sitio</p>
        </div>
        <a href="{{ route('admin.events.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Evento
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                            @if($event->coverImage)
                                                <img src="{{ route('media.show', $event->coverImage) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                            <p class="text-sm text-gray-500">/eventos/{{ $event->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-900">{{ $event->event_datetime->format('d/m/Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ $event->event_datetime->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $event->location ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($event->status === 'published')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Publicado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Borrador
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.events.edit', $event) }}" 
                                           class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
                                           title="Editar">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('events.show', $event) }}" 
                                           target="_blank"
                                           class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
                                           title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este evento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-blue-600 transition-colors"
                                                    title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($events->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $events->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 mb-4">No hay eventos todavía</p>
                <a href="{{ route('admin.events.create') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                    Crear el primer evento
                </a>
            </div>
        @endif
    </div>
@endsection
