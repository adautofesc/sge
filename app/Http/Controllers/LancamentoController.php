<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matricula;
use App\Boleto;
use App\Lancamento;


class LancamentoController extends Controller
{
    //
	public function gerarLancamentos($parcela){
		$matriculas=Matricula::where('status','ativa')->where('valor','>',0)->where('parcelas','>=',$parcela)->get();
		foreach($matriculas as $matricula){
			if(!$this->verificaSeLancada($matricula->id,$parcela)){
				$lancamento=new Lancamento;
				$lancamento->matricula=$matricula->id;
				$lancamento->parcela=$parcela;
				$lancamento->valor=($matricula->valor-$matricula->valor_desconto)/$matricula->parcelas;
				if($lancamento->valor>0)
					$lancamento->save();
			}
		}
		//gerar os boletos.
		return "lancamentos efetuados com sucesso";

	}
	public static function atualizaLancamentos($pessoa,$parcela,$boleto){
		$lancamentos=Lancamento::select('lancamentos.id as id')
								->join('matriculas','lancamentos.matricula','matriculas.id')
								->where('pessoa',$pessoa)
								->where('boleto',null)
								->get();

		foreach($lancamentos as $lancamento){
			$lancamento->boleto=$boleto;
			$lancamento->save();
		}
		return $lancamentos;
	}

	public function verificaSeLancada($matricula,$parcela){
		$lancamentos=Lancamento::where('matricula',$matricula)->where('parcela',$parcela)->get();
		if (count($lancamentos)>0)
			return true;
		else
			return false;
	}


}
