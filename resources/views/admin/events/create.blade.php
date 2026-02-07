@extends('layouts.admin')

@section('title', 'Nuevo Evento')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a Eventos
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-xl font-bold text-gray-900">Nuevo Evento</h1>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-blue-500 @enderror"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-blue-500 @enderror"
                               placeholder="Se genera automáticamente del título">
                        @error('slug')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="5"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('description') border-blue-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Lugar</label>
                            <input type="text" 
                                   name="venue" 
                                   id="venue" 
                                   value="{{ old('venue') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ej: Arena CDMX">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
                            <input type="text" 
                                   name="city" 
                                   id="city" 
                                   value="{{ old('city') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Ej: Ciudad de México">
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
                               value="{{ old('event_datetime') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('event_datetime') border-blue-500 @enderror"
                               required>
                        @error('event_datetime')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                        <select name="status" 
                                id="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-blue-500 @enderror">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen de Portada</label>
                        <input type="file" 
                               name="cover_image" 
                               id="cover_image" 
                               accept="image/jpeg,image/png,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cover_image') border-blue-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">JPEG, PNG o WebP. Máximo 10MB.</p>
                        @error('cover_image')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="flyer_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen de Flyer</label>
                        <input type="file" 
                               name="flyer_image" 
                               id="flyer_image" 
                               accept="image/jpeg,image/png,image/webp"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('flyer_image') border-blue-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">JPEG, PNG o WebP. Máximo 10MB. Se muestra junto a la info del evento.</p>
                        @error('flyer_image')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex items-center justify-end gap-4">
                <a href="{{ route('admin.events.index') }}" class="px-4 py-2 text-gray-700 hover:text-gray-900 font-medium transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Crear Evento
                </button>
            </div>
        </form>
    </div>
@endsection
