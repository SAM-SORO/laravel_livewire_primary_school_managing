<?php

namespace App\Livewire;

use App\Models\Batiment;
use Carbon\Exceptions\Exception;
use Livewire\Component;

class EditBatiment extends Component
{
    public $batiment;  // cette variable va contenir le niveaux sur lequel on a clicker

    public $nomBatiment;
    public $dateConstruction;

    public function mount(){
        $this->nomBatiment = $this->batiment->nomBat;
        $this->dateConstruction = $this->batiment->dateBat;
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
        $existingbatiment = batiment::where('nomBat', $this->nomBatiment)
            ->where('id', '!=' , $this->batiment->id)
            ->first();

        if ($existingbatiment) {
            return redirect()->back()->with('error', 'Ce batiment a déjà été enregistrer');
        }

        try {

            $batiment = Batiment::find($this->batiment->id);

            $batiment->nomBat = $this->nomBatiment;
            $batiment->dateBat = $this->dateConstruction;
            $batiment->save();

            return redirect()->route('batiment')->with('success', 'Modification enregistrer avec succès');

        } catch(Exception $e) {

            return redirect()->back()->with('error', "Une erreur s'est produite lors de l'enregistrement du batiment");
        }

    }

    public function render()
    {
        return view('livewire.edit-batiment');
    }
}
