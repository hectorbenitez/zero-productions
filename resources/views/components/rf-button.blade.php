@props(['variant' => 'primary', 'size' => null, 'block' => false, 'icon' => null, 'iconRight' => null, 'href' => null, 'type' => 'button'])
@php
    $classes = 'rf-btn rf-btn-'.$variant.($size === 'lg' ? ' rf-btn-lg' : '').($block ? ' rf-btn-block' : '');
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<x-rock-icon :name="$icon" />@endif{{ $slot }}@if($iconRight)<x-rock-icon :name="$iconRight" />@endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)<x-rock-icon :name="$icon" />@endif{{ $slot }}@if($iconRight)<x-rock-icon :name="$iconRight" />@endif
    </button>
@endif
