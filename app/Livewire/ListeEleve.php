<?php

namespace App\Livewire;

use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class ListeEleve extends Component
{

    use WithPagination;

    public $searchEnter;


    public function search()
    {
        // Exécute une requête de recherche basée sur l'année saisie
        $this->resetPage();
    }

    public function delete(Student $eleve){
        $eleve->delete();
        return redirect()->route('eleves')->with('success', 'Eleve supprimer avec succès.');
    }


    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $eleves = Student::query();

        if ($this->searchEnter) {
            $eleves->where('nom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%');
        }

        // Si une année scolaire active est trouvée, filtrez les niveaux en conséquence
        // if ($activeSchoolYear) {!p
        //     $eleves->where('schoolYear_id', $activeSchoolYear->id);
        // }

        $eleves = $eleves->paginate(5);

        return view('livewire.liste-eleve', compact('eleves'));
    }
}
