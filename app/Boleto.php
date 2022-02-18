<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Lancamento;


class Boleto extends Model
{
    //
    use SoftDeletes;
    public $timestamps = false;

    public function getLancamentos(){
    	$this->lancamentos = Lancamento::where('boleto',$this->id)->get();
    	return $this->lancamentos;
    }

    public function getNomePessoa(){
        $pessoa = \App\Pessoa::find($this->pessoa);
        if(isset($pessoa->nome))
            return $pessoa->nome;
        else
            return 'NÃO ENCONTRADO';
    }


    public static function verificarDebitos(int $pessoa){
        $vencimento = \Carbon\Carbon::today()->addDays(-3);
		$boletos_vencidos = Boleto::where('pessoa',$pessoa)->whereIn('status',['emitido','divida','aberto executado'])->where('vencimento','<',$vencimento->toDateString());
		return $boletos_vencidos;
    }
}
