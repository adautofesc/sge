<?php

namespace App\Http\Controllers;

use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    public static function gravarEndereco(int $pessoa, $logradouro=null, $numero=null, $complemento=null, $bairro=null, $cidade=null, $uf=null, $cep=null){
        if(is_null($cep)){
            return null;
        }
        else{
            $endereco_atual = PessoaDadosContato::where('pessoa',$pessoa)->where('dado',6)->get();
        }

    }
    
    
    
    public function importarBairros(){
        $col_enderecos=collect();
        $nomes_comuns=[ 
            'felicia'=>'138'

        ];


        $bairros=DB::table('bairros_sanca')->get();
        foreach($bairros as $bairro){
            $enderecos=Endereco::where('bairro_str','like','%'.$bairro->nome.'%')->where('bairro',0)->orWhere("bairro", null)->get();
            if($enderecos->count()>0){
                foreach ($enderecos as $endereco){   
                        $endereco->bairro=$bairro->id;
                        $endereco->save();
                }
            }

        }
        $enderecos=Endereco::where('bairro_str','like','%felicia%')->where('bairro',0)->orWhere("bairro", null)->get();
            if($enderecos->count()>0){
                foreach ($enderecos as $endereco){   
                        $endereco->bairro=138;
                        $endereco->save();
                        $col_enderecos->push($endereco);
                }
            }

        return $col_enderecos;


    }
    public function buscarBairro($valor=''){
        return DB::table('bairros_sanca')->where('nome','like','%'.$valor.'%')->limit(20)->get();
    }
}
