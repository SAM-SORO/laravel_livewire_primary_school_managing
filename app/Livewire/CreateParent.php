<?php

namespace App\Livewire;

use App\Mail\SendParentCreate;
use App\Models\Parents;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\StudentParents;
use App\Notifications\SendParentRegistration;
use Carbon\Exceptions\Exception;
use Exception as GlobalException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CreateParent extends Component
{
    public $email;
    public $nom;
    public $prenom;
    public $contact;
    public $matricule;
    public $enfant;

    public function annuler()
    {
        return redirect()->route('parents');
    }

    public function updatedMatricule($value){
        if (!empty($this->matricule)) {
            $enfant = Student::where('matricule', trim($this->matricule))->first();
            if ($enfant) {
                $this->contact = $enfant->contactParent;
                $this->enfant = $enfant;
            }else{
                $this->contact = "Aucun etudiant trouver avec ce matricule";
            }
        }
    }

    public function store()
    {
        $messages = [
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être une adresse e-mail valide.',
            'email.unique' => 'L\'adresse e-mail est déjà utilisée.',
            'nom.required' => 'Le nom est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'prenom.required' => 'Le prénom est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'contact.required' => 'Le contact est requis.',
            'contact.string' => 'Le contact doit être une chaîne de caractères.',
            'contact.regex' => 'Le champ contact du parent doit contenir uniquement des chiffres',
            'contact.size' => 'Le champ contact du parent doit contenir exactement :size chiffres.',
        ];

        $this->validate([
            'email' => 'email|required|unique:parents,email',
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
            $existingParent = Parents::where('nom', $this->nom)
                                            ->where('prenom', $this->prenom)
                                            ->orWhere('email', $this->email)
                                            ->exists();

            if ($existingParent) {
                session()->flash('error', 'Ce Parent est déjà enregistré.');
                return redirect()->back();
            }

            $parent = new Parents();
            $parent->nom = $this->nom;
            $parent->prenom = $this->prenom;
            $parent->email = $this->email;
            $parent->contact = $this->contact;

            // Vérifier si la sauvegarde du parent est réussie
            if ($parent->save()) {
                // Sauvegarder la relation dans la table pivot si l'enfant est présent
                if (!empty($this->enfant)) {
                    try {
                        $parentEnfant = new StudentParent();
                        $parentEnfant->parent_id = $parent->id;
                        $parentEnfant->student_id = $this->enfant->id;
                        $parentEnfant->save();
                    } catch (Exception $e) {
                        // Gérer l'exception plus tard
                    }
                }

            }


        } catch (Exception $e) {
            // Gérer l'exception
            session()->flash('error', "Une erreur s'est produite lors de l'enregistrement du parent");
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.create-parent');
    }
}
