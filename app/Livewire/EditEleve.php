<?php

namespace App\Livewire;

use App\Models\Student;
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
    public $age;
    public $genre;
    public $naissance;
    public $parent;
    public $photo;

    public function annuler()
    {
        return redirect()->route('eleves');
    }

    public function mount(){

        // Assigner les données aux propriétés du composant
        $this->nom = $this->eleve->nom;
        $this->prenom = $this->eleve->prenom;
        $this->matricule = $this->eleve->matricule;
        $this->age = $this->eleve->age;
        $this->genre = $this->eleve->sexe;
        $this->naissance = $this->eleve->naissance;
        $this->parent = $this->eleve->contactParent;
        // Vérifier s'il y a une photo enregistrée pour l'élève

        // Vérifier s'il y a une photo enregistrée pour l'élève
        if ($this->eleve->photo) {
            $photo = $this->eleve->photo; // Assigner le chemin de l'image à la propriété $photo
           // $this->photo = $this->eleve->photo;

        }

    }

    public function store()
    {
        // Définir les messages personnalisés
        $messages = [
            'nom.required' => 'Le champ nom est requis.',
            'matricule.required' => 'Le champ matricule est requis.',
            'matricule.min' => 'Le matricule doit avoir au moins :min caractères.',
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
            'matricule' => 'required|string|min:6',
            'prenom' => 'required|string',
            'age' => 'required|integer|between:6,16',
            'genre' => 'required|string',
            'naissance' => 'required|date',
            'parent' => 'required|string|min:10|regex:/^[0-9]*$/',
            'photo' => 'nullable|file',
        ], $messages);

        // if ($validatedData->fails()) {
        //     return redirect()->back()->with('error', $validatedData->errors()->first());
        // dd($validatedData->errors()->all());
        // }
        try {
            $validatedData = $validatedData->validated(); //pour pouvoir acceder au element comme ça $validatedData['matricule']

            $existingStudent = Student::where('matricule', $validatedData['matricule'])->where('id','=!',$this->eleve->id)->first();

            if ($existingStudent) {
                // Si l'élève existe déjà, vous pouvez renvoyer un message d'erreur ou effectuer une autre action nécessaire
                session()->flash('error', 'Cet élève existe déjà.');
                return redirect()->back();
            }

            $student = Student::find($this->eleve->id);
            $student->matricule = $validatedData['matricule'];
            $student->nom = $validatedData['nom'];
            $student->prenom = $validatedData['prenom'];
            $student->sexe = $validatedData['genre'];
            $student->age = $validatedData['age'];
            $student->naissance = $validatedData['naissance'];
            $student->contactParent = $validatedData['parent'];

            if ($this->photo) {

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
        return view('livewire.edit-eleve');

    }
}
