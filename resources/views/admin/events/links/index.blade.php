@extends('layouts.admin')

@section('title', 'Enlaces - ' . $event->title)

@section('content')
    <div class="mb-6">
        <x-rf-button :href="route('admin.events.edit', $event)" variant="ghost" icon="arrow-left">Volver al Evento</x-rf-button>
    </div>

    <div class="rf-page-h">
        <div class="min-w-0">
            <span class="rf-label">{{ $event->title }}</span>
            <h1>Enlaces de Boletos</h1>
        </div>
    </div>

    <div class="rf-panel rf-panel-flat mb-6">
        <!-- Add New Link Form -->
        <form action="{{ route('admin.events.links.store', $event) }}" method="POST" class="rf-panel-band">
            @csrf
            <div class="flex flex-col sm:flex-row gap-4 sm:items-start">
                <div @class(['rf-field flex-1', 'is-error' => $errors->has('label')])>
                    <label for="new-label" class="rf-label">Etiqueta</label>
                    <input type="text"
                           name="label"
                           id="new-label"
                           placeholder="Etiqueta (ej: Ticketmaster)"
                           value="{{ old('label') }}"
                           class="rf-input"
                           required>
                    @error('label')
                        <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                    @enderror
                </div>
                <div @class(['rf-field flex-1', 'is-error' => $errors->has('url')])>
                    <label for="new-url" class="rf-label">URL</label>
                    <input type="url"
                           name="url"
                           id="new-url"
                           placeholder="URL (https://...)"
                           value="{{ old('url') }}"
                           class="rf-input"
                           required>
                    @error('url')
                        <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="rf-btn rf-btn-primary whitespace-nowrap sm:mt-[22px]">
                    <x-rock-icon name="plus" />
                    Agregar
                </button>
            </div>
        </form>

        <!-- Links List -->
        <div class="rf-panel-b">
            @if($event->links->count() > 0)
                <form action="{{ route('admin.events.links.reorder', $event) }}" method="POST" id="reorder-form">
                    @csrf
                    <ul class="space-y-3" id="links-list">
                        @foreach($event->links as $link)
                            <li class="flex items-center gap-4 p-4 bg-cab border border-rule border-l-4 border-l-riff" data-id="{{ $link->id }}">
                                <input type="hidden" name="order[]" value="{{ $link->id }}">

                                <button type="button" class="cursor-move text-smoke hover:text-bone" aria-label="Mover">
                                    <x-rock-icon name="drag" />
                                </button>

                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold">{{ $link->label }}</p>
                                    <a href="{{ $link->url }}" target="_blank" class="rf-code hover:text-bone truncate block">
                                        {{ $link->url }}
                                    </a>
                                </div>

                                <div class="flex items-center gap-1">
                                    <button type="button"
                                            onclick="editLink({{ $link->id }}, '{{ $link->label }}', '{{ $link->url }}')"
                                            class="rf-iconbtn" title="Editar" aria-label="Editar">
                                        <x-rock-icon name="edit" />
                                    </button>
                                    <form action="{{ route('admin.events.links.destroy', [$event, $link]) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar este enlace?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rf-iconbtn rf-iconbtn-danger" title="Eliminar" aria-label="Eliminar">
                                            <x-rock-icon name="trash" />
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    @if($event->links->count() > 1)
                        <div class="mt-4 text-right">
                            <button type="submit" class="rf-btn rf-btn-secondary">
                                Guardar orden
                            </button>
                        </div>
                    @endif
                </form>
            @else
                <p class="text-smoke text-center py-8">No hay enlaces configurados</p>
            @endif
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="edit-modal" class="fixed inset-0 z-50 hidden">
        <div class="rf-scrim" onclick="closeModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="rf-modal max-w-md w-full">
                <form id="edit-form" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="rf-panel-h">
                        <h2>Editar Enlace</h2>
                    </div>
                    <div class="rf-panel-b space-y-4">
                        <div class="rf-field">
                            <label for="edit-label" class="rf-label">Etiqueta</label>
                            <input type="text" name="label" id="edit-label" class="rf-input" required>
                        </div>
                        <div class="rf-field">
                            <label for="edit-url" class="rf-label">URL</label>
                            <input type="url" name="url" id="edit-url" class="rf-input" required>
                        </div>
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
