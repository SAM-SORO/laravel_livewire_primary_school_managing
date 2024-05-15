<div class=" pb-6 shadow-sm">

    <form method="POST" wire:submit.prevent="store" id="inscriptionForm">
        @csrf
        @method('POST')

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


        <div class="p-5 flex flex-col">

            <div class="block mb-6 px-5">
                <label for="matricule">Matricule</label>
                <input type="text" wire:model="matricule" class="block mt-1 rounded-md border-gray-300 w-full @error('matricule') border-red-500 bg-red-100  @enderror"  name="matricule" id="matricule" value="{{ old('matricule')}}" readonly >

                @error('matricule')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mb-6 px-5">
                <label for="eleve">Nom & prenom</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('eleve') border-red-500 bg-red-100  @enderror" wire:model="eleve" name="eleve" id="eleve" readonly value="{{ old('eleve') }}" readonly>

                @error('eleve')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mb-6 px-5">
                <label for="niveau">Niveau</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('niveau') border-red-500 bg-red-100  @enderror" wire:model="niveau" name="niveau" id="niveau" readonly value="{{ old('niveau') }}" readonly>

                @error('niveau')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="px-5 mb-5 flex gap-5">
                <div class="block">
                    <label for="montant">Montant de la scolarité</label>
                    <input type="number" class="block mt-1 rounded-md border-gray-300" wire:model="montantScolarite" id="montant" readonly>

                    @error('montant')
                        <div class="text text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>


                <div class="block">
                    <label for="somme_verse">Somme dejà versé</label>
                    <input type="number" class="block mt-1 rounded-md border-gray-300 " wire:model="sommeVerse" id="somme_verse" readonly>

                    @error('somme_verse')
                        <div class="text text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="block">
                    <label for="somme_restante">Somme restante</label>
                    <input type="number" class="block mt-1 rounded-md border-gray-300" wire:model="sommeRestante" id="somme_restante" readonly>

                    @error('somme_restante')
                        <div class="text text-red-500 mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="block px-5 mb-5">
                <label for="somme_paye">Somme paye</label>
                <input type="number" class="block mt-1 rounded-md border-gray-300 w-full" wire:model="sommePaye" id="somme_paye" required step="1" pattern="\d+" min="0">

                @error('somme_paye')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100">
            <button id="btnAnnuler" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300" type="button" wire:click="annuler">Annuler</button>

            <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 ">Enregistrer</button>
        </div>

    </form>
    </div>

    <script>
        document.getElementById('matricule').addEventListener('keydown', function(event) {
            // Si la touche "Entrée" est pressée dans le champ "Matricule"
            if (event.key === 'Enter') {
                // Déplace le focus vers le champ "Nom & prénom"
                document.getElementById('eleve').focus();
            }
        });
    </script>



