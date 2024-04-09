<?php
namespace App\Livewire;

use App\Models\SchoolYear;
use Carbon\Carbon;
use Livewire\Component;

class CreateSchoolYear extends Component
{
    public $startYear;
    public $endYear;

    public function annuler()
    {
        return redirect()->route('schoolYears');
    }

    public function store()
    {
        // Validation des données du formulaire
        $this->validate([
            'startYear' => 'required',
            'endYear' => 'required|gt:startYear',
        ], [
            'startYear.required' => '*L\'année de début est obligatoire.',
            'endYear.required' => '*L\'année de fin est obligatoire.',
            'endYear.gt' => 'L\'année de fin doit être strictement supérieure à l\'année de début.',
        ]);

        // Vérifier si cette année scolaire existe déjà
        $existingSchoolYear = SchoolYear::where('startYear', $this->startYear)->where('endYear', $this->endYear)->first();
        if ($existingSchoolYear) {
            return redirect()->route('create-school-year')->with('error', 'Cette année scolaire a déjà été enregistrée.');
        }

        // Vérifier si les années scolaires sont successives
        if ($this->startYear != $this->endYear - 1) {
            return redirect()->route('create-school-year')->with('error', 'Les années scolaires doivent être successives.');
        }
        // Création de la nouvelle année scolaire
        try {
            $schoolYear = new SchoolYear();
            $schoolYear->startYear = $this->startYear;
            $schoolYear->endYear = $this->endYear;
            $schoolYear->currentYear = Carbon::now()->format('Y');
            $schoolYear->save();

            return redirect()->route('schoolYears')->with('success', 'L\'année scolaire a bien été enregistrer.');

            // return redirect()->route('schoolYears')->with('success', 'L\'année scolaire a bien été ajoutée.')  pour le redirigrer vers l'affichage

        } catch (\Exception $e) {
            // Gérer l'exception ici
            return redirect()->route('create-school-year')->with('error', 'Une erreur est survenue lors de l\'enregistrement de l\'année scolaire.');
        }
    }

    public function mount(){
        $this->startYear = null;
        $this->endYear = null;
    }

    public function render()
    {
        // Remplir la liste des années disponibles
        $years = range(date('Y') - 2, date('Y') + 2);

        return view('livewire.create-school-year', ['years' => $years]);
    }
}
