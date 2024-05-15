<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\SchoolYear;
use Livewire\Component;

class ListeClasse extends Component
{

    public $searchEnter;

    public $IdClasseToDelete;


    public function confirmDelete($IdClasse){
        $this->IdClasseToDelete = $IdClasse;
    }

    public function delete(Classe $classe)
    {
        // Trouver le bâtiment à supprimer
        $classe = Classe::findOrFail($this->IdClasseToDelete);

        // Vérifier s'il existe des affectations pour cette classe et demander une confirmation
        if ($classe->affecter()->exists()) {
            // Si des affectations existent, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer cette classe car elle est utiliser dans d\'autres tables.');
            return redirect()->back();
        } else {
            // Si aucune affectation n'existe, supprimer la classe
            $classe->delete();
            // Émettre un message de succès
            session()->flash('success', 'La classe a été supprimée avec succès.');
            return redirect()->back();
        }
    }

    public function render()
    {
        // Vérifier si une année scolaire active existe
        $activeSchoolYearExists = SchoolYear::where('active', '1')->exists();

        // Recherche des classes basée sur la saisie de l'utilisateur
        $classesList = Classe::query();

        if ($this->searchEnter && $activeSchoolYearExists) {
            // Obtenez l'année scolaire active
            $activeSchoolYear = SchoolYear::where('active', '1')->first();

            // Logique de recherche...
            // Si la chaîne de recherche contient un trait d'union comme CP1 -A par exemple
            $searchTerms = explode('-', $this->searchEnter);
            if (count($searchTerms) === 2) {
                $libele = trim($searchTerms[0]);
                $nomBat = trim($searchTerms[1]);

                $classesList->whereHas('level', function ($query) use ($libele, $activeSchoolYear) {
                    $query->where('libele', 'like', '%' . $libele . '%')
                        ->where('schoolYear_id', $activeSchoolYear->id);
                })->whereHas('batiment', function ($query) use ($nomBat) {
                    $query->where('nomBat', 'like', '%' . $nomBat . '%');
                });
            } else {
                $classesList->where(function ($query) use ($searchTerms, $activeSchoolYear) {
                    $query->where('id', 'like', '%' . $searchTerms[0] . '%')
                        ->orWhereHas('level', function ($subquery) use ($searchTerms, $activeSchoolYear) {
                            $subquery->where('libele', 'like', '%' . $searchTerms[0] . '%')
                                ->where('schoolYear_id', $activeSchoolYear->id);
                        })
                        ->orWhereHas('batiment', function ($subquery) use ($searchTerms) {
                            $subquery->where('nomBat', 'like', '%' . $searchTerms[0] . '%');
                        });
                });
            }
        }

        // Si une année scolaire active existe, filtrez les classes en conséquence et paginez les résultats
        if ($activeSchoolYearExists) {
            // Obtenez l'année scolaire active
            $activeSchoolYear = SchoolYear::where('active', '1')->first();

            $classesList = $classesList->where('schoolYear_id', $activeSchoolYear->id)->orderBy('nom')->paginate(5);
        } else {
            // Si aucune année scolaire active n'est trouvée, retournez une collection vide
            $classesList = collect();
        }

        return view('livewire.liste-classe', compact('classesList'));
    }

}

// if ($this->searchEnter) {
//     $classesList->where(function($query) {
//         $query->where('id', 'like', '%' . $this->searchEnter . '%')
//               ->orWhereHas('level', function($subquery) {
//                   $subquery->where('libele', 'like', '%' . $this->searchEnter . '%');
//               })
//               ->orWhereHas('batiment', function($subquery) {
//                   $subquery->where('nomBat', 'like', '%' . $this->searchEnter . '%');
//               });
//     });
// }


