<?php

namespace App\Livewire;

use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class ListeInscription extends Component
{
    use WithPagination;

    public $searchEnter; // Propriété pour suivre la sélection du filtre par inscription
    public $selectedFiltreInscrit = 'Eleves inscrit'; // Propriété pour suivre la sélection du filtre par inscription

    public $selectedFiltreNiveau = 'Tous les niveaux' ; // Propriété pour suivre la sélection du filtre par niveau

    public $inscriptionIdToDelete;

    // Méthode pour afficher le modal de confirmation de suppression
    public function confirmDelete($inscriptionId)
    {
        $this->inscriptionIdToDelete = $inscriptionId;
        //$this->dispatchBrowserEvent('show-delete-modal');
    }

    // Méthode pour supprimer l'inscription
    public function deleteInscription()
    {
        $inscription = Inscrire::find($this->inscriptionIdToDelete);
        if ($inscription) {
            $inscription->delete();
            session()->flash('success', 'Inscription supprimée avec succès.');
        }
    }



    public function updatedSelectedFiltreNiveau(){
        //pour pouvoir changer le nom du bouton pour le filtre par niveau c'est un peu different avec le filtre des inscrits ou non parce qu'ici c'est l'identifiant qu'on arrive a ciblé puissequ'on a relier ça a l'identifiant
        if(!empty($this->selectedFiltreNiveau)){
            if($this->selectedFiltreNiveau == 'Tous les niveaux'){
                $this->selectedFiltreNiveau = 'Tous les niveaux' ;
            }else{
                $levelName = Level::find($this->selectedFiltreNiveau)->libele;
                $this->selectedFiltreNiveau = $levelName;
            }

        }
    }

    public function delete(Inscrire $inscription){
        $inscription->delete();
        return redirect()->route('inscription')->with('success', 'Niveau supprimer avec succès.');
    }


    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $inscription = Inscrire::query();

        // Si une année scolaire active est trouvée, filtrez les inscriptions en conséquence
        if ($activeSchoolYear) {
            $inscription->where('schoolYear_id', $activeSchoolYear->id);
        }

        // Appliquer le filtre par inscription
        if ($this->selectedFiltreInscrit === 'Eleves inscrit') {
            $inscription->whereNotNull('student_id');
        } elseif ($this->selectedFiltreInscrit === 'Inscriptions soldé') {
            $inscription->where('etatInscription', '=', '1');
        } elseif ($this->selectedFiltreInscrit === 'Inscriptions non soldé') {
            $inscription->where('etatInscription', '=', '0');
        }


        // Appliquer le filtre par niveau
        if ($this->selectedFiltreNiveau !== 'Tous les niveaux') {
            $inscription->whereHas('Level', function ($query) {
                $query->where('libele', $this->selectedFiltreNiveau);
            });
        }else{
            $inscription->whereHas('Level', function ($query) {
                $query->whereNotNull('libele');
            });
        }

        // Filtrer par recherche de texte
        if (!empty($this->searchEnter)) {
            $inscription->whereHas('student', function ($query) {
                $query->where('nom', 'like', '%' . $this->searchEnter . '%')
                    ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                    ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%');
            });
        }

        $levels = Level::all();

        $inscriptionList = $inscription->paginate(5);

        return view('livewire.liste-inscription', compact('inscriptionList', 'levels'));
    }
}
