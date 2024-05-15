<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Classe;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class EditAffectation extends Component
{
    public $affectation;
    public $eleve;
    public $matricule;
    public $idClasse;
    public $effectif;
    public $idNiveau;

    public function annuler()
    {
        return redirect()->route('affectation');
    }

    public function mount(){
        $eleve = Student::find($this->affectation->student_id);
        $this->matricule = $eleve->matricule;
        $this->eleve = $eleve->nom . " " . $eleve->prenom;
        $this->idNiveau = $this->affectation->classe->idLevel;
        $this->idClasse = $this->affectation->classe->id;
        $this->effectif = $this->affectation->classe->Effectif . "/" . $this->affectation->classe->capacite;

        //$this->affectation = $this->affectation;
    }

    public function updated($value){

        if (!empty($this->idClasse)) {
            $classe = Classe::where('id', $this->idClasse)->first();
            if ( $classe) {
                $this->effectif = $classe->Effectif . '/' . $classe->capacite ;
            }else{
                $this->eleve = "";
            }
        }
    }


    public function store()
    {

        // Valider les données
        $this->validate([
            'effectif' => 'required',
        ]);


        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        } else {

            // Récupérer les informations sur la classe sélectionnée
            $selectedClasse = Classe::find($this->idClasse);

            // Vérifier si la classe est pleine
            if ($selectedClasse->effectif >= $selectedClasse->capacite) {
                return redirect()->back()->with('error', "La classe de {$selectedClasse->nom} est pleine.");
            }


            //affectation
            $affectation = Affecter::find($this->affectation->id);

            $affectation->classe_id = $this->idClasse;
            $affectation->save();

            // ou Classe::where('id', $this->idClasse)->increment('effectif');

            //$selectedClasse->save();


            // Réinitialiser les champs après l'enregistrement
            //$this->reset(['idEleve', 'idNiveau', 'idClasse']);

            // Afficher un message de succès
            Session::flash('success', 'modification enregistrée avec succès.');

            // Rediriger l'utilisateur vers une autre page ou rafraîchir la page actuelle
            return redirect()->route('affectation');

        }
    }


    public function render()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();
        
        $classes = Classe::Where('idLevel', $this->idNiveau)->where('schoolYear_id', $activeSchoolYear->id)->get();

        return view('livewire.edit-affectation', compact('classes'));
    }
}
