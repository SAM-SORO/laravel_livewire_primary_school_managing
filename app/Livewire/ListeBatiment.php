<?php

namespace App\Livewire;

use App\Models\Batiment;
use Livewire\Component;

class ListeBatiment extends Component
{
    public $searchEnter;

    public function search()
    {
        // Exécute une requête de recherche basée sur l'année saisie
        $this->resetPage();
    }

    public function delete(Batiment $batiment){
        $batiment->delete();
        return redirect()->route('batiment')->with('success', 'Batiment supprimer avec succès.');
    }

    public function render()
    {
        // Recherche des années scolaires basée sur la saisie de l'utilisateur
        if ($this->searchEnter) {
            $batiments = Batiment::where('nomBat', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('dateBat', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%')
                ->paginate(5);
        } else {
            $batiments = Batiment::paginate(10);
        }

        return view('livewire.liste-batiment', compact('batiments'));
    }
}
