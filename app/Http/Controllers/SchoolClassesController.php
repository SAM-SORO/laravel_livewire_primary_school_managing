<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class SchoolClassesController extends Controller
{
    public function index(){
        return  view('classes.list');
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
