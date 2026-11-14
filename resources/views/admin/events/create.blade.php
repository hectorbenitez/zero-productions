@extends('layouts.admin')

@section('title', 'Nuevo Evento')

@section('content')
    <div class="mb-6">
        <x-rf-button :href="route('admin.events.index')" variant="ghost" icon="arrow-left">Volver a Eventos</x-rf-button>
    </div>

    <div class="rf-page-h">
        <div>
            <span class="rf-label">Eventos</span>
            <h1>Nuevo Evento</h1>
        </div>
    </div>

    <div class="rf-panel">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="rf-panel-b">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div @class(['rf-field', 'is-error' => $errors->has('title')])>
                        <label for="title" class="rf-label">Título *</label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               class="rf-input"
                               required>
                        @error('title')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('slug')])>
                        <label for="slug" class="rf-label">Slug</label>
                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug') }}"
                               class="rf-input font-mono"
                               placeholder="Se genera automáticamente del título">
                        @error('slug')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('description')])>
                        <label for="description" class="rf-label">Descripción</label>
                        <textarea name="description"
                                  id="description"
                                  rows="5"
                                  class="rf-input">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rf-field">
                            <label for="venue" class="rf-label">Lugar</label>
                            <input type="text"
                                   name="venue"
                                   id="venue"
                                   value="{{ old('venue') }}"
                                   class="rf-input"
                                   placeholder="Ej: Arena CDMX">
                        </div>
                        <div class="rf-field">
                            <label for="city" class="rf-label">Ciudad</label>
                            <input type="text"
                                   name="city"
                                   id="city"
                                   value="{{ old('city') }}"
                                   class="rf-input"
                                   placeholder="Ej: Ciudad de México">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div @class(['rf-field', 'is-error' => $errors->has('event_datetime')])>
                        <label for="event_datetime" class="rf-label">Fecha y Hora *</label>
                        <input type="datetime-local"
                               name="event_datetime"
                               id="event_datetime"
                               value="{{ old('event_datetime') }}"
                               class="rf-input [color-scheme:dark]"
                               required>
                        @error('event_datetime')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('status')])>
                        <label for="status" class="rf-label">Estado *</label>
                        <select name="status"
                                id="status"
                                class="rf-select">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                        @error('status')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rf-field">
                        <label for="is_highlighted" class="rf-choice">
                            <input type="checkbox"
                                   name="is_highlighted"
                                   id="is_highlighted"
                                   value="1"
                                   {{ old('is_highlighted') ? 'checked' : '' }}>
                            Evento destacado
                        </label>
                        <p class="rf-hint">Los eventos pasados destacados tienen prioridad en la portada de inicio.</p>
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('cover_image')])>
                        <label for="cover_image" class="rf-label">Imagen de Portada</label>
                        <input type="file"
                               name="cover_image"
                               id="cover_image"
                               accept="image/jpeg,image/png,image/webp"
                               class="rf-input">
                        <p class="rf-hint">JPEG, PNG o WebP. Máximo 10MB.</p>
                        @error('cover_image')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('flyer_image')])>
                        <label for="flyer_image" class="rf-label">Imagen de Flyer</label>
                        <input type="file"
                               name="flyer_image"
                               id="flyer_image"
                               accept="image/jpeg,image/png,image/webp"
                               class="rf-input">
                        <p class="rf-hint">JPEG, PNG o WebP. Máximo 10MB. Se muestra junto a la info del evento.</p>
                        @error('flyer_image')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-rule flex flex-wrap items-center justify-end gap-6">
                <x-rf-button :href="route('admin.events.index')" variant="ghost">Cancelar</x-rf-button>
                <x-rf-button type="submit" variant="primary">Crear Evento</x-rf-button>
            </div>
        </form>
    </div>
@endsection
