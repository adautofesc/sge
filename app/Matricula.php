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
    protected $appends=['valor'];

	public function getValorAttribute($value){
		//return $value;
		
		$valor = \App\Http\Controllers\ValorController::valorMatricula($this->id);
			return $valor;

	}
	 public function getInscricoes($tipo = 'todas'){
		$inscricoes= \App\Http\Controllers\InscricaoController::inscricoesPorMatricula($this->id,$tipo);
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
			//return 'Matricula sem nome do curso.';
			

		}
	}

	public function getDescontoAttribute($value){
		//return $value;
		//return 100;
		
		$valor = \App\Http\Controllers\BolsaController::verificaBolsa($this->pessoa,$this->id);
		
			if($valor)
				return $valor;
			else
				return null;
	}

	public function getValorDescontoAttribute($value){
		//return $value;
		//dd($this);
		if($this->desconto != null){
			//dd($this->desconto);
			if($this->desconto->tipo == 'p')
				return $this->valor->valor*$this->desconto->valor/100;
			else
			
				return  $this->desconto->valor;

		}
		else 
			return 0;

	}

	public function getPrograma(){

		$inscricoes = $this->getInscricoes();

		return $inscricoes->first()->turma->programa;

	}





}
