<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use Illuminate\Http\Request;

class SchoolBatimentController extends Controller
{
    //
    public function index(){
        return view('batiment.index');
    }

    public function create(){
        return view('batiment.create');
    }

    public function edit(Batiment $batiment){
        return view('batiment.edit', compact('batiment'));
    }


}
