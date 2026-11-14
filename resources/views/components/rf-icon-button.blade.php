@props(['icon', 'label', 'tone' => null, 'solid' => false, 'size' => null, 'href' => null, 'type' => 'button'])
{{-- Riff IconButton: 36px square icon-only action (mirrors IconButton in bundle.js) --}}
@php
    $classes = 'rf-iconbtn'
        .($solid ? ' rf-iconbtn-solid' : '')
        .($tone === 'danger' ? ' rf-iconbtn-danger' : '')
        .($size === 'sm' ? ' rf-iconbtn-sm' : '');
@endphp
@if($href)
    <a href="{{ $href }}" title="{{ $label }}" aria-label="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}><x-rock-icon :name="$icon" /></a>
@else
    <button type="{{ $type }}" title="{{ $label }}" aria-label="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}><x-rock-icon :name="$icon" /></button>
@endif
