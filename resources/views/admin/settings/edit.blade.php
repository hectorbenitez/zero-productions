@extends('layouts.admin')

@section('title', 'Configuración')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Configuración del Sitio</h1>
        <p class="text-gray-600">Gestiona la información general del sitio</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Company Info -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Información de la Empresa</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa *</label>
                            <input type="text" 
                                   name="company_name" 
                                   id="company_name" 
                                   value="{{ old('company_name', $settings->company_name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('company_name') border-blue-500 @enderror"
                                   required>
                            @error('company_name')
                                <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Correo de Contacto *</label>
                            <input type="email" 
                                   name="contact_email" 
                                   id="contact_email" 
                                   value="{{ old('contact_email', $settings->contact_email) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('contact_email') border-blue-500 @enderror"
                                   required>
                            @error('contact_email')
                                <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" 
                                   name="contact_phone" 
                                   id="contact_phone" 
                                   value="{{ old('contact_phone', $settings->contact_phone) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="+52 55 1234 5678">
                        </div>
                        <div>
                            <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" 
                                   name="whatsapp" 
                                   id="whatsapp" 
                                   value="{{ old('whatsapp', $settings->whatsapp) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="+52 55 1234 5678">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" 
                               name="address" 
                               id="address" 
                               value="{{ old('address', $settings->address) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Calle, Ciudad, País">
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Redes Sociales</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">Instagram</label>
                        <input type="url" 
                               name="instagram_url" 
                               id="instagram_url" 
                               value="{{ old('instagram_url', $settings->instagram_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('instagram_url') border-blue-500 @enderror"
                               placeholder="https://instagram.com/...">
                        @error('instagram_url')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">Facebook</label>
                        <input type="url" 
                               name="facebook_url" 
                               id="facebook_url" 
                               value="{{ old('facebook_url', $settings->facebook_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('facebook_url') border-blue-500 @enderror"
                               placeholder="https://facebook.com/...">
                        @error('facebook_url')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 mb-1">YouTube</label>
                        <input type="url" 
                               name="youtube_url" 
                               id="youtube_url" 
                               value="{{ old('youtube_url', $settings->youtube_url) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('youtube_url') border-blue-500 @enderror"
                               placeholder="https://youtube.com/...">
                        @error('youtube_url')
                            <p class="mt-1 text-sm text-blue-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Sección Hero (Inicio)</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                        <input type="text" 
                               name="hero_title" 
                               id="hero_title" 
                               value="{{ old('hero_title', $settings->hero_title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Dejar vacío para usar el nombre de la empresa">
                    </div>

                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 mb-1">Subtítulo</label>
                        <input type="text" 
                               name="hero_subtitle" 
                               id="hero_subtitle" 
                               value="{{ old('hero_subtitle', $settings->hero_subtitle) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Producción de eventos y conciertos de primer nivel">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                Guardar Cambios
            </button>
        </div>
    </form>
@endsection
