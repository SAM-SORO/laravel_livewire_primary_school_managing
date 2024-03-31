<?php

namespace App\Livewire;

use App\Models\Level;
use Livewire\WithPagination;

use Livewire\Component;

class ListeNiveaux extends Component
{
    use WithPagination;

    public $searchEnter = '';


    public function search()
    {
        // Exécute une requête de recherche basée sur l'année saisie
        $this->resetPage();
    }

    public function delete(Level $level){
        $level->delete();
        return redirect()->route('schoolYears')->with('success', 'Niveau supprimer avec succès.');
    }

    public function render()
    {
        // Recherche des années scolaires basée sur la saisie de l'utilisateur
        if ($this->searchEnter) {
            $levels = Level::where('libele', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('scolarite', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%')
                ->paginate(5);
        } else {
            $levels = Level::paginate(10);
        }

        return view('livewire.liste-niveaux', ['levels' => $levels]);
    }
}
