<?php

namespace App\Livewire;

use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;

class SchoolYears extends Component
{
    use WithPagination;

    public $searchEnter = '';


    public function changerStatus(SchoolYear $schoolYear)
    {
        // Mettre toutes les lignes de la table à active = 0
        SchoolYear::where('active', '1')->update(['active' => '0']);

        // Mettre à jour le statut de l'enregistrement grâce à son identifiant
        $schoolYear->active = '1';
        $schoolYear->save();
    }

    public function search()
    {
        // Exécute une requête de recherche basée sur l'année saisie
        $this->resetPage();
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
            $schoolYearList = SchoolYear::paginate(10);
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
