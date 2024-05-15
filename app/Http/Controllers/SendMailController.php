<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function OneParent(Parents $parent){

        return view('mail.messageToOneParent', compact('parent'));

    }

    public function AllParent(){
        return view('mail.messageToAllParent');
    }
}
