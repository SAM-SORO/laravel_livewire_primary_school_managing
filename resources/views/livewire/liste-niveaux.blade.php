<div class="mt-1">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et Boutton crée --}}
        <div class="flex justify-between items-center">
            <div class="w-100 flex xl:justify-between">
                <div class="xl:w-80 md:w-80 sm:60">
                    <input type="search" id="searche" class="block mt-1 border-gray-300 rounded-sm text-sm w-full " placeholder="Rechercher" wire:model="searchEnter">
                </div>
                <button type="button" class="bg-blue-700 ml-4 rounded-md px-2 text-sm text-white" wire:click="search">Rechercher</button>
            </div>
            <a href="{{ route('school.create-school-level') }}" class="bg-blue-500 rounded-md p-2 text-sm text-white">Ajouter niveau</a>
        </div>

        @if (Session::has('success'))
            <div class="border-green-500 bg-green-400 text-white text-sm font-bold px-4 my-4 py-3 rounded relative" id="success-ajout">
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
            {{-- je pouvais l'envoyer sur la page ci apres ajout d'un niveaux --}}
            {{-- Styliser le tableau --}}
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">ID</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Classe</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Montant de la Scolarité</th>
                                    <th class="text-sm font-medium text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($levels as $item)
                                    <tr class="border-b-2 border-gray-100">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->libele }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->scolarite }}</td>

                                        {{-- items-center justify-center" style="vertical-align:middle" --}}
                                        <td class=" gap-3">
                                            <a href="{{ route('school.edit-school-level', $item->id) }}" class="text-md bg-blue-500 p-1 text-white rounded-sm">Modifier</a>
                                            <span class="text-md bg-red-500 p-1 text-white rounded-sm" wire:click="delete({{$item->id}})" style="cursor: pointer">Supprimer</span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr class="w-full">
                                        <td class="flex-1 w-full items-center justify-center" colspan="4">
                                            <div>
                                                <p class="flex justify-center content-center p-4">
                                                    <img src="{{ asset('storage/empty.svg') }}" alt="" class="w-20 h-20">
                                                    <div>Aucun élément trouvé !</div>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            @if (!empty($levels) && $levels->count() > 0)
                                {{ $levels->links() }}
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
