<?php

namespace App\Livewire;

use App\Models\Batiment;
use App\Models\Classe;
use App\Models\Level;
use App\Models\SchoolYear;
use Livewire\Component;

class EditClasse extends Component{

    public $classe;
    public $idNiveau;
    public $idBatiment;
    public $capaciteClasse;

    //la methode ci est toujours executé avant le render. elle va donc
    public function mount(){
        $this->idNiveau = $this->classe->level->id;
        $this->idBatiment = $this->classe->batiment->id;
        $this->capaciteClasse = $this->classe->capacite;
    }


    public function annuler()
    {
        return redirect()->route('classes');
    }

    public function store()
    {
        $this->validate([
            'idNiveau' => 'required',
            'idBatiment' => 'required',
            'capaciteClasse' => 'required|integer|min:0',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Vérifier si une classe avec les mêmes critères existe déjà
        $existingClass = Classe::where('idBat', $this->idBatiment)
            ->where('idLevel', $this->idNiveau)
            ->where('schoolYear_id', $activeSchoolYear->id)
            ->where('id', '=!', $this->classe->id)// Exclure le niveau en cours de modification
            ->first();

        if ($existingClass) {
            // Une classe avec les mêmes critères existe déjà
            session()->flash('error', 'Cette classe  existe déjà.');
            return redirect()->route('create-classes'); // Ou une autre redirection selon votre besoin
        }

        $classe = Classe::find($this->classe->id);
        $classe->idBat = $this->classe->batiment->id;
        $classe->idLevel = $this->classe->level->id;
        $classe->capacite = $this->capaciteClasse;

        $classe->save();

        // Rediriger avec un message de succès
        session()->flash('success', 'Classe modifiée avec succès!');

        // Redirection
        return redirect()->route('classes');
    }

    public function render()
    {
        $levels = Level::all();
        $batiments = Batiment::all();

        return view('livewire.edit-classe', compact('levels', 'batiments'));
    }
}
