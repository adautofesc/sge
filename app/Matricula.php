<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Inscricao;

class Matricula extends Model
{
	/*
	Constantes
	*/
	use SoftDeletes;
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
		/*$curso = Curso::find($this->curso);
		if($curso != null)
			return $curso->nome;
		else{*/
			
			$inscricoes = $this->getInscricoes();

			return $inscricoes->first()->turma->curso->nome;
			//return 'Matricula sem nome do curso.';
			

		
	}

	public function getIdCurso(){
		/*$curso = Curso::find($this->curso);
		if($curso != null)
			return $curso->nome;
		else{*/
			
			$inscricoes = $this->getInscricoes();

			return $inscricoes->first()->turma->curso->id;
			//return 'Matricula sem nome do curso.';
			

		
	}

	public function getBolsas(){
		$bolsa = Bolsa::join('bolsa_matriculas','bolsas.id','=','bolsa_matriculas.bolsa')
                ->where('bolsa_matriculas.matricula',$this->id)
                ->first();

               
        if($bolsa){
        	$tipo = \App\Desconto::find($bolsa->desconto);
        	$bolsa->tipo = $tipo->first();
        }
        return $bolsa;


	}

	public function getDescontoAttribute($value){
		//return $value;
		//return 100;
		
		$valor = \App\Http\Controllers\BolsaController::verificaBolsa($this->pessoa,$this->id);
		
			if($valor)
				return $valor->desconto;
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
		if(count($inscricoes)>0)
			return $inscricoes->first()->turma->programa;
		else
			return \App\Programa::find(1);

	}





}
