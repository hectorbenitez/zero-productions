@extends('layouts.admin')

@section('title', 'Mensajes de Contacto')

@section('content')
    <x-rf-page-header eyebrow="Panel" title="Mensajes" sub="Mensajes recibidos desde el formulario de contacto" />

    @if($messages->count() > 0)
        <div class="rf-table-wrap">
            <table class="rf-table">
                <thead>
                    <tr>
                        <th>De</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr>
                            <td>
                                <p class="font-semibold">{{ $message->name }}</p>
                                <a href="mailto:{{ $message->email }}" class="rf-code hover:text-bone">
                                    {{ $message->email }}
                                </a>
                            </td>
                            <td>
                                <p class="text-ash truncate max-w-md">{{ $message->message }}</p>
                            </td>
                            <td class="whitespace-nowrap">
                                <p class="font-mono">{{ $message->created_at->format('d/m/Y') }}</p>
                                <p class="rf-code">{{ $message->created_at->format('H:i') }}</p>
                            </td>
                            <td class="text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <x-rf-icon-button icon="eye" label="Ver mensaje" :href="route('admin.contact-messages.show', $message)" />
                                    <form action="{{ route('admin.contact-messages.destroy', $message) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('¿Eliminar este mensaje?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-rf-icon-button icon="trash" label="Eliminar mensaje" tone="danger" type="submit" />
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($messages->hasPages())
                <div class="px-4 py-4 border-t border-rule">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="rf-panel rf-panel-flat text-center py-12 px-6">
            <x-rock-icon name="mail" class="text-smoke mx-auto mb-4" />
            <p class="text-ash">No hay mensajes todavía</p>
        </div>
    @endif
@endsection
