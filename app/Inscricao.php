<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
	protected $table  = 'inscricoes';
    //
    public function getPessoaAttribute($value){
		$pessoa=Pessoa::where('id',$value)->get(['id','nome'])->first();
		return $pessoa;
	}

	public function getTurmaAttribute($value){
		$curso=Turma::where('id',$value)->get(['id','curso','disciplina'])->first();
		return $curso;
	}
}
