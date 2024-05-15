<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier batiment') }}
        </h2>
    </x-slot>

    {{-- c'est avec la vue de livewire que je definit le contenue de mon code --}}

    <div class="py-12">
        <div class="mx-auto py-2 sm:px-6  lg:px-8" style="max-width: 46rem">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @livewire("edit-batiment" , ['batiment'=>$batiment])
            </div>
        </div>
    </div>

</x-app-layout>
