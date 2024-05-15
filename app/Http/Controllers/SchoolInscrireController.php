<?php

namespace App\Http\Controllers;

use App\Models\Inscrire;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class SchoolInscrireController extends Controller
{
    public function index(){
        // Récupérer l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $totalInscrits= 0;

        if ($activeSchoolYear) {
            // Compter le nombre d'élèves inscrits pour l'année active
            $totalInscrits = Inscrire::where('schoolYear_id', $activeSchoolYear->id)->count();
        }

        return  view('inscription.list' , ['totalInscrits' => $totalInscrits]);
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){

        // Passer les années à la vue
        return view('inscription.create');
    }

    public function edit(Inscrire $inscription){
        return view('inscription.edit', compact('inscription'));
    }

    public function paiement(Inscrire $inscription){
        return view('inscription.paiement', compact('inscription'));
    }

    public function CreateInscrirePaiement($student){
        return view('inscription.createInscirePaid', compact('student'));
    }
}
