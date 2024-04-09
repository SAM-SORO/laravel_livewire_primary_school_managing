<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et Boutton crée --}}

        <div class="flex justify-between items-center">
            <div class="w-100 flex xl:justify-between">
                <div class="xl:w-80 md:w-80 sm:60">
                    <input type="search" wire:model.live="searchEnter" id="search" class="block mt-1 border-gray-300 rounded-sm text-sm w-full" placeholder="Rechercher">
                </div>
            </div>

            {{-- menu deroulant pour le filtre selon affectation le text du bouton est gerer par livewire--}}
            <div class="relative">
                <button id="dropdownBoutonFiltreAffecter" data-dropdown-toggle="dropdownFiltreAffecter" data-dropdown-placement="" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                    {{ $selectedFiltreAffecter }} <!-- le nom du bouton sera gerer par livewire-->
                    <svg class="w-2.5 h-2.5 ml-2 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button> <!-- bouton du menu -->

                <!--menu -->
                <div id="dropdownFiltreAffecter" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 top-full mt-1">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownBoutonFiltreAffecter">
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreAffecter', 'Elèves Affecter')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Elèves affecter</a>
                        </li>
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreAffecter', 'Elèves non affecter')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Elèves non affecter</a>
                        </li>
                    </ul>
                </div>
            </div>


            {{-- menu deroulant pour le filtre par niveau--}}
            <div class="relative">
                <button id="dropdownBoutonFiltreClasse" data-dropdown-toggle="dropdownFiltreClasse" data-dropdown-placement="" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                    {{ $selectedFiltreClasse }}
                    <svg class="w-2.5 h-2.5 ms-3 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button> <!-- boutons du menu -->

                <!-- Dropdown menu -->
                <div id="dropdownFiltreClasse" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 top-full mt-1">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownBottomButtonFiltreClasse">
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreClasse', 'Toutes les classes')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Toutes les classes</a>
                        </li>
                        @foreach ($classes as $item)
                            <li>
                                <a href="#" wire:click="$set('selectedFiltreClasse', {{$item->id}})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$item->nom}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <a href="{{ route('create-affectation') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Faire une affectation</a>
        </div>

        @if (Session::has('success'))
            <div class="border-green-500 bg-green-400 text-white text-sm font-bold px-4 mt-6 py-3 rounded relative" id="success-ajout">
                <span>{{ Session::get('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-success">
                    <svg class="fill-current h-6 w-6 text-white-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <title>Close</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
            </div>
        @endif

        <div class="flex flex-col">

            {{-- Styliser le tableau --}}

            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">id</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Classe</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Effectif/Capacite</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($affectationList as $item)
                                    <tr class="border-b-2 border-gray-100">

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->photo }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->matricule }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->nom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->prenom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->classe->idBat }} - {{ $item->classe->idLevel }}</td>

                                        <td>
                                            <div class="flex align-items-center gap-5 justify-center">
                                                <div class="text-sm bg-blue-500 p-2 text-white rounded-sm">
                                                    <a href="{{ route('edit-affectation', $item->id) }}">Modifier<a>
                                                </div>
                                                <div wire:click="delete({{ $item->id }})" class="text-sm bg-red-500 p-2 text-white rounded-sm cursor-pointer">Supprimer</div>
                                            </div>

                                        </td>
                                    </tr>
                                @empty
                                    <tr class="w-full">
                                        <td class=" flex-1 w-full items-center justify-center" colspan="4">
                                            <div>
                                                <p class="flex justify-center content-center p-4"> <img
                                                        src="{{ asset('storage/empty.svg') }}" alt=""
                                                        class="w-20 h-20">
                                                <div>Aucun élément trouvé!</div>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $affectationList->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

    
