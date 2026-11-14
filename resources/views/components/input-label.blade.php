@props(['value'])

<label {{ $attributes->merge(['class' => 'rf-label block']) }}>
    {{ $value ?? $slot }}
</label>
