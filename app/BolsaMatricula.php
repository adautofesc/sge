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
}
