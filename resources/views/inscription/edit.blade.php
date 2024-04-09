<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'nscription') }}
        </h2>
    </x-slot>

    <div class="py-2 px-12">
        @livewire('edit-inscription', ['inscription' => $inscription])
    </div>
</x-app-layout>
