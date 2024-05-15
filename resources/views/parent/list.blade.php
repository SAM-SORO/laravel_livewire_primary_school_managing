<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parents d\'élève (' . $totalParents . ')') }}
        </h2>
    </x-slot>

    <div class="py-6 px-12">
        @livewire('liste-parent')
    </div>
</x-app-layout>
