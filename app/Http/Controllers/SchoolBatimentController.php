<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SchoolBatimentController extends Controller
{
    //
    public function index(){
        return view('batiment.index');
    }
}
