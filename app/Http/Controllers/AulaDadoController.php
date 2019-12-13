<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AulaDado;


class AulaDadoController extends Controller
{
    /**********Tipos
     * 23 conteudo
     * 24 ocorrencia
     ***********
     */
    public function createDadoAula(int $aula, $conteudo, int $tipo ){
        if(!is_null($conteudo) && $conteudo <> ''){
            $info = new AulaDado();
            $info->dado = $tipo;
            $info->aula = $aula;
            $info->valor = $conteudo;
            $info->save();
            return $info;
        }
    }
    public function updateDadoAula(int $aula, $conteudo, int $tipo){
        $dado = AulaDado::where('aula',$aula)->where('dado',$tipo)->first();
        if(isset($dado->id)){
            if($dado->valor <> $conteudo)
                $dado->valor = $conteudo;
                $dado->save();
        }
        else $this->createDadoAula($aula,$conteudo, $tipo);

    }
}
