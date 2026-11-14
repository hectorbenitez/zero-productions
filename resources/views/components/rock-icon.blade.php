@props(['name', 'size' => null, 'title' => null])
{{-- ZeroPass Riff RockIcon: 24x24 strokes, 1.75 width, square caps, miter joins, currentColor.
     Paths copied verbatim from koden-zero-design-system/system/components/bundle.js (ICONS). --}}
<svg {{ $attributes->merge(['class' => 'rf-icon']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"
     stroke-linecap="square" stroke-linejoin="miter"
     @if($title) role="img" @else aria-hidden="true" @endif
     @if($size) style="width: {{ $size }}px; height: {{ $size }}px;" @endif>
    @if($title)<title>{{ $title }}</title>@endif
    @switch($name)
        @case('date')
            <path d="M3.5 5.5h17v15h-17z"/><path d="M3.5 9.5h17M8 3v4M16 3v4"/><path d="M13 11.5l-3 4.5h4l-3 4" stroke-width="1.5"/>
            @break
        @case('venue')
            <path d="M12 21.5C8 17 3.5 12 3.5 7.5 3.5 4.5 7 2.5 12 2.5s8.5 2 8.5 5c0 4.5-4.5 9.5-8.5 14z" stroke-linejoin="round"/><path d="M12 5.6l.95 1.9 2.1.3-1.5 1.5.35 2.1-1.9-1-1.9 1 .35-2.1-1.5-1.5 2.1-.3z" stroke-width="1.25" stroke-linejoin="round" fill="currentColor"/>
            @break
        @case('presenter')
            <path d="M7 13V4.75a1.25 1.25 0 0 1 2.5 0V11a1.5 1.5 0 0 1 3 0 1.5 1.5 0 0 1 3 0V6.25a1.25 1.25 0 0 1 2.5 0V15a5 5 0 0 1-5 5h-1.5a5 5 0 0 1-4.5-2.8V13z" stroke-linejoin="round"/><path d="M7 15.5l2.5-1.5h3.5" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('share')
            <path d="M3.5 9.5h4l9-5v15l-9-5h-4z"/><path d="M7.5 14.5l1.5 6h2.5l-1-5.2M19.5 9.5v5"/>
            @break
        @case('print')
            <path d="M6.5 9V3.5h11V9M6.5 17.5h-3v-8h17v8h-3"/><path d="M6.5 14h11v6.5h-11z"/>
            @break
        @case('ticket')
            <path d="M3.5 6.5h17v3.5a2 2 0 0 0 0 4v3.5h-17v-3.5a2 2 0 0 0 0-4z"/><path d="M15 7.5v1.5M15 11.25v1.5M15 15v1.5" stroke-width="1.5"/>
            @break
        @case('bolt')
            <path d="M13.5 2.5l-8 11h6l-1 8 8-11h-6z"/>
            @break
        @case('amp')
            <path d="M4.5 3.5h15v17h-15z"/><path d="M12 10.5a3.75 3.75 0 1 1 0 7.5 3.75 3.75 0 0 1 0-7.5z"/><path d="M8 7h1M11.5 7h1M15 7h1"/>
            @break
        @case('arrow-right')
            <path d="M4 12h15M13 6l6 6-6 6"/>
            @break
        @case('arrow-left')
            <path d="M20 12H5M11 6l-6 6 6 6"/>
            @break
        @case('check')
            <path d="M5 12.5l4.5 4.5L19 7.5"/>
            @break
        @case('alert')
            <path d="M12 3.5l9.5 17h-19z"/><path d="M12 10v4M12 17v.5"/>
            @break
        @case('lock')
            <path d="M5.5 10.5h13v10h-13z"/>
            <path d="M8.5 10.5V7a3.5 3.5 0 0 1 7 0v3.5M12 14.5v2"/>
            @break
        @case('home')
            <path d="M3.5 11L12 3.5l8.5 7.5"/>
            <path d="M5.5 9.5v11h13v-11"/>
            <path d="M10 20.5v-6h4v6"/>
            @break
        @case('settings')
            <path d="M6 3.5v10M6 17.5v3M12 3.5v3M12 10.5v10M18 3.5v8M18 15.5v5"/>
            <path d="M4 13.5h4v4h-4zM10 6.5h4v4h-4zM16 11.5h4v4h-4z"/>
            @break
        @case('mail')
            <path d="M3.5 5.5h17v13h-17z"/>
            <path d="M3.5 6.5l8.5 6.5 8.5-6.5"/>
            @break
        @case('external')
            <path d="M10 5.5H4.5v14h14V14"/>
            <path d="M14 3.5h6.5V10M20.5 3.5l-9 9"/>
            @break
        @case('logout')
            <path d="M10 3.5H4.5v17H10"/>
            <path d="M9 12h11.5M16 7.5l4.5 4.5-4.5 4.5"/>
            @break
        @case('edit')
            <path d="M4.5 19.5l1-4.5 10-10 3.5 3.5-10 10z"/>
            <path d="M13 7.5l3.5 3.5M12 19.5h8"/>
            @break
        @case('eye')
            <path d="M2.5 12C5 7.5 8.5 5.5 12 5.5s7 2 9.5 6.5c-2.5 4.5-6 6.5-9.5 6.5S5 16.5 2.5 12z"/>
            <path d="M12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
            @break
        @case('trash')
            <path d="M3.5 6.5h17M9 6.5v-3h6v3"/>
            <path d="M5.5 6.5l1 14h11l1-14"/>
            <path d="M10 10.5v6M14 10.5v6"/>
            @break
        @case('image')
            <path d="M3.5 4.5h17v15h-17z"/>
            <path d="M3.5 16l5-5 4.5 4.5 2.5-2.5 5 5"/>
            <path d="M15.5 8.5h1v1h-1z"/>
            @break
        @case('link')
            <path d="M10.5 13.5l3-3"/>
            <path d="M8.5 11L6 13.5a3 3 0 0 0 4.5 4.5l2.5-2.5M15.5 13l2.5-2.5A3 3 0 0 0 13.5 6L11 8.5"/>
            @break
        @case('drag')
            <path d="M4.5 9.5h15M4.5 14.5h15"/>
            <path d="M9.5 5.5L12 3l2.5 2.5M9.5 18.5L12 21l2.5-2.5"/>
            @break
        @case('plus')
            <path d="M12 4.5v15M4.5 12h15"/>
            @break
        @case('close')
            <path d="M5.5 5.5l13 13M18.5 5.5l-13 13"/>
            @break
        @case('menu')
            <path d="M3.5 6.5h17M3.5 12h17M3.5 17.5h17"/>
            @break
    @endswitch
</svg>
