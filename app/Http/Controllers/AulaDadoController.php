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
    public static function createDadoAula(int $aula,  string $tipo, string $conteudo ){
        if(!is_null($conteudo) && $conteudo <> ''){
            $info = new AulaDado();
            $info->dado = $tipo;
            $info->aula = $aula;
            $info->valor = $conteudo;
            $info->save();
            return $info;
        }
    }
    public static function updateDadoAula(int $aula, string $tipo, string $conteudo){
        $dado = AulaDado::where('aula',$aula)->where('dado',$tipo)->first();
        if(isset($dado->id)){
            if($dado->valor <> $conteudo)
                $dado->valor = $conteudo;
                $dado->save();
        }
        else 
            AulaDadoController::createDadoAula($aula,$tipo, $conteudo);

    }
    public function limparDado(Request $r){
        $dados = AulaDado::where('aula',$r->aula)->where('dado',$r->dado)->get();
        foreach($dados as $info){
            $info->delete();
        }
    }
}
