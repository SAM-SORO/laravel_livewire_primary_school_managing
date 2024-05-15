
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nouvelle Annee Scolaire') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto py-6 sm:px-6 lg:px-8" style="max-width: 46rem">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire("create-school-year")
                {{-- @livewire('li
                ste-niveaux')--}}
            </div>
        </div>
    </div>

</x-app-layout>
