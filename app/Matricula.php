<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Inscricao;

class Matricula extends Model
{
    //
    //protected $appends=['inscricoes'];

    public function getInscricoesAttribute($value){

		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		return $inscricoes;


	}
	 public function getInscricoes(){
		$inscricoes=Inscricao::where('matricula',$this->id)->get();
		$this->inscricoes = $inscricoes;
		return $inscricoes;
	}
	public function getNomeCurso(){
		$curso = Curso::find($this->curso);
		if($curso != null)
			return $curso->nome;
		else
			return "Erro: numero de curso não consta na matrícula";

	}

}
