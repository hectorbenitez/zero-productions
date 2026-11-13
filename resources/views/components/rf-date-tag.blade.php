@props(['day', 'month', 'tilt' => true])
<div {{ $attributes->merge(['class' => 'rf-date']) }} @if(! $tilt) style="transform: none;" @endif>
    <span class="rf-date-day">{{ $day }}</span>
    <span class="rf-date-month">{{ $month }}</span>
</div>
