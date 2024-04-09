<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Classe;
use App\Models\SchoolYear;
use Livewire\Component;
use Livewire\WithPagination;

class ListeAffectation extends Component
{

    use WithPagination;

    public $searchEnter;


    public $selectedFiltreAffecter = 'Eleves affecter'; // Propriété pour suivre la sélection du filtre par affectation

    public $selectedFiltreClasse = 'Toutes les classes' ; // Propriété pour suivre la sélection du filtre par niveau

    public function search()
    {
        // Exécute une requête de recherche basée sur l'année saisie
        $this->resetPage();
    }

    public function delete(Affecter $affectation){
        $affectation->delete();
        return redirect()->route('affectations')->with('success', 'Affectation supprimer avec succès.');
    }

    public function updatedSelectedFiltreClasse(){
        //pour pouvoir changer le nom du bouton pour le filtre par niveau c'est un peu different avec le filtre des inscrits ou non parce qu'ici c'est l'identifiant qu'on arrive a ciblé puissequ'on a relier ça a l'identifiant
        if(!empty($this->selectedFiltreClasse)){
            if($this->selectedFiltreClasse === 'Toutes les classes'){
                $this->selectedFiltreClasse = 'Toutes les classes' ;
            }else{
                $classeName = Classe::find($this->selectedFiltreClasse)->nom;
                $this->selectedFiltreClasse = $classeName;
            }

        }
    }

    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $affectation = Affecter::query();

        if ($this->searchEnter) {
            $affectation->where('nom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%');
        }

        // Si une année scolaire active est trouvée, filtrez les affectation en conséquence
        if ($activeSchoolYear) {
            $affectation->where('schoolYear_id', $activeSchoolYear->id);
        }

        $classes = Classe::all();

        $affectationList = $affectation->paginate(5);

        return view('livewire.liste-affectation', compact('affectationList', 'classes'));
    }
}
