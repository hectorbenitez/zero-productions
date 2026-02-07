@extends('layouts.admin')

@section('title', 'Mensaje de ' . $message->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Volver a Mensajes
        </a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900">{{ $message->name }}</h1>
                    <a href="mailto:{{ $message->email }}" class="text-blue-600 hover:text-blue-700">
                        {{ $message->email }}
                    </a>
                </div>
                <span class="text-sm text-gray-500">
                    {{ $message->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="prose max-w-none">
                <p class="whitespace-pre-line text-gray-700">{{ $message->message }}</p>
            </div>
        </div>

        <div class="p-6 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <a href="mailto:{{ $message->email }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Responder
            </a>

            <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                  method="POST"
                  onsubmit="return confirm('¿Eliminar este mensaje?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-blue-600 hover:text-blue-700 font-medium">
                    Eliminar mensaje
                </button>
            </form>
        </div>
    </div>
@endsection
