<?php

namespace App\Livewire;

use App\Mail\mailParentInscriptionSolde;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\Parents;
use App\Models\SchoolYear;
use App\Models\Student;
use Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateInscriptionPaiement extends Component
{

    public $student;
    public $matricule;
    public $eleve;
    public $idNiveau;
    public $montantScolarite; // Montant total de la scolarité
    public $sommePaye; // Montant déjà payé par l'utilisateur

    public function annuler()
    {
        return redirect()->route('classes');
    }

    public function updated($value){

        if (!empty($this->idNiveau)) {
            $level = Level::where('id', ($this->idNiveau))->first();
            if ($level) {
                $this->montantScolarite = $level->scolarite;
            }else{
                $this->eleve = "";
            }
        }
    }

    public function mount(){
        $eleve = Student::find($this->student);
        $this->matricule = $eleve->matricule;
        $this->eleve = $eleve->nom . " " . $eleve->prenom;
    }

    public function store()
    {

        $this->validate([
            'sommePaye' => 'required',

        ], [
            'sommePaye.required' => 'Le champ Somme paye est obligatoire.',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        }

        try {
            // Récupération de l'étudiant
            $student = Student::where('matricule', $this->matricule)->first();

            // Vérification si l'élève est déjà inscrit pour l'année scolaire active
            $existingInscription = Inscrire::where('student_id', $student->id)
            ->where('schoolYear_id', $activeSchoolYear->id)
            ->exists();

            if ($existingInscription) {
                session()->flash('error', 'Cet élève est déjà inscrit pour l\'année scolaire en cours.');
                return redirect()->back();
            }

            if ($this->sommePaye > $this->montantScolarite   ) {
                session()->flash('error', 'la somme payé est superieur au montant de la scolarite!');
                return redirect()->back();
            }

            // Récupération du niveau
            $level = Level::find($this->idNiveau);

            // Création d'une nouvelle inscription
            $inscription = new Inscrire();

            // Attribution des valeurs
            $inscription->student_id = $student->id;
            $inscription->level_id = $this->idNiveau;
            $inscription->montant = $this->sommePaye;

            // Si le montant payé est égal à la scolarité, l'inscription est marquée comme complète
            if ($this->sommePaye == $level->scolarite) {
                $inscription->etatPaiement = '1';
                // Mettre à jour l'état d'affectation de l'élève dans la table d'inscription
                // Inscrire::where('student_id', $this->idEleve)
                // ->where('level_id', $this->idNiveau)
                // ->update(['etatPaiement' => '1']);
            }

            // Attribution de l'année scolaire active
            $inscription->schoolYear_id = $activeSchoolYear->id;


            // Enregistrement de l'inscription
            if($inscription->save()){

                $eleve = Student::find($this->student);

                $parent = Parents::where('contact', $eleve->contactParent)->first();

                if ($this->sommePaye == $level->scolarite) {
                    try{
                        Mail::to($parent->email)->send(new mailParentInscriptionSolde([
                            'nom' => $parent->nom,
                            'prenom' => $parent->prenom,
                            'enfant' => $eleve->nom . " " . $eleve->prenom,
                            // Ajoutez d'autres données du parent ici
                        ]));
                    }catch (Exception $e) {
                        return redirect()->route('inscription')->with('success', 'Inscription effectuée.');
                    }

                    // $contact = '225' . str_replace(' ', '', $eleve->contactParent);


                    // if(CreateInscriptionPaiement::sendMessage($contact)){
                    //     return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail, SMS) envoyer au parent.');
                    // }

                    return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail) envoyer au parent.');

                }

                // Redirection avec un message de succès
                return redirect()->route('inscription')->with('success', 'Inscription effectuée.');

            };



        } catch (Exception $e) {
            // En cas d'erreur, redirection avec un message d'erreur
            return redirect()->back()->with('error', 'Erreur rencontrée. L\'inscription n\'a pas été enregistrée.');
        }
    }


    public function sendMessage($contact){
        $apiSecret = env('VONAGE_SECRET ');
        $auth = env('VONAGE_AUTH ');
        $basic  = new \Vonage\Client\Credentials\Basic($apiSecret, $auth);
        $client = new \Vonage\Client($basic);

        $message = 'Bonjour Mr/Mme. Vous venez d\'etre ajouté en tant que parent de l\'elève '.$this->nom . " " .$this->prenom .  'à l\'ecole primaire la colombe de koumassi';

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($contact, "soro", $message)
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            return true;
        } else {
            return false;
        }
    }


    public function render()
    {
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();
        return view('livewire.create-inscription-paiement', compact('levels'));
    }
}
