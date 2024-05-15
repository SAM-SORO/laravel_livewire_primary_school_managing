<?php

namespace App\Livewire;

use App\Mail\mailParentInscriptionSolde;
use App\Models\Classe;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\Parents;
use App\Models\Student;
use App\Models\SchoolYear;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Monolog\Handler\IFTTTHandler;
use Twilio\Rest\Client;

class CreateInscription extends Component
{
    public $eleve;
    public $idNiveau;
    public $matricule;
    public $montantTotal; // Montant total de la scolarité
    public $montantPaye; // Montant déjà payé par l'utilisateur

    public function annuler()
    {
        return redirect()->route('inscription');
    }

    public function updatedMatricule($value){

        if (!empty($this->matricule)) {
            $student = Student::where('matricule', trim($this->matricule))->first();
            if ($student) {
                $this->eleve = $student->nom . ' ' . $student->prenom;
            }else{
                $this->eleve = "";
            }
        }
    }

    public function updatedIdNiveau($value)
    {
        // je peux bien remplacer $value par $this->idNiveau sans faire de passage en parametre
        if (!empty($value)) {
            $level = Level::find($value);
            $this->montantTotal = $level->scolarite;
        }
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

            // Vérification si l'élève est déjà inscrit pour l'année scolaire active
            $existingInscription = Inscrire::where('student_id', $student->id)
            ->where('schoolYear_id', $activeSchoolYear->id)
            ->exists();

            if ($existingInscription) {
                session()->flash('error', 'Cet élève est déjà inscrit pour l\'année scolaire en cours.');
                return redirect()->back();
            }

            if ($this->montantPaye > $this->montantTotal   ) {
                session()->flash('error', 'la somme payer est superieur au montant de la scolarite!');
                return redirect()->back();
            }

            // Récupération du niveau
            $level = Level::find($this->idNiveau);

            // Création d'une nouvelle inscription
            $inscription = new Inscrire();

            // Attribution des valeurs
            $inscription->student_id = $student->id;
            $inscription->level_id = $this->idNiveau;
            $inscription->montant = $this->montantPaye;

            // Si le montant payé est égal à la scolarité, l'inscription est marquée comme complète
            if ($this->montantPaye == $level->scolarite) {
                $inscription->etatPaiement = '1';
                // Mettre à jour l'état d'affectation de l'élève dans la table d'inscription
                // Inscrire::where('student_id', $this->idEleve)
                // ->where('level_id', $this->idNiveau)
                // ->update(['etatPaiement' => '1']);
            }

            // Attribution de l'année scolaire active
            $inscription->schoolYear_id = $activeSchoolYear->id;

            $student = Student::where('matricule', trim($this->matricule))->first();
            $parent = Parents::where('contact', $student->contactParent)->first();

            // Enregistrement de l'inscription
            if($inscription->save()){

                if ($this->montantPaye == $level->scolarite) {
                    try{

                        try{
                            Mail::to($this->emailParent)->send(new mailParentInscriptionSolde([
                                'nom' => $parent->nom,
                                'prenom' => $parent->prenom,
                                'enfant' => $this->student->nom . " " . $this->student->prenom,
                                // Ajoutez d'autres données du parent ici
                            ]));
                        }catch (Exception $e) {
                            return redirect()->route('inscription')->with('success', 'Inscription effectuée.');
                        }


                        // $contact = '225' . str_replace(' ', '', $parent->contact);

                        // if(CreateInscription::sendMessage($contact)){
                        //     return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail, SMS) envoyer au parent.');
                        // }

                        return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail) envoyer au parent.');

                    }catch (Exception $e) {
                        return redirect()->route('inscription')->with('success', 'Inscription effectuée.');
                    }

                }
                return redirect()->route('inscription')->with('success', 'Inscription effectuée.');

            };

        } catch (Exception $e) {
            // En cas d'erreur, redirection avec un message d'erreur
            return redirect()->route('create-inscription')->with('error', 'Erreur rencontrée. L\'inscription n\'a pas été enregistrée.');
        }

    }




    public function sendMessage($contact){

        $basic  = new \Vonage\Client\Credentials\Basic("ee10a270", "q7c2iKvDZpad7iRG");
        $client = new \Vonage\Client($basic);

        $message = 'Bonjour Mr/Mme. Les frais de scolarité de votre enfant à l\'ecole primaire la colombe de koumassi ont été soldé' .$this->nom . " " .$this->prenom .  '';

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("2250546829308", "soro", $message)
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
        //$this->updatedMatriculeExecuted = false;

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $levels = Level::where('schoolYear_id', $activeSchoolYear->id)->get();

       /* if (!empty($this->idNiveau)) {
            $level = Level::find($this->idNiveau);
            dd($level); // Vérifiez ici si $level est récupéré correctement
            $this->montantTotal = $level->montant;
            dd($this->montantTotal); // Vérifiez ici si $this->montantTotal est correctement défini
        }*/

        return view('livewire.create-inscription', compact('levels'));
    }
}
