@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-600">Bienvenido al panel de administración</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Eventos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Publicados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['published_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Próximos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['upcoming_events'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Mensajes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['contact_messages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Próximos Eventos</h2>
            </div>
            <div class="p-6">
                @if($upcomingEvents->count() > 0)
                    <div class="space-y-4">
                        @foreach($upcomingEvents as $event)
                            <a href="{{ route('admin.events.edit', $event) }}" class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-bold text-blue-600">{{ $event->event_datetime->format('d') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $event->event_datetime->translatedFormat('M Y') }} · {{ $event->location ?? 'Sin ubicación' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No hay eventos próximos</p>
                @endif
            </div>
        </div>

        <!-- Recent Messages -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Mensajes Recientes</h2>
            </div>
            <div class="p-6">
                @if($recentMessages->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMessages as $message)
                            <a href="{{ route('admin.contact-messages.show', $message) }}" class="block p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-medium text-gray-900">{{ $message->name }}</p>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">{{ $message->message }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No hay mensajes</p>
                @endif
            </div>
        </div>
    </div>
@endsection
