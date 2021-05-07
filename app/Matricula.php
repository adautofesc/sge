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

	private const CORTE = 20;
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
			if($inscricoes!=null)
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
		if($this->parcelas>0)
			return  $this->parcelas;
		$parcelas = 0;
		$inscricoes = $this->getInscricoes();
		if($inscricoes->count()==0){
			 unset($this->inscricoes);
			return 0;
		}
		foreach($inscricoes as $inscricao){
			$turma= \App\Turma::find($inscricao->turma->id); 
			if($parcelas < $turma->getParcelas()){
				$parcelas = $turma->getParcelas();
			}
			
		}
		//dd($parcelas);

		//transforma data de inicio da turma e matrícula em objeto de data 
		$pp_dt = \DateTime::createFromFormat('d/m/Y', $turma->data_inicio);
		$dt_mt = \DateTime::createFromFormat('Y-m-d',$this->data);
		$interval = $pp_dt->diff($dt_mt);

		if($dt_mt->format('m') < $pp_dt->format('m'))
			return $parcelas;
		else{
			$parcelas = $parcelas - ($dt_mt->format('m')-$pp_dt->format('m'));
			if($dt_mt->format('d')>=$this::CORTE)
				$parcelas--;
		}
	
		/*
		//reduz a quantidade de parcelas de acordo com a diferença entre as datas de início e a data de matrícula
		if($interval->invert ==1){	
			
		}
		else{
			//dd($interval->m);
			if($dt_mt->format('d')<$this::CORTE && $interval->m>0 ){
				$parcelas = $parcelas - $interval->m;
				$parcelas++;
			}
			else
				
				$parcelas = $parcelas - $interval->m;

		}
		*/
		return $parcelas;

	}





}
