<?php

namespace App\Http\Controllers;

use App\Sala;
use Illuminate\Http\Request;


class UsoLivreController extends Controller
{
    function index(){
        $locais = Sala::getUsoLivre();
        
        return view('uso-livre.index')->with('locais',$locais);
    }
}
