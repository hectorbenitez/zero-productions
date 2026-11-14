@extends('layouts.admin')

@section('title', 'Galería - ' . $event->title)

@section('content')
    <div class="mb-6">
        <x-rf-button :href="route('admin.events.edit', $event)" variant="ghost" icon="arrow-left">Volver al Evento</x-rf-button>
    </div>

    <div class="rf-page-h">
        <div class="min-w-0">
            <span class="rf-label">{{ $event->title }}</span>
            <h1>Galería de Imágenes</h1>
        </div>
        @if($event->galleryImages->count() > 0)
            <span class="rf-code shrink-0">{{ $event->galleryImages->count() }} {{ $event->galleryImages->count() === 1 ? 'imagen' : 'imágenes' }}</span>
        @endif
    </div>

    <div class="rf-panel rf-panel-flat mb-6">
        <!-- Upload Form -->
        <form action="{{ route('admin.events.gallery.store', $event) }}" method="POST" enctype="multipart/form-data" class="rf-panel-band">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4 items-start">
                <div @class(['rf-field flex-1 w-full', 'is-error' => $errors->has('images') || $errors->has('images.*')])>
                    <label for="images" class="rf-label">Subir imágenes</label>
                    <input type="file"
                           name="images[]"
                           id="images"
                           multiple
                           accept="image/jpeg,image/png,image/webp"
                           class="rf-input">
                    <p class="rf-hint">JPEG, PNG o WebP. Máximo 10MB por imagen. Hasta 10 imágenes a la vez.</p>
                    @error('images')
                        <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="rf-btn rf-btn-primary whitespace-nowrap sm:mt-[22px]">
                    Subir Imágenes
                </button>
            </div>
        </form>

        <!-- Gallery Grid -->
        <div class="rf-panel-b">
            @if($event->galleryImages->count() > 0)
                <form action="{{ route('admin.events.gallery.reorder', $event) }}" method="POST" id="reorder-form">
                    @csrf
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4" id="gallery-grid" data-sortable>
                        @foreach($event->galleryImages as $image)
                            <div class="relative group" data-id="{{ $image->id }}" data-sortable-item>
                                <input type="hidden" name="order[]" value="{{ $image->id }}">

                                <div class="aspect-square bg-cab border border-rule overflow-hidden">
                                    <img src="{{ route('media.show', $image) }}"
                                         alt="{{ $image->caption ?? '' }}"
                                         class="w-full h-full object-cover">
                                </div>

                                <!-- Overlay Actions -->
                                <div class="absolute inset-0 bg-void/70 opacity-0 group-hover:opacity-100 group-focus-within:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button type="button" class="rf-iconbtn rf-iconbtn-solid cursor-move" data-sortable-handle
                                            title="Arrastra o usa las flechas para mover" aria-label="Mover imagen">
                                        <x-rock-icon name="drag" />
                                    </button>
                                    <button type="button"
                                            onclick="editCaption({{ $image->id }}, '{{ addslashes($image->caption ?? '') }}')"
                                            class="rf-iconbtn rf-iconbtn-solid" title="Editar descripción" aria-label="Editar descripción">
                                        <x-rock-icon name="edit" />
                                    </button>
                                    <a href="{{ route('media.show', $image) }}" target="_blank" class="rf-iconbtn rf-iconbtn-solid" title="Abrir" aria-label="Abrir imagen">
                                        <x-rock-icon name="external" />
                                    </a>
                                </div>

                                <!-- Delete Button: submits its own form below; forms can't nest inside the reorder form -->
                                <button type="submit" form="delete-image-{{ $image->id }}" class="absolute -top-2 -right-2 rf-iconbtn rf-iconbtn-solid rf-iconbtn-danger rf-iconbtn-sm opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity" title="Eliminar" aria-label="Eliminar imagen">
                                    <x-rock-icon name="close" />
                                </button>

                                @if($image->caption)
                                    <p class="mt-2 rf-code truncate">{{ $image->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if($event->galleryImages->count() > 1)
                        <div class="mt-6 flex flex-wrap items-center justify-end gap-4">
                            <p class="rf-hint">Arrastra las imágenes o usa las flechas sobre <x-rock-icon name="drag" :size="16" /> para cambiar el orden.</p>
                            <button type="submit" class="rf-btn rf-btn-secondary">
                                Guardar orden
                            </button>
                        </div>
                    @endif
                </form>

                @foreach($event->galleryImages as $image)
                    <form id="delete-image-{{ $image->id }}"
                          action="{{ route('admin.events.gallery.destroy', [$event, $image]) }}"
                          method="POST"
                          class="hidden"
                          onsubmit="return confirm('¿Eliminar esta imagen?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            @else
                <div class="text-center py-12">
                    <x-rock-icon name="image" :size="48" class="text-smoke mx-auto mb-4" />
                    <p class="text-smoke">No hay imágenes en la galería</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Caption Modal -->
    <div id="caption-modal" class="fixed inset-0 z-50 hidden">
        <div class="rf-scrim" onclick="closeModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="rf-modal max-w-md w-full">
                <form id="caption-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="rf-panel-h">
                        <h2>Editar Descripción</h2>
                    </div>
                    <div class="rf-panel-b">
                        <input type="text"
                               name="caption"
                               id="edit-caption"
                               placeholder="Descripción de la imagen (opcional)"
                               aria-label="Descripción de la imagen"
                               class="rf-input">
                    </div>
                    <div class="rf-panel-f justify-end">
                        <button type="button" onclick="closeModal()" class="rf-btn rf-btn-ghost">Cancelar</button>
                        <button type="submit" class="rf-btn rf-btn-primary">Guardar</button>
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
