<?php

namespace App\classes;

use App\ControleAcessoRecurso;
use Session;


class GerenciadorAcesso 
{
    // Verifica se o usuário pode executar um comando, baseado na tabela de controle de acesso
    public static function pedirPermissao($recurso){

        if(!Session::has('usuario'))
            return view('login');

        $query=ControleAcessoRecurso::where('pessoa', Session::get('usuario'))
                                    ->where('recurso', $recurso)->first();
        

        if(count($query))
            return True;
        else
            return False;

    }

}
