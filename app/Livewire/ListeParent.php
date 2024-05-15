<?php

namespace App\Livewire;

use App\Models\Parents;
use Livewire\Component;
use Livewire\WithPagination;

class ListeParent extends Component
{
    use WithPagination;

    public $searchEnter = '';

    public $IdParentToDelete;

    public function confirmDelete($IdParent){
        $this->IdParentToDelete = $IdParent;
    }

    public function delete(){
        // Trouver le parent à supprimer
        $parent = Parents::find($this->IdParentToDelete);

        // Récupérer les enfants associés au parent
        $children = $parent->students()->get();

        // Dissocier tous les enfants du parent
        $parent->students()->detach();

        // Supprimer le parent
        $parent->delete();

        $childrenNames = $children->map(function ($child) {
            return $child->nom . ' ' . $child->prenom;
        })->implode(', ');

        session()->flash('error', 'Suppression du parent de l\'élève(s) : ' . $childrenNames);

        return redirect()->back();
    }




    public function render()
    {
        if ($this->searchEnter) {
            $parents = Parents::where('nom', 'like', '%' . $this->searchEnter . '%')->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')->orWhere('email', 'like', '%' . $this->searchEnter . '%')->orWhere('contact', 'like', '%' . $this->searchEnter . '%')->orderBy('nom')->orderBy('prenom')->paginate(5);
        } else {

            $parents = Parents::orderBy('nom')->orderBy('prenom')->paginate(5);
        }

        return view('livewire.liste-parent', compact('parents'));
    }

}
