<div class="p-6 bg-white shadow-sm">

    <form method="POST" wire:submit.prevent="store">
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


        <div class="p-5 flex flex-col gap-4">

            <div class="block mb-5">
                <label for="niveau">Niveau</label>
                <select class="block mt-1 rounded-md border-gray-300 w-full @error('libele') border-red-500 @enderror" wire:model="niveau" name="niveau" required>
                    <option value="" selected>Sélectionner un niveau</option>
                    <option value="CP1">CP1</option>
                    <option value="CP2">CP2</option>
                    <option value="CE1">CE1</option>
                    <option value="CE2">CE2</option>
                    <option value="CM1">CM1</option>
                    <option value="CM2">CM2</option>
                </select>

                @error('libele')
                    <div class="text text-red-500 mt-1">*Veuillez selectionner un niveau</div>
                @enderror
            </div>

            <div class="block mb-5">
                <label for="code">Montant de la scolarité</label>
                {{-- <x-jet-label value="{{ __('Montant de la scolarité') }}" /> --}}
                <input type="text"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('scolarite') border-red-500 @enderror" wire:model="scolarite" name="scolarite" value="{{ old('scolarite') }}">
                @error('scolarite')
                    <div class="text text-red-500 mt-1">*Le champ Montant de la scolarité est requis</div>
                @enderror
            </div>
        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100">
            <button id="btnAnnuler" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300" type="button" wire:click="annuler">Annuler</button>


            <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300" >Ajouter</button>
        </div>

    </form>
</div>
