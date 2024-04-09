<?php

namespace App\Http\Controllers;

use App\Models\Affecter;
use Illuminate\Http\Request;

class SchoolAffecterController extends Controller
{
    //
    public function index()
    {
        return view('affectation.list');
    }

    public function create()
    {
        return view('affectation.create');
    }

    public function edit(Affecter $affectation)
    {
        return view('affectation.edit', compact('attribution'));
    }
}
