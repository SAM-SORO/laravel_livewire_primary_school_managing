<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Elèves inscrit et affecter') }}
        </h2>
    </x-slot>

    <div class="py-2 px-12">

        @livewire('liste-affectation')

    </div>
</x-app-layout>
