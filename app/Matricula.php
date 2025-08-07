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
			if($inscricoes->count() > 0 )
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
		$bmatricula = BolsaMatricula::where('matricula',$this->id)->orderByDesc('id')->first();
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
	public function getParcelas():int{
		//Fazer uma verificação inicial 
		if($this->parcelas>0)
			return  $this->parcelas;
		
		$parcelas = 0;
		$inscricoes = $this->getInscricoes();
		if($inscricoes->count()==0){
			 unset($this->inscricoes);
			return 0;
		}

		//pega a quantidade de parcelas da turma
		foreach($inscricoes as $inscricao){
			$turma= \App\Turma::find($inscricao->turma->id); 
			if($parcelas < $turma->getParcelas()){
				$parcelas = $turma->getParcelas();
			}
			
		}
		
		//se pacote
		if($this->pacote>0){
			$valor = Valor::where('pacote',$this->pacote)->where('ano',substr($turma->data_inicio,-4))->first();
			if(isset($valor->parcelas))
				$parcelas =  $valor->parcelas;
		}

		//transforma data de inicio da turma e matrícula em objeto de data 
		$primeira_parcela = $turma->getDataPrimeiraParcela();
		$data_matricula = \DateTime::createFromFormat('Y-m-d',$this->data);
		$interval = $primeira_parcela->diff($data_matricula);

		

		
		//se a data de matrícula for anterior ao início do curso
		if($data_matricula->format('m') <= $primeira_parcela->format('m') || $data_matricula->format('Y') < $primeira_parcela->format('Y'))
			return $parcelas;
		else{
			// se for de agosto em diante, adiciona uma parcela pois pula-se julho (se o curso começar antes de julho e a matricula depois de junho)
			if($primeira_parcela->format('m') < 7 && $data_matricula->format('m')>6)
				$parcelas = $parcelas - ($data_matricula->format('m')-$primeira_parcela->format('m'))+1;
			else
				$parcelas = $parcelas - ($data_matricula->format('m')-$primeira_parcela->format('m'));

		}
		return $parcelas;

	}





}
