@extends('layouts.admin')

@section('title', 'Editar Evento')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a Eventos
        </a>
    </div>

    <!-- Event Form -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">Editar Evento <span class="text-sm font-normal text-gray-400">(ID: {{ $event->id }})</span></h1>
            <a href="{{ route('events.show', $event) }}" target="_blank" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Ver en el sitio →
            </a>
        </div>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $event->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', $event->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Lugar</label>
                            <input type="text" 
                                   name="venue" 
                                   id="venue" 
                                   value="{{ old('venue', $event->venue) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                            <input type="text" 
                                   name="city" 
                                   id="city" 
                                   value="{{ old('city', $event->city) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div>
                        <label for="event_datetime" class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora *</label>
                        <input type="datetime-local" 
                               name="event_datetime" 
                               id="event_datetime" 
                               value="{{ old('event_datetime', $event->event_datetime->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('event_datetime') border-red-500 @enderror"
                               required>
                        @error('event_datetime')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                            <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Cover Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Portada</label>
                        @if($event->coverImage)
                            <div class="mb-4">
                                <div class="relative inline-block">
                                    <img src="{{ route('media.show', $event->coverImage) }}" 
                                         alt="Portada actual" 
                                         class="w-48 h-32 object-cover rounded-lg">
                                    <button type="button" 
                                            onclick="document.getElementById('delete-cover-form').submit()"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <input type="file" 
                               name="cover_image" 
                               id="cover_image" 
                               accept="image/jpeg,image/png,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cover_image') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">JPEG, PNG o WebP. Máximo 10MB. {{ $event->coverImage ? 'Subir nueva imagen reemplazará la actual.' : '' }}</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Flyer Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen de Flyer</label>
                        @if($event->flyerImage)
                            <div class="mb-4">
                                <div class="relative inline-block">
                                    <img src="{{ route('media.show', $event->flyerImage) }}" 
                                         alt="Flyer actual" 
                                         class="w-48 h-auto object-contain rounded-lg">
                                    <button type="button" 
                                            onclick="document.getElementById('delete-flyer-form').submit()"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <input type="file" 
                               name="flyer_image" 
                               id="flyer_image" 
                               accept="image/jpeg,image/png,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('flyer_image') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">JPEG, PNG o WebP. Máximo 10MB. Se muestra junto a la info del evento. {{ $event->flyerImage ? 'Subir nueva imagen reemplazará la actual.' : '' }}</p>
                        @error('flyer_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Hidden forms for image deletion (outside the main form to avoid nesting) -->
    @if($event->coverImage)
        <form id="delete-cover-form" 
              action="{{ route('admin.events.delete-cover', $event) }}" 
              method="POST" 
              class="hidden"
              onsubmit="return confirm('¿Eliminar esta imagen?')">
            @csrf
            @method('DELETE')
        </form>
    @endif

    @if($event->flyerImage)
        <form id="delete-flyer-form" 
              action="{{ route('admin.events.delete-flyer', $event) }}" 
              method="POST" 
              class="hidden"
              onsubmit="return confirm('¿Eliminar esta imagen?')">
            @csrf
            @method('DELETE')
        </form>
    @endif

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Links -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Enlaces de Boletos</h2>
                <a href="{{ route('admin.events.links.index', $event) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Gestionar →
                </a>
            </div>
            <div class="p-6">
                @if($event->links->count() > 0)
                    <ul class="space-y-2">
                        @foreach($event->links as $link)
                            <li class="flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                <span class="text-gray-700">{{ $link->label }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500 text-sm">No hay enlaces configurados</p>
                @endif
            </div>
        </div>

        <!-- Gallery -->
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Galería</h2>
                <a href="{{ route('admin.events.gallery.index', $event) }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Gestionar →
                </a>
            </div>
            <div class="p-6">
                @if($event->galleryImages->count() > 0)
                    <div class="flex gap-2 flex-wrap">
                        @foreach($event->galleryImages->take(6) as $image)
                            <img src="{{ route('media.show', $image) }}" 
                                 alt="" 
                                 class="w-16 h-16 object-cover rounded">
                        @endforeach
                        @if($event->galleryImages->count() > 6)
                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                <span class="text-sm text-gray-500">+{{ $event->galleryImages->count() - 6 }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-gray-500 text-sm">No hay imágenes en la galería</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="mt-6 bg-red-50 rounded-xl border border-red-200 overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-red-800 mb-2">Zona de Peligro</h2>
            <p class="text-red-600 text-sm mb-4">Esta acción no se puede deshacer.</p>
            <form action="{{ route('admin.events.destroy', $event) }}" 
                  method="POST" 
                  onsubmit="return confirm('¿Estás seguro de eliminar este evento? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Eliminar Evento
                </button>
            </form>
        </div>
    </div>
@endsection
