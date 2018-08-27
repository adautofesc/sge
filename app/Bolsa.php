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
		return $this->hasOne('App\Descobto','desconto'); // (Pessoa::class)
	}

	public function getNomeCurso(){
		$curso = Curso::find($this->curso);
		if($curso != null)
			return $curso->nome;
		else{
			$inscricoes = $this->getInscricoes();
			return $inscricoes->first()->turma->curso->nome;
			

		}
	}
}
