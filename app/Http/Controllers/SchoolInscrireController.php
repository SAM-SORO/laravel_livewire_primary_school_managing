<?php

namespace App\Http\Controllers;

use App\Models\Inscrire;
use Illuminate\Http\Request;

class SchoolInscrireController extends Controller
{
    public function index(){
        return  view('inscription.list');
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        
        // Passer les années à la vue
        return view('inscription.create');
    }

    public function edit(Inscrire $inscription){
        return view('inscription.edit', compact('inscription'));
    }
}
