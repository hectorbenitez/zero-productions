{{-- Riff TextLink: uppercase riff-text link with a trailing arrow (mirrors TextLink in bundle.js) --}}
<a {{ $attributes->merge(['class' => 'rf-link']) }}>{{ $slot }}<x-rock-icon name="arrow-right" /></a>
