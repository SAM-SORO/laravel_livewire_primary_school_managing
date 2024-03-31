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
                <label for="niveau">Niveau</label>
                <select class="block mt-1 rounded-md border-gray-300 w-full @error('libele') border-red-500 @enderror" wire:model="libelle" name="niveau" required>
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
                    class="block mt-1 rounded-md border-gray-300 w-full @error('scolarite') border-red-500 @enderror" wire:model="scolarite" name="scolarite">
                @error('scolarite')
                    <div class="text text-red-500 mt-1">*Le champ Montant de la scolarité est requis</div>
                @enderror
            </div>
        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100">
            <button class="bg-red-600 p-3 rounded-sm text-white text-sm">Annuler</button>
            <button class="bg-green-600 p-3 rounded-sm text-white text-sm" type="submit">Modifier</button>
        </div>

    </form>
</div>
