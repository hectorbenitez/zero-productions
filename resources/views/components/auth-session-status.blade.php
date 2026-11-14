@props(['status'])

@if ($status)
    <x-rf-alert {{ $attributes }}>{{ $status }}</x-rf-alert>
@endif
