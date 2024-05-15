<?php

namespace App\Http\Controllers;

use App\Exports\ListeClasseCVS;
use App\Models\Affecter;
use App\Models\Classe;
use Illuminate\Http\Request;


class PdfController extends Controller
{
    public function exportListeClasseToExcel($classe){

        $affecters = Affecter::where('classe_id', $classe)->first();

        if($affecters){
            $classe = Classe::findOrFail($classe);

            $fileName = "ListeClasse ".$classe->nom . ".xlsx";

            return (new ListeClasseCVS($classe))->download($fileName);

        }else{

            session()->flash('error', 'Aucun élève n\'a été enregistré dans cette classe.');

            return redirect()->back();
        }

    }
}
