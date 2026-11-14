@if(session('success'))
    <x-rf-alert class="mb-6">{{ session('success') }}</x-rf-alert>
@endif

@if(session('error'))
    <x-rf-alert tone="danger" class="mb-6">{{ session('error') }}</x-rf-alert>
@endif
