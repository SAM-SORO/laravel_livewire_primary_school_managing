<?php

namespace App\Http\Controllers;

use App\Models\Affecter;
use App\Models\Inscrire;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolAffecterController extends Controller
{
    //
    public function index()
    {
        // Récupérer l'année scolaire active
        $activeSchoolYear = SchoolYear::where('active', '1')->first();

        $totalAffecters= 0;

        if ($activeSchoolYear) {
            // Compter le nombre d'élèves Affecters pour l'année active
            $totalAffecters = Affecter::where('schoolYear_id', $activeSchoolYear->id)->count();
        }
        return view('affectation.list' , ['totalAffecters' => $totalAffecters]);
    }

    public function create()
    {
        return view('affectation.create');
    }

    public function edit(Affecter $affectation)
    {
        return view('affectation.edit', compact('affectation'));
    }


    public function createAffecterDirectly($affectation){
        $inscritNotAffected = $affectation;
        return view('affectation.AffecterDirectly' , compact('inscritNotAffected'));
    }

}
