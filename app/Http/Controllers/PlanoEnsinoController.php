<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanoEnsinoController extends Controller
{
    public function index(Request $r){

        return view('plano-ensino.home');
    }
}
