@props(['tone' => 'ok'])
{{-- Riff Alert: status slab, icon and one sentence (mirrors Alert in bundle.js) --}}
<div {{ $attributes->merge(['class' => $tone === 'danger' ? 'rf-alert rf-alert-danger' : 'rf-alert', 'role' => $tone === 'danger' ? 'alert' : 'status']) }}>
    <x-rock-icon :name="$tone === 'danger' ? 'alert' : 'check'" />
    <span>{{ $slot }}</span>
</div>
