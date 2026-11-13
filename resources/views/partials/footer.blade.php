<footer class="bg-void border-t border-rule mt-auto">
    <div class="zp-wrap">
        <div class="grid grid-cols-1 md:grid-cols-[2fr_1fr_1.4fr] gap-7 md:gap-12 pt-14 pb-10">
            <!-- Company Info -->
            <div>
                <img src="{{ asset('assets/logo-zero-productions-invert.png') }}"
                     alt="{{ $settings->company_name ?? 'Zero Productions' }}"
                     class="h-11 w-11 object-contain">
                <p class="font-display font-black uppercase text-[28px] leading-none text-bone mt-4 max-w-md">
                    Producción de eventos y conciertos de primer nivel.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="rf-label mb-4">Enlaces</h4>
                <ul class="text-sm leading-[26px]">
                    <li><a href="{{ route('home') }}" class="text-ash hover:text-bone transition-colors">Inicio</a></li>
                    <li><a href="{{ route('events.index') }}" class="text-ash hover:text-bone transition-colors">Eventos</a></li>
                    <li><a href="{{ route('contact.show') }}" class="text-ash hover:text-bone transition-colors">Contacto</a></li>
                    <li><a href="https://tickets.zero-productions.com" class="text-ash hover:text-bone transition-colors">Boletos · ZeroPass</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div>
                <h4 class="rf-label mb-4">Contacto</h4>
                <ul class="text-sm leading-[26px] text-ash">
                    <li>
                        <a href="{{ route('contact.show') }}" class="hover:text-bone transition-colors">
                            Escríbenos desde el formulario de contacto
                        </a>
                    </li>
                    @if($settings->contact_phone)
                        <li>
                            <a href="tel:{{ $settings->contact_phone }}" class="hover:text-bone transition-colors">
                                {{ $settings->contact_phone }}
                            </a>
                        </li>
                    @endif
                    @if($settings->address)
                        <li>{{ $settings->address }}</li>
                    @endif
                </ul>

                @if($settings->hasSocialLinks() || $settings->hasWhatsapp())
                    <div class="flex gap-3 mt-3">
                        @if($settings->hasInstagram())
                            <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener" class="zp-soc">
                                <span class="sr-only">Instagram</span>
                                <x-zp-social-icon name="instagram" class="!w-[18px] !h-[18px]" />
                            </a>
                        @endif
                        @if($settings->hasFacebook())
                            <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener" class="zp-soc">
                                <span class="sr-only">Facebook</span>
                                <x-zp-social-icon name="facebook" class="!w-[18px] !h-[18px]" />
                            </a>
                        @endif
                        @if($settings->hasYoutube())
                            <a href="{{ $settings->youtube_url }}" target="_blank" rel="noopener" class="zp-soc">
                                <span class="sr-only">YouTube</span>
                                <x-zp-social-icon name="youtube" class="!w-[18px] !h-[18px]" />
                            </a>
                        @endif
                        @if($settings->hasWhatsapp())
                            <a href="{{ $settings->whatsapp_url }}" target="_blank" rel="noopener" class="zp-soc">
                                <span class="sr-only">WhatsApp</span>
                                <x-zp-social-icon name="whatsapp" class="!w-[18px] !h-[18px]" />
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t border-rule py-5 flex flex-col sm:flex-row sm:justify-between gap-1.5 font-mono text-xs text-smoke">
            <p>&copy; {{ date('Y') }} {{ $settings->company_name ?? 'Zero Productions' }}. Todos los derechos reservados.</p>
            @if($settings->address)
                <p>{{ $settings->address }}</p>
            @endif
        </div>
    </div>
</footer>
