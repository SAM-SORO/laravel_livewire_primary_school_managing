<?php

namespace App\Livewire;

use App\Models\Batiment;
use App\Models\Classe;
use App\Models\Level;
use App\Models\SchoolYear;
use Livewire\Component;

class CreateClasse extends Component
{

    public $idNiveau;
    public $idBatiment;
    public $capaciteClasse;


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
            ->first();

        if ($existingClass) {
            // Une classe avec les mêmes critères existe déjà
            session()->flash('error', 'Cette classe existe déjà.');
            return redirect()->route('create-classes'); // Ou une autre redirection selon votre besoin
        }

        // Récupérer les modèles Level et Batiment correspondants
        $level = Level::find($this->idNiveau);
        $batiment = Batiment::find($this->idBatiment);

        // Concaténer les noms pour former le nom de la classe
        $nomClasse = $level->libele . '-' . $batiment->nomBat;

        // Créer la classe
        Classe::create([
            'nom' => $nomClasse,
            'idBat' => $this->idBatiment,
            'idLevel' => $this->idNiveau,
            'schoolYear_id' => $activeSchoolYear->id,
            'capacite' => $this->capaciteClasse,
            'Effectif' => 0,
        ]);

        // Rediriger avec un message de succès
        session()->flash('success', 'Classe ajoutée avec succès!');

        // Redirection
        return redirect()->route('classes');
    }


    public function render()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();
        $levels = Level::Where('schoolYear_id', $activeSchoolYear->id)->get();
        $batiments = Batiment::all();

        // Utilisez compact() avec les noms des variables en tant que chaînes
        return view('livewire.create-classe', compact('levels', 'batiments'));
    }
}
