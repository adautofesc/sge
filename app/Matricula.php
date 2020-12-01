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
		
		$valor = \App\Http\Controllers\ValorController::valorMatricula($this->id);
			return $valor;

	}


	public function getInscricoes($tipo = 'todas'){

		$inscricoes= \App\Http\Controllers\InscricaoController::inscricoesPorMatricula($this->id,$tipo);
		$this->inscricoes = $inscricoes;
		return $inscricoes;
	}

	public function getNomeCurso(){
		
			$inscricoes = $this->getInscricoes();

			if($inscricoes==null)
				return $inscricoes->first()->turma->curso->nome;
			else
				return 'Matrícula sem curso cadastrado';
		
	}

	public function getIdCurso(){
		
			
			$inscricoes = $this->getInscricoes();

			if(!is_null($inscricoes))
				return $inscricoes->first()->turma->curso->id;
			else 
				return 0;
	}


	// mostra bolsa quando mostrar a matrícula;
	// update bolsas set validade = '2019-12-31' where status = 'ativa'
	public function getBolsas(){
		
		$bmatricula = BolsaMatricula::where('matricula',$this->id)->first();
		if($bmatricula){	
			$bolsa = Bolsa::where('id',$bmatricula->bolsa)->where('status','ativa')->first();
		}
		else
			return null;
		
		
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
		if($inscricoes->count())
			return $inscricoes->first()->turma->programa;
		else
			return \App\Programa::find(1);

	}


	/**
	 * função pra calcular quantas parcelas a pessoa terá que pagar na hora de gerar matricula
	 * @return [Int] [quantidade de parcelas da matrícula]
	 */
	public function getParcelas(){

		$inscricoes = collect();
		$inscricoes = $this->getInscricoes();
		if($inscricoes->count()==0){
			 unset($this->inscricoes);
			return 0;
		}

		$valor_matricula = \App\Http\Controllers\ValorController::valorMatricula($this->id);

		//return $valor_matricula;

		//transforma data de inicio da turma em objeto de data para descobrir qual semestre é
		$pp_dt = \DateTime::createFromFormat('d/m/Y', $inscricoes->first()->turma->data_inicio);
		
		unset($this->inscricoes);

			//verifica qual semestre para determinar a data limite para geração da primeira parcela
			if($pp_dt->format('m')<8 || $valor_matricula->parcelas == 11 || $valor_matricula->parcelas == 10){
				$dt_pp= \DateTime::createFromFormat('d/m/Y', '20/02/'.$pp_dt->format('Y')); // 20/02/2019
				
			}
			else{
				$dt_pp= \DateTime::createFromFormat('d/m/Y', '20/08/'.$pp_dt->format('Y')); //ou 20/08/2019
				
			}
				
		//transforma data da matricula em objeto
		$dt_mt= \DateTime::createFromFormat('Y-m-d',$this->data);

		//calcula a diferença entre as datas
		$interval = $dt_pp->diff($dt_mt);
		$parcelas = $valor_matricula->parcelas - ceil($interval->days/30);

		//reduz a quantidade de parcelas de acordo com a diferença entre as datas
		if($interval->invert ==1){	
			return $valor_matricula->parcelas;
		}
		else{
			if($parcelas >=0)
				return $parcelas;
			else
				return $valor_matricula->parcelas;

		}
		return $interval;

	}





}
