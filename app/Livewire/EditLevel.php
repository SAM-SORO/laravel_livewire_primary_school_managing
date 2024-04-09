<?php

namespace App\Livewire;

use App\Models\Level;
use App\Models\SchoolYear;
use Carbon\Exceptions\Exception;
use Livewire\Component;

//c'est avec ce controleur qu'on va enregistrer les modifications


class EditLevel extends Component
{
    public $level;  // cette variable va contenir le niveaux sur lequel on a clicker
    public $niveau;
    public $scolarite;


    //la methode ci est toujours executé avant le render. elle va donc
    public function mount(){
        $this->niveau = $this->level->libele;
        $this->scolarite = $this->level->scolarite;
    }

    public function annuler()
    {
        return redirect()->route('niveaux');
    }

    public function store(){
        $this->validate([
            'niveau' => 'string|required',
            'scolarite' => 'integer|required',
        ], [
            'scolarite.integer' => 'Vous devez saisir un montant valide.',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Vérifier si le niveau a déjà été ajouté
        $existingLevel = Level::where('libele', $this->niveau)
                                ->where('schoolYear_id', $activeSchoolYear->id)
                                ->where('id', '!=', $this->level->id) // Exclure le niveau en cours de modification
                                ->first();

        if ($existingLevel) {
            return redirect()->route('school.edit-school-level', $this->level->id)->with('error', 'Veuillez choisir un autre nom de niveau.');
        }

        $level = Level::find($this->level->id);

        $level->libele = $this->niveau;
        $level->scolarite = $this->scolarite;

        $level->save();

        return redirect()->route('niveaux')->with('success', 'Niveau modifié avec succès.');
    }


    public function render()
    {
        return view('livewire.edit-level');
    }
}
