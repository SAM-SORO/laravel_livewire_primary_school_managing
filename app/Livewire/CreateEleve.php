<?php
namespace App\Livewire;

use App\Models\Student;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class CreateEleve extends Component
{
    use WithFileUploads;
    public $nom;
    public $prenom;
    public $age;
    public $genre;
    public $naissance;
    public $parent;
    public $photo;

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
            'age.required' => 'Le champ âge est requis.',
            'age.integer' => 'Le champ âge doit être un nombre entier.',
            'naissance.required' => 'Le champ date de naissance est requis.',
            'naissance.date' => 'Le champ date de naissance doit être une date valide.',
            'parent.required' => 'Le contact d\'un parent est requis.',
            'parent.min' => 'Le contact du parent doit avoir au moins :min chiffres.',
            'parent.regex' => 'Le champ contact du parent doit contenir uniquement des chiffres.',
            'age.between' => 'L\'âge doit être compris entre 6 et 16 ans.',
        ];

        $validatedData = Validator::make($this->all(), [
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'age' => 'required|integer|between:6,16',
            'genre' => 'required|string',
            'naissance' => 'required|date',
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

            // Récupérer l'année en cours
            $anneeEnCours = Carbon::now()->format('y');

            do {
                // Générer une suite aléatoire de chiffres pour le matricule
                $suiteAleatoire = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);

                // Générer une lettre aléatoire pour terminer le matricule
                $lettreAleatoire = chr(rand(65, 90)); // Génère une lettre majuscule de l'alphabet ASCII (A-Z)

                // Générer le matricule en concaténant les parties
                $matricule = $anneeEnCours . $suiteAleatoire . $lettreAleatoire;

                // Vérifier si le matricule est déjà utilisé
                $matriculeExiste = Student::where('matricule', $matricule)->exists();

            } while ($matriculeExiste);

            $validatedData = $validatedData->validated(); //pour pouvoir acceder au element comme ça $validatedData['matricule']

            $existingStudent = Student::where('nom', $validatedData['nom'])->where('nom', $validatedData['prenom'])->first();

            if ($existingStudent) {
                // Si l'élève existe déjà, vous pouvez renvoyer un message d'erreur ou effectuer une autre action nécessaire
                session()->flash('error', 'Cet élève existe déjà.');
                return redirect()->back();
            }

            $student = new Student();
            $student->nom = $validatedData['nom'];
            $student->matricule = $matricule;
            $student->prenom = $validatedData['prenom'];
            $student->sexe = $validatedData['genre'];
            $student->age = $validatedData['age'];
            $student->naissance = $validatedData['naissance'];
            $student->contactParent = $validatedData['parent'];

            //concernat la photo
            if ($this->photo) {
                //recuperer la photo
                $fileName = $this->photo->getClientOriginalName();

                // Vérifier si le fichier existe déjà dans la base de données
                $existingPhoto = Student::where('photo', $fileName)->first();

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

            session()->flash('success', 'Élève ajouté avec succès');
            return redirect()->route('eleves');

        } catch(Exception $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout de l\'élève.');
            // Log error message if needed
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.create-eleve');
    }
}
