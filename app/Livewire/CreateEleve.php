<?php
namespace App\Livewire;

use App\Mail\SendParentCreate;
use App\Models\Parents;
use App\Models\SchoolYear;
use App\Models\Student;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Exception as GlobalException;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Twilio\Rest\Client;

class CreateEleve extends Component
{
    use WithFileUploads;
    public $nom;
    public $prenom;
    public $genre;
    public $naissance;
    public $parent;
    public $photo;
    public $nomParent;
    public $prenomParent;
    public $emailParent;
    public $contactParent;



    public $photoUrl; // Ajoutez cette propriété pour stocker l'URL de l'image

    public function updatedPhoto($value)
    {
        // Mettez à jour l'URL de l'image lorsque la photo est mise à jour
        $this->photoUrl = $this->photo->temporaryUrl();
    }



    public function annuler()
    {
        return redirect()->route('eleves');
    }

    public function store()
    {
        // Définir les messages personnalisés
        $messages = [
            'nom.required' => 'Le nom de l\'élève est requis.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.regex' => 'Le nom ne doit pas contenir de caractères spéciaux ou des chifres.',
            'prenom.required' => 'Le prénom de l\'élève est requis.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.regex' => 'Le prenom ne doit pas contenir de caractères spéciaux ou des chifres.',
            'naissance.required' => 'Le champ date de naissance est requis.',
            'naissance.date' => 'Le champ date de naissance doit être une date valide.',
            'genre.required' => 'Le champ genre est requis.',
            'nomParent.required' => 'Le nom du parent est requis.',
            'nomParent.string' => 'Le nom du parent doit être une chaîne de caractères.',
            'nomParent.regex' => 'Le nom du parent ne doit pas contenir de caractères spéciaux ou des chifres.',
            'prenomParent.required' => 'Le prénom du parent est requis.',
            'prenomParent.string' => 'Le prénom du parent doit être une chaîne de caractères.',
            'prenomParent.regex' => 'Le prénom du parent  ne doit pas contenir de caractères spéciaux ou des chifres.',
            'contactParent.required' => 'Le champ contact du parent est requis.',
            'emailParent.required' => 'L\'adresse e-mail est requise.',
            'emailParent.email' => 'L\'adresse e-mail doit être une adresse e-mail valide.',
            'emailParent.unique' => 'L\'adresse e-mail est déjà utilisée.',
            'contactParent.string' => 'Le champ contact du parent doit être une chaîne de caractères.',
            'contactParent.regex' => 'Le champ contact du parent ne doit contenir que des chiffres.',
            'contactParent.size' => 'Le champ contact du parent doit contenir exactement :size chiffres.',
            'photo.nullable' => 'Le fichier photo doit être de type image.',
            'photo.file' => 'Le fichier photo doit être de type image.',
        ];


        $this->validate([
            'nom' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s\-]*$/'], // Seuls les lettres, espaces et tirets sont autorisés
            'prenom' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s\-]*$/'], // Seuls les lettres, espaces et tirets sont autorisés
            'genre' => 'required|string',
            'naissance' => [
                'required',
                'date',
                // Fonction de validation pour l'âge
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
            ],
            'emailParent' => 'required|email',
            'nomParent' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s\-]*$/'], // Seuls les lettres, espaces et tirets sont autorisés
            'prenomParent' => ['required', 'string', 'regex:/^[a-zA-ZÀ-ÿ\s\-]*$/'], // Seuls les lettres, espaces et tirets sont autorisés
            'contactParent' => [
                'required',
                'string',
                'regex:/^[0-9 ]*$/',
                function ($attribute, $value, $fail) {
                    // Supprimer tous les espaces
                    $phoneWithoutSpaces = str_replace(' ', '', $value);
                    if (strlen($phoneWithoutSpaces) !== 10) {
                        $fail('Le contact doit contenir exactement 10 chiffres.');
                    }
                },
            ],
            'photo' => 'nullable|file',
        ], $messages);


        try {

            // Récupérer l'année en cours
            $activeYear = SchoolYear::where('active', 1)->value('currentYear');

            // Formater l'année en format "y"
            $anneeEnCours = substr($activeYear, -2);

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



            $existingStudent = Student::where('nom', $this->nom)->where('prenom', $this->prenom)->first();


            if ($existingStudent) {
                // Si l'élève existe déjà, vous pouvez renvoyer un message d'erreur ou effectuer une autre action nécessaire
                session()->flash('error', 'Cet élève existe déjà.');
                return redirect()->back();
            }


            $student = new Student();
            $student->nom = $this->nom;
            $student->matricule = $matricule;
            $student->prenom = $this->prenom;
            $student->sexe = $this->genre;
            $student->naissance = $this->naissance;
            $student->contactParent = $this->contactParent;

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



            if($student->save()){


                // Vérifier si le parent existe déjà
                $parent = Parents::where('nom', $this->nomParent)
                ->where('prenom', $this->prenomParent)
                ->where('contact', $this->contactParent)
                ->first();

                // Si le parent n'existe pas, créez un nouveau parent
                if (!$parent) {
                    $parent = new Parents();
                    $parent->nom = $this->nomParent;
                    $parent->prenom = $this->prenomParent;
                    $parent->email = $this->emailParent;
                    $parent->contact = $this->contactParent;
                    $student->parents()->attach($parent->id);


                    $parent->save();

                }

                // Associez le parent à l'élève
                $student->parents()->attach($parent->id);

                // Envoyer l'email au parent
                try {
                    Mail::to($this->emailParent)->send(new SendParentCreate([
                        'nom' => $this->nomParent,
                        'prenom' => $this->prenomParent,
                        'enfant' => $this->nom . " " . $this->prenom,
                        // Ajoutez d'autres données du parent ici
                    ]));

                    $contact = '225' . str_replace(' ', '', $this->contactParent);

                    if(CreateEleve::sendMessage($contact)){
                        session()->flash('success', 'Élève enregistrer avec succès. email enoyée au parent avec un SMS');
                        return redirect()->route('eleves');
                    };

                    session()->flash('success', 'Élève enregistrer avec succès. email enoyée au parent');
                    return redirect()->route('eleves');

                } catch (\Exception $e) {
                    // Gérer l'exception si l'envoi d'email échoue
                    session()->flash('success', 'Élève enregistrer avec succès');
                    return redirect()->route('eleves');
                }
            }

        } catch(GlobalException $e) {
            session()->flash('error', 'Une erreur est survenue lors de l\'ajout de l\'élève.' . $e->getMessage());
            // Log error message if needed
            return redirect()->back();
        }
    }



    public function sendMessage($contact){

        $basic  = new \Vonage\Client\Credentials\Basic("ee10a270", "q7c2iKvDZpad7iRG");
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
        return view('livewire.create-eleve');
    }
}
