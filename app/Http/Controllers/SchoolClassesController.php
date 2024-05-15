<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolClassesController extends Controller
{
    public function index(){

        // Récupérer l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Si aucune année scolaire active n'est trouvée, le nombre total d'élèves sera 0
        $totalClasse = 0;

        // Si une année scolaire active est trouvée, compter le nombre total pour cette année
        if ($activeSchoolYear) {
            $totalClasse = Classe::where('schoolYear_id', $activeSchoolYear->id)->count();
        }

        return  view('classes.list' , ['totalClasse' => $totalClasse]);
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('classes.create');
    }

    public function edit(Classe $classe){
        return view('classes.edit', compact('classe'));
    }
}
