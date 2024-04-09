<div>
    <div class="p-2 bg-white shadow-sm">

        <form method="POST" wire:submit.prevent="store">
            @csrf
            @method('POST')

            @if (Session::has('error'))
                <div class="border-red-500 bg-red-400 text-white text-sm font-bold px-4 py-3 rounded relative" id="error-ajout">
                    <span>{{ Session::get('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-error">
                        <svg class="fill-current h-6 w-6 text-white-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if (Session::has('success'))
                <div class="border-green-500 bg-green-400 text-white text-sm font-bold px-4 py-3 rounded relative" id="success-ajout">
                    <span>{{ Session::get('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" id="close-success">
                        <svg class="fill-current h-6 w-6 text-white-50" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif


            <div class="p-5 flex flex-col gap-4">
                <div class="block mb-5">
                    <label for="nomBatiment">Nom du batiment</label>
                    {{-- <x-jet-label value="{{ __('Montant de la scolarité') }}" /> --}}
                    <input type="text"
                        class="block mt-1 rounded-md border-gray-300 w-full @error('nomBatiment') border-red-500 @enderror" wire:model="nomBatiment" name="nomBatiment" required>

                    @error('nomBatiment')
                        <div class="text text-red-500 mt-1">{{ $message}}</div>
                    @enderror
                </div>

                <div class="block mb-5">
                    <label for="dateConstruction">Date de construction du batiment</label>
                    {{-- <x-jet-label value="{{ __('Montant de la scolarité') }}" /> --}}
                    <input type="date"
                        class="block mt-1 rounded-md border-gray-300 w-full @error('dateConstruction') border-red-500 @enderror" wire:model="dateConstruction" name="dateConstruction" required>

                    @error('dateConstruction')
                        <div class="text text-red-500 mt-1">*La date de construction est requis</div>
                    @enderror
                </div>

            </div>

            <div class="p-5 flex justify-between items-center bg-gray-100">
                <button id="btnAnnuler" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300" type="button" wire:click="annuler">Annuler</button>

                <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300" >Ajouter</button>
            </div>

        </form>
    </div>

</div>
