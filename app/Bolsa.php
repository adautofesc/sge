<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bolsa extends Model
{
    //
    protected $appends=['desconto'];

	public function getDescontoAttribute($value){
		//return $value;
		//
		//
		//return $value;
		$valor = \App\Desconto::find($value);
		
			return $valor;

	}
    public function desconto(){
		return $this->hasOne('App\Desconto','desconto'); // (Pessoa::class)
	}

	public function getNomeCurso(){
		$matricula = \App\Matricula::find($this->matricula);
		return $matricula->getNomeCurso();
		
		
			

		
	}
	public function getNomePessoa(){
		$pessoa = Pessoa::find($this->pessoa);
		if($pessoa!=null)
			return $pessoa->nome;
		else
			return "Nome não encontrado.";
	}
}
