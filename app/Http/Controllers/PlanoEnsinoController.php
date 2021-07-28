<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PessoaDadosAdministrativos;
use App\PlanoEnsino;
use App\Programa;

class PlanoEnsinoController extends Controller
{
    public function index(Request $r){

        return view('plano-ensino.home');
    }

    public function create(){
        $semestres = \App\classes\Data::semestres();
        $professores = PessoaDadosAdministrativos::getFuncionarios(['Educador','Educador de Parceria']);
        $programas = Programa::all()->sortBy('nome');
        return view('plano-ensino.cadastrar')
            ->with('professores',$professores)
            ->with('semestres',$semestres)
            ->with('programas',$programas);
    }
}
