@props(['tone' => 'riff', 'tilt' => null, 'icon' => false])
@php
    // Default icon per tone, as in the design system's Stamp component
    $icon = $icon === false ? ['riff' => 'alert', 'volt' => 'bolt', 'ok' => 'check', 'bone' => null][$tone] ?? null : $icon;
@endphp
<span {{ $attributes->merge(['class' => 'rf-stamp rf-stamp-'.$tone]) }} @if(! is_null($tilt)) style="--rf-tilt: {{ $tilt }}deg;" @endif>
    @if($icon)<x-rock-icon :name="$icon" />@endif
    {{ $slot }}
</span>
