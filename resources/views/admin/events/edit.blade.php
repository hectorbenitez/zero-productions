@extends('layouts.admin')

@section('title', 'Editar Evento')

@section('content')
    <div class="mb-6">
        <x-rf-button :href="route('admin.events.index')" variant="ghost" icon="arrow-left">Volver a Eventos</x-rf-button>
    </div>

    <div class="rf-page-h">
        <div class="min-w-0">
            <span class="rf-label">Editar evento · <span class="rf-code">ID {{ $event->id }}</span></span>
            <h1 class="break-words">{{ $event->title }}</h1>
        </div>
        <a href="{{ route('events.show', $event) }}" target="_blank" class="rf-link shrink-0">
            Ver en el sitio <x-rock-icon name="arrow-right" />
        </a>
    </div>

    <!-- Event Form -->
    <div class="rf-panel mb-6">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="rf-panel-b">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div @class(['rf-field', 'is-error' => $errors->has('title')])>
                        <label for="title" class="rf-label">Título *</label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $event->title) }}"
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
                               value="{{ old('slug', $event->slug) }}"
                               class="rf-input font-mono">
                        @error('slug')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('description')])>
                        <label for="description" class="rf-label">Descripción</label>
                        <textarea name="description"
                                  id="description"
                                  rows="5"
                                  class="rf-input">{{ old('description', $event->description) }}</textarea>
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
                                   value="{{ old('venue', $event->venue) }}"
                                   class="rf-input">
                        </div>
                        <div class="rf-field">
                            <label for="city" class="rf-label">Ciudad</label>
                            <input type="text"
                                   name="city"
                                   id="city"
                                   value="{{ old('city', $event->city) }}"
                                   class="rf-input">
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
                               value="{{ old('event_datetime', $event->event_datetime->format('Y-m-d\TH:i')) }}"
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
                            <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Publicado</option>
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
                                   {{ old('is_highlighted', $event->is_highlighted) ? 'checked' : '' }}>
                            Evento destacado
                        </label>
                        <p class="rf-hint">Los eventos pasados destacados tienen prioridad en la portada de inicio.</p>
                    </div>

                    <!-- Current Cover Image -->
                    <div @class(['rf-field', 'is-error' => $errors->has('cover_image')])>
                        <label for="cover_image" class="rf-label">Imagen de Portada</label>
                        @if($event->coverImage)
                            <div class="relative inline-block self-start mb-2">
                                <img src="{{ route('media.show', $event->coverImage) }}"
                                     alt="Portada actual"
                                     class="w-48 h-32 object-cover border border-rule">
                                <button type="button"
                                        onclick="document.getElementById('delete-cover-form').submit()"
                                        class="rf-iconbtn rf-iconbtn-solid rf-iconbtn-danger absolute -top-3 -right-3 rf-iconbtn-sm"
                                        title="Eliminar portada" aria-label="Eliminar portada">
                                    <x-rock-icon name="close" />
                                </button>
                            </div>
                        @endif
                        <input type="file"
                               name="cover_image"
                               id="cover_image"
                               accept="image/jpeg,image/png,image/webp"
                               class="rf-input">
                        <p class="rf-hint">JPEG, PNG o WebP. Máximo 10MB. {{ $event->coverImage ? 'Subir nueva imagen reemplazará la actual.' : '' }}</p>
                        @error('cover_image')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Flyer Image -->
                    <div @class(['rf-field', 'is-error' => $errors->has('flyer_image')])>
                        <label for="flyer_image" class="rf-label">Imagen de Flyer</label>
                        @if($event->flyerImage)
                            <div class="relative inline-block self-start mb-2">
                                <img src="{{ route('media.show', $event->flyerImage) }}"
                                     alt="Flyer actual"
                                     class="w-48 h-auto object-contain border border-rule">
                                <button type="button"
                                        onclick="document.getElementById('delete-flyer-form').submit()"
                                        class="rf-iconbtn rf-iconbtn-solid rf-iconbtn-danger absolute -top-3 -right-3 rf-iconbtn-sm"
                                        title="Eliminar flyer" aria-label="Eliminar flyer">
                                    <x-rock-icon name="close" />
                                </button>
                            </div>
                        @endif
                        <input type="file"
                               name="flyer_image"
                               id="flyer_image"
                               accept="image/jpeg,image/png,image/webp"
                               class="rf-input">
                        <p class="rf-hint">JPEG, PNG o WebP. Máximo 10MB. Se muestra junto a la info del evento. {{ $event->flyerImage ? 'Subir nueva imagen reemplazará la actual.' : '' }}</p>
                        @error('flyer_image')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-rule flex flex-wrap items-center justify-end gap-6">
                <x-rf-button :href="route('admin.events.index')" variant="ghost">Cancelar</x-rf-button>
                <x-rf-button type="submit" variant="primary">Guardar Cambios</x-rf-button>
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
        <section class="rf-panel rf-panel-flat">
            <div class="rf-panel-h">
                <h2>Enlaces de Boletos</h2>
                <a href="{{ route('admin.events.links.index', $event) }}" class="rf-link">
                    Gestionar <x-rock-icon name="arrow-right" />
                </a>
            </div>
            <div class="rf-panel-b">
                @if($event->links->count() > 0)
                    <ul class="space-y-2">
                        @foreach($event->links as $link)
                            <li class="flex items-center gap-3 text-sm">
                                <x-rock-icon name="ticket" :size="18" class="text-riff-text" />
                                <span>{{ $link->label }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-smoke text-sm">No hay enlaces configurados</p>
                @endif
            </div>
        </section>

        <!-- Gallery -->
        <section class="rf-panel rf-panel-flat">
            <div class="rf-panel-h">
                <h2>Galería</h2>
                <a href="{{ route('admin.events.gallery.index', $event) }}" class="rf-link">
                    Gestionar <x-rock-icon name="arrow-right" />
                </a>
            </div>
            <div class="rf-panel-b">
                @if($event->galleryImages->count() > 0)
                    <div class="flex gap-2 flex-wrap">
                        @foreach($event->galleryImages->take(6) as $image)
                            <img src="{{ route('media.show', $image) }}"
                                 alt=""
                                 class="w-16 h-16 object-cover border border-rule">
                        @endforeach
                        @if($event->galleryImages->count() > 6)
                            <div class="w-16 h-16 bg-cab border border-rule flex items-center justify-center">
                                <span class="font-mono text-sm text-ash">+{{ $event->galleryImages->count() - 6 }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="text-smoke text-sm">No hay imágenes en la galería</p>
                @endif
            </div>
        </section>
    </div>

    <!-- Danger Zone -->
    <section class="mt-6 rf-panel rf-panel-flat border-danger/60 border-l-4 border-l-danger">
        <div class="rf-panel-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-display font-extrabold text-2xl uppercase text-danger">Zona de Peligro</h2>
                <p class="text-ash text-sm mt-1">Esta acción no se puede deshacer.</p>
            </div>
            <form action="{{ route('admin.events.destroy', $event) }}"
                  method="POST"
                  onsubmit="return confirm('¿Estás seguro de eliminar este evento? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rf-btn rf-btn-danger">
                    <x-rock-icon name="trash" />
                    Eliminar Evento
                </button>
            </form>
        </div>
    </section>
@endsection
