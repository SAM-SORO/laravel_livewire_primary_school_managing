<?php

namespace App\Livewire;

use App\Models\Inscrire;
use App\Models\Student;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditEleve extends Component
{
    use WithFileUploads;

    public $eleve;
    public $nom;
    public $prenom;
    public $matricule;
    public $genre;
    public $naissance;
    public $parent;
    public $photo;
    public $photoUrl;

    public function updatedPhoto($value)
    {
        if(!empty($this->photo)){
            // Mettez à jour l'URL de l'image lorsque la photo est mise à jour
            $this->photoUrl = $this->photo->temporaryUrl();
        }

    }

    public function mount(){

        // Assigner les données aux propriétés du composant
        $this->nom = $this->eleve->nom;
        $this->prenom = $this->eleve->prenom;
        $this->matricule = $this->eleve->matricule;
        $this->genre = $this->eleve->sexe;
        $this->naissance = $this->eleve->naissance;
        $this->parent = $this->eleve->contactParent;
        // Vérifier s'il y a une photo enregistrée pour l'élève

        // Vérifier s'il y a une photo enregistrée pour l'élève

        // Construire l'URL complète de la photo de l'élève
        if ($this->eleve->photo) {
            $this->photoUrl = asset('storage/img/' . $this->eleve->photo);
            $this->photo = $this->eleve->photo;
        } else {
            // Utiliser une image par défaut si aucune photo n'est définie
            $this->photoUrl = 'https://lh3.googleusercontent.com/a-/AFdZucpC_6WFBIfaAbPHBwGM9z8SxyM1oV4wB4Ngwp_UyQ=s96-c';
        }


    }

    public function annuler()
    {
        return redirect()->route('eleves');
    }


    public function store()
    {
        // Définir les messages personnalisés
        $messages = [
            'nom.required' => 'Le champ nom est requis.',
            'prenom.required' => 'Le champ prénom est requis.',
            'naissance.required' => 'Le champ date de naissance est requis.',
            'naissance.date' => 'Le champ date de naissance doit être une date valide.',
            'parent.required' => 'Le contact d\'un parent est requis.',
            'contact.regex' => 'Le champ contact du parent doit contenir uniquement des chiffres .',
            'contact.size' => 'Le champ contact du parent doit contenir exactement :size chiffres.',
        ];


        $validatedData = Validator::make($this->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'genre' => 'required|string',
            'naissance' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    // Récupérer l'année actuelle
                    $currentYear = Carbon::now()->year;

                    // Calculer les bornes d'âge
                    $minBirthYear = $currentYear - 16; // L'élève ne doit pas dépasser 16 ans
                    $maxBirthYear = $currentYear - 6;  // L'élève doit avoir au moins 6 ans

                    // Extraire l'année de naissance de la date fournie
                    $birthYear = Carbon::parse($value)->year;

                    // Vérifier si l'année de naissance est dans l'intervalle autorisé
                    if ($birthYear < $minBirthYear || $birthYear > $maxBirthYear) {
                        $fail('L\'année de naissance de l\'élève doit être comprise entre ' . $minBirthYear . ' et ' . $maxBirthYear . ' (entre 6 et 16 ans).');
                    }
                },

                // function ($attribute, $value, $fail) {
                //     // Calculer l'âge à partir de la date de naissance
                //     $age = Carbon::parse($value)->age;

                //     // Vérifier si l'âge est compris entre 6 et 16 ans
                //     if ($age < 6 || $age > 16) {
                //         $fail('L\'âge de l\'élève doit être compris entre 6 et 16 ans.');
                //     }
                // },
            ],
            'parent' => [
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
            'photo' => 'nullable|file',
        ], $messages);

        // if ($validatedData->fails()) {
        //     return redirect()->back()->with('error', $validatedData->errors()->first());
        // dd($validatedData->errors()->all());
        // }
        try {
            $validatedData = $validatedData->validated(); //pour pouvoir acceder au element comme ça : $validatedData['matricule']

            $existingStudent = Student::where('nom', $validatedData['nom'])->where('prenom', $validatedData['prenom'])->where('id','=!',$this->eleve->id)->first();

            if ($existingStudent) {
                // Si l'élève existe déjà, vous pouvez renvoyer un message d'erreur ou effectuer une autre action nécessaire
                session()->flash('error', 'Cet élève existe déjà.');
                return redirect()->back();
            }

            //le constat est que je n'arrive pas a valider la mofification d'un eleve qui est inscrit
            //$StudentIsInscription = Inscrire::where('student_id', );

            $student = Student::find($this->eleve->id);
            $student->nom = $validatedData['nom'];
            $student->prenom = $validatedData['prenom'];
            $student->sexe = $validatedData['genre'];
            $student->naissance = $validatedData['naissance'];
            $student->contactParent = $validatedData['parent'];

            if ($this->photo) {

                $fileName = $this->photo->getClientOriginalName();

                // Vérifier si le fichier existe déjà dans la base de données
                $existingPhoto = Student::where('photo', $fileName)
                                        ->where('id', '!=', $this->eleve->id)->first();

                if ($existingPhoto) {
                    // Le fichier existe déjà, vous pouvez gérer cette situation ici
                    session()->flash('error', 'Cette photo à deja ete utiliser pour un élève.');
                    return redirect()->back();
                }

                // Enregistrer la photo avec le même nom de fichier que celui importé
                // $path = $this->photo->storeAs('img', $fileName);
                $path = $this->photo->storePubliclyAs('img', $fileName);

                $student->photo = $fileName;
            }

            $student->save();

            session()->flash('success', 'Modification Enregistrer avec succès');
            return redirect()->route('eleves');

        } catch(Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de la modification de l\'eleve.');
            // Log error message if needed
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.edit-eleve');

    }
}
