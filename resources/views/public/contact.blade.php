@extends('layouts.public')

@section('title', 'Contacto - ' . $settings->company_name)
@section('description', 'Ponte en contacto con nosotros. Estamos aquí para ayudarte con cualquier consulta sobre eventos y conciertos.')

@section('content')
    <div class="zp-wrap">
        <!-- Header -->
        <section class="pt-14 pb-10 sm:pt-[72px] sm:pb-12 border-b-2 border-rule">
            <span class="rf-label">Hablemos</span>
            <h1 class="font-display font-black uppercase text-[76px] sm:text-[144px] leading-[.84] mt-3 mb-4">Contacto</h1>
            <p class="text-[17px] leading-[26px] sm:text-xl sm:leading-[30px] text-ash">
                ¿Tienes alguna pregunta? Estamos aquí para ayudarte.
            </p>
        </section>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)] gap-12 mt-12">
            <!-- Contact Form -->
            <div class="bg-amp border border-rule border-t-4 border-t-riff p-5 sm:p-8">
                <h2 class="font-display font-extrabold uppercase text-4xl leading-none mb-6">Envíanos un mensaje</h2>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-cab border border-rule border-l-4 border-l-ok flex items-center gap-3 text-ok font-semibold" role="status">
                        <x-rock-icon name="check" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Honeypot: hidden field that bots auto-fill --}}
                    <div style="position: absolute; left: -9999px;" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off" value="">
                    </div>

                    {{-- Timestamp to detect instant bot submissions --}}
                    <input type="hidden" name="_form_loaded_at" value="{{ now()->timestamp }}">

                    @if($errors->has('spam'))
                        <p class="rf-error p-4 bg-cab border border-rule border-l-4 border-l-danger" role="alert">
                            <x-rock-icon name="alert" />
                            {{ $errors->first('spam') }}
                        </p>
                    @endif

                    <div @class(['rf-field', 'is-error' => $errors->has('name')])>
                        <label for="name" class="rf-label">Nombre *</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               class="rf-input"
                               placeholder="Tu nombre completo"
                               required>
                        @error('name')
                            <span class="rf-error" role="alert"><x-rock-icon name="alert" />{{ $message }}</span>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('email')])>
                        <label for="email" class="rf-label">Correo electrónico *</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="rf-input"
                               placeholder="tu@email.com"
                               required>
                        @error('email')
                            <span class="rf-error" role="alert"><x-rock-icon name="alert" />{{ $message }}</span>
                        @else
                            <span class="rf-hint">Solo lo usamos para responderte.</span>
                        @enderror
                    </div>

                    <div @class(['rf-field', 'is-error' => $errors->has('message')])>
                        <label for="message" class="rf-label">Mensaje *</label>
                        <textarea name="message"
                                  id="message"
                                  rows="5"
                                  class="rf-input"
                                  placeholder="Escribe tu mensaje aquí..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="rf-error" role="alert"><x-rock-icon name="alert" />{{ $message }}</span>
                        @enderror
                    </div>

                    @if(config('services.turnstile.site_key'))
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}" data-theme="dark"></div>
                    @endif

                    <x-rf-button type="submit" size="lg" icon-right="arrow-right" class="w-full sm:w-auto">Enviar mensaje</x-rf-button>
                </form>
            </div>

            <!-- Contact Info -->
            <aside>
                <h2 class="font-display font-extrabold uppercase text-4xl leading-none mb-6">Información de contacto</h2>

                <div class="flex flex-col gap-3 mb-6">
                    @if($settings->contact_phone)
                        <a href="tel:{{ $settings->contact_phone }}" class="rf-chip !flex">
                            <div>
                                <span class="rf-label">Teléfono</span>
                                <span class="rf-chip-value">{{ $settings->contact_phone }}</span>
                            </div>
                        </a>
                    @endif
                    @if($settings->hasWhatsapp())
                        <a href="{{ $settings->whatsapp_url }}" target="_blank" rel="noopener" class="rf-chip !flex">
                            <x-zp-social-icon name="whatsapp" />
                            <div>
                                <span class="rf-label">WhatsApp</span>
                                <span class="rf-chip-value">{{ $settings->whatsapp }}</span>
                            </div>
                        </a>
                    @endif
                    @if($settings->address)
                        <x-rf-info-chip icon="venue" label="Ubicación" :value="$settings->address" class="!flex" />
                    @endif
                </div>

                <!-- Social Links -->
                @if($settings->hasSocialLinks())
                    <span class="rf-label">Síguenos en redes sociales</span>
                    <div class="flex flex-wrap gap-3 mt-3">
                        @if($settings->hasInstagram())
                            <x-rf-button :href="$settings->instagram_url" variant="secondary" target="_blank" rel="noopener" class="min-w-[160px]">Instagram</x-rf-button>
                        @endif
                        @if($settings->hasFacebook())
                            <x-rf-button :href="$settings->facebook_url" variant="secondary" target="_blank" rel="noopener" class="min-w-[160px]">Facebook</x-rf-button>
                        @endif
                        @if($settings->hasYoutube())
                            <x-rf-button :href="$settings->youtube_url" variant="secondary" target="_blank" rel="noopener" class="min-w-[160px]">YouTube</x-rf-button>
                        @endif
                    </div>
                @endif

                <div class="mt-8 p-5 bg-cab border border-dashed border-rule-strong text-ash text-sm leading-[22px]">
                    <b class="text-bone">¿Buscas boletos?</b>
                    Todos nuestros shows se venden en ZeroPass:
                    <a href="https://tickets.zero-productions.com" class="text-riff-text underline underline-offset-2 hover:text-bone">tickets.zero-productions.com</a>
                </div>
            </aside>
        </div>
    </div>

    <div class="h-20 sm:h-24"></div>
@endsection

@push('scripts')
    @if(config('services.turnstile.site_key'))
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    @endif
@endpush
