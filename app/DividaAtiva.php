<?php

namespace App;

use App\Http\Controllers\ValorController;
use App\Http\Controllers\BoletoController;
use Illuminate\Database\Eloquent\Model;

use App\Boleto;



class DividaAtiva extends Model
{
    protected $table  = 'divida_ativa';
    public $timestamps = false;


    public function getNomePessoa(){
        $pessoa = \App\Pessoa::withTrashed()->find($this->pessoa);
        return $pessoa->nome;
    }

    public function getValorConsolidadoAttribute($value){
        return $value/100;

    }

    /**
     * Gerador de Divida Ativa
     * 
     * Pega os boletos do ano anterior, faz a correção do ipca, consolida os valores e escreve em um unico registro.
     *
     * @param integer $ano
     * @return void
     */
    public static function gerarLivroCorrente($ano = 2022){
        $lista_pessoas = array();
        $boletos_nao_pagos = Boleto::whereIn('status',['emitido','divida'])->whereYear('vencimento',$ano-1)->get();

        //dd($boletos_nao_pagos);

        foreach($boletos_nao_pagos as &$boleto){
            if(!in_array($boleto->pessoa,$lista_pessoas))
                $lista_pessoas[] = $boleto->pessoa;
            $boleto->status = 'divida';
//$boleto->save();   
        }

        //dd($lista_pessoas);

        foreach($lista_pessoas as $pessoa){
            $da = new DividaAtiva;
            $da->pessoa = $pessoa;
            $da->status = 'aberto';
            $da->valor_consolidado = 0;
            $da->consolidado_em = date('Y-m-d');
            //$da->save();

            //dd($da);

            $boletos_divida = Boleto::where('pessoa',$pessoa)->where('status','emitido')->whereYear('vencimento',$ano-1)->get();
            //dd($boletos_divida);
            foreach($boletos_divida as $boleto){
                //$da->valor_consolidado = DividaAtiva::atualizarValor($boleto->valor,$boleto->vencimento);
                $da->valor_consolidado = DividaAtiva::atualizarValor('50','2021-02-10');
            }


        }

    }

  


    public static function cadastrar(Boleto $boleto, Array $ipca){
        

        $ano = substr($boleto->vencimento,0,4);
        $divida = DividaAtiva::where('pessoa',$boleto->pessoa)->where('ano',$ano)->first();
        if($divida){
            $valor_corrigido = round(BoletoController::getValorCorrigido($boleto, $ipca),2)*100;
            $divida->valor_consolidado += $valor_corrigido;
            $divida->save();
            
        }
        else{
            $ultima_inscricao = DividaAtiva::where('ano',$ano)->orderByDesc('inscricao')->first();
            if($ultima_inscricao){
                //dd($ultima_inscricao);
                $numero_inscricao = $ultima_inscricao->inscricao + 1;
                $numero_folha = $ultima_inscricao->folha + 1;
            }
            else{
                $numero_inscricao = 1;
                $numero_folha = 2;
            }

            $divida = new DividaAtiva;
            $divida->pessoa = $boleto->pessoa;
            $divida->ano = $ano;
            $divida->inscricao = $numero_inscricao;
            $divida->folha = $numero_folha;
            $divida->valor_consolidado =round(BoletoController::getValorCorrigido($boleto, $ipca),2)*100;
            $divida->consolidado_em = date('Y-m-d');
            $divida->save();
        }

        $divida_boleto = DividaAtivaDados::where('divida',$divida->id)->where('dado','boleto')->where('conteudo',$boleto->id)->get();
        if($divida_boleto->count() == 0){
            $dado_divida = new DividaAtivaDados;
            $dado_divida->divida = $divida->id;
            $dado_divida->dado = 'boleto';
            $dado_divida->conteudo = $boleto->id;
            $dado_divida->save();
        }


        
    }
}
