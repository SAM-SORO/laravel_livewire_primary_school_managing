<?php

namespace App\Livewire;

use App\Mail\mailOneParent;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;


class MessageToOneParent extends Component
{
    public $parent;
    public $infoParent;
    public $enfant;
    public $message;
    public $objet;

    public function mount(){

        $this->infoParent = $this->parent->nom . " " . $this->parent->prenom;

        $enfantComplet  = "";

        // Itérer sur chaque élève dans la collection $this->parent->students
        foreach ($this->parent->students as $student) {
            // Concaténer le nom et le prénom de chaque élève à $this->enfant
           $enfantComplet .= $student->nom . " " . $student->prenom . ", ";

        }

        // Supprimer la virgule et l'espace à la fin de la chaîne
        $this->enfant = rtrim($enfantComplet, ', ');

    }

    public function sendMessageToOneParent(){

        // Validation des données
        $this->validate([
            'objet' => 'required',
            'message' => 'required',
        ],[
            'objet.required' => '*l\'objet est requis',
            'message.required' => '*le message est requis',
        ]);

        // Envoi de l'email
        try {

            Mail::to($this->parent->email)->send(new mailOneParent(
                $this->objet, $this->message
            ));

            $contact = '225' . str_replace(' ', '', $this->parent->contact);

            if(MessageToOneParent::sendMessage($contact, $this->message)){

                session()->flash('success', 'Le message (email, SMS) à envoyé avec succès');

                return redirect()->route('parents');
            };

            // Message de succès
            session()->flash('success', 'Le message (email) à été envoyé avec succès à Msr/Mme '. $this->parent->nom . " " . $this->parent->prenom );

            return redirect()->route('parents');

        } catch (\Exception $e) {
            // Gérer les erreurs d'envoi d'email
            session()->flash('error', 'Une erreur s\'est produite lors de l\'envoi du message.' . $e->getMessage());

            return redirect()->back();
        }

    }


    public function sendMessage($contact, $message){

        $basic  = new \Vonage\Client\Credentials\Basic("b5868080", "ldc99fjAHaKIyhcn");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($contact, "FONGBE", $message)
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
        return view('livewire.message-to-one-parent');
    }
}
