<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Classe;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class ListeAffectation extends Component
{

    use WithPagination;

    public $searchEnter;

    public $selectedFiltreAffecter = 'Eleves affecter'; // Propriété pour suivre la sélection du filtre par affectation

    public $selectedFiltreClasse = 'Toutes les classes' ; // Propriété pour suivre la sélection du filtre par niveau


    public $affectationIdToDelete; //l'affectation a supprimer

    public $studentsNotAffecter;

    protected $listeners = ['deleteConfirmed' => 'deleteAffectation'];

    // cette fonction sera appelée lorsqu'il va cliquer sur l'icone de suppression
    public function confirmDelete($affectationId)
    {
        $this->affectationIdToDelete = $affectationId;
        $this->dispatch('show-delete-modal');
    }

    public function deleteAffectation(){
        $affectation = Affecter::find($this->affectationIdToDelete);

        if($affectation->classe->Effectif > 0 ){
            $affectation->classe->Effectif -= 1;
            $affectation->classe->save();

        }

        $affectation->delete();
        $this->dispatch('affectation-deleted');
    }


    public function updatedSelectedFiltreClasse(){
        //pour pouvoir changer le nom du bouton pour le filtre par niveau c'est un peu different avec le filtre des inscrits ou non parce qu'ici c'est l'identifiant qu'on arrive a ciblé puissequ'on a relier ça a l'identifiant
        if(!empty($this->selectedFiltreClasse)){
            if($this->selectedFiltreClasse === 'Toutes les classes'){
                $this->selectedFiltreClasse = 'Toutes les classes' ;
            }else{
                if ($this->selectedFiltreAffecter === "Elèves non affecter"){
                    $classeName = Level::find($this->selectedFiltreClasse)->libele;
                    $this->selectedFiltreClasse = $classeName;
                }else{
                    $classeName = Classe::find($this->selectedFiltreClasse)->nom;
                    $this->selectedFiltreClasse = $classeName;
                }
            }

        }
    }

    public function render(){
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Si aucune année scolaire active n'est trouvée, retournez une collection vide
        if (!$activeSchoolYear) {
            return view('livewire.liste-affectation', [
                'affectationList' => collect(),
                'studentsNotAffecterList' => collect(),
                'classes' => collect(),
            ]);
        }

        // Recherche des affectations basée sur la saisie de l'utilisateur
        $affectation = Affecter::query();

        // Filtrer les affectations pour l'année scolaire active
        $affectation->where('schoolYear_id', $activeSchoolYear->id);

        if ($this->selectedFiltreAffecter === "Elèves Affecter") {


            $affectation->whereNotNull('student_id')->where('schoolYear_id', $activeSchoolYear->id);

            // Compter le nombre d'élèves Affectés pour l'année active
            $totalAffecters = $affectation->count();

            // afin de changer le titre de la page
            $filtre = 'Elèves inscrit et Affecter (' . $totalAffecters . ')';
            $this->dispatch('filtreAffectationChanged', $filtre);

        } elseif ($this->selectedFiltreAffecter === "Elèves non affecter") {
            // Recherche des étudiants inscrits pour l'année scolaire active
            $inscriptions = Inscrire::where('schoolYear_id', $activeSchoolYear->id)->pluck('student_id');

            // Recherche des étudiants affectés pour l'année scolaire active
            $studentsAffected = Affecter::where('schoolYear_id', $activeSchoolYear->id)->pluck('student_id');

            // Recherche des étudiants inscrits mais non affectés
            $this->studentsNotAffecter = Inscrire::whereNotIn('student_id', $studentsAffected)
                ->whereIn('student_id', $inscriptions)
                ->where('schoolYear_id', $activeSchoolYear->id)
                ->with('student') // Charger les étudiants associés
                ->get();

            $totalNonAffecter = $this->studentsNotAffecter->count();

            //afin de changer le titre de la page
            $filtre = 'Elèves inscrit et non Affecter (' . $totalNonAffecter . ')';
            $this->dispatch('filtreAffectationChanged', $filtre);

        }

        if($this->selectedFiltreClasse !== 'Toutes les classes'){

            if ($this->selectedFiltreAffecter === "Elèves non affecter"){
                $this->selectedFiltreClasse = 'Toutes les classes';

            }else{
                $affectation->whereHas('classe', function ($query) {
                    $query->where('nom',  $this->selectedFiltreClasse);
                });

            }


        }

        if ($this->searchEnter) {
            $affectation->whereHas('student', function($query) {
                $query->where('nom', 'like', '%' . $this->searchEnter . '%')
                    ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                    ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%');
            });
        }


        $classes = Classe::where('schoolYear_id', $activeSchoolYear->id)->get();

        // Récupérer les classes
        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();

        // Paginer les résultats des affectations
        $affectationList = $affectation->paginate(5);

        // Liste des étudiants non affectés
        $studentsNotAffecterList = $this->studentsNotAffecter;

        // Rendre la vue avec les données
        return view('livewire.liste-affectation', compact('affectationList', 'studentsNotAffecterList', 'classes', 'levels'));
    }

}
