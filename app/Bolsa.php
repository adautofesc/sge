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
		if($matricula)
			return $matricula->getNomeCurso();
		else
			return "Erro ao obter nome do curso.";
		
		
			

		
	}
	public function getNomePessoa(){
		$pessoa = Pessoa::find($this->pessoa);
		if($pessoa!=null)
			return $pessoa->nome;
		else
			return "Nome não encontrado.";
	}
}
