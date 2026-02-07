@extends('layouts.admin')

@section('title', 'Enlaces - ' . $event->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.events.edit', $event) }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver al Evento
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-900">Enlaces de Boletos</h1>
            <p class="text-gray-600">{{ $event->title }}</p>
        </div>

        <!-- Add New Link Form -->
        <form action="{{ route('admin.events.links.store', $event) }}" method="POST" class="p-6 bg-gray-50 border-b border-gray-200">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" 
                           name="label" 
                           placeholder="Etiqueta (ej: Ticketmaster)"
                           value="{{ old('label') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('label') border-blue-500 @enderror"
                           required>
                    @error('label')
                        <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1">
                    <input type="url" 
                           name="url" 
                           placeholder="URL (https://...)"
                           value="{{ old('url') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url') border-blue-500 @enderror"
                           required>
                    @error('url')
                        <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors whitespace-nowrap">
                    Agregar
                </button>
            </div>
        </form>

        <!-- Links List -->
        <div class="p-6">
            @if($event->links->count() > 0)
                <form action="{{ route('admin.events.links.reorder', $event) }}" method="POST" id="reorder-form">
                    @csrf
                    <ul class="space-y-3" id="links-list">
                        @foreach($event->links as $link)
                            <li class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg" data-id="{{ $link->id }}">
                                <input type="hidden" name="order[]" value="{{ $link->id }}">
                                
                                <button type="button" class="cursor-move text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                </button>

                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $link->label }}</p>
                                    <a href="{{ $link->url }}" target="_blank" class="text-sm text-gray-500 hover:text-blue-600 truncate block">
                                        {{ $link->url }}
                                    </a>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="button" 
                                            onclick="editLink({{ $link->id }}, '{{ $link->label }}', '{{ $link->url }}')"
                                            class="p-2 text-gray-400 hover:text-gray-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('admin.events.links.destroy', [$event, $link]) }}" 
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar este enlace?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                    @if($event->links->count() > 1)
                        <div class="mt-4 text-right">
                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Guardar orden
                            </button>
                        </div>
                    @endif
                </form>
            @else
                <p class="text-gray-500 text-center py-8">No hay enlaces configurados</p>
            @endif
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Editar Enlace</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Etiqueta</label>
                            <input type="text" name="label" id="edit-label" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                            <input type="url" name="url" id="edit-url" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                    </div>
                    <div class="p-6 border-t border-gray-200 flex justify-end gap-4">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium">Cancelar</button>
                        <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function editLink(id, label, url) {
        document.getElementById('edit-form').action = "{{ route('admin.events.links.update', [$event, ':link']) }}".replace(':link', id);
        document.getElementById('edit-label').value = label;
        document.getElementById('edit-url').value = url;
        document.getElementById('edit-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('edit-modal').classList.add('hidden');
    }
</script>
@endpush
