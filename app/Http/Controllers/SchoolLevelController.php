<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolLevelController extends Controller
{

    public function index(){
        // Récupérer l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        // Si aucune année scolaire active n'est trouvée, le nombre total d'élèves sera 0
        $totalNiveau = 0;

        // Si une année scolaire active est trouvée, compter le nombre total d'élèves inscrits pour cette année
        if ($activeSchoolYear) {
            $totalNiveau = Level::where('schoolYear_id', $activeSchoolYear->id)->count();
        }


        return  view('niveaux.list', ['totalNiveau' => $totalNiveau]);
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('niveaux.create');
    }

    public function edit(Level $level){
        return view('niveaux.edit', compact('level'));
    }
}
