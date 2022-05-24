<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bolsa extends Model
{
    //
    use SoftDeletes;
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

	public function getNomeCurso($matricula){
		$matricula = \App\Matricula::find($matricula);
		if($matricula)
			return $matricula->getNomeCurso();
		else
			return "Erro ao obter nome do curso.";
	
	}

	public function getNomePessoa(){
		$pessoa = Pessoa::withTrashed()->find($this->pessoa);
		if($pessoa!=null)
			return $pessoa->nome;
		else
			return "Nome não encontrado.";
	}

	public function getMatriculas(){
		$matriculas = BolsaMatricula::where('bolsa',$this->id)->get();
		return $matriculas;
	}

	public function getTipo(){
		$tipo = Desconto::find($this->desconto);
	
	}

	public function getPrograma(){

		$programa = array();
		$bolsa_matriculas = $this->getMatriculas();

		
		foreach($bolsa_matriculas as $bolsa_matricula){
			$matricula = Matricula::find($bolsa_matricula->matricula);
			if(!in_array($matricula->getPrograma()->sigla, $programa))
				$programa[] = $matricula->getPrograma()->sigla; 


		}

		//dd($programa);
		return $programa;
	}
}
