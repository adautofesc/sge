<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ControleAcessoRecurso;
use Session;

class GerenciadorAcesso extends Controller
{
    //
    public function cadastrarPessoa(){
    	$query=ControleAcessoRecurso::where('pessoa', Session::get('usuario'))
    								->where('recurso', 1)->first();
    	return $query;


    }
}
