<?php
namespace App\Exports;

use App\Models\Affecter;
use App\Models\Classe;
use App\Models\Inscrire;
use App\Models\SchoolYear;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ListeClasseCVS implements FromCollection, WithTitle, WithHeadings
{
    use Exportable;

    protected $classeId;

    public function __construct($classe)
    {
        $this->classeId = $classe->id;
    }

    public function title(): string
    {
        // Récupérer le nom de la classe
        $classe = Classe::findOrFail($this->classeId);
        return 'Liste Classe ' . $classe->nom;
    }

    public function collection()
{
    // Obtenez l'année scolaire active
    $activeSchoolYear = SchoolYear::where('active', '1')->first();

    $affecters = Affecter::where('classe_id', $this->classeId)
                     ->where('schoolYear_id', $activeSchoolYear->id)
                     ->with('student')
                     ->get();
                     

    $data = $affecters->map(function ($affecter, $index) {
        return [
            'N°' => $index + 1, // Numéro d'ordre
            'Nom' => $affecter->student->nom,
            'Prénom' => $affecter->student->prenom,
            'Sexe' => $affecter->student->sexe,
        ];
    });

    return $data;
}


    public function headings(): array
    {
        return [
            'N°',
            'Nom',
            'Prénom',
            'Sexe',
        ];
    }
}



// namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromCollection;

// class listeClacsseCVS implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         //
//     }
// }
