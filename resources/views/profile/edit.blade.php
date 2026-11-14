<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-black text-5xl uppercase leading-none mt-1.5">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-4xl space-y-6">
            <div class="rf-panel rf-panel-flat p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rf-panel rf-panel-flat p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rf-panel rf-panel-flat p-4 sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
