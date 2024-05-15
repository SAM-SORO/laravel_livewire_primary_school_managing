<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{-- {{ __('Update Password') }} --}}
        {{ __('Mettre à jour le mot de passe') }}
    </x-slot>

    <x-slot name="description">
        {{-- {{ __('Ensure your account is using a long, random password to stay secure.') }} --}}
        {{ __('Assurer vous d\'utiliser un mot de passe fort.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            {{-- <x-label for="current_password" value="{{ __('Current Password') }}" /> --}}
            <x-label for="current_password" value="{{ __('Mot de passe actuelle') }}" />

            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model="state.current_password" autocomplete="current-password" />
            <x-input-error for="current_password" class="mt-2" />

        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('Nouveau mot de passe') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model="state.password" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirmer le mot de passe') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model="state.password_confirmation" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Sauvegarder') }}
        </x-action-message>

        <x-button>
            {{ __('Sauvegarder') }}
        </x-button>
    </x-slot>
</x-form-section>
