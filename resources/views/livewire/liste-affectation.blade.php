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
                        @if ($this->selectedFiltreAffecter === "Elèves non affecter")
                            @foreach ($levels as $item)
                                <li>
                                    <a href="#" wire:click="$set('selectedFiltreClasse', {{$item->id}})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$item->libele}}</a>
                                </li>
                            @endforeach
                        @else
                            @foreach ($classes as $item)
                                <li>
                                    <a href="#" wire:click="$set('selectedFiltreClasse', {{$item->id}})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{$item->nom}}</a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <a href="{{ route('create-affectation') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Faire une affectation</a>
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
                                    @if($this->selectedFiltreAffecter === "Elèves non affecter")
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Niveau</th>
                                    @else
                                        <th class="text-sm font-medium text-gray-900 px-6 py-6">Classe</th>
                                    @endif
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($this->selectedFiltreAffecter == "Elèves non affecter")

                                    @forelse ($studentsNotAffecterList as $item)
                                        <tr class="border-b-2 border-gray-100">
                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                                <div class="flex justify-center">
                                                    @if ($item->student->photo)
                                                        <img src="{{ asset('storage/img/'. $item->student->photo)}}" alt="{{ $item->student->nom}}" class="w-20 h-20 rounded-full">
                                                    @else
                                                        <span class="text-sm font-medium text-gray-900">
                                                            <img src="{{ asset('utilisateur.png') }}" alt="{{ $item->nom}}" class="w-20 h-20 rounded-full">
                                                        </span>
                                                    @endif
                                                </div>

                                            </td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->matricule }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->nom }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->prenom }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                                {{ $item->level->libele}}</td>

                                            <td>
                                                <div class="flex items-center gap-2 justify-center">

                                                    {{-- modifier --}}
                                                    <div class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                        <a href="{{ route('edit-eleves', $item->student->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="white" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2z"/></svg>
                                                        <a>
                                                    </div>


                                                    {{-- affectation direct --}}
                                                    <div class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm p-2 dark:bg-green-600 dark:hover:bg-green-600 focus:outline-none dark:focus:ring-green-800 ml-1">
                                                        <a href="{{ route('affectation-directly', $item->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="M18 6v6.26l2 1V6c0-1.1-.9-2-2-2h-4a2.5 2.5 0 0 0-5 0H5.01c-1.1 0-2 .9-2 2v3.8C5.7 9.8 6 11.96 6 12.5s-.29 2.7-3 2.7V19c0 1.1.9 2 2 2h3.8c0-2.16 1.37-2.78 2.2-2.94v-2.03c-1.43.17-3.15 1.04-3.87 2.97H5v-2.13c2.17-.8 3-2.87 3-4.37c0-1.49-.83-3.56-2.99-4.37V6H11V4c0-.28.22-.5.5-.5s.5.22.5.5v2z"/><path fill="white" d="M13 12v4l4 1l-4 1v4l10-5z"/></svg>
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
                                    @forelse ($affectationList as $item)
                                        <tr class="border-b-2 border-gray-100">

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">

                                                <div class="flex justify-center">
                                                    @if ($item->student->photo)
                                                        <img src="{{ asset('storage/img/'. $item->student->photo) }}" alt="{{ $item->nom}}" class="w-20 h-20 rounded-full">
                                                    @else
                                                        <span class="text-sm font-medium text-gray-900">
                                                            <img src="{{ asset('utilisateur.png') }}" alt="photo" class="w-20 h-20 rounded-full">
                                                        </span>
                                                    @endif
                                                </div>

                                            </td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->matricule }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->nom }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6"> {{ $item->student->prenom }}</td>

                                            <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->classe->nom }}</td>

                                            <td>
                                                <div class="flex align-items-center gap-5 justify-center">

                                                    <div class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                        <a href="{{ route('edit-affectation', $item->id) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="white" d="m18.988 2.012l3 3L19.701 7.3l-3-3zM8 16h3l7.287-7.287l-3-3L8 13z"/><path fill="white" d="M19 19H8.158c-.026 0-.053.01-.079.01c-.033 0-.066-.009-.1-.01H5V5h6.847l2-2H5c-1.103 0-2 .896-2 2v14c0 1.104.897 2 2 2h14a2 2 0 0 0 2-2v-8.668l-2 2z"/></svg>
                                                        <a>
                                                    </div>

                                                    <div wire:click.prevent ="confirmDelete({{ $item->id }})" class="focus:outline-none text-white bg-red-700 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm p-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 cursor-pointer">
                                                        <a>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                                <path fill="white" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="w-full">
                                            <td class=" flex-1 w-full items-center justify-center" colspan="6">
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
                                @endif


                            </tbody>
                        </table>

                        <div class="mt-3">
                            @if (!empty($affectationList) && $affectationList->count() > 0)
                                {{ $affectationList->links() }}
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
        Livewire.on('filtreAffectationChanged', function (filtre) {
            // Mettez à jour le titre de la page avec le texte du filtre
            document.getElementById('titlePage').textContent = filtre;
        });
    });
</script>

<script>


    window.addEventListener('show-delete-modal', event => {
        Swal.fire({
            title: "Ete vous sûr de vouloir supprimer cette affectation ?",
            //text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Oui, Supprimer!"
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('deleteConfirmed')
            }
        });
    })

    window.addEventListener('affectation-deleted', event => {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Affectation supprimer avec succès",
            showConfirmButton: false,
            timer: 1000
        });
    })


</script>

