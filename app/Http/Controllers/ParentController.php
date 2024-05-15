<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index(){
        // Compter le nombre total d'élèves enregistrés
        $totalParents = Parents::count();

        return  view('parent.list' , ['totalParents' => $totalParents]);
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('parent.create');
    }

    public function edit(Parents $parent){
        return view('parent.edit', compact('parent'));
    }
}
