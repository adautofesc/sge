<?php

use App\ControleAcessoRecurso;
use Session;

static class GerenciadorAcesso 
{
    //
    public static function pedirPermissao($recurso){
    	$query=ControleAcessoRecurso::where('pessoa', Session::get('usuario'))
    								->where('recurso', $recurso)->first();
    	return $query;


    }
}
