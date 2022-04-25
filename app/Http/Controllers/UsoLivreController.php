<?php

namespace App\Http\Controllers;

use App\Local;
use Illuminate\Http\Request;


class UsoLivreController extends Controller
{
    function index(){
        $locais = Local::getUsoLivre();
        return view('uso-livre.index');
    }
}
