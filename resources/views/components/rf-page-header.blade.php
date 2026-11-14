@props(['eyebrow' => null, 'title', 'sub' => null])
{{-- Riff PageHeader: eyebrow, condensed title, subline, actions slot (mirrors PageHeader in bundle.js) --}}
<div {{ $attributes->merge(['class' => 'rf-page-h']) }}>
    <div class="min-w-0">
        @if($eyebrow)<span class="rf-label">{{ $eyebrow }}</span>@endif
        <h1 class="break-words">{{ $title }}</h1>
        @if($sub)<p class="rf-page-sub">{{ $sub }}</p>@endif
    </div>
    {{ $slot }}
</div>
