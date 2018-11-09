<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{

	protected $appends=['icone_status','tempo_curso','valor'];

	public function setDiasSemanaAttribute($value){
		$this->attributes['dias_semana']= implode(',',$value);
	}
	public function getDiasSemanaAttribute($value){
		return explode(',',$value);
	}
	public function setValorAttribute($value){
		$this->attributes['valor'] = str_replace(',', '.', $value);
	}


	/**
	Valor que vai aparecer na lista de turmas
	**/
	public function getValorAttribute($value){

		//verifica se o curso é fora da fesc, se for, retorna valor 0
		$fesc=[84,85,86];
		if(!in_array($this->local->id,$fesc)){
			return number_format(0,2,',','.');
		}


		//verifica se não é EMG, se for retorna valor 0
		if($this->programa->id == 4)
			return number_format(0,2,',','.');
		
		// se for do curso atividades uati
		if($this->curso->id == 307 && $this->carga<10)
		{
			//mostra valor de 1 disciplina
			$valor= Valor::find(5);
		}
		else
		{	
			//procura curso carga.
			$valorc= Valor::where('curso',$this->curso->id)->where('carga',$this->carga)->get();
			if(count($valorc)!=1)

			//ṕrocura curso
			$valorc= Valor::where('curso',$this->curso->id)->get();
			if(count($valorc)!=1)

			//programa carga
			$valorc= Valor::where('programa',$this->programa->id)->where('carga',$this->carga)->get();
			if(count($valorc)!=1)

				//se não tiver na tabela, pega do valor da tabela turma mesmo;
				return number_format($value,2,',','.');

			$valor=$valorc->first();
				
			
		}
		

		if(isset($valor))
			return number_format($valor->valor,2,',','.');
		else
			return number_format(0,2,',','.');

	}
	public function setAtributosAttribute($value){
		if(count($value))
			$this->attributes['atributos'] = implode(',',$value);	
	}
	public function getAtributosAttribute($value){
		return explode(',',$value);
	}
	public function getProfessorAttribute($value){
		$professor=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $professor;
	}
	public function getDataInicioAttribute($value){
		return Carbon::parse($value)->format('d/m/Y');
	}
	public function getDataTerminoAttribute($value){
		return Carbon::parse($value)->format('d/m/Y');
	}
	public function getProgramaAttribute($value){
		return Programa::find($value);
	}
	public function getCursoAttribute($value){
		$curso=Curso::where('id',$value)->get(['id','nome','carga'])->first();
		//$curso->requisito();
		return $curso;
	}
	public function getDisciplinaAttribute($value){
		$disciplina=Disciplina::where('id',$value)->get(['id','nome','carga'])->first();
		//$disciplina->requisito();
		return $disciplina;
	}
	public function getParceriaAttribute($value){	
		return Parceria::find($value);
	}
	public function getLocalAttribute($value){	
		return Local::find($value);
	}
	public function getHoraInicioAttribute($value){	
		return substr($value,0,5);
	}
	public function getHoraTerminoAttribute($value){	
		return substr($value,0,5);
	}
	
	public function getIconeStatusAttribute($value){
		switch($this->status){
			case 'cancelada':
				return "ban";
				break;
			case 'espera':
				return "clock-o";
				break;
			case 'andamento': 
				return "check-circle";
				break;
			case 'inscricao':
				return "circle-o";
				break;
			case 'iniciada':
				return "check-circle-o";
				break;
			case 'encerrada':
				return "minus-circle";
				break;
			default:
				return "question-circle";
				break;
		}//end switch
	}
	public function getTempoCursoAttribute($value){
		$dt_i=Carbon::createFromFormat('d/m/Y', $this->data_inicio);
		$dt_t=Carbon::createFromFormat('d/m/Y', $this->data_termino);
		$diference=$dt_i->diffInMonths($dt_t);
		$diference++;
		return $diference;

	}


    



}
