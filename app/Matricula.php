<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Inscricao;

class Matricula extends Model
{
	/*
	Constantes
	*/
	const STATUS = [ 'ativa',
				'pendente',
				'cancelada',
				'expirada',
				'pendente',
				'espera'
				];

	
	 
    //
    //protected $appends=['inscricoes'];

    /*public function getInscricoesAttribute($value){

		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		return $inscricoes;


	}*/
	 public function getInscricoes(){
		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		$this->inscricoes = $inscricoes;
		return $inscricoes;
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
