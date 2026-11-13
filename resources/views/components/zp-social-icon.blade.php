@props(['name'])
{{-- Social marks redrawn in the RockIcon hand (stroke, square caps) for this site's footer and contact page --}}
<svg {{ $attributes->merge(['class' => 'rf-icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
     stroke-linecap="square" stroke-linejoin="miter" aria-hidden="true">
    @switch($name)
        @case('instagram')
            <path d="M3.5 3.5h17v17h-17z"/><path d="M12 8.25a3.75 3.75 0 1 1 0 7.5 3.75 3.75 0 0 1 0-7.5zM17 7h.5"/>
            @break
        @case('facebook')
            <path d="M14.5 21v-7.5h3l.5-3.5h-3.5V8c0-1 .5-1.75 2-1.75H18V3.25c-.5-.1-1.5-.25-2.75-.25C12.5 3 11 4.6 11 7.25V10H8v3.5h3V21"/>
            @break
        @case('youtube')
            <path d="M2.5 5.5h19v13h-19z"/><path d="M10 9v6l5-3z" fill="currentColor" stroke-width="1.25"/>
            @break
        @case('whatsapp')
            <path d="M4 20l1.2-4.2A8.5 8.5 0 1 1 8.4 19z" stroke-linejoin="round"/><path d="M9 8.5c0 3.5 3 6.5 6.5 6.5l1-1.75-2-1-1 1c-1.25-.5-2.25-1.5-2.75-2.75l1-1-1-2z" stroke-width="1.25" stroke-linejoin="round"/>
            @break
    @endswitch
</svg>
