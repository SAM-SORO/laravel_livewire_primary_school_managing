<div class="p-2 bg-white shadow-sm">

    <form method="POST" wire:submit.prevent="store" enctype="multipart/form-data">
        @csrf
        @method('post')


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
                <input type="date" class="block mt-1 rounded-md border-gray-300 w-full @error('naissance') border-red-500 bg-red-100  @enderror" wire:model="naissance" id="naissance" name="naissance" required onchange="calculateAge()">

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

            <div class="block mb-5">
                <label for="age">Age</label>
                <input type="number" class="block mt-1 rounded-md border-gray-300 w-full @error('prenom') border-red-500 bg-red-100  @enderror" wire:model="age" name="age" id="age" required step="1" pattern="\d+" min="0" readonly>

                @error('age')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="block mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="photo">Photo</label>
                <input type="file" class="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white  file:dark:text-white" wire:model="photo" id="photo" />
                @error('photo')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>


            <div class="block mb-5">
                <label for="parent">Contact du Parent</label>
                <input type="text" class="block mt-1 rounded-md border-gray-300 w-full @error('prenom') border-red-500 bg-red-100  @enderror" wire:model="parent" name="parent" id="parent">

                @error('parent')
                    <div class="text text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="p-5 flex justify-between items-center bg-gray-100">
            <button id="btnAnnuler" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300" type="button" wire:click="annuler">Annuler</button>

            <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300" >Ajouter</button>
        </div>

    </form>
</div>

<script>
    function calculateAge() {
        var dob = document.getElementById('naissance').value;
        var today = new Date();
        var birthDate = new Date(dob);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    }
</script>
