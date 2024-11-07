<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BolsaMatricula extends Model
{
	use SoftDeletes;
    protected $table  = 'bolsa_matriculas';

    public function getNomeCurso(){
		 $matricula = \App\Matricula::find($this->matricula);
		 if(!$matricula)
		 	return "ERRO: Matricula não encontrada. BolsaMatricula::getNomeCurso";
		 $curso = \App\Curso::find($matricula->curso);
		 if($curso)
		 	return $curso->nome;
		 else
		 	return "ERRO: curso não encontrado. BolsaMatricula::getNomeCurso";
    }

	public static function atualizarPorMatricula(int $matricula){
		$matricula = \App\Matricula::find($matricula);
		if(!$matricula)
			return null;
		switch($matricula->status){
			case 'expirada' :
			case 'cancelada' :
				//verifica se tem alguma matricula ativa senão cancela bolsa
				$bolsa_m = BolsaMatricula::where('matricula',$matricula->id)->first();
				if(!isset($bolsa_m->id))
					return null;
				
				$matriculas_bolsa = BolsaMatricula::where('bolsa',$bolsa_m->bolsa)->get();
				if($matriculas_bolsa->count()>1)
					BolsaMatricula::where('matricula',$matricula->id)->delete();
				elseif($matriculas_bolsa->count()==1)
					Bolsa::where('id',$bolsa_m->bolsa)->update(['status'=>'expirada']);
				break;
			case 'ativa':
			case 'espera':
			case 'pendente':
				//reativar bolsa
				//dd($matricula->id);
				$bolsa_m = BolsaMatricula::withTrashed()->where('matricula',$matricula->id)->first();
				
				if(!isset($bolsa_m->id))
					return null;
					
				$teste = BolsaMatricula::withTrashed()->where('bolsa',$bolsa_m->bolsa)->restore();
				Bolsa::where('id',$bolsa_m->bolsa)->update(['status'=>'ativa']);
				return true;


				break;

			

		}
		
	}
}
