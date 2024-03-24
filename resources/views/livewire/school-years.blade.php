<div class="mt-5">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
        {{-- Titre et Boutton crée --}}
        <div class="flex justify-between items-center">
            <div class="w-100 flex xl:justify-between">
                <div class="xl:w-80 md:w-80 sm:60">
                    <input type="search" id="searche" class="block mt-1 border-gray-300 rounded-sm text-sm w-full " placeholder="Rechercher" wire:model="searchEnter">
                </div>
                <button type="button" class="bg-blue-700 ml-4 rounded-md px-2 text-sm text-white" wire:click="search">Rechercher</button>
            </div>
            <a href="{{ route('school.create-school-year') }}" class="bg-blue-500 rounded-md p-2 text-sm text-white">Nouvelle Année Scolaire</a>
        </div>

        <div class="flex flex-col">
            {{-- Message qui apparaitra après operation --}}
            @if(session('success'))
            <div id="successMessage" class="block p-3 bg-green-700 text-white rounded-sm shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            {{-- Styliser le tableau --}}
            <div class="overflow-x-auto">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">
                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">ID</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Année Scolaire</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Statut</th>
                                    <th class="text-sm font-medium text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schoolYearList as $item)
                                    <tr class="border-b-2 border-gray-100">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->id }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            {{ $item->startYear }} - {{ $item->endYear }}
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <span class="p-1 text-sm {{ $item->active == 1 ? 'bg-green-600' : 'bg-red-400' }} text-white rounded-sm">
                                                {{ $item->active == 1 ? 'Actif' : 'Inactif' }}
                                            </span>
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            <button class="p-2 text-white {{ $item->active == 1 ? 'bg-red-400' : 'bg-green-600' }} text-sm rounded-sm" wire:click='changerStatus({{ $item->id }})'>
                                                {{ $item->active == 1 ? 'Rendre Inactif' : 'Rendre Actif' }}
                                            </button>
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
                            @if (!empty($schoolYearList) && $schoolYearList->count() > 0)
                                {{ $schoolYearList->links() }}
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
