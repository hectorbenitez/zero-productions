@props(['icon' => null, 'label' => null, 'value', 'href' => null])
@php($tag = $href ? 'a' : 'div')
<{{ $tag }} {{ $attributes->merge(['class' => 'rf-chip']) }} @if($href) href="{{ $href }}" target="_blank" rel="noopener" @endif>
    @if($icon)<x-rock-icon :name="$icon" />@endif
    <div>
        @if($label)<span class="rf-label">{{ $label }}</span>@endif
        <span class="rf-chip-value">{{ $value }}</span>
    </div>
</{{ $tag }}>
