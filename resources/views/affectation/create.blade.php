<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle affectation') }}
        </h2>
    </x-slot>

    <div class="py-12 px-12 mx-auto"  style="max-width: 46rem">
        @livewire('create-affectation')
    </div>
</x-app-layout>
