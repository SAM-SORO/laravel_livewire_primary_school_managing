<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Level;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolYears extends Component
{
    use WithPagination;

    public $searchEnter = '';

    public $schollYearIdToDelete; //l'schollYear a supprimer

    protected $listeners = ['deleteConfirmed' => 'deleteSchollYear'];


    public function changerStatus(SchoolYear $schoolYear)
    {
        // Mettre toutes les lignes de la table à active = 0
        SchoolYear::where('active', '1')->update(['active' => '0']);

        // Mettre à jour le statut de l'enregistrement grâce à son identifiant
        $schoolYear->active = '1';
        $schoolYear->save();
    }

    public function confirmDelete($schollYearId)
    {
        $this->schollYearIdToDelete = $schollYearId;
        $this->dispatch('show-delete-modal');
    }

    public function deleteSchollYear(){
        $schoolYearToDelete = SchoolYear::findOrFail($this->schollYearIdToDelete);

        // Vérifier si l'année scolaire à supprimer est active
        if ($schoolYearToDelete->active) {
            session()->flash('error', 'Impossible de supprimer une année scolaire active.');
            return redirect()->back();
        }

        // Vérifier s'il existe des classes associées à cette année scolaire
        $classesCount = Classe::where('schoolYear_id', $schoolYearToDelete->id)->count();

        // Vérifier s'il existe des niveaux associés à cette année scolaire
        $levelsCount = Level::where('schoolYear_id', $schoolYearToDelete->id)->count();

        if ($classesCount > 0 || $levelsCount > 0) {
            // Si des classes ou des niveaux sont associés, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer cette année scolaire car elle est en relation avec des classes ou des niveaux.');
            return redirect()->back();
        } else {
            // Supprimer l'année scolaire si aucune classe ni niveau n'est associé et si elle n'est pas active
            $schoolYearToDelete->delete();
            $this->dispatch('inscription-deleted');
        }
    }




    public function render()
    {
        // Recherche des années scolaires basée sur la saisie de l'utilisateur
        if ($this->searchEnter) {
            $schoolYearList = SchoolYear::where('startYear', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('endYear', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%')
                ->orWhere(function($query) {
                    // Permet de traiter la recherche sous la forme "année_début_année_fin"
                    $searchParts = explode('-', $this->searchEnter);
                    if (count($searchParts) == 2) {
                        $query->where('startYear', $searchParts[0])->where('endYear', $searchParts[1]);
                    }
                })
                ->paginate(5);
        } else {
            $schoolYearList = SchoolYear::orderBy('startYear')->paginate(10);
        }

        return view('livewire.school-years', ['schoolYearList' => $schoolYearList]);
    }
}





// public function toggleStatus(SchoolYear $schoolYear)
//     {
//         // Mettre toutes les lignes de la table à active = 0
//         SchoolYear::where('active', '1')->update(['active' => '0']);

//         // Mettre à jour le statut de l'enregistrement grâce à son identifiant
//         $schoolYear->active = '1';
//         $schoolYear->save();
//     }

// ->orWhere(function($query) {
//     // Permet de traiter la recherche sous la forme "année_début_année_fin"
//     $searchParts = explode('_', $this->searchEnter);
//     if (count($searchParts) == 2) {
//         $query->where('startYear', $searchParts[0])->where('endYear', $searchParts[1]);
//     } else {
//         // Recherche simple basée sur la colonne 'currentYear'
//         $query->where('startYear', 'like', '%' . $this->searchEnter . '%')
//             ->orWhere('endYear', 'like', '%' . $this->searchEnter . '%');
//     }
// })
