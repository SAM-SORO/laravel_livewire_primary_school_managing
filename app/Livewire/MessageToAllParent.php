<?php

namespace App\Livewire;

use App\Mail\mailAllParent;
use App\Models\Parents;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class MessageToAllParent extends Component
{
    public $message;
    public $objet;

    public function sendMessageToAllParent(){

        // Validation des données
        $this->validate([
            'objet' => 'required',
            'message' => 'required',
        ],[
            'objet.required' => '*l\'objet est requis',
            'message.required' => '*le message est requis',
        ]);

        // Obtenez une liste de tous les parents
        $parents = Parents::all();

        if($parents){
            // Envoi de l'email
            try {
                foreach ($parents as $parent) {
                    // Envoyer un e-mail à chaque parent
                    Mail::to($parent->email)->send(new mailAllParent(
                        $this->objet, $this->message
                    ));

                }
                // Message de succès
                session()->flash('success', 'Le message à été envoyé avec succès à tous les parents.');

                return redirect()->route('parents');

            } catch (\Exception $e) {
                // Gérer les erreurs d'envoi d'email
                session()->flash('error', 'Une erreur s\'est produite lors de l\'envoi de l\'email.');

                return redirect()->back();
            }
        }

    }


    public function render()
    {
        return view('livewire.message-to-all-parent');
    }
}
