<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un élève') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 70rem">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('create-eleve')
            </div>
        </div>
    </div>
</x-app-layout>


