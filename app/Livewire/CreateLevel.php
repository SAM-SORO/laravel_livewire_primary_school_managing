<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\SchoolYear;
use Exception;
use Livewire\Component;

class CreateLevel extends Component
{
    public $niveau;
    public $scolarite;

    public function annuler()
    {
        return redirect()->route('niveaux');
    }

    public function store()
    {
        $this->validate([
            'niveau' => 'string|required',
            'scolarite' => 'integer|required',
        ], [
            'scolarite.integer' => 'Vous devez saisir un montant',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');

        } else {
            // Vérifier si le niveau a déjà été ajouté pour l'année en cours
            $existingLevel = Level::where('libele', $this->niveau)
                                  ->where('schoolYear_id', $activeSchoolYear->id)
                                  ->first();

            if ($existingLevel) {
                return redirect()->route('create-school-level')->with('error', 'Ce niveau a déjà été enregistrer .');
            }

            // dd($this->niveau, $this->scolarite,  $activeSchoolYear->id );

            try {

                $level = new Level();
                $level->libele = $this->niveau;
                $level->scolarite = $this->scolarite;
                $level->schoolYear_id = $activeSchoolYear->id;
                $level->save();

                return redirect()->route('niveaux')->with('success', 'Niveau ajouté avec succès');

            } catch(Exception $e) {
                return redirect()->route('create-school-level')->with('error', "Une erreur s'est produite lors de l'enregistrement du niveau");
            }
        }
    }

    public function render()
    {
        return view('livewire.create-level');
    }
}
