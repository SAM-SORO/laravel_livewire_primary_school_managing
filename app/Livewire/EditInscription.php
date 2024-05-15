<?php

namespace App\Livewire;

use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Exception;
use Livewire\Component;

class EditInscription extends Component
{
    public $inscription;
    public $eleve;
    public $idNiveau;
    public $matricule;
    public $montantScolarite; // Montant total de la scolarité
    public $montantPaye; // Montant déjà payé par l'utilisateur

    public function annuler()
    {
        return redirect()->route('classes');
    }

    public function mount(){
        $this->matricule = $this->inscription->student->matricule;
        $this->eleve = $this->inscription->student->nom. " " . $this->inscription->student->prenom;
        $this->idNiveau = $this->inscription->level->id;
        $this->montantScolarite = $this->inscription->level->scolarite;
        $this->montantPaye = $this->inscription->montant;
    }


    public function store()
    {

        $this->validate([
            'matricule' => 'required',
            'eleve' => 'required',
            'idNiveau' => 'required',
        ], [
            'matricule.required' => 'Le champ matricule est obligatoire.',
            'eleve.required' => 'Le champ élève est obligatoire.',
            'idNiveau.required' => 'Le champ niveau est obligatoire.',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        }


        try {
            // Récupération de l'étudiant
            $student = Student::where('matricule', $this->matricule)->first();


            //Vérification si l'élève est déjà inscrit pour l'année scolaire active
            $existingInscription = Inscrire::where('student_id', $student->id)
                                            ->where('schoolYear_id', $activeSchoolYear->id)
                                            ->where('id', '!=', $this->inscription->id)  //ecclure l'inscription en cours
                                            ->exists();

            if ($existingInscription) {
                session()->flash('error', 'Cet élève est déjà inscrit pour l\'année scolaire en cours.');
                return redirect()->back();
            }

            if ($this->montantPaye > $this->montantScolarite) {
                session()->flash('error', 'la somme payer est superieur au montant de la scolarite!');
                return redirect()->back();
            }

            // Récupération du niveau
            $level = Level::where('id', $this->idNiveau)->first();

            // Création d'une nouvelle inscription
            $inscription = Inscrire::where('id', $this->inscription->id)->where('schoolYear_id', $activeSchoolYear->id)->first();

            $inscription->level_id = $this->idNiveau;
            $inscription->montant = $this->montantPaye;

            // Si le montant payé est égal à la scolarité, l'inscription est marquée comme complète
            if ($this->montantPaye == $level->scolarite) {
                $inscription->etatPaiement = '1';
            }else{
                $inscription->etatPaiement = '0';
            }

            // Enregistrement de l'inscription
           $inscription->save();

            // Redirection avec un message de succès
            return redirect()->route('inscription')->with('success', 'modification enregistrée avec succès');

        } catch (Exception $e) {
            // En cas d'erreur, redirection avec un message d'erreur
            return redirect()->back()->with('error', 'Erreur rencontrée. La modification n\'a pas été enregistrée.' . $e->getMessage());
        }
    }

    public function render()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();

        return view('livewire.edit-inscription' , compact('levels'));
    }
}
