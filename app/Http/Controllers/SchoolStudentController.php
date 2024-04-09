<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class SchoolStudentController extends Controller
{
    //
    public function index(){
        return  view('eleves.list');
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('eleves.create');
    }

    public function edit(Student $eleve){
        return view('eleves.edit', compact('eleve'));
    }

    public function getStudentsByMatricule(Request $request, $matricule)
    {
        $students = Student::where('matricule', 'like', $matricule . '%')->get();
        return response()->json($students);
    }
}
