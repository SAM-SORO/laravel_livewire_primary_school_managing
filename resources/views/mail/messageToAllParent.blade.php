<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Message à tous les parents' ) }}

        </h2>
    </x-slot>

    <div class="py-4">
        <div class="mx-auto sm:px-6 lg:px-8" style="max-width: 52rem; margin-top:40px">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire('message-to-all-parent')
            </div>
        </div>
    </div>
</x-app-layout>


