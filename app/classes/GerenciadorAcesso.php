<?php

namespace App\classes;

use App\ControleAcessoRecurso;
use Auth;


class GerenciadorAcesso 
{
    // Verifica se o usuário pode executar um comando, baseado na tabela de controle de acesso
    public static function pedirPermissao($recurso){



        $query=ControleAcessoRecurso::where('pessoa', Auth::user()->pessoa)
                                    ->where('recurso', $recurso)->first();
        

        if(!empty($query))
            return True;
        else
            return False;

    }
 

}
