<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">

        @if (Session::has('error'))
                <div class="border-red-500 bg-red-400 text-white text-sm font-bold px-4 py-3 rounded relative mt-2 mb-6" id="error-ajout" role="alert" x-data = "{show: true}" x-show="show">
                    <span>{{session('error')}}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-error" @click = "show = false">
                        <svg class="fill-current h-6 w-6 text-white-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="border-green-500 bg-green-400 text-white text-sm font-bold px-4 py-3 rounded relative mt-2 mb-6" id="success-ajout" x-data = "{show: true}" x-show="show">
                    <span>{{ Session::get('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-success" @click = "show = false">
                        <svg class="fill-current h-6 w-6 text-white-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

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
                            <a href="#" wire:click="$set('selectedFiltreInscrit', 'Eleves non inscrit')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Elèves non inscrit</a>
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

            {{-- imprimer --}}

            {{-- <button type="button" class="flex items-center text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg  text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Imprimer la liste
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="ml-1" viewBox="0 0 24 24"><path fill="white" d="M17 7.846H7v-3.23h10zm.615 4.27q.425 0 .713-.288t.287-.713t-.287-.712t-.713-.288t-.712.288t-.288.712t.288.713t.712.287M16 19v-4.538H8V19zm1 1H7v-4H3.577v-5.385q0-.85.577-1.425t1.423-.575h12.846q.85 0 1.425.575t.575 1.425V16H17z"/></svg>

            </button> --}}

            <a href="{{ route('create-inscription') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Faire une inscription</a>
        </div>

        <div class="flex flex-col">
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
                                    @if ($selectedFiltreInscrit !== 'Eleves non inscrit')
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Niveau</th>
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Etat paiement</th>
                                    @endif

                                    @if ($selectedFiltreInscrit === 'Eleves non inscrit')
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Actions/Inscription</th>
                                    @else
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Actions/Paiement</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if ($selectedFiltreInscrit === 'Eleves non inscrit' && !empty($this->studentsNotInscrit))

                                    @forelse ($studentsNotInscritList as $item)
                                        <tr class="border-b-2 border-gray-100">

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                                <div class="flex justify-center">

                                                    <div class="flex justify-center">
                                                        @if ($item->photo)
                                                            <img src="{{ asset('storage/img/'. $item->photo) }}" alt="{{ $item->nom}}" class="w-20 h-20 rounded-full">
                                                        @else
                                                            <span class="text-sm font-medium text-gray-900">
                                                                <img src="{{ asset('utilisateur.png') }}" alt="photo" class="w-20 h-20 rounded-full">
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                            </td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->matricule }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->nom }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->prenom }}</td>

                                            <td>
                                                <div class="flex items-center gap-2 justify-center">

                                                    {{-- modifier --}}
                                                    <div class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                        <a href="{{ route('edit-eleves', $item->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="white" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2z"/></svg>
                                                        <a>
                                                    </div>

                                                    {{-- faire inscription --}}
                                                    <div class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm p-2 dark:bg-green-600 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800 ml-1">
                                                        <a href="{{ route('create-inscription-paiement', $item->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="white" d="M327.027 65.816L229.79 128.23l9.856 5.397l86.51-55.53l146.735 83.116l-84.165 54.023l4.1 2.244v6.848l65.923-42.316l13.836 7.838l-79.76 51.195v11.723l64.633-41.487l15.127 8.57l-79.76 51.195v11.723l64.633-41.487l15.127 8.57l-79.76 51.195v11.723l100.033-64.21l-24.828-14.062l24.827-15.937l-24.828-14.064l24.827-15.937l-23.537-13.333l23.842-15.305zm31.067 44.74c-21.038 10.556-49.06 12.342-68.79 4.383l-38.57 24.757l126.903 69.47l36.582-23.48c-14.41-11.376-13.21-28.35 2.942-41.67zM227.504 147.5l-70.688 46.094l135.61 78.066l1.33-.85c2.5-1.61 6.03-3.89 10.242-6.613c8.42-5.443 19.563-12.66 30.674-19.86c16.002-10.37 24.248-15.72 31.916-20.694zm115.467 1.17a8.583 14.437 82.068 0 1 .003 0a8.583 14.437 82.068 0 1 8.32 1.945a8.583 14.437 82.068 0 1-.87 12.282a8.583 14.437 82.068 0 1-20.273 1.29a8.583 14.437 82.068 0 1 .87-12.28a8.583 14.437 82.068 0 1 11.95-3.237m-218.423 47.115L19.143 263.44l23.537 13.333l-23.842 15.305l24.828 14.063l-24.828 15.938l24.828 14.063l-24.828 15.938l166.135 94.106L285.277 381.8v-11.72l-99.433 63.824L39.11 350.787l14.255-9.15l131.608 74.547L285.277 351.8v-11.72l-99.433 63.824L39.11 320.787l14.255-9.15l131.608 74.547L285.277 321.8v-11.72l-99.433 63.824L39.11 290.787l13.27-8.52l132.9 75.28l99.997-64.188v-5.05l-5.48-3.154l-93.65 60.11l-146.73-83.116l94.76-60.824l-9.63-5.543zm20.46 11.78l-46.92 30.115c14.41 11.374 13.21 28.348-2.942 41.67l59.068 33.46c21.037-10.557 49.057-12.342 68.787-4.384l45.965-29.504l-123.96-71.358zm229.817 32.19c-8.044 5.217-15.138 9.822-30.363 19.688a36222 36222 0 0 1-30.69 19.873c-4.217 2.725-7.755 5.01-10.278 6.632c-.09.06-.127.08-.215.137v85.924l71.547-48.088zm-200.99 17.48a8.583 14.437 82.068 0 1 8.32 1.947a8.583 14.437 82.068 0 1-.87 12.28a8.583 14.437 82.068 0 1-20.27 1.29a8.583 14.437 82.068 0 1 .87-12.28a8.583 14.437 82.068 0 1 11.95-3.236z"/></svg>
                                                        </a>
                                                    </div>

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
                                @else
                                    @forelse ($inscriptionList as $item)
                                    <tr class="border-b-2 border-gray-100">

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <div class="flex justify-center">
                                                @if ($item->student->photo)
                                                    <img src="{{ asset('storage/img/'. $item->student->photo)}}" alt="{{ $item->student->nom}}" class="w-20 h-20 rounded-full">
                                                @else
                                                    <span class="text-sm font-medium text-gray-900">
                                                        <img src="{{ asset('utilisateur.png') }}" alt="{{ $item->student->nom}}" class="w-20 h-20 rounded-full">
                                                    </span>
                                                @endif
                                            </div>

                                        </td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->matricule }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->nom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->prenom }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{($item->level->libele)}}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            @if ($item->etatPaiement === "1")
                                                <button class="bg-green-600 text-white p-2 rounded-sm cursor-default">soldé</button>
                                            @else
                                                <button class="bg-orange-600 text-white p-2 rounded-sm cursor-default">{{$item->montant}} FCFA / {{ $item->level->scolarite }} FCFA</button>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="flex items-center gap-4 justify-center">

                                                {{-- modifier --}}
                                                <div class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                    <a href="{{ route('edit-inscription', $item->id) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="white" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2z"/></svg>
                                                    <a>
                                                </div>

                                                {{-- supprimer --}}
                                                <div wire:click.prevent ="confirmDelete({{ $item->id}} , {{$item->student->id}})" class="focus:outline-none text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm p-2 dark:bg-red-600 dark:hover:bg-red-600 dark:focus:ring-red-900 cursor-pointer">
                                                    <a>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                            <path fill="white" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/>
                                                        </svg>
                                                    </a>
                                                </div>

                                                @if ($item->etatPaiement)
                                                    <div class="ml-1">
                                                        <p class="cursor-default"><svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 24 24"><path fill="none" stroke="#3fa63f" stroke-width="2" d="M20 15c-1 1 1.25 3.75 0 5s-4-1-5 0s-1.5 3-3 3s-2-2-3-3s-3.75 1.25-5 0s1-4 0-5s-3-1.5-3-3s2-2 3-3s-1.25-3.75 0-5s4 1 5 0s1.5-3 3-3s2 2 3 3s3.75-1.25 5 0s-1 4 0 5s3 1.5 3 3s-2 2-3 3ZM7 12l3 3l7-7"/></svg></p>
                                                    </div>
                                                @else
                                                    <div class="text-white bg-orange-600 hover:bg-orange-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm p-2 dark:bg-orange-600 dark:hover:bg-orange-600 focus:outline-none dark:focus:ring-orange-800 ml-1">
                                                        <a href="{{ route('paiement-inscription', $item->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="white" d="M3 6v12h10.32a6.4 6.4 0 0 1-.32-2H7a2 2 0 0 0-2-2v-4c1.11 0 2-.89 2-2h10a2 2 0 0 0 2 2v.06c.67 0 1.34.12 2 .34V6zm9 3c-1.7.03-3 1.3-3 3s1.3 2.94 3 3c.38 0 .77-.08 1.14-.23c.27-1.1.72-2.14 1.83-3.16C14.85 10.28 13.59 8.97 12 9m7 2l2.25 2.25L19 15.5V14c-1.85 0-3.06 1.96-2.24 3.62l-1.09 1.09c-1.76-2.66.14-6.21 3.33-6.21zm0 11l-2.25-2.25L19 17.5V19c1.85 0 3.06-1.96 2.24-3.62l1.09-1.09c1.76 2.66-.14 6.21-3.33 6.21z"/></svg>
                                                        </a>
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
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-3">
                            @if (!empty($inscriptionList) && $inscriptionList->count() > 0)
                                {{ $inscriptionList->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
    document.addEventListener('livewire:init', () => {
        // Écoutez l'événement Livewire pour le changement du filtre Inscrit
        Livewire.on('filtreInscritChanged', function (filtre) {
            // Mettez à jour le titre de la page avec le texte du filtre
            document.getElementById('titlePage').textContent = filtre;
        });

        // Écouter l'événement refresh-page
        Livewire.on('refresh-page', () => {
            // Actualiser la page
            location.reload();
        });
    });


</script>



<script>
    window.addEventListener('show-delete-modal', event => {
        Swal.fire({
            title: "Ete vous sûr de vouloir supprimer cette inscription?",
            text: "cette action est irreversible!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui, supprimer!"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed')
            }
        });
    })

    window.addEventListener('inscription-deleted', event => {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Inscription supprimer avec succèes",
            showConfirmButton: false,
            timer: 1000
        });
    })


</script>

