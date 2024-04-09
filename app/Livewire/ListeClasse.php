<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\SchoolYear;
use Livewire\Component;

class ListeClasse extends Component
{

    public $searchEnter;

    public function delete(Classe $classe){
        $classe->delete();
        return redirect()->route('classes')->with('success', 'Classe supprimée avec succès.');
    }

    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des classes basée sur la saisie de l'utilisateur
        $classeQuery = Classe::query();

        if ($this->searchEnter) {
            // Si la chaîne de recherche contient un trait d'union comme CP1 -A par exemple
            $searchTerms = explode('-', $this->searchEnter);
            if (count($searchTerms) === 2) {
                $libele = trim($searchTerms[0]);
                $nomBat = trim($searchTerms[1]);

                $classeQuery->whereHas('level', function($query) use ($libele) {
                    $query->where('libele', 'like', '%' . $libele . '%');
                })->whereHas('batiment', function($query) use ($nomBat) {
                    $query->where('nomBat', 'like', '%' . $nomBat . '%');
                });
            } else {
                $classeQuery->where(function($query) use ($searchTerms) {
                    $query->where('id', 'like', '%' . $searchTerms[0] . '%')
                        ->orWhereHas('level', function ($subquery) use ($searchTerms) {
                            $subquery->where('libele', 'like', '%' . $searchTerms[0] . '%');
                        })
                        ->orWhereHas('batiment', function ($subquery) use ($searchTerms) {
                            $subquery->where('nomBat', 'like', '%' . $searchTerms[0] . '%');
                        });
                });
            }
        }

        // Si une année scolaire active est trouvée, filtrez les classes en conséquence
        if ($activeSchoolYear) {
            $classeQuery->where('schoolYear_id', $activeSchoolYear->id);
        }

        $classesList= $classeQuery->paginate(5);

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


