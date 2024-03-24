<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    //
    public function index(){
        return view('schoolYears.index');
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('schoolYears.create');
    }

}
