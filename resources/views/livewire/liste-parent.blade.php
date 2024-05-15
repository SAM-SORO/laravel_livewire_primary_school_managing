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

            <a href="{{ route('mail-all-parent')}}" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-sm text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Envoyer un message a tous les parents</a>
        </div>


        <div class="flex flex-col">

            <div class="overflow-x-auto ">
                <div class="py-4 inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full text-center">

                            <thead class="border-b bg-gray-50">
                                <tr>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">N°</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Nom</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Prenom</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Email</th>
                                    <th class="text-sm font-medium text-gray-900 px-6 py-6">Contact</th>
                                    <th class="text-sm font-medium text-gray-900 ">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php
                                    $counter = 0;
                                @endphp

                                @forelse ($parents as $item)
                                    <tr class="border-b-2 border-gray-100">
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ ++$counter }}</td>

                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->nom }}</td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">{{ $item->prenom }}
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            {{ $item->email }}
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 px-6 py-6">
                                            {{ $item->contact }}
                                        </td>

                                        <td class="gap-3">
                                            <div class="flex items-center gap-4 justify-center">
                                                <a href="{{ route('edit-parent', $item->id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Modifier</a>

                                                <button type="button" wire:click.prevent="confirmDelete({{ $item->id }})" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 cursor-pointer">Supprimer</button>


                                                {{-- message --}}
                                                <a href="{{route('mail-one-parent', $item->id)}}" type="button" class="bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-md text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="22" viewBox="0 0 20 20"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14L21 3m0 0l-6.5 18a.55.55 0 0 1-1 0L10 14l-7-3.5a.55.55 0 0 1 0-1z"/></svg>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="w-full">
                                        <td class="flex-1 w-full items-center justify-center" colspan="6">
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
                            @if (!empty($parents) && $parents->count() > 0)
                                {{ $parents->links() }}
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('modal')

</div>