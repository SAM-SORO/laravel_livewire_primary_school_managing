<?php

namespace App\Livewire;

use App\Models\Affecter;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Validation\Rules\Exists;
use Livewire\Component;
use Livewire\WithPagination;

class ListeInscription extends Component
{
    use WithPagination;

    public $searchEnter; // Propriété pour suivre la sélection du filtre par inscription

    public $selectedFiltreInscrit = 'Eleves inscrit'; // Propriété pour suivre la sélection du filtre par inscription

    public $selectedFiltreNiveau = 'Tous les niveaux' ; // Propriété pour suivre la sélection du filtre par niveau

    public $studentIdToDelete;

    public $inscriptionIdToDelete; //l'inscription a supprimer

    public $studentsNotInscrit;

    public $rafraichir = false;

    protected $listeners = ['deleteConfirmed' => 'deleteInscription'];

    // cette fonction sera appelée lorsqu'il va cliquer sur l'icone de suppression
    public function confirmDelete($inscriptionId, $studentToDelete)
    {
        $this->inscriptionIdToDelete = $inscriptionId;
        $this->studentIdToDelete = $studentToDelete;
        $this->dispatch('show-delete-modal');
    }

    public function deleteInscription(){
        //dd($this->studentIdToDelete);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $affecter = Affecter::where('student_id', $this->studentIdToDelete)->where('schoolYear_id', $activeSchoolYear->id)->exists();

        if ($affecter) {
            // Si des classes ou des niveaux sont associés, émettre un message d'erreur
            session()->flash('error', 'Impossible de supprimer cette inscription car l\'elève a été affecter dans une classe.');
            return redirect()->back();
        } else {
            $inscription = Inscrire::find($this->inscriptionIdToDelete);
            $inscription->delete();
            $this->dispatch('inscription-deleted');
        }
    }


    public function updatedSelectedFiltreNiveau(){
        //pour pouvoir changer le nom du bouton pour le filtre par niveau c'est un peu different avec le filtre des inscrits ou non parce qu'ici c'est l'identifiant qu'on arrive a ciblé puissequ'on a relier ça a l'identifiant
        if(!empty($this->selectedFiltreNiveau)){
            if($this->selectedFiltreNiveau == 'Tous les niveaux'){
                $this->selectedFiltreNiveau = 'Tous les niveaux' ;
            }else{
                //permet de rendre le filtre par niveau non fonctionnell si le fitre concerne les eleves non inscrits
                if ($this->selectedFiltreInscrit === 'Eleves non inscrit'){
                    $this->selectedFiltreNiveau = 'Tous les niveaux' ;
                }else{
                    $levelName = Level::find($this->selectedFiltreNiveau)->libele;
                    $this->selectedFiltreNiveau = $levelName;
                }

            }

        }
    }

    public function render()
    {
        // Obtenez l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->exists();

        // Recherche des niveaux basée sur la saisie de l'utilisateur
        $inscription = Inscrire::query();


        // Si une année scolaire active est trouvée, filtrez les inscriptions en conséquence
        if ($activeSchoolYear) {

            $activeSchoolYear = SchoolYear::where('active', '1')->first();

            $inscription->where('schoolYear_id', $activeSchoolYear->id);


            // Appliquer le filtre par inscription
            if ($this->selectedFiltreInscrit === 'Eleves inscrit') {

                if($this->rafraichir){
                    $this->rafraichir = false;
                    /// Actualiser la page après avoir émis l'événement
                    $this->dispatch('refresh-page');

                }

                // Récupérer les inscriptions pour lesquelles l'élève est non null et l'année scolaire correspond
                $inscription->where('schoolYear_id', $activeSchoolYear->id);

                // Obtenir le nombre total d'élèves inscrits
                $totalInscrits = Inscrire::where('schoolYear_id', $activeSchoolYear->id)->count();

                // Émettre un événement Livewire pour indiquer que le texte du bouton a changé afin de changer le titre de la page
                $filtre = 'Elèves inscrit (' . $totalInscrits . ')';
                $this->dispatch('filtreInscritChanged', $filtre);


            }
            elseif ($this->selectedFiltreInscrit === 'Eleves non inscrit') {

                // Recherche des inscriptions pour l'année scolaire active et le niveau sélectionné
                $inscrits = Inscrire::where('schoolYear_id', $activeSchoolYear->id)
                ->pluck('student_id');

                // Rechercher des élèves qui ne sont pas dans la liste des inscriptions
                $student = Student::all()->pluck('id');

                $this->studentsNotInscrit = Student::whereNotIn('id', $inscrits)
                    ->get();


                // Obtenir le nombre total d'élèves non inscrits
                $totalNonInscrits = $this->studentsNotInscrit->count();

                // Émettre un événement Livewire pour indiquer que le texte du bouton a changé afin de changer le titre de la page
                $filtre = 'Elèves non inscrit (' . $totalNonInscrits . ')';
                $this->dispatch('filtreInscritChanged', $filtre);

                $this->rafraichir = false;

            }
            elseif ($this->selectedFiltreInscrit === 'Inscriptions soldé') {

                $inscription->where('etatPaiement', '=', '1')
                            ->where('schoolYear_id', $activeSchoolYear->id);

                // Obtenir le nombre total d'inscriptions soldées
                $totalSoldes = Inscrire::where('etatPaiement', '1')->where('schoolYear_id', $activeSchoolYear->id)->count();
                // Émettre un événement Livewire pour indiquer que le texte du bouton a changé afin de changer le titre de la page

                // Concaténer le nombre total avec le texte du filtre
                $filtre = 'Inscriptions soldé (' . $totalSoldes . ')';
                $this->dispatch('filtreInscritChanged', $filtre);

                $this->rafraichir = true;


            }
            elseif ($this->selectedFiltreInscrit === 'Inscriptions non soldé') {

                $inscription->where('etatPaiement', '=', '0')
                            ->where('schoolYear_id', $activeSchoolYear->id);

                // Obtenir le nombre total d'inscriptions non soldées
                $totalNonSoldes = Inscrire::where('etatPaiement', '0')->where('schoolYear_id', $activeSchoolYear->id)->count();

                // Émettre un événement Livewire pour indiquer que le texte du bouton a changé afin de changer le titre de la page
                // Concaténer le nombre total avec le texte du filtre
                $filtre = 'Inscriptions non soldé (' . $totalNonSoldes . ')';
                $this->dispatch('filtreInscritChanged', $filtre);
            }

            // Appliquer le filtre par niveau
            if ($this->selectedFiltreNiveau !== 'Tous les niveaux') {

                $inscription->whereHas('Level', function ($query) {
                    $query->where('libele', $this->selectedFiltreNiveau);
                });

                // Récupérer le niveau correspondant au filtre sélectionné
                $levelId = Level::where('libele', $this->selectedFiltreNiveau)->value('id');

                if ($this->selectedFiltreInscrit === 'Inscriptions soldé'){

                    // Obtenir le nombre total d'inscriptions soldées pour ce niveau
                    $totalSoldes = Inscrire::where('etatPaiement', '=', '1')
                                            ->where('schoolYear_id', $activeSchoolYear->id)
                                            ->where('level_id', $levelId)
                                            ->count();

                    // Concaténer le nombre total avec le texte du filtre
                    $filtre = 'Inscriptions soldé (' . $totalSoldes . ')';
                    $this->dispatch('filtreInscritChanged', $filtre);

                }elseif($this->selectedFiltreNiveau ==="Tous les niveaux"){
                    $level = Level::where('schoolYear_id', $activeSchoolYear->id)
                    ->pluck('id');
                    $inscription->WhereIn('level_id', $level)->get();

                }elseif($this->selectedFiltreInscrit === 'Inscriptions non soldé'){

                    // Recherche des inscriptions non soldées pour l'année scolaire active et le niveau sélectionné
                    $totalNonSoldes  = Inscrire::where('etatPaiement', '=', '0')
                        ->where('schoolYear_id', $activeSchoolYear->id)
                        ->where('level_id', $levelId)
                        ->count();;

                    $filtre = 'Inscriptions non soldé (' . $totalNonSoldes . ')';
                    $this->dispatch('filtreInscritChanged', $filtre);
                }

            // }
            }

                //else if ($this->selectedFiltreInscrit === 'Inscriptions soldé'){

            //         // Obtenir le nombre total d'inscriptions soldées pour ce niveau
            //         $totalSoldes = Inscrire::where('etatPaiement', '=', '1')
            //                                 ->where('schoolYear_id', $activeSchoolYear->id)
            //                                 ->where('level_id', $levelId)
            //                                 ->count();

            //         // Concaténer le nombre total avec le texte du filtre
            //         $filtre = 'Inscriptions soldé (' . $totalSoldes . ')';
            //         $this->dispatch('filtreInscritChanged', $filtre);

            //     }elseif($this->selectedFiltreInscrit === 'Inscriptions non soldé'){

            //         // Recherche des inscriptions non soldées pour l'année scolaire active et le niveau sélectionné
            //         $totalNonSoldes  = Inscrire::where('etatPaiement', '=', '0')
            //             ->where('schoolYear_id', $activeSchoolYear->id)
            //             ->where('level_id', $levelId)
            //             ->count();;

            //         $filtre = 'Inscriptions non soldé (' . $totalNonSoldes . ')';
            //         $this->dispatch('filtreInscritChanged', $filtre);
            //     }

            // }elseif($this->selectedFiltreNiveau ==="Tous les niveaux"){
            //     $level = Level::where('schoolYear_id', $activeSchoolYear->id)
            //     ->pluck('id');
            //     $inscription->WhereIn('level_id', $level)->get();
            // }

            // Filtrer par recherche de texte
            if (!empty($this->searchEnter)) {
                $inscription->whereHas('student', function ($query) {
                    $query->where('nom', 'like', '%' . $this->searchEnter . '%')
                        ->orWhere('prenom', 'like', '%' . $this->searchEnter . '%')
                        ->orWhere('matricule', 'like', '%' . $this->searchEnter . '%');
                });
            }


            $inscriptionList = $inscription->paginate(5);

        }else{

            $inscriptionList = collect();
        }

        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();

        $studentsNotInscritList= "";
        if(!empty($this->studentsNotInscrit)){

            $studentsNotInscritList = $this->studentsNotInscrit ;

        }

        // Rendu de la vue avec les données
        return view('livewire.liste-inscription', compact('inscriptionList', 'levels', 'studentsNotInscritList'));
    }
}
