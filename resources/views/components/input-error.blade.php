@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li class="rf-error"><x-rock-icon name="alert" />{{ $message }}</li>
        @endforeach
    </ul>
@endif
