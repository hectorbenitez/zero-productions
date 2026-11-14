@extends('layouts.admin')

@section('title', 'Mensaje de ' . $message->name)

@section('content')
    <div class="mb-6">
        <x-rf-button :href="route('admin.contact-messages.index')" variant="ghost" icon="arrow-left">Volver a Mensajes</x-rf-button>
    </div>

    <div class="rf-page-h">
        <div class="min-w-0">
            <span class="rf-label">Mensaje de contacto</span>
            <h1 class="break-words">{{ $message->name }}</h1>
            <p class="rf-page-sub"><a href="mailto:{{ $message->email }}" class="text-riff-text hover:text-bone font-mono text-sm">{{ $message->email }}</a></p>
        </div>
        <span class="rf-code shrink-0">
            {{ $message->created_at->format('d/m/Y \a \l\a\s H:i') }}
        </span>
    </div>

    <section class="rf-panel rf-panel-flat max-w-3xl">
        <div class="rf-panel-b">
            <p class="whitespace-pre-line leading-relaxed">{{ $message->message }}</p>
        </div>

        <div class="rf-panel-f">
            <a href="mailto:{{ $message->email }}" class="rf-btn rf-btn-primary">
                <x-rock-icon name="mail" />
                Responder
            </a>

            <form action="{{ route('admin.contact-messages.destroy', $message) }}"
                  method="POST"
                  onsubmit="return confirm('¿Eliminar este mensaje?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rf-btn rf-btn-danger">
                    <x-rock-icon name="trash" />
                    Eliminar mensaje
                </button>
            </form>
        </div>
    </section>
@endsection
