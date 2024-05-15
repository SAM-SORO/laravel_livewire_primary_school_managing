<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Classe;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateAffectationDirectly extends Component
{

    public $inscritNotAffected;
    public $eleve;
    public $idEleve;
    public $matricule;
    public $niveau;
    public $niveauId;
    public $paiement;
    public $idClasse;
    public $effectif;
    public $somme_verse;


    public function annuler()
    {
        return redirect()->route('affectation');
    }

    public function mount(){
        $studentInInscription = Inscrire::find($this->inscritNotAffected);
        $this->matricule = $studentInInscription->student->matricule;
        $this->eleve = $studentInInscription->student->nom . " " . $studentInInscription->student->prenom;
        $this->idEleve = $studentInInscription->student->id;
        $this->niveau = $studentInInscription->level->libele;
        if ($studentInInscription->etatPaiement){
            $this->paiement = "soldé";
        }else{
            $this->paiement = "non soldé";
        }
        $this->niveau = $studentInInscription->level->libele;
        $this->somme_verse = $studentInInscription->montant;

        $this->niveauId =  $studentInInscription->level->id;

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
            'idClasse' => 'required',
        ]);


        $activeSchoolYear = SchoolYear::where('active', '1')->exists();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        } else {

            $activeSchoolYear = SchoolYear::where('active', '1')->first();

            // Récupérer les informations sur la classe sélectionnée
            $selectedClasse = Classe::find($this->idClasse);

            // Vérifier si la classe est pleine
            if ($selectedClasse->effectif >= $selectedClasse->capacite) {
                return back()->with('error', "La classe de {$selectedClasse->nom} est pleine.");
            }

            //affectation
            $affectation = new Affecter();
            $affectation->student_id = $this->idEleve;
            $affectation->classe_id = $this->idClasse;
            $affectation->schoolYear_id = $activeSchoolYear->id;
            $affectation->save();

            // Incrément de l'effectif de la classe
            $selectedClasse->Effectif += 1;
            // ou Classe::where('id', $this->idClasse)->increment('effectif');

            $selectedClasse->save();


            // Réinitialiser les champs après l'enregistrement
            //$this->reset(['idEleve', 'idNiveau', 'idClasse']);

            // Afficher un message de succès
            Session::flash('success', 'Affectation enregistrée avec succès.');

            // Rediriger l'utilisateur vers une autre page ou rafraîchir la page actuelle
            return redirect()->route('affectation');

        }
    }



    public function render()
    {

        //$niveauSelected = Level::where();
        $classes = Classe::Where('idLevel', $this->niveauId)->get();

        return view('livewire.create-affectation-directly', compact('classes'));
    }
}
