<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class SchoolStudentController extends Controller
{
    //
    public function index(){
        // Compter le nombre total d'élèves enregistrés
        $totalStudents = Student::count();

        // Passer le nombre total d'élèves à la vue
        return view('eleves.list', ['totalStudents' => $totalStudents]);
    }

      // Affiche la vue pour créer une nouvelle année scolaire
    public function create(){
        // Passer les années à la vue
        return view('eleves.create');
    }

    public function edit(Student $eleve){
        return view('eleves.edit', compact('eleve'));
    }


}
