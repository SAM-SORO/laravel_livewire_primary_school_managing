<?php

namespace App\Livewire;

use App\Models\Classe;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\Student;
use Livewire\Component;

class CreateAffectation extends Component
{
    public $idEleve;
    public $idNiveau;
    public $matricule;
    public $idClasse;
    public $effectif;
    public $eleves = [];

    public function annuler()
    {
        return redirect()->route('classes');
    }

    public function updatedIdNiveau($value)
    {
        // je peux bien remplacer $value par $this->idNiveau sans faire de passage en parametre
        if (!empty($this->idNiveau)) {

            $inscrit = Inscrire::where('level_id',$value)->get();

            //dd($inscrit);

            //$this->eleves = $inscrit->eleve->nom;

        }
    }

    public function updatedIdClasse($value)
    {
        // je peux bien remplacer $value par $this->idNiveau sans faire de passage en parametre
        if (!empty($value)) {
            $classe = Classe::find($value);
            $this->effectif = $classe->Effectif . '/' . $classe->capacite ;
        }
    }

    public function render()
    {
        $classes = Classe::all();
        $levels = Level::all();
        $eleves = $this->eleves;

        return view('livewire.create-affectation', compact('classes', 'levels', 'eleves'));
    }
}
