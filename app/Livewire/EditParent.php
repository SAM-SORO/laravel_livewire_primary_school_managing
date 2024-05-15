<?php

namespace App\Livewire;

use App\Models\Parents;
use App\Notifications\SendParentRegistration;
use Exception;
use Livewire\Component;

class EditParent extends Component
{
    public $parent;
    public $email;
    public $nom;
    public $prenom;
    public $contact;

    public function annuler()
    {
        return redirect()->route('parents');
    }

    public function mount(){
        $this->nom = $this->parent->nom;
        $this->prenom = $this->parent->prenom;
        $this->email = $this->parent->email;
        $this->contact = $this->parent->contact;
    }

    public function store()
    {
        $messages = [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être une adresse e-mail valide.',
            'email.unique' => 'L\'adresse e-mail est déjà utilisée.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'contact.required' => 'Le contact est requis.',
            'contact.string' => 'Le contact doit être une chaîne de caractères.',
            'contact.regex' => 'Le champ contact du parent doit contenir uniquement des chiffres',
            'contact.size' => 'Le champ contact du parent doit contenir exactement :size chiffres.',
        ];

        $this->validate([
            'email' => 'email|required',
            'nom' => 'string|required',
            'prenom' => 'string|required',
            'contact' => [
                'required',
                'string',
                'regex:/^[0-9 ]*$/',
                function ($attribute, $value, $fail) {
                    // Supprimer tous les espaces
                    $phoneWithoutSpaces = str_replace(' ', '', $value);
                    if (strlen($phoneWithoutSpaces) !== 10) {
                        $fail('Le champ contact du parent doit contenir exactement 10 chiffres.');
                    }
                },
            ],
        ], $messages);

        try {

            //Vérification cet parents exists
            $existingParent= Parents::where('nom', $this->parent->nom)
                                            ->where('prenom', $this->parent->prenom)
                                            ->where('id', '!=', $this->parent->id)  //ecclure l'inscription en cours
                                            ->exists();

            if ($existingParent) {
                session()->flash('error', 'Ce Parent est dejà enregistrer.');
                return redirect()->back();
            }

            $existingEmail = Parents::where('email', $this->email)
                        ->where('id', '!=', $this->parent->id)
                        ->exists(); // Utilisez exists() après la construction de la requête

            if ($existingEmail) {
                session()->flash('error', 'L\'adresse e-mail est déjà utilisée.');
                return redirect()->back();
            }


            $parent = Parents::find($this->parent->id);
            $parent->nom = $this->nom;
            $parent->prenom = $this->prenom;
            $parent->email = $this->email;
            $parent->contact = $this->contact;

            $parent->save();


            return redirect()->route('parents')->with('success', 'Modification enregistrer avec succès');

        } catch (Exception $e) {
            //Sera pris en compte si on a un problème

            session()->flash('error', "Une erreur s'est produite lors de l'enregistrement du parent" . $e->getMessage());
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.edit-parent');
    }
}
