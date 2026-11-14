<button {{ $attributes->merge(['type' => 'submit', 'class' => 'rf-btn rf-btn-primary']) }}>
    {{ $slot }}
</button>
