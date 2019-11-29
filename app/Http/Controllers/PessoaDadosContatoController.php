<?php

namespace App\Http\Controllers;

use App\PessoaDadosContato;
use Illuminate\Http\Request;

class PessoaDadosContatoController extends Controller
{
    public static function gravarTelefone($pessoa, $numero = null){
        if(!is_null($numero) 
            && $numero != ' ' 
            && $numero != '' 
            && $numero != '123' 
            && $numero != '123456' 
            && strlen($numero)>=8 
            && strlen($numero)<16){
            //procura pra ver se telefone já existe
            $dado = PessoaDadosContato::where('dado','2')->where('pessoa',$pessoa)->where('valor', $numero)->get();
            //cadastra se nao tiver
            if(count($dado) == 0){
                $telefone = new PessoaDadosContato;
                $telefone->pessoa = $pessoa;
                $telefone->dado = '2';
                $telefone->valor = preg_replace( '/[^0-9]/is', '', $numero);
                $telefone->save();
                return $telefone;

            }
        }
        else {
            return null;
        }

    }
    public static function gravarEndereco(int $pessoa, $logradouro=null, $numero=null, $complemento=null, $bairro=null, $cidade=null, $uf=null, $cep=null){
        if(is_null($cep)){
            return null;
        }
        else{
            $endereco_atual = PessoaDadosContato::where('pessoa',$pessoa)->where('dado',6)->get();
        }

    }
}
