<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\SchoolYear;
use Livewire\WithPagination;

use Livewire\Component;

class ListeNiveaux extends Component
{
    use WithPagination;

    public $searchEnter = '';


    public function delete(Level $level){
        $level->delete();
        return redirect()->route('niveaux')->with('success', 'Niveau supprimer avec succès.');
    }

    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $levels = Level::query();

        if ($this->searchEnter) {
            $levels->where('libele', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('scolarite', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%');
        }

        // Si une année scolaire active est trouvée, filtrez les niveaux en conséquence
        if ($activeSchoolYear) {
            $levels->where('schoolYear_id', $activeSchoolYear->id);
        }

        $levels = $levels->paginate(5);

        return view('livewire.liste-niveaux', compact('levels'));
    }
}
