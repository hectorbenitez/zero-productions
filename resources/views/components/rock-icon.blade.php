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
    @endswitch
</svg>
