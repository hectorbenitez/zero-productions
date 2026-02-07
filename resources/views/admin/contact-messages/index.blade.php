@extends('layouts.admin')

@section('title', 'Mensajes de Contacto')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Mensajes de Contacto</h1>
        <p class="text-gray-600">Mensajes recibidos desde el formulario de contacto</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">De</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Mensaje</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $message->name }}</p>
                                    <a href="mailto:{{ $message->email }}" class="text-sm text-gray-500 hover:text-blue-600">
                                        {{ $message->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-600 truncate max-w-md">{{ $message->message }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-500">
                                    <p>{{ $message->created_at->format('d/m/Y') }}</p>
                                    <p class="text-sm">{{ $message->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.contact-messages.show', $message) }}" 
                                           class="p-2 text-gray-400 hover:text-gray-600 transition-colors"
                                           title="Ver">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.contact-messages.destroy', $message) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('¿Eliminar este mensaje?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-gray-400 hover:text-blue-600 transition-colors"
                                                    title="Eliminar">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $messages->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500">No hay mensajes todavía</p>
            </div>
        @endif
    </div>
@endsection
