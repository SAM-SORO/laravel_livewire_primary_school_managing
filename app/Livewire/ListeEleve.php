<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Inscrire;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\StudentParent;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ListeEleve extends Component
{

    use WithPagination;

    public $searchEnter;

    public $IdEleveToDelete;


    public function confirmDelete($IdEleve){
        $this->IdEleveToDelete = $IdEleve;
    }

    public function delete()
    {

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Trouver l'élève à supprimer
        $eleve = Student::find($this->IdEleveToDelete);

        // Vérifier s'il y a des inscriptions associées à cet élève
        $inscriptions = Inscrire::where('student_id', $eleve->id)->where('schoolYear_id', $activeSchoolYear->id)->exists();
        $affectation = Affecter::where('student_id', $eleve->id)->where('schoolYear_id', $activeSchoolYear->id)->exists();


        if ($inscriptions || $affectation ) {
            // Si des inscriptions existent, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer cet élève car il est inscrit ou affecter.');
            return redirect()->back();
        } else {
            // Supprimer les parents associés à l'élève
            $eleve->parents()->detach();

            // Supprimer les enregistrements de la table pivot
            StudentParent::where('student_id', $eleve->id)->delete();

            try {
                // Supprimer l'élève lui-même
                $eleve->delete();

                // Émettre un message de succès
                session()->flash('success', 'L\'élève et ses parents ont été supprimés avec succès.');
                // Rediriger l'utilisateur vers la première page de la pagination
                return redirect()->route('eleves', ['page' => 1]);

            }catch(Exception $e ){
                // Émettre un message de succès
                session()->flash('error', 'L\'élève ne peut pas être supprimé car il à frequenté dans l\'ecole.');
                // Rediriger l'utilisateur vers la première page de la pagination
                return redirect()->route('eleves');
            }

        }
    }



    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $eleves = Student::query();

        if ($this->searchEnter) {
            $eleves->where('nom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%')
                ->orWhere('contactParent', 'like', '%' . $this->searchEnter . '%');
        }

        // Si une année scolaire active est trouvée, filtrez les niveaux en conséquence
        // if ($activeSchoolYear) {!p
        //     $eleves->where('schoolYear_id', $activeSchoolYear->id);
        // }

        $eleves = $eleves->orderBy('nom')->orderBy('prenom')->paginate(5);

        return view('livewire.liste-eleve', compact('eleves'));
    }
}
