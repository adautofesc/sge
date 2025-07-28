<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atestado extends Model
{
    use SoftDeletes;
    //protected $dates = ['emissao','validade','created_at','deleted_at'];
	protected $casts = [
    'emissao' => 'date',
	'validade' => 'date',
	'created_at' => 'date',
	'deleted_at' => 'date',
    ];
   
	/**
	 * The attributes that are mass assignable.
	 * @param int $sala
	 * @return string
	 */
    public function calcularVencimento(int $sala){
    	if($sala == 6) //se for piscina
    		$validade = "+6 months";
    	else
    		$validade = "+12 months";

    	if($this->emissao == null)
    		return $this->validade;
    	else
    		$vencimento = date('Y-m-d 23:23:59', strtotime($validade,strtotime($this->emissao))); 

    	return $vencimento;

    }

	/**
	 * Verifica se o atestado está vencido
	 * @param int $turma
	 * @return bool vencido ou não
	 */
	public function verificaPorTurma(int $turma){
		$turma = \App\Turma::find($turma);
		if($turma == null)
			return false;
		if($this->calcularVencimento($turma->sala) < date('Y-m-d 23:23:59'))
			return false;
		else
			return true;

	}

	public function getNome(){
		return \App\Pessoa::getNome($this->pessoa);
	}

	public function validar(){
		$validade = $this->calcularVencimento(0);
		if($validade < date('Y-m-d 23:23:59'))
			return true;
		else
			return false;
	}


}
