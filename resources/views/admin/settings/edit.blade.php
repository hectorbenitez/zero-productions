@extends('layouts.admin')

@section('title', 'Configuración')

@section('content')
    <x-rf-page-header eyebrow="Panel" title="Configuración" sub="Gestiona la información general del sitio" />

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Company Info -->
            <section class="rf-panel rf-panel-flat">
                <div class="rf-panel-h">
                    <h2>Información de la Empresa</h2>
                </div>
                <div class="rf-panel-b space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rf-field">
                            <label for="company_name" class="rf-label">Nombre de la Empresa *</label>
                            <input type="text"
                                   name="company_name"
                                   id="company_name"
                                   value="{{ old('company_name', $settings->company_name) }}"
                                   class="rf-input"
                                   required>
                            @error('company_name')
                                <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="rf-field">
                            <label for="contact_email" class="rf-label">Correo de Contacto *</label>
                            <input type="email"
                                   name="contact_email"
                                   id="contact_email"
                                   value="{{ old('contact_email', $settings->contact_email) }}"
                                   class="rf-input"
                                   required>
                            @error('contact_email')
                                <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rf-field">
                            <label for="contact_phone" class="rf-label">Teléfono</label>
                            <input type="text"
                                   name="contact_phone"
                                   id="contact_phone"
                                   value="{{ old('contact_phone', $settings->contact_phone) }}"
                                   class="rf-input"
                                   placeholder="+52 55 1234 5678">
                        </div>
                        <div class="rf-field">
                            <label for="whatsapp" class="rf-label">WhatsApp</label>
                            <input type="text"
                                   name="whatsapp"
                                   id="whatsapp"
                                   value="{{ old('whatsapp', $settings->whatsapp) }}"
                                   class="rf-input"
                                   placeholder="+52 55 1234 5678">
                        </div>
                    </div>

                    <div class="rf-field">
                        <label for="address" class="rf-label">Ubicación</label>
                        <input type="text"
                               name="address"
                               id="address"
                               value="{{ old('address', $settings->address) }}"
                               class="rf-input"
                               placeholder="Calle, Ciudad, País">
                    </div>
                </div>
            </section>

            <!-- Social Media -->
            <section class="rf-panel rf-panel-flat">
                <div class="rf-panel-h">
                    <h2>Redes Sociales</h2>
                </div>
                <div class="rf-panel-b space-y-6">
                    <div class="rf-field">
                        <label for="instagram_url" class="rf-label">Instagram</label>
                        <input type="url"
                               name="instagram_url"
                               id="instagram_url"
                               value="{{ old('instagram_url', $settings->instagram_url) }}"
                               class="rf-input"
                               placeholder="https://instagram.com/...">
                        @error('instagram_url')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rf-field">
                        <label for="facebook_url" class="rf-label">Facebook</label>
                        <input type="url"
                               name="facebook_url"
                               id="facebook_url"
                               value="{{ old('facebook_url', $settings->facebook_url) }}"
                               class="rf-input"
                               placeholder="https://facebook.com/...">
                        @error('facebook_url')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="rf-field">
                        <label for="youtube_url" class="rf-label">YouTube</label>
                        <input type="url"
                               name="youtube_url"
                               id="youtube_url"
                               value="{{ old('youtube_url', $settings->youtube_url) }}"
                               class="rf-input"
                               placeholder="https://youtube.com/...">
                        @error('youtube_url')
                            <p class="rf-error"><x-rock-icon name="alert" />{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <!-- Hero Section -->
            <section class="rf-panel rf-panel-flat">
                <div class="rf-panel-h">
                    <h2>Sección Hero (Inicio)</h2>
                </div>
                <div class="rf-panel-b space-y-6">
                    <div class="rf-field">
                        <label for="hero_title" class="rf-label">Título</label>
                        <input type="text"
                               name="hero_title"
                               id="hero_title"
                               value="{{ old('hero_title', $settings->hero_title) }}"
                               class="rf-input"
                               placeholder="Dejar vacío para usar el nombre de la empresa">
                    </div>

                    <div class="rf-field">
                        <label for="hero_subtitle" class="rf-label">Subtítulo</label>
                        <input type="text"
                               name="hero_subtitle"
                               id="hero_subtitle"
                               value="{{ old('hero_subtitle', $settings->hero_subtitle) }}"
                               class="rf-input"
                               placeholder="Producción de eventos y conciertos de primer nivel">
                    </div>
                </div>
            </section>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="rf-btn rf-btn-primary">
                Guardar Cambios
            </button>
        </div>
    </form>
@endsection
