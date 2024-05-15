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
        return redirect()->route('affectation');
    }

    public function updatedIdClasse($value)
    {
        // je peux bien remplacer $value par $this->idNiveau sans faire de passage en parametre
        if (!empty($value)) {
            $classe = Classe::find($value);
            $this->effectif = $classe->Effectif . '/' . $classe->capacite ;
        }
    }

    public function store()
    {

        // Valider les données
        $this->validate([
            'idEleve' => 'required',
            'idNiveau' => 'required',
            'idClasse' => 'required',
        ]);


        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {

            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        } else {

            // Vérification si l'élève est déjà affecter pour l'année scolaire active
            $existingAffectation = Affecter::where('student_id', $this->idEleve)
            ->where('schoolYear_id', $activeSchoolYear->id)
            ->exists();

            if ($existingAffectation) {
                session()->flash('error', 'Cet élève est déjà affecter pour l\'année scolaire en cours.');
                return redirect()->back();
            }

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
            //Classe::where('id', $this->idClasse)->increment('effectif');
            $selectedClasse->save();

            // Réinitialiser les champs après l'enregistrement
            $this->reset(['idEleve', 'idNiveau', 'idClasse']);

            // Afficher un message de succès
            Session::flash('success', 'Affectation enregistrée avec succès.');

            // Rediriger l'utilisateur vers une autre page ou rafraîchir la page actuelle
            //return redirect()->route('classes');

        }
    }

    public function render()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!empty($this->idNiveau)) {

            // récupérer l'identifiant des élèves inscrits pour le niveau sélectionné et qui n'ont pas encore été affectés à une classe
           $inscrits = Inscrire::where('level_id', $this->idNiveau)
           ->pluck('student_id'); // Récupérez uniquement les IDs des élèves

            //dd($this->idClasse);
           $affecter = Affecter::where('schoolYear_id', $activeSchoolYear->id)->pluck('student_id');


           // Sélectionnez les élèves correspondant à ces IDs, triés par ordre croissant de nom et de prénom
           $this->eleves = Student::whereNotIn('id', $affecter)
                   ->whereIn('id', $inscrits)
                   ->orderBy('nom')
                   ->orderBy('prenom')
                   ->get(['id','matricule', 'nom', 'prenom']);

        }
        //$niveauSelected = Level::where();
        $classes = Classe::Where('idLevel', $this->idNiveau)->get();
        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();
        $eleves = $this->eleves;

        return view('livewire.create-affectation', compact('classes', 'levels', 'eleves'));
    }
}
