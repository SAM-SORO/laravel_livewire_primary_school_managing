<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et Boutton crée --}}

        <div class="flex justify-between items-center">
            <div class="w-100 flex xl:justify-between">
                <div class="xl:w-80 md:w-80 sm:60">
                    <input type="search" wire:model.live="searchEnter" id="search" class="block mt-1 border-gray-300 rounded-sm text-sm w-full" placeholder="Rechercher">
                </div>
            </div>

            {{-- menu deroulant pour le filtre selon l'inscription le text du bouton est gerer par livewire--}}
            <div class="relative">
                <button id="dropdownBoutonFiltreInscrit" data-dropdown-toggle="dropdownFiltreInscrit" data-dropdown-placement="" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                    {{ $selectedFiltreInscrit }} <!-- le nom du bouton sera gerer par livewire-->
                    <svg class="w-2.5 h-2.5 ml-2 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button> <!-- bouton du menu -->

                <!--menu -->
                <div id="dropdownFiltreInscrit" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 top-full mt-1">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownBoutonFiltreInscrit">
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreInscrit', 'Eleves inscrit')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Elèves Inscrit</a>
                        </li>
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreInscrit', 'Inscriptions soldé')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Inscriptions soldé</a>
                        </li>
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreInscrit', 'Inscriptions non soldé')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Inscriptions non soldé</a>
                        </li>
                    </ul>
                </div>
            </div>


            {{-- menu deroulant pour le filtre par niveau--}}
            <div class="relative">
                <button id="dropdownBoutonFiltreNiveau" data-dropdown-toggle="dropdownFiltreNiveau" data-dropdown-placement="" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                    {{ $selectedFiltreNiveau }}
                    <svg class="w-2.5 h-2.5 ms-3 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button> <!-- boutons du menu -->

                <!-- Dropdown menu -->
                <div id="dropdownFiltreNiveau" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 top-full mt-1">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownBottomButtonFiltreNiveau">
                        <li>
                            <a href="#" wire:click="$set('selectedFiltreNiveau', 'Tous les niveaux')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tous les niveaux</a>
                        </li>
                        @foreach ($levels as $item)
                            <li>
                                <a href="#" wire:click="$set('selectedFiltreNiveau', {{$item->id}})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$item->libele}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <a href="{{ route('create-inscription') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Faire une inscription</a>
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
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Photo</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Matricule</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Nom</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prenom</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Niveau</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Etat paiement</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Actions/Paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inscriptionList as $item)
                                    <tr class="border-b-2 border-gray-100">

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <div class="flex justify-center">
                                                @if ($item->student->photo)
                                                    <img src="{{ asset('storage/img/'. $item->student->photo)}}" alt="{{ $item->nom}}" class="w-20 h-20 rounded-full">
                                                @else
                                                    <span class="text-sm font-medium text-gray-900">Pas de photo</span>
                                                @endif
                                            </div>

                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->matricule }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->nom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->prenom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->level->libele}}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            @if ($item->etatInscription)
                                                <button class="bg-green-600 text-white p-2 rounded-sm cursor-default">soldé</button>
                                            @else
                                                <button class="bg-orange-600 text-white p-2 rounded-sm cursor-default">{{$item->montant}}/{{$item->level->scolarite}}</button>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="flex align-items-center gap-2 justify-center">
                                                <div class="text-sm bg-blue-500 p-2 text-white rounded-lg">
                                                    <a href="{{ route('edit-inscription', $item->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="white" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2z"/></svg>
                                                    <a>
                                                </div>

                                                <div wire:click="confirmDelete({{ $item->id }})" class="text-sm bg-red-500 p-2 text-white rounded-lg cursor-pointer">
                                                    <a href="#">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="white" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/>
                                                        </svg>
                                                    </a>
                                                </div>



                                                @if ($item->etatInscription)
                                                    <div class="ml-1">
                                                        <p class="cursor-default"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><path fill="none" stroke="#3fa63f" stroke-width="2" d="M20 15c-1 1 1.25 3.75 0 5s-4-1-5 0s-1.5 3-3 3s-2-2-3-3s-3.75 1.25-5 0s1-4 0-5s-3-1.5-3-3s2-2 3-3s-1.25-3.75 0-5s4 1 5 0s1.5-3 3-3s2 2 3 3s3.75-1.25 5 0s-1 4 0 5s3 1.5 3 3s-2 2-3 3ZM7 12l3 3l7-7"/></svg></p>
                                                    </div>
                                                @else
                                                    <div class="bg-orange-600 rounded-lg text-white ml-1">
                                                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><path fill="white" d="M3 6v12h10.32a6.4 6.4 0 0 1-.32-2H7a2 2 0 0 0-2-2v-4c1.11 0 2-.89 2-2h10a2 2 0 0 0 2 2v.06c.67 0 1.34.12 2 .34V6zm9 3c-1.7.03-3 1.3-3 3s1.3 2.94 3 3c.38 0 .77-.08 1.14-.23c.27-1.1.72-2.14 1.83-3.16C14.85 10.28 13.59 8.97 12 9m7 2l2.25 2.25L19 15.5V14c-1.85 0-3.06 1.96-2.24 3.62l-1.09 1.09c-1.76-2.66.14-6.21 3.33-6.21zm0 11l-2.25-2.25L19 17.5V19c1.85 0 3.06-1.96 2.24-3.62l1.09-1.09c1.76 2.66-.14 6.21-3.33 6.21z"/></svg></a>
                                                    </div>
                                                @endif

                                            </div>

                                        </td>
                                    </tr>
                                @empty

                                    <td class="flex-1 w-full justify-center items-center justify-center" colspan="8">
                                        <div class="flex flex-col items-center align-items-center justify-center mt-3">
                                            <div><img src="{{ asset('storage/empty.svg') }}" alt="" class="w-20 h-20"></div>
                                            <div>Aucun élément trouvé!</div>
                                        </div>
                                    </td>

                                @endforelse


                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $inscriptionList->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal de confirmation de suppression -->
    <div id="popup-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Le contenu du modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <!-- Icone de suppression -->
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Supprimer l'inscription</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer cette inscription?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteInscription" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Supprimer
                    </button>
                    <button wire:click="$set('inscriptionIdToDelete', null)" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>


