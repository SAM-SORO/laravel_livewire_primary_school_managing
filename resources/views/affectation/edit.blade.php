<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editer une inscription') }}
        </h2>
    </x-slot>

    <div class="py-2 px-12">
        @livewire('edit-affectation', ['affectation' => $affectation])
    </div>
</x-app-layout>
