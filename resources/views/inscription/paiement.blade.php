<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paiement') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        <div class="mx-auto" style="max-width: 46rem">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                @livewire('paiement-inscription', ['inscription' => $inscription])
            </div>
        </div>
    </div>

</x-app-layout>
