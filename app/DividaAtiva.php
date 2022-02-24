<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Boleto;

class DividaAtiva extends Model
{
    protected $table  = 'divida_ativa';
    public $timestamps = false;

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
                $da->valor_consolidado = DividaAtiva::atualizarValor($boleto->valor,$boleto->vencimento);
            }


        }

    }

    public static function atualizarValor($valor,$vencimento){
        $VC = new \App\Http\Controllers\ValorController;
        $correcao = $VC->correcaoValor($valor,$vencimento);
        dd($valor);
        dd($vencimento);
        dd($correcao);
    }
}
