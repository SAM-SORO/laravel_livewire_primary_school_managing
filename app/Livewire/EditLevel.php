<?php

namespace App\Livewire;

use App\Models\Inscrire;
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
                                ->where('id', '!=', $this->level->id) // Exclure le niveau en cours de modification
                                ->where('schoolYear_id', $activeSchoolYear->id)
                                ->first();

        if ($existingLevel) {
            return redirect()->back()->with('error', 'Ce niveau existe déjà.');
        }


        $level = Level::where('id',$this->level->id)->where('schoolYear_id', $activeSchoolYear->id)->first();

        $level->libele = $this->niveau;
        $level->scolarite = $this->scolarite;

        $level->save();

        $inscriptions = Inscrire::where('level_id', $this->level->id)->where('schoolYear_id', $activeSchoolYear->id)->get();


        foreach ($inscriptions as $inscription){
            // Si le montant payé est inferieur à la scolarité, l'inscription est marquée comme incomplète
            if ($this->scolarite >  $inscription->montant) {
                $inscription->etatPaiement = '0';
                $inscription->save();
            }
        }


        return redirect()->route('niveaux')->with('success', 'Niveau modifié avec succès.');
    }



    public function render()
    {
        return view('livewire.edit-level');
    }
}
