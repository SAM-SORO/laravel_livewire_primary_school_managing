<div class="p-5 bg-white shadow-sm">

    <form method="POST" wire:submit.prevent="store" enctype="multipart/form-data">
        @csrf
        @method('post')


        @if (Session::has('error'))
            <div class="border-red-500 bg-red-400 text-white text-sm font-bold px-4 py-3 rounded relative" id="error-ajout" role="alert" x-data = "{show: true}" x-show="show">
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
            <div class="border-green-500 bg-green-400 text-white text-sm font-bold px-4 py-3 rounded relative" id="success-ajout" x-data = "{show: true}" x-show="show">
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
                <label for="matricule">Matricule</label>
                <input type="text"
                    class="block mt-1 rounded-md border-gray-300 w-full @error('code') border-red-500 bg-red-100  @enderror" wire:model="matricule" name="matricule" id="matricule" value="{{old('matricule')}}" readonly>

                @error('matricule')
                    <div class="text text-red-500 mt-1"> {{ $message }}</div>
                @enderror
            </div>
            <div class="block mb-5">
                <label for="nom">Nom</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('code') border-red-500 bg-red-100  @enderror" wire:model="nom" name="nom" id="nom" required>

                @error('nom')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mb-5">
                <label for="prenom">Prenom</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('prenom') border-red-500 bg-red-100  @enderror" wire:model="prenom" name="prenom" id="prenom" required>

                @error('prenom')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mb-5">
                <label for="naissance">Date de naissance</label>
                <input type="date" class="block mt-1 rounded-md border-gray-300 w-full @error('naissance') border-red-500 bg-red-100  @enderror" wire:model="naissance" id="naissance" name="naissance" required>

                @error('naissance')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="block mb-5">
                <label for="genre">Genre</label>
                <select class="block mt-1 rounded-md border-gray-300 w-full @error('genre') border-red-500 @enderror" wire:model="genre" name="genre" id="genre" required>
                    <option value="">Sélectionnez le genre</option>
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>

                @error('genre')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="flex items-center space-x-6 mb-2">
                <div class="shrink-0">
                    <img id='preview_img' class="h-20 w-20 object-cover rounded-full"
                    src="{{ $photoUrl ?? 'https://lh3.googleusercontent.com/a-/AFdZucpC_6WFBIfaAbPHBwGM9z8SxyM1oV4wB4Ngwp_UyQ=s96-cb' }}"
                    alt="Current profile photo" />
                </div>

                <div class="ml-3 mt-4 w-full">
                    <input type="file" wire:model="photo" class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500 rounded"/>
                    <p class="text-xs text-gray-400 mt-2">PNG, JPG, SVG, JPEG sont autorisés.</p>
                </div>
            </div>


            <div class="block mb-5">
                <label for="parent">Contact du Parent</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('prenom') border-red-500 bg-red-100 @enderror" wire:model="parent" oninput="formatContact(this)" name="parent">

                @error('parent')
                    <div class="text text-red-500 mt-1">{{$message}}</div>
                @enderror
            </div>

        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100">
            <button id="btnAnnuler" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300" type="button" wire:click="annuler">Annuler</button>

            <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 ">Modifier</button>
        </div>

    </form>
</div>


<script>
    // Dans votre fichier JavaScript
    function formatContact(input) {
        // Supprimer tous les espaces de la valeur saisie
        var value = input.value.replace(/\s/g, '');

        // Formater la valeur en groupes de deux caractères séparés par un espace
        var formattedValue = value.match(/.{1,2}/g).join(' ');

        // Mettre à jour la valeur du champ
        input.value = formattedValue;
    }

</script>
