<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rf-btn rf-btn-danger']) }}>
    {{ $slot }}
</button>
