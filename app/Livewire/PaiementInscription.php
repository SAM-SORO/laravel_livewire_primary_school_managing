<?php

namespace App\Livewire;

use App\Mail\mailParentInscriptionSolde;
use App\Models\Inscrire;
use App\Models\Level;
use App\Models\Parents;
use App\Models\SchoolYear;
use App\Models\Student;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class PaiementInscription extends Component
{
    public $inscription;
    public $matricule;
    public $eleve;
    public $niveau;
    public $montantScolarite ; // Montant total de la scolarité
    public $sommePaye; // Montant déjà payé par l'utilisateur
    public $sommeRestante; // Montant déjà payé par l'utilisateur
    public $sommeVerse; // Montant déjà payé par l'utilisateur

    public function mount(){
        $this->matricule= $this->inscription->student->matricule;
        $this->eleve= $this->inscription->student->nom . " ". $this->inscription->student->prenom ;
        $this->niveau= $this->inscription->level->libele;
        $this->montantScolarite = $this->inscription->level->scolarite;
        $this->sommeVerse= $this->inscription->montant ;
        $this->sommeRestante= $this->montantScolarite  - $this->sommeVerse;

    }

    public function store()
    {

        $this->validate([
            'sommePaye' => 'required|integer',
        ], [
            'sommePaye.required' => 'Le champ somme versé est obligatoire.',
            'sommePaye.integer' => 'La somme verse doit etre un entier.',
        ]);

        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        if (!$activeSchoolYear) {
            return redirect()->route('schoolYears')->with('error', 'Aucune année n\'est active.');
        }


        try {
            if ($this->sommePaye > $this->sommeRestante   ) {
                session()->flash('error', 'la somme payer est superieur à la somme restante!');
                return redirect()->back();
            }

            // Création d'une nouvelle inscription
            $inscriptionToUpdate = Inscrire::find($this->inscription->id);

            // Si le montant payé est égal à la scolarité, l'inscription est marquée comme complète
            if ($this->montantScolarite === $this->sommePaye + $this->sommeVerse) {
                $inscriptionToUpdate->etatPaiement = '1';
            }

            $inscriptionToUpdate->montant = $this->sommePaye + $this->sommeVerse;

            // Enregistrement de l'inscription

            $student = Student::where('matricule', trim($this->matricule))->first();
            $parent = Parents::where('contact', $student->contactParent)->first();

            if($inscriptionToUpdate->save()){

                if ($this->montantScolarite === $this->sommePaye + $this->sommeVerse) {
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


                    // $contact = '225' . str_replace(' ', '', $this->contactParent);

                    // if(PaiementInscription::sendMessage($contact)){
                    //     return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail, SMS) envoyer au parent.');
                    // }

                    return redirect()->route('inscription')->with('success', 'Inscription soldé message (mail) envoyer au parent.');

                }

                // Redirection avec un message de succès
                return redirect()->route('inscription')->with('success', 'Paiement enregistrer avec succès');

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
        return view('livewire.paiement-inscription');
    }
}
