<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class SchoolLevelController extends Controller
{

    public function index(){
        return  view('niveaux.list');
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
