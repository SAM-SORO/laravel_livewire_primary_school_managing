<?php

namespace App\Livewire;
use App\Models\Batiment;
use App\Models\SchoolYear;
use Livewire\Component;

class ListeBatiment extends Component
{
    public $searchEnter;
    public $IdBatimentToDelete;


    public function confirmDelete($IdBatiment){
        $this->IdBatimentToDelete = $IdBatiment;
    }


    public function delete(Batiment $batiment)
    {
        // Trouver le bâtiment à supprimer
        $batiment = Batiment::findOrFail($this->IdBatimentToDelete);

        // Vérifier s'il existe des relations (par exemple, les classes associées) et demander une confirmation
        if ($batiment->classes()->exists()) {
            // Si des relations existent, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer ce bâtiment car il est utiliser dans d\'autres tables.');
            return redirect()->back();
        } else {
            // Si aucune relation n'existe, supprimer le bâtiment
            $batiment->delete();
            // Émettre un message de succès
            session()->flash('success', 'Le bâtiment a été supprimé avec succès.');
            return redirect()->back();
        }

    }


    public function render()
    {
        // Vérifier s'il existe des années scolaires actives
        $anneesScolairesActives = SchoolYear::where('active', '1')->exists();

        // Recherche des bâtiments basée sur la saisie de l'utilisateur
        if ($this->searchEnter) {
            $batiments = Batiment::where('nomBat', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('dateBat', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('id', 'like', '%' . $this->searchEnter . '%')
                ->orderBy('created_at', 'desc') // Tri par date de création décroissante
                ->paginate(5);
        } else {
            $batiments = Batiment::orderBy('created_at', 'desc') // Tri par date de création décroissante
                ->paginate(10);
        }

        return view('livewire.liste-batiment', compact('batiments'));
    }


}
