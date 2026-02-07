@extends('layouts.admin')

@section('title', 'Galería - ' . $event->title)

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
            <h1 class="text-xl font-bold text-gray-900">Galería de Imágenes</h1>
            <p class="text-gray-600">{{ $event->title }}</p>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('admin.events.gallery.store', $event) }}" method="POST" enctype="multipart/form-data" class="p-6 bg-gray-50 border-b border-gray-200">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <div class="flex-1">
                    <input type="file" 
                           name="images[]" 
                           multiple
                           accept="image/jpeg,image/png,image/webp"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('images') border-blue-500 @enderror @error('images.*') border-blue-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">JPEG, PNG o WebP. Máximo 10MB por imagen. Hasta 10 imágenes a la vez.</p>
                    @error('images')
                        <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors whitespace-nowrap">
                    Subir Imágenes
                </button>
            </div>
        </form>

        <!-- Gallery Grid -->
        <div class="p-6">
            @if($event->galleryImages->count() > 0)
                <form action="{{ route('admin.events.gallery.reorder', $event) }}" method="POST" id="reorder-form">
                    @csrf
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="gallery-grid">
                        @foreach($event->galleryImages as $image)
                            <div class="relative group" data-id="{{ $image->id }}">
                                <input type="hidden" name="order[]" value="{{ $image->id }}">
                                
                                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ route('media.show', $image) }}" 
                                         alt="{{ $image->caption ?? '' }}" 
                                         class="w-full h-full object-cover">
                                </div>

                                <!-- Overlay Actions -->
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center gap-2">
                                    <button type="button" 
                                            onclick="editCaption({{ $image->id }}, '{{ addslashes($image->caption ?? '') }}')"
                                            class="p-2 bg-white rounded-full text-gray-700 hover:text-gray-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <a href="{{ route('media.show', $image) }}" target="_blank" class="p-2 bg-white rounded-full text-gray-700 hover:text-gray-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.events.gallery.destroy', [$event, $image]) }}" 
                                      method="POST"
                                      class="absolute -top-2 -right-2"
                                      onsubmit="return confirm('¿Eliminar esta imagen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-6 h-6 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </form>

                                @if($image->caption)
                                    <p class="mt-2 text-xs text-gray-500 truncate">{{ $image->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($event->galleryImages->count() > 1)
                        <div class="mt-6 text-right">
                            <button type="submit" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                Guardar orden
                            </button>
                        </div>
                    @endif
                </form>

                <p class="mt-4 text-sm text-gray-500">
                    {{ $event->galleryImages->count() }} {{ $event->galleryImages->count() === 1 ? 'imagen' : 'imágenes' }}
                </p>
            @else
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500">No hay imágenes en la galería</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Caption Modal -->
    <div id="caption-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                <form id="caption-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Editar Descripción</h2>
                    </div>
                    <div class="p-6">
                        <input type="text" 
                               name="caption" 
                               id="edit-caption" 
                               placeholder="Descripción de la imagen (opcional)"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
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
    function editCaption(id, caption) {
        document.getElementById('caption-form').action = "{{ route('admin.events.gallery.update', [$event, ':image']) }}".replace(':image', id);
        document.getElementById('edit-caption').value = caption;
        document.getElementById('caption-modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('caption-modal').classList.add('hidden');
    }
</script>
@endpush
