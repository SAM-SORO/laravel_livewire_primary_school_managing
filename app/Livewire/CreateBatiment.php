<?php

namespace App\Livewire;

use App\Models\Batiment;
use Carbon\Carbon;
use Exception;
use Livewire\Component;

class CreateBatiment extends Component
{
    public $nomBatiment;
    public $dateConstruction;

    public function annuler()
    {
        return redirect()->route('batiment');
    }

    public function store()
    {

        $this->validate([
            'nomBatiment' => 'string|required',
            'dateConstruction' => 'date|required',
        ], [
           'nomBatiment' => 'vous devez renseigner ce champ',
            'dateConstruction.date' => 'Vous devez renseigner une date'
        ]);


        // Vérifier si le niveau a déjà été ajouté pour l'année en cours
        $existingbatiment = batiment::where('nomBat', $this->nomBatiment)->first();

        if ($existingbatiment) {
            return redirect()->route('school.create-batiment')->with('error', 'Ce batiment a déjà été enregistrer');
        }

        try {

            $batiment = new Batiment();
            $batiment->nomBat = $this->nomBatiment;
            $batiment->dateBat = $this->dateConstruction;
            $batiment->save();

            return redirect()->route('batiment')->with('success', 'Batiment enregistrer avec succès');

        } catch(Exception $e) {

            return redirect()->route('school.create-batiment')->with('error', "Une erreur s'est produite lors de l'enregistrement du batiment");
        }

    }

    public function render()
    {
        return view('livewire.create-batiment');
    }
}
