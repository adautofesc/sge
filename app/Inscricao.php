<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscricao extends Model
{
	use SoftDeletes;
	protected $table  = 'inscricoes';
    //
    public function getPessoaAttribute($value){
		$pessoa=Pessoa::withTrashed()->where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}

	public function getTurmaAttribute($value){
		$curso=Turma::where('id',$value)->get(['id','programa','carga','curso','disciplina','professor','local','dias_semana','hora_inicio','hora_termino','data_inicio','data_termino','vagas','status'])->first();
		return $curso;
	}
	public function setTurma($value){
		$this->turma = $value;
		return $this->turma;

	}
	public function getCurso(){
		$curso=Turma::where('id',$value)->get(['id','curso']);
		return $curso->curso;

	}
	public function getTransferencia(){

		$tr = Transferencia::where('anterior',$this->id)->first();
		//dd($tr);
		return $tr;


	}
	public function getAtestado(){
			$atestado = \App\Atestado::where('pessoa',$this->pessoa->id)->orderByDesc('id')->first();
		
		

		return $atestado;
	}
	public static function addConceito(int $inscricao,$nota){
		$inscricao = Inscricao::find($inscricao);
		$inscricao->conceito = $nota;
		$inscricao->save();
		return true;
	}

	public function alterarStatus($status){     
		$this->status = $status;
		$this->save();
		switch($status){
			case "pendente" :
				\App\Http\Controllers\MatriculaController::atualizar($this->matricula);
				break;
			case "regular": 
				\App\Http\Controllers\TurmaController::modInscritos($this->turma->id);
				\App\Http\Controllers\MatriculaController::atualizar($this->matricula);
				break;
			case "finalizada": 
				\App\Http\Controllers\MatriculaController::atualizar($this->matricula);
				break;
			case "cancelada":
				\App\Http\Controllers\TurmaController::modInscritos($this->turma->id);
				\App\Http\Controllers\MatriculaController::atualizar($this->matricula);
				break;
			case "transferida": 
				\App\Http\Controllers\TurmaController::modInscritos($this->turma->id);
				\App\Http\Controllers\MatriculaController::atualizar($this->matricula);
				break;
		}
                    
    }
            
        
    


}
