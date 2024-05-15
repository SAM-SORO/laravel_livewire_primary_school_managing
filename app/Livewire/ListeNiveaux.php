<?php

namespace App\Livewire;

use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\WithPagination;

use Livewire\Component;

class ListeNiveaux extends Component
{
    use WithPagination;

    public $searchEnter = '';

    public $IdLevelToDelete;


    public function confirmDelete($IdLevel){
        $this->IdLevelToDelete = $IdLevel;
    }


    public function delete()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Trouver le bâtiment à supprimer
        $niveau= Level::findOrFail($this->IdLevelToDelete);

        $inscritLevel = Inscrire::where('level_id', $this->IdLevelToDelete)->where('schoolYear_id', $activeSchoolYear->id)->first();

        if ($inscritLevel) {
            // Si des affectations existent, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer ce Niveau car des élèves sont inscrits pour ce niveau.');
            return redirect()->back();
        } else {
            // Si aucune affectation n'existe, supprimer l'élève
            $niveau->delete();
            // Émettre un message de succès
            session()->flash('success', 'Le niveau à été supprimé avec succès.');
            return redirect()->back();
        }
    }

    public function render(){
    // Vérifier si une année scolaire active existe
    $anneeScolaireActive = SchoolYear::where('active', '1')->exists();

    // Recherche des niveaux basée sur la saisie de l'utilisateur
    $levels = Level::query();

    if ($this->searchEnter) {
        if($anneeScolaireActive){
            $activeSchoolYear = SchoolYear::where('active', '1')->first();
            $levels->where('libele', 'like', '%' . $this->searchEnter . '%')
                ->Where('schoolYear_id', $activeSchoolYear->id)
                ->orWhere('scolarite', 'like', '%' . $this->searchEnter . '%')
                ->Where('schoolYear_id', $activeSchoolYear->id)
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%')
                ->Where('schoolYear_id', $activeSchoolYear->id)
                ->paginate(5);
        }

    }

    // Si une année scolaire active est trouvée, filtrez les niveaux en conséquence et paginez les résultats
    if ($anneeScolaireActive) {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();
        $levels = $levels->where('schoolYear_id', $activeSchoolYear->id)->paginate(5);
    } else {
        // Si aucune année scolaire active n'est trouvée, retournez une collection vide
        $levels = collect();
    }

    return view('livewire.liste-niveaux', compact('levels'));
}




}
