<div class="p-2 bg-white shadow-sm">
    <form wire:submit.prevent="store">
        @csrf
        @method('post')

        {{--<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Attention!</p>
                <p>Vous avez une notification importante.</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button></div>--}}

        <div class="p-5">
            <label for="startYear">Début de l'année</label>
            <div class="relative">
                <select wire:model="startYear" id="startYear" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="" selected>Sélectionner une année</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" class="py-2 px-4 transition duration-300 ease-in-out transform hover:bg-gray-100">{{ $year }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.293 13.707a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 11.586l6.293-6.293a1 1 0 111.414 1.414l-7 7a1 1 0 01-1.414 0z"/></svg>
                </div>
            </div>
            @error('startYear')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="p-5">
            <label for="endYear">Fin de l'année scolaire</label>
            <div class="relative">
                <select wire:model="endYear" id="endYear" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="" selected>Sélectionner une année</option>
                    @foreach ($years as $year)
                        <option value="{{ $year }}" class="py-2 px-4 transition duration-300 ease-in-out transform hover:bg-gray-100">{{ $year }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.293 13.707a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 11.586l6.293-6.293a1 1 0 111.414 1.414l-7 7a1 1 0 01-1.414 0z"/></svg>
                </div>
            </div>
            @error('endYear')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div class="p-5 flex  justify-between items-center bg-gray-100">
            <button type="button" class="bg-red-600 p-3 rounded-sm text-white hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring focus:ring-red-300">Annuler</button>
            <button type="submit" class="bg-green-700 p-3 rounded-sm text-white hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring focus:ring-green-300" >Ajouter</button>
        </div>
    </form>
</div>
